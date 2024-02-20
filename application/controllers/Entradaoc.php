<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class Entradaoc extends CI_Controller

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



    public function folioOc()

    {

        $iduser = $this->session->userdata(IDUSERCOM);
        $numero_menu = 16;

        ////////******* verificar menu 

        $vtabla = "menus_departamento";
        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);
        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);

        if ( $verificar_menu > 0 ) {

            $dmenu["nommenu"] = "entrada";
            $idoc = $this->uri->segment(3);

            if( $iduser > 0 ){

                $sql="SELECT a.fecha,a.fentrega,a.observaciones,b.nombre AS comprador, c.nombre AS proveedor,a.id 

                    FROM alta_oc a, alta_usuarios b, alta_proveedores c

                    WHERE a.idusuario=b.id

                    AND a.idpro=c.id

                    AND a.id=".$idoc;

                $datos = $this->General_Model->infoxQueryUnafila($sql);
                $infopro["info"] =  $datos;

                $this->load->view('general/header');

                //$this->load->view('general/css_select2');

                //$this->load->view('general/css_autocompletar');

                //$this->load->view('general/css_xedit');

                $this->load->view('general/css_date');

                $this->load->view('general/css_datatable');

                $this->load->view('general/menuv2');

                $this->load->view('general/menu_header',$dmenu);

                $this->load->view('entradas/alta_entrada',$infopro);

                $this->load->view('general/footer');

                $this->load->view('entradas/acciones_alta_entrada');



            }else{



                redirect("Login");



            }



        }else{



            redirect('AccesoDenegado');

            

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



            case 2:

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
<<<<<<< HEAD
        $foundEntrada = 0;
        $updateStatus = TRUE;

        $sql1 = "SELECT id FROM alta_entrada WHERE idoc='".$data_post["idoc"]."' LIMIT 1";
        $partes = $this->General_Model->infoxQuery($sql1);

        if($partes){
            foreach ($partes as $row) {
                $foundEntrada = $row->id;
            }
        }

        if($foundEntrada == 0){
            //NO SE ENCUENTRA LA ENTRADA, SE DA DE ALTA

            $data = array('fecha' => date("Y-m-d"), 'hora' => date("H:i:s"), 'idoc' => $data_post["idoc"], 'idusuario' => $data_post['iduser'],  'observaciones' => $data_post["obs"], 'estatus' => '2');
            $table = "alta_entrada";
            $last_id= $this->General_Model->altaERP($data,$table);
=======
        
        $updateStatus = TRUE;

        
        $data = array('fecha' => date("Y-m-d"), 'hora' => date("H:i:s"), 'idoc' => $data_post["idoc"], 'idusuario' => $data_post['iduser'],  'observaciones' => $data_post["obs"], 'estatus' => '0');
        $table = "alta_entrada";
        $last_id= $this->General_Model->altaERP($data,$table);
>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2

            if ( $last_id > 0 ) {
                
                // DAMOS DE ALTA CADA PARTIDA DE LA ENTRADA 

                for ($i=0; $i < count($arrayid); $i++) {

                    $separar = explode("/",$arrayid[$i]);
                    $cant_odc = $separar[0];
                    $cant_entrada = $separar[1];
                    $idpentrada = $separar[2];
                    $resta = $cant_odc-$cant_entrada;

<<<<<<< HEAD
                        ///////completa
                        
                    $data2 = "";
                    $sql2 = "SELECT id, idparte, idpartecot FROM partes_asignar_oc WHERE id=".$idpentrada;
                    $info = $this->General_Model->infoxQueryUnafila($sql2);
                    ////
                    if($resta == 0){
                        $data2 = array('fecha' => date("Y-m-d"), 'identrada' => $last_id, 'idoc' => $data_post["idoc"], 'idparteoc' =>  $info->id, 'idparte' =>  $info->idparte, 'cantidad' => $cant_entrada, 'idpartecot' => $info->idpartecot, 'estatus' => 1);
                    }else{
                        $data2 = array('fecha' => date("Y-m-d"), 'identrada' => $last_id, 'idoc' => $data_post["idoc"], 'idparteoc' =>  $info->id, 'idparte' =>  $info->idparte, 'cantidad' => $cant_entrada, 'idpartecot' => $info->idpartecot, 'estatus' => 2);
=======
                    //// DATOS ADICIONALES ENTRADA
                        
                    $data2 = "";
                    $sql2 = "SELECT id, idparte, idpartecot FROM partes_oc WHERE id=".$idpentrada;
                    $info = $this->General_Model->infoxQueryUnafila($sql2);



                    $data2 = array('fecha' => date("Y-m-d"), 'identrada' => $last_id, 'idoc' => $data_post["idoc"], 'idparteoc' =>  $info->id, 'idparte' =>  $info->idparte, 'cantidad' => $cant_entrada, 'idpartecot' => $info->idpartecot, 'estatus' => 0);                  
                    $table2 = "partes_entrada";
                    $this->General_Model->altaERP($data2,$table2);
                   

                    if($resta>0){

                        $updateStatus = FALSE;/// entrada parcial

                        $upartes=array('estatus'=>0);
                        

                    }else{

                        /// entrada completa
                        $upartes=array('estatus'=>1);
                        

>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2
                    }
                    
                    $table2 = "partes_entrada";
                    $this->General_Model->altaERP($data2,$table2);
                    
                    $otherSQL = "SELECT SUM(pe.cantidad) AS parcialidad, IF(pao.cantidad_oc=0,pao.cantidad,pao.cantidad_oc) as cantidad FROM partes_entrada pe, partes_asignar_oc pao WHERE pe.idparteoc=pao.id AND idparteoc=".$idpentrada;
                    $otherInfo = $this->General_Model->infoxQueryUnafila($otherSQL);
                    $restante = $otherInfo->cantidad - $otherInfo->parcialidad;

<<<<<<< HEAD
                    if($restante>0){
                        $updateStatus = FALSE;
                    }
                    
                }

                $datos = array('estatus' => 3 );
                $tabla = "alta_oc";
                $condicion = array('id' => $data_post["idoc"]);
                $this->General_Model->updateERP($datos,$tabla,$condicion);

                if($updateStatus){
                    $datos = array('estatus' => 1 );
                    $tabla = "alta_entrada";
                    $condicion = array('id' => $last_id);
                    $this->General_Model->updateERP($datos,$tabla,$condicion);

                    $otherSQL = "SELECT idoc FROM alta_entrada WHERE id=".$last_id;
                    $otherInfo = $this->General_Model->infoxQueryUnafila($otherSQL);

                    $datos = array('estatus' => 1 );
                    $tabla = "alta_oc";
                    $condicion = array('id' => $otherInfo->idoc);
                    $this->General_Model->updateERP($datos,$tabla,$condicion);

                }

=======
                    $utable = "partes_oc";
                    $ucondicion = array('id' => $info->id);
                    $this->General_Model->updateERP($upartes,$utable,$ucondicion);
                    
                }


                if($updateStatus){

                    /////COMPLETA

                    $estatus_odc = array('estatus' => 1 );

                }else{

                    ///PARCIAL

                    $estatus_odc = array('estatus' => 3 );

                }

                $tabla = "alta_oc";
                $condicion = array('id' => $data_post["idoc"]);
                $this->General_Model->updateERP($estatus_odc,$tabla,$condicion);

>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2
                //echo json_encode( $last_id );

            }

<<<<<<< HEAD
        }else{

            for ($i=0; $i < count($arrayid); $i++) {

                $separar = explode("/",$arrayid[$i]);
                $cant_odc = $separar[0];
                $cant_entrada = $separar[1];
                $idpentrada = $separar[2];
                $resta = $cant_odc-$cant_entrada;

                    ///////completa
                    
                $sql2 = "SELECT id, idparte, idpartecot FROM partes_asignar_oc WHERE id=".$idpentrada;
                $info = $this->General_Model->infoxQueryUnafila($sql2);
                ////
                if($resta == 0){
                    $data2 = array('fecha' => date("Y-m-d"), 'identrada' => $foundEntrada, 'idoc' => $data_post["idoc"], 'idparteoc' =>  $info->id, 'idparte' =>  $info->idparte, 'cantidad' => $cant_entrada, 'idpartecot' => $info->idpartecot, 'estatus' => 1);
                }else{
                    $data2 = array('fecha' => date("Y-m-d"), 'identrada' => $foundEntrada, 'idoc' => $data_post["idoc"], 'idparteoc' =>  $info->id, 'idparte' =>  $info->idparte, 'cantidad' => $cant_entrada, 'idpartecot' => $info->idpartecot, 'estatus' => 2);
                }
                
                $table2 = "partes_entrada";
                $this->General_Model->altaERP($data2,$table2);
                
                $otherSQL = "SELECT SUM(pe.cantidad) AS parcialidad, IF(pao.cantidad_oc=0,pao.cantidad,pao.cantidad_oc) as cantidad FROM partes_entrada pe, partes_asignar_oc pao WHERE pe.idparteoc=pao.id AND idparteoc=".$idpentrada;
                $otherInfo = $this->General_Model->infoxQueryUnafila($otherSQL);
                $restante = $otherInfo->cantidad - $otherInfo->parcialidad;

                if($restante>0){
                    $updateStatus = FALSE;
                }
                
            }

            $datos = array('estatus' => 3 );
            $tabla = "alta_oc";
            $condicion = array('id' => $data_post["idoc"]);
            $this->General_Model->updateERP($datos,$tabla,$condicion);

            if($updateStatus){
                $datos = array('estatus' => 1 );
                $tabla = "alta_entrada";
                $condicion = array('id' => $foundEntrada);
                $this->General_Model->updateERP($datos,$tabla,$condicion);

                $otherSQL = "SELECT idoc FROM alta_entrada WHERE id=".$foundEntrada;
                $otherInfo = $this->General_Model->infoxQueryUnafila($otherSQL);

                $datos = array('estatus' => 1 );
                $tabla = "alta_oc";
                $condicion = array('id' => $otherInfo->idoc);
                $this->General_Model->updateERP($datos,$tabla,$condicion);
            }


        }

        echo json_encode(TRUE);

=======
       
        echo json_encode( true );
>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2
    }



    public function entradaAll(){

        $data_post = $this->input->post();
        $arrayid = $data_post["info"];
        $foundEntrada = 0;
        $updateStatus = TRUE;

        $sql1 = "SELECT id FROM alta_entrada WHERE idoc='".$data_post["idoc"]."' LIMIT 1";
        $partes = $this->General_Model->infoxQuery($sql1);
        foreach ($partes as $row) {
            $foundEntrada = $row->id;
        }

        if($foundEntrada == 0){
            //NO SE ENCUENTRA LA ENTRADA, SE DA DE ALTA

            $data = array('fecha' => date("Y-m-d"), 'hora' => date("H:i:s"), 'idoc' => $data_post["idoc"], 'idusuario' => $data_post['iduser'],  'observaciones' => $data_post["obs"], 'estatus' => '2');
            $table = "alta_entrada";
            $last_id= $this->General_Model->altaERP($data,$table);

            if ( $last_id > 0 ) {
                
                // DAMOS DE ALTA CADA PARTIDA DE LA ENTRADA 

                for ($i=0; $i < count($arrayid); $i++) {

                    $separar = explode("/",$arrayid[$i]);
                    $cant_odc = $separar[0];
                    $cant_entrada = $separar[1];
                    $idpentrada = $separar[2];
                    $resta = $cant_odc-$cant_entrada;

                        ///////completa
                        
                    $sql2 = "SELECT id, idparte, idpartecot FROM partes_asignar_oc WHERE id=".$idpentrada;
                    $info = $this->General_Model->infoxQueryUnafila($sql2);
                    ////
                    if($resta == 0){
                        $data2 = array('fecha' => date("Y-m-d"), 'identrada' => $last_id, 'idoc' => $data_post["idoc"], 'idparteoc' =>  $info->id, 'idparte' =>  $info->idparte, 'cantidad' => $cant_entrada, 'idpartecot' => $info->idpartecot, 'estatus' => 1);
                    }else{
                        $data2 = array('fecha' => date("Y-m-d"), 'identrada' => $last_id, 'idoc' => $data_post["idoc"], 'idparteoc' =>  $info->id, 'idparte' =>  $info->idparte, 'cantidad' => $cant_entrada, 'idpartecot' => $info->idpartecot, 'estatus' => 2);
                    }
                    
                    $table2 = "partes_entrada";
                    $this->General_Model->altaERP($data2,$table2);
                    
                }


                $datos = array('estatus' => 1 );
                $tabla = "alta_entrada";
                $condicion = array('id' => $last_id);
                $lastupt=$this->General_Model->updateERP($datos,$tabla,$condicion);

                $otherSQL = "SELECT idoc FROM alta_entrada WHERE id=".$last_id;
                $otherInfo = $this->General_Model->infoxQueryUnafila($otherSQL);

                $datos = array('estatus' => 1 );
                $tabla = "alta_oc";
                $condicion = array('id' => $otherInfo->idoc);
                $this->General_Model->updateERP($datos,$tabla,$condicion);
                
                //echo json_encode( $last_id );

            }

        }else{

            for ($i=0; $i < count($arrayid); $i++) {

                $separar = explode("/",$arrayid[$i]);
                $cant_odc = $separar[0];
                $cant_entrada = $separar[1];
                $idpentrada = $separar[2];
                $resta = $cant_odc-$cant_entrada;

                    ///////completa
                    
                $sql2 = "SELECT id, idparte, idpartecot FROM partes_asignar_oc WHERE id=".$idpentrada;
                $info = $this->General_Model->infoxQueryUnafila($sql2);
                ////
                if($resta == 0){
                    $data2 = array('fecha' => date("Y-m-d"), 'identrada' => $foundEntrada, 'idoc' => $data_post["idoc"], 'idparteoc' =>  $info->id, 'idparte' =>  $info->idparte, 'cantidad' => $cant_entrada, 'idpartecot' => $info->idpartecot, 'estatus' => 1);
                }else{
                    $data2 = array('fecha' => date("Y-m-d"), 'identrada' => $foundEntrada, 'idoc' => $data_post["idoc"], 'idparteoc' =>  $info->id, 'idparte' =>  $info->idparte, 'cantidad' => $cant_entrada, 'idpartecot' => $info->idpartecot, 'estatus' => 2);
                }
                
                $table2 = "partes_entrada";
                $this->General_Model->altaERP($data2,$table2);
            
            }

            $datos = array('estatus' => 1 );
            $tabla = "alta_entrada";
            $condicion = array('id' => $foundEntrada);
            $lastupt=$this->General_Model->updateERP($datos,$tabla,$condicion);

            $otherSQL = "SELECT idoc FROM alta_entrada WHERE id=".$foundEntrada;
            $otherInfo = $this->General_Model->infoxQueryUnafila($otherSQL);

            $datos = array('estatus' => 1 );
            $tabla = "alta_oc";
            $condicion = array('id' => $otherInfo->idoc);
            $this->General_Model->updateERP($datos,$tabla,$condicion);
            
        }

    }

    public function finalizarEntrada(){

        $data_post = $this->input->post();
        $arrayid = $data_post["info"];

        $separar = explode("/",$arrayid[0]);

        $datos = array('estatus' => 0 );
        $tabla = "partes_asignar_oc";
        $condicion = array('id' => $separar[2]);
        echo json_encode($this->General_Model->updateERP($datos,$tabla,$condicion));
        

    }

        ///////////****************TABLA PARTIDAS

        public function loadPartidas()

        {

            $iduser = $this->session->userdata('idusercomanorsa');
            $data_get = $this->input->get();

            /*$table = '( SELECT a.id, CONCAT_WS("/",b.nparte,b.descripcion) AS descrip,a.cantidad AS pedido,c.costo,c.descuento,c.iva,e.id AS idcot,"" AS documentox
                FROM partes_entrada a, alta_productos b, partes_asignar_oc c, partes_cotizacion d, alta_cotizacion e
                WHERE a.idparte=b.id
                AND a.idparteoc=c.id
                AND a.idpartecot=d.id
                AND d.idcotizacion=e.id
                AND a.identrada = 0
                AND a.idoc ='.$data_get["idoc"].' )temp'; */

<<<<<<< HEAD
            $table='(SELECT pao.id AS id, CONCAT_WS("/",ap.nparte,ap.descripcion) AS descrip, (IF(pao.cantidad_oc=0,pao.cantidad,pao.cantidad_oc)) AS pedido,
                        pao.costo AS costo, pao.iva AS iva, pao.idcot AS idcot, pao.idparte AS idparte, "" AS documentox, pao.descuento AS descuento, IFNULL((SELECT SUM(pe.cantidad) FROM partes_entrada pe WHERE idparteoc=pao.id),0) AS parcialidades,
                        (IF(pao.cantidad_oc=0,pao.cantidad,pao.cantidad_oc))-(IFNULL((SELECT SUM(pe.cantidad) FROM partes_entrada pe WHERE idparteoc=pao.id),0)) AS entrada
                        FROM partes_asignar_oc pao, alta_productos ap
                        WHERE pao.idparte = ap.id 
                        AND pao.estatus !=0
                        AND pao.idoc ='.$data_get["idoc"].')temp';
