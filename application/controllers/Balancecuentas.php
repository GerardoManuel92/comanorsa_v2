<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'third_party/ssp.php';

class Balancecuentas extends CI_Controller
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

        function obtenerFechaEnLetra($fecha){
            $num = date("j", strtotime($fecha));
            $anno = date("Y", strtotime($fecha));
            $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
            $mes = $mes[(date('m', strtotime($fecha))*1)-1];
            return $num.'-'.strtoupper($mes).'-'.$anno;
        }
        
    }

    public function index()
    {

        $numero_menu = 19;

        ////////******* verificar menu 

        $vtabla = "menus_departamento";
        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);
        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);

        if ( $verificar_menu > 0 ) {

             $iduser = $this->session->userdata(IDUSERCOM);

            if($iduser > 0){
            
                $info_menu = array('nommenu' => "balance_cuentas");
                $data["idusuario"] = $iduser;

                $this->load->view('general/header');
                $this->load->view('general/css_select2');
                $this->load->view('general/css_upload');
                $this->load->view('general/css_date');
                $this->load->view('general/css_datatable');
                $this->load->view('general/css_key_table');
                $this->load->view('general/menuv2');
                $this->load->view('general/menu_header',$info_menu);
                $this->load->view('balance/body_balance');
                $this->load->view('general/footer');
                $this->load->view('balance/acciones_balance',$data);

            }else{

                redirect("Login");

            } 

        }
        
       
    }

    public function showCliente(){

        $query="SELECT id,nombre,comercial FROM `alta_clientes` WHERE estatus = 0 ORDER BY nombre ASC";

            echo json_encode( $this->General_Model->infoxQuery($query) );

    }

    public function showCuentas(){

        $query="SELECT a.cuenta,b.comercial,a.id
                FROM alta_cuentas_comanorsa a, alta_bancos b
                WHERE a.idbanco=b.id AND a.estatus=0";

            echo json_encode( $this->General_Model->infoxQuery($query) );

    }

    public function showFpago(){

        $query="SELECT id, clave, descripcion FROM `sat_catalogo_fpago` WHERE estatus = 0 ORDER BY descripcion ASC";

            echo json_encode( $this->General_Model->infoxQuery($query) );
        
    }

    public function actualizarMov(){

        $data_post = $this->input->post();

        $idcuenta=0;        

            ///verificar si la cuenta pertenece algun cliente

            $condicion=array('cuenta'=>$data_post["cuentax"]);
            $tabla2="cuentas_bancariasxcliente";

            $repeat=$this->General_Model->verificarRepeat($tabla2,$condicion);

            if ($repeat>0) {

                ///COINCIDE CON UNA CUENTA DE CLIENTE

                $sdata="id";
                $stabla="cuentas_bancariasxcliente";
                $scondicion=array('cuenta'=>$data_post["cuentax"]);

                $srow=$this->General_Model->SelectUnafila($sdata,$stabla,$scondicion);

                $idcuenta=$srow->id;

            }

            $udatos=array(

                'fecha_banco' => $data_post["bfechax"],
                'hora_banco' => $data_post["bhorax"],
                'movimiento' => $data_post["movimientox"],
                'cuenta' => $data_post["cuentax"],
                'rastreo' => $data_post["rastreox"],
                'tipo' => $data_post["tipox"],
                'importe' => $data_post["importex"],
                'idcuenta'=>$idcuenta,
                'fpago'=>$data_post["xfpago"]

            );

            $utabla="saldo_bancos";
            $ucondicion=array('id'=>$data_post["idx"]);

            $update=$this->General_Model->updateERP($udatos,$utabla,$ucondicion);

            if($update) {
                
                ///////mostrar datos

                $sql='SELECT a.id,a.fecha_banco, a.hora_banco,a.movimiento,a.descripcion,a.rastreo,CONCAT_WS("/",a.tipo,a.importe) AS importex, CONCAT_WS(" | ",a.cuenta,d.comercial) AS cuentax,IFNULL(c.nombre,"No identificado") AS nombrex,a.estatus,a.tipo,a.importe,a.cuenta
                FROM saldo_bancos a
                LEFT JOIN cuentas_bancariasxcliente b ON a.idcuenta=b.id
                LEFT JOIN alta_bancos d ON b.idbanco=d.id 
                LEFT JOIN alta_clientes c ON b.idcliente=c.id
                WHERE
                a.estatus=0
                AND a.id='.$data_post["idx"];

                echo json_encode( $this->General_Model->infoxQueryUnafila($sql) );

            }else{

                echo json_encode(null);

            }


    }

    public function aplicarPago(){

        $data_post=$this->input->post();

        $ejemplo=array();

        ////////// separar los que son PUE 

        for ($i=0; $i<count($data_post["ids"]); $i++) { 
            
            $dcredito=$data_post["creditos"][$i];
            $saldo_aplicado=$data_post["saldos"][$i];
            $total_factura=$data_post["tot_facturas"][$i];
            $tipox=$data_post["tipos"][$i];

            if($dcredito==0 && $saldo_aplicado>0){
                
                //APLICAR EL SALDO PUE

                

                ////********** SOLSO SE PUEDEN PAGAR FACTURAS QUE SON POR PUE

                $data1 = array(



                            'fecha' => date("Y-m-d"),

                            'idusuario' => $this->session->userdata(IDUSERCOM),

                            'idfactura' => $data_post["ids"][$i],

                            'total' => $saldo_aplicado,

                            'idmovimiento' =>$data_post["idmovimiento"],

                            'tipo' => $tipox

                            

                );



                $table1="alta_pago_cxc";///tabla que referencia a lops pago PUE y PPD fuera del sistema

                $alta = $this->General_Model->altaERP($data1,$table1);


                if ( $alta > 0 ) {

                

                    if ( $tipox == 0 ) {



                        //////********** ACTUALIZAR ESTATUS PAGO FACTURA



                        if ( $saldo_aplicado == $total_factura ) {

                            

                            $datos = array('pago' => 1 );

                            $tabla = "alta_factura";

                            $condicion = array('id' =>$data_post["ids"][$i]);



                            $lastupt=$this->General_Model->updateERP($datos,$tabla,$condicion);



                        }

                        

                    }elseif ($tipox==1) {



                        //////********** ACTUALIZAR ESTATUS PAGO FACTURA



                        if ( $saldo_aplicado == $total_factura ) {



                            $datos = array('pago' => 1 );

                            $tabla = "alta_factura_sustitucion";

                            $condicion = array('id' =>$data_post["ids"][$i]);



                            $lastupt=$this->General_Model->updateERP($datos,$tabla,$condicion);



                        }

                        

                    }

                    //////////////********* ALTA DEL PAGO EN TABLA DE PAGOS



                    $data2 = array(



                            'fecha' => date("Y-m-d"),

                            'tipo' => $tipox,

                            'idfactura' => $data_post["ids"][$i],

                            'pago' => 1
   

                    );



                    $table2="pagos_factura";

                    $alta2 = $this->General_Model->altaERP($data2,$table2);



                    /*$datos = array('pago' => 1 );

                    $tabla = "alta_remision";

                    $condicion = array('id' =>$data_post["iddocx"]);



                    $lastupt=$this->General_Model->updateERP($datos,$tabla,$condicion);*/


                    $importe_movimiento=$data_post["abono_movimiento"];


                    if ($importe_movimiento>0) {
                       
                        ///////////// REVISAR EL ESTATUS DEL MOVIMIENTO PARA FINALIZARLO

                        $sql_pago='SELECT IFNULL(SUM(total),0) AS tot_pago
                                    FROM alta_pago_cxc WHERE idmovimiento="'.$data_post["idmovimiento"].'"
                                    UNION ALL
                                    SELECT IFNULL(SUM(a.pago),0) AS tot_pago   
                                    FROM alta_pagos_ppd a
                                    WHERE a.idppd=(SELECT x.id FROM alta_datos_ppd x WHERE x.idmovimiento_bancario="'.$data_post["idmovimiento"].'" limit 0,1)';

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
                            $ucondicion=array('id'=>$data_post["idmovimiento"] );

                            $this->General_Model->updateERP($udatos,$utabla,$ucondicion);

                        }

                    }


                }

            }

        }


        //echo json_encode($ejemplo);

        echo json_encode(true);


    }

    public function devolucionPago(){

        $data_post=$this->input->post();

        $datos=array('estatus'=>2);
        $tabla="saldo_bancos";
        $condicion=array('id' => $data_post["idsaldox"]);

        echo json_encode($this->General_Model->updateERP($datos,$tabla,$condicion) );

    }

    public function showFacturas(){

        $data = array();
        $pregunta = array();

        $data_post=$this->input->post();

        /*$table="SELECT x.id, x.pago,'0' AS tipox, x.total, CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,x.dias, CONCAT_WS('',z.serie,z.folio) AS fol_fact, ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito, TIMESTAMPDIFF(DAY, x.fecha, '2023-06-10') AS dias_transcurridos

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='11'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '2023-06-10'

                    OR  

                    x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='11'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '2023-06-10'

                    UNION ALL



                    SELECT x.id, x.pago,'0' AS tipox, x.total, CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,x.dias, CONCAT_WS('',z.serie,z.folio) AS fol_fact, ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito, TIMESTAMPDIFF(DAY, x.fecha, '2023-06-10') AS dias_transcurridos

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='11'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '2023-06-10'

                    OR  

                    x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='11'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '2023-06-10' ";*/

            $table ="SELECT x.id, x.pago,'0' AS tipox, x.total, CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,x.dias, CONCAT_WS('',z.serie,z.folio) AS fol_fact, ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito, TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$data_post['idclientex']."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."'

                    OR  

                    x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$data_post['idclientex']."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."'

                    UNION ALL



                    SELECT x.id, x.pago,'1' AS tipox, x.total, CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,x.dias, CONCAT_WS('',z.serie,z.folio) AS fol_fact, ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito, TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$data_post['idclientex']."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."'

                    OR  

                    x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$data_post['idclientex']."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."' ";

            $datos_sql=$this->General_Model->infoxQuery($table);



                
                $total_neto=0;
                $total_ncredito=0;

                $dias_mayor_factura=0;

                if ( $datos_sql != null ) {


                    foreach ($datos_sql as $row) {


                                    $sumatotal = 0;

                                    $total_vencido=0;

                                    $total=0;/// este total es el pagado por complementos o desde el sistema de pagos cxc

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



                                    }else{

                                        $sumatotal=0;

                                    }



                                    $total=$total+$sumatotal;





                                    //////////************ SUMAR LOS PAGOS FUERA DEL SISTEMA



                                    $sql3="SELECT SUM(total) AS totalx FROM `alta_pago_cxc` WHERE idfactura=".$row->id." AND tipo=".$row->tipox;

                                    $datos_sql3=$this->General_Model->infoxQueryUnafila($sql3);



                                    if ( $datos_sql3 != null ) {

                                        

                                        $total=$total+$datos_sql3->totalx;



                                    }


                                    $total_neto=$row->total;


                                    $total_ncredito=$total_ncredito+$row->totncredito;

                                  

                    


                                    $total_vencido=$total_neto-$total-$total_ncredito;


                                    //////*********** DATOS DEL CLIENTE 

                                    $pregunta=array(

                                            'id'=>$row->id,    
                                            'folio'=>$row->fol_fact,
                                            'dias' =>$row->dias,
                                            'saldo'=>wims_currency($total_vencido),
                                            'transcurridos'=>$row->dias_transcurridos,
                                            'credito'=>$row->dias,
                                            'tipo'=>$row->tipox

                                    );



                                array_push($data, $pregunta);


                    }


                    //$data = array("data"=>$pregunta);
                    //header('Content-type: application/json');
                    echo json_encode($data);
    
                }else{

                    echo json_encode(null);

                }


                         

                 



    }



        ///////////****************TABLA PARTIDAS BITACORA

        public function loadPartidas()
        {

            $data_get = $this->input->get();

            $where="";

            if( $data_get["idclientex"] >0 ) {
                
                if($data_get["estx"]==5) {
                    
                    //////
                     $where="WHERE a.estatus='0' AND a.idcuenta>0 AND a.tipo=2 AND b.idcliente=".$data_get["idclientex"]." AND (SELECT z.id FROM alta_factura z WHERE z.estatus=1 AND z.dias = 0 AND z.idcliente=c.id AND z.pago=0 LIMIT 0,1)
                
                        OR a.estatus='0' AND a.idcuenta>0 AND a.tipo=2 AND b.idcliente=".$data_get["idclientex"]." AND (SELECT z.id FROM alta_factura_sustitucion z WHERE z.estatus=1 AND z.dias = 0 AND z.idcliente=c.id AND z.pago=0 LIMIT 0,1)";

                }elseif($data_get["estx"]==3) {
                    
                    //////abono sin aplicar
                     $where="WHERE a.estatus='0' AND a.idcuenta>0 AND a.tipo=2 AND b.idcliente=".$data_get["idclientex"];

                }elseif($data_get["estx"]==2) {
                    
                    $where="WHERE b.idcliente=".$data_get["idclientex"]." AND a.estatus!=3";

                }elseif($data_get["estx"]==1) {
                    
                    ///// APLICADOS
                    $where="WHERE a.estatus=".$data_get["estx"]." AND b.idcliente=".$data_get["idclientex"];

                }elseif($data_get["estx"]==0) {
                    
                    /////// SIN APLICAR
                    $where="WHERE a.estatus=".$data_get["estx"]." AND b.idcliente=".$data_get["idclientex"];
                }

            }else{

                if($data_get["estx"]==5) {
                    
                    //////
                     $where="WHERE a.estatus='0' AND a.idcuenta>0 AND a.tipo=2 AND b.idcliente>0 AND (SELECT z.id FROM alta_factura z WHERE z.estatus=1 AND z.dias = 0 AND z.idcliente=c.id AND z.pago=0 LIMIT 0,1)
                
                        OR a.estatus='0' AND a.idcuenta>0 AND a.tipo=2 AND b.idcliente>0 AND (SELECT z.id FROM alta_factura_sustitucion z WHERE z.estatus=1 AND z.dias = 0 AND z.idcliente=c.id AND z.pago=0 LIMIT 0,1)";

                }elseif($data_get["estx"]==4) {

                    # ABONO NO IDENTIFICADO
                    $where="WHERE a.estatus='0' AND a.idcuenta=0 AND a.tipo=2";

                }elseif($data_get["estx"]==3) {
                    
                    //////abono sin aplicar
                     $where="WHERE a.estatus='0' AND a.idcuenta>0 AND a.tipo=2";

                }elseif($data_get["estx"]==2) {
                    
                    $where="WHERE a.estatus!=3";

                }elseif($data_get["estx"]==1) {
                    
                    ///// APLICADOS
                    $where="WHERE a.estatus=".$data_get["estx"];

                }elseif($data_get["estx"]==0) {
                    
                    /////// SIN APLICAR
                    $where="WHERE a.estatus=".$data_get["estx"];

                }
            }


            $table='(SELECT a.id,CONCAT_WS("/",a.id,a.estatus,a.idcuenta) AS acciones,a.fecha_banco, a.hora_banco,a.movimiento,a.descripcion,a.rastreo,CONCAT_WS("/",a.tipo,a.importe) AS importex, CONCAT_WS(" | ",a.cuenta,d.comercial) AS cuentax,IFNULL(c.nombre,"No identificado") AS nombrex,a.estatus,a.tipo,a.importe,a.cuenta,IFNULL(c.id,0) AS idclientex, IFNULL(e.descripcion,"s/aplicar") AS fpagox, a.fpago
                FROM saldo_bancos a
                LEFT JOIN cuentas_bancariasxcliente b ON a.idcuenta=b.id
                LEFT JOIN alta_bancos d ON b.idbanco=d.id 
                LEFT JOIN alta_clientes c ON b.idcliente=c.id
                LEFT JOIN sat_catalogo_fpago e ON a.fpago=e.id
                '.$where.' ORDER BY id DESC
                )temp';


            /*$table='(SELECT a.id,CONCAT_WS("/",a.id,a.estatus,a.idcuenta) AS acciones,a.fecha_banco, a.hora_banco,a.movimiento,a.descripcion,a.rastreo,CONCAT_WS("/",a.tipo,a.importe) AS importex, CONCAT_WS(" | ",a.cuenta,d.comercial) AS cuentax,IFNULL(c.nombre,"No identificado") AS nombrex,a.estatus,a.tipo,a.importe,a.cuenta,IFNULL(c.id,0) AS idclientex, IFNULL(e.descripcion,"s/aplicar") AS fpagox, a.fpago
                FROM saldo_bancos a
                LEFT JOIN cuentas_bancariasxcliente b ON a.idcuenta=b.id
                LEFT JOIN alta_bancos d ON b.idbanco=d.id 
                LEFT JOIN alta_clientes c ON b.idcliente=c.id
                LEFT JOIN sat_catalogo_fpago e ON a.fpago=e.id
                
                ORDER BY id DESC
                )temp';*/
  
            // Primary key of table
            $primaryKey = 'id';

            
            
            $columns = array(

               

                array( 'db' => 'acciones',     'dt' => 0,

                        'formatter' => function( $d, $row ) {

                            $separarx=explode("/", $d);


                            if($separarx[2]>0) {

                                ///// IDENTIFICADO

                                if( $separarx[1]==0 ) {
                                    
                                    //////sin aplicar

                                    return '<div class="btn-group">

                                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                        <span class="caret"></span>

                                          </button>

                                          <ul class="dropdown-menu">



                                            <li><a href="#" style="color:#E8B203; font-weight:bold;" data-toggle="modal" data-target="#modal-1"> <i class="fa fa-edit" style="color:#E8B203; font-weight:bold;"></i> Editar</a></li>


                                            <li><a href="#" style="color:darkgreen; font-weight:bold;" data-toggle="modal" data-target="#modal_facturas"> <i class="fa fa-money" style="color:darkgreen; font-weight:bold;"></i> Aplicar pago</a></li>

                                            <li><a href="javascript:devolucionPago('.$separarx[0].')" style="color:red; font-weight:bold;"><i class="fa fa-share    " style="color:red; font-weight:bold;"></i> Devolucion de pago</a></li>

                                          </ul>

                                        </div>';


                                }else if( $separarx[1]==1 ){

                                    ///// aplicado

                                    return '<div class="btn-group">

                                          <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                        <span class="caret"></span>

                                          </button>

                                          <ul class="dropdown-menu">


                                            <li><a href="#" style="color:darkgreen; font-weight:bold;" data-toggle="modal" data-target="#modal_saldadas"> <i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Ver facturas</a></li>





                                          </ul>

                                        </div>';

                                }else if( $separarx[1]==2 ){

                                    ///// devolucion

                                }

                            }else{


                                if ( $separarx[1]==2 ) {
                                    
                                    ////// devolucion

                                }else{


                                    //// NO IDENTIFICADO

                                    return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">



                                        <li><a href="#" style="color:#E8B203; font-weight:bold;" data-toggle="modal" data-target="#modal-1"> <i class="fa fa-edit" style="color:#E8B203; font-weight:bold;"></i> Editar</a></li>


                                        <li><a href="javascript:devolucionPago('.$separarx[0].')" style="color:red; font-weight:bold;"><i class="fa fa-share" style="color:red; font-weight:bold;"></i> Devolucion de pago</a></li>

                                      </ul>

                                    </div>';

                                }

                            }
                            

                        }  
                ),

                array( 'db' => 'estatus',     'dt' => 1,

                        'formatter' => function( $d, $row ) {

                           switch ($d) {
                                case 0:
                                
                                    $valor="<p style='color:orange; font-weight:bold;' >SIN APLICAR</p>";

                                break;

                                case 1:
                                      
                                    $valor="<p style='color:darkgreen; font-weight:bold;' >APLICADO</p>";

                                break;

                                case 2:
                                      
                                    $valor="<p style='color:red; font-weight:bold;' >DEVOLUCION</p>";

                                break;   
                               
                               
                           }

                           return $valor;

                        }  
                ),
                
                array( 'db' => 'fecha_banco',     'dt' => 2),

                array( 'db' => 'rastreo',     'dt' => 3),

                array( 'db' => 'cuentax',     'dt' => 4),

                array( 'db' => 'nombrex',     'dt' => 5),

                array( 'db' => 'importex',     'dt' => 6,

                        'formatter' => function( $d, $row ) {

                        $separar=explode("/",$d);

                            if( $separar[0] == 1) {
                                
                                return wims_currency($separar[1]);     

                            }else{

                                return wims_currency(0);

                            }

                           

                        }  
                ),

                array( 'db' => 'importex',     'dt' => 7,

                        'formatter' => function( $d, $row ) {

                           $separar=explode("/",$d);

                            if( $separar[0] == 2) {
                                
                                return wims_currency($separar[1]);     

                            }else{

                                return wims_currency(0);

                            }

                           

                        }  

                ),

                array( 'db' => 'fpagox',     'dt' => 8),







                array( 'db' => 'id',     'dt' => 9),

                array( 'db' => 'tipo',     'dt' => 10),

                array( 'db' => 'importe',     'dt' => 11),

                array( 'db' => 'cuenta',     'dt' => 12),

                array( 'db' => 'movimiento',     'dt' => 13),

                array( 'db' => 'hora_banco',     'dt' => 14),

                array( 'db' => 'importex',     'dt' => 15,

                        'formatter' => function( $d, $row ) {

                           $separar=explode("/",$d);

                            if( $separar[0] == 2) {
                                
                                return $separar[1];     

                            }else{

                                return 0;

                            }

                           

                        }  

                ),

                array( 'db' => 'idclientex',     'dt' => 16),

                array( 'db' => 'descripcion',     'dt' => 17),

                array( 'db' => 'fpago',     'dt' => 18)


           
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


        public function movXcliente(){


            $data_get = $this->input->get();




            $table='(SELECT a.id,a.fecha_banco, a.hora_banco,a.movimiento,a.descripcion,a.rastreo,CONCAT_WS("/",a.tipo,a.importe) AS importex, CONCAT_WS(" | ",a.cuenta,d.comercial) AS cuentax,IFNULL(c.nombre,"No identificado") AS nombrex,a.estatus,a.tipo,a.importe,a.cuenta
                FROM saldo_bancos a
                LEFT JOIN cuentas_bancariasxcliente b ON a.idcuenta=b.id
                LEFT JOIN alta_bancos d ON b.idbanco=d.id 
                LEFT JOIN alta_clientes c ON b.idcliente=c.id
                WHERE b.idcliente="'.$data_get["idcli"].'"
                )temp';
            
  
            // Primary key of table
            $primaryKey = 'id';

            
            
            $columns = array(

               

                array( 'db' => 'id',     'dt' => 0,

                        'formatter' => function( $d, $row ) {

                            return '<div class="btn-group">

                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                    <span class="caret"></span>

                                      </button>

                                      <ul class="dropdown-menu">

                                        <li><a href="#" style="color:#E8B203; font-weight:bold;" data-toggle="modal" data-target="#modal-1"> <i class="fa fa-edit" style="color:#E8B203; font-weight:bold;"></i> Editar</a></li>

                                        <li><a href="#" style="color:darkgreen; font-weight:bold;" data-toggle="modal" data-target="#modal_facturas"> <i class="fa fa-money" style="color:darkgreen; font-weight:bold;"></i> Aplicar pago</a></li>

                                      </ul>

                                    </div>';

                        }  
                ),

                array( 'db' => 'estatus',     'dt' => 1,

                        'formatter' => function( $d, $row ) {

                           switch ($d) {
                                case 0:
                                
                                    $valor="<p style='color:red; font-weight:bold;' >SIN APLICAR</p>";

                                break;

                                case 1:
                                      
                                    $valor="<p style='color:darkgreen; font-weight:bold;' >APLICADO</p>";

                                break;  
                               
                               
                           }

                           return $valor;

                        }  
                ),
                
                array( 'db' => 'fecha_banco',     'dt' => 2),

                array( 'db' => 'rastreo',     'dt' => 3),

                array( 'db' => 'cuentax',     'dt' => 4),

                array( 'db' => 'nombrex',     'dt' => 5),

                array( 'db' => 'importex',     'dt' => 6,

                        'formatter' => function( $d, $row ) {

                        $separar=explode("/",$d);

                            if( $separar[0] == 1) {
                                
                                return wims_currency($separar[1]);     

                            }else{

                                return wims_currency(0);

                            }

                           

                        }  
                ),

                array( 'db' => 'importex',     'dt' => 7,

                        'formatter' => function( $d, $row ) {

                           $separar=explode("/",$d);

                            if( $separar[0] == 2) {
                                
                                return wims_currency($separar[1]);     

                            }else{

                                return wims_currency(0);

                            }

                           

                        }  

                ),

                array( 'db' => 'id',     'dt' => 8),

                array( 'db' => 'tipo',     'dt' => 9),

                array( 'db' => 'importe',     'dt' => 10),

                array( 'db' => 'cuenta',     'dt' => 11),

                array( 'db' => 'movimiento',     'dt' => 12),

                array( 'db' => 'hora_banco',     'dt' => 13)
           
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
