<?php
		include("config.php"); 
        include("includes/mysqli.php");
        include("includes/db.php");
        set_time_limit(600000);
        date_default_timezone_set('America/Mexico_City');

        function changeString($string)
        {
         
            $string = trim($string);
         
            $string = str_replace(
                array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
                array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
                $string
            );
         
            $string = str_replace(
                array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
                array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
                $string
            );
         
            $string = str_replace(
                array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
                array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
                $string
            );
         
            $string = str_replace(
                array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
                array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
                $string
            );
         
            $string = str_replace(
                array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
                array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
                $string
            );
         
            $string = str_replace(
                array('ñ', 'Ñ', 'ç', 'Ç'),
                array('n', 'N', 'c', 'C',),
                $string
            );
         
            //Esta parte se encarga de eliminar cualquier caracter extraño
            $string = str_replace(
                array('º', '~','!','&','´',';','"','°'),
                array('','','','&amp;','','','&quot;',' grados'),
                $string
            );
         
         
            return $string;
        }


/***************************************************************************
                                           								   *
	*Observaciones 						   								   *
	
	- el regimen fiscal no fue añadido revisarlo con july				   *
								                                           *
								                                           *
								                                           *
								                                           *
								                                           *
								                                           *
								                                           *
								                                           *
****************************************************************************/

//$folio= 1;//trim($_POST["folio"]);
$idcliente = trim($_POST["idcli"]);
$idfactura = trim($_POST["idfact"]);
//$idmetodo_pago = 1;//
$idcotizacion= trim($_POST["idcot"]);

///////////****************** FOLIO 

$sqlfolio = "SELECT folio FROM folio_factura ORDER BY id DESC LIMIT 0,1";
$bmax = $db->sql_query($sqlfolio);
$rowmax = $db->sql_fetchrow($bmax);

$folio = trim($rowmax["folio"])+1;//// este folio suma un numero mas para simular el siguiente folio de faturacion y ya facturado los insertamos

/////************************************* DATOS XML COMANORSA 

$sql="SELECT iva,rfc,razon_social,calle,exterior,interior,colonia,localidad,municipio,estado,pais,cp,regimen,serie_factura FROM `datos_generales` WHERE estatus = 0";
$buscar = $db->sql_query($sql);
$row = $db->sql_fetchrow($buscar);

$rfc_emisor = changeString($row["rfc"]);
$nombre_emisor = changeString($row["razon_social"]);
$calle_emisor = changeString($row["calle"]);
$exterior_emisor = changeString($row["exterior"]);
$colonia_emisor = changeString($row["colonia"]);
$localidad_emisor = changeString($row["localidad"]);
$estado_emisor = changeString($row["estado"]);
$pais_emisor = changeString($row["pais"]);
$cp_emisor = changeString($row["cp"]);
$municipio_emisor = changeString($row["municipio"]);
$regimen_fiscal = changeString($row["regimen"]);

$reg_separar = explode("-", $regimen_fiscal);
$clave_regimen = $reg_separar[0];

$serie = trim($row["serie_factura"]);
$SerieFolio =$serie."".$folio;
$nserie_folio = $serie."".$folio;
$fecha=date("Y-m-d");
$tipo_comprobante ="ingreso";//
$tasa =$row["iva"]/100;//


////////////********************************** DATOS DEL CLIENTE

$sql2="SELECT a.rfc, a.nombre, a.calle, a.exterior, a.interior, a.colonia, a.municipio, a.estado, a.cp   
FROM 
alta_clientes a
WHERE 
a.id=".$idcliente;
$buscar2 = $db->sql_query($sql2);
$row2 = $db->sql_fetchrow($buscar2);


$rfc_receptor = changeString($row2["rfc"]);///////************* RFC DE PRUEBA
$nombre_receptor = changeString($row2["nombre"]);

