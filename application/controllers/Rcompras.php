<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class Rcompras extends CI_Controller

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

                array('º', '~', '!', '&', '´', ';', '"', '°'),

                array('', '', '', '&amp;', '', '', '&quot;', ' grados'),

                $string

            );





            return $string;
        }



        function obtenerFechaEnLetra($fecha)
        {

            $num = date("j", strtotime($fecha));

            $anno = date("Y", strtotime($fecha));

            $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

            $mes = $mes[(date('m', strtotime($fecha)) * 1) - 1];

            return $num . '-' . strtoupper($mes) . '-' . $anno;
        }



        function wims_currency($number)
        {

            if ($number < 0) {

                $print_number = "-$ " . str_replace('-', '', number_format($number, 2, ".", ",")) . "";
            } else {

                $print_number = "$ " .  number_format($number, 2, ".", ",");
            }

            return $print_number;
        }



        $this->load->model('General_Model');
    }



    public function index()

    {



        $iduser = $this->session->userdata(IDUSERCOM);



        $numero_menu = 16;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array('iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla, $vcondicion);



        if ($verificar_menu > 0) {



            if ($iduser > 0) {



                $data["idusuario"] = $iduser;

                //$mensaje['verificacion'] = "Ingreso correctamente por cookie";

                $nom_menu["nommenu"] = "rcompras";



                $this->load->view('general/header');

                $this->load->view('general/menuv2');

                $this->load->view('general/css_select2');

                $this->load->view('general/css_datatable');

                $this->load->view('general/menu_header', $nom_menu);

                $this->load->view('compras/reporte_compras');

                $this->load->view('general/footer');

                $this->load->view('compras/acciones_reporte_compras');
            } else {



                redirect("Login");
            }
        } else {



            redirect('AccesoDenegado');
        }
    }



    public function cancelarOrden()
    {



        $data_post = $this->input->post();



        /////////////no hay que verificar por que las partidas de entrada tiene odc y falta validar el id de entrada



        $condicion = array('idoc' => $data_post["odcx"], 'identrada>' => 0);

        $tabla = "partes_entrada";

        $verificar = $this->General_Model->verificarRepeat($tabla, $condicion);



        if ($verificar > 0) {



            //el articulo tiene entradas

            echo json_encode(0);
        } else {



            //borramos entrada

            $condicion2 = array('idoc' => $data_post["odcx"]);

            $tabla2 = "partes_entrada";

            $this->General_Model->deleteERP($tabla2, $condicion2);



            ////cambiamos el estatus de la odc 

            $datos3 = array('estatus' => 2,);

            $condicion3 = array('id' => $data_post["odcx"]);

            $tabla3 = "alta_oc";

            $this->General_Model->updateERP($datos3, $tabla3, $condicion3);



            /// regresamos las partidas a asignar

            $datos4 = array('idproveedor' => 1, 'idoc' => 0);

            $condicion4 = array('idoc' => $data_post["odcx"]);

            $tabla4 = "partes_asignar_oc";

            $this->General_Model->updateERP($datos4, $tabla4, $condicion4);



            echo json_encode(1);
        }
    }





    ///////////****************TABLA PARTIDAS BITACORA



    public function loadPartidas()

    {



        $iduser = $this->session->userdata('iduserformato');

        $data_get = $this->input->get();





        $table = "(SELECT  CONCAT_WS('/',a.id,a.estatus) AS acciones,a.id, a.estatus, a.fecha, b.nombre AS usuario, c.nombre AS proveedor, a.subtotal, a.descuento, a.iva, a.total

            FROM alta_oc a, alta_usuarios b, alta_proveedores c

            WHERE a.idusuario=b.id

            AND a.idpro=c.id 

            AND CONCAT_WS(a.id,c.nombre,b.nombre,a.total) LIKE '%" . $data_get['buscar'] . "%')temp";



        // Primary key of table

        $primaryKey = 'id';



        $columns = array(







            array(
                'db' => 'acciones',     'dt' => 0,



                'formatter' => function ($d, $row) {



                    $separar = explode("/", $d);



                    /*



                                0:darkblue;

                                1:#FFC300;

                                2:darkgreen



                            */



                    switch ($separar[1]) {

                        case 0:

                            ///$boton = '<a class="btn btn-success" href="'.base_url().'Entradaoc/folioOc/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';

                            $boton = '<div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                      <li><a href="javascript:finalizarEntrada(' . $separar[0] . ')" style="color:darkgreen; font-weight:bold;"> <i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Finalizar Entrada</a></li>
                                        <li><a href="' . base_url() . 'Entradaoc/folioOc/' . $separar[0] . '" style="color:darkgreen; font-weight:bold;"> <i class="fa fa-archive" style="color:darkgreen; font-weight:bold;"></i> Asignar entrada</a></li>
                                        <li><a href="javascript:cancelarOrden(' . $separar[0] . ')" style="color:red; font-weight:bold;"><i class="fa fa-close" style="color:red; font-weight:bold;"></i> Cancelar orden</a></li>
                                      </ul>
                                    </div>';
                            break;

                        case 1:
                            $boton = '';
                            break;

                        case 3:

                            ///$boton = '<a class="btn btn-success" href="'.base_url().'Entradaoc/folioOc/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';

                            $boton = '<div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                      <li><a href="javascript:finalizarEntrada(' . $separar[0] . ')" style="color:darkgreen; font-weight:bold;"> <i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Finalizar Entrada</a></li>
                                        <li><a href="' . base_url() . 'Entradaoc/folioOc/' . $separar[0] . '" style="color:darkgreen; font-weight:bold;"> <i class="fa fa-archive" style="color:darkgreen; font-weight:bold;"></i> Asignar entrada</a></li>
                                        <li><a href="javascript:cancelarOrden(' . $separar[0] . ')" style="color:red; font-weight:bold;"><i class="fa fa-close" style="color:red; font-weight:bold;"></i> Cancelar orden</a></li>
                                      </ul>
                                    </div>';
                            break;

                        default:
                            $boton = '';
                            break;
                    }





                    return $boton;
                }

            ),



            array(
                'db' => 'estatus',     'dt' => 1,



                'formatter' => function ($d, $row) {



                    $separar = explode("/", $d);



                    /*



                                0:darkblue;cotizacion

                                1:#F7694C;remision

                                2:darkgreen:facturacion

                                ////////

                                0:#8D27B0;orden de compra

                                1:#9A1B1B ;entradas



                            */



                    switch ($d) {



                        case 0:
                            $boton = '<p style="color:#8D27B0; font-weight:bold;" > ODC</p>';
                            break;

                        case 1:
                            $boton = '<p style="color:green; font-weight:bold;" > ENTRADA</p>';
                            break;

                        case 2:
                            $boton = '<p style="color:red; font-weight:bold;" > CANCELADA</p>';
                            break;

                        case 3:
                            $boton = '<p style="color:#B7950B; font-weight:bold;" > ENTRADA/PARCIAL</p>';
                            break;

                        case 4:
                            $boton = '<p style="color:blue; font-weight:bold;" > PARCIAL/FINALIZADA</p>';
                            break;

                        case 5:
                            $boton = '<p style="color:blue; font-weight:bold;" > FINALIZADA S/ENTRADAS</p>';
                            break;
                    }





                    return $boton;
                }

            ),



            array(
                'db' => 'fecha',     'dt' => 2,



                'formatter' => function ($d, $row) {



                    return obtenerFechaEnLetra($d);
                }

            ),



            array(
                'db' => 'id',     'dt' => 3,



                'formatter' => function ($d, $row) {



                    return '<a href="' . base_url() . 'tw/php/ordencompra/odc' . $d . '.pdf" target="_blank">' . $d . '</a>';
                }

            ),

            array('db' => 'usuario',     'dt' => 4),



            //array( 'db' => 'proveedor',     'dt' => 5 ),



            array(
                'db' => 'proveedor',     'dt' => 5,



                'formatter' => function ($d, $row) {



                    return utf8_encode($d);
                }



            ),



            array(
                'db' => 'subtotal',     'dt' => 6,



                'formatter' => function ($d, $row) {



                    return wims_currency($d);
                }



            ),



            array(
                'db' => 'descuento',     'dt' => 7,



                'formatter' => function ($d, $row) {



                    return wims_currency($d);
                }



            ),



            array(
                'db' => 'iva',     'dt' => 8,



                'formatter' => function ($d, $row) {



                    return wims_currency($d);
                }



            ),



            array(
                'db' => 'total',     'dt' => 9,



                'formatter' => function ($d, $row) {



                    return wims_currency($d);
                }



            ),







            array(
                'db' => 'id',     'dt' => 10,



                'formatter' => function ($d, $row) {



                    return wims_currency($d);
                }



            )



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

            SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)

        );
    }

    public function searchRows()
    {

        $data_post = $this->input->post();
        $sql = "SELECT COUNT(*) AS total FROM alta_entrada WHERE idoc =" . $data_post["idODC"];
        $datos = $this->General_Model->infoxQueryUnafila($sql);
        echo json_encode($datos->total);
    }

    public function finallyEntrada()
    {

        $data_post = $this->input->post();
        $data = array('estatus' => $data_post["estatus"]);
        $condition = array('id' => $data_post["idODC"]);
        $table = "alta_oc";
        echo json_encode($this->General_Model->updateERP($data, $table, $condition));
    }



    public function loadPartidasEst()

    {



        $iduser = $this->session->userdata('iduserformato');

        $data_get = $this->input->get();





        if ($data_get['est'] == 6) {



            $table = "(SELECT  CONCAT_WS('/',a.id,a.estatus) AS acciones,a.id, a.estatus, a.fecha, b.nombre AS usuario, c.nombre AS proveedor, a.subtotal, a.descuento, a.iva, a.total

                FROM alta_oc a, alta_usuarios b, alta_proveedores c

                WHERE a.idusuario=b.id

                AND a.idpro=c.id

                )temp";
        } else {



            $table = "(SELECT  CONCAT_WS('/',a.id,a.estatus) AS acciones,a.id, a.estatus, a.fecha, b.nombre AS usuario, c.nombre AS proveedor, a.subtotal, a.descuento, a.iva, a.total

                FROM alta_oc a, alta_usuarios b, alta_proveedores c

                WHERE a.idusuario=b.id

                AND a.idpro=c.id

                AND a.estatus=" . $data_get['est'] . "

                )temp";
        }



        // Primary key of table

        $primaryKey = 'id';



        $columns = array(







            array(
                'db' => 'acciones',     'dt' => 0,



                'formatter' => function ($d, $row) {



                    $separar = explode("/", $d);



                    /*



                                0:darkblue;

                                1:#FFC300;

                                2:darkgreen



                            */



                    switch ($separar[1]) {

                        case 0:
                            //$boton = '<a class="btn btn-success" href="'.base_url().'Entradaoc/folioOc/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';

                            $boton = '<div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                      <li><a href="javascript:finalizarEntrada(' . $separar[0] . ')" style="color:darkgreen; font-weight:bold;"> <i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Finalizar Entrada</a></li>
                                      <li><a href="' . base_url() . 'Entradaoc/folioOc/' . $separar[0] . '" style="color:darkgreen; font-weight:bold;"> <i class="fa fa-archive" style="color:darkgreen; font-weight:bold;"></i> Asignar entrada</a></li>
                                        <li><a href="javascript:cancelarFactura(' . $separar[0] . ')" style="color:red; font-weight:bold;"><i class="fa fa-close" style="color:red; font-weight:bold;"></i> Cancelar factura</a></li>                                        
                                      </ul>
                                    </div>';
                            break;

                        case 3:

                            ///$boton = '<a class="btn btn-success" href="'.base_url().'Entradaoc/folioOc/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';

                            $boton = '<div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                      <li><a href="javascript:finalizarEntrada(' . $separar[0] . ')" style="color:darkgreen; font-weight:bold;"> <i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Finalizar Entrada</a></li>
                                        <li><a href="' . base_url() . 'Entradaoc/folioOc/' . $separar[0] . '" style="color:darkgreen; font-weight:bold;"> <i class="fa fa-archive" style="color:darkgreen; font-weight:bold;"></i> Asignar entrada</a></li>
                                        <li><a href="javascript:cancelarOrden(' . $separar[0] . ')" style="color:red; font-weight:bold;"><i class="fa fa-close" style="color:red; font-weight:bold;"></i> Cancelar orden</a></li>
                                      </ul>
                                    </div>';
                            break;

                        case 1:
                            $boton = '';
                            break;

                        default:
                            $boton = '';
                            break;
                    }





                    return $boton;
                }

            ),



            array(
                'db' => 'estatus',     'dt' => 1,



                'formatter' => function ($d, $row) {



                    $separar = explode("/", $d);



                    /*



                                0:darkblue;cotizacion

                                1:#F7694C;remision

                                2:darkgreen:facturacion

                                ////////

                                0:#8D27B0;orden de compra

                                1:#9A1B1B ;entradas



                            */



                    switch ($d) {

                        case 0:
                            $boton = '<p style="color:#8D27B0; font-weight:bold;" > ODC</p>';
                            break;

                        case 1:
                            $boton = '<p style="color:green; font-weight:bold;" > ENTRADA</p>';
                            break;

                        case 2:
                            $boton = '<p style="color:red; font-weight:bold;" > CANCELADA</p>';
                            break;

                        case 3:
                            $boton = '<p style="color:#B7950B; font-weight:bold;" > ENTRADA/PARCIAL</p>';
                            break;

                        case 4:
                            $boton = '<p style="color:blue; font-weight:bold;" > PARCIAL/FINALIZADA</p>';
                            break;

                        case 5:
                            $boton = '<p style="color:blue; font-weight:bold;" > FINALIZADA S/ENTRADAS</p>';
                            break;
                    }





                    return $boton;
                }

            ),



            array(
                'db' => 'fecha',     'dt' => 2,



                'formatter' => function ($d, $row) {



                    return obtenerFechaEnLetra($d);
                }

            ),



            array(
                'db' => 'id',     'dt' => 3,



                'formatter' => function ($d, $row) {



                    return '<a href="' . base_url() . 'tw/php/ordencompra/odc' . $d . '.pdf" target="_blank">' . $d . '</a>';
                }

            ),

            array('db' => 'usuario',     'dt' => 4),



            //array( 'db' => 'proveedor',     'dt' => 5 ),



            array(
                'db' => 'proveedor',     'dt' => 5,



                'formatter' => function ($d, $row) {



                    return utf8_encode($d);
                }



            ),



            array(
                'db' => 'subtotal',     'dt' => 6,



                'formatter' => function ($d, $row) {



                    return wims_currency($d);
                }



            ),



            array(
                'db' => 'descuento',     'dt' => 7,



                'formatter' => function ($d, $row) {



                    return wims_currency($d);
                }



            ),



            array(
                'db' => 'iva',     'dt' => 8,



                'formatter' => function ($d, $row) {



                    return wims_currency($d);
                }



            ),



            array(
                'db' => 'total',     'dt' => 9,



                'formatter' => function ($d, $row) {



                    return wims_currency($d);
                }



            ),







            array(
                'db' => 'id',     'dt' => 10,



                'formatter' => function ($d, $row) {



                    return wims_currency($d);
                }



            )



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

            SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)

        );
    }


    /////////////*********************** FILTRO ENTRELAZADO  */

    public function loadFiltroEntrelazado()

    {



        $iduser = $this->session->userdata('iduserformato');

        $data_get = $this->input->get();

        $busquedax = $this->input->get("buscadorx");

        $estatus = $this->input->get("estatusx");



        
        if($estatus == 6){

            $table = "(SELECT  CONCAT_WS('/',a.id,a.estatus) AS acciones,a.id, a.estatus, a.fecha, b.nombre AS usuario, c.nombre AS proveedor, a.subtotal, a.descuento, a.iva, a.total

            FROM alta_oc a, alta_usuarios b, alta_proveedores c

            WHERE a.idusuario=b.id

            AND a.idpro=c.id 

            AND CONCAT_WS(a.id,c.nombre,b.nombre,a.total) LIKE '%" . $busquedax . "%')temp";

        }else{

            $table = "(SELECT  CONCAT_WS('/',a.id,a.estatus) AS acciones,a.id, a.estatus, a.fecha, b.nombre AS usuario, c.nombre AS proveedor, a.subtotal, a.descuento, a.iva, a.total

            FROM alta_oc a, alta_usuarios b, alta_proveedores c

            WHERE a.idusuario=b.id

            AND a.idpro=c.id 

            AND CONCAT_WS(a.id,c.nombre,b.nombre,a.total) LIKE '%" . $busquedax . "%'
            
            AND a.estatus ='".$estatus."')temp";

        }



        // Primary key of table

        $primaryKey = 'id';



        $columns = array(







            array(
                'db' => 'acciones',     'dt' => 0,



                'formatter' => function ($d, $row) {



                    $separar = explode("/", $d);



                    /*



                                0:darkblue;

                                1:#FFC300;

                                2:darkgreen



                            */



                    switch ($separar[1]) {

                        case 0:

                            ///$boton = '<a class="btn btn-success" href="'.base_url().'Entradaoc/folioOc/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';

                            $boton = '<div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                      <li><a href="javascript:finalizarEntrada(' . $separar[0] . ')" style="color:darkgreen; font-weight:bold;"> <i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Finalizar Entrada</a></li>
                                        <li><a href="' . base_url() . 'Entradaoc/folioOc/' . $separar[0] . '" style="color:darkgreen; font-weight:bold;"> <i class="fa fa-archive" style="color:darkgreen; font-weight:bold;"></i> Asignar entrada</a></li>
                                        <li><a href="javascript:cancelarOrden(' . $separar[0] . ')" style="color:red; font-weight:bold;"><i class="fa fa-close" style="color:red; font-weight:bold;"></i> Cancelar orden</a></li>
                                      </ul>
                                    </div>';
                            break;

                        case 1:
                            $boton = '';
                            break;

                        case 3:

                            ///$boton = '<a class="btn btn-success" href="'.base_url().'Entradaoc/folioOc/'.$separar[0].'" role="button" target="_blank"><i class="fa fa-check" title="2 fase cotizacion" ></i></a>';

                            $boton = '<div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                      <li><a href="javascript:finalizarEntrada(' . $separar[0] . ')" style="color:darkgreen; font-weight:bold;"> <i class="fa fa-check" style="color:darkgreen; font-weight:bold;"></i> Finalizar Entrada</a></li>
                                        <li><a href="' . base_url() . 'Entradaoc/folioOc/' . $separar[0] . '" style="color:darkgreen; font-weight:bold;"> <i class="fa fa-archive" style="color:darkgreen; font-weight:bold;"></i> Asignar entrada</a></li>
                                        <li><a href="javascript:cancelarOrden(' . $separar[0] . ')" style="color:red; font-weight:bold;"><i class="fa fa-close" style="color:red; font-weight:bold;"></i> Cancelar orden</a></li>
                                      </ul>
                                    </div>';
                            break;

                        default:
                            $boton = '';
                            break;
                    }





                    return $boton;
                }

            ),



            array(
                'db' => 'estatus',     'dt' => 1,



                'formatter' => function ($d, $row) {



                    $separar = explode("/", $d);



                    /*



                                0:darkblue;cotizacion

                                1:#F7694C;remision

                                2:darkgreen:facturacion

                                ////////

                                0:#8D27B0;orden de compra

                                1:#9A1B1B ;entradas



                            */



                    switch ($d) {



                        case 0:
                            $boton = '<p style="color:#8D27B0; font-weight:bold;" > ODC</p>';
                            break;

                        case 1:
                            $boton = '<p style="color:green; font-weight:bold;" > ENTRADA</p>';
                            break;

                        case 2:
                            $boton = '<p style="color:red; font-weight:bold;" > CANCELADA</p>';
                            break;

                        case 3:
                            $boton = '<p style="color:#B7950B; font-weight:bold;" > ENTRADA/PARCIAL</p>';
                            break;

                        case 4:
                            $boton = '<p style="color:blue; font-weight:bold;" > PARCIAL/FINALIZADA</p>';
                            break;

                        case 5:
                            $boton = '<p style="color:blue; font-weight:bold;" > FINALIZADA S/ENTRADAS</p>';
                            break;
                    }





                    return $boton;
                }

            ),



            array(
                'db' => 'fecha',     'dt' => 2,



                'formatter' => function ($d, $row) {



                    return obtenerFechaEnLetra($d);
                }

            ),



            array(
                'db' => 'id',     'dt' => 3,



                'formatter' => function ($d, $row) {



                    return '<a href="' . base_url() . 'tw/php/ordencompra/odc' . $d . '.pdf" target="_blank">' . $d . '</a>';
                }

            ),

            array('db' => 'usuario',     'dt' => 4),



            //array( 'db' => 'proveedor',     'dt' => 5 ),



            array(
                'db' => 'proveedor',     'dt' => 5,



                'formatter' => function ($d, $row) {



                    return utf8_encode($d);
                }



            ),



            array(
                'db' => 'subtotal',     'dt' => 6,



                'formatter' => function ($d, $row) {



                    return wims_currency($d);
                }



            ),



            array(
                'db' => 'descuento',     'dt' => 7,



                'formatter' => function ($d, $row) {



                    return wims_currency($d);
                }



            ),



            array(
                'db' => 'iva',     'dt' => 8,



                'formatter' => function ($d, $row) {



                    return wims_currency($d);
                }



            ),



            array(
                'db' => 'total',     'dt' => 9,



                'formatter' => function ($d, $row) {



                    return wims_currency($d);
                }



            ),







            array(
                'db' => 'id',     'dt' => 10,



                'formatter' => function ($d, $row) {



                    return wims_currency($d);
                }



            )



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

            SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns)

        );
    }
}