<?php

defined('BASEPATH')or exit('No direct script access allowed');

include APPPATH.'third_party/ssp.php';



class Rcotizacion extends CI_Controller

{



    public function __construct()

    {



        parent::__construct();



        function changeString($string)

        {

         

            $string = trim($string);

         

            $string = str_replace(

                array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),

                array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),

                $string

            );

         

            $string = str_replace(

                array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),

                array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),

                $string

            );

         

            $string = str_replace(

                array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),

                array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),

                $string

            );

         

            $string = str_replace(

                array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),

                array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),

                $string

            );

         

            $string = str_replace(

                array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),

                array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),

                $string

            );

         

            $string = str_replace(

                array('ñ', 'Ñ', 'ç', 'Ç'),

                array('n', 'N', 'c', 'C',),

                $string

            );

         

            //Esta parte se encarga de eliminar cualquier caracter extraño

            $string = str_replace(

                array('º', '~','!','&','´',';','"','°'),

                array('','','','&amp;','','','&quot;',' grados'),

                $string

            );

         

         

            return $string;

        }



        function obtenerFechaEnLetra($fecha){

            $num = date("j", strtotime($fecha));

            $anno = date("Y", strtotime($fecha));

            $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

            $mes = $mes[(date('m', strtotime($fecha))*1)-1];

            return $num.'-'.strtoupper($mes).'-'.$anno;

        }



        function wims_currency($number) { 

           if ($number < 0) { 

            $print_number = "-$ " . str_replace('-', '', number_format ($number, 2, ".", ",")) . ""; 

            } else { 

             $print_number = "$ " .  number_format ($number, 2, ".", ",") ; 

           } 

           return $print_number; 

        }



        $this->load->model('General_Model');

      

    }



    public function index()

    {



        $iduser=$this->session->userdata(IDUSERCOM);



        $numero_menu = 11;/// se coloca el mismo identificador que el alta de cotizacion;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



          if($iduser > 0){



              $data["idusuario"]= $iduser;

              //$mensaje['verificacion'] = "Ingreso correctamente por cookie";

              $nom_menu["nommenu"] = "rcotizacion";



              $this->load->view('general/header');

              $this->load->view('general/menuv2');

              $this->load->view('general/css_select2');

              $this->load->view('general/css_upload');

              $this->load->view('general/css_datatable');

              $this->load->view('general/menu_header',$nom_menu);

              $this->load->view('cotizaciones/reporte_cotizacion');

              $this->load->view('general/footer');

              $this->load->view('cotizaciones/accciones_reporte_cotizacion');



          }else{

         

              redirect(base_url("Login/index"));

              

          }



        }else{



          redirect('AccesoDenegado');



        }

       

    }



    public function masivoCorreo(){



          ///////#####################



          $arrayName = array('thinkweb.mx@gmail.com','administracion@thinkweb.com.mx','ventas@thinkweb.com.mx' );

                

          $this->load->library('email');



          for ($i=0; $i < count( $arrayName ); $i++) { 





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

                    $this->email->from(CORREOVENTAS, 'Cotización #'.$i.' - Comanorsa | prueba masivo');

                    $this->email->to($arrayName[$i]);

                    $this->email->subject(  'prueba masivo' );

                    ////ADJUNTAR ARCHIVOS

                    //$adjunto= base_url()."admin/files/admin/js/upload/files/".$this->input->post('nombre'); 

                    //$this->email->attach($adjunto);

                    //$this->email->attach('tw/php/cotizaciones/cot'.$i.'.pdf');

                    $this->email->message($mensaje);



                if($this->email->send()){    



                    //echo json_encode($nuevo_cliente);

                      echo json_encode(true);



                }else{



                    echo json_encode(false); //echo json_encode(0);



                }



          }



        echo "Correos enviados";



    }



    /*public function enviarCorreo(){



        $data_post = $this->input->post();



        $idclix = $data_post["idcli"];

        $idcotx = $data_post["idcot"];

        $destinatariox = $data_post["destinatario"];

        $copiax = $data_post["copia"];

        $otro_correox = $data_post["otro_correo"];



        $contacto3x=$data_post["cont3"];



                    ///////#####################

                

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

                    $this->email->from(CORREOVENTAS, 'Cotización #'.$idcotx.' - Comanorsa | Comercializadora angel de oriente S.A. DE C.V.');

                    //$this->email->to("thinkweb.mx@gmail.com");

                    $this->email->to($destinatariox);



                    if ( $copiax == 1 ) {

                        

                      if ($contacto3x != "") {

                        

                        $this->email->cc(COPIAVENTAS.','.$contacto3x);



                      }else{



                        $this->email->cc(COPIAVENTAS);



                      }  



                    }else{



                      if ($contacto3x != "") {



                        $this->email->cc(COPIAVENTAS.','.$otro_correox.','.$contacto3x);



                      }else{



                        $this->email->cc(COPIAVENTAS.','.$otro_correox);



                      }



                    }



                    $this->email->subject(  'Enviamos la cotización solicitada quedando al pendiente cualquier duda o aclaración' );

                    ////ADJUNTAR ARCHIVOS

                    //$adjunto= base_url()."admin/files/admin/js/upload/files/".$this->input->post('nombre'); 

                    //$this->email->attach($adjunto);

                    $this->email->attach('tw/php/cotizaciones/cot'.$idcotx.'.pdf');

                    $this->email->message($mensaje);



                if($this->email->send()){    



                    //echo json_encode($nuevo_cliente);

                      echo json_encode(true);



                }else{



                    echo json_encode(false); //echo json_encode(0);



                }



      



    }*/



    public function enviarCorreo(){



        $data_post = $this->input->post();



        $idclix = $data_post["idcli"];

        $idcotx = $data_post["idcot"];

        $destinatariox = $data_post["destinatario"];

        $copiax = $data_post["copia"];

        $otro_correox = $data_post["otro_correo"];



        $contacto3x=$data_post["cont3"];



        //////////***** DATOS DEL CLIENTE 



        $cdata="nombre";

        $ctabla="alta_clientes";

        $ccondicion=array('id' => $idclix );



        $datos_cliente=$this->General_Model->SelectUnafila($cdata,$ctabla,$ccondicion);





                ///////#####################

                

                $this->load->library('email');



                $mensaje = '';

                

                    /////////*********enviado email

                    $configuraciones['mailtype'] = 'html';

                    $this->email->initialize($configuraciones);

                    $this->email->from(CORREOVENTAS, 'Comanorsa cotización #'.$idcotx.' - '.$datos_cliente->nombre);

                    //$this->email->to("thinkweb.mx@gmail.com");

                    $this->email->to($destinatariox);



                    if ( $copiax == 1 ) {

                        

                      if ($contacto3x != "") {

                        

                        $this->email->cc(COPIAVENTAS.','.$contacto3x);



                      }else{



                        $this->email->cc(COPIAVENTAS);



                      }  



                    }else{



                      if ($contacto3x != "") {



                        $this->email->cc(COPIAVENTAS.','.$otro_correox.','.$contacto3x);



                      }else{



                        $this->email->cc(COPIAVENTAS.','.$otro_correox);



                      }



                    }



                    $this->email->subject(  'Comanorsa cotización #'.$idcotx.' - '.$datos_cliente->nombre );

                    ////ADJUNTAR ARCHIVOS

                    //$adjunto= base_url()."admin/files/admin/js/upload/files/".$this->input->post('nombre'); 

                    //$this->email->attach($adjunto);

                    $this->email->attach('tw/php/cotizaciones/cot'.$idcotx.'.pdf');

                    $this->email->message($mensaje);



                if($this->email->send()){    



                    //echo json_encode($nuevo_cliente);

                      echo json_encode(true);



                }else{



                    echo json_encode(false); //echo json_encode(0);



                }



      



    }



    public function showContacto(){



        $data_post = $this->input->post();



        $query="SELECT id, nombre, puesto, correo FROM `contactos_erp` WHERE iddepartamento = 2 AND iduser = ".$data_post['idcli']." AND estatus = 0 ORDER BY nombre ASC";



            echo json_encode( $this->General_Model->infoxQuery($query) );



    }



    public function showClientes(){



        $query="SELECT id, nombre, comercial FROM `alta_clientes` WHERE estatus = 0 ORDER BY nombre ASC";

        echo json_encode( $this->General_Model->infoxQuery($query) );



    }



    public function showVendedor(){



        $query="SELECT id, nombre FROM `alta_usuarios` WHERE iddepartamento IN(2,1) AND estatus = 0 ORDER BY nombre ASC";

        echo json_encode( $this->General_Model->infoxQuery($query) );



    }



    public function habilitarOdc(){



      $data_post = $this->input->post();



      $sqlx = "SELECT idparte,cantidad,id,iva,costo_proveedor,costo,descuento,descripcion,orden 
      FROM `partes_cotizacion` WHERE idcotizacion = ".$data_post["idcot"]." AND estatus = 0";

      $partes = $this->General_Model->infoxQuery($sqlx);



            $npartes = 0;


            foreach ($partes as $row) {



                $data3 = array( 'iduser'=>$data_post["iduser"], 'idparte' => $row->idparte, 'idcot'=> $data_post["idcot"], 
                  'idpartecot'=> $row->id, 'cantidad' => $row->cantidad, 'cantidad_rq' => $row->cantidad, 'costo' => $row->costo_proveedor,
                  'precio' => $row->costo_proveedor, 'descuento' => $row->descuento, 'iva' => $row->iva  );

                $table3 = "partes_solicitar_rq";

                $last_idoc = $this->General_Model->altaERP($data3,$table3);


                $npartes = $npartes+1;



            }  



            if ( $npartes > 0 ) {

              

              $uptdata = array('odc' => 1,'estatus' => 4 );

              $upttable = "alta_cotizacion";

              $uptcondicion = array('id' => $data_post["idcot"]);

              $this->General_Model->updateERP($uptdata,$upttable,$uptcondicion);



            }



            echo json_encode( $npartes );



    }



    public function subirEvidencia(){



      $data_post = $this->input->post();



        $uptdata = array('evidencia' => $data_post["evidencia"], 'estatus' => 4);

        $upttable = 'alta_cotizacion';

        $uptcondicion = array('id' => $data_post["idcotizacion"] );



      echo json_encode( $this->General_Model->updateERP($uptdata,$upttable,$uptcondicion) );



    }



    public function cancelarCotizacion(){



      $data_post = $this->input->post();



        $uptdata = array('estatus' => 6);

        $upttable = 'alta_cotizacion';

        $uptcondicion = array('id' => $data_post["idcotizacion"]);



      echo json_encode( $this->General_Model->updateERP($uptdata,$upttable,$uptcondicion) );



    }



    public function cancelarPedido(){



      $data_post = $this->input->post();

      $validar=0;

      ///// verificar si ya existe una orden de compra activa



      $tabla="partes_asignar_oc";

      $condicion = array('idcot'=>$data_post["idcotizacion"], 'estatus'=>0, 'idproveedor>'=>1 );



      $verificar=$this->General_Model->verificarRepeat($tabla,$condicion);



      if ( $verificar>0) {

        

        ///// tiene orden de compra activa



        $validar=0;

        

      }elseif ( $verificar == 0 ) {

      

        ////// no tiene ordenes de compra activas habra que eliminar todo lo ya creado para esta cotizacion



        $tabla2="partes_asignar_oc";

        $condicion2 = array('idcot' =>$data_post["idcotizacion"]);

        $this->General_Model->deleteERP($tabla2,$condicion2);



        $tabla3="partes_entrega";

        $condicion3 = array('idfolio' =>$data_post["idcotizacion"]);

        $this->General_Model->deleteERP($tabla3,$condicion3);



        $uptdata = array('estatus' => 0);

        $upttable = 'alta_cotizacion';

        $uptcondicion = array('id' => $data_post["idcotizacion"]);

        $this->General_Model->updateERP($uptdata,$upttable,$uptcondicion);



        $validar=1;





      }



        



        echo json_encode($validar);



    }





    ///////////****************TABLA PARTIDAS BITACORA



        public function loadPartidas()

        {



            $iduser=$this->session->userdata(IDUSERCOM);

            $departamento=$this->session->userdata(PUESTOCOM);



            if ($departamento==1) {

              

              $table = "(SELECT a.id,

              CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus,

              CONCAT_WS('/',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) END) AS info_estatus,

              CONCAT_WS('/',a.fecha,a.hora) AS dia, 

              b.nombre AS vendedor,

              c.nombre AS cliente,

              (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,

              (SELECT SUM(y.costo*y.cantidad) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id) AS tsubtotal,

              (SELECT SUM( (y.costo*y.cantidad)*(y.descuento/100) ) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id) AS tdescuento,

              (SELECT SUM( ( (y.costo*y.cantidad)-((y.costo*y.cantidad)*(y.descuento/100)) )*(y.iva/100) ) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id ) AS tiva,

              c.id AS idclientex



              FROM

              alta_cotizacion a, alta_usuarios b, alta_clientes c

              WHERE

              a.idusuario=b.id

              AND a.idcliente=c.id ORDER BY a.id DESC LIMIT 0,100)temp"; 



            }else{



              $table = "(SELECT a.id,

              CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus,

              CONCAT_WS('/',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) END) AS info_estatus,

              CONCAT_WS('/',a.fecha,a.hora) AS dia, 

              b.nombre AS vendedor,

              c.nombre AS cliente,

              (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,

              (SELECT SUM(y.costo*y.cantidad) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id) AS tsubtotal,

              (SELECT SUM( (y.costo*y.cantidad)*(y.descuento/100) ) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id) AS tdescuento,

              (SELECT SUM( ( (y.costo*y.cantidad)-((y.costo*y.cantidad)*(y.descuento/100)) )*(y.iva/100) ) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id ) AS tiva,

              c.id AS idclientex



              FROM

              alta_cotizacion a, alta_usuarios b, alta_clientes c

              WHERE

              a.idusuario=b.id

              AND a.idcliente=c.id ORDER BY a.id DESC LIMIT 0,100)temp"; 



              /*$table = "(SELECT a.id,

              CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus,

              CONCAT_WS('/',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) END) AS info_estatus,

              CONCAT_WS('/',a.fecha,a.hora) AS dia, 

              b.nombre AS vendedor,

              c.nombre AS cliente,

              (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,

              (SELECT SUM(y.costo*y.cantidad) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id) AS tsubtotal,

              (SELECT SUM( (y.costo*y.cantidad)*(y.descuento/100) ) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id) AS tdescuento,

              (SELECT SUM( ( (y.costo*y.cantidad)-((y.costo*y.cantidad)*(y.descuento/100)) )*(y.iva/100) ) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id ) AS tiva,

              c.id AS idclientex



              FROM

              alta_cotizacion a, alta_usuarios b, alta_clientes c

              WHERE

              a.idusuario=b.id

              AND a.idcliente=c.id

              AND a.idusuario = ".$iduser.")temp"; */



            }





            

  

            // Primary key of table

            $primaryKey = 'id';

            

            $columns = array(







                array( 'db' => 'acciones',     'dt' => 0,



                        'formatter' => function( $d, $row ) {



                            $separar = explode("/", $d);



                            /*



                                0:darkblue;

                                1:#FFC300;

                                2:darkgreen



                            */



                            switch ($separar[1]) {



                                case 0:

                                

                                    /*$boton = '<a class="btn btn-success" href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';*/



                                    $accion = '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'"  style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Acciones</a></li>



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>';



                                    if ( $separar[2] == 0 ) {

                                      

                                      $accion.= '<li><a href="javascript:habilitarOdc('.$separar[0].')" style="color:#8D27B0; font-weight:bold;"><i class="fa fa-file-o" style="color:#8D27B0; font-weight:bold;"></i> Habilitar ODC</a></li>';



                                    }



                                    $accion.='<li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                      </ul>

                                    </div>';



                                    /*return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'"target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Acciones</a></li>



                                        <li><a href="javascript:habilitarOdc('.$separar[0].')" style="color:#8D27B0; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:#8D27B0; font-weight:bold;"></i> Habilitar ODC</a></li>



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                      </ul>

                                    </div>';*/



                                    return $accion;



                                break;



                                case 1:

                                

                                    /*$boton = '<a class="btn btn-success" href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" style="color:blue; font-weight:bold;"><i class="fa fa-star" style="color:blue; font-weight:bold;"></i> Nuevo</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                      </ul>

                                    </div>';



                                break;



                                case 2:



                                    /*$boton = '<a class="btn btn-warning" href="'.base_url().'Vseguimiento/infoVenta/1-'.$separar[0].'" role="button" target="_blank"><i class="fa fa-eye" title="Ver seguimiento" style="color:black;"></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" style="color:blue; font-weight:bold;"><i class="fa fa-star" style="color:blue; font-weight:bold;"></i> Nuevo</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                      </ul>

                                    </div>';



                                break;



                                case 3:



                                    /*$boton = '<a class="btn btn-warning" href="'.base_url().'Vseguimiento/infoVenta/1-'.$separar[0].'" role="button" target="_blank"><i class="fa fa-eye" title="Ver seguimiento" style="color:black;"></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" style="color:blue; font-weight:bold;"><i class="fa fa-star" style="color:blue; font-weight:bold;"></i> Nuevo</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                      </ul>

                                    </div>';



                                break;



                            }



                        }  

                ),



                array( 'db' => 'info_estatus',     'dt' => 1,



                        'formatter' => function( $d, $row ) {



                            $separar = explode("/", $d);



                            /*



                                0:darkblue;cotizacion

                                1:#F7694C;remision

                                2:darkgreen:facturacion



                            */



                            switch ($separar[0]) {



                                case 0:

                                

                                    $boton = '<a href="'.base_url().'tw/php/cotizaciones/cot'.$separar[1].'.pdf" target="_blank" style="color:darkblue;"><i class="fa fa-file-text" title="ver cotizacion"  style="color:darkblue;"></i> Cotización</a>';



                                break;



                                case 1:

                                

                                    $boton = '<a href="'.base_url().'tw/php/remisiones/rem'.$separar[1].'.pdf" target="_blank" style="color:#F7694C;"><i class="fa fa-file-text" title="ver remision"  style="color:#F7694C;"></i> Remisión</a>';



                                break;



                                case 2:

                                

                                    $boton = '<p style="color:orange">Factura sin timbrar <i class="fa fa-bell" title="ver factura"  style="color:orange;"></i> </p>';



                                break;



                                case 3:

                                

                                    $boton = '<a href="'.base_url().'tw/php/facturas/fact'.$separar[1].'.pdf" target="_blank" style="color:darkgreen;"><i class="fa fa-file-text" title="ver cotizacion"  style="color:darkgreen;"></i> Factura</a>';



                                break;



                            }





                            return $boton;



                        }  

                ),



                array( 'db' => 'dia',     'dt' => 2,



                        'formatter' => function( $d, $row ) {



                            $separar = explode("/", $d);



                            return obtenerFechaEnLetra($separar[0])." ".$separar[1]." hrs";

                        }  

                ),

                //array( 'db' => 'vendedor',     'dt' => 3 ),



                array( 'db' => 'vendedor',     'dt' => 3,



                        'formatter' => function( $d, $row ) {



                            return utf8_encode($d);



                        }  



                ),



                array( 'db' => 'id',     'dt' => 4,



                        'formatter' => function( $d, $row ) {



                          //////////************** CREAR FOLIO ODV0010000

                              $idcot = $d;

                              $folio = 0;

                              $inicio = 10000;

                              $nuevo = $inicio+$idcot;



                              switch ( strlen($nuevo) ) {



                                  case 5:

                                      

                                      $folio = "ODV00".$nuevo;



                                  break;



                                  case 6:

                                      

                                      $folio = "ODV0".$nuevo;



                                  break;



                                  case 7:

                                      

                                      $folio = "ODV".$nuevo;



                                  break;



                                  default:



                                      $folio = "s/asignar";



                                  break;



                              }





                            return '<a href="'.base_url().'tw/php/cotizaciones/cot'.$d.'.pdf" target="_blank">'.$folio.'</a>';

                           

                        }  

                ),



                //array( 'db' => 'cliente',     'dt' => 5 ),



                array( 'db' => 'cliente',     'dt' => 5,



                        'formatter' => function( $d, $row ) {



                            return utf8_encode($d);



                        }  



                ),



                array( 'db' => 'contacto',     'dt' => 6,



                        'formatter' => function( $d, $row ) {



                            if ( $d == null) {

                                

                                return 'S/Contactos';



                            }else{



                                $separar = explode("/", $d);

                                return '<p><a href="mailto:'.$separar[0].'"><i class="fa fa-envelope"></i> '.utf8_encode($separar[0]).'</a></p><p><a href="tel:'.$separar[1].'"><i class="fa fa-phone"></i> '.$separar[1].'</a></p>';

                            }



                        }  

                ),



                array( 'db' => 'tsubtotal',     'dt' => 7,



                        'formatter' => function( $d, $row ) {



                            return wims_currency($d);



                        }  



                ),



                array( 'db' => 'tdescuento',     'dt' => 8,



                        'formatter' => function( $d, $row ) {



                            return wims_currency($d);



                        }  



                ),



                array( 'db' => 'tiva',     'dt' => 9,



                        'formatter' => function( $d, $row ) {



                            return wims_currency($d);



                        }  



                ),

                

                array( 'db' => 'id',     'dt' => 11 ),



                array( 'db' => 'idclientex',     'dt' => 12 ),

           

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

                SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns)

            );





        }





        public function loadPartidasFiltro()

        {



            $iduser=$this->session->userdata(IDUSERCOM);

            $departamento=$this->session->userdata(PUESTOCOM);



            $data_post = $this->input->get();



            /*if ($departamento==1) {





              if ( $data_post["cliente"] == 0 AND $data_post["vendedor"] > 0 ) {

                

                $filtrar=" AND a.idusuario=".$data_post["vendedor"];



              }else if ( $data_post["vendedor"] == 0 AND $data_post["cliente"] > 0 ) {

                

                $filtrar=" AND a.idcliente=".$data_post["cliente"];



              }else if ( $data_post["vendedor"] > 0 AND $data_post["cliente"] > 0 ) {

                

                $filtrar=" AND a.idcliente=".$data_post["cliente"]." AND a.idusuario=".$data_post["vendedor"] ;



              }else{



                //// todos

                $filtrar=" ORDER BY a.id DESC LIMIT 0,20";



              }

              



            }else{



              if ( $data_post["cliente"] == 0 AND $data_post["vendedor"] > 0 ) {

                

                $filtrar=" AND a.idusuario=".$data_post["vendedor"];



              }else if ( $data_post["vendedor"] == 0 AND $data_post["cliente"] > 0 ) {

                

                $filtrar=" AND a.idcliente=".$data_post["cliente"];



              }else if ( $data_post["vendedor"] > 0 AND $data_post["cliente"] > 0 ) {

                

                $filtrar=" AND a.idcliente=".$data_post["cliente"]." AND a.idusuario=".$data_post["vendedor"] ;



              }else{



                //// todos

                $filtrar=" ORDER BY a.id DESC LIMIT 0,20";



              }



            }





            

            $table = "(SELECT a.id,

              CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus,

              CONCAT_WS('$',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) WHEN '4' THEN a.evidencia WHEN '5' THEN '#' END) AS info_estatus,

              CONCAT_WS('/',a.fecha,a.hora) AS dia, 

              b.nombre AS vendedor,

              c.nombre AS cliente,

              (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,

              (SELECT SUM(y.costo*y.cantidad) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id) AS tsubtotal,

              (SELECT SUM( (y.costo*y.cantidad)*(y.descuento/100) ) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id) AS tdescuento,

              (SELECT SUM( ( (y.costo*y.cantidad)-((y.costo*y.cantidad)*(y.descuento/100)) )*(y.iva/100) ) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id ) AS tiva,

              c.id AS idclientex



              FROM

              alta_cotizacion a, alta_usuarios b, alta_clientes c

              WHERE

              a.idusuario=b.id

              AND a.idcliente=c.id ".$filtrar.")temp";*/



              if ( $data_post["buscador"] == "" OR $data_post["buscador"] == null ) {

                

                /*$table = "(SELECT a.id,

                          CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus,

                          CONCAT_WS('$',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) WHEN '4' THEN a.evidencia WHEN '5' THEN '#' END) AS info_estatus,

                          CONCAT_WS('/',a.fecha,a.hora) AS dia, 

                          b.nombre AS vendedor,

                          c.nombre AS cliente,

                          (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,

                          (SELECT SUM(y.costo*y.cantidad) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id) AS tsubtotal,

                          (SELECT SUM( (y.costo*y.cantidad)*(y.descuento/100) ) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id) AS tdescuento,

                          (SELECT SUM( ( (y.costo*y.cantidad)-((y.costo*y.cantidad)*(y.descuento/100)) )*(y.iva/100) ) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id ) AS tiva,

                          c.id AS idclientex



                          FROM

                          alta_cotizacion a, alta_usuarios b, alta_clientes c

                          WHERE

                          a.idusuario=b.id

                          AND a.idcliente=c.id ORDER BY a.id DESC LIMIT 0,20)temp";



                  $table = "(SELECT a.id,

                          CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus,

                          CONCAT_WS('$',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) WHEN '4' THEN a.evidencia WHEN '5' THEN '#' END) AS info_estatus,

                          CONCAT_WS('/',a.fecha,a.hora) AS dia, 

                          b.nombre AS vendedor,

                          c.nombre AS cliente,

                          (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,a.subtotal AS tsubtotal,a.descuento AS tdescuento,a.iva AS tiva,

                          c.id AS idclientex



                          FROM

                          alta_cotizacion a, alta_usuarios b, alta_clientes c

                          WHERE

                          a.idusuario=b.id

                          AND a.idcliente=c.id ORDER BY a.id DESC LIMIT 0,50)temp";*/




                          if ( $data_post['estatus'] == 6  ) {

                

                            $table = "(SELECT a.id,

                                      CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus,

                                      CONCAT_WS('$',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) WHEN '4' THEN a.evidencia WHEN '5' THEN '#' END) AS info_estatus,

                                      CONCAT_WS('/',a.fecha,a.hora) AS dia, 

                                      b.nombre AS vendedor,

                                      c.nombre AS cliente,

                                      (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,a.subtotal AS tsubtotal,a.descuento AS tdescuento,a.iva AS tiva,

                                      c.id AS idclientex



                                      FROM

                                      alta_cotizacion a, alta_usuarios b, alta_clientes c

                                      WHERE

                                      a.idusuario=b.id

                                      AND a.idcliente=c.id ORDER BY a.id DESC LIMIT 0,300)temp";



                          }else{



                            $table = "(SELECT a.id,

                                      CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus,

                                      CONCAT_WS('$',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) WHEN '4' THEN a.evidencia WHEN '5' THEN '#' END) AS info_estatus,

                                      CONCAT_WS('/',a.fecha,a.hora) AS dia, 

                                      b.nombre AS vendedor,

                                      c.nombre AS cliente,

                                      (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,a.subtotal AS tsubtotal,a.descuento AS tdescuento,a.iva AS tiva,

                                      c.id AS idclientex



                                      FROM

                                      alta_cotizacion a, alta_usuarios b, alta_clientes c

                                      WHERE

                                      a.idusuario=b.id

                                      AND a.idcliente=c.id 

                                      AND a.estatus =".$data_post['estatus'].")temp";



                          }




              }else{


                if ( $data_post['estatus'] == 6  ) {


                      $table = "(SELECT a.id,

                          CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus,

                          CONCAT_WS('$',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) WHEN '4' THEN a.evidencia WHEN '5' THEN '#' END) AS info_estatus,

                          CONCAT_WS('/',a.fecha,a.hora) AS dia, 

                          b.nombre AS vendedor,

                          c.nombre AS cliente,

                          (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,a.subtotal AS tsubtotal,a.descuento AS tdescuento,a.iva AS tiva,

                          c.id AS idclientex



                          FROM

                          alta_cotizacion a, alta_usuarios b, alta_clientes c

                          WHERE

                          a.idusuario=b.id

                          AND a.idcliente=c.id 

                          AND CONCAT_WS(c.nombre,c.comercial,a.total,a.id,CONCAT_WS('','ODV001',a.id),CONCAT_WS('','ODV00',a.id),b.nombre ) LIKE '%".$data_post['buscador']."%')temp";


                }else{

                      $table = "(SELECT a.id,

                          CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus,

                          CONCAT_WS('$',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) WHEN '4' THEN a.evidencia WHEN '5' THEN '#' END) AS info_estatus,

                          CONCAT_WS('/',a.fecha,a.hora) AS dia, 

                          b.nombre AS vendedor,

                          c.nombre AS cliente,

                          (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,a.subtotal AS tsubtotal,a.descuento AS tdescuento,a.iva AS tiva,

                          c.id AS idclientex



                          FROM

                          alta_cotizacion a, alta_usuarios b, alta_clientes c

                          WHERE

                          a.idusuario=b.id

                          AND a.idcliente=c.id 

                            AND CONCAT_WS(c.nombre,c.comercial,a.total,a.id,CONCAT_WS('','ODV001',a.id),CONCAT_WS('','ODV00',a.id),b.nombre ) LIKE '%".$data_post['buscador']."%' 

                            AND a.estatus =".$data_post['estatus']." )temp";


                }



              }



  

            // Primary key of table

            $primaryKey = 'id';

            

            $columns = array(







                array( 'db' => 'acciones',     'dt' => 0,



                        'formatter' => function( $d, $row ) {



                            $separar = explode("/", $d);



                            /*



                                0:darkblue;

                                1:#FFC300;

                                2:darkgreen



                            */



                            switch ($separar[1]) {



                                case 0:

                                

                                    /*$boton = '<a class="btn btn-success" href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';*/



                                    $accion = '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="#" data-toggle="modal" data-target="#modal_pedido"  style="color:blue; font-weight:bold;"><i class="fa fa-check-circle-o" style="color:blue; font-weight:bold;"></i> Crear pedido</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'"  style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Acciones</a></li>



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>';



                                    



                                    $accion.='<li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                        <li><a href="javascript:cancelarCotizacion('.$separar[0].')" style="color:red; font-weight:bold;" <i class="fa fa-close" style="color:red; font-weight:bold;"></i> Cancelar</a></li>



                                      </ul>

                                    </div>';



                                    /*return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'"target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Acciones</a></li>



                                        <li><a href="javascript:habilitarOdc('.$separar[0].')" style="color:#8D27B0; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:#8D27B0; font-weight:bold;"></i> Habilitar ODC</a></li>



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                      </ul>

                                    </div>';*/



                                    return $accion;



                                break;



                                case 1:

                                

                                    /*$boton = '<a class="btn btn-success" href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" style="color:blue; font-weight:bold;"><i class="fa fa-star" style="color:blue; font-weight:bold;"></i> Nuevo</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'"  style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Acciones</a></li>



                                      </ul>

                                    </div>';



                                break;



                                case 2:



                                    /*$boton = '<a class="btn btn-warning" href="'.base_url().'Vseguimiento/infoVenta/1-'.$separar[0].'" role="button" target="_blank"><i class="fa fa-eye" title="Ver seguimiento" style="color:black;"></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        

                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" style="color:blue; font-weight:bold;"><i class="fa fa-star" style="color:blue; font-weight:bold;"></i> Nuevo</a></li>



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'"  style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Acciones</a></li>



                                      </ul>

                                    </div>';



                                break;



                                case 3:



                                    /*$boton = '<a class="btn btn-warning" href="'.base_url().'Vseguimiento/infoVenta/1-'.$separar[0].'" role="button" target="_blank"><i class="fa fa-eye" title="Ver seguimiento" style="color:black;"></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" style="color:blue; font-weight:bold;"><i class="fa fa-star" style="color:blue; font-weight:bold;"></i> Nuevo</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'"  style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Acciones</a></li>



                                      </ul>

                                    </div>';



                                break;



                                case 4:



                                    /*$boton = '<a class="btn btn-warning" href="'.base_url().'Vseguimiento/infoVenta/1-'.$separar[0].'" role="button" target="_blank"><i class="fa fa-eye" title="Ver seguimiento" style="color:black;"></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="'.base_url().'Factpedido/Facturar/'.$separar[0].'"  style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Facturar</a></li>  



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'"  style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Acciones</a></li>



                                        <li><a href="javascript:cancelarPedido('.$separar[0].')" style="color:red; font-weight:bold;" <i class="fa fa-mail-reply" style="color:red; font-weight:bold;"></i> Revertir pedido</a></li>



                                      </ul>

                                    </div>';



                                break;



                                case 5:



                                    /*$boton = '<a class="btn btn-warning" href="'.base_url().'Vseguimiento/infoVenta/1-'.$separar[0].'" role="button" target="_blank"><i class="fa fa-eye" title="Ver seguimiento" style="color:black;"></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="'.base_url().'Factpedido/Facturar/'.$separar[0].'"  style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Facturar</a></li>  



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'"  style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Acciones</a></li>



                                      </ul>

                                    </div>';



                                break;



                            }



                        }  

                ),



                array( 'db' => 'info_estatus',     'dt' => 1,



                        'formatter' => function( $d, $row ) {



                            $separar = explode("$", $d);



                            /*



                                0:darkblue;cotizacion

                                1:#F7694C;remision

                                2:darkgreen:facturacion



                            */



                            switch ($separar[0]) {



                                case 0:

                                

                                    $boton = '<a href="'.base_url().'tw/php/cotizaciones/cot'.$separar[1].'.pdf" target="_blank" style="color:darkblue;"><i class="fa fa-file-text" title="ver cotizacion"  style="color:darkblue;"></i> Cotización</a>';



                                break;



                                case 1:

                                

                                    $boton = '<a href="'.base_url().'tw/php/remisiones/rem'.$separar[1].'.pdf" target="_blank" style="color:#F7694C;"><i class="fa fa-file-text" title="ver remision"  style="color:#F7694C;"></i> Remisión</a>';



                                break;



                                case 2:

                                

                                    $boton = '<p style="color:orange">Factura sin timbrar <i class="fa fa-bell" title="ver factura"  style="color:orange;"></i> </p>';



                                break;



                                case 3:

                                

                                    $boton = '<a href="#" target="_blank" style="color:darkgreen;"><i class="fa fa-file-text" title="ver cotizacion"  style="color:darkgreen;"></i> FINALIZADO</a>';



                                break;



                                case 4:

                                

                                    $boton = '<a href="'.base_url().'tw/js/upload_evidencias/files/'.$separar[1].'" target="_blank" style="color:blue;"><i class="fa fa-chain" title="ver evidencia"  style="color:blue;"></i> Pedido</a>';



                                break;



                                case 5:

                                

                                    $boton = '<a href="'.$separar[1].'" style="color:#581845;"><i class="fa fa-hourglass-half" title="ver evidencia"  style="color:#581845;"></i> Facturado parcial</a>';



                                break;



                                case 6:

                                

                                    $boton = '<p style="color:red;"><i class="fa fa-close" title="Proceso cancelado" style="color:red;"></i> Operacion cancelada</p>';



                                break;    



                            }





                            return $boton;



                        }  

                ),



                array( 'db' => 'dia',     'dt' => 2,



                        'formatter' => function( $d, $row ) {



                            $separar = explode("/", $d);



                            return obtenerFechaEnLetra($separar[0])." ".$separar[1]."hrs";

                        }  

                ),

                //array( 'db' => 'vendedor',     'dt' => 3 ),



                array( 'db' => 'vendedor',     'dt' => 3,



                        'formatter' => function( $d, $row ) {



                            return utf8_encode($d);



                        }  



                ),



                array( 'db' => 'id',     'dt' => 4,



                        'formatter' => function( $d, $row ) {



                          //////////************** CREAR FOLIO ODV0010000

                              $idcot = $d;

                              $folio = 0;

                              $inicio = 10000;

                              $nuevo = $inicio+$idcot;



                              switch ( strlen($nuevo) ) {



                                  case 5:

                                      

                                      $folio = "ODV00".$nuevo;



                                  break;



                                  case 6:

                                      

                                      $folio = "ODV0".$nuevo;



                                  break;



                                  case 7:

                                      

                                      $folio = "ODV".$nuevo;



                                  break;



                                  default:



                                      $folio = "s/asignar";



                                  break;



                              }





                            return '<a href="'.base_url().'tw/php/cotizaciones/cot'.$d.'.pdf" target="_blank">'.$folio.'</a>';

                           

                        }  

                ),



                //array( 'db' => 'cliente',     'dt' => 5 ),



                array( 'db' => 'cliente',     'dt' => 5,



                        'formatter' => function( $d, $row ) {



                            return utf8_encode($d);



                        }  



                ),



                array( 'db' => 'contacto',     'dt' => 6,



                        'formatter' => function( $d, $row ) {



                            if ( $d == null) {

                                

                                return 'S/Contactos';



                            }else{



                                $separar = explode("/", $d);

                                return '<p><a href="mailto:'.$separar[0].'"><i class="fa fa-envelope"></i> '.utf8_encode($separar[0]).'</a></p><p><a href="tel:'.utf8_encode($separar[1]).'"><i class="fa fa-phone"></i> '.utf8_encode($separar[1]).'</a></p>';

                            }



                        }  

                ),



                array( 'db' => 'tsubtotal',     'dt' => 7,



                        'formatter' => function( $d, $row ) {



                            return wims_currency($d);



                        }  



                ),



                array( 'db' => 'tdescuento',     'dt' => 8,



                        'formatter' => function( $d, $row ) {



                            return wims_currency($d);



                        }  



                ),



                array( 'db' => 'tiva',     'dt' => 9,



                        'formatter' => function( $d, $row ) {



                            return wims_currency($d);



                        }  



                ),



               



                array( 'db' => 'id',     'dt' => 11 ),



                array( 'db' => 'idclientex',     'dt' => 12 ),

           

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

                SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns)

            );





        }



        public function loadPartidasFolio()

        {



            $iduser=$this->session->userdata(IDUSERCOM);

            $departamento=$this->session->userdata(PUESTOCOM);

            $data_post = $this->input->get();



            $idx = $data_post["folio"]-10000;



            



            if ($departamento==1) {

              

              $table = "(SELECT a.id,

              CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus,

              CONCAT_WS('/',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) WHEN '4' THEN a.evidencia WHEN '5' THEN '#' END) AS info_estatus,

              CONCAT_WS('/',a.fecha,a.hora) AS dia, 

              b.nombre AS vendedor,

              c.nombre AS cliente,

              (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,

              (SELECT SUM(y.costo*y.cantidad) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id) AS tsubtotal,

              (SELECT SUM( (y.costo*y.cantidad)*(y.descuento/100) ) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id) AS tdescuento,

              (SELECT SUM( ( (y.costo*y.cantidad)-((y.costo*y.cantidad)*(y.descuento/100)) )*(y.iva/100) ) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id ) AS tiva,

              c.id AS idclientex



              FROM

              alta_cotizacion a, alta_usuarios b, alta_clientes c

              WHERE

              a.idusuario=b.id

              AND a.idcliente=c.id

              AND a.id=".$idx.")temp";



            }else{



              /*$table = "(SELECT a.id,

              CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus,

              CONCAT_WS('/',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) END) AS info_estatus,

              CONCAT_WS('/',a.fecha,a.hora) AS dia, 

              b.nombre AS vendedor,

              c.nombre AS cliente,

              (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,

              (SELECT SUM(y.costo*y.cantidad) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id) AS tsubtotal,

              (SELECT SUM( (y.costo*y.cantidad)*(y.descuento/100) ) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id) AS tdescuento,

              (SELECT SUM( ( (y.costo*y.cantidad)-((y.costo*y.cantidad)*(y.descuento/100)) )*(y.iva/100) ) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id ) AS tiva,

              c.id AS idclientex



              FROM

              alta_cotizacion a, alta_usuarios b, alta_clientes c

              WHERE

              a.idusuario=b.id

              AND a.idcliente=c.id

              AND a.id=".$idx." AND a.idusuario=".$iduser.")temp";*/



              $table = "(SELECT a.id,

              CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus,

              CONCAT_WS('/',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) WHEN '4' THEN a.evidencia WHEN '5' THEN '#' END) AS info_estatus,

              CONCAT_WS('/',a.fecha,a.hora) AS dia, 

              b.nombre AS vendedor,

              c.nombre AS cliente,

              (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,

              (SELECT SUM(y.costo*y.cantidad) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id) AS tsubtotal,

              (SELECT SUM( (y.costo*y.cantidad)*(y.descuento/100) ) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id) AS tdescuento,

              (SELECT SUM( ( (y.costo*y.cantidad)-((y.costo*y.cantidad)*(y.descuento/100)) )*(y.iva/100) ) FROM `partes_cotizacion` y WHERE y.idcotizacion = a.id ) AS tiva,

              c.id AS idclientex



              FROM

              alta_cotizacion a, alta_usuarios b, alta_clientes c

              WHERE

              a.idusuario=b.id

              AND a.idcliente=c.id

              AND a.id=".$idx.")temp";



            }



  

            // Primary key of table

            $primaryKey = 'id';

            

            $columns = array(







                array( 'db' => 'acciones',     'dt' => 0,



                        'formatter' => function( $d, $row ) {



                            $separar = explode("/", $d);



                            /*



                                0:darkblue;

                                1:#FFC300;

                                2:darkgreen



                            */



                            switch ($separar[1]) {



                                case 0:

                                

                                    /*$boton = '<a class="btn btn-success" href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';*/



                                    $accion = '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="#" data-toggle="modal" data-target="#modal_pedido"  style="color:blue; font-weight:bold;"><i class="fa fa-check-circle-o" style="color:blue; font-weight:bold;"></i> Crear pedido</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'"  style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Acciones</a></li>



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>';



                                    



                                    $accion.='<li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                        <li><a href="javascript:cancelarCotizacion('.$separar[0].')" style="color:red; font-weight:bold;" <i class="fa fa-close" style="color:red; font-weight:bold;"></i> Cancelar</a></li>



                                      </ul>

                                    </div>';



                                    /*return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'"target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Acciones</a></li>



                                        <li><a href="javascript:habilitarOdc('.$separar[0].')" style="color:#8D27B0; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:#8D27B0; font-weight:bold;"></i> Habilitar ODC</a></li>



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                      </ul>

                                    </div>';*/



                                    return $accion;



                                break;



                                case 1:

                                

                                    /*$boton = '<a class="btn btn-success" href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" style="color:blue; font-weight:bold;"><i class="fa fa-star" style="color:blue; font-weight:bold;"></i> Nuevo</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                      </ul>

                                    </div>';



                                break;



                                case 2:



                                    /*$boton = '<a class="btn btn-warning" href="'.base_url().'Vseguimiento/infoVenta/1-'.$separar[0].'" role="button" target="_blank"><i class="fa fa-eye" title="Ver seguimiento" style="color:black;"></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" style="color:blue; font-weight:bold;"><i class="fa fa-star" style="color:blue; font-weight:bold;"></i> Nuevo</a></li>



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                      </ul>

                                    </div>';



                                break;



                                case 3:



                                    /*$boton = '<a class="btn btn-warning" href="'.base_url().'Vseguimiento/infoVenta/1-'.$separar[0].'" role="button" target="_blank"><i class="fa fa-eye" title="Ver seguimiento" style="color:black;"></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" style="color:blue; font-weight:bold;"><i class="fa fa-star" style="color:blue; font-weight:bold;"></i> Nuevo</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                      </ul>

                                    </div>';



                                break;



                                case 4:



                                    /*$boton = '<a class="btn btn-warning" href="'.base_url().'Vseguimiento/infoVenta/1-'.$separar[0].'" role="button" target="_blank"><i class="fa fa-eye" title="Ver seguimiento" style="color:black;"></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="'.base_url().'Factpedido/Facturar/'.$separar[0].'"  style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Facturar</a></li>  



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                        <li><a href="javascript:cancelarPedido('.$separar[0].')" style="color:red; font-weight:bold;" <i class="fa fa-mail-reply" style="color:red; font-weight:bold;"></i> Revertir pedido</a></li>



                                      </ul>

                                    </div>';



                                break;



                                case 5:



                                    /*$boton = '<a class="btn btn-warning" href="'.base_url().'Vseguimiento/infoVenta/1-'.$separar[0].'" role="button" target="_blank"><i class="fa fa-eye" title="Ver seguimiento" style="color:black;"></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="'.base_url().'Factpedido/Facturar/'.$separar[0].'"  style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Facturar</a></li>  



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                      </ul>

                                    </div>';



                                break;



                            }



                        }  

                ),



                array( 'db' => 'info_estatus',     'dt' => 1,



                        'formatter' => function( $d, $row ) {



                            $separar = explode("/", $d);



                            /*



                                0:darkblue;cotizacion

                                1:#F7694C;remision

                                2:darkgreen:facturacion



                            */



                            switch ($separar[0]) {



                                case 0:

                                

                                    $boton = '<a href="'.base_url().'tw/php/cotizaciones/cot'.$separar[1].'.pdf" target="_blank" style="color:darkblue;"><i class="fa fa-file-text" title="ver cotizacion"  style="color:darkblue;"></i> Cotización</a>';



                                break;



                                case 1:

                                

                                    $boton = '<a href="'.base_url().'tw/php/remisiones/rem'.$separar[1].'.pdf" target="_blank" style="color:#F7694C;"><i class="fa fa-file-text" title="ver remision"  style="color:#F7694C;"></i> Remisión</a>';



                                break;



                                case 2:

                                

                                    $boton = '<p style="color:orange">Factura sin timbrar <i class="fa fa-bell" title="ver factura"  style="color:orange;"></i> </p>';



                                break;



                                case 3:

                                

                                    $boton = '<a href="#" target="_blank" style="color:darkgreen;"><i class="fa fa-file-text" title="ver cotizacion"  style="color:darkgreen;"></i> Finalizado</a>';



                                break;



                                case 4:

                                

                                    $boton = '<a href="'.$separar[1].'" target="_blank" style="color:blue;"><i class="fa fa-chain" title="ver evidencia"  style="color:blue;"></i> Pedido</a>';



                                break;



                                case 5:

                                

                                    $boton = '<a href="'.$separar[1].'" style="color:#581845;"><i class="fa fa-hourglass-half" title="ver evidencia"  style="color:#581845;"></i> Facturado parcial</a>';



                                break; 



                                case 6:

                                

                                    $boton = '<p><i class="fa fa-close" title="Proceso cancelado"  style="color:red;"></i> Operacion cancelada</p>';



                                break; 



                            }





                            return $boton;



                        }  

                ),



                array( 'db' => 'dia',     'dt' => 2,



                        'formatter' => function( $d, $row ) {



                            $separar = explode("/", $d);



                            return obtenerFechaEnLetra($separar[0])." ".$separar[1]."hrs";

                        }  

                ),

                //array( 'db' => 'vendedor',     'dt' => 3 ),



                array( 'db' => 'vendedor',     'dt' => 3,



                        'formatter' => function( $d, $row ) {



                            return utf8_encode($d);



                        }  



                ),



                array( 'db' => 'id',     'dt' => 4,



                        'formatter' => function( $d, $row ) {



                          //////////************** CREAR FOLIO ODV0010000

                              $idcot = $d;

                              $folio = 0;

                              $inicio = 10000;

                              $nuevo = $inicio+$idcot;



                              switch ( strlen($nuevo) ) {



                                  case 5:

                                      

                                      $folio = "ODV00".$nuevo;



                                  break;



                                  case 6:

                                      

                                      $folio = "ODV0".$nuevo;



                                  break;



                                  case 7:

                                      

                                      $folio = "ODV".$nuevo;



                                  break;



                                  default:



                                      $folio = "s/asignar";



                                  break;



                              }





                            return '<a href="'.base_url().'tw/php/cotizaciones/cot'.$d.'.pdf" target="_blank">'.$folio.'</a>';

                           

                        }  

                ),



                //array( 'db' => 'cliente',     'dt' => 5 ),



                array( 'db' => 'cliente',     'dt' => 5,



                        'formatter' => function( $d, $row ) {



                            return utf8_encode($d);



                        }  



                ),



                array( 'db' => 'contacto',     'dt' => 6,



                        'formatter' => function( $d, $row ) {



                            if ( $d == null) {

                                

                                return 'S/Contactos';



                            }else{



                                $separar = explode("/", $d);

                                return '<p><a href="mailto:'.$separar[0].'"><i class="fa fa-envelope"></i> '.utf8_encode($separar[0]).'</a></p><p><a href="tel:'.$separar[1].'"><i class="fa fa-phone"></i> '.$separar[1].'</a></p>';

                            }



                        }  

                ),



                array( 'db' => 'tsubtotal',     'dt' => 7,



                        'formatter' => function( $d, $row ) {



                            return wims_currency($d);



                        }  



                ),



                array( 'db' => 'tdescuento',     'dt' => 8,



                        'formatter' => function( $d, $row ) {



                            return wims_currency($d);



                        }  



                ),



                array( 'db' => 'tiva',     'dt' => 9,



                        'formatter' => function( $d, $row ) {



                            return wims_currency($d);



                        }  



                ),



               



                array( 'db' => 'id',     'dt' => 11 ),



                array( 'db' => 'idclientex',     'dt' => 12 ),

           

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

                SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns)

            );





        }





        public function loadPartidasEstatus()

        {



            $iduser=$this->session->userdata(IDUSERCOM);

            $departamento=$this->session->userdata(PUESTOCOM);



            $data_post = $this->input->get();





              if ( $data_post['estatus'] == 6  ) {

                
                if ( $data_post["buscador"] == "" OR $data_post["buscador"] == null ) {

                  $table = "(SELECT a.id,

                          CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus,

                          CONCAT_WS('$',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) WHEN '4' THEN a.evidencia WHEN '5' THEN '#' END) AS info_estatus,

                          CONCAT_WS('/',a.fecha,a.hora) AS dia, 

                          b.nombre AS vendedor,

                          c.nombre AS cliente,

                          (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,a.subtotal AS tsubtotal,a.descuento AS tdescuento,a.iva AS tiva,

                          c.id AS idclientex



                          FROM

                          alta_cotizacion a, alta_usuarios b, alta_clientes c

                          WHERE

                          a.idusuario=b.id

                          AND a.idcliente=c.id)temp";


                }else{

                    $table = "(SELECT a.id,

                          CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus,

                          CONCAT_WS('$',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) WHEN '4' THEN a.evidencia WHEN '5' THEN '#' END) AS info_estatus,

                          CONCAT_WS('/',a.fecha,a.hora) AS dia, 

                          b.nombre AS vendedor,

                          c.nombre AS cliente,

                          (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,a.subtotal AS tsubtotal,a.descuento AS tdescuento,a.iva AS tiva,

                          c.id AS idclientex



                          FROM

                          alta_cotizacion a, alta_usuarios b, alta_clientes c

                          WHERE

                          a.idusuario=b.id

                          AND a.idcliente=c.id

                          AND CONCAT_WS(c.nombre,c.comercial,a.total,a.id,CONCAT_WS('','ODV001',a.id),CONCAT_WS('','ODV00',a.id),b.nombre ) LIKE '%".$data_post['buscador']."%' )temp";

                }

              }else{


                if ( $data_post["buscador"] == "" OR $data_post["buscador"] == null ) {

                    $table = "(SELECT a.id,

                          CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus,

                          CONCAT_WS('$',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) WHEN '4' THEN a.evidencia WHEN '5' THEN '#' END) AS info_estatus,

                          CONCAT_WS('/',a.fecha,a.hora) AS dia, 

                          b.nombre AS vendedor,

                          c.nombre AS cliente,

                          (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,a.subtotal AS tsubtotal,a.descuento AS tdescuento,a.iva AS tiva,

                          c.id AS idclientex



                          FROM

                          alta_cotizacion a, alta_usuarios b, alta_clientes c

                          WHERE

                          a.idusuario=b.id

                          AND a.idcliente=c.id 

                          AND a.estatus =".$data_post['estatus'].")temp";


                }else{


                  $table = "(SELECT a.id,

                          CONCAT_WS('/',a.id,a.estatus,a.odc) AS acciones, a.estatus,

                          CONCAT_WS('$',a.estatus,CASE a.estatus WHEN '0' THEN a.id WHEN '1' THEN (SELECT x.id FROM alta_remision x WHERE x.idcotizacion=a.id LIMIT 0,1 ) WHEN '2' THEN 2 WHEN 2 THEN 0 WHEN 3 THEN (SELECT y.id FROM alta_factura y WHERE y.idcotizacion=a.id LIMIT 0,1) WHEN '4' THEN a.evidencia WHEN '5' THEN '#' END) AS info_estatus,

                          CONCAT_WS('/',a.fecha,a.hora) AS dia, 

                          b.nombre AS vendedor,

                          c.nombre AS cliente,

                          (SELECT CONCAT_WS('/',z.correo,z.telefono) FROM contactos_erp z WHERE z.iduser=c.id AND z.iddepartamento= 2 LIMIT 0,1) AS contacto,a.subtotal AS tsubtotal,a.descuento AS tdescuento,a.iva AS tiva,

                          c.id AS idclientex



                          FROM

                          alta_cotizacion a, alta_usuarios b, alta_clientes c

                          WHERE

                          a.idusuario=b.id

                          AND a.idcliente=c.id 

                          AND a.estatus =".$data_post['estatus']."
                          
                          AND CONCAT_WS(c.nombre,c.comercial,a.total,a.id,CONCAT_WS('','ODV001',a.id),CONCAT_WS('','ODV00',a.id),b.nombre ) LIKE '%".$data_post['buscador']."%'

                          )temp"; 

                }


              }



             

                

  

            // Primary key of table

            $primaryKey = 'id';

            

            $columns = array(







                array( 'db' => 'acciones',     'dt' => 0,



                        'formatter' => function( $d, $row ) {



                            $separar = explode("/", $d);



                            /*



                                0:darkblue;

                                1:#FFC300;

                                2:darkgreen



                            */



                            switch ($separar[1]) {



                                case 0:

                                

                                    /*$boton = '<a class="btn btn-success" href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';*/



                                    $accion = '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="#" data-toggle="modal" data-target="#modal_pedido"  style="color:blue; font-weight:bold;"><i class="fa fa-check-circle-o" style="color:blue; font-weight:bold;"></i> Crear pedido</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'"  style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Acciones</a></li>



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>';



                                    



                                    $accion.='<li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                        <li><a href="javascript:cancelarCotizacion('.$separar[0].')" style="color:red; font-weight:bold;" <i class="fa fa-close" style="color:red; font-weight:bold;"></i> Cancelar</a></li>



                                      </ul>

                                    </div>';



                                    /*return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'"target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Acciones</a></li>



                                        <li><a href="javascript:habilitarOdc('.$separar[0].')" style="color:#8D27B0; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:#8D27B0; font-weight:bold;"></i> Habilitar ODC</a></li>



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                      </ul>

                                    </div>';*/



                                    return $accion;



                                break;



                                case 1:

                                

                                    /*$boton = '<a class="btn btn-success" href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" style="color:blue; font-weight:bold;"><i class="fa fa-star" style="color:blue; font-weight:bold;"></i> Nuevo</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                      </ul>

                                    </div>';



                                break;



                                case 2:



                                    /*$boton = '<a class="btn btn-warning" href="'.base_url().'Vseguimiento/infoVenta/1-'.$separar[0].'" role="button" target="_blank"><i class="fa fa-eye" title="Ver seguimiento" style="color:black;"></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        

                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" style="color:blue; font-weight:bold;"><i class="fa fa-star" style="color:blue; font-weight:bold;"></i> Nuevo</a></li>



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                      </ul>

                                    </div>';



                                break;



                                case 3:



                                    /*$boton = '<a class="btn btn-warning" href="'.base_url().'Vseguimiento/infoVenta/1-'.$separar[0].'" role="button" target="_blank"><i class="fa fa-eye" title="Ver seguimiento" style="color:black;"></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="'.base_url().'TestCotizacion/EditCot/'.$separar[0].'" style="color:blue; font-weight:bold;"><i class="fa fa-star" style="color:blue; font-weight:bold;"></i> Nuevo</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                      </ul>

                                    </div>';



                                break;



                                case 4:



                                    /*$boton = '<a class="btn btn-warning" href="'.base_url().'Vseguimiento/infoVenta/1-'.$separar[0].'" role="button" target="_blank"><i class="fa fa-eye" title="Ver seguimiento" style="color:black;"></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="'.base_url().'Factpedido/Facturar/'.$separar[0].'"  style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Facturar</a></li>  



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                        <li><a href="javascript:cancelarPedido('.$separar[0].')" style="color:red; font-weight:bold;" <i class="fa fa-mail-reply" style="color:red; font-weight:bold;"></i> Revertir pedido</a></li>



                                      </ul>

                                    </div>';



                                break;



                                case 5:



                                    /*$boton = '<a class="btn btn-warning" href="'.base_url().'Vseguimiento/infoVenta/1-'.$separar[0].'" role="button" target="_blank"><i class="fa fa-eye" title="Ver seguimiento" style="color:black;"></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="'.base_url().'Factpedido/Facturar/'.$separar[0].'"  style="color:darkgreen; font-weight:bold;"><i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Facturar</a></li>  



                                        <li><a href="javascript:showexcel('.$separar[0].')"  style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold;"></i> Excel</a></li>



                                        <li><a href="'.base_url().'Vseguimiento/infoVenta/'.$separar[0].'" target="_blank" style="color:darkgreen; font-weight:bold;"><i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Seguimiento</a></li>



                                        <li><a href="#" style="color:darkblue; font-weight:bold;" data-toggle="modal" data-target="#modal_enviar"> <i class="fa fa-paper-plane" style="color:darkblue; font-weight:bold;"></i> Enviar</a></li>



                                      </ul>

                                    </div>';



                                break;



                            }



                        }  

                ),



                array( 'db' => 'info_estatus',     'dt' => 1,



                        'formatter' => function( $d, $row ) {



                            $separar = explode("$", $d);



                            /*



                                0:darkblue;cotizacion

                                1:#F7694C;remision

                                2:darkgreen:facturacion



                            */



                            switch ($separar[0]) {



                                case 0:

                                

                                    $boton = '<a href="'.base_url().'tw/php/cotizaciones/cot'.$separar[1].'.pdf" target="_blank" style="color:darkblue;"><i class="fa fa-file-text" title="ver cotizacion"  style="color:darkblue;"></i> Cotización</a>';



                                break;



                                case 1:

                                

                                    $boton = '<a href="'.base_url().'tw/php/remisiones/rem'.$separar[1].'.pdf" target="_blank" style="color:#F7694C;"><i class="fa fa-file-text" title="ver remision"  style="color:#F7694C;"></i> Remisión</a>';



                                break;



                                case 2:

                                

                                    $boton = '<p style="color:orange">Factura sin timbrar <i class="fa fa-bell" title="ver factura"  style="color:orange;"></i> </p>';



                                break;



                                case 3:

                                

                                    $boton = '<a href="#" target="_blank" style="color:darkgreen;"><i class="fa fa-file-text" title="ver cotizacion"  style="color:darkgreen;"></i> FINALIZADO</a>';



                                break;



                                case 4:

                                

                                    $boton = '<a href="'.base_url().'tw/js/upload_evidencias/files/'.$separar[1].'" target="_blank" style="color:blue;"><i class="fa fa-chain" title="ver evidencia"  style="color:blue;"></i> Pedido</a>';



                                break;



                                case 5:

                                

                                    $boton = '<a href="'.$separar[1].'" style="color:#581845;"><i class="fa fa-hourglass-half" title="ver evidencia"  style="color:#581845;"></i> Facturado parcial</a>';



                                break; 



                                case 6:

                                

                                    $boton = '<p style="color:red;"><i class="fa fa-close" title="Proceso cancelado"  style="color:red;"></i> Operacion cancelada</p>';



                                break;   



                            }





                            return $boton;



                        }  

                ),



                array( 'db' => 'dia',     'dt' => 2,



                        'formatter' => function( $d, $row ) {



                            $separar = explode("/", $d);



                            return obtenerFechaEnLetra($separar[0])." ".$separar[1]."hrs";

                        }  

                ),

                //array( 'db' => 'vendedor',     'dt' => 3 ),



                array( 'db' => 'vendedor',     'dt' => 3,



                        'formatter' => function( $d, $row ) {



                            return utf8_encode($d);



                        }  



                ),



                array( 'db' => 'id',     'dt' => 4,



                        'formatter' => function( $d, $row ) {



                          //////////************** CREAR FOLIO ODV0010000

                              $idcot = $d;

                              $folio = 0;

                              $inicio = 10000;

                              $nuevo = $inicio+$idcot;



                              switch ( strlen($nuevo) ) {



                                  case 5:

                                      

                                      $folio = "ODV00".$nuevo;



                                  break;



                                  case 6:

                                      

                                      $folio = "ODV0".$nuevo;



                                  break;



                                  case 7:

                                      

                                      $folio = "ODV".$nuevo;



                                  break;



                                  default:



                                      $folio = "s/asignar";



                                  break;



                              }





                            return '<a href="'.base_url().'tw/php/cotizaciones/cot'.$d.'.pdf" target="_blank">'.$folio.'</a>';

                           

                        }  

                ),



                //array( 'db' => 'cliente',     'dt' => 5 ),



                array( 'db' => 'cliente',     'dt' => 5,



                        'formatter' => function( $d, $row ) {



                            return utf8_encode($d);



                        }  



                ),



                array( 'db' => 'contacto',     'dt' => 6,



                        'formatter' => function( $d, $row ) {



                            if ( $d == null) {

                                

                                return 'S/Contactos';



                            }else{



                                $separar = explode("/", $d);

                                return '<p><a href="mailto:'.$separar[0].'"><i class="fa fa-envelope"></i> '.utf8_encode($separar[0]).'</a></p><p><a href="tel:'.utf8_encode($separar[1]).'"><i class="fa fa-phone"></i> '.utf8_encode($separar[1]).'</a></p>';

                            }



                        }  

                ),



                array( 'db' => 'tsubtotal',     'dt' => 7,



                        'formatter' => function( $d, $row ) {



                            return wims_currency($d);



                        }  



                ),



                array( 'db' => 'tdescuento',     'dt' => 8,



                        'formatter' => function( $d, $row ) {



                            return wims_currency($d);



                        }  



                ),



                array( 'db' => 'tiva',     'dt' => 9,



                        'formatter' => function( $d, $row ) {



                            return wims_currency($d);



                        }  



                ),



               



                array( 'db' => 'id',     'dt' => 11 ),



                array( 'db' => 'idclientex',     'dt' => 12 ),

           

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

                SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns)

            );





        }







}