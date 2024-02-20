<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class AltaFactura extends CI_Controller

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



        $numero_menu = 10;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



            $dmenu["nommenu"] = "nfactura";

        

       

            if($iduser > 0){



                $this->load->view('general/header');

                $this->load->view('general/css_select2');

                $this->load->view('general/css_autocompletar');

                $this->load->view('general/css_upload');

                //$this->load->view('general/css_xedit');

                $this->load->view('general/css_date');

                $this->load->view('general/css_datatable');

                $this->load->view('general/menuv2');

                $this->load->view('general/menu_header',$dmenu);

                $this->load->view('facturas/alta_factura');

                $this->load->view('general/footer');

                $this->load->view('facturas/acciones_alta_factura');



            }else{



                redirect("Login");



            } 



        }else{



            redirect('AccesoDenegado');



        }

       

    }



    public function showCliente(){



        $query="SELECT id,rfc,nombre,comercial FROM `alta_clientes` WHERE estatus = 0 ORDER BY nombre ASC";



            echo json_encode( $this->General_Model->infoxQuery($query) );



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





    public function ingresarPartidas(){



        $data_post = $this->input->post();



        $condicion1 =   array(



                            'idusuario' => $data_post['iduser'], 

                            'idparte' => $data_post['idparte'], 

                            'estatus' => 0

                        );



        $tabla1 = "temporal_partes_nueva_factura";

        $repeat = 0;//$this->General_Model->verificarRepeat($tabla1,$condicion1);



        if ( $repeat == 0 ) {



            ////////********* ORDEN

            $sql="SELECT COUNT(id) AS total FROM `temporal_partes_nueva_factura` WHERE idusuario = ".$data_post['iduser']." AND estatus = 0";

            $last_orden = $this->General_Model->infoxQueryUnafila($sql);







                //////************** CALCULAR VALORES FALTANTES 



                $subtotal = round($data_post['cantidad'],2)*round($data_post['costo'],2);



                if ( $data_post['descuento'] > 0 ) {

                    

                    $subtotal_desc = round($subtotal,2)-round( ( round($subtotal,2)*($data_post['descuento']/100) ),2 );



                }else{



                    $subtotal_desc = $subtotal;



                }



                

                $total_descuento = round($subtotal,2)-round($subtotal_desc,2);



                if ( $data_post['iva'] > 0 ) {

                    

                    $valor_iva = $data_post['iva']/100;

                    $total_partida = round($subtotal_desc,2)+round( ( round($subtotal_desc,2)*$valor_iva ),2 );





                    //$iva =round( ( round($subtotal_desc,2)*($data_post['iva']/100) ),2 );



                }else{



                    $total_partida = round($subtotal_desc,2);



                    //$iva =0;



                }



                



                //$total_partida = round( (round($subtotal_desc,2)+$iva),2 );



                $iva = round($total_partida,2)-round($subtotal_desc,2);









            

                $data = array(



                    'orden' => $last_orden->total+1,

                    'idusuario' => $data_post['iduser'],

                    'idparte' => $data_post['idparte'],

                    'cantidad' => $data_post['cantidad'],

                    'costo' => $data_post['costo'],

                    'costo_proveedor' => $data_post['cproveedor'],

                    'iva' => changeString($data_post['iva']),

                    'descuento' => $data_post['descuento'],

                    'descripcion'=> changeString($data_post['descripx']),

                    'riva' => $data_post['rivax'],

                    'risr' => $data_post['risrx'],

                    'tcambio' => $data_post['tcambiox'],

                    'utilidad' => $data_post['utilidadx'],



                    'tot_subtotal' => $subtotal,

                    'tot_descuento' => $total_descuento,

                    'tot_iva' => $iva,

                    'tot_total' => $total_partida



               

                );



            $table = "temporal_partes_nueva_factura";



            $last_id=$this->General_Model->altaERP($data,$table);



        }else{



            $last_id = 0;



        }



        

        echo json_encode( $last_id );



    }



    public function actualizarPartidas(){



        $data_post = $this->input->post();



            

                $datos = array(



                    'idusuario' => $data_post['iduser'],

                    'idparte' => $data_post['idparte'],

                    'cantidad' => $data_post['cantidad'],

                    'costo' => $data_post['costo'],

                    'iva' => changeString($data_post['iva']),

                    'descuento' => $data_post['descuento']

               

                );

                $condicion = array(



                    'id' => $data_post["idpcot"] 



                );



            $tabla = "temporal_partes_nueva_factura";



            $last_id=$this->General_Model->updateERP($datos,$tabla,$condicion);



        echo json_encode( $last_id );



    }





    public function retirarParte(){



        $data_post = $this->input->post();

        $resultado = 0;



        $condicion = array( 'id' => $data_post["idpcot"] );

        $tabla="temporal_partes_nueva_factura";



        $delete=$this->General_Model->deleteERP($tabla,$condicion);



        if ( $delete ) {

            

            $sql="UPDATE temporal_partes_nueva_factura SET `orden` = `orden`-1 WHERE orden > ".$data_post['ordenx']." AND idusuario=".$data_post['idusuario'];



            $this->General_Model->infoxQueryUpt($sql);



            $resultado = 1;



        }else{



            $resultado = 0;



        }



        echo json_encode( $resultado );



    }



    public function verDatosCli(){



        $data_post = $this->input->post();



        $sql="SELECT a.idfpago,a.idcfdi,a.idregimen,b.credito

            FROM alta_clientes a,direccion_clientes b

            WHERE b.idcliente=a.id

            AND a.id=".$data_post['idclientex'];



       echo json_encode( $this->General_Model->infoxQueryUnafila($sql) );



    }



    /*public function finalizarCotizacion(){



        $data_post = $this->input->post();



        $fechaIni = $data_post["fecha"];

        $inicio=explode("/",$fechaIni);

            $cod=strlen($inicio[1]);

            if($cod==1){

            $inicio[1]="0".$inicio[1];

            }

            

        $fcotizacion = $inicio[2]."-".$inicio[1]."-".$inicio[0];



        $data = array(



                    'fcotizacion' => $fcotizacion,

                    'fecha' => date("Y-m-d"),

                    'hora' => date("H:i:s"),

                    'idusuario' => $data_post["iduser"],

                    'idcliente' => $data_post["idcliente"],

                    'observaciones' => $data_post["obsx"],

                    'moneda' => 1,

                    'tcambio' =>1



                );



        $table = "alta_cotizacion";



        $last_id=$this->General_Model->altaERP($data,$table);



        if ( $last_id > 0 ) {

            

            

            $sqlx = "SELECT idparte,cantidad,costo,iva,descuento,descripcion,orden,costo_proveedor,riva,risr,tcambio,utilidad,tot_subtotal,tot_descuento,tot_iva,tot_total FROM temporal_partes_nueva_factura WHERE idusuario=".$data_post["iduser"]." AND estatus = 0 ORDER BY orden ASC";



            //$partes = $this->General_Model->SelectsinOrder($data2,$tabla2,$condicion2);

            $partes = $this->General_Model->infoxQuery($sqlx);



            foreach ($partes as $row) {



                $data3 = array( 'idcotizacion' => $last_id, 'idparte' => $row->idparte, 'costo_proveedor' => $row->costo_proveedor,'cantidad' => $row->cantidad, 'costo' => $row->costo, 'iva' => $row->iva, 'descuento' => $row->descuento, 'descripcion' => $row->descripcion, 'orden' => $row->orden, 'riva' =>$row->riva, 'risr' =>$row->risr,'tcambio' => $row->tcambio, 'utilidad' => $row->utilidad, 'tot_subtotal' =>$row->tot_subtotal, 'tot_descuento' =>$row->tot_descuento, 'tot_iva' =>$row->tot_iva, 'tot_total' => $row->tot_total);



                $table3 = "partes_cotizacion";



                $this->General_Model->altaERP($data3,$table3);



            }





            $condicion4 = array('idusuario' => $data_post["iduser"] );

            $tabla4 = "temporal_partes_nueva_factura";



            $this->General_Model->deleteERP($tabla4,$condicion4);



            echo json_encode($last_id);



        }else{



            echo json_encode(0);



        }



    }*/





    public function porcientoAll(){



        $data_post = $this->input->post();

        $idusuariox = trim($data_post["idusuario"]);



        $sql="SELECT id,cantidad,costo_proveedor,costo,iva,utilidad,descuento FROM `temporal_partes_nueva_factura` WHERE idusuario=".$idusuariox;

        $partes = $this->General_Model->infoxQuery($sql);



        $total_partida = 0;



        foreach ($partes as $row) {





            if ( $data_post["gutilidad"] >= 0 AND $data_post["gdescuento"] >= 0 ) {



                



                if ( $data_post["gutilidad"] > 0 ) {

                    

                    $porcientoutil = $data_post["gutilidad"]/100;

                    $utilidad_valor= round($data_post["gutilidad"],2);

                    $precio = round($row->costo_proveedor,2)+round( (round($row->costo_proveedor,2)*$porcientoutil),2 );



                }else{



                    $porcientoutil = $row->utilidad/100;

                    $utilidad_valor= $row->utilidad;

                    $precio = $row->costo;



                }





                $subtotal = round($row->cantidad,2)*round($precio,2);



                if ( $data_post["gdescuento"] > 0 ) {

                    

                    $porcientodesc = $data_post["gdescuento"]/100;

                    $descuento_valor=$data_post["gdescuento"];

                    $subtotal_desc = round($subtotal,2)-round( ( round($subtotal,2)*($porcientodesc) ),2 );

                    $total_descuento = round($subtotal,2)-round($subtotal_desc,2);



                }else{



                    $porcientodesc = $row->descuento/100;

                    $descuento_valor=$row->descuento;

                    $subtotal_desc = round($subtotal,2)-round( ( round($subtotal,2)*($porcientodesc) ),2 );

                    $total_descuento = round($subtotal,2)-round($subtotal_desc,2);



                }



                ////////******** CALCULO DE DESCUENTOS 



                if ( $row->iva > 0 ) {

                    

                    $valor_iva = $row->iva/100;

                    $total_partida = round($subtotal_desc,2)+round( ( round($subtotal_desc,2)*$valor_iva ),2 );



                }else{



                    $total_partida = round($subtotal_desc,2);



                    //$iva =0;



                }



                //$total_partida = round( (round($subtotal_desc,2)+$iva),2 );



                $iva = round($total_partida,2)-round($subtotal_desc,2);



                $datos = " costo=".round($precio,2).", descuento=".$descuento_valor.", utilidad=".$utilidad_valor.", tot_subtotal=".$subtotal.", tot_descuento=".$total_descuento.", tot_iva=".$iva.", tot_total=".$total_partida;







            }elseif ( $data_post["gutilidad"] >= 0 ) {



                if ( $data_post["gutilidad"] > 0 ) {

                    

                    $porcientoutil = $data_post["gutilidad"]/100;

                    $utilidad_valor= round($data_post["gutilidad"],2);

                    $precio = round($row->costo_proveedor,2)+round( (round($row->costo_proveedor,2)*$porcientoutil),2 );



                }else{



                    $porcientoutil = $row->utilidad/100;

                    $utilidad_valor= $row->utilidad;

                    $precio = $row->costo;

                }





                $subtotal = round($row->cantidad,2)*round($precio,2);



                /////****** DESCUENTO



                $porcientodesc = $row->descuento/100;

                $descuento_valor=$row->descuento;

                $subtotal_desc = round($subtotal,2)-round( ( round($subtotal,2)*($porcientodesc) ),2 );

                $total_descuento = round($subtotal,2)-round($subtotal_desc,2);



                if ( $row->iva > 0 ) {

                    

                    $valor_iva = $row->iva/100;

                    $total_partida = round($subtotal_desc,2)+round( ( round($subtotal_desc,2)*$valor_iva ),2 );



                }else{



                    $total_partida = round($subtotal_desc,2);



                    //$iva =0;



                }



                $iva = round($total_partida,2)-round($subtotal_desc,2);



                $datos = " costo=".round($precio,2).", descuento=".$descuento_valor.", utilidad=".$utilidad_valor.", tot_subtotal=".$subtotal.", tot_descuento=".$total_descuento.", tot_iva=".$iva.", tot_total=".$total_partida;





            }elseif (  $data_post["gdescuento"] >= 0  ) {





                $porcientoutil = $row->utilidad/100;

                $utilidad_valor= $row->utilidad;

                $precio = $row->costo;



                $subtotal = round($row->cantidad,2)*round($precio,2);

                

                if ( $data_post["gdescuento"] > 0 ) {

                    

                    $porcientodesc = $data_post["gdescuento"]/100;

                    $descuento_valor=$data_post["gdescuento"];

                    $subtotal_desc = round($subtotal,2)-round( ( round($subtotal,2)*($porcientodesc) ),2 );

                    $total_descuento = round($subtotal,2)-round($subtotal_desc,2);



                }else{



                    $porcientodesc = $row->descuento/100;

                    $descuento_valor=$row->descuento;

                    $subtotal_desc = round($subtotal,2)-round( ( round($subtotal,2)*($porcientodesc) ),2 );

                    $total_descuento = round($subtotal,2)-round($subtotal_desc,2);



                }



                

                ////////******** CALCULO DE DESCUENTOS 



                if ( $row->iva > 0 ) {

                    

                    $valor_iva = $row->iva/100;

                    $total_partida = round($subtotal_desc,2)+round( ( round($subtotal_desc,2)*$valor_iva ),2 );



                }else{



                    $total_partida = round($subtotal_desc,2);



                    //$iva =0;



                }



                //$total_partida = round( (round($subtotal_desc,2)+$iva),2 );



                $iva = round($total_partida,2)-round($subtotal_desc,2);



                $datos = " costo=".round($precio,2).", descuento=".$descuento_valor.", utilidad=".$utilidad_valor.", tot_subtotal=".$subtotal.", tot_descuento=".$total_descuento.", tot_iva=".$iva.", tot_total=".$total_partida;



            }



            $query = "UPDATE temporal_partes_nueva_factura SET ".$datos." WHERE idusuario=".$idusuariox." AND id=".$row->id;

            $this->General_Model->infoxQueryUpt($query);



        }



        echo json_encode(true);



    }



    public function porcientoFal(){



        $data_post = $this->input->post();

        $idusuariox = trim($data_post["idusuario"]);



        $sql="SELECT id,cantidad,costo_proveedor,costo,iva,utilidad,descuento FROM `temporal_partes_nueva_factura` WHERE idusuario=".$idusuariox;

        $partes = $this->General_Model->infoxQuery($sql);



        $total_partida = 0;



        foreach ($partes as $row) {



            if ( $data_post["gutilidad"] >= 0 AND $data_post["gdescuento"] >= 0 ) {



                



                if ( $data_post["gutilidad"] > 0 ) {

                    

                    $porcientoutil = $data_post["gutilidad"]/100;

                    $utilidad_valor= round($data_post["gutilidad"],2);

                    $precio = round($row->costo_proveedor,2)+round( (round($row->costo_proveedor,2)*$porcientoutil),2 );



                }else{



                    $porcientoutil = $row->utilidad/100;

                    $utilidad_valor= $row->utilidad;

                    $precio = $row->costo;



                }





                $subtotal = round($row->cantidad,2)*round($precio,2);



                if ( $data_post["gdescuento"] > 0 ) {

                    

                    $porcientodesc = $data_post["gdescuento"]/100;

                    $descuento_valor=$data_post["gdescuento"];

                    $subtotal_desc = round($subtotal,2)-round( ( round($subtotal,2)*($porcientodesc) ),2 );

                    $total_descuento = round($subtotal,2)-round($subtotal_desc,2);



                }else{



                    $porcientodesc = $row->descuento/100;

                    $descuento_valor=$row->descuento;

                    $subtotal_desc = round($subtotal,2)-round( ( round($subtotal,2)*($porcientodesc) ),2 );

                    $total_descuento = round($subtotal,2)-round($subtotal_desc,2);



                }



                ////////******** CALCULO DE DESCUENTOS 



                if ( $row->iva > 0 ) {

                    

                    $valor_iva = $row->iva/100;

                    $total_partida = round($subtotal_desc,2)+round( ( round($subtotal_desc,2)*$valor_iva ),2 );



                }else{



                    $total_partida = round($subtotal_desc,2);



                    //$iva =0;



                }



                //$total_partida = round( (round($subtotal_desc,2)+$iva),2 );



                $iva = round($total_partida,2)-round($subtotal_desc,2);



                $datos = " costo=".round($precio,2).", descuento=".$descuento_valor.", utilidad=".$utilidad_valor.", tot_subtotal=".$subtotal.", tot_descuento=".$total_descuento.", tot_iva=".$iva.", tot_total=".$total_partida;







            }elseif ( $data_post["gutilidad"] >= 0 ) {



                if ( $data_post["gutilidad"] > 0 ) {

                    

                    $porcientoutil = $data_post["gutilidad"]/100;

                    $utilidad_valor= round($data_post["gutilidad"],2);

                    $precio = round($row->costo_proveedor,2)+round( (round($row->costo_proveedor,2)*$porcientoutil),2 );



                }else{



                    $porcientoutil = $row->utilidad/100;

                    $utilidad_valor= $row->utilidad;

                    $precio = $row->costo;

                }





                $subtotal = round($row->cantidad,2)*round($precio,2);



                /////****** DESCUENTO



                $porcientodesc = $row->descuento/100;

                $descuento_valor=$row->descuento;

                $subtotal_desc = round($subtotal,2)-round( ( round($subtotal,2)*($porcientodesc) ),2 );

                $total_descuento = round($subtotal,2)-round($subtotal_desc,2);



                if ( $row->iva > 0 ) {

                    

                    $valor_iva = $row->iva/100;

                    $total_partida = round($subtotal_desc,2)+round( ( round($subtotal_desc,2)*$valor_iva ),2 );



                }else{



                    $total_partida = round($subtotal_desc,2);



                    //$iva =0;



                }



                $iva = round($total_partida,2)-round($subtotal_desc,2);



                $datos = " costo=".round($precio,2).", descuento=".$descuento_valor.", utilidad=".$utilidad_valor.", tot_subtotal=".$subtotal.", tot_descuento=".$total_descuento.", tot_iva=".$iva.", tot_total=".$total_partida;





            }elseif (  $data_post["gdescuento"] >= 0  ) {





                $porcientoutil = $row->utilidad/100;

                $utilidad_valor= $row->utilidad;

                $precio = $row->costo;



                $subtotal = round($row->cantidad,2)*round($precio,2);

                

                if ( $data_post["gdescuento"] > 0 ) {

                    

                    $porcientodesc = $data_post["gdescuento"]/100;

                    $descuento_valor=$data_post["gdescuento"];

                    $subtotal_desc = round($subtotal,2)-round( ( round($subtotal,2)*($porcientodesc) ),2 );

                    $total_descuento = round($subtotal,2)-round($subtotal_desc,2);



                }else{



                    $porcientodesc = $row->descuento/100;

                    $descuento_valor=$row->descuento;

                    $subtotal_desc = round($subtotal,2)-round( ( round($subtotal,2)*($porcientodesc) ),2 );

                    $total_descuento = round($subtotal,2)-round($subtotal_desc,2);



                }



                

                ////////******** CALCULO DE DESCUENTOS 



                if ( $row->iva > 0 ) {

                    

                    $valor_iva = $row->iva/100;

                    $total_partida = round($subtotal_desc,2)+round( ( round($subtotal_desc,2)*$valor_iva ),2 );



                }else{



                    $total_partida = round($subtotal_desc,2);



                    //$iva =0;



                }



                //$total_partida = round( (round($subtotal_desc,2)+$iva),2 );



                $iva = round($total_partida,2)-round($subtotal_desc,2);



                $datos = " costo=".round($precio,2).", descuento=".$descuento_valor.", utilidad=".$utilidad_valor.", tot_subtotal=".$subtotal.", tot_descuento=".$total_descuento.", tot_iva=".$iva.", tot_total=".$total_partida;



            }





        



            /*if ( $data_post["gutilidad"] >= 0 ) {



                if ( $data_post["gutilidad"] > 0 ) {

                    

                    $porcientoutil = $data_post["gutilidad"]/100;



                }else{



                    $porcientoutil = 0;



                }



                $datos = "costo=costo_proveedor+(costo_proveedor*".$porcientoutil.")";





            }



            if (  $data_post["gdescuento"] >= 0  ) {

                

                if ( $data_post["gdescuento"] > 0 ) {

                    

                    $porcientodesc = $data_post["gdescuento"];



                }else{



                    $porcientodesc = 0;



                }



                

                $datos2 = " descuento=".$porcientodesc;



            }*/







            /////////*********** ACTUALIZACION DESCUENTO



            /*$query = "UPDATE temporal_partes_nueva_factura SET ".$datos2." WHERE idusuario=".$this->session->userdata(IDUSERCOM)." AND descuento = 0";



            $this->General_Model->infoxQueryUpt($query);



            /////////*********** ACTUALIZACION UTILIDAD



            $query2 = "UPDATE temporal_partes_nueva_factura SET ".$datos." WHERE idusuario=".$this->session->userdata(IDUSERCOM)." AND costo = 0";



            $this->General_Model->infoxQueryUpt($query2);



            if ( $query2 == true OR $query == true ) {

                

                $valor = true;



            }*/





            $query = "UPDATE temporal_partes_nueva_factura SET ".$datos." WHERE idusuario=".$idusuariox." AND id=".$row->id." AND descuento=0 OR idusuario=".$idusuariox." AND id=".$row->id." AND utilidad=0";

            $this->General_Model->infoxQueryUpt($query);



        }



        echo json_encode( true );



    }



    public function cancelarCotizacion(){



        $data_post = $this->input->post();



        $condicion = array( 'idusuario' => $data_post["iduser"] );



        $tabla="temporal_partes_nueva_factura";



        echo json_encode(   $this->General_Model->deleteERP($tabla,$condicion)  );

        

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



        function calcularTotales($pcantidad,$pcosto,$piva,$pdescuento){





            $array_suma = array();



            //////************** CALCULAR VALORES FALTANTES 



                $subtotal = round($pcantidad,2)*round($pcosto,2);



                if ( $pdescuento > 0 ) {

                    

                    $subtotal_desc = round($subtotal,2)-round( ( round($subtotal,2)*($pdescuento/100) ),2 );



                }else{



                    $subtotal_desc = $subtotal;



                }



                

                $total_descuento = $subtotal-$subtotal_desc;



                if ( $piva > 0 ) {

                    

                    $iva =round( ( $subtotal_desc*($piva/100) ),2 );



                }else{



                    $iva =0;



                }



                



                $total_partida = round( ($subtotal_desc+$iva),2 );





                array_push($array_suma, $subtotal,$total_descuento,$iva,$total_partida);





                return $array_suma;





        }



        ////////********** TRAEMOS LOS DATOS DE LA PARTIDA PARA LOS CALCULOS



        $ddata = "cantidad,costo_proveedor,costo,iva,descuento,riva,risr,utilidad,tcambio";

                $dtabla = "temporal_partes_nueva_factura";

                $dcondicion = array('id' => $data_post["idpcot"]);

                $row_partida = $this->General_Model->SelectUnafila($ddata,$dtabla,$dcondicion); 





        switch ( $data_post["columna"] ) {



            case 1:



                if ( $data_post["texto"] > 0 ) {

                    

                    $neworden= $data_post["texto"];

                    $orden_actual= $data_post["ordenx"];

                    //$idcotizacion=;

                    $idparte=$data_post["idpcot"];



                    //////////********* REVISAR QUE EL NUMERO NO SEA MAYOR A LA CANTIDAD DE DATOS EXISTENTES



                    if ( $orden_actual > $neworden ) {

                        

                        //$orden_actual = 4;

                        $limite = $orden_actual-1;

                        //$neworden = 2;

                        //$idcotizacion = 10;



                        $sql="UPDATE temporal_partes_nueva_factura SET `orden` = `orden`+1 WHERE orden BETWEEN ".$neworden." AND ".$limite." AND idusuario=".$this->session->userdata(IDUSERCOM);

                        $update=$this->General_Model->infoxQueryUpt($sql);



                        if ( $update ) {

                             

                            $datos = array('orden' => $neworden );

                            /*$utabla = "temporal_partes_nueva_factura";

                            $ucondicion = array('id' => $idparte );



                            $update2=$this->General_Model->updateERP($udatos,$utabla,$ucondicion);



                            echo json_encode($update2);*/



                         }else{



                            $error = 1;



                         }



                    }else if ( $neworden > $orden_actual) {

                        

                        //$orden_actual = 1

                        $inicio = $orden_actual+1;

                        //$neworden = 4



                        $sql="UPDATE temporal_partes_nueva_factura SET `orden` = `orden`-1 WHERE orden BETWEEN ".$inicio." AND ".$neworden." AND idusuario=".$this->session->userdata(IDUSERCOM);

                        $update=$this->General_Model->infoxQueryUpt($sql);



                        if ( $update ) {

                             

                            $datos = array('orden' => $neworden );

                            /*$utabla = "temporal_partes_nueva_factura";

                            $ucondicion = array('id' => $idparte );



                            $update2=$this->General_Model->updateERP($udatos,$utabla,$ucondicion);



                            echo json_encode($update2);*/



                        }else{



                            $error = 1;



                        } 



                    }else{



                        $error = 1;



                    }



                }else{



                    $error=1;



                }



            break;



            case 2:

            /// cantidad



            if ( $data_post["texto"] > 0 ) {



                $sumas_totales = calcularTotales($data_post["texto"],$row_partida->costo,$row_partida->iva,$row_partida->descuento);

               

                $datos = array(

                    

                    'cantidad' => round($data_post["texto"],2),

                    'tot_subtotal' => $sumas_totales[0],

                    'tot_descuento' => $sumas_totales[1],

                    'tot_iva' => $sumas_totales[2],

                    'tot_total' => $sumas_totales[3]

                   

                );



            }else{



                $error = 1;



            }

                

            break;



            case 4:



            /// descripcion



            if ( $data_post["texto"] != "" ) {

               

                $datos = array(

                    

                    'descripcion' => changeString(trim($data_post["texto"]))

                   

                );



            }else{



                $error = 1;



            }

                

            break;



            case 6:





                ///// traemos los datos registrados en la tabla



                /*$sdata = "tcambio";

                $stabla = "temporal_partes_nueva_factura";

                $scondicion = array('id' => $data_post["idpcot"]);

                $datosx = $this->General_Model->SelectUnafila($sdata,$stabla,$scondicion);*/



                /// costo

                $costo_proveedor = $data_post["idcpro"];

                $costox = quitarPesos(trim($data_post["texto"]));



                $utilidadx = ( ( ( ( round($costox,2) )/round( ($costo_proveedor*$row_partida->tcambio),2 ) )-1)*100 );



                $sumas_totales = calcularTotales($row_partida->cantidad,$costox,$row_partida->iva,$row_partida->descuento);



                if ( $costox > 0 ) {



                    

                   

                    $datos = array(

                        

                        'costo' => round($costox,2),

                        'utilidad'=>$utilidadx,

                        'tot_subtotal' => $sumas_totales[0],

                        'tot_descuento' => $sumas_totales[1],

                        'tot_iva' => $sumas_totales[2],

                        'tot_total' => $sumas_totales[3]



                       

                    );



                }else{



                    $error = 1;



                }





                

            break;





            case 8:



                //descuento



                $descuentox =round( trim($data_post["texto"]),2 );



                $sumas_totales = calcularTotales($row_partida->cantidad,$row_partida->costo,$row_partida->iva,$descuentox);



                if (  $descuentox >= 0 ) {

               

                    $datos = array(

                        

                        'descuento' => $descuentox,

                        'tot_subtotal' => $sumas_totales[0],

                        'tot_descuento' => $sumas_totales[1],

                        'tot_iva' => $sumas_totales[2],

                        'tot_total' => $sumas_totales[3]

                       

                    );



                }else{



                    $error = 1;



                }

                

            break;



            case 9:



                //UTILIDAD



                ///// traemos los datos registrados en la tabla



                /*$sdata = "tcambio";

                $stabla = "temporal_partes_nueva_factura";

                $scondicion = array('id' => $data_post["idpcot"]);

                $datosx = $this->General_Model->SelectUnafila($sdata,$stabla,$scondicion);*/



                $utilidadxx = round( trim($data_post["texto"]),2 );

                $costo_proveedor = $data_post["idcpro"];

                $costox = ( ( $costo_proveedor+ ( round( ($costo_proveedor)*( $utilidadxx/100),2 ) ) )*$row_partida->tcambio );



                $sumas_totales = calcularTotales($row_partida->cantidad,$costox,$row_partida->iva,$row_partida->descuento);



                if ( $utilidadxx > 0 ) {

               

                    $datos = array(

                        

                        'utilidad' => $utilidadxx,

                        'costo' => round($costox,2),

                        'tot_subtotal' => $sumas_totales[0],

                        'tot_descuento' => $sumas_totales[1],

                        'tot_iva' => $sumas_totales[2],

                        'tot_total' => $sumas_totales[3]

                       

                    );



                }else{



                    $error = 1;



                }

                

            break; 



            case 10:



                //TIPO DE CAMBIO



                ///// traemos los datos registrados en la tabla



                /*$sdata = "utilidad";

                $stabla = "temporal_partes_nueva_factura";

                $scondicion = array('id' => $data_post["idpcot"]);

                $datosx = $this->General_Model->SelectUnafila($sdata,$stabla,$scondicion);*/



                $costo_proveedor = $data_post["idcpro"];

                $tcambiox = round( trim($data_post["texto"]),2 );

                $costox = ( ( $costo_proveedor+ round( ($costo_proveedor*( round( ($row_partida->utilidad/100),3 ) ) ),2 ) )*$tcambiox);



                if (  $tcambiox > 0 ) {



                    

               

                    $datos = array(

                        

                        'tcambio' => $tcambiox,

                        'costo' => round($costox,2),

                        'tot_subtotal' => $sumas_totales[0],

                        'tot_descuento' => $sumas_totales[1],

                        'tot_iva' => $sumas_totales[2],

                        'tot_total' => $sumas_totales[3]



                        //'costo' => ( ( $costo_proveedor+( ($costo_proveedor*$data_post["utilidad"])/100 ) )*round($data_post["texto"],2) )

                       

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



            $tabla = "temporal_partes_nueva_factura";



            $update=$this->General_Model->updateERP($datos,$tabla,$condicion);



            if( $update ){



                $sql="SELECT orden,cantidad,costo,descripcion,descuento,tot_subtotal AS subtotal,

                tot_descuento AS tdescuento,

                tot_iva AS tiva,utilidad,tcambio 

                FROM `temporal_partes_nueva_factura` WHERE id=".$data_post["idpcot"];



                echo json_encode( $this->General_Model->infoxQueryUnafila($sql) );



            }



        }else{





            $update = null;



            echo json_encode( $update );



        }



    }







    public function finalizarFactura(){



        $data_post = $this->input->post();



        ////////******** OBTENER EL TOTAL DEL TEMPORAL DE FACTURACION

        

        $total = $data_post["totalx"];

        $iva = $data_post["ivax"];

        $descuento = $data_post["descuentox"];

        $subtotal = $data_post["subtotalx"];



        $data = array(



                    'fecha' => date("Y-m-d"),

                    'hora' => date("H:i:s"),

                    //'idcotizacion' => $data_post["idcot"],

                    'idusuario' => $data_post["iduser"],

                    'dias' => $data_post["dias"],

                    'idmpago' => $data_post["mpagox"],

                    'idfpago' => $data_post["fpagox"],

                    'idcfdi' => $data_post["cfdix"],

                    'moneda' =>  1,

                    'tcambio' =>  1,

                    'idcliente' => $data_post["idcliente"],

                    'subtotal' => $subtotal,

                    'descuento' => $descuento,

                    'iva' => $iva,

                    'total' => $total,

                    'odc' => $data_post["odc"]



                    

        );



        $table = "alta_factura_sustitucion";



        $last_id=$this->General_Model->altaERP($data,$table);



        if ( $last_id > 0 ) {

            

            /*$data2 = array('estatus' => 2, 'documento' => $last_id );

            $table2 = "alta_cotizacion";

            $condicion2 = array('id' => $data_post["idcot"]);



            $this->General_Model->updateERP($data2,$table2,$condicion2);*/

            /////////************* CAMBIAR ODC

            $ruta_actual="tw/js/upload_odc/files/".$data_post['odc'];

            $ruta_nueva="tw/js/odc_cliente/odc".$last_id.".pdf";

            if(copy($ruta_actual,$ruta_nueva)){

                $data2x = array('odc' => "odc".$last_id.".pdf");
                $table2x = "alta_factura";
                $condicion2x = array('id' => $last_id);

                $this->General_Model->updateERP($data2x,$table2x,$condicion2x);

            }



            //////***************** PASAR LAS PARTIDAS DEL TEMPORAL DE FACTURACION A LA FACTURA



            $sql_partes="SELECT a.id,b.nparte AS clave,a.idparte,a.cantidad,

                        CONVERT(CAST(CONVERT( CONCAT_WS(' ',b.clave,a.descripcion,d.marca) USING latin1) AS BINARY) USING utf8) AS descrip, 

                        c.descripcion AS unidad, 

                        a.costo, a.iva,a.descuento,

                        a.orden,a.utilidad,a.tcambio,

                        a.costo_proveedor, a.id AS idpcot,a.riva,a.risr,a.tot_subtotal,a.tot_descuento,a.tot_iva,a.tot_total

                        FROM temporal_partes_nueva_factura a, alta_productos b, sat_catalogo_unidades c, alta_marca d

                        WHERE a.idparte=b.id

                        AND b.idunidad=c.id

                        AND b.idmarca = d.id

                        AND a.idusuario = ".$data_post["iduser"]."

                        AND a.estatus = 0";



            $partes = $this->General_Model->infoxQuery($sql_partes);



            foreach ($partes as $row) {



                    //$total_neto = ($row->subtotal-$row->descuento)+$row->tiva;



                    $data3 = array( 'idfactura' => $last_id, 'idparte' => $row->idparte,

                    'descripcion' => $row->descrip, 'cantidad'=> $row->cantidad,

                    'costo_proveedor' => $row->costo_proveedor, 

                    'costo' => $row->costo,

                    'iva' => $row->iva,

                    'descuento'=> $row->descuento, 

                    'riva' => $row->riva, 

                    'risr' => $row->risr,

                    'utilidad' => $row->utilidad, 'tcambio' => $row->tcambio, 'orden' => $row->orden, 'tot_subtotal' => $row->tot_subtotal,

                    'tot_descuento' => $row->tot_descuento, 'tot_iva' => $row->tot_iva, 'tot_total' => $row->tot_total);



                    $table3 = "partes_factura_sustitucion";



                    $this->General_Model->altaERP($data3,$table3);



            }



        }





        echo json_encode($last_id);







    }





        ///////////****************TABLA PARTIDAS BITACORA



        public function loadPartidas()

        {



            $iduser = $this->session->userdata(IDUSERCOM);





            $table = "( SELECT a.id,b.nparte AS clave,

                CONCAT_WS('/',a.id,a.orden) AS acciones,

                CONVERT(CAST(CONVERT( CONCAT_WS(' ',b.clave,a.descripcion,d.marca) USING latin1) AS BINARY) USING utf8) AS descrip, c.descripcion AS unidad, a.costo_proveedor, a.costo, a.iva,a.descuento,

                tot_subtotal AS subtotal,a.cantidad,a.idparte,a.tot_iva AS tiva,

                a.tot_descuento AS tdescuento,a.orden,a.utilidad,a.tcambio

                FROM temporal_partes_nueva_factura a, alta_productos b, sat_catalogo_unidades c, alta_marca d

                WHERE a.idparte=b.id

                AND b.idunidad=c.id

                AND b.idmarca = d.id

                AND a.idusuario = ".$iduser."

                AND a.estatus = 0 )temp"; 



  

            // Primary key of table

            $primaryKey = 'id';

            

            $columns = array(



                /*<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    Default <span class="caret"></span>

                                  </button>*/



                array( 'db' => 'acciones',     'dt' => 0,



                        'formatter' => function( $d, $row ) {



                            $separar=explode("/",$d);



                            return '<button class="btn btn-red" type="button" class="form-control" onclick="retirarParte('.$separar[0].','.$separar[1].')" ><i class="fa fa-trash"></i></button>';



                        }  

                ),



                array( 'db' => 'orden',     'dt' => 1 ),

                array( 'db' => 'cantidad',     'dt' => 2 ),

                array( 'db' => 'clave',     'dt' => 3 ),

                array( 'db' => 'descrip',     'dt' => 4 ),

                array( 'db' => 'unidad',     'dt' => 5 ),

                array( 'db' => 'costo',        

                        'dt' => 6,

                        'formatter' => function( $d, $row ) {



                            return "<p>".wims_currency($d)."</p>";



                        }

                ), 

                array( 'db' => 'iva',     'dt' => 7 ),

                array( 'db' => 'descuento',     'dt' => 8 ),



                array( 'db' => 'utilidad',     'dt' => 9 ),



                array( 'db' => 'tcambio',     'dt' => 10 ),



                array( 'db' => 'subtotal',        

                        'dt' => 11,

                        'formatter' => function( $d, $row ) {



                            return wims_currency($d);



                        }

                ), 

                array( 'db' => 'id',     'dt' => 12 ),

                array( 'db' => 'costo',     'dt' => 13 ),

                array( 'db' => 'idparte',     'dt' => 14 ),



                array( 'db' => 'subtotal',     'dt' => 15 ),

                array( 'db' => 'tiva',     'dt' => 16 ),

                array( 'db' => 'tdescuento',     'dt' => 17 ),

                array( 'db' => 'costo_proveedor',     'dt' => 18 )



           

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

