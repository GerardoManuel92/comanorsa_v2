<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'third_party/ssp.php';

class Entradas extends CI_Controller
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
        
    }

    public function index()
    {
        $iduser = $this->session->userdata('idusercomanorsa');

        $dmenu["nommenu"] = "entradas";
        
       
        if($iduser > 0){

            $this->load->view('general/header');
            $this->load->view('general/css_select2');
            $this->load->view('general/css_autocompletar');
            $this->load->view('general/css_datatable');
            $this->load->view('general/css_upload');
            $this->load->view('general/menu');
            $this->load->view('general/menu_header',$dmenu);
            $this->load->view('entradas/alta_entrada');
            $this->load->view('general/footer');
            $this->load->view('entradas/acciones_alta_entrada');

        }else{

            redirect("Login");

        } 
       
    }

    public function selectProveedor(){

        $data_post= $this->input->post();

        $sql = "SELECT id FROM alta_proveedores WHERE rfc='MOCJ901005BR6' AND estatus = 0";

        echo json_encode( $this->General_Model->infoxQueryUnafila($sql) );

    }


        public function updateCelda(){

            $data_post = $this->input->post();

            /////// VERIFICAR SI EXISTE LA CLAVE NUEVA

            $sql = "SELECT id FROM alta_productos WHERE nparte = '".$data_post['texto']."' OR tags LIKE '%".$data_post['texto']."%' ";
            $existe = $this->General_Model->infoxQueryUnafila($sql);

            if ( $existe != null ) {
                
                $datos = array( 'idparte' => $existe->id );
                $tabla = "xml_partes_entrada";
                $condicion = array('id' => $data_post["idpxml"] );

                $updateid=$this->General_Model->updateERP($datos,$tabla,$condicion);

                if ( $updateid ) {
                    
                    $sql2="SELECT a.id,a.clave AS sat,a.no_identificacion,CONVERT(CAST(CONVERT( a.descripcion USING latin1) AS BINARY) USING utf8) AS descrip,a.cantidad,a.unitario,a.subtotal,b.abr AS unidad,c.nparte,c.tags
                FROM xml_partes_entrada a
                LEFT JOIN alta_productos c ON c.id=a.idparte
                ,sat_catalogo_unidades b
                WHERE
                a.unidad=b.clave
                AND a.id=".$data_post["idpxml"];

                echo json_encode( $this->General_Model->infoxQueryUnafila($sql2) );

                }

            }else{

                echo json_encode(null);

            }


        }


    ///////////****************TABLA PARTIDAS BITACORA

        public function loadPartidas()
        {

            $iduser = $this->session->userdata('idusercomanorsa');


            $table = "( SELECT a.id,a.clave AS sat,a.no_identificacion,CONVERT(CAST(CONVERT( a.descripcion USING latin1) AS BINARY) USING utf8) AS descrip,a.cantidad,a.unitario,a.subtotal,b.abr AS unidad,c.nparte,c.tags
            FROM xml_partes_entrada a
            LEFT JOIN alta_productos c ON c.id=a.idparte
            ,sat_catalogo_unidades b
            WHERE
            a.unidad=b.clave
            AND a.iduser=".$iduser." )temp"; 
  
            // Primary key of table
            $primaryKey = 'id';
            
            $columns = array(


                array( 'db' => 'no_identificacion',     'dt' => 0 ),
                array( 'db' => 'nparte',     'dt' => 1 ),
                array( 'db' => 'tags',     'dt' => 2 ),

                array( 'db' => 'descrip',     'dt' => 3 ),
                array( 'db' => 'cantidad',     'dt' => 4 ),
                array( 'db' => 'unidad',     'dt' => 5 ),
                array( 'db' => 'unitario',        
                        'dt' => 6,
                        'formatter' => function( $d, $row ) {

                            return wims_currency($d);

                        }
                ), 
                array( 'db' => 'subtotal',        
                        'dt' => 7,
                        'formatter' => function( $d, $row ) {

                            return wims_currency($d);

                        }
                ),
                array( 'db' => 'id',     'dt' => 8 )

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