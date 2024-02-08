<?php
/**
 * Trabajando con archivos ZIP en PHP
 * Ejemplo 2: simple creación de archivo zip
 * con un poco de contenido, para mandarlo
 * para su descarga
 *
 * @author parzibyte
 */

$folio = trim($_POST["folio"]);

$zip = new ZipArchive();
// Ruta absoluta
$nombreArchivoZip = "zip_facturas_nc/".$folio.".zip";

if (!$zip->open($nombreArchivoZip, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
    exit("Error abriendo ZIP en $nombreArchivoZip");
}
// Si no hubo problemas, continuamos
// Agregamos el script.js
// Su ruta absoluta, como D:\documentos\codigo\script.js
$rutaAbsoluta ="factura_comprobante_nc/".$folio.".xml";
$pdf = "facturas_nc/".$folio.".pdf";
// Su nombre resumido, algo como "script.js"
$nombre = basename($rutaAbsoluta);
$zip->addFile($rutaAbsoluta, $nombre);

$nombre2 = basename($pdf);
$zip->addFile($pdf, $nombre2);

// No olvides cerrar el archivo
$resultado = $zip->close();
/*if (!$resultado) {
    exit("Error creando archivo");
}*/

// Ahora que ya tenemos el archivo lo enviamos como respuesta
// para su descarga

// El nombre con el que se descarga
/*$nombreAmigable = "simple.zip";
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=$nombreAmigable");*/

// Leer el contenido binario del zip y enviarlo
//readfile($nombreArchivoZip);

// Si quieres puedes eliminarlo después:
//unlink($nombreArchivoZip);

echo json_encode(true);


?>