<?php
/**
 * Created by PhpStorm.
 * User: beeker
 * Date: 2019-04-15
 * Time: 16:55
 */

require_once 'db-connect.php';

session_start();
unset($_SESSION['wish']);
unset($_SESSION['cart']);

$email = $_SESSION['email'];
if(!$email){
    header("Location: login.html");
    die();
}

$queryString = 'CREATE TABLE FilteredUW(wemail varchar(225), isbn char(16), PRIMARY KEY(wemail, isbn));';
$myConn->set_query_string($queryString);
$result = $myConn->execute_query();

$queryString = "INSERT INTO FilteredUW (wemail, isbn) SELECT email, isbn FROM tblUserWishXref uwx WHERE uwx.email = '$email';";
$myConn->set_query_string($queryString);
$result = $myConn->execute_query();

$queryString = 'SELECT b.isbn, b.title, b.price, b.pubDate, b.imageFilename, a.compositeName, fuw.wemail FROM tblBooks b' .
    ' LEFT JOIN tblBooksAuthorsXref bax on b.isbn = bax.isbn LEFT JOIN tblAuthors a on bax.authorId = a.authorId' .
    ' LEFT JOIN tblUserCartXref ucx on ucx.isbn = b.isbn LEFT JOIN tblUser u on ucx.email = u.email' .
    ' LEFT JOIN FilteredUW fuw ON fuw.isbn = b.isbn' .
    " WHERE u.email = '$email' ORDER BY title;";

$myConn->set_query_string($queryString);
$result = $myConn->execute_query();
if (!$result)
    die ('The query failed for some reason');
$books = $myConn->get_first_result(RETURN_OBJECT);
$num_rows = $myConn->get_number_of_returned_rows();
$subtotal = 0;
session_start();
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Volga/Cart</title>
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
    <h1><?php echo $_SESSION['name'] . '\'s cart'; ?></h1>
    <div id="cartLeft">
    <?php
    if($num_rows<=0){
        echo '<h3 style="text-align:center;margin-top:60px;">There are no books in your cart</h3>';
    } else {
        for ($i = 0; $i < $num_rows; $i++) {
            if($i != 0){
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
                            <h2 class="logPrice">$' . sprintf("%.2f", $books->price) . '</h2>
                            <a href="removecart.php?href=cart.php&isbn=' . $books->isbn . '" class="addCart" style="font-size:15px">Remove From Cart</a>';

            if(!$books->wemail){
                echo '<a href="addwishlist.php?href=cart.php&isbn=' . $books->isbn . '" class="addWish">Add To Wishlist</a>';
            } else {
                echo '<a href="removewishlist.php?href=cart.php&isbn=' . $books->isbn . '" class="addWish" style="font-size:12px;">Remove from Wishlist</a>';
            }

                    echo '</div>
                    </div>
                    </a>';
            $subtotal = $subtotal + $books->price;
            $books = $myConn->get_next_result(RETURN_OBJECT);
        }
    }
    $queryString = 'DROP TABLE FilteredUW;';

    $myConn->set_query_string($queryString);
    $result = $myConn->execute_query();
    ?>
    </div>
    <div id="cartRight">
        <h2>Cart Totals</h2>
        <p>Subtotal: $<?php echo sprintf("%.2f", $subtotal) ?><br>
        Tax: $<?php $tax = $subtotal*0.08; echo sprintf("%.2f", $tax) ?><br>
        Gradtotal: $<?php echo sprintf("%.2f", $subtotal + $tax) ?></p>
        <a href="removecart.php?all=1" class="addCart" style="margin-bottom:15px">CheckOut</a>
    </div>
</div><!-- End inner -->
</body>
</html>