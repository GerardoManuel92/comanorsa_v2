<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ActProducto extends CI_Controller
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
                array('&ntilde;', '&Ntilde;', 'ç', 'Ç'),
                array('n', 'N', 'c', 'C',),
                $string
            );
         
            //Esta parte se encarga de eliminar cualquier caracter extraño
            $string = str_replace(
                array('º', '~','!','&','´',';','"',),
                array('','','','&amp;','','','&quot;'),
                $string
            );
         
         
            return $string;
        }
        
    }

    public function actualizar()
    {
        $iduser = $this->session->userdata(IDUSERCOM);

        $numero_menu = 1;

        ////////******* verificar menu 

        $vtabla = "menus_departamento";
        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);
        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);

        if ( $verificar_menu > 0 ) {
       
            if($iduser > 0){

                $dmenu["nommenu"] = "actproductos";
                $idpro = $this->uri->segment(3);

                    $titulo = "<i class='fa fa-edit' style='color:yellow;'></i> Actualizar Partida";

                    $datos = "clave,nparte,sat,idcategoria,idsubcategoria,descripcion,idmarca,idunidad,cb,maxmin,maximo,minimo,iva,costo,utilidad,precio,cimpuesto,tasa,tags,moneda,img,porciento_riva,porciento_risr";
                    $tabla = "alta_productos";
                    $condicion = array('id' => $idpro );

                    $infodatos = array( 'info' => $this->General_Model->SelectUnafila($datos,$tabla,$condicion), 'titulox' =>$titulo, 'idprox' => $idpro );

                $this->load->view('general/header');
                $this->load->view('general/css_select2');
                $this->load->view('general/css_upload');
                $this->load->view('general/css_autocompletar');
                $this->load->view('general/menuv2');
                $this->load->view('general/menu_header',$dmenu);
                $this->load->view('productos/actualizar_producto',$infodatos);
                $this->load->view('general/footer');
                $this->load->view('productos/acciones_actualizar_producto');

            }else{

                redirect("Login");

            }

        }else{

            redirect("AccesoDenegado");

        } 
       
    }


    public function showUnidades(){

        $query="SELECT clave,descripcion,id FROM `sat_catalogo_unidades` WHERE estatus = 0 ORDER BY descripcion ASC";

            echo json_encode( $this->General_Model->infoxQuery($query) );

    }

    public function showMarcas(){

        $query="SELECT id,marca FROM `alta_marca` WHERE estatus = 0 ORDER BY marca ASC";

            echo json_encode( $this->General_Model->infoxQuery($query) );

    }


    public function showCategoria(){

        $query="SELECT id,descripcion FROM `alta_categoria` WHERE estatus = 0 ORDER BY descripcion ASC";

            echo json_encode( $this->General_Model->infoxQuery($query) );

    }

    public function showSubcategoria(){

        $data_post = $this->input->post();

        $query="SELECT id,descripcion FROM `alta_subcategoria` WHERE estatus = 0 AND idcategoria = ".$data_post['idcatx']." ORDER BY descripcion ASC";

            echo json_encode( $this->General_Model->infoxQuery($query) );

    }

    public function showTags(){

        $data_post = $this->input->post();

        $query="SELECT tags FROM `alta_productos` WHERE id = ".$data_post['idpro'];

            echo json_encode( $this->General_Model->infoxQueryUnafila($query) );

    }


    public function altaTags(){

        $data_post = $this->input->post();

        $sql = "UPDATE `alta_productos` SET tags = CONCAT_WS(',',tags,'".$data_post['tagx']."') WHERE id =".$data_post['idpro'];
        $actualizar = $this->General_Model->infoxQueryUpt($query);

        if ( $actualizar ) {
            
            $data2 = array( 'tag' =>$data_post['tagx'], 'idparte' => $data_post['idpro'] );
            $table2 = "alta_tags";
            $this->General_Model->altaERP($data2,$table2);

        }

        echo json_encode( $actualizar );

    }

    public function buscarxdescrip(){

        $this->load->model('Model_Buscador');
        $data = $this->input->get();

        if( strlen($data['clv']) > 0    ){

            echo json_encode(   $this->Model_Buscador->buscarSatclave2($data['clv'])    );  

        }else{

            $arrayName []= array('id' => 0, 'descrip'=>"");

            echo json_encode(   $arrayName  );

        }

    }

    public function vClave(){

        $data_post = $this->input->post();

        $condicion = array('clave' => $data_post["clave"], 'estatus' => 0, 'id!=' => $data_post["idpro"] );
        $tabla = "alta_productos";

        echo json_encode(  $this->General_Model->verificarRepeat($tabla,$condicion) );


    }


    public function actPartida(){

        $data_post = $this->input->post();

        if ( $data_post['maximox'] > 0 and $data_post['minimox'] > 0) {

            $almacen = 1;
            
        }else{

            $almacen = 0;

        }

        $data = array(

            'fecha' => date('Y-m-d'),
            'nparte' => $data_post['clavex'],
            'idcategoria' => $data_post['categoriax'],
            'descripcion' => changeString($data_post['descripx']),
            'idmarca' => $data_post['marcax'],
            'idunidad' => $data_post['unidadx'],
            'cb' => $data_post['cbx'],
            'maxmin'=> $almacen,
            'maximo'=> $data_post['maximox'],
            'minimo'=> $data_post['minimox'],
            'iva' => $data_post['ivax'],
            'cimpuesto' => $data_post['cimpuestox'],
            'tasa' => $data_post['tasax'],
            'costo' => $data_post['costox'],
            'utilidad' => $data_post['utilidadx'],
            'precio' => $data_post['preciox'],
            'moneda' => $data_post['monedax'],
            'sat' => $data_post['satx'],
            'porciento_riva' => $data_post["riva_valor"],  
            'porciento_risr' => $data_post["risr_valor"],
            'tags' => $data_post['tagx'],
            'imagen' => $data_post["imgpro"]

        );

        $table = "alta_productos";

        $condicion = array( 'id' => $data_post["idprox"] );

        $last_id=$this->General_Model->updateERP($data,$table,$condicion);
        

        //////////****** INSERTAR TAGS

        if ( $last_id ) {

            ////********** borramos el contenido anterior de tagx

            $table2 = "alta_tags";
            $dcondicion = array( 'idparte' => $data_post["idprox"] );

            $this->General_Model->deleteERP($table2,$dcondicion);

            //////********
            $array_sep =explode(",",$data_post['tagx']);
            

            for ($i=0; $i <count($array_sep); $i++) { 
                
                $data2 = array(

                    'idparte' => $data_post["idprox"],
                    'tag' => $array_sep[$i]

                );

                $this->General_Model->altaERP($data2,$table2);

            }


            ///////***** RETIRAR LA IMAGEN SI SE SOLICITO SU RETIRO 

            if ( $data_post["retirar"] == 1 ) {

                $datos = array('img' => 0 );
                $tabla = "alta_productos";
                $condicion = array('id' => $data_post["idprox"] );

                $this->General_Model->updateERP($datos,$tabla,$condicion);
                
            }

            ///////**************** CAMBIAR LA IMAGEN DE LUGAR Y COLOCAR SU ID

            if ( $data_post["imgpro"] != "" ) {

                rename( 'tw/js/upload_producto/files/'.$data_post["imgpro"] , 'comanorsa/productos/'.$data_post["idprox"].'.jpg' );

                $datos = array('img' => 1 );
                $tabla = "alta_productos";
                $condicion = array('id' => $data_post["idprox"] );

                $this->General_Model->updateERP($datos,$tabla,$condicion);

            }

            echo json_encode( $last_id );

        }else{

            echo json_encode(false);

        }


    }
   

}
