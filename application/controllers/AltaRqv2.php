<?php
defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class AltaRqv2 extends CI_Controller

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

                array('º', '~', '!', '&', '´', ';', '"', '°', ''),

                array('', '', '', '&amp;', '', '', '&quot;', ' grados'),

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

        function wims_currency($number)
        {

            if ($number < 0) {

                $print_number = "-$ " . str_replace('-', '', number_format($number, 2, ".", ",")) . "";
            } else {

                $print_number = "$ " .  number_format($number, 2, ".", ",");
            }

            return $print_number;
        }

        function Mptotal($idpartex)
        {

            $ci = &get_instance();

            $class = $ci->db->query('SELECT idcotizacion FROM partes_cotizacion WHERE id=' . $idpartex . ' AND estatus=0');
                                


            /*"SELECT a.idparte,a.id,a.idoc,a.idcot,b.nparte,

                        CONCAT_WS('/',a.id,a.idproveedor) AS asignar,

                        CONCAT_WS('/',b.nparte,b.descripcion) AS descrip,

                        c.nombre AS proveedor, SUM(a.cantidad) AS tot_solicitado,'0' AS almacen,a.costo,

                        CASE (SELECT t.iva FROM alta_productos t WHERE t.id=a.idparte) WHEN 1 THEN (SELECT z.iva FROM datos_generales z WHERE z.estatus = 0) WHEN 2 THEN 0 WHEN 3 THEN (SELECT t.tasa FROM alta_productos t WHERE t.id=a.idparte) END AS ivax,

                        a.descuento, a.cantidad_oc

                        FROM partes_asignar_oc a, alta_productos b, alta_proveedores c

                        WHERE a.idparte=b.id

                        AND a.idproveedor=c.id

                        AND a.estatus = 0

                        AND a.idproveedor = 1
                        GROUP BY a.idparte
                        ORDER BY `b`.`nparte` ASC"*/

            $class = $class->result_array();



            $resultx = '<ul>';

            foreach ($class as $row) {

                $resultx .= '<li><a style="font-size:11px;" href="' . base_url() . 'tw/php/cotizaciones/cot' . $row["idcotizacion"] . '.pdf" target="_blank"> ODV001' . $row["idcotizacion"] . '</a></li>';
            }

            $resultx .= '</ul>';

            /*$pagadox=0;

                            foreach($class as $row) {
                                   
                                $pagadox = $pagadox+$row['folio'];

                            }*/

            return $resultx;
        }

        function Mptotal2($idpartex, $idprox)
        {

            $ci = &get_instance();

            /*$class = $ci->db->query('SELECT b.idcot,a.cantidad 
                                                        FROM partes_costos_asignar a, partes_asignar_oc b 
                                                        WHERE
                                                        a.idpasignar=b.id
                                                        AND a.idparte='.$idpartex.'
                                                        AND a.idproveedor='.$idprox);*/

            $class = $ci->db->query('SELECT b.idcot,a.cantidad,a.idpasignar 
                                                        FROM partes_costos_asignar a
                                                        LEFT JOIN alta_producto_proveedor b ON a.idpasignar=b.id
                                                        WHERE
                                                        a.idparte=' . $idpartex . '
                                                        AND a.idproveedor=' . $idprox);



            $class = $class->result_array();



            $resultx = '<ul>';

            foreach ($class as $row) {

                if ($row["idpasignar"] > 0) {

                    $resultx .= '<li><a style="font-size:11px;" href="' . base_url() . 'tw/php/cotizaciones/cot' . $row["idcot"] . '.pdf" target="_blank"> ODV001' . $row["idcot"] . '(' . $row["cantidad"] . ')</a></li>';
                } else {

                    $resultx .= '<li><p style="font-size:11px;" >Extra:(' . $row["cantidad"] . ')</p></li>';
                }
            }

            $resultx .= '</ul>';

            /*$pagadox=0;

                            foreach($class as $row) {
                                   
                                $pagadox = $pagadox+$row['folio'];

                            }*/

            return $resultx;
        }

        function totalXproducto($idpartey){

            $ci =& get_instance();
            $entradas=0;
            $salidas = 0;    

            $class = $ci->db->query("
                SELECT CONCAT_WS('<br>',a.nparte,a.descripcion) AS descrip,b.abr,
                IFNULL( (SELECT SUM(pa.cantidad) FROM partes_entrada pa WHERE pa.idparte = a.id AND pa.estatus=0),0) + 
                IFNULL((SELECT SUM(ex.cantidad) FROM partes_ajuste_entrada ex WHERE ex.estatus = 0 AND idparte = a.id ),0) totentrada,
                IFNULL((SELECT SUM(pas.cantidad) FROM partes_ajuste_salida pas WHERE pas.estatus = 0 AND pas.idparte = a.id),0) +
                IFNULL( (SELECT SUM(pef.cantidad) FROM partes_entrega_factura pef WHERE pef.estatus = 0 AND pef.idparte=a.id),0) AS totentrega
                FROM alta_productos a, sat_catalogo_unidades b 
                WHERE
                a.idunidad=b.id 
                AND a.id=".$idpartey."
            ");

            $class = $class->result_array();

            foreach($class as $row) {
                $entradas=$entradas+$row["totentrada"];
                $salidas=$salidas+$row["totentrega"];

            }

            $total = $entradas - $salidas;
                
            return $total;

        }

        function calcularPrecio($costo, $descuento) {
            $costo = floatval(preg_replace('/[^\d.]/', '', $costo));    
            if (is_nan($costo)) {
                return 0;
            }    
            if ($costo < 0) {
                return 0;
            }    
            $precioConIVA = $costo * (1 + $iva / 100);    
            $precioFinal = $precioConIVA * (1 - $descuento / 100);    
            $precioFinalRedondeado = round($precioFinal, 2);        
            return number_format($precioFinalRedondeado, 2);
        } 

        function almacenTotal($idpartey){


            ///BALANCE O KARDEX PARA LA ASIGNACION ALMACEN=ENTRADA AJUSTE-SALIDA AJUSTE+REQUERIMIENTO SIN PEDIDO;

            $ci =& get_instance();
            $entradas=0;
            $salidas = 0;   
            $asignado = 0; 

            $class = $ci->db->query("
                SELECT CONCAT_WS('<br>',a.nparte,a.descripcion) AS descrip,b.abr,
                IFNULL( (SELECT SUM(pa.cantidad) FROM partes_entrada pa WHERE pa.idparte = a.id AND pa.estatus=0 AND idpartecot = 0),0) + 
                IFNULL((SELECT SUM(ex.cantidad) FROM partes_ajuste_entrada ex WHERE ex.estatus = 0 AND idparte = a.id ),0) totentrada,
                IFNULL((SELECT SUM(pas.cantidad) FROM partes_ajuste_salida pas WHERE pas.estatus = 0 AND pas.idparte = a.id),0) +
                IFNULL( (SELECT SUM(pef.cantidad) FROM entregasasignacion pef WHERE pef.estatus = 0 AND pef.idparte=a.id),0) AS totentrega,
                IFNULL( (SELECT SUM(psr.asignado_almacen) FROM partes_solicitar_rq psr WHERE psr.estatus != 2 AND psr.idparte= a.id),0) AS totasignado
                FROM alta_productos a, sat_catalogo_unidades b 
                WHERE
                a.idunidad=b.id 
                AND a.id=".$idpartey."
            ");

            $class = $class->result_array();

            if($class!=null) {
                

                foreach($class as $row) {
                    $entradas=$entradas+$row["totentrada"];
                    $salidas=$salidas+$row["totentrega"];
                    $asignado = $asignado+$row["totasignado"];
                }

                $total = $entradas - $salidas - $asignado;

            }else{


                $total=0;  
            
            }


            return $total;

        }

        function ODCxCOT($idCotY,$idpartex)
        {

            $ci = &get_instance();

            $class = $ci->db->query('SELECT idcot,cantidad FROM partes_asignar_oc WHERE idcot=' . $idCotY . ' AND estatus=0 AND idproveedor=1 AND idparte = '.$idpartex);

            $class = $class->result_array();

            $resultx = '<ul>';

            foreach ($class as $row) {

                $resultx .= '<li><a style="font-size:11px;" href="' . base_url() . 'tw/php/cotizaciones/cot' . $row["idcot"] . '.pdf" target="_blank"> ODV001' . $row["idcot"] . '(' . $row["cantidad"] . ')</a></li>';
            }

            $resultx .= '</ul>';

            return $resultx;
        }

    }



    public function index()

    {

        $iduser = $this->session->userdata(IDUSERCOM);





        $numero_menu = 15;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array('iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla, $vcondicion);



        if ($verificar_menu > 0) {



            $dmenu["nommenu"] = "menuRQ";


            if ($iduser > 0) {


                // CARGA DE ALMMACEN AUTOMATICAMENTE ----- START ----- ///////

                $sql="SELECT psr.id,SUM(psr.cantidad) AS pedido, psr.idparte,
                    SUM(psr.asignado_almacen) as asignacion_automatica, SUM(psr.cantidad_rq_solicitada) AS cantidad_requerida
                        FROM partes_solicitar_rq psr
                        WHERE psr.estatus = 0
                        GROUP BY psr.idparte";

                $qdatos=$this->General_Model->infoxQuery($sql);

                if ($qdatos!=null) {
                    
                    foreach ($qdatos as $qrow) {

                        $idparte_pedidos=$qrow->idparte;
                        $almacenDisponible=almacenTotal($idparte_pedidos);

                        //////// BALANCE PARA SABER QUE CANTIDAD NECESITAMOS REQUERIR PARA EL PEDIDO 
                        $cantidad_pedido=$qrow->pedido-$qrow->cantidad_requerida;
                        /////////
                        $total_asignadas=$qrow->asignacion_automatica;

                        $solicitadas=$cantidad_pedido-$total_asignadas;

                        if ($almacenDisponible>$solicitadas OR $almacenDisponible==$solicitadas) {
                            
                            //UPDATE QUE LA CANTIDAD ASIGNADA EN AUTOMATICO  SEA IGUAL A LA CANTIDAD DEL PEDIDO 

                            $usql="UPDATE partes_solicitar_rq SET `asignado_almacen`=".$cantidad_pedido.",`estatus`=1,`fautomatica`='".date("Y-m-d")."',`cantidad_rq`=0, `iduser` = ".$iduser."
                            WHERE `idparte`=".$idparte_pedidos." AND  `estatus`=0";

                            $this->General_Model->infoxQueryUpt($usql);




                        }elseif($almacenDisponible>0 AND $almacenDisponible<$solicitadas){

                            $almacen_consumido=$almacenDisponible;

                            do {

                                $isql="SELECT id,cantidad,asignado_almacen,cantidad_rq_solicitada FROM partes_solicitar_rq
                                WHERE estatus=0
                                AND idparte=".$idparte_pedidos."
                                ORDER BY idcot,idpartecot ASC 
                                LIMIT 0,1";

                                $info=$this->General_Model->infoxQueryUnafila($isql);

                                if ($info!=null) {
                                    
                                    ////////// ASIGNAMOS LA CANTIDAD DE ALMACEN Y LA DESCONTAMOS DEL MISMO

                                    $ipedido=$info->cantidad-$info->cantidad_rq_solicitada;
                                    //$icantidad_rq=$info->cantidad_rq;
                                    $iasignado_almacen=$info->asignado_almacen;

                                    $xasignar=$ipedido-$iasignado_almacen;

                                    $estatus_parte_rq=0;

                                    if($almacen_consumido>$xasignar OR $almacen_consumido==$xasignar) {
                                     
                                        $iasignar_almacen=$ipedido;///DE COMPLETA LA PARTIDA CON LO QUE EXISTE EN INVENTARIO
                                        $asignado_real=$xasignar;

                                        $cantidadxsolicitar_rq=0;

                                        $estatus_parte_rq=1;

                                    }else{

                                        $iasignar_almacen=$almacen_consumido+$iasignado_almacen;
                                        $asignado_real=$almacen_consumido;

                                        $cantidadxsolicitar_rq=$ipedido-$iasignar_almacen;

                                    }


                                    $udatos2=array('asignado_almacen'=>$iasignar_almacen, 'estatus'=>$estatus_parte_rq, 'fautomatica'=>date("Y-m-d"), 'cantidad_rq'=>$cantidadxsolicitar_rq, 'iduser'=>$iduser);
                                    $utabla2="partes_solicitar_rq";
                                    $ucondicion2=array('id'=> $info->id, 'estatus'=>0);
                                    $uactualizar=$this->General_Model->updateERP($udatos2,$utabla2,$ucondicion2);

                                    if ($uactualizar) {
                                        

                                        $almacen_consumido=$almacen_consumido-$asignado_real;

                                        //echo "Despues del recorrido el almacen es ".$almacen_consumido."<br>";

                                    }


                                }else{

                                    $almacen_consumido=0;

                                }


                                if($almacen_consumido<0 OR $almacen_consumido==null) {
                                        
                                    $almacen_consumido=0;

                                }


                            } while ($almacen_consumido>0);


                        }elseif($almacenDisponible==0){
                            
                            /// SI NO TIENE EXISTENCIA EL ALMACEN SOLO REALIZA UN BALANCE PARA COLOCAR LAS PARTIDAS SOLICITADAS

                            $usql="UPDATE partes_solicitar_rq SET `cantidad_rq`=(`cantidad`-`asignado_almacen`-`cantidad_rq_solicitada`), `iduser` = ".$iduser." WHERE `idparte`=".$idparte_pedidos." AND  `estatus`=0";

                            $this->General_Model->infoxQueryUpt($usql);

                            //echo $usql."<br>";


                        }

                        

                    }

                }

                // CARGA DE ALMMACEN AUTOMATICAMENTE ----- FINALIZA ----- ///////



               

                $this->load->view('general/header');

                $this->load->view('general/css_select2');

                $this->load->view('general/css_autocompletar');

                //$this->load->view('general/css_xedit');

                $this->load->view('general/css_date');

                $this->load->view('general/css_datatable');

                $this->load->view('general/menuv2');

                $this->load->view('general/menu_header', $dmenu);

                $this->load->view('requerimientos/alta_asignar_rqv2');

                $this->load->view('general/footer');

                $this->load->view('requerimientos/acciones_asignar_rqv2');
            } else {



                redirect("Login");
            }
        } else {



            redirect('AccesoDenegado');
        }
    }


    public function testAsignacion(){

         // CARGA DE ALMMACEN AUTOMATICAMENTE ----- START ----- ///////

                $sql="SELECT psr.id,SUM(psr.cantidad) AS pedido, psr.idparte,
                    SUM(psr.asignado_almacen) as asignacion_automatica
                        FROM partes_solicitar_rq psr
                        WHERE psr.estatus = 0
                        AND psr.idparte=25
                        GROUP BY psr.idparte
                        ORDER BY psr.idparte ASC";

                $qdatos=$this->General_Model->infoxQuery($sql);

                if ($qdatos!=null) {
                    
                    foreach ($qdatos as $qrow) {

                        $idparte_pedidos=$qrow->idparte;
                        $almacenDisponible=almacenTotal($idparte_pedidos);
                        $cantidad_pedido=$qrow->pedido;
                        $total_asignadas=$qrow->asignacion_automatica;

                        $solicitadas=$cantidad_pedido-$total_asignadas;

                        if ($almacenDisponible>$solicitadas OR $almacenDisponible==$solicitadas) {
                            
                            //UPDATE QUE LA CANTIDAD ASIGNADA EN AUTOMATICO  SEA IGUAL A LA CANTIDAD DEL PEDIDO 

                            /*$udatos=array('asignado_almacen'=>'cantidad','estatus'=>1 );
                            $utabla="partes_solicitar_rq";
                            $ucondicion=array('idparte'=> $idparte_pedidos, 'estatus'=>0);*/

                            $usql="UPDATE partes_solicitar_rq SET `asignado_almacen`=`cantidad`, `estatus`=1 
                            WHERE `idparte`=".$idparte_pedidos." AND  `estatus`=0";

                            $this->General_Model->infoxQueryUpt($usql);




                        }elseif($almacenDisponible>0 AND $almacenDisponible<$solicitadas){

                            $almacen_consumido=$almacenDisponible;

                            do {

                                $isql="SELECT id,cantidad,asignado_almacen FROM partes_solicitar_rq
                                WHERE estatus=0
                                AND idparte=".$idparte_pedidos."
                                ORDER BY idcot,idpartecot ASC 
                                LIMIT 0,1";

                                $info=$this->General_Model->infoxQueryUnafila($isql);

                                if ($info!=null) {
                                    
                                    ////////// ASIGNAMOS LA CANTIDAD DE ALMACEN Y LA DESCONTAMOS DEL MISMO

                                    $ipedido=$info->cantidad;
                                    $iasignado_almacen=$info->asignado_almacen;

                                    $xasignar=$ipedido-$iasignado_almacen;

                                    $estatus_parte_rq=0;

                                    if($almacen_consumido>$xasignar OR $almacen_consumido==$xasignar) {
                                     
                                        $iasignar_almacen=$xasignar+$iasignado_almacen;
                                        $asignado_real=$xasignar;

                                        $estatus_parte_rq=1;

                                    }else{

                                        $iasignar_almacen=$almacen_consumido+$iasignado_almacen;
                                        $asignado_real=$almacen_consumido;

                                    }


                                    $udatos2=array('asignado_almacen'=>$iasignar_almacen, 'estatus'=>$estatus_parte_rq);
                                    $utabla2="partes_solicitar_rq";
                                    $ucondicion2=array('id'=> $info->id, 'estatus'=>0);
                                    $uactualizar=$this->General_Model->updateERP($udatos2,$utabla2,$ucondicion2);

                                    if ($uactualizar) {
                                        

                                        $almacen_consumido=$almacen_consumido-$asignado_real;

                                        echo "Despues del recorrido el almacen es ".$almacen_consumido."<br>";

                                    }


                                }else{

                                    $almacen_consumido=0;

                                }


                                if($almacen_consumido<0 OR $almacen_consumido==null) {
                                        
                                    $almacen_consumido=0;

                                }


                            } while ($almacen_consumido>0);


                        }

                        

                    }

                }

                // CARGA DE ALMMACEN AUTOMATICAMENTE ----- FINALIZA ----- ///////

    }


    public function testAlmacen(){

        echo almacenTotal(5004);

    }

    public function showProveedor()
    {
        $query = "SELECT id,nombre,comercial,rfc FROM alta_proveedores WHERE estatus = 0 ORDER BY nombre ASC";
        echo json_encode($this->General_Model->infoxQuery($query));
    }

    public function showProAsignado()
    {

        $query = "SELECT DISTINCT(a.idproveedor) AS idprox,b.nombre,b.comercial
                    FROM alta_producto_proveedor a, alta_proveedores b
                    WHERE a.estatus = 0
                    AND a.idproveedor=b.id
                    AND a.idproveedor NOT IN(1)
                    ORDER BY b.nombre ASC";

        echo json_encode($this->General_Model->infoxQuery($query));
    }



    public function showDocumentos()
    {
        $query = "SELECT DISTINCT(a.idcot) AS idcotx, CONCAT_WS( ' ','COT#',(SELECT y.id FROM alta_cotizacion y WHERE y.id = a.idcot) ) AS documento,
        (SELECT x.nombre FROM alta_cotizacion z, alta_clientes x WHERE z.idcliente=x.id AND z.id = a.idcot) AS clientex
        FROM `partes_solicitar_rq` AS a WHERE a.idoc = 0 AND a.idproveedor = 0 AND a.estatus = 0 ORDER BY `idcotx` ASC";
        
        echo json_encode($this->General_Model->infoxQuery($query));
    }


    public function showDias()
    {

        $data_post = $this->input->post();
        $data = "dias,limite";
        $tabla = "alta_proveedores";
        $condicion = array('id' => $data_post['idprov']);

        echo json_encode($this->General_Model->SelectUnafila($data, $tabla, $condicion));
    }

    public function buscarxdescrip()
    {

        $this->load->model('Model_Buscador');
        $data = $this->input->get();

        if (strlen($data['clv']) > 0) {



            echo json_encode($this->Model_Buscador->buscarProductos($data['clv']));
        } else {



            $arrayName[] = array('id' => 0, 'descrip' => "");



            echo json_encode($arrayName);
        }
    }





    public function asignarPartidas()
    {

        $data_post = $this->input->post();
        $dataArrayid = $data_post["idpoc"];//idparte array
        $idUser = $data_post["iduser"];

        //for ($i = 0; $i < count($arrayid); $i++) {
            /*$datos = array('idproveedor' => $idproveedor);
            $tabla = "partes_asignar_oc";
            $condicion = array('id' => $arrayid[$i]);
            $this->General_Model->updateERP($datos, $tabla, $condicion);*/
            ////// GUARDAR en la tabla de partes_costos_asignar -> esta guardara las partidas aignadas al proveedor antes de convertirse en odc  - partes_costos_asignar
        //}

        $inData2 = array('fecha' => date("Y-m-d"), 'frq' => date("Y-m-d"), 'hora' => date("H:i:s"), 'idusuario' =>$data_post["iduser"], 'estatus' => 0);
        $inTable2 = "alta_rq";
        $last_idrq=$this->General_Model->altaERP($inData2,$inTable2);

        if($last_idrq>0) {
            
            foreach ($dataArrayid as $arrayid) {

                $sqlInfo = "SELECT id,idparte,idpartecot,idcot,cantidad_rq,costo,precio,descuento,iva,asignado_almacen,cantidad_rq_solicitada,cantidad,estatus FROM partes_solicitar_rq WHERE id=".$arrayid;
                $info_rq = $this->General_Model->infoxQueryUnafila($sqlInfo);

                if($info_rq->cantidad_rq>0){

                    //////////// LAS PARTIDAS QUE NO HAYAN CONCLUIDO CON LA ASIGNACION AUTOMATICA
                 
                    $insertToRq = array('fecha' => date("Y-m-d"), 'hora' => date("H:i:s"), 'idcot' =>$info_rq->idcot, 'idpartecot' => $info_rq->idpartecot, 'cantidad_rq' =>$info_rq->cantidad_rq, 'idparte'=> $info_rq->idparte, 'idrq' => $last_idrq,'idparte_solicitar_rq'=>$info_rq->id);
                    $inTableRq = "partes_rq";
                    $last_id_prq=$this->General_Model->altaERP($insertToRq,$inTableRq);

                    if($last_id_prq>0) {

                        $precio_final=$info_rq->precio-$info_rq->descuento;
                        
                        $insertToCA = array('fecha' => date("Y-m-d"), 'iduser' => $data_post["iduser"], 'idparterq' => $last_id_prq, 'idparte'=>$info_rq->idparte, 'costo_proveedor'=>$info_rq->costo, 'costo_final'=>$info_rq->precio, 'precio'=>$info_rq->precio,
                            'precio_final'=>round($precio_final,2),
                            'iva'=>$info_rq->iva, 'descuento'=>$info_rq->descuento, 'cantidad'=>$info_rq->cantidad_rq, 
                            'solicitar'=>$info_rq->cantidad_rq);

                        $inTableCA = "partes_costos_asignar";
                        $this->General_Model->altaERP($insertToCA,$inTableCA);

                        /*$usql2="UPDATE `partes_solicitar_rq` SET `partes_solicitar_rq`";

                        $actualizacion_rq=$this->General_Model->infoxQueryUpt($usql2);*/


                        ////////// ACTUALIZAMOS LAS PARTIDAS ASIGNADAS POR RQ

                        $total_solicitado=$info_rq->cantidad_rq_solicitada+$info_rq->cantidad_rq;


                        ////////////REVISAMOS SI YA FINALIZO la solicitud de rq  por producto


                        $cantidad_pedido=$info_rq->cantidad;
                        $total_cantidad_solicitada=$total_solicitado+$info_rq->asignado_almacen;

                        

                        if($cantidad_pedido==$total_cantidad_solicitada) {

                            //////////la RQ ha concluido
                        
                            $udatos=array('estatus'=> 1, 'cantidad_rq_solicitada'=>$total_solicitado, 'visto'=>1);
                            
                        }else{

                            $udatos=array('cantidad_rq_solicitada'=>$total_solicitado);


                        }



                        $itabla="partes_solicitar_rq";
                        $ucondicion=array('id'=> $info_rq->id);
                        $this->General_Model->updateERP($udatos,$itabla,$ucondicion);


                    }




                }elseif($info_rq->cantidad_rq==0 AND $info_rq->estatus==1) {

                    //FINALIZO UNA ASIGNACION AUTOMATICA

                    ////////// ACTUALIZAMOS LAS PARTIDAS ASIGNADAS POR RQ

                        $total_solicitado=$info_rq->cantidad_rq_solicitada;

                    ////////// Y REVISAMOS SI YA FINALIZO la solicitud de rq  por producto

                        $cantidad_pedido=$info_rq->cantidad;
                        $total_cantidad_solicitada=$total_solicitado+$info_rq->asignado_almacen;

                        

                        if($cantidad_pedido==$total_cantidad_solicitada) {

                            //////////la RQ ha concluido
                        
                            $udatos=array('visto'=>1 );
                            $itabla="partes_solicitar_rq";
                            $ucondicion=array('id'=> $info_rq->id);
                            $this->General_Model->updateERP($udatos,$itabla,$ucondicion);


                        }

                }

    
        
            }

        }  

     

        echo json_encode($last_idrq);
    }



    public function updateCelda()
    {

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
        switch ($data_post["columna"]) {
            case 8:
                /// solicitar

                        

                        $udatos=array('cantidad_rq' => $data_post["cantidadRq"]);
                        $itabla="partes_solicitar_rq";
                        $ucondicion=array('id'=> $data_post["idRq"]);
                        $this->General_Model->updateERP($udatos,$itabla,$ucondicion);

                        
                    //}                     
                //}
            break;
            
        }


        echo json_encode(true);
    }






    public function calcularBalance()
    {

        $data_post = $this->input->post();

        $sql = 'SELECT cantidad FROM `partes_entrada` where idparte="' . $data_post["idparte"] . '" 
            AND estatus=0
            UNION ALL
            SELECT cantidad
            FROM partes_ajuste_entrada
            WHERE 
            idparte="' . $data_post["idparte"] . '" AND estatus=0';

        echo json_encode($this->General_Model->infoxQuery($sql));
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
            $estatus = 1;

            $valoresCheckboxes = $_POST['values'];
            foreach ($valoresCheckboxes as $valor) {
                // Actualización de estatus de partes_oc
                $upData= array('estatus' => $estatus, 'idoc' => $last_id);
                $upTable = "partes_asignar_oc";        
                $upCondition = array('id' => $valor );                    
                $this->General_Model->updateERP($upData,$upTable,$upCondition);
                
                $sql1 = "SELECT idcot,idpartecot,idoc,cantidad,cantidad_oc,idparte,idproveedor,costo_proveedor,costo,iva,descuento, cantidad_oc FROM `partes_asignar_oc` where id=" . $valor;
                $partes = $this->General_Model->infoxQuery($sql1);
                foreach ($partes as $row) {
                    $inData = array('fecha' => date("Y-m-d"), 'hora' => date("H:i:s"), 'idasoc' => $valor, 'idcot' => $row->idcot, 'idpartecot' => $row->idpartecot, 'idoc' => $last_id, 'cantidad' => $row->cantidad_oc, 'cantidad_oc' => $row->cantidad_oc, 'idparte' => $row->idparte, 'idproveedor' => $data_post["idpro"], 'costo_proveedor' => $row->costo_proveedor, 'costo' => $row->costo, 'iva' => $row->iva, 'descuento' => $row->descuento);
                    $inTable = "alta_producto_proveedor";
                    $this->General_Model->altaERP($inData,$inTable);
                }

            }
            /*
            //$sqlUpd = "UPDATE alta_producto_proveedor SET idoc='".$last_id."', estatus='".$estatus."' WHERE idproveedor='".$data_post["idpro"]."'";
            $sqlUpd2 = "UPDATE partes_asignar_oc SET estatus='".$estatus."' WHERE idproveedor='".$data_post["idpro"]."'";
            //$this->General_Model->infoxQueryUpt($sqlUpd);
            $this->General_Model->infoxQueryUpt($sqlUpd2);
            ///////******* MANDAR LAS PARTIDAS AL TEMPORAL DE ENTRADAS
            $sqlx = "SELECT a.idparte,a.cantidad,a.id,a.idpartecot,
                CASE (SELECT t.iva FROM alta_productos t WHERE t.id=a.idparte) WHEN 1 THEN (SELECT z.iva FROM datos_generales z WHERE z.estatus = 0) WHEN 2 THEN 0 WHEN 3 THEN (SELECT t.tasa FROM alta_productos t WHERE t.id=a.idparte) END AS ivax
                FROM `alta_producto_proveedor` a WHERE idoc = ".$last_id;
            //$partes = $this->General_Model->SelectsinOrder($data2,$tabla2,$condicion2);
            $partes = $this->General_Model->infoxQuery($sqlx);
            foreach ($partes as $row) {
                /////****** VALIDAR SI LA CANTIDAD CUMPLE CON LO SOLICITADO Y SER ESTE NUMERO MAYOR MANDAR ESA CANTIDAD AL ALMACEN 
                /*$salmaen = $cantidad_oc - $cantidad;
                if ( $salmaen > 0 ) {
                    ///// la diferencia se colocara para la solicitud de almacen
                }
                $data3 = array( 'fecha' => date("y-m-d"), 'idoc' =>$last_id, 'idparteoc' => $row->id, 'idpartecot' => $row->idpartecot, 'cantidad'=> $row->cantidad, 'idparte'=> $row->idparte);
                $table3 = "partes_entrada";
                $this->General_Model->altaERP($data3,$table3);
                /////////********** actualizar el iva de odc
                $datos2= array('iva' => $row->ivax );
                $tabla2 = "alta_producto_proveedor";
                $condicion2 = array('id' => $row->id );
                $this->General_Model->updateERP($datos2,$tabla2,$condicion2);
            } */ 
            echo json_encode($last_id);
        }else{
            echo json_encode(0);
        }
    }

    public function cancelarOC()
    {



        $data_post = $this->input->post();



        $condicion = array('idusuario' => $data_post["iduser"]);



        $tabla = "temporal_partes_compras";



        echo json_encode($this->General_Model->deleteERP($tabla, $condicion));
    }


    public function DatosAsignar()
    {

        $data_post = $this->input->post();

        $arrayx = array();

        $sql = "SELECT a.idparte,a.id,a.idoc,a.idcot,b.nparte,

                        CONCAT_WS('/',a.id,a.idproveedor) AS asignar,

                        CONCAT_WS('/',b.nparte,b.descripcion) AS descrip,

                        c.nombre AS proveedor, ( (a.cantidad)-IFNULL( (SELECT (SUM(y.cantidad)+SUM(y.almacen)) AS asignados FROM partes_costos_asignar y WHERE y.idparte=a.idparte AND y.estatus=0 AND y.idpasignar=a.id),0 ) ) AS cantidad ,'0' AS almacen,a.costo,

                        CASE (SELECT t.iva FROM alta_productos t WHERE t.id=a.idparte) WHEN 1 THEN (SELECT z.iva FROM datos_generales z WHERE z.estatus = 0) WHEN 2 THEN 0 WHEN 3 THEN (SELECT t.tasa FROM alta_productos t WHERE t.id=a.idparte) END AS ivax,

                        a.descuento, a.cantidad_oc,d.abr

                        FROM alta_producto_proveedor a, alta_productos b, alta_proveedores c, sat_catalogo_unidades d

                        WHERE a.idparte=b.id

                        AND a.idproveedor=c.id
                        
                        AND b.idunidad=d.id 

                        AND a.estatus = 0

                        AND a.idproveedor = 1
                        AND a.idparte=" . $data_post['idpartex'] . "
                        
                        ORDER BY `b`.`nparte` ASC";



        $info = $this->General_Model->infoxQuery($sql);

        if ($info != "") {

            $datos = "";

            foreach ($info as $row) {

                $datos = array(

                    'idparte' => $row->idparte,
                    'idpasignar' => $row->id,
                    'descrip' => $row->descrip,
                    'cantidad' => $row->cantidad,
                    'costo' => $row->costo,
                    'almacen' => 0,
                    'cantidad_odc' => $row->cantidad_oc,
                    'unidad' => $row->abr,
                    'idcot' => $row->idcot,
                    'abr' => $row->abr

                );

                array_push($arrayx, $datos);
            }
        } else {

            $arrayx = null;
        }

        echo json_encode($arrayx);
    }


    public function Asignarproveedor()
    {

        $data_post = $this->input->post();

        /////revisar el array 
        //echo json_encode( count($data_post["array_pro"]) );

        $pasignar = $data_post["array_pro"];

        $idpartex = 0;

        for ($i = 0; $i < count($pasignar); $i++) {

            $separar = explode("/", $pasignar[$i]);


            if ($data_post["array_odc"][$i] >= 0 or $data_post["array_almacen"][$i] > 0) {


                $data = array(

                    'fecha' => date("Y-m-d"),
                    'iduser' => $data_post["iduser"],
                    'idpasignar' => $separar[0],
                    'idproveedor' => $data_post["provx"],
                    'costo' => $data_post["costox"],
                    'idparte' => $separar[2],
                    'cantidad' => $data_post["array_odc"][$i],
                    'almacen' => $data_post["array_almacen"][$i]

                );

                $table = "partes_costos_asignar";

                $alta = $this->General_Model->altaERP($data, $table);

                if ($alta > 0) {

                    $cantidad_total = $data_post["array_almacen"][$i] + $data_post["array_odc"][$i]; //almacen en inventario + solicitada a proveedor
                    $cantidad_total_requerida = $separar[1]; /// cantidad requerida en el pedido 

                    if ($cantidad_total == $cantidad_total_requerida) {

                        /////// la cantidad solicitada ya se cumplio con el inventario y lo solicita ODC - cambiamos el status

                        $udatos = array('estatus' => 1);
                        $utabla = "alta_producto_proveedor";
                        $ucondicion = array('id' => $separar[0]);

                        $this->General_Model->updateERP($udatos, $utabla, $ucondicion);
                    }


                    $idpartex = $separar[2];


                    if ($data_post["extrax"] > 0) {


                        ////////////// AÑADIR SOLICITUD EXTRA DE MATERIAL
                        $data2 = array(

                            'fecha' => date("Y-m-d"),
                            'iduser' => $data_post["iduser"],
                            'idpasignar' => 0,
                            'idproveedor' => $data_post["provx"],
                            'costo' => $data_post["costox"],
                            'idparte' => $idpartex,
                            'cantidad' => $data_post["extrax"],
                            'almacen' => 0

                        );

                        $table2 = "partes_costos_asignar";

                        $this->General_Model->altaERP($data2, $table2);
                    }
                }
            }
        }

        if ($idpartex > 0) {

            $idcotx = $data_post["docx"];

            if ($idcotx > 0) {

                $sql = "SELECT a.idparte,a.id,a.idoc,a.idcot,b.nparte,

                        CONCAT_WS('/',a.id,a.idproveedor) AS asignar,

                        CONCAT_WS('/',b.nparte,b.descripcion) AS descrip,

                        c.nombre AS proveedor, ( SUM(a.cantidad)- IFNULL( (SELECT (SUM(y.cantidad)+SUM(y.almacen)) AS asignados FROM partes_costos_asignar y WHERE y.idparte=a.idparte AND y.estatus=0),0 ) ) AS tot_solicitado,'0' AS almacen,a.costo,

                        CASE (SELECT t.iva FROM alta_productos t WHERE t.id=a.idparte) WHEN 1 THEN (SELECT z.iva FROM datos_generales z WHERE z.estatus = 0) WHEN 2 THEN 0 WHEN 3 THEN (SELECT t.tasa FROM alta_productos t WHERE t.id=a.idparte) END AS ivax, a.descuento, a.cantidad_oc

                        FROM alta_producto_proveedor a, alta_productos b, alta_proveedores c

                        WHERE a.idparte=b.id

                        AND a.idproveedor=c.id

                        AND a.estatus = 0

                        AND a.idproveedor = 1

                        AND a.idcot = " . $idcotx . "
                        
                        GROUP BY a.idparte
                        ORDER BY `b`.`nparte` ASC";
            } elseif ($idcotx == 0) {



                $sql = "SELECT a.idparte,a.id,a.idoc,a.idcot,b.nparte,

                        CONCAT_WS('/',a.id,a.idproveedor) AS asignar,

                        CONCAT_WS('/',b.nparte,b.descripcion) AS descrip,

                        c.nombre AS proveedor,( SUM(a.cantidad)-IFNULL( (SELECT (SUM(y.cantidad)+SUM(y.almacen)) AS asignados FROM partes_costos_asignar y WHERE y.idparte=a.idparte AND y.estatus=0),0 ) ) AS tot_solicitado,'0' AS almacen,a.costo,

                        CASE (SELECT t.iva FROM alta_productos t WHERE t.id=a.idparte) WHEN 1 THEN (SELECT z.iva FROM datos_generales z WHERE z.estatus = 0) WHEN 2 THEN 0 WHEN 3 THEN (SELECT t.tasa FROM alta_productos t WHERE t.id=a.idparte) END AS ivax, a.descuento, a.cantidad_oc

                        FROM alta_producto_proveedor a, alta_productos b, alta_proveedores c

                        WHERE a.idparte=b.id

                        AND a.idproveedor=c.id

                        AND a.estatus = 0

                        AND a.idproveedor = 1
                        GROUP BY a.idparte
                        ORDER BY `b`.`nparte` ASC";
            }

            $info_datos = $this->General_Model->infoxQueryUnafila($sql);

            $info = array('cotizaciones' => Mptotal($info_datos->idparte), 'tot_solicitado' => $info_datos->tot_solicitado);

            echo json_encode($info);
        }

        //echo json_encode(true);        

    }


    ///////////****************TABLA PARTIDAS 

    public function loadPartidas()

    {

        $iduser = $this->session->userdata('idusercomanorsa');
        $data_get = $this->input->get();
        $cotFilter = false;

        if ($data_get["cot"] > 0) {
            
            $cotFilter = true;

            $table = "(SELECT psr.id AS id, ap.nparte AS clave, CONCAT_WS('||',ap.nparte,ap.descripcion) AS descripcion,
                        psr.cantidad AS pedido, psr.idparte AS almacen, psr.idpartecot AS pcot,
                        psr.cantidad_rq AS solicitado,
                        IFNULL((SELECT SUM(pr.cantidad_rq) FROM partes_rq pr WHERE pr.idpartecot = psr.idpartecot AND pr.estatus = 0),0) AS ODC, psr.asignado_almacen AS asignado_almacen
                        FROM partes_solicitar_rq psr, alta_productos ap
                        WHERE psr.idparte = ap.id
                        AND psr.estatus=0
                        AND psr.idcot =" . $data_get['cot'] . "

                        OR 

                        psr.idparte = ap.id
                        AND psr.estatus=1
                        AND psr.visto=0
                        AND psr.idcot =" . $data_get['cot'] . "

                    )temp ";

        } elseif ($data_get["cot"] == 0) {

            $table = "(SELECT psr.id AS id, ap.nparte AS clave, CONCAT_WS('||',ap.nparte,ap.descripcion) AS descripcion,
                        psr.cantidad AS pedido, psr.idparte AS almacen, psr.idpartecot AS pcot,
                        psr.cantidad_rq AS solicitado,
                        IFNULL((SELECT SUM(pr.cantidad_rq) FROM partes_rq pr WHERE pr.idpartecot = psr.idpartecot AND pr.estatus = 0),0) AS ODC, psr.asignado_almacen AS asignado_almacen
                        FROM partes_solicitar_rq psr, alta_productos ap
                        WHERE psr.idparte = ap.id
                        AND psr.estatus=0

                        OR 

                        psr.idparte = ap.id 
                        AND psr.estatus=1
                        AND psr.visto=0

                    )temp ";
        }


        /* $table = "(SELECT psr.id AS id, ap.nparte AS clave, CONCAT_WS('||',ap.nparte,ap.descripcion) AS descripcion,
                    psr.cantidad AS pedido, psr.idparte AS almacen, psr.idpartecot AS pcot,
                    IF(psr.cantidad_rq = 0, 0, psr.cantidad_rq) AS solicitado,
                    IFNULL((SELECT SUM(pr.cantidad_rq) FROM partes_rq pr WHERE pr.idpartecot = psr.idpartecot AND pr.estatus = 0),0) AS ODC, psr.asignado_almacen AS asignado_almacen
                    FROM partes_solicitar_rq psr, alta_productos ap
                    WHERE psr.idparte = ap.id
                    AND psr.idproveedor = 0 AND psr.estatus = 0)temp"; */

        // Primary key of table
        $primaryKey = 'id';
        $columns = array(
            array(
                'db' => 'id',     'dt' => 0,
                'formatter' => function ($d, $row) {                                        
                     return '<input type="checkbox" name="menux" value="'.$d.'" style="border-color:#FF338A; border-style:solid;" tabindex="-1">';                    
                }
            ),
            array(
                'db' => 'pcot',     'dt' => 1,
                'formatter' => function ($d, $row) use ($cotFilter) {                    
                    return Mptotal($d);
                }
            ),            
            array('db' => 'clave',     'dt' => 2),
            array(
                'db' => 'descripcion',     'dt' => 3,
                'formatter' => function ($d, $row) {
                    $separar = explode("||", $d);
                    return '<p title="' . utf8_encode($separar[1]) . '">' . utf8_encode($separar[0]) . '&nbsp;&nbsp;' . utf8_encode(substr($separar[1], 0, 30)) . '</p>';
                }
            ),
            array('db' => 'pedido',     'dt' => 4),
            array('db' => 'ODC',     'dt' => 5),
            
            array('db' => 'asignado_almacen',     'dt' => 6),

            array('db' => 'solicitado',     'dt' => 8),

            array('db' => 'id',   'dt' => 10)

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

        echo json_encode(SSP::simple($_GET, $sql_details, $table, $primaryKey, $columns));
    }


    ///////////****************TABLA PARTIDAS POR PROVEEDOR




}
