<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class AltaOc extends CI_Controller

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



        $numero_menu = 16;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



            if($iduser > 0){



                $data["idusuario"]= $iduser;

                //$mensaje['verificacion'] = "Ingreso correctamente por cookie";

                $nom_menu["nommenu"] = "alta_occ";



                $this->load->view('general/header');

                $this->load->view('general/menuv2');

                $this->load->view('general/css_select2');

                $this->load->view('general/css_datatable');

                $this->load->view('general/menu_header',$nom_menu);

                $this->load->view('compras/alta_occ');

                $this->load->view('general/footer');

                $this->load->view('compras/acciones_alta_occ');



            }else{

           

                redirect("Login");

                

            }



        }else{



            redirect('AccesoDenegado');



        }

       

    }



    public function cancelarOrden(){



        $data_post=$this->input->post();



        /////////////no hay que verificar por que las partidas de entrada tiene odc y falta validar el id de entrada



            $condicion = array('idoc'=>$data_post["odcx"], 'identrada>'=>0 );

            $tabla="partes_entrada";

            $verificar=$this->General_Model->verificarRepeat($tabla,$condicion);



            if ( $verificar>0 ) {



                //el articulo tiene entradas

                echo json_encode(0);



            }else{



                //borramos entrada

                $condicion2 = array('idoc'=>$data_post["odcx"]);

                $tabla2="partes_entrada";

                $this->General_Model->deleteERP($tabla2,$condicion2);



                ////cambiamos el estatus de la odc 

                $datos3 = array('estatus' => 2 );

                $condicion3 = array('id'=>$data_post["odcx"]);

                $tabla3="alta_oc";

                $this->General_Model->updateERP($datos3,$tabla3,$condicion3);



                /// regresamos las partidas a asignar

                $datos4 = array('idproveedor' => 1,'idoc'=>0 );

                $condicion4 = array('idoc'=>$data_post["odcx"]);

                $tabla4="partes_asignar_oc";

                $this->General_Model->updateERP($datos4,$tabla4,$condicion4);



                echo json_encode(1);



            }



    }


    public function retirarParte(){

        $data_post=$this->input->post();

        ////cambiamos el estatus de la odc 
        $udatos3 = array('estatus' => 2);

        $ucondicion3 = array('id'=>$data_post["idparte_asignarx"]);

        $utabla3="partes_oc";

        $actualizacion=$this->General_Model->updateERP($udatos3,$utabla3,$ucondicion3);

        if($actualizacion) {
            
            ////cambiamos el estatus y cantidad de solicitasdas en la asignacion de proveedor 

            $udatos4 = array('estatus' => 0);

            $ucondicion4 = array('id'=>$data_post["idparte_asignacion_prov"]);

            $utabla4="partes_costos_asignar";

            $this->General_Model->updateERP($udatos4,$utabla4,$ucondicion4);

        }

        echo json_encode();

    }





    ///////////****************TABLA PARTIDAS BITACORA



        public function loadPartidas()
        {

            $iduser = $this->session->userdata('iduserformato');
            $data_get = $this->input->get();

            $table = "(SELECT po.id AS id, CONCAT(ap.nombre,' - ',ap.comercial) AS proveedor, app.descripcion AS descripcion,
                        po.cantidad AS cantidad, po.costo AS costo, po.iva AS iva, po.precio AS precio, po.descuento AS descuento,(po.cantidad*po.costo) AS subtotalx,po.idpartecosto
                        FROM partes_oc po, alta_proveedores ap, alta_productos app
                        WHERE ap.id = po.idproveedor
                        AND app.id = po.idparte
                        AND po.estatus = 0
                        AND po.idproveedor ='".$data_get['proveedor']."')temp"; 

            // Primary key of table

            $primaryKey = 'id';            
            $columns = array(

                array( 'db' => 'id',     'dt' => 0,
                        'formatter' => function( $d, $row ) {
                            $boton='<div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">                                      
                                        <li><a href="javascript:retirarParte('.$d.')" style="color:red; font-weight:bold;"><i class="fa fa-close" style="color:red; font-weight:bold;"></i> Retirar partida</a></li>
                                      </ul>
                                    </div>';
                            return $boton;
                        }  
                ),

                

                array( 'db' => 'descripcion',     'dt' => 1,
                        'formatter' => function( $d, $row ) {
                            return $d;
                        }  
                ),

                array( 'db' => 'cantidad',     'dt' => 2 ),

                array( 'db' => 'costo',     'dt' => 3,
                        'formatter' => function( $d, $row ) {
                            return wims_currency($d);
                        } 
                ),        
                array( 'db' => 'descuento',     'dt' => 4,
                        'formatter' => function( $d, $row ) {
                            return $d;
                        }  
                ),
                array( 'db' => 'iva',     'dt' => 5,
                        'formatter' => function( $d, $row ) {
                            return $d;
                        }  
                ),
                array( 'db' => 'subtotalx',     'dt' => 6,
                        'formatter' => function( $d, $row ) {
                            return wims_currency($d);
                        }  
                ),
                array( 'db' => 'id',     'dt' => 7,
                        'formatter' => function( $d, $row ) {
                            return ($d);
                        }  
                ),

                array( 'db' => 'idpartecosto',     'dt' => 8,
                        'formatter' => function( $d, $row ) {
                            return ($d);
                        }  
                )
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

        public function showProveedor()
        {
            $query = "SELECT ap.id, ap.nombre, ap.comercial, ap.rfc,ap.dias 
            FROM alta_proveedores ap, partes_oc po
                WHERE ap.id = po.idproveedor 
                AND ap.estatus = 0 AND po.estatus = 0 GROUP BY ap.id ORDER BY ap.nombre ASC";
            echo json_encode($this->General_Model->infoxQuery($query));
        }

        public function finalizarOc(){

            $data_post = $this->input->post();
    
            $subtotal = ($data_post["subtotal"]);
            $descuento = ($data_post["descuento"]);
            $iva = ($data_post["iva"]);
            $total = ($data_post["total"]);
    
            /*
            echo($subtotal);
            echo($descuento);
            echo($iva);
            echo($total);*/
    
            $data = array(
                    'fecha' => date("Y-m-d"),
                    'fentrega' => $data_post["entrega"],
                    'hora' => date("H:i:s"),
                    'idusuario' => $data_post["iduser"],
                    'idpro' => $data_post["idpro"],
                    'observaciones' => changeString($data_post["obs"]),
                    'moneda' => 1,
                    'dias' => $data_post["dias"],
                    'subtotal' => $subtotal,
                    'descuento' => $descuento,
                    'iva' => $iva,
                    'total' => $total,
                    );
    
            $table = "alta_oc";
            $last_id=$this->General_Model->altaERP($data,$table);
    
            if ( $last_id > 0 ) {      
                // id oc es la id de la alta_oc  idoc = $last_id

                //////////// CAMBIAMOS EL ESTATUS DE LAS PARTIDAS DE PARTES_OC QUE YA TENGAN ODC ASIGNADA -------- 1  


                $upData= array('estatus' => 1, 'idoc' => $last_id);
                $upTable = "partes_oc";        
                $upCondition = array('idproveedor'=>$data_post["idpro"], 'estatus'=>0 );                    
                $this->General_Model->updateERP($upData,$upTable,$upCondition);

                echo json_encode($last_id);
            }else{
                echo json_encode(0);
            }
        }

}