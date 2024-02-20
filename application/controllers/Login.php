<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {


	public function index()
	{
		$iduser=$this->session->userdata(IDUSERCOM);

		if ($iduser>0) {
			
			$dmenu["nommenu"] = "dashboard";

            $this->load->view('general/header');
            $this->load->view('general/menuv2');
            $this->load->view('general/menu_header',$dmenu);
            $this->load->view('dash/body_dash');
            $this->load->view('general/footer');
            $this->load->view('dash/acciones_dash');

		}else{

			$this->load->view('login');	

		}
		
	}


	public function verificarUser(){

        $data = $this->input->post();///RESIVIMOS LA DATA DE AJAX POR POST
        $tabla = "alta_usuarios";
        $datos = array(
                            'usuario'=>$data['usuario'],
                            'pass'=>$data['pass'],
                            'estatus'=>0
                        );

        $verificador=$this->General_Model->verificarLogin($datos);

        //echo json_encode($verificador);

       if(trim($verificador) == 0){

           echo json_encode(0);


       }else{

            $sepveri = explode("/", $verificador);

            $idusuario = $sepveri[0];
            $nombre = $sepveri[1];
            $puesto = $sepveri[2];
            $correo = $sepveri[3];
           
  
            $this->session->set_userdata(IDUSERCOM,$idusuario);  
            $this->session->set_userdata(PUESTOCOM,$puesto);
            $this->session->set_userdata(NOMBRECOM,$nombre);
            $this->session->set_userdata(CORREOCOM,$correo);

                    /////////###################### INICIO DE SESION

                        $alta_bi = array(

                            'fecha' => date("Y-m-d"),
                            'hora' => date("H:i:s"),
                            'idusuario' => $this->session->userdata(IDUSERCOM),
                            'menu' => 'SESION',
                            'accion' => 'Inicio de sesion'

                        );

                        $table_bi = "alta_bitacora";

                        $this->General_Model->altaERP($alta_bi,$table_bi);

                    ///////#####################
            

            echo  json_encode($sepveri[2]);
       }


    }


    public function verificarUser2(){

        $data_post = $this->input->post();

        $query="SELECT id,nombre,iddepartamento,correo,telefono FROM `alta_usuarios` WHERE estatus = 0 AND usuario='".$data_post['usuario']."' AND pass='".$data_post['pass']."' ";
        $mquery2 = $this->db->query($query);
        $cant = $mquery2->num_rows();

        if( $cant > 0  ){

          $datos=$mquery2->row();

            $this->session->set_userdata(IDUSERCOM,$datos->id);  
            $this->session->set_userdata(PUESTOCOM,$datos->iddepartamento);
            $this->session->set_userdata(NOMBRECOM,$datos->nombre);
            $this->session->set_userdata(CORREOCOM,$datos->correo);

                    /////////###################### INICIO DE SESION

                        $alta_bi = array(

                            'fecha' => date("Y-m-d"),
                            'hora' => date("H:i:s"),
                            'idusuario' => $datos->id,
                            'menu' => 'SESION',
                            'accion' => 'Inicio de sesion'

                        );

                        $table_bi = "alta_bitacora";

                        $this->General_Model->altaERP($alta_bi,$table_bi);

                    ///////#####################
            

            echo json_encode($datos->id);

        }else{

          echo json_encode(null);

        }

    }


    public function CerrarSesion(){
       
        $this->session->unset_userdata(IDUSERCOM,0);
        $this->session->unset_userdata(PUESTOCOM,"");
        $this->session->unset_userdata(NOMBRECOM,"");
        $this->session->unset_userdata(CORREOCOM,"");

        $this->load->view('login');

    }

}
