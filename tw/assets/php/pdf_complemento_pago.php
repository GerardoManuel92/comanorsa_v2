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

        global $idppd;
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
        global $total;
        global $operacion;
        global $rfc_cuenta;
        global $banco;
        global $cuenta;
        global $bcuenta;
        global $brfc;
        global $fecha_comprobante;
        global $valor_iva;
      
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


        $this->SetDrawColor(147, 0, 1);
        $this->SetFillColor(147, 0, 1);
        $this->Rect(130, 11, 70, 6, 'DF');

        $this->SetFont('Arial','B',11);

        $this->SetTextColor(255, 255, 255);
        $this->SetDrawColor(0,0,0);
        $this->SetY(14);$this->SetX(130); $this->MultiCell(70,1,utf8_decode("COMPROBANTE DE PAGO"),0,'C',0);///////TITUL


        $this->SetFont('Arial','B',8);
        $this->SetTextColor(0, 0, 0);

        $this->SetY(21);$this->SetX(130); $this->MultiCell(30,1,utf8_decode("Folio:"),0,'L',0);///////
        $this->SetY(21);$this->SetX(170); $this->MultiCell(30,1,"Tipo: Pago",0,'P',0);///////
        $this->SetY(29);$this->SetX(130); $this->MultiCell(30,1,utf8_decode("Moneda:"),0,'L',0);///////
        $this->SetY(33);$this->SetX(130); $this->MultiCell(51,1,utf8_decode("Lugar de expedicion:"),0,'L',0);///////
        $this->SetY(25);$this->SetX(130); $this->MultiCell(30,1,utf8_decode("Fecha y hora:"),0,'L',0);///////
        $this->SetY(25);$this->SetX(150); $this->MultiCell(50,1,obtenerFechaEnLetra( date('Y-m-d') )." | ".date('H:i')." hrs",0,'R',0);///////
        

        //////////******************** MONEDA Y TIPO DE CAMBIO 
        switch ($moneda) {

            case 1:
                
                $infomoneda = "Pesos";

                $this->SetY(29);$this->SetX(150); $this->MultiCell(50,1,$infomoneda,0,'R',0);//////

            break;
            
            case 2:
                
                $infomoneda = "Dolares";

                $this->SetY(29);$this->SetX(150); $this->MultiCell(20,1,$infomoneda,0,'L',1);//////

                $this->SetY(29);$this->SetX(170); $this->MultiCell(20,1,"T.C.: ".$tcambio,0,'R',1);//////

            break;
        }

        $this->SetFont('Arial','B',10);
        $this->SetY(21);$this->SetX(140); $this->MultiCell(20,1,$folio,0,'R',0);///////
        $this->SetFont('Arial','B',8);
        $this->SetY(33);$this->SetX(150); $this->MultiCell(50,1,$cp,0,'R',0);////// LUGAR EXPEDICION

        $this->SetFont('Arial','B',12);



        ////////////// INFORMACION DE LA RQ

        $this->SetDrawColor(250,250,250);
        $this->SetFillColor(243,243,243);
        $this->Rect(10, 37, 190, 18, 'DF');

        $this->SetFont('Arial','B',7);
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0,0,0);

        $this->SetY(41);$this->SetX(14); $this->MultiCell(9,2,"RFC: ",0,'L',0);///////TITULO
        $this->SetY(47);$this->SetX(14); $this->MultiCell(150,0,"Domicilio:",0,'L',0);///////TITULO
        $this->SetY(41);$this->SetX(50); $this->MultiCell(15,2,"Cliente:",0,'L',0);///////TITULO

        $this->SetY(51);$this->SetX(14); $this->MultiCell(18,2,"Uso CFDI: ",0,'L',0);///////TITULO

        

        $this->SetFont('Arial','',7);
        $this->SetY(41);$this->SetX(22); $this->MultiCell(30,2,strtoupper($rfc),0,'L',0);///////TITULO
        $this->SetY(46);$this->SetX(28); $this->MultiCell(170,2,strtoupper( $direccion ),0,'L',0);///////TITULO
        $this->SetY(41);$this->SetX(61); $this->MultiCell(130,2,strtoupper( utf8_decode($cliente) ),0,'L',0);///////TITULO

        $this->SetY(50.5);$this->SetX(29); $this->MultiCell(39,3,"CP01 - Pagos",0,'L',0);///////TITULO
        
        //$this->SetY(52);$this->SetX(105); $this->MultiCell(88,2,utf8_decode("Pago en una sola exhibición"),0,'L',0);///////TITULO

        
        /////################ TITULOS DE LA TABLA ##################################

        /*$this->SetDrawColor(134,187,224);
        $this->SetFillColor(134,187,224);
        $this->Rect(10, 56, 190, 5, 'DF');

        $this->SetFont('Arial', 'B', 8);
        $this->SetTextColor(255, 255, 255);

        $this->SetY(59.2);
        $this->SetX(12);
        $this->MultiCell(25, 0, 'IMAGEN',0,'R',1); ///////importe con letra

        $this->SetY(59.2);
        $this->SetX(38);
        $this->MultiCell(25, 0, 'CANTIDAD', 0, 'C', 1); ///////importe con letra

        $this->SetY(59.2);
        $this->SetX(64);
        $this->MultiCell(55, 0, 'DECRIPCION', 0, 'L', 1); ///////importe con letra

        $this->SetY(59.2);
        $this->SetX(141);
        $this->MultiCell(27, 0, 'UNITARIO', 0, 'R', 1); ///////importe con letra

        $this->SetY(59.2);
        $this->SetX(169);
        $this->MultiCell(29, 0, 'IMPORTE', 0, 'R', 1); ///////importe con letra*/






        $this->SetTextColor(0,0,0);
        
        $this->SetFont('Arial','',6);
        $this->SetY(57);



    }
    function Footer(){
        $this->SetY(2);
        $this->SetX(167);
        $this->SetFont('Arial','B',9);
        $this->SetTextColor(0,0,0);
        $this->Cell(30,10,'Hoja '.$this->PageNo().' de {nb}',0,0,'C');
    }

    public function GeneraContenido(  

        $idppd,
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
        $total,
        $operacion,
        $rfc_cuenta,
        $banco,
        $cuenta,
        $bcuenta,
        $brfc,
        $fecha_comprobante,
        $valor_iva

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


        $valory = $this->GetY();
        $valor_init = $this->GetY();

        $InterLigne = 5;
        $valor_incremento = 0;


        $this->SetDrawColor(134,187,224);
        $this->SetFillColor(255,255,255);
        $this->Rect(10, $valory, 190,50, 'DF');


        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial','',8);
        

        $this->SetY($valory+5);$this->SetX(14); $this->MultiCell(20,0,"Concepto",0,'L',0);

        $this->SetY($valory+13);$this->SetX(14); $this->MultiCell(25,0,utf8_decode("No.Operación"),0,'L',0);//

        $this->SetY($valory+21);$this->SetX(14); $this->MultiCell(40,0,utf8_decode("Fecha de apliación"),0,'L',0);//

        $this->SetY($valory+29);$this->SetX(14); $this->MultiCell(40,0,utf8_decode("RFC banco ordenante"),0,'L',0);//

        $this->SetY($valory+37);$this->SetX(14); $this->MultiCell(40,0,utf8_decode("Banco ordenante:"),0,'L',0);//

        $this->SetY($valory+45);$this->SetX(14); $this->MultiCell(30,0,utf8_decode("Cuenta ordenante"),0,'L',0);//

        /////******

        $this->SetY($valory+5);$this->SetX(40); $this->MultiCell(90,0,$fpago,0,'R',0);

        $this->SetY($valory+13);$this->SetX(45); $this->MultiCell(85,0,$operacion,0,'R',0);//

        $this->SetY($valory+21);$this->SetX(45); $this->MultiCell(85,0,$fecha_comprobante,0,'R',0);//

        $this->SetY($valory+29);$this->SetX(45); $this->MultiCell(85,0,$rfc_cuenta,0,'R',0);//

        $this->SetY($valory+37);$this->SetX(45); $this->MultiCell(85,3,$banco,0,'R',0);//

        $this->SetY($valory+45);$this->SetX(45); $this->MultiCell(85,0,$cuenta,0,'R',0);//


        ////////////////////////////////////////// IMPORTES

        $this->SetY($valory+5);$this->SetX(138); $this->MultiCell(30,0,"Importe",0,'L',0);

        $this->SetY($valory+13);$this->SetX(138); $this->MultiCell(30,0,utf8_decode("Moneda"),0,'L',0);//

        $this->SetY($valory+21);$this->SetX(138); $this->MultiCell(30,0,utf8_decode("Tipo de cambio"),0,'L',0);//

        $this->SetY($valory+29);$this->SetX(138); $this->MultiCell(40,2,utf8_decode("RFC banco beneficiario"),0,'L',0);//

        $this->SetY($valory+37);$this->SetX(138); $this->MultiCell(30,0,utf8_decode("Cuenta beneficiario:"),0,'L',0);//

        ////*******

        $this->SetY($valory+5);$this->SetX(167); $this->MultiCell(30,0,wims_currency($total),0,'R',0);

        $this->SetY($valory+13);$this->SetX(167); $this->MultiCell(30,0,"MXN",0,'R',0);//

        $this->SetY($valory+21);$this->SetX(167); $this->MultiCell(30,0,"1",0,'R',0);//

        $this->SetY($valory+29);$this->SetX(158); $this->MultiCell(40,0,$brfc,0,'R',0);//

        $this->SetY($valory+37);$this->SetX(162); $this->MultiCell(35,0,$bcuenta,0,'R',0);//

        /////******************** IMPUESTOS ACUMULADOS

            if ( $row_pagos["idcfdi"] == 23 ) {
                
                ////****** NO DESGLOSA IMPUESTOS

                $tasa = 0;
                $base = 1;
                $importe_inpuesto = 0; 

            }else{

                ///////******* DESGLOSA IMPUESTOS 

                $tasa= round( ($valor_iva/100),6 );
                $pago_total = $row_pagos['pago'];
                $divisor = $tasa+1;
                $base= round( ($pago_total/$divisor),6 );
                $importe_inpuesto = round( ($pago_total-$base),6 ); 

            }

        $this->SetFont('Arial','B',8);


        /////// 
        $sqltipo="SELECT a.pago,a.tipo,a.idfactura
        FROM alta_pagos_ppd a, alta_datos_ppd b, alta_ppd c
        WHERE
        a.idppd=b.id
        AND b.idcpd=c.id
        AND c.id=".$idppd;
        $buscar_total=$db->sql_query($sqltipo);



        /////************* calculamos el total para desglose
        /*$sql_total= "SELECT a.pago, d.idcfdi
        FROM alta_pagos_ppd a, alta_datos_ppd b, alta_ppd c, alta_factura d
        WHERE
        a.idppd=b.id
        AND b.idcpd=c.id
        AND a.idfactura=d.id
        AND c.id=".$idppd;
        $buscar_total=$db->sql_query($sql_total);*/

        $suma_bases = 0;
        $suma_importe_impuesto = 0;

        while( $row_total=$db->sql_fetchrow($buscar_total) ) {


            if ( $row_total["tipo"] == 0 ) {
                
                $sqlcfdi="SELECT d.idcfdi
                FROM alta_factura d
                WHERE
                d.id=".$row_total["idfactura"];

            }elseif ( $row_total["tipo"] == 1 ) {
                

                $sqlcfdi="SELECT d.idcfdi
                FROM alta_factura_sustitucion d
                WHERE
                d.id=".$row_total["idfactura"];

            }

            $buscar_cfdi=$db->sql_query($sqlcfdi);
            $row_cfdi=$db->sql_fetchrow($buscar_cfdi);


            if ( $row_cfdi["idcfdi"] == 23 ) {
                
                ////****** NO DESGLOSA IMPUESTOS

                $tasax = 0;
                $basex = 1;
                $importe_inpuestox = 0; 

            }else{

                ///////******* DESGLOSA IMPUESTOS 

                $tasax= round( ($valor_iva/100),6 );
                $pago_totalx = $row_total['pago'];
                $divisorx = $tasax+1;
                $basex= round( ($pago_totalx/$divisorx),6 );
                $importe_inpuestox= round( ($pago_totalx-$basex),6 ); 

            }


            $suma_bases = $suma_bases+$basex;
            $suma_importe_impuesto = $suma_importe_impuesto+$importe_inpuestox;

        }


        

        $this->SetY($valory+58);$this->SetX(12); $this->MultiCell(30,0,utf8_decode("Tipo: Trasladado"),0,'L',0);//
        $this->SetY($valory+58);$this->SetX(37); $this->MultiCell(33,0,utf8_decode("Base: ".$suma_bases),0,'L',0);//
        $this->SetY($valory+58);$this->SetX(70); $this->MultiCell(30,0,utf8_decode("Impuesto: 002"),0,'L',0);//
        $this->SetY($valory+58);$this->SetX(95); $this->MultiCell(30,0,utf8_decode("Tipo o factor: Tasa"),0,'L',0);//
        $this->SetY($valory+58);$this->SetX(130); $this->MultiCell(40,0,utf8_decode("Tasa o cuota:".$tasa),0,'L',0);//
        $this->SetY($valory+58);$this->SetX(160); $this->MultiCell(40,0,utf8_decode("Importe: ".$suma_importe_impuesto),0,'L',0);//


        $ypagos=$valory+60;


        //////********************* INICIAMOS CON LOS PAGOS



        /*$sql_pagos = "SELECT a.id,d.uuid,CONCAT_WS('',e.serie,e.folio) AS folio_fact,a.saldo_anterior, a.pago, a.saldo_restante, a.npago, d.ftimbrado, d.idcfdi
        FROM alta_pagos_ppd a, alta_datos_ppd b, alta_ppd c, alta_factura d, folio_factura e
        WHERE
        a.idppd=b.id
        AND b.idcpd=c.id
        AND a.idfactura=d.id
        AND d.idfolio=e.id
        AND c.id=".$idppd;*/

        $sql_pagos = "SELECT a.id,d.uuid,CONCAT_WS('',e.serie,e.folio) AS folio_fact,a.saldo_anterior, a.pago, a.saldo_restante, a.npago, d.ftimbrado, d.idcfdi
        FROM alta_pagos_ppd a, alta_datos_ppd b, alta_ppd c, alta_factura d, folio_factura e
        WHERE
        a.idppd=b.id
        AND b.idcpd=c.id
        AND a.idfactura=d.id
        AND d.idfolio=e.id
        AND a.tipo=0
        AND c.id=".$idppd."
        
        UNION ALL
        
        SELECT a.id,d.uuid,CONCAT_WS('',e.serie,e.folio) AS folio_fact,a.saldo_anterior, a.pago, a.saldo_restante, a.npago, d.ftimbrado, d.idcfdi
        FROM alta_pagos_ppd a, alta_datos_ppd b, alta_ppd c, alta_factura_sustitucion d, folio_factura e
        WHERE
        a.idppd=b.id
        AND b.idcpd=c.id
        AND a.idfactura=d.id
        AND d.idfolio=e.id
        AND a.tipo=1
        AND c.id=".$idppd;

        $buscar_pagos=$db->sql_query($sql_pagos);
        while( $row_pagos=$db->sql_fetchrow($buscar_pagos) ) {


            $this->SetDrawColor(134,187,224);
            $this->SetFillColor(134,187,224);
            $this->Rect(10, $ypagos+5, 190, 5, 'DF');

            $this->SetFont('Arial', 'B', 8);
            $this->SetTextColor(255, 255, 255);

            $this->SetY($ypagos+8);
            $this->SetX(12);
            $this->MultiCell(25, 0, 'Documento',0,'L',1); ///////importe con letra

            $this->SetY($ypagos+8);
            $this->SetX(33);
            $this->MultiCell(35, 0, 'Fecha de emision', 0, 'C', 1); ///////importe con letra

            $this->SetY($ypagos+8);
            $this->SetX(65);
            $this->MultiCell(20, 0, 'UUID', 0, 'L', 1); ///////importe con letra

            $this->SetY($ypagos+8);
            $this->SetX(110);
            $this->MultiCell(27, 0, 'Saldo anterior', 0, 'R', 1); ///////importe con letra

            $this->SetY($ypagos+8);
            $this->SetX(135);
            $this->MultiCell(29, 0, 'Importe pagado', 0, 'R', 1); ///////importe con letra

            $this->SetY($ypagos+8);
            $this->SetX(162);
            $this->MultiCell(27, 0, 'Saldo insoluto', 0, 'R', 0); ///////importe con letra

            $this->SetY($ypagos+8);
            $this->SetX(170);
            $this->MultiCell(29, 0, 'Parc.', 0, 'R', 0); ///////importe con letra


            //////// datos

            $this->SetFont('Arial', '', 7);
            $this->SetTextColor(0, 0, 0);

            $this->SetY($ypagos+15);
            $this->SetX(12);
            $this->MultiCell(25, 0,$row_pagos['folio_fact'],0,'L',0); ///////importe con letra

            $this->SetY($ypagos+15);
            $this->SetX(38);
            $this->MultiCell(34, 0,$row_pagos['ftimbrado'], 0, 'L', 0); ///////importe con letra

            $this->SetFont('Arial', '', 6);
            

            $this->SetY($ypagos+13);
            $this->SetX(65);
            $this->MultiCell(50, 4,$row_pagos['uuid'], 0, 'L', 0); ///////importe con letra

            $this->SetFont('Arial', '', 7);

            $this->SetY($ypagos+15);
            $this->SetX(110);
            $this->MultiCell(27, 0,wims_currency($row_pagos['saldo_anterior']), 0, 'R', 0); ///////importe con letra

            $this->SetY($ypagos+15);
            $this->SetX(135);
            $this->MultiCell(30 , 0,wims_currency($row_pagos['pago']), 0, 'R', 0); ///////importe con letra

            $this->SetY($ypagos+15);
            $this->SetX(160);
            $this->MultiCell(29, 0,wims_currency($row_pagos['saldo_restante']), 0, 'R', 0); ///////importe con letra

            $this->SetY($ypagos+15);
            $this->SetX(170);
            $this->MultiCell(29, 0,$row_pagos['npago'],0, 'R', 0); ///////importe con letra


            $this->SetTextColor(0,0,0);
            $this->SetFont('Arial','',8);


            if ( $row_pagos["idcfdi"] == 23 ) {
                
                ////****** NO DESGLOSA IMPUESTOS

                $tasa = 0;
                $base = 1;
                $importe_inpuesto = 0; 

            }else{

                ///////******* DESGLOSA IMPUESTOS 

                $tasa= round( ($valor_iva/100),6 );
                $pago_total = $row_pagos['pago'];
                $divisor = $tasa+1;
                $base= round( ($pago_total/$divisor),6 );
                $importe_inpuesto = round( ($pago_total-$base),6 ); 

            }


            $this->SetY($ypagos+25);$this->SetX(12); $this->MultiCell(30,0,"Tipo: Trasladado",0,'L',0);//
            $this->SetY($ypagos+25);$this->SetX(37); $this->MultiCell(33,0,"Base: ".$base,0,'L',0);//
            $this->SetY($ypagos+25);$this->SetX(70); $this->MultiCell(30,0,"Impuesto: 002",0,'L',0);//
            $this->SetY($ypagos+25);$this->SetX(95); $this->MultiCell(30,0,"Tipo o factor: Tasa",0,'L',0);//
            $this->SetY($ypagos+25);$this->SetX(130); $this->MultiCell(40,0,"Tasa o cuota: ".$tasa,0,'L',0);//
            $this->SetY($ypagos+25);$this->SetX(160); $this->MultiCell(40,0,"Importe: ".$importe_inpuesto,0,'L',0);//


            


            if ( $ypagos+25 > 260 ) {
                
                $this->AddPage();
                $ypagos = 57;

            }


            $ypagos = $this->GetY();

            

        }

        $yxml=$this->GetY();


        ////////////************ INSERTAMOS LA CADENA DIGITAL DEL SAT

            //$this->Image('xml_qr/'.$folio.'.png',113,$yxml+16,24,24,"PNG");A7018.png
            $this->Image('xml_qr_ppd/'.$folio.'.png',113,$yxml+16,24,24,"PNG");

            $this->SetFont('Arial', 'B', 7);

            $this->SetY($yxml+16);
            $this->SetX(12);
            $this->MultiCell(120, 0, "*Este documentos es una representacion impresa de un CFDI", 0, 'L', 0); ///////TOTAL

            $this->SetFont('Arial', 'B', 10);
            $this->SetY($yxml+18);
            $this->MultiCell(190, 0, "Total: ".wims_currency($total), 0, 'R', 0); ///////importe con letra

            $yxml1=$this->GetY();

            if ( $yxml1 > 260 OR $yxml1 == 260 ) {
                
                $this->AddPage();
                $yxml = 57;

            }


            $this->SetFont('Arial', '', 7);

            $this->SetY($yxml+23);
            $this->SetX(12);
            $this->MultiCell(50, 0, "Folio fiscal: ", 0, 'L', 0); ///////TOTAL

            $this->SetY($yxml+23);
            $this->SetX(41);
            $this->MultiCell(70, 0, $UUID, 0, 'R', 0); ///////TOTAL


            $yxml1=$this->GetY();

            if ( $yxml1 > 260 OR $yxml1 == 260 ) {
                
                $this->AddPage();
                $yxml = 57;

            }

            $this->SetY($yxml+28);
            $this->SetX(12);
            $this->MultiCell(50, 3, "Numero de serie del certificado de sello digital: ", 0, 'L', 0); ///////TOTAL

            $this->SetY($yxml+30);
            $this->SetX(61);
            $this->MultiCell(50, 0, $noCertificadox, 0, 'R', 0); ///////TOTAL

            $yxml1=$this->GetY();

            if ( $yxml1 > 260 OR $yxml1 == 260 ) {
                
                $this->AddPage();
                $yxml = 57;

            }


            $this->SetY($yxml+37);
            $this->SetX(12);
            $this->MultiCell(50, 3, "Numero de serie del certificado de sello digital del SAT: ", 0, 'L', 0); ///////TOTAL

            $this->SetY($yxml+39);
            $this->SetX(61);
            $this->MultiCell(50, 0, $noCertificadoSAT, 0, 'R', 0); ///////TOTAL


            $yxml1=$this->GetY();

            if ( $yxml1 > 250 OR $yxml1 == 250 ) {
                
                $this->AddPage();
                $yxml = 15;

            }

        

            $this->SetY($yxml+50);
            $this->SetX(12);$this->MultiCell(110,0,"Cadena original del complemento de certificacion del SAT",0,'L',0);

            $this->SetFont('Arial', '', 6);

            $this->SetY($yxml+53);
            $this->SetX(12);$this->MultiCell(185, 3,$cadena,0, 'L', 0); ///////importe con letra

            $yxml1=$this->GetY();

            if ( $yxml1 > 260 OR $yxml1 == 260 ) {
                
                $this->AddPage();
                $yxml = 57;

            }


            $this->SetY($yxml+65);
            $this->SetX(12);$this->MultiCell(185,0,"Sello digital del EMISOR",0,'L',0);
            $this->SetFont('Arial', '', 6);
            $this->SetY($yxml+68);
            $this->SetX(12);$this->MultiCell(185, 3, $selloCFD,0, 'L', 0); ///////importe con letra


            $yxml1=$this->GetY();

            if ( $yxml1 > 260 OR $yxml1 == 260 ) {
                
                $this->AddPage();
                $yxml = -15;

            }


            $this->SetY($yxml+80);
            $this->SetX(12);$this->MultiCell(120,0,"Sello digital del SAT",0,'L',0);
            $this->SetFont('Arial', '', 6);
            $this->SetY($yxml+83);
            $this->SetX(12);$this->MultiCell(188, 3,$selloSAT,0, 'L', 0);

    }       

}


