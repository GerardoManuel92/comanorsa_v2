<?php
		
		/*namespace TIMBRADORXPRESS\API;
		require __DIR__ . "/facturalo/class.conexion.php";
		use TIMBRADORXPRESS\API\Conexion;*/

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
    	NO SE ESTA USANDO **************							                                           *
    								                                           *
    								                                           *
    								                                           *
    								                                           *
    								                                           *
    ****************************************************************************/

    $idcliente = trim($_POST["idcliente"]);
    $idusuario = trim($_POST["iduser"]);
    $fecha =date("Y-m-d");

    $mifecha =date('H:i:s'); 
    //$mifecha->modify('-1 hours');
    $separar_hora=explode(":", $mifecha);

    $hora_separar=$separar_hora[0];

        $hora_menos="";

    if ($hora_separar==0 or $hora_separar=="00") {
        
            $hora_menos="11";

    }else{

            $hora_menos=$separar_hora[0]-1;   

    }

    if($hora_menos<10) {
        
        $hora_menos="0".$hora_menos;

    }

    $hora_actual=$hora_menos.":".$separar_hora[1].":".$separar_hora[2];

    $fecha_factura = date("Y-m-d")."T".$hora_actual;
    
    //$serie = "P";

    $fpagox = trim($_POST["fpagox"]);
    $noperacionx = trim($_POST["noperacionx"]);
    $fechax = trim($_POST["fechax"]);
    $rfcx = trim($_POST["rfcx"]);
    $bancox = trim($_POST["bancox"]);
    $cuentax = trim($_POST["cuentax"]);
    $monedax = 1;
    $bcuenta = trim($_POST["bcuentax"]);
    $brfc = trim($_POST["brfcx"]);
    $total = trim($_POST["totalx"]);
    $documento = trim($_POST["documentox"]);

    $idmovimiento=trim($_POST["idmov"]);

    /*$idcliente = 1;//trim($_POST["idcli"]);
    $idusuario = 1;//trim($_POST["iduser"]);
    $fecha_factura = date("Y-m-d")."T".date("H:i:s");
    $fecha = ;//date("Y-m-d");
    //$serie = "P";

    $fpagox = ;//trim($_POST["fpagox"]);
    $noperacionx = ;//trim($_POST["noperacionx"]);
    $fechax = ;//trim($_POST["fechax"]);
    $rfcx = ;//trim($_POST["rfcx"]);
    $bancox = ;//trim($_POST["bancox"]);
    $cuentax = ;//trim($_POST["cuentax"]);
    $monedax = ;//;
    $rbancox = ;//trim($_POST["rbancox"]);
    $rrfcx = ;//trim($_POST["rrfcx"]);
    $total = ;//trim($_POST["total"]);
    $documento = ;//trim($_POST["documentox"]);

    */

    ////////////********** REVISAR QUE EXISTA INFORMACION EN EL TEMPORAL 

    $sql="SELECT COUNT(a.id) AS ntemporal
    FROM temporal_ppdv2 a
    WHERE a.idcliente =".$idcliente." AND cobrado > 0";
    $buscar = $db->sql_query($sql);
    $row = $db->sql_fetchrow($buscar);

    $ntemporal = trim($row["ntemporal"]);

    if ( $ntemporal == 0 ) {
        
        echo json_encode( null );

    }else{

        /////********** damos de alta el complemento de pago
        //$sql1="INSERT INTO `alta_ppd` (`id`, `idcliente`, `iduser`, `fecha`) VALUES (NULL, $idcliente, $idusuario, '$fecha')";
        $sql1x="INSERT INTO `alta_ppd` (`id`, `idcliente`, `iduser`, `fecha`, `hora`, `total`,`idmoneda`) VALUES (NULL, '$idcliente', '$idusuario', '".$fecha."', '".$hora_actual."', '".$total."','1')";
        $db->sql_query($sql1x);

        ////traemos el ultimo ID

        $sql2 = "SELECT MAX(id) AS idmax
        FROM alta_ppd";
        $buscar2 = $db->sql_query($sql2);
        $row2 = $db->sql_fetchrow($buscar2);

        $last_id = trim($row2["idmax"]);




        //////////******* CREAMOS EL DATOS DE CADA COMPROBANTE DE PAGO PARA SUS FACTURAS 

        $sql2x="INSERT INTO `alta_datos_ppd` (`id`, `idcpd`, `fecha`, `total`, `idfpago`, `operacion`, `rfc`, `banco`, `cuenta`, `moneda`, `bcuenta`, `brfc`, `documento`, `estatus`,`idmovimiento_bancario`) 
                VALUES (NULL, '".$last_id."', '".$fechax."', '".$total."', '".$fpagox."', '".$noperacionx."', '".$rfcx."', '".$bancox."', '".$cuentax."', '".$monedax."', '".$bcuenta."', '".$brfc."', '".$documento."', '0','".$idmovimiento."');";
        $db->sql_query($sql2x);

        //////***** TRAER EL ULTIMO ID DE LOS DATOS DE DEL CPP
        $lsql2 = "SELECT MAX(id) AS idmax
        FROM alta_datos_ppd";
        $lbuscar2 = $db->sql_query($lsql2);
        $lrow2 = $db->sql_fetchrow($lbuscar2);

        $last_id_dato = trim($lrow2["idmax"]);


        $sql3="SELECT a.id,a.idfactura,a.ncpp,a.cobrado,a.posterior,a.anterior,a.estatus,a.tipo
        FROM temporal_ppdv2 a, alta_factura b
        WHERE a.idfactura=b.id
        AND b.idcliente =".$idcliente."
        AND a.iduser=".$idusuario."
        UNION ALL
        SELECT a.id,a.idfactura,a.ncpp,a.cobrado,a.posterior,a.anterior,a.estatus,a.tipo
        FROM temporal_ppdv2 a, alta_factura_sustitucion b
        WHERE a.idfactura=b.id
        AND b.idcliente=".$idcliente."
        AND a.iduser=".$idusuario;

        $buscar3 = $db->sql_query($sql3);
        while($row3 = $db->sql_fetchrow($buscar3)){

            ///////****** agregamos los complementos de pago a la tabla del alta 

            if ( $row3['cobrado']>0 ) {

                $sql4="INSERT INTO `alta_pagos_ppd` (`id`, `idppd`, `idfactura`, `npago`, `saldo_anterior`, `pago`, `saldo_restante`,`tipo`) VALUES 
                (NULL, '".$last_id_dato."', '".$row3['idfactura']."','".$row3['ncpp']."', '".$row3['anterior']."', '".$row3['cobrado']."', '".$row3['posterior']."', '".$row3['tipo']."')";
                $db->sql_query($sql4);
            }

        }

        /////********* LIMPIAMOS EL TEMPORAL DE LOS PAGOS AÑADIDOS AL CLIENTE

            $sql_delete="DELETE FROM temporal_ppdv2 WHERE idcliente=".$idcliente." AND iduser=".$idusuario;
            $db->sql_query($sql_delete);  


        ////// traemos el ultimo folio del complemento 

        $sql5="SELECT folio FROM folio_ppd ORDER BY id DESC limit 0,1";
        $buscar5 = $db->sql_query($sql5);
        $row5 = $db->sql_fetchrow($buscar5);

        $folio = $row5["folio"]+1;

        $nserie_folio = $folio;

        /////************************************* DATOS XML COMANORSA 

        $sql="SELECT iva,rfc,razon_social,calle,exterior,interior,colonia,localidad,municipio,estado,pais,cp,regimen,serie_ppd,certificado,nocertificado,keyx,cer,keypem,cerpem,apikey FROM `datos_generales` WHERE estatus = 0";
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

        $serie = trim($row["serie_ppd"]);
        $SerieFolio =$serie."".$folio;
        
        $fecha=date("Y-m-d");
        $tipo_comprobante ="ingreso";//
        $tasa =$row["iva"]/100;//

        $key =trim($row["keyx"]);
        $cer =trim($row["cer"]);
        $keypem =trim($row["keypem"]);
        $cerpem =trim($row["cerpem"]);
        $apikeyx =trim($row["apikey"]);

        ////////////********************************** DATOS DEL CLIENTE

        /*$sql2="SELECT a.rfc, a.nombre, a.calle, a.exterior, a.interior, a.colonia, a.municipio, a.estado, a.cp, b.clave
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
        $clave = trim($row2["clave"]);

        */

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

        /*if ( $idcliente == 21 ) {
    
            if ( $name_factura != "" ) {
                
                $nombre_receptor=trim($name_factura);

            }else{

                $nombre_receptor=trim("VENTAS PUBLICO GENERAL");

            }

        }else{

            $nombre_receptor = trim($row2["nombre"]);

        }*/

        $nombre_receptor = trim($row2["nombre"]);
        $calle_receptor = changeString($row2["calle"]);
        $exterior_receptor = changeString($row2["exterior"]);
        $interior_receptor = changeString($row2["interior"]);
        $colonia_receptor = changeString($row2["colonia"]);
        $municipio_receptor = changeString($row2["municipio"]);
        $estado_receptor = changeString($row2["estado"]);
        $pais_receptor = changeString("Mexico");
        $cp_receptor = trim($row2["cp"]);
        $regimen_receptor = trim($row2["regimen_receptor"]);



        ////////********** CREAMOS EL XML DEL COMPLEMENTO DE PAGO

        $cadena_xml       = '<?xml version="1.0" encoding="utf-8"?>
        <cfdi:Comprobante xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd http://www.sat.gob.mx/Pagos20 
         http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos20.xsd" xmlns:pago20="http://www.sat.gob.mx/Pagos20" Version="4.0" Serie="'.$serie.'" Folio="'.$folio.'" Fecha="'.$fecha_factura.'" SubTotal="0" Moneda="XXX" Total="0" TipoDeComprobante="P" Exportacion="01" Certificado="'.$certificado.'" NoCertificado="'.$nocertificado.'" LugarExpedicion="'.$cp_emisor.'"  xmlns:cfdi="http://www.sat.gob.mx/cfd/4" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">

          <cfdi:Emisor Rfc="'.strtoupper($rfc_emisor).'" Nombre="'.strtoupper($nombre_emisor).'" RegimenFiscal="'.strtoupper($clave_regimen).'"/>
          <cfdi:Receptor Rfc="'.strtoupper($rfc_receptor).'" Nombre="'.$nombre_receptor.'" DomicilioFiscalReceptor="'.$cp_receptor.'" RegimenFiscalReceptor="'.strtoupper($regimen_receptor).'" UsoCFDI="CP01"/>
          <cfdi:Conceptos>
            <cfdi:Concepto ClaveProdServ="84111506" Cantidad="1" ClaveUnidad="ACT" Descripcion="Pago" ValorUnitario="0" Importe="0" ObjetoImp="01"/>
          </cfdi:Conceptos>';

    }

    //////////********** CARGAR COMPLEMENTOS 

    ///***** CARGAMOS DATOS DEL COMPROBANTE

    $sql_datos="SELECT a.fecha,a.total,b.clave,a.operacion, a.rfc, a.banco, a.cuenta, c.clave AS monedax, a.bcuenta, a.brfc
    FROM `alta_datos_ppd` a, sat_catalogo_fpago b, alta_moneda c
    WHERE
    a.idfpago=b.id
    AND a.moneda=c.id
    AND a.idcpd =".$last_id;
    $buscar_datos = $db->sql_query($sql_datos);
    $row_datos = $db->sql_fetchrow($buscar_datos);

    $fecha_pago = $row_datos['fecha']."T12:00:00";


    $pagos_xml = '<pago20:Pago FechaPago="'.$fecha_pago.'" FormaDePagoP="'.$row_datos['clave'].'" MonedaP="'.$row_datos['monedax'].'" Monto="'.$row_datos['total'].'" TipoCambioP="1" RfcEmisorCtaOrd="'.$row_datos['rfc'].'" NomBancoOrdExt="'.$row_datos['banco'].'" CtaOrdenante="'.$row_datos['cuenta'].'" RfcEmisorCtaBen="'.$row_datos['brfc'].'" CtaBeneficiario="'.$row_datos['bcuenta'].'">';


    /////////************ CORREGIR ESTA CONSULTA HACIENDO QUE EL DATOS SE EXTRAIGA CON UNA SUBCONSULTA DE ALTA FACTURA Y FOLIO FACTURA Y CON UN CASE DEPENDIENDOE LTIPO SERA LA CONULTA QUE SE EJECUTE

    /*$sql6="SELECT a.pago,c.uuid,a.npago,a.saldo_anterior,a.saldo_restante, c.moneda, c.tcambio, d.serie, d.folio
    FROM alta_pagos_ppd a,alta_factura c, folio_factura d
    WHERE
    a.idfactura=c.id
    AND c.idfolio=d.id
    AND a.idppd=".$last_id_dato;
    $buscar6 = $db->sql_query($sql6);*/


    $sql6="SELECT a.pago,a.npago,a.saldo_anterior,a.saldo_restante,a.idfactura,a.tipo
    FROM alta_pagos_ppd a
    WHERE
    a.idppd=".$last_id_dato;
    $buscar6 = $db->sql_query($sql6);

    
    $total_pagos = 0;
    $pimpuesto = 0;
    $bimpuesto = 0;

    while($row6 = $db->sql_fetchrow($buscar6)){


        if ( $row6["tipo"]==0 ) {
           
            $sql7="SELECT c.uuid,c.moneda,c.tcambio,d.serie,d.folio
            FROM alta_factura c, folio_factura d
            WHERE
            c.idfolio=d.id
            AND c.id=".$row6["idfactura"];

        }elseif ( $row6["tipo"]==1 ) {
            
            $sql7="SELECT c.uuid,c.moneda,c.tcambio,d.serie,d.folio
            FROM alta_factura_sustitucion c, folio_factura d
            WHERE
            c.idfolio=d.id
            AND c.id=".$row6["idfactura"];

        }

        
        $buscar7 = $db->sql_query($sql7);
        $row7 = $db->sql_fetchrow($buscar7);


        $monedax = $row7["moneda"];

        if ( $monedax == 1 ) {
            
            $moneda_xml = "MXN";
            $tcambio_xml = 1;
            $pagado = $row6["pago"];

            $p20sub = $pagado/1.16;
            $p20iva = $pagado-$p20sub;



        }else if ( $monedax == 2 ) {
            
            $moneda_xml = "USD";
            $tcambio_xml = $row7["tcambio"];
            $pagado = round($row6["pago"]*$row7["tcambio"],2);

            $p20sub = $pagado/1.16;
            $p20iva = $pagado-$p20sub;

        }

        $total_pagos = $total_pagos+$pagado;
        $pimpuesto = $pimpuesto+round($p20iva,2);
        $bimpuesto = $bimpuesto+round($p20sub,2);

        $pagos_xml .= '<pago20:DoctoRelacionado IdDocumento="'.$row7["uuid"].'" Serie="'.$row7["serie"].'" Folio="'.$row7["folio"].'" MonedaDR="'.$moneda_xml.'" NumParcialidad="'.$row6["npago"].'" ImpSaldoAnt="'.$row6["saldo_anterior"].'" ImpPagado="'.$row6["pago"].'" ImpSaldoInsoluto="'.$row6["saldo_restante"].'" ObjetoImpDR="02" EquivalenciaDR="'.$tcambio_xml.'">

                    <pago20:ImpuestosDR>
                        <pago20:TrasladosDR>
                            <pago20:TrasladoDR BaseDR="'.round($p20sub,2).'" ImpuestoDR="002" TipoFactorDR="Tasa" TasaOCuotaDR="0.160000" ImporteDR="'.round($p20iva,2).'">
                            </pago20:TrasladoDR>
                        </pago20:TrasladosDR>
                    </pago20:ImpuestosDR>
                </pago20:DoctoRelacionado>';

    }


        $pagos_xml .= '<pago20:ImpuestosP>
                    <pago20:TrasladosP>
                        <pago20:TrasladoP BaseP="'.round($bimpuesto,2).'" ImpuestoP="002" TipoFactorP="Tasa" TasaOCuotaP="0.160000" ImporteP="'.round($pimpuesto,2).'">
                        </pago20:TrasladoP>
                    </pago20:TrasladosP>
                </pago20:ImpuestosP>
                </pago20:Pago>';

    /////************ DESLOSAMOS EL IVA AL 16%

    //$psubtotal=$total_pagos/1.16;
    //$piva = $total_pagos-round($psubtotal,2);
    $piva=round($total_pagos,2)-round($bimpuesto,2);


    $cadena_xml.='<cfdi:Complemento>
      <pago20:Pagos Version="2.0">
        <pago20:Totales TotalTrasladosBaseIVA16="'.round($bimpuesto,2).'" MontoTotalPagos="'.round($total_pagos,2).'" TotalTrasladosImpuestoIVA16="'.round($piva,2).'"/>';

    $cadena_xml.= $pagos_xml;

    $cadena_xml.='</pago20:Pagos>
        </cfdi:Complemento>
    </cfdi:Comprobante>';


    //////////***** ALMACENAMOS EL XML CREADO 

    $ubicacion = 'xml_pago/xml'.$last_id.'.xml';
    $archivo = fopen($ubicacion, "w+");
    fwrite($archivo, $cadena_xml);


     //ruta al archivo XML del CFDI
    $xmlFile=$ubicacion;
 
    // Ruta al archivo XSLT
    $xslFile = "cadenaoriginal.xslt"; 
 
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
 
    //echo $cadenaOriginal."<br><br>";
    

    $private = openssl_pkey_get_private(file_get_contents("facturalo/pkcomanorsa.pem"));
    $sig = "";
    openssl_sign($cadenaOriginal, $sig, $private, OPENSSL_ALGO_SHA256);
    $sello = base64_encode($sig);

    $sqlupt="UPDATE `alta_ppd` SET `sello` ='".$sello."', `folio_temporal`='".$folio."', serie_temporal='".$serie."' WHERE `id`=".$last_id;
    $db->sql_query($sqlupt);

    //echo json_encode("xml creado con exito");

    ////////////////*********************************** FACTURAR EL ARCHIVO CREADO ****************************************************************************

