<?php

/******************************************************
 * FATURACION ELECTRONICA CFDI V4.0                   *
 * ENERO 2021                                         *
 * http://www.webalamedida.com.mx                     *
 * by Alejandro Monzon Cortes                         *
 ******************************************************/

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

function changeString($string){
         
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

function dias_hasta_fin_mes(){

    //$total_mes = cal_days_in_month(CAL_GREGORIAN, date("Y"), date("Y"));

    $total_mes == 2 ? (date("Y") % 4 ? 28 : (date("Y") % 100 ? 29 : (date("Y") % 400 ? 28 : 29))) : ((date("Y") - 1) % 7 % 2 ? 30 : 31);

    $transcurrido = date("d");

    return date("t") - $transcurrido;

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
        global $rutaImagenSalida;
        global $regimen_info;
        global $cp;
        global $obs_factura;
        global $no_odc;
        global $fechax;

        ///////***************** ENCABEZADO

        $this->SetDrawColor(250,250,250);
        $this->SetFillColor(243,243,243);
        $this->Rect(10, 11, 190, 25, 'DF');

        $this->Image("logo_icono.png",14,14,21,18,"PNG","http://comanorsa.com/");

        $this->SetFont('Arial','',11);

        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0,0,0);
        $this->SetY(15);$this->SetX(40); $this->MultiCell(85,1,$infocomercial,0,'C',0);///////TITULO


        $this->SetFont('Arial','B',7);
        $this->SetY(21);$this->SetX(40); $this->MultiCell(85,1,$inforazon_social." ".$inforfc,0,'L',0);///////TITULO

        $this->SetFont('Arial','',7);

        $this->SetY(24);$this->SetX(40); $this->MultiCell(85,3,utf8_decode($infodireccion),0,'L',0);///////TITULO

        $this->SetY(31);$this->SetX(40); $this->MultiCell(85,3,utf8_decode("Regimen fiscal: ".$regimen_fiscal." - ".$regimen_info),0,'L',0);///////TITULO


        $this->SetDrawColor(134,187,224);
        $this->SetFillColor(134,187,224);
        $this->Rect(130, 11, 70, 6, 'DF');

        $this->SetFont('Arial','B',11);

        $this->SetTextColor(255, 255, 255);
        $this->SetDrawColor(0,0,0);
        $this->SetY(15);$this->SetX(130); $this->MultiCell(70,1,utf8_decode("FACTURA"),0,'C',0);///////TITUL


        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0, 0, 0);

        $this->SetY(21);$this->SetX(130); $this->MultiCell(30,1,utf8_decode("Folio:"),0,'L',0);///////
        $this->SetY(21);$this->SetX(170); $this->MultiCell(30,1,"Tipo: Ingreso",0,'R',0);///////
        $this->SetY(29);$this->SetX(130); $this->MultiCell(30,1,utf8_decode("Moneda:"),0,'L',0);///////
        $this->SetY(29);$this->SetX(160); $this->MultiCell(35,1,utf8_decode("Lugar de expedicion:"),0,'L',0);///////
        $this->SetY(25);$this->SetX(130); $this->MultiCell(30,1,utf8_decode("Fecha y hora:"),0,'L',0);///////
        //$this->SetY(25);$this->SetX(150); $this->MultiCell(50,1,obtenerFechaEnLetra( date('Y-m-d') )." | ".date('H:i')." hrs",0,'R',0);///////
        $this->SetY(25);$this->SetX(150); $this->MultiCell(50,1,$fechax." hrs",0,'R',0);
        
        $this->SetY(33);$this->SetX(130); $this->MultiCell(30,1,utf8_decode("Orden de compra:"),0,'L',0);///////

        //////////******************** MONEDA Y TIPO DE CAMBIO 
        switch ($moneda) {

            case 1:
                
                $infomoneda = "Pesos";

                $this->SetY(29);$this->SetX(103); $this->MultiCell(50,1,$infomoneda,0,'R',0);//////

            break;
            
            case 2:
                
                $infomoneda = "Dolares";

                $this->SetY(29);$this->SetX(103); $this->MultiCell(20,1,$infomoneda,0,'L',1);//////

                $this->SetY(29);$this->SetX(170); $this->MultiCell(20,1,"T.C.: ".$tcambio,0,'R',1);//////

            break;
        }

        $this->SetFont('Arial','B',10);
        $this->SetY(21);$this->SetX(140); $this->MultiCell(20,1,$folio,0,'R',0);///////
        $this->SetFont('Arial','B',8);
        $this->SetY(29);$this->SetX(150); $this->MultiCell(50,1,$cp,0,'R',0);////// LUGAR EXPEDICION

        $this->SetY(33);$this->SetX(160.5); $this->MultiCell(40,1,$no_odc,0,'R',0);////// LUGAR EXPEDICION

        $this->SetFont('Arial','B',12);



        ////////////// INFORMACION DE LA RQ

        $this->SetDrawColor(250,250,250);
        $this->SetFillColor(243,243,243);
        $this->Rect(10, 37, 190, 23, 'DF');

        $this->SetFont('Arial','B',7);
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0,0,0);

        $this->SetY(41);$this->SetX(14); $this->MultiCell(9,2,"RFC: ",0,'L',0);///////TITULO
        $this->SetY(47);$this->SetX(14); $this->MultiCell(150,0,"Domicilio:",0,'L',0);///////TITULO
        $this->SetY(41);$this->SetX(50); $this->MultiCell(15,2,"Cliente:",0,'L',0);///////TITULO

        $this->SetY(51);$this->SetX(14); $this->MultiCell(18,2,"Uso CFDI: ",0,'L',0);///////TITULO

        $this->SetY(56);$this->SetX(14); $this->MultiCell(25,2,"Forma de pago: ",0,'L',0);///////TITULO
        $this->SetY(56);$this->SetX(95); $this->MultiCell(25,2,"Metodo de pago: ",0,'L',0);///////TITULO
        
      

        $this->SetFont('Arial','',7);
        $this->SetY(41);$this->SetX(22); $this->MultiCell(30,2,strtoupper($rfc),0,'L',0);///////TITULO
        $this->SetY(46);$this->SetX(28); $this->MultiCell(170,2,strtoupper( $direccion ),0,'L',0);///////TITULO
        $this->SetY(41);$this->SetX(61); $this->MultiCell(130,2,strtoupper( utf8_decode($cliente) ),0,'L',0);///////TITULO

        $this->SetY(50);$this->SetX(29); $this->MultiCell(39,3,$cfdi,0,'L',0);///////TITULO
        $this->SetY(56);$this->SetX(36); $this->MultiCell(40,2,$fpago,0,'L',0);///////TITULO        
        $this->SetY(56);$this->SetX(118); $this->MultiCell(60,2,utf8_decode($mpago),0,'L',0);///////TITULO
        //$this->SetY(52);$this->SetX(105); $this->MultiCell(88,2,utf8_decode("Pago en una sola exhibición"),0,'L',0);///////TITULO

        
        /////################ TITULOS DE LA TABLA ##################################

        $this->SetDrawColor(134,187,224);
        $this->SetFillColor(134,187,224);
        $this->Rect(10, 61, 190, 5, 'DF');

        $this->SetFont('Arial', 'B', 8);
        $this->SetTextColor(255, 255, 255);

        $this->SetY(64.2);
        $this->SetX(12);
        $this->MultiCell(25, 0, 'IMAGEN',0,'R',1); ///////importe con letra

        $this->SetY(64.2);
        $this->SetX(38);
        $this->MultiCell(25, 0, 'CANTIDAD', 0, 'C', 1); ///////importe con letra

        $this->SetY(64.2);
        $this->SetX(64);
        $this->MultiCell(55, 0, 'DECRIPCION', 0, 'L', 1); ///////importe con letra

        $this->SetY(64.2);
        $this->SetX(141);
        $this->MultiCell(27, 0, 'UNITARIO', 0, 'R', 1); ///////importe con letra

        $this->SetY(64.2);
        $this->SetX(169);
        $this->MultiCell(29, 0, 'IMPORTE', 0, 'R', 1); ///////importe con letra

        

        /*$this->SetY(200);
        $this->SetX(10);
        $this->MultiCell(180, 0, '************************************************************************************************************', 0, 'R', 1); *////////importe con letra



        $this->SetTextColor(0,0,0);
        
        $this->SetFont('Arial','',6);
        $this->SetY(65);



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
        $regimen_info,
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
        $rutaImagenSalida,
        $cp,
        $obs_factura,
        $no_odc,
        $fechax

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

        $selectPart = "SELECT a.id,b.nparte AS clave, CONCAT_WS(' ',b.clave,a.descripcion,d.marca) AS descrip, c.abr AS unidad, a.costo, a.iva,a.descuento,(e.cantidad*a.costo) AS subtotal,e.cantidad,a.idparte,
            ROUND( ( ((e.cantidad*a.costo)- ((e.cantidad*a.costo)*(a.descuento/100)))*(a.iva/100)),2 ) AS tiva, 
            ROUND( ( (e.cantidad*a.costo)*(a.descuento/100)),2 ) AS tdescuento,
            d.marca AS marcax,img
                FROM partes_factura e,partes_cotizacion a, alta_productos b, sat_catalogo_unidades c, alta_marca d
                WHERE
                e.idpartecot=a.id 
                AND a.idparte=b.id
                AND b.idunidad=c.id
                AND b.idmarca = d.id
                AND e.idfactura = ".$idfact."
                AND e.estatus = 0
                ORDER BY a.orden ASC";  




        /*$selectPart = "SELECT a.id,b.nparte AS clave, CONCAT_WS(' ',b.clave,a.descripcion,d.marca) AS descrip, c.abr AS unidad, a.costo, a.iva,a.descuento,(a.cantidad*a.costo) AS subtotal,a.cantidad,a.idparte,( ((a.cantidad*a.costo)- ((a.cantidad*a.costo)*(a.descuento/100)))*(a.iva/100)) AS tiva, ( (a.cantidad*a.costo)*(a.descuento/100)) AS tdescuento
                FROM partes_cotizacion a, alta_productos b, sat_catalogo_unidades c, alta_marca d
                WHERE a.idparte=b.id
                AND b.idunidad=c.id
                AND b.idmarca = d.id
                AND a.idcotizacion = ".$idcotizacion."
                AND a.estatus = 0";*/

        $buscar3 = $db->sql_query($selectPart);

        $valory = $this->GetY();
        $valor_init = $this->GetY();

        $suma_subtotal = 0;
        $suma_iva = 0;
        $suma_descuento = 0;
        $suma_total = 0;

        $InterLigne = 5;

        $valor_incremento = 0;

        while(  $row=$db->sql_fetchrow($buscar3)   ){


            ///********** COLOCAR DESCRIPCION
            $total_lineas = strlen( utf8_decode( strtoupper($row['descrip']) ) );
            $nlineas = ceil($total_lineas/48)*5;
            $this->SetFont('Arial','',6);

            /*if ( $nlineas == 1 OR $nlineas == 2 ) {

                //$this->SetY($valory+4);$this->SetX(64);$this->MultiCell(85,$InterLigne,utf8_decode("No.PARTE: ".$row['clave']."\n"."MARCA: ".$row['marcax']."\n".strtoupper($row['descrip'])." STR: ".$total_lineas ),0,'J',0,0);

                $this->SetY($valory+4);$this->SetX(64);$this->MultiCell(85,$InterLigne,utf8_decode("No.PARTE: ".$this->GetY()."\n"."MARCA: ".$row['marcax']."\n".strtoupper($row['descrip'])." STR: ".$total_lineas ),0,'J',0,0);

            }else{

                //$this->SetY($valory+4);$this->SetX(64);$this->MultiCell(85,$nlineas,utf8_decode($row['clave']."\n".$row['descrip']), 1, 'L', 0);

                $this->SetY($valory+4);$this->SetX(64);$this->MultiCell(85,$InterLigne,utf8_decode("No.PARTE: ".$row['clave']."\n"."MARCA: ".$row['marcax']."\n".strtoupper($row['descrip'])." STR: ".$total_lineas ),0,'J',0,0);

            }*/


          
            /////////************ VALOR DE "Y" DESPUES DE LA DESCRIPCION
            $last_y = $valory+4+$nlineas+10; //$this->GetY();

            

           /////////********* VALOR DE "Y" DE LA IMAGEN 
           $last_yimg = $valory+25;



           
            $this->SetTextColor(0, 0, 0);

            if ($last_yimg > $last_y ) {
               
                //$valory = $last_yimg;
                $valor_incremento = $last_yimg;

            }else{

                //$valory = $last_y;
                $valor_incremento = $last_y;

            }

            //////***** OBTENEMOS SUBTOTAL

            $suma_subtotal = $suma_subtotal+$row['subtotal'];
            $suma_iva = $suma_iva+$row['tiva'];
            $suma_descuento = $suma_descuento+$row['tdescuento'];

            $descuentos = $suma_subtotal-$suma_descuento+$suma_iva;

            $suma_total = $suma_total+$descuentos;
            
            
            if ($valor_incremento > 270) {

                $this->AddPage();

                $valory = $valor_init;

                $last_y = 65;

                $this->SetY($valory+4);$this->SetX(64);$this->MultiCell(85,$InterLigne,utf8_decode("CLAVE: ".$row['clave']."\n"."MARCA: ".$row['marcax']."\n".strtoupper($row['descrip']) ),0,'J',0,0);

                $nombre_fichero  = "../../comanorsa/productos/".$row["idparte"].".jpg";

                    ////************ COLOCAR IMAGEN 
                    //if ( file_exists($nombre_fichero) ) {

                    if ( $row['img'] == 1 ) {
                        
                        $this->Image($nombre_fichero,9,$valory+4,30,25,"JPG","http://comanorsa.com/");

                    } else {

                        $this->Image("no_disponible.jpg",9,$valory+4,30,25,"JPG","http://comanorsa.com/");

                        
                    }

                /////////************* COLOCAR LAS PARTIDAS RESTANTES A LA COTIZACION

                $this->SetY($valory+7);

                //$this->SetX(38);$this->Sety($valory+5);$this->MultiCell(25,2,"valory_img: ".$last_yimg." valor_descrip: ".$last_y, 0, 'R', 0);

                $this->SetFont('Arial','',8);
               
                //$this->SetX(120);$this->MultiCell(20,0,$row['descuento'], 0, 'R', 0);
                $this->SetX(141);$this->MultiCell(27,0,wims_currency($row['costo']), 0, 'R', 0);    

                $this->SetFont('Arial','B',8);
                $this->SetX(38);$this->MultiCell(25,0,$row['cantidad']." ".$row['unidad'], 0, 'R', 0);
                $this->SetFont('Arial','B',9);
                $this->SetX(169);$this->MultiCell(29,0,wims_currency($row['subtotal']), 0, 'R', 0);

                if( $row['tcambio'] == 1 ) {
                    
                    $this->SetY($valory+11);
                    $this->SetTextColor(0, 0, 0);    
                    $this->SetFont('Arial','B',7);    
                    $this->SetX(152);$this->MultiCell(20,0,"MXN", 0, 'C', 0);

                }elseif( $row['tcambio'] > 1) {
                    
                    $this->SetY($valory+11);
                    $this->SetTextColor(255, 0, 0); 
                    $this->SetFont('Arial','B',7);
                    $this->SetX(152);$this->MultiCell(20,0,"USD TC ".$row['tcambio'], 0, 'C', 0);

                }

                $last_y = $valory+4+$nlineas+10;

                $last_yimg = $valory+25;

                if ($last_yimg > $last_y ) {
               
                    //$valory = $last_yimg;
                    $valory = $last_yimg;

                }else{

                    //$valory = $last_y;
                    $valory = $last_y;

                }

            }else{

                $this->SetY($valory+4);$this->SetX(64);$this->MultiCell(85,$InterLigne,utf8_decode("CLAVE: ".$row['clave']."\n"."MARCA: ".$row['marcax']."\n".strtoupper($row['descrip']) ),0,'J',0,0);

                    $nombre_fichero  = "../../comanorsa/productos/".$row["idparte"].".jpg";

                    ////************ COLOCAR IMAGEN 
                    if ( $row['img'] == 1 ) {

                        $this->Image($nombre_fichero,9,$valory+4,30,25,"JPG","http://comanorsa.com/");

                    } else {

                        $this->Image("no_disponible.jpg",9,$valory+4,30,25,"JPG","http://comanorsa.com/");

                        
                    }

                
                /////////************* COLOCAR LAS PARTIDAS RESTANTES A LA COTIZACION

                $this->SetY($valory+7);

                //$this->SetX(38);$this->Sety($valory+5);$this->MultiCell(25,2,"valory_img: ".$last_yimg." valor_descrip: ".$last_y, 0, 'R', 0);

                $this->SetFont('Arial','',8);
               
                //$this->SetX(120);$this->MultiCell(20,0,$row['descuento'], 0, 'R', 0);
                $this->SetX(141);$this->MultiCell(27,0,wims_currency($row['costo']), 0, 'R', 0);    

                $this->SetFont('Arial','B',8);
                $this->SetX(38);$this->MultiCell(25,0,$row['cantidad']." ".$row['unidad'], 0, 'R', 0);
                $this->SetFont('Arial','B',9);
                $this->SetX(169);$this->MultiCell(29,0,wims_currency($row['subtotal']), 0, 'R', 0);

                if( $row['tcambio'] == 1 ) {
                    
                    $this->SetY($valory+11);
                    $this->SetTextColor(0, 0, 0);    
                    $this->SetFont('Arial','B',7);    
                    $this->SetX(152);$this->MultiCell(20,0,"MXN", 0, 'C', 0);

                }elseif( $row['tcambio'] > 1) {
                    
                    $this->SetY($valory+11);
                    $this->SetTextColor(255, 0, 0); 
                    $this->SetFont('Arial','B',7);
                    $this->SetX(152);$this->MultiCell(20,0,"USD TC ".$row['tcambio'], 0, 'C', 0);

                }

                $valory = $valor_incremento;

            }


        }


        if ( $valory > 182 ) {
            
            $this->AddPage();
            $last_y = 65;

            $this->SetFont('Arial', 'B', 9);
            $this->SetTextColor(0, 0, 0);

            $this->SetX(17);

            
            ///////******* SUBTOTAL

            $this->SetFont('Arial', '', 9);
            $this->SetY($last_y+17);
            $this->SetX(133);
            $this->MultiCell(30, 0, 'Subtotal', 0, 'R', 0); ///////importe con letra


            if ( $suma_descuento > 0) {
                
                $this->SetY($last_y+23);
                $this->SetX(133);
                $this->MultiCell(30, 0, 'Descuento', 0, 'R', 0); ///////importe con letra

            }
           
            

           
            $this->SetY($last_y+29);
            $this->SetX(133);
            $this->MultiCell(30, 0, 'Iva', 0, 'R', 0); ///////importe con letra


            $this->SetY($last_y+35      );
            $this->SetX(133);
            $this->MultiCell(30, 0, 'Total', 0, 'R', 0); ///////importe con letra


            ////////// CALCULO 

            $total = $suma_subtotal-$suma_descuento+$suma_iva;
          
            
            $this->SetY($last_y+17);
            $this->SetX(148);
            $this->MultiCell(50, 0, wims_currency($suma_subtotal), 0, 'R', 0); ///////SUBTOTAL

            $this->SetTextColor(226, 16, 16);

            if ( $suma_descuento > 0) {

                $this->SetY($last_y+23);
                $this->SetX(148);
                $this->MultiCell(50, 0, "- ".wims_currency($suma_descuento), 0, 'R', 0); ///////IVA

            }

            $this->SetTextColor(0, 0, 0);
            $this->SetY($last_y+29);
            $this->SetX(148);
            $this->MultiCell(50, 0, wims_currency($suma_iva), 0, 'R', 0); ///////TOTAL

            $this->SetFont('Arial', 'B', 11);
            $this->SetY($last_y+35);
            $this->SetX(148);
            $this->MultiCell(50, 0, wims_currency($total), 0, 'R', 0); ///////TOTAL

            

            ////////****************** DATOS XML

            $this->Image('xml_qr/'.$folio.'.png',113,$last_y+16,24,24,"PNG");

            $this->SetFont('Arial', 'B', 7);


            $this->SetY($last_y+16);
            $this->SetX(12);
            $this->MultiCell(120, 0, "*Este documentos es una representacion impresa de un CFDI", 0, 'L', 0); ///////TOTAL

            $this->SetFont('Arial', '', 7);

            $this->SetY($last_y+23);
            $this->SetX(12);
            $this->MultiCell(50, 0, "Folio fiscal: ", 0, 'L', 0); ///////TOTAL

            $this->SetY($last_y+28);
            $this->SetX(12);
            $this->MultiCell(50, 3, "Numero de serie del certificado de sello digital: ", 0, 'L', 0); ///////TOTAL

            $this->SetY($last_y+37);
            $this->SetX(12);
            $this->MultiCell(50, 3, "Numero de serie del certificado de sello digital del SAT: ", 0, 'L', 0); ///////TOTAL


            $this->SetY($last_y+23);
            $this->SetX(40);
            $this->MultiCell(70, 0, $UUID, 0, 'R', 0); ///////TOTAL

            $this->SetY($last_y+30);
            $this->SetX(61);
            $this->MultiCell(50, 0, $noCertificadox, 0, 'R', 0); ///////TOTAL

            $this->SetY($last_y+39);
            $this->SetX(61);
            $this->MultiCell(50, 0, $noCertificadoSAT, 0, 'R', 0); ///////TOTAL
            

            $this->SetFont('Arial', 'B', 6);
            $this->SetY($last_y+43);

            //////////******************** MONEDA Y TIPO DE CAMBIO 
            switch ($moneda) {

                case 1:
                    
                    $infomoneda = "PESOS";

                break;
                
                case 2:
                    
                    $infomoneda = "DOLARES";

                break;
            }


            $this->MultiCell(190, 0, letras2($total,$infomoneda), 0, 'R', 0); ///////importe con letra


            $this->SetY($last_y+50);
            $this->SetX(12);$this->MultiCell(110,0,"Cadena original del complemento de certificacion del SAT",0,'L',0);

            $this->SetFont('Arial', '', 6);

            $this->SetY($last_y+53);
            $this->SetX(12);$this->MultiCell(185, 3,$cadena,0, 'L', 0); ///////importe con letra


            $this->SetY($last_y+65);
            $this->SetX(12);$this->MultiCell(185,0,"Sello digital del EMISOR",0,'L',0);
            $this->SetFont('Arial', '', 6);
            $this->SetY($last_y+68);
            $this->SetX(12);$this->MultiCell(185, 3, $selloCFD,0, 'L', 0); ///////importe con letra

            $this->SetY($last_y+80);
            $this->SetX(12);$this->MultiCell(120,0,"Sello digital del SAT",0,'L',0);
            $this->SetFont('Arial', '', 6);
            $this->SetY($last_y+83);
            $this->SetX(12);$this->MultiCell(188, 3,$selloSAT,0, 'L', 0);

            //$this->SetFont('Arial', 'B', 8);

            $this->SetFont('Arial', 'B', 7);

            $this->SetY($last_y+97);

            if ( $observaciones != "" ) {
                
                $this->SetX(12);$this->MultiCell(180,2,strtoupper( $observaciones.", imagenes con fines ilustrativos el producto real puede variar" ),0,'L',0);

            }else{

                $this->SetX(12);$this->MultiCell(180,2,strtoupper( "Imagenes con fines ilustrativos el producto real puede variar" ),0,'L',0);

            }

            
            


        }else{


            //$last_y = 182;

            $this->SetFont('Arial', 'B', 9);
            $this->SetTextColor(0, 0, 0);

            $this->SetX(17);

            
            ///////******* SUBTOTAL

            $this->SetFont('Arial', '', 9);
            $this->SetY($last_y+17);
            $this->SetX(133);
            $this->MultiCell(30, 0, 'Subtotal', 0, 'R', 0); ///////importe con letra

            if ( $suma_descuento > 0 ) {
                
                $this->SetY($last_y+23);
                $this->SetX(133);
                $this->MultiCell(30, 0, 'Descuento', 0, 'R', 0); ///////importe con letra

            }
           
            $this->SetY($last_y+29);
            $this->SetX(133);
            $this->MultiCell(30, 0, 'Iva', 0, 'R', 0); ///////importe con letra


            $this->SetY($last_y+35      );
            $this->SetX(133);
            $this->MultiCell(30, 0, 'Total', 0, 'R', 0); ///////importe con letra


            ////////// CALCULO 

            $total = $suma_subtotal-$suma_descuento+$suma_iva;
            
            $this->SetY($last_y+17);
            $this->SetX(148);
            $this->MultiCell(50, 0, wims_currency($suma_subtotal), 0, 'R', 0); ///////SUBTOTAL

            if ( $suma_descuento > 0) {

                $this->SetTextColor(226, 16, 16);

                $this->SetY($last_y+23);
                $this->SetX(148);
                $this->MultiCell(50, 0, "- ".wims_currency($suma_descuento), 0, 'R', 0); ///////IVA

            }

            $this->SetTextColor(0, 0, 0);
            $this->SetY($last_y+29);
            $this->SetX(148);
            $this->MultiCell(50, 0, wims_currency($suma_iva), 0, 'R', 0); ///////TOTAL

            $this->SetFont('Arial', 'B', 11);
            $this->SetY($last_y+35);
            $this->SetX(148);
            $this->MultiCell(50, 0, wims_currency($total), 0, 'R', 0); ///////TOTAL

            

            ////////****************** DATOS XML

            $this->Image('xml_qr/'.$folio.'.png',113,$last_y+16,24,24,"PNG");

            $this->SetFont('Arial', 'B', 7);


            $this->SetY($last_y+16);
            $this->SetX(12);
            $this->MultiCell(120, 0, "*Este documentos es una representacion impresa de un CFDI", 0, 'L', 0); ///////TOTAL

            $this->SetFont('Arial', '', 7);

            $this->SetY($last_y+23);
            $this->SetX(12);
            $this->MultiCell(50, 0, "Folio fiscal: ", 0, 'L', 0); ///////TOTAL

            $this->SetY($last_y+28);
            $this->SetX(12);
            $this->MultiCell(50, 3, "Numero de serie del certificado de sello digital: ", 0, 'L', 0); ///////TOTAL

            $this->SetY($last_y+37);
            $this->SetX(12);
            $this->MultiCell(50, 3, "Numero de serie del certificado de sello digital del SAT: ", 0, 'L', 0); ///////TOTAL


            $this->SetY($last_y+23);
            $this->SetX(40);
            $this->MultiCell(70, 0, $UUID, 0, 'R', 0); ///////TOTAL

            $this->SetY($last_y+30);
            $this->SetX(61);
            $this->MultiCell(50, 0, $noCertificadox, 0, 'R', 0); ///////TOTAL

            $this->SetY($last_y+39);
            $this->SetX(61);
            $this->MultiCell(50, 0, $noCertificadoSAT, 0, 'R', 0); ///////TOTAL
            

            $this->SetFont('Arial', 'B', 6);
            $this->SetY($last_y+43);

            //////////******************** MONEDA Y TIPO DE CAMBIO 
            switch ($moneda) {

                case 1:
                    
                    $infomoneda = "PESOS";

                break;
                
                case 2:
                    
                    $infomoneda = "DOLARES";

                break;
            }


            $this->MultiCell(190, 0, letras2($total,$infomoneda), 0, 'R', 0); ///////importe con letra


            $this->SetY($last_y+50);
            $this->SetX(12);$this->MultiCell(110,0,"Cadena original del complemento de certificacion del SAT",0,'L',0);

            $this->SetFont('Arial', '', 6);

            $this->SetY($last_y+53);
            $this->SetX(12);$this->MultiCell(185, 3,$cadena,0, 'L', 0); ///////importe con letra


            $this->SetY($last_y+65);
            $this->SetX(12);$this->MultiCell(185,0,"Sello digital del EMISOR",0,'L',0);
            $this->SetFont('Arial', '', 6);
            $this->SetY($last_y+68);
            $this->SetX(12);$this->MultiCell(185, 3, $selloCFD,0, 'L', 0); ///////importe con letra

            $this->SetY($last_y+80);
            $this->SetX(12);$this->MultiCell(120,0,"Sello digital del SAT",0,'L',0);
            $this->SetFont('Arial', '', 6);
            $this->SetY($last_y+83);
            $this->SetX(12);$this->MultiCell(188, 3,$selloSAT,0, 'L', 0);

            $this->SetFont('Arial', 'B', 7);

            $this->SetY($last_y+97);

            if ( $observaciones != "" ) {
                
                $this->SetX(12);$this->MultiCell(180,4,"**".$observaciones.", imagenes con fines ilustrativos el producto real puede variar",0,'L',0);

            }else{

                $this->SetX(12);$this->MultiCell(180,4,"**Imagenes con fines ilustrativos el producto real puede variar",0,'L',0);

            }
            

        }
        

    }       

}


