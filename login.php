<?php
/**
 * Created by PhpStorm.
 * User: beeker
 * Date: 2019-04-25
 * Time: 14:17
 */

session_start();

$wish=$_GET['wish'];
if($wish){
    $_SESSION['wish']=$wish;
}

$cart = $_GET['cart'];
if($cart){
    $_SESSION['cart']=$cart;
}

$email=$_POST['email'];
$pass=$_POST['password'];

if($_SESSION['wish']){
    header('Location: relogin.php?error=1');
    die();
}

if((!$email || !$pass) && $_SESSION['cart']){
    header('Location: relogin.php?error=2');
    die();
}

require_once 'db-connect.php';

$queryString = 'SELECT * FROM tblUser' .
    " WHERE email = '$email' AND pass = '$pass';";
$myConn->set_query_string($queryString);
$result = $myConn->execute_query();
if (!$result)
    die ('The query failed for some reason');
$account = $myConn->get_first_result(RETURN_OBJECT);
if(!$account){
    header("Location: relogin.php?email=$email");
    die ();
}


$_SESSION["name"]=$account->name;
$_SESSION['email']=$account->email;
$_SESSION['pass']=$account->pass;

if($_SESSION['wish']){
//    $wish=$_SESSION['wish'];
    header("Location: addwishlist.php?isbn=$wish");
    unset($_SESSION['wish']);
    die();
}

if($_SESSION['cart']){
    $cart=$_SESSION['cart'];
    header("Location: addcart.php?isbn=$cart");
    unset($_SESSION['cart']);
    die();
}

header('Location: index.php');
?>
