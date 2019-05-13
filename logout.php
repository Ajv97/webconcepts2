<?php
$href=$_GET['href'];

session_start();
session_unset();
session_destroy();

header("Location: $href");
die();
