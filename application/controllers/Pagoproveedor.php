<?php
defined('BASEPATH') or exit('No direct script access allowed');
include APPPATH . 'third_party/ssp.php';

class Pagoproveedor extends CI_Controller
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

    public function index()
    {

        $numero_menu = 19;

        ////////******* verificar menu 

        $vtabla = "menus_departamento";
        $vcondicion = array( 'iddepa' => $this->session->userdata(PUESTOCOM), 'idsubmenu' => $numero_menu);
        $verificar_menu = $this->General_Model->verificarRepeat($vtabla,$vcondicion);

        if ( $verificar_menu > 0 ) {

             $iduser = $this->session->userdata(IDUSERCOM);

            if($iduser > 0){
            
                $info_menu = array('nommenu' => "pagoproveedor");
                $data["idusuario"] = $iduser;

                $this->load->view('general/header');
                $this->load->view('general/css_select2');
                $this->load->view('general/css_upload');
                $this->load->view('general/css_date');
                $this->load->view('general/css_datatable');
                $this->load->view('general/css_key_table');
                $this->load->view('general/menuv2');
                $this->load->view('general/menu_header',$info_menu);
                $this->load->view('pagos/body_pagoproveedor');
                $this->load->view('general/footer');
                $this->load->view('pagos/acciones_pagoproveedor',$data);

            }else{

                redirect("Login");

            } 

        }
        
       
    }

    public function showProveedor(){

        $query="SELECT id,nombre,comercial FROM `alta_proveedores` WHERE estatus = 0 ORDER BY nombre ASC";

            echo json_encode( $this->General_Model->infoxQuery($query) );

    }

    public function showODC(){

        $query="SELECT id,  CONCAT('ODC001', LPAD(id, 4, '0')) AS nom FROM alta_oc";

            echo json_encode( $this->General_Model->infoxQuery($query) );

    }

    public function cargarPagosTemporal(){

        $data_post = $this->input->post();

        $query="SELECT * FROM temporal_pagos_proveedor WHERE idsaldo=".$data_post["idSaldo"];

        echo json_encode( $this->General_Model->infoxQuery($query) );

    }

    public function cargaraTemporal(){

        $data_post = $this->input->post();
        
        $idSaldo = $data_post['idSaldo'];
        
        if(isset($_POST['datos'])){

            $tableData = $data_post['datos'];

            $table1="temporal_pagos_proveedor";

            $condic = array(
                'idsaldo' => $idSaldo
            );

            $this->General_Model->deleteERP($table1,$condic);

            foreach ($tableData as $fila) {

                $ODC = $fila['ODC'];
                $importe = $fila['IMPORTE'];

                $sql = "INSERT INTO temporal_pagos_proveedor (idodc, idsaldo, total) VALUES (".$fila['ODC'].", ".$idSaldo.", ". $fila['IMPORTE'].")";
                $query = $this->db->query($sql);
                /*
                $data1 = array(
    
                    'idodc' => $fila['ODC'],
                    'idsaldo' => $idSaldo,
                    'total' => $fila['IMPORTE']
    
                 );
    
                $this->General_Model->altaERP($data1,$table1);*/
            }
        }else{
            $table1="temporal_pagos_proveedor";

            $condic = array(
                'idsaldo' => $idSaldo
            );

            $this->General_Model->deleteERP($table1,$condic);
        }

    }

    public function showCuentas(){

        $query="SELECT a.cuenta,b.comercial,a.id
                FROM alta_cuentas_comanorsa a, alta_bancos b
                WHERE a.idbanco=b.id AND a.estatus=0";

            echo json_encode( $this->General_Model->infoxQuery($query) );

    }

    public function actualizarMov(){

        $data_post = $this->input->post();

        $idcuenta=0;        

            ///verificar si la cuenta pertenece algun cliente

            $condicion=array('cuenta'=>$data_post["cuentax"]);
            $tabla2="alta_saldo_proveedor";

            $repeat=$this->General_Model->verificarRepeat($tabla2,$condicion);

            if ($repeat>0) {

                ///COINCIDE CON UNA CUENTA DE CLIENTE

                $sdata="id";
                $stabla="alta_saldo_proveedor";
                $scondicion=array('cuenta'=>$data_post["cuentax"]);

                $srow=$this->General_Model->SelectUnafila($sdata,$stabla,$scondicion);

                $idcuenta=$srow->id;

            }

            $udatos=array(

                'fecha_banco' => $data_post["bfechax"],
                'hora_banco' => $data_post["bhorax"],
                'movimiento' => $data_post["movimientox"],
                'cuenta' => $data_post["cuentax"],
                'rastreo' => $data_post["rastreox"],
                'importe' => $data_post["importex"],
                'idcuenta'=>$idcuenta,
                'fpago'=>$data_post["xfpago"]

            );

            $utabla="alta_saldo_proveedor";
            $ucondicion=array('id'=>$data_post["idx"]);

            $update=$this->General_Model->updateERP($udatos,$utabla,$ucondicion);

            if($update) {
                
                ///////mostrar datos

                $sql='SELECT a.id,CONCAT_WS("/",a.id,a.estatus,a.idcuenta) AS acciones,a.fecha_banco, a.hora_banco,a.movimiento,a.descripcion,a.rastreo,CONCAT_WS("/",a.tipo,a.importe) AS importex, CONCAT_WS(" | ",a.cuenta,d.comercial) AS cuentax,IFNULL(c.nombre,"No identificado") AS nombrex,a.estatus,a.tipo,a.importe,a.cuenta,IFNULL(c.id,0) AS idclientex, IFNULL(e.descripcion,"s/aplicar") AS fpagox, a.fpago
                        FROM alta_saldo_proveedor a
                        LEFT JOIN alta_cuentas_proveedor b ON a.idcuenta=b.id
                        LEFT JOIN alta_bancos d ON b.idbanco=d.id 
                        LEFT JOIN alta_proveedores c ON b.idproveedor=c.id
                        LEFT JOIN sat_catalogo_fpago e ON a.fpago=e.id
                        WHERE a.estatus=0 AND a.id='.$data_post["idx"];

                echo json_encode( $this->General_Model->infoxQueryUnafila($sql) );

            }else{

                echo json_encode(null);

            }


    }

    public function showODCxSaldo(){
           
        $data_post = $this->input->post();

        $sql = "SELECT acp.fecha, acp.idodc, acp.total, p.nombre, asp.evidencia
            FROM alta_pago_proveedor acp, alta_proveedores p, alta_saldo_proveedor asp
            WHERE acp.idproveedor=p.id AND asp.id = acp.idsaldo
            AND asp.id =".$data_post['idSaldo'];

        echo json_encode( $this->General_Model->infoxQuery($sql) ); 

    }

    public function aplicarPago(){

        $data_post = $this->input->post();
        $iduser = $this->session->userdata(IDUSERCOM);

        $idSaldo = $_POST['idSaldo'];
        $idProveedor = $_POST['idProveedor'];
        
        if(isset($_POST['datos'])){

            $tableData = $data_post['datos'];

            $table1="temporal_pagos_proveedor";
            $table2 = "alta_pago_proveedor";

            $condic = array(
                'idsaldo' => $idSaldo
            );

            if($this->General_Model->deleteERP($table1,$condic)){
                
            }

            foreach ($tableData as $fila) {

                $ODC = $fila['ODC'];
                $importe = $fila['IMPORTE'];
    
                $data1 = array(
    
                    'idodc' => $fila['ODC'],
                    'idsaldo' => $idSaldo,
                    'total' => $fila['IMPORTE'],
                    'idproveedor' => $idProveedor,
                    'fecha' => date("Y-m-d"),
                    'iduser' => $iduser
    
                 );
    
                $this->General_Model->altaERP($data1,$table2);

                $datos=array('estatus'=>1, 'evidencia' => $data_post['evidencia']);
                $tabla="alta_saldo_proveedor";
                $condicion=array('id' => $idSaldo);
        
                echo json_encode($this->General_Model->updateERP($datos,$tabla,$condicion) );
            }
        }

    }

    public function loadPartidas()
    {

        $data_get = $this->input->get();
        $where="";

        if($data_get["estx"] != 5 && $data_get["idclientex"] > 0){

            $where="WHERE a.estatus='".$data_get["estx"]."' AND a.idproveedor='".$data_get["idclientex"]."'";

        }else{

            if($data_get["estx"] != 5) {
            
                $where="WHERE a.estatus='".$data_get["estx"]."'";

            }

            if($data_get["idclientex"] > 0) {

                $where="WHERE a.idproveedor='".$data_get["idclientex"]."'";

            }

        }
            


        $table='(SELECT a.id,CONCAT_WS("/",a.id,a.estatus,a.idcuenta) AS acciones,a.fecha_banco, a.hora_banco,a.movimiento,a.descripcion,a.rastreo,CONCAT_WS("/",a.tipo,a.importe) AS importex, CONCAT_WS(" | ",a.cuenta,d.comercial) AS cuentax,IFNULL(c.nombre,"No identificado") AS nombrex,a.estatus,a.tipo,a.importe,a.cuenta,IFNULL(c.id,0) AS idclientex, IFNULL(e.descripcion,"s/aplicar") AS fpagox, a.fpago
                FROM alta_saldo_proveedor a
                LEFT JOIN alta_cuentas_proveedor b ON a.idcuenta=b.id
                LEFT JOIN alta_bancos d ON b.idbanco=d.id 
                LEFT JOIN alta_proveedores c ON b.idproveedor=c.id
                LEFT JOIN sat_catalogo_fpago e ON a.fpago=e.id
                '.$where.' ORDER BY id DESC)temp';

        // Primary key of table
        $primaryKey = 'id';
        
        $columns = array(
            
            array( 'db' => 'acciones',     'dt' => 0,

                    'formatter' => function( $d, $row ) {

                        $separarx=explode("/", $d);

                        if($separarx[2]>0) {
                            ///// IDENTIFICADO
                            if( $separarx[1]==0 ) {
                                //////sin aplicar

                                return '<div class="btn-group">

                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    <span class="caret"></span>

                                        </button>

                                        <ul class="dropdown-menu">

                                        <li><a href="#" style="color:darkgreen; font-weight:bold;" data-toggle="modal" data-target="#modal_pagos"> <i class="fa fa-money" style="color:darkgreen; font-weight:bold;"></i> Aplicar pago</a></li>

                                        </ul>

                                    </div>';


                            }else if( $separarx[1]==1 ){

                                ///// aplicado

                                return '<div class="btn-group">

                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    <span class="caret"></span>

                                        </button>

                                        <ul class="dropdown-menu">

                                        <li><a href="#" style="color:darkgreen; font-weight:bold;" data-toggle="modal" data-target="#modalODC"> <i class="fa fa-eye" style="color:darkgreen; font-weight:bold;"></i> Ver ODC</a></li>

                                        </ul>

                                    </div>';

                            }else if( $separarx[1]==2 ){

                                ///// devolucion

                                return '<div class="btn-group">

                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    <span class="caret"></span>

                                        </button>

                                        <ul class="dropdown-menu">

                                        <li><a href="#" style="color:#E8B203; font-weight:bold;" data-toggle="modal" data-target="#modalAccounts"> <i class="fa fa-edit" style="color:#E8B203; font-weight:bold;"></i> Editar</a></li>


                                        </ul>

                                    </div>';

                            }

                        }else{


                            if ( $separarx[1]==2 ) {
                                
                                ////// devolucion

                                return '<div class="btn-group">

                                        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                                    <span class="caret"></span>

                                        </button>

                                        <ul class="dropdown-menu">

                                        <li><a href="#" style="color:#E8B203; font-weight:bold;" data-toggle="modal" data-target="#modalAccounts"> <i class="fa fa-edit" style="color:#E8B203; font-weight:bold;"></i> Editar</a></li>


                                        </ul>

                                    </div>';


                            }else{


                                //// NO IDENTIFICADO

                                return '<div class="btn-group">

                                    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">



                                <span class="caret"></span>

                                    </button>

                                    <ul class="dropdown-menu">

                                    <li><a href="#" style="color:#E8B203; font-weight:bold;" data-toggle="modal" data-target="#modalAccounts"> <i class="fa fa-edit" style="color:#E8B203; font-weight:bold;"></i> Editar</a></li>

                                    </ul>

                                </div>';

                            }

                        }
                        

                    }  
            ),

            array( 'db' => 'estatus',     'dt' => 1,

                    'formatter' => function( $d, $row ) {

                        switch ($d) {
                            case 0:
                            
                                $valor="<p style='color:orange; font-weight:bold;' >SIN APLICAR</p>";

                            break;

                            case 1:
                                    
                                $valor="<p style='color:darkgreen; font-weight:bold;' >APLICADO</p>";

                            break;

                            case 2:
                                    
                                $valor="<p style='color:red; font-weight:bold;' >CTA. NO IDENTIFICADA</p>";

                            break;    
                            
                            
                        }

                        return $valor;

                    }  
            ),
            
            array( 'db' => 'fecha_banco',     'dt' => 2),

            array( 'db' => 'rastreo',     'dt' => 3),

            array( 'db' => 'cuentax',     'dt' => 4),

            array( 'db' => 'nombrex',     'dt' => 5),

            array( 'db' => 'importex',     'dt' => 6,

                    'formatter' => function( $d, $row ) {

                    $separar=explode("/",$d);

                        if( $separar[0] == 1) {
                            
                            return wims_currency($separar[1]);     

                        }else{

                            return wims_currency(0);

                        }

                        

                    }  
            ),


            array( 'db' => 'fpagox',     'dt' => 7),



            array( 'db' => 'id',     'dt' => 9),

            array( 'db' => 'tipo',     'dt' => 10),

            array( 'db' => 'importe',     'dt' => 11),

            array( 'db' => 'cuenta',     'dt' => 12),

            array( 'db' => 'movimiento',     'dt' => 13),

            array( 'db' => 'hora_banco',     'dt' => 14),

            array( 'db' => 'importex',     'dt' => 15,

                    'formatter' => function( $d, $row ) {

                        $separar=explode("/",$d);

                        if( $separar[0] == 2) {
                            
                            return $separar[1];     

                        }else{

                            return 0;

                        }

                        

                    }  

            ),

            array( 'db' => 'idclientex',     'dt' => 16),

            array( 'db' => 'descripcion',     'dt' => 17),

            array( 'db' => 'fpago',     'dt' => 18)


        
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

    public function showBancos(){

        $query="SELECT id,rfc,comercial FROM alta_bancos WHERE estatus=0 ORDER BY comercial ASC";

        echo json_encode( $this->General_Model->infoxQuery($query) );

    }

    public function actualizarCuenta(){

        $data_post=$this->input->post();

        $sql = "SELECT razon FROM alta_bancos WHERE id = '".$data_post['idbancox']."'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $result = $query->row();
            $banco = $result->razon;
        }

        $data=array(

            'idproveedor' => $data_post["idProveedor"],
            'idbanco' => $data_post["idbancox"],
            'banco' => $banco,
            'cuenta' => $data_post["cuentax"],
            'estatus' => 1

        );

        $table="alta_cuentas_proveedor";
        $this->General_Model->altaERP($data,$table);

        $sql = "SELECT id FROM alta_cuentas_proveedor WHERE idproveedor = '".$data_post["idProveedor"]."' AND cuenta = '".$data_post["cuentax"]."'";
        $query = $this->db->query($sql);

        if ($query->num_rows() > 0) {
            $result = $query->row();
            $idCuenta = $result->id;
        }

        $datos=array('idcuenta'=> $idCuenta, 'idproveedor'=>$data_post["idProveedor"], 'estatus'=>0);
        $tabla="alta_saldo_proveedor";
        $condicion=array('id' => $data_post["idSaldo"]);

        echo json_encode($this->General_Model->updateERP($datos,$tabla,$condicion) );

    }
   
}
