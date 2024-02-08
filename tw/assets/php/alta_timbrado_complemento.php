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

    $idcliente = trim($_POST["idcli"]);
    $idusuario = trim($_POST["iduser"]);
    $fecha_factura = date("Y-m-d")."T".date("H:i:s");
    $fecha = date("Y-m-d");
    $serie = "P";


    ////////////********** REVISAR QUE EXISTA INFORMACION EN EL TEMPORAL 

    $sql="SELECT COUNT(a.id) AS ntemporal
    FROM temporal_ppd a, alta_factura b
    WHERE a.idfactura=b.id
    AND b.idcliente =".$idcliente;
    $buscar = $db->sql_query($sql);
    $row = $db->sql_fetchrow($buscar);

    $ntemporal = trim($row["ntemporal"]);

    if ( $ntemporal == 0 ) {
        
        echo json_encode( null );

    }else{

        /////********** damos de alta el complemento de pago
        $sql1="INSERT INTO `alta_ppd` (`id`, `idcliente`, `iduser`, `fecha`) VALUES (NULL, $idcliente, $idusuario, '$fecha')";
        $db->sql_query($sql1);

        ////traemos el ultimo ID

        $sql2 = "SELECT MAX(id) AS idmax
        FROM alta_ppd";
        $buscar2 = $db->sql_query($sql2);
        $row2 = $db->sql_fetchrow($buscar2);

        $last_id = trim($row2["idmax"]);


        $sql3="SELECT a.id,a.idfactura,a.fecha,a.hora,a.fpago,a.npago,a.moneda,a.tcambio,a.saldo,a.pago,a.insoluto
        FROM temporal_ppd a, alta_factura b
        WHERE a.idfactura=b.id
        AND b.idcliente = ".$idcliente;
        $buscar3 = $db->sql_query($sql3);
        while($row3 = $db->sql_fetchrow($buscar3)){

            ///////****** agregamos los complementos de pago a la tabla del alta 

            $sql4="INSERT INTO `alta_pagos_ppd` (`id`, `idppd`, `idfactura`, `fecha`, `moneda`, `tcambio`, `npago`, `saldo_anterior`, `pago`, `saldo_restante`, `idfpago`) VALUES (NULL, $last_id, '".$row3['idfactura']."', '".$row3['fecha']."', '".$row3['moneda']."', '".$row3['tcambio']."', '".$row3['npago']."', '".$row3['saldo']."', '".$row3['pago']."', '".$row3['insoluto']."','".$row3['fpago']."')";
            $buscar4 = $db->sql_query($sql4);

        }


        ////// traemos el ultimo folio del complemento 

        $sql5="SELECT folio FROM folio_ppd ORDER BY id DESC limit 0,1";
        $buscar5 = $db->sql_query($sql5);
        $row5 = $db->sql_fetchrow($buscar5);

        $folio = $row5["folio"]+1;

        $nserie_folio = $serie."".$folio;

        /////************************************* DATOS XML COMANORSA 

        $sql="SELECT iva,rfc,razon_social,calle,exterior,interior,colonia,localidad,municipio,estado,pais,cp,regimen,serie_factura,certificado,nocertificado,keyx,cer,keypem,cerpem,apikey FROM `datos_generales` WHERE estatus = 0";
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

        //$serie = trim($row["serie_factura"]);
        $SerieFolio =$folio;
        
        $fecha=date("Y-m-d");
        $tipo_comprobante ="ingreso";//
        $tasa =$row["iva"]/100;//

        $key =trim($row["key"]);
        $cer =trim($row["cer"]);
        $keypem =trim($row["keypem"]);
        $cerpem =trim($row["cerpem"]);
        $apikeyx =trim($row["apikey"]);

        ////////////********************************** DATOS DEL CLIENTE

        $sql2="SELECT a.rfc, a.nombre, a.calle, a.exterior, a.interior, a.colonia, a.municipio, a.estado, a.cp, b.clave
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



        ////////********** CREAMOS EL XML DEL COMPLEMENTO DE PAGO

        $cadena_xml       = '<?xml version="1.0" encoding="utf-8"?>
<cfdi:Comprobante xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd http://www.sat.gob.mx/Pagos20 
 http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos20.xsd" xmlns:pago20="http://www.sat.gob.mx/Pagos20" Version="4.0" Serie="'.$serie.'" Folio="'.$folio.'" Fecha="'.$fecha_factura.'" SubTotal="0" Moneda="XXX" Total="0.00" TipoDeComprobante="P" Exportacion="01" Certificado="'.$certificado.'" NoCertificado="'.$nocertificado.'" LugarExpedicion="'.$cp_emisor.'"  xmlns:cfdi="http://www.sat.gob.mx/cfd/4" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">

  <cfdi:Emisor Rfc="'.strtoupper($rfc_emisor).'" Nombre="'.strtoupper($nombre_emisor).'" RegimenFiscal="'.strtoupper($clave_regimen).'" />
  <cfdi:Receptor Rfc="'.strtoupper($rfc_receptor).'" Nombre="'.strtoupper($nombre_receptor).'" DomicilioFiscalReceptor="'.$cp_receptor.'" RegimenFiscalReceptor="'.strtoupper($clave).'" UsoCFDI="CP01" />
  <cfdi:Conceptos>
    <cfdi:Concepto ClaveProdServ="84111506" Cantidad="1" ClaveUnidad="ACT" Descripcion="Pago" ValorUnitario="0" Importe="0" ObjetoImp="01" />
  </cfdi:Conceptos>';

    }

    //////////********** CARGAR COMPLEMENTOS 

    $sql6="SELECT a.fecha,b.clave,a.moneda,a.tcambio,a.pago,c.uuid,a.npago,a.saldo_anterior,a.saldo_restante
    FROM alta_pagos_ppd a, sat_catalogo_fpago b, alta_factura c
    WHERE
    a.idfpago=b.id
    AND a.idfactura=c.id
    AND a.idppd=".$last_id;
    $buscar6 = $db->sql_query($sql6);

    $pagos_xml = '';
    $total_pagos = 0;

    while($row6 = $db->sql_fetchrow($buscar6)){

        $fecha_pago = $row6["fecha"]."T12:00:00";

        $monedax = $row6["moneda"];

        if ( $monedax == 1 ) {
            
            $moneda_xml = "MXN";
            $tcambio_xml = 1;
            $pagado = $row6["pago"];

        }else if ( $monedax == 2 ) {
            
            $moneda_xml = "USD";
            $tcambio_xml = $row6["tcambio"];
            $pagado = round($row6["pago"]*$row6["tcambio"],2);

        }

        $total_pagos = $total_pagos+$pagado;

        $pagos_xml .= '<pago20:Pago FechaPago="'.$fecha_pago.'" FormaDePagoP="'.$row6["clave"].'" MonedaP="'.$moneda_xml.'" Monto="'.$row6["pago"].'" TipoCambioP="'.$tcambio_xml.'">
                <pago20:DoctoRelacionado IdDocumento="'.$row6["uuid"].'" MonedaDR="'.$moneda_xml.'" NumParcialidad="'.$row6["npago"].'" ImpSaldoAnt="'.$row6["saldo_anterior"].'" ImpPagado="'.$row6["pago"].'" ImpSaldoInsoluto="'.$row6["saldo_restante"].'" ObjetoImpDR="01" EquivalenciaDR="'.$tcambio_xml.'"/>
            </pago20:Pago>';

    }

    $cadena_xml.='<cfdi:Complemento>
      <pago20:Pagos Version="2.0">
        <pago20:Totales MontoTotalPagos="'.$total_pagos.'" />';

    $cadena_xml.= $pagos_xml;

    $cadena_xml.='</pago20:Pagos>
        </cfdi:Complemento>
    </cfdi:Comprobante>';


    //////////***** ALMACENAMOS EL XML CREADO 

    $ubicacion = 'xml_pago/xml'.$last_id.'.xml';
    $archivo = fopen($ubicacion, "w+");
    fwrite($archivo, $cadena_xml);


    //echo json_encode("xml creado con exito");

