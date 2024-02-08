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



$objPHPExcel = $objReader->load("plantilla/plantilla_nota_credito.xlsx");

$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora

$objPHPExcel->getActiveSheet()->setTitle("NOTAS_CRÉDITO"); //establecer titulo de hoja





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

$status = $_POST["statusx"];

$fecha = obtenerFechaEnLetra(date("d-m-Y h:i:s"));

switch ($status) {
  case 0:
    $statusx = "SIN TIMBRAR";
    break;
  case 1:
    $statusx = "FACTURADA";
    break;
  case 2:
    $statusx = "CANCELADA";
    break;
  default:
    $statusx = "";
    break;
}

if (strlen($texto) > 0 && $status == 5) {

  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

  $objPHPExcel->getActiveSheet()->SetCellValue("E4", $texto);

  $objPHPExcel->getActiveSheet()->SetCellValue("C5", "TODOS");
} else if (strlen($texto) > 0 && $status != 5) {

  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

  $objPHPExcel->getActiveSheet()->SetCellValue("E4", $texto);

  $objPHPExcel->getActiveSheet()->SetCellValue("C5", $statusx);
} else if (strlen($texto) == 0 && $status == 5) {

  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

  $objPHPExcel->getActiveSheet()->SetCellValue("E4", "TODOS");

  $objPHPExcel->getActiveSheet()->SetCellValue("C5", "TODOS");
} else if (strlen($texto) == 0 && $status != 5) {

  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

  $objPHPExcel->getActiveSheet()->SetCellValue("E4", "TODOS");

  $objPHPExcel->getActiveSheet()->SetCellValue("C5", $statusx);
}




//////////********************* MOSTRAR LAS PARTIDAS DE LA COTIZACION 



if (strlen($texto) > 0 && $status == 5) {

  $sql2 = "SELECT CONCAT_WS('/',a.id,a.estatus,f.serie,f.folio) AS acciones, a.id, a.estatus,a.ftimbrado,b.nombre AS usuario,CONCAT_WS('',c.id,d.serie,d.folio) AS fol_factura, e.nombre AS cliente, a.total, g.clave AS monedax, CONCAT_WS('',f.serie,f.folio) AS fol_cpp, e.id AS idcliente
  
            FROM alta_nota_credito a
  
            LEFT JOIN folio_nota_credito f ON a.idfolio=f.id,
  
            alta_usuarios b, alta_factura c, folio_factura d, alta_clientes e, alta_moneda g
            
            WHERE a.idusuario=b.id

            AND a.idfactura=c.id

            AND c.idfolio=d.id

            AND c.idcliente=e.id

            AND c.moneda=g.id

            AND CONCAT_WS(' ',e.nombre,e.comercial,a.total,b.nombre,d.folio,f.folio,e.nombre,a.total,c.uuid) LIKE '%" . $texto . "%'";
} else if (strlen($texto) > 0 && $status != 5) {

  $sql2 = "SELECT CONCAT_WS('/',a.id,a.estatus,f.serie,f.folio) AS acciones, a.id, a.estatus,a.ftimbrado,b.nombre AS usuario,CONCAT_WS('',c.id,d.serie,d.folio) AS fol_factura, e.nombre AS cliente, a.total, g.clave AS monedax, CONCAT_WS('',f.serie,f.folio) AS fol_cpp, e.id AS idcliente
  
            FROM alta_nota_credito a
  
            LEFT JOIN folio_nota_credito f ON a.idfolio=f.id,
  
            alta_usuarios b, alta_factura c, folio_factura d, alta_clientes e, alta_moneda g
            
            WHERE a.idusuario=b.id

            AND a.idfactura=c.id

            AND c.idfolio=d.id

            AND c.idcliente=e.id

            AND c.moneda=g.id

            AND CONCAT_WS(' ',e.nombre,e.comercial,a.total,b.nombre,d.folio,f.folio,e.nombre,a.total,c.uuid) LIKE '%" . $texto . "%'
            
            AND a.estatus = '" . $status . "'";
            
} else if (strlen($texto) == 0 && $status != 5) {

  $sql2 = "SELECT CONCAT_WS('/',a.id,a.estatus,f.serie,f.folio) AS acciones, a.id, a.estatus,a.ftimbrado,b.nombre AS usuario,CONCAT_WS('',c.id,d.serie,d.folio) AS fol_factura, e.nombre AS cliente, a.total, g.clave AS monedax, CONCAT_WS('',f.serie,f.folio) AS fol_cpp, e.id AS idcliente
  
            FROM alta_nota_credito a
  
            LEFT JOIN folio_nota_credito f ON a.idfolio=f.id,
  
            alta_usuarios b, alta_factura c, folio_factura d, alta_clientes e, alta_moneda g
            
            WHERE a.idusuario=b.id

            AND a.idfactura=c.id

            AND c.idfolio=d.id

            AND c.idcliente=e.id

            AND c.moneda=g.id            
            
            AND a.estatus = '" . $status . "'";
} else {

  $sql2 = "SELECT CONCAT_WS('/',a.id,a.estatus,f.serie,f.folio) AS acciones, a.id, a.estatus,a.ftimbrado,b.nombre AS usuario,CONCAT_WS('',d.serie,d.folio) AS fol_factura, e.nombre AS cliente, a.total, g.clave AS monedax, CONCAT_WS('',f.serie,f.folio) AS fol_cpp, e.id AS idcliente

            FROM alta_nota_credito a

            LEFT JOIN folio_nota_credito f ON a.idfolio=f.id,

            alta_usuarios b, alta_factura c, folio_factura d, alta_clientes e, alta_moneda g

            WHERE

            a.idusuario=b.id

            AND a.idfactura=c.id

            AND c.idfolio=d.id

            AND c.idcliente=e.id

            AND c.moneda=g.id

            LIMIT 0,100";
}

