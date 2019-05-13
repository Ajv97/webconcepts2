<?php

require_once 'db-connect.php';

$queryString = 'SELECT * FROM tblGenres ORDER BY genreName;';
$myConn->set_query_string($queryString);
$result = $myConn->execute_query();
if (!$result)
    die ('The query failed for some reason');
$genres = $myConn->get_first_result(RETURN_OBJECT);
$num_rows = $myConn->get_number_of_returned_rows();
session_start();
unset($_SESSION['wish']);
unset($_SESSION['cart']);
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Volga/Genres</title>
        <link href="style.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Raleway:400,600,800" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    </head>

    <body>
        <div class="inner">
            <p class="account right"><?php
                if(!$_SESSION["name"]){
                    echo '<a class="login" href="login.html">Login</a>';
                } else {
                    echo 'Hello, ' . $_SESSION["name"] . " &nbsp &nbsp <a class='login' href='cart.php'>Cart</a> &nbsp &nbsp <a class='login' href='wishlist.php'>Wishlist</a> &nbsp &nbsp <a class='login' href='logout.php?href=get-genres.php'>Logout</a>";
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

            <div class="genre">
                <?php echo '<a href="books.php?id=' . $genres->genreId . '"><h3>' . $genres->genreName . '</h3></a>';
                $genres = $myConn->get_next_result(RETURN_OBJECT); ?>
            </div>
            <?php
            for ($i = 1; $i < $num_rows; $i++) {
                echo '<div class="spacerSmall"></div> 
                              <div class="genre">
                                  <a href="books.php?id=' . $genres->genreId . '"><h3>' . $genres->genreName . '</h3></a>
                              </div>';
                $genres = $myConn->get_next_result(RETURN_OBJECT);
            }
            ?>
        </div><!-- End inner -->
    </body>
</html>
