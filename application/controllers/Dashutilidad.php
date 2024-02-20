<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH.'third_party/ssp.php';



class Dashutilidad extends CI_Controller

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



            $dmenu["nommenu"] = "dashutilidad";



            $this->load->view('general/header');

            $this->load->view('general/css_datatable');

            $this->load->view('general/css_grafica');

            $this->load->view('general/menuv2');

            $this->load->view('general/menu_header',$dmenu);

            if($idpuesto==1) {
                
                $this->load->view('dash/body_dash_utilidad');

            }else{

                $this->load->view('dash/body_dash_otros');

            }

            

            $this->load->view('general/footer');

            $this->load->view('dash/acciones_dash_utilidad');



        }else{



            //$this->load->view('login');



            redirect('Login');



        } 

       

    }

    public function showProductosUtilidad(){


        //$info_vencidas=array();

        $data = array();
        $pregunta = array();

        $sqlProductos='SELECT 
                            productos.nparte AS clave,
                            productos.descripcion AS producto,
                            SUM((pcotizacion.costo-pcotizacion.costo_proveedor)*pfactura.cantidad)+IFNULL((SELECT SUM((x.costo-x.costo_proveedor)*x.cantidad) FROM partes_factura_sustitucion x INNER JOIN alta_factura_sustitucion y ON y.id = x.idfactura WHERE x.idparte=pfactura.idparte AND y.estatus IN (1,3)),0) AS utilidad,
                            productos.id AS id
                        FROM partes_factura pfactura
                        INNER JOIN partes_cotizacion pcotizacion ON pcotizacion.id = pfactura.idpartecot
                        INNER JOIN alta_productos productos ON productos.id = pfactura.idparte
                        INNER JOIN alta_factura factura ON factura.id = pfactura.idfactura 
                        WHERE factura.estatus IN (1,3)
                        GROUP BY pfactura.idparte
                        ORDER BY utilidad DESC
                        LIMIT 20;';

        $datos_productos=$this->General_Model->infoxQuery($sqlProductos);

        if ($datos_productos!=null) {
            
            foreach ($datos_productos as $row) {
                
                //////*********** DATOS DEL CLIENTE 
                $cantidadFormateada = number_format($row->utilidad, 2, '.', ',');
                $cantidadFormateada = '$' . $cantidadFormateada;
                $pregunta[] =array(
                            'CLAVE'=>$row->clave,
                            'PRODUCTO'=>$row->producto,
                            'UTILIDAD'=>$cantidadFormateada,
                            'VER'=>'<a class="btn btn-primary" role="button" onclick="verProducto('.$row->id.')"><i class="fa fa-eye"></i></a>',
                            );


                        //array_push($info_vencidas, $datos_adjuntar);

            }

        }

            $data = array("data"=>$pregunta);
            header('Content-type: application/json');
            echo json_encode($data);    

    }

    public function showClientesUtilidad(){


        //$info_vencidas=array();

        $data = array();
        $pregunta = array();

        $sqlProductos='SELECT 
                            cliente.comercial AS comercial,
                            cliente.nombre AS cliente,
                            SUM((pcotizacion.costo-pcotizacion.costo_proveedor)*pfactura.cantidad)+IFNULL( ( SELECT SUM((x.costo-x.costo_proveedor)*x.cantidad) FROM partes_factura_sustitucion x INNER JOIN alta_factura_sustitucion y ON y.id = x.idfactura WHERE y.idcliente=cliente.id AND y.estatus IN (1,3) GROUP BY y.idcliente LIMIT 0,1),0 ) AS utilidad,
                            cliente.id AS id
                        FROM partes_factura pfactura
                        INNER JOIN partes_cotizacion pcotizacion ON pcotizacion.id = pfactura.idpartecot
                        INNER JOIN alta_productos productos ON productos.id = pfactura.idparte
                        INNER JOIN alta_factura factura ON factura.id = pfactura.idfactura
                        INNER JOIN alta_clientes cliente ON cliente.id = factura.idcliente
                        WHERE factura.estatus IN (1,3)
                        GROUP BY factura.idcliente
                        ORDER BY utilidad DESC
                        LIMIT 20;  ';

        $datos_productos=$this->General_Model->infoxQuery($sqlProductos);

        if ($datos_productos!=null) {
            
            foreach ($datos_productos as $row) {
                
                $cantidadFormateada = number_format($row->utilidad, 2, '.', ',');
                $cantidadFormateada = '$' . $cantidadFormateada;
                $pregunta[] =array(
                            'COMERCIAL'=>$row->comercial,
                            'CLIENTE'=>$row->cliente,
                            'UTILIDAD'=>$cantidadFormateada,
                            'VER'=>'<a class="btn btn-primary" role="button" onclick="verCliente('.$row->id.')"><i class="fa fa-eye"></i></a>',
                            );


                        //array_push($info_vencidas, $datos_adjuntar);

            }

        }

            $data = array("data"=>$pregunta);
            header('Content-type: application/json');
            echo json_encode($data);    

    }

    public function showProductosInRange(){

        $data_post = $this->input->get();
        //$info_vencidas=array();

        $data = array();
        $pregunta = array();

        $sqlProductos='SELECT 
                            productos.nparte AS clave,
                            productos.descripcion AS producto,
                            SUM((pcotizacion.costo-pcotizacion.costo_proveedor)*pfactura.cantidad)+IFNULL((SELECT SUM((x.costo-x.costo_proveedor)*x.cantidad) FROM partes_factura_sustitucion x INNER JOIN alta_factura_sustitucion y ON y.id = x.idfactura WHERE x.idparte=pfactura.idparte AND y.estatus IN (1,3) AND y.fecha BETWEEN "'.$data_post["dateStart"].'" AND "'.$data_post["dateEnd"].'"),0) AS utilidad,
                            productos.id AS id
                        FROM partes_factura pfactura
                        INNER JOIN partes_cotizacion pcotizacion ON pcotizacion.id = pfactura.idpartecot
                        INNER JOIN alta_productos productos ON productos.id = pfactura.idparte
                        INNER JOIN alta_factura factura ON factura.id = pfactura.idfactura 
                        WHERE factura.estatus IN (1,3)
                        AND factura.fecha BETWEEN "'.$data_post["dateStart"].'" AND "'.$data_post["dateEnd"].'"
                        GROUP BY pfactura.idparte
                        ORDER BY utilidad DESC
                        LIMIT 20;';

        $datos_productos=$this->General_Model->infoxQuery($sqlProductos);

        if ($datos_productos!=null) {
            
            foreach ($datos_productos as $row) {
                
                //////*********** DATOS DEL CLIENTE 
                $cantidadFormateada = number_format($row->utilidad, 2, '.', ',');
                $cantidadFormateada = '$' . $cantidadFormateada;
                $pregunta[] =array(
                            'CLAVE'=>$row->clave,
                            'PRODUCTO'=>$row->producto,
                            'UTILIDAD'=>$cantidadFormateada,
                            'VER'=>'<a class="btn btn-primary" role="button" onclick="verProducto('.$row->id.')"><i class="fa fa-eye"></i></a>',
                            );


                        //array_push($info_vencidas, $datos_adjuntar);

            }

        }

            $data = array("data"=>$pregunta);
            header('Content-type: application/json');
            echo json_encode($data);    

    }

    public function showClientesInRange(){

        $data_post = $this->input->get();

        //$info_vencidas=array();

        $data = array();
        $pregunta = array();

        $sqlProductos='SELECT 
                        cliente.comercial AS comercial,
                        cliente.nombre AS cliente,
                        SUM((pcotizacion.costo-pcotizacion.costo_proveedor)*pfactura.cantidad)+IFNULL( ( SELECT SUM((x.costo-x.costo_proveedor)*x.cantidad) FROM partes_factura_sustitucion x INNER JOIN alta_factura_sustitucion y ON y.id = x.idfactura WHERE y.idcliente=cliente.id AND y.estatus IN (1,3) AND y.fecha BETWEEN "'.$data_post["dateStart"].'" AND "'.$data_post["dateEnd"].'" GROUP BY y.idcliente LIMIT 0,1),0 ) AS utilidad,
                        cliente.id AS id
                    FROM partes_factura pfactura
                    INNER JOIN partes_cotizacion pcotizacion ON pcotizacion.id = pfactura.idpartecot
                    INNER JOIN alta_productos productos ON productos.id = pfactura.idparte
                    INNER JOIN alta_factura factura ON factura.id = pfactura.idfactura
                    INNER JOIN alta_clientes cliente ON cliente.id = factura.idcliente
                    WHERE factura.estatus IN (1,3)
                    AND factura.fecha BETWEEN "'.$data_post["dateStart"].'" AND "'.$data_post["dateEnd"].'"
                    GROUP BY factura.idcliente
                    ORDER BY utilidad DESC
                    LIMIT 20;';

        $datos_productos=$this->General_Model->infoxQuery($sqlProductos);

        if ($datos_productos!=null) {
            
            foreach ($datos_productos as $row) {
                
                //////*********** DATOS DEL CLIENTE 
                $cantidadFormateada = number_format($row->utilidad, 2, '.', ',');
                $cantidadFormateada = '$' . $cantidadFormateada;
                $pregunta[] =array(
                            'COMERCIAL'=>$row->comercial,
                            'CLIENTE'=>$row->cliente,
                            'UTILIDAD'=>$cantidadFormateada,
                            'VER'=>'<a class="btn btn-primary" role="button" onclick="verCliente('.$row->id.')"><i class="fa fa-eye"></i></a>',
                            );


                        //array_push($info_vencidas, $datos_adjuntar);

            }

        }

            $data = array("data"=>$pregunta);
            header('Content-type: application/json');
            echo json_encode($data);    

    }


    public function verProducto(){

        $this->load->model('Model_Buscador');
        $data_post=$this->input->post();

        $sql='SELECT
                    cliente.nombre,
                    SUM(pfactura.cantidad) cantidadProductos,
                    SUM(pcotizacion.utilidad) AS total
                FROM
                    partes_factura pfactura
                    INNER JOIN alta_productos ap ON pfactura.idparte = ap.id
                    INNER JOIN alta_factura factura ON pfactura.idfactura = factura.id
                    INNER JOIN alta_clientes cliente ON cliente.id = factura.idcliente
                    INNER JOIN partes_cotizacion pcotizacion ON pcotizacion.id = pfactura.idpartecot
                WHERE
                    pfactura.idparte = '.$data_post["idproducto"].'
                AND
                    factura.estatus IN (1,3)
                GROUP BY
                    factura.idcliente
                ORDER BY total DESC;';

                
            echo json_encode( $this->General_Model->infoxQuery($sql) );

    }



}