/*$nombre_fichero = $ubicacion;

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

                $ubicacion = 'factura_comprobante_pago/'.$SerieFolio.'.xml';
                $archivo = fopen($ubicacion, "w+");
                fwrite( $archivo,$respuesta['cfdi'] );


                if ( $respuesta['codigo'] == 200 ) {
                    
                    /////////******************* INSERTAMOS EL NUEVO FOLIO CREADO 

                    $sqlnewfolio="INSERT INTO `folio_ppd` (`id`, `serie`, `folio`, `estatus`) VALUES (NULL, '".$serie."','".$folio."', '0')";
                    $db->sql_query($sqlnewfolio);

                    /////////////******************* COLOCAMOS EL ULTIMO ID DE FOLIO FACTURA EN ALTA FACTURA

                    $sql_update = "UPDATE alta_ppd SET fecha = '".date('Y-m-d')."', hora='".date('H:i:s')."',idfolio = (SELECT MAX(x.id) FROM folio_ppd x), estatus='1' WHERE id=".$last_id;
                    $db->sql_query($sql_update);

                    echo json_encode($last_id);


                }else{

                    echo json_encode("Mensaje: ".$respuesta['codigo'].'|'.$respuesta['mensaje']);
                    
                }

                ///
        break;

    }

}else{

    echo json_encode("xml no encontrado, favor de realizar el coplemento nuevamente");

}

*/

echo json_encode($last_id);

?>
