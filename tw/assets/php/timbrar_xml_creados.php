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

$nombre_fichero = 'xml/archivo_xml22.xml';//$ubicacion;

if ( file_exists($nombre_fichero) ) {

	# OBJETO DEL API DE CONEXION
	//$url = 'https://dev.facturaloplus.com/ws/servicio.do?wsdl'; //prueba
	$url = 'https://app.facturaloplus.com/ws/servicio.do?wsdl';
	$objConexion = new Conexion($url);

	# CREDENCIAL
	$apikey = '4056008b83334c1d84f6776c6144beba';
	$opc = 31;

	switch($opc)
	{
		

		case 31: 

				/* RFC:EKU9003173C9 */

				$cfdi = file_get_contents($nombre_fichero);
				//echo $objConexion->operacion_timbrar($apikey, $cfdi);
				$keyPEM = file_get_contents('facturalo/'.$keypem);

				$idfolio = $nserie_folio;

				/////***************** AÑADIDOS A LA VERSION 4.0

				/*Exportacion etiqueta cfdi:Comprobante a un lado de tipo de comprobante*/

				//// Se debe registrar la clave “ 01” (No aplica)."

				/*LugarExpedicion cfdi:Comprobante a un lado de forma de pago*/

				/// se debe colocar el codigo postal del emisor para poder emitir la fatura

				/*DomicilioFiscalReceptor etiqueta cfdi:Receptor */

				/*ObjetoImp añadida a cada una de las partidas*/

				//// este tiene tres valores: 01(No objeto de impuesto), 02(Objeto de impuesto), 03(Sí objeto del impuesto y no obligado al desglose)

				/*Base etiqueta cfdi:Traslados*/

				//// tambien se tiene que colocar la base o sumatoria de las bases de todos los impuestos trasladados o retenidos 


				$respuesta = $objConexion->operacion_timbrar_sellar($apikey, $cfdi, $keyPEM);

	        	$ubicacion = 'factura_comprobante/'.$idfolio.'.xml';
	        	$archivo = fopen($ubicacion, "w+");
	        	fwrite( $archivo,$respuesta['cfdi'] );
	        	//codigo
				//mensaje
				//cfdi

	        	//echo "codigo: ".$respuesta['codigo']."<br>mensaje: ".$respuesta['mensaje']."<br>cfdi: ".$respuesta['cfdi'];

	        	if ( $respuesta['codigo'] == 200 ) {
	        		
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