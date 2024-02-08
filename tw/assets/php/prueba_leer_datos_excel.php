<?php

	$ubicacion=fopen("../js/upload_balance/files/totales_banco.csv","r");

	function str_replaceChars ($str){
      return str_replace(array("$", " ", "."), "", $str);
    }

	while ($data = fgetcsv ($ubicacion, 1000, ";")) {

		$num = count ($data);
		print "";
		$separar=explode(",",$data[0]);

		if ( abs(str_replaceChars($separar[5]))>0 OR str_replaceChars($separar[6])>0 ) {
			
			echo $separar[4]."<br><br><br>";

		}

	}

	fclose ($ubicacion);


?>