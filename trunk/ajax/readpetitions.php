<?php
session_start();
session_name("peticionesaldj");

header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");	
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Content-Type: text/html; charset=UTF-8');
header('Pragma: no-cache');

require_once("../includes/database.php");
require_once("../lang/es/strings.php");
require_once("../ajax/readmail.php");

echo "<table id=\"listsongs\">";
echo "<tr><th>&nbsp;</th><th>".$string['song']."</th><th>".$string['artist']."</th><th>".$string['album']."</th><th>".$string['date_and_hour']."</th><th>&nbsp;</th></tr>";
//Obtengo las peticiones para el usuario en cuestión
$i = 1;
//$result_petitions = mysql_query("SELECT id, id_song, 'when' FROM petitions WHERE id_user=".$_SESSION['id_user']." AND played=0 AND deleted=0 ORDER BY 'when' ASC");
$result_petitions = mysql_query("SELECT id, id_song, fechahora FROM petitions WHERE id_user=1 AND played=0 AND deleted=0 ORDER BY fechahora ASC");
while ($row_petitions = mysql_fetch_array($result_petitions)){
	//Obtengo los datos de esta canción
	$result_song = mysql_query("SELECT a.name as nameArtist, al.name as nameAlbum, s.name as nameSong FROM albums al, artists a, songs s WHERE s.id=".$row_petitions['id_song']." AND s.id_album=al.id AND al.id_artist=a.id");
	if (mysql_num_rows($result_song)<=0){//Es una canción suelta
		$result_just_a_song = mysql_query("SELECT name as nameSong FROM songs WHERE id=".$row_petitions['id_song']);
		$row_song = mysql_fetch_array($result_just_a_song);
	}
	else
		$row_song = mysql_fetch_array($result_song);

	echo "<tr id=\"petition_".$row_petitions['id']."\"><td align=\"center\">$i</td><td>".stripslashes($row_song['nameSong'])."</td><td>".stripslashes($row_song['nameArtist'])."</td><td>".stripslashes($row_song['nameAlbum'])."</td><td>".$row_petitions['fechahora']."</td><td align=\"center\"><a href=\"#\" onClick=\"mark_petition_as(".$row_petitions['id'].",'played');\"><img src=\"../images/checkmark.gif\" title=\"".$string['mark_as_played']."\"></a>&nbsp;<a href=\"#\" onClick=\"mark_petition_as(".$row_petitions['id'].",'deleted');\" title=\"".$string['delete_this_petition']."\"><img src=\"../images/trash.gif\"></a></td></tr>";
	$i++;
}
echo "</table>";


?>
