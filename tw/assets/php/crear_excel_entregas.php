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



$objPHPExcel = $objReader->load("plantilla/plantilla_entregas.xlsx");

$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora

$objPHPExcel->getActiveSheet()->setTitle("ENTREGAS"); //establecer titulo de hoja





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

$texto = trim($_POST["inputx"]);

<<<<<<< HEAD
$estatus = $_POST["statusx"];

$fecha = obtenerFechaEnLetra(date("d-m-Y h:i:s"));

switch ($estatus) {

  case 0:
    $vstatus = "ACTIVA";
    break;
  case 1:
    $vstatus = "CANCELADA";
    break;
}

if (strlen($texto) == 0 && $estatus == 2) {

  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

  $objPHPExcel->getActiveSheet()->SetCellValue("C4", "TODOS");

  $objPHPExcel->getActiveSheet()->SetCellValue("E5", "TODOS");

}else if (strlen($texto) == 0 && $estatus != 2) {

  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

  $objPHPExcel->getActiveSheet()->SetCellValue("C4", $vstatus);

  $objPHPExcel->getActiveSheet()->SetCellValue("E5", "TODOS");

}else if (strlen($texto) > 0 && $estatus == 2) {

  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

  $objPHPExcel->getActiveSheet()->SetCellValue("C4", "TODOS");

  $objPHPExcel->getActiveSheet()->SetCellValue("E5", $texto);

} else if (strlen($texto) > 0 && $estatus != 2){

  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

  $objPHPExcel->getActiveSheet()->SetCellValue("C4", $vstatus);

  $objPHPExcel->getActiveSheet()->SetCellValue("E5", $texto);
=======
$fecha = obtenerFechaEnLetra(date("d-m-Y h:i:s"));

if (strlen($texto) > 0) {

  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

  $objPHPExcel->getActiveSheet()->SetCellValue("E4", $texto);

} else {

  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

  $objPHPExcel->getActiveSheet()->SetCellValue("E4", "TODOS");
>>>>>>> ca63c84eed77a5e94e01248e21a910616fd27e73
  
}





//////////********************* MOSTRAR LAS PARTIDAS DE LA COTIZACION 



<<<<<<< HEAD
if (strlen($texto) == 0 && $estatus == 2){
=======
if (strlen($texto) > 0) {

  $sql2 = "SELECT a.id, a.estatus, a.fecha, CONCAT_WS('',b.serie,b.folio) AS folio, a.idfactura AS factura, d.nombre AS cliente, e.nombre AS entrego, a.recibio AS recibio, a.observaciones,CONCAT_WS('/',a.id,a.estatus) AS acciones 
              
  FROM alta_entrega a, folio_factura b, alta_factura af, alta_clientes d, alta_usuarios e 

  WHERE a.idfactura=af.id 

  AND af.idfolio=b.id 

  AND af.idcliente=d.id 

  AND a.idusuario=e.id

  AND CONCAT_WS(a.idfactura,b.serie, b.folio ,d.nombre,e.nombre) LIKE '%" . $texto . "%'";
} else {
>>>>>>> ca63c84eed77a5e94e01248e21a910616fd27e73

  $sql2 = "SELECT a.id, a.estatus, a.fecha, CONCAT_WS('',b.serie,b.folio) AS folio, a.idfactura AS factura, d.nombre AS cliente, e.nombre AS entrego, a.recibio AS recibio, a.observaciones,CONCAT_WS('/',a.id,a.estatus) AS acciones 
              
  FROM alta_entrega a, folio_factura b, alta_factura af, alta_clientes d, alta_usuarios e 

  WHERE a.idfactura=af.id 

  AND af.idfolio=b.id 

  AND af.idcliente=d.id 

  AND a.idusuario=e.id";
<<<<<<< HEAD

}else if (strlen($texto) == 0 && $estatus != 2) {

  $sql2 = "SELECT a.id, a.estatus, a.fecha, CONCAT_WS('',b.serie,b.folio) AS folio, a.idfactura AS factura, d.nombre AS cliente, e.nombre AS entrego, a.recibio AS recibio, a.observaciones,CONCAT_WS('/',a.id,a.estatus) AS acciones 
              
  FROM alta_entrega a, folio_factura b, alta_factura af, alta_clientes d, alta_usuarios e 

  WHERE a.idfactura=af.id 

  AND af.idfolio=b.id 

  AND af.idcliente=d.id 

  AND a.idusuario=e.id

  AND a.estatus= '" . $estatus . "'";

} else if (strlen($texto) > 0 && $estatus == 2){

  $sql2 = "SELECT a.id, a.estatus, a.fecha, CONCAT_WS('',b.serie,b.folio) AS folio, a.idfactura AS factura, d.nombre AS cliente, e.nombre AS entrego, a.recibio AS recibio, a.observaciones,CONCAT_WS('/',a.id,a.estatus) AS acciones 
              
  FROM alta_entrega a, folio_factura b, alta_factura af, alta_clientes d, alta_usuarios e 

  WHERE a.idfactura=af.id 

  AND af.idfolio=b.id 

  AND af.idcliente=d.id 

  AND a.idusuario=e.id
  
  AND CONCAT_WS(a.idfactura,b.serie, b.folio ,d.nombre,e.nombre) LIKE '%" . $texto . "%'";

}else if (strlen($texto) > 0 && $estatus != 2){

  $sql2 = "SELECT a.id, a.estatus, a.fecha, CONCAT_WS('',b.serie,b.folio) AS folio, a.idfactura AS factura, d.nombre AS cliente, e.nombre AS entrego, a.recibio AS recibio, a.observaciones,CONCAT_WS('/',a.id,a.estatus) AS acciones 
              
  FROM alta_entrega a, folio_factura b, alta_factura af, alta_clientes d, alta_usuarios e 

  WHERE a.idfactura=af.id 

  AND af.idfolio=b.id 

  AND af.idcliente=d.id 

  AND a.idusuario=e.id

  AND a.estatus= '" . $estatus . "'

  AND CONCAT_WS(a.idfactura,b.serie, b.folio ,d.nombre,e.nombre) LIKE '%" . $texto . "%'";

=======
>>>>>>> ca63c84eed77a5e94e01248e21a910616fd27e73
}

$buscar2 = $db->sql_query($sql2);

<<<<<<< HEAD
$numFila = 9;
=======
$numFila = 8;
>>>>>>> ca63c84eed77a5e94e01248e21a910616fd27e73

$partida = 1;



while ($row2 = $db->sql_fetchrow($buscar2)) {



  $idx = $row2["id"];

  $fechax = $row2["fecha"];

  $foliox = $row2["folio"];

  $facturax = $row2["factura"];

  $clientex = $row2["cliente"];

  $entregox = $row2["entrego"];

  $recibiox = $row2["recibio"];

  $observacionx = $row2["observaciones"];

  $estatusx = $row2["estatus"];


  if ($estatusx == 0) {



    $vestatusy = "ACTIVO";
  } else {



    $vestatusy = "DECLINADO";
  }



  $objPHPExcel->getActiveSheet()->SetCellValue("B$numFila", $partida);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("C$numFila", $fechax);

<<<<<<< HEAD
  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "C$numFila:C$numFila"); //
=======
  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "C$numFila:C$numFila"); //
>>>>>>> ca63c84eed77a5e94e01248e21a910616fd27e73



  $objPHPExcel->getActiveSheet()->SetCellValue("D$numFila", $foliox);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "D$numFila:D$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("E$numFila", $facturax);

<<<<<<< HEAD
  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "E$numFila:E$numFila"); //
=======
  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_left, "E$numFila:E$numFila"); //
>>>>>>> ca63c84eed77a5e94e01248e21a910616fd27e73



  $objPHPExcel->getActiveSheet()->SetCellValue("F$numFila", $clientex);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "F$numFila:F$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("G$numFila", $entregox);

<<<<<<< HEAD
  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "G$numFila:G$numFila"); // 
=======
  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "G$numFila:G$numFila"); // 
>>>>>>> ca63c84eed77a5e94e01248e21a910616fd27e73



  $objPHPExcel->getActiveSheet()->SetCellValue("H$numFila", $recibiox);

<<<<<<< HEAD
  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "H$numFila:H$numFila"); // 
=======
  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "H$numFila:H$numFila"); // 
>>>>>>> ca63c84eed77a5e94e01248e21a910616fd27e73



  $objPHPExcel->getActiveSheet()->SetCellValue("I$numFila", $observacionx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "I$numFila:I$numFila"); // 



  $objPHPExcel->getActiveSheet()->SetCellValue("J$numFila", $vestatusy);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "J$numFila:J$numFila"); //  



  $numFila += 1;

  $partida += 1;
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('reporte/reporte_entregas.xlsx');

//header('Content-type: application/json');

echo json_encode("OK");
