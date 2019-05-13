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
$all = $_GET['all'];

if(!$href){
    if($isbn) {
        $href = "book.php?isbn=$isbn";
    }else{
        $href = "index.php";
    }
}

if(!$email){
    header("Location: login.php");
    die();
}

require_once 'db-connect.php';

$queryString = 'DELETE FROM tblUserCartXref' .
    " WHERE email = '$email' AND isbn = '$isbn';";
if($all){
    $queryString = 'DELETE FROM tblUserCartXref' .
        " WHERE email = '$email';";
}

$myConn->set_query_string($queryString);
$result = $myConn->execute_query();

if (!$result)
    die ('The query failed for some reason');


header("Location: $href");