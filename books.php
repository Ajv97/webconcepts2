<?php
/**
 * Created by PhpStorm.
 * User: beeker
 * Date: 2019-04-15
 * Time: 16:55
 */

require_once 'db-connect.php';

$genreId = $_GET['id'];

session_start();
unset($_SESSION['wish']);
unset($_SESSION['cart']);
$email = $_SESSION['email'];

$search = $_POST['muse'];
$searchOption = $_POST['category'];

$queryString;
if(!$search) {
    if (!$email) {
        if (!$genreId) {
            $queryString = 'SELECT b.isbn, b.title, b.price, b.pubDate, b.imageFilename, a.compositeName FROM tblBooks b' .
                ' LEFT JOIN tblBooksAuthorsXref bax on b.isbn = bax.isbn LEFT JOIN tblAuthors a on bax.authorId = a.authorId' .
                ' ORDER BY title;';

        } else {
            $queryString = 'SELECT b.isbn, b.title, b.price, b.pubDate, b.imageFilename, a.compositeName, g.genreName FROM tblBooks b' .
                ' LEFT JOIN tblBooksGenresXref bgx ON b.isbn = bgx.isbn LEFT JOIN tblGenres g ON g.genreId = bgx.genreId' .
                ' LEFT JOIN tblBooksAuthorsXref bax on b.isbn = bax.isbn LEFT JOIN tblAuthors a on bax.authorId = a.authorId' .
                " WHERE bgx.genreId = '$genreId' ORDER BY title;";
        }
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

        if (!$genreId) {
            $queryString = 'SELECT b.isbn, b.title, b.price, b.pubDate, b.imageFilename, a.compositeName, fuc.cemail, fuw.wemail FROM tblBooks b' .
                ' LEFT JOIN tblBooksAuthorsXref bax ON b.isbn = bax.isbn LEFT JOIN tblAuthors a ON bax.authorId = a.authorId' .
                ' LEFT JOIN FilteredUC fuc ON fuc.isbn = b.isbn LEFT JOIN FilteredUW fuw ON fuw.isbn = b.isbn' .
                ' ORDER BY title;';
        } else {
            $queryString = 'SELECT b.isbn, b.title, b.price, b.pubDate, b.imageFilename, a.compositeName, g.genreName, fuc.cemail, fuw.wemail FROM tblBooks b' .
                ' LEFT JOIN tblBooksGenresXref bgx ON b.isbn = bgx.isbn LEFT JOIN tblGenres g ON g.genreId = bgx.genreId' .
                ' LEFT JOIN tblBooksAuthorsXref bax ON b.isbn = bax.isbn LEFT JOIN tblAuthors a ON bax.authorId = a.authorId' .
                ' LEFT JOIN FilteredUC fuc ON fuc.isbn = b.isbn LEFT JOIN FilteredUW fuw ON fuw.isbn = b.isbn' .
                " WHERE bgx.genreId = '$genreId' ORDER BY title;";
        }
    }
} else {
    if(!$email) {
        switch ($searchOption) {
            case "Title":
                $queryString = 'SELECT b.isbn, b.title, b.price, b.pubDate, b.imageFilename, a.compositeName FROM tblBooks b' .
                    ' LEFT JOIN tblBooksAuthorsXref bax on b.isbn = bax.isbn LEFT JOIN tblAuthors a on bax.authorId = a.authorId' .
                    " WHERE b.title LIKE '%$search%' ORDER BY title;";
                break;

            case "Author":
                $queryString = 'SELECT b.isbn, b.title, b.price, b.pubDate, b.imageFilename, a.compositeName FROM tblBooks b' .
                    ' LEFT JOIN tblBooksAuthorsXref bax on b.isbn = bax.isbn LEFT JOIN tblAuthors a on bax.authorId = a.authorId' .
                    " WHERE a.compositeName LIKE '%$search%' ORDER BY title;";
                break;

            case "Isbn":
                $queryString = 'SELECT b.isbn, b.title, b.price, b.pubDate, b.imageFilename, a.compositeName FROM tblBooks b' .
                    ' LEFT JOIN tblBooksAuthorsXref bax on b.isbn = bax.isbn LEFT JOIN tblAuthors a on bax.authorId = a.authorId' .
                    " WHERE b.isbn LIKE '%$search%' ORDER BY title;";
                break;
        }
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

        switch ($searchOption) {
            case "Title":
                $queryString = 'SELECT b.isbn, b.title, b.price, b.pubDate, b.imageFilename, a.compositeName, fuc.cemail, fuw.wemail FROM tblBooks b' .
                    ' LEFT JOIN tblBooksAuthorsXref bax ON b.isbn = bax.isbn LEFT JOIN tblAuthors a ON bax.authorId = a.authorId' .
                    ' LEFT JOIN FilteredUC fuc ON fuc.isbn = b.isbn LEFT JOIN FilteredUW fuw ON fuw.isbn = b.isbn' .
                    " WHERE b.title LIKE '%$search%' ORDER BY title;";
                break;

            case "Author":
                $queryString = 'SELECT b.isbn, b.title, b.price, b.pubDate, b.imageFilename, a.compositeName, fuc.cemail, fuw.wemail FROM tblBooks b' .
                    ' LEFT JOIN tblBooksAuthorsXref bax ON b.isbn = bax.isbn LEFT JOIN tblAuthors a ON bax.authorId = a.authorId' .
                    ' LEFT JOIN FilteredUC fuc ON fuc.isbn = b.isbn LEFT JOIN FilteredUW fuw ON fuw.isbn = b.isbn' .
                    " WHERE a.compositeName LIKE '%$search%' ORDER BY title;";
                break;

            case "Isbn":
                $queryString = 'SELECT b.isbn, b.title, b.price, b.pubDate, b.imageFilename, a.compositeName, fuc.cemail, fuw.wemail FROM tblBooks b' .
                    ' LEFT JOIN tblBooksAuthorsXref bax ON b.isbn = bax.isbn LEFT JOIN tblAuthors a ON bax.authorId = a.authorId' .
                    ' LEFT JOIN FilteredUC fuc ON fuc.isbn = b.isbn LEFT JOIN FilteredUW fuw ON fuw.isbn = b.isbn' .
                    " WHERE b.isbn LIKE '%$search%' ORDER BY title;";
                break;
        }
    }
}
$myConn->set_query_string($queryString);
$result = $myConn->execute_query();
if (!$result)
    die ('The query failed for some reason');
