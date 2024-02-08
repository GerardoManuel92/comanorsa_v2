<?php


include("config.php"); 
include("includes/mysqli.php");
include("includes/db.php");
set_time_limit (600000);
date_default_timezone_set('America/Mexico_City');


	//$nota="NC10.xml";//trim($_POST["nc"]);
	$nota=trim($_POST["nc"]);

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


	foreach ($xml->xpath('//cfdi:CfdiRelacionado') as $cfdiComprobante) {
	    $atributos      = $cfdiComprobante->attributes();
	    //$noCertificadox = $atributos['NoCertificado'];
	    $uuidx = $atributos['UUID'];
	}


	//echo $uuidx." || ".$totalx;

	////////// **** buscamos la factura aplicar por el uuid 

	$sql="SELECT a.id, '0' AS tipo, b.nombre, CONCAT_WS('', c.serie, c.folio) AS fol_factura,(SELECT x.descripcion FROM sat_catalogo_fpago x WHERE x.clave='".$formaPago."') AS fpago
	FROM alta_factura a, alta_clientes b, folio_factura c
	WHERE
	a.idcliente=b.id
	AND a.idfolio=c.id
	AND a.uuid='".$uuidx."'
	UNION ALL
	SELECT a.id, '0' AS tipo, b.nombre, CONCAT_WS('', c.serie, c.folio) AS fol_factura,(SELECT x.descripcion FROM sat_catalogo_fpago x WHERE x.clave='".$formaPago."') AS fpago
	FROM alta_factura_sustitucion a, alta_clientes b, folio_factura c
	WHERE
	a.idcliente=b.id
	AND a.idfolio=c.id
	AND a.uuid='".$uuidx."'";
	$buscar=$db->sql_query($sql);
	$row=$db->sql_fetchrow($buscar);

	$idfactura=$row["id"];
	$tipo=$row["tipo"];
	$nombre=$row["nombre"];
	$fol_factura=$row["fol_factura"];
	$fpago=$row["fpago"];


	if ( $idfactura > 0 ) {
		
		$datos = array('idfactura'=>$idfactura,'tipo'=>$tipo,'cliente'=>$nombre,'fol_factura'=>$fol_factura,'totalx'=>$totalx,'formaPago'=>$fpago,'nc'=>$nc);


		echo json_encode($datos);

	}else{

		echo json_encode(null);

	}

	//echo ($totalx);


?>