$pdf = new PDF();

include("config.php"); 
include("includes/mysqli.php");
include("includes/db.php");
set_time_limit (600000);
date_default_timezone_set('America/Mexico_City');

//$idcot =trim($_POST["idcot"]);//40;//trim($_POST["idcot"]);

$idppd=trim($_POST["idcompx"]);


//////************************ !!!IMPORTANTE, LOS DATOS DEL BANCO DE ALTA_DATOS_PPD DEBEN DE TRAERSE PORSTERIORMENTE A TRAVEZ DE UN WHILE POR QUE LOS PAGOS TENDRAN MULTIPLES COMPROBANTES Y MOVIMIENTOS, PRO E MOMENTO SOLO TRAEREMOS UNO POR ESO LO CARGO DESDE AQUI!!

$query = 'SELECT x.id,x.fecha,x.hora, b.nombre AS cliente, b.comercial, c.nombre AS vendedor,h.calle,h.exterior,h.colonia,h.interior,h.municipio,h.estado,h.cp, 
CONCAT_WS(" / ",b.telefono,b.celular) AS telefonos,b.correo,
b.rfc, CONCAT_WS("",g.serie,g.folio) AS folfactura, i.fecha AS fecha_comprobante, i.total, i.operacion, i.rfc AS rfc_cuenta, i.banco,i.cuenta,i.moneda,i.bcuenta,i.brfc,CONCAT_WS("-",j.clave,j.descripcion) AS fpagox
FROM alta_ppd x, alta_clientes b, alta_usuarios c, folio_ppd g, direccion_clientes h, alta_datos_ppd i, sat_catalogo_fpago j
WHERE
x.idcliente=b.id
AND x.iduser=c.id
AND x.idfolio=g.id
AND b.id=h.idcliente
AND i.idcpd=x.id
AND i.idfpago=j.id
AND x.id='.$idppd;

