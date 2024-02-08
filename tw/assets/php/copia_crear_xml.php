<?php
header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
include("config.php"); 
include("includes/mysql.php");
include("includes/db.php");
set_time_limit (600000);
date_default_timezone_set('America/Mexico_City');


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

$folio= 1;//trim($_POST["folio"]);
$idcliente = 3;//trim($_POST["idcliente"]);
$idfactura = 1;//trim($_POST["idfactura"]);
$idmetodo_pago = 1;//trim($_POST["mpago"]);////** PPD(Pago en Parcialidades o Diferido) | 99 (por definir) | PUE (Pago en Una sola Exhibición))
$idcotizacion= 5;//trim($_POST["idcot"]);

/////************************************* DATOS XML COMANORSA 

$sql="SELECT iva,rfc,razon_social,calle,exterior,interior,colonia,localidad,municipio,estado,pais,cp,regimen,serie_factura FROM `datos_generales` WHERE estatus = 0";
$buscar = $db->sql_query($sql);
$row = $db->sql_fetchrow($buscar);

$rfc_emisor = trim($row["rfc"]);
$nombre_emisor = trim($row["razon_social"]);
$calle_emisor = trim($row["calle"]);
$exterior_emisor = trim($row["exterior"]);
$colonia_emisor = trim($row["colonia"]);
$localidad_emisor = trim($row["localidad"]);
$estado_emisor = trim($row["estado"]);
$pais_emisor = trim($row["pais"]);
$cp_emisor = trim($row["cp"]);
$municipio_emisor = trim($row["municipio"]);
$regimen_fiscal = trim($row["regimen"]);

$serie = trim($row["SerieFolio"]);
$SerieFolio =$serie."-".$folio;
$nserie_folio = $serie."".$folio;
$fecha=date("Y-m-d");
$tipo_comprobante ="ingreso";//
$tasa =$row["iva"]/100;//

////////////********************************** DATOS DEL CLIENTE

$sql2="SELECT b.clave as fpago, a.rfc, a.nombre,c.clave AS cfdi, a.calle, a.exterior, a.interior, a.colonia, a.municipio, a.estado, a.cp   
FROM 
alta_clientes a,sat_catalogo_fpago b, sat_catalogo_cfdi c
WHERE 
a.idfpago=b.id
AND a.idcfdi=c.id
AND a.id=".$idcliente;
$buscar2 = $db->sql_query($sql2);
$row2 = $db->sql_fetchrow($buscar2);

$forma_pago = trim($row2["fpago"]);
$rfc_receptor = trim($row2["rfc"]);///////************* RFC DE PRUEBA
$nombre_receptor = trim($row2["nombre"]);
$uso_cfdi = trim($row2["cfdi"]);
$calle_receptor = trim($row2["calle"]);
$exterior_receptor = trim($row2["exterior"]);
$interior_receptor = trim($row2["interior"]);
$colonia_receptor = trim($row2["colonia"]);
$municipio_receptor = trim($row2["municipio"]);
$estado_receptor = trim($row2["estado"]);
$pais_receptor = trim("Mexico");
$cp_receptor = trim($row2["cp"]);

///////////////////************************** DATOS DE LA FACTURA

$sql3="SELECT fecha,hora,subtotal,iva,total,moneda,tcambio FROM `alta_factura` WHERE id=".$idfactura;
$buscar3 = $db->sql_query($sql3);
$row3 = $db->sql_fetchrow($buscar3);

$fechax = date("Y-m-d");
$horax = date("H:i:s");
$fecha_fact = $ti_fecha.'T'.$ti_hora;

$subTotal = $row3["subTotal"];
$total_iva = $row3["iva"];
$total = $row3["total"];
$impuesto_iva = "002";
$tcambio = $row3["tcambio"];

if( $row3["moneda"] == 1 ){

	/// pesos
	$moneda = "MXN";

}elseif ( $row3["moneda"] == 2 ) {
	
	/// USD
	$moneda = "USD";

}

/// ***** METODO DE PAGO

switch ( $idmetodo_pago ) {

	case 1:
		
		$metodo_pago = "PUE";

	break;

	case 2:
		
		$metodo_pago = "PPD";	

	break;

	case 3:
		
		$metodo_pago = "99";

	break;
	

}

//////////////*********************************** PARTIDAS DE LA FACTURA 

