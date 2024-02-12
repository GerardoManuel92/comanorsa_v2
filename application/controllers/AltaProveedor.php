<?php

defined('BASEPATH') or exit('No direct script access allowed');



class AltaProveedor extends CI_Controller

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

                array('º', '~','!','&','´',';','"',),

                array('','','','&amp;','','','&quot;'),

                $string

            );

         

         

            return $string;

        }

        

    }



    public function altaProveedor()

    {

        $iduser = $this->session->userdata(IDUSERCOM);



        $numero_menu = 3;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



            $idproveedor = $this->uri->segment(3);

           

            if($iduser > 0){



                $dmenu["nommenu"] = "alta_proveedor";



                if ( $idproveedor == 0 ) {

                #NUEVA PARTIDA



                $titulo = "<i class='fa fa-star'></i> Nuevo Proveedor";



                }else{



                    //// sql de partes



                    $titulo = "<i class='fa fa-edit' style='color:yellow;'></i> Actualizar Proveedor";

                    $info_proyecto_op = $this->General_Model->SelectUnafila($datos,$tabla,$condicion);



                }



                $data["titulox"]= $titulo;



                $this->load->view('general/header');

                $this->load->view('general/css_select2');

                $this->load->view('general/menuv2');

                $this->load->view('general/menu_header',$dmenu);

                $this->load->view('proveedor/alta_proveedor',$data);

                $this->load->view('general/footer');

                $this->load->view('proveedor/acciones_alta_proveedor');



            }else{



                redirect("Login");



            }



        }else{



            redirect('AccesoDenegado');



        } 

       

    }





    public function showFpago(){



        $query="SELECT id,clave,descripcion FROM sat_catalogo_fpago WHERE estatus = 0 ORDER BY descripcion ASC";



            echo json_encode( $this->General_Model->infoxQuery($query) );



    }



    public function showCfdi(){



        $query="SELECT id,clave,descripcion FROM sat_catalogo_cfdi WHERE estatus = 0 ORDER BY descripcion ASC";



            echo json_encode( $this->General_Model->infoxQuery($query) );



    }

    



    public function vRfc(){



        $data_post = $this->input->post();



        $condicion = array('rfc' => $data_post["rfc"], 'estatus' => 0);

        $tabla = "alta_proveedores";



        echo json_encode(  $this->General_Model->verificarRepeat($tabla,$condicion) );





    }



    public function altaPro(){



        $data_post = $this->input->post();



        $data = array(



            'fecha' => date('Y-m-d'),

            'nombre' => $data_post['nombre'],

            'comercial' => $data_post['comercial'],

            'rfc' => $data_post['rfc'],

            'calle'=> $data_post['calle'],

            'exterior'=> $data_post['exterior'],

            'interior'=> $data_post['interior'],

            'colonia' => $data_post['colonia'],

            'municipio' => $data_post['municipio'],

            'estado' => $data_post['estado'],

            'cp' => $data_post['cp'],

            'referencia'=> $data_post['referencia'],

            'idfpago'=> $data_post['idfpago'],

            'idcfdi'=> $data_post['idcfdi'],

            'dias' => $data_post['diasx'],

            'limite' => $data_post['limitex']



        );



        $table = "alta_proveedores";



        $last_id = $this->General_Model->altaERP($data,$table);



        //////////****** INSERTAR TAGS



        if ( $last_id > 0 ) {

            

            $array_sep =explode(",",$data_post['contactox']);

            $table2 = "contactos_erp";



            for ($i=0; $i <count($array_sep); $i++) { 



                //// 2da separacion 



                $separar = explode("||", $array_sep[$i]);

                

                $data2 = array(



                    'fecha' => date("Y-m-d"),

                    'iddepartamento' => '1',

                    'iduser' => $last_id,

                    'nombre' => $separar[0],

                    'puesto' => $separar[1],

                    'telefono' => $separar[2],

                    'correo' => $separar[3]



                );



                $this->General_Model->altaERP($data2,$table2);



            }



        }



        echo json_encode( $last_id );



    }



    ///////////****************TABLA PARTIDAS BITACORA



        public function loadPartidas()

        {



            $iduser = $this->session->userdata('iduserformato');





            $table = "( SELECT a.id, a.clave,a.descripcion,d.descripcion AS unidad,b.descripcion AS categoria, c.descripcion AS subcategoria,a.iva

                FROM alta_productos a, alta_categoria b, alta_subcategoria c, sat_catalogo_unidades d

                WHERE 

                a.idunidad=d.id

                AND a.idcategoria=b.id

                AND a.idsubcategoria=c.id

                AND a.estatus = 0 )temp"; 

  

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

                                        <li><a href="#"><i class="fa fa-eye"></i> Mas información</a></li>

                                        <li><a href="#" style="color:#FFC300;"> <i class="fa fa-pencil"></i> Editar</a></li>

                                        

                                        <li role="separator" class="divider"></li>



                                        <li><a href="#" style="color:red;"><i class="fa fa-trash"></i> Eliminar</a></li>

                                      </ul>

                                    </div>';



                        }  

                ),



                array( 'db' => 'clave',     'dt' => 1 ),

                array( 'db' => 'descripcion',     'dt' => 2 ),

                array( 'db' => 'unidad',     'dt' => 3 ),



                array( 'db' => 'iva',     'dt' => 4,



                        'formatter' => function( $d, $row ) {



                            switch ($d) {



                                case 2:

                                    

                                    $ivax = "Aplica";



                                break;

                                

                                case 1:

                                    

                                    $ivax = "No aplica";



                                break;

                            }



                            return $ivax;



                        }  

                ),



                array( 'db' => 'categoria',     'dt' => 5 ),

                array( 'db' => 'subcategoria',     'dt' => 6 )

           

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

