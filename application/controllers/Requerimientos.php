<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class Requerimientos extends CI_Controller

{



    /**

     * Index Page for this controller.

     *

     * Maps to the following URL

     *         http://example.com/index.php/welcome

     *    - or -

     *         http://example.com/index.php/welcome/index

     *    - or -

     * Since this controller is set as the default controller in

     * config/routes.php, it's displayed at http://example.com/

     *

     * So any other public methods not prefixed with an underscore will

     * map to /index.php/welcome/<method_name>

     * @see https://codeigniter.com/user_guide/general/urls.html

     */



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



        $iduser = $this->session->userdata(IDUSERCOM);



        $numero_menu = 16;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



            if($iduser > 0){



                $data["idusuario"]= $iduser;

                //$mensaje['verificacion'] = "Ingreso correctamente por cookie";

                $nom_menu["nommenu"] = "requerimientos";



                $this->load->view('general/header');

                $this->load->view('general/menuv2');

                $this->load->view('general/css_select2');

                $this->load->view('general/css_datatable');

                $this->load->view('general/menu_header',$nom_menu);

                $this->load->view('requerimientos/reporte_rq');

                $this->load->view('general/footer');

                $this->load->view('requerimientos/acciones_reporte_rq');



            }else{

           

                redirect("Login");

                

            }



        }else{



            redirect('AccesoDenegado');



        }

       

    }



    public function cancelarOrden(){



        $data_post=$this->input->post();



        /////////////no hay que verificar por que las partidas de entrada tiene odc y falta validar el id de entrada



            $condicion = array('idoc'=>$data_post["odcx"], 'identrada>'=>0 );

            $tabla="partes_entrada";

            $verificar=$this->General_Model->verificarRepeat($tabla,$condicion);



            if ( $verificar>0 ) {



                //el articulo tiene entradas

                echo json_encode(0);



            }else{



                //borramos entrada

                $condicion2 = array('idoc'=>$data_post["odcx"]);

                $tabla2="partes_entrada";

                $this->General_Model->deleteERP($tabla2,$condicion2);



                ////cambiamos el estatus de la odc 

                $datos3 = array('estatus' => 2, );

                $condicion3 = array('id'=>$data_post["odcx"]);

                $tabla3="alta_oc";

                $this->General_Model->updateERP($datos3,$tabla3,$condicion3);



                /// regresamos las partidas a asignar

                $datos4 = array('idproveedor' => 1,'idoc'=>0 );

                $condicion4 = array('idoc'=>$data_post["odcx"]);

                $tabla4="partes_asignar_oc";

                $this->General_Model->updateERP($datos4,$tabla4,$condicion4);



                echo json_encode(1);



            }



    }





    ///////////****************TABLA PARTIDAS BITACORA


        public function searchRows(){

            $data_post = $this->input->post();
            $sql="SELECT COUNT(*) AS total FROM alta_entrada WHERE idoc =".$data_post["idODC"];
            $datos = $this->General_Model->infoxQueryUnafila($sql);
            echo json_encode($datos->total); 
            
        }

        public function finallyEntrada(){

            $data_post = $this->input->post();
            $data = array('estatus' => $data_post["estatus"]);
            $condition = array('id'=>$data_post["idODC"]);
            $table="alta_oc";
            echo json_encode($this->General_Model->updateERP($data,$table,$condition));
            
        }

        public function showRQ(){

            $data_post = $this->input->post();    
            $sql = "SELECT ap.clave AS clave, ap.descripcion AS descripcion, scu.abr AS unidad, pr.cantidad AS cantidad, pr.cantidad_rq AS cantidad_rq
                            FROM partes_rq pr, alta_rq ar, alta_productos ap, sat_catalogo_unidades scu
                            WHERE pr.idrq = ar.id
                            AND pr.idparte = ap.id
                            AND ap.idunidad = scu.id
                            AND ar.id =".$data_post["idRq"];
    
            echo json_encode( $this->General_Model->infoxQuery($sql) );
    
        }

        public function cancelarRQ(){
            $data_post = $this->input->post();    
            
            $dataRq = array('estatus' => 1);
            $conditionRq = array('id'=>$data_post["idRq"]);
            $tableRq="alta_rq";
            $this->General_Model->updateERP($dataRq,$tableRq,$conditionRq);                                    
        
            $dataPrq = array('estatus' => 1);
            $conditionPrq = array('idrq'=>$data_post["idRq"]);
            $tablePrq="partes_rq";
            $this->General_Model->updateERP($dataPrq,$tablePrq,$conditionPrq);
            

            echo json_encode( TRUE );

        }



        public function loadPartidasEst()

        {

            $iduser = $this->session->userdata('iduserformato');
            $data_get = $this->input->get();

            if ( $data_get['est'] == 6 ) {

                $table = "(SELECT ar.id AS id, CONCAT_WS('/',ar.id,ar.estatus) AS acciones, ar.fecha AS fecha, au.nombre AS solicito, ar.documento AS documento
                            FROM alta_rq ar, alta_usuarios au
                            WHERE ar.idusuario = au.id)temp";            

            }else{

                $table = "(SELECT ar.id AS id, CONCAT_WS('/',ar.id,ar.estatus) acciones, ar.fecha AS fecha, au.nombre AS solicito, ar.documento AS documento
                            FROM alta_rq ar, alta_usuarios au
                            WHERE ar.idusuario = au.id
                            AND ar.estatus=".$data_get['est'].")temp";

            } 

            // Primary key of table
            $primaryKey = 'id';

            $columns = array(

                array( 'db' => 'acciones',     'dt' => 0,
                        'formatter' => function( $d, $row ) {
                            $separar = explode("/", $d);

                            switch ($separar[1]) {
                                case 0:                                
                                    //$boton = '<a class="btn btn-success" href="'.base_url().'Entradaoc/folioOc/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';

                                    $boton='<div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                                                      
                                      <li><a href="javascript:cancelarRQ('.$separar[0].')" style="color:darkred; font-weight:bold;"> <i class="fa fa-close" style="color:red; font-weight:bold;"></i> Cancelar RQ</a></li>
                                      </ul>
                                    </div>';
                                break;
                                case 1:
                                
                                    ///$boton = '<a class="btn btn-success" href="'.base_url().'Entradaoc/folioOc/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';

                                    /* $boton='<div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                      <li><a href="javascript:cancelarRQ('.$separar[0].')" style="color:darkgreen; font-weight:bold;"> <i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Reactivar RQ</a></li>
                                      </ul>
                                    </div>'; */

                                    
                                    $boton = "";
                                break;
                                case 1:
                                    $boton ='';
                                break;

                               default:
                                    $boton = '';
                               break;
                            }
                            return $boton;
                        }  

                ),

                array( 'db' => 'acciones',     'dt' => 1,

                        'formatter' => function( $d, $row ) {
                            $separar = explode("/", $d);

                            switch ($separar[1]) {

                                case 0:                            
                                    $boton = '<p style="color:darkgreen; font-weight:bold;" > Activa</p>';
                                break;

                                case 1:                            
                                     $boton = '<p style="color:darkred; font-weight:bold;" > Cancelada</p>';
                                break;                                
                               

                            }
                            return $boton;
                        }  
                ),

                array( 'db' => 'fecha',     'dt' => 2,
                        'formatter' => function( $d, $row ) {
                            return obtenerFechaEnLetra($d);
                        }  
                ),

                array( 'db' => 'solicito',     'dt' => 3),

                array( 'db' => 'documento',     'dt' => 4,
                        'formatter' => function( $d, $row ) {
                            return '<a href="'.base_url().'tw/php/requerimientos/'.$d.'.pdf" target="_blank">'.$d.'</a>';                           
                        }
                ),
                
                array( 'db' => 'id',     'dt' => 5,
                        'formatter' => function( $d, $row ) {
                            $separar = explode("/",$d);
                            return ($separar[0]);
                        }  
                )
           
            );

            $sql_details = array(
                'user' => USERDB,
                'pass' => PASSDB,
                'db'   => DBB,
                'host' => 'localhost'
            );
        
            echo json_encode(
                SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns)
            );
        }

}