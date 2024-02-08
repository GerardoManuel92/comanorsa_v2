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



$objPHPExcel = $objReader->load("plantilla/plantilla_cotizacion.xlsx");

$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora

$objPHPExcel->getActiveSheet()->setTitle("COTIZACION"); //establecer titulo de hoja





/////////********************************************************************************************



include("config.php"); 

include("includes/mysqli.php");

include("includes/db.php");



set_include_path('includes');



//$objPHPExcel->getActiveSheet()->SetCellValue("C3", "CLIENTE DE PRUEBA");

//$objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila");//



$idcotizacion = trim($_POST["alta1"]);

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);
ini_set('log_errors', 1);



$sql = "SELECT a.fecha, b.nombre

FROM alta_cotizacion a, alta_clientes b

WHERE 

a.idcliente=b.id

AND a.id =".$idcotizacion;

$buscar = $db->sql_query($sql);

$row = $db->sql_fetchrow($buscar);



$fecha = obtenerFechaEnLetra($row["fecha"]);

$nombre = $row["nombre"];



$objPHPExcel->getActiveSheet()->SetCellValue("C3", $nombre);

$objPHPExcel->getActiveSheet()->SetCellValue("C4", $fecha);



$folio = 0;

$inicio = 10000;

$nuevo = $inicio+$idcotizacion;



switch ( strlen($nuevo) ) {



    case 5:

        

        $folio = "ODV00".$nuevo;



    break;



    case 6:

        

        $folio = "ODV0".$nuevo;



    break;



    case 7:

        

        $folio = "ODV".$nuevo;



    break;



    default:



        $folio = "s/asignar";



    break;



}



$objPHPExcel->getActiveSheet()->SetCellValue("G4", $folio);



//////////********************* MOSTRAR LAS PARTIDAS DE LA COTIZACION 



$sql2 = "SELECT a.orden, a.cantidad,  b.nparte, a.descripcion, c.abr AS unidad, a.costo_proveedor, a.utilidad, a.costo, a.iva, a.descuento, a.tcambio

FROM partes_cotizacion a, alta_productos b, sat_catalogo_unidades c

WHERE a.idparte=b.id

AND b.idunidad=c.id

AND a.idcotizacion =".$idcotizacion;

$buscar2=$db->sql_query($sql2);



$numFila = 8;



while($row2 = $db->sql_fetchrow($buscar2)){



  $orden = $row2["orden"];

  $cantidad = $row2["cantidad"];

  $nparte = $row2["nparte"];

  $descripcion = $row2["descripcion"];

  $unidad = $row2["unidad"];

  $costo_proveedor = $row2["costo_proveedor"];

  $utilidad = $row2["utilidad"];

  $costo = $row2["costo"];

  $iva = $row2["iva"];

  $descuento = $row2["descuento"];

  $tcambio = $row2["tcambio"];

  $subtotal = $costo*$cantidad;



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