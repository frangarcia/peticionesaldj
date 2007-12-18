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
new Ajax.PeriodicalUpdater('infocontent', '../ajax/readpetitions.php', {
  method: 'get', frequency: 60, decay: 1
});

function mark_petition_as(id, action){
	url = "../ajax/markpetitionas.php";
	new Ajax.Request(url, {
		parameters: { id_petition: id, flag: action},
		method: 'post',
		onSuccess: function(transport){
			$("petition_"+id).toggle();
		}
	});	 
}


</script>
</head>
<body>
<div id="infocontent">
</div>
</body>
</html>
