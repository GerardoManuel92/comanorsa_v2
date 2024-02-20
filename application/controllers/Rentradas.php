<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class Rentradas extends CI_Controller

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



        $iduser = $this->session->userdata(IDUSERCOM);

        $numero_menu = 17;



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



          



          if($iduser > 0){



              $data["idusuario"]= $iduser;

              //$mensaje['verificacion'] = "Ingreso correctamente por cookie";

              $nom_menu["nommenu"] = "rentradas";



              $this->load->view('general/header');

              $this->load->view('general/menuv2');

              $this->load->view('general/css_datatable');

              $this->load->view('general/menu_header',$nom_menu);

              $this->load->view('entradas/reporte_entradas');

              $this->load->view('general/footer');

              $this->load->view('entradas/acciones_rentradas');



          }else{

         

              redirect("Login");

              

          }



        }

       

    }



    public function enviarCorreo(){



        $data_post = $this->input->post();



        $idclix = $data_post["idcli"];

        $idcotx = $data_post["idcot"];

        $destinatariox = $data_post["destinatario"];

        $copiax = $data_post["copia"];

        $otro_correox = $data_post["otro_correo"];



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

                                                <p style="margin:0;">Hemos enviado la FACTURA solicitada, esperando su total satisfacción tanto en producto como en precio quedamos a sus órdenes cualquier duda o aclaración.<!--<a href="http://www.example.com/" style="color:#e50d70;text-decoration:underline;">eget accumsan dictum</a>, nisi libero ultricies ipsum, in posuere mauris neque at erat.--></p>



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

                    $this->email->from(CORREOVENTAS, 'Factura #'.$idcotx.' - Comanorsa | Comercializadora angel de oriente S.A. DE C.V.');

                    //$this->email->to("thinkweb.mx@gmail.com");

                    $this->email->to($destinatariox);



                    if ( $copiax == 1 ) {

                        

                        $this->email->cc(COPIAVENTAS);  



                    }else{



                        $this->email->cc(COPIAVENTAS.','.$otro_correox);



                    }



                    $this->email->subject(  'Enviamos la Remision solicitada quedando al pendiente cualquier duda o aclaración' );

                    ////ADJUNTAR ARCHIVOS

                    //$adjunto= base_url()."admin/files/admin/js/upload/files/".$this->input->post('nombre'); 

                    //$this->email->attach($adjunto);

                    $this->email->attach('tw/php/facturas/fact'.$idcotx.'.pdf');

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



    public function showEntradas(){



      $query="SELECT id FROM `alta_entrada` LIMIT 50,110";

      echo json_encode( $this->General_Model->infoxQuery($query) );



    }



    public function cambiarEstatus(){



      $data_post = $this->input->post();

      $idoc=0;

      

      /////////// verificar que no haya entregas de ese material



      $sql="SELECT id,idpartecot,idoc FROM `partes_entrada` where identrada=".$data_post["identradax"];

      $infosql=$this->General_Model->infoxQuery($sql);



      if ( $infosql != null ) {

        

        $entrega=0;



        foreach ($infosql as $row) {

          

          $vcondicion = array('idpartefolio' => $row->idpartecot, 'identrega>' => 0);

          $vtabla = "partes_entrega";

          $verificar = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



          $entrega=$entrega+$verificar;

          $idoc=$row->idoc;



        }



        if ( $entrega > 0) {

          

          /// las partidas de la entrada ya tienen entrega 

          echo json_encode(false);



        }elseif ( $entrega == 0 ) {

          

          /// las partidas no tienen entrega, la cancelacion procede

          $datos=array('estatus' => 2 );

          $condicion=array('id' => $data_post["identradax"] );

          $tabla="alta_entrada";

          $this->General_Model->updateERP($datos,$tabla,$condicion);



          //// regresar las partidas a entrada 



          $datos2=array('identrada' => 0 );

          $condicion2=array('identrada' => $data_post["identradax"] );

          $tabla2="partes_entrada";

          $this->General_Model->updateERP($datos2,$tabla2,$condicion2);



          /// cambiar el estatus de la ODC a incompleta



          $datos3=array('estatus' => 0 );

          $condicion3=array('id' => $idoc );

          $tabla3="alta_oc";

          $this->General_Model->updateERP($datos3,$tabla3,$condicion3);



          echo json_encode(true);



        }else{



          //// el datoa no es reconocido 



          echo json_encode(null);



        } 



      }





    }





    ///////////****************TABLA PARTIDAS BITACORA



        public function loadPartidasFiltro()

        {



            $iduser = $this->session->userdata('iduserformato');



            $data_get=$this->input->get();

            $buscar=$data_get["buscador"];

            $estatus=$data_get["estatusx"];



            if($buscar == "" && $estatus == 2){



              $table = "(SELECT a.id,a.fecha,a.estatus,c.nombre as proveedor,a.idoc,a.observaciones,CONCAT_WS('/',a.id,a.estatus) AS acciones, d.nombre AS recibio

                      FROM alta_entrada a, alta_oc b, alta_proveedores c, alta_usuarios d

                      WHERE

                      a.idoc=b.id

                      AND b.idpro=c.id

                      AND a.idusuario=d.id)temp";



            }else if($buscar == "" && $estatus != 2){



              $table = "(SELECT a.id,a.fecha,a.estatus,c.nombre as proveedor,a.idoc,a.observaciones,CONCAT_WS('/',a.id,a.estatus) AS acciones, d.nombre AS recibio

                      FROM alta_entrada a, alta_oc b, alta_proveedores c, alta_usuarios d

                      WHERE

                      a.idoc=b.id

                      AND b.idpro=c.id

                      AND a.idusuario=d.id

                      AND a.estatus = '".$estatus."')temp";



            }else if ( $buscar != "" && $estatus == 2) {

              

              $table = "(SELECT a.id,a.fecha,a.estatus,c.nombre as proveedor,a.idoc,a.observaciones,CONCAT_WS('/',a.id,a.estatus) AS acciones, d.nombre AS recibio

                      FROM alta_entrada a, alta_oc b, alta_proveedores c, alta_usuarios d

                      WHERE

                      a.idoc=b.id

                      AND b.idpro=c.id

                      AND a.idusuario=d.id

                      AND CONCAT_WS(a.idoc,a.id,c.nombre,d.nombre) LIKE '%".$buscar."%')temp";



            }else if ( $buscar != "" && $estatus != 2){



              $table = "(SELECT a.id,a.fecha,a.estatus,c.nombre as proveedor,a.idoc,a.observaciones,CONCAT_WS('/',a.id,a.estatus) AS acciones, d.nombre AS recibio

                      FROM alta_entrada a, alta_oc b, alta_proveedores c, alta_usuarios d

                      WHERE

                      a.idoc=b.id

                      AND b.idpro=c.id

                      AND a.idusuario=d.id
                      
                      AND CONCAT_WS(a.idoc,a.id,c.nombre,d.nombre) LIKE '%".$buscar."%'
                      
                      AND a.estatus = '".$estatus."')temp";



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

                                

                                    /*$boton = '<a class="btn btn-success" href="'.base_url().'Actcotizacion/EditCot/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="javascript:cambiarEstatus('.$separar[0].')" style="color:red; font-weight:bold;"><i class="fa fa-cancel" style="color:red; font-weight:bold;"></i> Cancelar</a></li>

                                        



                                      </ul>

                                    </div>';



                                break;



                                case 1:



                                  return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">





                                      </ul>

                                    </div>';



                                break;



                            }



                        }  

                ),



                array( 'db' => 'estatus',     'dt' => 1,



                        'formatter' => function( $d, $row ) {



                            /*$separar = explode("/", $d);



                            



                                0:darkblue;cotizacion

                                1:#F7694C;remision

                                2:darkgreen:facturacion



                            */



                            switch ($d) {



                                case 0:

                                

                                    $boton = '<p style="color:green; font-weight:bold;"> ACTIVA</p>';



                                break;



                                case 1:

                                

                                    $boton = '<p style="color:darkblue; font-weight:bold;"> ENTREGADO</p>';



                                break;



                                case 2:

                                

                                    $boton = '<p style="color:red; font-weight:bold;"> CANCELADA</p>';



                                break;



                            }





                            return $boton;



                        }  

                ),



                array( 'db' => 'fecha',     'dt' => 2,



                        'formatter' => function( $d, $row ) {



                            //$separar = explode("/", $d);



                            if ( $d == '0000-00-00' ) {

                              

                              return 's/asignar';



                            }else{



                               return obtenerFechaEnLetra($d);



                            }



                        }  

                ),

                array( 'db' => 'id',     'dt' => 3,



                        'formatter' => function( $d, $row ) {



                            return '<a href="'.base_url().'tw/php/entradas/entrada'.$d.'.pdf" target="_blank">'.$d.'</a>';

                           

                        }  

                ),

                array( 'db' => 'idoc',     'dt' => 4,



                        'formatter' => function( $d, $row ) {



                            return '<a href="'.base_url().'tw/php/ordencompra/odc'.$d.'.pdf" target="_blank">'.$d.'</a>';

                           

                        }  

                ),



                array( 'db' => 'proveedor',     'dt' => 5 ),



                array( 'db' => 'recibio',     'dt' => 6 ),



                array( 'db' => 'observaciones',     'dt' => 7 ),



                array( 'db' => 'id',     'dt' => 8 ),

           

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