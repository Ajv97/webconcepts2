<?php
/**
 * Created by PhpStorm.
 * User: beeker
 * Date: 2019-04-12
 * Time: 15:49
 */

require_once 'db-connect.php';

session_start();
unset($_SESSION['wish']);
unset($_SESSION['cart']);

$isbn = $_GET['isbn'];

$email = $_SESSION['email'];

$queryString;

if(!$email) {
    $queryString = 'SELECT b.title, b.isbn, b.price, b.pages, b.binding, b.pubDate, b.description, b.imageFilename, a.compositeName FROM tblBooks b' .
        ' LEFT JOIN tblBooksAuthorsXref xref ON xref.isbn = b.isbn LEFT JOIN tblAuthors a ON xref.authorId = a.authorId' .
        " WHERE b.isbn='$isbn';";
} else {
    $queryString = 'CREATE TABLE FilteredUC(cemail varchar(225), isbn char(16), PRIMARY KEY(cemail, isbn));';
    $myConn->set_query_string($queryString);
    $result = $myConn->execute_query();

    $queryString = 'CREATE TABLE FilteredUW(wemail varchar(225), isbn char(16), PRIMARY KEY(wemail, isbn));';
    $myConn->set_query_string($queryString);
    $result = $myConn->execute_query();

    $queryString = "INSERT INTO FilteredUC (cemail, isbn) SELECT email, isbn FROM tblUserCartXref ucx WHERE ucx.email = '$email';";
    $myConn->set_query_string($queryString);
    $result = $myConn->execute_query();

    $queryString = "INSERT INTO FilteredUW (wemail, isbn) SELECT email, isbn FROM tblUserWishXref uwx WHERE uwx.email = '$email';";
    $myConn->set_query_string($queryString);
    $result = $myConn->execute_query();

    $queryString = 'SELECT b.title, b.isbn, b.price, b.pages, b.binding, b.pubDate, b.description, b.imageFilename, a.compositeName, fuc.cemail, fuw.wemail FROM tblBooks b' .
        ' LEFT JOIN tblBooksAuthorsXref xref ON xref.isbn = b.isbn LEFT JOIN tblAuthors a ON xref.authorId = a.authorId' .
        ' LEFT JOIN FilteredUC fuc ON fuc.isbn = b.isbn LEFT JOIN FilteredUW fuw ON fuw.isbn = b.isbn' .
        " WHERE b.isbn='$isbn';";
}

$myConn->set_query_string($queryString);
$result = $myConn->execute_query();
if (!$result)
    die ('The query failed for some reason');
$book = $myConn->get_first_result(RETURN_OBJECT);


$description = preg_replace('/[^(\x20-\x7F)]*/', '', html_entity_decode($book->description));

function clean($str){

    $trimmed = $str;
    return $trimmed;
}

?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Volga/<?php echo $book->title ?></title>
        <link href="style.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,600,800" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    </head>

    <body>
    <div class="inner">
        <form class="left" id="searchBar" method="post" action="books.php">
            <input class="left" type="text" name="muse" id="search"/>
            <select class="left" id="searchOptions" name="category" size="1">
                <option selected>Title</option>
                <option>Author</option>
                <option>Isbn</option>
            </select>
            <input class="left" type="submit" id="searchButton" value="SEARCH"/>
        </form>

        <p class="account right"><?php
            if(!$_SESSION["name"]){
                echo '<a class="login" href="login.html">Login</a>';
            } else {
                echo 'Hello, ' . $_SESSION["name"] . " &nbsp &nbsp <a class='login' href='cart.php'>Cart</a> &nbsp &nbsp <a class='login' href='wishlist.php'>Wishlist</a> &nbsp &nbsp <a class='login' href='logout.php?href=book.php?isbn=$isbn'>Logout</a>";
            }
            ?>
        </p>

        <a id="logo" href="index.php">
            <h1>Volga</h1>
        </a>
    </div>

    <header>
        <nav class="inner">
            <!-- Start nav list-->
            <ul>
                <li>
                    <a href="index.php">
                        Home
                    </a>
                </li><li>
                    <a href="books.php">
                        Books
                    </a>
                </li><li>
                    <a href="get-genres.php">
                        Genres
                    </a>
                </li>
            </ul><!-- End nav list -->
        </nav>
    </header>

        <div class="inner">
            <div class="left" id="imgHolder">
                <img id="pic" src="images/books/<?php echo $book->imageFilename ?>" alt="book cover for <?php echo $book->title?>" width="391px">
                <h3 id="pages"><?php echo $book->pages ?> Pages</h3>
            </div>
            <div class="right" id="booksDetails">
                <h2><?php echo $book->title . ' (' . $book->binding . ')' ?></h2>
                <h3><?php echo $book->compositeName ?></h3>
                <p><?php print($description) ?></p>
            </div>
            <div id="bottomContent">
                <h4 id="price">$<?php echo sprintf("%.2f", $book->price) ?></h4>
                <?php
                if(!$book->cemail){
                echo '<a href="addcart.php?href=book.php?isbn=' . $book->isbn . '&isbn=' . $book->isbn . '" class="addCart">Add To Cart</a>';
                } else {
                echo '<a href="removecart.php?href=book.php?isbn=' . $book->isbn . '&isbn=' . $book->isbn . '" class="addCart" style="font-size:15px">Remove From Cart</a>';
                }


                if(!$book->wemail){
                echo '<a href="addwishlist.php?href=book.php?isbn=' . $book->isbn . '&isbn=' . $book->isbn . '" class="addWish">Add To Wishlist</a>';
                } else {
                echo '<a href="removewishlist.php?href=book.php?isbn=' . $book->isbn . '&isbn=' . $book->isbn . '" class="addWish" style="font-size:12px;">Remove from Wishlist</a>';
                }

                $queryString = 'DROP TABLE FilteredUC, FilteredUW;';

                $myConn->set_query_string($queryString);
                $result = $myConn->execute_query();
                ?>
            </div>
        </div>
    </body>
</html>
