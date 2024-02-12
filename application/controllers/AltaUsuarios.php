<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class AltaUsuarios extends CI_Controller

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
    }



    public function index()

    {

       /*  $iduser = $this->session->userdata(IDUSERCOM); */
       $iduser = 1;


        $numero_menu = 36;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

       /*  $vcondicion = array('iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu); */

       $vcondicion = array('iddepa' => 1, 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla, $vcondicion);



        if ($verificar_menu > 0) {



            if ($iduser > 0) {


               /*  $titulo = "<i class='fa fa-user-plus'></i> Alta de usuarios y departamentos"; */

                $dmenu["nommenu"] = "usuarios";
               /*  $data["titulox"] = $titulo; */


                //////borrar temporal submenus usuario

                $dtabla = "temporal_submenus";
                $dcondicion = array('idusuario' => $iduser);

                $this->General_Model->deleteERP($dtabla, $dcondicion);



                $this->load->view('general/head');
                $this->load->view('general/topbar');
                $this->load->view('general/sidebar');
                $this->load->view('general/css_autocompletar');
                $this->load->view('general/css_xedit');
                $this->load->view('general/css_date');
                $this->load->view('general/css_datatable');
                $this->load->view('general/css_select2');
                $this->load->view('general/css_upload');
                $this->load->view('usuario/body_usuarios');
                $this->load->view('usuario/modal_departamentos', $iduser);
                $this->load->view('usuario/modal_menu_usuario');
                $this->load->view('usuario/modal_submenus_departamento');
                $this->load->view('general/footer');
                $this->load->view('general/settings');
                $this->load->view('usuario/acciones_alta_usuario');

            } else {



                redirect("Login");
            }
        } else {



            redirect('AccesoDenegado');
        }
    }


    public function showDepartamentos()
    {

        $query = "SELECT id,nombre FROM alta_departamentos WHERE estatus=0 ORDER BY id ASC";

        echo json_encode($this->General_Model->infoxQuery($query));
    }

    public function showMenus()
    {

        $query = "SELECT id,nombre FROM menus WHERE estatus=0  AND nombre != 'Administracion' ORDER BY id ASC";

        echo json_encode($this->General_Model->infoxQuery($query));
    }

    public function showSubmenus()
    {

        $data_post = $this->input->get();

        $menux = $this->input->get("menux");

        $menu2x = $this->input->get("menu2x");

        $query = "SELECT id,nombre FROM submenus WHERE estatus=0 AND idmenu ='" . $menux . "' OR idmenu ='" . $menu2x . "' ORDER BY id ASC";

        echo json_encode($this->General_Model->infoxQuery($query));
    }

    public function altaUsuario()
    {

        $data_post = $this->input->post();


        $table = "alta_usuarios";

        $condicion = array('usuario' => $data_post['usuariox'], 'pass' => $data_post['passwordx'], 'estatus' => 0);

        $repeat = $this->General_Model->verificarRepeat($table, $condicion);

        if ($repeat > 0) {

            echo json_encode(0);
        } else {



            $data = array(

                'fecha' => date('Y-m-d'),
                'nombre' => $data_post['nombrex'],
                'correo' => $data_post['correox'],
                'telefono' => $data_post['telefonox'],
                'usuario' => $data_post['usuariox'],
                'pass' => $data_post['passwordx'],
                'iddepartamento' => $data_post['departamentox'],
                'estatus' => 0

            );

            echo json_encode($this->General_Model->altaERP($data, $table));
        }
    }

    public function showUsuarios()
    {

        $data_post = $this->input->post();

        $busqueda = $data_post['buscarx'];

        $departamento = $data_post['dept'];

        if (strlen($busqueda) == 0 && $departamento == 0) {

            $query = "SELECT a.id,a.nombre,b.nombre AS departamento,a.correo,a.telefono,a.estatus
        
            FROM alta_usuarios a, alta_departamentos b 
            
            WHERE b.id = a.iddepartamento
            
            AND a.estatus = 0";
        } else if (strlen($busqueda) == 0 && $departamento > 0) {

            $query = "SELECT a.id,a.nombre,b.nombre AS departamento,a.correo,a.telefono,a.estatus
        
            FROM alta_usuarios a, alta_departamentos b 
            
            WHERE b.id = a.iddepartamento

            AND a.iddepartamento = '" . $departamento . "'
            
            AND a.estatus = 0";
        } else if (strlen($busqueda) > 0 && $departamento == 0) {

            $query = "SELECT a.id,a.nombre,b.nombre AS departamento,a.correo,a.telefono,a.estatus
        
            FROM alta_usuarios a, alta_departamentos b 
            
            WHERE b.id = a.iddepartamento

            AND CONCAT_WS(a.nombre,b.nombre,a.correo,a.telefono) LIKE '%" . $busqueda . "%'           
            
            AND a.estatus = 0";
        } else if (strlen($busqueda) > 0 && $departamento > 0) {

            $query = "SELECT a.id,a.nombre,b.nombre AS departamento,a.correo,a.telefono,a.estatus
        
            FROM alta_usuarios a, alta_departamentos b 
            
            WHERE b.id = a.iddepartamento

            AND CONCAT_WS(a.nombre,b.nombre,a.correo,a.telefono) LIKE '%" . $busqueda . "%'  
            
            AND a.iddepartamento = '" . $departamento . "'
            
            AND a.estatus = 0";
        }




        echo json_encode($this->General_Model->infoxQuery($query));
    }

    public function showMenusxUsuario()
    {

        $data_post = $this->input->get();

        $idclientex = $this->input->get("clientex");

        $query = "SELECT d.nombre as usuario, b.nombre AS menu, a.nombre AS submenu
        
                FROM submenus a, menus b, menus_departamento c, alta_usuarios d, alta_departamentos e 
                
                WHERE a.id = c.idsubmenu 
                
                AND b.id = a.idmenu 
                
                AND c.iddepa = e.id 
                
                AND d.iddepartamento = e.id 
                
                AND d.id = '" . $idclientex . "'
                
                AND c.estatus = 0";

        echo json_encode($this->General_Model->infoxQuery($query));
    }

    public function altaDepartamento()
    {
        $data_post = $this->input->post();
        $table = "alta_departamentos";

        $condicion = array('nombre' => $data_post['departamentox'], 'estatus' => 0);

        $repeat = $this->General_Model->verificarRepeat($table, $condicion);

        if ($repeat > 0) {
            echo json_encode(0); // Departamento ya existe
        } else {
            $data = array(
                'fecha' => date('Y-m-d'),
                'nombre' => $data_post['departamentox'],
                'estatus' => 0
            );

            // Alta de departamento
            $last_id = $this->General_Model->altaERP($data, $table);

            if ($last_id > 0) {
                $registros = $this->input->post('submenux');  // Obtener el array de registros


                $table2 = "menus_departamento";
                $data2 = array(
                    'iddepa' => $last_id,
                    'idsubmenu' => $registros,
                    'estatus' => 0
                );

                // Alta de relación departamento-submenu
                echo json_encode($this->General_Model->altaERP($data2, $table2));
            } else {
                echo json_encode(0); // Error al dar de alta el departamento
            }
        }
    }


    public function editarUser()
    {

        $data_post = $this->input->post();
        $this->load->model('General_Model');

        $data = "nombre,iddepartamento,correo,telefono,usuario,pass";
        $tabla = "alta_usuarios";
        $condicion = array('id' => $data_post["idedit"]);

        $info = $this->General_Model->SelectUnafila($data, $tabla, $condicion);

        /* $contrasena=openssl_decrypt($info->pass,AES,KEY);
        $user=openssl_decrypt($info->usuario,AES,KEY); */

        echo json_encode(array('nombre' => $info->nombre, 'iddepartamento' => $info->iddepartamento, 'correo' => $info->correo, 'telefono' => $info->telefono, 'usuario' => $info->usuario, 'pass' => $info->pass));
    }


    public function actUsuario()
    {


        $valor = false;

        $data_post = $this->input->post();
        $this->load->model('General_Model');
        $table = "alta_usuarios";

        $condicion = array('usuario' => $data_post['usuariox'], 'estatus' => 0, 'id!=' => $data_post['iduserx']);

        $repeat = $this->General_Model->verificarRepeat($table, $condicion);

        if ($repeat > 0) {

            $valor = false;

            //echo json_encode(false);

        } else {

            $data = array(

                'fecha' => date('Y-m-d'),
                'nombre' => $data_post['nombrex'],
                'correo' => $data_post['correox'],
                'telefono' => $data_post['telefonox'],
                'usuario' => $data_post['usuariox'],
                'pass' => $data_post['passwordx'],
                'iddepartamento' => $data_post['departamentox'],
                'estatus' => 0

            );


            $table = "alta_usuarios";

            $condicion = array('id' => $data_post['iduserx']);


            $update = $this->General_Model->updateERP($data, $table, $condicion);

            $valor = $update;

            //echo json_encode($update);

        }


        echo json_encode($valor);
    }

    public function eliminaUser()
    {

        $data_post = $this->input->post();

        $this->load->model('General_Model');


        $datos = array('estatus' => 1);

        $tabla = "alta_usuarios";

        $condicion = array('id' => $data_post["iduser"]);

        $update = $this->General_Model->updateERP($datos, $tabla, $condicion);


        echo json_encode($update);
    }

    public function deleteSubmenu()
    {



        $data_post = $this->input->post();



        $datos = array(



            'estatus' => 1



        );

        $table = "menus_departamento";

        $condicion = array('idsubmenu' => $data_post['submenux'], 'iddepa' => $data_post['submenux']);



        echo json_encode($this->General_Model->updateERP($datos, $table, $condicion));
    }


    public function showDepa()
    {

        $data_post = $this->input->get();

        $depax = $this->input->get("depax");

        $query = "SELECT nombre  
        
                FROM alta_departamentos  
                
                WHERE id = '" . $depax . "'";

        echo json_encode($this->General_Model->infoxQuery($query));
    }

    public function showSubmenusxDepa()
    {

        $data_post = $this->input->get();

        $depax = $this->input->get("depax");

        $query = "SELECT d.id, a.id AS iddept, a.nombre AS departamento, c.nombre AS menu, d.nombre as submenu 
        
                FROM alta_departamentos a, menus_departamento b, menus c, submenus d 
                
                WHERE a.id = b.iddepa 
                
                AND d.id = b.idsubmenu 
                
                AND d.idmenu = c.id 
                
                AND a.id = '" . $depax . "'
                
                AND b.estatus = 0";

        echo json_encode($this->General_Model->infoxQuery($query));
    }


    public function anadirMenus()
    {

        $data_post = $this->input->post();

        $tabla = "temporal_submenus";

        $condicion = array('idsubmenu' => $data_post['submenux'], 'idusuario' => $data_post["idusuariox"]);

        $repeat = $this->General_Model->verificarRepeat($tabla, $condicion);

        if ($repeat > 0) {

            ///menu repetido

            echo json_encode(0);
        } else {

            $data = array(

                'idsubmenu' => $data_post['submenux'],
                'idusuario' => $data_post['idusuariox'],
                'estatus' => 0

            );

            echo json_encode($this->General_Model->altaERP($data, $tabla));
        }
    }

    public function retiraSubmenu()
    {
        $data_post = $this->input->post();
        $this->load->model('General_Model');

        $tabla_temp = "temporal_submenus";
        $condicion_temp = array('id' => $data_post["idsubx"]);

        $eliminado = $this->General_Model->deleteERP($tabla_temp, $condicion_temp);


        echo json_encode($eliminado);
    }

    public function mostrartemporalMenus()
    {

        $data_post = $this->input->get();

        $iduserx = $this->input->get("userx");

        $query = "SELECT a.id, a.idusuario, b.nombre as menu, c.nombre as submenu 
        
                    FROM temporal_submenus a, menus b, submenus c 
                    
                    WHERE a.idsubmenu = c.id 
                    
                    AND c.idmenu = b.id 
                    
                    AND a.idusuario = '" . $iduserx . "'";

        echo json_encode($this->General_Model->infoxQuery($query));
    }

    public function eliminaSubmenu()
    {

        $data_post = $this->input->post();

        $this->load->model('General_Model');


        $datos = array('estatus' => 1);

        $tabla = "menus_departamento";

        $condicion = array('idsubmenu' => $data_post["subx"], 'iddepa' => $data_post["ideptx"]);

        $update = $this->General_Model->updateERP($datos, $tabla, $condicion);


        echo json_encode($update);
    }

    public function AgregaNvoSubmenu()
    {

        $data_post = $this->input->post();


        $table = "menus_departamento";

        $condicion = array('iddepa' => $data_post['iddepartamentox'], 'idsubmenu' => $data_post['idsubmenux'], 'estatus' => 0);

        $repeat = $this->General_Model->verificarRepeat($table, $condicion);

        if ($repeat > 0) {

            echo json_encode(0);
        } else {



            $data = array(

                'iddepa' => $data_post['iddepartamentox'],
                'idsubmenu' => $data_post['idsubmenux'],
                'estatus' => 0

            );

            echo json_encode($this->General_Model->altaERP($data, $table));
        }
    }
}
