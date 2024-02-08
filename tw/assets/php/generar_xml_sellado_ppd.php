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

        $idppd=trim($_POST["idppdx"]);

        ///////********* DATOS DEL COMPLEMENTO DE PAGO

        $sqlinfo="SELECT idcliente,iduser,fecha,hora,total,idmoneda,folio_temporal,sello,serie_temporal
                    FROM alta_ppd
                    WHERE id=".$idppd;
        $binfo = $db->sql_query($sqlinfo);
        $rinfo = $db->sql_fetchrow($binfo);

        $idcliente=$rinfo["idcliente"];
        $iduser=$rinfo["iduser"];
        $fecha=$rinfo["fecha"];
        $hora=$rinfo["hora"];
        $total=$rinfo["total"];
        $idmoneda=$rinfo["idmoneda"];
        $folio_temporal=trim($rinfo["folio_temporal"]);
        $fecha_factura=trim($fecha."T".$hora);
        $sello=trim($rinfo["sello"]);
        $serie_temporal=trim($rinfo["serie_temporal"]);

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
        //$SerieFolio =$serie."".$folio;
        
        $fecha=date("Y-m-d");
        $tipo_comprobante ="ingreso";//
        $tasa =$row["iva"]/100;//

        $key =trim($row["keyx"]);
        $cer =trim($row["cer"]);
        $keypem =trim($row["keypem"]);
        $cerpem =trim($row["cerpem"]);
        $apikeyx =trim($row["apikey"]);

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
        $rfc_receptor = changeString($row2["rfc"]);
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
         http://www.sat.gob.mx/sitio_internet/cfd/Pagos/Pagos20.xsd" xmlns:pago20="http://www.sat.gob.mx/Pagos20" Version="4.0" Serie="'.$serie_temporal.'" Folio="'.$folio_temporal.'" Fecha="'.$fecha_factura.'" SubTotal="0" Moneda="XXX" Total="0" TipoDeComprobante="P" Exportacion="01" Certificado="'.$certificado.'" NoCertificado="'.$nocertificado.'"  Sello="'.$sello.'" LugarExpedicion="'.$cp_emisor.'"  xmlns:cfdi="http://www.sat.gob.mx/cfd/4" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">

          <cfdi:Emisor Rfc="'.strtoupper($rfc_emisor).'" Nombre="'.strtoupper($nombre_emisor).'" RegimenFiscal="'.strtoupper($clave_regimen).'"/>
          <cfdi:Receptor Rfc="'.strtoupper($rfc_receptor).'" Nombre="'.$nombre_receptor.'" DomicilioFiscalReceptor="'.$cp_receptor.'" RegimenFiscalReceptor="'.strtoupper($regimen_receptor).'" UsoCFDI="CP01"/>
          <cfdi:Conceptos>
            <cfdi:Concepto ClaveProdServ="84111506" Cantidad="1" ClaveUnidad="ACT" Descripcion="Pago" ValorUnitario="0" Importe="0" ObjetoImp="01"/>
          </cfdi:Conceptos>';
          
    //////////********** CARGAR COMPLEMENTOS 

    ///***** CARGAMOS DATOS DEL COMPROBANTE

    $sql_datos="SELECT a.id,a.fecha,a.total,b.clave,a.operacion, a.rfc, a.banco, a.cuenta, c.clave AS monedax, a.bcuenta, a.brfc
    FROM `alta_datos_ppd` a, sat_catalogo_fpago b, alta_moneda c
    WHERE
    a.idfpago=b.id
    AND a.moneda=c.id
    AND a.idcpd =".$idppd;
    $buscar_datos = $db->sql_query($sql_datos);
    $row_datos = $db->sql_fetchrow($buscar_datos);

    $fecha_pago = $row_datos['fecha']."T12:00:00";


    $pagos_xml = '<pago20:Pago FechaPago="'.$fecha_pago.'" FormaDePagoP="'.$row_datos['clave'].'" MonedaP="'.$row_datos['monedax'].'" Monto="'.$row_datos['total'].'" TipoCambioP="1" RfcEmisorCtaOrd="'.$row_datos['rfc'].'" NomBancoOrdExt="'.$row_datos['banco'].'" CtaOrdenante="'.$row_datos['cuenta'].'" RfcEmisorCtaBen="'.$row_datos['brfc'].'" CtaBeneficiario="'.$row_datos['bcuenta'].'">';

    $last_id_dato=trim($row_datos['id']);


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

    $ubicacion = 'xml_pago_sellado/xml'.$idppd.'.xml';
    $archivo = fopen($ubicacion, "w+");
    fwrite($archivo, $cadena_xml);


    echo json_encode($idppd);

?>