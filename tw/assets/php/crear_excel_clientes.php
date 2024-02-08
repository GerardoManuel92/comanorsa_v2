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



$objPHPExcel = $objReader->load("plantilla/plantilla_clientes.xlsx");

$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora

$objPHPExcel->getActiveSheet()->setTitle("CLIENTES"); //establecer titulo de hoja





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

$texto = trim($_POST["inputx"]);



//////////********************* MOSTRAR LAS PARTIDAS DE LA COTIZACION 



if(strlen($texto) > 0){

  $sql = "SELECT a.id,a.estatus,CONCAT_WS('/',a.id,a.estatus) AS acciones, a.nombre,a.comercial, a.rfc,
  
  CONCAT_WS(' ', a.calle, a.exterior, a.interior, a.colonia, a.municipio, a.estado, a.cp) AS direccion, 
  
  IFNULL( (SELECT CONCAT_WS('/',z.correo,z.telefono) 
  
  FROM contactos_erp z 
  
  WHERE z.iduser=a.id 
  
  AND z.iddepartamento= 2 LIMIT 0,1),'') AS contacto, 
  
  b.descripcion AS fpago, c.descripcion AS cfdi, a.credito, a.limite,( SELECT x.credito FROM direccion_clientes x WHERE x.idcliente=a.id ) AS creditox, ( SELECT x.limite FROM direccion_clientes x WHERE x.idcliente=a.id ) AS limitex FROM `alta_clientes` a, sat_catalogo_fpago b, sat_catalogo_cfdi c WHERE a.idfpago=b.id AND a.idcfdi=c.id

  AND a.nombre LIKE '%".$texto."%'
  
  OR a.comercial LIKE '%".$texto."%'
  
  OR a.rfc LIKE '%".$texto."%'
  
  GROUP BY(a.id)";

}else{

  $sql = "SELECT a.id,a.estatus,CONCAT_WS('/',a.id,a.estatus) AS acciones, a.nombre,a.comercial, a.rfc,
  
  CONCAT_WS(' ', a.calle, a.exterior, a.interior, a.colonia, a.municipio, a.estado, a.cp) AS direccion, 
  
  IFNULL( (SELECT CONCAT_WS('/',z.correo,z.telefono) 
  
  FROM contactos_erp z 
  
  WHERE z.iduser=a.id 
  
  AND z.iddepartamento= 2 LIMIT 0,1),'') AS contacto, 
  
  b.descripcion AS fpago, c.descripcion AS cfdi, a.credito, a.limite,( SELECT x.credito FROM direccion_clientes x WHERE x.idcliente=a.id ) AS creditox, ( SELECT x.limite FROM direccion_clientes x WHERE x.idcliente=a.id ) AS limitex FROM `alta_clientes` a, sat_catalogo_fpago b, sat_catalogo_cfdi c WHERE a.idfpago=b.id AND a.idcfdi=c.id";

}

$buscar2=$db->sql_query($sql);

$numFila = 8;



while($row2 = $db->sql_fetchrow($buscar2)){



  $idx = $row2["id"];

  $nombrex = $row2["nombre"];

  $comercialx = $row2["comercial"];

  $rfcx = $row2["rfc"];

  $fpagox = $row2["fpago"];

  $cfdix = $row2["cfdi"];

  $estatusx = $row2["estatus"];

  $direccionx = $row2["direccion"];

  $diasx = $row2["credito"];

  $limitex = $row2["limite"]; 



  if ( $estatusx == 0 ) {

    

    $vestatus = "ACTIVO";



  }else{



    $vestatus = "DECLINADO";



  }



  $objPHPExcel->getActiveSheet()->SetCellValue("B$numFila", $idx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("C$numFila", $nombrex);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "C$numFila:C$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("D$numFila", $comercialx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "D$numFila:D$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("E$numFila", $rfcx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_left, "E$numFila:E$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("F$numFila", $fpagox);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "F$numFila:F$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("G$numFila", $cfdix);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "G$numFila:G$numFila");// 



  $objPHPExcel->getActiveSheet()->SetCellValue("H$numFila", $direccionx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "H$numFila:H$numFila");// 



  $objPHPExcel->getActiveSheet()->SetCellValue("I$numFila", $diasx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "I$numFila:I$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("J$numFila", $limitex);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "J$numFila:J$numFila");//

  $objPHPExcel->getActiveSheet()->getStyle("J$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



  $objPHPExcel->getActiveSheet()->SetCellValue("K$numFila", $vestatus );

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "K$numFila:K$numFila");//  



  $numFila +=1;



}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('reporte/reporte_clientes.xlsx');

//header('Content-type: application/json');

echo json_encode("OK");