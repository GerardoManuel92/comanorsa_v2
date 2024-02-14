<?php
defined('BASEPATH') OR exit('No direct script access allowed');




class Sitemap extends CI_Controller {

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


	public function index()
	{
		$this->load->view('general/head');
        $this->load->view('general/topbar');
        $this->load->view('general/sidebar');        
        $this->load->view('sitemap/body_sitemap');
        $this->load->view('general/footer');
        $this->load->view('general/settings');
        $this->load->view('js/js');
	}
}