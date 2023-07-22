<?php
session_start();
ob_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);


$_SESSION['db_host'] = 'localhost';
$_SESSION['db_user'] = 'jeanie';
$_SESSION['db_password'] = 'jeanieGreeceDB';
$_SESSION['db_db'] = 'greecebookings';

$_SESSION['mysqli'] = mysqli_connect($_SESSION['db_host'],$_SESSION['db_user'], $_SESSION['db_password'], $_SESSION['db_db']);

if(!$_SESSION['mysqli']){
    echo 'Error: '. mysqli_connect_errno();
    echo '<br>';
    echo 'Error: '. mysqli_connect_error();
    exit();
}

echo 'Success: A proper connection to mySQL was made.';
echo '<br>';
echo 'Host information: '.mysqli_get_host_info($_SESSION['mysqli']);
echo '<br>';
echo 'Protocol version: '.mysqli_get_proto_info($_SESSION['mysqli']);

?>