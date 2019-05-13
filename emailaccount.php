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


require_once 'db-connect.php';

function sanitize_my_email($field) {
    $field = filter_var($field, FILTER_SANITIZE_EMAIL);
    if (filter_var($field, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {
        return false;
    }
}
$subject = 'Volga Account registration';
$message = "Hi $name we're sending this email to confirm the email you used when registering an account for Volga book store

copy the link below into your url to confirm account creation
localhost:8887/volga/addaccount.php?email=" . $email . "&pass=" . $pass1 . "&name=" . $name;
$headers = 'From: noreply@volga.com';
//check if the email address is invalid $secure_check
$secure_check = sanitize_my_email($email);


if ($secure_check == false) {
    echo "Invalid input";
} else { //send email
    mail($email, $subject, $message, $headers);
    echo "This email is sent using PHP Mail";
}
?>