$sql4 = "SELECT a.costo,a.cantidad,a.descripcion,b.sat,c.clave AS clave_unidad,c.abr AS unidad, b.nparte 
FROM partes_cotizacion a, alta_productos b, sat_catalogo_unidades c
WHERE
a.idparte=b.id
AND b.idunidad=c.id
AND a.estatus = 0
AND a.idcotizacion =".$idcotizacion;
//echo $sql2;
$buscar4 = $db->sql_query($sql4);
$partes_xml = '';
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
	$ti_clv_unidad = $row4['nparte'];
	////////

	$partes_xml = $partes_xml.'<cfdi:Concepto ClaveProdServ="'.$ti_clavesat.'" cantidad="'.$ti_cantidad.'" unidad="'.$ti_unidad.'" noIdentificacion="'.$ti_clave.'" descripcion="'.$ti_descripcion.'" valorUnitario="'.$ti_costo.'" importe="'.$ti_importe.'" ClaveUnidad="'.$ti_clv_unidad.'" />';

}


$cadena_xml       = '<?xml version="1.0" encoding="utf-8"?>'."\r\n";
$cadena_xml      .= '<cfdi:Comprobante xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:cfdi="http://www.sat.gob.mx/cfd/3" xsi:schemaLocation="http://www.sat.gob.mx/cfd/3 http://www.sat.gob.mx/sitio_internet/cfd/3/cfdv33.xsd" Version="3.3" folio="'.$SerieFolio.'" fecha="'.$fecha_fact.'" formaDePago="'.$forma_pago.'" subTotal="'.$subTotal.'" Moneda="'.$moneda.'" total="'.$total.'" tipoDeComprobante="'.$tipo_comprobante.'" metodoDePago="'.$metodo_pago.'" LugarExpedicion="'.$cp_emisor.'" >'."\r\n";

$cadena_xml      .= '<cfdi:Emisor rfc="'.$rfc_emisor.'" nombre="'.$nombre_emisor.'">'."\r\n";
$cadena_xml      .= '<cfdi:DomicilioFiscal calle="'.$calle_emisor.'" noExterior="'.$exterior_emisor.'" colonia="'.$colonia_emisor.'" localidad="'.$localidad_emisor.'" municipio="'.$municipio_emisor.'" estado="'.$estado_emisor.'" pais="'.$pais_emisor.'" codigoPostal="'.$cp_emisor.'" />'."\r\n";
$cadena_xml      .= '<cfdi:RegimenFiscal Regimen="'.$regimen_fiscal.'" />'."\r\n";

$cadena_xml      .= '</cfdi:Emisor>'."\r\n";
$cadena_xml      .= '<cfdi:Receptor rfc="'.$rfc_receptor.'" nombre="'.$nombre_receptor.'" UsoCFDI="'.$uso_cfdi.'">'."\r\n";

$cadena_xml      .= '<cfdi:Domicilio calle="'.$calle_receptor.'" noExterior="'.$exterior_receptor.'" noInterior="'.$interior_receptor.'" colonia="'.$colonia_receptor.'" municipio="'.$municipio_receptor.'" estado="'.$estado_receptor.'" pais="'.$pais_receptor.'" codigoPostal="'.$cp_receptor.'" />'."\r\n";
$cadena_xml      .= '</cfdi:Receptor>'."\r\n";
$cadena_xml      .= '<cfdi:Conceptos>'."\r\n";
$cadena_xml      .= $partes_xml."\r\n";
$cadena_xml      .= '</cfdi:Conceptos>'."\r\n";
$cadena_xml      .= '<cfdi:Impuestos totalImpuestosTrasladados="'.$total_iva.'">'."\r\n";
$cadena_xml      .= '<cfdi:Traslados>'."\r\n";
$cadena_xml      .=  '<cfdi:Traslado Impuesto="'.$impuesto_iva.'" TasaOCuota="'.$tasa.'" Importe="'.$total_iva.'" TipoFactor="Tasa" />'."\r\n";
$cadena_xml      .= '</cfdi:Traslados>'."\r\n";
$cadena_xml      .= '</cfdi:Impuestos>'."\r\n";
$cadena_xml      .= '</cfdi:Comprobante>';

         $ubicacion = 'xml/archivo_xml'.$nserie_folio.'.xml';
         $archivo = fopen($ubicacion, "w+");
         fwrite($archivo, $cadena_xml);

echo '<?xml version="1.0" encoding="iso-8859-1"?>'; 
echo '<resultado>'; 

echo '</resultado>';

?>