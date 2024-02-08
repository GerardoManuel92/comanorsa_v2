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

                array('º', '~','!','&','´',';','"','°',"'"),

                array('','','','&amp;','','','&quot;',' grados',""),

                $string

            );

         

         

            return $string;

}



$idfactura=trim($_POST["idfactura"]);

$idcotizacion=trim($_POST["idcotizacion"]);

$fpago=trim($_POST["fpago"]);

$observaciones=changeString($_POST["observaciones"]);

$fecha= date("Y-m-d");

$hora = date("H:i:s");

$fecha_factura = $fecha."T".$hora;

$iduser =trim($_POST["iduser"]);

$mifecha =date('H:i:s'); 
//$mifecha->modify('-1 hours');
$separar_hora=explode(":", $mifecha);
$hora_menos=$separar_hora[0]-1;
$hora_actual=$hora_menos.":".$separar_hora[1].":".$separar_hora[2];

/////////////*********** CREAMOS LA NOTA DE CREDITO



$new_nc = "INSERT INTO `alta_nota_credito` (`id`, `idusuario`, `idfolio`, `idfactura`, `fecha`, `hora`, `fpago`, `subtotal`, `iva`, `retenciones`, `total`, `observaciones`, `estatus`) VALUES (NULL, '$iduser', '0', '$idfactura', '".$fecha."', '".$hora."', '$fpago', '0', '0', '0', '0', '".$observaciones."', '0')";

$db->sql_query($new_nc);



$maxid = "SELECT MAX(id) AS idmax FROM alta_nota_credito LIMIT 0,1";

$buscarmax = $db->sql_query($maxid);

$rowmax = $db->sql_fetchrow($buscarmax);

$idnota = trim($rowmax["idmax"]);



$sql_temp = "SELECT a.idpartefact,a.cantidad,a.descripcion, b.costo, b.iva, b.riva, b.risr

FROM `temporal_partes_ncredito` a, partes_factura c,partes_cotizacion b

WHERE 

a.idpartefact=c.id

AND c.idpartecot=b.id

AND a.idfactura=".$idfactura;

$buscar_temp = $db->sql_query($sql_temp);



$csubtotal = 0;

$civa = 0;

$cretencion = 0;



while ( $row_temp = $db->sql_fetchrow($buscar_temp)) {

    

    $idpartefact = $row_temp["idpartefact"];

    $cantidad = $row_temp["cantidad"];

    $descripcion = $row_temp["descripcion"];

    $costo = $row_temp["costo"];

    $iva = $row_temp["iva"];

    $riva = $row_temp["riva"];

    $risr = $row_temp["risr"];



    $partes_nc = "INSERT INTO `partes_ncredito` (`id`, `idnota`, `idfactura`, `idpartefact`, `idparte`, `descripcion`, `cantidad`) VALUES (NULL, '$idnota', '$idfactura', '$idpartefact', '0', '".changeString($descripcion)."', '".$cantidad."')";

    $db->sql_query($partes_nc);

    

    /////////***CALCULAR IMPORTES



    $sub = $cantidad*$costo;

    $csubtotal = round($csubtotal+$sub,2);



    if ( $iva > 0 ) {

        

        $ivax = $sub*($iva/100);

        $civa = $civa+round($ivax,2);



    }



    if ( $riva > 0 ) {

        

        $rivax = $sub*($riva/100);

        $cretencion = $cretencion+round($rivax,2);



    }



    if ( $risr > 0 ) {

        

        $risrx = $sub*($risr/100);

        $cretencion = $cretencion+round($risrx,2);



    }



}



//////************** ACTUALIZAMOS LOS IMPORTES DE LA NOTA DE CREDITO 

$ctotal = $csubtotal+$civa-$cretencion;



$update_nc = "UPDATE `alta_nota_credito` SET `subtotal` = '".$csubtotal."', `iva` = '".$civa."', `retenciones` = '".$cretencion."', `total` = '".$ctotal."' WHERE id=".$idnota;

$db->sql_query($update_nc);





//////////////////////////////////******************** COMPROBAMOS EL FOLIO DE LA NOTA DE CREDITO *************************************************************************************************



$sqlfolio = "SELECT folio FROM folio_nota_credito ORDER BY id DESC LIMIT 0,1";

$bmax = $db->sql_query($sqlfolio);

$rowmax = $db->sql_fetchrow($bmax);



$folio = trim($rowmax["folio"])+1;//// este folio suma un numero mas para simular el siguiente folio de faturacion y ya facturado los insertamos

$serie = "NC";

$serie_folio = $serie."".$folio;



/////************************************* DATOS XML COMANORSA 



$sql="SELECT iva,rfc,razon_social,calle,exterior,interior,colonia,localidad,municipio,estado,pais,cp,regimen,serie_factura,certificado,nocertificado,keyx,cer,keypem,cerpem,apikey

