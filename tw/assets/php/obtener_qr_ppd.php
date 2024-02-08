<?php


						/////*************** LO TIMBRAMOS CON LA NUEVA FUNCION PARA OBTENER EL QR DEL XML 

                            namespace TIMBRADORXPRESS\API;
                            require __DIR__ . "/facturalo/class.conexion.php";
                            use TIMBRADORXPRESS\API\Conexion;

                            ///**** DATOS DE CONEXION
                            include("config.php"); 
							include("includes/mysqli.php");
							include("includes/db.php");
							set_time_limit (600000);

                            $idfactura = 139;///trim($_POST["idfactura"]);

						    $sql = "SELECT b.serie, b.folio
                            FROM alta_ppd a, folio_ppd b
                            WHERE a.idfolio=b.id
                            AND a.id =".$idfactura;
							$buscar = $db->sql_query($sql);
							$row = $db->sql_fetchrow($buscar);

							$nserie_folio = $row['serie']."".$row['folio'];

                            $nombre_fichero='xml_sellado_pago/'.$nserie_folio.'.xml';
                            $rutaImagenSalida = "";
                            //$name_archivo = "prueba1.xml";

                            if ( file_exists($nombre_fichero) ) {

                                # OBJETO DEL API DE CONEXION
                                //$url = 'https://dev.facturaloplus.com/ws/servicio.do?wsdl'; //prueba
                                $url = 'https://app.facturaloplus.com/ws/servicio.do?wsdl';
                                $objConexion = new Conexion($url);

                                # CREDENCIAL
                                $apikey = '4056008b83334c1d84f6776c6144beba';
                                $opc = 1;
                                //$keypem = "pkcomanorsa.pem";

                                $cfdi = file_get_contents($nombre_fichero);
                                $respuesta = $objConexion->operacion_timbrar3($apikey, $cfdi);

                                echo json_encode("Mensaje: ".$respuesta['codigo'].'|'.$respuesta['mensaje']);


                                /*$decoded_json = json_decode($respuesta, false);
                                $decode_dos = json_decode($decoded_json->cfdi,false);

                                $imagenEnBase64=$decode_dos->CodigoQR;

                                if ( $imagenEnBase64 != "" ) {
                                	
                                	
	                                $rutaImagenSalida ='xml_qr_ppd/'.$nserie_folio.'.png';
	                                $imagenBinaria = base64_decode($imagenEnBase64);
	                                $bytes = file_put_contents($rutaImagenSalida, $imagenBinaria);

	                                echo json_encode(true);

                                }else{

                                	///echo  json_encode(false);
                                    echo json_encode("Imagen no generada");

                                }*/

                                

                            }else{

                            	//echo  json_encode(false);
                                echo json_encode("Archivo no encontrado");

                            }





?>