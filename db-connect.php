<?php
/**
 * Created by PhpStorm.
 * User: beeker
 * Date: 2019-04-12
 * Time: 14:49
 */

require_once 'MySqlConn.class.php';

$dbHostname = 'localhost';
$dbUsername = 'root';
$dbPassword = 'root';
$dbDatabaseName = 'volga_db';

$myConn = new MySqlConn ($dbHostname, $dbUsername, $dbPassword);

$result = $myConn->connect_to_database();
if (!$result)
    die ('Error connecting to the database');

$result = $myConn->select_database($dbDatabaseName);
if (!$result)
    die ('Error selecting to the database');
?>