<?php
/**
 * Created by PhpStorm.
 * User: beeker
 * Date: 2019-04-22
 * Time: 14:21
 */

$name=$_POST['name'];
$email=$_POST['email'];
$pass1=$_POST['password1'];
$pass2=$_POST['password2'];


if($name == ""){
    header("Location: createAccount.php?error=1&name=$name&email=$email&pass1=$pass1&pass2=$pass2");
    die();
}

if(50 < strlen($name)){
    header("Location: createAccount.php?error=2&email=$email&pass1=$pass1&pass2=$pass2");
    die();
}

if($email == ""){
    header("Location: createAccount.php?error=3&name=$name&email=$email&pass1=$pass1&pass2=$pass2");
    die();
}

if($email == ""){
    header("Location: createAccount.php?error=4&name=$name&email=$email&pass1=$pass1&pass2=$pass2");
    die();
}

if(225 < strlen($email)){
    header("Location: createAccount.php?error=5&name=$name&email=$email&pass1=$pass1&pass2=$pass2");
    die();
}

if($pass1 == ""){
    header("Location: createAccount.php?error=6&name=$name&email=$email&pass1=$pass1&pass2=$pass2");
    die();
}

if(strlen($pass1)<6){
    header("Location: createAccount.php?error=7&name=$name&email=$email&pass1=$pass1&pass2=$pass2");
    die();
}

if(!($pass1 == $pass2)){
    header("Location: createAccount.php?error=8&name=$name&email=$email&pass1=$pass1&pass2=$pass2");
    die();
}

header("Location: addaccount.php?email=" . $email . "&pass=" . $pass1 . "&name=" . $name);
die();

?>
