<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'third_party/ssp.php';

class Pmvendidos extends CI_Controller
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


        if($iduser > 0){

            $data["idusuario"]= $iduser;
            //$mensaje['verificacion'] = "Ingreso correctamente por cookie";
            $nom_menu["nommenu"] = "pmvendidos";

            $this->load->view('general/header');
            $this->load->view('general/menu');
            $this->load->view('general/css_select2');
            $this->load->view('general/css_datatable');
            $this->load->view('general/menu_header',$nom_menu);
            $this->load->view('productos/reporte_mas_vendidos');
            $this->load->view('general/footer');
            $this->load->view('productos/accciones_reporte_masvendidos');

        }else{
       
            redirect("Login");
            
        }
       
    }




    ///////////****************TABLA PARTIDAS BITACORA

        public function loadPartidas()
        {

            $iduser = $this->session->userdata('iduserformato');


            $table = "(SELECT a.idparte,b.clave,b.descripcion,MAX(d.fecha) AS fechax, SUM(a.cantidad) AS vendidas,'0' AS existencia, c.abr
            FROM `partes_cotizacion` a, alta_cotizacion d,alta_productos b, sat_catalogo_unidades c
            WHERE a.idparte=b.id
            AND b.idunidad=c.id
            AND a.idcotizacion=d.id
            AND d.estatus IN(1,3)
            GROUP BY a.idparte
            ORDER BY a.idparte LIMIT 0,200)temp"; 
  
            // Primary key of table
            $primaryKey = 'idparte';
            
            $columns = array(



                array( 'db' => 'idparte',     'dt' => 0,

                        'formatter' => function( $d, $row ) {

                            $boton = '<a class="btn btn-success" href="'.base_url().'Kardex/producto/'.$d.'" role="button" target="_blank"><i class="fa fa-eye" title="Ver kardex" style="color:white;"></i></a>';

                            return $boton;

                        }  
                ),

                array( 'db' => 'fechax',     'dt' => 1,

                        'formatter' => function( $d, $row ) {

                            return obtenerFechaEnLetra($d);
                        }  
                ),
                array( 'db' => 'clave',     'dt' => 2 ),
                
                array( 'db' => 'descripcion',     'dt' => 3 ),

                array( 'db' => 'vendidas',     'dt' => 4 ),

                array( 'db' => 'abr',     'dt' => 5 ),
           
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