$calle_receptor = changeString($row2["calle"]);
$exterior_receptor = changeString($row2["exterior"]);
$interior_receptor = changeString($row2["interior"]);
$colonia_receptor = changeString($row2["colonia"]);
$municipio_receptor = changeString($row2["municipio"]);
$estado_receptor = changeString($row2["estado"]);
$pais_receptor = changeString("Mexico");
$cp_receptor = trim($row2["cp"]);


///////////////////************************** DATOS DE LA FACTURA

$sql3="SELECT a.fecha,a.hora,a.subtotal,a.iva,a.total,a.moneda,a.tcambio,b.clave AS fpago,c.clave AS cfdi,d.clave AS mpago
FROM `alta_factura` a, sat_catalogo_fpago b, sat_catalogo_cfdi c, sat_metodo_pago d
WHERE 
a.idfpago=b.id
AND a.idcfdi=c.id
and a.idmpago=d.id
AND a.id=".$idfactura;
$buscar3 = $db->sql_query($sql3);
$row3 = $db->sql_fetchrow($buscar3);

$fechax = date("Y-m-d");
$horax = date("H:i:s");
//$fecha_fact = $ti_fecha.'T'.$ti_hora;

$forma_pago = $row3["fpago"];
$uso_cfdi = $row3["cfdi"];
$metodo_pago = $row3["mpago"];
$subTotal = $row3["subtotal"];
$total_iva = $row3["iva"];
$total = $row3["total"];
$impuesto_iva = "002";
$tcambio = $row3["tcambio"];

if( $row3["moneda"] == 1 ){

	/// pesos
	$moneda = "MXN";
	$tipo_cambio = 1;

}elseif ( $row3["moneda"] == 2 ) {
	
	/// USD
	$moneda = "USD";
	$tipo_cambio = $tcambio;

}

/// ***** METODO DE PAGO

/*switch ( $idmetodo_pago ) {

	case 1:
		
		$metodo_pago = "PUE";

	break;

	case 2:
		
		$metodo_pago = "PPD";	

	break;

	case 3:
		
		$metodo_pago = "99";

	break;
	

}*/

//////////////*********************************** PARTIDAS DE LA FACTURA 

$sql4 = "SELECT a.costo,a.cantidad,a.descripcion,b.sat,c.clave AS clave_unidad,c.abr AS unidad, b.nparte, a.iva, a.descuento
FROM partes_cotizacion a, alta_productos b, sat_catalogo_unidades c
WHERE
a.idparte=b.id
AND b.idunidad=c.id
AND a.estatus = 0
AND a.idcotizacion =".$idcotizacion;
//echo $sql2;
$buscar4 = $db->sql_query($sql4);
$partes_xml = '';

$totiva = 0;
$totdescuento = 0;
$total_subtotal = 0;

