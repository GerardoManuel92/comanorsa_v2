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
    $mes = array('Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    return $num.'-'.$mes.'-'.$anno;
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

        global $idfact;
        global $fecha;
        global $observaciones;
        global $cliente;
        global $comercial;
        global $vendedor;
        global $folio;
        global $direccion;
        global $fpago;
        global $telefonos;
        global $correo;
        global $rfc;
        global $infocomercial;
        global $inforfc;
        global $inforazon_social;
        global $infodireccion;
        global $moneda;
        global $tcambio;
        global $regimen_fiscal;
        global $mpago;
        global $cfdi;
        global $noCertificadox;
        global $UUID;
        global $noCertificadoSAT;
        global $FechaTimbrado;
        global $selloCFD;
        global $selloSAT;
        global $cadena;
        global $subtotal;
        global $iva;
        global $total;

        ///////***************** ENCABEZADO

        $this->SetDrawColor(250,250,250);
        $this->SetFillColor(243,243,243);
        $this->Rect(10, 11, 190, 30, 'DF');

        $this->Image("logo_icono.png",14,14,21,18,"PNG","http://comanorsa.com/");

        $this->SetFont('Arial','',11);

        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0,0,0);
        $this->SetY(15);$this->SetX(40); $this->MultiCell(85,1,$infocomercial,0,'C',0);///////TITULO


        $this->SetFont('Arial','B',7);
        $this->SetY(21);$this->SetX(40); $this->MultiCell(85,1,$inforazon_social." ".$inforfc,0,'C',0);///////TITULO

        $this->SetFont('Arial','',7);

        $this->SetY(24);$this->SetX(40); $this->MultiCell(85,3,utf8_decode($infodireccion),0,'C',0);///////TITULO

        $this->SetY(32);$this->SetX(40); $this->MultiCell(85,3,utf8_decode($regimen_fiscal),0,'C',0);///////TITULO



        $this->SetFont('Arial','B',10);

        $this->SetY(21);$this->SetX(128); $this->MultiCell(30,1,utf8_decode("Folio:"),0,'L',0);///////
        
        $this->SetFont('Arial','',8);

        $this->SetY(34);$this->SetX(128); $this->MultiCell(30,1,utf8_decode("Fecha y hora:"),0,'L',0);///////
        $this->SetY(34);$this->SetX(150); $this->MultiCell(50,1,obtenerFechaEnLetra( date('Y-m-d') )." | ".date('H:i')." hrs",0,'R',0);///////
        $this->SetY(38);$this->SetX(128); $this->MultiCell(30,1,utf8_decode("Moneda:"),0,'L',0);///////
        

        //////////******************** MONEDA Y TIPO DE CAMBIO 
        switch ($moneda) {

            case 1:
                
                $infomoneda = "Pesos";

                $this->SetY(38);$this->SetX(150); $this->MultiCell(50,1,$infomoneda,0,'R',0);//////

            break;
            
            case 2:
                
                $infomoneda = "Dolares";

                $this->SetY(38);$this->SetX(150); $this->MultiCell(20,1,$infomoneda,0,'L',1);//////

                $this->SetY(38);$this->SetX(170); $this->MultiCell(20,1,"T.C.: ".$tcambio,0,'R',1);//////

            break;
        }

        $this->SetFont('Arial','B',10);
        $this->SetY(21);$this->SetX(140); $this->MultiCell(20,1,$folio,0,'R',0);///////

        $this->SetFont('Arial','B',10);
        $this->SetY(21);$this->SetX(170); $this->MultiCell(30,1,"Tipo: Egreso",0,'R',0);///////
        $this->SetFont('Arial','',8);
        $this->SetY(26);$this->SetX(128); $this->MultiCell(80,1,utf8_decode("Folio fiscal: ".$UUID),0,'L',0);///////
        $this->SetY(30);$this->SetX(128); $this->MultiCell(80,1,utf8_decode("No.Serie CSD: ".$noCertificadox),0,'L',0);///////

        $this->SetFont('Arial','B',12);

        ////////////// INFORMACION DE LA RQ

        $this->SetDrawColor(250,250,250);
        $this->SetFillColor(243,243,243);
        $this->Rect(10, 42, 190, 20, 'DF');

        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0,0,0);

        $this->SetY(45);$this->SetX(14); $this->MultiCell(9,2,"RFC: ",0,'L',0);///////TITULO
        $this->SetY(51);$this->SetX(14); $this->MultiCell(150,0,"Domicilio:",0,'L',0);///////TITULO
        $this->SetY(45);$this->SetX(55); $this->MultiCell(15,2,"Cliente:",0,'L',0);///////TITULO

        $this->SetY(56);$this->SetX(14); $this->MultiCell(25,2,"Forma de pago: ",0,'L',0);///////TITULO
        $this->SetY(56);$this->SetX(75); $this->MultiCell(25,2,"Metodo de pago: ",0,'L',0);///////TITULO
        $this->SetY(56);$this->SetX(145); $this->MultiCell(18,2,"Uso CFDI: ",0,'L',0);///////TITULO

        /*$this->SetY(64);$this->SetX(50); $this->MultiCell(140,0,"Entregar a:".,0,'R',0);///////TITULO*/

        $this->SetFont('Arial','',8);
        $this->SetY(45);$this->SetX(22); $this->MultiCell(30,2,$rfc,0,'L',0);///////TITULO
        $this->SetY(50);$this->SetX(28); $this->MultiCell(170,2,strtolower( $direccion ),0,'L',0);///////TITULO
        $this->SetY(45);$this->SetX(66); $this->MultiCell(110,2,strtolower($cliente.' | '.$comercial ),0,'L',0);///////TITULO

        $this->SetY(56);$this->SetX(36); $this->MultiCell(40,2,$fpago,0,'L',0);///////TITULO
        $this->SetY(56);$this->SetX(160); $this->MultiCell(39,3,$cfdi,0,'L',0);///////TITULO
        $this->SetY(56);$this->SetX(98); $this->MultiCell(45,2,utf8_decode($mpago),0,'L',0);///////TITULO


        $this->SetDrawColor(134,187,224);
        $this->SetFillColor(134,187,224);
        $this->Rect(128, 11, 72, 6, 'DF');

        $this->SetFont('Arial','B',11);

        $this->SetTextColor(255, 255, 255);
        $this->SetDrawColor(0,0,0);
        $this->SetY(14);$this->SetX(128); $this->MultiCell(72,1,utf8_decode("NOTA DE CREDITO"),0,'C',0);///////TITULO

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
        $this->Rect(10, 63, 190, 5, 'DF');

        $this->SetFont('Arial', 'B', 8);
        $this->SetTextColor(255, 255, 255);

        $this->SetY(65.2);
        $this->SetX(12);
        $this->MultiCell(25, 0, 'IMAGEN',0,'R',1); ///////importe con letra

        $this->SetY(65.2);
        $this->SetX(38);
        $this->MultiCell(25, 0, 'CANTIDAD', 0, 'C', 1); ///////importe con letra

        $this->SetY(65.2);
        $this->SetX(64);
        $this->MultiCell(55, 0, 'DECRIPCION', 0, 'L', 1); ///////importe con letra

        $this->SetY(65.2);
        $this->SetX(141);
        $this->MultiCell(27, 0, 'UNITARIO', 0, 'R', 1); ///////importe con letra

        $this->SetY(65.2);
        $this->SetX(169);
        $this->MultiCell(29, 0, 'IMPORTE', 0, 'R', 1); ///////importe con letra


        $this->SetTextColor(0,0,0);
        
        $this->SetFont('Arial','',6);
        $this->SetY(66);



    }
    function Footer(){
        $this->SetY(2);
        $this->SetX(167);
        $this->SetFont('Arial','B',9);
        $this->SetTextColor(0,0,0);
        $this->Cell(30,10,'Hoja '.$this->PageNo().' de {nb}',0,0,'C');
    }

    public function GeneraContenido(  

         $idfact,
        $fecha,
        $observaciones,
        $cliente,
        $comercial,
        $vendedor,
        $folio,
        $direccion,
        $fpago,
        $telefonos,
        $correo,
        $rfc,
        $infocomercial,
        $inforfc,
        $inforazon_social,
        $infodireccion,
        $moneda,
        $tcambio,
        $regimen_fiscal,
        $mpago,
        $cfdi,
        $noCertificadox,
        $UUID,
        $noCertificadoSAT,
        $FechaTimbrado,
        $selloCFD,
        $selloSAT,
        $cadena,
        $idcotizacion,
        $subtotal,
        $iva,
        $total

    ){

        $this->AliasNbPages();
        $this->AddPage();
        $this->SetDrawColor(150, 25, 0);
        $this->SetFillColor(150, 25, 0);
        $this->SetLineWidth(0.3);

        /*include("config.php"); 
        include("includes/mysqli.php");
        include("includes/db.php");
        set_time_limit(600000);
        date_default_timezone_set('America/Mexico_City');


        $selectPart = "SELECT b.nparte, CONCAT_WS(' ',b.clave,a.descripcion,c.marca) AS descrip, d.abr AS unidad, e.costo, e.iva,e.descuento,
        (a.cantidad*e.costo) AS subtotal,a.cantidad,( ((a.cantidad*e.costo)- ((a.cantidad*e.costo)*(e.descuento/100)))*(e.iva/100)) AS tiva, 
        ( (a.cantidad*e.costo)*(e.descuento/100)) AS tdescuento,b.id AS idparte
        FROM
        partes_ncredito a, alta_productos b, alta_marca c, sat_catalogo_unidades d, partes_cotizacion e, partes_factura f
        WHERE 
        a.idpartefact=f.id
        AND f.idpartecot=e.id
        AND e.idparte = b.id
        AND b.idmarca=c.id
        AND b.idunidad=d.id
        AND a.idnota =".$idfact."
        AND a.estatus = 0";

        $buscar3 = $db->sql_query($selectPart);*/

        $valory = $this->GetY();
        $valor_init = $this->GetY();


        /*$suma_subtotal = 0;
        $suma_iva = 0;
        $suma_descuento = 0;
        $suma_total = 0;*/

        $InterLigne = 5;

        //while(  $row=$db->sql_fetchrow($buscar3)   ){


            

            $this->SetY($valory+4);
            $this->SetX(64);
            $this->MultiCell(85,$InterLigne,utf8_decode("BONIFICACION DE SERVICIOS"),0,'J',0,0);
                
               
            /////////************ VALOR DE "Y" DESPUES DE LA DESCRIPCION
            $last_y = $this->GetY();

            $nombre_fichero  = "../../comanorsa/productos/".$row["idparte"].".jpg";

            ////************ COLOCAR IMAGEN 
            if ( file_exists($nombre_fichero) ) {

                $this->Image($nombre_fichero,9,$valory+3,30,25,"JPG","http://comanorsa.com/");

            } else {

                $this->Image("no_disponible.jpg",9,$valory+3,30,25,"JPG","http://comanorsa.com/");

                
            }

           /////////********* VALOR DE "Y" DE LA IMAGEN 
           $last_yimg = $valory+25;



           /////////************* COLOCAR LAS PARTIDAS RESTANTES A LA COTIZACION

            $this->SetY($valory+7);

            //$this->SetX(38);$this->Sety($valory+5);$this->MultiCell(25,2,"valory_img: ".$last_yimg." valor_descrip: ".$last_y, 0, 'R', 0);

            $this->SetFont('Arial','',8);
           
            //$this->SetX(120);$this->MultiCell(20,0,$row['descuento'], 0, 'R', 0);
            $this->SetX(141);$this->MultiCell(27,0,wims_currency($subtotal), 0, 'R', 0);
            $this->SetFont('Arial','B',8);
            $this->SetX(35);$this->MultiCell(25,0,"1 ACT", 0, 'R', 0);
            $this->SetFont('Arial','B',9);
            $this->SetX(169);$this->MultiCell(29,0,wims_currency($subtotal), 0, 'R', 0);


            if ($last_yimg > $last_y ) {
               
                $valory = $last_yimg;

            }else{

                $valory = $last_y;

            }

            
            
            if ($valory > 218) {

                $this->AddPage();

                $valory = $valor_init;

            }


        //}


        //////////////////////////////////////////////*********** FOOTER

        

        /*$this->SetDrawColor(0,0,0);
        $this->SetFillColor(255,255,255);
        $this->Rect(10, 240, 190, 40, 'DF');*/

        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(0, 0, 0);


        ///////******* SUBTOTAL

        $this->SetFont('Arial', '', 11);
        $this->SetY(225);
        $this->SetX(132);
        $this->MultiCell(30, 0, 'Subtotal', 0, 'R', 0); ///////importe con letra

       
        $this->SetY(233);
        $this->SetX(132);
        $this->MultiCell(30, 0, 'Descuento', 0, 'R', 0); ///////importe con letra

       
        $this->SetY(241);
        $this->SetX(132);
        $this->MultiCell(30, 0, 'Iva', 0, 'R', 0); ///////importe con letra


        $this->SetY(249);
        $this->SetX(132);
        $this->MultiCell(30, 0, 'Total', 0, 'R', 0); ///////importe con letra


       
        
        $this->SetY(225);
        $this->SetX(147);
        $this->MultiCell(50, 0, wims_currency($subtotal), 0, 'R', 0); ///////SUBTOTAL

        $this->SetTextColor(226, 16, 16);

        $this->SetY(233);
        $this->SetX(147);
        $this->MultiCell(50, 0, "- ".wims_currency(0), 0, 'R', 0); ///////IVA

        $this->SetTextColor(0, 0, 0);
        $this->SetY(241);
        $this->SetX(147);
        $this->MultiCell(50, 0, wims_currency($iva), 0, 'R', 0); ///////TOTAL

        $this->SetFont('Arial', 'B', 11);
        $this->SetY(249);
        $this->SetX(147);
        $this->MultiCell(50, 0, wims_currency($total), 0, 'R', 0); ///////TOTAL

        

        

        $this->SetX(17);

        $this->SetFont('Arial', 'B', 7);
        $this->SetY(220);

       

        //codigo qr factura
        $targetDir = 'factura_qr/codigo1.jpg';////seleccioanr el numero ya que estoy en la espera de la respuesta de facturalo para obtenerr el qr
        $this->Image($targetDir, 10, 220, 17);

        //$this->SetY(242);
        $this->SetX(28);$this->MultiCell(110,0,"Cadena original del complemento de certificacion del SAT",0,'L',0);

        $this->SetFont('Arial', '', 6);

        $this->SetY(223);
        $this->SetX(28);$this->MultiCell(110, 3,$cadena,0, 'L', 0); ///////importe con letra


        $this->SetFont('Arial', 'B', 7);
        $this->SetY(242);
        $this->SetX(10);$this->MultiCell(120,0,"Sello digital del EMISOR",0,'L',0);
        $this->SetFont('Arial', '', 6);
        $this->SetY(245);
        $this->SetX(10);$this->MultiCell(127, 3, $selloCFD,0, 'L', 0); ///////importe con letra


        $this->SetFont('Arial', 'B', 7);
        $this->SetY(260);
        $this->SetX(10);$this->MultiCell(120,0,"Sello digital del SAT",0,'L',0);
        $this->SetFont('Arial', '', 6);
        $this->SetY(263);
        $this->SetX(10);$this->MultiCell(188, 3,$selloSAT,0, 'L', 0); 


        $this->SetFont('Arial', 'B', 7);
        //$this->SetY(252);

        //////////******************** MONEDA Y TIPO DE CAMBIO 
        switch ($moneda) {

            case 1:
                
                $infomoneda = "PESOS";

            break;
            
            case 2:
                
                $infomoneda = "DOLARES";

            break;
        }



    }       

}


