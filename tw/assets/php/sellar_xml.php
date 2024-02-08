<?php





    //ruta al archivo XML del CFDI

    $xmlFile="xml/archivo_xml1711.xml";

 

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

 

    echo $cadenaOriginal."<br><br>";

    /*'||4.0|APSF|F1F2|2022-03-05T12:05:34|99|30001000000400002434|80000.00|MXN|1|92800.00|I|01|PPD|62070|01|12|2021|EKU9003173C9|ESCUELA KEMPER URGATE SA DE CV|601|XAXX010101000|PUBLICO EN GENERAL|62070|616|G01|10191508|34006|1.00|ACT|QUIMICA CLINICA|80000.00|80000.00|02|80000.00|002|Tasa|0.160000|12800.00|80000.00|002|Tasa|0.160000|12800.00|12800.00||';



    '||4.0|a|492|2022-02-06T15:46:10|03|30001000000400002434|CondicionesDePago|2250376.00|0|MXN|1|1417936.16|I|01|PUE|20000|EKU9003173C9|ESCUELA KEMPER URGATE SA DE CV|601|MOCJ901005BR6|JAVIER ALEJANDRO MONZON CORTES|57140|612|G01|31201610|21GCH|100.00|XPK|pq|LAPIZ ADHESIVO 21G1 PIEZA|3.76|376|0|02|376|002|Tasa|0.160000|60.16|01010101|00001|1.5|F52|TONELADA|ACERO|1500000|2250000|02|2250000|002|Tasa|0.160000|360000|2250000|003|Tasa|0.530000|1192500|51888|003|1192500|1192500|2250376|002|Tasa|0.160000|360060.16|360060.16||'*/



///////*********************************



//Sellar

//$fileKey = Principal::$AppPath . "docs/sat/ACO560518KW7-20001000000300005692.key.pem"; // Ruta al archivo key



$private = openssl_pkey_get_private(file_get_contents("pkcomanorsa.pem"));

$sig = "";

openssl_sign($cadenaOriginal, $sig, $private, OPENSSL_ALGO_SHA256);

$sello = base64_encode($sig);

//$this->Comprobante->Sello = $sello;



echo $sello;



?>