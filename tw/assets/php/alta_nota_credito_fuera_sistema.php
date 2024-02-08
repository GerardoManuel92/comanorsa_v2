<?php





include("config.php"); 

include("includes/mysqli.php");

include("includes/db.php");

set_time_limit (600000);

date_default_timezone_set('America/Mexico_City');





	$nota=trim($_POST["nc"]);

	$idfactura=trim($_POST["idfact"]);

	$tipo=trim($_POST["tipo"]);

	//$nota="NC10.xml";//trim($_POST["nc"]);
	$idfactura_aplicar=trim($_POST["idfactura_aplicar"]);
	$idtipo=trim($_POST["idtipo"]);
	$xpagarx=trim($_POST["xpagarx"]);
	$idusuariox=trim($_POST["idusuario"]);



	////////////********************* EXTRACCION DE DATOS DEL COMPROBANTE TIMBRADO



	$xml = simplexml_load_file('../js/upload_cxc_nota/files/'.$nota);

	//$xml = simplexml_load_file('factura_comprobante/A277.xml');////////////COLOCAMOS FOLIO DE PRUEBA

	foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante) {

	    $atributos      = $cfdiComprobante->attributes();

	    //$noCertificadox = $atributos['NoCertificado'];

	    $totalx = $atributos['Total'];

	    $formaPago=$atributos['FormaPago'];

	    $folio=$atributos['Folio'];

		$serie=$atributos['Serie'];



		$nc=$serie."".$folio;

	}





	/*foreach ($xml->xpath('//cfdi:CfdiRelacionado') as $cfdiComprobante) {

	    $atributos      = $cfdiComprobante->attributes();

	    //$noCertificadox = $atributos['NoCertificado'];

	    $uuidx = $atributos['UUID'];

	}*/





	////////// **** buscamos la factura aplicar por el uuid 



	/*$sql="SELECT id, '0' AS tipo FROM alta_factura WHERE uuid='".$uuidx."'

			UNION ALL

			SELECT id, '1' AS tipo FROM alta_factura_sustitucion WHERE uuid='".$uuidx."'";



	$buscar=$db->sql_query($sql);

	$row=$db->sql_fetchrow($buscar);



	$idfactura=$row["id"];

	$tipo=$row["tipo"];*/





	//////////////////******** insertar en la tabla para darla de alta en el sistema


	$importe_aplicado=0;
	$factura_concluida=0;


	if ($idfactura > 0) {



		$sql2="INSERT INTO `notas_credito_fuera_sistema` (`id`, `iduser`, `idfactura`, `tipo`, `total`, `folio`, `fpago`, `estatus`) 

		VALUES (NULL, '1','".$idfactura."', '".$tipo."','".$totalx."','".$nc."', '".$formaPago."', '0')";

		$db->sql_query($sql2);


		//////////// BUSCAMO EL ULTIMO ID E INSERTAMOS EN LA TABLA DE NOTAS APLICADAS A FACTURA

		$sql3='SELECT MAX(id) AS last_id FROM `notas_credito_fuera_sistema` LIMIT 0,1';
		$buscar3=$db->sql_query($sql3);
		$row3=$db->sql_fetchrow($buscar3);

		/////// CALCULAMOS EL IMPORTE DE LA NOTA CON RESPECTO A LA FACTURA 

		if($xpagarx>$totalx OR $xpagarx==$totalx) {

			////// La nota aplicada concluye por que se aplica por completo

			$importe_aplicado=$totalx

			if ($xpagarx==$totalx) {
				
				$factura_concluida=1;

			}

			
		}elseif($totalx>$xpagarx) {

			///// la nota no concluye por que es mas grande que el importe de la factura

			$importe_aplicado=$totalx-$xpagarx;/// el saldod e la nota menos el importe de la factura

			//////***** CAMBIAR EL ESTATUS DE LA FACTURA A PAGADA 
			$factura_concluida=1;


		}

		$sql4="INSERT INTO `aplicacion_pagos_nc_fuera_sistema` (`id`, `fecha`, `iduser`, `idnota`, `idfactura`, `tipo`, `importe`, `estatus`) VALUES (NULL, '".date('Y-m-d')."', '".$idusuariox."', '".$row3['last_id']."', '".$idfactura_aplicar."', '".$idtipo."', '".$importe_aplicado."', '0')";

		$db->sql_query($sql4);


		if ($factura_concluida==1) {

			if($idtipo==0) {
				
				$sql5="UPDATE alta_factura SET pago=1 WHERE id=".$idfactura_aplicar;
				$db->sql_query($sql5);

			}elseif($idtipo==1) {
				
				$sql5="UPDATE alta_factura_sustitucion SET pago=1 WHERE id=".$idfactura_aplicar;
				$db->sql_query($sql5);

			}

			$db->sql_query($sql5);
			
		}

		echo json_encode(true);



	}else{



		echo json_encode(false);



	}









?>