////////////////*********************************** FACTURAR EL ARCHIVO CREADO ****************************************************************************
//echo json_encode("xml creado");

$nombre_fichero = $ubicacion;

if ( file_exists($nombre_fichero) ) {

    # OBJETO DEL API DE CONEXION
    $url = 'https://dev.facturaloplus.com/ws/servicio.do?wsdl';
    $objConexion = new Conexion($url);

    # CREDENCIAL
    $apikey = $apikeyx;
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

                //codigo
                //mensaje
                //cfdi

                //echo "codigo: ".$respuesta['codigo']."<br>mensaje: ".$respuesta['mensaje']."<br>cfdi: ".$respuesta['cfdi'];

                if ( $respuesta['codigo'] == 200 ) {

                    $ubicacion = 'factura_comprobante_pago/'.$idfolio.'.xml';
                    $archivo = fopen($ubicacion, "w+");
                    fwrite( $archivo,$respuesta['cfdi'] );
                    
                    /////////******************* INSERTAMOS EL NUEVO FOLIO CREADO 

                    $sqlnewfolio="INSERT INTO `folio_ppd` (`id`, `serie`, `folio`, `estatus`) VALUES (NULL, '".$serie."','".$folio."', '0')";
                    $db->sql_query($sqlnewfolio);

                    /////////////******************* COLOCAMOS EL ULTIMO ID DE FOLIO FACTURA EN ALTA FACTURA

                    $sql_update = "UPDATE alta_ppd SET fecha = '".date('Y-m-d')."', hora='".date('H:i:s')."',total= '".$total_pagos."',idfolio = (SELECT MAX(x.id) FROM folio_ppd x), estatus='1' WHERE id=".$last_id;
                    $db->sql_query($sql_update);


                    echo json_encode($last_id);


                }else{

                    echo json_encode("Mensaje: ".$respuesta['codigo'].'|'.$respuesta['mensaje']);
                    
                }

                ///
        break;

    }

}else{

    echo json_encode("xml no encontrado, favor de realizar el complemento nuevamente");

}

?>
