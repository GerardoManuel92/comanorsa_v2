<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class CuentasCom extends CI_Controller

{


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

    }



    public function index()

    {

        $iduser = $this->session->userdata(IDUSERCOM);

        
        $numero_menu = 25;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {

       

            if($iduser > 0){


                $titulo="<i class='fa fa-star'></i> Nueva cuenta";

                $dmenu["nommenu"] = "cuentas_comanorsa";
                $data["titulox"]= $titulo;



                $this->load->view('general/header');

                $this->load->view('general/css_select2');

                $this->load->view('general/css_datatable');

                $this->load->view('general/menuv2');

                $this->load->view('general/menu_header',$dmenu);

                $this->load->view('bancos/cuentas_comanorsa',$data);

                $this->load->view('general/footer');

                $this->load->view('bancos/acciones_comanorsa');



            }else{



                redirect("Login");



            }

        }else{



            redirect('AccesoDenegado');



        } 

       

    }


   


    public function altaCuenta(){



        $data_post = $this->input->post();


        $table = "alta_cuentas_comanorsa";

        $condicion = array( 'cuenta' => $data_post['cuentax'], 'estatus' => 0 );

        $repeat = $this->General_Model->verificarRepeat($table,$condicion);

        if ( $repeat > 0) {

            echo json_encode(0);

        }else{



            $data = array(

            'idusuario' => $data_post['idusuario'],
            'idbanco' => $data_post['bancox'],
            'rfc' => $data_post['rfcx'],
            'cuenta' => $data_post['cuentax'],
            'saldo'=>$data_post['inicialx']

            );

            echo json_encode( $this->General_Model->altaERP($data,$table) );



        }

    }





    public function actCuenta(){



       $data_post = $this->input->post();


        $table = "alta_cuentas_comanorsa";

        $condicion = array( 'cuenta' => $data_post['cuentax'], 'estatus' => 0, 'id!=' => $data_post['idcuentax'] );



        $repeat = $this->General_Model->verificarRepeat($table,$condicion);



        if ( $repeat > 0) {

            

            echo json_encode(0);



        }else{



            $datos = array(

            'idbanco' => $data_post['bancox'],
            'rfc' => $data_post['rfcx'],
            'cuenta' => $data_post['cuentax'],
            'saldo'=>$data_post['inicialx']

            );



            $condicion = array('id' => $data_post['idcuentax'] );





            echo json_encode( $this->General_Model->updateERP($datos,$table,$condicion) );



        } 



    }





    public function deleteCuenta(){



        $data_post = $this->input->post();



        $datos = array(

            'estatus' => $data_post["estx"]

        );

        $table = "alta_cuentas_comanorsa";

        $condicion = array('id' => $data_post['idcuentax'] );



        echo json_encode( $this->General_Model->updateERP($datos,$table,$condicion) );

    }



    ///////////****************TABLA PARTIDAS BITACORA



        public function loadPartidas()

        {



            $iduser = $this->session->userdata(IDUSERCOM);





            $table = '( SELECT a.id,a.rfc,a.cuenta,b.comercial,a.saldo,IF(moneda=0,"PESOS","DOLARES") AS monedax,a.idbanco,a.estatus,CONCAT_WS("/",a.id,a.estatus) AS acciones
                        FROM alta_cuentas_comanorsa a, alta_bancos b
                        WHERE a.idbanco=b.id)temp'; 

  

            // Primary key of table

            $primaryKey = 'id';

            

            $columns = array(



                array( 'db' => 'acciones',     'dt' => 0,



                        'formatter' => function( $d, $row ) {



                            $separar=explode("/",$d);



                            switch ($separar[1]) {

                                case 0:

                                    // ACTIVO
                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">

                                        

                                        <li><a href="javascript:editarCuenta('.$separar[0].')" style="color:#FFC300;"> <i class="fa fa-pencil"></i> Editar</a></li>

                                        

                                        <li role="separator" class="divider"></li>



                                        <li><a href="javascript:deleteCuenta('.$separar[0].',1)" style="color:red;"><i class="fa fa-times-circle"></i> Desactivar</a></li>

                                      </ul>

                                    </div>';

                                break;
                                
                                case 1:

                                    // INNACTIVO
                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">

                                        

                                        <li><a href="javascript:editarCuenta('.$separar[0].')" style="color:#FFC300;"> <i class="fa fa-pencil"></i> Editar</a></li>

                                        

                                        <li role="separator" class="divider"></li>



                                        <li><a href="javascript:deleteCuenta('.$separar[0].',0)" style="color:green;"><i class="fa fa-check"></i> Activar</a></li>

                                      </ul>

                                    </div>';

                                break;
                            }


                            

                                //return $d;



                        }  

                ),

                array( 'db' => 'estatus',     'dt' => 1,



                        'formatter' => function( $d, $row ) {



                            switch ($d) {

                                case 0:
                                    
                                    return "<p style='font-size:15px; color:darkgreen;'>ACTIVA</p>";

                                break;

                                case 1:
                                    
                                     return "<p style='font-size:15px; color:red;'>INACTIVA</p>";

                                break;
                                
                               
                            }

                            



                        }

                ),

                array('db' => 'rfc', 'dt' => 2),

                array('db' => 'cuenta', 'dt' => 3),

                array('db' => 'comercial', 'dt' => 4),

                array( 'db' => 'saldo',     'dt' => 5,



                        'formatter' => function( $d, $row ) {



                            return wims_currency($d);



                        }

                ),

                array('db' => 'monedax', 'dt' => 6),

                array('db' => 'id', 'dt' => 7),

                array('db' => 'idbanco', 'dt' => 8),

                array('db' => 'saldo', 'dt' => 9)




           

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