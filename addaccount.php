<?php

$name=$_GET['name'];
$email=$_GET['email'];
$pass=$_GET['pass'];

require_once 'db-connect.php';

$queryString = 'INSERT INTO tblUser(`name`, `pass`, `email`)' .
    " VALUES ('$name','$pass','$email');";
$myConn->set_query_string($queryString);
$result = $myConn->execute_query();

header("Location: index.php");
die();
if (!$result)
    die ('The query failed for some reason');