$pdf = new PDF();

include("config.php"); 
include("includes/mysqli.php");
include("includes/db.php");
set_time_limit (600000);
date_default_timezone_set('America/Mexico_City');

$idfact =trim($_POST["idfactura"]);//nota de credito

/*$query = 'SELECT x.ftimbrado,x.ftimbrado,x.htimbrado,x.moneda,x.tcambio,x.cadena,x.dias,x.idcotizacion,
a.fcotizacion, a.observaciones, b.nombre AS cliente, b.comercial, c.nombre AS vendedor,
CONCAT_WS(",",b.calle,b.colonia,b.exterior,b.interior,b.municipio,b.estado,b.cp) AS direccion, 
CONCAT_WS(" / ",b.telefono,b.celular) AS telefonos,b.correo,
d.descripcion AS fpago,b.rfc,
e.descripcion AS mpago,f.descripcion AS cfdi, CONCAT_WS("",g.serie,g.folio) AS folfactura
FROM alta_factura x,alta_cotizacion a, alta_clientes b, alta_usuarios c, sat_catalogo_fpago d, sat_catalogo_cfdi f, folio_factura g
WHERE
x.idcotizacion=a.id
AND a.idcliente=b.id
AND a.idusuario=c.id
AND x.idfpago=d.id
AND x.idmpago=e.id
AND x.idcfdi=f.id
AND x.idfolio=g.id
AND x.id ='.$idfact;*/

