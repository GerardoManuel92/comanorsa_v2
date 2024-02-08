<?php


	header('Content-Type: application/json');
	include("config.php"); 
    include("includes/mysqli.php");
    include("includes/db.php");
    set_time_limit(600000);
    date_default_timezone_set('America/Mexico_City');

    $idfactura = trim($_POST["idfactura"]);

    $sql = "SELECT b.serie, b.folio
	FROM alta_factura_sustitucion a, folio_factura b
	WHERE a.idfolio=b.id
	AND a.id =".$idfactura;
	$buscar = $db->sql_query($sql);
	$row = $db->sql_fetchrow($buscar);

	$nserie_folio = $row['serie']."".$row['folio'];


	$doc = new DOMDocument; 
    $doc->load('factura_comprobante/'.$nserie_folio.'.xml');
    $xp = new DOMXPath($doc);
    $video = $xp->query('//cfdi:Comprobante//cfdi:Complemento')->item(0);
    $video->parentNode->removeChild($video);

    $doc->save('xml_sellado/'.$nserie_folio.'.xml');

    echo json_encode($idfactura);

?>