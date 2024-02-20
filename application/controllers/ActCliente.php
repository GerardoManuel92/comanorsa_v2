<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ActCliente extends CI_Controller
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

    public function editcliente()
    {
        $iduser = $this->session->userdata(IDUSERCOM);
        $idcliente = $this->uri->segment(3);

        $numero_menu = 8;//igual al alta de clientes

        ////////******* verificar menu 

        $vtabla = "menus_departamento";
        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);
        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);

        if ( $verificar_menu > 0 ) {
       
            if($iduser > 0){

                $sql = "SELECT a.id,a.nombre, a.comercial, a.rfc, b.calle, b.exterior, b.interior, b.colonia, b.municipio, b.estado, b.cp, b.referencia, a.descuento, a.credito, a.limite, a.idfpago, a.idcfdi, a.idregimen, a.descuento, a.credito, a.limite
                    FROM alta_clientes a
                    LEFT JOIN direccion_clientes b ON b.idcliente=a.id
                    WHERE a.id =".$idcliente;

                $info = array( 'info_cliente' => $this->General_Model->infoxQueryUnafila($sql) );

                $dmenu["nommenu"] = "act_clientes";

                $this->load->view('general/header');
                $this->load->view('general/css_select2');
                $this->load->view('general/css_datatable');
                $this->load->view('general/menuv2');
                $this->load->view('general/menu_header',$dmenu);
                $this->load->view('cliente/actualizar_cliente',$info);
                $this->load->view('general/footer');
                $this->load->view('cliente/acciones_actualizar_cliente',$info);

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
            AND a.iddepartamento = 2
            AND a.estatus = 0";

            echo json_encode( $this->General_Model->infoxQuery($sql) );

    }

    public function showDirecciones(){

        $data_post = $this->input->post();

        $sql = "SELECT a.id,a.calle, a.exterior, a.interior, a.colonia, a.municipio, a.estado, a.cp, a.referencia,a.credito,a.descuento,a.limite FROM direccion_clientes a WHERE a.idcliente =".$data_post['idcliente'];

        echo json_encode( $this->General_Model->infoxQuery($sql) );

    }

    public function vRfc(){

        $data_post = $this->input->post();

        $condicion = array('rfc' => $data_post["rfc"], 'estatus' => 0, 'id!=' => $data_post["idcliente"] );
        $tabla = "alta_clientes";

        echo json_encode(  $this->General_Model->verificarRepeat($tabla,$condicion) );


    }


    public function actCli(){

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
            'descuento' => $data_post['descuento'],
            'credito' => $data_post['credito'],
            'limite' => $data_post['limite'],
            'idregimen' => $data_post['regimenx'],
            'fecha_actualizacion' => date('Y-m-d')." ".date('H:i:s')

        );

        $table = "alta_clientes";

        $condicion = array('id' => $data_post['idcliente']);

        //$last_id = $this->General_Model->altaERP($data,$table);
        $update = $this->General_Model->updateERP($datos,$table,$condicion);

        if ( $update ) {
            
            ///**** borramos los contactos del cliente
            $table2 = "contactos_erp";
            $dcondicion = array('iduser' => $data_post['idcliente'], 'iddepartamento' => 2);

            $delete = $this->General_Model->deleteERP($table2,$dcondicion);

            if ( $data_post['contactox'] != "" or $data_post['contactox'] != null ) {
                # code...
               
                $array_sep =explode(",",$data_post['contactox']);

                if ( count($array_sep) > 0 ) {

                    
                    ///**** insertamos los contactos
                    for ($i=0; $i <count($array_sep); $i++) { 

                        //// 2da separacion 

                        $separar = explode("||", $array_sep[$i]);
                        
                        $data2 = array(

                            'fecha' => date("Y-m-d"),
                            'iddepartamento' => '2',
                            'iduser' => $data_post['idcliente'],
                            'nombre' => $separar[0],
                            'puesto' => $separar[1],
                            'telefono' => $separar[2],
                            'correo' => $separar[3]

                        );

                        $this->General_Model->altaERP($data2,$table2);

                    }

                } 

            }



            //**** borramos las direcciones del cliente
            $table2 = "direccion_clientes";
            $dcondicion = array('idcliente' => $data_post['idcliente']);

            $delete = $this->General_Model->deleteERP($table2,$dcondicion);

                    //////*********** añadir direcciones

                    //$array_sep3 =explode(",",$data_post['direccionex']);
                    $table3 = "direccion_clientes";

                    $data3=array(

                        'fecha' => date("Y-m-d"),

                        'idcliente' => $last_id,

                        'calle'=> $data_post['calle'],
                        'exterior'=> $data_post['exterior'],
                        'interior'=> $data_post['interior'],
                        'colonia' => $data_post['colonia'],
                        'municipio' => $data_post['municipio'],
                        'estado' => $data_post['estado'],
                        'cp' => $data_post['cp'],
                        'referencia'=> $data_post['referencia']

                    );

                    $this->General_Model->altaERP($data3,$table3);

                    /*for ($i=0; $i <count($array_sep3); $i++) { 

                        //// 2da separacion 

                        $separar3 = explode("||", $array_sep3[$i]);
                        
                        $data3 = array(

                            'fecha' => date("Y-m-d"),
                            'idcliente' => $data_post['idcliente'],
                            'calle' => $separar3[0],
                            'exterior' => $separar3[1],
                            'interior' => $separar3[2],
                            'colonia' => $separar3[3],
                            'municipio' => $separar3[4],
                            'estado' => $separar3[5],
                            'cp' => $separar3[6],
                            'referencia' => $separar3[7],
                            
                            'fecha_actualizacion' => date("Y-m-d")

                        );

                        $this->General_Model->altaERP($data3,$table3);

                    }*/

        }


        echo json_encode( $update );

    }



    public function Actmarca(){

       $data_post = $this->input->post();


        $table = "alta_marca";
        $condicion = array( 'marca' => $data_post['marca'], 'estatus' => 0, 'id!=' => $data_post['idmarca'] );

        $repeat = $this->General_Model->verificarRepeat($table,$condicion);

        if ( $repeat > 0) {
            
            echo json_encode(0);

        }else{

            $datos = array(

            'marca' => $data_post['marca']
            
            );

            $condicion = array('id' => $data_post['idmarca'] );


            echo json_encode( $this->General_Model->updateERP($datos,$table,$condicion) );

        } 

    }



}