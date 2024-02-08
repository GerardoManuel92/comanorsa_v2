<?php

set_time_limit (600000);

//ajuntar la libreria excel

include "libreria_excel/PHPExcel.php";

include 'libreria_excel/PHPExcel/IOFactory.php';

include ("libreria_excel/funciones.php");

date_default_timezone_set("America/Mexico_City");





$objPHPExcel = new PHPExcel();

$objReader = PHPExcel_IOFactory::createReader('Excel2007');



//****************************************************  ESTILOS  **********************



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

$style_vencidas = new PHPExcel_Style(); //nuevo estilo

$style_vencidas->applyFromArray(

  array(

    'fill' => array( //relleno de color

      'type' => PHPExcel_Style_Fill::FILL_SOLID,

      'color' => array('argb' => 'C7381C')

      ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 12,

      'color' => array('argb' => 'FFFFFF')

    )

));


$style_cobradas = new PHPExcel_Style(); //nuevo estilo

$style_cobradas->applyFromArray(

  array(

    'fill' => array( //relleno de color

      'type' => PHPExcel_Style_Fill::FILL_SOLID,

      'color' => array('argb' => '2B7A06')

      ),

    'font' => array( //fuente

      'bold' => true,

      'size' => 12,

      'color' => array('argb' => 'FFFFFF')

    )

));


$style_nota_aplicada = new PHPExcel_Style(); //nuevo estilo

$style_nota_aplicada->applyFromArray(

  array(

    'fill' => array( //relleno de color

      'type' => PHPExcel_Style_Fill::FILL_SOLID,

      'color' => array('argb' => 'FFC300')

      )


));




//****************************************************  FIN DE ESTILOS**********************



$objPHPExcel = $objReader->load("plantilla/plantilla_cxc2.xlsx");

$objPHPExcel->setActiveSheetIndex(0); //seleccionar hora

$objPHPExcel->getActiveSheet()->setTitle("Cxc COMANORSA"); //establecer titulo de hoja



/////////********************************************************************************************



include("config.php"); 

include("includes/mysqli.php");

include("includes/db.php");



set_include_path('includes');



$idcliente=trim($_POST["idcliente"]);

