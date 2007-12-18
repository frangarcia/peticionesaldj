<?php
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");	
header('Cache-Control: no-store, no-cache, must-revalidate'); 
header('Cache-Control: post-check=0, pre-check=0', FALSE);
header('Content-Type: text/html; charset=UTF-8');
header('Pragma: no-cache');

session_start();
session_name("peticionesaldj");

require_once("../lang/es/strings.php");

//En función de la página en la que me encuentre muestro un contenido u otro
if ($page=="logout")
	session_destroy();
	
switch ($page){
			case "register":if ($_SESSION['email']==""){
								echo "<form name=\"formi\" method=\"post\">";
								echo "<h1>".$string['register1']."</h1>";
								echo "<p>".$string['register2']."</p>";
								echo "<p>";
								echo $string['tell_me_your_name']."&nbsp;<input type=\"text\" name=\"pNameRegister\" size=\"40\"><br>";
								echo $string['gmail_email']."&nbsp;<input type=\"text\" name=\"pEmailRegister\" size=\"20\"><br>";
								echo $string['gmail_password']."&nbsp;<input type=\"password\" name=\"pPasswordRegister\" size=\"20\"><br>";
								echo $string['phone_number_openmovil']."&nbsp;<input type=\"text\" name=\"pPhoneNumberRegister\" size=\"14\"><br>";
								echo "<input type=\"button\" value=\"".$string['register']."\" onClick=\"register();\">";														
								echo "</p>";
								echo "<hr/>";
								echo "<h1>".$string['register3']."</h1>";
								echo "<p>";
								echo $string['gmail_email']."&nbsp;<input type=\"text\" name=\"pEmailLogin\" size=\"20\"><br>";							
								echo $string['gmail_password']."&nbsp;<input type=\"password\" name=\"pPasswordLogin\" size=\"20\"><br>";
								echo "<input type=\"button\" value=\"".$string['login']."\" onClick=\"login();\">";
								echo "</p>";							
								echo "</form>";
							}
							else{
								echo $string['already_logged'];
							}
							break;
			case "itunes":	if ($_SESSION['email']!=""){
								echo "<form name=\"formi\" method=\"post\">";
								echo "<h1>".$string['upload_itunes_library']."</h1>";
								echo "<p>".$string['you_must_have_an_itunes_library']."</p>";
								echo "<p>";
								echo $string['xml_itunes_library']."&nbsp;<input type=\"file\" name=\"pItunes_library\" size=\"30\"><br>";
								echo "<input type=\"button\" value=\"".$string['upload']."\" onClick=\"upload_itunes_library();\">";														
								echo "</p>";
								echo "</form>";
								//Compruebo si este usuario tiene algún archivo de música subido
								require_once("../includes/database.php");
								$result = mysql_query("SELECT id_user, id_song, deleted, hidden FROM users_songs WHERE id_user=".$_SESSION['id_user']." AND deleted=0");
								if (mysql_num_rows($result)>0){
									echo "<table id=\"listsongs\">";
									echo "<tr><th width=\"5%\" align=\"center\">".$string['id']."</th><th width=\"30%\">".$string['song']."</th><th width=\"30%\">".$string['album']."</th><th width=\"25%\">".$string['artist']."</th><th width=\"10%\">&nbsp;</th></tr>";
									while ($row = mysql_fetch_array($result)){
									 	//Obtengo los datos de esta canción
										$result_song = mysql_query("SELECT s.id as idSong, a.name as nameArtist, al.name as nameAlbum, s.name as nameSong FROM albums al, artists a, songs s WHERE s.id=".$row['id_song']." AND s.id_album=al.id AND al.id_artist=a.id");
										if (mysql_num_rows($result_song)<=0){//Es una canción suelta
											$result_just_a_song = mysql_query("SELECT id as idSong, name as nameSong FROM songs WHERE id=".$row['id_song']);
											$row_song = mysql_fetch_array($result_just_a_song);
										}
										else
											$row_song = mysql_fetch_array($result_song);
										if ($row['deleted']!=1)
											$txt_nameSong = $row_song['idSong'].".-".stripslashes($row_song['nameSong'])." [".stripslashes($row_song['nameAlbum'])."] - ".stripslashes($row_song['nameArtist']);
										
										if ($row['hidden']==1)
											echo "<tr id=\"song_".$_SESSION['id_user']."_".$row_song['idSong']."\"><td align=\"center\">".$row_song['idSong']."</td><td>".stripslashes($row_song['nameSong'])."</td><td>".stripslashes($row_song['nameAlbum'])."</td><td><a href=\"http://www.lastfm.es/music/".stripslashes(str_replace(" ","+",$row_song['nameArtist']))."\" target=\"_blank\">".stripslashes($row_song['nameArtist'])."</a></td><td align=\"center\" nowrap><a href=\"#\" onClick=\"delete_song(".$_SESSION['id_user'].",".$row['id_song'].");\" title=\"".$string['delete_this_song']."\"><img src=\"../images/trash.gif\" border=\"0\"></a>&nbsp;<a href=\"#\" onClick=\"toggle_song(".$_SESSION['id_user'].",".$row['id_song'].");\" title=\"".$string['show_this_song']."\"><img src=\"../images/checkmark.gif\" border=\"0\" id=\"img_hidden_".$row['id_song']."\"></a></td></tr>";
										else
											echo "<tr id=\"song_".$_SESSION['id_user']."_".$row_song['idSong']."\"><td align=\"center\">".$row_song['idSong']."</td><td>".stripslashes($row_song['nameSong'])."</td><td>".stripslashes($row_song['nameAlbum'])."</td><td><a href=\"http://www.lastfm.es/music/".stripslashes(str_replace(" ","+",$row_song['nameArtist']))."\" target=\"_blank\">".stripslashes($row_song['nameArtist'])."</a></td><td align=\"center\" nowrap><a href=\"#\" onClick=\"delete_song(".$_SESSION['id_user'].",".$row['id_song'].");\" title=\"".$string['delete_this_song']."\"><img src=\"../images/trash.gif\" border=\"0\"></a>&nbsp;<a href=\"#\" onClick=\"toggle_song(".$_SESSION['id_user'].",".$row['id_song'].");\" title=\"".$string['hidden_this_song']."\"><img src=\"../images/against.gif\" border=\"0\" id=\"img_hidden_".$row['id_song']."\"></a></td></tr>";
									}
									echo "</table>";	
								}
								
							}
							else
								echo "<p align=\"center\">".$string['you_must_be_logged_in_to_upload_your_music']."</p>";
							break;
			case "wait_sms":
							if ($_SESSION['email']!=""){
								echo "<a href=\"#\" onClick=\"window.open('../web/listpetitions.php','peticiones','width=800,height=600');\">Ver peticiones</a>";
							}
							else
								echo "<p align=\"center\">".$string['you_must_be_logged_in_to_wait_sms']."</p>";
							break;
			case "welcome":
			default:		echo "<p>".$string['welcome1']."</p>";
							echo "<p>".$string['welcome2']."</p>";
							echo "<p>".$string['welcome3']."</p>";
							echo "<p>".$string['welcome4']."</p>";
							echo "<p>".$string['welcome5']."</p>";

							break;							
}
if ($_SESSION['email']!="")//Está logado
	echo "<p id=\"footinfocontent\">".$_SESSION['name']."&nbsp;<a href=\"#\" onClick=\"getinfocontent('logout');getoptions('welcome');\">[".$string['logout']."]</a></p>";

?>
