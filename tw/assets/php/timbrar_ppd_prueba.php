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

                            $idfactura=285;//trim($_POST["idppdx"]);

                            $sql = "SELECT folio_temporal,serie_temporal FROM alta_ppd WHERE id=".$idfactura;
                            $buscar = $db->sql_query($sql);
                            $row = $db->sql_fetchrow($buscar);
                            $nserie_folio=$row['serie_temporal']."".$row['folio_temporal'];

                            $nombre_fichero='xml_pago_sellado/xml'.$idfactura.'.xml';
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

                               

                                echo json_encode($respuesta);

                                $decoded_json = json_decode($respuesta, false);
                                $decode_dos = json_decode($decoded_json->cfdi,false);

                                $imagenEnBase64=$decode_dos->CodigoQR;
                                $xml_timbrado=$decode_dos->XML;



                                if ( $imagenEnBase64 != "" ) {
                                    
                                    
                                    $rutaImagenSalida ='xml_qr_ppd/'.$nserie_folio.'.png';
                                    $imagenBinaria = base64_decode($imagenEnBase64);
                                    $bytes = file_put_contents($rutaImagenSalida, $imagenBinaria);

                                    $ubicacion = 'factura_comprobante_pago/'.$nserie_folio.'.xml';
                                    $archivo = fopen($ubicacion, "w+");
                                    fwrite( $archivo,$xml_timbrado );

                                    /////////******************* INSERTAMOS EL NUEVO FOLIO CREADO 

                                    $sqlnewfolio="INSERT INTO `folio_ppd` (`id`, `serie`, `folio`, `estatus`) VALUES (NULL, '".$row['serie_temporal']."','".$row['folio_temporal']."', '0')";
                                    $db->sql_query($sqlnewfolio);

                                    /////////////******************* COLOCAMOS EL ULTIMO ID DE FOLIO FACTURA EN ALTA PPD

                                    $sql_update = "UPDATE alta_ppd SET idfolio = (SELECT MAX(x.id) FROM folio_ppd x), estatus='1' WHERE id=".$idfactura;
                                    $db->sql_query($sql_update);

                                    ///////////  REVISAR LOS PAGOS DEL COMPLEMENTO POR FACTURA Y REVISAR QUE ESTOS YA SE HAYAN PAGADO AL 100% Y CAMBIAR EL ESTATUS EN LA FACTURA


                                    $sql_pagos="SELECT a.idfactura,a.saldo_restante,a.tipo
                                    FROM alta_pagos_ppd a
                                    WHERE a.idppd=(SELECT x.id FROM alta_datos_ppd x WHERE x.idcpd=".$idfactura.")";
                                    $pbuscar=$db->sql_query($sql_pagos);
                                    while($prow=$db->sql_fetchrow($pbuscar)){

                                        if ( $prow["tipo"]==0 ) {
                                            
                                            ////facturas
                                            if ( $prow["saldo_restante"] > 0 ) {
                                                
                                                

                                            }else{

                                                $sql_pupdate="UPDATE `alta_factura` SET pago=1 WHERE id=".$prow["idfactura"];
                                                $db->sql_query($sql_pupdate);

                                            }

                                        }elseif( $prow["tipo"]==1 ) {

                                            //factura de sustitucion
                                            if ( $prow["saldo_restante"] > 0 ) {
                                                
                                                

                                            }else{

                                                $sql_pupdate="UPDATE `alta_factura_sustitucion` SET pago=1 WHERE id=".$prow["idfactura"];
                                                $db->sql_query($sql_pupdate);
                                                
                                            }
                                            

                                        }

                                    }



                                    echo json_encode(true);
                                    //echo json_encode("Imagen y xml generados");

                                }else{

                                    echo  json_encode(false);
                                    //echo json_encode("Imagen no generada");

                                }

                                

                            }else{

                                echo  json_encode(false);
                                //echo json_encode("Archivo no encontrado");

                            }





?>