<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class AltaCliente extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
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
 
		 
 
	 }


     public function altaCliente()

     {
 
         /* $iduser = $this->session->userdata(IDUSERCOM); */
         $iduser = 1;
 
 
 
 
 
         /* $numero_menu = 6; */
 
 
 
         ////////******* verificar menu 
 
 
 
         $vtabla = "menus_departamento";
 
         /* $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu); */
         $vcondicion = array( 'iddepa' => 1);
 
         $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);
 
 
 
         if ( $verificar_menu > 0 ) {
 
 
 
             $idcliente = $this->uri->segment(3);
 
            
 
             if($iduser > 0){
 
 
 
                 if ( $idcliente == 0 ) {
 
                     #NUEVA PARTIDA
 
 
 
                     /* $titulo = "<i class='fa fa-star'></i> Nuevo Cliente";
  */
 
 
                 }else{
 
 
 
                     //// sql de partes
 
 
 
                   /*   $titulo = "<i class='fa fa-edit' style='color:yellow;'></i> Actualizar Cliente"; */
 
                     $info_proyecto_op = $this->General_Model->SelectUnafila($datos,$tabla,$condicion);
 
 
 
                 }
 
 
 
                 /* $data["titulox"]= $titulo;
 
                 $dmenu["nommenu"] = "clientes"; */
 
 
 
                 $this->load->view('general/head');
                 $this->load->view('general/topbar');
                 $this->load->view('general/sidebar');
                 $this->load->view('general/css_autocompletar');
                 $this->load->view('general/css_xedit');
                 $this->load->view('general/css_date');        
                 $this->load->view('general/css_select2');       
                 $this->load->view('clientes/alta_cliente');
                 $this->load->view('general/footer');
                 $this->load->view('general/settings');
                 $this->load->view('js/clientes/acciones_clientes');
 
 
 
             }else{
 
 
 
                 redirect("Login");
 
 
 
             }
 
 
 
         }else{
 
 
 
             redirect('AccesoDenegado');
 
 
 
         } 
 
 
 
 
 
        
 
     }

    public function showFpago(){



        $query="SELECT id,clave,descripcion FROM sat_catalogo_fpago WHERE estatus = 0 ORDER BY descripcion ASC";



            echo json_encode( $this->General_Model->infoxQuery($query) );



    }



    public function showCfdi(){



        $query="SELECT id,clave,descripcion FROM sat_catalogo_cfdi WHERE estatus = 0 ORDER BY descripcion ASC";



            echo json_encode( $this->General_Model->infoxQuery($query) );



    }





    public function showRegimen(){



        $query="SELECT id,clave,regimen FROM sat_catalogo_regimen_fiscal WHERE estatus = 0 ORDER BY clave ASC";



            echo json_encode( $this->General_Model->infoxQuery($query) );



    }


    /*public function showBancos(){

        $query="SELECT id,rfc,comercial FROM alta_bancos WHERE estatus=0 ORDER BY comercial ASC";

        echo json_encode( $this->General_Model->infoxQuery($query) );

    }*/

    



    public function vRfc(){



        $data_post = $this->input->post();



        $condicion = array('rfc' => $data_post["rfc"], 'estatus' => 0);

        $tabla = "alta_clientes";



        echo json_encode(  $this->General_Model->verificarRepeat($tabla,$condicion) );





    }



    public function altaCli(){



        $data_post = $this->input->post();



        $data = array(


            'fecha' => date('Y-m-d'),

            'nombre' => $data_post['nombre'],

            'comercial' => $data_post['comercial'],

            'rfc' => $data_post['rfc'],

            

            'calle'=> $data_post['calle'],

            'exterior'=> $data_post['exterior'],

            'interior'=> $data_post['interior'],

            'colonia' => $data_post['colonia'],

            'municipio' => $data_post['municipio'],

            'estado' => $data_post['estado'],

            'cp' => $data_post['cp'],

            'referencia'=> $data_post['referencia'],


            'idfpago'=> $data_post['idfpago'],

            'idcfdi'=> $data_post['idcfdi'],

            'descuento' => $data_post['descuento'],

            'credito' => $data_post['credito'],

            'limite' => $data_post['limite'],

            'idregimen' => $data_post['regimenx']



        );



        $table = "alta_clientes";



        $last_id = $this->General_Model->altaERP($data,$table);



        if ( $last_id > 0 ) {



            if( $data_post['contactox'] != "" OR $data_post['contactox'] != null ) {
                

                $array_sep =explode(",",$data_post['contactox']);

                $table2 = "contactos_erp";

                for ($i=0; $i <count($array_sep); $i++) { 

                    //// 2da separacion 

                    $separar = explode("||", $array_sep[$i]);

                    $data2 = array(


                        'fecha' => date("Y-m-d"),

                        'iddepartamento' => '2',

                        'iduser' => $last_id,

                        'nombre' => $separar[0],

                        'puesto' => $separar[1],

                        'telefono' => $separar[2],

                        'correo' => $separar[3]



                    );


                    $this->General_Model->altaERP($data2,$table2);

                }



            }



            //////*********** añadir direcciones / Se modifico por que ya solo se usara una direccion



            //$array_sep3 =explode(",",$data_post['direccionesx']);

            $table3 = "direccion_clientes";

            $data3=array(

                'fecha' => date("Y-m-d"),

                'idcliente' => $last_id,

                'calle'=> $data_post['calle'],

                'exterior'=> $data_post['exterior'],

                'interior'=> $data_post['interior'],

                'colonia' => $data_post['colonia'],

                'municipio' => $data_post['municipio'],

                'estado' => $data_post['estado'],

                'cp' => $data_post['cp'],

                'referencia'=> $data_post['referencia']

            );

            $this->General_Model->altaERP($data3,$table3);




            /*for ($i=0; $i <count($array_sep3); $i++) { 



                //// 2da separacion 



                $separar3 = explode("||", $array_sep3[$i]);

                

                $data3 = array(



                    'fecha' => date("Y-m-d"),

                    'idcliente' => $last_id,

                    'calle' => $separar3[0],

                    'exterior' => $separar3[1],

                    'interior' => $separar3[2],

                    'colonia' => $separar3[3],

                    'municipio' => $separar3[4],

                    'estado' => $separar3[5],

                    'cp' => $separar3[6],

                    'referencia' => $separar3[7],

                    'descuento' => $separar3[8],

                    'credito' => $separar3[9],

                    'limite' => $separar3[10],

                    'fecha_actualizacion' => date("Y-m-d")



                );



                $this->General_Model->altaERP($data3,$table3);



            }*/



        }


        echo json_encode( $last_id );



    }





    public function Actdireccion(){



        ////*********** FUNION USADA PARA CREAR LOS PRIMEROS REGISTROS DE MULTIDIRECCIONES PARA UN CLIENTE

        $query="SELECT id,calle,exterior,interior,colonia,municipio,estado,cp,referencia,descuento,credito,limite FROM `alta_clientes`";



        $info=$this->General_Model->infoxQuery($query);



        if ($info != null) {

           

            foreach ($info as $rowx) {

                

                /*INSERT INTO `direccion_clientes` (`id`, `fecha`, `idcliente`, `calle`, `exterior`, `interior`, `colonia`, `municipio`, `estado`, `cp`, `referencia`, `descuento`, `credito`, `limite`, `fecha_actualizacion`, `estatus`) VALUES (NULL, '2022-04-14', '1', 'monterrey', '47', 's/n', 'jardines de gpe', 'neza', 'mexico', '57140', 'abajo', '5', '30', '10000', '2022-04-14', '0');*/



                $data = array('fecha' => date("Y-m-d"),'idcliente'=>$rowx->id,'calle'=>$rowx->calle,'exterior'=>$rowx->exterior,'interior'=>$rowx->interior,'colonia'=>$rowx->colonia,'municipio'=>$rowx->municipio,'estado'=>$rowx->estado,'colonia'=>$rowx->cp,'referencia'=>$rowx->referencia,'descuento'=>$rowx->descuento,'credito'=>$rowx->credito,'limite'=>$rowx->limite,'fecha_actualizacion'=>$rowx->referencia);

                $table = "direccion_clientes";



                $this->General_Model->altaERP($data,$table);



            }



            echo json_encode("Se insertron correctmente");



        }else{



            echo json_encode("Error, favor de intentarlo nuevamente");



        }





    }
}