while($row4=$db->sql_fetchrow($buscar4)){
	
	$ti_costo = round($row4['costo'], 2);
	$ti_cantidad = $row4['cantidad'];
	$ti_descripcionx = $row4['descripcion'];
    $replace=array('<','>','&','"','\'','¨');
    $match=array('&lt;','&gt;','&amp;','&quot;','&apos;','&quot;');
	$ti_descripcion =str_replace($replace, $match, $ti_descripcionx);
	$ti_unidad = $row4['unidad'];
	$ti_clave = $row4['nparte'];
	$ti_clavesat = $row4['sat'];
	$ti_importe = round($ti_cantidad*$ti_costo, 2);
	$vdescuento = $row4["descuento"];
	

	if ( $vdescuento > 0 ) {

		$ti_descuento = $vdescuento/100;
		$descuento =$ti_importe*$ti_descuento;
		$ti_importe_iva = round( ($ti_importe-$descuento),2 );

	}else{

		//$ti_descuento = 0;
		$descuento =0;
		$ti_importe_iva = $ti_importe;

	}
	
	$ti_clv_unidad = $row4['clave_unidad'];
	$ti_iva = $row4["iva"]/100;
	$total_iva = round( ($ti_importe_iva*$ti_iva),2 );
	$totdescuento = $totdescuento+$descuento;
	$total_subtotal = $total_subtotal+$ti_importe_iva;
	////////

	/*$partes_xml = $partes_xml.'<cfdi:Concepto ClaveProdServ="'.$ti_clavesat.'" cantidad="'.$ti_cantidad.'" unidad="'.$ti_unidad.'" noIdentificacion="'.$ti_clave.'" descripcion="'.$ti_descripcion.'" valorUnitario="'.$ti_costo.'" importe="'.$ti_importe.'" ClaveUnidad="'.$ti_clv_unidad.'" />';*/

	$partes_xml = $partes_xml.'<cfdi:Concepto Cantidad="'.$ti_cantidad.'" ClaveProdServ="'.$ti_clavesat.'" ClaveUnidad="'.$ti_clv_unidad.'" Descripcion="'.$ti_descripcion.'" Importe="'.$ti_importe.'" NoIdentificacion="'.$ti_clave.'" Unidad="'.$ti_unidad.'" ValorUnitario="'.$ti_costo.'" Descuento="'.round($descuento,2).'">
      <cfdi:Impuestos>
        <cfdi:Traslados>
          <cfdi:Traslado Base="'.$ti_importe_iva.'" Importe="'.$total_iva.'" Impuesto="002" TasaOCuota="0.160000" TipoFactor="Tasa" />
        </cfdi:Traslados>
      </cfdi:Impuestos>
    </cfdi:Concepto>';

    $totiva = $totiva+$total_iva;

}

/////////////***************** TOTAL REAL
$total_real = ( $subTotal-round($totdescuento,2) )+round($totiva,2);


$cadena_xml       = '<?xml version="1.0" encoding="utf-8"?>
<cfdi:Comprobante xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:cfdi="http://www.sat.gob.mx/cfd/3" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd" Fecha="'.date("Y-m-d").'T'.date("H:i:s").'" Folio="'.$SerieFolio.'" FormaPago="'.$forma_pago.'" LugarExpedicion="'.$cp_emisor.'" MetodoPago="'.$metodo_pago.'" Moneda="'.$moneda.'" TipoCambio="'.$tipo_cambio.'" SubTotal="'.$subTotal.'" TipoDeComprobante="I" Total="'.round($total_real,2).'" Descuento="'.round($totdescuento,2).'" Version="3.3">
  <cfdi:Emisor Nombre="'.$nombre_emisor.'" RegimenFiscal="'.$clave_regimen.'" Rfc="'.$rfc_emisor.'" />
  <cfdi:Receptor Nombre="'.$nombre_receptor.'" Rfc="'.$rfc_receptor.'" UsoCFDI="'.$uso_cfdi.'" />
  <cfdi:Conceptos>'."\r\n";

$cadena_xml      .= $partes_xml."\r\n";

$cadena_xml      .='</cfdi:Conceptos>
					  <cfdi:Impuestos TotalImpuestosTrasladados="'.round($totiva,2).'">
					    <cfdi:Traslados>
					      <cfdi:Traslado Importe="'.round($totiva,2).'" Impuesto="002" TasaOCuota="0.160000" TipoFactor="Tasa" />
					    </cfdi:Traslados>
					  </cfdi:Impuestos>
					</cfdi:Comprobante>';

         $ubicacion = 'xml/archivo_xml'.$idfactura.'.xml';
         $archivo = fopen($ubicacion, "w+");
         fwrite($archivo, $cadena_xml);

/*echo '<?xml version="1.0" encoding="iso-8859-1"?>'; 
echo '<resultado>'; 

echo '</resultado>';*/

////////////////*********************************** FACTURAR EL ARCHIVO CREADO ****************************************************************************

$nombre_fichero = $ubicacion;

