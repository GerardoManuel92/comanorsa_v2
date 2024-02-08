<?php
/* 
KIT DE INTEGRACION PHP para CFID 3.3
versión 1.0
Integración de Timbrado de CFDI
Licencia: MIT - https://opensource.org/licenses/MIT
Profact - La forma más simple de facturar
*/
/* Ruta del servicio de integracion*/

$ws = "https://cfdi33-pruebas.buzoncfdi.mx:1443/Timbrado.asmx?wsdl";/*<- Esta ruta es para el servicio de pruebas, para pasar a productivo cambiar por https://timbracfdi33.mx:1443/Timbrado.asmx*/
$response = '';
$workspace="";/*<- Configurar la ruta en donde se encuentra nuestro kit de integración para localizar correctamente el archivo Ejemplo_cfdi_3.3.xml*/
/* Ruta del comprobante a timbrar*/
$rutaArchivo = "xml_erp.xml";
/* El servicio recibe el comprobante (xml) codificado en Base64, el rfc del emisor deberá ser 'AAA010101AAA' para efecto de pruebas*/ 
$base64Comprobante = file_get_contents($rutaArchivo);
$base64Comprobante = base64_encode($base64Comprobante);
try
{
$params = array();
/*Nombre del usuario integrador asignado, para efecto de pruebas utilizaremos 'mvpNUXmQfK8=' <- Este usuario es para el servicio de pruebas, para pasar a productivo cambiar por el que le asignarán posteriormente*/
$params['usuarioIntegrador'] = 'mvpNUXmQfK8=';
/* Comprobante en base 64*/
$params['xmlComprobanteBase64'] = $base64Comprobante;
/*Id del comprobante, deberá ser un identificador único, para efecto del ejemplo se utilizará un numero aleatorio*/
$params['idComprobante'] = rand(5, 999999);

$context = stream_context_create(array(
    'ssl' => array(
        // set some SSL/TLS specific options
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => false
    ),
	'http' => array(
            'user_agent' => 'PHPSoapClient'
            )
 ) );
$options =array();
$options['stream_context'] = $context;
$options['cache_wsdl']= WSDL_CACHE_MEMORY;
$options['trace']= true;

libxml_disable_entity_loader(false);
echo "SoapClient";

$client = new SoapClient($ws,$options);
echo "__soapCall";
$response = $client->__soapCall('TimbraCFDI', array('parameters' => $params));

}
catch (SoapFault $fault)
{
	echo "SOAPFault: ".$fault->faultcode."-".$fault->faultstring."\n";
}
/*Obtenemos resultado del response*/
echo "resultado";
//echo $response;
$tipoExcepcion = $response->TimbraCFDIResult->anyType[0];
$numeroExcepcion = $response->TimbraCFDIResult->anyType[1];
$descripcionResultado = $response->TimbraCFDIResult->anyType[2];
$xmlTimbrado = $response->TimbraCFDIResult->anyType[3];
$codigoQr = $response->TimbraCFDIResult->anyType[4];
$cadenaOriginal = $response->TimbraCFDIResult->anyType[5];
$errorInterno = $response->TimbraCFDIResult->anyType[6];
$mensajeInterno = $response->TimbraCFDIResult->anyType[7];
$detalleError = $response->TimbraCFDIResult->anyType[8];

if($xmlTimbrado != '')
{
	echo "xmlTimbrado";
/*El comprobante fue timbrado correctamente*/

/*Guardamos comprobante timbrado*/
file_put_contents('comprobanteTimbrado.xml', $xmlTimbrado);

/*Guardamos codigo qr*/
file_put_contents('codigoQr.jpg', $codigoQr);

/*Guardamos cadena original del complemento de certificacion del SAT*/
file_put_contents('cadenaOriginal.txt', $cadenaOriginal);

print_r("Timbrado exitoso");

}
else
{
	echo "else";
	echo "[".$tipoExcepcion."  ".$numeroExcepcion." ".$descripcionResultado."  ei=".$errorInterno." mi=".$mensajeInterno."]" ;
}
?>


