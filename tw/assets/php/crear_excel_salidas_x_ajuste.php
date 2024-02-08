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



$objPHPExcel = $objReader->load("plantilla/plantilla_salidas_x_ajuste.xlsx");

$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora

$objPHPExcel->getActiveSheet()->setTitle("SALIDAS_POR_AJUSTE"); //establecer titulo de hoja





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

$usuario = $_POST["usuariox"];

$statusx = $_POST["statusx"];

$fecha = obtenerFechaEnLetra(date("d-m-Y h:i:s"));

$sql = "SELECT nombre FROM alta_usuarios WHERE id='" . $usuario . "'";

$buscar = $db->sql_query($sql);

switch ($statusx) {

  case 0:
    $vstatus = "ACTIVA";
    break;
  case 1:
    $vstatus = "CANCELADA";
    break;
}

if ($usuario == 0 && $statusx == 2) {

  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

  $objPHPExcel->getActiveSheet()->SetCellValue("C4", "TODOS");

  $objPHPExcel->getActiveSheet()->SetCellValue("C5", "TODOS");
} else if ($usuario == 0 && $statusx != 2) {


  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

  $objPHPExcel->getActiveSheet()->SetCellValue("C4", $vstatus);

  $objPHPExcel->getActiveSheet()->SetCellValue("C5", "TODOS");
} else if ($usuario > 0 && $statusx == 2) {

  while ($row = $db->sql_fetchrow($buscar)) {

    $prov = $row['nombre'];

    $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

    $objPHPExcel->getActiveSheet()->SetCellValue("C4", "TODOS");

    $objPHPExcel->getActiveSheet()->SetCellValue("C5", $prov);
  }
} else if ($usuario > 0 && $statusx != 2) {

  while ($row = $db->sql_fetchrow($buscar)) {

    $prov = $row['nombre'];

    $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

    $objPHPExcel->getActiveSheet()->SetCellValue("C4", $vstatus);

    $objPHPExcel->getActiveSheet()->SetCellValue("C5", $prov);
  }
}







//////////********************* MOSTRAR LAS PARTIDAS DE LA COTIZACION 



if ($usuario == 0 && $statusx == 2) {

  $sql2 = "SELECT a.id,a.fecha,a.total,b.nombre AS almacenista, CONCAT_WS('/',a.id,a.estatus) AS acciones, a.estatus, a.observaciones as motivo, a.documento
  
  FROM alta_ajuste_salida a, alta_usuarios b, partes_ajuste_salida d
  
  WHERE a.idusuario=b.id AND d.idajuste = a.id   
  
  GROUP BY a.id";
}
if ($usuario > 0 && $statusx == 2) {

  $sql2 = "SELECT a.id,a.fecha,a.total,b.nombre AS almacenista, CONCAT_WS('/',a.id,a.estatus) AS acciones, a.estatus, a.observaciones as motivo, a.documento
  
  FROM alta_ajuste_salida a, alta_usuarios b, partes_ajuste_salida d
  
  WHERE a.idusuario=b.id AND d.idajuste = a.id

  AND a.idusuario='" . $usuario . "'  
  
  GROUP BY a.id";
} else if ($usuario == 0 && $statusx != 2) {

  $sql2 = "SELECT a.id,a.fecha,a.total,b.nombre AS almacenista, CONCAT_WS('/',a.id,a.estatus) AS acciones, a.estatus, a.observaciones as motivo, a.documento
  
  FROM alta_ajuste_salida a, alta_usuarios b, partes_ajuste_salida d
  
  WHERE a.idusuario=b.id AND d.idajuste = a.id  
  
  AND a.estatus='" . $statusx . "' 
  
  GROUP BY a.id";
} else if ($usuario > 0 && $statusx != 2) {

  $sql2 = "SELECT a.id,a.fecha,a.total,b.nombre AS almacenista, CONCAT_WS('/',a.id,a.estatus) AS acciones, a.estatus, a.observaciones as motivo, a.documento
  
  FROM alta_ajuste_salida a, alta_usuarios b, partes_ajuste_salida d
  
  WHERE a.idusuario=b.id AND d.idajuste = a.id 

  AND a.idusuario='" . $usuario . "' 
  
  AND a.estatus='" . $statusx . "' 
  
  GROUP BY a.id";
}

$buscar2 = $db->sql_query($sql2);

$numFila = 9;

$partida = 1;



while ($row2 = $db->sql_fetchrow($buscar2)) {



  $foliox = $row2["id"];

  $fechax = $row2["fecha"];

  $motivox = $row2["motivo"];

  $almacenistax = $row2["almacenista"];

  $proveedorx = $row2["proveedor"];

  $totalx = $row2["total"];

  $estatusx = $row2["estatus"];


  if ($estatusx == 0) {



    $vestatusy = "ACTIVO";
  } else {



    $vestatusy = "DECLINADA";
  }



  $objPHPExcel->getActiveSheet()->SetCellValue("B$numFila", $partida);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("C$numFila", $fechax);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "C$numFila:C$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("D$numFila", $foliox);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "D$numFila:D$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("E$numFila", $motivox);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_left, "E$numFila:E$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("F$numFila", $almacenistax);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "F$numFila:F$numFila"); // 



  $objPHPExcel->getActiveSheet()->SetCellValue("G$numFila", $totalx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "G$numFila:G$numFila"); // 

  $objPHPExcel->getActiveSheet()->getStyle("G$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



  $objPHPExcel->getActiveSheet()->SetCellValue("H$numFila", $vestatusy);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "H$numFila:H$numFila"); //  



  $numFila += 1;

  $partida += 1;
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('reporte/reporte_salidas_x_ajuste.xlsx');

//header('Content-type: application/json');

echo json_encode("OK");
