<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class Ajustesalida extends CI_Controller

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





        $numero_menu = 28;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



            $dmenu["nommenu"] = "ajuste_salida";

            

           

            if($iduser > 0){



                $this->load->view('general/header');

                $this->load->view('general/css_autocompletar');

                $this->load->view('general/css_datatable');

                $this->load->view('general/menuv2');

                $this->load->view('general/css_select2');

                $this->load->view('general/css_upload');

                $this->load->view('general/menu_header',$dmenu);

                $this->load->view('salidas/body_ajustexsalida');

                $this->load->view('general/footer');

                $this->load->view('salidas/acciones_ajustexsalida');



            }else{



                redirect("Login");



            }



        }else{



            redirect('AccesoDenegado');



        }

       

    }



    public function showProveedor(){



        $query="SELECT id,nombre,rfc FROM alta_proveedores WHERE estatus = 0 ORDER BY nombre ASC";



            echo json_encode( $this->General_Model->infoxQuery($query) );



    }

    public function showUsers(){



        $query="SELECT id,nombre,correo FROM alta_usuarios WHERE estatus = 0 ORDER BY nombre ASC";



            echo json_encode( $this->General_Model->infoxQuery($query) );



    }


    public function retirarParte(){

        $data_post = $this->input->post();

        $condicion = array( 'id' => $data_post["idpcot"] );

        $tabla="temporal_partes_ajuste_salida";

        $delete=$this->General_Model->deleteERP($tabla,$condicion);


        echo json_encode( $delete );

    }



    public function ingresarPartidas(){
        
        $data_post = $this->input->post();        


        $condicion1 =   array(



                            'idusuario' => $data_post['iduser'], 

                            'idparte' => $data_post['idparte'], 

                            'estatus' => 0

        );



        $tabla1 = "temporal_partes_ajuste_salida";

        $repeat = $this->General_Model->verificarRepeat($tabla1,$condicion1);

        if ( $repeat == 0 ) {


            $subtotal_final=round($data_post["cproveedor"],2)*round($data_post["cantidad"],2);

            if ( $data_post['iva'] > 0 ) {

                    //$valor_iva = $data_post['iva']/100;

                    //$total_partida = round($subtotal_desc,2)+round( ( round($subtotal_desc,2)*$valor_iva ),2 );



                    $valor_iva=($data_post["iva"]/100)+1;

                    $total_partida=round($subtotal_final,2)*round($valor_iva,2);



            }else{


                    $total_partida = round($subtotal_final,2);



            }

            $iva = round($total_partida,2)-round($subtotal_final,2);


            $data = array(



                    'fecha' => date("Y-m-d"),

                    'idusuario' => $data_post['iduser'],

                    'idparte' => $data_post['idparte'],

                    'cantidad' => $data_post['cantidad'],

                    'costo' => $data_post['cproveedor'],

                    'iva' => $data_post['iva'],

                    'tot_iva' => $iva,

                    'tot_total' => $total_partida,

                    //'motivo' => $data_post['motivo']

                );



            $table = "temporal_partes_ajuste_salida";



            $last_id=$this->General_Model->altaERP($data,$table);


        }else{

            $last_id = 0;

        }


        echo json_encode( $last_id );

    }


    public function finalizarAjuste(){

        $data_post = $this->input->post();

        /////////verificar repeat

        $rcondicion=array('idusuario'=>$data_post["iduser"]);
        $rtabla="temporal_partes_ajuste_salida";

        $repeat=$this->General_Model->verificarRepeat($rtabla,$rcondicion);

        if ($repeat>0) {

            $data = array(

                        'fecha' => date("Y-m-d"),

                        'hora' => date("H:i:s"),
                
                        'idusuario' => $data_post["iduser"],

                        //'idproveedor' => $data_post["idpro"],

                        'observaciones' => $data_post["obsx"],

                        'documento' => $data_post["docx"],


                    );

            $table = "alta_ajuste_salida";

            $last_id=$this->General_Model->altaERP($data,$table);

            if ( $last_id > 0 ) {

                $sqlx = "SELECT id,fecha,idusuario,idparte,cantidad,costo,iva,tot_iva,tot_total,estatus FROM `temporal_partes_ajuste_salida` WHERE idusuario=".$data_post['iduser']." AND estatus=0";

                $partes = $this->General_Model->infoxQuery($sqlx);

                $subtotalx=0;
                $ivax=0;
                $totalx=0;

                foreach ($partes as $row) {

                    $data3 = array( 

                                    'idajuste' => $last_id, 
                                    'idparte' => $row->idparte,
                                    'cantidad' => $row->cantidad,
                                    'costo' => $row->costo, 
                                    'iva' => $row->iva, 
                                    'tot_iva' => $row->tot_iva,
                                    'tot_total' => $row->tot_total,
                                    
                                    
                                );

                    $table3 = "partes_ajuste_salida";
                    $this->General_Model->altaERP($data3,$table3);

                    $subtotalx=$subtotalx+$row->costo;
                    $ivax=$ivax+$row->iva;
                    $totalx=$totalx+$row->tot_total;

                }


                //////// ACTUALIZAR LOS TOTALES DEL AJUSTE

                $udatos=array('subtotal'=>$subtotalx,'iva'=>$ivax,'total'=>$totalx );
                $utabla="alta_ajuste_salida";
                $ucondicion=array('id'=>$last_id);

                $this->General_Model->updateERP($udatos,$utabla,$ucondicion);

                /////////// ELIMINAR LAS PARTIDAS DEL TEMPORAL

                $condicion4 = array('idusuario' => $data_post["iduser"] );

                $tabla4 = "temporal_partes_ajuste_salida";

                $this->General_Model->deleteERP($tabla4,$condicion4);

                echo json_encode($last_id);


            }else{

                echo json_encode(0);

            }

        }else{

            echo json_encode(1);

        }

    }


    public function loadPartidas()

        {

            $data_get=$this->input->get();

            $iduser = $data_get["iduser"];

            $data = array();
            $pregunta = array();

                $sql= "SELECT a.id,b.nparte AS clave,

                CONCAT_WS(' ',b.clave,b.descripcion,d.marca) AS descrip, c.descripcion AS unidad, a.costo, a.iva,a.cantidad,a.idparte,a.tot_iva,a.tot_total

                FROM temporal_partes_ajuste_salida a, alta_productos b, sat_catalogo_unidades c, alta_marca d

                WHERE a.idparte=b.id

                AND b.idunidad=c.id

                AND b.idmarca = d.id

                AND a.idusuario = ".$iduser."

                AND a.estatus = 0";

                $datos=$this->General_Model->infoxQuery($sql);

                if ($datos!=null) {
                    
                    foreach ($datos as $row) {

                        //$separar=explode("/",$row->acciones);
                       
                        $pregunta[] = array(

                            'ID'=>$row->id,
                            'ACCION'=>'<button class="btn btn-red" type="button" class="form-control" onclick="retirarParte('.$row->id.')" ><i class="fa fa-trash"></i></button>',
                            
                            'CANTIDAD'=>$row->cantidad,
                            'CLAVE'=>$row->clave,
                            'DESCRIPCION'=>$row->descrip,
                            'UM'=>$row->unidad,
                            'PRECIO'=>wims_currency($row->costo),
                            'IVA'=>$row->iva,
                            'SUBTOTAL'=>wims_currency($row->tot_total),
                            'IDX'=>$row->id,
                            'COSTOX'=>$row->costo,
                            'IDPARTEX'=>$row->idparte,
                            'SUBX'=>$row->tot_total,
                            'IVAX'=>$row->tot_iva,

                        );

                    }

                }


                $data = array("data"=>$pregunta);
                header('Content-type: application/json');
                echo json_encode($data);


        }




}