$pdf = new PDF();

include("config.php"); 
include("includes/mysqli.php");
include("includes/db.php");
set_time_limit (600000);
date_default_timezone_set('America/Mexico_City');

//$idcot =trim($_POST["idcot"]);//40;//trim($_POST["idcot"]);

$idfact=trim($_POST["idfactura"]);

$query = 'SELECT x.ftimbrado,x.ftimbrado,x.htimbrado,x.moneda,x.tcambio,x.cadena,x.dias,x.idcotizacion,
a.fcotizacion, x.obs_factura AS observaciones, b.nombre AS cliente, b.comercial, c.nombre AS vendedor,h.calle,h.exterior,h.colonia,h.interior,h.municipio,h.estado,h.cp, 
CONCAT_WS(" / ",b.telefono,b.celular) AS telefonos,b.correo,
d.descripcion AS fpago,b.rfc,
e.descripcion AS mpago,f.descripcion AS cfdi, CONCAT_WS("",g.serie,g.folio) AS folfactura,x.no_odc
FROM alta_factura x,alta_cotizacion a, alta_clientes b, alta_usuarios c, sat_catalogo_fpago d, sat_metodo_pago e, sat_catalogo_cfdi f, folio_factura g, direccion_clientes h
WHERE
x.idcotizacion=a.id
AND a.idcliente=b.id
AND a.idusuario=c.id
AND x.idfpago=d.id
AND x.idmpago=e.id
AND x.idcfdi=f.id
AND x.idfolio=g.id
AND b.id=h.idcliente
AND x.id='.$idfact;

