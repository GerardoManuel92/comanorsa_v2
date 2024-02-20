<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'third_party/ssp.php';

class Ccxp extends CI_Controller
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

            //Esta parte se encarga de eliminar cualquier caracter extraño
            $string = str_replace(
                array('º', '~','!','&','´',';','"','°',''),
                array('','','','&amp;','','','&quot;',' grados'),
                $string
            );
         
            $string = str_replace(
                array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
                array('&aacute;', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
                $string
            );
         
            $string = str_replace(
                array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
                array('&eacute;', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
                $string
            );
         
            $string = str_replace(
                array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
                array('&iacute;', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
                $string
            );
         
            $string = str_replace(
                array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
                array('&oacute;', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
                $string
            );
         
            $string = str_replace(
                array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
                array('&uacute;', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
                $string
            );
         
            $string = str_replace(
                array('ñ', 'Ñ', 'ç', 'Ç'),
                array('&ntilde;', '&Ntilde;', 'c', 'C'),
                $string
            );
         
            
         
         
            return $string;
        }

        function wims_currency($number) { 
           if ($number < 0) { 
            $print_number = "-$ " . str_replace('-', '', number_format ($number, 2, ".", ",")) . ""; 
            } else { 
             $print_number = "$ " .  number_format ($number, 2, ".", ",") ; 
           } 
           return $print_number; 
        } 

        function conocerDiaSemanaFecha($fecha) {
            $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
            $dia = $dias[date('w', strtotime($fecha))];
            return $dia;
        }

        function obtenerFechaEnLetra($fecha){
            $dia= conocerDiaSemanaFecha($fecha);
            $num = date("j", strtotime($fecha));
            $anno = date("Y", strtotime($fecha));
            $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
            $mes = $mes[(date('m', strtotime($fecha))*1)-1];
            return $num.' de '.$mes.' del '.$anno;
        }

        function fechaLatino($ingles){

            $separarx = explode("-", $ingles);

            return $separarx[2]."/".$separarx[1]."/".$separarx[0];

        }
        

    }

    public function index()
    {
        $iduser = $this->session->userdata('idusercomanorsa');

        $dmenu["nommenu"] = "cxp";
        
       
        if($iduser > 0){

            $this->load->view('general/header');
            $this->load->view('general/css_select2');
            $this->load->view('general/css_upload');
            $this->load->view('general/css_datatable');
            $this->load->view('general/menu');
            $this->load->view('general/menu_header',$dmenu);
            $this->load->view('cxp/alta_cxp');
            $this->load->view('general/footer');
            $this->load->view('cxp/acciones_alta_cxp');

        }else{

            redirect("Login");

        } 
       
    }

    public function showProveedor(){

        $query="SELECT id,nombre,comercial FROM alta_proveedores ORDER BY nombre ASC";

            echo json_encode( $this->General_Model->infoxQuery($query) );

    }

    public function guardarPago(){

            $data_post = $this->input->post();


            $datos = array('pago' => 1 );
            $tabla = "alta_oc";
            $condicion = array('id' =>$data_post["idocx"]);

            $lastupt=$this->General_Model->updateERP($datos,$tabla,$condicion);

            echo json_encode($lastupt);

    }



        ///////////****************TABLA PARTIDAS 

        public function loadPartidas()
        {

            $iduser = $this->session->userdata('idusercomanorsa');


            $table = "( SELECT a.id,a.fecha,a.pago, 
                            CONCAT_WS('/',a.id,a.pago) AS boton,
                            DATE_ADD(a.fecha,INTERVAL a.dias DAY) AS fpago,
                            CONCAT_WS( '/',IF( DATE_ADD(a.fecha,INTERVAL a.dias DAY) <= '".date('Y-m-d')."',1,0 ),a.pago ) AS est_pago,
                            b.nombre AS proveedor, a.subtotal,a.iva,a.total,a.descuento
                            FROM alta_oc a, alta_proveedores b
                            WHERE a.idpro=b.id ORDER by fpago ASC )temp"; 
  
            // Primary key of table
            $primaryKey = 'id';
            
            $columns = array(

                /*<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Default <span class="caret"></span>
                                  </button>*/

                array( 'db' => 'boton',     'dt' => 0,

                        'formatter' => function( $d, $row ) {

                            $separar= explode("/", $d);

                            if ( $separar[1] == 1) {
                                
                                //////// pagado
                                return '';

                            }else{

                                return '<a class="btn btn-success" data-toggle="modal" data-target="#exampleModal" role="button" target="_blank"><i class="fa fa-money" title="pagar a proveedor" ></i></a>';

                            }

                            

                        }  
                ),

                array( 'db' => 'est_pago',     'dt' => 1,

                        'formatter' => function( $d, $row ) {

                                $separar= explode("/", $d);

                                if ( $separar[1] == 1) {
                                
                                    //////// pagado
                                    return '<p style="color:green; font-weight:bold;" >PAGADA</p>';

                                }else{

                                    
                                    if ( $separar[0] == 1 ) {
                                        
                                        ////////// VENCIDA
                                        return '<p style="color:red; font-weight:bold;" >VENCIDA</p>';

                                    }else{

                                        ////////// ACTIVA
                                        return '<p style="color:darkblue; font-weight:bold;" >ACTIVA</p>';

                                    }

                                }

                        }  
                ),

                array( 'db' => 'id',     'dt' => 2,

                        'formatter' => function( $d, $row ) {


                                return '<a href="'.base_url().'tw/php/ordencompra/odc'.$d.'.pdf" target="_blank">'.$d.'</a>';

                        }  
                ),
                
                array( 'db' => 'proveedor',     'dt' => 3 ),

                array( 'db' => 'fecha',     'dt' => 4,

                        'formatter' => function( $d, $row ) {

                            return fechaLatino($d);
                        }  
                ),

                array( 'db' => 'fpago',     'dt' => 5,

                        'formatter' => function( $d, $row ) {

                            return fechaLatino($d);
                        }  
                ),
               
                array( 'db' => 'subtotal',        
                        'dt' => 6,
                        'formatter' => function( $d, $row ) {

                            return "<p>".wims_currency($d)."</p>";

                        }
                ), 

                array( 'db' => 'descuento',        
                        'dt' => 7,
                        'formatter' => function( $d, $row ) {

                            return "<p>".wims_currency($d)."</p>";

                        }
                ), 

                array( 'db' => 'iva',        
                        'dt' => 8,
                        'formatter' => function( $d, $row ) {

                            return "<p>".wims_currency($d)."</p>";

                        }
                ), 

                array( 'db' => 'total',        
                        'dt' => 9,
                        'formatter' => function( $d, $row ) {

                            return "<p>".wims_currency($d)."</p>";

                        }
                ),


                
                 array( 'db' => 'id',     'dt' => 10 )
           
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
