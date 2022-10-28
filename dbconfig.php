<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();

date_default_timezone_set('Asia/Calcutta');

$page_name = $_SERVER['PHP_SELF'];

define("base_url", "http://expertalterationsandtuxedo.com/");
define("admin_mail", "creative@corporateranking.com");

/* Table Name */

define('tbl_booking',"booking_aptment");


/* Table Name */
$DB_HOST = 'vuxmysql14';
$DB_USER = 'ealtertiontuxedo';
$DB_PASS = 'Tuxedo0867';
$DB_NAME = 'altertiontuxedo';

try
{
	$DB_con = new PDO("mysql:host={$DB_HOST};dbname={$DB_NAME}",$DB_USER,$DB_PASS);
	$DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e)
{
	echo $e->getMessage();
}

?>