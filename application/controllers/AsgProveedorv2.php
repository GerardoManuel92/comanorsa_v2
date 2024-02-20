<?php
defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class AsgProveedorv2 extends CI_Controller

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

        function calcularPrecio($costo, $iva, $descuento) {
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
        

        function Mptotal($idpartex)
        {

            $ci = &get_instance();

            $class = $ci->db->query('SELECT idcot,cantidad FROM partes_asignar_oc WHERE idparte=' . $idpartex . ' AND estatus=0 AND idproveedor=1');


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

                $resultx .= '<li><a style="font-size:11px;" href="' . base_url() . 'tw/php/cotizaciones/cot' . $row["idcot"] . '.pdf" target="_blank"> ODV001' . $row["idcot"] . '(' . $row["cantidad"] . ')</a></li>';
            }

            $resultx .= '</ul>';

            /*$pagadox=0;

                            foreach($class as $row) {
                                   
                                $pagadox = $pagadox+$row['folio'];

                            }*/

            return $resultx;
        }

        function showRQ($id)
        {

            $ci = &get_instance();

            $class = $ci->db->query('SELECT ar.documento 
                                    FROM alta_rq ar, partes_rq pr
                                    WHERE ar.id = pr.idrq
                                    AND pr.id ='.$id);


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

                $resultx .= '<li><a style="font-size:11px;" href="' . base_url() . 'tw/php/requerimientos/' . $row["documento"] . '.pdf" target="_blank"> ' . $row["documento"] . '</a></li>';
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
                IFNULL( (SELECT SUM(x.cantidad) FROM `partes_entrada` x WHERE x.idparte =".$idpartey." AND x.estatus = 0 AND x.identrada > 0),0) + IFNULL((SELECT SUM(ex.cantidad) FROM partes_ajuste_entrada ex, alta_ajuste_entrada ax WHERE ax.id = ex.idajuste AND ax.estatus = 0 AND idparte = a.id),0) totentrada,
                IFNULL( (SELECT SUM(y.cantidad) FROM `partes_entrega` y, partes_cotizacion w WHERE y.idpartefolio=w.id AND w.idparte = ".$idpartey." AND y.estatus = 0 AND y.identrega > 0),0) + IFNULL((SELECT SUM(ex.cantidad) FROM partes_ajuste_salida ex, alta_ajuste_salida ax WHERE ax.id = ex.idajuste AND ax.estatus = 0 AND idparte = a.id),0) AS totentrega
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



            $dmenu["nommenu"] = "asignar";





            if ($iduser > 0) {


                /* ///BORRAMOS TABLA TEMPORAL


                $ttabla="partes_asignar_oc";
                $this->General_Model->vaciarTabla($ttabla);


                ///// CREAMOS LA TABLA TEMPORAL

                $sqlx="SELECT pr.idpartecot AS idpartecot, pr.cantidad_rq AS cantidad, pr.idparte AS idparte, 
                        pc.costo_proveedor AS costo_proveedor, pc.costo AS precio, pc.iva AS iva, pc.descuento AS descuento
                        FROM partes_rq pr, partes_cotizacion pc
                        WHERE pr.idpartecot = pc.id AND pr.estatus = 0";

                $qdatos=$this->General_Model->infoxQuery($sqlx);

                if ($qdatos!=null) {
                    

                    foreach ($qdatos as $qrow) {
                        
                        
                        $idata=array('idpartecot'=>$qrow->idpartecot, 'cantidad'=>$qrow->cantidad, 'idparte'=>$qrow->idparte, 'costo_proveedor'=>$qrow->costo_proveedor, 'costo'=>$qrow->costo_proveedor, 'precio'=>$qrow->precio, 'iva'=>$qrow->iva, 'descuento'=>$qrow->descuento, 'estatus'=>0);
                        $itabla="partes_asignar_oc";

                        $this->General_Model->altaERP($idata,$itabla);

                    }


                } */



                $this->load->view('general/header');

                $this->load->view('general/css_select2');

                $this->load->view('general/css_autocompletar');

                //$this->load->view('general/css_xedit');

                $this->load->view('general/css_date');

                $this->load->view('general/css_datatable');

                $this->load->view('general/menuv2');

                $this->load->view('general/menu_header', $dmenu);

                $this->load->view('compras/alta_asignar_proveedorv2');

                $this->load->view('general/footer');

                $this->load->view('compras/acciones_asignar_proveedorv2');
            } else {



                redirect("Login");
            }
        } else {



            redirect('AccesoDenegado');
        }
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
        /* $query = "SELECT DISTINCT(a.idcot) AS idcotx, CONCAT_WS( ' ','COT#',(SELECT y.id FROM alta_cotizacion y WHERE y.id = a.idcot) ) AS documento,
        (SELECT x.nombre FROM alta_cotizacion z, alta_clientes x WHERE z.idcliente=x.id AND z.id = a.idcot) AS clientex
        FROM `partes_asignar_oc` AS a WHERE a.idoc = 0 AND a.idproveedor = 1 ORDER BY `idcotx` ASC"; */

        $query = "SELECT DISTINCT(ar.id) AS idcotx, ar.documento AS documento 
                    FROM alta_rq ar, partes_rq pr, partes_costos_asignar pca
                    WHERE pr.idrq = ar.id AND pca.idparterq = pr.id
                    AND pca.estatus = 0";
        
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


    public function asignarParteOC(){

        $data_post = $this->input->post();
        $arrayid = $data_post["idpoc"];//idrq array
        $idproveedor = $data_post["idpro"];//id proveedor
        $idUser = $data_post["iduser"];

        for ($i = 0; $i < sizeof($arrayid); $i++){                        

            $query = "SELECT pca.id AS id, pr.idpartecot AS idpartecot, pca.idparte AS idparte,pca.cantidad AS requerido,
                        pca.solicitar AS cantidad, pca.iva AS iva, pca.costo_proveedor,
                        pca.descuento AS descuento, pca.precio_final AS precio, pca.idproveedor,
                        IFNULL((SELECT SUM(po.cantidad) FROM partes_oc po WHERE po.estatus = 0 AND po.idpartecosto =pca.id),0) AS asignado
                        FROM partes_costos_asignar pca, partes_rq pr
                        WHERE pca.idparterq = pr.id 
                        AND pca.id =".$arrayid[$i];
            $resultQuery = $this->General_Model->infoxQueryUnafila($query);

            $inData2 = array('idpartecosto'=>$resultQuery->id, 'idpartecot'=>$resultQuery->idpartecot, 'idparte'=>$resultQuery->idparte, 'cantidad'=>$resultQuery->cantidad, 'costo'=>$resultQuery->costo_proveedor, 'iva'=>$resultQuery->iva, 'descuento'=>$resultQuery->descuento, 'precio'=>$resultQuery->precio, 'idproveedor'=>$idproveedor);
            $inTable2 = "partes_oc";
            $this->General_Model->altaERP($inData2,$inTable2);
            
            // UPDATE ESTATUS

            $asignadototal=$resultQuery->asignado+$resultQuery->cantidad;
            $requerido=$resultQuery->requerido;

            $restax=$requerido-$asignadototal;

            if( ($restax)==0 ){

                $udatos=array('estatus' => 1, 'solicitar'=>0);
                
            } else{

                $udatos=array('solicitar'=>$restax);

            }               
            
            $itabla="partes_costos_asignar";
            $ucondicion=array('id'=> $arrayid[$i]);
            $this->General_Model->updateERP($udatos,$itabla,$ucondicion);
            

            // END UPDATE ESTATUS

        }

        echo json_encode(true);

    }


    public function asignarPartidas()
    {

        $data_post = $this->input->post();
        $arrayid = $data_post["idpoc"];//idrq array
        $idproveedor = $data_post["idpro"];//id proveedor
        $idUser = $data_post["iduser"];

        //for ($i = 0; $i < count($arrayid); $i++) {
            /*$datos = array('idproveedor' => $idproveedor);
            $tabla = "partes_asignar_oc";
            $condicion = array('id' => $arrayid[$i]);
            $this->General_Model->updateERP($datos, $tabla, $condicion);*/
            ////// GUARDAR en la tabla de partes_costos_asignar -> esta guardara las partidas aignadas al proveedor antes de convertirse en odc  - partes_costos_asignar
        //}
        
        for ($i = 0; $i < sizeof($arrayid); $i++) {

            $query = "SELECT idparte, cantidad FROM temporal_partes_asignar_oc WHERE id = ".$arrayid[$i];
            $resultQuery = $this->General_Model->infoxQuery($query);
            
            foreach ($resultQuery as $row) {

                $cantidad = $row->cantidad;

                $query2 = "SELECT * FROM partes_asignar_oc WHERE idparte = ".$row->idparte." AND estatus = 0 ORDER BY cantidad DESC";
                $resultQuery2 = $this->General_Model->infoxQuery($query2);

                foreach ($resultQuery2 as $row2) {                     

                    $cantidadInsert = 0;
                    $thisUP = false;

                    if($cantidad >= $row2->cantidad ){
                        $cantidadInsert = $row2->cantidad;
                        $thisUP = true;
                    }else{
                        $cantidadInsert = $cantidad;
                    }
                    

                    $inData2 = array('fecha' => date("Y-m-d"), 'iduser' => $idUser, 'idpasignar' => $row2->id, 'idproveedor' =>$idproveedor, 'idoc' => $row2->idoc, 'idparte' => $row2->idparte, 'costo' => $row2->costo, 'iva' => $row2->iva, 'cantidad' => $cantidadInsert, 'estatus' =>0);
                    $inTable2 = "partes_costos_asignar";
                    $this->General_Model->altaERP($inData2,$inTable2);

                    if($thisUP == true){
                        $udatos=array('estatus' => 1);
                        $itabla="partes_asignar_oc";
                        $ucondicion=array('id'=> $row2->id);
                        $this->General_Model->updateERP($udatos,$itabla,$ucondicion);
                    }else{
                        $udatos=array('cantidad' => $row2->cantidad-$cantidad);
                        $itabla="partes_asignar_oc";
                        $ucondicion=array('id'=> $row2->id);
                        $this->General_Model->updateERP($udatos,$itabla,$ucondicion);
                    }

                    $cantidad = $cantidad - $cantidadInsert;

                    if($cantidad == 0){
                        echo json_encode(true);
                        return;
                    }
                    
                }               

            }

        }
                   

        echo json_encode(true);
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
            case 5:
                // Cantidad                 
                $udatos=array('solicitar' => $data_post["texto"]);
                $itabla="partes_costos_asignar";
                $ucondicion=array('id'=> $data_post["idprq"]);
                $this->General_Model->updateERP($udatos,$itabla,$ucondicion);                
            break;


            case 6:
                // Costo                 
                $udatos=array('costo_proveedor' => $data_post["texto"]);
                $itabla="partes_costos_asignar";
                $ucondicion=array('id'=> $data_post["idprq"]);
                $this->General_Model->updateERP($udatos,$itabla,$ucondicion);                
            break;

            case 8:
                // Descuento                 
                $udatos=array('descuento' => $data_post["texto"]);
                $itabla="partes_costos_asignar";
                $ucondicion=array('id'=> $data_post["idprq"]);
                $this->General_Model->updateERP($udatos,$itabla,$ucondicion);                
            break;
            
        }

        /*$sqlCantidades = "SELECT costo_final, iva, descuento FROM partes_costos_asignar WHERE id =".$data_post["idprq"];
        $cantidades = $this->General_Model->infoxQueryUnafila($sqlCantidades); 
        $precioFinal = calcularPrecio($cantidades->costo_final, $cantidades->iva, $cantidades->descuento);
        $udatos=array('precio_final' => $precioFinal);
                    $itabla="partes_costos_asignar";
                    $ucondicion=array('id'=> $data_post["idprq"]);
                    $this->General_Model->updateERP($udatos,$itabla,$ucondicion);*/


        ;


        $sdata="costo_proveedor,solicitar,descuento";
        $stabla="partes_costos_asignar";
        $scondicion=array('id'=>$data_post["idprq"]);

        echo json_encode($this->General_Model->SelectUnafila($sdata,$stabla,$scondicion));
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

        if ($data_get["rq"] > 0) {
            
            $cotFilter = true;

            $table = "(SELECT pca.id AS id, ap.nparte AS nparte, CONCAT_WS('||',ap.nparte,ap.descripcion) AS descrip,
                        CONCAT_WS('/',(IFNULL((SELECT SUM(po.cantidad) FROM partes_oc po WHERE po.idpartecosto = pca.id),0)),pca.cantidad) AS cantidad,
                        pca.solicitar AS solicitar, pca.costo_proveedor, pca.precio AS precio_venta, pca.descuento, 
                        pca.iva AS iva,pca.idparterq AS parterq
                        FROM partes_costos_asignar pca, alta_productos ap, alta_rq ar, partes_rq pr
                        WHERE pca.idparte = ap.id
                        AND pr.id = pca.idparterq
                        AND ar.id = pr.idrq
                        AND pca.estatus = 0
                        AND ar.id =" . $data_get['rq'] . ")temp ";

        } elseif ($data_get["rq"] == 0) {

            $table = "(SELECT pca.id AS id, ap.nparte AS nparte, CONCAT_WS('||',ap.nparte,ap.descripcion) AS descrip,
                        CONCAT_WS('/',(IFNULL((SELECT SUM(po.cantidad) FROM partes_oc po WHERE po.idpartecosto = pca.id),0)),pca.cantidad) AS cantidad,
                        pca.solicitar AS solicitar, pca.costo_proveedor, pca.precio AS precio_venta, pca.descuento, 
                        pca.iva AS iva,pca.idparterq AS parterq
                        FROM partes_costos_asignar pca, alta_productos ap
                        WHERE pca.idparte = ap.id
                        AND pca.estatus = 0)temp";
        }        

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
                'db' => 'parterq',     'dt' => 1,
                'formatter' => function ($d, $row) use ($cotFilter) {
                    
                    return showRQ($d);

                }
            ),
            //array( 'db' => 'proveedor',     'dt' => 2 ),
            array('db' => 'nparte',     'dt' => 2),
            array(
                'db' => 'descrip',     'dt' => 3,
                'formatter' => function ($d, $row) {
                    $separar = explode("||", $d);
                    return '<p title="' . utf8_encode($separar[1]) . '">' . utf8_encode($separar[0]) . '&nbsp;&nbsp;' . utf8_encode(substr($separar[1], 0, 30)) . '</p>';
                }
            ),
            array('db' => 'cantidad',     'dt' => 4),
            array('db' => 'solicitar',     'dt' => 5),
            array('db' => 'costo_proveedor',     'dt' => 6,
                'formatter' => function ($d, $row) {
                    return wims_currency($d);
                }
            ),
            array('db' => 'precio_venta',     'dt' => 7,
                'formatter' => function ($d, $row) {

                    //$precio_real=$row["precio_venta"]-$row["descuento"];

                    return wims_currency($d);
                }
            ),
            array('db' => 'descuento',     'dt' => 8),
            array('db' => 'iva',     'dt' => 9),

            
           
            array('db' => 'id',     'dt' => 11),

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



    public function loadPartidaspro()

    {

        $iduser = $this->session->userdata('idusercomanorsa');
        $data_get = $this->input->get();
        $table = "(SELECT a.idparte,a.id,a.idoc,a.idcot,b.nparte,
                    CONCAT_WS('/',a.id,a.idproveedor) AS asignar,
                    CONCAT_WS('/',b.nparte,b.descripcion) AS descrip,
                    c.nombre AS proveedor, ( SUM(a.cantidad)- IFNULL( (SELECT (SUM(y.cantidad)+SUM(y.almacen)) AS asignados FROM partes_costos_asignar y WHERE y.idparte=a.idparte AND y.estatus=0),0 ) ) AS tot_solicitado,a.idparte AS almacen,a.costo,
                    CASE (SELECT t.iva FROM alta_productos t WHERE t.id=a.idparte) WHEN 1 THEN (SELECT z.iva FROM datos_generales z WHERE z.estatus = 0) WHEN 2 THEN 0 WHEN 3 THEN (SELECT t.tasa FROM alta_productos t WHERE t.id=a.idparte) END AS ivax, a.descuento, a.cantidad_oc
                    FROM partes_asignar_oc a, alta_productos b, alta_proveedores c
                    WHERE a.idparte=b.id
                    AND a.idproveedor=c.id
                    AND a.estatus = 0
                    AND a.idproveedor = ".$data_get['idpro']."                      
                    GROUP BY a.idparte
                    ORDER BY `b`.`nparte` ASC)temp"; 

        // Primary key of table

        $primaryKey = 'id';
        $columns = array(
            /*<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                Default <span class="caret"></span>

                              </button>*/
            array( 'db' => 'asignar',     'dt' => 0,
                    'formatter' => function( $d, $row ) {
                        $separar = explode("/", $d);
                        if ( $separar[1] > 0 ) {                            
                            return '<input type="checkbox" name="menux" value="'.$separar[0].'" style="border-color:#FF338A; border-style:solid;" tabindex="-1" disabled>';
                        }else{
                            return '<input type="checkbox" name="menux" value="'.$separar[0].'" style="border-color:#FF338A; border-style:solid;" tabindex="-1" disabled>';
                        }
                    }  
            ),
            array( 'db' => 'idcot',     'dt' => 1,
                    'formatter' => function( $d, $row ) {
                            /*$separar = explode(" ", $d);
                            if ( $separar[0] == "REM" ) {
                                return '<a href="'.base_url().'tw/php/remisiones/rem'.$separar[1].'.pdf" target="_blank" style="color:#F7694C;"  tabindex="-1">'.$d.'</a>';
                            }else{
                                return '<a href="'.base_url().'tw/php/facturaciones/fact'.$separar[1].'.pdf" target="_blank" style="color:darkgreen;"  tabindex="-1">'.$d.'</a>';
                            }*/
                            return '<a href="'.base_url().'tw/php/cotizaciones/cot'.$d.'.pdf" target="_blank" style="color:darkblue;"  tabindex="-1">Cot#'.$d.'</a>';
                    }  
            ),
            //array( 'db' => 'proveedor',     'dt' => 2 ),
            array( 'db' => 'nparte',     'dt' => 2),
            array( 'db' => 'descrip',     'dt' => 3,
                    'formatter' => function( $d, $row ) {
                            $separar = explode("/", $d);
                            return '<p title="'.utf8_encode($separar[1]).'">'.utf8_encode($separar[0]).'&nbsp;&nbsp;'.utf8_encode( substr($separar[1],0,30) ).'</p>';
                    }  
            ),            
            array( 'db' => 'tot_solicitado',     'dt' => 4 ),
            array('db' => 'almacen',     'dt' => 5,
                'formatter' => function ($d, $row) {
                    return totalXproducto($d);
                }
            ),

            //array( 'db' => 'cantidad_oc', 'dt' => 6 ),

            array( 'db' => 'costo',        
                    'dt' => 8,
                    'formatter' => function( $d, $row ) {
                        return wims_currency($d);
                    }
            ), 
            array( 'db' => 'descuento',     'dt' => 9 ),
            array( 'db' => 'ivax',     'dt' => 10 ),
            array( 'db' => 'id',     'dt' => 12 ),
            array( 'db' => 'idoc',     'dt' => 13 ),
            array('db' => 'cantidad_oc', 'dt' =>14 )
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
}
