<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';

class Rcotizacionesxcliente extends CI_Controller

{

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

        $iduser = $this->session->userdata(IDUSERCOM);



        $numero_menu = 10;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



            $dmenu["nommenu"] = "rcotizacionxcliente";


            if($iduser > 0){



                $this->load->view('general/header');

                $this->load->view('general/css_select2');

                $this->load->view('general/css_datatable');

                $this->load->view('general/menuv2');

                $this->load->view('general/menu_header',$dmenu);

                $this->load->view('reportes/body_cotizacionxcliente');

                $this->load->view('general/footer');

                $this->load->view('reportes/acciones_cotizacionxcliente');



            }else{


                redirect("Login");

            } 



        }else{



            redirect('AccesoDenegado');



        }

       

    }


    public function showCliente(){



        $query="SELECT id,rfc,nombre,comercial FROM `alta_clientes` WHERE estatus = 0 ORDER BY nombre ASC";



            echo json_encode( $this->General_Model->infoxQuery($query) );



    }

    public function lista_ventaxproducto(){

        $this->load->model('Model_Buscador');
        $data_post=$this->input->post();

        $sql='SELECT a.cantidad,(a.cantidad*a.costo) AS costo, c.id AS fol_factura,g.descripcion AS unidad, c.id AS folio
                FROM partes_cotizacion a, alta_productos b, alta_cotizacion c, alta_marca d, sat_catalogo_unidades g
                WHERE a.idparte=b.id
                AND a.idcotizacion=c.id
                AND b.idmarca=d.id
                AND b.idunidad=g.id
                AND c.idcliente='.$data_post["idcli"].'
                AND c.estatus NOT IN (1,6)
                AND a.idparte='.$data_post["idproducto"].' ORDER BY c.id DESC;';

                /*SELECT a.cantidad,(a.cantidad*a.costo) AS costox, c.id AS fol_factura,g.descripcion AS unidad, CONCAT("ODV001", LPAD(c.id, 4, "0")) AS folio
                FROM partes_cotizacion a, alta_productos b, alta_cotizacion c, alta_marca d, sat_catalogo_unidades g
                WHERE a.idparte=b.id
                AND a.idcotizacion=c.id
                AND b.idmarca=d.id
                AND b.idunidad=g.id
                AND c.idcliente='.$data_post["idcli"].'
                AND c.estatus=0
                AND a.idparte='.$data_post["idproducto"].' ORDER BY c.id DESC;*/

                
            echo json_encode( $this->General_Model->infoxQuery($sql) );

    }

    public function loadPartidas()

        {


            $data_get=$this->input->get();

                $table = "( SELECT a.id,a.idparte,SUM(a.cantidad) AS cantidadx, b.descripcion, b.nparte, d.marca
                FROM partes_cotizacion a, alta_productos b, alta_cotizacion c, alta_marca d
                WHERE a.idparte=b.id
                AND a.idcotizacion=c.id
                AND b.idmarca=d.id
                AND c.idcliente='".$data_get['idcliente']."'
                AND c.estatus=0
                GROUP BY a.idparte)temp";


            // Primary key of table

            $primaryKey = 'id';

            

            $columns = array(



                array( 'db' => 'idparte',     'dt' => 0,



                        'formatter' => function( $d, $row ) {

                            return '<button class="btn btn-success" type="button" class="form-control" onclick="verEstatus('.$d.')"><i class="fa fa-eye"></i></button>';



                        }  

                ),



                array( 'db' => 'cantidadx',     'dt' => 1 ),

                array( 'db' => 'nparte',     'dt' => 2 ),

                array( 'db' => 'descripcion',     'dt' => 3 ),

                array( 'db' => 'marca',     'dt' => 4 ),

                array( 'db' => 'idparte',     'dt' => 5 )


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


    public function loadProductos(){

        $data_get=$this->input->get();
        $data = array();
        $pregunta = array();

                $sql="SELECT a.id,a.idparte,SUM(a.cantidad) AS cantidadx, b.descripcion, b.nparte, d.marca
                FROM partes_cotizacion a, alta_productos b, alta_cotizacion c, alta_marca d
                WHERE a.idparte=b.id
                AND a.idcotizacion=c.id
                AND b.idmarca=d.id
                AND c.idcliente='".$data_get['idcliente']."'
                AND c.estatus=0
                GROUP BY a.idparte";

            $datos=$this->General_Model->infoxQuery($sql);

            

            if ($datos!=null) {
                
                foreach ($datos as $row) {

                    

                    $pregunta[] = array(

                        'ID'=>$row->id,
                        'ACCION'=>'<button class="btn btn-success" type="button" class="form-control" onclick="verEstatus('.$row->idparte.')"><i class="fa fa-eye"></i></button>',
                        'CANTIDAD'=>$row->cantidadx,
                        'CLAVE'=>$row->nparte,
                        'DESCRIPCION'=>$row->descripcion,
                        'MARCA'=>$row->marca,
                        'IDPARTE'=>$row->idparte

                    );

                }
            }


            $data = array("data"=>$pregunta);
            header('Content-type: application/json');
            echo json_encode($data);
            
    }


}