$buscar = $db->sql_query($query);
$row2 = $db->sql_fetchrow($buscar);
    
$fecha = obtenerFechaEnLetra($row2["ftimbrado"])."".$row2["htimbrado"];
$observaciones = utf8_decode( utf8_encode($row2["observaciones"]) );
$cliente = utf8_decode( utf8_encode($row2["cliente"]) );
$comercial = utf8_decode( utf8_encode($row2["comercial"]) );
$vendedor = utf8_decode( utf8_encode($row2["vendedor"]) );
//$direccion = utf8_decode($row2["direccion"]);

$calle = utf8_decode( utf8_encode($row2["calle"]) );
$exterior = utf8_decode( utf8_encode($row2["exterior"]) );
$colonia = utf8_decode( utf8_encode($row2["colonia"]) );
$interior = utf8_decode( utf8_encode($row2["interior"]) );
$municipio = utf8_decode( utf8_encode($row2["municipio"]) );
$estado = utf8_decode( utf8_encode($row2["estado"]) );
$cp = utf8_decode( utf8_encode($row2["cp"]) );

$fpago = utf8_decode($row2["fpago"]);
$mpago = utf8_decode($row2["mpago"]);
$cfdi = utf8_decode($row2["cfdi"]);
$telefonos =$row2["telefonos"];
$correo =$row2["correo"];
$rfc =$row2["rfc"];
$moneda = $row2["moneda"];
$tcambio = $row2["tcambio"];
$folio = $row2["folfactura"];