if (file_exists($nombre_fichero)) {

    ///////*********** SI EXISTE EL ARCHIVO INICIAR LA FACTURACION 

	/* 
	KIT DE INTEGRACION PHP para CFID 3.3
	versión 1.0
	Integración de Timbrado de CFDI
	Licencia: MIT - https://opensource.org/licenses/MIT
	Profact - La forma más simple de facturar
	*/
	/* Ruta del servicio de integracion*/

	$ws = "https://cfdi33-pruebas.buzoncfdi.mx:1443/Timbrado.asmx?wsdl";/*<- Esta ruta es para el servicio de pruebas, para pasar a productivo cambiar por https://timbracfdi33.mx:1443/Timbrado.asmx*/
	$response = '';
	$workspace="";/*<- Configurar la ruta en donde se encuentra nuestro kit de integración para localizar correctamente el archivo Ejemplo_cfdi_3.3.xml*/
	/* Ruta del comprobante a timbrar*/
	$rutaArchivo = $nombre_fichero;
	/* El servicio recibe el comprobante (xml) codificado en Base64, el rfc del emisor deberá ser 'AAA010101AAA' para efecto de pruebas*/ 
	$base64Comprobante = file_get_contents($rutaArchivo);
	$base64Comprobante = base64_encode($base64Comprobante);
	try
	{
	$params = array();
	/*Nombre del usuario integrador asignado, para efecto de pruebas utilizaremos 'mvpNUXmQfK8=' <- Este usuario es para el servicio de pruebas, para pasar a productivo cambiar por el que le asignarán posteriormente*/
	$params['usuarioIntegrador'] = 'mvpNUXmQfK8=';
	/* Comprobante en base 64*/
	$params['xmlComprobanteBase64'] = $base64Comprobante;
	/*Id del comprobante, deberá ser un identificador único, para efecto del ejemplo se utilizará un numero aleatorio*/
	$params['idComprobante'] = rand(5, 999999);

	$context = stream_context_create(array(
	    'ssl' => array(
	        // set some SSL/TLS specific options
	        'verify_peer' => false,
	        'verify_peer_name' => false,
	        'allow_self_signed' => false
	    ),
		'http' => array(
	            'user_agent' => 'PHPSoapClient'
	            )
	 ) );
	$options =array();
	$options['stream_context'] = $context;
	$options['cache_wsdl']= WSDL_CACHE_MEMORY;
	$options['trace']= true;

	libxml_disable_entity_loader(false);
	//echo "SoapClient";

	$client = new SoapClient($ws,$options);
	//echo "__soapCall";
	$response = $client->__soapCall('TimbraCFDI', array('parameters' => $params));

	}
	catch (SoapFault $fault)
	{
		//echo "SOAPFault: ".$fault->faultcode."-".$fault->faultstring."\n";
	}
	/*Obtenemos resultado del response*/
	//echo "resultado";
	//echo $response;
	$tipoExcepcion = $response->TimbraCFDIResult->anyType[0];
	$numeroExcepcion = $response->TimbraCFDIResult->anyType[1];
	$descripcionResultado = $response->TimbraCFDIResult->anyType[2];
	$xmlTimbrado = $response->TimbraCFDIResult->anyType[3];
	$codigoQr = $response->TimbraCFDIResult->anyType[4];
	$cadenaOriginal = $response->TimbraCFDIResult->anyType[5];
	$errorInterno = $response->TimbraCFDIResult->anyType[6];
	$mensajeInterno = $response->TimbraCFDIResult->anyType[7];
	$detalleError = $response->TimbraCFDIResult->anyType[8];

	if($xmlTimbrado != '')
	{
		//echo "xmlTimbrado";
		/*El comprobante fue timbrado correctamente*/

		////////////////**************** guardamos la cadena original
		include("config.php"); 
		include("includes/mysqli.php");
		include("includes/db.php");
		set_time_limit(600000);
		date_default_timezone_set('America/Mexico_City');
		////////********************
		$sql = "UPDATE alta_factura SET cadena = '$cadenaOriginal'
		WHERE id =".$idfactura;
		$db->sql_query($sql);

		/*Guardamos comprobante timbrado*/
		file_put_contents('factura_comprobante/comprobante'.$idfactura.'.xml', $xmlTimbrado);

		/*Guardamos codigo qr*/
		file_put_contents('factura_qr/codigo'.$idfactura.'.jpg', $codigoQr);

		/*Guardamos cadena original del complemento de certificacion del SAT*/
		file_put_contents('factura_cadena/cadena'.$idfactura.'.txt', $cadenaOriginal);

			//print_r("Timbrado exitoso");

			//echo true;
			//echo "Timbrado exitoso";

			/////////******************* INSERTAMOS EL NUEVO FOLIO CREADO 

			$sqlnewfolio="INSERT INTO `folio_factura` (`id`, `serie`, `folio`, `estatus`) VALUES (NULL, '".$serie."','".$folio."', '0')";
			$db->sql_query($sqlnewfolio);

			/////////////******************* COLOCAMOS EL ULTIMO ID DE FOLIO FACTURA EN ALTA FACTURA

			$sql_update = "UPDATE alta_factura SET ftimbrado = '".date('Y-m-d')."', htimbrado='".date('H:i:s')."',idfolio = (SELECT MAX(x.id) FROM folio_factura x), estatus='1' WHERE id=".$idfactura;
			$db->sql_query($sql_update);

			/////////////******************* CAMBIAMOS EL ESTATUS DE LA COTIZACION COMO FACTURA TIMBRADA

			if ( $idcotizacion > 0 ) {

				$sql_update2 = "UPDATE alta_cotizacion SET estatus='3' WHERE id=".$idcotizacion;
				$db->sql_query($sql_update2);
				
			}

			////////////////****************** COLOCAMOS LAS PARTIDAS EN OC Y ENTREGA POR QUE LA FACTURA YA TIMBRO 

			$sqlx = "SELECT idparte,cantidad,id,iva,costo_proveedor,costo,descuento,descripcion,orden 
			FROM `partes_cotizacion` 
			WHERE idcotizacion = ".$idcotizacion." AND estatus = 0";
			$buscarx = $db->sql_query($sqlx);
			while ( $rowx = $db->sql_fetchrow($buscarx) ) {
				
				///// OC
				$sqlx1 = "INSERT INTO `partes_asignar_oc` (`id`,`fecha`,`hora`,`idcot`,`idpartecot`,`cantidad`,`idparte`,`idproveedor`,`costo`) 
				VALUES (NULL, '".date("y-m-d")."', '".date("H:i:s")."', '".$idcotizacion."', '".$rowx['id']."', '".$rowx['cantidad']."',
				'".$rowx['idparte']."', '1', '".$rowx['costo']."' ) " ;
				$db->sql_query($sqlx1);

				///// ENTREGA
				$sqlx2 = "INSERT INTO `partes_entrega` (`id`,`fecha`,`hora`,`idpartefolio`,`idfolio`,`cantidad`,`idtipo`) 
				VALUES ( NULL, '".date("y-m-d")."', '".date("H:i:s")."', '".$rowx['id']."', '".$idfactura."', '".$rowx['cantidad']."', '2'  ) " ;
				$db->sql_query($sqlx2);

	                
			}


			echo json_encode(0);

	}
	else
	{
		//echo "else";
		echo "[".$tipoExcepcion."  ".$numeroExcepcion." ".$descripcionResultado."  ei=".$errorInterno." mi=".$mensajeInterno."]" ;

		//echo false;
		//echo "Error en timbrado";
		//echo json_encode(1);

	}



} else {

		////////////************ MANDAR ALERTA DE XML MAL ESTRUCTURADO

		//echo null;
		//echo "Error, XML mal formado";
	    echo json_encode(2);

}


?>