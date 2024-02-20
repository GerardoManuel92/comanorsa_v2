<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'third_party/ssp.php';

class Cpp extends CI_Controller
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
            
                $info_menu = array('nommenu' => "ppd");
                $data["idusuario"] = $iduser;

                $this->load->view('general/header');
                $this->load->view('general/css_select2');
                $this->load->view('general/css_upload');
                //$this->load->view('general/css_xedit');
                $this->load->view('general/css_date');
                $this->load->view('general/css_datatable');
                $this->load->view('general/menuv2');
                $this->load->view('general/menu_header',$info_menu);
                $this->load->view('ppd/body_ppdv2');
                $this->load->view('general/footer');
                $this->load->view('ppd/acciones_ppdv2',$data);

            }else{

                redirect("Login");

            } 

        }
        
       
    }

    public function showCliente(){

        $query="SELECT id,nombre,comercial FROM `alta_clientes` WHERE estatus = 0 ORDER BY nombre ASC";

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

    public function updateCelda(){

        $data_post = $this->input->post();
        
        if ( $data_post["texto"] > 0 ) {

            $xpagar= $data_post["total"]-$data_post["pagado"];
            $diferencia = round($xpagar,2)-round($data_post["texto"],2);

            if ( $diferencia > 0 OR $diferencia == 0) {
                

                //////borrarmos el dato que este registradod e la fcatura en el temporal

                $table1 = "temporal_ppdv2";
                $ucondicion = array('idfactura' => $data_post["idfactura"], 'tipo' => $data_post["tipo"] );
                $this->General_Model->deleteERP($table1,$ucondicion);

                ////////insertamos el nuevo monto

                $data1 = array(

                        'idfactura' => $data_post["idfactura"],
                        'idcliente' => $data_post["idcliente"],
                        'cobrado' => $data_post["texto"],
                        'posterior' => $diferencia,
                        'anterior' => $xpagar,
                        'ncpp' => $data_post["ncpp"]+1,
                        'tipo' => $data_post["tipo"],
                        'iduser' => $data_post["iduser"]

                );

                $alta = $this->General_Model->altaERP($data1,$table1);

                if ( $alta > 0 AND $data_post["tipo"] == 0 ) {
                    
                    /*$sql="SELECT a.id,a.uuid,CONCAT_WS('-',a.id,b.serie,b.folio) AS folio,a.fecha,a.total,
                    IFNULL( (SELECT CONCAT_WS('/',COUNT(x.id),SUM(x.pago)) FROM alta_pagos_ppd x, alta_ppd y WHERE x.idppd=y.id AND x.idfactura= a.id AND y.estatus = 1 GROUP BY x.idfactura) ,null) AS ppd,IFNULL(c.cobrado,0) AS cobrado,IFNULL(c.posterior,0) AS posterior
                    FROM 
                    alta_factura a
                    LEFT JOIN temporal_ppdv2 c ON c.idfactura=a.id,
                    folio_factura b
                    WHERE 
                    a.idfolio = b.id
                    AND a.idcliente= '".$data_post['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.estatus = 1
                    AND a.id = '".$data_post["idfactura"]."'

                    OR

                    a.idfolio = b.id
                    AND a.idcliente= '".$data_post['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.id=".$data_post["idfactura"];*/


                    $sql="SELECT a.id,a.uuid,CONCAT_WS('-',a.id,b.serie,b.folio) AS folio,a.fecha,a.total,    
                    IFNULL( (SELECT CONCAT_WS('/',COUNT(x.id),SUM(x.pago)) FROM alta_pagos_ppd x, alta_datos_ppd w,alta_ppd y 
                    WHERE 
                    x.idppd = w.id
                    AND w.idcpd=y.id 
                    AND x.idfactura= a.id
                    AND x.tipo=0
                    AND y.estatus = 1 
                    GROUP BY x.idfactura) ,null ) AS ppd,
                    IFNULL((SELECT z.cobrado FROM temporal_ppdv2 z WHERE z.idfactura=a.id AND z.iduser=".$data_post['iduser']."),0) AS cobrado,
                    IFNULL((SELECT h.posterior FROM temporal_ppdv2 h WHERE h.idfactura=a.id AND h.iduser=".$data_post['iduser']."),0) AS posterior
                    FROM 
                    alta_factura a,
                    folio_factura b
                    WHERE 
                    a.idfolio = b.id
                    AND a.idcliente='".$data_post['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.estatus = 1
                    AND a.id = '".$data_post["idfactura"]."' 

                    OR

                    a.idfolio = b.id
                    AND a.idcliente='".$data_post['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.id =".$data_post["idfactura"];

                    echo json_encode( $this->General_Model->infoxQueryUnafila($sql) );


                }elseif ( $alta > 0 AND $data_post["tipo"] == 1 ) {
                 
                    /*$sql="SELECT a.id,a.uuid,CONCAT_WS('-',a.id,b.serie,b.folio) AS folio,a.fecha,a.total,
                    IFNULL( (SELECT CONCAT_WS('/',COUNT(x.id),SUM(x.pago)) FROM alta_pagos_ppd x, alta_ppd y WHERE x.idppd=y.id AND x.idfactura= a.id AND y.estatus = 1 GROUP BY x.idfactura) ,null) AS ppd,IFNULL(c.cobrado,0) AS cobrado,IFNULL(c.posterior,0) AS posterior
                    FROM 
                    alta_factura_sustitucion a
                    LEFT JOIN temporal_ppdv2 c ON c.idfactura=a.id,
                    folio_factura b
                    WHERE 
                    a.idfolio = b.id
                    AND a.idcliente= '".$data_post['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.estatus = 1
                    AND a.id = '".$data_post["idfactura"]."'

                    OR

                    a.idfolio = b.id
                    AND a.idcliente= '".$data_post['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.id=".$data_post["idfactura"];*/



                    $sql="SELECT a.id,a.uuid,CONCAT_WS('-',a.id,b.serie,b.folio) AS folio,a.fecha,a.total,    
                    IFNULL( (SELECT CONCAT_WS('/',COUNT(x.id),SUM(x.pago)) FROM alta_pagos_ppd x, alta_datos_ppd w,alta_ppd y 
                    WHERE 
                    x.idppd = w.id
                    AND w.idcpd=y.id 
                    AND x.idfactura= a.id
                    AND x.tipo=1
                    AND y.estatus = 1 
                    GROUP BY x.idfactura) ,null ) AS ppd,
                    IFNULL((SELECT z.cobrado FROM temporal_ppdv2 z WHERE z.idfactura=a.id AND z.iduser=".$data_post['iduser']."),0) AS cobrado,
                    IFNULL((SELECT h.posterior FROM temporal_ppdv2 h WHERE h.idfactura=a.id AND h.iduser=".$data_post['iduser']."),0) AS posterior
                    FROM 
                    alta_factura_sustitucion a,
                    folio_factura b
                    WHERE 
                    a.idfolio = b.id
                    AND a.idcliente='".$data_post['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.estatus = 1
                    AND a.id = '".$data_post["idfactura"]."' 

                    OR

                    a.idfolio = b.id
                    AND a.idcliente='".$data_post['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.id =".$data_post["idfactura"];

                    echo json_encode( $this->General_Model->infoxQueryUnafila($sql) );

                }else{

                    echo json_encode(0);

                }


            }else{

                //echo  json_encode("Error, la diferencia es "+$diferencia);
                echo json_encode(null);
                
            }

            //echo json_encode($diferencia);


        }elseif ( $data_post["texto"]==0 ) {

            /////// RETIRAMOS SU DATOS DE EXISTIR EN LA TABLA TEMPORAL

            $dtabla="temporal_ppdv2";
            $dcondicion=array('idfactura'=>$data_post["idfactura"], 'tipo'=>$data_post["tipo"]);

            $this->General_Model->deleteERP($dtabla,$dcondicion);
            
            if ( $data_post["tipo"] == 0 ) {
                    
                    /*$sql="SELECT a.id,a.uuid,CONCAT_WS('-',a.id,b.serie,b.folio) AS folio,a.fecha,a.total,
                    IFNULL( (SELECT CONCAT_WS('/',COUNT(x.id),SUM(x.pago)) FROM alta_pagos_ppd x, alta_ppd y WHERE x.idppd=y.id AND x.idfactura= a.id AND y.estatus = 1 GROUP BY x.idfactura) ,null) AS ppd,IFNULL(c.cobrado,0) AS cobrado,IFNULL(c.posterior,0) AS posterior
                    FROM 
                    alta_factura a
                    LEFT JOIN temporal_ppdv2 c ON c.idfactura=a.id,
                    folio_factura b
                    WHERE 
                    a.idfolio = b.id
                    AND a.idcliente= '".$data_post['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.estatus = 1
                    AND a.id = '".$data_post["idfactura"]."'

                    OR

                    a.idfolio = b.id
                    AND a.idcliente= '".$data_post['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.id=".$data_post["idfactura"];*/


                    $sql="SELECT a.id,a.uuid,CONCAT_WS('-',a.id,b.serie,b.folio) AS folio,a.fecha,a.total,    
                    IFNULL( (SELECT CONCAT_WS('/',COUNT(x.id),SUM(x.pago)) FROM alta_pagos_ppd x, alta_datos_ppd w,alta_ppd y 
                    WHERE 
                    x.idppd = w.id
                    AND w.idcpd=y.id 
                    AND x.idfactura= a.id
                    AND x.tipo=0
                    AND y.estatus = 1 
                    GROUP BY x.idfactura) ,null ) AS ppd,
                    IFNULL((SELECT z.cobrado FROM temporal_ppdv2 z WHERE z.idfactura=a.id AND z.iduser=".$data_post['iduser']."),0) AS cobrado,
                    IFNULL((SELECT h.posterior FROM temporal_ppdv2 h WHERE h.idfactura=a.id AND h.iduser=".$data_post['iduser']."),0) AS posterior
                    FROM 
                    alta_factura a,
                    folio_factura b
                    WHERE 
                    a.idfolio = b.id
                    AND a.idcliente='".$data_post['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.estatus = 1
                    AND a.id = '".$data_post["idfactura"]."' 

                    OR

                    a.idfolio = b.id
                    AND a.idcliente='".$data_post['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.id =".$data_post["idfactura"];

                    echo json_encode( $this->General_Model->infoxQueryUnafila($sql) );


            }elseif ( $data_post["tipo"] == 1 ) {
                 
                    /*$sql="SELECT a.id,a.uuid,CONCAT_WS('-',a.id,b.serie,b.folio) AS folio,a.fecha,a.total,
                    IFNULL( (SELECT CONCAT_WS('/',COUNT(x.id),SUM(x.pago)) FROM alta_pagos_ppd x, alta_ppd y WHERE x.idppd=y.id AND x.idfactura= a.id AND y.estatus = 1 GROUP BY x.idfactura) ,null) AS ppd,IFNULL(c.cobrado,0) AS cobrado,IFNULL(c.posterior,0) AS posterior
                    FROM 
                    alta_factura_sustitucion a
                    LEFT JOIN temporal_ppdv2 c ON c.idfactura=a.id,
                    folio_factura b
                    WHERE 
                    a.idfolio = b.id
                    AND a.idcliente= '".$data_post['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.estatus = 1
                    AND a.id = '".$data_post["idfactura"]."'

                    OR

                    a.idfolio = b.id
                    AND a.idcliente= '".$data_post['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.id=".$data_post["idfactura"];*/



                    $sql="SELECT a.id,a.uuid,CONCAT_WS('-',a.id,b.serie,b.folio) AS folio,a.fecha,a.total,    
                    IFNULL( (SELECT CONCAT_WS('/',COUNT(x.id),SUM(x.pago)) FROM alta_pagos_ppd x, alta_datos_ppd w,alta_ppd y 
                    WHERE 
                    x.idppd = w.id
                    AND w.idcpd=y.id 
                    AND x.idfactura= a.id
                    AND x.tipo=1
                    AND y.estatus = 1 
                    GROUP BY x.idfactura) ,null ) AS ppd,
                    IFNULL((SELECT z.cobrado FROM temporal_ppdv2 z WHERE z.idfactura=a.id AND z.iduser=".$data_post['iduser']."),0) AS cobrado,
                    IFNULL((SELECT h.posterior FROM temporal_ppdv2 h WHERE h.idfactura=a.id AND h.iduser=".$data_post['iduser']."),0) AS posterior
                    FROM 
                    alta_factura_sustitucion a,
                    folio_factura b
                    WHERE 
                    a.idfolio = b.id
                    AND a.idcliente='".$data_post['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.estatus = 1
                    AND a.id = '".$data_post["idfactura"]."' 

                    OR

                    a.idfolio = b.id
                    AND a.idcliente='".$data_post['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.id =".$data_post["idfactura"];

                    echo json_encode( $this->General_Model->infoxQueryUnafila($sql) );

            }else{

                echo json_encode(0);

            }


        }else{

            //echo json_encode("Alerta, la cantidad no puede ser menor o igual a 0");
            echo json_encode(null);

        }


    }

    public function enviarCorreo(){

        $data_post = $this->input->post();
        $idppd=$data_post["idppdx"];

        //////////***** DATOS DEL CLIENTE 

        $sql='SELECT CONCAT_WS("",b.serie,b.folio) AS foliox,c.nombre
            FROM alta_ppd a, folio_ppd b, alta_clientes c
            WHERE
            a.idfolio=b.id
            AND a.idcliente=c.id
            AND a.id='.$idppd;

        $row=$this->General_Model->infoxQueryUnafila($sql);

                              
  
                
                $this->load->library('email');

                /*$mensaje = '<!DOCTYPE html>
                                <html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
                                <head>
                                  <meta charset="utf-8">
                                  <meta name="viewport" content="width=device-width,initial-scale=1">
                                  <meta name="x-apple-disable-message-reformatting">
                                  <title></title>
                                  <!--[if mso]>
                                  <style>
                                    table {border-collapse:collapse;border-spacing:0;border:none;margin:0;}
                                    div, td {padding:0;}
                                    div {margin:0 !important;}
                                  </style>
                                  <noscript>
                                    <xml>
                                      <o:OfficeDocumentSettings>
                                        <o:PixelsPerInch>96</o:PixelsPerInch>
                                      </o:OfficeDocumentSettings>
                                    </xml>
                                  </noscript>
                                  <![endif]-->
                                  <style>
                                    table, td, div, h1, p {
                                      font-family: Arial, sans-serif;
                                    }
                                    @media screen and (max-width: 530px) {
                                      .unsub {
                                        display: block;
                                        padding: 8px;
                                        margin-top: 14px;
                                        border-radius: 6px;
                                        background-color: #555555;
                                        text-decoration: none !important;
                                        font-weight: bold;
                                      }
                                      .col-lge {
                                        max-width: 100% !important;
                                      }
                                    }
                                    @media screen and (min-width: 531px) {
                                      .col-sml {
                                        max-width: 27% !important;
                                      }
                                      .col-lge {
                                        max-width: 73% !important;
                                      }
                                    }
                                  </style>
                                </head>
                                <body style="margin:0;padding:0;word-spacing:normal;background-color:#aec8df;">
                                  <div role="article" aria-roledescription="email" lang="en" style="text-size-adjust:100%;-webkit-text-size-adjust:100%;-ms-text-size-adjust:100%;background-color:#aec8df;">
                                    <table role="presentation" style="width:100%;border:none;border-spacing:0;">
                                      <tr>
                                        <td align="center" style="padding:0;">
                                          <!--[if mso]>
                                          <table role="presentation" align="center" style="width:600px;">
                                          <tr>
                                          <td>
                                          <![endif]-->
                                          <table role="presentation" style="width:94%;max-width:600px;border:none;border-spacing:0;text-align:left;font-family:Arial,sans-serif;font-size:16px;line-height:22px;color:#363636;">
                                            <tr>
                                              <td style="padding:40px 30px 30px 30px;text-align:center;font-size:24px;font-weight:bold;">
                                                <a href="http://www.comanorsa.com/" style="text-decoration:none;"><img src="'.base_url().'comanorsa/logo_sombra.png" width="250" alt="Logo" style="width:165px;max-width:80%;height:auto;border:none;text-decoration:none;color:#ffffff;"></a>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="padding:30px;background-color:#ffffff;">
                                                <h1 style="margin-top:0;margin-bottom:16px;font-size:26px;line-height:32px;font-weight:bold;letter-spacing:-0.02em;">Gracias por confiar en nuestros productos</h1>
                                                <p style="margin:0;">Hemos enviado la cotización solicitada, esperando su total satisfacción tanto en producto como en precio quedamos a sus órdenes cualquier duda o aclaración.<!--<a href="http://www.example.com/" style="color:#e50d70;text-decoration:underline;">eget accumsan dictum</a>, nisi libero ultricies ipsum, in posuere mauris neque at erat.--></p>

                                                <p style="margin:0;"><a href="https://api.whatsapp.com/send?phone=5567654150&text=Hola%20quiero%20saber%20mas%20acerca%20de%20sus%20productos%20%C2%BFMe%20pueden%20ayudar?" style="background: #25D366; text-decoration: none; padding: 10px 25px; color: #ffffff; border-radius: 4px; display:inline-block; mso-padding-alt:0;text-underline-color:#25D366"><!--[if mso]><i style="letter-spacing: 25px;mso-font-width:-100%;mso-text-raise:20pt">&nbsp;</i><![endif]-->
                                                    <span style="mso-text-raise:10pt;font-weight:bold;">Comunicate con un asesor</span><!--[if mso]><i style="letter-spacing: 25px;mso-font-width:-100%">&nbsp;</i><![endif]--></a></p>

                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="padding:0;font-size:24px;line-height:28px;font-weight:bold;">
                                                <a href="http://www.comanorsa.com/" style="text-decoration:none;"><img src="'.base_url().'comanorsa/promocion.jpg" width="600" alt="" style="width:100%;height:auto;display:block;border:none;text-decoration:none;color:#363636;"></a>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="padding:35px 30px 11px 30px;font-size:0;background-color:#ffffff;border-bottom:1px solid #f0f0f5;border-color:rgba(201,201,207,.35);">
                                                <!--[if mso]>
                                                <table role="presentation" width="100%">
                                                <tr>
                                                <td style="width:145px;" align="left" valign="top">
                                                <![endif]-->
                                                <div class="col-sml" style="display:inline-block;width:100%;max-width:250px;vertical-align:top;text-align:left;font-family:Arial,sans-serif;font-size:14px;color:#363636;">
                                                  <img src="'.base_url().'comanorsa/vendedora.jpg" width="250" alt="" style="width:115px;max-width:80%;margin-bottom:20px;">
                                                </div>
                                                <!--[if mso]>
                                                </td>
                                                <td style="width:395px;padding-bottom:20px;" valign="top">
                                                <![endif]-->
                                                <div class="col-lge" style="display:inline-block;width:100%;max-width:395px;vertical-align:top;padding-bottom:20px;font-family:Arial,sans-serif;font-size:16px;line-height:22px;color:#363636;">
                                                  <p style="margin-top:0;margin-bottom:12px;">Somos una organización dedica a la comercialización de productos básicos para el buen funcionamiento de cualquier empresa como los son artículos de oficina y papelería, tecnología Informática, software, redes, artículos de limpieza y muchos más.</p>
                                                  <p style="margin-top:0;margin-bottom:18px;">Contamos con asesoría de expertos que te ayudaran para que tu compra sea la ideal para ti. </p>
                                                  <p style="margin:0;"><a href="http://comanorsa.com/" style="background: #5285b8; text-decoration: none; padding: 10px 25px; color: #ffffff; border-radius: 4px; display:inline-block; mso-padding-alt:0;text-underline-color:#5285b8"><!--[if mso]><i style="letter-spacing: 25px;mso-font-width:-100%;mso-text-raise:20pt">&nbsp;</i><![endif]-->
                                                    <span style="mso-text-raise:10pt;font-weight:bold;">Visítanos</span><!--[if mso]><i style="letter-spacing: 25px;mso-font-width:-100%">&nbsp;</i><![endif]--></a></p>
                                                </div>
                                                <!--[if mso]>
                                                </td>
                                                </tr>
                                                </table>
                                                <![endif]-->
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="padding:30px;font-size:24px;line-height:28px;font-weight:bold;background-color:#ffffff;border-bottom:1px solid #f0f0f5;border-color:rgba(201,201,207,.35);">

                                                <p style="margin:0; font-size: 17px; font-weight: bold;">Tenemos todo para tu oficina:</p>

                                                <a href="http://www.example.com/" style="text-decoration:none;"><img src="'.base_url().'comanorsa/oficina.jpg" width="600" alt="" style="width:100%;height:auto;border:none;text-decoration:none;color:#363636;"></a>
                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="padding:30px;background-color:#ffffff;">
                                                

                                                <ul>
                                                  
                                                  <li>Accesorios</li>
                                                  <li>Artículos de oficina</li>
                                                  <li>Cafeteria</li>
                                                  <li>Limpieza</li>
                                                  <li>Muebles</li>
                                                  <li>Tecnologia</li>
                                                  <li>Tintas y toners</li>
                                                  <li>Tlapaleria</li>
                                                  <li>Papeleria</li>

                                                </ul>

                                              </td>
                                            </tr>
                                            <tr>
                                              <td style="padding:30px;text-align:center;font-size:12px;background-color:#404040;color:#cccccc;">
                                                <p style="margin:0 0 8px 0;"><a href="https://www.facebook.com/Ventas-comanorsa-101556301529755" style="text-decoration:none;"><img src="https://assets.codepen.io/210284/facebook_1.png" width="40" height="40" alt="f" style="display:inline-block;color:#cccccc;"></a> </p>
                                                <p style="margin:0;font-size:14px;line-height:20px;">Comanorsa 2021<br><a class="unsub" href="http://www.comanorsa.com/" style="color:#cccccc;text-decoration:underline;">www.comanorsa.com</a></p>
                                              </td>
                                            </tr>
                                          </table>
                                          <!--[if mso]>
                                          </td>
                                          </tr>
                                          </table>
                                          <![endif]-->
                                        </td>
                                      </tr>
                                    </table>
                                  </div>
                                </body>
                            </html>';*/

                            $mensaje ='';
                
                    /////////*********enviado email
                    $configuraciones['mailtype'] = 'html';
                    $this->email->initialize($configuraciones);
                    $this->email->from(CORREOVENTAS, 'COMANORSA Complemento de pago '.$row->foliox.' - '.$row->nombre);
                    //$this->email->to("thinkweb.mx@gmail.com");
                    $this->email->to(CORREOFACTURAS);

                    $this->email->subject(  'COMANORSA Complemento de pago '.$row->foliox.' - '.$row->nombre );
                    ////ADJUNTAR ARCHIVOS
                    //$adjunto= base_url()."admin/files/admin/js/upload/files/".$this->input->post('nombre'); 
                    //$this->email->attach($adjunto);
                    $this->email->attach('tw/php/factura_comprobante_pago/'.$row->foliox.'.xml');//xml
                    $this->email->attach('tw/php/facturas_ppd/'.$row->foliox.'.pdf');//xml
                    $this->email->message($mensaje);

                if($this->email->send()){    

                    //echo json_encode($nuevo_cliente);
                      echo json_encode(true);

                }else{

                    echo json_encode(false); //echo json_encode(0);

                }

      

    }

        ///////////****************TABLA PARTIDAS BITACORA

        public function loadPartidas()
        {

            $data_get = $this->input->get();
            $iduser = $this->session->userdata('idusercomanorsa');


            /*$table = "(SELECT a.id,a.uuid,CONCAT_WS('-',a.id,b.serie,b.folio) AS folio,a.fecha,a.total,
                    IFNULL( (SELECT CONCAT_WS('/',COUNT(x.id),SUM(x.pago)) FROM alta_pagos_ppd x, alta_datos_ppd w,alta_ppd y 
                    WHERE 
                    x.idppd = w.id
                    AND w.idcpd=y.id 
                    AND x.idfactura= a.id
                    AND y.estatus = 1 
                    GROUP BY x.idfactura) ,null ) AS ppd,
                    IFNULL(c.cobrado,0) AS cobradox,IFNULL(c.posterior,0) AS posteriorx,'0' AS tipo
                    FROM 
                    alta_factura a
                    LEFT JOIN temporal_ppdv2 c ON c.idfactura=a.id,
                    folio_factura b
                    WHERE 
                    a.idfolio = b.id
                    AND a.idcliente= '".$data_get['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.estatus = 1

                    UNION ALL

                    SELECT a.id,a.uuid,CONCAT_WS('-',a.id,b.serie,b.folio) AS folio,a.fecha,a.total,
                    IFNULL( (SELECT CONCAT_WS('/',COUNT(x.id),SUM(x.pago)) FROM alta_pagos_ppd x, alta_datos_ppd w,alta_ppd y 
                    WHERE 
                    x.idppd = w.id
                    AND w.idcpd=y.id 
                    AND x.idfactura= a.id
                    AND y.estatus = 1 
                    GROUP BY x.idfactura) ,null ) AS ppd,
                    IFNULL(c.cobrado,0) AS cobradox,IFNULL(c.posterior,0) AS posteriorx,'1' AS tipo
                    FROM 
                    alta_factura_sustitucion a
                    LEFT JOIN temporal_ppdv2 c ON c.idfactura=a.id,
                    folio_factura b
                    WHERE 
                    a.idfolio = b.id
                    AND a.idcliente= '".$data_get['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.estatus = 1

                )temp";*/


            $table="(SELECT a.id,a.uuid,
                    CONCAT_WS('-',a.id,b.serie,b.folio) AS folio,
                    a.fecha,a.total,    
                    IFNULL( (SELECT CONCAT_WS('/',COUNT(x.id),SUM(x.pago)) FROM alta_pagos_ppd x, alta_datos_ppd w,alta_ppd y 
                    WHERE 
                    x.idppd = w.id
                    AND w.idcpd=y.id 
                    AND x.idfactura= a.id
                    AND x.tipo=0
                    AND y.estatus = 1 
                    GROUP BY x.idfactura) ,null ) AS ppd,
                    IFNULL((SELECT z.cobrado FROM temporal_ppdv2 z WHERE z.idfactura=a.id AND z.iduser=".$data_get['iduser']."),0) AS cobradox,
                    IFNULL((SELECT h.posterior FROM temporal_ppdv2 h WHERE h.idfactura=a.id AND h.iduser=".$data_get['iduser']."),0) AS posteriorx,
                    '0' AS tipo
                    FROM 
                    alta_factura a,
                    folio_factura b
                    WHERE 
                    a.idfolio = b.id
                    AND a.idcliente='".$data_get['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.estatus = 1

                    UNION ALL

                    SELECT a.id,a.uuid,
                    CONCAT_WS('-',a.id,b.serie,b.folio) AS folio,
                    a.fecha,a.total,    
                    IFNULL( (SELECT CONCAT_WS('/',COUNT(x.id),SUM(x.pago)) FROM alta_pagos_ppd x, alta_datos_ppd w,alta_ppd y 
                    WHERE 
                    x.idppd = w.id
                    AND w.idcpd=y.id 
                    AND x.idfactura= a.id
                    AND x.tipo=1
                    AND y.estatus = 1 
                    GROUP BY x.idfactura) ,null ) AS ppd,
                    IFNULL((SELECT z.cobrado FROM temporal_ppdv2 z WHERE z.idfactura=a.id AND z.iduser=".$data_get['iduser']."),0) AS cobradox,
                    IFNULL((SELECT h.posterior FROM temporal_ppdv2 h WHERE h.idfactura=a.id AND h.iduser=".$data_get['iduser']."),0) AS posteriorx,
                    '1' AS tipo
                    FROM 
                    alta_factura_sustitucion a,
                    folio_factura b
                    WHERE 
                    a.idfolio = b.id
                    AND a.idcliente='".$data_get['idcliente']."'
                    AND a.idmpago = 2
                    AND a.pago = 0
                    AND a.estatus = 1


                )temp";
            
  
            // Primary key of table
            $primaryKey = 'id';

            
            
            $columns = array(

               

                array( 'db' => 'fecha',     'dt' => 0,

                        'formatter' => function( $d, $row ) {

                           return obtenerFechaEnLetra($d);

                        }  
                ),

                array( 'db' => 'folio',     'dt' => 1,

                        'formatter' => function( $d, $row ) {

                           $separar = explode("-", $d);

                           return '<a href="'.base_url().'tw/php/facturas/fact'.$separar[0].'.pdf" target="_blank" tabindex="-1">'.$separar[1].''.$separar[2].'</a>';

                        }  
                ),

                
                array( 'db' => 'total',     'dt' => 2,

                        'formatter' => function( $d, $row ) {

                           return wims_currency($d);

                        }  
                ),

                array( 'db' => 'ppd',     'dt' => 3,

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

                array( 'db' => 'ppd',     'dt' => 4,

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


                array( 'db' => 'cobradox',     'dt' => 6,

                        'formatter' => function( $d, $row ) {

                            return $d;

                        }  
                ),

                array( 'db' => 'posteriorx',     'dt' => 7,

                        'formatter' => function( $d, $row ) {

                            return $d;

                        }  
                ),

                array( 'db' => 'id',     'dt' => 8 ),

                array( 'db' => 'tipo',     'dt' => 9 )
           
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
