<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'third_party/ssp.php';

class Factpedido extends CI_Controller
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
        $idcot = $this->uri->segment(3);

        $numero_menu = 10;/// se coloca el mismo identificador que el alta de cotizacion;

        ////////******* verificar menu 

        $vtabla = "menus_departamento";
        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);
        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);

        if ( $verificar_menu > 0 ) {

            ///////////* datos cotizacion

            /*$query="SELECT b.nombre AS cliente, a.idcliente,a.moneda,a.tcambio,a.observaciones,a.estatus, b.idfpago, b.idcfdi,

            (SELECT CONCAT_WS('/',z.credito,z.limite) FROM direccion_clientes z WHERE z.idcliente=b.id LIMIT 0,1) AS limitex,

            IFNULL( (SELECT SUM(x.total) FROM alta_factura x WHERE x.idcliente = b.id AND x.pago = 0 AND x.estatus IN(1,3) ), 0 ) AS totfactura,
            IFNULL( (SELECT SUM(y.total) FROM alta_remision y WHERE y.idcliente = b.id AND y.pago = 0 AND y.estatus IN(0,2) ), 0 ) AS totremision,
            IFNULL( (SELECT SUM(w.total) FROM alta_factura w WHERE w.idcliente = b.id AND w.pago = 0 AND w.estatus IN(1,3) 
            AND DATE_ADD(w.fecha,INTERVAL w.dias DAY) <= '".date('Y-m-d')."' ), 0) AS sfvencido,
            IFNULL( (SELECT SUM(z.total) FROM alta_remision z WHERE z.idcliente = b.id AND z.pago = 0 AND z.estatus IN(0,2) 
            AND DATE_ADD(z.fecha,INTERVAL '0' DAY) <= '".date('Y-m-d')."' ), 0) AS srvencido,a.odc

                    FROM alta_cotizacion a, alta_clientes b
                    WHERE a.idcliente=b.id
                    AND a.id =".$idcot;*/

            $query="SELECT b.nombre AS cliente, a.idcliente,a.moneda,a.tcambio,a.observaciones,a.estatus, b.idfpago, b.idcfdi,
            CONCAT_WS('/',b.credito,b.limite) AS limitex,
            IFNULL( (SELECT SUM(x.total) FROM alta_factura x WHERE x.idcliente = b.id AND x.pago = 0 AND x.estatus IN(1,3) ), 0 ) AS totfactura,
            IFNULL( (SELECT SUM(y.total) FROM alta_remision y WHERE y.idcliente = b.id AND y.pago = 0 AND y.estatus IN(0,2) ), 0 ) AS totremision,
            IFNULL( (SELECT SUM(w.total) FROM alta_factura w WHERE w.idcliente = b.id AND w.pago = 0 AND w.estatus IN(1,3) 
            AND DATE_ADD(w.fecha,INTERVAL w.dias DAY) <= '".date('Y-m-d')."' ), 0) AS sfvencido,
            IFNULL( (SELECT SUM(z.total) FROM alta_remision z WHERE z.idcliente = b.id AND z.pago = 0 AND z.estatus IN(0,2) 
            AND DATE_ADD(z.fecha,INTERVAL '0' DAY) <= '".date('Y-m-d')."' ), 0) AS srvencido,a.odc

                    FROM alta_cotizacion a, alta_clientes b
                    WHERE a.idcliente=b.id
                    AND a.id =".$idcot;

            $datos = $this->General_Model->infoxQueryUnafila($query);

           

            //////******* BORRAMOS EL CONTENIDO ACTUAL DE LA COTIZACION

            $tablax = "temporal_partes_facturacion";
            $condicionx = array( 'idcot' => $idcot );

            $borrar = $this->General_Model->deleteERP($tablax,$condicionx);


            $sqlx = "SELECT a.id,(a.cantidad-(SELECT IFNULL(SUM(x.cantidad),0) FROM partes_factura x WHERE x.idpartecot=a.id)) AS cantidadx 
            FROM partes_cotizacion a 
            WHERE 
            a.idcotizacion =".$idcot."
            AND (a.cantidad-( SELECT IFNULL(SUM(x.cantidad),0) FROM partes_factura x WHERE x.idpartecot=a.id )) > 0
            AND a.estatus = 0

            ORDER BY a.orden ASC";



            $partes = $this->General_Model->infoxQuery($sqlx);

            if ($partes != null ) {

                foreach ($partes as $row) {

                    $data3 = array( 'idusuario' => $iduser, 'idpartecot' => $row->id, 'idcot' => $idcot, 'cantidad' => $row->cantidadx );

                    $table3 = "temporal_partes_facturacion";

                    $this->General_Model->altaERP($data3,$table3);

                }


                /////////////*****************

                //idodc : este nos idnica que la odc de esa cotizacion ha sidfo habilitada y ya no puede haber una edicion o actualizacion
                $info_cot = array('info' => $datos, 'idcot' => $idcot);
                $info_menu = array('nommenu' => "facturacion", 'idestatus' => $datos->estatus );

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
                    $this->load->view('facturas/crear_factura',$info_cot);
                    $this->load->view('general/footer');
                    $this->load->view('facturas/acciones_factura',$info_cot);

                }else{

                    redirect("Login");

                }


            }else{

                if($iduser > 0){

                    $data["idusuario"]= $iduser;
                    //$mensaje['verificacion'] = "Ingreso correctamente por cookie";
                    $nom_menu["nommenu"] = "rcotizacion";

                    $this->load->view('general/header');
                    $this->load->view('general/menuv2');
                    $this->load->view('general/css_select2');
                    $this->load->view('general/css_datatable');
                    $this->load->view('general/menu_header',$nom_menu);
                    $this->load->view('cotizaciones/reporte_cotizacion');
                    $this->load->view('general/footer');
                    $this->load->view('cotizaciones/accciones_reporte_cotizacion');

                }else{

                    redirect("Login");

                }

            }

            

        }else{


            redirect('AccesoDenegado');

        } 

       
    }

    public function showCliente(){

        $query="SELECT id,rfc,nombre,comercial FROM `alta_clientes` WHERE estatus = 0 ORDER BY nombre ASC";

            echo json_encode( $this->General_Model->infoxQuery($query) );

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


    public function buscarxdescrip(){

        $this->load->model('Model_Buscador');
        $data = $this->input->get();

        if( strlen($data['clv']) > 0    ){

            echo json_encode(   $this->Model_Buscador->buscarProductos($data['clv'])    );  

        }else{

            $arrayName []= array('id' => 0, 'descrip'=>"");

            echo json_encode(   $arrayName  );

        }

    }


    public function enviarCorreo(){

        $data_post = $this->input->post();
        $idcotx = $data_post["idcot"];
        $foliox = trim($data_post["folio"]);
        $idclientex=trim($data_post["idcliente"]);

        //////////***** DATOS DEL CLIENTE 

        $cdata="nombre";
        $ctabla="alta_clientes";
        $ccondicion=array('id' => $idclientex );

        $datos_cliente=$this->General_Model->SelectUnafila($cdata,$ctabla,$ccondicion);

                              
  
                
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
                    $this->email->from(CORREOVENTAS, 'COMANORSA Factura '.$foliox.' - '.$datos_cliente->nombre);
                    //$this->email->to("thinkweb.mx@gmail.com");
                    $this->email->to(CORREOFACTURAS);

                    $this->email->subject(  'COMANORSA Factura '.$foliox.' - '.$datos_cliente->nombre );
                    ////ADJUNTAR ARCHIVOS
                    //$adjunto= base_url()."admin/files/admin/js/upload/files/".$this->input->post('nombre'); 
                    //$this->email->attach($adjunto);
                    $this->email->attach('tw/php/factura_comprobante/'.$foliox.'.xml');//xml
                    $this->email->attach('tw/php/facturas/'.$foliox.'.pdf');//xml
                    $this->email->message($mensaje);

                if($this->email->send()){    

                    //echo json_encode($nuevo_cliente);
                      echo json_encode(true);

                }else{

                    echo json_encode(false); //echo json_encode(0);

                }

      

    }


    public function ingresarPartidas(){

        $data_post = $this->input->post();

        $condicion1 =   array(

                            'idcotizacion' => $data_post['idcot'], 
                            'idparte' => $data_post['idparte'], 
                            'estatus' => 0
                        );

        $tabla1 = "temporal_partes_act_cotizacion";
        $repeat = $this->General_Model->verificarRepeat($tabla1,$condicion1);

        if ( $repeat == 0 ) {

            ////////********* ORDEN
            $sql="SELECT COUNT(id) AS total FROM `temporal_partes_act_cotizacion` WHERE idcotizacion = ".$data_post['idcot']." AND estatus = 0";
            $last_orden = $this->General_Model->infoxQueryUnafila($sql);
            
                $data = array(

                    'orden' => $last_orden->total+1,
                    'idcotizacion' => $data_post['idcot'],
                    'idparte' => $data_post['idparte'],
                    'cantidad' => $data_post['cantidad'],
                    'costo' => $data_post['costo'],
                    'costo_proveedor' => $data_post['cproveedor'],
                    'iva' => changeString($data_post['iva']),
                    'descuento' => $data_post['descuento'],
                    'descripcion'=> changeString($data_post['descripx']),
                    'riva' => $data_post['rivax'],
                    'risr' => $data_post['risrx'],
                    'tcambio' => $data_post['tcambiox'],
                    'utilidad' => $data_post['utilidadx']
               
                );

            $table = "temporal_partes_act_cotizacion";

            $last_id=$this->General_Model->altaERP($data,$table);

        }else{

            $last_id = 0;

        }

        
        echo json_encode( $last_id );

    }

    public function actualizarPartidas(){

        $data_post = $this->input->post();

            
                $datos = array(

                    'idusuario' => $data_post['iduser'],
                    'idparte' => $data_post['idparte'],
                    'cantidad' => $data_post['cantidad'],
                    'costo' => $data_post['costo'],
                    'iva' => changeString($data_post['iva']),
                    'descuento' => $data_post['descuento']
               
                );
                $condicion = array(

                    'id' => $data_post["idpcot"] 

                );

            $tabla = "temporal_partes_act_cotizacion";

            $last_id=$this->General_Model->updateERP($datos,$tabla,$condicion);

        echo json_encode( $last_id );

    }


    public function retirarParte(){

        $data_post = $this->input->post();

        $condicion = array( 'id' => $data_post["idpcot"] );

        $tabla="temporal_partes_facturacion";

        echo json_encode(   $this->General_Model->deleteERP($tabla,$condicion)  );

    }

    ///////////************* ACCION A COTIZACION

    public function actCotizacion(){

        $data_post = $this->input->post();
        $data = array(

                    'fecha' => date("Y-m-d"),
                    'hora' => date("H:i:s"),
                    'idcliente' => $data_post["idcliente"],
                    'observaciones' => $data_post["obsx"],
                    'moneda' => 1,//$data_post["monedax"],
                    'tcambio' => 1//$data_post["tcx"],


                );

        $table = "alta_cotizacion";
        $condicion = array('id' => $data_post["idcot"] );

        $last_id=$this->General_Model->updateERP($data,$table,$condicion);

        if ( $last_id ) {

            ////////******************BORRAR LAS PARTIDAS DE LA COTIZACION ACTUAL

            $dtabla= "partes_cotizacion";
            $dcondicion = array('idcotizacion' => $data_post["idcot"] );
            $this->General_Model->deleteERP($dtabla,$dcondicion);

            //////////******** AÑADIR LAS PARTIDAS DEL TEMPORAL A ALA NUEVA COTIZACION
            
            $sqlx = "SELECT idparte,cantidad,costo,iva,descuento,descripcion,orden,costo_proveedor,riva,risr,utilidad,tcambio FROM temporal_partes_act_cotizacion WHERE idcotizacion =".$data_post["idcot"]." AND estatus = 0 ORDER BY orden ASC";

            $partes = $this->General_Model->infoxQuery($sqlx);

            foreach ($partes as $row) {

                $data3 = array( 'idcotizacion' => $data_post["idcot"], 'idparte' => $row->idparte, 'costo_proveedor' => $row->costo_proveedor,'cantidad' => $row->cantidad, 'costo' => $row->costo, 'iva' => $row->iva, 'descuento' => $row->descuento, 'descripcion' => $row->descripcion, 'orden' => $row->orden, 'riva' =>$row->riva, 'risr' =>$row->risr, 'utilidad' =>$row->utilidad, 'tcambio' =>$row->tcambio );

                $table3 = "partes_cotizacion";

                $this->General_Model->altaERP($data3,$table3);

            }


            echo json_encode($data_post["idcot"]);

        }else{

            echo json_encode(0);

        }

    }

    public function remCotizacion(){

        $data_post = $this->input->post();
        $data = array(

                    'fecha' => date("Y-m-d"),
                    'hora' => date("H:i:s"),
                    'idcotizacion' => $data_post["idcot"],
                    'observaciones' => $data_post["obsx"],
                    'idcliente' => $data_post["idcliente"]
                   
                );

        $table = "alta_remision";

        $last_id=$this->General_Model->altaERP($data,$table);

        if ( $last_id > 0 ) {
            
            $data2 = array('estatus' => 1, 'documento' => $last_id );
            $table2 = "alta_cotizacion";
            $condicion2 = array('id' => $data_post["idcot"]);

            $this->General_Model->updateERP($data2,$table2,$condicion2);

            //////***************** PASAR LAS PARTIDAS DE LA COTIZACION A ASIGNACION Y ENTREGA

            ////////******************BORRAR LAS PARTIDAS DE LA COTIZACION ACTUAL

            /*$dtabla= "partes_cotizacion";
            $dcondicion = array('idcotizacion' => $data_post["idcot"] );
            $this->General_Model->deleteERP($dtabla,$dcondicion);

            //////////
            
            $sqlx = "SELECT idparte,cantidad,id,iva,costo_proveedor,costo,descuento,descripcion,orden FROM `temporal_partes_act_cotizacion` WHERE idcotizacion = ".$data_post["idcot"]." AND estatus = 0";

            //$partes = $this->General_Model->SelectsinOrder($data2,$tabla2,$condicion2);
            $partes = $this->General_Model->infoxQuery($sqlx);

            foreach ($partes as $row) {

                ////// ACTUALIZAR LAS NUEVAS PARTIDAS DE LA COTIZACION

                $data3 = array( 'idcotizacion' => $data_post["idcot"], 'idparte' => $row->idparte, 'costo_proveedor' => $row->costo_proveedor,'cantidad' => $row->cantidad, 'costo' => $row->costo, 'iva' => $row->iva, 'descuento' => $row->descuento, 'descripcion' => $row->descripcion, 'orden' => $row->orden );

                $table3 = "partes_cotizacion";

                $this->General_Model->altaERP($data3,$table3);


            */


                ////// ORDEN DE COMPRA

                /*$data3 = array( 'fecha' => date("y-m-d"), 'hora' => date("H:i:s"), 'idcot' =>$data_post["idcot"], 'idpartecot' => $row->id, 'cantidad'=> $row->cantidad, 'idparte'=> $row->idparte, 'idproveedor' => 1, 'costo' => $row->costo_proveedor );

                $table3 = "partes_asignar_oc";

                $this->General_Model->altaERP($data3,$table3);

                ///// ENTREGA

                $data3 = array( 'fecha' => date("y-m-d"), 'hora' => date("H:i:s"), 'idpartefolio' =>$row->id, 'idfolio' => $last_id, 'cantidad'=> $row->cantidad, 'idtipo'=> 1);

                $table3 = "partes_entrega";

                $this->General_Model->altaERP($data3,$table3);

                

            }  
                */
        }


        echo json_encode($last_id);

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
                    'odc' => $data_post["odc"],
                    'obs_factura' => $data_post["obs_factura"],
                    'no_odc' => $data_post["no_odc"],

                    
                    

                    
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
                        CONCAT_WS(' ',b.clave,e.descripcion,d.marca) AS descrip, 
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

        //echo json_encode($ruta_actual);

    }


    public function simularFactura(){


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
                    'odc' => $data_post["odc"],
                    'obs_factura' => $data_post["obs_factura"],
                    'no_odc' => $data_post["no_odc"],

                    
                    

                    
        );

        $table = "alta_factura";

        $last_id=$this->General_Model->altaERP($data,$table);

        if ( $last_id > 0 ) {
            
            $data2 = array('estatus' => 3, 'documento' => $last_id );
            $table2 = "alta_cotizacion";
            $condicion2 = array('id' => $data_post["idcot"]);

            $this->General_Model->updateERP($data2,$table2,$condicion2);


            /////////////******************* COLOCAMOS EL ULTIMO ID DE FOLIO FACTURA EN ALTA FACTURA

            $sql_info="SELECT folio FROM folio_factura ORDER BY id DESC LIMIT 0,1";

            $info=$this->General_Model->infoxQueryUnafila($sql_info);

            $nuevo_folio=$info->folio+1;


            $fdata = array('serie' =>'BDL', 'folio' =>$nuevo_folio);
            $ftable="folio_factura";

            $this->General_Model->altaERP($fdata,$ftable);


            $usql="UPDATE alta_factura SET ftimbrado = '".date('Y-m-d')."', htimbrado='".date('H:i:s')."',idfolio = (SELECT MAX(x.id) FROM folio_factura x), estatus=1 WHERE id=".$last_id;

            $this->General_Model->infoxQueryUpt($usql);

            /////////************* CAMBIAR ODC

            /*$ruta_actual="tw/js/upload_odc/files/".$data_post['odc'];

            $ruta_nueva="tw/js/odc_cliente/odc".$last_id.".pdf";

            if(copy($ruta_actual,$ruta_nueva)){

                $data2x = array('odc' => "odc".$last_id.".pdf");
                $table2x = "alta_factura";
                $condicion2x = array('id' => $last_id);

                $this->General_Model->updateERP($data2x,$table2x,$condicion2x);

            }*/


            //////***************** PASAR LAS PARTIDAS DEL TEMPORAL DE FACTURACION A LA FACTURA

            $sql_partes="SELECT a.id,b.nparte AS clave,
                        CONCAT_WS(' ',b.clave,e.descripcion,d.marca) AS descrip, 
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

        //echo json_encode($ruta_actual);


    }

    public function newCotizacion(){

        $data_post = $this->input->post();

        $data = array(

                    'fecha' => date("Y-m-d"),
                    'fcotizacion' => date("Y-m-d"),
                    'hora' => date("H:i:s"),
                    'idcliente' => $data_post["idcliente"],
                    'observaciones' => $data_post["obsx"],
                    'moneda' => $data_post["monedax"],
                    'tcambio' => $data_post["tcx"],
                    'idusuario' => $data_post["iduser"]


        );

        $table = "alta_cotizacion";

        $last_id=$this->General_Model->altaERP($data,$table);

        if ( $last_id > 0 ) {

            //////////******** AÑADIR LAS PARTIDAS DEL TEMPORAL A ALA NUEVA COTIZACION
            
            $sqlx = "SELECT idparte,cantidad,costo,iva,descuento,descripcion,orden,costo_proveedor,riva,risr FROM temporal_partes_act_cotizacion WHERE idcotizacion =".$data_post['idcot']." AND estatus = 0 ORDER BY orden ASC";

            $partes = $this->General_Model->infoxQuery($sqlx);

            foreach ($partes as $row) {

                $data3 = array( 'idcotizacion' => $last_id, 'idparte' => $row->idparte, 'costo_proveedor' => $row->costo_proveedor,'cantidad' => $row->cantidad, 'costo' => $row->costo, 'iva' => $row->iva, 'descuento' => $row->descuento, 'descripcion' => $row->descripcion, 'orden' => $row->orden, 'riva'=>$row->riva, 'risr'=>$row->risr  );

                $table3 = "partes_cotizacion";

                $this->General_Model->altaERP($data3,$table3);

            }


            echo json_encode($last_id);

        }else{

            echo json_encode(0);

        }



    }


    public function habilitarFact(){

        $data_post=$this->input->post();

        $queryx='SELECT id FROM alta_usuarios WHERE pass="'.$data_post["adminpass"].'" AND iddepartamento=1';

        echo json_encode( $this->General_Model->infoxQueryUnafila($queryx) );

    }

    public function porcientoAll(){

        $data_post = $this->input->post();

        if ( $data_post["gutilidad"] >= 0 AND $data_post["gdescuento"] >= 0 ) {

            if ( $data_post["gdescuento"] > 0 ) {
                
                $porcientodesc = $data_post["gdescuento"];

            }else{

                $porcientodesc = 0;

            }

            if ( $data_post["gutilidad"] > 0 ) {
                
                $porcientoutil = $data_post["gutilidad"]/100;

            }else{

                $porcientoutil = 0;

            }

            $datos = " costo=costo_proveedor+(costo_proveedor*".$porcientoutil."), descuento=".$porcientodesc;


        }elseif ( $data_post["gutilidad"] >= 0 ) {

            if ( $data_post["gutilidad"] > 0 ) {
                
                $porcientoutil = $data_post["gutilidad"]/100;

            }else{

                $porcientoutil = 0;

            }

            $datos = "costo=costo_proveedor+(costo_proveedor*".$porcientoutil.")";


        }elseif (  $data_post["gdescuento"] >= 0  ) {
            
            if ( $data_post["gdescuento"] > 0 ) {
                
                $porcientodesc = $data_post["gdescuento"];

            }else{

                $porcientodesc = 0;

            }

            
            $datos = " descuento=".$porcientodesc;

        }

        $query = "UPDATE temporal_partes_act_cotizacion SET ".$datos." WHERE idusuario=".$this->session->userdata(IDUSERCOM);

        echo json_encode( $this->General_Model->infoxQueryUpt($query) );

        //echo json_encode($query);

    }

    public function porcientoFal(){

        $data_post = $this->input->post();

        if ( $data_post["gutilidad"] >= 0 ) {

            if ( $data_post["gutilidad"] > 0 ) {
                
                $porcientoutil = $data_post["gutilidad"]/100;

            }else{

                $porcientoutil = 0;

            }

            $datos = "costo=costo_proveedor+(costo_proveedor*".$porcientoutil.")";


        }

        if (  $data_post["gdescuento"] >= 0  ) {
            
            if ( $data_post["gdescuento"] > 0 ) {
                
                $porcientodesc = $data_post["gdescuento"];

            }else{

                $porcientodesc = 0;

            }

            
            $datos2 = " descuento=".$porcientodesc;

        }

        /////////*********** ACTUALIZACION DESCUENTO

        $query = "UPDATE temporal_partes_act_cotizacion SET ".$datos2." WHERE idusuario=".$this->session->userdata(IDUSERCOM)." AND descuento = 0";

        $this->General_Model->infoxQueryUpt($query);

        /////////*********** ACTUALIZACION UTILIDAD

        $query2 = "UPDATE temporal_partes_act_cotizacion SET ".$datos." WHERE idusuario=".$this->session->userdata(IDUSERCOM)." AND costo = 0";

        $this->General_Model->infoxQueryUpt($query2);

        if ( $query2 == true OR $query == true ) {
            
            $valor = true;

        }

        echo json_encode( $valor );

    }

    ////////******************

    public function updateCelda(){

        $data_post = $this->input->post();
        
        $error = 0;

        function quitarPesos($string)
        {
         
            $string = trim($string);
         
            $string = str_replace(
                array('$', ' ', ','),
                array('', '', ''),
                $string
            );

            return $string;

        }

        switch ( $data_post["columna"] ) {

            case 2:

                /// cantidad

                if ( $data_post["texto"] > 0 ) {
                   
                    $datos = array(
                        
                        'cantidad' => $data_post["texto"]
                       
                    );

                }else{

                    $error = 1;

                }
                
            break;

            
                
                       
        }
        
              
        if ( $error == 0 ) {


            ///// TRAER LA CANTIDAD QUE PERTENECE A ESA COTIZACION
            
            $sqlx="SELECT (a.cantidad-( SELECT IFNULL(SUM(x.cantidad),0) FROM partes_factura x WHERE x.idpartecot=a.id )) AS cantidadx 
                    FROM partes_cotizacion a WHERE a.id=".$data_post["idpcotizacion"];
            //$condicion_cot = array( 'id' => $data_post["idpcot"] );
            $info_cot = $this->General_Model->infoxQueryUnafila($sqlx);

            $diferencia=$info_cot->cantidadx-$data_post["texto"];       

            if ( $diferencia == 0 or $diferencia > 0 ) {
                
                $condicion = array(

                    'id' => $data_post["idpcot"] 

                );

                $tabla = "temporal_partes_facturacion";

                $update=$this->General_Model->updateERP($datos,$tabla,$condicion);

                if( $update ){

                    $sql="SELECT a.cantidad,b.costo,b.descripcion,b.descuento,(a.cantidad*b.costo) AS subtotal,
                    ( (a.cantidad*b.costo)*( (b.descuento/100) ) ) AS tdescuento,
                    ( ((a.cantidad*b.costo)-((a.cantidad*b.costo)*( ROUND( (b.descuento/100),2 ) )))*( ROUND( (b.iva/100),2 ) )) AS tiva,b.utilidad,b.tcambio 
                    FROM temporal_partes_facturacion a, partes_cotizacion b 
                    WHERE 
                    a.idpartecot=b.id
                    AND a.id=".$data_post["idpcot"];

                    echo json_encode( $this->General_Model->infoxQueryUnafila($sql) );

                }

            }else{

                echo json_encode(0);

            }
                

        }else{


            $update = null;

            echo json_encode( $update );

        }

    }


        ///////////****************TABLA PARTIDAS BITACORA

        /* public function loadPartidas()
        {

            $data_get = $this->input->get();
            $iduser = $this->session->userdata(IDUSERCOM);

            $table = "(SELECT a.id,b.nparte AS clave,
                        CONCAT_WS(' ',b.clave,e.descripcion,d.marca) AS descrip, 
                        c.descripcion AS unidad, 
                        e.costo, e.iva,e.descuento,
                        (a.cantidad*e.costo) AS subtotal,
                        a.cantidad,e.idparte,
                        ROUND( ( ( (a.cantidad*e.costo)-( (a.cantidad*e.costo)*( e.descuento/100 ) ))*( e.iva/100 )),2 ) AS tiva,
                        ROUND( ( (a.cantidad*e.costo)*( e.descuento/100 ) ),2 ) AS tdescuento,
                        e.orden,e.utilidad,e.tcambio,
                        e.costo_proveedor, e.id AS idpcot
                        FROM temporal_partes_facturacion a, partes_cotizacion e,alta_productos b, sat_catalogo_unidades c, alta_marca d
                        WHERE a.idpartecot=e.id 
                        AND e.idparte=b.id
                        AND b.idunidad=c.id
                        AND b.idmarca = d.id
                        AND a.idcot = ".$data_get['idcot']."
                        AND a.estatus = 0)temp";


            // Primary key of table
            $primaryKey = 'id';
            
            $columns = array(



                array( 'db' => 'id',     'dt' => 0,

                        'formatter' => function( $d, $row ) {

                            return '<button class="btn btn-red" type="button" class="form-control" onclick="retirarParte('.$d.')" tabindex="-1"><i class="fa fa-trash"></i></button>';

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

                array( 'db' => 'subtotal',     'dt' => 15,

                        'formatter' => function( $d, $row ) {

                            return round($d,2);

                        }

                ),
                array( 'db' => 'tiva',     'dt' => 16,

                        'formatter' => function( $d, $row ) {

                            return round($d,2);

                        }

                ),

                array( 'db' => 'tdescuento',     'dt' => 17,

                        'formatter' => function( $d, $row ) {

                            return round($d,2);

                        }


                 ),
                array( 'db' => 'costo_proveedor',     'dt' => 18,

                        'formatter' => function( $d, $row ) {

                            return round($d,2);

                        }


                ),
                array( 'db' => 'idpcot',     'dt' => 19 )

           
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
        */
        public function loadPartidas(){
            
            $data_get = $this->input->get();
            $iduser = $this->session->userdata(IDUSERCOM);

            $data = array();
            $pregunta = array();

            $sql= "SELECT a.id,b.nparte AS clave,
                    CONCAT_WS(' ',b.clave,e.descripcion,d.marca) AS descrip, 
                    c.descripcion AS unidad, 
                    e.costo, e.iva,e.descuento,
                    (a.cantidad*e.costo) AS subtotal,
                    a.cantidad,e.idparte,
                    ROUND( ( ( (a.cantidad*e.costo)-( (a.cantidad*e.costo)*( e.descuento/100 ) ))*( e.iva/100 )),2 ) AS tiva,
                    ROUND( ( (a.cantidad*e.costo)*( e.descuento/100 ) ),2 ) AS tdescuento,
                    e.orden,e.utilidad,e.tcambio,
                    e.costo_proveedor, e.id AS idpcot
                    FROM temporal_partes_facturacion a, partes_cotizacion e,alta_productos b, sat_catalogo_unidades c, alta_marca d
                    WHERE a.idpartecot=e.id 
                    AND e.idparte=b.id
                    AND b.idunidad=c.id
                    AND b.idmarca = d.id
                    AND a.idcot = ".$data_get['idcot']."
                    AND a.estatus = 0";

                $datos=$this->General_Model->infoxQuery($sql);                

                if ($datos!=null) {
                    
                    foreach ($datos as $row) {

                        //$separar=explode("/",$row->acciones);
                       
                        $pregunta[] = array(

                            'ID'=>$row->id,
                            'ACCION'=>'<button class="btn btn-red" type="button" class="form-control" onclick="retirarParte('.$row->id.')" tabindex="-1"><i class="fa fa-trash"></i></button>',
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

                        );

                    }

                }


                $data = array("data"=>$pregunta);
                header('Content-type: application/json');
                echo json_encode($data);
        }
   

}