$query ='SELECT a.ftimbrado,a.htimbrado,b.moneda,b.tcambio,a.observaciones,c.nombre AS cliente, c.comercial, d.nombre AS vendedor,
i.calle,i.exterior,i.colonia,i.interior,i.municipio,i.estado,i.cp,
CONCAT_WS(" / ",c.telefono,c.celular) AS telefonos,c.correo,
e.descripcion AS fpago,c.rfc,
CONCAT_WS("",h.serie,h.folio) AS folfactura,a.subtotal,a.iva,a.total
FROM alta_nota_credito a, alta_factura b, alta_clientes c,alta_usuarios d, sat_catalogo_fpago e, folio_nota_credito h, direccion_clientes i
WHERE 
a.idfactura=b.id
AND b.idcliente=c.id
AND b.idusuario=d.id
AND a.fpago=e.id
AND a.idfolio=h.id
AND i.idcliente=c.id
AND a.id = '.$idfact;

$buscar = $db->sql_query($query);
$row2 = $db->sql_fetchrow($buscar);
    
$fecha = obtenerFechaEnLetra($row2["ftimbrado"])."".$row2["htimbrado"];
$observaciones = utf8_decode($row2["observaciones"]);
$cliente = utf8_decode($row2["cliente"]);
$comercial = utf8_decode($row2["comercial"]);
$vendedor = utf8_decode($row2["vendedor"]);
//$direccion = utf8_decode($row2["direccion"]);

