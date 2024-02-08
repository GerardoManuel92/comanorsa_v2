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



$objPHPExcel = $objReader->load("plantilla/plantilla_cotizaciones.xlsx");

$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora

$objPHPExcel->getActiveSheet()->setTitle("COTIZACIONES"); //establecer titulo de hoja





/////////********************************************************************************************



include("config.php");

include("includes/mysqli.php");

include("includes/db.php");



set_include_path('includes');



//$objPHPExcel->getActiveSheet()->SetCellValue("C3", "CLIENTE DE PRUEBA");

//$objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila");//



$busqueda = trim($_POST["inputx"]);
$estatus = $_POST["select_estatusx"];
$val_iva = 16;

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);
ini_set('log_errors', 1);


if (strlen($busqueda) > 0 and $estatus != 6) {

  $sql = "SELECT b.id AS id, b.nombre AS nombre, a.estatus AS estatus 

  FROM alta_cotizacion a, alta_clientes b 
  
  WHERE a.idcliente=b.id AND b.nombre LIKE '%" . $busqueda . "%'
  
  AND a.estatus = '" . $estatus . "'
  
  GROUP BY(a.idcliente)";

  $buscar = $db->sql_query($sql);

  $row = $db->sql_fetchrow($buscar);



  $fecha = obtenerFechaEnLetra(date("d-m-Y h:i:s"));

  $idcliente = $row["id"];

  $nombre = $row["nombre"];

  $vestatus = $row["estatus"];

  switch ($estatus) {

    case 0:

      $vestatusx = "COTIZACION";

      break;
    case 2:

      $vestatusx = "SIN FACTURAR";

      break;
    case 3:

      $vestatusx = "FINALIZADA";

      break;
    case 4:

      $vestatusx = "PEDIDO";

      break;
    case 5:

      $vestatusx = "EN PROCESO DE FACTURACION";

      break;
    default:

      $vestatusx = "DESCONOCIDO";

      break;
  }



  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $idcliente . '.- ' . $nombre);

  $objPHPExcel->getActiveSheet()->SetCellValue("C4", $vestatusx);

  $objPHPExcel->getActiveSheet()->SetCellValue("C5", $fecha);
} else {

  $fecha = obtenerFechaEnLetra(date("d-m-Y h:i:s"));


  $objPHPExcel->getActiveSheet()->SetCellValue("C3", "TODOS");

  $objPHPExcel->getActiveSheet()->SetCellValue("C4", "TODOS");

  $objPHPExcel->getActiveSheet()->SetCellValue("C5", $fecha);
}





//////////********************* MOSTRAR LAS PARTIDAS DE LA COTIZACION 

if (strlen($busqueda) > 0 and $estatus != 6) {

  $sql2 = "SELECT a.id, CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus AS statusx,

  CONCAT_WS('$',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) WHEN '4' THEN a.evidencia WHEN '5' THEN '#' END) AS info_estatus,

  CONCAT_WS('/',a.fecha,a.hora) AS dia, b.nombre AS vendedor,

  c.nombre AS cliente, (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,a.subtotal AS tsubtotal,a.descuento AS tdescuento,a.iva AS tiva,

  c.id AS idclientex

  FROM alta_cotizacion a, alta_usuarios b, alta_clientes c

  WHERE a.idusuario=b.id

  AND a.idcliente=c.id
  
  AND c.nombre LIKE '%" . $busqueda . "%'

  AND a.estatus = '" . $estatus . "'";
  
} else if (strlen($busqueda) > 0 and $estatus == 6) {

  $sql2 = "SELECT a.id, CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus AS statusx,

  CONCAT_WS('$',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) WHEN '4' THEN a.evidencia WHEN '5' THEN '#' END) AS info_estatus,

  CONCAT_WS('/',a.fecha,a.hora) AS dia, b.nombre AS vendedor,

  c.nombre AS cliente, (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,a.subtotal AS tsubtotal,a.descuento AS tdescuento,a.iva AS tiva,

  c.id AS idclientex

  FROM alta_cotizacion a, alta_usuarios b, alta_clientes c

  WHERE a.idusuario=b.id

  AND a.idcliente=c.id
  
  AND c.nombre LIKE '%" . $busqueda . "%'";

} else {

  $sql2 = "SELECT a.id,   CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus AS statusx,

  CONCAT_WS('$',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) WHEN '4' THEN a.evidencia WHEN '5' THEN '#' END) AS info_estatus,

  CONCAT_WS('/',a.fecha,a.hora) AS dia, b.nombre AS vendedor, c.nombre AS cliente,

  (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,a.subtotal AS tsubtotal,a.descuento AS tdescuento,a.iva AS tiva,

  c.id AS idclientex

  FROM alta_cotizacion a, alta_usuarios b, alta_clientes c

  WHERE a.idusuario=b.id

  AND a.idcliente=c.id ORDER BY a.id DESC LIMIT 0,300";
}

