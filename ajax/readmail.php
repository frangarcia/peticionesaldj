<?php
//Este script pretende leer el contenido de una dirección de correo electrónico
//para analizar los últimos mensajes recibidos. Mostrará el título de los últimos 5 mensajes.
session_start();
session_name("peticionesaldj");

require_once("../includes/database.php");

$mbox = imap_open ("{imap.gmail.com:993/imap/ssl/novalidate-cert}INBOX", $_SESSION['email'], $_SESSION['password'])
     or die("can't connect: " . imap_last_error());
//Obtengo el último número de mensaje para este usuario
$result_last_message = mysql_query("SELECT id_last_message FROM last_messages WHERE id_user=".$_SESSION['id_user']);
if (mysql_num_rows($result_last_message)<=0)
	$id_last_message = 1;
else{
	$row = mysql_fetch_array($result_last_message);
	$id_last_message = $row['id_last_message'];
}
	
$num_msg = imap_num_msg($mbox);
for($i=$id_last_message+1;$i<=$num_msg;$i++){
	$msg = imap_fetch_overview($mbox,$i);
	if ($msg[0]->subject=="OPEN SMS"){
		//print_r($msg);
		$body = imap_fetchbody($mbox,$msg[0]->msgno,1);
		$info = split("\n",$body,2);
		if ((substr($info[0],0,5)=="Movil")){
			mysql_query("INSERT INTO petitions (phone_number,id_song,id_user) VALUES ('".substr($info[0],6,strlen($info[0]))."',".substr($info[1],6,strlen($info[1])).",".$_SESSION['id_user'].")");
			//Actualizo el último identificador del mensaje
			mysql_query("DELETE FROM last_messages WHERE id_user=".$_SESSION['id_user']);
			mysql_query("INSERT INTO last_messages (id_user, id_last_message) VALUES (".$_SESSION['id_user'].",".$msg[0]->msgno.")");
		}
	}
}


?>
