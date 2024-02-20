<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class NuevoRequerimiento extends CI_Controller

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



            $dmenu["nommenu"] = "Nrequerimiento";

            

           

            if($iduser > 0){



                $this->load->view('general/header');

                $this->load->view('general/css_autocompletar');

                $this->load->view('general/css_datatable');

                $this->load->view('general/menuv2');

                $this->load->view('general/css_select2');

                $this->load->view('general/css_upload');

                $this->load->view('general/menu_header',$dmenu);

                $this->load->view('requerimientos/body_rq');

                $this->load->view('general/footer');

                $this->load->view('requerimientos/acciones_rq');



            }else{



                redirect("Login");



            }



        }else{



            redirect('AccesoDenegado');



        }

       

    }




    public function retirarParte(){

        $data_post = $this->input->post();
        $condicion = array( 'id' => $data_post["idpcot"] );
        $tabla="temporal_partes_solicitar_rq";
        $delete=$this->General_Model->deleteERP($tabla,$condicion);
        echo json_encode( $delete );

    }



    public function ingresarPartidas(){
        
        $data_post = $this->input->post();        
        $condicion1 =   array(
            'iduser' => $data_post['iduser'], 
            'idparte' => $data_post['idparte'], 
            'cantidad' => $data_post['cantidad'],
            'estatus' => 0
        );

        $tabla1 = "temporal_partes_solicitar_rq";

        $repeat = $this->General_Model->verificarRepeat($tabla1,$condicion1);
        if ( $repeat == 0 ) {

            
            $data = array(                
                'iduser' => $data_post['iduser'],
                'idparte' => $data_post['idparte'],
                'cantidad' => $data_post['cantidad'],
                'estatus' => 0
            );
            $table = "temporal_partes_solicitar_rq";
            $last_id=$this->General_Model->altaERP($data,$table);

        }else{

            $last_id = 0;

        }


        echo json_encode( $last_id );

    }

    public function loadMaxMin(){
        
        $rowAffected = 0;
        $data_post = $this->input->post();   

        $sqlx = "SELECT a.maximo,a.minimo,a.id,                    
                ((IFNULL( (SELECT SUM(pa.cantidad) FROM partes_entrada pa WHERE pa.idparte = a.id AND pa.estatus=0),0) + IFNULL((SELECT SUM(ex.cantidad) FROM partes_ajuste_entrada ex WHERE ex.estatus = 0 AND idparte = a.id ),0))
                -(IFNULL((SELECT SUM(pas.cantidad) FROM partes_ajuste_salida pas WHERE pas.estatus = 0 AND pas.idparte = a.id),0) + IFNULL( (SELECT SUM(pef.cantidad) FROM partes_entrega_factura pef WHERE pef.estatus = 0 AND pef.idparte=a.id),0))
                ) AS almacen
                ,IFNULL( (SELECT SUM(psr.asignado_almacen) FROM partes_solicitar_rq psr WHERE psr.estatus != 2 AND psr.idparte= a.id),0)  AS asignado
                FROM alta_productos a
                WHERE a.maximo > 0 AND a.minimo >=0";                

        $partes = $this->General_Model->infoxQuery($sqlx);

        foreach ($partes as $row) {

            $rowAffected ++;

            if(($row->almacen + $row->asignado) <= $row->minimo){

                $toInsert = $row->maximo - ($row->almacen + $row->asignado);//5-(-15);


                $condicion1 =   array(
                    'iduser' => $data_post['idUser'], 
                    'idparte' => $row->id, 
                    'cantidad' => $toInsert,
                    'estatus' => 0
                );
        
                $tabla1 = "temporal_partes_solicitar_rq";
        
                $repeat = $this->General_Model->verificarRepeat($tabla1,$condicion1);
                if ( $repeat == 0 ) {
                    
                    $data = array(                
                        'iduser' => $data_post['idUser'],
                        'idparte' => $row->id,
                        'cantidad' => $toInsert,
                        'estatus' => 0
                    );
                    $table = "temporal_partes_solicitar_rq";
                    $this->General_Model->altaERP($data,$table);
        
                }   
            }            

        }

        echo json_encode( $rowAffected );

    }

    public function updateCelda()
    {

        $data_post = $this->input->post();
        $error = 0;    

        switch ($data_post["columna"]) {
            case 4:
                // Cantidad                 
                $udatos=array('cantidad' => $data_post["texto"]);
                $itabla="temporal_partes_solicitar_rq";
                $ucondicion=array('id'=> $data_post["idTemporal"]);
                $this->General_Model->updateERP($udatos,$itabla,$ucondicion);                
            break;
        }

        echo json_encode($data_post["texto"]);
    }


    public function finalizarAjuste(){

        $data_post = $this->input->post();

        /////////verificar repeat

        $rcondicion=array('iduser'=>$data_post["iduser"]);
        $rtabla="temporal_partes_solicitar_rq";

        $repeat=$this->General_Model->verificarRepeat($rtabla,$rcondicion);

        if ($repeat>0) {

            $data = array(
                        'fecha' => date("Y-m-d"),
                        'frq' => date("Y-m-d"),
                        'hora' => date("H:i:s"),            
                        'idusuario' => $data_post["iduser"],
                        'estatus' => 0,
                    );

            $table = "alta_rq";
            $last_id=$this->General_Model->altaERP($data,$table);

            if ( $last_id > 0 ) {
                $sqlx = "SELECT tpsr.idparte, tpsr.cantidad, 
                            IFNULL((SELECT pc.costo_proveedor FROM partes_cotizacion pc WHERE pc.idparte = tpsr.idparte ORDER BY pc.id DESC LIMIT 1),(SELECT ap.costo FROM alta_productos ap WHERE ap.id = tpsr.idparte ORDER BY ap.id DESC LIMIT 1)) AS costo,ap.iva,ap.tasa
                            
                            FROM temporal_partes_solicitar_rq tpsr, alta_productos ap
                            WHERE 
                            tpsr.idparte=ap.id
                            AND tpsr.iduser =".$data_post['iduser']." AND tpsr.estatus=0";
                $partes = $this->General_Model->infoxQuery($sqlx);

                foreach ($partes as $row) {

                    $data3 = array( 
                        'fecha' => date("Y-m-d"), 
                        'hora' => date("H:i:s"),
                        'idcot' => 0,
                        'idpartecot' => 0, 
                        'cantidad' => $row->cantidad, 
                        'cantidad_rq' => $row->cantidad,
                        'idparte' => $row->idparte,
                        'idrq' => $last_id,
                        'estatus' => 0,
                    );

                    $table3 = "partes_rq";
                    $last_id_prq=$this->General_Model->altaERP($data3,$table3);

                    /*$pquery = "SELECT MAX(id) AS id FROM partes_rq";
                    $idPRQ = ($this->General_Model->infoxQueryUnafila($pquery));*/

                    $precio30=$row->costo+($row->costo*.30);
                    $ivax=0;

                    switch ($row->iva) {

                        case 1:
                            
                            $ivax="16";

                        break;

                        case 2:
                            
                            $ivax="0";

                        break;

                        case 3:
                            
                            $ivax=$row->tasa;

                        break;
                        
                        
                    }

                    $dataCostosASG = array( 
                        'fecha' => date("Y-m-d"), 
                        'iduser' => $data_post["iduser"],
                        'idparterq' => $last_id_prq,
                        'idproveedor' => 0, 
                        'idoc' => 0,
                        'costo_proveedor' => $row->costo,
                        'idparte' => $row->idparte,
                        'precio' => $precio30,
                        'costo_final' => $precio30,
                        'precio_final' => $precio30,
                        'iva' => $ivax,
                        'descuento' => 0,
                        'cantidad' => $row->cantidad,
                        'solicitar' => 0,                 
                        'estatus' => 0,
                    );
                    // SE CALCULA EL PRECIO
                    $tableCostosASG = "partes_costos_asignar";
                    $this->General_Model->altaERP($dataCostosASG,$tableCostosASG);

                }

                /////////// ELIMINAR LAS PARTIDAS DEL TEMPORAL
                $condicion4 = array('iduser' => $data_post["iduser"] );
                $tabla4 = "temporal_partes_solicitar_rq";
                $this->General_Model->deleteERP($tabla4,$condicion4);

                echo json_encode($last_id);


            }else{

                echo json_encode(0);

            }

        }else{

            echo json_encode(1);

        }

    }

    public function cancelarRQ() {

        $data_post = $this->input->post();

        $deleteTable = "temporal_partes_solicitar_rq";
        $deleteCondition = array('iduser' => $data_post["idUser"] );

        $this->General_Model->deleteERP($deleteTable,$deleteCondition);

        echo json_encode(true);

    }

    public function loadStock(){

        $data_post=$this->input->post();

        $query = "SELECT CONCAT_WS('<br>',a.nparte,a.descripcion) AS descrip,b.abr,a.maximo,a.minimo,
                    
                    IFNULL((SELECT SUM(ex.cantidad) FROM partes_ajuste_entrada ex WHERE ex.estatus = 0 AND idparte = a.id ),0) totentrada,

                    IFNULL((SELECT SUM(pas.cantidad) FROM partes_ajuste_salida pas WHERE pas.estatus = 0 AND pas.idparte = a.id),0) AS totentrega,

                    IFNULL( (SELECT (SUM(x.asignado_almacen)-SUM(x.entrega_asignacion)) FROM partes_solicitar_rq x WHERE x.asignado_almacen>x.entrega_asignacion AND x.estatus!=2 AND x.idparte=a.id),0 ) AS totasignado
                    FROM alta_productos a, sat_catalogo_unidades b 
                    WHERE
                    a.idunidad=b.id 
                    AND a.id=".$data_post["idparte"];

        echo json_encode($this->General_Model->infoxQueryUnafila($query));

    }


    public function loadPartidas()

        {

            $data_get=$this->input->get();
            $iduser = $data_get["iduser"];
            $data = array();
            $pregunta = array();

                $sql= "SELECT tpsr.id, b.nparte AS clave, CONCAT_WS(' ',b.clave,b.descripcion,d.marca) AS descrip,
                        c.descripcion AS unidad, tpsr.cantidad, tpsr.idparte AS idparte
                        FROM temporal_partes_solicitar_rq tpsr, alta_productos b, sat_catalogo_unidades c, alta_marca d
                        WHERE tpsr.idparte = b.id
                        AND b.idunidad=c.id
                        AND b.idmarca = d.id
                        AND tpsr.iduser = ".$iduser."
                        AND tpsr.estatus = 0
                        ORDER BY id DESC";

                $datos=$this->General_Model->infoxQuery($sql);

                if ($datos!=null) {                    
                    foreach ($datos as $row) {
                        //$separar=explode("/",$row->acciones);                    
                        $pregunta[] = array(
                            'ID'=>$row->id,
                            'ACCION'=>'<button class="btn btn-red" type="button" class="form-control" onclick="retirarParte('.$row->id.')" ><i class="fa fa-trash"></i></button>',                            
                            'CLAVE'=>$row->clave,
                            'DESCRIPCION'=>$row->descrip,
                            'UM'=>$row->unidad,
                            'CANTIDAD'=>$row->cantidad,   
                            'IDPARTE'=>$row->idparte,                            
                        );
                    }
                }

                $data = array("data"=>$pregunta);
                header('Content-type: application/json');
                echo json_encode($data);
        }
}

