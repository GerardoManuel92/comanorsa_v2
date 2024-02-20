<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Actproveedor extends CI_Controller
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
    }

    public function edit()
    {
        $iduser = $this->session->userdata(IDUSERCOM);
        $idpro = $this->uri->segment(3);

        $numero_menu = 3;//igual al alta de proveedor

        ////////******* verificar menu 

        $vtabla = "menus_departamento";
        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);
        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);

        if ( $verificar_menu > 0 ) {
       
            if($iduser > 0){

                $sql = "SELECT a.nombre,a.comercial,a.rfc,a.estatus,a.calle, a.exterior, a.interior, a.colonia, a.municipio, a.estado, a.cp, a.referencia,a.idfpago, a.idcfdi
                        FROM alta_proveedores a
                        WHERE 
                        a.id =".$idpro;

                $info = array( 'info_pro' => $this->General_Model->infoxQueryUnafila($sql), 'idpro' => $idpro );

                $dmenu["nommenu"] = "act_pro";

                $this->load->view('general/header');
                $this->load->view('general/css_datatable');
                $this->load->view('general/menuv2');
                $this->load->view('general/menu_header',$dmenu);
                $this->load->view('proveedor/actualizar_proveedor',$info);
                $this->load->view('general/footer');
                $this->load->view('proveedor/acciones_actualizar_proveedor',$info);

            }else{

                redirect("Login");

            }
        }else{

            redirect('AccesoDenegado');

        } 
       
    }


    public function showContactos(){

        $data_post = $this->input->post();

        $sql = "SELECT a.id, a.nombre, a.puesto, a.telefono, a.correo
            FROM contactos_erp a
            WHERE 
            a.iduser = ".$data_post['idcliente']."
            AND a.iddepartamento = 1
            AND a.estatus = 0";

            echo json_encode( $this->General_Model->infoxQuery($sql) );

    }

    public function vRfc(){

        $data_post = $this->input->post();

        $condicion = array('rfc' => $data_post["rfc"], 'estatus' => 0, 'id!=' => $data_post["pro"] );
        $tabla = "alta_proveedores";

        echo json_encode(  $this->General_Model->verificarRepeat($tabla,$condicion) );


    }

    public function altaPro(){

        $data_post = $this->input->post();

        $datos = array(

            'fecha' => date('Y-m-d'),
            'nombre' => $data_post['nombre'],
            'comercial' => $data_post['comercial'],
            'rfc' => $data_post['rfc'],
            'calle'=> $data_post['calle'],
            'exterior'=> $data_post['exterior'],
            'interior'=> $data_post['interior'],
            'colonia' => $data_post['colonia'],
            'municipio' => $data_post['municipio'],
            'estado' => $data_post['estado'],
            'cp' => $data_post['cp'],
            'referencia'=> $data_post['referencia'],
            'idfpago'=> $data_post['idfpago'],
            'idcfdi'=> $data_post['idcfdi'],
            'fecha_actualizacion' => date("Y-m-d")

        );

        $tabla = "alta_proveedores";
        $condicion = array('id' => $data_post["idpro"]);

        $update = $this->General_Model->updateERP($datos,$tabla,$condicion);

        //////////****** INSERTAR TAGS

        if ( $update ) {
            
            ///**** borramos los contactos del cliente
            $table2 = "contactos_erp";
            $dcondicion = array('iduser' => $data_post['idpro'], 'iddepartamento' => 2);

            $delete = $this->General_Model->deleteERP($table2,$dcondicion);

            if ( $data_post['contactox'] != "" or $data_post['contactox'] != null ) {
                
                # code...
            
                $array_sep =explode(",",$data_post['contactox']);

                if ( count($array_sep) > 0 ) {


                    $table2 = "contactos_erp";

                    for ($i=0; $i <count($array_sep); $i++) { 

                        //// 2da separacion 

                        $separar = explode("||", $array_sep[$i]);
                        
                        $data2 = array(

                            'fecha' => date("Y-m-d"),
                            'iddepartamento' => '1',
                            'iduser' => $data_post['idpro'],
                            'nombre' => $separar[0],
                            'puesto' => $separar[1],
                            'telefono' => $separar[2],
                            'correo' => $separar[3]

                        );

                        $this->General_Model->altaERP($data2,$table2);

                    }

                }

            }

        }

        echo json_encode( $update );

    }



}