$buscar = $db->sql_query($query);
$row2 = $db->sql_fetchrow($buscar);
    
$fecha = obtenerFechaEnLetra($row2["fecha"])."".$row2["hora"];
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

$total = utf8_decode( utf8_encode($row2["total"]) );
$operacion = utf8_decode( utf8_encode($row2["operacion"]) );
$rfc_cuenta = utf8_decode( utf8_encode($row2["rfc_cuenta"]) );
$banco = utf8_decode( utf8_encode($row2["banco"]) );
$cuenta = utf8_decode( utf8_encode($row2["cuenta"]) );
$moneda = utf8_decode( utf8_encode($row2["moneda"]) );
$bcuenta = utf8_decode( utf8_encode($row2["bcuenta"]) );
$brfc = utf8_decode( utf8_encode($row2["brfc"]) );
$fpago = trim($row2["fpagox"]);
$fecha_comprobante = $row2["fecha_comprobante"];

$telefonos =$row2["telefonos"];
$correo =$row2["correo"];
$rfc =$row2["rfc"];
$tcambio = 1;
$folio = $row2["folfactura"];


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

$sql_info = "SELECT comercial,rfc,razon_social,direccion,regimen,regimen_info,cp,iva FROM `datos_generales` WHERE estatus = 0";
$buscar_info = $db->sql_query($sql_info);
$row_info = $db->sql_fetchrow($buscar_info);