FROM `datos_generales` WHERE estatus = 0";

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

$tipo_comprobante ="ingreso";//

$tasa =$row["iva"]/100;//

////

$key =trim($row["key"]);

$cer =trim($row["cer"]);

$keypem =trim($row["keypem"]);

$cerpem =trim($row["cerpem"]);

$apikey = trim($row["apikey"]);



///////////********************************** DATOS DEL CLIENTE Y FACTURA



$sql2="SELECT a.rfc, a.nombre, a.calle, a.exterior, a.interior, a.colonia, a.municipio, a.estado, a.cp, b.moneda, b.tcambio, b.uuid,

(SELECT y.clave FROM sat_catalogo_fpago y WHERE y.id= '".$fpago."' ) AS fpagox,a.id AS idclientex

FROM alta_factura b, alta_clientes a

WHERE

b.idcliente=a.id

AND b.id=".$idfactura;

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

$forma_pago = trim($row2["fpagox"]);

$idclientex = trim($row2["idclientex"]);



///////////////////************************** DATOS DE LA FACTURA



$uso_cfdi = "G02";

$metodo_pago = "PUE";

$impuesto_iva = "002";

$tcambio = $row2["tcambio"];

$uuid = $row2["uuid"];

$trelacion= "01";////////// tipo de lrelacion de la factura 01-nota de devolucion



if( $row2["moneda"] == 1 ){



    /// pesos

    $moneda = "MXN";

    $tipo_cambio = 1;



}elseif ( $row2["moneda"] == 2 ) {

    

    /// USD

    $moneda = "USD";

    $tipo_cambio = $tcambio;



}



///////////////****************** DATOS DEL CLIENTE O RECEPTOR



$sql2x="SELECT a.rfc, a.nombre, c.calle, c.exterior,c.interior, c.colonia, c.municipio, c.estado, c.cp, b.clave AS regimen_receptor  

        FROM 

        alta_clientes a, sat_catalogo_regimen_fiscal b, direccion_clientes c

        WHERE

        a.idregimen=b.id

        AND c.idcliente=a.id

        AND a.id=".$idclientex;

        $buscar2x = $db->sql_query($sql2x);

        $row2x = $db->sql_fetchrow($buscar2x);





        $rfc_receptor = changeString($row2x["rfc"]);///////************* RFC DE PRUEBA

        //$nombre_receptor = changeString($row2["nombre"]);



        if ( $idcliente == 21 ) {

    

            if ( $name_factura != "" ) {

                

                $nombre_receptor=trim($name_factura);



            }else{



                $nombre_receptor=trim("VENTAS PUBLICO GENERAL");



            }



        }else{



            $nombre_receptor = trim($row2x["nombre"]);



        }



        $calle_receptor = changeString($row2x["calle"]);

        $exterior_receptor = changeString($row2x["exterior"]);

        $interior_receptor = changeString($row2x["interior"]);

        $colonia_receptor = changeString($row2x["colonia"]);

        $municipio_receptor = changeString($row2x["municipio"]);

        $estado_receptor = changeString($row2x["estado"]);

        $pais_receptor = changeString("Mexico");

        $cp_receptor = trim($row2x["cp"]);

        $regimen_receptor = trim($row2x["regimen_receptor"]);



//////////////*********************************** PARTIDAS DE LA FACTURA 



$sql4 = "SELECT b.costo,a.cantidad,a.descripcion,c.sat,d.clave AS clave_unidad, d.abr AS unidad, c.nparte, b.iva, b.descuento, b.riva, b.risr

FROM partes_ncredito a, partes_factura e,partes_cotizacion b, alta_productos c, sat_catalogo_unidades d

WHERE 

a.idpartefact=e.id

AND e.idpartecot=b.id

AND b.idparte=c.id

AND c.idunidad=d.id

