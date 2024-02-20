<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'third_party/ssp.php';

class Ncreditodesc extends CI_Controller
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
        
    }


    public function showFactura(){

        $iduser = $this->session->userdata(IDUSERCOM);

        $numero_menu = 10;

        ////////******* verificar menu 

        $vtabla = "menus_departamento";
        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);
        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);

        if ( $verificar_menu > 0 ) {
            
            if($iduser > 0){

                $idfact = $this->uri->segment(3);

                ///////*** 
                $sql = "SELECT a.id, b.nombre AS cliente, b.comercial, a.total, CONCAT_WS('',c.serie,c.folio) AS folio, a.moneda, a.tcambio, a.idcotizacion,(SELECT SUM(z.total) FROM alta_nota_credito z WHERE z.idfactura=a.id AND z.estatus=1) AS totnota 
                FROM alta_factura a, alta_clientes b, folio_factura c
                WHERE
                a.idcliente=b.id
                AND a.idfolio=c.id
                AND a.id=".$idfact;

                ///// borrar los datos termporales de partes del ncredito

                /*$dtabla = "temporal_partes_ncredito";
                $dcondicion = array( 'idfactura' => $idfact);
                $this->General_Model->deleteERP($dtabla,$dcondicion);*/

                /////////

                $data['rowsql1'] = $this->General_Model->infoxQueryUnafila($sql);
                $data_header['nommenu'] = 'ncreditodesc';

                $data_user['iduserx'] = $iduser;

                    $this->load->view('general/header');
                    $this->load->view('general/css_select2');
                    $this->load->view('general/css_autocompletar');
                    $this->load->view('general/css_datatable');
                    $this->load->view('general/menuv2');
                    $this->load->view('general/menu_header',$data_header);
                    $this->load->view('nota_credito/body_nota_descuento',$data);
                    $this->load->view('general/footer');
                    $this->load->view('nota_credito/acciones_ndescuento',$data_user);

            }else{

                    redirect("Login");

            }

        }else{

            redirect('AccesoDenegado');

        }
        
         

    }

    public function showFpago(){

        $query="SELECT id, clave, descripcion FROM `sat_catalogo_fpago` WHERE estatus = 0 ORDER BY descripcion ASC";

            echo json_encode( $this->General_Model->infoxQuery($query) );
        
    }

    public function updateCelda(){

        $data_post = $this->input->post();
        $verificar= 0;

        switch ( $data_post['columna'] ) {

            case 0:
                //devoluciones

                if ( $data_post["texto"] > 0 OR $data_post["texto"] == 0 ) {
                    # code...
                    $datos= array( 'idfactura' => $data_post["idfacturax"],
                                    'idpartefact' => $data_post["idpfact"] ,
                                    'cantidad' => $data_post["texto"],
                                    'descripcion' => changeString($data_post["anterior_descrip"]) );

                    $verificar = 0;

                }else{

                    $verificar = 1;

                }

            break;

            case 2:
                //texto
                if( $data_post["texto"] != "" ){

                    $datos= array( 'idfactura' => $data_post["idfacturax"],
                                    'idpartefact' => $data_post["idpfact"] ,
                                    'descripcion' => changeString($data_post["texto"]),
                                    'cantidad' => $data_post["anterior_cant"] );
                    //$datos= array('descripcion' => changeString($data_post["texto"]) );
                    $verificar = 0;

                }else{

                    $verificar = 1;

                }

            break;

        }

            /////////
            $tabla="temporal_partes_ncredito";

            if ( $verificar == 0 ) {
                
                ///// verificar si existe
                $condicion1 = array('idpartefact' => $data_post["idpfact"] );
                $repeat = $this->General_Model->verificarRepeat($tabla,$condicion1);

                if ( $repeat > 0 ) {
                    
                    $condicion = array('idpartefact' => $data_post["idpfact"] );
                    $update = $this->General_Model->updateERP($datos,$tabla,$condicion);

                }else{

                    $insercion=$this->General_Model->altaERP($datos,$tabla);

                    if ( $insercion > 0 ) {
                        
                        $update = true;

                    }else{

                        $update = false;
                    }

                }

            }else{

               $update = false;

            }

            ////////************ TRAER DATOS PARA LA FILA
            $sdata = "cantidad,descripcion";
            $scondicion = array('idpartefact' => $data_post["idpfact"] );
            echo json_encode( $this->General_Model->SelectUnafila($sdata,$tabla,$scondicion) );

    }


    ///////////****************TABLA PARTIDAS BITACORA

        public function loadPartidas()
        {

            $data_get = $this->input->get();
            $iduser = $this->session->userdata('idusercomanorsa');


            $table = "( SELECT a.id,b.nparte AS clave, d.descripcion, a.cantidad, c.abr AS unidad, d.costo, d.iva, d.descuento, (d.costo*a.cantidad) AS subtotal, '0' AS devolucion,
            IFNULL( ( SELECT SUM(x.cantidad) FROM partes_ncredito x, alta_nota_credito y WHERE  x.idnota=y.id AND x.idpartefact = a.id AND y.estatus = 1),0 ) AS ncantidad
            FROM partes_factura a, partes_cotizacion d ,alta_productos b, sat_catalogo_unidades c
            WHERE
            a.idpartecot=d.id
            AND d.idparte=b.id
            AND b.idunidad=c.id
            AND a.idfactura=".$data_get['idfactura'].")temp"; 
  
            // Primary key of table
            $primaryKey = 'id';
            
            $columns = array(

                /*<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Default <span class="caret"></span>
                                  </button>*/

                array( 'db' => 'devolucion',     'dt' => 0,

                        'formatter' => function( $d, $row ) {

                            return $d;

                        }  
                ),

                array( 'db' => 'clave',     'dt' => 1 ),
                array( 'db' => 'descripcion',     'dt' => 2 ),
                array( 'db' => 'cantidad',     'dt' => 3 ),
                array( 'db' => 'ncantidad',     'dt' => 4 ),
                array( 'db' => 'unidad',     'dt' => 5 ),
                array( 'db' => 'costo',        
                        'dt' => 6,
                        'formatter' => function( $d, $row ) {

                            return wims_currency($d);

                        }
                ), 
                array( 'db' => 'iva',     'dt' => 7 ),
                array( 'db' => 'descuento',     'dt' => 8 ),
                array( 'db' => 'subtotal',        
                        'dt' => 9,
                        'formatter' => function( $d, $row ) {

                            return wims_currency($d);

                        }
                ), 
                array( 'db' => 'id',     'dt' => 10 ),
                array( 'db' => 'costo',     'dt' => 11 )

           
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