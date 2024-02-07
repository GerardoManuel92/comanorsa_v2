<?php 

   	class Model_Buscador extends CI_Model {
	
      	function __construct() { 

        	parent::__construct(); 
  
    	}


    	public function buscarSatclave($descripcion){

        	$buscar =trim($descripcion);

        	if( strlen($descripcion)>2 ){

	            $mquery2 = $this->db->query("SELECT CONCAT_WS(' - ',clave,descripcion) AS descripcionx,id FROM `sat_catalogos_clvproveedor` WHERE clave LIKE '%".$descripcion."%' OR descripcion LIKE '%".$descripcion."%' ");
	            
	            $nproductos = $mquery2->num_rows();

	            if( $nproductos > 0 ){

	              return $mquery2->result();

	            }else{

	              $arrayName= array('id' => 0, 'descripcionx'=>"Sin articulos en busqueda");

	              return $arrayName;

	            }

	            //return $mquery2;

          	}else{

            	$arrayName= array('id' => 0, 'descripcionx'=>"");
            	return $arrayName;

          	}
      }

            //////////***********************BUSCAR POR DESCRIPCION

      public function buscarSatclave2($descripcion){

          $buscar =trim($descripcion);
          ///////////*************IDENTIFICAR LOS ENLAZADORES DE TEXTO Y  SEPARAR LAS PALABRAS CLAVES
          $separador = explode(" ", $buscar);
          $busqueda = "";
          $total_separador = count($separador);


          for ($i=0; $i < $total_separador; $i++) { 

              if( $separador[$i] != 'de' and $separador[$i] != "la" and $separador[$i] != "las" and $separador[$i] != "lo" and $separador[$i] != "los" and $separador[$i] != "con" and $separador[$i] != "en" and $separador[$i] != "para" and $separador[$i] != "a" and $separador[$i] != "e"  and $separador[$i] != "y"  and $separador[$i] != "i"  and $separador[$i] != "o"  and $separador[$i] != "u" ){


                      if( $busqueda == "" ){


                          $busqueda = $busqueda."CONCAT_WS('',descripcion,similares,clave) like '%".$separador[$i]."%' ";

                      }else{


                          $busqueda = $busqueda."AND  CONCAT_WS('',descripcion,similares,clave) like '%".$separador[$i]."%' ";

                      } 

              }

          }

          if( strlen($descripcion)>2 ){

            $mquery2 = $this->db->query("SELECT CONCAT_WS(' - ',clave,descripcion) AS descripcionx,id,clave 
              FROM sat_catalogos_clvproveedor WHERE (".$busqueda.") AND estatus = 0");
            //ORDER BY titulo ASC

            $nproductos = $mquery2->num_rows();

            if( $nproductos > 0 ){

              return $mquery2->result();

            }else{

              $arrayName []= array('id' => 0, 'descripcionx'=>"Sin articulos en busqueda");

              return $arrayName;

            }

            //return $mquery2;

          }else{

              $arrayName []= array('id' => 0, 'descripcionx'=>"");
              return $arrayName;

          }  

      }


      //////////////***********************************BUSCAR DESCRIPCION DE PRODUCTOS

      public function buscarProductos($descripcion){

          $buscar =trim($descripcion);
          ///////////*************IDENTIFICAR LOS ENLAZADORES DE TEXTO Y  SEPARAR LAS PALABRAS CLAVES
          $separador = explode(" ", $buscar);
          $busqueda = "";
          $total_separador = count($separador);


          for ($i=0; $i < $total_separador; $i++) { 

              if( $separador[$i] != 'de' and $separador[$i] != "la" and $separador[$i] != "las" and $separador[$i] != "lo" and $separador[$i] != "los" and $separador[$i] != "con" and $separador[$i] != "en" and $separador[$i] != "para" and $separador[$i] != "a" and $separador[$i] != "e"  and $separador[$i] != "y"  and $separador[$i] != "i"  and $separador[$i] != "o"  and $separador[$i] != "u" ){


                      if( $busqueda == "" ){


                          $busqueda = $busqueda."CONCAT_WS('',a.clave,a.nparte,a.descripcion,a.tags,c.marca) like '%".$separador[$i]."%' ";

                      }else{


                          $busqueda = $busqueda."AND  CONCAT_WS('',a.clave,a.nparte,a.descripcion,a.tags,c.marca) like '%".$separador[$i]."%' ";

                      } 

              }

          }

          if( strlen($descripcion)>2 ){

            $mquery2 = $this->db->query("SELECT a.id, CONCAT_WS(' - ',a.clave,a.nparte,a.descripcion,a.tags,c.marca) AS descripcionx,b.descripcion AS unidad, a.descripcion AS descrip, a.costo,(SELECT x.costo_proveedor FROM `partes_asignar_oc` x WHERE x.idparte = a.id AND x.idproveedor != 11 ORDER BY x.id DESC LIMIT 0,1) AS costo_new,a.iva,a.cimpuesto,a.utilidad,a.precio, a.porciento_riva, a.porciento_risr,CASE a.iva WHEN 1 THEN (SELECT x.iva FROM datos_generales x WHERE x.estatus = 0) WHEN 2 THEN '0' WHEN 3 THEN a.tasa END AS tasa
            FROM `alta_productos` a, sat_catalogo_unidades b, alta_marca c
            WHERE a.idunidad=b.id AND a.idmarca=c.id AND (".$busqueda.") AND a.estatus = 0");
            //ORDER BY titulo ASC

            $nproductos = $mquery2->num_rows();

            if( $nproductos > 0 ){

              return $mquery2->result();

            }else{

              $arrayName []= array('id' => 0, 'descripcionx'=>"Sin articulos en busqueda");

              return $arrayName;

            }

            //return $mquery2;

          }else{

              $arrayName []= array('id' => 0, 'descripcionx'=>"");
              return $arrayName;

          }  

      }


    }