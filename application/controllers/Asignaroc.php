<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class Asignaroc extends CI_Controller

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



    public function index()

    {

        $iduser = $this->session->userdata(IDUSERCOM);





        $numero_menu = 15;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



            $dmenu["nommenu"] = "asignar";

            

           

            if($iduser > 0){



                $this->load->view('general/header');

                $this->load->view('general/css_select2');

                $this->load->view('general/css_autocompletar');

                //$this->load->view('general/css_xedit');

                $this->load->view('general/css_date');

                $this->load->view('general/css_datatable');

                $this->load->view('general/menuv2');

                $this->load->view('general/menu_header',$dmenu);

                $this->load->view('compras/alta_oc');

                $this->load->view('general/footer');

                $this->load->view('compras/acciones_alta_oc');



            }else{



                redirect("Login");



            }



        }else{



            redirect('AccesoDenegado');



        }

       

    }



    public function showProveedor(){



        $query="SELECT id,nombre,comercial,rfc FROM alta_proveedores WHERE estatus = 0 ORDER BY nombre ASC";



            echo json_encode( $this->General_Model->infoxQuery($query) );



    }



    public function showProAsignado(){



        $query="SELECT DISTINCT(a.idproveedor) AS idprox,b.nombre,b.comercial

        FROM partes_asignar_oc a, alta_proveedores b

        WHERE a.estatus = 0

        AND a.idproveedor=b.id

        AND a.idproveedor NOT IN(1)

        AND a.idoc = 0

        ORDER BY b.nombre ASC";



        echo json_encode( $this->General_Model->infoxQuery($query) );



    }



    public function showDocumentos(){



        $query="SELECT DISTINCT(a.idcot) AS idcotx, CONCAT_WS( ' ','COT#',(SELECT y.id FROM alta_cotizacion y WHERE y.id = a.idcot) ) AS documento,

        (SELECT x.nombre FROM alta_cotizacion z, alta_clientes x WHERE z.idcliente=x.id AND z.id = a.idcot) AS clientex

        FROM `partes_asignar_oc` AS a WHERE a.idoc = 0 AND a.idproveedor = 1 ORDER BY `idcotx` ASC";



            echo json_encode( $this->General_Model->infoxQuery($query) );



    }



    public function showDias(){



        $data_post = $this->input->post();



        $data="dias";

        $tabla = "alta_proveedores";

        $condicion = array('id' => $data_post['idprov'] );



        echo json_encode( $this->General_Model->SelectUnafila($data,$tabla,$condicion) );



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





    public function asignarPartidas(){



        $data_post = $this->input->post();



        $arrayid = $data_post["idpoc"];

        $idproveedor = $data_post["idpro"];



        for ($i=0; $i < count($arrayid); $i++) {



            $datos = array('idproveedor' => $idproveedor );

            $tabla = "partes_asignar_oc";

            $condicion = array('id' => $arrayid[$i]);



            $lastupt=$this->General_Model->updateERP($datos,$tabla,$condicion);

        }



        echo json_encode(true);



    }



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



            case 7:



            /// solicitar



            /////********** REVISAR QUE LA CANTIDAD SOLICITADA SEA IGUAL O MENOR A LA COMPRADA AL SER EST MENOR QUEIRE DECIR QUE LO RESTANTE SE SOLICITARA EN UN PROXIMO PEDIDO 



            $solicitado=$data_post["pedido"]-$data_post["almacen"];



            if ( $solicitado > 0 ) {

             

                $diferencia=$solicitado-$data_post["texto"];



                if ( $diferencia > 0 ) {



                    //////////////// lo solicitado es mayor a lo requerido en esta orden por lo tanto la diferencia se va a insertar como nueva partida en la asignacion



                    //INSERT INTO `partes_asignar_oc` (`id`, `fecha`, `hora`, `idcot`, `idpartecot`, `idoc`, `cantidad`, `cantidad_oc`, `idparte`, `idproveedor`, `costo_proveedor`, `costo`, `iva`, `descuento`, `estatus`) VALUES (NULL, '2022-08-04', '19:43:19', '896', '18235', '0', '10.00', '0', '42', '1', '10.00', '12.00', '16', '2', '0');



                    $sql1="SELECT idcot,idpartecot,idoc,cantidad,cantidad_oc,idparte,idproveedor,costo_proveedor,costo,iva,descuento FROM `partes_asignar_oc` where id=".$data_post["idpcot"];

                    $partes = $this->General_Model->infoxQuery($sql1);



                    foreach ($partes as $row) {



                        $pdatos = array('fecha' => date("Y-m-d"),'hora' => date("H:i:s"),'idcot'=>$row->idcot, 'idpartecot'=>$row->idpartecot, 'idoc'=>0, 'cantidad'=>$diferencia, 'cantidad_oc'=>$row->cantidad_oc, 'idparte'=>$row->idparte, 'idproveedor'=>1, 'costo_proveedor'=>$row->costo_proveedor,'costo'=>$row->costo,'iva'=>$row->iva,'descuento'=>$row->descuento );



                        $table3="partes_asignar_oc";

                        $this->General_Model->altaERP($pdatos,$table3);



                    }



                    

                }



            } 







            if ( $data_post["texto"] > 0 ) {

               

                $datos = array(

                    

                    'cantidad' => $data_post["texto"]

                   

                );



            }else{



                $error = 1;



            }



            break;



            case 8:



            /// costo



            if ( quitarPesos($data_post["texto"]) > 0 ) {

               

                $datos = array(

                    

                    'costo' => quitarPesos($data_post["texto"]),

                    'iva' => $data_post["iva"]

                   

                );



            }else{



                $error = 1;



            }

                

            break;



            case 9:



                /// descuento



                if ( $data_post["texto"] >= 0) {

                   

                    $datos = array(

                        

                        'descuento' => $data_post["texto"]

                       

                    );



                }else{



                    $error = 1;



                }

                

            break;

                       

        }



        

              

        if ( $error == 0 ) {

            



            $condicion = array(



                    'id' => $data_post["idpcot"] 



                );



            $tabla = "partes_asignar_oc";



            echo json_encode($this->General_Model->updateERP($datos,$tabla,$condicion));



           



        }else{





            $update = null;



            echo json_encode( $update );



        }



    }





    public function enviarCorreo(){



        $data_post = $this->input->post();

        $idocx = $data_post["idodc"];

                

                $this->load->library('email');



                $mensaje = '<!DOCTYPE html>

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

                            </html>';

                

                    /////////*********enviado email

                    $configuraciones['mailtype'] = 'html';

                    $this->email->initialize($configuraciones);

                    $this->email->from(CORREOVENTAS, 'Orden de compra ODC'.$idocx.' - Comanorsa | Comercializadora angel de oriente S.A. DE C.V.');

                    //$this->email->to("thinkweb.mx@gmail.com");

                    $this->email->to(CORREOCOMPRAS);



                    $this->email->subject(  'Correo generado de forma automatica sistema Comanorsa' );

                    ////ADJUNTAR ARCHIVOS

                    //$adjunto= base_url()."admin/files/admin/js/upload/files/".$this->input->post('nombre'); 

                    //$this->email->attach($adjunto);

                    $this->email->attach('tw/php/ordencompra/odc'.$idocx.'.pdf');

                    $this->email->message($mensaje);



                if($this->email->send()){    



                    //echo json_encode($nuevo_cliente);

                      echo json_encode(true);



                }else{



                    echo json_encode(false); //echo json_encode(0);



                }



      



    }



    public function finalizarOc(){



        $data_post = $this->input->post();



        $data = array(

  

                    'fecha' => date("Y-m-d"),

                    'fentrega' => $data_post["entrega"],

                    'hora' => date("H:i:s"),

                    'idusuario' => $data_post["iduser"],

                    'idpro' => $data_post["idpro"],

                    'observaciones' => changeString($data_post["obs"]),

                    'moneda' => 1,

                    'dias' => $data_post["dias"]



                );



        $table = "alta_oc";



        $last_id=$this->General_Model->altaERP($data,$table);



        if ( $last_id > 0 ) {

            

            $datos = array('idoc' => $last_id );

            

            $condicion = array('idproveedor' => $data_post["idpro"], 'idoc' => 0);

            $tabla = "partes_asignar_oc";



            $this->General_Model->updateERP($datos,$tabla,$condicion);



            ///////******* MANDAR LAS PARTIDAS AL TEMPORAL DE ENTRADAS



            $sqlx = "SELECT a.idparte,a.cantidad,a.id,a.idpartecot,

                CASE (SELECT t.iva FROM alta_productos t WHERE t.id=a.idparte) WHEN 1 THEN (SELECT z.iva FROM datos_generales z WHERE z.estatus = 0) WHEN 2 THEN 0 WHEN 3 THEN (SELECT t.tasa FROM alta_productos t WHERE t.id=a.idparte) END AS ivax

                FROM `partes_asignar_oc` a WHERE idoc = ".$last_id;



            //$partes = $this->General_Model->SelectsinOrder($data2,$tabla2,$condicion2);

            $partes = $this->General_Model->infoxQuery($sqlx);



            foreach ($partes as $row) {



                /////****** VALIDAR SI LA CANTIDAD CUMPLE CON LO SOLICITADO Y SER ESTE NUMERO MAYOR MANDAR ESA CANTIDAD AL ALMACEN 



                /*$salmaen = $cantidad_oc - $cantidad;



                if ( $salmaen > 0 ) {

                    

                    ///// la diferencia se colocara para la solicitud de almacen







                }*/





                $data3 = array( 'fecha' => date("y-m-d"), 'idoc' =>$last_id, 'idparteoc' => $row->id, 'idpartecot' => $row->idpartecot, 'cantidad'=> $row->cantidad, 'idparte'=> $row->idparte);

                $table3 = "partes_entrada";



                $this->General_Model->altaERP($data3,$table3);



                /////////********** actualizar el iva de odc



                $datos2= array('iva' => $row->ivax );

                $tabla2 = "partes_asignar_oc";

                $condicion2 = array('id' => $row->id );



                $this->General_Model->updateERP($datos2,$tabla2,$condicion2);



            }  



            echo json_encode($last_id);



        }else{



            echo json_encode(0);



        }



    }



    public function cancelarOC(){



        $data_post = $this->input->post();



        $condicion = array( 'idusuario' => $data_post["iduser"] );



        $tabla="temporal_partes_compras";



        echo json_encode(   $this->General_Model->deleteERP($tabla,$condicion)  );

        

    }





        ///////////****************TABLA PARTIDAS 



        public function loadPartidas()

        {



            $iduser = $this->session->userdata('idusercomanorsa');

            $data_get = $this->input->get();



            if ( $data_get["cot"] > 0 ) {

                

                $table = "( SELECT a.id,a.idoc,a.idcot,b.nparte,

                        CONCAT_WS('/',a.id,a.idproveedor) AS asignar,

                        CONCAT_WS('/',b.nparte,b.descripcion) AS descrip,

                        c.nombre AS proveedor, a.cantidad,'0' AS almacen,a.costo,

                        CASE (SELECT t.iva FROM alta_productos t WHERE t.id=a.idparte) WHEN 1 THEN (SELECT z.iva FROM datos_generales z WHERE z.estatus = 0) WHEN 2 THEN 0 WHEN 3 THEN (SELECT t.tasa FROM alta_productos t WHERE t.id=a.idparte) END AS ivax,

                        a.descuento, a.cantidad_oc

                        FROM partes_asignar_oc a, alta_productos b, alta_proveedores c

                        WHERE a.idparte=b.id

                        AND a.idproveedor=c.id

                        AND a.estatus = 0

                        AND a.idproveedor = 1 AND a.idcot = ".$data_get['cot']." )temp"; 



            }elseif ( $data_get["cot"] == 0 ) {

                

                $table = "( SELECT a.id,a.idoc,a.idcot,b.nparte,

                        CONCAT_WS('/',a.id,a.idproveedor) AS asignar,

                        CONCAT_WS('/',b.nparte,b.descripcion) AS descrip,

                        c.nombre AS proveedor, a.cantidad,'0' AS almacen,a.costo,

                        CASE (SELECT t.iva FROM alta_productos t WHERE t.id=a.idparte) WHEN 1 THEN (SELECT z.iva FROM datos_generales z WHERE z.estatus = 0) WHEN 2 THEN 0 WHEN 3 THEN (SELECT t.tasa FROM alta_productos t WHERE t.id=a.idparte) END AS ivax,

                        a.descuento, a.cantidad_oc

                        FROM partes_asignar_oc a, alta_productos b, alta_proveedores c

                        WHERE a.idparte=b.id

                        AND a.idproveedor=c.id

                        AND a.estatus = 0

                        AND a.idproveedor = 1 )temp"; 



            }

  

            // Primary key of table

            $primaryKey = 'id';

            

            $columns = array(



                array( 'db' => 'asignar',     'dt' => 0,



                        'formatter' => function( $d, $row ) {



                            $separar = explode("/", $d);



                            if ( $separar[1] > 0 ) {

                                

                                return '<input type="checkbox" name="menux" value="'.$separar[0].'" style="border-color:#FF338A; border-style:solid;" tabindex="-1">';



                            }else{



                                return '<input type="checkbox" name="menux" value="'.$separar[0].'" style="border-color:#FF338A; border-style:solid;" tabindex="-1">';



                            }





                        }  

                ),



                array( 'db' => 'idcot',     'dt' => 1,



                        'formatter' => function( $d, $row ) {



                                //$separar = explode(" ", $d);



                                /*if ( $separar[0] == "REM" ) {

                                    

                                    return '<a href="'.base_url().'tw/php/remisiones/rem'.$separar[1].'.pdf" target="_blank" style="color:#F7694C;"  tabindex="-1">'.$d.'</a>';



                                }else{



                                    return '<a href="'.base_url().'tw/php/facturaciones/fact'.$separar[1].'.pdf" target="_blank" style="color:darkgreen;"  tabindex="-1">'.$d.'</a>';



                                }*/



                                return '<a href="'.base_url().'tw/php/cotizaciones/cot'.$d.'.pdf" target="_blank" style="color:darkblue;"  tabindex="-1">Cot#'.$d.'</a>';



                        }  

                ),



                //array( 'db' => 'proveedor',     'dt' => 2 ),



                array( 'db' => 'nparte',     'dt' => 2 ),



                array( 'db' => 'descrip',     'dt' => 3,



                        'formatter' => function( $d, $row ) {



                                $separar = explode("/", $d);



                                return '<p title="'.utf8_encode($separar[1]).'">'.utf8_encode($separar[0]).'&nbsp;&nbsp;'.utf8_encode( substr($separar[1],0,30) ).'</p>';



                        }  

                ),



                

                array( 'db' => 'cantidad',     'dt' => 4 ),

                array( 'db' => 'almacen',     'dt' => 5 ),



                //array( 'db' => 'cantidad_oc', 'dt' => 6 ),

               

                array( 'db' => 'costo',        

                        'dt' => 8,

                        'formatter' => function( $d, $row ) {



                            return "<p>".wims_currency($d)."</p>";



                        }

                ), 

                array( 'db' => 'descuento',     'dt' => 9 ),

                array( 'db' => 'ivax',     'dt' => 10 ),



                array( 'db' => 'id',     'dt' => 12 ),

                array( 'db' => 'idoc',     'dt' => 13),

                array( 'db' => 'cantidad_oc',     'dt' => 14)

           

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





        ///////////****************TABLA PARTIDAS POR PROVEEDOR



        public function loadPartidaspro()

        {



            $iduser = $this->session->userdata('idusercomanorsa');



            $data_get = $this->input->get();



            /*



                SELECT a.id,a.idoc,

                        CONCAT_WS('/',a.id,a.idproveedor) AS asignar,

                        IF( (SELECT x.estatus FROM alta_cotizacion x WHERE x.id=a.idcot) = 1, CONCAT_WS( ' ','REM',(SELECT y.id FROM alta_remision y WHERE y.idcotizacion = a.idcot) ), 

                        CONCAT_WS( ' ','FACT',(SELECT z.id FROM alta_factura z WHERE z.idcotizacion = a.idcot) ) ) AS documento,

                        CONCAT_WS('/',b.nparte,b.descripcion) AS descrip,

                        c.nombre AS proveedor, a.cantidad,'0' AS almacen,a.costo,

                        CASE (SELECT t.iva FROM alta_productos t WHERE t.id=a.idparte) WHEN 1 THEN (SELECT z.iva FROM datos_generales z) WHEN 2 THEN 0 WHEN 3 THEN (SELECT t.tasa FROM alta_productos t WHERE t.id=a.idparte) END AS ivax,

                        a.descuento

                        FROM partes_asignar_oc a, alta_productos b, alta_proveedores c

                        WHERE a.idparte=b.id

                        AND a.idproveedor=c.id

                        AND a.estatus = 0

                        AND a.idoc = 0

                        AND a.idproveedor = 

                

            */





            $table = "( SELECT a.id,a.idoc,a.idcot,b.nparte,

                        CONCAT_WS('/',a.id,a.idproveedor) AS asignar,

                        CONCAT_WS('/',b.nparte,b.descripcion) AS descrip,

                        c.nombre AS proveedor, a.cantidad,'0' AS almacen,a.costo,

                        CASE (SELECT t.iva FROM alta_productos t WHERE t.id=a.idparte) WHEN 1 THEN (SELECT z.iva FROM datos_generales z WHERE z.estatus = 0) WHEN 2 THEN 0 WHEN 3 THEN (SELECT t.tasa FROM alta_productos t WHERE t.id=a.idparte) END AS ivax,

                        a.descuento, a.cantidad_oc

                        FROM partes_asignar_oc a, alta_productos b, alta_proveedores c

                        WHERE a.idparte=b.id

                        AND a.idproveedor=c.id

                        AND a.estatus = 0

                        AND a.idoc = 0

                        AND a.idproveedor = ".$data_get['idpro']." )temp"; 

  

            // Primary key of table

            $primaryKey = 'id';

            

            $columns = array(



                /*<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    Default <span class="caret"></span>

                                  </button>*/



                array( 'db' => 'asignar',     'dt' => 0,



                        'formatter' => function( $d, $row ) {



                            $separar = explode("/", $d);



                            if ( $separar[1] > 0 ) {

                                

                                return '<input type="checkbox" name="menux" value="'.$separar[0].'" style="border-color:#FF338A; border-style:solid;" tabindex="-1">';



                            }else{



                                return '<input type="checkbox" name="menux" value="'.$separar[0].'" style="border-color:#FF338A; border-style:solid;" tabindex="-1">';



                            }





                        }  

                ),



                array( 'db' => 'idcot',     'dt' => 1,



                        'formatter' => function( $d, $row ) {



                                /*$separar = explode(" ", $d);



                                if ( $separar[0] == "REM" ) {

                                    

                                    return '<a href="'.base_url().'tw/php/remisiones/rem'.$separar[1].'.pdf" target="_blank" style="color:#F7694C;"  tabindex="-1">'.$d.'</a>';



                                }else{



                                    return '<a href="'.base_url().'tw/php/facturaciones/fact'.$separar[1].'.pdf" target="_blank" style="color:darkgreen;"  tabindex="-1">'.$d.'</a>';



                                }*/



                                return '<a href="'.base_url().'tw/php/cotizaciones/cot'.$d.'.pdf" target="_blank" style="color:darkblue;"  tabindex="-1">Cot#'.$d.'</a>';



                        }  

                ),



                //array( 'db' => 'proveedor',     'dt' => 2 ),



                array( 'db' => 'nparte',     'dt' => 2),



                array( 'db' => 'descrip',     'dt' => 3,



                        'formatter' => function( $d, $row ) {



                                $separar = explode("/", $d);



                                return '<p title="'.utf8_encode($separar[1]).'">'.utf8_encode($separar[0]).'&nbsp;&nbsp;'.utf8_encode( substr($separar[1],0,30) ).'</p>';



                        }  

                ),



                

                array( 'db' => 'cantidad',     'dt' => 4 ),

                array( 'db' => 'almacen',     'dt' => 5 ),



                //array( 'db' => 'cantidad_oc', 'dt' => 6 ),

               

                array( 'db' => 'costo',        

                        'dt' => 8,

                        'formatter' => function( $d, $row ) {



                            return "<p>".wims_currency($d)."</p>";



                        }

                ), 

                array( 'db' => 'descuento',     'dt' => 9 ),

                array( 'db' => 'ivax',     'dt' => 10 ),



                array( 'db' => 'id',     'dt' => 12 ),

                array( 'db' => 'idoc',     'dt' => 13 ),

                array('db' => 'cantidad_oc', 'dt' =>14 )

            

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

