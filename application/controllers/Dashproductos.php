<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH.'third_party/ssp.php';



class Dashproductos extends CI_Controller

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



            $dmenu["nommenu"] = "dashproductos";



            $this->load->view('general/header');

            $this->load->view('general/css_datatable');

            $this->load->view('general/css_grafica');

            $this->load->view('general/menuv2');

            $this->load->view('general/menu_header',$dmenu);

            if($idpuesto==1) {
                
                $this->load->view('dash/body_dash_productos');

            }else{

                $this->load->view('dash/body_dash_otros');

            }

            

            $this->load->view('general/footer');

            $this->load->view('dash/acciones_dash_productos');



        }else{



            //$this->load->view('login');



            redirect('Login');



        } 

       

    }



    public function showProductosVendidos(){


        //$info_vencidas=array();

        $data = array();
        $pregunta = array();

        $sqlProductos='SELECT b.nparte AS nparte, b.descripcion as descripcion,
                        (SUM(a.cantidad)+IFNULL( ( SELECT SUM(x.cantidad) FROM partes_factura_sustitucion x WHERE x.idparte=a.idparte GROUP BY x.idparte LIMIT 0,1),0 ) ) AS total, b.id AS id
                        FROM partes_factura a, alta_productos b, alta_factura c
                        WHERE a.idparte=b.id
                        AND c.id = a.idfactura
                        AND c.estatus IN (1,3)
                        GROUP BY a.idparte
                        ORDER BY total DESC
                        LIMIT 100;';

        $datos_productos=$this->General_Model->infoxQuery($sqlProductos);

        if ($datos_productos!=null) {
            
            $noRow = 1;
            
            foreach ($datos_productos as $row) {
                
                //////*********** DATOS DEL CLIENTE 

                $pregunta[] =array(

                            'NO'=>$noRow,
                            'CLAVE'=>$row->nparte,
                            'DESCRIPCION'=>$row->descripcion,
                            'TOTAL'=>$row->total,
                            'CLIENTES'=>'<a class="btn btn-primary" role="button" onclick="verCliente('.$row->id.')"><i class="fa fa-eye"></i></a>',
                            );


                        //array_push($info_vencidas, $datos_adjuntar);
                        $noRow +=1;

            }


        }

            $data = array("data"=>$pregunta);
            header('Content-type: application/json');
            echo json_encode($data);    

    }

    public function showGrafica(){
        
        $iduser = $this->session->userdata(IDUSERCOM);

        $this->load->model('General_Model');

        ///////////// Cargamos todas las evaluaciones que ya hayan sido contestadas

        $info ="";

        $sql="
            SELECT categoria.id, categoria.descripcion, 
            (SUM(pfactura.cantidad) + IFNULL(( SELECT SUM(x.cantidad) FROM partes_factura_sustitucion x, alta_categoria y, alta_productos z, alta_factura_sustitucion v WHERE x.idparte=z.id AND z.idcategoria = y.id AND v.id = x.idfactura AND v.estatus IN(1,3) AND y.id=categoria.id GROUP BY y.id LIMIT 0,1),0 )) as total
            FROM alta_productos productos, alta_categoria categoria, partes_factura pfactura, alta_factura factura
            WHERE productos.id = pfactura.idparte
            AND categoria.id = productos.idcategoria
            AND factura.id = pfactura.idfactura
            AND factura.estatus IN (1,3)
            GROUP BY categoria.id
            ORDER BY total DESC
            LIMIT 8;
        ";

        $consulta=$this->General_Model->infoxQuery($sql); 

        if ( $consulta != null ) {


            
            $array = array();

            foreach ($consulta as $row) {

                if($row->descripcion=="ART&Iacute;CULOS DE OFICINA"){
                    $array[] = array(
                        'descripcion' => 'OFICINA',
                        'total' => $row->total
                    );
                }else{
                    $array[] = array(
                        'descripcion' => $row->descripcion,
                        'total' => $row->total
                    );
                }

                
            }
            


            echo json_encode($array);

        }else{


            echo json_encode(null); 

        }



    }

    public function verCliente(){

        $this->load->model('Model_Buscador');
        $data_post=$this->input->post();

        $sql='SELECT
                    cliente.nombre,
                    SUM(pfactura.cantidad) cantidadProductos,
                    (pcotizacion.costo * SUM(pfactura.cantidad)) AS total
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