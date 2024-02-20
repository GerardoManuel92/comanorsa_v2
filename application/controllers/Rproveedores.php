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



        $iduser = $this->session->userdata(IDUSERCOM);



        $numero_menu = 4;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



            if($iduser > 0){



                $data["idusuario"]= $iduser;

                //$mensaje['verificacion'] = "Ingreso correctamente por cookie";

                $nom_menu["nommenu"] = "rproveedor";



                $this->load->view('general/header');

                $this->load->view('general/menuv2');

                $this->load->view('general/css_datatable');

                $this->load->view('general/menu_header',$nom_menu);

                $this->load->view('proveedor/reporte_proveedores');

                $this->load->view('general/footer');

                $this->load->view('proveedor/acciones_reporte_proveedor');



            }else{

           

                redirect("Login");

                

            }



        }else{



            redirect('AccesoDenegado');



        }

       

    }





    public function showContactos(){



        $data_post = $this->input->post();

        $sql = "SELECT a.nombre AS contacto, b.dias,b.limite,a.puesto, a.telefono, a.correo, b.nombre, b.calle, b.exterior, b.interior, b.colonia, b.municipio, b.estado, b.cp, b.referencia 

            FROM contactos_erp a, alta_proveedores b

            WHERE

            a.iduser=b.id

            AND a.iddepartamento = 1

            AND b.id=".$data_post["idcli"];





        echo json_encode( $this->General_Model->infoxQuery($sql) );



    }



    public function retirarPro(){



        $data_post = $this->input->post();



        $datos = array('estatus' => 1);

        $table="alta_proveedores";

        $condicion = array('id' => $data_post["prov"]);



        echo json_encode( $this->General_Model->updateERP($datos,$table,$condicion) );



    }



    





    ///////////****************TABLA PARTIDAS BITACORA



        public function loadPartidas()

        {



            $iduser = $this->session->userdata(IDUSERCOM);





            $table = "(SELECT a.id,a.nombre,a.comercial,a.rfc,b.descripcion AS fpago, c.descripcion AS cfdi, a.estatus, CONCAT_WS(' ', a.calle, a.exterior, a.interior, a.colonia, a.municipio, a.estado, a.cp) AS direccion, CONCAT_WS('/',a.id,a.estatus) AS acciones, a.dias, a.limite

                        FROM alta_proveedores a, sat_catalogo_fpago b, sat_catalogo_cfdi c

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



                                        <li><a href="'.base_url().'Actproveedor/edit/'.$separar[0].'" style="color:orange; font-weight:bold;"><i class="fa fa-edit" style="color:orange; font-weight:bold;"></i> Editar</a></li>

                                        <li><a href="javascript:retirarPro('.$separar[0].')" style="color:red; font-weight:bold;"> <i class="fa fa-cancel" style="color:red; font-weight:bold;"></i> Declinar</a></li>

                                        <li><a href="#" data-toggle="modal" data-target="#modalAccounts" style="color:darkblue; font-weight:bold;"> <i class="fa fa-bank" style="color:darkblue; font-weight:bold;"></i> Ver/Añadir cuentas</a></li>

                                        <li><a href="javascript:exportarInfo(' . $separar[0] . ')" style="color:green; font-weight:bold;"> <i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Exportar información</a></li>

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



                //array( 'db' => 'nombre',     'dt' => 2 ),



                array( 'db' => 'nombre',     'dt' => 2,



                        'formatter' => function( $d, $row ) {



                            return utf8_encode($d);



                        }  

                ),



                array( 'db' => 'comercial',     'dt' => 3,



                        'formatter' => function( $d, $row ) {



                            return utf8_encode($d);



                        }  

                ),



                array( 'db' => 'rfc',     'dt' => 4,



                        'formatter' => function( $d, $row ) {



                            return utf8_encode($d);



                        }  

                ),

                

                

                



                array( 'db' => 'fpago',     'dt' => 5 ),



                array( 'db' => 'cfdi',     'dt' => 6 ),



                array( 'db' => 'direccion',     'dt' => 7 ),



                //array( 'db' => 'nombre',     'dt' => 10 ),



                array( 'db' => 'dias',     'dt' => 8,



                        'formatter' => function( $d, $row ) {



                            return utf8_encode($d);



                        }  

                ),



                array( 'db' => 'limite',     'dt' => 9,



                        'formatter' => function( $d, $row ) {



                            return utf8_encode($d);



                        }  

                ),

                array( 'db' => 'id',     'dt' => 10 ),

                array( 'db' => 'nombre',     'dt' => 11 )


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


        public function showBancos(){

            $query="SELECT id,rfc,comercial FROM alta_bancos WHERE estatus=0 ORDER BY comercial ASC";
    
            echo json_encode( $this->General_Model->infoxQuery($query) );
    
        }

        public function altaCuentas(){

            $data_post=$this->input->post();

            $sql = "SELECT razon FROM alta_bancos WHERE id = '".$data_post['idbancox']."'";
            $query = $this->db->query($sql);

            if ($query->num_rows() > 0) {
                $result = $query->row();
                $banco = $result->razon;
            }

            $data=array(
    
                'idproveedor' => $data_post["idProveedor"],
                'idbanco' => $data_post["idbancox"],
                'banco' => $banco,
                'cuenta' => $data_post["cuentax"],
                'estatus' => 1
    
            );
    
            $table="alta_cuentas_proveedor";
    
            echo json_encode( $this->General_Model->altaERP($data,$table) );

            $this->actualizarCuentasProveedor($data_post["cuentax"], $data_post["idProveedor"]);

        }

        public function actualizarCuentasProveedor($noCuenta, $idProveedor){

            $datos = array('idproveedor' => $idProveedor);
            $tabla = "alta_saldo_proveedor";
            $condicion = array('cuenta' => $noCuenta);
        
            $this->General_Model->updateERP($datos, $tabla, $condicion);
        
            $num_filas_afectadas = $this->db->affected_rows();
        
            if ($num_filas_afectadas > 0) {
                
                $consulta = $this->db->get_where($tabla, $condicion);
        
                if ($consulta->num_rows() > 0) {

                    $filas_afectadas = $consulta->result_array();
        
                    foreach ($filas_afectadas as $fila) {

                        $id_actualizado = $fila['id'];

                        $datos = array('id');
                        $tabla = "alta_cuentas_proveedor";
                        $condicion = array('cuenta' => $noCuenta);
                        
                        $idCuenta =  $this->General_Model->SelectUnafila($datos, $tabla, $condicion);
                        $valorIdCuenta = $idCuenta->id;

                        $datos = array('idcuenta' => $valorIdCuenta, 'estatus' => 0);
                        $tabla = "alta_saldo_proveedor";
                        $condicion = array('id' => $id_actualizado);
                    
                        echo ($this->General_Model->updateERP($datos, $tabla, $condicion));    
                    }
                } 
            } 
        }
        
        

        public function eliminarBanco(){

            $data_post=$this->input->post();
    
            $datos=array('estatus'=>0);
            $tabla="alta_cuentas_proveedor";
            $condicion=array('id'=> $data_post["idcuentax"]);
    
            echo json_encode( $this->General_Model->updateERP($datos,$tabla,$condicion) );
        }

        public function bancosxProveedor(){
           
            $data_post = $this->input->post();
     
             $sql = "SELECT aProv.id, aProv.cuenta, bancos.rfc, bancos.comercial
                     FROM alta_cuentas_proveedor aProv, alta_bancos bancos
                     WHERE aProv.idbanco = bancos.id
                     AND aProv.idproveedor=".$data_post['idProveedor']." 
                     AND aProv.estatus=1";
     
             echo json_encode( $this->General_Model->infoxQuery($sql) ); 
     
         }







}