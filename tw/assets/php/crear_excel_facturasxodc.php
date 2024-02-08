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



$objPHPExcel = $objReader->load("plantilla/plantilla_facturasxodc.xlsx");

$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora

$objPHPExcel->getActiveSheet()->setTitle("Facturas Por ODC"); //establecer titulo de hoja





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


$fecha_actual = date("Y-m-d");
$hora_actual = date("H:i:s");

$objPHPExcel->getActiveSheet()->SetCellValue("C3", $fecha_actual);
$objPHPExcel->getActiveSheet()->SetCellValue("C4", $hora_actual);

//////////********************* MOSTRAR LAS PARTIDAS DE LA COTIZACION 

$table = "";

if ( $_POST["buscador"] == "" OR $_POST["buscador"] == null ) {
  if ( $_POST['estatus'] == 6  ) {
    $table = "(SELECT oc.id AS ID,
                CASE
                      WHEN oc.estatus = 1 THEN 'Pagado'
                      WHEN oc.estatus = 0 THEN 'No pagado'
                      ELSE 'No asignado'
                  END AS estatus,
                oc.id AS folio,
                  prov.nombre AS proveedor,
                  oc.total AS total,
                  IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
                  (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
              FROM alta_oc oc
              INNER JOIN alta_proveedores prov ON prov.id = oc.idpro)";
  }
  else if ( $_POST['estatus'] == 3  ) {
    $table = "(	SELECT oc.id AS ID,
                CASE
                      WHEN oc.estatus = 1 THEN 'Pagado'
                      WHEN oc.estatus = 0 THEN 'No pagado'
                      ELSE 'No asignado'
                  END AS estatus,
                oc.id AS folio,
                  prov.nombre AS proveedor,
                  oc.total AS total,
                  IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
                  (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
              FROM alta_oc oc
              INNER JOIN alta_proveedores prov ON prov.id = oc.idpro
              WHERE oc.estatus NOT IN (0,1))";

  }
  else{
    $table = "(SELECT oc.id AS ID,
            CASE
                  WHEN oc.estatus = 1 THEN 'Pagado'
                  WHEN oc.estatus = 0 THEN 'No pagado'
                  ELSE 'No asignado'
              END AS estatus,
            oc.id AS folio,
              prov.nombre AS proveedor,
              oc.total AS total,
              IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
              (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
          FROM alta_oc oc
          INNER JOIN alta_proveedores prov ON prov.id = oc.idpro
          WHERE oc.estatus = ".$_POST['estatus'].")";
  }
}else{
  if ( $_POST['estatus'] == 6  ) {
    $table = "(SELECT oc.id AS ID,
              CASE
                    WHEN oc.estatus = 1 THEN 'Pagado'
                    WHEN oc.estatus = 0 THEN 'No pagado'
                    ELSE 'No asignado'
                END AS estatus,
              oc.id AS folio,
                prov.nombre AS proveedor,
                oc.total AS total,
                IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
                (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
            FROM alta_oc oc
            INNER JOIN alta_proveedores prov ON prov.id = oc.idpro
            WHERE CONCAT_WS(oc.id,prov.nombre,oc.total) LIKE '%".$_POST['buscador']."%')";
  }
  else if ( $_POST['estatus'] == 3  ) {
    $table = "(	SELECT oc.id AS ID,
          CASE
                WHEN oc.estatus = 1 THEN 'Pagado'
                WHEN oc.estatus = 0 THEN 'No pagado'
                ELSE 'No asignado'
            END AS estatus,
          oc.id AS folio,
            prov.nombre AS proveedor,
            oc.total AS total,
            IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
            (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
        FROM alta_oc oc
        INNER JOIN alta_proveedores prov ON prov.id = oc.idpro
        WHERE oc.estatus NOT IN (0,1))";
  }
  else{
    $table = "(SELECT oc.id AS ID,
            CASE
                  WHEN oc.estatus = 1 THEN 'Pagado'
                  WHEN oc.estatus = 0 THEN 'No pagado'
                  ELSE 'No asignado'
              END AS estatus,
            oc.id AS folio,
              prov.nombre AS proveedor,
              oc.total AS total,
              IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
              (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
          FROM alta_oc oc
          INNER JOIN alta_proveedores prov ON prov.id = oc.idpro
          WHERE CONCAT_WS(oc.id,prov.nombre,oc.total) LIKE '%".$_POST['buscador']."%'
          AND oc.estatus = ".$_POST['estatus'].")";
  }
}


$buscar = $db->sql_query($table);

$numFila = 8;


while($row = $db->sql_fetchrow($buscar)){

  $folio = $row["folio"];
  $inicio = 10000;
  $nuevo = $inicio+$folio;

  switch ( strlen($nuevo) ) {
      case 5:
          $folio = "ODC00".$nuevo;
      break;
      case 6:
          $folio = "ODC0".$nuevo;
      break;
      case 7:
          $folio = "ODC".$nuevo;
      break;
      default:
          $folio = "s/asignar";
      break;
  }

  $estatus = $row["estatus"];
  $proveedor = $row["proveedor"];
  $total = $row["total"];
  $pagado = $row["pagado"];
  $porPagar = $row["porPagar"];


  $objPHPExcel->getActiveSheet()->SetCellValue("B$numFila", $folio);
  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila");//

  $objPHPExcel->getActiveSheet()->SetCellValue("C$numFila", $estatus);
  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "C$numFila:C$numFila");//

  $objPHPExcel->getActiveSheet()->SetCellValue("D$numFila", $proveedor);
  $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "D$numFila:D$numFila");//


  $objPHPExcel->getActiveSheet()->SetCellValue("E$numFila", $total);
  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "E$numFila:E$numFila");//
  $objPHPExcel->getActiveSheet()->getStyle("E$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');

  $objPHPExcel->getActiveSheet()->SetCellValue("F$numFila", $pagado);
  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "F$numFila:F$numFila");//
  $objPHPExcel->getActiveSheet()->getStyle("F$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');

  $objPHPExcel->getActiveSheet()->SetCellValue("G$numFila", $porPagar);
  $objPHPExcel->getActiveSheet()->setSharedStyle($datos_right, "G$numFila:G$numFila");//
  $objPHPExcel->getActiveSheet()->getStyle("G$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');

  $numFila +=1;


}



$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$name = date("d_m_Y_H_i_s");

$objWriter->save('reporte/cuentasodc'.$name.'.xlsx');

//header('Content-type: application/json');

echo json_encode($name);