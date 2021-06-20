<?php 
session_start();

$db_user 	= 'root';
$db_passw 	= '';
$db_name 	= 'test';

$records_per_page = 5;

$db = new PDO('mysql:host=127.0.0.1;dbname='.$db_name.';', $db_user, $db_passw);


$db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
$db->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, true);
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>