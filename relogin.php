<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Volga/Login</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,600,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <?php
    $email = $_GET['email'];
    $error = $_GET['error'];
    ?>
</head>

<body>
<a id="logo" href="index.php">
    <h1>Volga</h1>
</a>

<div class="center">
    <form method="post" action="login.php">
        <?php
        if ($error == 1) {
            echo '<p class="error" style="text-align:center;display:block;">! Login or create account to add to wishlist</p>';
        } elseif($error == 2) {
            echo '<p class="error" style="text-align:center;display:block;">! Login or create account to add to cart</p>';
        }
        ?>
        <div class="left">
            <label>
                Email
            </label>
            <input type="email" name="email" value="<?php echo $email; ?>" required>

            <label>
                Password
            </label>
            <input type="password" name="password" required>
            <?php
            if (!$error)
                echo '<p class="error">! Email or password is incorrect</p>'
            ?>
        </div>
        <div class="right">
            <p>
                Need to <a class="login" href="createAccount.php" >create an account</a>,<br>
                or <!-- href="resetPassword.html" --><a class="login" >Reset password</a>?
            </p>
            <input type="submit" value="Login">
        </div>
    </form>
</div>
</body>
</html>
