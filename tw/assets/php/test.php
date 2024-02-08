<?php 
	
	date_default_timezone_set('America/Mexico_City');
	//echo date("H:i:s");

	$mifecha =date('H:i:s'); 
	//$mifecha->modify('-1 hours');
	$separar_hora=explode(":", $mifecha);
	$hora_menos=$separar_hora[0]-1;
	$hora_actual=$hora_menos.":".$separar_hora[1].":".$separar_hora[2];

	echo $hora_actual;

?>