$buscar2 = $db->sql_query($sql2);



$numFila = 9;

$fila = 1;



while ($row2 = $db->sql_fetchrow($buscar2)) {

  $idcotx = $row2["id"];

  $idclientex = $row2["idclientex"];

  $diax = $row2["dia"];

  $vendedorx = $row2["vendedor"];

  $clientex = $row2["cliente"];

  $contactox = $row2["contacto"];

  $subtotalx = $row2["tsubtotal"];

  $descuentox = $row2["tdescuento"];

  $estatusx = $row2["statusx"];

  $subtotaly = $subtotalx - $descuentox;

  $ivax = $subtotaly * ($val_iva / 100);

  $totalx = $subtotaly + $ivax;

  switch ($estatusx) {

    case 0:

      $vestatusy = "COTIZACION";

      break;
    case 2:

      $vestatusy = "SIN FACTURAR";

      break;
    case 3:

      $vestatusy = "FINALIZADA";

      break;
    case 4:

      $vestatusy = "PEDIDO";

      break;
    case 5:

      $vestatusy = "EN PROCESO DE FACTURACION";

      break;
    default:

      $vestatusy = "DESCONOCIDO";

      break;
  }

  $folio = 0;

  $inicio = 10000;

  $nuevo = $inicio + $idcotx;



  switch (strlen($nuevo)) {



    case 5:



      $folio = "ODV00" . $nuevo;



      break;



    case 6:



      $folio = "ODV0" . $nuevo;



      break;



    case 7:



      $folio = "ODV" . $nuevo;



      break;



    default:



      $folio = "s/asignar";



      break;
  }



  $objPHPExcel->getActiveSheet()->SetCellValue("B$numFila", $fila);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("C$numFila", $diax);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "C$numFila:C$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("D$numFila", $vendedorx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "D$numFila:D$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("E$numFila", $folio);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "E$numFila:E$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("F$numFila", $clientex);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "F$numFila:F$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("G$numFila", $contactox);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "G$numFila:G$numFila"); //  



  $objPHPExcel->getActiveSheet()->SetCellValue("H$numFila", $subtotalx);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "H$numFila:H$numFila"); //



  $objPHPExcel->getActiveSheet()->getStyle("H$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



  $objPHPExcel->getActiveSheet()->SetCellValue("I$numFila", round($descuentox, 2));

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "I$numFila:I$numFila"); //

  $objPHPExcel->getActiveSheet()->getStyle("I$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



  $objPHPExcel->getActiveSheet()->SetCellValue("J$numFila", round($ivax, 2));

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "J$numFila:J$numFila"); //

  $objPHPExcel->getActiveSheet()->getStyle("J$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



  $objPHPExcel->getActiveSheet()->SetCellValue("K$numFila", round($totalx, 2));

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "K$numFila:K$numFila"); //

  $objPHPExcel->getActiveSheet()->getStyle("K$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



  $objPHPExcel->getActiveSheet()->SetCellValue("L$numFila", $vestatusy);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "L$numFila:L$numFila"); //


  $numFila += 1;

  $fila += 1;
}


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('reporte/reporte_cotizaciones.xlsx');

//header('Content-type: application/json');

echo json_encode("OK");
