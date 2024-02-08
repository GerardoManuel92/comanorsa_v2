<?php

	include("config.php"); 
	include("includes/mysqli.php");
	include("includes/db.php");
	set_time_limit (600000);
	date_default_timezone_set('America/Mexico_City');

	$nombre_archivo=trim($_POST["archivo"]);
	$idcuenta_empresa=trim($_POST["cuenta_empresa"]);
	$idUserJS = trim($_POST["idUser"]);

	$ubicacion=fopen("../js/upload_csv_facturasxodc/files/".$nombre_archivo,"r");
	$total = 0;


	function str_replaceChars ($str){
      return str_replace(array("$", " ", ","), "", $str);
    }

	function getID($ODC) {
		$idODC = str_replace("ODC", "", $ODC);
		$idODC = abs(intval($idODC));
	
		if ($idODC >= 10000) {
			$idODC = $idODC - 10000;
		}
	
		return $idODC;
	}
	

	while ($data = fgetcsv ($ubicacion, 1000, ",")) {

		//$data=explode(",",$fila[0]);

		// $data[0]; -> ODC
		// $data[1]; -> Folio
		// $data[2]; -> UUID 
		// $data[3]; -> Fecha 
		// $data[4]; -> Subtotal
		// $data[5]; -> IVA
		// $data[6]; -> Total

		for ($i = 0; $i < count($data); $i++) {
			$data[$i] = str_replaceChars($data[$i]);
		}

		$revision='SELECT * FROM facturasxodc WHERE folio = "'.$data[1].'"';

		$prepare=$db->sql_prepare($revision);
		$folio=$db->sql_numrows($prepare);

		if ($folio > 0) {		
			// Ya esta registrado
		}else{
			// NO esta registrado
			$revision='SELECT * FROM alta_oc WHERE id = "'.getID($data[0]).'" AND estatus = 0';

			$prepare=$db->sql_prepare($revision);
			$odcActiva=$db->sql_numrows($prepare);

			if ($odcActiva > 0) {
				// La OC esta activa
				
				$total = $total+1;

				$sql="INSERT INTO `facturasxodc` ( `idcuenta_empresa`, `idodc`, `folio`, `uuid`, `fecha`, `subtotal`, `iva`, `total`, `estatus`) VALUES ('".$idcuenta_empresa."','".getID($data[0])."', '".$data[1]."', '".$data[2]."', '".$data[3]."', '".$data[4]."', '".$data[5]."', '".$data[6]."', '1')";
				$db->sql_query($sql);
			}

		}

	}

	fclose ($ubicacion);

	if ($total>0) {
	
		echo json_encode($total);

	}else{

		echo json_encode($total);

	}


?>