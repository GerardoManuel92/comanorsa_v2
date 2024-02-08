<?php

set_time_limit(600000);

//ajuntar la libreria excel

include "libreria_excel/PHPExcel.php";

include 'libreria_excel/PHPExcel/IOFactory.php';

include("libreria_excel/funciones.php");

date_default_timezone_set("America/Mexico_City");





$objPHPExcel = new PHPExcel();

$objReader = PHPExcel_IOFactory::createReader('Excel2007');





$titulo = new PHPExcel_Style(); //nuevo estilo

$titulo->applyFromArray(

  array(
    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 14

    )

  )
);

$titulo1 = new PHPExcel_Style(); //nuevo estilo

$titulo1->applyFromArray(

  array(
    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10

    ),

    'fill' => array( //relleno de color

      'type' => PHPExcel_Style_Fill::FILL_SOLID,

      'color' => array('argb' => '920D0B')

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 14,

      'color' => array('argb' => 'FFFFFF')

    )

  )
);



$titulo2 = new PHPExcel_Style(); //nuevo estilo

$titulo2->applyFromArray(

  array(
    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10

    ),

    'fill' => array( //relleno de color

      'type' => PHPExcel_Style_Fill::FILL_SOLID,

      'color' => array('argb' => '333300')

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10,

      'color' => array('argb' => 'FFFFFF')

    )

  )
);



$titulo3 = new PHPExcel_Style(); //nuevo estilo

$titulo3->applyFromArray(

  array(
    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10

    ),

    'fill' => array( //relleno de color

      'type' => PHPExcel_Style_Fill::FILL_SOLID,

      'color' => array('argb' => '660066')

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10,

      'color' => array('argb' => 'FFFFFF')

    )

  )
);



$titulo4 = new PHPExcel_Style(); //nuevo estilo

$titulo4->applyFromArray(

  array(
    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10

    ),

    'fill' => array( //relleno de color

      'type' => PHPExcel_Style_Fill::FILL_SOLID,

      'color' => array('argb' => '990000')

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10,

      'color' => array('argb' => 'FFFFFF')

    )

  )
);



$titulo5 = new PHPExcel_Style(); //nuevo estilo

$titulo5->applyFromArray(

  array(
    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10

    ),

    'fill' => array( //relleno de color

      'type' => PHPExcel_Style_Fill::FILL_SOLID,

      'color' => array('argb' => '331900')

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10,

      'color' => array('argb' => 'FFFFFF')

    )

  )
);



$titulo6 = new PHPExcel_Style(); //nuevo estilo

$titulo6->applyFromArray(

  array(
    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10

    ),

    'fill' => array( //relleno de color

      'type' => PHPExcel_Style_Fill::FILL_SOLID,

      'color' => array('argb' => '333300')

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10,

      'color' => array('argb' => 'FFFFFF')

    )

  )
);



$titulo7 = new PHPExcel_Style(); //nuevo estilo

$titulo7->applyFromArray(

  array(
    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10

    ),

    'fill' => array( //relleno de color

      'type' => PHPExcel_Style_Fill::FILL_SOLID,

      'color' => array('argb' => '006666')

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10,

      'color' => array('argb' => 'FFFFFF')

    )

  )
);



$titulo8 = new PHPExcel_Style(); //nuevo estilo

$titulo8->applyFromArray(

  array(
    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10

    ),

    'fill' => array( //relleno de color

      'type' => PHPExcel_Style_Fill::FILL_SOLID,

      'color' => array('argb' => 'FF9933')

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10,

      'color' => array('argb' => 'CC0000')

    )

  )
);

$tituloFIN = new PHPExcel_Style(); //nuevo estilo

$tituloFIN->applyFromArray(

  array(
    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

    ),

    'borders' => array( //bordes

      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10

    ),

    'fill' => array( //relleno de color

      'type' => PHPExcel_Style_Fill::FILL_SOLID,

      'color' => array('argb' => 'F7E00B')

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10,

      'color' => array('argb' => '000000')

    )

  )
);

$titulo9 = new PHPExcel_Style(); //nuevo estilo

$titulo9->applyFromArray(

  array(
    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

    ),

    'borders' => array( //bordes

      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10

    ),

    'fill' => array( //relleno de color

      'type' => PHPExcel_Style_Fill::FILL_SOLID,

      'color' => array('argb' => 'FF66FF')

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10,

      'color' => array('argb' => '000000')

    )

  )
);



$subtitulo = new PHPExcel_Style(); //nuevo estilo



$subtitulo->applyFromArray(

  array(
    'fill' => array( //relleno de color

      'type' => PHPExcel_Style_Fill::FILL_SOLID,

      'color' => array('argb' => '808080')

    ),

    'borders' => array( //bordes

      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)

    ),

    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 10,

      'color' => array('argb' => 'FFFFFF')

    )

  )
);

$datos = new PHPExcel_Style(); //nuevo estilo

$datos->applyFromArray(

  array(
    'borders' => array( //bordes

      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)

    ),

    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

    )

  )
);



$datos2 = new PHPExcel_Style(); //nuevo estilo

$datos2->applyFromArray(

  array(
    'borders' => array( //bordes

      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)

    ),

    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 14,

      'color' => array('argb' => '000000')

    )

  )
);



$datos_right = new PHPExcel_Style(); //nuevo estilo

$datos_right->applyFromArray(

  array(
    'borders' => array( //bordes

      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)

    ),

    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT

    )



  )
);



$datos_left = new PHPExcel_Style(); //nuevo estilo

$datos_left->applyFromArray(

  array(
    'borders' => array( //bordes

      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)

    ),

    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT

    )



  )
);



