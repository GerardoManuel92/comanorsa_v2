<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'third_party/ssp.php';

class Ccxc extends CI_Controller
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

        function conocerDiaSemanaFecha($fecha) {
            $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');
            $dia = $dias[date('w', strtotime($fecha))];
            return $dia;
        }

        function obtenerFechaEnLetra($fecha){
            $dia= conocerDiaSemanaFecha($fecha);
            $num = date("j", strtotime($fecha));
            $anno = date("Y", strtotime($fecha));
            $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
            $mes = $mes[(date('m', strtotime($fecha))*1)-1];
            return $num.' de '.$mes.' del '.$anno;
        }

        function fechaLatino($ingles){

            $separarx = explode("-", $ingles);

            return $separarx[2]."/".$separarx[1]."/".$separarx[0];

        }
        

    }

    public function index()
    {
        $numero_menu = 19;

        ////////******* verificar menu 

        $vtabla = "menus_departamento";
        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);
        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);

        if ( $verificar_menu > 0 ) {

            
            $iduser = $this->session->userdata(IDUSERCOM);
           
            if($iduser > 0){

                $info_menu = array('nommenu' => "cxc");
                $data["idusuario"] = $iduser;

                $this->load->view('general/header');
                $this->load->view('general/css_select2');
                $this->load->view('general/css_upload');
                $this->load->view('general/css_datatable');
                $this->load->view('general/menuv2');
                $this->load->view('general/menu_header',$info_menu);
                $this->load->view('cxc/alta_cxc');
                $this->load->view('general/footer');
                $this->load->view('cxc/acciones_alta_cxc',$data);

            }else{

                redirect("Login");

            }

        } 
       
    }

    public function showProveedor(){

        $query="SELECT id,nombre,comercial FROM alta_proveedores ORDER BY nombre ASC";

            echo json_encode( $this->General_Model->infoxQuery($query) );

    }

    public function guardarPago(){

            $data_post = $this->input->post();

            $tipox=$data_post["tipo"];

            ////********** SOLSO SE PUEDEN PAGAR FACTURAS QUE SON POR PUE

            $data1 = array(

                        'fecha' => date("Y-m-d"),
                        'idusuario' => $data_post["iduser"],
                        'idfactura' => $data_post["editid"],
                        'total' => $data_post["pagox"],
                        'comprobante' => $data_post["comprobantex"]
                        
            );

            $table1="alta_pago_cxc";
            $alta = $this->General_Model->altaERP($data1,$table1);

            if ( $alta > 0 ) {
                
                if ( $tipox == 0 ) {

                    //////********** ACTUALIZAR ESTATUS PAGO FACTURA

                    $datos = array('pago' => 1 );
                    $tabla = "alta_factura";
                    $condicion = array('id' =>$data_post["editid"]);

                    $lastupt=$this->General_Model->updateERP($datos,$tabla,$condicion);
                    
                }elseif ($tipox==1) {

                    //////********** ACTUALIZAR ESTATUS PAGO FACTURA

                    $datos = array('pago' => 1 );
                    $tabla = "alta_factura_sustitucion";
                    $condicion = array('id' =>$data_post["editid"]);

                    $lastupt=$this->General_Model->updateERP($datos,$tabla,$condicion);
                    
                }

                

                //////////////********* ALTA DEL PAGO EN TABLA DE PAGOS

                $data2 = array(

                        'fecha' => date("Y-m-d"),
                        'tipo' => $tipox,
                        'idfactura' => $data_post["editid"],
                        'comprobante' => $data_post["comprobantex"],
                        'pago' => 1,
                        'pdf' => $data_post["pdf_ppd"],
                        'xml' => $data_post["xml"]

                        
                );

                $table2="pagos_factura";
                $alta = $this->General_Model->altaERP($data2,$table2);

                /*$datos = array('pago' => 1 );
                $tabla = "alta_remision";
                $condicion = array('id' =>$data_post["iddocx"]);

                $lastupt=$this->General_Model->updateERP($datos,$tabla,$condicion);*/

            }

            

            echo json_encode($alta);

    }



        ///////////****************TABLA PARTIDAS 

        public function loadPartidas()
        {

            $data_post = $this->input->get();
            $estatus = $data_post["est"];

            /*<option id="0" style="color: darkblue; font-weight: bold;">Activas</option>
                                    <option id="1" style="color: darkgreen; font-weight: bold;">Cobradas</option>
                                    <option id="2" selected style="color: red; font-weight: bold;">Vencidas</option>
                                    <option id="3" style="color:#E1A009; font-weight: bold;">Canceladas</option>*/


            switch ( $estatus ) {

                case 1:
                    //// ACTIVA
                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,
                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,
                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,
                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,
                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar
                    FROM alta_factura x, alta_clientes y, folio_factura z
                    WHERE x.idcliente=y.id
                    AND x.idfolio=z.id
                    AND x.estatus = 1
                    AND x.pago = 0 
                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."' 

                    UNION ALL

                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,
                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,
                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,
                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,
                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar
                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z
                    WHERE x.idcliente=y.id
                    AND x.idfolio=z.id
                    AND x.estatus = 1
                    AND x.pago = 0 
                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."' )temp";

                break;

                case 2:
                    //// COBRADA
                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,
                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,
                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,
                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,
                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0) AS xpagar
                    FROM alta_factura x, alta_clientes y, folio_factura z
                    WHERE x.idcliente=y.id
                    AND x.idfolio=z.id
                    AND x.estatus = 1
                    AND x.pago = 1 

                    UNION ALL

                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,
                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,
                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,
                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,
                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0) AS xpagar
                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z
                    WHERE x.idcliente=y.id
                    AND x.idfolio=z.id
                    AND x.estatus = 1
                    AND x.pago = 1 )temp";
                    
                break;

                case 3:
                    ///// VENCIDA
                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,
                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,
                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,
                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,
                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar
                    FROM alta_factura x, alta_clientes y, folio_factura z
                    WHERE x.idcliente=y.id
                    AND x.idfolio=z.id
                    AND x.estatus = 1
                    AND x.pago=0
                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."' 

                    UNION ALL

                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,
                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,
                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,
                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,
                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar
                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z
                    WHERE x.idcliente=y.id
                    AND x.idfolio=z.id
                    AND x.estatus = 1
                    AND x.pago=0
                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."'

                    )temp";
                    
                break;

                case 4:
                    //// CANCELADA
                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,
                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,
                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,
                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,
                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS xpagar
                    FROM alta_factura x, alta_clientes y, folio_factura z
                    WHERE x.idcliente=y.id
                    AND x.idfolio=z.id
                    AND x.estatus = 2

                    UNION ALL

                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,
                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,
                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,
                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,
                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS xpagar
                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z
                    WHERE x.idcliente=y.id
                    AND x.idfolio=z.id
                    AND x.estatus = 2 )temp";
                    
                break;
                
                
            }

            


            /*"( SELECT a.id,a.pago,a.fecha,'Remisión' AS documento,b.nombre AS cliente,c.subtotal,c.descuento,c.iva,c.total,
            CONCAT_WS('/',a.id,a.pago) AS boton,
            DATE_ADD(a.fecha,INTERVAL 0 DAY) AS fcobro,
                CONCAT_WS( '/',IF( DATE_ADD(a.fecha,INTERVAL 0 DAY) <= '".date('Y-m-d')."',1,0 ),a.pago ) AS est_pago
                FROM alta_remision a, alta_clientes b, alta_cotizacion c
                WHERE a.idcotizacion=c.id
                AND c.idcliente=b.id
                AND a.estatus != 1

                UNION ALL

            SELECT x.id, x.pago, x.fecha, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,
            CONCAT_WS('/',x.id,x.pago) AS boton,
            DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,
            CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago ) AS est_pago
            FROM alta_factura x, alta_clientes y
            WHERE x.idcliente=y.id
            AND a.estatus != 0

                 )temp";*/ 
  
            // Primary key of table
            $primaryKey = 'id';
            
            $columns = array(

                /*<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Default <span class="caret"></span>
                                  </button>*/

                array( 'db' => 'boton',     'dt' => 0,

                        'formatter' => function( $d, $row ) {

                            $separar= explode("/", $d);

                            if ( $separar[2] == 1 ) {
                                
                                if ( $separar[1] == 1) {
                                
                                    //////// pagado
                                    return '';

                                }else{

                                    return '<a class="btn btn-success" data-toggle="modal" data-target="#exampleModal" role="button" target="_blank"><i class="fa fa-money" title="Agregar cobro" ></i></a>';

                                }
                            
                            }else if ( $separar[2] == 2 ) {
                                
                                return '';

                            }

                            

                            

                        }  
                ),

                array( 'db' => 'est_pago',     'dt' => 1,

                        'formatter' => function( $d, $row ) {

                                $separar= explode("/", $d);


                                if ( $separar[2] == 1 ) {
                                    
                                    if ( $separar[1] == 1) {
                                
                                        //////// pagado
                                        return '<p style="color:green; font-weight:bold;" >COBRADA</p>';

                                    }else{

                                        
                                        if ( $separar[0] == 1 ) {
                                            
                                            ////////// VENCIDA
                                            return '<p style="color:red; font-weight:bold;" >VENCIDA</p>';

                                        }else{

                                            ////////// ACTIVA
                                            return '<p style="color:darkblue; font-weight:bold;" >ACTIVA</p>';

                                        }

                                    }

                                }else if ( $separar[2] == 2 ) {
                                    
                                    return '<p style="color:#E1A009; font-weight:bold;" ><i class="fa fa-close"></i>CANCELADA</p>';

                                }

                                

                                //return $d;

                        }  
                ),

                array( 'db' => 'documento',     'dt' => 2 ),

                array( 'db' => 'fol_fact',     'dt' => 3,

                        'formatter' => function( $d, $row ) {


                                return '<a href="'.base_url().'tw/php/facturas/'.$d.'.pdf" target="_blank">'.$d.'</a>';

                        }  
                ),
                
                array( 'db' => 'cliente',     'dt' => 4 ),

                array( 'db' => 'fecha',     'dt' => 5,

                        'formatter' => function( $d, $row ) {

                            return fechaLatino($d);
                        }  
                ),

                array( 'db' => 'fcobro',     'dt' => 6,

                        'formatter' => function( $d, $row ) {

                            return fechaLatino($d);
                        }  
                ),
               
                array( 'db' => 'subtotal',        
                        'dt' => 7,
                        'formatter' => function( $d, $row ) {

                            return "<p>".wims_currency($d)."</p>";

                        }
                ), 

                array( 'db' => 'descuento',        
                        'dt' => 8,
                        'formatter' => function( $d, $row ) {

                            return "<p>".wims_currency($d)."</p>";

                        }
                ), 

                array( 'db' => 'iva',        
                        'dt' => 9,
                        'formatter' => function( $d, $row ) {

                            return "<p>".wims_currency($d)."</p>";

                        }
                ), 

                array( 'db' => 'total',        
                        'dt' => 10,
                        'formatter' => function( $d, $row ) {

                            return "<p>".wims_currency($d)."</p>";

                        }
                ),


                array( 'db' => 'cobrado',        
                        'dt' => 11,
                        'formatter' => function( $d, $row ) {

                            return "<p>".wims_currency($d)."</p>";

                        }
                ),

                array( 'db' => 'xpagar',        
                        'dt' => 12,
                        'formatter' => function( $d, $row ) {

                            return "<p>".wims_currency($d)."</p>";

                        }
                ),

                
                array( 'db' => 'id',     'dt' => 13 ),

                array( 'db' => 'dias',     'dt' => 14 ),

                array( 'db' => 'tipox',     'dt' => 15 )
           
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


        //////////////********************* PARTIDAS POR BUSCADOR

        public function loadBuscar(){

            $data_post = $this->input->get();
          
            $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,
                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,
                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,
                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,
                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar
                    FROM alta_factura x, alta_clientes y, folio_factura z
                    WHERE x.idcliente=y.id
                    AND x.idfolio=z.id
                    AND x.estatus = 1
                    AND CONCAT_WS('', y.nombre,y.comercial,z.serie,z.folio,y.rfc) LIKE '%".trim($data_post['buscar'])."%'

                    UNION ALL

                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,
                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,
                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,
                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,
                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar
                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z
                    WHERE x.idcliente=y.id
                    AND x.idfolio=z.id
                    AND x.estatus = 1
                    AND CONCAT_WS('', y.nombre,y.comercial,z.serie,z.folio,y.rfc) LIKE '%".trim($data_post['buscar'])."%'
                    
                )temp";

            $primaryKey = 'id';
            
            $columns = array(

                /*<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Default <span class="caret"></span>
                                  </button>*/

                array( 'db' => 'boton',     'dt' => 0,

                        'formatter' => function( $d, $row ) {

                            $separar= explode("/", $d);

                            if ( $separar[2] == 1 ) {
                                
                                if ( $separar[1] == 1) {
                                
                                    //////// pagado
                                    return '';

                                }else{

                                    return '<a class="btn btn-success" data-toggle="modal" data-target="#exampleModal" role="button" target="_blank"><i class="fa fa-money" title="Agregar cobro" ></i></a>';

                                }
                            
                            }else if ( $separar[2] == 2 ) {
                                
                                return '';

                            }

                            

                            

                        }  
                ),

                array( 'db' => 'est_pago',     'dt' => 1,

                        'formatter' => function( $d, $row ) {

                                $separar= explode("/", $d);


                                if ( $separar[2] == 1 ) {
                                    
                                    if ( $separar[1] == 1) {
                                
                                        //////// pagado
                                        return '<p style="color:green; font-weight:bold;" >COBRADA</p>';

                                    }else{

                                        
                                        if ( $separar[0] == 1 ) {
                                            
                                            ////////// VENCIDA
                                            return '<p style="color:red; font-weight:bold;" >VENCIDA</p>';

                                        }else{

                                            ////////// ACTIVA
                                            return '<p style="color:darkblue; font-weight:bold;" >ACTIVA</p>';

                                        }

                                    }

                                }else if ( $separar[2] == 2 ) {
                                    
                                    return '<p style="color:#E1A009; font-weight:bold;" ><i class="fa fa-close"></i>CANCELADA</p>';

                                }

                                

                                //return $d;

                        }  
                ),

                array( 'db' => 'documento',     'dt' => 2 ),

                array( 'db' => 'fol_fact',     'dt' => 3,

                        'formatter' => function( $d, $row ) {


                                return '<a href="'.base_url().'tw/php/facturas/'.$d.'.pdf" target="_blank">'.$d.'</a>';

                        }  
                ),
                
                array( 'db' => 'cliente',     'dt' => 4 ),

                array( 'db' => 'fecha',     'dt' => 5,

                        'formatter' => function( $d, $row ) {

                            return fechaLatino($d);
                        }  
                ),

                array( 'db' => 'fcobro',     'dt' => 6,

                        'formatter' => function( $d, $row ) {

                            return fechaLatino($d);
                        }  
                ),
               
                array( 'db' => 'subtotal',        
                        'dt' => 7,
                        'formatter' => function( $d, $row ) {

                            return "<p>".wims_currency($d)."</p>";

                        }
                ), 

                array( 'db' => 'descuento',        
                        'dt' => 8,
                        'formatter' => function( $d, $row ) {

                            return "<p>".wims_currency($d)."</p>";

                        }
                ), 

                array( 'db' => 'iva',        
                        'dt' => 9,
                        'formatter' => function( $d, $row ) {

                            return "<p>".wims_currency($d)."</p>";

                        }
                ), 

                array( 'db' => 'total',        
                        'dt' => 10,
                        'formatter' => function( $d, $row ) {

                            return "<p>".wims_currency($d)."</p>";

                        }
                ),


                array( 'db' => 'cobrado',        
                        'dt' => 11,
                        'formatter' => function( $d, $row ) {

                            return "<p>".wims_currency($d)."</p>";

                        }
                ),

                array( 'db' => 'xpagar',        
                        'dt' => 12,
                        'formatter' => function( $d, $row ) {

                            return "<p>".wims_currency($d)."</p>";

                        }
                ),

                
                array( 'db' => 'id',     'dt' => 13 ),

                array( 'db' => 'dias',     'dt' => 14 ),

                array( 'db' => 'tipox',     'dt' => 15 )
           
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
