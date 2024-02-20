<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/ssp.php';



class Kardex extends CI_Controller

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



    public function producto()

    {
<<<<<<< HEAD

        $iduser = $this->session->userdata(IDUSERCOM);



         $numero_menu = 1;



        ////////******* verificar menu 



        $vtabla = "menus_departamento";

        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);

        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);



        if ( $verificar_menu > 0 ) {



            if($iduser > 0){



                $idpro = $this->uri->segment(3);



                $query="SELECT CONCAT_WS('<br>',a.nparte,a.descripcion) AS descrip,b.abr,
                        IFNULL( (SELECT SUM(pa.cantidad) FROM partes_entrada pa, alta_oc ao WHERE ao.estatus IN (1,4) AND pa.idoc = ao.id AND pa.idparte = ".$idpro."),0) + IFNULL((SELECT SUM(ex.cantidad) FROM partes_ajuste_entrada ex, alta_ajuste_entrada ax WHERE ax.id = ex.idajuste AND ax.estatus = 0 AND idparte = a.id),0) totentrada,
                        IFNULL( (SELECT SUM(y.cantidad) FROM `partes_entrega` y, partes_cotizacion w WHERE y.idpartefolio=w.id AND w.idparte = ".$idpro." AND y.estatus = 0 AND y.identrega > 0),0) + IFNULL((SELECT SUM(ex.cantidad) FROM partes_ajuste_salida ex, alta_ajuste_salida ax WHERE ax.id = ex.idajuste AND ax.estatus = 0 AND idparte = a.id),0) +IFNULL( (SELECT SUM(y.cantidad) FROM `partes_entrega_factura` y, partes_factura w WHERE y.idpartefactura=w.id AND w.idparte = ".$idpro." AND y.estatus = 0 AND y.identrega > 0),0) AS totentrega
=======
        $iduser = $this->session->userdata(IDUSERCOM);
        $numero_menu = 1;
        ////////******* verificar menu 

        $vtabla = "menus_departamento";
        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);
        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);

        if ( $verificar_menu > 0 ) {
            if($iduser > 0){

                $idpro = $this->uri->segment(3);

                $query="SELECT CONCAT_WS('<br>',a.nparte,a.descripcion) AS descrip,b.abr,
                        IFNULL( (SELECT SUM(pa.cantidad) FROM partes_entrada pa WHERE pa.idparte = a.id AND pa.estatus=0),0) + 
                        IFNULL((SELECT SUM(ex.cantidad) FROM partes_ajuste_entrada ex WHERE ex.estatus = 0 AND idparte = a.id ),0) totentrada,
                        IFNULL((SELECT SUM(pas.cantidad) FROM partes_ajuste_salida pas WHERE pas.estatus = 0 AND pas.idparte = a.id),0) +
                        IFNULL( (SELECT SUM(pef.cantidad) FROM partes_entrega_factura pef WHERE pef.estatus = 0 AND pef.idparte=a.id),0) AS totentrega,
                        IFNULL( (SELECT SUM(psr.asignado_almacen) FROM partes_solicitar_rq psr WHERE psr.estatus != 2 AND psr.idparte= a.id),0) AS totasignado
>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2
                        FROM alta_productos a, sat_catalogo_unidades b 
                        WHERE
                        a.idunidad=b.id 
                        AND a.id=".$idpro;   

                $datos = $this->General_Model->infoxQueryUnafila($query);
<<<<<<< HEAD





                $info_doc = array('idproducto' => $idpro, 'info' => $datos, 'sqlx' => $query);



                //$documento = array('tipo' => $tipo, 'folio' => $iddoc );



=======
                $info_doc = array('idproducto' => $idpro, 'info' => $datos, 'sqlx' => $query);

                //$documento = array('tipo' => $tipo, 'folio' => $iddoc );

>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2
                $dmenu["nommenu"] = "kardex"; 



                    $this->load->view('general/header');

                    $this->load->view('general/css_datatable');

                    $this->load->view('general/menuv2');

                    $this->load->view('general/menu_header',$dmenu);

                    $this->load->view('kardex/kardex_menu',$info_doc);

                    $this->load->view('general/footer');

                    $this->load->view('kardex/acciones_kardex_menu',$info_doc);



            }else{



                $this->load->view('login');



            } 



        }else{



            redirect("AccesoDenegado");



        }

      

    }





        ///////////****************TABLA PARTIDAS BITACORA



        public function loadPartidas()

        {
<<<<<<< HEAD



            $data_get = $this->input->get();

            $iduser = $this->session->userdata(IDUSERCOM);





            $table = "(SELECT b.fecha AS fechax, '0' AS tipox,'COTIZACION' AS documento,CONCAT_WS('/','0','cot',b.id) AS folio, a.cantidad, d.abr AS unidad
                        FROM partes_cotizacion a, alta_cotizacion b, alta_productos c, sat_catalogo_unidades d
                        WHERE a.idcotizacion=b.id
                        AND a.idparte=c.id
                        AND c.idunidad=d.id
                        AND a.idparte=  ".$data_get['idparte']."
                        UNION ALL
                        SELECT b.fecha AS fechax, '1' AS tipox,'COMPRAS' AS documento,CONCAT_WS('/','1','odc',b.id) AS folio, a.cantidad, d.abr AS unidad
                        FROM partes_asignar_oc a, alta_oc b, alta_productos c, sat_catalogo_unidades d
                        WHERE a.idoc = b.id
                        AND a.idparte=c.id
                        AND c.idunidad=d.id
                        AND a.idparte= ".$data_get['idparte']."
                        UNION ALL
                        SELECT b.fecha AS fechax, '2' AS tipox,'FACTURA' AS documento,CONCAT_WS('/','2',e.serie,e.folio) AS folio, a.cantidad, d.abr AS unidad
                        FROM partes_factura a, alta_factura b, alta_productos c, sat_catalogo_unidades d, folio_factura e
=======
            $data_get = $this->input->get();
            $iduser = $this->session->userdata(IDUSERCOM);

            $table = "(SELECT b.fecha AS fechax, '0' AS tipox,'COTIZACION' AS documento,CONCAT_WS('/','0','cot',b.id) AS folio, a.cantidad, d.abr AS unidad, au.nombre AS usuario
                        FROM partes_cotizacion a, alta_cotizacion b, alta_productos c, sat_catalogo_unidades d, alta_usuarios au
                        WHERE a.idcotizacion=b.id
                        AND a.idparte=c.id
                        AND c.idunidad=d.id
                        AND b.idusuario = au.id
                        AND a.idparte= ".$data_get['idparte']." 
                        UNION ALL
                        SELECT b.fecha AS fechax, '1' AS tipox,'COMPRAS' AS documento,CONCAT_WS('/','1','odc',b.id) AS folio, a.cantidad, d.abr AS unidad, au.nombre AS usuario
                        FROM partes_asignar_oc a, alta_oc b, alta_productos c, sat_catalogo_unidades d, alta_usuarios au
                        WHERE a.idoc = b.id
                        AND a.idparte=c.id
                        AND c.idunidad=d.id
                        AND b.idusuario = au.id
                        AND a.idparte= ".$data_get['idparte']."
                        UNION ALL
                        SELECT b.fecha AS fechax, '2' AS tipox,'FACTURA' AS documento,CONCAT_WS('/','2',e.serie,e.folio) AS folio, a.cantidad, d.abr AS unidad, au.nombre AS usuario
                        FROM partes_factura a, alta_factura b, alta_productos c, sat_catalogo_unidades d, folio_factura e, alta_usuarios au
>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2
                        WHERE a.idfactura = b.id
                        AND a.idparte=c.id
                        AND c.idunidad=d.id
                        AND b.idfolio=e.id
<<<<<<< HEAD
                        AND a.idparte= ".$data_get['idparte']."
                        UNION ALL
                        SELECT f.fecha AS fechax, '3' AS tipox,'REMISION' AS documento,CONCAT_WS('/',3,'rem',f.id) AS folio, a.cantidad, d.abr AS unidad
                        FROM partes_cotizacion a, alta_cotizacion b,alta_remision f,alta_productos c, sat_catalogo_unidades d
=======
                        AND b.idusuario = au.id
                        AND a.idparte= ".$data_get['idparte']."
                        UNION ALL
                        SELECT f.fecha AS fechax, '3' AS tipox,'REMISION' AS documento,CONCAT_WS('/',3,'rem',f.id) AS folio, a.cantidad, d.abr AS unidad, au.nombre AS usuario
                        FROM partes_cotizacion a, alta_cotizacion b,alta_remision f,alta_productos c, sat_catalogo_unidades d, alta_usuarios au
>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2
                        WHERE a.idcotizacion=b.id
                        AND f.idcotizacion =  b.id
                        AND a.idparte=c.id
                        AND c.idunidad=d.id
<<<<<<< HEAD
                        AND a.idparte= ".$data_get['idparte']."
                        UNION ALL
                        SELECT a.fecha AS fechax, '4' AS tipox,'ENTRADA' AS documento,CONCAT_WS('/','4','odc',a.idoc) AS folio, a.cantidad, d.abr AS unidad
                        FROM partes_entrada a, alta_entrada b, alta_productos c, sat_catalogo_unidades d, alta_oc ao
=======
                        AND b.idusuario = au.id
                        AND a.idparte= ".$data_get['idparte']."
                        UNION ALL
                        SELECT a.fecha AS fechax, '4' AS tipox,'ENTRADA' AS documento,CONCAT_WS('/','4','odc',a.idoc) AS folio, a.cantidad, d.abr AS unidad, au.nombre AS usuario
                        FROM partes_entrada a, alta_entrada b, alta_productos c, sat_catalogo_unidades d, alta_oc ao, alta_usuarios au
>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2
                        WHERE a.identrada = b.id
                        AND a.idoc = ao.id
                        AND a.idparte=c.id
                        AND c.idunidad=d.id
<<<<<<< HEAD
=======
                        AND b.idusuario = au.id
>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2
                        AND ao.estatus IN (1,4)
                        AND a.cantidad != 0
                        AND a.idparte= ".$data_get['idparte']."
                        UNION ALL
<<<<<<< HEAD
                        SELECT a.fecha AS fechax, '5' AS tipox,'ENTREGA' AS documento,CONCAT_WS('/','5',b.archivo) AS folio, a.cantidad, d.abr AS unidad
                        FROM partes_entrega a, alta_entrega b, partes_cotizacion f,alta_productos c, sat_catalogo_unidades d 
                        WHERE a.identrega = b.id
                        AND a.idpartefolio=f.id
                        AND f.idparte=c.id
                        AND c.idunidad=d.id
                        AND f.idparte= ".$data_get['idparte']."
                        UNION ALL
                        SELECT ae.fecha AS fechax, '6' AS tipox, 'AJUSTE_ENTRADA' AS documento,CONCAT_WS('/','6','APE',ae.id) AS folio, (SELECT SUM(ex.cantidad) FROM partes_ajuste_entrada ex, alta_ajuste_entrada ax WHERE ax.id = ex.idajuste AND ax.estatus = 0 AND idparte = pe.idparte AND ex.idajuste = ae.id) AS cantidad, u.abr AS unidad
                        FROM alta_ajuste_entrada ae, partes_ajuste_entrada pe, alta_productos ap, sat_catalogo_unidades u
                        WHERE ae.id = pe.idajuste
                        AND pe.idparte=ap.id
                        AND ap.idunidad=u.id
                        AND pe.idparte = ".$data_get['idparte']."
                        AND ae.estatus = 0
                        UNION ALL
                        SELECT ae.fecha AS fechax, '7' AS tipox, 'AJUSTE_SALIDA' AS documento,CONCAT_WS('/','7','APS',ae.id) AS folio, (SELECT SUM(ex.cantidad) FROM partes_ajuste_salida ex, alta_ajuste_salida ax WHERE ax.id = ex.idajuste AND ax.estatus = 0 AND idparte = pe.idparte AND ex.idajuste = ae.id) AS cantidad, u.abr AS unidad
                        FROM alta_ajuste_salida ae, partes_ajuste_salida pe, alta_productos ap, sat_catalogo_unidades u
                        WHERE ae.id = pe.idajuste
                        AND pe.idparte=ap.id
                        AND ap.idunidad=u.id
                        AND pe.idparte = ".$data_get['idparte']."
                        AND ae.estatus = 0
                        UNION ALL
                        SELECT a.fecha AS fechax, '5' AS tipox,'ENTREGA_FACTURA' AS documento,CONCAT_WS('/','5',b.archivo) AS folio, a.cantidad, d.abr AS unidad
                        FROM partes_entrega_factura a, alta_entrega b,alta_productos c, sat_catalogo_unidades d, partes_factura e 
=======
                        SELECT a.fecha AS fechax, '5' AS tipox,'ENTREGA' AS documento,CONCAT_WS('/','5',b.archivo) AS folio, a.cantidad, d.abr AS unidad, au.nombre AS usuario
                        FROM partes_entrega a, alta_entrega b, partes_cotizacion f,alta_productos c, sat_catalogo_unidades d, alta_usuarios au
                        WHERE a.identrega = b.id
                        AND a.idpartefolio=f.id
                        AND f.idparte=c.id
                        AND b.idusuario = au.id
                        AND c.idunidad=d.id
                        AND f.idparte= ".$data_get['idparte']."
                        UNION ALL
                        SELECT ae.fecha AS fechax, '6' AS tipox, 'AJUSTE_ENTRADA' AS documento,CONCAT_WS('/','6','APE',ae.id) AS folio, (SELECT SUM(ex.cantidad) FROM partes_ajuste_entrada ex, alta_ajuste_entrada ax WHERE ax.id = ex.idajuste AND ax.estatus = 0 AND idparte = pe.idparte AND ex.idajuste = ae.id) AS cantidad, u.abr AS unidad, au.nombre AS usuario
                        FROM alta_ajuste_entrada ae, partes_ajuste_entrada pe, alta_productos ap, sat_catalogo_unidades u, alta_usuarios au
                        WHERE ae.id = pe.idajuste
                        AND pe.idparte=ap.id
                        AND ap.idunidad=u.id
                        AND ae.idusuario = au.id
                        AND pe.idparte = ".$data_get['idparte']."
                        AND ae.estatus = 0
                        UNION ALL
                        SELECT ae.fecha AS fechax, '7' AS tipox, 'AJUSTE_SALIDA' AS documento,CONCAT_WS('/','7','APS',ae.id) AS folio, (SELECT SUM(ex.cantidad) FROM partes_ajuste_salida ex, alta_ajuste_salida ax WHERE ax.id = ex.idajuste AND ax.estatus = 0 AND idparte = pe.idparte AND ex.idajuste = ae.id) AS cantidad, u.abr AS unidad, au.nombre AS usuario
                        FROM alta_ajuste_salida ae, partes_ajuste_salida pe, alta_productos ap, sat_catalogo_unidades u, alta_usuarios au
                        WHERE ae.id = pe.idajuste
                        AND pe.idparte=ap.id
                        AND ap.idunidad=u.id
                        AND ae.idusuario = au.id
                        AND pe.idparte = ".$data_get['idparte']."
                        AND ae.estatus = 0
                        UNION ALL
                        SELECT a.fecha AS fechax, '5' AS tipox,'ENTREGA_FACTURA' AS documento,CONCAT_WS('/','5',b.archivo) AS folio, a.cantidad, d.abr AS unidad, au.nombre AS usuario
                        FROM partes_entrega_factura a, alta_entrega b,alta_productos c, sat_catalogo_unidades d, partes_factura e, alta_usuarios au 
>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2
                        WHERE a.identrega = b.id
                        AND e.id = a.idpartefactura
                        AND c.idunidad=d.id
                        AND c.id = e.idparte
<<<<<<< HEAD
                        AND a.cantidad>0
                        AND e.idparte= ".$data_get['idparte']."
                        ORDER BY fechax DESC)temp"; 

  

            // Primary key of table

            $primaryKey = 'fechax';

            

            $columns = array(



                array( 'db' => 'fechax',     'dt' => 0,



                        'formatter' => function( $d, $row ) {



                            return obtenerFechaEnLetra($d);



                        }  

                ),



                array( 'db' => 'tipox',     'dt' => 1,



                        'formatter' => function( $d, $row ) {





                            switch ($d) {



                                case 0:

                                    

                                    return '<p style="color:#FFC300; font-size:15px; font-weight:bold;"> COTIZACION</p>';



                                break;



                                case 1:

                                    

                                    return '<p style="color:#8D27B0; font-size:15px; font-weight:bold;"> COMPRAS</p>';



                                break;



                                case 2:

                                    

                                    return '<p style="color:black; font-size:15px; font-weight:bold;"> FACTURA</p>';



                                break;



                                case 3:

                                    

                                    return '<p style="color:black; font-size:15px; font-weight:bold;"> REMISION</p>';



                                break;



                                case 4:

                                    

                                    return '<p style="color:darkgreen; font-size:15px; font-weight:bold;"> ENTRADA</p>';



                                break;



                                case 5:

                                    

                                    return '<p style="color:red; font-size:15px; font-weight:bold;"> ENTREGA</p>';



                                break;

                                case 6:

                                    

                                    return '<p style="color:green; font-size:15px; font-weight:bold;"> AJUSTE_ENTRADA</p>';



                                break;

                                case 7:

                                    

                                    return '<p style="color:red; font-size:15px; font-weight:bold;"> AJUSTE_SALIDA</p>';



                                break;

                                

                                default:

                                    

                                break;

                            }



                         

                        }  

                ),



                array( 'db' => 'folio',     'dt' => 2,



                        'formatter' => function( $d, $row ) {



                            $separar = explode("/", $d);





                            switch ( $separar[0] ) {



                                case 0:

                                    

                                    ////// folio de cotizacion pedido



                                $idcot = $separar[2];

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





                                    return '<a href="'.base_url().'tw/php/cotizaciones/'.$separar[1].''.$separar[2].'.pdf" target="_blank">'.$folio.'</a>';



                                break;



                                case 1:

                                    

                                    return '<a href="'.base_url().'tw/php/ordencompra/odc'.$separar[2].'.pdf" target="_blank">ODC'.$separar[2].'</a>';



                                break;



                                case 2:

                                    

                                    return '<a href="'.base_url().'tw/php/facturas/'.$separar[1].''.$separar[2].'.pdf" target="_blank">'.$separar[1].''.$separar[2].'</a>';



                                break;



                                case 3:

                                    

                                    return '<a href="'.base_url().'tw/php/remisiones/rem'.$separar[2].'.pdf" target="_blank">REM'.$separar[2].'</a>';



                                break;



                                case 4:

                                    

                                    return '<a href="'.base_url().'tw/php/ordencompra/odc'.$separar[2].'.pdf" target="_blank">ODC'.$separar[2].'</a>';



                                break;



                                case 5:

                                    

                                    return '<a href="'.base_url().'tw/js/upload_entrega/files/'.$separar[1].'" target="_blank">Evidencia</a>';



                                break;

                                case 6:

=======
                        AND b.idusuario = au.id
                        AND a.cantidad>0
                        AND e.idparte= ".$data_get['idparte']."
                        UNION ALL
                        SELECT psr.fautomatica AS fechax, '8' AS tipox, 'ASIGNACION' AS documento, CONCAT_WS('/','0','cot',psr.idcot) AS folio, psr.asignado_almacen AS cantidad, scu.abr AS unidad, au.nombre AS usuario
                        FROM partes_solicitar_rq psr, alta_productos ap, sat_catalogo_unidades scu, alta_usuarios au
                        WHERE psr.idparte = ap.id
                        AND ap.idunidad = scu.id
                        AND psr.iduser=au.id
                        AND psr.asignado_almacen>0
                        AND psr.idparte = ".$data_get['idparte']."
                        AND psr.estatus != 2
                        ORDER BY fechax DESC)temp"; 

            // Primary key of table
            $primaryKey = 'fechax';   
            $columns = array(
                array( 'db' => 'fechax',     'dt' => 0,
                        'formatter' => function( $d, $row ) {
                            return obtenerFechaEnLetra($d);
                        }  
                ),
                array( 'db' => 'tipox',     'dt' => 1,
                        'formatter' => function( $d, $row ) {
                            switch ($d) {
                                case 0:                                
                                    return '<p style="color:#FFC300; font-size:15px; font-weight:bold;"> COTIZACION</p>';
                                break;
                                case 1:                                    
                                    return '<p style="color:#8D27B0; font-size:15px; font-weight:bold;"> COMPRAS</p>';
                                break;
                                case 2:                                
                                    return '<p style="color:black; font-size:15px; font-weight:bold;"> FACTURA</p>';
                                break;
                                case 3:                                    
                                    return '<p style="color:black; font-size:15px; font-weight:bold;"> REMISION</p>';
                                break;
                                case 4:                                    
                                    return '<p style="color:darkgreen; font-size:15px; font-weight:bold;"> ENTRADA</p>';
                                break;
                                case 5:                                    
                                    return '<p style="color:red; font-size:15px; font-weight:bold;"> ENTREGA</p>';
                                break;
                                case 6:                                    
                                    return '<p style="color:green; font-size:15px; font-weight:bold;"> AJUSTE_ENTRADA</p>';
                                break;
                                case 7:                                
                                    return '<p style="color:red; font-size:15px; font-weight:bold;"> AJUSTE_SALIDA</p>';
                                break;     
                                case 8:                                
                                    return '<p style="color:blue; font-size:15px; font-weight:bold;"> ASIGNACION_AUTO</p>';
                                break;                         
                                default:     
                                    return '<p style="color:red; font-size:15px; font-weight:bold;"> NO RECONOCIDO</p>';                               
                                break;
                            }                         
                        }  
                ),
                array( 'db' => 'folio',     'dt' => 2,
                        'formatter' => function( $d, $row ) {
                            $separar = explode("/", $d);
                            switch ( $separar[0] ) {
                                case 0:                                
                                    ////// folio de cotizacion pedido
                                $idcot = $separar[2];
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
                                    return '<a href="'.base_url().'tw/php/cotizaciones/'.$separar[1].''.$separar[2].'.pdf" target="_blank">'.$folio.'</a>';
                                break;
                                case 1:                                    
                                    return '<a href="'.base_url().'tw/php/ordencompra/odc'.$separar[2].'.pdf" target="_blank">ODC'.$separar[2].'</a>';
                                break;
                                case 2:                                
                                    return '<a href="'.base_url().'tw/php/facturas/'.$separar[1].''.$separar[2].'.pdf" target="_blank">'.$separar[1].''.$separar[2].'</a>';
                                break;
                                case 3:                                    
                                    return '<a href="'.base_url().'tw/php/remisiones/rem'.$separar[2].'.pdf" target="_blank">REM'.$separar[2].'</a>';
                                break;
                                case 4:                                
                                    return '<a href="'.base_url().'tw/php/ordencompra/odc'.$separar[2].'.pdf" target="_blank">ODC'.$separar[2].'</a>';
                                break;
                                case 5:                                
                                    return '<a href="'.base_url().'tw/js/upload_entrega/files/'.$separar[1].'" target="_blank">Evidencia</a>';
                                break;
                                case 6:
>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2
                                    $idcot = $separar[2];
                                    $folio = 0;
                                    $inicio = 10000;
                                    $nuevo = $inicio+$idcot;
                                    switch ( strlen($nuevo) ) {
                                        case 5:                                            
                                            $folio = "APE00".$nuevo;
                                        break;
                                        case 6:                                        
                                            $folio = "APE0".$nuevo;
                                        break;
                                        case 7:
                                            $folio = "APE".$nuevo;
                                        break;
                                        default:
                                            $folio = "s/asignar";
                                        break;

                                    }
<<<<<<< HEAD
                                    return '<a href="'.base_url().'tw/php/ajustes/'.$folio.'.pdf" target="_blank">Evidencia</a>';



                                break;

                                case 7:

=======
                                    return '<a href="'.base_url().'tw/php/ajustes/'.$folio.'.pdf" target="_blank">'.$folio.'</a>';
                                break;
                                case 7:
>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2
                                    $idcot = $separar[2];
                                    $folio = 0;
                                    $inicio = 10000;
                                    $nuevo = $inicio+$idcot;
                                    switch ( strlen($nuevo) ) {
                                        case 5:                                            
                                            $folio = "APS00".$nuevo;
                                        break;
                                        case 6:                                        
                                            $folio = "APS0".$nuevo;
                                        break;
                                        case 7:
                                            $folio = "APS".$nuevo;
                                        break;
                                        default:
                                            $folio = "s/asignar";
                                        break;
<<<<<<< HEAD

                                    }

                                    return '<a href="'.base_url().'tw/php/ajustes/'.$folio.'.pdf" target="_blank">Evidencia</a>';

                                break;

                                

                                default:



                                    return '<p>S/asignar</p>';

                                    

                                break;

                            }





                           /*if ( $separar[2] == 0 ) {

                            

                            /////////****** remision

                            return '<a href="'.base_url().'tw/php/remisiones/rem'.$separar[1].'.pdf" target="_blank">'.$separar[0].''.$separar[1].'</a>';



                           }elseif( $separar[2] == 1 ) {

                               

                            ///////******* facturacion

                            return '<a href="'.base_url().'tw/php/facturas/fact'.$separar[1].'.pdf" target="_blank">'.$separar[0].''.$separar[1].'</a>';



                           }*/





                        }  

                ),

                

                array( 'db' => 'cantidad',     'dt' => 3 ),

                array( 'db' => 'unidad',     'dt' => 4 ),



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



=======
                                    }
                                    return '<a href="'.base_url().'tw/php/ajustes/'.$folio.'.pdf" target="_blank">'.$folio.'</a>';
                                break;                                
                                default:
                                    return '<p>S/asignar</p>';                                
                                break;
                            }
                           /*if ( $separar[2] == 0 ) {                            
                            /////////****** remision
                            return '<a href="'.base_url().'tw/php/remisiones/rem'.$separar[1].'.pdf" target="_blank">'.$separar[0].''.$separar[1].'</a>';
                           }elseif( $separar[2] == 1 ) {                            
                            ///////******* facturacion
                            return '<a href="'.base_url().'tw/php/facturas/fact'.$separar[1].'.pdf" target="_blank">'.$separar[0].''.$separar[1].'</a>';
                           }*/
                        }  
                ),            
                array( 'db' => 'cantidad',     'dt' => 3 ),
                array( 'db' => 'unidad',     'dt' => 4 ),
                array( 'db' => 'usuario',     'dt' => 5 ),
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
>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2
}