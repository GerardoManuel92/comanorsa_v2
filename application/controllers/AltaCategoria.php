<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'third_party/ssp.php';

class AltaCategoria extends CI_Controller
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
    }

    public function altaCategoria()
    {
        $iduser = $this->session->userdata(IDUSERCOM);

        $numero_menu = 7;

        ////////******* verificar menu 

        $vtabla = "menus_departamento";
        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);
        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);

        if ( $verificar_menu > 0 ) {

            $idcategoria = $this->uri->segment(3);
           
            if($iduser > 0){

                if ( $idcategoria == 0 ) {
                #NUEVA PARTIDA

                $titulo = "<i class='fa fa-star'></i> Nueva Categoria";

                }else{

                    //// sql de partes

                    $titulo = "<i class='fa fa-edit' style='color:yellow;'></i> Actualizar Categoria";
                    

                }

                $data["titulox"]= $titulo;
                $dmenu["nommenu"] = "categoria";

                $this->load->view('general/header');
                $this->load->view('general/css_select2');
                $this->load->view('general/css_datatable');
                $this->load->view('general/menuv2');
                $this->load->view('general/menu_header',$dmenu);
                $this->load->view('categoria/alta_categoria',$data);
                $this->load->view('general/footer');
                $this->load->view('categoria/acciones_alta_categoria');

            }else{

                redirect("Login");

            }

        }else{

            redirect("AccesoDenegado");

        } 
       
    }


    public function altaNewcategoria(){

        $data_post = $this->input->post();

        

        $table = "alta_categoria";
        $condicion = array( 'descripcion' => $data_post['categoria'], 'estatus' => 0 );

        $repeat = $this->General_Model->verificarRepeat($table,$condicion);

        if ( $repeat > 0) {
            
            echo json_encode(0);

        }else{

            $data = array(

            'descripcion' => $data_post['categoria'],
            
            );

            echo json_encode( $this->General_Model->altaERP($data,$table) );

        }
        
        

    }

    public function Actcat(){

        $data_post = $this->input->post();

        $table = "alta_categoria";
        $condicion = array( 'descripcion' => $data_post['categoria'], 'estatus' => 0, 'id!=' => $data_post['idcatx']);

        $repeat = $this->General_Model->verificarRepeat($table,$condicion);

        if ( $repeat > 0) {
            
            echo json_encode(0);

        }else{

            $datos = array(

            'descripcion' => $data_post['categoria'],
            
            );

            $condicion = array('id' => $data_post['idcatx'] );

            echo json_encode( $this->General_Model->updateERP($datos,$table,$condicion) );

        }

    }

    public function deleteCat(){

        $data_post = $this->input->post();

        $datos = array(

            'estatus' => 1
            
        );
        $table = "alta_categoria";
        $condicion = array('id' => $data_post['idcat'] );

        echo json_encode( $this->General_Model->updateERP($datos,$table,$condicion) );
    }


    ///////////****************TABLA PARTIDAS BITACORA

        public function loadPartidas()
        {

            $iduser = $this->session->userdata(IDUSERCOM);


            $table = "( SELECT id,descripcion AS categoria FROM alta_categoria WHERE estatus = 0 ORDER BY descripcion ASC )temp"; 
  
            // Primary key of table
            $primaryKey = 'id';
            
            $columns = array(

                /*<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Default <span class="caret"></span>
                                  </button>*/

                array( 'db' => 'id',     'dt' => 0,

                        'formatter' => function( $d, $row ) {

                            return '<div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                        
                                        <li><a href="javascript:editarCat()" style="color:#FFC300;"> <i class="fa fa-pencil"></i> Editar</a></li>
                                        
                                        <li role="separator" class="divider"></li>

                                        <li><a href="javascript:deleteCat('.$d.')" style="color:red;"><i class="fa fa-trash"></i> Eliminar</a></li>
                                      </ul>
                                    </div>';

                        }  
                ),

                //array( 'db' => 'categoria',     'dt' => 1 ) 

                array( 'db' => 'categoria',     'dt' => 1,

                        'formatter' => function( $d, $row ) {

                            return utf8_encode($d);

                        }
                ),

                array( 'db' => 'id',     'dt' => 2)           
           
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


            echo json_encode(
                SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns)
            );


        }



}