=======
            $table='(SELECT pao.id, CONCAT_WS("/",ap.nparte,ap.descripcion) AS descrip, 
                        pao.cantidad AS pedido, pao.costo AS costo, pao.iva AS iva, pao.idparte AS idparte,
                        pao.descuento AS descuento, IFNULL((SELECT SUM(pe.cantidad) FROM partes_entrada pe WHERE idparteoc=pao.id),0) AS parcialidades,
                        ((pao.cantidad)-(IFNULL((SELECT SUM(pe.cantidad) FROM partes_entrada pe WHERE idparteoc=pao.id),0))) AS entrada,
                        pc.idcotizacion
                        FROM partes_oc pao, alta_productos ap, partes_cotizacion pc
                        WHERE pao.idparte = ap.id
                        AND pao.idpartecot=pc.id 
                        AND pao.estatus =0
                        AND pao.idoc='.$data_get["idoc"].')temp';

                        

>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2

            // Primary key of table
            $primaryKey = 'id';

            $columns = array(

                /*<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    Default <span class="caret"></span>

                                  </button>*/
                array( 'db' => 'id',     'dt' => 0,
                        'formatter' => function( $d, $row ) {
                            return '<div class="btn-group">
                                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="caret"></span>
                                      </button>
                                      <ul class="dropdown-menu">
                                        <li><a  data-toggle="modal" data-target="#modal_info" style="color:green; font-weight:bold;"><i class="fa fa-plus" style="color:green; font-weight:bold;"></i> Agregar info</a></li>
                                        <li><a href="javascript:finalizarEntrada('.$d.')" style="color:red; font-weight:bold;"><i class="fa fa-cancel" style="color:red; font-weight:bold;"></i> Finalizar</a></li>
                                      </ul>
                                    </div>';
                        }
                ),

                array( 'db' => 'descrip',     'dt' => 1,
                        'formatter' => function( $d, $row ) {
                                $separar = explode("/", $d);
                                return '<p>'.utf8_encode($separar[0]).'</p><p>'.utf8_encode($separar[1]).'</p>';
                        }  
                ),

<<<<<<< HEAD
                array( 'db' => 'idcot',        
                        'dt' => 2,
                        'formatter' => function( $d, $row ) {
                            if ($d==0) {
=======
                array( 'db' => 'idcotizacion',        
                        'dt' => 2,
                        'formatter' => function( $d, $row ) {

                            if ($d==0) {

>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2
                                 return "<p>ALMACEN</p>";
                            }else{
<<<<<<< HEAD
                                return "<a href='".base_url()."tw/php/cotizaciones/cot".$d.".pdf' target='_blank'>COT#".$d."</a>";
=======

                                //////////************** CREAR FOLIO ODV0010000

                              $idcot = $d;

                              $folio = 0;

                              $inicio = 10000;

                              $nuevo = $inicio+$idcot;



                              switch ( strlen($nuevo) ) {



                                  case 5:

                                      

                                      $folio = "ODV00".$nuevo;



                                  break;



                                  case 6:

                                      

                                      $folio = "ODV0".$nuevo;



                                  break;



                                  case 7:

                                      

                                      $folio = "ODV".$nuevo;



                                  break;



                                  default:



                                      $folio = "s/asignar";



                                  break;



                              }





                                return '<a href="'.base_url().'tw/php/cotizaciones/cot'.$d.'.pdf" target="_blank">'.$folio.'</a>';

>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2
                            }
                        }
                ), 

                /*array( 'db' => 'documentox',        

                        'dt' => 2), */

                array( 'db' => 'pedido',     'dt' => 3 ),
                array( 'db' => 'parcialidades',     'dt' => 4 ),
                array( 'db' => 'entrada',     'dt' => 5 ),

                array( 'db' => 'costo',        
                        'dt' => 6,
                        'formatter' => function( $d, $row ) {
                            return "<p>".wims_currency($d)."</p>";
                        }
                ), 
                /*array( 'db' => 'descuento',     'dt' => 6 ),*/

                array( 'db' => 'iva',     'dt' => 7 ),
                array( 'db' => 'id',     'dt' => 8 ),
                array( 'db' => 'id',     'dt' => 9 ),
                array( 'db' => 'id',     'dt' => 10 )
<<<<<<< HEAD
=======
               
>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2

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

            echo json_encode(SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns));
        }
    
}

