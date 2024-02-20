<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class Rsalidaxajuste extends CI_Controller

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



        ////////******* verificar menu 



        $numero_menu = 29;



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



          if($iduser > 0){



              $data["idusuario"]= $iduser;

              //$mensaje['verificacion'] = "Ingreso correctamente por cookie";

              $nom_menu["nommenu"] = "rsalidaxajuste";



              $this->load->view('general/header');

              $this->load->view('general/menuv2');

              $this->load->view('general/css_select2');

              $this->load->view('general/css_datatable');

              $this->load->view('general/menu_header',$nom_menu);

              $this->load->view('salidas/reporte_salidasxajuste');

              $this->load->view('general/footer');

              $this->load->view('salidas/accciones_reporte_salidasxajuste');



          }else{

         

            redirect("Login");

              

          }



        }else{



          redirect('AccesoDenegado');



        }

       

    }


    ////////////******* PARTIDAS POR FOLIO

    public function cancelarAjuste(){

        $data_post=$this->input->post();

        $query='UPDATE alta_ajuste_salida SET estatus = 1 WHERE id ='.$data_post["id"];

        echo json_encode( $this->General_Model->infoxQueryUpt($query) );
        
    }


    public function showPartidas(){

        $data_post=$this->input->post();

        $query='SELECT a.cantidad,a.costo,a.tot_total,b.nparte,b.descripcion, c.observaciones as motivo
        FROM partes_ajuste_salida a, alta_productos b, alta_ajuste_salida c
        WHERE
        a.idparte=b.id
        AND c.id = a.idajuste
        AND a.idajuste= "'.$data_post["ident"].'"
        AND a.estatus=0';

        echo json_encode( $this->General_Model->infoxQuery($query) );

    }


    ///////////****************TABLA PARTIDAS BITACORA



        public function loadPartidas()

        {



            $data_get=$this->input->get();


            if($data_get["idus"] == 0 && $data_get["statusx"] == 2) {
                
                $table = "(SELECT a.id,a.fecha,a.total,b.nombre AS almacenista, CONCAT_WS('/',a.id,a.estatus) AS acciones, a.estatus, a.observaciones as motivo, a.documento
                            FROM alta_ajuste_salida a, alta_usuarios b, partes_ajuste_salida d
                            WHERE
                            a.idusuario=b.id AND d.idajuste = a.id                            
                            GROUP BY a.id)temp";

            }else if($data_get["idus"] > 0 && $data_get["statusx"] == 2) {
                
                $table = "(SELECT a.id,a.fecha,a.total,b.nombre AS almacenista, CONCAT_WS('/',a.id,a.estatus) AS acciones, a.estatus, a.observaciones as motivo, a.documento
                            FROM alta_ajuste_salida a, alta_usuarios b, partes_ajuste_salida d
                            WHERE
                            a.idusuario=b.id AND d.idajuste = a.id
                            AND a.idusuario='".$data_get['idus']."'
                            AND a.estatus=0
                            GROUP BY a.id)temp";

            }else if($data_get["idus"] == 0 && $data_get["statusx"] != 2) {
                
                $table = "(SELECT a.id,a.fecha,a.total,b.nombre AS almacenista, CONCAT_WS('/',a.id,a.estatus) AS acciones, a.estatus, a.observaciones as motivo, a.documento
                            FROM alta_ajuste_salida a, alta_usuarios b, partes_ajuste_salida d
                            WHERE
                            a.idusuario=b.id AND d.idajuste = a.id
                            AND a.estatus='".$data_get['statusx']."'                            
                            GROUP BY a.id)temp";

            }else if($data_get["idus"] > 0 && $data_get["statusx"] != 2){                

                $table = "(SELECT a.id,a.fecha,a.total,b.nombre AS almacenista, CONCAT_WS('/',a.id,a.estatus) AS acciones, a.estatus, a.observaciones as motivo, a.documento
                            FROM alta_ajuste_salida a, alta_usuarios b, partes_ajuste_salida d
                            WHERE
                            a.idusuario=b.id AND d.idajuste = a.id
                            AND a.idusuario='".$data_get['idus']."'
                            AND a.estatus='".$data_get['statusx']."'                            
                            GROUP BY a.id)temp";

            }


             

  

            // Primary key of table

            $primaryKey = 'id';

            

            $columns = array(


                array( 'db' => 'acciones',     'dt' => 0,

                        'formatter' => function( $d, $row ) {

                            
                            $separar = explode("/", $d);

                            /*$boton = '<a class="btn btn-danger" href="javascript:cancelarAjuste()" role="button"><i class="fa fa-close" title="Cancelar ajuste" ></i></a>';

                            return $boton;*/

                            return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">

                                        <li><a href="#" data-toggle="modal" data-target="#modal_partidas"style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye"></i> Ver partidas</a></li>
                                        <li><a href="#" onclick="cancelarAjuste('.$separar[0].',1); return false;" target="_blank" style="color:red; font-weight:bold;"><i class="fa fa-close" style="color:red; font-weight:bold;"></i> Cancelar</a></li>

                                      </ul>

                                    </div>';

                                    


                        }  


                ),



                array( 'db' => 'estatus',     'dt' => 1,



                        'formatter' => function( $d, $row ) {


                            switch ($d) {



                                case 0:

                                

                                    $boton = '<p style="color:darkgreen; font-weight:bold;"> Activo</p>';



                                break;



                                case 1:

                                

                                    $boton = '<p style="color:red; font-weight:bold;"> Cancelado</p>';



                                break;



                            }





                            return $boton;



                        }  

                ),



                array( 'db' => 'fecha',     'dt' => 2,



                        'formatter' => function( $d, $row ) {



                            //$separar = explode("/", $d);



                            if ( $d == '0000-00-00' ) {

                              

                              return 's/asignar';



                            }else{



                               return obtenerFechaEnLetra($d);



                            }



                        }  

                ),

                array( 'db' => 'id',     'dt' => 3 ),

                array( 'db' => 'motivo',     'dt' => 4 ),

                array( 'db' => 'almacenista', 'dt' => 5),  



                array( 'db' => 'total',     'dt' => 6,

                        'formatter' => function( $d, $row ) {


                            return wims_currency($d);

                        }  


                ),

                array( 'db' => 'documento',     'dt' => 7,


                        'formatter' => function( $d, $row ) {

                            if($d == ""){
                                $boton = '<p>No se encontro documento</p>';

                            }else{
                                $boton = '<a href="tw/php/ajustes/'.$d.'.pdf" target="_blank" style="color:blue;"><i class="fa fa-file-pdf-o" style="color:blue; font-weight:bold;"></i> Ver</a>'; 
                            }

                                    

                            return $boton;



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
