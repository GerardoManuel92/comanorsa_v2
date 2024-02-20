<?php

defined('BASEPATH')or exit('No direct script access allowed');

include APPPATH.'third_party/ssp.php';



class Rgastos extends CI_Controller

{



    public function __construct()

    {



        parent::__construct();



        function changeString($string)

        {

         

            $string = trim($string);

         

            $string = str_replace(

                array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),

                array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),

                $string

            );

         

            $string = str_replace(

                array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),

                array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),

                $string

            );

         

            $string = str_replace(

                array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),

                array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),

                $string

            );

         

            $string = str_replace(

                array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),

                array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),

                $string

            );

         

            $string = str_replace(

                array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),

                array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),

                $string

            );

         

            $string = str_replace(

                array('ñ', 'Ñ', 'ç', 'Ç'),

                array('n', 'N', 'c', 'C',),

                $string

            );

         

            //Esta parte se encarga de eliminar cualquier caracter extraño

            $string = str_replace(

                array('º', '~','!','&','´',';','"','°'),

                array('','','','&amp;','','','&quot;',' grados'),

                $string

            );

         

         

            return $string;

        }



        function obtenerFechaEnLetra($fecha){

            $num = date("j", strtotime($fecha));

            $anno = date("Y", strtotime($fecha));

            $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

            $mes = $mes[(date('m', strtotime($fecha))*1)-1];

            return $num.'-'.strtoupper($mes).'-'.$anno;

        }



        function wims_currency($number) { 

           if ($number < 0) { 

            $print_number = "-$ " . str_replace('-', '', number_format ($number, 2, ".", ",")) . ""; 

            } else { 

             $print_number = "$ " .  number_format ($number, 2, ".", ",") ; 

           } 

           return $print_number; 

        }



        $this->load->model('General_Model');

      

    }



    public function index()

    {



        $iduser=$this->session->userdata(IDUSERCOM);



        $numero_menu = 11;/// se coloca el mismo identificador que el alta de cotizacion;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



          if($iduser > 0){



              $data["idusuario"]= $iduser;

              //$mensaje['verificacion'] = "Ingreso correctamente por cookie";

              $nom_menu["nommenu"] = "rgastos";



              $this->load->view('general/header');

              $this->load->view('general/menuv2');

              $this->load->view('general/css_select2');

              $this->load->view('general/css_upload');

              $this->load->view('general/css_datatable');

              $this->load->view('general/menu_header',$nom_menu);

              $this->load->view('pagos/rgastos');

              $this->load->view('general/footer');

              $this->load->view('pagos/acciones_rgastos');



          }else{

         

              redirect(base_url("Login/index"));

              

          }



        }else{



          redirect('AccesoDenegado');



        }

       

    }




    public function showClientes(){



        $query="SELECT id, nombre, comercial FROM `alta_clientes` WHERE estatus = 0 ORDER BY nombre ASC";

        echo json_encode( $this->General_Model->infoxQuery($query) );



    }



    public function showVendedor(){



        $query="SELECT id, nombre FROM `alta_usuarios` WHERE iddepartamento IN(2,1) AND estatus = 0 ORDER BY nombre ASC";

        echo json_encode( $this->General_Model->infoxQuery($query) );



    }



    public function habilitarOdc(){



      $data_post = $this->input->post();



      $sqlx = "SELECT idparte,cantidad,id,iva,costo_proveedor,costo,descuento,descripcion,orden FROM `partes_cotizacion` WHERE idcotizacion = ".$data_post["idcot"]." AND estatus = 0";



            //$partes = $this->General_Model->SelectsinOrder($data2,$tabla2,$condicion2);

            $partes = $this->General_Model->infoxQuery($sqlx);



            $npartes = 0;



            //////////////****

            $dtabla = "partes_asignar_oc";

            $dtabla2 ="partes_entrega";

            $dcondicion = array('idcot' => $data_post["idcot"] );

            $dcondicion2 = array('idfolio' => $data_post["idcot"] );



            $this->General_Model->deleteERP($dtabla,$dcondicion);



            $this->General_Model->deleteERP($dtabla2,$dcondicion2);



            foreach ($partes as $row) {



                ////// ACTUALIZAR LAS NUEVAS PARTIDAS DE LA COTIZACION



                /*$data3 = array( 'idcotizacion' => $data_post["idcot"], 'idparte' => $row->idparte, 'costo_proveedor' => $row->costo_proveedor,'cantidad' => $row->cantidad, 'costo' => $row->costo, 'iva' => $row->iva, 'descuento' => $row->descuento, 'descripcion' => $row->descripcion, 'orden' => $row->orden );



                $table3 = "partes_cotizacion";



                $this->General_Model->altaERP($data3,$table3);*/



                ////// ORDEN DE COMPRA



                $data3 = array( 'fecha' => date("y-m-d"), 'hora' => date("H:i:s"), 'idcot' =>$data_post["idcot"], 'idpartecot' => $row->id, 'cantidad'=> $row->cantidad, 'idparte'=> $row->idparte, 'idproveedor' => 1, 'costo' => $row->costo_proveedor, 'iva' => $data_post["idcot"] );



                $table3 = "partes_asignar_oc";



                $last_idoc = $this->General_Model->altaERP($data3,$table3);



                ///// ENTREGA



                $data3x = array( 'fecha' => date("y-m-d"), 'hora' => date("H:i:s"), 'idpartefolio' =>$row->id, 'idfolio' => $data_post["idcot"], 'cantidad'=> $row->cantidad, 'idtipo'=> 1);



                $table3x = "partes_entrega";



                $this->General_Model->altaERP($data3x,$table3x);



                $npartes = $npartes+1;



            }  



            if ( $npartes > 0 ) {

              

              $uptdata = array('odc' => 1 );

              $upttable = "alta_cotizacion";

              $uptcondicion = array('id' => $data_post["idcot"]);

              $this->General_Model->updateERP($uptdata,$upttable,$uptcondicion);



            }



            echo json_encode( $npartes );



    }



    public function subirEvidencia(){



      $data_post = $this->input->post();



        $uptdata = array('evidencia' => $data_post["evidencia"], 'estatus' => 4);

        $upttable = 'alta_cotizacion';

        $uptcondicion = array('id' => $data_post["idcotizacion"] );



      echo json_encode( $this->General_Model->updateERP($uptdata,$upttable,$uptcondicion) );



    }



    ///////////****************TABLA PARTIDAS BITACORA


        public function loadPartidasEstatus()

        {

            $iduser=$this->session->userdata(IDUSERCOM);
            $departamento=$this->session->userdata(PUESTOCOM);
            $data_post = $this->input->get();

              if ( $data_post['estatus'] == 6  ) {

                
                if ( $data_post["buscador"] == "" OR $data_post["buscador"] == null ) {

                  $table = "(SELECT CONCAT(id,'/',estatus) AS acciones, estatus, fecha, descripcion_original, descripcion_editada, importe, id FROM alta_gastos)temp";

                }
                else{

                    $table = "(SELECT CONCAT(id,'/',estatus) AS acciones, estatus, fecha, descripcion_original, descripcion_editada, importe, id FROM alta_gastos WHERE descripcion_editada LIKE '%".$data_post['buscador']."%' OR importe = '".$data_post['buscador']."')temp";

                }

              }
              else if ( $data_post['estatus'] == 0  ) {

                if ( $data_post["buscador"] == "" OR $data_post["buscador"] == null ) {

                  $table = "(SELECT CONCAT(id,'/',estatus) AS acciones, estatus, fecha, descripcion_original, descripcion_editada, importe, id FROM alta_gastos WHERE estatus = 0)temp";

                }
                else{

                    $table = "(SELECT CONCAT(id,'/',estatus) AS acciones, estatus, fecha, descripcion_original, descripcion_editada, importe, id FROM alta_gastos WHERE estatus = 0 AND (descripcion_editada LIKE '%".$data_post['buscador']."%' OR importe = '".$data_post['buscador']."'))temp";

                }

              }else if ( $data_post['estatus'] == 1  ){


                if ( $data_post["buscador"] == "" OR $data_post["buscador"] == null ) {

                  $table = "(SELECT CONCAT(id,'/',estatus) AS acciones,estatus, fecha, descripcion_original, descripcion_editada, importe, id FROM alta_gastos WHERE estatus = 1)temp";

                }
                else{

                    $table = "(SELECT CONCAT(id,'/',estatus) AS acciones, estatus, fecha, descripcion_original, descripcion_editada, importe, id FROM alta_gastos WHERE estatus = 1 AND (descripcion_editada LIKE '%".$data_post['buscador']."%' OR importe = '".$data_post['buscador']."'))temp";

                }


              }

            // Primary key of table

            $primaryKey = 'acciones';

            $columns = array(

              array( 'db' => 'acciones',     'dt' => 0,

                      'formatter' => function( $d, $row ) {   
                          
                        $acciones = explode("/", $d);

                        if($acciones[1] == 0){
                          return '<div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                        <li><a href="#" style="color:darkgreen; font-weight:bold;" data-toggle="modal" data-target="#modalDescripcion"> <i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Ver descripción</a></li>
                                        </ul>
                                    </div>';
                        }elseif ($acciones[1] == 1) {
                          return '<div class="btn-group">
                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
                                        <li><a href="#" style="color:darkgreen; font-weight:bold;" data-toggle="modal" data-target="#modalDescripcion"> <i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Ver descripción</a></li>
                                        <li><a href="#" onclick="cancelarAplicacion('.$acciones[0].');" style="color:darkred; font-weight:bold;"> <i class="fa fa-remove" style="color:darkred; font-weight:bold;"></i> Cancelar</a></li>
                                        </ul>
                                    </div>';
                        }                          
                        
                      }  

              ),

              array( 'db' => 'estatus',     'dt' => 1,

                      'formatter' => function( $d, $row ) {

                        if($d == 0){
                          return utf8_encode("Activo");
                        }else if($d == 1){
                          return utf8_encode("Aplicado");
                        }     

                      }  

              ),

              array( 'db' => 'fecha',     'dt' => 2,
                
                'formatter' => function( $d, $row ) {

                  return utf8_encode($d);
                        
                }
              ),


              array( 'db' => 'descripcion_editada', 'dt' => 3,

                      'formatter' => function( $d, $row ) {

                        return ($d);

                      }  

              ),

              array( 'db' => 'importe',     'dt' => 4,

                      'formatter' => function( $d, $row ) {

                          return utf8_encode($d);

                      }  

              ),

              array( 'db' => 'descripcion_original', 'dt' => 5,

                      'formatter' => function( $d, $row ) {

                          return ($d);
                      } 
              ),

              array( 'db' => 'id', 'dt' => 6,

                      'formatter' => function( $d, $row ) {

                          return utf8_encode($d);
                      } 
              ),
         
         

          );



            $sql_details = array(

                'user' => USERDB,

                'pass' => PASSDB,

                'db'   => DBB,

                'host' => 'localhost'

            );

            

            /*$sql_details = array(

                'user' => 'root',

                'pass' => '',

                'db'   => 'esmex_prueba',

                'host' => 'localhost'

            );*/


            $query = SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns);
            echo json_encode($query);

            
        }


      public function reconocerPago(){

        $iduser=$this->session->userdata(IDUSERCOM);
        $departamento=$this->session->userdata(PUESTOCOM);
        $data_post = $this->input->post();

        $uptdata = array('descripcion_editada' => $data_post["descripcion"], 'estatus' => 1);

        $upttable = "alta_gastos";

        $uptcondicion = array('id' => $data_post["id"]);

        //echo json_decode( $this->General_Model->updateERP($uptdata,$upttable,$uptcondicion));

        $datosActualizados = $this->General_Model->updateERP($uptdata, $upttable, $uptcondicion);

        $respuesta = array(
            'eject' => $datosActualizados,
            'fieldDescript' => $data_post["descripcion"],
            'fieldId' => $data_post["id"]
        );

        echo json_encode($respuesta);

      }

      public function cancelarAplicacion(){

        $iduser=$this->session->userdata(IDUSERCOM);
        $departamento=$this->session->userdata(PUESTOCOM);
        $data_post = $this->input->post();

        $uptdata = array('descripcion_editada' => $data_post["descripcion"], 'estatus' => 0);

        $upttable = "alta_gastos";

        $uptcondicion = array('id' => $data_post["id"]);

        $datosActualizados = $this->General_Model->updateERP($uptdata,$upttable,$uptcondicion);

        $respuesta = array(
          'eject' => $datosActualizados,
          'fieldDescript' => $data_post["descripcion"],
          'fieldId' => $data_post["id"]
      );

      echo json_encode($respuesta);

      }

      public function showCuentas(){

        $query="SELECT a.cuenta,b.comercial,a.id
                FROM alta_cuentas_comanorsa a, alta_bancos b
                WHERE a.idbanco=b.id AND a.estatus=0";

            echo json_encode( $this->General_Model->infoxQuery($query) );

    }


}