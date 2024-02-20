<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH.'third_party/ssp.php';



class Dashboard extends CI_Controller

{



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

    }



    public function index()

    {

        $iduser=$this->session->userdata(IDUSERCOM);
        $idpuesto=$this->session->userdata(PUESTOCOM);

        

       

        if($iduser > 0){



            $dmenu["nommenu"] = "dashboard";



            $this->load->view('general/header');

            $this->load->view('general/css_datatable');

            $this->load->view('general/menuv2');

            $this->load->view('general/menu_header',$dmenu);

            if($idpuesto==1) {
                
                $this->load->view('dash/body_dash');

            }else{

                $this->load->view('dash/body_dash_otros');

            }

            

            $this->load->view('general/footer');

            $this->load->view('dash/acciones_dash');



        }else{



            //$this->load->view('login');



            redirect('Login');



        } 

       

    }



    public function showPagosVencidos(){


        //$info_vencidas=array();

        $data = array();
        $pregunta = array();

        $sql_clientes='SELECT a.id FROM alta_clientes a
                        WHERE a.estatus=0
                        AND (SELECT x.id FROM alta_factura x WHERE x.idcliente=a.id AND x.pago=0 AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <="'.date("Y-m-d").'" AND x.estatus=1 LIMIT 0,1) > 0';

        $datos_cliente=$this->General_Model->infoxQuery($sql_clientes);

        if ($datos_cliente!=null) {
            
            foreach ($datos_cliente as $row_cliente) {
                

                /*$sql_vencidas="SELECT x.id, x.fecha, '0' AS tipox,y.nombre AS cliente, x.total,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito,
                    
                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos, x.idcliente

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$row_cliente->id."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."' 



                    UNION ALL



                    SELECT x.id, x.fecha, '1' AS tipox, y.nombre AS cliente, x.total,
                    
                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,
                    
                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito,
                    
                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos, x.idcliente

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$row_cliente->id."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <='".date('Y-m-d')."' ";


                $datos_vencidas=$this->General_Model->infoxQuery($sql_vencidas);

                if ($datos_vencidas!=null) {
            
                    foreach ($datos_vencidas as $row_vencida) {

                        $datos_adjuntar=array('id' => $row_vencida->id, 'fecha' =>$row_vencida->fecha, 'cliente' => $row_vencida->cliente, 'total' => $row_vencida->total, 'fcobro' => $row_vencida->fcobro, 'totncredito' => $row_vencida->totncredito, 'dias_transcurridos' => $row_vencida->dias_transcurridos, 'folio'=>$row_vencida->fol_fact, 'credito'=>$row_vencida->dias,'idcliente'=>$row_vencida->idcliente );


                        array_push($info_vencidas, $datos_adjuntar);

                    }

                }*/


                $sql_vencidas="SELECT x.id, '0' AS tipox,x.fecha, y.nombre AS cliente,x.total,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito,

                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos, x.idcliente



                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$row_cliente->id."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."' 



                    UNION ALL



                    SELECT x.id,'0' AS tipox, x.fecha, y.nombre AS cliente, x.total,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito,

                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos, x.idcliente



                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$row_cliente->id."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."' ";


                $datos_sql=$this->General_Model->infoxQuery($sql_vencidas);



                $total=0;/// este total es el pagado por complementos o desde el sistema de pagos cxc
                $total_neto=0;
                $total_ncredito=0;

                $dias_mayor_factura=0;

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

                        if( $row->dias_transcurridos>$dias_mayor_factura ) {
                            
                            $dias_mayor_factura=$row->dias_transcurridos;

                        }


                    }
    
                }


                $total_vencido=$total_neto-$total-$total_ncredito;


                //////*********** DATOS DEL CLIENTE 

                $pregunta[] =array(

                            'ID'=>$row_cliente->id,
                            'ACCION'=>'<button class="btn btn-success" type="button" class="form-control" onclick="generarExcel('.$row_cliente->id.')" ><i class="fa fa-file-excel-o"></i></button>&nbsp;<a class="btn btn-primary" href="'.base_url().'Cxcxc/Cliente/'.$row_cliente->id.'" target="_blank" role="button"><i class="fa fa-eye"></i></a>',
                            
                            'CLIENTE'=>$row->cliente,
                            'DIAS' =>$dias_mayor_factura,
                            'VENCIDO'=>wims_currency($total_vencido),
                            'IDCLIENTE'=>$row_cliente->id, 

                            );


                        //array_push($info_vencidas, $datos_adjuntar);

            }

        }

            $data = array("data"=>$pregunta);
            header('Content-type: application/json');
            echo json_encode($data);    

    }





}