AND a.idnota =".$idnota;

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

    

    $ti_costo = round($row4['costo'], 2);

    $ti_cantidad = $row4['cantidad'];

    $ti_descripcionx = $row4['descripcion'];

    $replace=array('<','>','&','"','\'','¨');

    $match=array('&lt;','&gt;','&amp;','&quot;','&apos;','&quot;');

    $ti_descripcion =str_replace($replace, $match, $ti_descripcionx);

    $ti_unidad = $row4['unidad'];

    $ti_clave = $row4['nparte'];

    $ti_clavesat = $row4['sat'];

    $ti_importe = round($ti_cantidad*$ti_costo, 2);

    $vdescuento = $row4["descuento"];

    $riva= $row4["riva"];

    $risr= $row4["risr"];

    



    if ( $vdescuento > 0 ) {



        $ti_descuento = $vdescuento/100;

        $descuento =$ti_importe*$ti_descuento;

        $ti_importe_iva = round( ($ti_importe-$descuento),2 );



    }else{



        //$ti_descuento = 0;

        $descuento =0;

        $ti_importe_iva = $ti_importe;



    }

    

    $ti_clv_unidad = $row4['clave_unidad'];

    $ti_iva = $row4["iva"]/100;

    $total_iva = round( ($ti_importe_iva*$ti_iva),2 );

    $totdescuento = $totdescuento+$descuento;

    $total_subtotal = $total_subtotal+$ti_importe_iva;







    $partes_xml = $partes_xml.'<cfdi:Concepto Cantidad="'.$ti_cantidad.'" ClaveProdServ="'.$ti_clavesat.'" ClaveUnidad="'.$ti_clv_unidad.'" Descripcion="'.$ti_descripcion.'" Importe="'.$ti_importe.'" NoIdentificacion="'.$ti_clave.'" Unidad="'.$ti_unidad.'" ValorUnitario="'.$ti_costo.'" Descuento="'.round($descuento,2).'" ObjetoImp="02">

      <cfdi:Impuestos>

        <cfdi:Traslados>

          <cfdi:Traslado Base="'.$ti_importe_iva.'" Importe="'.$total_iva.'" Impuesto="002" TasaOCuota="0.160000" TipoFactor="Tasa" />

        </cfdi:Traslados>';



        $total_base_iva = $total_base_iva+$ti_importe_iva;



        if ( $riva > 0 OR $risr > 0 ) {

            

            ////////******* CALCULAR RETENCIONES



            $partes_xml.='<cfdi:Retenciones>';



            if ( $riva > 0) {

                

                $ti_riva = round( ($riva/100),2 );

                $total_riva = round( ($ti_importe_iva*$ti_riva),2 );



                $partes_xml.='<cfdi:Retencion Base="'.$ti_importe_iva.'" Impuesto="002" TipoFactor="Tasa" TasaOCuota="'.$ti_riva.'0000" Importe="'.$total_riva.'" />';



                $total_retenciones = $total_retenciones+$total_riva;

                $total_retenciones_iva = $total_retenciones_iva+$total_riva;



            }



            if ( $risr > 0) {

                

                $ti_risr = round( ($risr/100),2 );

                $total_risr = round( ($ti_importe_iva*$ti_risr),2 );



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



    $total_real = ( $csubtotal-round($totdescuento,2) )+round($totiva,2)-round($total_retenciones,2);



}else{



    /////////***** SOLO SUMAR IVA

    $total_real = ( $csubtotal-round($totdescuento,2) )+round($totiva,2);





}



//////////////***************** JUNTAR DATOS DEL XML



$cadena_xml       = '<?xml version="1.0" encoding="utf-8"?>

<cfdi:Comprobante xsi:schemaLocation="http://www.sat.gob.mx/cfd/4 http://www.sat.gob.mx/sitio_internet/cfd/4/cfdv40.xsd" Version="4.0" Serie="'.$serie.'" Folio="'.$folio.'" Fecha="'.date("Y-m-d").'T'.$hora_actual.'" SubTotal="'.$csubtotal.'" Descuento="'.round($totdescuento,2).'" Moneda="'.$moneda.'" TipoCambio="'.$tipo_cambio.'" Total="'.round($total_real,2).'" TipoDeComprobante="E" Exportacion="01" Certificado="'.$certificado.'" NoCertificado="'.$nocertificado.'" MetodoPago="'.$metodo_pago.'" FormaPago="'.$forma_pago.'" LugarExpedicion="'.$cp_emisor.'" xmlns:cfdi="http://www.sat.gob.mx/cfd/4" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" >

  <cfdi:CfdiRelacionados TipoRelacion="'.$trelacion.'">

        <cfdi:CfdiRelacionado UUID="'.$uuid.'" />

  </cfdi:CfdiRelacionados>

  <cfdi:Emisor Nombre="'.strtoupper($nombre_emisor).'" RegimenFiscal="'.$clave_regimen.'" Rfc="'.strtoupper($rfc_emisor).'" />

  <cfdi:Receptor Nombre="'.strtoupper($nombre_receptor).'" Rfc="'.strtoupper($rfc_receptor).'" UsoCFDI="'.strtoupper($uso_cfdi).'" DomicilioFiscalReceptor="'.$cp_receptor.'" RegimenFiscalReceptor="'.$regimen_receptor.'"/>

  <cfdi:Conceptos>'."\r\n";



$cadena_xml      .= $partes_xml."\r\n";



$cadena_xml      .='</cfdi:Conceptos>';



if ( $total_retenciones > 0 ) {



    $cadena_xml     .='<cfdi:Impuestos TotalImpuestosRetenidos="'.round($total_retenciones,2).'" TotalImpuestosTrasladados="'.round($totiva,2).'">';



    $cadena_xml     .='<cfdi:Retenciones>';



        if ( $total_retenciones_iva > 0 ) {

            

            $cadena_xml.='<cfdi:Retencion Impuesto="002" Importe="'.round($total_retenciones_iva,2).'" />';



        }



        if ( $total_retenciones_isr > 0 ) {

            

            $cadena_xml.='<cfdi:Retencion Impuesto="001" Importe="'.round($total_retenciones_isr,2).'" />';



        }



    $cadena_xml     .='</cfdi:Retenciones>';

        



    $cadena_xml     .='<cfdi:Traslados>

                          <cfdi:Traslado Base="'.$total_base_iva.'" Importe="'.round($totiva,2).'" Impuesto="002" TasaOCuota="0.160000" TipoFactor="Tasa" />

                        </cfdi:Traslados>';



}else{



    $cadena_xml     .='<cfdi:Impuestos TotalImpuestosTrasladados="'.round($totiva,2).'">';



    $cadena_xml     .='<cfdi:Traslados>

                          <cfdi:Traslado Base="'.$total_base_iva.'" Importe="'.round($totiva,2).'" Impuesto="002" TasaOCuota="0.160000" TipoFactor="Tasa" />

                        </cfdi:Traslados>';



}



    $cadena_xml     .='</cfdi:Impuestos>

                        </cfdi:Comprobante>';







         $ubicacion = 'xml_nc/archivo_xml'.$idnota.'.xml';

         $archivo = fopen($ubicacion, "w+");

         fwrite($archivo, $cadena_xml);



         //echo  json_encode("XML generado con exito");



////////////////FACTURAR EL ARCHIVO CREADO

//echo json_encode("xml creado");



         /////***************** AÑADIDOS A LA VERSION 4.0



                //Exportacion etiqueta cfdi:Comprobante a un lado de tipo de comprobante



                //// Se debe registrar la clave “ 01” (No aplica)."



                //LugarExpedicion cfdi:Comprobante a un lado de forma de pago



                /// se debe colocar el codigo postal del emisor para poder emitir la fatura



                //DomicilioFiscalReceptor etiqueta cfdi:Receptor 



                //ObjetoImp añadida a cada una de las partidas



                //// este tiene tres valores: 01(No objeto de impuesto), 02(Objeto de impuesto), 03(Sí objeto del impuesto y no obligado al desglose)



            //Base etiqueta cfdi:Traslados





$nombre_fichero = $ubicacion;



if ( file_exists($nombre_fichero) ) {



    # OBJETO DEL API DE CONEXION

    //$url = 'https://dev.facturaloplus.com/ws/servicio.do?wsdl';

    $url = 'https://app.facturaloplus.com/ws/servicio.do?wsdl';

    $objConexion = new Conexion($url);



    # CREDENCIAL

    $apikey = $apikey;

    $opc = 31;



    switch($opc)

    {

        



        case 31: 



                



                $cfdi = file_get_contents($nombre_fichero);

                //echo $objConexion->operacion_timbrar($apikey, $cfdi);

                $keyPEM = file_get_contents('facturalo/'.$keypem);



                $idfolio = $serie_folio;



                

                //// tambien se tiene que colocar la base o sumatoria de las bases de todos los impuestos trasladados o retenidos 





                $respuesta = $objConexion->operacion_timbrar_sellar($apikey, $cfdi, $keyPEM);



                $ubicacion = 'factura_comprobante_nc/'.$idfolio.'.xml';

                $archivo = fopen($ubicacion, "w+");

                fwrite( $archivo,$respuesta['cfdi'] );

                //codigo

                //mensaje

                //cfdi



                //echo "codigo: ".$respuesta['codigo']."<br>mensaje: ".$respuesta['mensaje']."<br>cfdi: ".$respuesta['cfdi'];



                if ( $respuesta['codigo'] == 200 ) {

                    

                    /////////******************* INSERTAMOS EL NUEVO FOLIO CREADO 



                    $sqlnewfolio="INSERT INTO `folio_nota_credito` (`id`, `serie`, `folio`, `estatus`) VALUES (NULL, '".$serie."','".$folio."', '0')";

                    $db->sql_query($sqlnewfolio);



                    /////////////******************* COLOCAMOS EL ULTIMO ID DE FOLIO FACTURA EN ALTA FACTURA



                    $sql_update = "UPDATE alta_nota_credito SET ftimbrado = '".date('Y-m-d')."', htimbrado='".$hora_actual."',idfolio = (SELECT MAX(x.id) FROM folio_nota_credito x), estatus='1' WHERE id=".$idnota;

                    $db->sql_query($sql_update);



                    echo json_encode($idnota);





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