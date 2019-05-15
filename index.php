<?php
session_start();
unset($_SESSION['wish']);
unset($_SESSION['cart']);
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Volga</title>
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

            <p class="right"><?php
                if(!$_SESSION["name"]){
                    echo '<a class="login" href="login.html">Login</a>';
                } else {
                    echo 'Hello, ' . $_SESSION["name"] . " &nbsp &nbsp <a class='login' href='cart.php'>Cart</a> &nbsp &nbsp <a class='login' href='wishlist.php'>Wishlist</a> &nbsp &nbsp <a class='login' href='logout.php?href=index.php'>Logout</a>";
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
            <div id="firstRow">
                <h2> About Our Site</h2>
                <h3 class="indent">
                    Our Story
                </h3>
                <p class="indent">
                    Our little humble store started through word of mouth back when homo erectus was walking the earth, in
                    search of food and comfort, in those times each human could only remember a limited amount of stories
                    averaging around three. Since then we have offered a plethora of books while staying with the tradition
                    older than the invention of time, only three books offered at a time. Once we get enough requests for a
                    different book we go out and find it, but in doing so we have to remove one of our beloved books.
                </p>
                <h3 class="indent">
                    The Books We Currently Have
                </h3>
                <p class="indent">
                    The books that are currently held at our store are part of a member royality event. Our collection contains
                    books for up and comming king for all activities. It contains "The Little Prince", perfect for every young
                    prince, or even a king that has a little one to read stories to, "The Prince", useful for the those who are
                    about to have the burden of kinghood placed appon them, and "The King".
                </p>
            </div>
        </div>

        <footer>

        </footer>
    </body>
</html>
