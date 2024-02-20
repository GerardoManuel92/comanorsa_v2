<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class Cxcxc extends CI_Controller

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



        function conocerDiaSemanaFecha($fecha) {

            $dias = array('Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado');

            $dia = $dias[date('w', strtotime($fecha))];

            return $dia;

        }



        function obtenerFechaEnLetra($fecha){

            $dia= conocerDiaSemanaFecha($fecha);

            $num = date("j", strtotime($fecha));

            $anno = date("Y", strtotime($fecha));

            $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');

            $mes = $mes[(date('m', strtotime($fecha))*1)-1];

            return $num.' de '.$mes.' del '.$anno;

        }



        function fechaLatino($ingles){



            $separarx = explode("-", $ingles);



            return $separarx[2]."/".$separarx[1]."/".substr($separarx[0], -2);



        }



        function Mptotal($pagox,$idfactx,$totalx,$tipo){



                        $ci =& get_instance();



                        $total=0;



                        



                            $sumatotal = 0;

                            

                            $class = $ci->db->query("SELECT a.pago AS pagado, 

                            (SELECT x.idcpd FROM alta_datos_ppd x WHERE x.id=a.idppd) AS iddatocpp

                            FROM alta_pagos_ppd a WHERE a.idfactura=".$idfactx." AND a.tipo=".$tipo);



                            $class = $class->result_array();



                            foreach($class as $row) {

                                   

                                //// VALIDAR QUE EL COMPLEMENTO DE PAGO ESTE FACTURADO 



                                $class2 = $ci->db->query("SELECT a.estatus

                                FROM alta_ppd a WHERE a.id=".$row["iddatocpp"]);



                                $class2 = $class2->result_array();



                                foreach($class2 as $row2) {



                                    if ( $row2["estatus"] == 1 ) {

                                        

                                        $sumatotal=$sumatotal+$row["pagado"];



                                    }



                                }



                            }



                            $total=$sumatotal;





                            //////////************ SUMAR LOS PAGOS FUERA DEL SISTEMA O PUE



                            $class3 = $ci->db->query("SELECT SUM(total) AS totalx FROM `alta_pago_cxc` WHERE idfactura=".$idfactx." AND estatus=0 AND tipo=".$tipo);



                            $class3 = $class3->result_array();



                            foreach($class3 as $row3) {



                                if ( $row3["totalx"] != null ) {

                                    

                                    $total=$total+$row3["totalx"];



                                }



                            }


                        /*else{


                            ///// SE COMENTO POR QUE 


                            $total=$totalx; 



                        }*/


                        return $total;



        }

        



    }



    public function Cliente()

    {

        $numero_menu = 19;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



            

            $iduser = $this->session->userdata(IDUSERCOM);

           

            if($iduser > 0){

                $idcliente_select = $this->uri->segment(3);

                $info_menu = array('nommenu' => "cxc_xcliente");

                //$data["idusuario"] = $iduser;

                $datos_select = array('idcli'=>$idcliente_select,'idusuario'=>$iduser);

                $this->load->view('general/header');

                $this->load->view('general/css_select2');

                $this->load->view('general/css_upload');

                $this->load->view('general/css_date');

                $this->load->view('general/css_datatable');

                $this->load->view('general/menuv2');

                $this->load->view('general/menu_header',$info_menu);

                $this->load->view('cxc/alta_cxc_cliente');

                $this->load->view('general/footer');

                $this->load->view('cxc/acciones_cxc_cliente',$datos_select);



            }else{



                redirect("Login");



            }



        } 

       

    }



    public function showCliente(){



        $query="SELECT id,rfc,nombre,comercial FROM `alta_clientes` WHERE estatus = 0 ORDER BY nombre ASC";



            echo json_encode( $this->General_Model->infoxQuery($query) );



    }


    public function showMovimientos(){

        $data_post=$this->input->post();

        $query="SELECT a.fecha_banco,a.hora_banco,a.id,a.rastreo,b.cuenta,c.comercial,a.importe, CONCAT_WS('/',a.id,a.importe) AS dato
                FROM saldo_bancos a, cuentas_bancariasxcliente b, alta_bancos c
                WHERE a.idcuenta=b.id
                AND b.idbanco=c.id
                AND a.estatus=0
                AND b.idcliente=".$data_post["idcli"];

        echo json_encode( $this->General_Model->infoxQuery($query) );

    }


    public function showNotasxcliente(){

        $data_post=$this->input->post();

        $query='SELECT a.id, CONCAT_WS("",c.serie,c.folio) AS foliox,d.nombre AS ciente,d.id AS idcliente,a.total
                FROM `alta_nota_credito` a, alta_factura b, folio_nota_credito c, alta_clientes d
                WHERE a.idfactura=b.id
                AND a.idfolio=c.id
                AND b.idcliente=d.id
                AND b.idcliente='.$data_post["idcliente"].'
                AND a.estatus IN(1,3)';
        echo json_encode( $this->General_Model->infoxQuery($query) );

    }



    public function guardarPago(){



            $data_post = $this->input->post();



            $tipox=$data_post["tipo"];



            ////********** SOLSO SE PUEDEN PAGAR FACTURAS QUE SON POR PUE



            $data1 = array(



                        'fecha' => date("Y-m-d"),

                        'idusuario' => $data_post["iduser"],

                        'idfactura' => $data_post["editid"],

                        'total' => $data_post["pagox"],

                        'comprobante' => $data_post["comprobantex"],

                        'idmovimiento' =>$data_post["lista_movx"],

                        'tipo' => $tipox,

                        'pdf' => $data_post["pdf_ppd"],

                        'xml' => $data_post["xml"]

                        

            );



            $table1="alta_pago_cxc";///tabla que referencia a lops pago PUE y PPD fuera del sistema

            $alta = $this->General_Model->altaERP($data1,$table1);



            if ( $alta > 0 ) {

                

                if ( $tipox == 0 ) {



                    //////********** ACTUALIZAR ESTATUS PAGO FACTURA



                    if ( $data_post["xcobrar"] ==  $data_post["pagox"]  OR $data_post["pagox"] > $data_post["xcobrar"] ) {

                        

                        $datos = array('pago' => 1 );

                        $tabla = "alta_factura";

                        $condicion = array('id' =>$data_post["editid"]);



                        $lastupt=$this->General_Model->updateERP($datos,$tabla,$condicion);



                    }

                    

                }elseif ($tipox==1) {



                    //////********** ACTUALIZAR ESTATUS PAGO FACTURA



                    if ( $data_post["xcobrar"] ==  $data_post["pagox"]  OR $data_post["pagox"] > $data_post["xcobrar"] ) {



                        $datos = array('pago' => 1 );

                        $tabla = "alta_factura_sustitucion";

                        $condicion = array('id' =>$data_post["editid"]);



                        $lastupt=$this->General_Model->updateERP($datos,$tabla,$condicion);



                    }

                    

                }



                //////////////********* ALTA DEL PAGO EN TABLA DE PAGOS



                $data2 = array(



                        'fecha' => date("Y-m-d"),

                        'tipo' => $tipox,

                        'idfactura' => $data_post["editid"],

                        'comprobante' => $data_post["comprobantex"],

                        'pago' => 1,

                        'pdf' => $data_post["pdf_ppd"],

                        'xml' => $data_post["xml"]



                        

                );



                $table2="pagos_factura";

                $alta2 = $this->General_Model->altaERP($data2,$table2);



                /*$datos = array('pago' => 1 );

                $tabla = "alta_remision";

                $condicion = array('id' =>$data_post["iddocx"]);



                $lastupt=$this->General_Model->updateERP($datos,$tabla,$condicion);*/


                $importe_movimiento=$data_post["importe_movimiento"];


                if ($importe_movimiento>0) {
                   
                    ///////////// REVISAR EL ESTATUS DEL MOVIMIENTO PARA FINALIZARLO

                    $sql_pago='SELECT IFNULL(SUM(total),0) AS tot_pago
                                FROM alta_pago_cxc WHERE idmovimiento="'.$data_post["lista_movx"].'"
                                UNION ALL
                                SELECT IFNULL(SUM(a.pago),0) AS tot_pago   
                                FROM alta_pagos_ppd a
                                WHERE a.idppd=(SELECT x.id FROM alta_datos_ppd x WHERE x.idmovimiento_bancario="'.$data_post["lista_movx"].'" limit 0,1)';

                    $datos_pago=$this->General_Model->infoxQuery($sql_pago);

                    


                    if ($datos_pago != null) {

                        $total_pago=0;
                        
                        foreach ($datos_pago as $row) {
                            
                            $total_pago=$total_pago+$row->tot_pago;

                        }

                    }

                    $restante=$importe_movimiento-$total_pago;

                    if( $restante==0 OR $restante<0 ){

                        /////////// CAMBIAR ES ESTATUS DEL SALFDO DEL BANCO A APLICADO

                        $udatos=array('estatus'=>1);
                        $utabla="saldo_bancos";
                        $ucondicion=array('id'=>$data_post["lista_movx"] );

                        $this->General_Model->updateERP($udatos,$utabla,$ucondicion);

                    }

                }


            }


            echo json_encode($alta);



    }





    public function sumaTotal(){



        $data_post = $this->input->post();

        $estatus=trim($data_post["estatusx"]);



        switch ( $estatus ) {



                case 0:

                    //// ACTIVA

                    $sql ="SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,y.limite,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito



                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.idcliente='".$data_post['idcliente']."'



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,y.limite,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito



                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.idcliente=".$data_post['idcliente'];



                break;



                case 1:

                    //// ACTIVA

                    $sql ="SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,y.limite,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito



                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente='".$data_post['idcliente']."' 

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."' 



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,y.limite,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar,



                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito


                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente='".$data_post['idcliente']."' 

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."' ";



                break;



                case 2:

                    //// COBRADA

                    $sql ="SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0) AS xpagar,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito



                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 1

                    AND x.idcliente='".$data_post['idcliente']."' 



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,y.limite,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0) AS xpagar,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito



                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 1

                    AND x.idcliente=".$data_post['idcliente'];

                    

                break;



                case 3:

                    ///// VENCIDA

                    $sql ="SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,y.limite,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito



                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$data_post['idcliente']."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."' 



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,y.limite,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito



                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$data_post['idcliente']."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."' ";

                    

                break;



                case 4:

                    //// CANCELADA

                    $sql ="SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,y.limite,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS xpagar,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito



                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 2

                    AND x.idcliente='".$data_post['idcliente']."'



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,y.limite,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS xpagar,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito



                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 2

                    AND x.idcliente=".$data_post['idcliente'];

                    

                break;

                

        } 





        $datos_sql=$this->General_Model->infoxQuery($sql);

            $total=0;/// este total es el pagado por complementos o desde el sistema de pagos cxc



            $total_neto=0;

            $total_ncredito=0;

            $limitex=0;


        if ( $datos_sql != null ) {


            foreach ($datos_sql as $row) {



                      



                            $sumatotal = 0;

                            

                            $sql2="SELECT a.pago AS pagado, 

                            (SELECT x.idcpd FROM alta_datos_ppd x WHERE x.id=a.idppd) AS iddatocpp

                            FROM alta_pagos_ppd a WHERE a.idfactura=".$row->id." AND a.tipo=".$row->tipox;



                            $datos_sql2=$this->General_Model->infoxQuery($sql2);



                            if ($datos_sql2 != null ) {

                            

                                foreach($datos_sql2 as $row2) {

                                       

                                    //// VALIDAR QUE EL COMPLEMENTO DE PAGO ESTE FACTURADO 



                                    $sql3="SELECT a.estatus

                                    FROM alta_ppd a WHERE a.id=".$row2->iddatocpp;



                                    $datos_sql3=$this->General_Model->infoxQuery($sql3);



                                    foreach($datos_sql3 as $row3) {



                                        if ( $row3->estatus == 1 ) {

                                            

                                            $sumatotal=$sumatotal+$row2->pagado;



                                        }



                                    }



                                }



                            }



                            $total=$total+$sumatotal;





                            //////////************ SUMAR LOS PAGOS FUERA DEL SISTEMA



                            $sql3="SELECT SUM(total) AS totalx FROM `alta_pago_cxc` WHERE idfactura=".$row->id." AND tipo=".$row->tipox;

                            $datos_sql3=$this->General_Model->infoxQueryUnafila($sql3);



                            if ( $datos_sql3 != null ) {

                                

                                $total=$total+$datos_sql3->totalx;



                            }


                $total_neto=$total_neto+$row->total;



                $total_ncredito=$total_ncredito+$row->totncredito;

                $limitex=$row->limite;



            }



            echo json_encode( array('total'=>$total_neto, 'pagado'=>$total, 'ncredito'=>$total_ncredito, 'limite'=>$limitex ) );



        }else{

            $sql_cliente='SELECT limite FROM alta_clientes WHERE id='.$data_post['idcliente'];

            $row_cliente=$this->General_Model->infoxQueryUnafila($sql_cliente);


            echo json_encode( array('total'=>0, 'pagado'=>0, 'ncredito'=>0, 'limite'=>$row_cliente->limite ) );



        }  



    }


    public function AplicarNota(){

        $data_post = $this->input->post();

        $idncx=trim($data_post["idnc"]);
        $xpagar_factura=trim($data_post["xpagarx"]);

        $data="total";
        $tabla="alta_nota_credito";
        $condicion=array('id'=>$idncx);

        $datos=$this->General_Model->SelectUnafila($data,$tabla,$condicion);

        /////////REVISAMOS SI LA NOTA DE CREDITO NO HA SIDO APLICADA Y DE SER ASI QUE SALDO LE SOBRA 

        $sql="SELECT SUM(importe) AS total_nc_aplicado FROM `aplicacion_pagos_nc` WHERE idnota=".$idncx." AND estatus=0";

        $datos2=$this->General_Model->infoxQueryUnafila($sql);

        $total_nc_activo=($datos->total)-($datos2->total_nc_aplicado);

        if($xpagar_factura>$total_nc_activo){
           
            ////////la nota de credito concluye

            ///////AÑADIMOS EL PAGO A LA TABLA DE PAGOS _NC

            $adatos=array(

                'fecha'=> date("Y-m-d"),
                'iduser'=> trim($data_post["idusuario"]),
                'idnota'=> trim($idncx),
                'idfactura'=> trim($data_post["idfactura_aplicar"]),
                'tipo'=> $data_post["idtipo"],
                'importe'=> $total_nc_activo 

            );
            $atabla="aplicacion_pagos_nc";
            $alta=$this->General_Model->altaERP($adatos,$atabla);


            if ($alta>0) {
                

                /////////*************CAMBIAMOS EL ESTATUS DE LA NC A CONCLUIDA
                $udatos=array('estatus' => 2);
                $utabla="alta_nota_credito";
                $ucondicion=array('id'=>$idncx);

                $this->General_Model->updateERP($udatos,$utabla,$ucondicion);

                echo  json_encode(true);
            }else{

                echo  json_encode(false);

            }

        }elseif($xpagar_factura==$total_nc_activo){
            
            /////////// CONCLUYE LA NOTA DE CREDITO Y LA FACTURA

            $adatos=array(

                'fecha'=> date("Y-m-d"),
                'iduser'=> trim($data_post["idusuario"]),
                'idnota'=> trim($idncx),
                'idfactura'=> trim($data_post["idfactura_aplicar"]),
                'tipo'=> $data_post["idtipo"],
                'importe'=> $total_nc_activo 

            );
            $atabla="aplicacion_pagos_nc";
            $alta=$this->General_Model->altaERP($adatos,$atabla);


            if ($alta>0) {
                

                /////////*************CAMBIAMOS EL ESTATUS DE LA NC A CONCLUIDA
                $udatos=array('estatus' => 2);
                $utabla="alta_nota_credito";
                $ucondicion=array('id'=>$idncx);

                $this->General_Model->updateERP($udatos,$utabla,$ucondicion);

                ///////******************CAMBIAMOS A ESTATUS DE PAGADA LA FACTURA

                $udatos2=array('pago'=>1);
                $ucondicion2=array('id'=>$data_post["idfactura_aplicar"]);

                if ($data_post["idtipo"]==0) {

                    $utabla2="alta_factura";
                    
                    

                }elseif ($data_post["idtipo"]==1) {
                    
                    $utabla2="alta_factura_sustitucion";

                }

                $this->General_Model->updateERP($udatos2,$utabla2,$ucondicion2);

                echo json_encode(true);

            }else{


                echo json_encode(false);

            }

        }elseif($total_nc_activo>$xpagar_factura) {


            $saldo_insoluto_nota=$total_nc_activo-$xpagar_factura;
            
            /////////////VENCE LA FACTURA MAS NO LA NOTA 

            $adatos=array(

                'fecha'=> date("Y-m-d"),
                'iduser'=> trim($data_post["idusuario"]),
                'idnota'=> trim($idncx),
                'idfactura'=> trim($data_post["idfactura_aplicar"]),
                'tipo'=> $data_post["idtipo"],
                'importe'=> $saldo_insoluto_nota

            );
            $atabla="aplicacion_pagos_nc";
            $alta2=$this->General_Model->altaERP($adatos,$atabla);


            if ($alta2>0) {
                
                ////////// CAMBIAR EL ESTATUS DE LA NOTA A PARCIAL
                $udatos=array('estatus' => 1);
                $utabla="alta_nota_credito";
                $ucondicion=array('id'=>$idncx);

                $this->General_Model->updateERP($udatos,$utabla,$ucondicion);

                echo json_encode(true);

            }else{

                echo json_encode(false);

            }

        }



    }


    public function showPagosFactura(){

        $data_post=$this->input->post();

        $info_pagos=array();

        $datos_pago="";

        /////////*************** AÑADIMOS COMPLEMENTOS DE PAGO

        $sql1='SELECT a.id,a.npago,a.pago,CONCAT_WS("",d.serie,d.folio) AS foliox,c.fecha, "0" AS tpago
                FROM alta_pagos_ppd a, alta_datos_ppd b, alta_ppd c, folio_ppd d
                WHERE a.idppd=b.id
                AND b.idcpd=c.id
                AND c.idfolio=d.id
                AND a.idfactura='.$data_post["idfacturax"].'
                AND a.tipo='.$data_post["tipox"].'
                AND c.estatus=1';

        $datos_ppd=$this->General_Model->infoxQuery($sql1);

        if ( $datos_ppd!=null ) {
            
            foreach ($datos_ppd as $row) {
              
              $datos_pago=array('npago'=>$row->npago,'pago'=>$row->pago, 'folio'=>$row->foliox, 'fecha'=>$row->fecha, 'tpago'=>$row->tpago, 'comprobante'=>'' );
              array_push($info_pagos,$datos_pago);

            }

        }


        ////////////****************** AÑADIMOS PAGOS EN UNA SOLA EXHIBICION O PPD FUERA DEL SISTEMA


        $sql2='SELECT a.comprobante,a.total,IFNULL(b.movimiento,"") AS movimientox, IF(a.idmovimiento>0,2,1) AS tpago, IF(a.idmovimiento>0,b.fecha_banco,a.fecha) AS fechax
                FROM alta_pago_cxc a
                LEFT JOIN saldo_bancos b ON a.idmovimiento=b.id,
                alta_factura c, folio_factura d
                WHERE a.idfactura=c.id
                AND c.idfolio=d.id
                AND a.idfactura='.$data_post["idfacturax"].'
                AND a.tipo='.$data_post["tipox"];

        $datos_ppd2=$this->General_Model->infoxQuery($sql2);

        if ( $datos_ppd2!=null ) {
            
            foreach ($datos_ppd2 as $row2) {
              
              $datos_pago=array('npago'=>'0','pago'=>$row2->total, 'folio'=>$row2->movimientox, 'fecha'=>$row2->fechax, 'tpago'=>$row2->tpago, 'comprobante'=>$row2->comprobante );
              array_push($info_pagos,$datos_pago);

            }

        }

        echo json_encode($info_pagos);

    }







        //////////////********************* PARTIDAS POR BUSCADOR



        public function loadBuscar(){



            $data_post = $this->input->get();



            $estatus=trim($data_post["estatusx"]);





            switch ( $estatus ) {

                
                case 0:

                    //// TODOS

                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.idcliente='".$data_post['buscar']."'



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.idcliente='".$data_post['buscar']."')temp";



                break;



                case 1:

                    //// ACTIVA

                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente='".$data_post['buscar']."' 

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."' 



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente='".$data_post['buscar']."' 

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."' )temp";



                break;



                case 2:

                    //// COBRADA

                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0) AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 1

                    AND x.idcliente='".$data_post['buscar']."' 



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0) AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 1

                    AND x.idcliente='".$data_post['buscar']."' )temp";

                    

                break;



                case 3:

                    ///// VENCIDA

                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$data_post['buscar']."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."' 



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$data_post['buscar']."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."'



                    )temp";

                    

                break;



                case 4:

                    //// CANCELADA

                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 2

                    AND x.idcliente='".$data_post['buscar']."'



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 2

                    AND x.idcliente='".$data_post['buscar']."' )temp";

                    

                break;

                case 5:

                    /////// ACTIVAS MAS VENCIDAS

                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$data_post['buscar']."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."'

                    OR  

                    x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$data_post['buscar']."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."'

                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$data_post['buscar']."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."'

                    OR  

                    x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$data_post['buscar']."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."'

                    )temp";

                break;


                /*case 0:

                    //// TODOS

                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id AND z.estatus=1),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.idcliente='".$data_post['buscar']."'



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id AND z.estatus=1),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.idcliente='".$data_post['buscar']."')temp";



                break;



                case 1:

                    //// ACTIVA

                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id AND z.estatus=1),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente='".$data_post['buscar']."' 

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."' 



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id AND z.estatus=1),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente='".$data_post['buscar']."' 

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."' )temp";



                break;



                case 2:

                    //// COBRADA

                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0) AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id AND z.estatus=1),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 1

                    AND x.idcliente='".$data_post['buscar']."' 



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0) AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id AND z.estatus=1),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 1

                    AND x.idcliente='".$data_post['buscar']."' )temp";

                    

                break;



                case 3:

                    ///// VENCIDA

                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id AND z.estatus=1),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$data_post['buscar']."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."' 



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id AND z.estatus=1),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$data_post['buscar']."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."'



                    )temp";

                    

                break;



                case 4:

                    //// CANCELADA

                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id AND z.estatus=1),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 2

                    AND x.idcliente='".$data_post['buscar']."'



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id AND z.estatus=1),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 2

                    AND x.idcliente='".$data_post['buscar']."' )temp";

                    

                break;

                
                */
                

            }



            $primaryKey = 'id';

            

            $columns = array(



                /*<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    Default <span class="caret"></span>

                                  </button>*/



                array( 'db' => 'boton',     'dt' => 0,



                        'formatter' => function( $d, $row ) {



                            $separar= explode("/", $d);



                            if ( $separar[2] == 1 ) {

                                

                                if ( $separar[1] == 1) {

                                

                                    //////// pagado

                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">


                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="#" style="color:green; font-weight:bold;" data-toggle="modal" data-target="#modal_pagos"> <i class="fa fa-eye" style="color:green; font-weight:bold;"></i> Ver pagos</a></li>


                                      </ul>

                                    </div>';



                                }else{



                                    /*return '<a class="btn btn-success" data-toggle="modal" data-target="#exampleModal" role="button" target="_blank"><i class="fa fa-money" title="Agregar cobro" ></i></a>';*/



                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="#" style="color:darkgreen; font-weight:bold;" data-toggle="modal" data-target="#exampleModal"> <i class="fa fa-money" style="color:darkgreen; font-weight:bold;"></i> Cobrar</a></li>



                                        <li><a href="#" style="color:red; font-weight:bold;" data-toggle="modal" data-target="#modalnota"> <i class="fa fa-file-o" style="color:red; font-weight:bold;"></i> Nota credito</a></li>



                                      </ul>

                                    </div>';



                                }

                            

                            }else if ( $separar[2] == 2 ) {

                                

                                return '';



                            }



                            



                            



                        }  

                ),



                array( 'db' => 'est_pago',     'dt' => 1,



                        'formatter' => function( $d, $row ) {



                                $separar= explode("/", $d);





                                if ( $separar[2] == 1 ) {

                                    

                                    if ( $separar[1] == 1) {

                                

                                        //////// pagado

                                        return '<p style="color:green; font-weight:bold;" >COBRADA</p>';



                                    }else{



                                        

                                        if ( $separar[0] == 1 ) {

                                            

                                            ////////// VENCIDA

                                            return '<p style="color:red; font-weight:bold;" >VENCIDA</p>';



                                        }else{



                                            ////////// ACTIVA

                                            return '<p style="color:darkblue; font-weight:bold;" >ACTIVA</p>';



                                        }



                                    }



                                }else if ( $separar[2] == 2 ) {

                                    

                                    return '<p style="color:#E1A009; font-weight:bold;" ><i class="fa fa-close"></i>CANCELADA</p>';



                                }



                                



                                //return $d;



                        }  

                ),



                //array( 'db' => 'documento',     'dt' => 2 ),



                array( 'db' => 'fol_fact',     'dt' => 2,



                        'formatter' => function( $d, $row ) {





                                return '<a href="'.base_url().'tw/php/facturas/'.$d.'.pdf" target="_blank">'.$d.'</a>';



                        }  

                ),

                

                //array( 'db' => 'cliente',     'dt' =>  ),



                array( 'db' => 'fecha',     'dt' => 3,



                        'formatter' => function( $d, $row ) {



                            return fechaLatino($d);

                        }  

                ),



                array( 'db' => 'dias',     'dt' => 4 ),



                array( 'db' => 'fcobro',     'dt' => 5,



                        'formatter' => function( $d, $row ) {



                            return fechaLatino($d);

                        }  

                ),

               

                array( 'db' => 'subtotal',        

                        'dt' => 6,

                        'formatter' => function( $d, $row ) {



                            return "<p>".wims_currency($d)."</p>";



                        }

                ), 



                array( 'db' => 'descuento',        

                        'dt' => 7,

                        'formatter' => function( $d, $row ) {



                            return "<p>".wims_currency($d)."</p>";



                        }

                ), 



                array( 'db' => 'iva',        

                        'dt' => 8,

                        'formatter' => function( $d, $row ) {



                            return "<p>".wims_currency($d)."</p>";



                        }

                ), 



                array( 'db' => 'total',        

                        'dt' => 9,

                        'formatter' => function( $d, $row ) {



                            return wims_currency($d);



                        }

                ),





                array( 'db' => 'totncredito',        

                        'dt' => 10,

                        'formatter' => function( $d, $row ) {



                            return "<p>".wims_currency($d)."</p>";



                        }

                ),



                array( 'db' => 'dpagos',        

                        'dt' => 11,

                        'formatter' => function( $d, $row ) {



                            $separar=explode("/", $d);



                            //'/',x.pago,x.id,x.total



                            return "<p>".wims_currency( Mptotal($separar[0],$separar[1],$separar[2],$separar[3]) )."</p>";



                        }

                ),



               

                array( 'db' => 'id',     'dt' => 13 ),



                array( 'db' => 'dias',     'dt' => 14 ),



                array( 'db' => 'tipox',     'dt' => 15 ),

                array( 'db' => 'tipox',     'dt' => 16 )

           

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



        /////////////////********************** PARTIDAS POR FECHAS



        public function buscarxFecha(){



            $data_post = $this->input->get();



            $estatus=trim($data_post["estatusx"]);





            switch ( $estatus ) {



                case 0:

                    //// ACTIVA

                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar,CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.idcliente='".$data_post['buscar']."'

                    AND x.fecha BETWEEN '".$data_post['inicio']."' AND '".$data_post['fin']."'



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.idcliente='".$data_post['buscar']."'

                    AND x.fecha BETWEEN '".$data_post['inicio']."' AND '".$data_post['fin']."'



                    )temp";





                break;



                case 1:

                    //// ACTIVA

                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente='".$data_post['buscar']."' 

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."'

                    AND x.fecha BETWEEN '".$data_post['inicio']."' AND '".$data_post['fin']."' 



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente='".$data_post['buscar']."' 

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."' 

                    AND x.fecha BETWEEN '".$data_post['inicio']."' AND '".$data_post['fin']."'



                    )temp";



                break;



                case 2:

                    //// COBRADA

                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0) AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 1

                    AND x.idcliente='".$data_post['buscar']."'

                    AND x.fecha BETWEEN '".$data_post['inicio']."' AND '".$data_post['fin']."' 



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0) AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 1

                    AND x.idcliente='".$data_post['buscar']."'

                    AND x.fecha BETWEEN '".$data_post['inicio']."' AND '".$data_post['fin']."' 

                    )temp";

                    

                break;



                case 3:

                    ///// VENCIDA

                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$data_post['buscar']."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."'

                    AND x.fecha BETWEEN '".$data_post['inicio']."' AND '".$data_post['fin']."' 



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$data_post['buscar']."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."'

                    AND x.fecha BETWEEN '".$data_post['inicio']."' AND '".$data_post['fin']."'



                    )temp";

                    

                break;



                case 4:

                    //// CANCELADA

                    $table ="(SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 2

                    AND x.idcliente='".$data_post['buscar']."'

                    AND x.fecha BETWEEN '".$data_post['inicio']."' AND '".$data_post['fin']."'



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS cobrado, x.total-IFNULL( (SELECT i.total FROM `alta_pago_cxc` i WHERE i.idfactura = x.id),0 ) AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( IFNULL( (SELECT SUM(z.total) FROM alta_nota_credito AS z WHERE z.idfactura=x.id),0)+ IFNULL((SELECT SUM(w.total) FROM notas_credito_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0 ),0) ) AS totncredito

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 2

                    AND x.idcliente='".$data_post['buscar']."'

                    AND x.fecha BETWEEN '".$data_post['inicio']."' AND '".$data_post['fin']."' )temp";

                    

                break;

                

                

            }





            $primaryKey = 'id';

            

            $columns = array(



                /*<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    Default <span class="caret"></span>

                                  </button>*/



                array( 'db' => 'boton',     'dt' => 0,



                        'formatter' => function( $d, $row ) {



                            $separar= explode("/", $d);



                            if ( $separar[2] == 1 ) {

                                

                                if ( $separar[1] == 1) {


                                    //////// pagado

                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">


                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="#" style="color:green; font-weight:bold;" data-toggle="modal" data-target="#modal_pagos"> <i class="fa fa-eye" style="color:green; font-weight:bold;"></i> Ver pagos</a></li>


                                      </ul>

                                    </div>';



                                }else{



                                    return '<a class="btn btn-success" data-toggle="modal" data-target="#exampleModal" role="button" target="_blank"><i class="fa fa-money" title="Agregar cobro" ></i></a>';



                                }

                            

                            }else if ( $separar[2] == 2 ) {

                                

                                return '';



                            }



                            



                            



                        }  

                ),



                array( 'db' => 'est_pago',     'dt' => 1,



                        'formatter' => function( $d, $row ) {



                                $separar= explode("/", $d);





                                if ( $separar[2] == 1 ) {

                                    

                                    if ( $separar[1] == 1) {

                                

                                        //////// pagado

                                        return '<p style="color:green; font-weight:bold;" >COBRADA</p>';



                                    }else{



                                        

                                        if ( $separar[0] == 1 ) {

                                            

                                            ////////// VENCIDA

                                            return '<p style="color:red; font-weight:bold;" >VENCIDA</p>';



                                        }else{



                                            ////////// ACTIVA

                                            return '<p style="color:darkblue; font-weight:bold;" >ACTIVA</p>';



                                        }



                                    }



                                }else if ( $separar[2] == 2 ) {

                                    

                                    return '<p style="color:#E1A009; font-weight:bold;" ><i class="fa fa-close"></i>CANCELADA</p>';



                                }



                                



                                //return $d;



                        }  

                ),



                 array( 'db' => 'fol_fact',     'dt' => 2,



                        'formatter' => function( $d, $row ) {





                                return '<a href="'.base_url().'tw/php/facturas/'.$d.'.pdf" target="_blank">'.$d.'</a>';



                        }  

                ),

                

                //array( 'db' => 'cliente',     'dt' =>  ),



                array( 'db' => 'fecha',     'dt' => 3,



                        'formatter' => function( $d, $row ) {



                            return fechaLatino($d);

                        }  

                ),



                array( 'db' => 'dias',     'dt' => 4 ),



                array( 'db' => 'fcobro',     'dt' => 5,



                        'formatter' => function( $d, $row ) {



                            return fechaLatino($d);

                        }  

                ),

               

                array( 'db' => 'subtotal',        

                        'dt' => 6,

                        'formatter' => function( $d, $row ) {



                            return "<p>".wims_currency($d)."</p>";



                        }

                ), 



                array( 'db' => 'descuento',        

                        'dt' => 7,

                        'formatter' => function( $d, $row ) {



                            return "<p>".wims_currency($d)."</p>";



                        }

                ), 



                array( 'db' => 'iva',        

                        'dt' => 8,

                        'formatter' => function( $d, $row ) {



                            return "<p>".wims_currency($d)."</p>";



                        }

                ), 



                array( 'db' => 'total',        

                        'dt' => 9,

                        'formatter' => function( $d, $row ) {



                            return "<p>".wims_currency($d)."</p>";



                        }

                ),





                array( 'db' => 'totncredito',        

                        'dt' => 10,

                        'formatter' => function( $d, $row ) {



                            return "<p>".wims_currency($d)."</p>";



                        }

                ),



                array( 'db' => 'dpagos',        

                        'dt' => 11,

                        'formatter' => function( $d, $row ) {



                            $separar=explode("/", $d);



                            //'/',x.pago,x.id,x.total



                            return "<p>".wims_currency( Mptotal($separar[0],$separar[1],$separar[2],$separar[3]) )."</p>";



                        }

                ),



               

                array( 'db' => 'id',     'dt' => 13 ),



                array( 'db' => 'dias',     'dt' => 14 ),



                array( 'db' => 'tipox',     'dt' => 15 ),

                array( 'db' => 'tipox',     'dt' => 16 )

           

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



}

