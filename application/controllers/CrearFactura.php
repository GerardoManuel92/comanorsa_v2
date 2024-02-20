<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'third_party/ssp.php';

class CrearFactura extends CI_Controller
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

    public function Factura()
    {
        $iduser = $this->session->userdata(IDUSERCOM);
        

        $numero_menu = 10;/// se coloca el mismo identificador que el alta de cotizacion;

        ////////******* verificar menu 

        $vtabla = "menus_departamento";
        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);
        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);

        if ( $verificar_menu > 0 ) {

            $idfactura = $this->uri->segment(3);

            if( $iduser > 0 ){

                ////////********* DATOS GENERALES DE LA FACTURA

                $queryx="SELECT b.nombre AS cliente, a.idcliente,a.moneda,a.tcambio,a.estatus, a.idfpago, a.idcfdi,b.rfc,
                (SELECT CONCAT_WS('/',z.credito,z.limite) FROM direccion_clientes z WHERE z.idcliente=b.id LIMIT 0,1) AS limitex,
                IFNULL( (SELECT SUM(x.total) FROM alta_factura x WHERE x.idcliente = b.id AND x.pago = 0 AND x.estatus IN(1,3) ), 0 ) AS totfactura,
                IFNULL( (SELECT SUM(y.total) FROM alta_remision y WHERE y.idcliente = b.id AND y.pago = 0 AND y.estatus IN(0,2) ), 0 ) AS totremision,
                IFNULL( (SELECT SUM(w.total) FROM alta_factura w WHERE w.idcliente = b.id AND w.pago = 0 AND w.estatus IN(1,3) 
                AND DATE_ADD(w.fecha,INTERVAL w.dias DAY) <= '".date('Y-m-d')."' ), 0) AS sfvencido,
                IFNULL( (SELECT SUM(z.total) FROM alta_remision z WHERE z.idcliente = b.id AND z.pago = 0 AND z.estatus IN(0,2) 
                AND DATE_ADD(z.fecha,INTERVAL '0' DAY) <= '".date('Y-m-d')."' ), 0) AS srvencido,a.odc, c.serie, c.folio,a.uuid

                        FROM alta_factura a, alta_clientes b, folio_factura c
                        WHERE a.idcliente=b.id
                        AND a.idfolio=c.id
                        AND a.id=".$idfactura;

                $datosx = $this->General_Model->infoxQueryUnafila($queryx);

                ///////////*trae los datos de la factura para timbrar 

                $query="SELECT id,idparte,idpartecot,cantidad FROM `partes_factura` where estatus = 0 and idfactura=".$idfactura;

                $datos = $this->General_Model->infoxQueryUnafila($query);

                //////******* BORRAMOS EL CONTENIDO ACTUAL DE LA COTIZACION

                $tablax = "temporal_partes_relacion";
                $condicionx = array( 'idusuario' => $iduser );

                $borrar = $this->General_Model->deleteERP($tablax,$condicionx);


                $sqlx="SELECT id,idparte,idpartecot,cantidad FROM `partes_factura` where estatus = 0 and idfactura=".$idfactura;
                $partes = $this->General_Model->infoxQuery($sqlx);

                if ($partes != null ) {

                    foreach ($partes as $row) {

                        $data3 = array( 'idusuario' => $iduser, 'idparte' => $row->idparte, 'idpartecot' => $row->idpartecot,'cantidad' => $row->cantidad );
                        $table3 = "temporal_partes_relacion";
                        $this->General_Model->altaERP($data3,$table3);

                    }

                }

                /////////////*****************

                //idodc : este nos idnica que la odc de esa cotizacion ha sidfo habilitada y ya no puede haber una edicion o actualizacion
                $info_cot = array('info' => $datosx, 'idfactura' => $idfactura);
                $info_menu = array('nommenu' => "crear_factura" );

                //$dmenu["nommenu"] = "editcotizacion"; 
                

                    $this->load->view('general/header');
                    $this->load->view('general/css_select2');
                    $this->load->view('general/css_autocompletar');
                    $this->load->view('general/css_upload');
                    $this->load->view('general/css_date');
                    $this->load->view('general/css_datatable');
                    $this->load->view('general/menuv2');
                    $this->load->view('general/menu_header',$info_menu);
                    $this->load->view('facturas/crear_factura_sin_pedido',$info_cot);
                    $this->load->view('general/footer');
                    $this->load->view('facturas/acciones_crear_factura_spedido',$info_cot);

            }else{

                redirect("Login");

            }

        }else{


            redirect('AccesoDenegado');

        } 

       
    }

    public function factCotizacion(){

        $data_post = $this->input->post();


        ///////******* ACTUALIZAR COTIZACION
        /*$cotdata = array('fcotizacion' => date('Y-m-d'), 'hora' => date('H:i:s'), 'idcliente' => $data_post['idcliente'], 'moneda' => $data_post['monedax'], 'tcambio' => $data_post['tcx'],'observaciones' => $data_post['obsx'] );
        $cottable = "alta_cotizacion";
        $cotcondicion = array('id' => $data_post['idcot'] );
        $this->General_Model->updateERP($cotdata,$cottable,$cotcondicion);*/

        ////////******** OBTENER EL TOTAL DEL TEMPORAL DE FACTURACION
        
        $total = $data_post["totalx"];
        $iva = $data_post["ivax"];
        $descuento = $data_post["descuentox"];
        $subtotal = $data_post["subtotalx"];


        ///////////********** ALTA FACTURA

        /*if ( $data_post["idcliente"] == 21 ) {
            
            $subtotalx = $infosql1->subtotal+$infosql1->iva;
            
            $ivax = 0;

        }else{

            $subtotalx = $infosql1->subtotal;
            $ivax = $infosql1->iva;

        }*/

        $data = array(

                    'fecha' => date("Y-m-d"),
                    'hora' => date("H:i:s"),
                    'idcotizacion' => 0,
                    'rcancelacion' => $data_post["idfactura"],
                    'idusuario' => $data_post["iduser"],
                    'dias' => $data_post["dias"],
                    'idmpago' => $data_post["mpagox"],
                    'idfpago' => $data_post["fpagox"],
                    'idcfdi' => $data_post["cfdix"],
                    'moneda' =>  1,
                    'tcambio' =>  1,
                    'idcliente' => $data_post["idcliente"],
                    'subtotal' => $subtotal,
                    'descuento' => $descuento,
                    'iva' => $iva,
                    'total' => $total,
                    'odc' => $data_post["odc"]

                    
                );

        $table = "alta_factura";

        $last_id=$this->General_Model->altaERP($data,$table);

        if ( $last_id > 0 ) {
            
            /*$data2 = array('estatus' => 2, 'documento' => $last_id );
            $table2 = "alta_cotizacion";
            $condicion2 = array('id' => $data_post["idcot"]);*/

            //$this->General_Model->updateERP($data2,$table2,$condicion2);

            //////***************** PASAR LAS PARTIDAS DEL TEMPORAL DE FACTURACION A LA FACTURA

            $sql_partes="SELECT a.id,a.idparte,a.cantidad,a.idpartecot
                        FROM temporal_partes_relacion a
                        WHERE a.idusuario = ".$data_post["iduser"]."
                        AND a.estatus = 0";

            $partes = $this->General_Model->infoxQuery($sql_partes);

            foreach ($partes as $row) {

                    $data3 = array( 'idfactura' => $last_id, 'idparte' => $row->idparte,'cantidad' => $row->cantidad, 'idpartecot' => $row->idpartecot );

                    $table3 = "partes_factura";

                    $this->General_Model->altaERP($data3,$table3);

            }

        }


        echo json_encode($last_id);

    }



        ///////////****************TABLA PARTIDAS BITACORA

        public function loadPartidas()
        {

            $iduser = $this->session->userdata(IDUSERCOM);


            $table = "(SELECT a.id,b.nparte AS clave,
                CONCAT_WS('/',a.id,e.orden) AS acciones,
                CONVERT(CAST(CONVERT( CONCAT_WS(' ',b.clave,e.descripcion,d.marca) USING latin1) AS BINARY) USING utf8) AS descrip, c.descripcion AS unidad, e.costo_proveedor, b.costo, b.iva,3.descuento,
                e.tot_subtotal AS subtotal,a.cantidad,e.idparte,e.tot_iva AS tiva,
                e.tot_descuento AS tdescuento,e.orden,e.utilidad,e.tcambio
                FROM temporal_partes_relacion a, partes_cotizacion e,alta_productos b, sat_catalogo_unidades c, alta_marca d
                WHERE 
                a.idpartecot=e.id
                AND a.idparte=b.id
                AND b.idunidad=c.id
                AND b.idmarca = d.id
                AND a.idusuario = ".$iduser."
                AND a.estatus = 0 )temp"; 

                /*SELECT a.id,d.uuid,CONCAT_WS(),
FROM alta_pagos_ppd a, alta_datos_ppd b, alta_ppd c, alta_factura d, folio_factura e
WHERE
a.idppd=b.id
AND b.idcpd=c.id
AND a.idfactura=d.id
AND d.idfolio=e.id
AND c.id=17

SELECT a.id,b.nparte AS clave,
                CONCAT_WS('/',a.id,e.orden) AS acciones,
                CONVERT(CAST(CONVERT( CONCAT_WS(' ',b.clave,e.descripcion,d.marca) USING latin1) AS BINARY) USING utf8) AS descrip, c.descripcion AS unidad, e.costo_proveedor, b.costo, b.iva,3.descuento,
                e.tot_subtotal AS subtotal,a.cantidad,e.idparte,e.tot_iva AS tiva,
                e.tot_descuento AS tdescuento,e.orden,e.utilidad,e.tcambio
                FROM temporal_partes_relacion a, partes_cotizacion e,alta_productos b, sat_catalogo_unidades c, alta_marca d
                WHERE 
                a.idpartecot=e.id
                AND a.idparte=b.id
                AND b.idunidad=c.id
                AND b.idmarca = d.id
                AND a.idusuario = ".$iduser."
                AND a.estatus = 0*/

  
            // Primary key of table
            $primaryKey = 'id';
            
            $columns = array(

                /*<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Default <span class="caret"></span>
                                  </button>*/

                array( 'db' => 'acciones',     'dt' => 0,

                        'formatter' => function( $d, $row ) {

                            $separar=explode("/",$d);

                            return '<button class="btn btn-red" type="button" class="form-control" onclick="retirarParte('.$separar[0].','.$separar[1].')" ><i class="fa fa-trash"></i></button>';

                        }  
                ),

                array( 'db' => 'orden',     'dt' => 1 ),
                array( 'db' => 'cantidad',     'dt' => 2 ),
                array( 'db' => 'clave',     'dt' => 3 ),
                array( 'db' => 'descrip',     'dt' => 4 ),
                array( 'db' => 'unidad',     'dt' => 5 ),
                array( 'db' => 'costo',        
                        'dt' => 6,
                        'formatter' => function( $d, $row ) {

                            return "<p>".wims_currency($d)."</p>";

                        }
                ), 
                array( 'db' => 'iva',     'dt' => 7 ),
                array( 'db' => 'descuento',     'dt' => 8 ),

                array( 'db' => 'utilidad',     'dt' => 9 ),

                array( 'db' => 'tcambio',     'dt' => 10 ),

                array( 'db' => 'subtotal',        
                        'dt' => 11,
                        'formatter' => function( $d, $row ) {

                            return wims_currency($d);

                        }
                ), 
                array( 'db' => 'id',     'dt' => 12 ),
                array( 'db' => 'costo',     'dt' => 13 ),
                array( 'db' => 'idparte',     'dt' => 14 ),

                array( 'db' => 'subtotal',     'dt' => 15 ),
                array( 'db' => 'tiva',     'dt' => 16 ),
                array( 'db' => 'tdescuento',     'dt' => 17 ),
                array( 'db' => 'costo_proveedor',     'dt' => 18 )

           
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