$bordes = new PHPExcel_Style(); //nuevo estilo



$bordes->applyFromArray(

  array(
    'borders' => array(

      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)

    )

  )
);







//****************************************************  FIN DE ESTILOS**********************



$objPHPExcel = $objReader->load("plantilla/plantilla_proveedor_individual.xlsx");

$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora

$objPHPExcel->getActiveSheet()->setTitle("DATOS GENERALES"); //establecer titulo de hoja





/////////********************************************************************************************



include("config.php");

include("includes/mysqli.php");

include("includes/db.php");



set_include_path('includes');



//$objPHPExcel->getActiveSheet()->SetCellValue("C3", "CLIENTE DE PRUEBA");

//$objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila");//


error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

$fecha = obtenerFechaEnLetra(date("d-m-Y h:i:s"));

$objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

$proveedor = $_POST["idprovx"];



if ($proveedor > 0) {

  $sql = "SELECT a.id,a.nombre,a.comercial,a.rfc,b.descripcion AS fpago, c.descripcion AS cfdi, a.estatus, CONCAT_WS(' ', a.calle, a.exterior, a.interior, a.colonia, a.municipio, a.estado, a.cp) AS direccion, CONCAT_WS('/',a.id,a.estatus) AS acciones, a.dias, a.limite

  FROM alta_proveedores a, sat_catalogo_fpago b, sat_catalogo_cfdi c

  WHERE 

  a.idfpago=b.id

  AND a.idcfdi=c.id
  
  AND a.id = '".$proveedor."'";

  $buscar = $db->sql_query($sql);

  while ($row = $db->sql_fetchrow($buscar)) {

    $idprox = $row["id"];

    $nombre_proveedorx = $row["nombre"];

    $direccion = $row["direccion"];

    $rfc = $row["rfc"];

    $fpago = $row["fpago"];

    $cfdi = $row["cfdi"];

    $credito = $row["dias"];

    $limite = $row["limite"];

    $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

    $objPHPExcel->getActiveSheet()->SetCellValue("C4", $idprox . '.- ' . $nombre_proveedorx);

    $objPHPExcel->getActiveSheet()->SetCellValue("C5", $direccion);

    $objPHPExcel->getActiveSheet()->SetCellValue("C6", $rfc);

    $objPHPExcel->getActiveSheet()->SetCellValue("C7", $fpago);

    $objPHPExcel->getActiveSheet()->SetCellValue("C8", $cfdi);

    $objPHPExcel->getActiveSheet()->SetCellValue("C9", $credito);

    $objPHPExcel->getActiveSheet()->SetCellValue("C10", $limite);

  }
}

//////////********************* MOSTRAR CONTACTOS DEL PROVEEDOR 

$sql2 = "SELECT a.nombre AS contacto, b.dias,b.limite,a.puesto, a.telefono, a.correo, b.nombre, b.calle, b.exterior, b.interior, b.colonia, b.municipio, b.estado, b.cp, b.referencia 

          FROM contactos_erp a, alta_proveedores b

          WHERE

          a.iduser=b.id

          AND a.iddepartamento = 1

          AND b.id= '" . $proveedor . "'";



$buscar2 = $db->sql_query($sql2);

$numFila = 15;

$partida = 1; 

while ($row2 = $db->sql_fetchrow($buscar2)) {

   

  $contactox = $row2["contacto"];

  $puestox = $row2["puesto"];

  $telefonox = $row2["telefono"]; 

  $correox = $row2["correo"];
 



  $objPHPExcel->getActiveSheet()->SetCellValue("B$numFila", $partida);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("C$numFila", $contactox);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "C$numFila:C$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("D$numFila", $puestox);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "D$numFila:D$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("E$numFila", $telefonox);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_left, "E$numFila:E$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("F$numFila", $correox);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "F$numFila:F$numFila"); //



  $numFila += 1;

  $partida += 1;
}

//////////********************* MOSTRAR CUENTAS BANCARIAS DEL PROVEEDOR

$sql3 = "SELECT aProv.id, aProv.cuenta, bancos.rfc, bancos.comercial
          
          FROM alta_cuentas_proveedor aProv, alta_bancos bancos
          
          WHERE aProv.idbanco = bancos.id
          
          AND aProv.idproveedor='".$proveedor."' 
          
          AND aProv.estatus=1";



$buscar3 = $db->sql_query($sql3);

$numFila = 15;

$partida = 1; 

while ($row3 = $db->sql_fetchrow($buscar3)) {

   

  $cuentax = $row3["cuenta"];

  $rfcx = $row3["rfc"];

  $comercialx = $row3["comercial"];  



  $objPHPExcel->getActiveSheet()->SetCellValue("I$numFila", $partida);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "I$numFila:I$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("J$numFila", $cuentax);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "J$numFila:J$numFila"); //

  // Obtener el objeto de estilo para la celda
  $style = $objPHPExcel->getActiveSheet()->getStyle("J$numFila");

  // Establecer el formato numérico para evitar la notación exponencial
  $style->getNumberFormat()->setFormatCode('0');



  $objPHPExcel->getActiveSheet()->SetCellValue("K$numFila", $rfcx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "K$numFila:K$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("L$numFila", $comercialx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_left, "L$numFila:L$numFila"); //



  $numFila += 1;

  $partida += 1;
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('reporte/PROVEEDORES/' . $proveedor . '.- '. $nombre_proveedorx .'.xlsx');

// Para crear siguiente hoja
$hoja2 = $spreadsheet->createSheet();

// Generale el nombre de hoja para que confirmes que tienes la hoja creada
$hoja2->setTitle('Cuenta Bancaria');

//header('Content-type: application/json');

echo json_encode("OK");


