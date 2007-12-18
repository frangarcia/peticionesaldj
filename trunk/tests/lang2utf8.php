<?php
header('Content-Type: text/html; charset=utf-8');
//Script para convertir un fichero con literales en utf-8

//Obtengo todos los ficheros de traduccion de esta carpeta
$dir = "../lang/es/original/";
$dh  = opendir($dir);
$archivos = array();
while (false !== ($nombre_archivo = readdir($dh))) {
	echo $nombre_archivo."<br>";
  	if ($nombre_archivo!="." && $nombre_archivo!=".."){
		require_once($dir.$nombre_archivo);

		$handle = fopen($dir."../".$nombre_archivo, "w");

		$output = "<?php\n";
		$keys = array_keys($string);
		foreach ($keys as $key)
			$output .= "\$string['".$key."'] = '".utf8_encode($string[$key])."';\n";

		$output .= "?>";
		fwrite($handle, $output);
		fclose($handle);
		unset($string);
	}
}

?>