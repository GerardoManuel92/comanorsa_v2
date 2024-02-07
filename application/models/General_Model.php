<?php

class General_Model extends CI_Model {
	
      function __construct() { 
         parent::__construct(); 
      } 
   

      /////********* INSERCION GENERAL
      public function altaERP($data,$table) { 

         $this->db->insert($table, $data);

         $last_insert = $this->db->insert_id();

         if(   $this->db->affected_rows() > 0  ){

            /*
            ////********INGRESAR A BITACORA
            $this->db->insert('alta_bitacora', $form);
            */   
            ///////*******

            return $last_insert;
            

         }else{

            return null;

         }

      }

      //////7******** MOSTRAR INFO SELECT
      public function showSelect($data,$tabla,$condicion){


           $this->db->select($data);
           $this->db->from($tabla);
           $this->db->where($condicion);
           $this->db->order_by("descripcion", "asc");

           $query_info=$this->db->get();

           return $query_info->result();

      }

      //////7******** MOSTRAR INFO SELECT ORDER BY
      public function showSelectOrder($data,$tabla,$condicion,$order){


           $this->db->select($data);
           $this->db->from($tabla);
           $this->db->where($condicion);
           $this->db->order_by($order, "asc");

           $query_info=$this->db->get();

           return $query_info->result();

      }

      ////////**************VACIAR TABLAS

      public function vaciarTabla($tabla){

        $this->db->truncate($tabla);

        return true;

      }

      //////7******** MOSTRAR INFO SELECT SIN ORDER
      public function SelectsinOrder($data,$tabla,$condicion){


           $this->db->select($data);
           $this->db->from($tabla);
           $this->db->where($condicion);

           $query_info=$this->db->get();

           return $query_info->result();

      }

      //////7******** MOSTRAR INFO SELECT SIN ORDER, SIN CONDICION
      public function SelectsinOrdersinCondicion($data,$tabla){


           $this->db->select($data);
           $this->db->from($tabla);

           $query_info=$this->db->get();

           return $query_info->result();

      }

      //////7******** SELECCIONA QUERY UNA SOLA FILA
      public function SelectUnafila($data,$tabla,$condicion){


           $this->db->select($data);
           $this->db->from($tabla);
           $this->db->where($condicion);

           $query_info=$this->db->get();

           //$qdata= $query->row();

           return $query_info->row();

      }

      ////////****** VERIFICAR SI YA SE ENCUENTRA EL CONCEPTO
      public function verificarRepeat($tabla,$condicion){


           $this->db->select('id');
           $this->db->from($tabla);
           $this->db->where($condicion);
           //$this->db->where('folio',$folio);

           $query = $this->db->get();
           return $query->num_rows();

      }

      //// *********** VERIFICAR REPEAT SQL

      public function verificarRepeatSql($query){

        $mquery2 = $this->db->query($query);
        $cant = $mquery2->num_rows();

        if($cant>0) {
            
         return $mquery2->row();  

        }else{

            return null;

        }


      }


      //////*********** ACTUALIZACION
      public function updateERP($datos,$tabla,$condicion){

         $this->db->where($condicion);
         $this->db->update($tabla, $datos);

         if( $this->db->affected_rows() > 0){

         return true;

         }else{

         return false;

         }

      }

      /////////////******** ACTUALIZAR POR UN QUERY TRADICIONAL
      public function infoxQueryUpt($query){

        $mquery2 = $this->db->query($query);

        if( $this->db->affected_rows() > 0 ){

         return true;

        }else{

         return false;

        }

        

      }

      /////////******** ELIMINAR DATOS

      public function deleteERP($tabla,$condicion){

        $this->db->where($condicion);
        $this->db->delete($tabla);

        if( $this->db->affected_rows() > 0){

          return true;

        }else{

          return false;

        }
      }  


      /////////////******** REVISAR EL FOLIO PARA REINICIARSE AL AÑO NUEVO
      public function verificarFolioxAno(){

        $ano_actual = date("Y");
        $mquery2 = $this->db->query('SELECT fecha FROM `alta_proyecto` WHERE estatus = 0 ORDER BY id DESC LIMIT 0,1');
        $qdata= $mquery2->result();

            foreach($qdata as $r) {
               
               $sep1 = explode("-", $r->fecha);
               //$iduser = $r->id."/".$r->correo."/".$r->puesto."/".$r->nombre."/".$r->iddepartamento;

            }

        

        $ano_ant = $sep1[0];

        if( $ano_actual == $ano_ant ){

          $mquery3 = $this->db->query('SELECT COUNT(id) AS idtotal FROM `alta_proyecto` WHERE estatus = 0 AND fecha BETWEEN "'.$ano_actual.'-01-01" AND "'.$ano_actual.'-12-31" ');
          

          foreach($mquery3->result() as $x) {
               
               return  $x->idtotal + 1;

          }

           

        }elseif ( $ano_actual > $ano_ant ) {


          return 1;

        }


      }

      /////////////******** OBTENER INFORMACION POR UN QUERY TRADICIONAL
      public function infoxQuery($query){

        $mquery2 = $this->db->query($query);

        $cant = $mquery2->num_rows();

        if( $cant > 0  ){

          return $mquery2->result();

        }else{

          return null;

        }

        

      }

      /////////////******** OBTENER INFORMACION POR UN QUERY TRADICIONAL
      public function crearTabla($query){

        $this->db->query($query);

        return true;

      }

      /////////////******** OBTENER INFORMACION POR UN QUERY TRADICIONAL UNA SOLA FILA
      public function infoxQueryUnafila($query){

        $mquery2 = $this->db->query($query);

        $cant = $mquery2->num_rows();

        if( $cant > 0  ){

          return $mquery2->row();

        }else{

          return null;

        }

        

      }

      ///////********************* VERIFICACION DEL LOGIN Y EXTRAERLA INFROMACION DEL USUARIO
      public function verificarLogin($data) { 

         $iduser = 0;

          $query = $this->db->get_where("alta_usuarios",$data);

          $mnumpro = $query->num_rows();

         if($mnumpro > 0){

            $qdata= $query->result();

            foreach($qdata as $r) {
               
              $iduser=$r->id."/".$r->nombre."/".$r->iddepartamento."/".$r->correo;

            }  

         }else{

            $iduser=0;

         }

         return $iduser;
      }


} 
   
?> 