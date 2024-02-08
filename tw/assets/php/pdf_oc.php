<?php

require_once('fpdf/fpdf.php');
require_once('fpdf/letras.php');

function wims_currency($number) { 
   if ($number < 0) { 
    $print_number = "-$ " . str_replace('-', '', number_format ($number, 2, ".", ",")) . ""; 
    } else { 
     $print_number = "$ " .  number_format ($number, 2, ".", ",") ; 
   } 
   return $print_number; 
} 

function textOracion($x, $valor){

    if($valor == 0){

        $valortxt = ucwords(strtolower($x));

    }else{

        $valortxt = strtoupper($x);

    }
    

    return $valortxt;

}

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
                array('º', '~','!','&','´',';','"',),
                array('','','','&amp;','','','&quot;'),
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

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

class PDF extends FPDF
{ 
    function Header(){
        parent::Header();

        global $idoc;
        global $fecha;
        global $usuario;
        global $proveedor;
        global $alm;
        global $pago;
        global $dias;
        global $clvproveedor;
        global $facturable;
        
        ///////***************** ENCABEZADO

        $this->SetDrawColor(0,0,0);
        $this->SetFillColor(255,255,255);
        $this->Rect(10, 11, 190, 35, 'DF');

        $this->Image("logo_sf.png",14,12,32,25,"PNG","http://www.esmex.com.mx/");

        $this->SetFont('Arial','B',14);

        $this->SetTextColor(0, 0, 0);
        $this->SetY(20);$this->SetX(50); $this->MultiCell(150,0,"ESTRATEGIAS EN MUEBLES Y EXHIBIDORES, S.A. DE C.V. ",0,'C',0);///////TITULO

        $this->SetFont('Arial','',14);

        $this->SetTextColor(0, 0, 0);
        $this->SetY(30);$this->SetX(50); $this->MultiCell(150,0,"Departamento de Compras ESMEX",0,'C',0);///////TITULO

        $this->SetFont('Arial','B',12);

        $this->SetTextColor(0, 0, 0);
        $this->SetY(40);$this->SetX(50); $this->MultiCell(150,0,"Clave de Proyecto: ",0,'C',0);///////TITULO

        $this->SetFont('Arial','B',24);
        $this->SetTextColor(220, 21, 15);
        $this->SetY(40);$this->SetX(150); $this->MultiCell(40,0,"OC",0,'R',0);///////TITULO

        ////////////// INFORMACION DE LA RQ

        $this->SetDrawColor(0,0,0);
        $this->SetFillColor(255,255,255);
        $this->Rect(10, 46, 190, 25, 'DF');

        $this->SetFont('Arial','',10);
        $this->SetTextColor(0, 0, 0);

        $this->SetY(52);$this->SetX(50); $this->MultiCell(140,0,utf8_decode("Orden No.").$idoc,0,'R',0);///////TITULO
        $this->SetY(52);$this->SetX(14); $this->MultiCell(80,0,"Proveedor asignado (".$clvproveedor.")",0,'L',0);///////TITULO

        $this->SetFont('Arial','',9);
        $this->SetY(58);$this->SetX(50); $this->MultiCell(140,0,"Fecha: ".$fecha,0,'R',0);///////TITULO
        $this->SetY(64);$this->SetX(50); $this->MultiCell(140,0,"Entregar a:".utf8_decode($alm),0,'R',0);///////TITULO

        $this->SetFont('Arial','',9);
        $this->SetY(58);$this->SetX(14); $this->MultiCell(135,0,utf8_decode($proveedor),0,'L',0);///////TITULO


        $this->SetY(64);$this->SetX(14); $this->MultiCell(135,0,"Facturable a: ".utf8_decode($facturable),0,'L',0);///////TITULO
        
        /*$this->SetY(38);$this->SetX(80); $this->MultiCell(80,0,"NOMBRE DEL OPERADOR",0,'L',1);///////TITULO

         $this->SetY(38);$this->SetX(165); $this->MultiCell(40,0,"NO. DE PROYECTO",0,'L',0);///////TITULO

        $this->SetFont('Arial','',8);
        $this->SetTextColor(0, 0, 0);


        $this->SetDrawColor(0, 0, 0);
        $this->SetFillColor(255, 255, 255);
        $this->SetY(40);$this->SetX(10); $this->Cell(35,8,"fecha",1,1,'C',1);
        $this->SetY(40);$this->SetX(45); $this->Cell(120,8,"OPERADOR",1,1,'C',0);
        $this->SetY(40);$this->SetX(165); $this->Cell(35,8,"FOLIO",1,1,'C',0);

        $this->SetDrawColor(237,125,49);
        $this->SetFillColor(237,125,49);
        $this->Rect(10, 53, 190, 5, 'DF');

        $this->SetFont('Arial','',9);

        $this->SetTextColor(0, 0, 0);
        $this->SetY(56);$this->SetX(20); $this->MultiCell(125,0,"CLIENTE",0,'C',1);///////TITULO  
        $this->SetY(56);$this->SetX(150); $this->MultiCell(50,0,"FECHA ENTREGA PROYECTO",0,'L',0);///////TITULO

        $this->SetFont('Arial','',8);
        $this->SetTextColor(0, 0, 0);


        $this->SetDrawColor(0, 0, 0);
        $this->SetFillColor(255, 255, 255);
        $this->SetY(58);$this->SetX(10); $this->Cell(140,8,"cliente",1,1,'C',1);
        $this->SetY(58);$this->SetX(150); $this->Cell(50,8,"fentrega",1,1,'C',0);

        $this->SetDrawColor(237,125,49);
        $this->SetFillColor(237,125,49);
        $this->Rect(10, 71, 190, 5, 'DF');

        $this->SetFont('Arial','',9);

        $this->SetTextColor(0, 0, 0);
        
        $this->SetY(74);$this->SetX(10); $this->MultiCell(190,0,"PROYECTO",0,'C',0);///////TITULO

        $this->SetFont('Arial','',8);
        $this->SetTextColor(0, 0, 0);


        $this->SetDrawColor(0, 0, 0);
        $this->SetFillColor(255, 255, 255);
        $this->SetY(76);$this->SetX(10); $this->Cell(190,8,"proyecto",1,1,'C',0);

    
    */
        
    /////################ TITULOS DE LA TABLA ##################################

        $this->SetDrawColor(0,0,0);
        $this->SetFillColor(255,255,255);
        $this->Rect(10, 70, 190, 8, 'DF');

        $this->SetFont('Arial', 'B', 9);
        $this->SetTextColor(0, 0, 0);

        $this->SetY(74);
        $this->SetX(12);
        $this->MultiCell(25, 0, 'CANTIDAD',0,'R',1); ///////importe con letra

        $this->SetY(74);
        $this->SetX(38);
        $this->MultiCell(25, 0, 'PRODUCTO', 0, 'C', 1); ///////importe con letra

        $this->SetY(74);
        $this->SetX(64);
        $this->MultiCell(55, 0, 'DECRIPCION', 0, 'L', 1); ///////importe con letra

        $this->SetY(74);
        $this->SetX(120);
        $this->MultiCell(20, 0, '%DESC', 0, 'R', 1); ///////importe con letra

        $this->SetY(74);
        $this->SetX(141);
        $this->MultiCell(27, 0, 'UNITARIO', 0, 'R', 1); ///////importe con letra

        $this->SetY(74);
        $this->SetX(169);
        $this->MultiCell(29, 0, 'IMPORTE', 0, 'R', 1); ///////importe con letra


        $this->SetTextColor(0,0,0);
        
        $this->SetFont('Arial','',6);
        $this->SetY(77);



    }
    function Footer(){
        $this->SetY(2);
        $this->SetX(167);
        $this->SetFont('Arial','B',9);
        $this->SetTextColor(0,0,0);
        $this->Cell(30,10,'Hoja '.$this->PageNo().' de {nb}',0,0,'C');
    }

