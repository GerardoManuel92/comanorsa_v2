<?php

	include("config.php"); 
	include("includes/mysqli.php");
	include("includes/db.php");
	set_time_limit (600000);
	date_default_timezone_set('America/Mexico_City');

	$nombre_archivo="subir_saldo_banco_bajiov2.csv";//trim($_POST["archivo"]);
	$idcuenta_empresa=2;//trim($_POST["cuenta_empresa"]);

	$ubicacion=fopen("../js/upload_balance/files/".$nombre_archivo,"r");

	$tipo=0;//// 0:NO RECONOCIDO, 1:CARGO, 2:ABONO

	$cuenta="";
	$no_rastreo="";

	$idcunetaxcliente=0;

	$importe=0;


	function str_replaceChars ($str){
      return str_replace(array("$", " ", ","), "", $str);
    }

    $total=0;

	while ($data = fgetcsv ($ubicacion, 1000, ";")) {

		$total=$total+1;

		$num = count ($data);
		print "";
		$separar=explode(",",$data[0]);

		if ( abs(str_replaceChars($separar[4]))>0 OR str_replaceChars($separar[5])>0 ) {
			
			echo $separar[3]."<br><br>";

			/////REVISAR SI ES CARGO O ABONO

			if ( abs(str_replaceChars($separar[4]))>0 ) {
				
				$tipo=1;

				$importe=abs(str_replaceChars($separar[4]));

			}elseif( abs(str_replaceChars($separar[5]))>0 ) {
				
				$tipo=2;

				$importe=abs(str_replaceChars($separar[5]));

			}

			$texto=$separar[3];

			$separar_texto=explode(":", $texto);

			if ( count($separar_texto)>5 ) {

				/////************** ABONOS SPEI

				$separar_cuenta=trim($separar_texto[4]);

				$cuenta=substr($separar_cuenta,0,18);

				echo "No.de cuenta:".$cuenta."<br>";

				////////************** BUSCAR SI EL NUMERO DE CUENTA CONICIDE CON ALGUN CLIENTE

				$revision='SELECT a.id AS idcunetaxcliente FROM cuentas_bancariasxcliente a
				WHERE a.cuenta="'.$cuenta.'" ';

				$prepare=$db->sql_prepare($revision);
    			$ncuentas=$db->sql_numrows($prepare);

				if ($ncuentas>0) {
					
					echo "El ID DE LA CUENTA ES:".$idcunetaxcliente."<br>-----------------------------------<br>";

					$buscar=$db->sql_query($revision);
					$row=$db->sql_fetchrow($buscar);

					$idcunetaxcliente=trim($row["idcunetaxcliente"]);

				}else{

					echo "EL CARGO NO FUE RECONOCIDO<br>-----------------------------------<br>";

					$idcunetaxcliente=0;

				}

				//////************** CLAVE DE RASTREO 

				$rseparar=explode("Rastreo:", $texto);

				$rseparar_crastreo=trim($rseparar[1]);

				$rseparar2=explode(" ", $rseparar_crastreo);

				$no_rastreo=trim($rseparar2[0]);

				echo "Clave de rastreo:".trim($rseparar2[0])."<br>----------------------------------------------------------------<br>";

			}else{


				/////********* CARGO NO RECONOCIDO MOVIMIENTO NO SPEI

				echo "EL CARGO NO FUE RECONOCIDO<br>-----------------------------------<br>";

				$idcunetaxcliente=0;

			}

		}

		if($tipo>0) {

			$idrepeat=0;

			///////////// REVISAR MOVIMIENTOS REPETIDOS

			$repeat="SELECT id FROM `saldo_bancos` WHERE movimiento='".$separar[2]."' LIMIT 0,1";

			$prepare2=$db->sql_prepare($repeat);
    		$rmovimiento=$db->sql_numrows($prepare2);

			/*$rbuscar=$db->sql_query($repeat);
			$rrow=$db->sql_fetchrow($rbuscar);*/
			//$idrepeat=$rrow["id"];
			

			//echo $repeat."<br><br>";

			if($rmovimiento > 0){



			}else{

				
				if ( abs(str_replaceChars($separar[4]))>0 OR str_replaceChars($separar[5])>0 ) {


					$sql="INSERT INTO `saldo_bancos` (`id`, `fecha`, `idcuenta`, `fecha_banco`, `hora_banco`, `movimiento`, `cuenta`, `rastreo`, `tipo`, `descripcion`,`importe`,`idcuenta_empresa`) VALUES ('', '".date('Y-m-d')."', '".$idcunetaxcliente."', '".$separar[0]."', '".$separar[1]."', '".$separar[2]."', '".$cuenta."', '".$no_rastreo."', '".$tipo."', '".$texto."', '".$importe."', '".$idcuenta_empresa."')";

					//$db->sql_query($sql);

					echo $sql."<br><br>";

				}

			}

		}



	}

	fclose ($ubicacion);

	if ($total>0) {
		

		echo json_encode(true);

	}else{

		echo json_encode(false);

	}


?>