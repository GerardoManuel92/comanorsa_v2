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
    
    function MultiCellx($w, $h, $txt, $border=0, $align='J', $fill=false, $indent=0)
    {
        //Output text with automatic or explicit line breaks
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;

        $wFirst = $w-$indent;
        $wOther = $w;

        $wmaxFirst=($wFirst-2*$this->cMargin)*1000/$this->FontSize;
        $wmaxOther=($wOther-2*$this->cMargin)*1000/$this->FontSize;

        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 && $s[$nb-1]=="\n")
            $nb--;
        $b=0;
        if($border)
        {
            if($border==1)
            {
                $border='LTRB';
                $b='LRT';
                $b2='LR';
            }
            else
            {
                $b2='';
                if(is_int(strpos($border,'L')))
                    $b2.='L';
                if(is_int(strpos($border,'R')))
                    $b2.='R';
                $b=is_int(strpos($border,'T')) ? $b2.'T' : $b2;
            }
        }
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $ns=0;
        $nl=1;
            $first=true;
        while($i<$nb)
        {
            //Get next character
            $c=$s[$i];
            if($c=="\n")
            {
                //Explicit line break
                if($this->ws>0)
                {
                    $this->ws=0;
                    $this->_out('0 Tw');
                }
                $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $ns=0;
                $nl++;
                if($border && $nl==2)
                    $b=$b2;
                continue;
            }
            if($c==' ')
            {
                $sep=$i;
                $ls=$l;
                $ns++;
            }
            $l+=$cw[$c];

            if ($first)
            {
                $wmax = $wmaxFirst;
                $w = $wFirst;
            }
            else
            {
                $wmax = $wmaxOther;
                $w = $wOther;
            }

            if($l>$wmax)
            {
                //Automatic line break
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                    if($this->ws>0)
                    {
                        $this->ws=0;
                        $this->_out('0 Tw');
                    }
                    $SaveX = $this->x; 
                    if ($first && $indent>0)
                    {
                        $this->SetX($this->x + $indent);
                        $first=false;
                    }
                    $this->Cell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
                        $this->SetX($SaveX);
                }
                else
                {
                    if($align=='J')
                    {
                        $this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
                        $this->_out(sprintf('%.3f Tw',$this->ws*$this->k));
                    }
                    $SaveX = $this->x; 
                    if ($first && $indent>0)
                    {
                        $this->SetX($this->x + $indent);
                        $first=false;
                    }
                    $this->Cell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
                        $this->SetX($SaveX);
                    $i=$sep+1;
                }
                $sep=-1;
                $j=$i;
                $l=0;
                $ns=0;
                $nl++;
                if($border && $nl==2)
                    $b=$b2;
            }else{
                $i++;
            }
        }
        //Last chunk
        if($this->ws>0)
        {
            $this->ws=0;
            $this->_out('0 Tw');
        }
        if($border && is_int(strpos($border,'B')))
            $b.='B';
            $this->Cell($w,$h,substr($s,$j,$i),$b,2,$align,$fill);
            $this->x=$this->lMargin;
       
    }

    function Header(){
        parent::Header();

        global $identrada;
        global $folio;
        global $fecha;
        global $moneda;
        global $rfc;
        global $proveedor;
        global $recibio;
        
        global $observaciones;
        ///////***************** ENCABEZADO

        $this->SetDrawColor(250,250,250);
        $this->SetFillColor(243,243,243);
        $this->Rect(10, 11, 190, 22, 'DF');

        $this->Image("logo_icono.png",14,14,21,18,"PNG","http://comanorsa.com/");

        $this->SetFont('Arial','',11);

        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0,0,0);
        $this->SetY(15);$this->SetX(40); $this->MultiCell(85,1,"COMANORSA",0,'C',0);///////TITULO


        $this->SetFont('Arial','B',7);
        $this->SetY(21);$this->SetX(40); $this->MultiCell(85,1,"COMERCIALIZADORA ANGEL DE ORIENTE SA DE CV CAO160125IT7",0,'L',0);///////TITULO

        $this->SetFont('Arial','',7);

        $this->SetY(24);$this->SetX(40); $this->MultiCell(85,3,utf8_decode("Calle Av. Tamaulipas, No. 150, No. int 1301B, Col. Condesa, Cuauhtémoc, Ciudad de México, México, CP 06140"),0,'L',0);///////TITULO

        $this->SetFont('Arial','B',8);

        $this->SetY(21);$this->SetX(130); $this->MultiCell(30,1,utf8_decode("Folio:"),0,'L',0);///////
        $this->SetY(29);$this->SetX(130); $this->MultiCell(30,1,utf8_decode("Moneda:"),0,'L',0);///////
        $this->SetY(25);$this->SetX(130); $this->MultiCell(30,1,utf8_decode("Fecha y hora:"),0,'L',0);///////
        $this->SetY(25);$this->SetX(150); $this->MultiCell(50,1,$fecha." | ".date("H:i:s"),0,'R',0);///////
        $this->SetY(29);$this->SetX(150); $this->MultiCell(50,1,$moneda,0,'R',0);//////

        $this->SetFont('Arial','B',10);
        $this->SetY(20);$this->SetX(180); $this->MultiCell(20,1,$folio,0,'R',0);///////

        $this->SetFont('Arial','B',12);

        ////////////// INFORMACION DE LA RQ

        $this->SetDrawColor(250,250,250);
        $this->SetFillColor(243,243,243);
        $this->Rect(10, 34, 190, 15, 'DF');

        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0,0,0);

        $this->SetY(37);$this->SetX(14); $this->MultiCell(9,2,"RFC: ",0,'L',0);///////TITULO
        $this->SetY(43);$this->SetX(14); $this->MultiCell(150,0,"Recepcion:",0,'L',0);///////TITULO
        $this->SetY(37);$this->SetX(52); $this->MultiCell(20,2,"Proveedor:",0,'L',0);///////TITULO
        
        $this->SetY(37);$this->SetX(155); $this->MultiCell(30,2,"Recibido por: ",0,'L',0);///////TITULO

       

        $this->SetFont('Arial','',8);
        $this->SetY(37);$this->SetX(22); $this->MultiCell(30,2,$rfc,0,'L',0);///////TITULO
        $this->SetY(41);$this->SetX(30); $this->MultiCell(100,4,( strtolower(utf8_decode("Almacen principal")) ),0,'L',0);///////TITULO
        $this->SetY(37);$this->SetX(68); $this->MultiCell(125,2,$proveedor,0,'L',0);///////TITULO
        $this->SetY(37);$this->SetX(154); $this->MultiCell(45,2,$recibio,0,'R',0);///////TITULO


        $this->SetDrawColor(134,187,224);
        $this->SetFillColor(134,187,224);
        $this->Rect(130, 11, 70, 6, 'DF');

        $this->SetFont('Arial','B',11);

        $this->SetTextColor(255, 255, 255);
        $this->SetDrawColor(0,0,0);
        $this->SetY(15);$this->SetX(130); $this->MultiCell(68,1,utf8_decode("ENTRADA ALMACEN"),0,'C',0);///////TITULO

        /*$this->SetY(64);$this->SetX(14); $this->MultiCell(135,0,"Facturable a: ",0,'L',0);///////TITULO*/
        
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

        $this->SetDrawColor(134,187,224);
        $this->SetFillColor(134,187,224);
        $this->Rect(10, 49, 190, 5, 'DF');

        $this->SetFont('Arial', 'B', 8);
        $this->SetTextColor(255, 255, 255);

        $this->SetY(52.2);
        $this->SetX(12);
        $this->MultiCell(20, 0, 'CANTIDAD',0,'R',1); ///////importe con letra

        $this->SetY(52.2);
        $this->SetX(33);
        $this->MultiCell(15, 0, 'UNIDAD', 0, 'R', 1); ///////importe con letra

        $this->SetY(52.2);
        $this->SetX(52);
        $this->MultiCell(55, 0, 'DECRIPCION', 0, 'L', 1); ///////importe con letra

        $this->SetY(52.2);
        $this->SetX(141);
        $this->MultiCell(27, 0, 'UNITARIO', 0, 'R', 1); ///////importe con letra

        $this->SetY(52.2);
        $this->SetX(169);
        $this->MultiCell(29, 0, 'IMPORTE', 0, 'R', 1); ///////importe con letra


        $this->SetTextColor(0,0,0);
        
        $this->SetFont('Arial','',6);
        $this->SetY(53);



    }
    function Footer(){
        $this->SetY(2);
        $this->SetX(167);
        $this->SetFont('Arial','B',9);
        $this->SetTextColor(0,0,0);
        $this->Cell(30,10,'Hoja '.$this->PageNo().' de {nb}',0,0,'C');
    }

    public function GeneraContenido(  

       $identrada,
        $folio,
        $fecha,
        $dias,
        $moneda,
        $rfc,
        $proveedor,
        $recibio,
        $observaciones

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


        /*$selectPart = "SELECT a.id,b.nparte AS clave, CONCAT_WS(' ',b.clave,b.descripcion,d.marca) AS descrip, c.abr AS unidad, a.costo, a.iva,a.descuento,(a.cantidad*a.costo) AS subtotal,a.cantidad,a.idparte,( ((a.cantidad*a.costo)- ((a.cantidad*a.costo)*(a.descuento/100)))*(a.iva/100)) AS tiva, ( (a.cantidad*a.costo)*(a.descuento/100)) AS tdescuento
                FROM partes_asignar_oc a, alta_productos b, sat_catalogo_unidades c, alta_marca d
                WHERE a.idparte=b.id
                AND b.idunidad=c.id
                AND b.idmarca = d.id
                AND a.identrada = ".$identrada."
                AND a.estatus = 0";*/

                $selectPart = "SELECT a.id, b.nparte AS clave,CONCAT_WS('/',b.nparte,b.descripcion) AS descrip,a.cantidad AS centrada,c.costo,c.descuento,c.iva,e.id AS idcot, f.abr AS unidad
                FROM partes_entrada a, alta_productos b, partes_asignar_oc c, partes_cotizacion d, alta_cotizacion e, sat_catalogo_unidades f
                WHERE a.idparte=b.id
                AND a.idparteoc=c.id
                AND a.idpartecot=d.id
                AND d.idcotizacion=e.id
                AND b.idunidad=f.id
                AND a.identrada =".$identrada ;

        $buscar3 = $db->sql_query($selectPart);

        $valory = $this->GetY();
        $valor_init = $this->GetY();


        $suma_subtotal = 0;
        $suma_iva = 0;
        $suma_descuento = 0;
        $suma_total = 0;

        $InterLigne = 5;

        while(  $row=$db->sql_fetchrow($buscar3)   ){


            ///********** COLOCAR DESCRIPCION
            $total_lineas = strlen( utf8_decode($row['clave']." - ".$row['descrip']) );
            $nlineas = ceil($total_lineas/62);
            $this->SetFont('Arial','',8);

            if ( $nlineas == 1 OR $nlineas == 2 ) {

                $this->SetY($valory+4);$this->SetX(52);$this->MultiCellx(85,$InterLigne,utf8_decode($row['clave']."\n".strtolower(utf8_encode($row['descrip'])) ),0,'J',0,0);
                
                //$this->SetY($valory+4);$this->SetX(64);$this->MultiCell(85,$nlineas+2,utf8_decode($row['clave']."\n".$row['descrip']), 1, 'L', 0);

            }else{

                //$this->SetY($valory+4);$this->SetX(64);$this->MultiCell(85,$nlineas,utf8_decode($row['clave']."\n".$row['descrip']), 1, 'L', 0);

                $this->SetY($valory+4);$this->SetX(52);$this->MultiCellx(85,$InterLigne,utf8_decode($row['clave']."\n".strtolower(utf8_encode($row['descrip'])) ),0,'J',0,0);

            }
          
            /////////************ VALOR DE "Y" DESPUES DE LA DESCRIPCION
            $last_y = $this->GetY();


           /////////************* COLOCAR LAS PARTIDAS RESTANTES A LA COTIZACION

            $this->SetY($valory+7);

            //$this->SetX(38);$this->Sety($valory+5);$this->MultiCell(25,2,"valory_img: ".$last_yimg." valor_descrip: ".$last_y, 0, 'R', 0);

            $this->SetFont('Arial','',8);

            $subtotal=$row['centrada']*$row['costo'];
           
            //$this->SetX(120);$this->MultiCell(20,0,$row['descuento'], 0, 'R', 0);
            $this->SetX(12);$this->MultiCell(20,0,$row['centrada'], 0, 'R', 0);
            $this->SetX(141);$this->MultiCell(27,0,wims_currency($row['costo']), 0, 'R', 0);
            $this->SetFont('Arial','B',8);
            $this->SetX(33);$this->MultiCell(15,0,$row['unidad'], 0, 'C', 0);
            $this->SetFont('Arial','B',9);
            $this->SetX(169);$this->MultiCell(29,0,wims_currency($subtotal), 0, 'R', 0);


            if ($last_yimg > $last_y ) {
               
                $valory = $last_yimg;

            }else{

                $valory = $last_y;

            }

            //////***** OBTENEMOS SUBTOTAL

            
            $tiva=round($subtotal,2)*($row['iva']/100);

            $suma_subtotal = $suma_subtotal+round($subtotal,2);
            $suma_iva = $suma_iva+round($tiva,2);
            $suma_descuento=0;//$suma_descuento+$row['tdescuento'];

            $descuentos = $suma_subtotal-$suma_descuento+$suma_iva;

            $suma_total=round($suma_total+$suma_subtotal+$suma_iva,2);
            
            
            if ($valory > 245) {

                $this->AddPage();

                $valory = $valor_init;

            }  



        }


        //////////////////////////////////////////////*********** FOOTER

        

        $this->SetDrawColor(0,0,0);
        $this->SetFillColor(255,255,255);
        $this->Rect(10, 240, 190, 40, 'DF');

        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(0, 0, 0);


        ///////******* SUBTOTAL

        $this->SetFont('Arial', '', 11);
        $this->SetY(247);
        $this->SetX(125);
        $this->MultiCell(30, 0, 'Subtotal', 0, 'R', 1); ///////importe con letra

       
        $this->SetY(255);
        $this->SetX(125);
        $this->MultiCell(30, 0, 'Descuento', 0, 'R', 1); ///////importe con letra

       
        $this->SetY(263);
        $this->SetX(125);
        $this->MultiCell(30, 0, 'Iva', 0, 'R', 1); ///////importe con letra


        $this->SetY(271);
        $this->SetX(125);
        $this->MultiCell(30, 0, 'Total', 0, 'R', 1); ///////importe con letra


        ////////// CALCULO 

        $total = $suma_subtotal-$suma_descuento+$suma_iva;
        /*$iva = $total-$suma_subtotal;*/
        
        $this->SetY(247);
        $this->SetX(145);
        $this->MultiCell(50, 0, wims_currency($suma_subtotal), 0, 'R', 0); ///////SUBTOTAL

        $this->SetTextColor(226, 16, 16);

        $this->SetY(255);
        $this->SetX(145);
        $this->MultiCell(50, 0, "- ".wims_currency($suma_descuento), 0, 'R', 0); ///////IVA

        $this->SetTextColor(0, 0, 0);
        $this->SetY(263);
        $this->SetX(145);
        $this->MultiCell(50, 0, wims_currency($suma_iva), 0, 'R', 0); ///////TOTAL

        $this->SetFont('Arial', 'B', 11);
        $this->SetY(271);
        $this->SetX(145);
        $this->MultiCell(50, 0, wims_currency($total), 0, 'R', 0); ///////TOTAL

        

        

        $this->SetX(17);

        $this->SetFont('Arial', 'B', 7);
        $this->SetY(242);
        $this->MultiCell(120, 5, "Observaciones: ".$observaciones,0, 'L', 0); ///////importe con letra

        $this->SetFont('Arial', 'B', 7);
        $this->SetY(272);

        $this->MultiCell(120, 3, letras2($total,$moneda), 0, 'L', 0); ///////importe con letra

        $this->SetFont('Arial', '', 7);
        $this->SetTextColor(27, 97, 218);
        $this->SetY(265);
        //$this->MultiCell(120, 3, utf8_decode("**Vigencia: 5 días o hasta agotar existencias / Precios, existencias y Promociones sujetas a cambio sin previo aviso."), 0, 'L', 0); ///////importe con letra

        ////////************** AVCTUALIZAR LOS IMPORTES DE LA ODC

        //$sql_upt="UPDATE alta_oc SET subtotal='".$suma_subtotal."', descuento='".$suma_descuento."', iva='".$suma_iva."', total='".$total."' WHERE id=".$identrada;
        //$db->sql_query($sql_upt);

        

    }       

}