    public function GeneraContenido(  

        $idoc,
        $fecha,
        $usuario,
        $proveedor,
        $alm,
        $pago,
        $dias,
        $clvproveedor,
        $facturable

    ){

        $this->AliasNbPages();
        $this->AddPage();
        $this->SetDrawColor(150, 25, 0);
        $this->SetFillColor(150, 25, 0);
        $this->SetLineWidth(0.3);

        include("config.php"); 
        include("includes/mysqli.php");
        include("includes/db.php");
        set_time_limit(600000);
        date_default_timezone_set('America/Mexico_City');


        $selectPart = "SELECT b.descripcion,a.total,b.um,a.total,a.costo,(a.total*a.costo) AS subtotal,b.clave,b.um,a.idrq,d.folio 
            FROM partes_rq a, catalogo_productos_rq b, alta_rq c, alta_proyecto d
                            WHERE
                            a.idparte=b.id
                            AND a.idrq=c.id
                            AND c.idproyecto=d.idproyecto
                            AND a.estatus IN(1,3)
                            AND a.idoc=".$idoc."
UNION ALL

SELECT b.descripcion,a.total,b.um,a.total,a.costo,(a.total*a.costo) AS subtotal,b.clave,b.um,a.idrq,'Sin asignar' AS folio 
            FROM partes_rq a, catalogo_productos_rq b
            WHERE a.idparte=b.id
            AND a.idparte = 473
            AND a.estatus IN(1,3)
            AND a.idoc = ".$idoc;

        $buscar3 = $db->sql_query($selectPart);



        $valory = $this->GetY();
        $valor_init = $this->GetY();


        $suma_subtotal = 0; 

        while(  $row=$db->sql_fetchrow($buscar3)   ){

            $total_lineas = strlen( $row['descripcion']." (".$row['folio'].")" );
            

            $nlineas = round($total_lineas/55);
            $this->SetFont('Arial','',8);

            if ( $nlineas == 1 ) {
                
                $this->SetY($valory+11);$this->SetX(64);$this->MultiCell(68,$nlineas+2,utf8_decode($row['descripcion'])." (".$row["folio"].")", 0, 'L', 0);

            }else{

                $this->SetY($valory+11);$this->SetX(64);$this->MultiCell(68,$nlineas,utf8_decode($row['descripcion'])." (".$row["folio"].")", 0, 'L', 0);

            }
          
            
            

            if ( $nlineas > 1 ) {

                $this->SetY($valory+13);     
                
            }else{

                $this->SetY($valory+11);

            }

            $this->SetFont('Arial','',8);
            $this->SetX(38);$this->MultiCell(25,0,$row['clave'], 0, 'C', 0);

            $this->SetFont('Arial','',9);

            $this->SetX(12);$this->MultiCell(25,0,$row['total']." ".$row["um"], 0, 'R', 0);
            $this->SetX(120);$this->MultiCell(20,0,"0%", 0, 'R', 0);
            $this->SetX(141);$this->MultiCell(27,0,wims_currency($row['costo']), 0, 'R', 0);

            $this->SetFont('Arial','B',9);
            $this->SetX(169);$this->MultiCell(29,0,wims_currency($row['subtotal']), 0, 'R', 0);

            if ( $nlineas > 1 ) {

                $valory = $valory+10+$nlineas+10;      
                
            }else{

                $valory = $valory+10+$nlineas;

            }

            //////***** OBTENEMOS SUBTOTAL

            $suma_subtotal = $suma_subtotal+$row['subtotal'];
            
            
            if ($valory > 230) {

                $this->AddPage();

                $valory = $valor_init;

            }  



        }


        //////////////////////////////////////////////*********** FOOTER

        $this->SetDrawColor(0,0,0);
        $this->SetFillColor(255,255,255);
        $this->Rect(10, 230, 190, 55, 'DF');
        $this->Rect(15, 238, 70, 30, 'DF');

        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(0, 0, 0);

        $this->SetY(235);
        $this->SetX(30);
        $this->MultiCell(50, 0, 'Sello de autorizacion', 0, 'L', 1); ///////importe con letra


        $this->SetY(240);
        $this->SetX(110);
        $this->MultiCell(90, 0, '_____________________________________', 0, 'L', 1); ///////importe con letra

        $this->SetFont('Arial', 'B', 11);
        $this->SetTextColor(0, 0, 0);

        $this->SetY(245);
        $this->SetX(125);
        $this->MultiCell(50, 0, 'Firma', 0, 'C', 1); ///////importe con letra

        ///////******* SUBTOTAL

        $this->SetFont('Arial', '', 11);
        $this->SetY(252);
        $this->SetX(110);
        $this->MultiCell(30, 0, 'Subtotal', 0, 'R', 1); ///////importe con letra

       
        $this->SetY(260);
        $this->SetX(110);
        $this->MultiCell(30, 0, 'Iva', 0, 'R', 1); ///////importe con letra

       
        $this->SetY(268);
        $this->SetX(110);
        $this->MultiCell(30, 0, 'Total', 0, 'R', 1); ///////importe con letra


        ////////// CALCULO 

        $total = $suma_subtotal* 1.16;
        $iva = $total-$suma_subtotal;
        
        $this->SetY(252);
        $this->SetX(145);
        $this->MultiCell(50, 0, wims_currency($suma_subtotal), 0, 'R', 1); ///////SUBTOTAL

        
        $this->SetY(260);
        $this->SetX(145);
        $this->MultiCell(50, 0, wims_currency($iva), 0, 'R', 1); ///////IVA

        $this->SetFont('Arial', 'B', 11);
        $this->SetY(268);
        $this->SetX(145);
        $this->MultiCell(50, 0, wims_currency($total), 0, 'R', 1); ///////TOTAL

        //////////////// ACTUALIZAMOS EL COSTO EN LA TABLA DE ORDEND E COMPRA

        $sql_upt="UPDATE alta_oc SET subtotal = $suma_subtotal, iva=$iva, total=$total WHERE id=".$idoc;
        $db->sql_query($sql_upt);


        $this->SetY(275);
        $this->SetX(15);
        $this->MultiCell(180, 0, letras($total), 0, 'L', 1); ///////importe con letra

        /*$this->ln(30);

        $newy = $this->GetY();

        $this->SetDrawColor(237,125,49);
        $this->SetFillColor(237,125,49);
        $this->Rect(10, $newy, 190, 5, 'DF');

        $this->SetFont('Arial','',9); 
        $this->SetTextColor(0, 0, 0);
        
        $this->SetY($newy+3);$this->SetX(10); $this->MultiCell(190,0,"INFORMACION ENTREGADA",0,'C',0);///////TITULO

        $this->SetDrawColor(0,0,0);
        $this->SetFillColor(235,235,235);

        /////********** REVISION DE DOCUMENTOS 

        $planox = "";
        $croquisx = "";
        $fichax = "";


        if (  $planos != ""  ) {

            $planox = "X";
            
        }

        if (  $croquis != ""  ) {

            $croquisx = "X";
            
        }

        if (  $ficha != ""  ) {

            $planox = "X";
            
        }



        $this->SetY($newy+10);$this->SetX(70); $this->Cell(7,5,$planox,1,1,'C',1);//Mobiliario institucional

        $this->SetY($newy+10);$this->SetX(101); $this->Cell(7,5,$croquisx,1,1,'C',1);//Mobiliario institucional

        $this->SetY($newy+10);$this->SetX(140); $this->Cell(7,5,$fichax,1,1,'C',1);//Mobiliario institucional


        
        $this->SetFont('Arial','',8);
        $this->SetY($newy+13);$this->SetX(55); $this->MultiCell(50,0,utf8_decode("PLANOS"),0,'l',0);//

        $this->SetFont('Arial','',8);
        $this->SetY($newy+13);$this->SetX(85); $this->MultiCell(50,0,utf8_decode("CROQUIS"),0,'l',0);//

        $this->SetFont('Arial','',8);
        $this->SetY($newy+13);$this->SetX(115); $this->MultiCell(50,0,utf8_decode("FICHA TECNICA"),0,'l',0);//

        $this->SetDrawColor(237,125,49);
        $this->SetFillColor(237,125,49);
        $this->Rect(10, $newy+20, 190, 5, 'DF');

        $this->SetFont('Arial','',9); 
        $this->SetTextColor(0, 0, 0);
        
        $this->SetY($newy+23);$this->SetX(10); $this->MultiCell(190,0,"OBSERVACIONES",0,'C',0);//

        $this->SetFont('Arial','',8);
        $this->SetTextColor(0, 0, 0);


        $this->SetDrawColor(0, 0, 0);
        $this->SetFillColor(255, 255, 255);
        $this->SetY($newy+28);$this->SetX(10); $this->Cell(190,15,$obs,1,1,'C',0);


        $this->SetDrawColor(237,125,49);
        $this->SetFillColor(237,125,49);
        $this->Rect(10, $newy+45, 190, 5, 'DF');

        $this->SetFont('Arial','',9); 
        $this->SetTextColor(0, 0, 0);
        
        $this->SetY($newy+48);$this->SetX(10); $this->MultiCell(190,0,"AUTORIZACIONES",0,'C',0);//

        */
    }       

}


