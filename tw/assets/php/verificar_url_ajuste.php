<?php

	include("config.php"); 
	include("includes/mysqli.php");
	include("includes/db.php");
	set_time_limit (600000);
	date_default_timezone_set('America/Mexico_City');

	$archivo = trim($_POST["archivo"]);///archivo, ya no es url
	$idcot = trim($_POST["folio"]);

	/*   //abrimos el archivo en lectura
	   $id = @fopen($url,"r");
	   //hacemos las comprobaciones
	   if ($id) $abierto = verdadero;
	   else $abierto = falso;
	   //devolvemos el valorverificar_url
	   //echo $abierto;
	   //cerramos el archivo
	   fclose($id);

	*/

	   $abierto = true;

	   if ($abierto) {
	   	
	   		$sql = "UPDATE `alta_ajuste_entrada` SET `documento` = '".$archivo."', `estatus` = 4 WHERE `id`=".$idcot;
	   		$db->sql_query($sql);

	   		///////////****************** HABILITAR ODC
			/*
	   		$sqlx = "SELECT idparte,cantidad,id,iva,costo_proveedor,costo,descuento,descripcion,orden FROM `partes_cotizacion` WHERE idcotizacion = ".$idcot." AND estatus = 0";
	   		$buscarx = $db->sql_query($sqlx);
	   		$npartes = 0;

	   		while ( $rowx=$db->sql_fetchrow($buscarx) ) {
         
                ////// ACTUALIZAR LAS NUEVAS PARTIDAS DE LA COTIZACION

                $sql_odc = "INSERT INTO `partes_asignar_oc` (`id`, `fecha`, `hora`, `idcot`, `idpartecot`, `idoc`, `cantidad`, `cantidad_oc`, `idparte`, `idproveedor`, `costo_proveedor`, `costo`, `iva`, `descuento`, `estatus`) VALUES (NULL, '".date('Y-m-d')."', '".date('Y-m-d')."', '".$idcot."', '".$rowx['id']."', '0', '".$rowx['cantidad']."', '0', '".$rowx['idparte']."', '1', '".$rowx['costo_proveedor']."', '".$rowx['costo']."', '".$rowx['iva']."', '0', '0')";
                $db->sql_query($sql_odc);

                ///// ENTREGA

                $sql_entrega = "INSERT INTO `partes_entrega` (`id`, `fecha`, `hora`, `identrega`, `idtipo`, `idfolio`, `idpartefolio`, `cantidad`, `estatus`) VALUES (NULL, '".date('Y-m-d')."', '".date('H:i:s')."', '0', '1', '".$idcot."', '".$rowx['id']."', '".$rowx['cantidad']."', '0')";
                $db->sql_query($sql_entrega);

                $npartes = $npartes+1;

            }  

            if ( $npartes > 0 ) {
              
              $uptdata = array('odc' => 1 );
              $upttable = "alta_cotizacion";
              $uptcondicion = array('id' => $data_post["idcot"]);
              $this->General_Model->updateERP($uptdata,$upttable,$uptcondicion);

              $upt_cot = "UPDATE alta_cotizacion SET odc = 1 WHERE id=".$idcot;
              $db->sql_query($upt_cot);

            }

            //echo json_encode( $npartes );
			*/

	   		echo json_encode(true);

	   }else{

	   		echo json_encode(false);

	   }

?> 

