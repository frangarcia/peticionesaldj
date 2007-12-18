<?php
require_once("../lang/es/strings.php");

$options = array("welcome","register","itunes","wait_sms");
echo "<ul>";
foreach ($options as $option){
	if ($page==$option)
		echo "<li class=\"selected\">".utf8_encode($string[$option])."</li>";
	else
		echo "<li><a href=\"#\" onClick=\"getoptions('$option');getinfocontent('$option');\">".utf8_encode($string[$option])."</a></li>";
}
echo "</ul>";
?>