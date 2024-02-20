<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'third_party/ssp.php';

class Ppd extends CI_Controller
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
        
    }

    public function cliente()
    {

        $numero_menu = 6;

        ////////******* verificar menu 

        $vtabla = "menus_departamento";
        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);
        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);

        if ( $verificar_menu > 0 ) {

            $iduser = $this->session->userdata(IDUSERCOM);
       
            //$dmenu["nommenu"] = "editcotizacion"; 
            if($iduser > 0){

                $cliente = $this->uri->segment(3);

                $info_menu = array('nommenu' => "ppd");

                $query="SELECT id,rfc,nombre,comercial FROM `alta_clientes` WHERE id=".$cliente;

                $datos = array('idcliente' => $cliente, "infocliente" => $this->General_Model->infoxQueryUnafila($query) );
                $data["idusuario"] = $iduser;


                $this->load->view('general/header');
                $this->load->view('general/css_select2');
                $this->load->view('general/css_upload');
                //$this->load->view('general/css_xedit');
                $this->load->view('general/css_date');
                $this->load->view('general/css_datatable');
                $this->load->view('general/menu');
                $this->load->view('general/menu_header',$info_menu);
                $this->load->view('ppd/body_ppd',$datos);
                $this->load->view('general/footer');
                $this->load->view('ppd/acciones_ppd',$data);

            }else{

                redirect("Login");

            } 

        }
        
       
    }

    public function showCliente(){

        $query="SELECT id,rfc,nombre,comercial FROM `alta_clientes` WHERE estatus = 0 ORDER BY nombre ASC";

            echo json_encode( $this->General_Model->infoxQuery($query) );

    }

    public function showFpago(){

        $query="SELECT id, clave, descripcion FROM `sat_catalogo_fpago` WHERE estatus = 0 ORDER BY descripcion ASC";

            echo json_encode( $this->General_Model->infoxQuery($query) );
        
    }

    public function showInfo(){

        $data_post = $this->input->post();

        ///SUMAR LOS IMPORTES DE LOS CFDI TIMBRADOS MAS LOS INGRESADOS EN EL TEMPORAL 
        $sql= 'SELECT COUNT(a.id) AS npagos, SUM(pago) as total
        FROM
        temporal_ppd a
        WHERE 
        a.idfactura = '.$data_post["idfact"].'
        GROUP BY a.idfactura
        UNION ALL
        SELECT COUNT(x.id) AS npagos,SUM(x.pago) AS total 
        FROM alta_pagos_ppd x, alta_ppd y 
        WHERE 
        x.idppd=y.id 
        AND x.idfactura='.$data_post["idfact"].' 
        AND y.estatus = 1 
        GROUP BY x.idfactura';

        echo json_encode( $this->General_Model->infoxQuery($sql) );

    }

    public function ingresarPago(){

        $data_post = $this->input->post();


        $data = array(  

                        'idfactura' => $data_post["idfact"],
                        'fecha' => $data_post["fecha"],
                        'fpago' => $data_post["fpago"],
                        'npago' => $data_post["npago"],
                        'moneda' => $data_post["moneda"],
                        'tcambio' => $data_post["tcambio"],
                        'saldo' => $data_post["saldo"],
                        'pago' => $data_post["pago"],
                        'insoluto' => $data_post["insoluto"]

            );
        $table = "temporal_ppd";

        echo json_encode( $this->General_Model->altaERP($data,$table) );

    }

    public function showPartidas(){

        $data_post = $this->input->post();

        $sql="SELECT a.id,a.fecha, a.npago, a.moneda, a.tcambio, a.saldo, a.pago, a.insoluto, b.clave,b.descripcion
            FROM
            temporal_ppd a, sat_catalogo_fpago b
            WHERE 
            a.idfactura =".$data_post['idfact']."
            AND a.fpago=b.id
            AND a.estatus = 0";

            echo json_encode( $this->General_Model->infoxQuery($sql) );


    }

    public function retirarComprobante(){

        $data_post = $this->input->post();

        $tabla="temporal_ppd";
        $condicion = array( 'id' => $data_post["idcomp"]);

        $delete = $this->General_Model->deleteERP($tabla,$condicion);

        /////******actualizar los numeros de pagos y los ontos del mismo 

        if ( $delete ) {

            //////***** traemos el numero de pagos ya facturados

            $sql1="SELECT COUNT(x.id) AS npagos,SUM(x.pago) AS total 
                    FROM alta_pagos_ppd x, alta_ppd y 
                    WHERE 
                    x.idppd=y.id 
                    AND x.idfactura=".$data_post["idfact"]." 
                    AND y.estatus = 1 
                    GROUP BY x.idfactura";

            $infosql1 = $this->General_Model->infoxQueryUnafila($sql1); 

            ////////////*** pagos del temporal

            $sql = "SELECT a.id,a.pago
                FROM
                temporal_ppd a
                WHERE 
                a.idfactura =".$data_post['idfact']."
                AND a.estatus = 0";

            $infosql = $this->General_Model->infoxQuery($sql);

            if ( $infosql != null ) {

                $total_factura = $data_post["total"];
                $npago = $infosql1->npagos;
                $tpago = $infosql1->total;

                $xcobrar = $total_factura-$tpago;
                

                foreach ($infosql as $row) {
                    
                    $npago=$npago+1;
                    $insoluto = $xcobrar-$row->pago;

                    $datos = array('npago' => $npago, 'saldo' => $xcobrar, 'insoluto' => $insoluto);
                    $condicion = array( 'id' => $row->id );
                    $this->General_Model->updateERP($datos,$tabla,$condicion);
                    $xcobrar = $insoluto;

                }

            }

        }

        echo json_encode( $delete );

    }

        ///////////****************TABLA PARTIDAS BITACORA

        public function loadPartidas()
        {

            $data_get = $this->input->get();
            $iduser = $this->session->userdata('idusercomanorsa');


            $table = "( SELECT a.id,a.uuid,CONCAT_WS('-',a.id,b.serie,b.folio) AS folio,a.fecha,a.total,
                    IFNULL( (SELECT CONCAT_WS('/',COUNT(x.id),SUM(x.pago)) FROM alta_pagos_ppd x, alta_ppd y WHERE x.idppd=y.id AND x.idfactura= a.id AND y.estatus = 1 GROUP BY x.idfactura) ,null) AS ppd
                    FROM 
                    alta_factura a, folio_factura b
                    WHERE 
                    a.idfolio = b.id
                    AND a.idcliente= '".$data_get['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.estatus = 1

                    OR

                    a.idfolio = b.id
                    AND a.idcliente= '".$data_get['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.estatus = 3

                     )temp"; 
  
            // Primary key of table
            $primaryKey = 'id';
            
            $columns = array(

                /*<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Default <span class="caret"></span>
                                  </button>*/

                array( 'db' => 'id',     'dt' => 0,

                        'formatter' => function( $d, $row ) {

                            $boton = '<a class="btn btn-success" href="#" data-toggle="modal" data-target="#modal1" aria-haspopup="true" role="button" target="_blank"><i class="fa fa-plus" title="Ver/Agregar" ></i></a>';

                            return $boton;

                        }  
                ),

                array( 'db' => 'uuid',     'dt' => 1 ),

                array( 'db' => 'folio',     'dt' => 2,

                        'formatter' => function( $d, $row ) {

                           $separar = explode("-", $d);

                           return '<a href="'.base_url().'tw/php/facturas/fact'.$separar[0].'.pdf" target="_blank" >'.$separar[1].''.$separar[2].'</a>';

                        }  
                ),

                array( 'db' => 'fecha',     'dt' => 3,

                        'formatter' => function( $d, $row ) {

                           return obtenerFechaEnLetra($d);

                        }  
                ),
                array( 'db' => 'total',     'dt' => 4,

                        'formatter' => function( $d, $row ) {

                           return wims_currency($d);

                        }  
                ),

                array( 'db' => 'ppd',     'dt' => 5,

                        'formatter' => function( $d, $row ) {

                            if ( $d!= null ) {
                            
                                $separar = explode("/", $d);

                                $valor=$separar[0];

                            }else{

                                $valor = "0";

                            }

                            return $valor;

                        }  
                ),

                 array( 'db' => 'ppd',     'dt' => 6,

                        'formatter' => function( $d, $row ) {

                            

                            if ( $d!= null ) {
                            
                                $separar = explode("/", $d);

                                $valor=wims_currency($separar[1]);

                            }else{

                                $valor = "0";

                            }

                            return $valor;

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