$obs_factura=trim($row2["obs_factura"]);
$no_odc=trim($row2["no_odc"]);

//$cadena = $row2["cadena"];
$idcotizacion = $row2["idcotizacion"];


//////////*********+ creamos direccion 

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


/////////////***************** DATOS GENERALES 

$sql_info = "SELECT comercial,rfc,razon_social,direccion,regimen,regimen_info,cp FROM `datos_generales` WHERE estatus = 0";
$buscar_info = $db->sql_query($sql_info);
$row_info = $db->sql_fetchrow($buscar_info);

$infocomercial = utf8_decode($row_info["comercial"]);
$inforfc = utf8_decode($row_info["rfc"]);
$inforazon_social = utf8_decode($row_info["razon_social"]);
$infodireccion = utf8_decode($row_info["direccion"]);
$regimen_fiscal = $row_info["regimen"];
$regimen_info = utf8_decode($row_info["regimen_info"]);
$cp = trim($row_info["cp"]);

////////////********************* EXTRACCION DE DATOS DEL COMPROBANTE TIMBRADO

$xml = simplexml_load_file('factura_comprobante/'.$folio.'.xml');
//$xml = simplexml_load_file('factura_comprobante/A277.xml');////////////COLOCAMOS FOLIO DE PRUEBA
foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante) {
    $atributos      = $cfdiComprobante->attributes();
    $noCertificadox = $atributos['NoCertificado'];
    $fechax = $atributos['Fecha'];
}
//////***************
$dom = new DOMDocument('1.0', 'utf-8'); // Creamos el Objeto DOM
$dom->load('factura_comprobante/'.$folio.'.xml'); // Definimos la ruta de nuestro XML
//$dom->load('factura_comprobante/A277.xml'); // Definimos la ruta de nuestro XML
////******* Recorremos el XML Tag por Tag para encontrar los elementos buscados
// *********Obtenemos el Machote(Estructura) del XML desde la web de SAT
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


$sqlupt = "UPDATE alta_factura SET cadena='".$cadena."', uuid='".$UUID."' WHERE id=".$idfact;
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
    $regimen_info,
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
    $rutaImagenSalida,
    $cp,
    $obs_factura,
    $no_odc,
    $fechax


);

$nombrearchivo = "facturas/".$folio.".pdf";
$pdf->Output($nombrearchivo, 'F');
//$pdf->Output();

echo json_encode($folio);


?>