///$estatus=0;



	////** DATOS DEL CLIENTE ***********//////////////



	$info_cliente="SELECT a.nombre,a.rfc,a.limite
    FROM alta_clientes a, direccion_clientes b
    WHERE 
    b.idcliente=a.id
    AND a.id=".$idcliente;

	$b2=$db->sql_query($info_cliente);

    $r2= $db->sql_fetchrow($b2);



    $nombre=$r2["nombre"];

	  $rfc=$r2["rfc"];

    $limite=$r2["limite"];



	///***  TOTAL ENCABEZADOS SOLO SALDO VENCIDO ***********//////////////////



		$sql ="SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito



                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$idcliente."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."' 



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito



                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$idcliente."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."' ";



                    //echo $sql;

        $total=0;



        $total_neto=0;

        //$total_ncredito=0;

        $prepare2=$db->sql_prepare($sql);
        $datos_vencidas=$db->sql_numrows($prepare2);


        if( $datos_vencidas>0 ){

            
            $buscar=$db->sql_query($sql);

            while( $row= $db->sql_fetchrow($buscar) ){



            	$pagox=$row["pago"];



          

            		

            		$sumatotal = 0;

                                

                    $sql2="SELECT a.pago AS pagado, 

                          (SELECT x.idcpd FROM alta_datos_ppd x WHERE x.id=a.idppd) AS iddatocpp

                          FROM alta_pagos_ppd a WHERE a.idfactura=".$row['id']." AND a.tipo=".$row['tipox'];

                          $buscar2=$db->sql_query($sql2);

                      		while( $row2= $db->sql_fetchrow($buscar2) ){



                      			$sql3="SELECT a.estatus

                                  FROM alta_ppd a WHERE a.id=".$row2['iddatocpp'];

                                  $buscar3=$db->sql_query($sql3);

                      			while( $row3= $db->sql_fetchrow($buscar3) ){





                      				if ( $row3["estatus"] == 1 ) {

                                                          

                                          $sumatotal=$sumatotal+$row2["pagado"];



                                      }



                      			}



                      		}



            		$total=$total+$sumatotal;



            		//////////************ SUMAR LOS PAGOS FUERA DEL SISTEMA



                    $sql3="SELECT SUM(totalx) AS totalx FROM `alta_pago_cxc` WHERE idfactura=".$row['id']." AND tipo=".$row['tipox'];

                    $buscar3=$db->sql_query($sql3);

            		    $row3=$db->sql_fetchrow($buscar3);



                    $total=$total+$row3["totalx"];




                  	$total_neto=$total_neto+$row["total"];



                    //$total_ncredito=$total_ncredito+$row["totncredito"];



            }


        }



      ///***  TOTAL ENCABEZADOS SOLO SALDO ACTIVO ***********//////////////////



		  $sql_act ="SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito



                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente='".$idcliente."' 

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."' 



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar,



                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito



                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente='".$idcliente."' 

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."' ";





        $total_act=0;



        $total_neto_act=0;

      


        $buscar_act=$db->sql_query($sql_act);

        while( $row_act= $db->sql_fetchrow($buscar_act) ){



        	$pago_act=$row_act["pago"];



        	if ( $pago_act==0 ) {

        		

        		$sumatotal_act = 0;

                            

                $sql2_act="SELECT a.pago AS pagado, 

                (SELECT x.idcpd FROM alta_datos_ppd x WHERE x.id=a.idppd) AS iddatocpp

                FROM alta_pagos_ppd a WHERE a.idfactura=".$row_act['id']." AND a.tipo=".$row_act['tipox'];

                $buscar2_act=$db->sql_query($sql2_act);

        		while( $row2_act= $db->sql_fetchrow($buscar2_act) ){



        			$sql3_act="SELECT a.estatus

                    FROM alta_ppd a WHERE a.id=".$row2_act['iddatocpp'];

                    $buscar3_act=$db->sql_query($sql3_act);

        			while( $row3_act= $db->sql_fetchrow($buscar3_act) ){





        				if ( $row3_act["estatus"] == 1 ) {

                                            

                            $sumatotal_act=$sumatotal_act+$row2_act["pagado"];



                        }



        			}



        		}



        		$total_act=$total_act+$sumatotal_act;



        		//////////************ SUMAR LOS PAGOS FUERA DEL SISTEMA



                $sql4_act="SELECT SUM(totalx) AS totalx FROM `alta_pago_cxc` WHERE idfactura=".$row_act['id']." AND tipo=".$row_act['tipox'];

                $buscar4_act=$db->sql_query($sql4_act);

        		$row4_act=$db->sql_fetchrow($buscar4_act);



                $total_act=$total_act+$row4_act["totalx"];



        	}elseif( $pago_act==1 ) {

        		

        		$total_act=$total_act+$row_act["total"];



        	}



        	$total_neto_act=$total_neto_act+$row_act["total"];



            //$total_ncredito_act=$total_ncredito_act+$row_act["totncredito"];



        }



        /////////////////**************************** TOTAL DE NOTAS DE CREDITO

        $sql_notas ="SELECT 

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito


                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.idcliente='".$idcliente."'



                    UNION ALL

                    SELECT

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito



                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.idcliente=".$idcliente;

        ///$total_nc=$total_ncredito+$total_ncredito_act;

        //echo $sql_notas;

        $total_nc=0;

        /*$buscar_nota=$db->sql_query($sql_notas);

        while( $row_nota= $db->sql_fetchrow($buscar_nota) ){

          $total_nc=$total_nc+$row_nota["totncredito"];

        }*/



    /////********************* IMPRIMIR ENCABEZADO DEL REPORTE



    $objPHPExcel->getActiveSheet()->SetCellValue("C5", $nombre);

    $objPHPExcel->getActiveSheet()->SetCellValue("C7", $rfc);

    $objPHPExcel->getActiveSheet()->SetCellValue("C8", obtenerFechaEnLetra(date("Y-m-d")));





    $objPHPExcel->getActiveSheet()->SetCellValue("G5", $limite);

    $objPHPExcel->getActiveSheet()->getStyle("G5")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');

    $saldo_total_deudor=$total_neto+$total_neto_act;

    $objPHPExcel->getActiveSheet()->SetCellValue("G6", $saldo_total_deudor);

    $objPHPExcel->getActiveSheet()->getStyle("G6")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');

    $objPHPExcel->getActiveSheet()->SetCellValue("G7", $total_nc);

    $objPHPExcel->getActiveSheet()->getStyle("G7")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');

    ////****************** SALDO DISPONBLE 





    $objPHPExcel->getActiveSheet()->SetCellValue("J5", $total_neto);//VENCIDO

    $objPHPExcel->getActiveSheet()->getStyle("J5")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');

    $objPHPExcel->getActiveSheet()->SetCellValue("J6", $total_ncredito);//NC DEL SALDO VENCIDO

    $objPHPExcel->getActiveSheet()->getStyle("J6")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



    $xcobrar=$total_neto-$total_ncredito;



    $objPHPExcel->getActiveSheet()->SetCellValue("J7", $xcobrar);//NC DEL SALDO VENCIDO

    $objPHPExcel->getActiveSheet()->getStyle("J7")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');


    ////////********* SALDO DISPONIBLE limite_saldo - saldo vencido - saldo activo;

    $sdisponible=$limite-$xcobrar-$total_neto_act;

    $objPHPExcel->getActiveSheet()->SetCellValue("G8", $sdisponible);

    $objPHPExcel->getActiveSheet()->getStyle("G8")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');














    ///////////************** DOCUMENTOS DEL CLIENTE FACTURAS Y NOTAS DE CREDITO



	$sql2_doc="SELECT x.uuid,x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito,

                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos,x.obs_factura,z.folio

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.idcliente=".$idcliente."



                    UNION ALL



                    SELECT x.uuid,x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <='".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito,

                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos,x.obs_factura,z.folio

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.idcliente=".$idcliente." 

                    ORDER BY folio ASC";



    $buscar_doc=$db->sql_query($sql2_doc);



    $numFila = 12;



    while( $row_doc=$db->sql_fetchrow($buscar_doc) ){



    	$objPHPExcel->getActiveSheet()->SetCellValue("B$numFila", $row_doc["uuid"]);

  		$objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila");//



        $objPHPExcel->getActiveSheet()->SetCellValue("C$numFila", $row_doc["documento"]);

        $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "C$numFila:C$numFila");//



        $objPHPExcel->getActiveSheet()->SetCellValue("D$numFila", $row_doc["fecha"]);

        $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "D$numFila:D$numFila");//



        $objPHPExcel->getActiveSheet()->SetCellValue("E$numFila", $row_doc["fol_fact"]);

        $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "E$numFila:E$numFila");//



        $objPHPExcel->getActiveSheet()->SetCellValue("F$numFila", $row_doc["total"]);

        $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "F$numFila:F$numFila");//


        $objPHPExcel->getActiveSheet()->getStyle("F$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');





        $objPHPExcel->getActiveSheet()->SetCellValue("K$numFila", $row_doc["totncredito"]);

        if($row_doc["totncredito"]>0) {
          
          $objPHPExcel->getActiveSheet()->setSharedStyle($style_nota_aplicada, "K$numFila:K$numFila");//

        }else{

          $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "K$numFila:K$numFila");//

        }

        

        $objPHPExcel->getActiveSheet()->getStyle("K$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



        $objPHPExcel->getActiveSheet()->SetCellValue("L$numFila", $row_doc["dias"]);

        $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "L$numFila:L$numFila");//



        $objPHPExcel->getActiveSheet()->SetCellValue("M$numFila", $row_doc["fcobro"]);

        $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "M$numFila:M$numFila");//



       







        /////////********* ESTATUS DE PAGO 



        $est_dato="SIN DATOS";

        

        $separar= explode("/", $row_doc["est_pago"]);



                                if ( $separar[2] == 1 ) {

                                    

                                    if ( $separar[1] == 1) {

                                

                                        //////// pagado

                                        //return '<p style="color:green; font-weight:bold;" >COBRADA</p>';

                                        $est_dato="COBRADA";
                                        $dia_cero=0;
                                        $objPHPExcel->getActiveSheet()->SetCellValue("N$numFila", $dia_cero);

                                        $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "N$numFila:N$numFila");//

                                        $objPHPExcel->getActiveSheet()->setSharedStyle($style_cobradas, "O$numFila:O$numFila");//



                                    }else{



                                        

                                        if ( $separar[0] == 1 ) {

                                            

                                            ////////// VENCIDA

                                            //return '<p style="color:red; font-weight:bold;" >VENCIDA</p>';

                                            $est_dato="VENCIDA";

                                           

                                            $objPHPExcel->getActiveSheet()->SetCellValue("N$numFila", $row_doc["dias_transcurridos"]);

                                            $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "N$numFila:N$numFila");//

                                            $objPHPExcel->getActiveSheet()->setSharedStyle($style_vencidas, "O$numFila:O$numFila");//



                                        }else{



                                            ////////// ACTIVA

                                            //return '<p style="color:darkblue; font-weight:bold;" >ACTIVA</p>';

                                            $est_dato="ACTIVA";

                                            $objPHPExcel->getActiveSheet()->SetCellValue("N$numFila", $row_doc["dias_transcurridos"]);

                                            $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "N$numFila:N$numFila");//



                                        }



                                    }



                                }else if ( $separar[2] == 2 ) {

                                    

                                    //return '<p style="color:#E1A009; font-weight:bold;" ><i class="fa fa-close"></i>CANCELADA</p>';

                                    $est_dato="CANCELADA";



                                }



        $objPHPExcel->getActiveSheet()->SetCellValue("O$numFila", $est_dato);

        //$objPHPExcel->getActiveSheet()->setSharedStyle($datos, "N$numFila:N$numFila");//

        



        $objPHPExcel->getActiveSheet()->SetCellValue("P$numFila", $row_doc["obs_factura"]);

        $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "P$numFila:P$numFila");//





        /////////////************* REVISAR LOS PAGOS DE LA FACTURA 



            

            $sql_pagos="SELECT a.pago AS pagado, 

            (SELECT x.idcpd FROM alta_datos_ppd x WHERE x.id=a.idppd) AS iddatocpp

            FROM alta_pagos_ppd a WHERE a.idfactura=".$row_doc["id"]." AND a.tipo=".$row_doc["tipox"];



            $buscar_pagos=$db->sql_query($sql_pagos);



            $npago=0;



            while( $row_pagos=$db->sql_fetchrow($buscar_pagos) ){



                              

                ////VALIDAR QUE EL COMPLEMENTO DE PAGO ESTE FACTURADO 



                $sql_pagos2="SELECT a.estatus

                FROM alta_ppd a WHERE a.id=".$row_pagos["iddatocpp"];

                $buscar_pagos2=$db->sql_query($sql_pagos2);

                $row_pagos2=$db->sql_fetchrow($buscar_pagos2);

                               



                if ( $row_pagos2["estatus"] == 1 ) {

                

                    $npago=$npago+1;





                    switch ($npago) {

                        case 1:



                            $objPHPExcel->getActiveSheet()->SetCellValue("G$numFila", $row_pagos["pagado"]);

                            $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "G$numFila:G$numFila");//

                            $objPHPExcel->getActiveSheet()->getStyle("G$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



                        break;



                        case 2:



                            $objPHPExcel->getActiveSheet()->SetCellValue("H$numFila", $row_pagos["pagado"]);

                            $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "H$numFila:H$numFila");//
                            $objPHPExcel->getActiveSheet()->getStyle("H$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



                        break;



                        case 3:



                            $objPHPExcel->getActiveSheet()->SetCellValue("I$numFila", $row_pagos["pagado"]);

                            $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "I$numFila:I$numFila");//
                            $objPHPExcel->getActiveSheet()->getStyle("I$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



                        break;



                        case 4:



                            $objPHPExcel->getActiveSheet()->SetCellValue("J$numFila", $row_pagos["pagado"]);

                            $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "J$numFila:J$numFila");//
                            $objPHPExcel->getActiveSheet()->getStyle("J$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');



                        break;

                        

                      

                    }



                }



            }





        //////********** AUMENTAR UNA FILA AL FINALIZAR EL NUMERO DE PAGOS



        $numFila+=1;





        ////////************** REVISAR SI LA FACTURA TIENE NOTAS DE CREDITO 





        /*if ( $row_doc["tipox"]==0 ) {



            ////// ALTA_FACTURA

            $sql_nota="SELECT a.uuid,a.id,a.ftimbrado,CONCAT('',b.serie,b.folio) AS folio_nota,a.total, CONCAT_WS('',c.serie,c.folio) AS fol_factura

            FROM alta_nota_credito a, folio_nota_credito b, folio_factura c

            WHERE a.idfolio=b.id

            AND (SELECT z.idfolio FROM alta_factura z WHERE z.id=a.idfactura)=c.id

            AND a.estatus=1

            AND a.idfactura=".$row_doc["id"];

            

        }elseif ( $row_doc["tipox"]==1 ) {



            /////// ALTA FACTURA SUSTITUCION

            $sql_nota="SELECT a.uuid,a.id,a.ftimbrado,CONCAT('',b.serie,b.folio) AS folio_nota,a.total, CONCAT_WS('',c.serie,c.folio) AS fol_factura

            FROM alta_nota_credito a, folio_nota_credito b, folio_factura c

            WHERE a.idfolio=b.id

            AND (SELECT z.idfolio FROM alta_factura_sustitucion z WHERE z.id=a.idfactura)=c.id

            AND a.estatus=1

            AND a.idfactura=".$row_doc["id"];



        }



        



        $buscar_nota=$db->sql_query($sql_nota);

        while( $row_nota=$db->sql_fetchrow($buscar_nota) ){



                $relacion="Relacionada a la factura:".$row_nota["fol_factura"];





                $objPHPExcel->getActiveSheet()->SetCellValue("B$numFila", $row_nota["uuid"]);

                $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "B$numFila:B$numFila");//



                $objPHPExcel->getActiveSheet()->SetCellValue("C$numFila", "Nota credito");

                $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "C$numFila:C$numFila");//



                $objPHPExcel->getActiveSheet()->SetCellValue("D$numFila", $row_nota["ftimbrado"]);

                $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "D$numFila:D$numFila");//



                $objPHPExcel->getActiveSheet()->SetCellValue("E$numFila", $row_nota["folio_nota"]);

                $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "E$numFila:E$numFila");//



                $objPHPExcel->getActiveSheet()->SetCellValue("F$numFila", $row_nota["total"]);

                $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "F$numFila:F$numFila");//

                $objPHPExcel->getActiveSheet()->getStyle("F$numFila")->getNumberFormat()->setFormatCode('_-$* #,##0.00_-;-$* #,##0.00_-;_-$* "-"??_-;_-@_-');




                $objPHPExcel->getActiveSheet()->SetCellValue("O$numFila", "ACTIVA");

                $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "O$numFila:O$numFila");//



                $objPHPExcel->getActiveSheet()->SetCellValue("P$numFila", $relacion);

                $objPHPExcel->getActiveSheet()->setSharedStyle($datos, "P$numFila:P$numFila");//



            $numFila+=1;



        }*/





    }





$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$titulo_excel='cxc'.date("Ymd").'_'.$nombre.'.xlsx';

//$titulo_excel="prueba_excel9.xlsx";

$objWriter->save('reporte/'.$titulo_excel);

//header('Content-type: application/json');

echo json_encode($titulo_excel);

