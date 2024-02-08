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



$objPHPExcel = $objReader->load("plantilla/plantilla_producto.xlsx");

$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora

$objPHPExcel->getActiveSheet()->setTitle("DETALLADO DE PRODUCTO(S)"); //establecer titulo de hoja





/////////********************************************************************************************



include("config.php");

include("includes/mysqli.php");

include("includes/db.php");



set_include_path('includes');



//$objPHPExcel->getActiveSheet()->SetCellValue("C3", "CLIENTE DE PRUEBA");

//$objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila");//



$idcategoria = $_POST["categoriax"];

$idmarca = $_POST["marcax"];

$texto = trim($_POST["inputx"]);

$idx = "";

$clavex = "";

$skux = "";

$descripcionx = "";

$unidadx = "";

$categoriax = "";

$marcax = "";

$costox = "";

$imagenx = "";

$ivax = "";

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

if ($idcategoria > 0 && $idmarca > 0 && strlen($texto) == 0) {

  $sql = "SELECT b.descripcion AS categoria,e.marca AS marca

  FROM alta_productos a, alta_categoria b, sat_catalogo_unidades d, alta_marca e

  WHERE 

  a.idunidad=d.id

  AND a.idcategoria=b.id

  AND a.idmarca=e.id

  AND b.id ='" . $idcategoria . "'

  AND e.id ='" . $idmarca . "'

  AND a.estatus = 0";

  $buscar = $db->sql_query($sql);

  $row = $db->sql_fetchrow($buscar);



  $fecha = obtenerFechaEnLetra(date("d-m-Y h:i:s"));

  $categoria = $row["categoria"];

  $marca = $row["marca"];



  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

  $objPHPExcel->getActiveSheet()->SetCellValue("C4", $categoria);

  $objPHPExcel->getActiveSheet()->SetCellValue("C5", $marca);

} else if($idcategoria == 0 && $idmarca == 0 && strlen($texto) > 0){   

    $sql = "SELECT b.descripcion AS categoria,e.marca

    FROM alta_productos a, alta_categoria b, sat_catalogo_unidades d, alta_marca e

    WHERE 

    a.idunidad=d.id

    AND a.idcategoria=b.id

    AND a.idmarca=e.id
    
    AND a.descripcion LIKE '%" . $texto . "%'

    AND a.estatus = 0";
  
    $buscar = $db->sql_query($sql);
  
    $row = $db->sql_fetchrow($buscar);
  
  
  
    $fecha = obtenerFechaEnLetra(date("d-m-Y h:i:s"));
  
    /* $categoria = $row["categoria"];
  
    $marca = $row["marca"]; */
  
  
  
    $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);
  
    $objPHPExcel->getActiveSheet()->SetCellValue("C4", "VARIADO");
  
    $objPHPExcel->getActiveSheet()->SetCellValue("C5", "VARIADO");
  
}else {

  $fecha = obtenerFechaEnLetra(date("d-m-Y h:i:s"));

  $categoria = $row["categoria"];

  $marca = $row["marca"];



  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

  $objPHPExcel->getActiveSheet()->SetCellValue("C4", "TODAS");

  $objPHPExcel->getActiveSheet()->SetCellValue("C5", "TODAS");
}





//////////********************* MOSTRAR LAS PARTIDAS DE LOS PRODUCTOS 

if ($idcategoria > 0 and $idmarca > 0 && strlen($texto) == 0) {

  $sql2 = "SELECT a.id, CONVERT(CAST(CONVERT(a.nparte USING latin1) AS BINARY) USING utf8) AS clave,a.clave as sku,CONCAT_WS(' - ',CONVERT(CAST(CONVERT(a.descripcion USING latin1) AS BINARY) USING utf8), a.clave ) AS descripcion,d.descripcion AS unidad,b.descripcion AS categoria,a.iva,e.marca,a.costo AS costox,CONCAT_WS('/',a.id,a.img) AS imagen

  FROM alta_productos a, alta_categoria b, sat_catalogo_unidades d, alta_marca e

  WHERE 

  a.idunidad=d.id

  AND a.idcategoria=b.id

  AND a.idmarca=e.id

  AND b.id ='" . $idcategoria . "'

  AND e.id ='" . $idmarca . "'

  AND a.estatus = 0";

}else if($idcategoria == 0 && $idmarca == 0 && strlen($texto) > 0){

  $sql2 = "SELECT a.id, CONVERT(CAST(CONVERT(a.nparte USING latin1) AS BINARY) USING utf8) AS clave,a.clave as sku,CONCAT_WS(' - ',CONVERT(CAST(CONVERT(a.descripcion USING latin1) AS BINARY) USING utf8), a.clave ) AS descripcion,d.descripcion AS unidad,b.descripcion AS categoria,a.iva,e.marca,a.costo AS costox,CONCAT_WS('/',a.id,a.img) AS imagen

  FROM alta_productos a, alta_categoria b, sat_catalogo_unidades d, alta_marca e

  WHERE 

  a.idunidad=d.id

  AND a.idcategoria=b.id

  AND a.idmarca=e.id 

  AND a.descripcion LIKE '%" . $texto . "%'

  AND a.estatus = 0";

}else if($idcategoria == 0 && $idmarca == 0 && strlen($texto) == 0){

  $sql2 = "SELECT a.id, CONVERT(CAST(CONVERT(a.nparte USING latin1) AS BINARY) USING utf8) AS clave,a.clave as sku,CONCAT_WS(' - ',CONVERT(CAST(CONVERT(a.descripcion USING latin1) AS BINARY) USING utf8), a.clave ) AS descripcion,d.descripcion AS unidad,b.descripcion AS categoria,a.iva,e.marca,a.costo AS costox,CONCAT_WS('/',a.id,a.img) AS imagen

  FROM alta_productos a, alta_categoria b, sat_catalogo_unidades d, alta_marca e

  WHERE 

  a.idunidad=d.id

  AND a.idcategoria=b.id

  AND a.idmarca=e.id 

  AND a.estatus = 0";
}

$buscar2 = $db->sql_query($sql2);



$numFila = 8;



while ($row2 = $db->sql_fetchrow($buscar2)) {



  $idx = $row2["id"];

  $clavex = $row2["clave"];

  $skux = $row2["sku"];

  $descripcionx = $row2["descripcion"];

  $unidadx = $row2["unidad"];

  $categoriax = $row2["categoria"];

  $marcax = $row2["marca"];

  $costox = $row2["costox"];

  $ivax = $row2["iva"];

  $imagenx = $row2["imagen"];



  $objPHPExcel->getActiveSheet()->SetCellValue("B$numFila", $idx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("C$numFila", $imagenx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "C$numFila:C$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("D$numFila", $clavex);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "D$numFila:D$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("E$numFila", $skux);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_left, "E$numFila:E$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("F$numFila", $descripcionx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "F$numFila:F$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("G$numFila", $unidadx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "G$numFila:G$numFila"); //    



  $objPHPExcel->getActiveSheet()->SetCellValue("H$numFila", $categoriax);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "H$numFila:H$numFila"); //    



  $objPHPExcel->getActiveSheet()->SetCellValue("I$numFila", $ivax);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "I$numFila:I$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("J$numFila", $marcax);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "J$numFila:J$numFila"); //
  


  $objPHPExcel->getActiveSheet()->SetCellValue("K$numFila", round($costox, 2));

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "K$numFila:K$numFila"); //

  $objPHPExcel->getActiveSheet()->getStyle("K$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');

  $numFila += 1;
}


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('reporte/hoja_productos.xlsx');

//header('Content-type: application/json');

echo json_encode("OK");