$books = $myConn->get_first_result(RETURN_OBJECT);
$num_rows = $myConn->get_number_of_returned_rows();
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Volga/<?php if(!$genreId){echo 'Books';}else{echo 'Genre/' . $books->genreName;} ?></title>
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
                if(!$_SESSION['name']){
                    echo '<a class="login" href="login.html">Login</a>';
                } else {
                    echo 'Hello, ' . $_SESSION['name'] . " &nbsp &nbsp <a class='login' href='cart.php'>Cart</a> &nbsp &nbsp <a class='login' href='wishlist.php'>Wishlist</a> &nbsp &nbsp <a class='login' href='logout.php?href=books.php?id=$genreId'>Logout</a>";
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

        <!-- Start inner Div -->
        <div class="inner">
            <div style="margin:auto">
            <h1><?php
                if (!$genreId && !$search) {
                    echo 'All Books';
                } elseif (!$genreId){
                    echo $searchOption . ' results for "'. $search . '"';
                } else {
                    echo $books->genreName;
                }
                ?></h1>

            <?php
            if($num_rows==0){
                echo '<h3 style="text-align:center;margin-top:60px;">There are no books found under your search</h3>';
            }
            for ($i = 0; $i < $num_rows; $i++) {
                if($i != 0){
                    echo '<div class="spacer"></div>';
                }
                echo '<a href="book.php?isbn=' . $books->isbn . '">
                    <div class="bookLog">
                        <img class="bookCover left" src="images/books/' . $books->imageFilename . '" alt="The Cover for ' . $books->title . '" width="195">
                        <div class="details left">
                            <h3><em>TITLE</em><br>' .
                    $books->title .
                    '</h3><h3><em>AUTHOR</em><br>';

                if (!$books->compositeName) {
                    echo 'Unknown';
                } else {
                    echo $books->compositeName;
                }

                echo '</h3><h3><em>DATE PUBLISHED</em><br>';

                if (!$books->pubDate || $books->pubDate == '0000-00-00') {
                    echo 'Unknown';
                } else {
                    echo $books->pubDate;
                }

                echo '</h3>
                        </div>
                        <div class="purcahseButtons left">
                            <h2 class="logPrice">$' . sprintf("%.2f", $books->price) . '</h2>';

                if(!$books->cemail){
                    echo '<a href="addcart.php?href=books.php?id=' . $genreId . '&isbn=' . $books->isbn . '" class="addCart">Add To Cart</a>';
                } else {
                    echo '<a href="removecart.php?href=books.php?id=' . $genreId . '&isbn=' . $books->isbn . '" class="addCart" style="font-size:15px">Remove From Cart</a>';
                }


                if(!$books->wemail){
                    echo '<a href="addwishlist.php?href=books.php?id=' . $genreId . '&isbn=' . $books->isbn . '" class="addWish">Add To Wishlist</a>';
                } else {
                    echo '<a href="removewishlist.php?href=books.php?id=' . $genreId . '&isbn=' . $books->isbn . '" class="addWish" style="font-size:12px;">Remove from Wishlist</a>';
                }

                        echo '</div>
                    </div>
                    </a>';

                $books = $myConn->get_next_result(RETURN_OBJECT);
            }

            $queryString = 'DROP TABLE FilteredUC, FilteredUW;';

            $myConn->set_query_string($queryString);
            $result = $myConn->execute_query();
            ?>
            </div>
        </div><!-- End inner -->
    </body>
</html>

