<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PromoSoldador extends CI_Controller {



	 public function __construct()
    {

        parent::__construct();
        
        function Sustituto_Cadena($rb){ 

	        ## Sustituyo caracteres en la cadena final	
	        $rb = str_replace("Ã¡", "&aacute;", $rb);
	        $rb = str_replace("Ã©", "&eacute;", $rb);
	        $rb = str_replace("Â®", "&reg;", $rb);
	        $rb = str_replace("Ã­", "&iacute;", $rb);
	        $rb = str_replace("ï¿½", "&iacute;", $rb);
	        $rb = str_replace("Ã³", "&oacute;", $rb);
	        $rb = str_replace("Ãº", "&uacute;", $rb);
	        $rb = str_replace("n~", "&ntilde;", $rb);
	        $rb = str_replace("Âº", "&ordm;", $rb);
	        $rb = str_replace("Âª", "&ordf;", $rb);
	        $rb = str_replace("ÃƒÂ¡", "&aacute;", $rb);
	        $rb = str_replace("Ã±", "&ntilde;", $rb);
	        $rb = str_replace("Ã‘", "&Ntilde;", $rb);
	        $rb = str_replace("ÃƒÂ±", "&ntilde;", $rb);
	        $rb = str_replace("n~", "&ntilde;", $rb);
	        $rb = str_replace("Ãš", "&Uacute;", $rb);
	        $rb = str_replace("Ã", "", $rb);
	        $rb = str_replace("", "", $rb);
	        $rb = str_replace("¡", "a", $rb);
	        
	        return $rb;
    	}

    	function textOracion($x, $valor){

			if($valor == 0){

				$valortxt = ucwords(strtolower($x));

			}else{

				$valortxt = strtoupper($x);

			}
		

			return $valortxt;

		} 

		function wims_currency($number) { 
		   if ($number < 0) { 
		    $print_number = "-$ " . str_replace('-', '', number_format ($number, 2, ".", ",")) . ""; 
		    } else { 
		     $print_number = "$ " .  number_format ($number, 2, ".", ",") ; 
		   } 
		   return $print_number; 
		} 

    	$this->load->model('Model_lista');
		$this->load->model('Model_general');
    	
      
    }


    public function index()
	{

		//$ip = getRealIP();

		/////////********** BUSCAR LOS ARTICULOS DEL CARRITO POR USUARIO O POR CLIENTE 

		$iduserchimalweb = $this->session->userdata('idwebchimal2');


        $sql1 = "SELECT a.clave,CONVERT(CAST(CONVERT(a.titulo USING latin1) AS BINARY) USING utf8) AS titulo,a.marca,a.id,x.anterior AS precio, x.ahora AS promo
                FROM precios_promo_soldadura x,`datos_productos_chimal_admin` a
                WHERE
                x.idparte=a.id
                AND x.estatus = 0";


		$data = array(	'destacado' => $this->Model_general->infoxQuery($sql1) 	);

		$this->load->view('general/header');
		$this->load->view('general/menu');
		$this->load->view('promociones/promocion_soldadura',$data);
		$this->load->view('general/footer');
		$this->load->view('general/js_archivos');
		$this->load->view('general/fin');

	}

}