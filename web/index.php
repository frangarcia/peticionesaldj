<?php
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");	
	header('Cache-Control: no-store, no-cache, must-revalidate'); 
	header('Cache-Control: post-check=0, pre-check=0', FALSE);
	header('Content-Type: text/html; charset=UTF-8');
	header('Pragma: no-cache');
	include("../lang/es/strings.php");
	

	session_start();
	session_name("peticionesaldj");	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html><head><link href="../css/styles.css" type="text/css" rel="stylesheet"/>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<script src="../js/functions.js" language="javascript"></script>
<script src="../js/prototype.js" language="javascript"></script>
<script src="../js/scriptaculous.js" type="text/javascript"></script>
<script language="javascript">
var currentpage;
//new Ajax.PeriodicalUpdater('infocontent', '../ajax/readmail.php', {
//  method: 'get', frequency: 3, decay: 1
//});

function getoptions(page){
	url = "../ajax/getoptions.php?page="+page;
	new Ajax.Request(url, {
		method: 'get',
		onSuccess: function(transport){
			$("options").update(transport.responseText);
		}
	});			
}

function getinfocontent(page){
 	currentpage = page;
	url = "../ajax/getinfocontent.php?page="+page;
	new Ajax.Request(url, {
		method: 'get',
		onSuccess: function(transport){
			$("infocontent").update(transport.responseText);
		}
	});			
}

function register(){
	if (document['formi'].pNameRegister.value=="")
		alert("<?php echo $string['i_need_your_name'];?>");
	else if (document['formi'].pEmailRegister.value=="")
		alert("<?php echo $string['i_need_your_gmail_mail'];?>");	
	else if (document['formi'].pPasswordRegister.value=="")
		alert("<?php echo $string['i_need_your_gmail_password'];?>");
	else if (document['formi'].pPhoneNumberRegister.value=="")
		alert("<?php echo $string['i_need_your_phone_number'];?>");
	else{
		url = "../ajax/register.php";
		new Ajax.Request(url, {
			parameters: { name: document['formi'].pNameRegister.value, email: document['formi'].pEmailRegister.value, password: document['formi'].pPasswordRegister.value, phonenumber:document['formi'].pPhoneNumberRegister.value},
			method: 'post',
			onSuccess: function(transport){
				$("infocontent").update(transport.responseText);
			}
		});
	}
}

function login(){
	if (document['formi'].pEmailLogin.value=="")
		alert("<?php echo $string['i_need_your_gmail_mail'];?>");	
	else if (document['formi'].pPasswordLogin.value=="")
		alert("<?php echo $string['i_need_your_gmail_password'];?>");
	else{
		url = "../ajax/login.php";
		new Ajax.Request(url, {
			parameters: { email: document['formi'].pEmailLogin.value, password: document['formi'].pPasswordLogin.value},
			method: 'post',
			onSuccess: function(transport){
				$("infocontent").update(transport.responseText);
			}
		});
	}
}

function upload_itunes_library(){
	url = "../ajax/loadituneslibrary.php";
	new Ajax.Request(url, {
		parameters: { xmlfile: document['formi'].pItunes_library.value},
		method: 'post',
		onSuccess: function(transport){
			$("infocontent").update(transport.responseText);
		}
	});	
}

function toggle_song(user,song){
	url = "../ajax/togglesong.php";
	new Ajax.Request(url, {
		parameters: { id_user: user, id_song: song},
		method: 'post',
		onSuccess: function(transport){
		  	if (transport.responseText=="1")
				$("img_hidden_"+song).src = "../images/checkmark.gif";
			else
				$("img_hidden_"+song).src = "../images/against.gif";
		}
	});	 
}

function delete_song(user,song){
	if (confirm("<?php echo $string['are_you_sure_you_want_delete_this_song'];?>")){
		url = "../ajax/deletesong.php";
		new Ajax.Request(url, {
			parameters: { id_user: user, id_song: song},
			method: 'post',
			onSuccess: function(transport){
				$("song_"+transport.responseText).toggle();
			}
		});
	}
}

function delete_petition(petition){
	url = "../ajax/deletepetition.php";
	new Ajax.Request(url, {
		parameters: { id_petition: petition},
		method: 'post',
		onSuccess: function(transport){
			url = "../ajax/readpetitions.php";
			new Ajax.Request(url, {
				method: 'get',
				onSuccess: function(transport){
					$("infocontent").update(transport.responseText);
				}
			});	
		}
	});	 
}

/*function reload_readpetitions(){
	new Ajax.PeriodicalUpdater('infocontent', '../ajax/readpetitions.php', {
	  method: 'get', frequency: 10, decay: 1
	});
}*/


</script>
</head>
<body onLoad="getoptions('welcome');getinfocontent('');">
<div id="content">
<img src="../images/logopeticionesaldj.jpg" border="1">
<div id="options">
</div>
<div id="infocontent">
</div>
</div>
</body>
</html>
