<?php
require_once("../includes/database.php");
require_once("../lang/es/strings.php");

//Compruebo si este usuario está registrado
$result = mysql_query("SELECT id, name FROM users WHERE email='$email' AND password='$password'");
if (mysql_num_rows($result)>0){
 	$row = mysql_fetch_array($result);
 	session_start();
 	session_name("peticionesaldj");
 	$_SESSION['id_user'] = $row['id']; 	
 	$_SESSION['email'] = $email;
	$_SESSION['password'] = $password;
 	$_SESSION['name'] = $row['name'];
 	echo $string['welcome_home'].$_SESSION['name'];	
}
else
	echo $string['error_logging_in']." <a href=\"#\" onClick=\"getinfocontent('register')\">".$string['try_it_again']."</a>";
?>