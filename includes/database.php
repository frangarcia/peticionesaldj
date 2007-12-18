<?php
$dbhost = "localhost"; // The host where your database is
$dbname = "ddbb_peticionesaldj";  // Your database name
$dbuser = "user_petaldj";      // The user name
$dbpass = "peticionesaldj";  // The user's password

$connect = mysql_connect($dbhost, $dbuser, $dbpass);
mysql_select_db($dbname, $connect);

mysql_query("SET NAMES utf8");
mysql_query("SET collation_connection = 'utf8_unicode_ci'");
?>