$pdf = new PDF();

include("config.php"); 
include("includes/mysqli.php");
include("includes/db.php");
set_time_limit (600000);
date_default_timezone_set('America/Mexico_City');

/*$fecha = date("Y-m-d");
$operador = trim($_POST["operador"]);
$folio = trim($_POST["folio"]);
$planos = $_POST["name_planos"];
$croquis = $_POST["name_croquis"];
$ficha = $_POST["name_ficha"];
$cliente = trim(utf8_decode($_POST["cliente"]));
$proyecto = trim($_POST["proyecto"]);
$entrega = trim($_POST["entrega"]);
$idip = trim($_POST["idip"]);
$obs = trim(utf8_decode($_POST["observaciones"]));*/

$idoc =trim($_POST["idoc"]);

$query = 'SELECT a.fecha,b.nombre AS usuario,c.nombre AS proveedor,c.clave AS clvproveedor, CASE a.almacen WHEN 1 THEN "Almacen peñoles" WHEN 2 THEN "Almacen lerma" END AS alm, CASE WHEN a.fpago=0 THEN "Contado" WHEN a.fpago = 2 THEN "Credito" END AS pago, a.dias, CASE a.facturar WHEN 1 THEN "Jose Luis Escobedo Suarez" WHEN 2 THEN "Estrategias en muebles y exhibidores s.a. de c.v." END AS facturable
FROM alta_oc a, alta_usuarios b, proveedores c
WHERE
a.idusuario=b.id
AND a.idproveedor=c.id
AND a.id='.$idoc;
$buscar = $db->sql_query($query);
$row2 = $db->sql_fetchrow($buscar);
    
$fecha = obtenerFechaEnLetra($row2["fecha"]);
$usuario = utf8_decode($row2["usuario"]);
$proveedor = utf8_decode($row2["proveedor"]);
$alm = utf8_decode($row2["alm"]);
$pago = $row2["pago"];
$dias   = $row2["dias"];
$clvproveedor = $row2["clvproveedor"];
$facturable = $row2["facturable"];


$pdf->GeneraContenido(

    $idoc,
    $fecha,
    $usuario,
    $proveedor,
    $alm,
    $pago,
    $dias,
    $clvproveedor,
    $facturable

);

$nombrearchivo = "oc/oc".$idoc.".pdf";
$pdf->Output($nombrearchivo, 'F');
//$pdf->Output();

//$arrayName= array('imprime'=>$idip);

echo json_encode($idoc);


?>