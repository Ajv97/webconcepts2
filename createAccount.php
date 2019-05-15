<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Volga/Create Account</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Raleway:400,600,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600" rel="stylesheet">
    <?php
    $error = $_GET['error'];
    $name = $_GET['name'];
    $email = $_GET['email'];
    $pass1 = $_GET['pass1'];
    $pass2 = $_GET['pass2'];
    ?>
</head>

<body>
<a id="logo" href="index.php">
    <h1>Volga</h1>
</a>

<div class="center" id="create">
    <form method="post" action="checkaccount.php">
        <h2>Create account</h2>

        <label>Your Name</label>
        <input type="text" name="name" value="<?php echo $name ?>">
        <?php
        if($error==1){
            echo '<p class="error">! Enter your name</p>';
        }elseif($error==2){
            echo '<p class="error">! Name was too long</p>';
        }
        ?>

        <label>Email</label>
        <input type="email" name="email" value="<?php echo $email ?>">
        <?php
        if($error==3){
            echo '<p class="error">! Enter your email</p>';
        }elseif($error==4){
            echo '<p class="error">! Enter a valid email</p>';
        }elseif($error==5){
            echo '<p class="error">! Enter a valid email</p>';
        }
        ?>

        <label>Password</label>
        <input type="password" name="password1" value="<?php echo $pass1 ?>">
        <?php
        if($error==6){
            echo '<p class="error">! Enter your password</p>';
        }elseif($error==7){
            echo '<p class="error">! Password must contain at least 6 characters</p>';
        }
        ?>

        <label>Re-enter password</label>
        <input type="password" name="password2" value="<?php echo $pass2 ?>"4>
        <?php
        if($error==8){
            echo '<p class="error">! Passwords must match</p>';
        }
        ?>

        <br/>
        <input type="submit" value="Create your Volga account">
    </form>
</div>

<footer>

</footer>
</body>
</html>
