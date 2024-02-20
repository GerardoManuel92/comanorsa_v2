<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class Seguimiento extends CI_Controller

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

        

        function obtenerFechaEnLetra($fecha){

            $num = date("j", strtotime($fecha));

            $anno = date("Y", strtotime($fecha));

            $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

            $mes = $mes[(date('m', strtotime($fecha))*1)-1];

            return $num.'-'.strtoupper($mes).'-'.$anno;

        }

        function almacen($idpartey){

            $ci =& get_instance();
            $entradas=0;
            $salidas = 0;    

            $class = $ci->db->query("
                SELECT CONCAT_WS('<br>',a.nparte,a.descripcion) AS descrip,b.abr,
                IFNULL( (SELECT SUM(pa.cantidad) FROM partes_entrada pa WHERE pa.idparte = a.id AND pa.estatus=0),0) + 
                IFNULL((SELECT SUM(ex.cantidad) FROM partes_ajuste_entrada ex WHERE ex.estatus = 0 AND idparte = a.id ),0) totentrada,
                IFNULL((SELECT SUM(pas.cantidad) FROM partes_ajuste_salida pas WHERE pas.estatus = 0 AND pas.idparte = a.id),0) +
                IFNULL( (SELECT SUM(pef.cantidad) FROM partes_entrega_factura pef WHERE pef.estatus = 0 AND pef.idparte=a.id),0) AS totentrega,
                IFNULL( (SELECT SUM(psr.asignado_almacen) FROM partes_solicitar_rq psr WHERE psr.estatus != 2 AND psr.idparte= a.id),0) AS totasignado
                FROM alta_productos a, sat_catalogo_unidades b 
                WHERE
                a.idunidad=b.id 
                AND a.id=".$idpartey."
                ");

            $class = $class->result_array();

            foreach($class as $row) {
                $entradas=$entradas+$row["totentrada"];
                $salidas=$salidas+$row["totentrega"];

            }

            $total = $entradas - $salidas;
                
            return $total;

        }





    }



    public function infoVenta()

    {

        $iduser = $this->session->userdata(IDUSERCOM);



        $numero_menu = 10;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



            if($iduser > 0){



                $idcot = $this->uri->segment(3);





                //$queryinfo = "SELECT estatus FROM alta_cotizacion WHERE id=".$idcot;

                //$tipo_doc = $this->General_Model->infoxQueryUnafila($queryinfo);

                //$tipo_doc->estatus



                switch ( 0 ) {



                    case 0:



                        $query="SELECT a.fecha,b.nombre AS cliente,a.estatus,a.id AS idcotizacion,a.odc_cliente AS odcx,a.evidencia,

                        c.nombre AS vendedor,a.observaciones,a.estatus,b.comercial,

                        CONCAT_WS('','cot',a.id) AS pdf, 'cotizaciones' AS doc

                        FROM alta_cotizacion a,alta_clientes b, alta_usuarios c

                        WHERE a.idcliente=b.id

                        AND a.idusuario=c.id

                        AND a.id=".$idcot;

                        

                    break;

                    

                    case 1:

                        

                        ////////COTIZACION

                        $query="SELECT a.id AS iddoc, a.fecha, c.nombre AS cliente, a.estatus,b.id AS idcotizacion, CONCAT_WS('','REM#',a.id) AS folio, d.nombre AS vendedor,a.observaciones, CONCAT_WS('','rem',a.id)  AS pdf, 'remisiones' AS doc,'' AS odcx

                        FROM alta_remision a, alta_cotizacion b,alta_clientes c, alta_usuarios d

                        WHERE a.idcotizacion=b.id

                        AND b.idcliente=c.id

                        AND b.idusuario=d.id

                        AND b.id=".$idcot;



                    break;



                    case 2:

                        

                        //////// PENDIENTE POR TIMBRAR

                        $query="SELECT a.id AS iddoc, a.fecha, c.nombre AS cliente, a.estatus,b.id AS idcotizacion, 

                        'S/timbrar' AS folio, d.nombre AS vendedor, '' AS observaciones, 

                        'null'  AS pdf, 'facturas' AS doc, a.odc AS odcx

                        FROM alta_factura a, alta_cotizacion b,alta_clientes c, alta_usuarios d

                        WHERE a.idcotizacion=b.id

                        AND b.idcliente=c.id

                        AND b.idusuario=d.id

                        AND b.id=".$idcot;



                    break;



                    case 3:



                        ////////// TIMBRADO FINALIZADO    

                        $query="SELECT a.id AS iddoc, a.fecha, c.nombre AS cliente, a.estatus,b.id AS idcotizacion, 

                        CONCAT_WS('','FACT#',a.id) AS folio, d.nombre AS vendedor, '' AS observaciones, 

                        CONCAT_WS('','fact',a.id)  AS pdf, 'facturas' AS doc, a.odc AS odcx

                        FROM alta_factura a, alta_cotizacion b,alta_clientes c, alta_usuarios d

                        WHERE a.idcotizacion=b.id

                        AND b.idcliente=c.id

                        AND b.idusuario=d.id

                        AND b.id=".$idcot;



                    break;



                    case 4:

                        

                        ////////////// PEDIDO

                        $query="SELECT a.id AS iddoc, a.fecha, c.nombre AS cliente, a.estatus,b.id AS idcotizacion, CONCAT_WS('','REM#',a.id) AS folio, d.nombre AS vendedor,a.observaciones, CONCAT_WS('','rem',a.id)  AS pdf, 'remisiones' AS doc,'' AS odcx

                        FROM alta_remision a, alta_cotizacion b,alta_clientes c, alta_usuarios d

                        WHERE a.idcotizacion=b.id

                        AND b.idcliente=c.id

                        AND b.idusuario=d.id

                        AND b.id=".$idcot;



                    break;



                    case 5:

                        

                        //////// FACTURACION EN PROCESO

                        $query="SELECT a.id AS iddoc, a.fecha, c.nombre AS cliente, a.estatus,b.id AS idcotizacion, 

                        CONCAT_WS('','FACT#',a.id) AS folio, d.nombre AS vendedor, '' AS observaciones, 

                        CONCAT_WS('','fact',a.id)  AS pdf, 'facturas' AS doc, a.odc AS odcx

                        FROM alta_factura a, alta_cotizacion b,alta_clientes c, alta_usuarios d

                        WHERE a.idcotizacion=b.id

                        AND b.idcliente=c.id

                        AND b.idusuario=d.id

                        AND b.id=".$idcot;



                    break;



                }



                    

                $datos = $this->General_Model->infoxQueryUnafila($query);





                //$info_doc = array('info' => $datos, 'estatus' => $tipo_doc->estatus);

                $info_doc = array('info' => $datos);



                //$documento = array('tipo' => $tipo, 'folio' => $iddoc );



                $dmenu["nommenu"] = "seguimiento"; 



                    $this->load->view('general/header');

                    $this->load->view('general/css_datatable');

                    $this->load->view('general/menuv2');

                    $this->load->view('general/menu_header',$dmenu);

                    $this->load->view('reportes/seguimiento',$info_doc);

                    $this->load->view('general/footer');

                    $this->load->view('reportes/acciones_seguimiento',$info_doc);



            }else{



                 redirect("Login");



            }



        }else{



            redirect("AccesoDenegado");



        } 



      

    }



    public function showOdc(){



        $data_post = $this->input->post();



        $query="SELECT DISTINCT(a.idoc) AS oc, c.nombre 

        FROM partes_asignar_oc a, alta_oc b, alta_proveedores c

        WHERE a.idcot = ".$data_post['idcot']."

        AND a.idoc=b.id

        AND b.idpro=c.id

        AND a.idoc > 0";

        echo json_encode( $this->General_Model->infoxQuery($query) );



    }



    public function showFactura(){



        $data_post = $this->input->post();



        $query2="SELECT a.id, a.total, CONCAT_WS('',b.serie,b.folio) AS foliox

        FROM alta_factura a, folio_factura b

        WHERE a.idfolio=b.id

        AND a.idcotizacion=".$data_post["idcot"];



        echo json_encode( $this->General_Model->infoxQuery($query2) );



    }

    public function showEntregas(){

        $data_post = $this->input->post();

        $query2="SELECT ae.id, ae.fecha, ae.recibio, ae.archivo 
            FROM alta_entrega ae
            WHERE idfactura =".$data_post["idFactura"];

        echo json_encode( $this->General_Model->infoxQuery($query2) );

    }



    public function verOdcCliente(){



        $data_post=$this->input->post();



        $query2="SELECT b.odc

        FROM folio_factura a, alta_factura b 

        WHERE b.idfolio=a.id

        AND a.folio=".$data_post["idfolio"];



        echo json_encode( $this->General_Model->infoxQueryUnafila($query2) );

    }





        ///////////****************TABLA PARTIDAS BITACORA



        public function loadPartidas()

        {



            $data_get = $this->input->get();

            $iduser = $this->session->userdata(IDUSERCOM);





            $table = "( SELECT a.id,a.orden,CONCAT_WS('/',b.nparte,b.descripcion) AS descrip, a.cantidad AS vendido, c.descripcion AS unidad,
                    IFNULL( (SELECT SUM(w.cantidad) FROM partes_factura w WHERE w.idpartecot=a.id AND w.idfactura > 0),0 ) AS facturado,
                    a.idparte AS compras,        
                    IFNULL( (SELECT SUM(y.cantidad) FROM partes_entrada y WHERE y.idpartecot=a.id AND y.identrada > 0 ),0 ) AS entrada,                
                    IFNULL( (SELECT SUM(z.cantidad) FROM partes_entrega_factura z WHERE z.idpartecotizacion=a.id AND z.identrega > 0 ),0 ) AS entrega
                    FROM partes_cotizacion a, alta_productos b, sat_catalogo_unidades c
                    WHERE
                    a.idparte=b.id
                    AND b.idunidad = c.id
                    AND a.idcotizacion = ".$data_get['idcot']." )temp"; 

  

            // Primary key of table

            $primaryKey = 'id';

            

            $columns = array(



                /*<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    Default <span class="caret"></span>

                                  </button>*/



                array( 'db' => 'orden',     'dt' => 0 ),

                array( 'db' => 'descrip',     'dt' => 1,



                        'formatter' => function( $d, $row ) {



                            $separar = explode("/", $d);



                            return 'Clave: <strong style="color:darkblue;">'.utf8_encode($separar[0]).'</strong><p> '.utf8_encode($separar[1]).' </p>';



                        }  

                ),



               

                array( 'db' => 'vendido',     'dt' => 2 ),

                array( 'db' => 'unidad',     'dt' => 3 ),

                array( 'db' => 'facturado',     'dt' => 4 ),

                array('db' => 'compras',     'dt' => 5,
                    'formatter' => function ($d, $row) {
                        return almacen($d);
                    }
                ),

                array( 'db' => 'entrada',     'dt' => 6 ),

                array( 'db' => 'entrega',     'dt' => 7 ),

                array( 'db' => 'id',     'dt' => 10 )



           

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