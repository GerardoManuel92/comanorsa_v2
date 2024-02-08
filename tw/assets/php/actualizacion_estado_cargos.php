<?php

	include("config.php"); 
	include("includes/mysqli.php");
	include("includes/db.php");
	set_time_limit (600000);
	date_default_timezone_set('America/Mexico_City');

	$nombre_archivo=trim($_POST["archivo"]);
	$idcuenta_empresa=trim($_POST["cuenta_empresa"]);
	//$idUserJS = trim($_POST["idUser"]);

	$ubicacion=fopen("../js/upload_balance_cargos/files/".$nombre_archivo,"r");

	$tipo=0;//// 0:NO RECONOCIDO, 1:CARGO, 2:ABONO

	$cuenta="";
	$clave_rastreo="";

	$idCuentaProveedor=0;
	$idproveedor =0;

	$importe=0;
	$estatus = 0;


	function str_replaceChars ($str){
      return str_replace(array("$", " ", ","), "", $str);
    }

    $total=0;

	while ($data = fgetcsv ($ubicacion, 1000, ";")) {

		$total=$total+1;

		$num = count ($data);

		$separar=explode(",",$data[0]);
		//echo(abs(str_replaceChars($separar[5])));

		if ( abs(str_replaceChars($separar[4]))>0 ) {

			$tipo=1;
			$importe=abs(str_replaceChars($separar[4]));
			$importe = round(($separar[4]), 2);
			//echo ($importe);

			$texto=$separar[3];

			$descripcion_separada=explode("|", $texto);

			if (strpos($descripcion_separada[0], 'SPEI Enviado:') !== false) {

				/////************** ABONOS SPEI
				$separar_cuenta=($descripcion_separada[3]);
				//echo($separar_cuenta."\n\n\n\n");
				$cuenta = "";

				$expresion_regular = "/Cuenta Beneficiario: (\S+)/";

				if (preg_match($expresion_regular, $separar_cuenta, $coincidencias)) {
					$cuenta = $coincidencias[1];
					//echo($coincidencias[1]." ");
				} else {
					$cuenta = "";
					//echo("NOHAY");
				}

				//echo "No.de cuenta:".$cuenta."<br>";

				////////************** BUSCAR SI EL NUMERO DE CUENTA CONICIDE CON ALGUN PROVEEDOR

				$revision='SELECT cuentaProveedor.id AS cuentaprov, cuentaProveedor.idproveedor AS idproveedor FROM alta_cuentas_proveedor cuentaProveedor
							WHERE cuentaProveedor.cuenta="'.$cuenta.'" AND estatus=1';

				$prepare=$db->sql_prepare($revision);
    			$ncuentas=$db->sql_numrows($prepare);

				if ($ncuentas>0) {
					
					//echo "El ID DE LA CUENTA ES:".$idCuentaProveedor."<br>-----------------------------------<br>";

					$buscar=$db->sql_query($revision);
					$row=$db->sql_fetchrow($buscar);

					$idCuentaProveedor =trim($row["cuentaprov"]);
					$idproveedor =trim($row["idproveedor"]);

					$fpagox=3;
					$estatus = 0;

				}else{

					// el número de cuenta no fue reconocido
					$idproveedor =0;
					$idCuentaProveedor=0;
					$fpagox=0;
					$estatus = 2;

				}

				//////************** CLAVE DE RASTREO 

				$separar_cuenta=trim($descripcion_separada[6]);
				$clave_rastreo = "";

				$expresion_regular = "/Clave de Rastreo: (\S+)/";

				if (preg_match($expresion_regular, $separar_cuenta, $coincidencias)) {
					$clave_rastreo = $coincidencias[1];
				} else {
					$clave_rastreo = "No se encontro clave de rastreo";
				}

			}else{

				/////********* CARGO NO RECONOCIDO MOVIMIENTO NO SPEI, se carga a alta_gastos
				$revision='SELECT * FROM alta_gastos WHERE descripcion_original ="'.$texto.'"';

				$prepare=$db->sql_prepare($revision);
    			$ncuentas=$db->sql_numrows($prepare);

				if ($ncuentas > 0) {		
					// Ya esta registrado
				}else{

					// NO esta registrado

					$sql="INSERT INTO `alta_gastos` ( `fecha`, `descripcion_original`, `descripcion_editada`, `importe`, `estatus`) VALUES ('".$separar[0]."', '".$texto."', '".$texto."', '".$importe."', '0')";
					$db->sql_query($sql);

				}

				$tipo = 0;

			}

		}

		if($tipo>0) {

			$idrepeat=0;

			///////////// REVISAR MOVIMIENTOS REPETIDOS

			$repeat="SELECT id FROM `alta_saldo_proveedor` WHERE descripcion='".$separar[3]."' LIMIT 0,1";

			$prepare2=$db->sql_prepare($repeat);
    		$rmovimiento=$db->sql_numrows($prepare2);

			if($rmovimiento > 0){


			}else{

				
				$sql="INSERT INTO `alta_saldo_proveedor` (`id`, `fecha`, `idcuenta`, `fecha_banco`, `hora_banco`, `movimiento`, `cuenta`, `rastreo`, `tipo`, `descripcion`,`importe`,`idcuenta_empresa`,`fpago`,`idproveedor`, `estatus`) VALUES ('', '".date('Y-m-d')."', '".$idCuentaProveedor."', '".$separar[0]."', '".$separar[1]."', '".$separar[2]."', '".$cuenta."', '".$clave_rastreo."', '".$tipo."', '".$separar[3]."', '".$importe."', '".$idcuenta_empresa."', '".$fpagox."', '".$idproveedor."', '".$estatus."')";
				$db->sql_query($sql);

				// Inserción en pago_proveedor

				$revision='SELECT MAX(id) AS id FROM alta_saldo_proveedor';

				$buscar=$db->sql_query($revision);
				$row=$db->sql_fetchrow($buscar);

				$idSaldoProveedor =trim($row["id"]);

				//$sql="INSERT INTO `alta_pago_proveedor` (`id`, `fecha`, `idodc`, `idproveedor`, `idsaldo`, `iduser`, `total`) VALUES ('', '".date('Y-m-d')."', '0', '".$idproveedor."', '".$idSaldoProveedor."', '".$idUserJS."', '".$importe."')";
				//$db->sql_query($sql);



			}

			$tipo=0;

		}

	}

	fclose ($ubicacion);

	if ($total>0) {
	
		echo json_encode(TRUE);

	}else{

		echo json_encode(FALSE);

	}


?>