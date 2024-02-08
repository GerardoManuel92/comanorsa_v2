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



$objPHPExcel = $objReader->load("plantilla/plantilla_odc.xlsx");

$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora

$objPHPExcel->getActiveSheet()->setTitle("PROVEEDORES"); //establecer titulo de hoja





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

$estatus = $_POST["select_estatusx"];


if (strlen($texto) > 0 and $estatus != 6) {


  $fecha = obtenerFechaEnLetra(date("d-m-Y h:i:s"));

  switch ($estatus) {

    case 1:

      $vestatusx = "ENTRADA";

      break;
    case 2:

      $vestatusx = "CANCELADA";

      break;
    case 3:

      $vestatusx = "ENTRADA PARCIAL";

      break;
    case 4:

      $vestatusx = "FINALIZADA";

      break;
    case 5:

      $vestatusx = "FINALIZADA SIN ENTRADAS";

      break;
    default:

      $vestatusx = "DESCONOCIDO";

      break;
  }



  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $texto);

  $objPHPExcel->getActiveSheet()->SetCellValue("C4", $vestatusx);

  $objPHPExcel->getActiveSheet()->SetCellValue("C5", $fecha);
} else {

  $fecha = obtenerFechaEnLetra(date("d-m-Y h:i:s"));


  $objPHPExcel->getActiveSheet()->SetCellValue("C3", "TODOS");

  $objPHPExcel->getActiveSheet()->SetCellValue("C4", "TODOS");

  $objPHPExcel->getActiveSheet()->SetCellValue("C5", $fecha);
}





//////////********************* MOSTRAR LAS PARTIDAS DE LA COTIZACION 

if (strlen($texto) > 0 and $estatus != 6) {

  $sql2 = "SELECT CONCAT_WS('/',a.id,a.estatus) AS acciones,a.id, a.estatus AS statusx, a.fecha, b.nombre 
  
  AS usuario, c.nombre AS proveedor, a.subtotal, a.descuento, a.iva, a.total 
  
  FROM alta_oc a, alta_usuarios b, alta_proveedores c 
  
  WHERE a.idusuario=b.id 
  
  AND a.idpro=c.id 
  
  AND CONCAT_WS(a.id,c.nombre,b.nombre,a.total) LIKE '%" . $texto . "%' 
  
  AND a.estatus = '" . $estatus . "'";


  /*  $fecha = obtenerFechaEnLetra(date("d-m-Y h:i:s")); */
} else if (strlen($texto) > 0 and $estatus == 6) {

  $sql2 = "SELECT CONCAT_WS('/',a.id,a.estatus) AS acciones,a.id, a.estatus AS statusx, a.fecha, b.nombre 
  
  AS usuario, c.nombre AS proveedor, a.subtotal, a.descuento, a.iva, a.total 
  
  FROM alta_oc a, alta_usuarios b, alta_proveedores c 
  
  WHERE a.idusuario=b.id 
  
  AND a.idpro=c.id 
  
  AND CONCAT_WS(a.id,c.nombre,b.nombre,a.total) LIKE '%" . $texto . "%'";


  /*  $fecha = obtenerFechaEnLetra(date("d-m-Y h:i:s")); */
} else {

  $sql2 = "SELECT CONCAT_WS('/',a.id,a.estatus) AS acciones,a.id, a.estatus AS statusx, a.fecha, b.nombre 
  
  AS usuario, c.nombre AS proveedor, a.subtotal, a.descuento, a.iva, a.total 
  
  FROM alta_oc a, alta_usuarios b, alta_proveedores c 
  
  WHERE a.idusuario=b.id 
  
  AND a.idpro=c.id";

}


$buscar2 = $db->sql_query($sql2);



$numFila = 9;

$fila = 1;



while ($row2 = $db->sql_fetchrow($buscar2)) {  

  $id_oc = $row2["id"];  

  $fecha = $row2["fecha"];

  $usuariox = $row2["usuario"];

  $proveedorx = $row2["proveedor"];

  $contactox = $row2["contacto"];

  $subtotalx = $row2["subtotal"];

  $descuentox = $row2["descuento"];

  $ivax = $row2["iva"];

  $totalx = $row2["total"];

  $estatusx = $row2["statusx"];
 

  switch ($estatusx) {

    case 1:

      $vestatusy = "ENTRADA";

      break;
    case 2:

      $vestatusy = "CANCELADA";

      break;
    case 3:

      $vestatusy = "ENTRADA PARCIAL";

      break;
    case 4:

      $vestatusy = "FINALIZADA";

      break;
    case 5:

      $vestatusy = "FINALIZADA SIN ENTRADAS";

      break;
    default:

      $vestatusy = "DESCONOCIDO";

      break;
  }

  $objPHPExcel->getActiveSheet()->SetCellValue("B$numFila", $fila);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("C$numFila", $fecha);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "C$numFila:C$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("D$numFila", $id_oc);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "D$numFila:D$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("E$numFila", $usuariox);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "E$numFila:E$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("F$numFila", $proveedorx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "F$numFila:F$numFila"); //    



  $objPHPExcel->getActiveSheet()->SetCellValue("G$numFila", $subtotalx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "G$numFila:G$numFila"); //

  $objPHPExcel->getActiveSheet()->getStyle("G$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



  $objPHPExcel->getActiveSheet()->SetCellValue("H$numFila", round($descuentox, 2));

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "H$numFila:H$numFila"); //

  $objPHPExcel->getActiveSheet()->getStyle("H$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



  $objPHPExcel->getActiveSheet()->SetCellValue("I$numFila", round($ivax, 2));

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "I$numFila:I$numFila"); //

  $objPHPExcel->getActiveSheet()->getStyle("I$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



  $objPHPExcel->getActiveSheet()->SetCellValue("J$numFila", round($totalx, 2));

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "J$numFila:J$numFila"); //

  $objPHPExcel->getActiveSheet()->getStyle("J$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



  $objPHPExcel->getActiveSheet()->SetCellValue("K$numFila", $vestatusy);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "K$numFila:K$numFila"); //


  $numFila += 1;

  $fila += 1;
}



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('reporte/reportes_ODC.xlsx');

//header('Content-type: application/json');

echo json_encode("OK");
