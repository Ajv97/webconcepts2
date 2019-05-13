<?php
/**
 * Created by PhpStorm.
 * User: beeker
 * Date: 2019-04-25
 * Time: 14:17
 */

session_start();
$isbn = $_GET['isbn'];
$email = $_SESSION['email'];
$href = $_GET['href'];

if(!$href){
    $href="book.php?isbn=$isbn";
}

if(!$email){
    header("Location: login.php?wish=$isbn");
    die();
}

require_once 'db-connect.php';

$queryString = 'DELETE FROM tblUserWishXref' .
    " WHERE email = '$email' AND isbn = '$isbn';";

$myConn->set_query_string($queryString);
$result = $myConn->execute_query();

if (!$result)
    die ('The query failed for some reason');


header("Location: $href");