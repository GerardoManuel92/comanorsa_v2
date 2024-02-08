<?php

set_time_limit (600000);

//ajuntar la libreria excel

include "libreria_excel/PHPExcel.php";

include 'libreria_excel/PHPExcel/IOFactory.php';

include ("libreria_excel/funciones.php");

date_default_timezone_set("America/Mexico_City");





$objPHPExcel = new PHPExcel();

$objReader = PHPExcel_IOFactory::createReader('Excel2007');





$titulo = new PHPExcel_Style(); //nuevo estilo

$titulo->applyFromArray(

  array('alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

    ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 14

    )

));

$titulo1 = new PHPExcel_Style(); //nuevo estilo

$titulo1->applyFromArray(

  array('alignment' => array( //alineacion

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

));



$titulo2 = new PHPExcel_Style(); //nuevo estilo

$titulo2->applyFromArray(

  array('alignment' => array( //alineacion

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

));



$titulo3 = new PHPExcel_Style(); //nuevo estilo

$titulo3->applyFromArray(

  array('alignment' => array( //alineacion

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

));



$titulo4 = new PHPExcel_Style(); //nuevo estilo

$titulo4->applyFromArray(

  array('alignment' => array( //alineacion

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

));



$titulo5 = new PHPExcel_Style(); //nuevo estilo

$titulo5->applyFromArray(

  array('alignment' => array( //alineacion

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

));



$titulo6 = new PHPExcel_Style(); //nuevo estilo

$titulo6->applyFromArray(

  array('alignment' => array( //alineacion

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

));



$titulo7 = new PHPExcel_Style(); //nuevo estilo

$titulo7->applyFromArray(

  array('alignment' => array( //alineacion

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

));



$titulo8 = new PHPExcel_Style(); //nuevo estilo

$titulo8->applyFromArray(

  array('alignment' => array( //alineacion

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

));

$tituloFIN = new PHPExcel_Style(); //nuevo estilo

$tituloFIN->applyFromArray(

  array('alignment' => array( //alineacion

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

));

$titulo9 = new PHPExcel_Style(); //nuevo estilo

$titulo9->applyFromArray(

  array('alignment' => array( //alineacion

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

));



$subtitulo = new PHPExcel_Style(); //nuevo estilo



$subtitulo->applyFromArray(

  array('fill' => array( //relleno de color

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

));

$datos = new PHPExcel_Style(); //nuevo estilo

$datos->applyFromArray(

  array('borders' => array( //bordes

      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)

    ),

    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER

    )

));



$datos2 = new PHPExcel_Style(); //nuevo estilo

$datos2->applyFromArray(

  array('borders' => array( //bordes

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

));



$datos_right = new PHPExcel_Style(); //nuevo estilo

$datos_right->applyFromArray(

  array('borders' => array( //bordes

      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)

    ),

    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT

    )

    

));



$datos_left = new PHPExcel_Style(); //nuevo estilo

$datos_left->applyFromArray(

  array('borders' => array( //bordes

      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)

    ),

    'alignment' => array( //alineacion

      'wrap' => false,

      'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT

    )

    

));



$bordes = new PHPExcel_Style(); //nuevo estilo



$bordes->applyFromArray(

  array('borders' => array(

      'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'right' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN),

      'left' => array('style' => PHPExcel_Style_Border::BORDER_THIN)

    )

));







//****************************************************  FIN DE ESTILOS**********************



$objPHPExcel = $objReader->load("plantilla/plantilla_estado_de_cuenta.xlsx");

$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora

$objPHPExcel->getActiveSheet()->setTitle("Estado de cuenta"); //establecer titulo de hoja





/////////********************************************************************************************



include("config.php"); 

include("includes/mysqli.php");

include("includes/db.php");



set_include_path('includes');


//////////********************* MOSTRAR LAS PARTIDAS DE LA COTIZACION 


$sql2 = 'SELECT CASE a.estatus WHEN 0 THEN "ACTIVO" WHEN 1 THEN "APLICADO" END AS estx, a.fecha, a.fecha_banco, a.hora_banco, a.movimiento, a.descripcion, CASE a.tipo  WHEN 1 THEN "CARGO" WHEN 2 THEN "ABONO" END AS tipox,IFNULL(b.banco,"") AS bancox,IFNULL(b.cuenta,"") AS cuentax,IFNULL(c.nombre,"") AS cliente
FROM saldo_bancos a 
LEFT JOIN cuentas_bancariasxcliente b ON a.idcuenta=b.id
LEFT JOIN alta_clientes c ON b.idcliente=c.id';

$buscar2=$db->sql_query($sql2);



$numFila = 8;



while($row2 = $db->sql_fetchrow($buscar2)){



  $estx = $row2["estx"];

  $fecha = $row2["fecha"];

  $fecha_banco = $row2["fecha_banco"];

  $hora_banco = $row2["hora_banco"];

  $movimiento = $row2["movimiento"];

  $descripcion = $row2["descripcion"];

  $tipox = $row2["tipox"];

  $bancox = $row2["bancox"];

  $cuentax = $row2["cuentax"];

  $cliente = $row2["cliente"];



  if ( $utilidad == 0.00 ) {

    

    $vutilidad = ( ( $costo/($costo_proveedor*$tcambio) )-1 )*100;



  }else if ( $utilidad > 0 ) {

    

    $vutilidad = $utilidad;



  }else{



    $vutilidad = 0;



  }



  $objPHPExcel->getActiveSheet()->SetCellValue("B$numFila", $orden);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("C$numFila", $cantidad);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "C$numFila:C$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("D$numFila", $nparte);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "D$numFila:D$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("E$numFila", $descripcion);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_left, "E$numFila:E$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("F$numFila", $unidad);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "F$numFila:F$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("G$numFila", $costo_proveedor);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "G$numFila:G$numFila");//



  $objPHPExcel->getActiveSheet()->getStyle("G$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



  $objPHPExcel->getActiveSheet()->SetCellValue("H$numFila", $costo);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "H$numFila:H$numFila");//



  $objPHPExcel->getActiveSheet()->getStyle("H$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



  $objPHPExcel->getActiveSheet()->SetCellValue("I$numFila", $iva);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "I$numFila:I$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("J$numFila", $descuento);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "J$numFila:J$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("K$numFila", round($vutilidad,2) );

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "K$numFila:K$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("L$numFila", $tcambio);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "L$numFila:L$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("M$numFila", $subtotal);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "M$numFila:M$numFila");//



  $objPHPExcel->getActiveSheet()->getStyle("M$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



  $numFila +=1;



}



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('reporte/cotizacion_'.$folio.'.xlsx');

//header('Content-type: application/json');

echo json_encode("OK");