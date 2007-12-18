<?php
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");	
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Content-Type: text/html; charset=UTF-8');
header('Pragma: no-cache');

require_once("../includes/database.php");
require_once("../lang/es/strings.php");

//Obtengo los datos de esta canción
$result_song = mysql_query("SELECT a.name as nameArtist, al.name as nameAlbum, s.name as nameSong FROM albums al, artists a, songs s WHERE s.id=$id_song AND s.id_album=al.id AND al.id_artist=a.id");
if (mysql_num_rows($result_song)<=0){//Es una canción suelta
	$result_just_a_song = mysql_query("SELECT name as nameSong FROM songs WHERE id=$id_song");
	$row_song = mysql_fetch_array($result_just_a_song);
}
else
	$row_song = mysql_fetch_array($result_song);

//Compruebo si la canción está ya insertada para este usuario
$result = mysql_query("SELECT hidden FROM users_songs WHERE id_user=$id_user AND id_song=$id_song");
$row = mysql_fetch_array($result);
if ($row['hidden']==0){//Debo eliminar la relación
	mysql_query("UPDATE users_songs SET hidden=1 WHERE id_user=$id_user AND id_song=$id_song");
	//echo "<span class=\"deleted_song\">".stripslashes($row_song['nameSong'])." [".stripslashes($row_song['nameAlbum'])."] - ".stripslashes($row_song['nameArtist'])."</span>";
	echo "1";
}
else{
	mysql_query("UPDATE users_songs SET hidden=0 WHERE id_user=$id_user AND id_song=$id_song");
	//echo stripslashes($row_song['nameSong'])." [".stripslashes($row_song['nameAlbum'])."] - ".stripslashes($row_song['nameArtist']);
	echo "0";	
}

	

?>