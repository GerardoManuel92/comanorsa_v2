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

                            /*$idfactura = ;///trim($_POST["idfactura"]);

						    $sql = "SELECT b.serie, b.folio
							FROM alta_factura a, folio_factura b
							WHERE a.idfolio=b.id
							AND a.id =".$idfactura;
							$buscar = $db->sql_query($sql);
							$row = $db->sql_fetchrow($buscar);*/

							$nserie_folio = "BDL7450";//$row['serie']."".$row['folio'];

                            $nombre_fichero='xml_sellado/'.$nserie_folio.'.xml';
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
                                $decoded_json = json_decode($respuesta, false);
                                $decode_dos = json_decode($decoded_json->cfdi,false);

                                $imagenEnBase64=$decode_dos->CodigoQR;

                                if ( $imagenEnBase64 != "" ) {
                                	
                                	/*$imagenEnBase64="iVBORw0KGgoAAAANSUhEUgAAAJcAAACXAQMAAAAiUVs6AAAABlBMVEUAAAD///+l2Z/dAAAACXBIWXMAAA7EAAAOxAGVKw4bAAADGklEQVRIiZWWvWrkMBDHxwiiztumEOgVcp3SRA9zL2D3wfZyvfwCB3kVpVl1ySsIptjW7hQQnhvluOq2mHWxmN8ieT7/MwBgly4aFU7R1nHxGdrzP/P0dj48WvpMFU6bvtImZk79nnRCFboCdRjTFYZ7WP8C1p73YnFd3J1svGhTgd8oTP4e5qkxxPMBpPbN//VNxgDMeHFoxo/2E9zfmP7PiOpIBez5cAb3xRMdYubArqlku4CjPM2UYRKzqJC+IsDw5EyeN/dYBzFz9EZFIwVfqtopXtUhZh5zlyLWwSdradFWBTHj+5YHqHiOHqDbY27ZkjJFKyUFXdRcmJunFpcbDPisA8CDba7jmrQNcob5dNHZwAsYWkBf1SJmxUD/XAD3D87ReDjCIGbJVq5BRccTmxV6TXkQM7Bv63sCFXyiPHOFcZylTOef24s29kxcXGGMrSZvsQh2v3iDoUs2z3u8mknMIL8ODx6JyyfzXfox92KmjdrfI+CZDYfTHrXd5Ey14EAefME6DfDYEiVlfEvRtr1xxDt2K4iZU7XvSm6ptbWfC3FtSJlXv+evmNX+4asZJrja4ybjthoLkBkPT6ZbXDsrZdxR/YO3yKqnKgzcAoOYJfhJVIyld8J62tqIETPH9cd6YGkvAONeWMjELOXX5gf0TYeWjgAXMSNcWvxYHiDX005QJzErqs6pgAFfsuk5JGq7ybz9xbKecevY8H2NlutAylK7LxngdkGe2KxDi5ixlpwuYPH4EQ2Mm7esz1KW6hw4qer8GRWcWAXbN4RMZ55HZMz0omueOiJ7iJnPrz3fx34UTvKamnbeZFx//Ifp9sLqP/P47OXse/YANpXHNjTtIWYamrkGadPGsL+WgphFVvToqplOEWGa9NXKGdm3zTmel/AtoAXuYVThOSruc4cYBmh9LmXcnOtXYgH90PafvtxivCPNByhq+wvPHj67iRnvZm3paFklfto2cg/jnRDt8dT8HRxRuIdNmlV5fS8EI6XHttMIGe/A4ZkItx+J1NG77/4VMt4TZ0oVl97zDjyn3OagjP0BEOl9NYrEIzoAAAAASUVORK5CYII=";*/

	                                //$rutaImagenSalida ='xml_qr/'.$nserie_folio.'.png';
	                                //$imagenBinaria = base64_decode($imagenEnBase64);
	                                //$bytes = file_put_contents($rutaImagenSalida, $imagenBinaria);

	                                echo json_encode("QR creado con exito");

                                }else{

                                	echo json_encode($respuesta);

                                }

                                

                            }else{

                            	echo  json_encode("XML NO ENCONTRADO");

                            }



?>