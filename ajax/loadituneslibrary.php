<?php
/*
  Copyright (C) 2003 Robert A. Wallis http://codetriangle.com

  This software is provided 'as-is', without any express or implied
  warranty.  In no event will the authors be held liable for any damages
  arising from the use of this software.

  Permission is granted to anyone to use this software for any purpose,
  including commercial applications, and to alter it and redistribute it
  freely, subject to the following restrictions:

  1. The origin of this software must not be misrepresented; you must not
     claim that you wrote the original software. If you use this software
     in a product, an acknowledgment in the product documentation would be
     appreciated but is not required.
  2. Altered source versions must be plainly marked as such, and must not be
     misrepresented as being the original software.
  3. This notice may not be removed or altered from any source distribution.
*/

session_start();
session_name("peticionesaldj");

// must do this
include "itunes_xml_parser_php5.php";
include "../includes/database.php";

require_once("../lang/es/strings.php");

// get songs from the xml file
$songs = iTunesXmlParser($xmlfile);

//Obtengo el identificador de este usuario
$result = mysql_query("SELECT id FROM users WHERE email='".$_SESSION['email']."' AND password='".$_SESSION['password']."'");
$row = mysql_fetch_array($result);

// if it worked
if ($songs){
	echo "<table id=\"listsongs\">";
	echo "<tr><th width=\"5%\" align=\"center\">".$string['id']."</th><th width=\"30%\">".$string['song']."</th><th width=\"30%\">".$string['album']."</th><th width=\"25%\">".$string['artist']."</th><th width=\"10%\">&nbsp;</th></tr>";
	// loop through the songs in the array and get 4 fields that I want to see
	foreach ($songs as $song){
	 	$artist = addslashes(trim($song['Artist']));
	 	$album = addslashes(trim($song['Album']));
	 	$namesong = addslashes(trim($song['Name']));
	 	$totaltime = (int)(trim($song['Total Time']));
	 	$location = addslashes(trim($song['Location']));
	 	$year = (int)(trim($song['Year']));
	 	if ($artist!=""){
			mysql_query("INSERT INTO artists (name) VALUES ('$artist')");
			//Obtengo el id de este artista
			$result_artist = mysql_query("SELECT id FROM artists WHERE name='$artist'");
			$row_artist = mysql_fetch_array($result_artist);
			$id_artist = $row_artist['id'];			
		 	if ($album!=""){
				mysql_query("INSERT INTO albums (name, id_artist) VALUES ('$album', $id_artist)");
				//Obtengo el identificador del album
				$result_album = mysql_query("SELECT id FROM albums WHERE name='$album'");
				$row_album = mysql_fetch_array($result_album);
				$id_album = (int)($row_album['id']);
				if ($namesong!=""){
				 	//Compruebo que no esté repetido 
				 	if (mysql_num_rows(mysql_query("SELECT id FROM songs WHERE name='$namesong' AND total_time=$totaltime AND location='$location' AND year=$year AND id_album=$id_album"))<=0){
						mysql_query("INSERT INTO songs (name, total_time, location, year, id_album) VALUES ('$namesong',$totaltime,'$location',$year,$id_album)");
					}
					$just_a_song = false;
				}
			}
			else
				$just_a_song = true;
		}
		else
			$just_a_song = true;
		
		if ($just_a_song){
			$id_album = 0;		 
		 	//Compruebo que no esté repetido 
		 	if (mysql_num_rows(mysql_query("SELECT id FROM songs WHERE name='$namesong' AND total_time=$totaltime AND location='$location' AND year=$year AND id_album=$id_album"))<=0)
				mysql_query("INSERT INTO songs (name, total_time, location, year, id_album) VALUES ('$namesong',$totaltime,'$location',$year,$id_album)");
		}
		//Selecciono el último identificador de la canción introducida para relacionarla con el usuario en cuestión
		$result_last_id = mysql_query("SELECT MAX(id) as new_id FROM songs WHERE name='$namesong' AND total_time=$totaltime AND location='$location' AND year=$year AND id_album=$id_album");
		$row_last_id = mysql_fetch_array($result_last_id);
		mysql_query("INSERT INTO users_songs (id_user, id_song) VALUES (".$row['id'].",".$row_last_id['new_id'].")");
		//echo "<li id=\"song_".$row['id']."_".$row_last_id['new_id']."\" onClick=\"toggle_song(".$row['id'].",".$row_last_id['new_id'].");\">".$row_last_id['new_id'].".-".stripslashes($namesong)." [".stripslashes($album)."] - ".stripslashes($artist)."</li>";		
		echo "<tr><td align=\"center\">".$row_last_id['new_id']."</td><td>".stripslashes($namesong)."</td><td>".stripslashes($album)."</td><td>".stripslashes($artist)."</td><td align=\"center\" nowrap><a href=\"#\" onClick=\"delete_song(".$_SESSION['id_user'].",".$row_last_id['new_id'].");\" title=\"".$string['delete_this_song']."\"><img src=\"../images/trash.gif\" border=\"0\"></a>&nbsp;<a href=\"#\" onClick=\"toggle_song(".$_SESSION['id_user'].",".$row_last_id['new_id'].");\" title=\"".$string['hidden_this_song']."\"><img src=\"../images/against.gif\" border=\"0\" id=\"img_hidden_".$row['id_song']."\"></a></td></tr>";		
	}
	echo "</table>";
}

?>