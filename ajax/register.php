<?php
require_once("../includes/database.php");
require_once("../lang/es/strings.php");

//Compruebo si este usuario ya está registrado
$result = mysql_query("SELECT id FROM users WHERE email LIKE '$email'");
if (mysql_num_rows($result)<=0){
	mysql_query("INSERT INTO users (name, email, password, phone_number) VALUES ('$name','$email','$password','$phonenumber')");
	if (mysql_errno()==0){
	 	session_start();
	 	session_name("peticionesaldj");
	 	$_SESSION['email'] = $email;
		$_SESSION['password'] = $password;
	 	$_SESSION['name'] = $name;
		echo $string['good_registered'];
	}
	else
		echo $string['error_registering'];	
}
else
	echo $string['error_registering'];
?>