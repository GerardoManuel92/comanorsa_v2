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



$objPHPExcel = $objReader->load("plantilla/plantilla_balance_cuentas.xlsx");

$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora

$objPHPExcel->getActiveSheet()->setTitle("BALANCE_CUENTAS"); //establecer titulo de hoja





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

$cliente = $_POST["clientex"];

$estatus = $_POST["statusx"];



switch ($estatus) {
  case 0:
    $estatusx = "SIN APLICAR";
    break;
  case 1:
    $estatusx = "APLICADOS";
    break;
  case 2:
    $estatusx = "TODOS";
    break;
  case 3:
    $estatusx = "ABONO S/APLICAR";
    break;
  case 4:
    $estatusx = "ABONO S/IDENTIFICAR";
    break;
  case 5:
    $estatusx = "ABONO S/FACTURAS PUE";
    break;
}

if ($estatus >= 0 && $cliente == 0) {

  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

  $objPHPExcel->getActiveSheet()->SetCellValue("C4", "TODOS");

  $objPHPExcel->getActiveSheet()->SetCellValue("C5", $estatusx);

}else if($estatus >= 0 && $cliente > 0){

  $sql = "SELECT nombre FROM alta_clientes WHERE id = '" . $cliente . "'";

  $buscar = $db->sql_query($sql);

  $row = $db->sql_fetchrow($buscar);

  $nombre_clientex = $row["nombre"];

  $objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha);

  $objPHPExcel->getActiveSheet()->SetCellValue("C4", $nombre_clientex);

  $objPHPExcel->getActiveSheet()->SetCellValue("C5", $estatusx);

}



//////////********************* MOSTRAR LAS PARTIDAS DE LA COTIZACION 



if ($estatus == 2 && $cliente == 0) {

  $sql2 = "SELECT a.id,CONCAT_WS('/',a.id,a.estatus,a.idcuenta) AS acciones,a.fecha_banco, a.hora_banco,a.movimiento,a.descripcion,a.rastreo,CONCAT_WS('/',a.tipo,a.importe) AS importex, CONCAT_WS(' | ',a.cuenta,d.comercial) AS cuentax,IFNULL(c.nombre,'No identificado') AS nombrex,a.estatus,a.tipo,a.importe,a.cuenta,IFNULL(c.id,0) AS idclientex, IFNULL(e.descripcion,'s/aplicar') AS fpagox, a.fpago
          
          FROM saldo_bancos a
          
          LEFT JOIN cuentas_bancariasxcliente b ON a.idcuenta=b.id
          
          LEFT JOIN alta_bancos d ON b.idbanco=d.id 
          
          LEFT JOIN alta_clientes c ON b.idcliente=c.id
          
          LEFT JOIN sat_catalogo_fpago e ON a.fpago=e.id";

} else if ($estatus == 2 && $cliente > 0){

  $sql2 = "SELECT a.id,CONCAT_WS('/',a.id,a.estatus,a.idcuenta) AS acciones,a.fecha_banco, a.hora_banco,a.movimiento,a.descripcion,a.rastreo,CONCAT_WS('/',a.tipo,a.importe) AS importex, CONCAT_WS(' | ',a.cuenta,d.comercial) AS cuentax,IFNULL(c.nombre,'No identificado') AS nombrex,a.estatus,a.tipo,a.importe,a.cuenta,IFNULL(c.id,0) AS idclientex, IFNULL(e.descripcion,'s/aplicar') AS fpagox, a.fpago
          
          FROM saldo_bancos a
          
          LEFT JOIN cuentas_bancariasxcliente b ON a.idcuenta=b.id
          
          LEFT JOIN alta_bancos d ON b.idbanco=d.id 
          
          LEFT JOIN alta_clientes c ON b.idcliente=c.id
          
          LEFT JOIN sat_catalogo_fpago e ON a.fpago=e.id
          
          WHERE c.id = '".$cliente."'";

} else if ($estatus != 2 && $cliente == 0){

  $sql2 = "SELECT a.id,CONCAT_WS('/',a.id,a.estatus,a.idcuenta) AS acciones,a.fecha_banco, a.hora_banco,a.movimiento,a.descripcion,a.rastreo,CONCAT_WS('/',a.tipo,a.importe) AS importex, CONCAT_WS(' | ',a.cuenta,d.comercial) AS cuentax,IFNULL(c.nombre,'No identificado') AS nombrex,a.estatus,a.tipo,a.importe,a.cuenta,IFNULL(c.id,0) AS idclientex, IFNULL(e.descripcion,'s/aplicar') AS fpagox, a.fpago
          
          FROM saldo_bancos a
          
          LEFT JOIN cuentas_bancariasxcliente b ON a.idcuenta=b.id
          
          LEFT JOIN alta_bancos d ON b.idbanco=d.id 
          
          LEFT JOIN alta_clientes c ON b.idcliente=c.id
          
          LEFT JOIN sat_catalogo_fpago e ON a.fpago=e.id
          
          WHERE a.estatus = '".$estatus."'";

} else if ($estatus != 2 && $cliente > 0){

  $sql2 = "SELECT a.id,CONCAT_WS('/',a.id,a.estatus,a.idcuenta) AS acciones,a.fecha_banco, a.hora_banco,a.movimiento,a.descripcion,a.rastreo,CONCAT_WS('/',a.tipo,a.importe) AS importex, CONCAT_WS(' | ',a.cuenta,d.comercial) AS cuentax,IFNULL(c.nombre,'No identificado') AS nombrex,a.estatus,a.tipo,a.importe,a.cuenta,IFNULL(c.id,0) AS idclientex, IFNULL(e.descripcion,'s/aplicar') AS fpagox, a.fpago
          
          FROM saldo_bancos a
          
          LEFT JOIN cuentas_bancariasxcliente b ON a.idcuenta=b.id
          
          LEFT JOIN alta_bancos d ON b.idbanco=d.id 
          
          LEFT JOIN alta_clientes c ON b.idcliente=c.id
          
          LEFT JOIN sat_catalogo_fpago e ON a.fpago=e.id
          
          WHERE a.estatus = '".$estatus."'
          
          AND c.id = '".$cliente."'";
}

