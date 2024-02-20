<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class Centregav2 extends CI_Controller

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

        function almacen($idpartey){

            $ci =& get_instance();
            $entradas=0;
            $salidas = 0;    

            $class = $ci->db->query("
                SELECT CONCAT_WS('<br>',a.nparte,a.descripcion) AS descrip,b.abr,
                IFNULL( (SELECT SUM(pa.cantidad) FROM partes_entrada pa WHERE pa.idparte = a.id AND pa.estatus=0),0) + 
                IFNULL((SELECT SUM(ex.cantidad) FROM partes_ajuste_entrada ex WHERE ex.estatus = 0 AND idparte = a.id ),0) totentrada,

                IFNULL((SELECT SUM(pas.cantidad) FROM partes_ajuste_salida pas WHERE pas.estatus = 0 AND pas.idparte = a.id),0) +
                IFNULL( (SELECT SUM(pef.cantidad) FROM `partes_entrega_factura` pef WHERE pef.estatus = 0 AND pef.idparte=a.id),0) AS totentrega

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



            $idoc = $this->uri->segment(3);

            $dmenu["nommenu"] = "entrega";



        

            if($iduser > 0){



                $this->load->view('general/header');

                $this->load->view('general/css_upload');

                //$this->load->view('general/css_autocompletar');

                //$this->load->view('general/css_xedit');

                $this->load->view('general/css_date');

                $this->load->view('general/css_datatable');

                $this->load->view('general/menuv2');

                $this->load->view('general/menu_header',$dmenu);

                $this->load->view('entregas/alta_entregav2');

                $this->load->view('general/footer');

                $this->load->view('entregas/acciones_alta_entregav2');



            }else{



                redirect("Login");



            }



        } 

       

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



        switch ( $data_post["columna"] ) {



            case 3:

            /// cantidad



            if ( $data_post["texto"] > 0 ) {

               

                $datos = array(

                    

                    'cantidad' => $data_post["texto"]

                   

                );



            }else{



                $error = 1;



            }

                

            break; 

                       

        }



        

              

        if ( $error == 0 ) {



            $condicion = array(



                    'id' => $data_post["idpentrada"] 



                );



            $tabla = "partes_entrada";



            $update=$this->General_Model->updateERP($datos,$tabla,$condicion);



            ///////////////// VERIFICAR LA ENTRADA PÁRCIAL



            $cantidad_odc = $data_post["cantidad_odc"];

            $cantidad_entrada = $data_post["texto"];

            $resta = $cantidad_odc-$cantidad_entrada;



            if ( $resta > 0 ) {



                $query="SELECT idoc,idparte,idparteoc

                        FROM partes_entrada WHERE id=".$data_post["idpentrada"];



                $info_odc = $this->General_Model->infoxQueryUnafila($query);



                //////



                $data2 = array('fecha' => date("Y-m-d"),'idoc' => $info_odc->idoc, 'idparteoc' => $info_odc->idparteoc, 'idparte' => $info_odc->idparte, 'cantidad' => $resta );



                $table2 = "partes_entrada";



                $this->General_Model->altaERP($data2,$table2);

                

            }



            echo json_encode( $update );



        }else{





            $update = null;



            echo json_encode( $update );



        }



    }





    public function entradaParcial(){

        $data_post = $this->input->post();
        $arrayid = $data_post["info"];

        $sqlfactura='SELECT y.id FROM folio_factura x,alta_factura y WHERE y.idfolio=x.id AND x.folio='.trim($data_post["foliox"]);
        $idfacturax=$this->General_Model->infoxQueryUnafila($sqlfactura);

       //////// alta de entrega

        $data = array('fecha' => date("Y-m-d"), 'hora' => date("H:i:s"), 'recibio' => $data_post["recibio"], 'idusuario' => $data_post['iduser'],  'tipo' => $data_post["tipox"],
            'idfactura' =>$idfacturax->id,  'archivo' => $data_post["name_factpdf"],
            'observaciones' => changeString($data_post['obs'])
        );

        $table = "alta_entrega";
        $last_id= $this->General_Model->altaERP($data,$table);

        if ( $last_id > 0 ) {

            for ($i=0; $i < count($arrayid); $i++) {

                $separar = explode( "/",$arrayid[$i] );
                $cant_doc = $separar[0];
                $cant_entrega = $separar[1];
                $idpentrega = $separar[2];///  IDPARTE_FACTURA
                $resta = $cant_doc-$cant_entrega;

            
            }



            echo json_encode( $last_id );



        }else{



            echo  json_encode( 0 );



        }





    }



    public function entradaAll(){

        $data_post = $this->input->post();
        ////////////*************** idfactura

        $sqlfactura='SELECT y.id FROM folio_factura x,alta_factura y WHERE y.idfolio=x.id AND (CONCAT(x.serie,x.folio)="'.trim($data_post["foliox"]).'" OR x.folio="'.trim($data_post["foliox"]).'")';
        $idfacturax=$this->General_Model->infoxQueryUnafila($sqlfactura);

       //////// alta de entrega
        $data = array('fecha' => date("Y-m-d"), 'hora' => date("H:i:s"), 'recibio' => $data_post["recibio"], 'idusuario' => $data_post['iduser'], 'idfactura' =>$idfacturax->id,  'archivo' => $data_post["name_factpdf"],
            'observaciones' => changeString($data_post['obs'])
        );
        $table = "alta_entrega";
        $last_id= $this->General_Model->altaERP($data,$table);

        if ( $last_id > 0 ) {

                $arrayid = $data_post["entregas"];

                $validador=true;

                for ($i=0; $i < count($arrayid); $i++) {

                    $separar = explode("/",$arrayid[$i]);
                    $cant_odc = $separar[0];//cantidad x entregar
                    $cant_entrada = $separar[1];//cantidad entrega actual
                    $idpentrada = $separar[2];//id IDPARTE_FACTURA
                    $resta = $cant_odc-$cant_entrada;

                    if($cant_entrada > 0){
                        // Code para contemplar solo las entregas mayores a 0

                        $sql='SELECT a.idpartecot AS id, a.idparte
                        FROM 
                        partes_factura a,partes_cotizacion b, alta_productos c
                        WHERE
                        a.idpartecot=b.id
                        AND b.idparte=c.id
                        AND a.id='.$idpentrada;

                        $datos = $this->General_Model->infoxQueryUnafila($sql);                    

                        if ( $datos != null ) {                        

                            $data2=array('fecha' =>date('Y-m-d'),'identrega'=>$last_id,'idpartefactura'=>$idpentrada,'idpartecotizacion'=>$datos->id,'cantidad'=>$cant_entrada, 'idparte'=>$datos->idparte );
                            $table2='partes_entrega_factura';
                            $idParteEntrega = $this->General_Model->altaERP($data2,$table2);                        

                            ///// REVISAR SI LA PARTIDA TIENE ASIGNACIONES DE ALMACEN EN LA RQ

                            $vsql="SELECT id, asignado_almacen, entrega_asignacion, idparte, costo FROM `partes_solicitar_rq` WHERE idpartecot='".$datos->id."' AND `asignado_almacen`>`entrega_asignacion`";                        
                            $vrepeat=$this->General_Model->infoxQueryUnafila($vsql);                                        

                            if($vrepeat != null){
                                
                                // se encontro una coincidencia                                                                                                                    
                                // Resta para ingresar a entrega_asignación

                                $restax=$vrepeat->asignado_almacen-$vrepeat->entrega_asignacion;
                                                                    
                                // Consumo de partes_solicitar_rq                                                                
                                if($cant_entrada>$restax){
                                
                                    //// termina la entrega de la asignacion
                                    //$totalasgx=$vrepeat->entrega_asignacion+$cant_entrada;
                                    $cosumirPEPS = $restax;
                                    $usql="UPDATE partes_solicitar_rq SET `entrega_asignacion`=`asignado_almacen` WHERE id=".$vrepeat->id;
                                    $this->General_Model->infoxQueryUpt($usql);

                                }else{

                                    //// cantidada entregada parcial 

                                    $totalasgx=$vrepeat->entrega_asignacion+$cant_entrada;
                                    $cosumirPEPS = $totalasgx;
                                    $usql="UPDATE partes_solicitar_rq SET `entrega_asignacion`='".$totalasgx."' WHERE id=".$vrepeat->id;
                                    $this->General_Model->infoxQueryUpt($usql);

                                }                                

                                // Comienza a buscar en entradas_peps

                                $sqlMovimientoPEPS = "SELECT * FROM entrada_peps WHERE idparte = ".$vrepeat->idparte." AND estatus = 0 ORDER BY fecha ASC";                            
                                $movimientoPEPS = $this->General_Model->infoxQuery($sqlMovimientoPEPS);

                                // Insersión en entregasasignacion
                                        
                                $dataAjuste=array('fecha' =>date('Y-m-d'), 'hora'=>date("H:i:s"), 'idparte'=>$vrepeat->idparte, 'costo'=>$vrepeat->costo, 'cantidad'=> $cosumirPEPS, 'idparteentrega'=> $idParteEntrega, 'idpartefactura' => $idpentrada, 'estatus'=>0);
                                $tableAjuste='entregasasignacion';
                                $this->General_Model->altaERP($dataAjuste,$tableAjuste);

                                foreach($movimientoPEPS as $entradaPEPS) {  

                                    // Selección del valor de entrada_peps
                                    $cantidadConsumida = min($cosumirPEPS, ($entradaPEPS->cantidad - $entradaPEPS->cantidad_consumida));
                                    
                                    // Consumo de PEPS
                                    if ($cosumirPEPS < ($entradaPEPS->cantidad - $entradaPEPS->cantidad_consumida)) {
                                        // Consumo de partidas peps
                                        $updatePEPSql = "UPDATE entrada_peps SET cantidad_consumida = cantidad_consumida + ".$cantidadConsumida." WHERE id = ".$entradaPEPS->id;                                                                    
                                    } else {
                                        // Consumo de partidas peps
                                        $updatePEPSql = "UPDATE entrada_peps SET cantidad_consumida = cantidad_consumida + ".$cantidadConsumida.", estatus = 1 WHERE id = ".$entradaPEPS->id;
                                    } 

                                    $this->General_Model->infoxQueryUpt($updatePEPSql);                                    

                                    $cosumirPEPS -= $cantidadConsumida;

                                    if ($cosumirPEPS <= 0) {
                                        break;
                                    }
                                }                            

                            }
                            
                        
                        }
                    }                    

                    if ($resta>0) {
                        

                        $validador=false;

                    }

                }                                                    



                ////////////************ VERIFICAR SI LA ENTREGA YA ESTA COMPLETA PARA CAMBIAR EL ESTATUS A LA FACTURA DE ENTREGADA


                if($validador) {
                    

                    $udatos = array( 'entrega' => 1 );

                    $ucondicion = array('id'=>$idfacturax->id);

                    $utabla = "alta_factura";

                    $update=$this->General_Model->updateERP($udatos,$utabla,$ucondicion);

                }


                /*$verificar='SELECT a.id,a.cantidad AS cant_documento,

                IFNULL( (SELECT SUM(z.cantidad) FROM partes_entrega_factura z WHERE z.idpartefactura=a.id AND z.identrega > 0 ),0 ) AS entrega

                FROM 

                partes_factura a,partes_cotizacion b, alta_productos c

                WHERE

                a.idpartecot=b.id

                AND b.idparte=c.id

                AND a.idfactura='.$idfacturax->id;



                $datos2 = $this->General_Model->infoxQuery($verificar);



                $verificar_xentregar = 0;



                foreach ($datos2 as $row2) {



                    $cantidad_factura2=$row2->cant_documento;

                    $cantidad_entrega=$row2->entrega;



                    $xentregar = $cantidad_factura2-$cantidad_entrega;



                    if ( $xentregar > 0 ) {

                    

                        $verificar_xentregar=1;



                    } 





                }



                if ( $verificar_xentregar == 0 ) {

                    



                    /////********* ACTUALIZAR ENTREGA DE FACTURA



                    $udatos = array( 'entrega' => 1 );

                    $ucondicion = array(



                        'id'=>$idfacturax->id



                    );

                    $utabla = "alta_factura";

                    $update=$this->General_Model->updateERP($udatos,$utabla,$ucondicion);

                }



                */



                echo json_encode($last_id);



           



        }else{



            echo json_encode(0);



        }





    }



    public function showInfo(){



        $data_post = $this->input->post();





            $query="SELECT CONCAT_WS('',e.serie,e.folio) AS folio,a.ftimbrado, c.nombre AS vendedor, d.nombre AS cliente, a.estatus, a.entrega, '0' AS tipox

            FROM alta_factura a, alta_cotizacion b, alta_usuarios c, alta_clientes d, folio_factura e

            WHERE

            a.idcotizacion=b.id

            AND b.idusuario=c.id

            AND b.idcliente=d.id

            AND a.idfolio=e.id

            AND a.id = (SELECT y.id FROM folio_factura x,alta_factura y WHERE y.idfolio=x.id AND (CONCAT(x.serie, x.folio) = '".trim($data_post["folio"])."' OR (x.folio='".trim($data_post["folio"])."')) LIMIT 0,1)


            UNION ALL

            SELECT CONCAT_WS('',e.serie,e.folio) AS folio,a.ftimbrado, c.nombre AS vendedor, d.nombre AS cliente, a.estatus, a.entrega, '1' AS tipox

            FROM alta_factura_sustitucion a, alta_usuarios c, alta_clientes d, folio_factura e

            WHERE

            a.idusuario=c.id

            AND a.idcliente=d.id

            AND a.idfolio=e.id

            AND a.id = (SELECT y.id FROM folio_factura x,alta_factura_sustitucion y WHERE y.idfolio=x.id AND (CONCAT(x.serie, x.folio) = '".trim($data_post["folio"])."' OR (x.folio='".trim($data_post["folio"])."')) LIMIT 0,1) ";




        echo json_encode( $this->General_Model->infoxQueryUnafila($query) );



    }



        ///////////****************TABLA PARTIDAS 

        



        public function loadPartidas()

        {

            $iduser = $this->session->userdata(IDUSERCOM);
            $data_get = $this->input->get();

           
                ////////// version factura

                $table = '(SELECT a.id,b.orden,CONCAT_WS("/",c.nparte,c.descripcion) AS descrip,
                a.cantidad AS cant_documento, (SELECT IFNULL(SUM(w.cantidad),0) FROM partes_entrega_factura w WHERE w.idpartecotizacion = a.idpartecot) AS entregas,
                b.idparte AS almacen,
                 (a.cantidad- (SELECT IFNULL(SUM(w.cantidad),0) FROM partes_entrega_factura w WHERE w.idpartecotizacion = a.idpartecot)) AS entrega,b.costo,b.descuento,b.iva,a.idpartecot,
                 ( (SELECT IFNULL(SUM(pex.cantidad),0) FROM partes_entrada pex WHERE pex.idpartecot=x.idpartecot)+IFNULL(x.asignado_almacen,0) ) AS entrada_odc

                FROM 
                partes_factura a,partes_cotizacion b
                LEFT JOIN partes_solicitar_rq x ON x.idpartecot=b.id,
                alta_productos c
                WHERE
                a.idpartecot=b.id
                AND b.idparte=c.id
                AND a.idfactura=(SELECT y.id FROM folio_factura x,alta_factura y WHERE y.idfolio=x.id AND (CONCAT(x.serie, x.folio) = "'.trim($data_get["iddoc"]).'" OR (x.folio="'.trim($data_get["iddoc"]).'")) LIMIT 0,1) )temp';


            // Primary key of table

            $primaryKey = 'id';

            

            $columns = array(



                /*<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    Default <span class="caret"></span>

                                  </button>*/





                 array( 'db' => 'orden',     'dt' => 0 ),

                array( 'db' => 'descrip',     'dt' => 1,



                        'formatter' => function( $d, $row ) {



                                $separar = explode("/", $d);



                                return '<p>'.$separar[0].'</p><p>'.$separar[1].'</p>';



                        }  

                ),



                

                array( 'db' => 'cant_documento',     'dt' => 2 ),



                array('db' => 'entrada_odc',     'dt' => 3,
                    'formatter' => function ($d, $row) {
                        return $d;

                        //return 0;
                    }
                ),


                array( 'db' => 'entregas',     'dt' => 4 ),


                array( 'db' => 'entrega',     'dt' => 5 ),



                array( 'db' => 'costo',        

                        'dt' => 6,

                        'formatter' => function( $d, $row ) {



                            return "<p>".wims_currency($d)."</p>";



                        }

                ),

                array( 'db' => 'descuento',     'dt' => 7 ),

                array( 'db' => 'iva',     'dt' => 8 ), 

                array( 'db' => 'id',     'dt' => 10 )   

           

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

