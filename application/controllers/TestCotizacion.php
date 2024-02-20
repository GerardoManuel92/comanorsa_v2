<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class TestCotizacion extends CI_Controller

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



    public function EditCot()

    {

        $iduser = $this->session->userdata(IDUSERCOM);

        $idcot = $this->uri->segment(3);



        $numero_menu = 10;/// se coloca el mismo identificador que el alta de cotizacion;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



            ///////////* datos cotizacion



            $query="SELECT b.nombre AS cliente, a.idcliente,a.moneda,a.tcambio,a.observaciones,a.estatus, b.idfpago, b.idcfdi, b.credito, b.limite,

            IFNULL( (SELECT SUM(x.total) FROM alta_factura x WHERE x.idcliente = b.id AND x.pago = 0 AND x.estatus IN(1,3) ), 0 ) AS totfactura,

            IFNULL( (SELECT SUM(y.total) FROM alta_remision y WHERE y.idcliente = b.id AND y.pago = 0 AND y.estatus IN(0,2) ), 0 ) AS totremision,

            IFNULL( (SELECT SUM(w.total) FROM alta_factura w WHERE w.idcliente = b.id AND w.pago = 0 AND w.estatus IN(1,3) 

            AND DATE_ADD(w.fecha,INTERVAL w.dias DAY) <= '".date('Y-m-d')."' ), 0) AS sfvencido,

            IFNULL( (SELECT SUM(z.total) FROM alta_remision z WHERE z.idcliente = b.id AND z.pago = 0 AND z.estatus IN(0,2) 

            AND DATE_ADD(z.fecha,INTERVAL '0' DAY) <= '".date('Y-m-d')."' ), 0) AS srvencido,a.odc



                    FROM alta_cotizacion a, alta_clientes b

                    WHERE a.idcliente=b.id

                    AND a.id =".$idcot;



            $datos = $this->General_Model->infoxQueryUnafila($query);



           



            //////******* BORRAMOS EL CONTENIDO ACTUAL DE LA COTIZACION



            $tablax = "temporal_partes_act_cotizacion";

            $condicionx = array( 'idcotizacion' => $idcot );



            $borrar = $this->General_Model->deleteERP($tablax,$condicionx);





            $sqlx = "SELECT idparte,cantidad,costo,iva,descuento,descripcion,orden,costo_proveedor,riva,risr,utilidad,tcambio,

            tot_subtotal,

            tot_descuento,

            tot_iva,

            tot_total

            FROM partes_cotizacion WHERE idcotizacion =".$idcot." AND estatus = 0 ORDER BY orden ASC";



            $partes = $this->General_Model->infoxQuery($sqlx);



            if ($partes != null ) {



                foreach ($partes as $row) {


                    $descrip_new=str_replace(array('ñ','Ñ'),array('&ntilde;','&Ntilde;'),$row->descripcion);


                    if ( $row->tot_subtotal == 0 ) {

                        

                        //////************** CALCULAR VALORES FALTANTES 



                        $subtotal = round($row->cantidad,2)*round($row->costo,2);



                        if ( $row->tot_descuento > 0 ) {

                            

                            $subtotal_desc = round($subtotal,2)-round( ( round($subtotal,2)*round( ($row->tot_descuento/100),2 ) ),2 );



                        }else{



                            $subtotal_desc = $subtotal;



                        }



                        

                        $total_descuento = $subtotal-$subtotal_desc;



                        if ( $row->tot_iva > 0 ) {

                            

                            $iva =round( $subtotal_desc*round( ($row->tot_iva/100),2 ),2 );



                        }else{



                            $iva =0;



                        }



                        $total_partida = round( ($subtotal_desc+$iva),2 );





                        $data3 = array( 'idcotizacion' => $idcot, 'idparte' => $row->idparte, 'costo_proveedor' => $row->costo_proveedor,'cantidad' => $row->cantidad, 'costo' => $row->costo, 'iva' => $row->iva, 'descuento' => $row->descuento, 'descripcion' =>$descrip_new, 'orden' => $row->orden, 'riva'=>$row->riva, 'risr'=>$row->risr, 'utilidad'=>$row->utilidad, 'tcambio'=>$row->tcambio,

                            'tot_subtotal' => $subtotal_desc,

                            'tot_descuento' => $total_descuento,

                            'tot_iva' => $iva,

                            'tot_total' => $total_partida );



                    }else{



                        $data3 = array( 'idcotizacion' => $idcot, 'idparte' => $row->idparte, 'costo_proveedor' => $row->costo_proveedor,'cantidad' => $row->cantidad, 'costo' => $row->costo, 'iva' => $row->iva, 'descuento' => $row->descuento, 'descripcion' =>$descrip_new, 'orden' => $row->orden, 'riva'=>$row->riva, 'risr'=>$row->risr, 'utilidad'=>$row->utilidad, 'tcambio'=>$row->tcambio,

                            'tot_subtotal' =>$row->tot_subtotal,

                            'tot_descuento' =>$row->tot_descuento,

                            'tot_iva' =>$row->tot_iva,

                            'tot_total' =>$row->tot_total  );



                    }



                    $table3 = "temporal_partes_act_cotizacion";

                    $this->General_Model->altaERP($data3,$table3);



                }



            }



            /////////////*****************



            //idodc : este nos idnica que la odc de esa cotizacion ha sidfo habilitada y ya no puede haber una edicion o actualizacion

            $info_cot = array('info' => $datos, 'idcot' => $idcot);

            $info_menu = array('nommenu' => "editcotizacion", 'idestatus' => $datos->estatus );



            //$dmenu["nommenu"] = "editcotizacion"; 

            if($iduser > 0){



                $this->load->view('general/header');

                $this->load->view('general/css_select2');

                $this->load->view('general/css_autocompletar');

                $this->load->view('general/css_upload');

                //$this->load->view('general/css_xedit');

                $this->load->view('general/css_date');

                $this->load->view('general/css_datatable');

                $this->load->view('general/menuv2');

                $this->load->view('general/menu_header',$info_menu);

                $this->load->view('cotizaciones/prueba_actualizar_cotizacion',$info_cot);

                $this->load->view('general/footer');

                $this->load->view('cotizaciones/acciones_prueba_actualizar_cotizacion',$info_cot);



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



    public function showDatosCliente(){



        $data_post = $this->input->post();



        $query="SELECT a.nombre,a.rfc,b.cp,CONCAT_WS('-', c.clave,c.regimen) AS regimen_fiscal

        FROM alta_clientes a, direccion_clientes b, sat_catalogo_regimen_fiscal c

        WHERE b.idcliente=a.id

        AND a.idregimen=c.id

        AND a.id=".$data_post['idcliente'];



        echo json_encode( $this->General_Model->infoxQueryUnafila($query) );       



    }   



    public function showCfdi(){



        $query="SELECT id, clave, descripcion FROM `sat_catalogo_cfdi` WHERE estatus = 0 ORDER BY descripcion ASC";



            echo json_encode( $this->General_Model->infoxQuery($query) );



    }



    public function showFpago(){



        $query="SELECT id, clave, descripcion FROM `sat_catalogo_fpago` WHERE estatus = 0 ORDER BY descripcion ASC";



            echo json_encode( $this->General_Model->infoxQuery($query) );

        

    }



    public function showMpago(){



        $query="SELECT id, clave, descripcion FROM `sat_metodo_pago` WHERE estatus = 0 ORDER BY descripcion ASC";



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



                            'idcotizacion' => $data_post['idcot'], 

                            'idparte' => $data_post['idparte'], 

                            'estatus' => 0

                        );



        $tabla1 = "temporal_partes_act_cotizacion";

        $repeat = 0;//$this->General_Model->verificarRepeat($tabla1,$condicion1);



        if ( $repeat == 0 ) {



            ////////********* ORDEN

            $sql="SELECT COUNT(id) AS total FROM `temporal_partes_act_cotizacion` WHERE idcotizacion = ".$data_post['idcot']." AND estatus = 0";

            $last_orden = $this->General_Model->infoxQueryUnafila($sql);





            //////************** CALCULAR VALORES FALTANTES 



                $subtotal = round($data_post['cantidad'],2)*round($data_post['costo'],2);



                if ( $data_post['descuento'] > 0 ) {

                    

                    $subtotal_desc = round($subtotal,2)-round( ( round($subtotal,2)*($data_post['descuento']/100 ) ),2 );



                }else{



                    $subtotal_desc = $subtotal;



                }



                

                $total_descuento = round($subtotal,2)-round($subtotal_desc,2);





                if ( $data_post['iva'] > 0 ) {

                    

                    //$iva =round( ( $subtotal_desc*($data_post['iva']/100) ),2 );



                    $valor_iva=($data_post["iva"]/100)+1;

                    $total_partida=round($subtotal_desc,2)*round($valor_iva,2);



                }else{



                    //$iva =0;

                    $total_partida = round($subtotal_desc,2);



                }



                //$total_partida = round( ($subtotal_desc+$iva),2 );

                $iva = round($total_partida,2)-round($subtotal_desc,2);

            

                $data = array(



                    'orden' => $last_orden->total+1,

                    'idcotizacion' => $data_post['idcot'],

                    'idparte' => $data_post['idparte'],

                    'cantidad' => $data_post['cantidad'],

                    'costo' => $data_post['costo'],

                    'costo_proveedor' => $data_post['cproveedor'],

                    'iva' => $data_post['iva'],

                    'descuento' => $data_post['descuento'],

                    'descripcion'=>changeString($data_post['descripx']),

                    'riva' => $data_post['rivax'],

                    'risr' => $data_post['risrx'],

                    'tcambio' => $data_post['tcambiox'],

                    'utilidad' => $data_post['utilidadx'],



                    'tot_subtotal' => $subtotal,

                    'tot_descuento' => $total_descuento,

                    'tot_iva' => $iva,

                    'tot_total' => $total_partida

               

                );



            $table = "temporal_partes_act_cotizacion";



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

                    'iva' => $data_post['iva'],

                    'descuento' => $data_post['descuento']

               

                );

                $condicion = array(



                    'id' => $data_post["idpcot"] 



                );



            $tabla = "temporal_partes_act_cotizacion";



            $last_id=$this->General_Model->updateERP($datos,$tabla,$condicion);



        echo json_encode( $last_id );



    }





    public function retirarParte(){



        $data_post = $this->input->post();

        $resultado = 0;

        $condicion = array( 'id' => $data_post["idpcot"] );

        $tabla="temporal_partes_act_cotizacion";



        $delete=$this->General_Model->deleteERP($tabla,$condicion);



        if ( $delete ) {

            

            $sql="UPDATE temporal_partes_act_cotizacion SET `orden` = `orden`-1 WHERE orden > ".$data_post['ordenx']." AND idcotizacion=".$data_post['idcotizacion'];



            $this->General_Model->infoxQueryUpt($sql);



            $resultado = 1;



        }else{



            $resultado = 0;



        }



        echo json_encode( $resultado );



        //echo json_encode(   $this->General_Model->deleteERP($tabla,$condicion)  );



    }



    ///////////************* ACCION A COTIZACION



    public function actCotizacion(){



        $data_post = $this->input->post();

        $data = array(



                    'fecha' => date("Y-m-d"),

                    'hora' => date("H:i:s"),

                    'idcliente' => $data_post["idcliente"],

                    'observaciones' => $data_post["obsx"],

                    'moneda' => 1,//$data_post["monedax"],

                    'tcambio' => 1//$data_post["tcx"],





                );



        $table = "alta_cotizacion";

        $condicion = array('id' => $data_post["idcot"] );



        $last_id=$this->General_Model->updateERP($data,$table,$condicion);



        if ( $last_id ) {



            ////////******************BORRAR LAS PARTIDAS DE LA COTIZACION ACTUAL



            $dtabla= "partes_cotizacion";

            $dcondicion = array('idcotizacion' => $data_post["idcot"] );

            $this->General_Model->deleteERP($dtabla,$dcondicion);



            //////////******** AÑADIR LAS PARTIDAS DEL TEMPORAL A ALA NUEVA COTIZACION

            

            $sqlx = "SELECT idparte,cantidad,costo,iva,descuento,descripcion,orden,costo_proveedor,riva,risr,utilidad,tcambio,tot_subtotal,tot_descuento,tot_iva,tot_total 

            FROM temporal_partes_act_cotizacion WHERE idcotizacion =".$data_post['idcot']." AND estatus = 0 ORDER BY orden ASC";



            $partes = $this->General_Model->infoxQuery($sqlx);



            foreach ($partes as $row) {



                $data3 = array( 'idcotizacion' => $data_post["idcot"], 'idparte' => $row->idparte, 'costo_proveedor' => $row->costo_proveedor,'cantidad' => $row->cantidad, 'costo' => $row->costo, 'iva' => $row->iva, 'descuento' => $row->descuento, 'descripcion' => $row->descripcion, 'orden' => $row->orden, 'riva' =>$row->riva, 'risr' =>$row->risr, 'utilidad' =>$row->utilidad, 'tcambio' =>$row->tcambio, 'tot_subtotal' => $row->tot_subtotal, 'tot_descuento' => $row->tot_descuento, 'tot_iva' => $row->tot_iva, 'tot_total' => $row->tot_total



                );



                $table3 = "partes_cotizacion";



                $this->General_Model->altaERP($data3,$table3);



            }





            echo json_encode($data_post["idcot"]);



        }else{



            echo json_encode(0);



        }



    }



    public function remCotizacion(){



        $data_post = $this->input->post();

        $data = array(



                    'fecha' => date("Y-m-d"),

                    'hora' => date("H:i:s"),

                    'idcotizacion' => $data_post["idcot"],

                    'observaciones' => $data_post["obsx"],

                    'idcliente' => $data_post["idcliente"]

                   

                );



        $table = "alta_remision";



        $last_id=$this->General_Model->altaERP($data,$table);



        if ( $last_id > 0 ) {

            

            $data2 = array('estatus' => 1, 'documento' => $last_id );

            $table2 = "alta_cotizacion";

            $condicion2 = array('id' => $data_post["idcot"]);



            $this->General_Model->updateERP($data2,$table2,$condicion2);



            //////***************** PASAR LAS PARTIDAS DE LA COTIZACION A ASIGNACION Y ENTREGA



            ////////******************BORRAR LAS PARTIDAS DE LA COTIZACION ACTUAL



            /*$dtabla= "partes_cotizacion";

            $dcondicion = array('idcotizacion' => $data_post["idcot"] );

            $this->General_Model->deleteERP($dtabla,$dcondicion);



            //////////

            

            $sqlx = "SELECT idparte,cantidad,id,iva,costo_proveedor,costo,descuento,descripcion,orden FROM `temporal_partes_act_cotizacion` WHERE idcotizacion = ".$data_post["idcot"]." AND estatus = 0";



            //$partes = $this->General_Model->SelectsinOrder($data2,$tabla2,$condicion2);

            $partes = $this->General_Model->infoxQuery($sqlx);



            foreach ($partes as $row) {



                ////// ACTUALIZAR LAS NUEVAS PARTIDAS DE LA COTIZACION



                $data3 = array( 'idcotizacion' => $data_post["idcot"], 'idparte' => $row->idparte, 'costo_proveedor' => $row->costo_proveedor,'cantidad' => $row->cantidad, 'costo' => $row->costo, 'iva' => $row->iva, 'descuento' => $row->descuento, 'descripcion' => $row->descripcion, 'orden' => $row->orden );



                $table3 = "partes_cotizacion";



                $this->General_Model->altaERP($data3,$table3);





            */





                ////// ORDEN DE COMPRA



                /*$data3 = array( 'fecha' => date("y-m-d"), 'hora' => date("H:i:s"), 'idcot' =>$data_post["idcot"], 'idpartecot' => $row->id, 'cantidad'=> $row->cantidad, 'idparte'=> $row->idparte, 'idproveedor' => 1, 'costo' => $row->costo_proveedor );



                $table3 = "partes_asignar_oc";



                $this->General_Model->altaERP($data3,$table3);



                ///// ENTREGA



                $data3 = array( 'fecha' => date("y-m-d"), 'hora' => date("H:i:s"), 'idpartefolio' =>$row->id, 'idfolio' => $last_id, 'cantidad'=> $row->cantidad, 'idtipo'=> 1);



                $table3 = "partes_entrega";



                $this->General_Model->altaERP($data3,$table3);



                



            }  

                */

        }





        echo json_encode($last_id);



    }



    public function factCotizacion(){



        $data_post = $this->input->post();





        ///////******* ACTUALIZAR COTIZACION

        /*$cotdata = array('fcotizacion' => date('Y-m-d'), 'hora' => date('H:i:s'), 'idcliente' => $data_post['idcliente'], 'moneda' => $data_post['monedax'], 'tcambio' => $data_post['tcx'],'observaciones' => $data_post['obsx'] );

        $cottable = "alta_cotizacion";

        $cotcondicion = array('id' => $data_post['idcot'] );

        $this->General_Model->updateERP($cotdata,$cottable,$cotcondicion);*/



        ////////******** seleccionar los datos de la cotizacion



        $sql1="SELECT  moneda, tcambio, idcliente, subtotal, descuento, iva, total FROM alta_cotizacion WHERE id =".$data_post['idcot'];

        $infosql1 = $this->General_Model->infoxQueryUnafila($sql1);





        ///////////********** ALTA FACTURA



        if ( $infosql1->idcliente == 21 ) {

            

            $subtotalx = $infosql1->subtotal+$infosql1->iva;

            

            $ivax = 0;



        }else{



            $subtotalx = $infosql1->subtotal;

            

            $ivax = $infosql1->iva;



        }



        $data = array(



                    'fecha' => date("Y-m-d"),

                    'hora' => date("H:i:s"),

                    'idcotizacion' => $data_post["idcot"],

                    'idusuario' => $data_post["iduser"],

                    'dias' => $data_post["dias"],

                    'idmpago' => $data_post["mpagox"],

                    'idfpago' => $data_post["fpagox"],

                    'idcfdi' => $data_post["cfdix"],

                    'moneda' =>  $infosql1->moneda,

                    'tcambio' =>  $infosql1->tcambio,

                    'idcliente' =>  $infosql1->idcliente,

                    'subtotal' => $subtotalx,

                    'descuento' => $infosql1->descuento,

                    'iva' => $ivax,

                    'total' => $infosql1->total,

                    'odc' => $data_post["odc"]



                    

                );



        $table = "alta_factura";



        $last_id=$this->General_Model->altaERP($data,$table);



        if ( $last_id > 0 ) {

            

            //$data2 = array('estatus' => 2, 'documento' => $last_id );

            $data2 = array('documento' => $last_id );

            $table2 = "alta_cotizacion";

            $condicion2 = array('id' => $data_post["idcot"]);



            $this->General_Model->updateERP($data2,$table2,$condicion2);



            //////***************** PASAR LAS PARTIDAS DE LA COTIZACION A ASIGNACION Y ENTREGA



            ////////******************BORRAR LAS PARTIDAS DE LA COTIZACION ACTUAL



            /*$dtabla= "partes_cotizacion";

            $dcondicion = array('idcotizacion' => $data_post["idcot"] );

            $this->General_Model->deleteERP($dtabla,$dcondicion);



            //////////

            

            $sqlx = "SELECT idparte,cantidad,id,iva,costo_proveedor,costo,descuento,descripcion,orden FROM `temporal_partes_act_cotizacion` WHERE idcotizacion = ".$data_post["idcot"]." AND estatus = 0";



            //$partes = $this->General_Model->SelectsinOrder($data2,$tabla2,$condicion2);

            $partes = $this->General_Model->infoxQuery($sqlx);



            foreach ($partes as $row) {



                ////// ACTUALIZAR LAS NUEVAS PARTIDAS DE LA COTIZACION



                $data3 = array( 'idcotizacion' => $data_post["idcot"], 'idparte' => $row->idparte, 'costo_proveedor' => $row->costo_proveedor,'cantidad' => $row->cantidad, 'costo' => $row->costo, 'iva' => $row->iva, 'descuento' => $row->descuento, 'descripcion' => $row->descripcion, 'orden' => $row->orden );



                $table3 = "partes_cotizacion";



                $this->General_Model->altaERP($data3,$table3);



            */



                ////// ESTAS PARTIDAS SE AÑADIRAN CUANDO LA FACTURA ESTE TIMBRADA



                /*$data3 = array( 'fecha' => date("y-m-d"), 'hora' => date("H:i:s"), 'idcot' =>$data_post["idcot"], 'idpartecot' => $row->id, 'cantidad'=> $row->cantidad, 'idparte'=> $row->idparte, 'idproveedor' => 1, 'costo' => $row->costo_proveedor );



                $table3 = "partes_asignar_oc";



                $this->General_Model->altaERP($data3,$table3);



                ///// ENTREGA



                $data3 = array( 'fecha' => date("y-m-d"), 'hora' => date("H:i:s"), 'idpartefolio' =>$row->id, 'idfolio' => $last_id, 'cantidad'=> $row->cantidad, 'idtipo'=> 1);



                $table3 = "partes_entrega";



                $this->General_Model->altaERP($data3,$table3);



            }*/  



        }





        echo json_encode($last_id);



    }



    public function newCotizacion(){



        $data_post = $this->input->post();



        $data = array(



                    'fecha' => date("Y-m-d"),

                    'fcotizacion' => date("Y-m-d"),

                    'hora' => date("H:i:s"),

                    'idcliente' => $data_post["idcliente"],

                    'observaciones' => $data_post["obsx"],

                    'moneda' => $data_post["monedax"],

                    'tcambio' => $data_post["tcx"],

                    'idusuario' => $data_post["iduser"]





        );



        $table = "alta_cotizacion";



        $last_id=$this->General_Model->altaERP($data,$table);



        if ( $last_id > 0 ) {



            //////////******** AÑADIR LAS PARTIDAS DEL TEMPORAL A ALA NUEVA COTIZACION

            

            $sqlx = "SELECT idparte,cantidad,costo,iva,descuento,descripcion,orden,costo_proveedor,riva,risr,utilidad,tcambio,tot_subtotal,tot_descuento,tot_iva,tot_total 

            FROM temporal_partes_act_cotizacion WHERE idcotizacion =".$data_post['idcot']." AND estatus = 0 ORDER BY orden ASC";



            $partes = $this->General_Model->infoxQuery($sqlx);



            foreach ($partes as $row) {



                $data3 = array( 'idcotizacion' => $last_id, 'idparte' => $row->idparte, 'costo_proveedor' => $row->costo_proveedor,'cantidad' => $row->cantidad, 'costo' => $row->costo, 'iva' => $row->iva, 'descuento' => $row->descuento, 'descripcion' => $row->descripcion, 'orden' => $row->orden, 'riva'=>$row->riva, 'risr'=>$row->risr, 'utilidad' =>$row->utilidad, 'tcambio' =>$row->tcambio, 'tot_subtotal' => $row->tot_subtotal, 'tot_descuento' => $row->tot_descuento, 'tot_iva' => $row->tot_iva, 'tot_total' => $row->tot_total  );



                $table3 = "partes_cotizacion";



                $this->General_Model->altaERP($data3,$table3);



            }





            echo json_encode($last_id);



        }else{



            echo json_encode(0);



        }







    }



    public function porcientoAll(){



        $data_post = $this->input->post();



        if ( $data_post["gutilidad"] >= 0 AND $data_post["gdescuento"] >= 0 ) {



            if ( $data_post["gdescuento"] > 0 ) {

                

                $porcientodesc = $data_post["gdescuento"];



            }else{



                $porcientodesc = 0;



            }



            if ( $data_post["gutilidad"] > 0 ) {

                

                $porcientoutil = $data_post["gutilidad"]/100;



            }else{



                $porcientoutil = 0;



            }



            $datos = " costo=costo_proveedor+(costo_proveedor*".$porcientoutil."), descuento=".$porcientodesc;





        }elseif ( $data_post["gutilidad"] >= 0 ) {



            if ( $data_post["gutilidad"] > 0 ) {

                

                $porcientoutil = $data_post["gutilidad"]/100;



            }else{



                $porcientoutil = 0;



            }



            $datos = "costo=costo_proveedor+(costo_proveedor*".$porcientoutil.")";





        }elseif (  $data_post["gdescuento"] >= 0  ) {

            

            if ( $data_post["gdescuento"] > 0 ) {

                

                $porcientodesc = $data_post["gdescuento"];



            }else{



                $porcientodesc = 0;



            }



            

            $datos = " descuento=".$porcientodesc;



        }



        $query = "UPDATE temporal_partes_act_cotizacion SET ".$datos." WHERE idusuario=".$this->session->userdata(IDUSERCOM);



        echo json_encode( $this->General_Model->infoxQueryUpt($query) );



        //echo json_encode($query);



    }



    public function porcientoFal(){



        $data_post = $this->input->post();



        if ( $data_post["gutilidad"] >= 0 ) {



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



        }



        /////////*********** ACTUALIZACION DESCUENTO



        $query = "UPDATE temporal_partes_act_cotizacion SET ".$datos2." WHERE idusuario=".$this->session->userdata(IDUSERCOM)." AND descuento = 0";



        $this->General_Model->infoxQueryUpt($query);



        /////////*********** ACTUALIZACION UTILIDAD



        $query2 = "UPDATE temporal_partes_act_cotizacion SET ".$datos." WHERE idusuario=".$this->session->userdata(IDUSERCOM)." AND costo = 0";



        $this->General_Model->infoxQueryUpt($query2);



        if ( $query2 == true OR $query == true ) {

            

            $valor = true;



        }



        echo json_encode( $valor );



    }



    ////////******************



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

                $dtabla = "temporal_partes_act_cotizacion";

                $dcondicion = array('id' => $data_post["idpcot"]);

                $row_partida = $this->General_Model->SelectUnafila($ddata,$dtabla,$dcondicion); 





        switch ( $data_post["columna"] ) {



            case 1:



                if ( $data_post["texto"] > 0 ) {

                    

                    $neworden= $data_post["texto"];

                    $orden_actual= $data_post["ordenx"];

                    //$idcotizacion=;

                    $idparte=$data_post["idpcot"];



                    if ( $orden_actual > $neworden ) {

                        

                        //$orden_actual = 4;

                        $limite = $orden_actual-1;

                        //$neworden = 2;

                        //$idcotizacion = 10;



                        $sql="UPDATE temporal_partes_act_cotizacion SET `orden` = `orden`+1 WHERE orden BETWEEN ".$neworden." AND ".$limite." AND idcotizacion=".$data_post["idcotizacion"];

                        $update=$this->General_Model->infoxQueryUpt($sql);



                        if ( $update ) {

                             

                            $datos = array('orden' => $neworden );

                            /*$utabla = "temporal_partes_cotizacion";

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



                        $sql="UPDATE temporal_partes_act_cotizacion SET `orden` = `orden`-1 WHERE orden BETWEEN ".$inicio." AND ".$neworden." AND idcotizacion=".$data_post["idcotizacion"];

                        $update=$this->General_Model->infoxQueryUpt($sql);



                        if ( $update ) {

                             

                            $datos = array('orden' => $neworden );

                            /*$utabla = "temporal_partes_cotizacion";

                            $ucondicion = array('id' => $idparte );



                            $update2=$this->General_Model->updateERP($udatos,$utabla,$ucondicion);



                            echo json_encode($update2);*/



                        }else{



                            $error = 1;



                        } 



                    }else{



                        $error = 1;



                    }



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

                    

                    'descripcion' => trim($data_post["texto"])

                   

                );



            }else{



                $error = 1;



            }

                

            break;



            case 6:





                ///// traemos los datos registrados en la tabla



                /*$sdata = "tcambio";

                $stabla = "temporal_partes_cotizacion";

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

                $stabla = "temporal_partes_cotizacion";

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

                $stabla = "temporal_partes_cotizacion";

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



            $tabla = "temporal_partes_act_cotizacion";



            $update=$this->General_Model->updateERP($datos,$tabla,$condicion);



            if( $update ){



                $sql="SELECT cantidad,costo,descripcion,descuento,tot_subtotal AS subtotal,

                tot_descuento AS tdescuento,

                tot_iva AS tiva,utilidad,tcambio 

                FROM `temporal_partes_act_cotizacion` WHERE id=".$data_post["idpcot"];



                echo json_encode( $this->General_Model->infoxQueryUnafila($sql) );



            }



        }else{





            $update = null;



            echo json_encode( $update );



        }



    }





        ///////////****************TABLA PARTIDAS BITACORA



        public function loadPartidas()

        {

            $data = array();
            $pregunta = array();

            $data_get = $this->input->get();

            $sql="SELECT a.id,b.nparte AS clave,

                CONCAT_WS('/',a.id,a.orden) AS acciones,

                CONCAT_WS(' ',b.clave,a.descripcion,d.marca) AS descrip, c.descripcion AS unidad, a.costo, a.iva,a.descuento,

                a.tot_subtotal AS subtotal,a.cantidad,a.idparte,

                a.tot_iva AS tiva,

                a.tot_descuento AS tdescuento,

                a.orden,a.utilidad,a.tcambio,a.costo_proveedor

                FROM temporal_partes_act_cotizacion a, alta_productos b, sat_catalogo_unidades c, alta_marca d

                WHERE a.idparte=b.id

                AND b.idunidad=c.id

                AND b.idmarca = d.id

                AND a.idcotizacion = ".$data_get['idcot']."

                AND a.estatus = 0";

            $datos=$this->General_Model->infoxQuery($sql);

            if ($datos!=null) {
                
                foreach ($datos as $row) {

                    $separar=explode("/",$row->acciones);
                   
                    $pregunta[] = array(

                        'ID'=>$row->id,
                        'ACCION'=>'<button class="btn btn-red" type="button" class="form-control" onclick="retirarParte('.$separar[0].','.$separar[1].')" ><i class="fa fa-trash"></i></button>',
                        'ITEM'=>$row->orden,
                        'CANTIDAD'=>$row->cantidad,
                        'CLAVE'=>$row->clave,
                        'DESCRIPCION'=>$row->descrip,
                        'UM'=>$row->unidad,
                        'PRECIO'=>wims_currency($row->costo),
                        'IVA'=>$row->iva,
                        'DESC'=>$row->descuento,
                        'UTILIDAD'=>$row->utilidad,
                        'TC'=>$row->tcambio,
                        'SUBTOTAL'=>wims_currency($row->subtotal),
                        'IDX'=>$row->id,
                        'COSTOX'=>$row->costo,
                        'IDPARTEX'=>$row->idparte,
                        'SUBX'=>$row->subtotal,
                        'IVAX'=>$row->tiva,
                        'DESCX'=>$row->tdescuento,
                        'PROVX'=>$row->costo_proveedor


                    );

                }

            }


            $data = array("data"=>$pregunta);
            header('Content-type: application/json');
            echo json_encode($data);


        }



}

