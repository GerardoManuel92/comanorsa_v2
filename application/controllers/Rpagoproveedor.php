<?php

defined('BASEPATH')or exit('No direct script access allowed');

include APPPATH.'third_party/ssp.php';



class Rpagoproveedor extends CI_Controller

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



        $this->load->model('General_Model');

      

    }



    public function index()

    {



        $iduser=$this->session->userdata(IDUSERCOM);



        $numero_menu = 11;/// se coloca el mismo identificador que el alta de cotizacion;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



          if($iduser > 0){



              $data["idusuario"]= $iduser;

              //$mensaje['verificacion'] = "Ingreso correctamente por cookie";

              $nom_menu["nommenu"] = "rpagoproveedor";



              $this->load->view('general/header');

              $this->load->view('general/menuv2');

              $this->load->view('general/css_select2');

              $this->load->view('general/css_upload');

              $this->load->view('general/css_datatable');

              $this->load->view('general/menu_header',$nom_menu);

              $this->load->view('pagos/rpago_proveedor');

              $this->load->view('general/footer');

              $this->load->view('pagos/accciones_rpago_proveedor');



          }else{

         

              redirect(base_url("Login/index"));

              

          }



        }else{



          redirect('AccesoDenegado');



        }

       

    }




    public function showClientes(){



        $query="SELECT id, nombre, comercial FROM `alta_clientes` WHERE estatus = 0 ORDER BY nombre ASC";

        echo json_encode( $this->General_Model->infoxQuery($query) );



    }



    public function showVendedor(){



        $query="SELECT id, nombre FROM `alta_usuarios` WHERE iddepartamento IN(2,1) AND estatus = 0 ORDER BY nombre ASC";

        echo json_encode( $this->General_Model->infoxQuery($query) );



    }



    public function habilitarOdc(){



      $data_post = $this->input->post();



      $sqlx = "SELECT idparte,cantidad,id,iva,costo_proveedor,costo,descuento,descripcion,orden FROM `partes_cotizacion` WHERE idcotizacion = ".$data_post["idcot"]." AND estatus = 0";



            //$partes = $this->General_Model->SelectsinOrder($data2,$tabla2,$condicion2);

            $partes = $this->General_Model->infoxQuery($sqlx);



            $npartes = 0;



            //////////////****

            $dtabla = "partes_asignar_oc";

            $dtabla2 ="partes_entrega";

            $dcondicion = array('idcot' => $data_post["idcot"] );

            $dcondicion2 = array('idfolio' => $data_post["idcot"] );



            $this->General_Model->deleteERP($dtabla,$dcondicion);



            $this->General_Model->deleteERP($dtabla2,$dcondicion2);



            foreach ($partes as $row) {



                ////// ACTUALIZAR LAS NUEVAS PARTIDAS DE LA COTIZACION



                /*$data3 = array( 'idcotizacion' => $data_post["idcot"], 'idparte' => $row->idparte, 'costo_proveedor' => $row->costo_proveedor,'cantidad' => $row->cantidad, 'costo' => $row->costo, 'iva' => $row->iva, 'descuento' => $row->descuento, 'descripcion' => $row->descripcion, 'orden' => $row->orden );



                $table3 = "partes_cotizacion";



                $this->General_Model->altaERP($data3,$table3);*/



                ////// ORDEN DE COMPRA



                $data3 = array( 'fecha' => date("y-m-d"), 'hora' => date("H:i:s"), 'idcot' =>$data_post["idcot"], 'idpartecot' => $row->id, 'cantidad'=> $row->cantidad, 'idparte'=> $row->idparte, 'idproveedor' => 1, 'costo' => $row->costo_proveedor, 'iva' => $data_post["idcot"] );



                $table3 = "partes_asignar_oc";



                $last_idoc = $this->General_Model->altaERP($data3,$table3);



                ///// ENTREGA



                $data3x = array( 'fecha' => date("y-m-d"), 'hora' => date("H:i:s"), 'idpartefolio' =>$row->id, 'idfolio' => $data_post["idcot"], 'cantidad'=> $row->cantidad, 'idtipo'=> 1);



                $table3x = "partes_entrega";



                $this->General_Model->altaERP($data3x,$table3x);



                $npartes = $npartes+1;



            }  



            if ( $npartes > 0 ) {

              

              $uptdata = array('odc' => 1 );

              $upttable = "alta_cotizacion";

              $uptcondicion = array('id' => $data_post["idcot"]);

              $this->General_Model->updateERP($uptdata,$upttable,$uptcondicion);



            }



            echo json_encode( $npartes );



    }



    public function subirEvidencia(){



      $data_post = $this->input->post();



        $uptdata = array('evidencia' => $data_post["evidencia"], 'estatus' => 4);

        $upttable = 'alta_cotizacion';

        $uptcondicion = array('id' => $data_post["idcotizacion"] );



      echo json_encode( $this->General_Model->updateERP($uptdata,$upttable,$uptcondicion) );



    }



    public function cancelarCotizacion(){



      $data_post = $this->input->post();



        $uptdata = array('estatus' => 6);

        $upttable = 'alta_cotizacion';

        $uptcondicion = array('id' => $data_post["idcotizacion"]);



      echo json_encode( $this->General_Model->updateERP($uptdata,$upttable,$uptcondicion) );



    }



    public function cancelarPedido(){



      $data_post = $this->input->post();

      $validar=0;

      ///// verificar si ya existe una orden de compra activa



      $tabla="partes_asignar_oc";

      $condicion = array('idcot'=>$data_post["idcotizacion"], 'estatus'=>0, 'idproveedor>'=>1 );



      $verificar=$this->General_Model->verificarRepeat($tabla,$condicion);



      if ( $verificar>0) {

        

        ///// tiene orden de compra activa



        $validar=0;

        

      }elseif ( $verificar == 0 ) {

      

        ////// no tiene ordenes de compra activas habra que eliminar todo lo ya creado para esta cotizacion



        $tabla2="partes_asignar_oc";

        $condicion2 = array('idcot' =>$data_post["idcotizacion"]);

        $this->General_Model->deleteERP($tabla2,$condicion2);



        $tabla3="partes_entrega";

        $condicion3 = array('idfolio' =>$data_post["idcotizacion"]);

        $this->General_Model->deleteERP($tabla3,$condicion3);



        $uptdata = array('estatus' => 0);

        $upttable = 'alta_cotizacion';

        $uptcondicion = array('id' => $data_post["idcotizacion"]);

        $this->General_Model->updateERP($uptdata,$upttable,$uptcondicion);



        $validar=1;





      }



        



        echo json_encode($validar);



    }





    ///////////****************TABLA PARTIDAS BITACORA






        public function loadPartidasFiltro()

        {

            $iduser=$this->session->userdata(IDUSERCOM);

            $departamento=$this->session->userdata(PUESTOCOM);

            $data_post = $this->input->get();


              if ( $data_post["buscador"] == "" OR $data_post["buscador"] == null ) {


                          if ( $data_post['estatus'] == 6  ) {


                            $table = "(SELECT oc.id AS ID,
                                        CASE
                                              WHEN oc.estatus = 1 THEN 'Pagado'
                                              WHEN oc.estatus = 0 THEN 'No pagado'
                                              ELSE 'No asignado'
                                          END AS estatus,
                                        oc.id AS folio,
                                          prov.nombre AS proveedor,
                                          oc.total AS total,
                                          IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
                                          (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
                                      FROM alta_oc oc
                                      INNER JOIN alta_proveedores prov ON prov.id = oc.idpro)temp";

                          }
                          else if ( $data_post['estatus'] == 3  ) {


                            $table = "(	SELECT oc.id AS ID,
                                        CASE
                                              WHEN oc.estatus = 1 THEN 'Pagado'
                                              WHEN oc.estatus = 0 THEN 'No pagado'
                                              ELSE 'No asignado'
                                          END AS estatus,
                                        oc.id AS folio,
                                          prov.nombre AS proveedor,
                                          oc.total AS total,
                                          IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
                                          (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
                                      FROM alta_oc oc
                                      INNER JOIN alta_proveedores prov ON prov.id = oc.idpro
                                      WHERE oc.estatus NOT IN (0,1))temp";

                          }
                          else{


                            $table = "(SELECT oc.id AS ID,
                                    CASE
                                          WHEN oc.estatus = 1 THEN 'Pagado'
                                          WHEN oc.estatus = 0 THEN 'No pagado'
                                          ELSE 'No asignado'
                                      END AS estatus,
                                    oc.id AS folio,
                                      prov.nombre AS proveedor,
                                      oc.total AS total,
                                      IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
                                      (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
                                  FROM alta_oc oc
                                  INNER JOIN alta_proveedores prov ON prov.id = oc.idpro
                                  WHERE oc.estatus = ".$data_post['estatus'].")temp";


                          }

              }else{


                if ( $data_post['estatus'] == 6  ) {


                      $table = "(SELECT oc.id AS ID,
                                  CASE
                                        WHEN oc.estatus = 1 THEN 'Pagado'
                                        WHEN oc.estatus = 0 THEN 'No pagado'
                                        ELSE 'No asignado'
                                    END AS estatus,
                                  oc.id AS folio,
                                    prov.nombre AS proveedor,
                                    oc.total AS total,
                                    IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
                                    (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
                                FROM alta_oc oc
                                INNER JOIN alta_proveedores prov ON prov.id = oc.idpro
                                WHERE CONCAT_WS(oc.id,prov.nombre,oc.total) LIKE '%".$data_post['buscador']."%')temp";


                }
                else if ( $data_post['estatus'] == 3  ) {


                  $table = "(	SELECT oc.id AS ID,
                              CASE
                                    WHEN oc.estatus = 1 THEN 'Pagado'
                                    WHEN oc.estatus = 0 THEN 'No pagado'
                                    ELSE 'No asignado'
                                END AS estatus,
                              oc.id AS folio,
                                prov.nombre AS proveedor,
                                oc.total AS total,
                                IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
                                (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
                            FROM alta_oc oc
                            INNER JOIN alta_proveedores prov ON prov.id = oc.idpro
                            WHERE oc.estatus NOT IN (0,1))temp";

                }
                else{

                      $table = "(SELECT oc.id AS ID,
                                CASE
                                      WHEN oc.estatus = 1 THEN 'Pagado'
                                      WHEN oc.estatus = 0 THEN 'No pagado'
                                      ELSE 'No asignado'
                                  END AS estatus,
                                oc.id AS folio,
                                  prov.nombre AS proveedor,
                                  oc.total AS total,
                                  IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
                                  (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
                              FROM alta_oc oc
                              INNER JOIN alta_proveedores prov ON prov.id = oc.idpro
                              WHERE CONCAT_WS(oc.id,prov.nombre,oc.total) LIKE '%".$data_post['buscador']."%'
                              AND oc.estatus = ".$data_post['estatus'].")temp";

                }



              }



  

            // Primary key of table

            $primaryKey = 'id';

            $columns = array(

                array( 'db' => 'ID',     'dt' => 0,



                        'formatter' => function( $d, $row ) {   
                          return  '<a class="btn btn-success" role="button" onclick="cargarFacturas('.$d.')" btn-id="'. $d .'" data-target="#modal_pago" data-toggle="modal"><i class="fa fa-money"></i></a>';
                        }  

                ),

                array( 'db' => 'estatus',     'dt' => 1,



                        'formatter' => function( $d, $row ) {

                          return utf8_encode($d);

                        }  

                ),

                array( 'db' => 'folio',     'dt' => 2,

                        'formatter' => function( $d, $row ) {

                          $idcot = $d;

                          $folio = 0;

                          $inicio = 10000;

                          $nuevo = $inicio+$idcot;


                          switch ( strlen($nuevo) ) {
                              case 5:
                                  $folio = "ODC00".$nuevo;
                              break;
                              case 6:
                                  $folio = "ODC0".$nuevo;
                              break;
                              case 7:
                                  $folio = "ODC".$nuevo;
                              break;
                              default:
                                  $folio = "s/asignar";
                              break;

                          }

                        return '<a href="'.base_url().'tw/php/ordencompra/odc'.$d.'.pdf" target="_blank">'.$folio.'</a>';
                  }
                ),


                array( 'db' => 'proveedor',     'dt' => 3,



                        'formatter' => function( $d, $row ) {



                            return utf8_encode($d);



                        }  



                ),



                array( 'db' => 'total',     'dt' => 4,



                        'formatter' => function( $d, $row ) {

                          return utf8_encode($d);

                        }  

                ),

                array( 'db' => 'pagado',     'dt' => 5,



                        'formatter' => function( $d, $row ) {



                            return utf8_encode($d);



                        }  



                ),



                array( 'db' => 'porPagar',     'dt' => 6,



                        'formatter' => function( $d, $row ) {

                          return utf8_encode($d);
                        }  

                ),

                array( 'db' => 'ID',     'dt' => 7,



                        'formatter' => function( $d, $row ) {   
                          return  $d;
                        }  

                ),
           

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

                SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns)

            );





        }



        public function loadPartidasEstatus()

        {



            $iduser=$this->session->userdata(IDUSERCOM);

            $departamento=$this->session->userdata(PUESTOCOM);



            $data_post = $this->input->get();





              if ( $data_post['estatus'] == 6  ) {

                
                if ( $data_post["buscador"] == "" OR $data_post["buscador"] == null ) {

                  $table = "(SELECT oc.id AS ID,
                              CASE
                                    WHEN oc.estatus = 1 THEN 'Pagado'
                                    WHEN oc.estatus = 0 THEN 'No pagado'
                                    ELSE 'No asignado'
                                END AS estatus,
                              oc.id AS folio,
                                prov.nombre AS proveedor,
                                oc.total AS total,
                                IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
                                (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
                            FROM alta_oc oc
                            INNER JOIN alta_proveedores prov ON prov.id = oc.idpro)temp";


                }
                else{

                    $table = "(SELECT oc.id AS ID,
                                CASE
                                      WHEN oc.estatus = 1 THEN 'Pagado'
                                      WHEN oc.estatus = 0 THEN 'No pagado'
                                      ELSE 'No asignado'
                                  END AS estatus,
                                oc.id AS folio,
                                  prov.nombre AS proveedor,
                                  oc.total AS total,
                                  IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
                                  (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
                              FROM alta_oc oc
                              INNER JOIN alta_proveedores prov ON prov.id = oc.idpro
                              WHERE CONCAT_WS(oc.id,prov.nombre,oc.total) LIKE '%".$data_post['buscador']."%')temp";

                }

              }
              else if ( $data_post['estatus'] == 3  ) {

                if ( $data_post["buscador"] == "" OR $data_post["buscador"] == null ) {

                  $table = "(SELECT oc.id AS ID,
                              CASE
                                    WHEN oc.estatus = 1 THEN 'Pagado'
                                    WHEN oc.estatus = 0 THEN 'No pagado'
                                    ELSE 'No asignado'
                                END AS estatus,
                              oc.id AS folio,
                                prov.nombre AS proveedor,
                                oc.total AS total,
                                IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
                                (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
                            FROM alta_oc oc
                            INNER JOIN alta_proveedores prov ON prov.id = oc.idpro
                            WHERE oc.estatus NOT IN (0,1))temp";


                }
                else{

                    $table = "(SELECT oc.id AS ID,
                                CASE
                                      WHEN oc.estatus = 1 THEN 'Pagado'
                                      WHEN oc.estatus = 0 THEN 'No pagado'
                                      ELSE 'No asignado'
                                  END AS estatus,
                                oc.id AS folio,
                                  prov.nombre AS proveedor,
                                  oc.total AS total,
                                  IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
                                  (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
                              FROM alta_oc oc
                              INNER JOIN alta_proveedores prov ON prov.id = oc.idpro
                              WHERE CONCAT_WS(oc.id,prov.nombre,oc.total) LIKE '%".$data_post['buscador']."%'
                              AND oc.estatus NOT IN (0,1))temp";

                }

              }else{


                if ( $data_post["buscador"] == "" OR $data_post["buscador"] == null ) {

                    $table = "(SELECT oc.id AS ID,
                                CASE
                                      WHEN oc.estatus = 1 THEN 'Pagado'
                                      WHEN oc.estatus = 0 THEN 'No pagado'
                                      ELSE 'No asignado'
                                  END AS estatus,
                                oc.id AS folio,
                                  prov.nombre AS proveedor,
                                  oc.total AS total,
                                  IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
                                  (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
                              FROM alta_oc oc
                              INNER JOIN alta_proveedores prov ON prov.id = oc.idpro
                              WHERE oc.estatus = ".$data_post['estatus'].")temp";


                }else{


                  $table = "(SELECT oc.id AS ID,
                            CASE
                                  WHEN oc.estatus = 1 THEN 'Pagado'
                                  WHEN oc.estatus = 0 THEN 'No pagado'
                                  ELSE 'No asignado'
                              END AS estatus,
                            oc.id AS folio,
                              prov.nombre AS proveedor,
                              oc.total AS total,
                              IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0) AS pagado,
                              (oc.total-(IFNULL((SELECT SUM(total) FROM facturasxodc WHERE idodc = oc.id LIMIT 0,1),0))) as porPagar
                          FROM alta_oc oc
                          INNER JOIN alta_proveedores prov ON prov.id = oc.idpro
                          WHERE CONCAT_WS(oc.id,prov.nombre,oc.total) LIKE '%".$data_post['buscador']."%'
                          AND oc.estatus = ".$data_post['estatus'].")temp"; 

                }


              }


            // Primary key of table

            $primaryKey = 'id';

            

            $columns = array(

              array( 'db' => 'ID',     'dt' => 0,



                      'formatter' => function( $d, $row ) {   
                        return  '<a class="btn btn-success" role="button" onclick="cargarFacturas('.$d.')" btn-id="'. $d .'" data-target="#modal_pago" data-toggle="modal"><i class="fa fa-money"></i></a>';
                      }  

              ),

              array( 'db' => 'estatus',     'dt' => 1,



                      'formatter' => function( $d, $row ) {

                        return utf8_encode($d);

                      }  

              ),

              array( 'db' => 'folio',     'dt' => 2,

                      'formatter' => function( $d, $row ) {

                        $idcot = $d;

                        $folio = 0;

                        $inicio = 10000;

                        $nuevo = $inicio+$idcot;


                        switch ( strlen($nuevo) ) {
                            case 5:
                                $folio = "ODC00".$nuevo;
                            break;
                            case 6:
                                $folio = "ODC0".$nuevo;
                            break;
                            case 7:
                                $folio = "ODC".$nuevo;
                            break;
                            default:
                                $folio = "s/asignar";
                            break;

                        }

                      return '<a href="'.base_url().'tw/php/ordencompra/odc'.$d.'.pdf" target="_blank">'.$folio.'</a>';
                }
              ),


              array( 'db' => 'proveedor',     'dt' => 3,



                      'formatter' => function( $d, $row ) {



                          return utf8_encode($d);



                      }  



              ),



              array( 'db' => 'total',     'dt' => 4,



                      'formatter' => function( $d, $row ) {

                        return utf8_encode($d);

                      }  

              ),

              array( 'db' => 'pagado',     'dt' => 5,



                      'formatter' => function( $d, $row ) {



                          return utf8_encode($d);



                      }  



              ),



              array( 'db' => 'porPagar',     'dt' => 6,



                      'formatter' => function( $d, $row ) {

                        return utf8_encode($d);
                      }  

              ),
         

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

                SSP::simple($_GET,$sql_details,$table,$primaryKey,$columns)

            );





        }


        public function cargarPago(){



          $data_post = $this->input->post();
          $iduser=$this->session->userdata(IDUSERCOM);

          $ddata = "id";
          $dtabla = "alta_proveedores";
          $dcondicion = array('nombre' => $data_post['idProveedor']);

          $row_partida = $this->General_Model->SelectUnafila($ddata,$dtabla,$dcondicion); 
  
  
          $data = array(
  
              'fecha' => date('Y-m-d'),
              'idodc' => $data_post['idODC'],
              'idproveedor' => $row_partida->id,
              'idsaldo' => 1,
              'iduser' => $iduser,
              'total' => $data_post['total'],
  
          );
  
          $table = "alta_pago_proveedor";

          $insercion = $this->General_Model->altaERP($data,$table);
    
          if ( $insercion > 0 ) {
    
  
          }

  
          echo json_encode( $insercion );
  
  
  
      }

    public function finalizarODC(){

      $data_post = $this->input->post();

      $uptdata = array('estatus' => 1 );

      $upttable = "alta_oc";

      $uptcondicion = array('id' => $data_post["idODC"]);

      echo json_encode($this->General_Model->updateERP($uptdata,$upttable,$uptcondicion));

    }

    public function cargarFacturas(){

      $data_post = $this->input->post();

      $query="SELECT id, folio, uuid, fecha, subtotal, iva, total FROM facturasxodc WHERE idodc='".$data_post["idODC"]."'";

          echo json_encode( $this->General_Model->infoxQuery($query) );

    }

      public function showCuentas(){

        $query="SELECT a.cuenta,b.comercial,a.id
                FROM alta_cuentas_comanorsa a, alta_bancos b
                WHERE a.idbanco=b.id AND a.estatus=0";

            echo json_encode( $this->General_Model->infoxQuery($query) );

    }


}