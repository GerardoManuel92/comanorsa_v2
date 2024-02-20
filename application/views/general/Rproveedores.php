<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'third_party/ssp.php';

class Rproveedores extends CI_Controller
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

        $iduser = $this->session->userdata('idusercomanorsa');

        if($iduser > 0){

            $data["idusuario"]= $iduser;
            //$mensaje['verificacion'] = "Ingreso correctamente por cookie";
            $nom_menu["nommenu"] = "rcotizacion";

            $this->load->view('general/header');
            $this->load->view('general/menu');
            $this->load->view('general/css_select2');
            $this->load->view('general/css_datatable');
            $this->load->view('general/menu_header',$nom_menu);
            $this->load->view('proveedor/reporte_proveedores');
            $this->load->view('general/footer');
            $this->load->view('proveedor/acciones_reporte_proveedor');

        }else{
       
            redirect("Login");
            
        }
       
    }




    ///////////****************TABLA PARTIDAS BITACORA

        public function loadPartidas()
        {

            $iduser = $this->session->userdata('iduserformato');


            $table = "(SELECT a.id,a.estatus,CONCAT_WS('/',a.id,a.estatus) AS acciones, a.nombre,a.comercial, a.rfc,CONCAT_WS(' ', a.calle, a.exterior, a.interior, a.colonia, a.municipio, a.estado, a.cp) AS direccion,
                IFNULL( (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=a.id AND z.iddepartamento= 2 LIMIT 0,1),'') AS contacto, b.descripcion AS fpago, c.descripcion AS cfdi, a.credito, a.limite
                FROM `alta_clientes` a, sat_catalogo_fpago b, sat_catalogo_cfdi c
                WHERE
                a.idfpago=b.id
                AND a.idcfdi=c.id)temp"; 
  
            // Primary key of table
            $primaryKey = 'id';
            
            $columns = array(



                array( 'db' => 'acciones',     'dt' => 0,

                        'formatter' => function( $d, $row ) {

                            $separar = explode("/", $d);

                            switch ($separar[1]) {

                                case 0:
                                
                                    /*$boton = '<a class="btn btn-success" href="'.base_url().'Actcotizacion/EditCot/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';*/

                                    return '<div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">

                                        <li><a href="#" target="_blank" style="color:orange; font-weight:bold;"><i class="fa fa-edit" style="color:orange; font-weight:bold;"></i> Editar</a></li>
                                        <li><a href="#" style="color:red; font-weight:bold;"> <i class="fa fa-cancel" style="color:red; font-weight:bold;"></i> Declinar</a></li>

                                      </ul>
                                    </div>';

                                break;

                                case 1:
                                
                                    /*$boton = '<a class="btn btn-success" href="'.base_url().'Actcotizacion/EditCot/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';*/

                                    return '<div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">

                                        
                                        <li><a href="#" style="color:darkgreen; font-weight:bold;"> <i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Activar</a></li>

                                      </ul>
                                    </div>';

                                break;

                            }

                        }  
                ),

                array( 'db' => 'acciones',     'dt' => 1,

                        'formatter' => function( $d, $row ) {

                            $separar = explode("/", $d);

                            switch ($separar[1]) {

                                case 0:
                                
                                    return '<p style="color:darkgreen; font-weight:bold; ">Activo</p>';

                                break;

                                case 1:
                                
                                    return '<p style="color:red; font-weight:bold; ">Declinado</p>';

                                break;

                            }

                        }  
                ),

                array( 'db' => 'nombre',     'dt' => 2 ),
                
                array( 'db' => 'comercial',     'dt' => 3 ),

                array( 'db' => 'rfc',     'dt' => 4 ),

                array( 'db' => 'contacto',     'dt' => 5 ),

                array( 'db' => 'direccion',     'dt' => 6 ),

                array( 'db' => 'fpago',     'dt' => 7 ),

                array( 'db' => 'cfdi',     'dt' => 8 ),

                array( 'db' => 'credito',     'dt' => 9 ),

                array( 'db' => 'limite',     'dt' => 10,

                        'formatter' => function( $d, $row ) {

                            return wims_currency($d);

                        }  
                )
           
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