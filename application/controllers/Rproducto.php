<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class Rproducto extends CI_Controller

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



       /*  $iduser = $this->session->userdata(IDUSERCOM); */

       $iduser = 1;



       /*  $numero_menu = 2; */



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

       /*  $vcondicion = array('iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu); */

        $vcondicion = array('iddepa' => 1);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla, $vcondicion);



        if ($verificar_menu > 0) {



            if ($iduser > 0) {



                $data["idusuario"] = $iduser;

                //$mensaje['verificacion'] = "Ingreso correctamente por cookie";

                /* $nom_menu["nommenu"] = "rproductos"; */



                $this->load->view('general/head');

                $this->load->view('general/topbar');

                $this->load->view('general/sidebar');

                $this->load->view('general/css_autocompletar');                

                $this->load->view('general/css_select2');

                $this->load->view('general/css_upload');

                $this->load->view('productos/body_productos');
                
                $this->load->view('general/css_date');

                $this->load->view('general/css_datatable');

                $this->load->view('general/footer');

                $this->load->view('general/settings');

                $this->load->view('productos/accciones_reporte_productos');
            } else {



                redirect("Login");
            }
        } else {



            redirect("AccesoDenegado");
        }
    }





    public function retirarProducto()
    {



        $data_post = $this->input->post();



        $datos = array('estatus' => 1);

        $tabla = "alta_productos";

        $condicion = array('id' => $data_post["idpro"]);



        echo json_encode($this->General_Model->updateERP($datos, $tabla, $condicion));
    }


    public function showCategoria()
    {


        $query = "SELECT id,descripcion FROM alta_categoria WHERE estatus IN(0,1) ORDER BY descripcion ASC";



        echo json_encode($this->General_Model->infoxQuery($query));
    }

    public function showCategoriaxMarcas()
    {

        $data_post = $this->input->get();

        $marcaId = $this->input->get("marcaId");
        $categoriaId = $this->input->get("categoriaId");

        if ($marcaId > 0 and $categoriaId == 0) {

            $query = "SELECT DISTINCT(b.id) as id, b.descripcion AS descripcion FROM alta_productos a, alta_categoria b, sat_catalogo_unidades d, alta_marca e WHERE a.idunidad=d.id AND a.idcategoria=b.id AND a.idmarca=e.id AND e.id ='" . $marcaId . "' AND a.estatus = 0 ORDER BY(b.descripcion) ASC";
        } else {
            $query = "SELECT id,descripcion FROM alta_categoria WHERE estatus IN(0,1) ORDER BY descripcion ASC";
        }

        echo json_encode($this->General_Model->infoxQuery($query));
    }


    public function showMarca()
    {

        $data_post = $this->input->get();

        $categoriaId = $this->input->get("categoriaId");

        if ($categoriaId > 0) {

            $query = "SELECT DISTINCT(e.id) as id, e.marca as marca FROM alta_productos a, alta_categoria b, sat_catalogo_unidades d, alta_marca e 
            
            WHERE a.idunidad=d.id AND a.idcategoria=b.id AND a.idmarca=e.id AND b.id ='" . $categoriaId . "' AND a.estatus = 0 ORDER BY(e.marca) ASC";
        } else {
            $query = "SELECT id,marca FROM alta_marca WHERE estatus IN(0,1) ORDER BY marca ASC";
        }

        echo json_encode($this->General_Model->infoxQuery($query));
    }

    ///////////****************TABLA PARTIDAS BITACORA



    public function loadPartidas()

    {



       /*  $iduser = $this->session->userdata('iduserformato'); */

       $iduser = 1;





        $table = "( SELECT a.id, CONVERT(CAST(CONVERT(a.nparte USING latin1) AS BINARY) USING utf8) AS clave,a.clave as sku,CONCAT_WS(' - ',CONVERT(CAST(CONVERT(a.descripcion USING latin1) AS BINARY) USING utf8), a.clave ) AS descripcion,d.descripcion AS unidad,b.descripcion AS categoria,a.iva,e.marca,a.costo AS costox,CONCAT_WS('/',a.id,a.img) AS imagen

                FROM alta_productos a, alta_categoria b, sat_catalogo_unidades d, alta_marca e

                WHERE 

                a.idunidad=d.id

                AND a.idcategoria=b.id

                AND a.idmarca=e.id

                AND a.estatus = 0)temp";



        // Primary key of table

        $primaryKey = 'id';



        $columns = array(



            /*<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    Default <span class="caret"></span>

                                  </button>*/



            array(
                'db' => 'id',     'dt' => 0,



                'formatter' => function ($d, $row) {



                    return '<div class="btn-group">

                    <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><span class="caret"></span> </button>

                                    <ul class="dropdown-menu">

                                        <li><a href="#"><i class="ri-eye-fill"></i> Mas información</a></li>

                                        <li><a href="' . base_url() . 'ActProducto/actualizar/' . $d . '" style="color:#FFC300;"> <i class="ri-pencil-fill"></i> Editar</a></li>

                                        <li><a href="' . base_url() . 'Kardex/producto/' . $d . '" target="_blank" style="color:darkgreen;"><i class="ri-database-fill"></i> Kardex</a></li>

                                        <li role="separator" class="divider"></li>



                                        <li><a href="javascript:retirarProducto(' . $d . ')" style="color:red;"><i class="ri-delete-bin-fill"></i> Eliminar</a></li>

                                      </ul>

                                    </div>';
                }

            ),



            array(
                'db' => 'imagen',     'dt' => 1,



                'formatter' => function ($d, $row) {



                    $separar = explode("/", $d);



                    if ($separar[1] > 0) {



                        return "<center><img src='" . base_url() . "comanorsa/productos/" . $separar[0] . ".jpg' class='img img-responsive' ></center>";
                    } else {





                        return "<p>s/asignar</p>";
                    }
                }

            ),



            //array( 'db' => 'clave',     'dt' => 2 ),

            array(
                'db' => 'clave',     'dt' => 2,



                'formatter' => function ($d, $row) {



                    return utf8_encode($d);
                }

            ),

            //array( 'db' => 'descripcion',     'dt' => 3 ),

            array(
                'db' => 'descripcion',     'dt' => 3,



                'formatter' => function ($d, $row) {



                    return utf8_encode($d);
                }

            ),

            //array( 'db' => 'unidad',     'dt' => 4 ),



            array(
                'db' => 'unidad',     'dt' => 4,



                'formatter' => function ($d, $row) {



                    return utf8_encode($d);
                }

            ),

            //array( 'db' => 'marca',     'dt' => 5 ),



            array(
                'db' => 'marca',     'dt' => 5,



                'formatter' => function ($d, $row) {



                    return utf8_encode($d);
                }

            ),







            //array( 'db' => 'categoria',     'dt' => 6 ),



            array(
                'db' => 'categoria',     'dt' => 6,



                'formatter' => function ($d, $row) {



                    return utf8_encode($d);
                }

            ),



            array(
                'db' => 'costox',     'dt' => 7,



                'formatter' => function ($d, $row) {



                    return wims_currency($d);
                }

            ),



            array(
                'db' => 'iva',     'dt' => 8,



                'formatter' => function ($d, $row) {



                    switch ($d) {



                        case 3:



                            $ivax = "Individual";



                            break;



                        case 2:



                            $ivax = "Aplica";



                            break;



                        case 1:



                            $ivax = "General";



                            break;
                    }



                    return $ivax;
                }

            ),







            array('db' => 'id',     'dt' => 9)



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


    public function loadPartidasCategoria()

    {



       /*  $iduser = $this->session->userdata('iduserformato'); */
        $data_post = $this->input->get();

        $categoriaId = $this->input->get("categoriaId");
        $marcaId = $this->input->get("marcaId");

        $table = "( SELECT a.id, CONVERT(CAST(CONVERT(a.nparte USING latin1) AS BINARY) USING utf8) AS clave,a.clave as sku,CONCAT_WS(' - ',CONVERT(CAST(CONVERT(a.descripcion USING latin1) AS BINARY) USING utf8), a.clave ) AS descripcion,d.descripcion AS unidad,b.descripcion AS categoria,a.iva,e.marca,a.costo AS costox,CONCAT_WS('/',a.id,a.img) AS imagen

                FROM alta_productos a, alta_categoria b, sat_catalogo_unidades d, alta_marca e

                WHERE 

                a.idunidad=d.id

                AND a.idcategoria=b.id

                AND a.idmarca=e.id

                AND b.id ='" . $categoriaId . "'

                AND e.id ='" . $marcaId . "'

                AND a.estatus = 0)temp";



        // Primary key of table

        $primaryKey = 'id';



        $columns = array(



            /*<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    Default <span class="caret"></span>

                                  </button>*/



            array(
                'db' => 'id',     'dt' => 0,



                'formatter' => function ($d, $row) {



                    return '<div class="btn-group">

                    <button type="button" class="btn btn-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><span class="caret"></span> </button>

                    <ul class="dropdown-menu">

                        <li><a href="#"><i class="ri-eye-fill"></i> Mas información</a></li>

                        <li><a href="' . base_url() . 'ActProducto/actualizar/' . $d . '" style="color:#FFC300;"> <i class="ri-pencil-fill"></i> Editar</a></li>

                        <li><a href="' . base_url() . 'Kardex/producto/' . $d . '" target="_blank" style="color:darkgreen;"><i class="ri-database-fill"></i> Kardex</a></li>

                        <li role="separator" class="divider"></li>



                        <li><a href="javascript:retirarProducto(' . $d . ')" style="color:red;"><i class="ri-delete-bin-fill"></i> Eliminar</a></li>

                      </ul>

                    </div>';
                }

            ),



            array(
                'db' => 'imagen',     'dt' => 1,



                'formatter' => function ($d, $row) {



                    $separar = explode("/", $d);



                    if ($separar[1] > 0) {



                        return "<center><img src='" . base_url() . "comanorsa/productos/" . $separar[0] . ".jpg' class='img img-responsive' ></center>";
                    } else {





                        return "<p>s/asignar</p>";
                    }
                }

            ),



            //array( 'db' => 'clave',     'dt' => 2 ),

            array(
                'db' => 'clave',     'dt' => 2,



                'formatter' => function ($d, $row) {



                    return utf8_encode($d);
                }

            ),

            //array( 'db' => 'descripcion',     'dt' => 3 ),

            array(
                'db' => 'descripcion',     'dt' => 3,



                'formatter' => function ($d, $row) {



                    return utf8_encode($d);
                }

            ),

            //array( 'db' => 'unidad',     'dt' => 4 ),



            array(
                'db' => 'unidad',     'dt' => 4,



                'formatter' => function ($d, $row) {



                    return utf8_encode($d);
                }

            ),

            //array( 'db' => 'marca',     'dt' => 5 ),



            array(
                'db' => 'marca',     'dt' => 5,



                'formatter' => function ($d, $row) {



                    return utf8_encode($d);
                }

            ),







            //array( 'db' => 'categoria',     'dt' => 6 ),



            array(
                'db' => 'categoria',     'dt' => 6,



                'formatter' => function ($d, $row) {



                    return utf8_encode($d);
                }

            ),



            array(
                'db' => 'costox',     'dt' => 7,



                'formatter' => function ($d, $row) {



                    return wims_currency($d);
                }

            ),



            array(
                'db' => 'iva',     'dt' => 8,



                'formatter' => function ($d, $row) {



                    switch ($d) {



                        case 3:



                            $ivax = "Individual";



                            break;



                        case 2:



                            $ivax = "Aplica";



                            break;



                        case 1:



                            $ivax = "General";



                            break;
                    }



                    return $ivax;
                }

            ),







            array('db' => 'id',     'dt' => 9)



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
