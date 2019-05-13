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
if (!$email) {
    header("Location: login.html");
    die();
}
$queryString = 'CREATE TABLE FilteredUC(cemail varchar(225), isbn char(16), PRIMARY KEY(cemail, isbn));';
$myConn->set_query_string($queryString);
$result = $myConn->execute_query();

$queryString = "INSERT INTO FilteredUC (cemail, isbn) SELECT email, isbn FROM tblUserCartXref ucx WHERE ucx.email = '$email';";
$myConn->set_query_string($queryString);
$result = $myConn->execute_query();

$queryString = 'SELECT b.isbn, b.title, b.price, b.pubDate, b.imageFilename, a.compositeName, fuc.cemail FROM tblBooks b' .
    ' LEFT JOIN tblBooksAuthorsXref bax on b.isbn = bax.isbn LEFT JOIN tblAuthors a on bax.authorId = a.authorId' .
    ' LEFT JOIN tblUserWishXref uwx on uwx.isbn = b.isbn LEFT JOIN tblUser u on uwx.email = u.email' .
    ' LEFT JOIN FilteredUC fuc ON fuc.isbn = b.isbn' .
    " WHERE u.email = '$email' ORDER BY title;";

$myConn->set_query_string($queryString);
$result = $myConn->execute_query();
if (!$result)
    die ('The query failed for some reason');
$books = $myConn->get_first_result(RETURN_OBJECT);
$num_rows = $myConn->get_number_of_returned_rows();
session_start();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Volga/Wishlist</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,600,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
</head>

<body>
<div class="inner">
    <p class="account right"><?php
        if (!$_SESSION['name']) {
            echo '<a class="login" href="login.html">Login</a>';
        } else {
            echo 'Hello, ' . $_SESSION['name'] . " &nbsp &nbsp <a class='login' href='cart.php'>Cart</a> &nbsp &nbsp <a class='login' href='wishlist.php'>Wishlist</a> &nbsp &nbsp <a class='login' href='logout.php?href=index.php'>Logout</a>";
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
    <h1><?php echo $_SESSION['name'] . '\'s wishlist'; ?></h1>
    <?php
    if ($num_rows <= 0) {
        echo '<h3 style="text-align:center;margin-top:60px;">There are no books in your wishlist</h3>';
    } else {
        for ($i = 0; $i < $num_rows; $i++) {
            if ($i != 0) {
                echo '<div class="spacer"></div>';
            }
            echo '<a href="book.php?isbn=' . $books->isbn . '">
                    <div class="wishLog">
                        <img class="bookCover left" src="images/books/' . $books->imageFilename . '" alt="The Cover for ' . $books->title . '" width="120">
                        <div class="details left">
                            <h3 style="font-size:20px; line-height:25px; margin-top:20px;"><em>TITLE</em><br>' .
                $books->title .
                '</h3>';

            echo '</div>
                        <div class="purcahseButtons left">
                            <h2 class="logPrice">$' . sprintf("%.2f", $books->price) . '</h2>';

            if(!$books->cemail){
                echo '<a href="addcart.php?href=wishlist.php&isbn=' . $books->isbn . '" class="addCart">Add To Cart</a>';
            } else {
                echo '<a href="removecart.php?href=wishlist.php&isbn=' . $books->isbn . '" class="addCart" style="font-size:15px">Remove From Cart</a>';
            }

                        echo '<a href="removewishlist.php?href=wishlist.php&isbn=' . $books->isbn . '" class="addWish" style="font-size:12px;">Remove from Wishlist</a>
                        </div>
                    </div>
                    </a>';
            $books = $myConn->get_next_result(RETURN_OBJECT);
        }
    }
    $queryString = 'DROP TABLE FilteredUC;';

    $myConn->set_query_string($queryString);
    $result = $myConn->execute_query();
    ?>
</div><!-- End inner -->
</body>
</html>