$buscar2 = $db->sql_query($sql2);

$numFila = 9;

$partida = 1;



while ($row2 = $db->sql_fetchrow($buscar2)) {

  $idppdx = $row2["ippdx"];

  $fechax = $row2["ftimbrado"];

  $realizo = $row2["usuario"];

  $facturax = $row2["fol_factura"];

  $cppx = $row2["fol_cpp"];

  $clientex = $row2["cliente"];

  $totalx = $row2["total"];

  $monedax = $row2["monedax"];

  $estatusx = $row2["estatus"];


  switch ($estatusx) {

    case 0:

      $vestatusy = "SIN TIMBRAR";

      break;
    case 1:

      $vestatusy = "FACTURADA";

      break;
    case 2:

      $vestatusy = "CANCELADA";

      break;

    default:
      $vestatusy = "";
      break;
  }





  $objPHPExcel->getActiveSheet()->SetCellValue("B$numFila", $partida);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("C$numFila", $fechax);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "C$numFila:C$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("D$numFila", $realizo);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "D$numFila:D$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("E$numFila", $facturax);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "E$numFila:E$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("F$numFila", $cppx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "F$numFila:F$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("G$numFila", $clientex);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "G$numFila:G$numFila"); // 



  $objPHPExcel->getActiveSheet()->SetCellValue("H$numFila", $totalx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "H$numFila:H$numFila"); // 

  $objPHPExcel->getActiveSheet()->getStyle("H$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



  $objPHPExcel->getActiveSheet()->SetCellValue("I$numFila", $monedax);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "I$numFila:I$numFila"); //   



  $objPHPExcel->getActiveSheet()->SetCellValue("J$numFila", $vestatusy);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "J$numFila:J$numFila"); //  



  $numFila += 1;

  $partida += 1;
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('reporte/reporte_nota_credito.xlsx');

//header('Content-type: application/json');

echo json_encode("OK");