$pdf = new PDF();

include("config.php"); 
include("includes/mysqli.php");
include("includes/db.php");
set_time_limit (600000);
date_default_timezone_set('America/Mexico_City');

$identrada =trim($_POST["identrada"]);

$query = "SELECT a.fecha,a.estatus,c.nombre as proveedor,a.idoc,a.observaciones,CONCAT_WS('/',a.id,a.estatus) AS acciones, d.nombre AS recibio,c.rfc,e.moneda
                      FROM alta_entrada a, alta_oc b, alta_proveedores c, alta_usuarios d, alta_moneda e
                      WHERE
                      a.idoc=b.id
                      AND b.idpro=c.id
                      AND a.idusuario=d.id
                      AND b.moneda=e.id
                      AND a.id=".$identrada;

$buscar = $db->sql_query($query);
$row2 = $db->sql_fetchrow($buscar);
    
$fecha = obtenerFechaEnLetra($row2["fecha"]);
$estatus = utf8_decode($row2["estatus"]);
$proveedor = utf8_decode($row2["proveedor"]);
$idoc =$row2["idoc"];
$observaciones = utf8_decode($row2["observaciones"]);
$recibio = utf8_decode($row2["recibio"]);
$moneda = $row2["moneda"];
$rfc=$row2["rfc"];

$folio = 0;
switch ( strlen($identrada) ) {

    case 1:
        
        $folio = "000000".$identrada;

    break;

    case 2:
        
        $folio = "00000".$identrada;

    break;

    case 3:
        
        $folio = "0000".$identrada;

    break;

    case 4:
        
        $folio = "000".$identrada;

    break;

    case 5:
        
        $folio = "00".$identrada;

    break;

    case 6:
        
        $folio = "0".$identrada;

    break;

    case 7:
        
        $folio = $identrada;

    break;

}

$pdf->GeneraContenido(

    $identrada,
    $folio,
    $fecha,
    $dias,
    $moneda,
    $rfc,
    $proveedor,
    $recibio,
    $observaciones

);

$nombrearchivo = "entradas/entrada".$identrada.".pdf";
$pdf->Output($nombrearchivo, 'F');
//$pdf->Output();

echo json_encode($identrada);


?>