$calle = utf8_decode( utf8_encode($row2["calle"]) );
$exterior = utf8_decode( utf8_encode($row2["exterior"]) );
$colonia = utf8_decode( utf8_encode($row2["colonia"]) );
$interior = utf8_decode( utf8_encode($row2["interior"]) );
$municipio = utf8_decode( utf8_encode($row2["municipio"]) );
$estado = utf8_decode( utf8_encode($row2["estado"]) );
$cp = utf8_decode( utf8_encode($row2["cp"]) );

$direccion.=$calle;

if ( $exterior != "" ) {
    
    $direccion.=" ".$exterior;
}

if ( $interior != "" ) {
    
    $direccion.=" Int.".$interior;
}

if ( $colonia != "" ) {
    
    $direccion.=" ".$colonia;

}

if ( $municipio != "" ) {
    
    $direccion.=" ".$municipio;

}

if ( $estado != "" ) {
    
    $direccion.=" ".$estado;

}

if ( $cp != "" ) {
    
    $direccion.=" Cp.".$cp;

}


$fpago = utf8_decode($row2["fpago"]);
$mpago = "PUE";
$cfdi = "G02";
$telefonos =$row2["telefonos"];
$correo =$row2["correo"];
$rfc =$row2["rfc"];
$moneda = $row2["moneda"];
$tcambio = $row2["tcambio"];
$folio = $row2["folfactura"];
$subtotal=$row2["subtotal"];
$iva=$row2["iva"];
$total=$row2["total"];
//$cadena = $row2["cadena"];
$idcotizacion = "";
/////////////***************** DATOS GENERALES 

