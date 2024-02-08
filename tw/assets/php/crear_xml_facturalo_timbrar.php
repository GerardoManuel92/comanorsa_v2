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


        /////************** CREAR XML *********************////

        //*DATOS RECIBIDOS

        $idcliente = 1;//trim($_POST["idcli"]);
        $idfactura = 7;//trim($_POST["idfact"]);
        //$idmetodo_pago = 1;//
        $idcotizacion= 235;//trim($_POST["idcot"]);


        ////*******FOLIO 

        $sqlfolio = "SELECT folio FROM folio_factura ORDER BY id DESC LIMIT 0,1";
        $bmax = $db->sql_query($sqlfolio);
        $rowmax = $db->sql_fetchrow($bmax);

        $folio = 100;//trim($rowmax["folio"])+1;//// este folio suma un numero mas para simular el siguiente folio de faturacion y ya facturado los insertamos

        /////************************************* DATOS XML COMANORSA 

        $sql="SELECT iva,rfc,razon_social,calle,exterior,interior,colonia,localidad,municipio,estado,pais,cp,regimen,serie_factura,certificado,nocertificado,keyx,cer,keypem,cerpem FROM `datos_generales` WHERE estatus = 0";
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

        $certificado=trim($row["certificado"]);
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


        ////////////********************************** DATOS DEL CLIENTE

        $sql2="SELECT a.rfc, a.nombre, a.calle, a.exterior, a.interior, a.colonia, a.municipio, a.estado, a.cp, b.clave AS regimen_receptor  
        FROM 
        alta_clientes a, sat_catalogo_regimen_fiscal b
        WHERE
        a.idregimen=b.id
        AND a.id=".$idcliente;
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
        $regimen_receptor = trim($row2["regimen_receptor"]);


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



        //////////////*********************************** PARTIDAS DE LA FACTURA 

        $sql4 = "SELECT a.costo,a.cantidad,a.descripcion,b.sat,c.clave AS clave_unidad,c.abr AS unidad, b.nparte, a.iva, a.descuento, a.riva, a.risr
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
        $total_retenciones = 0;
        $total_retenciones_iva = 0;
        $total_retenciones_isr = 0;
        $total_base_iva = 0;

        while($row4=$db->sql_fetchrow($buscar4)){
            
            $ti_costo = redondedoFloat($row4['costo'], 2);
            $ti_cantidad = $row4['cantidad'];
            $ti_descripcionx = $row4['descripcion'];
            $replace=array('<','>','&','"','\'','¨');
            $match=array('&lt;','&gt;','&amp;','&quot;','&apos;','&quot;');
            $ti_descripcion =str_replace($replace, $match, $ti_descripcionx);
            $ti_unidad = $row4['unidad'];
            $ti_clave = $row4['nparte'];
            $ti_clavesat = $row4['sat'];
            $ti_importe = redondedoFloat($ti_cantidad*$ti_costo, 2);
            $vdescuento = $row4["descuento"];
            $riva= $row4["riva"];
            $risr= $row4["risr"];
            

            if ( $vdescuento > 0 ) {

                $ti_descuento = $vdescuento/100;
                $descuento =$ti_importe*$ti_descuento;
                $ti_importe_iva = redondedoFloat( ($ti_importe-$descuento),2 );

            }else{

                //$ti_descuento = 0;
                $descuento =0;
                $ti_importe_iva = $ti_importe;

            }
            
            $ti_clv_unidad = $row4['clave_unidad'];
            $ti_iva = $row4["iva"]/100;
            $total_iva = redondedoFloat( ($ti_importe_iva*$ti_iva),2 );
            $totdescuento = $totdescuento+$descuento;
            $total_subtotal = $total_subtotal+$ti_importe_iva;



            /*$partes_xml = $partes_xml.'<cfdi:Concepto ClaveProdServ="'.$ti_clavesat.'" cantidad="'.$ti_cantidad.'" unidad="'.$ti_unidad.'" noIdentificacion="'.$ti_clave.'" descripcion="'.$ti_descripcion.'" valorUnitario="'.$ti_costo.'" importe="'.$ti_importe.'" ClaveUnidad="'.$ti_clv_unidad.'" />';*/

            $partes_xml = $partes_xml.'<cfdi:Concepto Cantidad="'.$ti_cantidad.'" ClaveProdServ="'.$ti_clavesat.'" ClaveUnidad="'.$ti_clv_unidad.'" Descripcion="'.$ti_descripcion.'" Importe="'.$ti_importe.'" NoIdentificacion="'.$ti_clave.'" Unidad="'.$ti_unidad.'" ValorUnitario="'.$ti_costo.'" Descuento="'.redondedoFloat($descuento,2).'" ObjetoImp="02">
              <cfdi:Impuestos>
                <cfdi:Traslados>
                  <cfdi:Traslado Base="'.$ti_importe_iva.'" Importe="'.$total_iva.'" Impuesto="002" TasaOCuota="0.160000" TipoFactor="Tasa" />
                </cfdi:Traslados>';

                $total_base_iva = $total_base_iva+$ti_importe_iva;

                if ( $riva > 0 OR $risr > 0 ) {
                    
                    ////////******* CALCULAR RETENCIONES

                    $partes_xml.='<cfdi:Retenciones>';

                    if ( $riva > 0) {
                        
                        $ti_riva = redondedoFloat( ($riva/100),2 );
                        $total_riva = redondedoFloat( ($ti_importe_iva*$ti_riva),2 );

                        $partes_xml.='<cfdi:Retencion Base="'.$ti_importe_iva.'" Impuesto="002" TipoFactor="Tasa" TasaOCuota="'.$ti_riva.'0000" Importe="'.$total_riva.'" />';

                        $total_retenciones = $total_retenciones+$total_riva;
                        $total_retenciones_iva = $total_retenciones_iva+$total_riva;

                    }

                    if ( $risr > 0) {
                        
                        $ti_risr = redondedoFloat( ($risr/100),2 );
                        $total_risr = redondedoFloat( ($ti_importe_iva*$ti_risr),2 );

                        $partes_xml.='<cfdi:Retencion Base="'.$ti_importe_iva.'" Impuesto="001" TipoFactor="Tasa" TasaOCuota="'.$ti_risr.'0000" Importe="'.$total_risr.'" />';

                        $total_retenciones = $total_retenciones+$total_risr;
                        $total_retenciones_isr = $total_retenciones_isr+$total_risr;

                    }


                    $partes_xml.='</cfdi:Retenciones></cfdi:Impuestos>';

                                

                }else{

                    $partes_xml.='</cfdi:Impuestos>';

                }

                $partes_xml.='</cfdi:Concepto>';

                        
                            
                        

            $totiva = $totiva+$total_iva;

        }

        /////////////***************** TOTAL REAL

        if ( $total_retenciones > 0 ) {
            
            //////**** RESTAS RETENCIONES Y SUMAR IVA 

            $total_real = ( $subTotal-redondedoFloat($totdescuento,2) )+redondedoFloat($totiva,2)-redondedoFloat($total_retenciones,2);

        }else{

            /////////***** SOLO SUMAR IVA
            $total_real = ( $subTotal-redondedoFloat($totdescuento,2) )+redondedoFloat($totiva,2);


        }

        //////****************************** ARMAR XML

        $cadena_xml       = '<?xml version="1.0" encoding="utf-8"?>
        <cfdi:Comprobante xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd" Version="4.0" Serie="'.$serie.'" Folio="'.$SerieFolio.'" Fecha="'.date("Y-m-d").'T'.date("H:i:s").'" SubTotal="'.$subTotal.'" Descuento="'.redondedoFloat($totdescuento,2).'" Moneda="'.$moneda.'" TipoCambio="'.$tipo_cambio.'" Total="'.redondedoFloat($total_real,2).'" TipoDeComprobante="I" Exportacion="01" Certificado="'.$certificado.'" NoCertificado="'.$nocertificado.'" MetodoPago="'.$metodo_pago.'" FormaPago="'.$forma_pago.'" LugarExpedicion="'.$cp_emisor.'" xmlns:cfdi="http://www.sat.gob.mx/cfd/4" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" >
          <cfdi:Emisor Nombre="'.strtoupper($nombre_emisor).'" RegimenFiscal="'.$clave_regimen.'" Rfc="'.$rfc_emisor.'" />
          <cfdi:Receptor Nombre="'.strtoupper($nombre_receptor).'" Rfc="'.$rfc_receptor.'" UsoCFDI="'.$uso_cfdi.'" DomicilioFiscalReceptor="'.$cp_receptor.'" RegimenFiscalReceptor="'.$regimen_receptor.'"/>
          <cfdi:Conceptos>'."\r\n";

        $cadena_xml      .= $partes_xml."\r\n";

        $cadena_xml      .='</cfdi:Conceptos>';

        if ( $total_retenciones > 0 ) {

            $cadena_xml     .='<cfdi:Impuestos TotalImpuestosRetenidos="'.redondedoFloat($total_retenciones,2).'" TotalImpuestosTrasladados="'.redondedoFloat($totiva,2).'">';

            $cadena_xml     .='<cfdi:Retenciones>';

                if ( $total_retenciones_iva > 0 ) {
                    
                    $cadena_xml.='<cfdi:Retencion Impuesto="002" Importe="'.redondedoFloat($total_retenciones_iva,2).'" />';

                }

                if ( $total_retenciones_isr > 0 ) {
                    
                    $cadena_xml.='<cfdi:Retencion Impuesto="001" Importe="'.redondedoFloat($total_retenciones_isr,2).'" />';

                }

            $cadena_xml     .='</cfdi:Retenciones>';
                

            $cadena_xml     .='<cfdi:Traslados>
                                  <cfdi:Traslado Base="'.$total_base_iva.'" Importe="'.redondedoFloat($totiva,2).'" Impuesto="002" TasaOCuota="0.160000" TipoFactor="Tasa" />
                                </cfdi:Traslados>';

        }else{

            $cadena_xml     .='<cfdi:Impuestos TotalImpuestosTrasladados="'.redondedoFloat($totiva,2).'">';

            $cadena_xml     .='<cfdi:Traslados>
                                  <cfdi:Traslado Base="'.$total_base_iva.'" Importe="'.redondedoFloat($totiva,2).'" Impuesto="002" TasaOCuota="0.160000" TipoFactor="Tasa" />
                                </cfdi:Traslados>';

        }

        $cadena_xml     .='</cfdi:Impuestos>
                        </cfdi:Comprobante>';


        /////////******************************* GUARDAR XML

        $ubicacion = 'xml/xml'.$idfactura.'.xml';
        $archivo = fopen($ubicacion, "w+");
        fwrite($archivo, $cadena_xml);


        ///////////********************************** TIMBRAMOS EL XML CREADO CON LA FUNCION (SELLADO/TIMBRADO)

        $nombre_fichero=$ubicacion;


        if ( file_exists($nombre_fichero) ) {

            # OBJETO DEL API DE CONEXION
            //$url = 'https://dev.facturaloplus.com/ws/servicio.do?wsdl'; //prueba
            $url = 'https://app.facturaloplus.com/ws/servicio.do?wsdl';
            $objConexion = new Conexion($url);

            # CREDENCIAL
            $apikey = '4056008b83334c1d84f6776c6144beba';
            $opc = 31;
            $keypem = "pkcomanorsa.pem";

            switch($opc)
            {
                

                case 31: 

                        /* RFC:EKU9003173C9 */

                        $cfdi = file_get_contents($nombre_fichero);
                        //echo $objConexion->operacion_timbrar($apikey, $cfdi);
                        $keyPEM = file_get_contents('facturalo/'.$keypem);

                        //$idfolio = "A100";

                        $respuesta = $objConexion->operacion_timbrar_sellar($apikey, $cfdi, $keyPEM);

                        $ubicacion = 'factura_comprobante/'.$nserie_folio.'.xml';
                        $archivo = fopen($ubicacion, "w+");
                        fwrite( $archivo,$respuesta['cfdi'] );
                        //codigo
                        //mensaje
                        //cfdi

                        if ( $respuesta['codigo'] == 200 ) {

                            //////*********** RETIRAMOS EL TIMBRADO DEL XML TIMBRADO

                            $doc = new DOMDocument; 
                            $doc->load('factura_comprobante/'.$nserie_folio.'.xml');
                            $xp = new DOMXPath($doc);
                            $video = $xp->query('//cfdi:Comprobante//cfdi:Complemento')->item(0);
                            $video->parentNode->removeChild($video);

                            $doc->save('xml_sellado/'.$nserie_folio.'.xml');

                            ///////*************** LO TIMBRAMOS CON LA NUEVA FUNCION PARA OBTENER EL QR DEL XML 

                            $cfdi = file_get_contents('xml_sellado/'.$nserie_folio.'.xml');
                            $respuesta = $objConexion->operacion_timbrar3($apikey, $cfdi);
                            $decoded_json = json_decode($respuesta, false);
                            $decode_dos = json_decode($decoded_json->cfdi,false);

                            $imagenEnBase64=$decode_dos->CodigoQR;

                            /*$imagenEnBase64="iVBORw0KGgoAAAANSUhEUgAAAJcAAACXAQMAAAAiUVs6AAAABlBMVEUAAAD///+l2Z/dAAAACXBIWXMAAA7EAAAOxAGVKw4bAAADGklEQVRIiZWWvWrkMBDHxwiiztumEOgVcp3SRA9zL2D3wfZyvfwCB3kVpVl1ySsIptjW7hQQnhvluOq2mHWxmN8ieT7/MwBgly4aFU7R1nHxGdrzP/P0dj48WvpMFU6bvtImZk79nnRCFboCdRjTFYZ7WP8C1p73YnFd3J1svGhTgd8oTP4e5qkxxPMBpPbN//VNxgDMeHFoxo/2E9zfmP7PiOpIBez5cAb3xRMdYubArqlku4CjPM2UYRKzqJC+IsDw5EyeN/dYBzFz9EZFIwVfqtopXtUhZh5zlyLWwSdradFWBTHj+5YHqHiOHqDbY27ZkjJFKyUFXdRcmJunFpcbDPisA8CDba7jmrQNcob5dNHZwAsYWkBf1SJmxUD/XAD3D87ReDjCIGbJVq5BRccTmxV6TXkQM7Bv63sCFXyiPHOFcZylTOef24s29kxcXGGMrSZvsQh2v3iDoUs2z3u8mknMIL8ODx6JyyfzXfox92KmjdrfI+CZDYfTHrXd5Ey14EAefME6DfDYEiVlfEvRtr1xxDt2K4iZU7XvSm6ptbWfC3FtSJlXv+evmNX+4asZJrja4ybjthoLkBkPT6ZbXDsrZdxR/YO3yKqnKgzcAoOYJfhJVIyld8J62tqIETPH9cd6YGkvAONeWMjELOXX5gf0TYeWjgAXMSNcWvxYHiDX005QJzErqs6pgAFfsuk5JGq7ybz9xbKecevY8H2NlutAylK7LxngdkGe2KxDi5ixlpwuYPH4EQ2Mm7esz1KW6hw4qer8GRWcWAXbN4RMZ55HZMz0omueOiJ7iJnPrz3fx34UTvKamnbeZFx//Ifp9sLqP/P47OXse/YANpXHNjTtIWYamrkGadPGsL+WgphFVvToqplOEWGa9NXKGdm3zTmel/AtoAXuYVThOSruc4cYBmh9LmXcnOtXYgH90PafvtxivCPNByhq+wvPHj67iRnvZm3paFklfto2cg/jnRDt8dT8HRxRuIdNmlV5fS8EI6XHttMIGe/A4ZkItx+J1NG77/4VMt4TZ0oVl97zDjyn3OagjP0BEOl9NYrEIzoAAAAASUVORK5CYII=";*/
                            $rutaImagenSalida ='xml_qr/'.$nserie_folio.'.png';
                            $imagenBinaria = base64_decode($imagenEnBase64);
                            $bytes = file_put_contents($rutaImagenSalida, $imagenBinaria);


                        }else{



                        }

                        echo "codigo: ".$respuesta['codigo']."<br>mensaje: ".$respuesta['mensaje']."<br>cfdi: ".$respuesta['cfdi'];

                break;

                

            }

        }else{

            echo json_encode("xml no encontrado, favor de realizar la cotizacion nuevamente");

        }

        /////************************************** OBTENER SELLO XML

            //ruta al archivo XML del CFDI
        /*    $xmlFile=$ubicacion;
         
            // Ruta al archivo XSLT
            $xslFile = "facturalo/cadenaoriginal.xslt"; 
         
            // Crear un objeto DOMDocument para cargar el CFDI
            $xml = new DOMDocument("1.0","UTF-8"); 
            // Cargar el CFDI
            $xml->load($xmlFile);
         
            // Crear un objeto DOMDocument para cargar el archivo de transformación XSLT
            $xsl = new DOMDocument();
            $xsl->load($xslFile);
         
            // Crear el procesador XSLT que nos generará la cadena original con base en las reglas descritas en el XSLT
            $proc = new XSLTProcessor;
            // Cargar las reglas de transformación desde el archivo XSLT.
            $proc->importStyleSheet($xsl);
            // Generar la cadena original y asignarla a una variable
            $cadenaOriginal = $proc->transformToXML($xml);
         
            echo $cadenaOriginal."<br><br>";
            

        ///////********************************* GENERAR SELLO XML

        $private = openssl_pkey_get_private(file_get_contents("pkcomanorsa.pem"));
        $sig = "";
        openssl_sign($cadenaOriginal, $sig, $private, OPENSSL_ALGO_SHA256);
        $sello = base64_encode($sig);

        //echo $sello;

        */





?>
