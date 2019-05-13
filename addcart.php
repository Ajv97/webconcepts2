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

header("Location: $href");

if(!$email){
    header("Location: login.php?cart=$isbn");
    die();
}

require_once 'db-connect.php';

$queryString = 'INSERT INTO tblUserCartxref(`email`, `isbn`)' .
    " VALUES ('$email','$isbn');";

$myConn->set_query_string($queryString);
$result = $myConn->execute_query();

if (!$result)
    die ('The query failed for some reason');