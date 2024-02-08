<?php
		
		namespace TIMBRADORXPRESS\API;
		require __DIR__ . "/facturalo/class.conexion.php";
		use TIMBRADORXPRESS\API\Conexion;

		$nombre_fichero="xml124_timbrada.xml";
		$name_archivo = "prueba1.xml";

		if ( file_exists($nombre_fichero) ) {

			# OBJETO DEL API DE CONEXION
			//$url = 'https://dev.facturaloplus.com/ws/servicio.do?wsdl'; //prueba
			$url = 'https://app.facturaloplus.com/ws/servicio.do?wsdl';
			$objConexion = new Conexion($url);

			# CREDENCIAL
			$apikey = '4056008b83334c1d84f6776c6144beba';
			$opc = 1;
			$keypem = "pkcomanorsa.pem";

			switch($opc)
			{
				

				case 31: 

						/* RFC:EKU9003173C9 */

						$cfdi = file_get_contents($nombre_fichero);
						//echo $objConexion->operacion_timbrar($apikey, $cfdi);
						$keyPEM = file_get_contents('facturalo/'.$keypem);

						$idfolio = "A100";

						$respuesta = $objConexion->operacion_timbrar_sellar($apikey, $cfdi, $keyPEM);

			        	$ubicacion = 'factura_comprobante/'.$idfolio.'.xml';
			        	$archivo = fopen($ubicacion, "w+");
			        	fwrite( $archivo,$respuesta['cfdi'] );
			        	//codigo
						//mensaje
						//cfdi

			        	echo "codigo: ".$respuesta['codigo']."<br>mensaje: ".$respuesta['mensaje']."<br>cfdi: ".$respuesta['cfdi'];

				break;

				case 1:

					$cfdi = file_get_contents($nombre_fichero);
					$respuesta = $objConexion->operacion_timbrar3($apikey, $cfdi);


			        /*if ( $respuesta['codigo'] == 200 ) {

			        	echo json_encode( $respuesta['cfdi'] );

			        }else{

			        	echo json_encode( "Mensaje: ".$respuesta['codigo'].'|'.$respuesta['mensaje'] );

			        }*/

			        $decoded_json = json_decode($respuesta, false);
			        $decode_dos = json_decode($decoded_json->cfdi,false);

			        echo "QR:".$decode_dos->CodigoQR;

			        //echo $respuesta;

			        

				break;

			}

		}else{

			echo json_encode("xml no encontrado, favor de realizar la cotizacion nuevamente");

		}

?>