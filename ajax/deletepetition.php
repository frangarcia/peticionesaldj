<?php
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");	
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Content-Type: text/html; charset=UTF-8');
header('Pragma: no-cache');

require_once("../includes/database.php");
require_once("../lang/es/strings.php");


mysql_query("UPDATE petitions SET deleted=1 WHERE id_petition=$id_petition");
	

?>