$infocomercial = utf8_decode($row_info["comercial"]);
$inforfc = utf8_decode($row_info["rfc"]);
$inforazon_social = utf8_decode($row_info["razon_social"]);
$infodireccion = utf8_decode($row_info["direccion"]);
$regimen_fiscal = $row_info["regimen"];
$regimen_info = utf8_decode($row_info["regimen_info"]);
$cp = trim($row_info["cp"]);
$valor_iva=$row_info["iva"];

////////////********************* EXTRACCION DE DATOS DEL COMPROBANTE TIMBRADO

$xml = simplexml_load_file('factura_comprobante_pago/'.$folio.'.xml');
//$xml = simplexml_load_file('factura_comprobante/A277.xml');////////////COLOCAMOS FOLIO DE PRUEBA
foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante) {
    $atributos      = $cfdiComprobante->attributes();
    $noCertificadox = $atributos['NoCertificado'];
    $fechax = $atributos['Fecha'];
}
//////***************
$dom = new DOMDocument('1.0', 'utf-8'); // Creamos el Objeto DOM
$dom->load('factura_comprobante_pago/'.$folio.'.xml'); // Definimos la ruta de nuestro XML
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


$sqlupt = "UPDATE alta_ppd SET cadena='".$cadena."', uuid='".$UUID."' WHERE id=".$idppd;
$db->sql_query($sqlupt);


$pdf->GeneraContenido(

    $idppd,
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
    $total,
    $operacion,
    $rfc_cuenta,
    $banco,
    $cuenta,
    $bcuenta,
    $brfc,
    $fecha_comprobante,
    $valor_iva


);

$nombrearchivo="facturas_ppd/".$folio.".pdf";
$pdf->Output($nombrearchivo, 'F');
//$pdf->Output();

echo json_encode($folio);


?>