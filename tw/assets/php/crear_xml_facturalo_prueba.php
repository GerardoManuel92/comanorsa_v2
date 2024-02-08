<?php

		namespace TIMBRADORXPRESS\API;

		require __DIR__ . "/facturalo/class.conexion.php";

		use TIMBRADORXPRESS\API\Conexion;



		header('Content-Type: application/json');

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



        function redondedoFloat($cantidad,$decimales){



        	return number_format((float)$cantidad, $decimales, '.', '');



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

$idcliente =trim($_POST["idcli"]);

$idfactura =trim($_POST["idfact"]);

$idcotizacion=trim($_POST["idcot"]);

$name_factura=trim($_POST["name_factura"]);


$mifecha =date('H:i:s');
$fecha_actual=date("Y-m-d");


//$mifecha->modify('-1 hours');
$separar_hora=explode(":", $mifecha);

$separar_fecha=explode("-", $fecha_actual);

if($separar_hora[0]=="00"){
	
	$hora_menos="11";

	$diamenos=$separar_fecha-1;

	$fecha_actual=$separar_fecha[0]."-".$separar_fecha[1]."-".$diamenos;

}else{

	$hora_menos=$separar_hora[0]-1;

	if($hora_menos<10) {
		
		$hora_menos="0".$hora_menos;

	}
}

$hora_actual=$hora_menos.":".$separar_hora[1].":".$separar_hora[2];


$tipox =trim($_POST["tipo"]);



if ( $tipox == 1 ) {



	//// se va a refacturar este cfdi



	$mpagox =trim($_POST["mpagox"]);

	$fpagox =trim($_POST["fpagox"]);

	$cfdix =trim($_POST["cfdix"]);

	$odcx =trim($_POST["odc"]);



	////***************************** ACTUALIZAMOS LOS DATOS DEL SAT DEL ALTA FACTURA CON LO ENVIADO POR EL RE-TIMBRADO



	if ( $odcx != "" ) {

	

		$sql_uptfact = "UPDATE `alta_factura` SET `idmpago` = '".$mpagox."', `idfpago` = '".$fpagox."', `idcfdi` = '".$cfdix."', `odc` = '".$odcx."' 

		WHERE `id`=".$idfactura;

		$db->sql_query($sql_uptfact);



	}else{



		$sql_uptfact = "UPDATE `alta_factura` SET `idmpago` = '".$mpagox."', `idfpago` = '".$fpagox."', `idcfdi` = '".$cfdix."'

		WHERE `id`=".$idfactura;

		$db->sql_query($sql_uptfact);



	}





	



}



///////////****************** FOLIO 



$sqlfolio = "SELECT folio FROM folio_factura ORDER BY id DESC LIMIT 0,1";

$bmax = $db->sql_query($sqlfolio);

$rowmax = $db->sql_fetchrow($bmax);



$folio = trim($rowmax["folio"])+1;//// este folio suma un numero mas para simular el siguiente folio de faturacion y ya facturado los insertamos



/////************************************* DATOS XML COMANORSA 



$sql="SELECT iva,rfc,razon_social,calle,exterior,interior,colonia,localidad,municipio,estado,pais,cp,regimen,serie_factura,certificado,nocertificado,keyx,cer,keypem,cerpem,apikey FROM `datos_generales` WHERE estatus = 0";

$buscar = $db->sql_query($sql);

$row = $db->sql_fetchrow($buscar);

$nombre_emisor = changeString($row["razon_social"]);

$rfc_emisor = changeString($row["rfc"]);

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



$certificado=$row["certificado"];

$nocertificado=trim($row["nocertificado"]);



$serie = trim($row["serie_factura"]);

$SerieFolio =$folio;

$nserie_folio = $serie."".$folio;

$fecha=date("Y-m-d");

$tipo_comprobante ="ingreso";//

$tasa =$row["iva"]/100;//



$key =trim($row["key"]);

$cer =trim($row["cer"]);

$keypem =trim($row["keypem"]);

$cerpem =trim($row["cerpem"]);

$apikeyx=trim($row["apikey"]);





////////////********************************** DATOS DEL CLIENTE



$sql2="SELECT a.rfc, a.nombre, c.calle, c.exterior,c.interior, c.colonia, c.municipio, c.estado, c.cp, b.clave AS regimen_receptor  

        FROM 

        alta_clientes a, sat_catalogo_regimen_fiscal b, direccion_clientes c

        WHERE

        a.idregimen=b.id

        AND c.idcliente=a.id

        AND a.id=".$idcliente;

        $buscar2 = $db->sql_query($sql2);

        $row2 = $db->sql_fetchrow($buscar2);





        $rfc_receptor = changeString($row2["rfc"]);///////************* RFC DE PRUEBA

        //$nombre_receptor = changeString($row2["nombre"]);



        if ( $idcliente == 21 ) {

	

			if ( $name_factura != "" ) {

				

				$nombre_receptor=trim($name_factura);



			}else{



				$nombre_receptor=trim("VENTAS PUBLICO GENERAL");



			}



		}else{



			$nombre_receptor = trim($row2["nombre"]);



		}



        $calle_receptor = changeString($row2["calle"]);

        $exterior_receptor = changeString($row2["exterior"]);

        $interior_receptor = changeString($row2["interior"]);

        $colonia_receptor = changeString($row2["colonia"]);

        $municipio_receptor = changeString($row2["municipio"]);

        $estado_receptor = changeString($row2["estado"]);

        $pais_receptor = changeString("Mexico");

        $cp_receptor = trim($row2["cp"]);

        $regimen_receptor = trim($row2["regimen_receptor"]);





///////////////////************************** DATOS DE LA FACTURA



$sql3="SELECT a.fecha,a.hora,a.subtotal,a.iva,a.total,a.moneda,a.tcambio,b.clave AS fpago,c.clave AS cfdi,d.clave AS mpago, idcfdi

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

$ivax = $row3["iva"];

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



$idcfdi=trim($row3["idcfdi"]);



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



////*** revisar los ivas de la factura 



$array_iva = array();



$sql_ivax = "SELECT DISTINCT(iva) AS diferentes_ivas 

			FROM partes_factura a, partes_cotizacion b

			WHERE

			a.idpartecot=b.id

			AND a.idfactura=".$idfactura;

$buscar_iva=$db->sql_query($sql_ivax);

while ( $row_iva=$db->sql_fetchrow($buscar4) ) {

 	

	array_push($array_iva, $row_iva["diferentes_ivas"]);



 }



$sql4 = "SELECT a.costo,d.cantidad,a.descripcion,b.sat,c.clave AS clave_unidad,c.abr AS unidad, b.nparte, a.iva, a.descuento, a.riva, a.risr

FROM partes_factura d,partes_cotizacion a, alta_productos b, sat_catalogo_unidades c

WHERE

d.idpartecot=a.id

AND a.idparte=b.id

AND b.idunidad=c.id

AND a.estatus = 0

AND d.idfactura= ".$idfactura;

//echo $sql2;

$buscar4 = $db->sql_query($sql4);

$partes_xml = '';



$totiva = 0;

$totdescuento = 0;

$total_subtotal = 0;

$total_retenciones = 0;

$total_retenciones_iva = 0;

$total_retenciones_isr = 0;

$total_base_iva = 0;



$array_suma_iva= array();

$array_suma_importe=array();



$tot_subtotal_sin_desglose = 0;



while($row4=$db->sql_fetchrow($buscar4)){

	

	$ti_costo = $row4['costo'];

	$ti_cantidad = $row4['cantidad'];

	$ti_descripcionx =trim($row4['descripcion']);

    $replace=array('<','>','&','"','\'','¨','?','|');

    $match=array('&lt;','&gt;','&amp;','&quot;','&apos;','&quot;','','');

	$ti_descripcion =str_replace($replace, $match, $ti_descripcionx);

	$ti_unidad = $row4['unidad'];

	$ti_clave =trim($row4['nparte'])																																																																																												;

	$ti_clavesat = $row4['sat'];

	$ti_importe = redondedoFloat($ti_cantidad*$ti_costo, 2);

	$vdescuento = $row4["descuento"];

	$riva= $row4["riva"];

	$risr= $row4["risr"];

	



	if ( $vdescuento > 0 ) {



		$ti_descuento = $vdescuento/100;

		$descuento =redondedoFloat( ($ti_importe*$ti_descuento),2 );

		$ti_importe_iva = redondedoFloat( ($ti_importe-$descuento),2 );



	}else{



		//$ti_descuento = 0;

		$descuento =0;

		$ti_importe_iva = $ti_importe;



	}

	

	$ti_clv_unidad = $row4['clave_unidad'];



	/////////// en esta seccion se coloca el iva 0 por el array con el valor de defecto, y el iva del producto para identificar donde sumara 

	$select_iva = 0;

	$iva_producto = trim($row4["iva"]);

	////



	$ti_iva = $row4["iva"]/100;

	$total_iva = redondedoFloat( ($ti_importe_iva*$ti_iva),2 );

	$totdescuento = redondedoFloat( ($totdescuento+$descuento),2 );

	$total_subtotal = redondedoFloat( ($total_subtotal+$ti_importe_iva),2 );







	/*$partes_xml = $partes_xml.'<cfdi:Concepto ClaveProdServ="'.$ti_clavesat.'" cantidad="'.$ti_cantidad.'" unidad="'.$ti_unidad.'" noIdentificacion="'.$ti_clave.'" descripcion="'.$ti_descripcion.'" valorUnitario="'.$ti_costo.'" importe="'.$ti_importe.'" ClaveUnidad="'.$ti_clv_unidad.'" />';*/



	if ( $idcfdi == 23 ) {



		$obj_impuesto = "03";



		///// se le suma el iva a los importes 

		if ( $vdescuento > 0 ) {



			$ti_descuentox =$vdescuento/100;

			$descuentox =redondedoFloat( ($ti_costo*$ti_descuentox),2 );

			$ti_importe_descuento = redondedoFloat( ($ti_costo-$descuentox),2 );



		}else{



			//$ti_descuento = 0;

			$descuento =0;

			$ti_importe_descuento = $ti_costo;



		}





		$ti_costo_iva = $ti_importe_descuento*$ti_iva;



		$ti_costo_obj_impuesto = $ti_costo+$ti_costo_iva;

		$ti_importe_obj_impuesto = $ti_costo_obj_impuesto*$ti_cantidad;





		$tot_subtotal_sin_desglose=$tot_subtotal_sin_desglose+redondedoFloat($ti_importe_obj_impuesto,2);



		//



		$partes_xml = $partes_xml.'<cfdi:Concepto Cantidad="'.$ti_cantidad.'" ClaveProdServ="'.$ti_clavesat.'" ClaveUnidad="'.$ti_clv_unidad.'" Descripcion="'.$ti_descripcion.'"  Importe="'.redondedoFloat($ti_importe_obj_impuesto,2).'"  NoIdentificacion="'.$ti_clave.'" Unidad="'.$ti_unidad.'" ValorUnitario="'.redondedoFloat($ti_costo_obj_impuesto,2).'" Descuento="'.$descuento.'" ObjetoImp="'.$obj_impuesto.'">';



		    $partes_xml.='</cfdi:Concepto>'; 

		    $totiva = $totiva+$total_iva;

		

	}else{



		$obj_impuesto = "02";





			$partes_xml = $partes_xml.'<cfdi:Concepto Cantidad="'.$ti_cantidad.'" ClaveProdServ="'.$ti_clavesat.'" ClaveUnidad="'.$ti_clv_unidad.'" Descripcion="'.$ti_descripcion.'" Importe="'.$ti_importe.'" NoIdentificacion="'.$ti_clave.'" Unidad="'.$ti_unidad.'" ValorUnitario="'.$ti_costo.'" Descuento="'.$descuento.'" ObjetoImp="'.$obj_impuesto.'">

		      <cfdi:Impuestos>

		        <cfdi:Traslados>

		          <cfdi:Traslado Base="'.$ti_importe_iva.'" Importe="'.$total_iva.'" Impuesto="002" TasaOCuota="'.redondedoFloat($ti_iva,6).'" TipoFactor="Tasa"/>

		        </cfdi:Traslados>';



		      	$total_base_iva = $total_base_iva+$ti_importe_iva;



		      	if ( $riva > 0 OR $risr > 0 ) {

		      		

		      		////////******* CALCULAR RETENCIONES



		      		$partes_xml.='<cfdi:Retenciones>';



		      		if ( $riva > 0) {

		      			

		      			$ti_riva = $riva/100;

		      			$total_riva = redondedoFloat( ($ti_importe_iva*$ti_riva),2 );



		      			$partes_xml.='<cfdi:Retencion Base="'.$ti_importe_iva.'" Impuesto="002" TipoFactor="Tasa" TasaOCuota="'.redondedoFloat($ti_riva,6).'0000" Importe="'.$total_riva.'" />';



		      			$total_retenciones = $total_retenciones+$total_riva;

		      			$total_retenciones_iva = $total_retenciones_iva+$total_riva;



		      		}



		      		if ( $risr > 0) {

		      			

		      			$ti_risr = $risr/100;

		      			$total_risr = redondedoFloat( ($ti_importe_iva*$ti_risr),2 );



		      			$partes_xml.='<cfdi:Retencion Base="'.$ti_importe_iva.'" Impuesto="001" TipoFactor="Tasa" TasaOCuota="'.redondedoFloat($ti_risr,6).'0000" Importe="'.$total_risr.'" />';



		      			$total_retenciones = $total_retenciones+$total_risr;

		      			$total_retenciones_isr = $total_retenciones_isr+$total_risr;



		      		}





		      		$partes_xml.='</cfdi:Retenciones></cfdi:Impuestos>';



		      					



		      	}else{



		      		$partes_xml.='</cfdi:Impuestos>';



		      	}



		    $partes_xml.='</cfdi:Concepto>';



		    /////********* SUMAR EL IVA A DONDE CORRESPONDE 



		    for ($i=0; $i < count($array_iva); $i++) { 

		    	



		    	if ( $iva_producto == $array_iva[$i] ) {

		    		

		    		array_push($array_suma_iva, $total_iva."/".$i);

		    		array_push($array_suma_importe, $ti_importe_iva."/".$i);



		    	}



		    } 



		    $totiva = $totiva+$total_iva;



	}







}





if ( $idcfdi == 23 ) {



	//$total_real=$total;

	//$subTotal-redondedoFloat($totdescuento,2);



	//$subTotal=redondedoFloat( ( $subTotal+$ivax ),2);

	

	$subTotal = $tot_subtotal_sin_desglose;

	//$descuento = $tot_descuento_sin_desglose;



	$total_real = $subTotal-$totdescuento;



}else{



	/////////////***************** TOTAL REAL



	if ( $total_retenciones > 0 ) {

		

		//////**** RESTAS RETENCIONES Y SUMAR IVA 



		$total_real = ( $subTotal-redondedoFloat($totdescuento,2) )+redondedoFloat($totiva,2)-redondedoFloat($total_retenciones,2);



	}else{



		/////////***** SOLO SUMAR IVA

		$total_real = ( $subTotal-redondedoFloat($totdescuento,2) )+redondedoFloat($totiva,2);



		//$subTotalx = $subTotal;

	}



}



$cadena_xml       = '<?xml version="1.0" encoding="utf-8"?>

<cfdi:Comprobante xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd" Version="4.0" Serie="'.$serie.'" Folio="'.$SerieFolio.'" Fecha="'.$fecha_actual.'T'.$hora_actual.'" SubTotal="'.redondedoFloat($subTotal,2).'" Descuento="'.redondedoFloat($totdescuento,2).'" Moneda="'.$moneda.'" TipoCambio="'.$tipo_cambio.'" Total="'.redondedoFloat($total_real,2).'" TipoDeComprobante="I" Exportacion="01" Certificado="'.$certificado.'" NoCertificado="'.$nocertificado.'" MetodoPago="'.$metodo_pago.'" FormaPago="'.$forma_pago.'" LugarExpedicion="'.$cp_emisor.'" xmlns:cfdi="http://www.sat.gob.mx/cfd/4" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">

  <cfdi:Emisor Nombre="'.strtoupper($nombre_emisor).'" RegimenFiscal="'.$clave_regimen.'" Rfc="'.$rfc_emisor.'"/>

  <cfdi:Receptor Nombre="'.$nombre_receptor.'" Rfc="'.$rfc_receptor.'" UsoCFDI="'.$uso_cfdi.'" DomicilioFiscalReceptor="'.$cp_receptor.'" RegimenFiscalReceptor="'.$regimen_receptor.'"/>

  <cfdi:Conceptos>'."\r\n";



$cadena_xml      .= $partes_xml."\r\n";



$cadena_xml      .='</cfdi:Conceptos>';





if ( $idcfdi == 23 ) {



	//// SIN EFECTOS FISCALES



	$cadena_xml		.='</cfdi:Comprobante>';



}else{



	///// CON EFECTOS FISCALES



	if ( $total_retenciones > 0 ) {



		$cadena_xml		.='<cfdi:Impuestos TotalImpuestosRetenidos="'.redondedoFloat($total_retenciones,2).'" TotalImpuestosTrasladados="'.redondedoFloat($totiva,2).'">';



		$cadena_xml		.='<cfdi:Retenciones>';



			if ( $total_retenciones_iva > 0 ) {

				

				$cadena_xml.='<cfdi:Retencion Impuesto="002" Importe="'.redondedoFloat($total_retenciones_iva,2).'"/>';



			}



			if ( $total_retenciones_isr > 0 ) {

				

				$cadena_xml.='<cfdi:Retencion Impuesto="001" Importe="'.redondedoFloat($total_retenciones_isr,2).'"/>';



			}



		$cadena_xml		.='</cfdi:Retenciones>';

	        



		$cadena_xml 	.='<cfdi:Traslados>

						      <cfdi:Traslado Base="'.$total_base_iva.'" Importe="'.redondedoFloat($totiva,2).'" Impuesto="002" TasaOCuota="0.160000" TipoFactor="Tasa"/>

						    </cfdi:Traslados>';



	}else{



		$cadena_xml		.='<cfdi:Impuestos TotalImpuestosTrasladados="'.redondedoFloat($totiva,2).'"><cfdi:Traslados>';





		for ($i=0; $i<count($array_iva); $i++) { 

			

			$sumar_iva = 0;

			$sumar_importe = 0;



			for ($x=0; $x<count($array_suma_iva); $x++) { 

				

				$separar=explode("/", $array_suma_iva[$x]);

				$separar2=explode("/", $array_suma_importe[$x]);



				if ( $separar[1] == $i ) {

					

					$sumar_iva=$sumar_iva+$separar[0];

					$sumar_importe=$sumar_importe+$separar2[0];



				}



			}





			$cadena_xml 	.='<cfdi:Traslado Base="'.$sumar_importe.'" Importe="'.redondedoFloat($sumar_iva,2).'" Impuesto="002" TasaOCuota="'.redondedoFloat( ($array_iva[$i]/100),6 ).'" TipoFactor="Tasa"/>';





		}



		



		



	}



	$cadena_xml		.='</cfdi:Traslados>

							</cfdi:Impuestos>

						</cfdi:Comprobante>';



}



	







$ubicacion = 'xml/archivo_xml'.$idfactura.'.xml';

$archivo = fopen($ubicacion, "w+");

fwrite($archivo, $cadena_xml);



//echo json_encode("XML credo con exito");





////////////////*********************************** FACTURAR EL ARCHIVO CREADO ****************************************************************************



$nombre_fichero = $ubicacion;



if ( file_exists($nombre_fichero) ) {



	# OBJETO DEL API DE CONEXION

	//$url = 'https://dev.facturaloplus.com/ws/servicio.do?wsdl'; //prueba

	$url = 'https://app.facturaloplus.com/ws/servicio.do?wsdl';

	$objConexion = new Conexion($url);



	# CREDENCIAL

	$apikey = $apikeyx;

	$opc = 31;



	switch($opc)

	{

		



		case 31: 



				$cfdi = file_get_contents($nombre_fichero);

				//echo $objConexion->operacion_timbrar($apikey, $cfdi);

				$keyPEM = file_get_contents('facturalo/'.$keypem);



				$idfolio = $nserie_folio;







				$respuesta = $objConexion->operacion_timbrar_sellar($apikey, $cfdi, $keyPEM);



	        	$ubicacion = 'factura_comprobante/'.$idfolio.'.xml';

	        	$archivo = fopen($ubicacion, "w+");

	        	fwrite( $archivo,$respuesta['cfdi'] );





	        	if ( $respuesta['codigo'] == 200 ) {

	        		

	        		/////////******************* INSERTAMOS EL NUEVO FOLIO CREADO 



					$sqlnewfolio="INSERT INTO `folio_factura` (`id`, `serie`, `folio`, `estatus`) VALUES (NULL, '".$serie."','".$folio."', '0')";

					$db->sql_query($sqlnewfolio);



					/////////////******************* COLOCAMOS EL ULTIMO ID DE FOLIO FACTURA EN ALTA FACTURA



					$sql_update = "UPDATE alta_factura SET ftimbrado = '".date('Y-m-d')."', htimbrado='".$hora_actual."',idfolio = (SELECT MAX(x.id) FROM folio_factura x), estatus='1' WHERE id=".$idfactura;

					$db->sql_query($sql_update);



					/////////////******************* CAMBIAMOS EL ESTATUS DE LA COTIZACION COMO FACTURA TIMBRADA



					if ( $idcotizacion > 0 ) {



						$sql_verificar = "SELECT a.id,( a.cantidad-( SELECT IFNULL(SUM(x.cantidad),0) FROM partes_factura x, alta_factura y WHERE x.idpartecot=a.id AND x.idfactura=y.id AND y.estatus = 1 ) ) AS cantidadx 

			            FROM partes_cotizacion a 

			            WHERE 

			            a.idcotizacion =".$idcotizacion."

			            AND ( a.cantidad-( SELECT IFNULL(SUM(x.cantidad),0) FROM partes_factura x, alta_factura y WHERE x.idpartecot=a.id AND x.idfactura=y.id AND y.estatus = 1 ) ) > 0

			            AND a.estatus = 0

			            ORDER BY a.orden ASC LIMIT 0,1";

			            $vbuscar=$db->sql_query($sql_verificar);



			            $contador = 0;

			            while ( $vrow=$db->sql_fetchrow($vbuscar) ) {

			            	

			            	$contador=$contador+1;



			            }





			            if ( $contador == 0 ) {

			            	

			            	$sql_update2 = "UPDATE alta_cotizacion SET estatus='3' WHERE id=".$idcotizacion;

							$db->sql_query($sql_update2);



			            }else{



			            	$sql_update2 = "UPDATE alta_cotizacion SET estatus='5' WHERE id=".$idcotizacion;

							$db->sql_query($sql_update2);



			            }





						

						

					}





					echo json_encode(0);





	        	}else{



	        		echo json_encode("Mensaje: ".$respuesta['codigo'].'|'.$respuesta['mensaje']);

	        		

	        	}



				///

		break;



	}



}else{



	echo json_encode("xml no encontrado, favor de realizar la cotizacion nuevamente");



}



?>