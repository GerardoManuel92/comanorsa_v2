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



$objPHPExcel = $objReader->load("plantilla/plantilla_seguimiento_entrega.xlsx");

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

$cotx = $_POST["cotizacionx"];



if ($cotx > 0) {

  $sql = "SELECT a.fecha,b.nombre AS cliente,a.id AS idcotizacion,c.nombre AS vendedor 
  
          FROM alta_cotizacion a,alta_clientes b, alta_usuarios c 
          
          WHERE a.idcliente=b.id 
          
          AND a.idusuario=c.id 
          
          AND a.id= '" . $cotx . "'";

  $buscar = $db->sql_query($sql);

  while ($row = $db->sql_fetchrow($buscar)) {

    $idcot = $row["idcotizacion"];

    $nombre_cliente = $row["cliente"];

    $vendedor = $row["vendedor"];

    $fecha_entrega =  obtenerFechaEnLetra($row["fecha"]);


    $folio = 0;

    $inicio = 10000;

    $nuevo = $inicio + $idcot;



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



    $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

    $objPHPExcel->getActiveSheet()->SetCellValue("C4", $folio);

    $objPHPExcel->getActiveSheet()->SetCellValue("C5", $nombre_cliente);

    $objPHPExcel->getActiveSheet()->SetCellValue("C6", $vendedor);

    $objPHPExcel->getActiveSheet()->SetCellValue("C7", $fecha_entrega);
  }
}

//////////********************* MOSTRAR CONTACTOS DEL CLIENTE 

$sql2 = "SELECT a.id,a.orden,CONCAT_WS('/',b.nparte,b.descripcion) AS descrip, a.cantidad AS vendido, c.descripcion AS unidad, 

          IFNULL( (SELECT SUM(w.cantidad) FROM partes_factura w WHERE w.idpartecot=a.id AND w.idfactura > 0),0 ) AS facturado, 
          
          IFNULL( (SELECT SUM(x.cantidad) FROM partes_asignar_oc x WHERE x.idpartecot=a.id AND x.idoc > 0),0 ) AS compras, 
          
          IFNULL( (SELECT SUM(y.cantidad) FROM partes_entrada y WHERE y.idpartecot=a.id AND y.identrada > 0 ),0 ) AS entrada, 
          
          IFNULL( (SELECT SUM(z.cantidad) FROM partes_entrega_factura z WHERE z.idpartecotizacion=a.id AND z.identrega > 0 ),0 ) AS entrega, a.estatus 
          
          FROM partes_cotizacion a, alta_productos b, sat_catalogo_unidades c 
          
          WHERE a.idparte=b.id 
          
          AND b.idunidad = c.id 
          
          AND a.idcotizacion = '" . $cotx . "'";



$buscar2 = $db->sql_query($sql2);

$numFila = 12;


while ($row2 = $db->sql_fetchrow($buscar2)) {



  $orden = $row2["orden"];

  $descripcion = $row2["descrip"];

  $telefonox = $row2["telefono"];

  $vendido = $row2["vendido"];

  $unidad = $row2["unidad"];

  $facturado = $row2["facturado"];

  $compras = $row2["compras"];

  $entrada = $row2["entrada"];

  $entrega = $row2["entrega"];

  $xentregar = $vendido - $entrega;

  $estatus = $row2["estatus"];

  if ($estatus == 0) {
    $vestatus = "POR ENTREGAR";
  } else if ($estatus == 1) {
    $vestatus = "ENTREGADO";
  }


  $objPHPExcel->getActiveSheet()->SetCellValue("B$numFila", $orden);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("C$numFila", $descripcion);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "C$numFila:C$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("D$numFila", $vendido);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "D$numFila:D$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("E$numFila", $unidad);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_left, "E$numFila:E$numFila"); //



  $objPHPExcel->getActiveSheet()->SetCellValue("F$numFila", $facturado);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "F$numFila:F$numFila"); //


  $objPHPExcel->getActiveSheet()->SetCellValue("G$numFila", $compras);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "G$numFila:G$numFila"); //


  $objPHPExcel->getActiveSheet()->SetCellValue("H$numFila", $entrada);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "H$numFila:H$numFila"); //


  $objPHPExcel->getActiveSheet()->SetCellValue("I$numFila", $entrega);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "I$numFila:I$numFila"); //


  $objPHPExcel->getActiveSheet()->SetCellValue("J$numFila", $xentregar);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "J$numFila:J$numFila"); //


  $objPHPExcel->getActiveSheet()->SetCellValue("K$numFila", $vestatus);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "K$numFila:K$numFila"); //



  $numFila += 1;
}


$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('reporte/Seguimiento_ventas/' . $folio . '.- ' . $nombre_cliente . '.xlsx');



//header('Content-type: application/json');

echo json_encode("OK");