$sql_info = "SELECT comercial,rfc,razon_social,direccion,regimen,regimen_info FROM `datos_generales` WHERE estatus = 0";
$buscar_info = $db->sql_query($sql_info);
$row_info = $db->sql_fetchrow($buscar_info);

$infocomercial = utf8_decode($row_info["comercial"]);
$inforfc = utf8_decode($row_info["rfc"]);
$inforazon_social = utf8_decode($row_info["razon_social"]);
$infodireccion = utf8_encode($row_info["direccion"]);
$regimen_fiscal = utf8_decode($row_info["regimen"]."-".$row_info["regimen_info"]);

////////////********************* EXTRACCION DE DATOS DEL COMPROBANTE TIMBRADO

$xml = simplexml_load_file('factura_comprobante_nc/'.$folio.'.xml');
foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante) {
    $atributos      = $cfdiComprobante->attributes();
    $noCertificadox = $atributos['NoCertificado'];
    $fechax = $atributos['Fecha'];
}
//////***************
$dom = new DOMDocument('1.0', 'utf-8'); // Creamos el Objeto DOM
$dom->load('factura_comprobante_nc/'.$folio.'.xml'); // Definimos la ruta de nuestro XML
// Recorremos el XML Tag por Tag para encontrar los elementos buscados
// Obtenemos el Machote(Estructura) del XML desde la web de SAT
foreach ($dom->getElementsByTagNameNS('http://www.sat.gob.mx/TimbreFiscalDigital', '*') as $elemento) {
    $UUID             = $elemento->getAttribute('UUID');
    $noCertificadoSAT = $elemento->getAttribute('NoCertificadoSAT');
    $FechaTimbrado    = $elemento->getAttribute('FechaTimbrado');
    $selloCFD         = $elemento->getAttribute('SelloCFD');
    $selloSAT         = $elemento->getAttribute('SelloSAT');
    $version          = $elemento->getAttribute('Version');
    $rfc_proveedor    = $elemento->getAttribute('RfcProvCertif');
    // etc...
}

$cadena = '||'.$version.'|'.$UUID.'|'.$fechax.'|'.$rfc_proveedor.'|'.$selloCFD.'|'.$noCertificadoSAT.'||';

$sqlupt = "UPDATE alta_nota_credito SET cadena='".$cadena."', uuid='".$UUID."' WHERE id=".$idfact;
$db->sql_query($sqlupt);

$pdf->GeneraContenido(

    $idfact,
    $fecha,
    $observaciones,
    $cliente,
    $comercial,
    $vendedor,
    $folio,
    $direccion,
    $fpago,
    $telefonos,
    $correo,
    $rfc,
    $infocomercial,
    $inforfc,
    $inforazon_social,
    $infodireccion,
    $moneda,
    $tcambio,
    $regimen_fiscal,
    $mpago,
    $cfdi,
    $noCertificadox,
    $UUID,
    $noCertificadoSAT,
    $FechaTimbrado,
    $selloCFD,
    $selloSAT,
    $cadena,
    $idcotizacion,
    $subtotal,
    $iva,
    $total

);

$nombrearchivo = "facturas_nc/".$folio.".pdf";
$pdf->Output($nombrearchivo, 'F');
//$pdf->Output();

echo json_encode($folio);


?>