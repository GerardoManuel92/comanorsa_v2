<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'third_party/ssp.php';

class Factstimbrar extends CI_Controller
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

    public function Facturar()
    {
        $iduser = $this->session->userdata(IDUSERCOM);
        $idfact = $this->uri->segment(3);

        $numero_menu = 10;/// se coloca el mismo identificador que el alta de cotizacion;

        ////////******* verificar menu 

        $vtabla = "menus_departamento";
        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);
        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);

        if ( $verificar_menu > 0 ) {

            ///////////* datos cotizacion

            $query="SELECT b.nombre AS cliente, a.idcliente,a.moneda,a.tcambio,a.estatus, b.idfpago, b.idcfdi, b.credito, b.limite, a.idcotizacion,
                IFNULL( (SELECT SUM(x.total) FROM alta_factura x WHERE x.idcliente = b.id AND x.pago = 0 AND x.estatus IN(1,3) ), 0 ) AS totfactura,
                IFNULL( (SELECT SUM(y.total) FROM alta_remision y WHERE y.idcliente = b.id AND y.pago = 0 AND y.estatus IN(0,2) ), 0 ) AS totremision,
                IFNULL( (SELECT SUM(w.total) FROM alta_factura w WHERE w.idcliente = b.id AND w.pago = 0 AND w.estatus IN(1,3) AND DATE_ADD(w.fecha,INTERVAL w.dias DAY) <= '".date('Y-m-d')."' ), 0) AS sfvencido,
                IFNULL( (SELECT SUM(z.total) FROM alta_remision z WHERE z.idcliente = b.id AND z.pago = 0 AND z.estatus IN(0,2) 
                AND DATE_ADD(z.fecha,INTERVAL '0' DAY) <= '".date('Y-m-d')."' ), 0) AS srvencido,a.odc
                    FROM alta_factura a, alta_clientes b
                    WHERE a.idcliente=b.id
                    AND a.id=".$idfact;

            /*$query="SELECT b.nombre AS cliente, a.idcliente,a.moneda,a.tcambio,a.estatus, b.idfpago, b.idcfdi, b.credito, b.limite, a.idcotizacion,
                (SELECT CONCAT_WS('/',z.credito,z.limite) FROM direccion_clientes z WHERE z.idcliente=b.id LIMIT 0,1) AS limitex,
                IFNULL( (SELECT SUM(x.total) FROM alta_factura x WHERE x.idcliente = b.id AND x.pago = 0 AND x.estatus IN(1,3) ), 0 ) AS totfactura,
                IFNULL( (SELECT SUM(y.total) FROM alta_remision y WHERE y.idcliente = b.id AND y.pago = 0 AND y.estatus IN(0,2) ), 0 ) AS totremision,
                IFNULL( (SELECT SUM(w.total) FROM alta_factura w WHERE w.idcliente = b.id AND w.pago = 0 AND w.estatus IN(1,3) AND DATE_ADD(w.fecha,INTERVAL w.dias DAY) <= '".date('Y-m-d')."' ), 0) AS sfvencido,
                IFNULL( (SELECT SUM(z.total) FROM alta_remision z WHERE z.idcliente = b.id AND z.pago = 0 AND z.estatus IN(0,2) 
                AND DATE_ADD(z.fecha,INTERVAL '0' DAY) <= '".date('Y-m-d')."' ), 0) AS srvencido,a.odc
                    FROM alta_factura a, alta_clientes b
                    WHERE a.idcliente=b.id
                    AND a.id=".$idfact;*/

            $datos = $this->General_Model->infoxQueryUnafila($query);

                /////////////*****************

                //idodc : este nos idnica que la odc de esa cotizacion ha sidfo habilitada y ya no puede haber una edicion o actualizacion
                $info_cot = array('info' => $datos, 'idfact' => $idfact);
                $info_menu = array('nommenu' => "refacturacion", 'idestatus' => $datos->estatus );

                //$dmenu["nommenu"] = "editcotizacion"; 
                if($iduser > 0){

                    $this->load->view('general/header');
                    $this->load->view('general/css_select2');
                    $this->load->view('general/css_autocompletar');
                    $this->load->view('general/css_upload');
                    //$this->load->view('general/css_xedit');
                    $this->load->view('general/css_date');
                    $this->load->view('general/css_datatable');
                    $this->load->view('general/menuv2');
                    $this->load->view('general/menu_header',$info_menu);
                    $this->load->view('facturas/refacturar_stimbrar',$info_cot);
                    $this->load->view('general/footer');
                    $this->load->view('facturas/acciones_refacturar_stimbrar',$info_cot);

                }else{

                    redirect("Login");

                }
            

        }else{


            redirect('AccesoDenegado');

        } 

       
    }

  

    public function showDatosCliente(){

        $data_post = $this->input->post();

        $query="SELECT a.nombre,a.rfc,b.cp,CONCAT_WS('-', c.clave,c.regimen) AS regimen_fiscal
        FROM alta_clientes a, direccion_clientes b, sat_catalogo_regimen_fiscal c
        WHERE b.idcliente=a.id
        AND a.idregimen=c.id
        AND a.id=".$data_post['idcliente'];

        echo json_encode( $this->General_Model->infoxQueryUnafila($query) );       

    }   

    public function showCfdi(){

        $query="SELECT id, clave, descripcion FROM `sat_catalogo_cfdi` WHERE estatus = 0 ORDER BY descripcion ASC";

            echo json_encode( $this->General_Model->infoxQuery($query) );

    }

    public function showFpago(){

        $query="SELECT id, clave, descripcion FROM `sat_catalogo_fpago` WHERE estatus = 0 ORDER BY descripcion ASC";

            echo json_encode( $this->General_Model->infoxQuery($query) );
        
    }

    public function showMpago(){

        $query="SELECT id, clave, descripcion FROM `sat_metodo_pago` WHERE estatus = 0 ORDER BY descripcion ASC";

            echo json_encode( $this->General_Model->infoxQuery($query) );

    }


    ///////////************* ACCION A COTIZACION



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
                    'idcotizacion' => $data_post["idcot"],
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
            
            $data2 = array('estatus' => 2, 'documento' => $last_id );
            $table2 = "alta_cotizacion";
            $condicion2 = array('id' => $data_post["idcot"]);

            $this->General_Model->updateERP($data2,$table2,$condicion2);

            /////////************* CAMBIAR ODC

            $ruta_actual="tw/js/upload_odc/files/".$data_post['odc'];

            $ruta_nueva="tw/js/odc_cliente/odc".$last_id.".pdf";

            if(copy($ruta_actual,$ruta_nueva)){

                $data2x = array('odc' => "odc".$last_id.".pdf");
                $table2x = "alta_factura";
                $condicion2x = array('id' => $last_id);

                $this->General_Model->updateERP($data2x,$table2x,$condicion2x);

            }

            //////***************** PASAR LAS PARTIDAS DEL TEMPORAL DE FACTURACION A LA FACTURA

            $sql_partes="SELECT a.id,b.nparte AS clave,
                        CONVERT(CAST(CONVERT( CONCAT_WS(' ',b.clave,e.descripcion,d.marca) USING latin1) AS BINARY) USING utf8) AS descrip, 
                        c.descripcion AS unidad, 
                        e.costo, e.iva,e.descuento,
                        (a.cantidad*e.costo) AS subtotal,
                        a.cantidad,e.idparte,( ((a.cantidad*e.costo)- ((a.cantidad*e.costo)*(e.descuento/100)))*(e.iva/100)) AS tiva,
                        ( (a.cantidad*e.costo)*(e.descuento/100)) AS tdescuento,
                        e.orden,e.utilidad,e.tcambio,
                        e.costo_proveedor, e.id AS idpcot 
                        FROM temporal_partes_facturacion a, partes_cotizacion e,alta_productos b, sat_catalogo_unidades c, alta_marca d
                        WHERE a.idpartecot=e.id 
                        AND e.idparte=b.id
                        AND b.idunidad=c.id
                        AND b.idmarca = d.id
                        AND a.idcot = ".$data_post["idcot"]."
                        AND a.estatus = 0";

            $partes = $this->General_Model->infoxQuery($sql_partes);

            foreach ($partes as $row) {

                    $data3 = array( 'idfactura' => $last_id, 'idparte' => $row->idparte, 'idpartecot' => $row->idpcot,'cantidad' => $row->cantidad);

                    $table3 = "partes_factura";

                    $this->General_Model->altaERP($data3,$table3);

            }

        }


        echo json_encode($last_id);

    }


        ///////////****************TABLA PARTIDAS BITACORA

        public function loadPartidas()
        {

            $data_get = $this->input->get();
            $iduser = $this->session->userdata(IDUSERCOM);

            $data = array();
            $pregunta = array();

            $sql = "( SELECT a.id,b.nparte AS clave,
                        CONVERT(CAST(CONVERT( CONCAT_WS(' ',b.clave,e.descripcion,d.marca) USING latin1) AS BINARY) USING utf8) AS descrip, 
                        c.descripcion AS unidad, 
                        e.costo, e.iva,e.descuento,
                        (a.cantidad*e.costo) AS subtotal,
                        a.cantidad,e.idparte,
                        ROUND( ( ( (a.cantidad*e.costo)-( (a.cantidad*e.costo)*(e.descuento/100) ))*(e.iva/100)),2 ) AS tiva,
                        ROUND( ( (a.cantidad*e.costo)*(e.descuento/100) ),2 ) AS tdescuento,
                        e.orden,e.utilidad,e.tcambio,
                        e.costo_proveedor, e.id AS idpcot
                        FROM partes_factura a, partes_cotizacion e,alta_productos b, sat_catalogo_unidades c, alta_marca d
                        WHERE a.idpartecot=e.id 
                        AND e.idparte=b.id
                        AND b.idunidad=c.id
                        AND b.idmarca = d.id
                        AND a.idfactura = ".$data_get['idfact']."
                        AND a.estatus = 0)"; 


            $datos=$this->General_Model->infoxQuery($sql);                

            if ($datos!=null) {
                
                foreach ($datos as $row) {

                    //$separar=explode("/",$row->acciones);
                    
                    $pregunta[] = array(

                        'ID'=>$row->id,
                        'ACCION'=>'<button class="btn btn-red" type="button" class="form-control" onclick="retirarParte('.$row->id.')"                      tabindex="-1"><i class="fa fa-trash"></i></button>',
                        'ORDEN'=>$row->orden,
                        'CANTIDAD'=>$row->cantidad,
                        'CLAVE'=>$row->clave,
                        'DESCRIP'=>$row->descrip,
                        'UNIDAD'=>$row->unidad,
                        'COSTO'=>wims_currency($row->costo),
                        'IVA'=>$row->iva,
                        'DESCUENTO'=>$row->descuento,
                        'UTILIDAD'=>$row->utilidad,
                        'TCAMBIO'=>$row->tcambio,
                        'SUBTOTAL'=>wims_currency($row->subtotal),
                        'TIVA'=>round($row->tiva,2),
                        'TDESCUENTO'=>round($row->tdescuento,2),
                        'COSTOPROVEEDOR'=>round($row->costo_proveedor,2),
                        'IDPCOT'=>round($row->idpcot,2),
                        'IDPARTE'=>$row->idparte

                    );

                }

            }


            $data = array("data"=>$pregunta);
            header('Content-type: application/json');
            echo json_encode($data);

        }
   

}