$buscar2 = $db->sql_query($sql2);

$numFila = 9;

$partida = 1;



while ($row2 = $db->sql_fetchrow($buscar2)) {



  $fecha_bancox = $row2["fecha_banco"];
  
  $rastreox = $row2["rastreo"];

  $cuentax = $row2["cuentax"];

  $nombre = $row2["nombrex"];

  $cargo = 0.00;

  $abono = $row2["importe"];

  $forma_pagox = $row2["fpagox"];

  $vestatus = $row2["estatus"];





  if ( $vestatus == 0 ) {

    

    $vestatus = "SIN APLICAR";



  }else{



    $vestatus = "APLICADOS";



  }


  
  $objPHPExcel->getActiveSheet()->SetCellValue("B$numFila", $partida);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("C$numFila", $fecha_bancox);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "C$numFila:C$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("D$numFila", $rastreox);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "D$numFila:D$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("E$numFila", $cuentax);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "E$numFila:E$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("F$numFila", $nombre);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "F$numFila:F$numFila");//



  $objPHPExcel->getActiveSheet()->SetCellValue("G$numFila", $cargo);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "G$numFila:G$numFila");// 

  $objPHPExcel->getActiveSheet()->getStyle("G$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



  $objPHPExcel->getActiveSheet()->SetCellValue("H$numFila", $abono);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "H$numFila:H$numFila");// 

  $objPHPExcel->getActiveSheet()->getStyle("H$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



  $objPHPExcel->getActiveSheet()->SetCellValue("I$numFila", $forma_pagox);

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "I$numFila:I$numFila");// 



  $objPHPExcel->getActiveSheet()->SetCellValue("J$numFila", $vestatus );

  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "J$numFila:J$numFila");//  



  $numFila += 1;
  $partida +=1;
}

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('reporte/reporte_balance_cuentas.xlsx');

//header('Content-type: application/json');

echo json_encode("OK");
