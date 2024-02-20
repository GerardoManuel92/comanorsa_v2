<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class Ordenxcliente extends CI_Controller

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

        function getFactura($idFactura){

            $ci =& get_instance();
            $documento = "";

            $class = $ci->db->query("
                SELECT CONCAT(ff.serie, ff.folio) AS factura FROM folio_factura ff, alta_factura af WHERE
                af.idfolio = ff.id AND af.id =".$idFactura."
            ");

            $class = $class->result_array();

            foreach($class as $row) {
                $documento=$row["factuta"];
            }

            return '<a href="'.base_url().'tw/php/facturas/cot'.$documento.'.pdf" target="_blank">'.$documento.'</a>';                

        }


        $this->load->model('General_Model');

      

    }



    public function index()

    {



        $iduser = $this->session->userdata(IDUSERCOM);



        $numero_menu = 2;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



            if($iduser > 0){



                $data["idusuario"]= $iduser;

                //$mensaje['verificacion'] = "Ingreso correctamente por cookie";

                $nom_menu["nommenu"] = "ordenxcliente";



                $this->load->view('general/header');

                $this->load->view('general/menuv2');
                
                $this->load->view('general/css_upload');

                $this->load->view('general/css_select2');

                $this->load->view('general/css_datatable');

                $this->load->view('general/menu_header',$nom_menu);

                $this->load->view('cliente/ordenxcliente');

                $this->load->view('general/footer');

                $this->load->view('cliente/accciones_ordenxcliente');



            }else{

           

                redirect("Login");

                

            }



        }else{



            redirect("AccesoDenegado");



        }

       

    }

    public function showCliente(){

        $query="SELECT id,rfc,nombre,comercial FROM `alta_clientes` WHERE estatus = 0 ORDER BY nombre ASC";
        echo json_encode( $this->General_Model->infoxQuery($query) );

    }

    public function showOC(){

        $query="SELECT id FROM alta_oc ORDER BY id ASC";
        echo json_encode( $this->General_Model->infoxQuery($query) );

    }





    public function retirarProducto(){



        $data_post = $this->input->post();



        $datos = array('estatus' => 1);

        $tabla = "alta_productos";

        $condicion = array( 'id' => $data_post["idpro"] );



        echo json_encode( $this->General_Model->updateERP($datos,$tabla,$condicion) );



    }





    ///////////****************TABLA PARTIDAS BITACORA



        public function loadPartidas()

        {

            $iduser = $this->session->userdata('iduserformato');

            if (isset($_GET['idClient']) || isset($_GET['estatus'])) {

                $data_get = $this->input->get();

                if($data_get["idClient"]>0 AND $data_get["estatus"] != 6){
                    $table = "(SELECT oxc.id, CONCAT_WS('/',oxc.id,oxc.estatus) AS acciones, CONCAT(ac.nombre, ' ',ac.comercial) AS cliente,
                        oxc.idfactura AS factura, oxc.idoc AS oc, oxc.folio AS folio, oxc.evidencia AS evidencia
                        FROM ordenxcliente oxc, alta_clientes ac
                        WHERE oxc.idcliente = ac.id AND oxc.idcliente ='".$data_get["idClient"]."' AND oxc.estatus = '".$data_get["estatus"]."')temp"; 
                }else if($data_get["idClient"] == 0 AND $data_get["estatus"] == 6){
                    $table = "(SELECT oxc.id, CONCAT_WS('/',oxc.id,oxc.estatus) AS acciones, CONCAT(ac.nombre, ' ',ac.comercial) AS cliente,
                        oxc.idfactura AS factura, oxc.idoc AS oc, oxc.folio AS folio, oxc.evidencia AS evidencia
                        FROM ordenxcliente oxc, alta_clientes ac
                        WHERE oxc.idcliente = ac.id)temp"; 
                }else if($data_get["idClient"] == 0){
                    $table = "(SELECT oxc.id, CONCAT_WS('/',oxc.id,oxc.estatus) AS acciones, CONCAT(ac.nombre, ' ',ac.comercial) AS cliente,
                        oxc.idfactura AS factura, oxc.idoc AS oc, oxc.folio AS folio, oxc.evidencia AS evidencia
                        FROM ordenxcliente oxc, alta_clientes ac
                        WHERE oxc.idcliente = ac.id AND oxc.estatus = '".$data_get["estatus"]."')temp"; 
                }
                else if($data_get["estatus"] == 6){
                    $table = "(SELECT oxc.id, CONCAT_WS('/',oxc.id,oxc.estatus) AS acciones, CONCAT(ac.nombre, ' ',ac.comercial) AS cliente,
                        oxc.idfactura AS factura, oxc.idoc AS oc, oxc.folio AS folio, oxc.evidencia AS evidencia
                        FROM ordenxcliente oxc, alta_clientes ac
                        WHERE oxc.idcliente = ac.id AND oxc.idcliente='".$data_get["idClient"]."')temp"; 
                }
                
            }else{

                $table = "(SELECT oxc.id, CONCAT_WS('/',oxc.id,oxc.estatus) AS acciones, CONCAT(ac.nombre, ' ',ac.comercial) AS cliente,
                        oxc.idfactura AS factura, oxc.idoc AS oc, oxc.folio AS folio, oxc.evidencia AS evidencia
                        FROM ordenxcliente oxc, alta_clientes ac
                        WHERE oxc.idcliente = ac.id)temp"; 

            }


            // Primary key of table

            $primaryKey = 'id';

            $columns = array(

                array( 'db' => 'acciones',     'dt' => 0,

                        'formatter' => function( $d, $row ) {

                            $separar=explode("/",$d);

                            if($separar[1]==1){
                                return '<div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                        <li><a href="#"><i class="fa fa-eye"></i> Mas información</a></li>
                                        <li role="separator" class="divider"></li>
                                        <li><a href="javascript:cancelarOC('.$separar[0].')" style="color:red;"><i class="fa fa-trash"></i> Cancelar asignación</a></li>
                                      </ul>
                                    </div>';
                            }else{
                                return '<div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                        <li><a href="#"><i class="fa fa-eye"></i> Mas información</a></li>                                        
                                      </ul>
                                    </div>';
                            }

                        }  

                ),

                 array( 'db' => 'acciones',     'dt' => 1,

                        'formatter' => function( $d, $row ) {

                            $separar=explode("/", $d);

                            if ( $separar[1] == 1 ) {                        
                                return '<a style="color:darkgreen;"> ASIGNADO</a>';
                            }else{                        
                                return '<a style="color:darkred;"> CANCELADO</a>';
                            }

                        }  

                ),                

                array( 'db' => 'cliente',     'dt' => 2,

                        'formatter' => function( $d, $row ) {
                            return utf8_encode($d);
                        }

                ),

                //array( 'db' => 'descripcion',     'dt' => 3 ),

                array( 'db' => 'factura',     'dt' => 3,

                        'formatter' => function( $d, $row ) {

                            if($d == null){
                                return '<a style="color:darkred;"> NO ASIGNADO</a>';
                            }else{
                                return getFactura($d);
                            }                        

                        }

                ),

                array( 'db' => 'oc',     'dt' => 4,

                        'formatter' => function( $d, $row ) {

                            if($d == null){
                                return '<a style="color:darkred;"> NO ASIGNADO</a>';
                            }else{

                                $idcot = $d;
                                $folio = 0;
                                $inicio = 10000;
                                $nuevo = $inicio+$idcot;
    
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
                                
                                return '<a href="'.base_url().'tw/php/ordencompra/odc'.$d.'.pdf" target="_blank">'.$folio.'</a>';                
                            }                        

                        }

                ),

                array( 'db' => 'folio',     'dt' => 5,

                        'formatter' => function( $d, $row ) {

                            return utf8_encode($d);

                        }

                ),

                array( 'db' => 'evidencia',     'dt' => 6,

                        'formatter' => function( $d, $row ) {

                            return '<a href="'.base_url().'tw/js/upload_ordenxcliente/files/'.$d.'" target="_blank">'.$d.'</a>';

                        }

                ),

                array( 'db' => 'id',     'dt' => 9 )        

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


        public function asignarOC(){
            
            $data_post = $this->input->post();
            $noFolio = "";
            $folioX = null;

            if($data_post["folioOC"] == ""){
                $sqlSearchFolio='SELECT MAX(nofolio) AS folio FROM ordenxcliente WHERE nofolio IS NOT NULL';
                $noFol=$this->General_Model->infoxQueryUnafila($sqlSearchFolio);
                if($noFol->folio == null){
                    $noFolio = 1;
                }else{
                    $noFolio = $noFol->folio +1;
                }

                $folioX = 0;
                $inicio = 10000;
                $nuevo = $inicio+$noFolio;

                switch ( strlen($nuevo) ) {
                    case 5:            
                        $folioX = "SO00".$nuevo;
                    break;
                    case 6:                    
                        $folioX = "SO0".$nuevo;
                    break;
                    case 7:            
                        $folioX = "SO".$nuevo;
                    break;
                    default:
                        $folioX = "s/asignar";
                    break;
                }
            }else{
                $folioX = $data_post["folioOC"];
                $noFolio = null;
            }

            $data = array('fecha' => $data_post["fecha"],'iduser' => $data_post["iduser"], 'idcliente' => $data_post["idCliente"], 'folio' => $folioX, 'evidencia' => $data_post["evidencia"], 'observacion' => $data_post["observaciones"], 'nofolio' => $noFolio, 'estatus' => '1');
            $table = "ordenxcliente";
            $lastID = $this->General_Model->altaERP($data,$table);
            echo json_encode($lastID);
        }

        public function cancelarOC(){

            $data_post = $this->input->post();

            $fieldToUpdate = array( 'estatus' => 0 );
            $condition = array(
                'id'=>$data_post["idOC"]
            );
            $table = "ordenxcliente";
            $update=$this->General_Model->updateERP($fieldToUpdate,$table,$condition);
            echo json_encode($update);
        }



}