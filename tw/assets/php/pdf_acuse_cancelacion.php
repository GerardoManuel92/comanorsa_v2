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


        global $infocomercial;
        global $inforfc;
        global $inforazon_social;
        global $infodireccion;
        global $folio_fact;
        global $cliente;
        global $rfc_cliente;
        global $uuid;
        global $total;
        global $rcancelacion;
        global $uuid_sustitucion;
        global $foliox;

        //////// ENCABEZADO
        $this->SetDrawColor(250,250,250);
        $this->SetFillColor(243,243,243);
        $this->Rect(10, 11, 190, 22, 'DF');

        $this->Image("logo_icono.png",14,14,21,18,"PNG","http://comanorsa.com/");

        $this->SetFont('Arial','',12);

        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0,0,0);
        $this->SetY(15);$this->SetX(10); $this->MultiCell(190,1,$infocomercial,0,'C',0);///////TITULO


        $this->SetFont('Arial','B',8);
        $this->SetY(21);$this->SetX(10); $this->MultiCell(190,1,$inforazon_social." - RFC: ".$inforfc,0,'C',0);///////TITULO

        $this->SetFont('Arial','',8);

        $this->SetY(24);$this->SetX(10); $this->MultiCell(190,3,utf8_decode($infodireccion),0,'C',0);///////TITULO

        $this->SetFont('Arial','B',9);

    }
    function Footer(){
        $this->SetY(2);
        $this->SetX(167);
        $this->SetFont('Arial','B',9);
        $this->SetTextColor(0,0,0);
        $this->Cell(30,10,'Hoja '.$this->PageNo().' de {nb}',0,0,'C');
    }

    public function GeneraContenido(  

        $infocomercial,
        $inforfc,
        $inforazon_social,
        $infodireccion,
        $folio_fact,
        $cliente,
        $rfc_cliente,
        $uuid,
        $total,
        $rcancelacion,
        $uuid_sustitucion,
        $foliox

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


        $this->SetFont('Arial','B',14);

        $this->SetTextColor(245, 11, 11);
        $this->SetY(45);$this->SetX(10); $this->MultiCell(190,1,utf8_decode("Acuse de cancelación"),0,'C',0);///////TITULO

        $fechax = "";
        $uuidx = "";
        $estatus = "";
        $folio_fiscal = "";

        $xml = simplexml_load_file('acuse_cancelacion/acuse'.$folio_fact.'.xml');

        //Mostramos el DATO de la ETIQUETA XML
        $uuidx=$xml->Folios[0]->UUID;
        $estatus=$xml->Folios[0]->EstatusUUID;
        $folio_fiscal=$xml->Signature[0]->SignedInfo[0]->Reference[0]->DigestValue;

        if( $estatus == 201 ){

            $txt_est = "UUID Cancelado";

        }

        if( $estatus == 202 ){

            $txt_est = "UUID Previamente Cancelado";

        }

        if( $estatus == 203 ){

            $txt_est = "UUID no Encontrado";

        }

        if( $estatus == 204 ){

            $txt_est = "UUID no Aplicable a Cancelación";

        }

        if( $estatus == 205 ){

            $txt_est = "UUID no Existe o no lo ha Recibido el SAT";

        }

        if( $estatus == 301 ){

            $txt_est = "XML mal formado";

        }

        if( $estatus == 302 ){

            $txt_est = "Sello mal formado o inválido";

        }

        if( $estatus == 303 ){

            $txt_est = "Sello no corresponde a emisor o caduco";

        }

        if( $estatus == 304 ){

            $txt_est = "Certificado revocado o caduco";

        }

        if( $estatus == 305 ){

            $txt_est = "La fecha de emisión no está dentro de la vigencia del CSD del emisor";

        }

        if( $estatus == 306 ){

            $txt_est = "El certificado no es de tipo CSD";

        }

        if( $estatus == 307 ){

            $txt_est = "El CFDI contiene un timbre previo";

        }

        if( $estatus == 308 ){

            $txt_est = "Certificado no expedido por el SAT";

        }


        /*foreach ($xml->xpath('//Acuse//Folios') as $cfdiFolios) {
            //$atributos      = $cfdiComprobante->attributes();
            $uuidx = $cfdiFolios[0];
            //$estatus = $cfdiFolios['EstatusUUID'];
        }*/

        foreach ($xml->xpath('//Acuse') as $cfdiComprobante) {
            $atributos      = $cfdiComprobante->attributes();
            //$uuid = $atributos['UUID'];
            $fechax = $atributos['Fecha'];
        }

        $this->SetFont('Arial','',10);
        $this->SetTextColor(0, 0, 0);

        $this->SetY(60);$this->SetX(15); $this->MultiCell(35,0,utf8_decode("No. Comprobante: "),0,'L',0);//
        $this->SetY(60);$this->SetX(47); $this->MultiCell(40,0,$folio_fact,0,'L',0);//

        $this->SetY(60);$this->SetX(90); $this->MultiCell(35,0,utf8_decode("Sustituido por:"),0,'L',0);//

        if ($rcancelacion != 0) {
            
            $this->SetY(60);$this->SetX(115); $this->MultiCell(40,0,$foliox,0,'L',0);//

        }

        $this->SetY(70);$this->SetX(15); $this->MultiCell(40,0,utf8_decode("RFC del receptor: "),0,'L',0);//
        $this->SetY(70);$this->SetX(47); $this->MultiCell(40,0,$rfc_cliente,0,'L',0);//

        $this->SetY(70);$this->SetX(90); $this->MultiCell(40,0,utf8_decode("UUID sustitucion:"),0,'L',0);//
        $this->SetY(70);$this->SetX(118); $this->MultiCell(80,0,$uuid_sustitucion,0,'L',0);//

        $this->SetY(80);$this->SetX(15); $this->MultiCell(45,0,utf8_decode("Nombre del receptor: "),0,'L',0);//
        $this->SetY(80);$this->SetX(52); $this->MultiCell(100,0,$cliente,0,'L',0);//

        $this->SetY(90);$this->SetX(15); $this->MultiCell(80,0,utf8_decode("Fecha y hora de cancelación:"),0,'L',0);//
        $this->SetY(90);$this->SetX(65); $this->MultiCell(80,0,$fechax,0,'L',0);//


        $this->SetDrawColor(134,187,224);
        $this->SetFillColor(134,187,224);
        $this->Rect(10, 100, 190, 5, 'DF');

        $this->SetFont('Arial', 'B', 9);
        $this->SetTextColor(255, 255, 255);

        $this->SetY(102.5);
        $this->SetX(12);
        $this->MultiCell(50, 0, 'Folio Fiscal (UUID)',0,'R',0); ///////importe con letra

        $this->SetY(102.2);
        $this->SetX(100);
        $this->MultiCell(30, 0, 'Estado CFDI', 0, 'C', 0); ///////importe con letra

        $this->SetY(102.2);
        $this->SetX(126);
        $this->MultiCell(70, 0, 'Importe', 0, 'R', 0); ///////importe con letra



        $this->SetFont('Arial', 'B', 9);
        $this->SetTextColor(0, 0, 0);

        $this->SetY(110.5);
        $this->SetX(12);
        $this->MultiCell(70, 0,$uuidx,0,'R',0); ///////importe con letra

        $this->SetY(110.2);
        $this->SetX(95);
        $this->MultiCell(80, 3,$estatus." - ".$txt_est, 0, 'C', 0); ///////importe con letra

        $this->SetY(110.2);
        $this->SetX(126);
        $this->MultiCell(70, 0, wims_currency($total), 0, 'R', 0); ///////importe con letra

        $this->SetFont('Arial', '', 9);
        $this->SetTextColor(0, 0, 0);

        $this->SetY(130);
        $this->SetX(12);
        $this->MultiCell(40, 0, 'Folio fiscal:', 0, 'L', 0); ///////importe con letra

        $this->SetY(135);
        $this->SetX(12);
        $this->MultiCell(190, 0, $folio_fiscal , 0, 'L', 0); ///////importe con letra





    }       

}


$pdf = new PDF();

include("config.php"); 
include("includes/mysqli.php");
include("includes/db.php");
set_time_limit (600000);
date_default_timezone_set('America/Mexico_City');

//$folio_fact = "A7055";
$idfactura=trim($_POST["idfactura"]);

/////////////***************** DATOS GENERALES 

$sql_info = "SELECT comercial,rfc,razon_social,direccion FROM `datos_generales` WHERE id = 2";
$buscar_info = $db->sql_query($sql_info);
$row_info = $db->sql_fetchrow($buscar_info);

$infocomercial = utf8_decode($row_info["comercial"]);
$inforfc = utf8_decode($row_info["rfc"]);
$inforazon_social = utf8_decode($row_info["razon_social"]);
$infodireccion = utf8_decode($row_info["direccion"]);

/////////**************************** DATOS DE FACTURA

$sql_cliente = "SELECT b.nombre AS cliente, b.rfc AS rfc_cliente, a.uuid, a.total,CONCAT_WS('',c.serie,c.folio) AS folio_fact, a.rcancelacion,IFNULL( (SELECT CONCAT_WS('',x.serie,x.folio) FROM folio_factura x WHERE x.id=a.rcancelacion),'' ) AS foliox, IFNULL(a.uuid_sustitucion,'') AS uuid_sustitucionx 
FROM alta_factura a, alta_clientes b, folio_factura c
WHERE a.idcliente=b.id
AND a.idfolio=c.id
AND a.id=".$idfactura;
$buscar_cli = $db->sql_query($sql_cliente);
$row_cli = $db->sql_fetchrow($buscar_cli);
$cliente = $row_cli["cliente"];
$rfc_cliente = $row_cli["rfc_cliente"];
$total = $row_cli["total"];
$folio_fact=$row_cli["folio_fact"];
$rcancelacion = $row_cli["rcancelacion"];
$uuid_sustitucion = $row_cli["uuid_sustitucionx"];
$foliox=$row_cli["foliox"];


$pdf->GeneraContenido(

    $infocomercial,
    $inforfc,
    $inforazon_social,
    $infodireccion,
    $folio_fact,
    $cliente,
    $rfc_cliente,
    $uuid,
    $total,
    $rcancelacion,
    $uuid_sustitucion,
    $foliox

);

$nombrearchivo = "facturas_canceladas/cancelacion_".$folio_fact.".pdf";
$pdf->Output($nombrearchivo, 'F');
//$pdf->Output();

echo json_encode($folio_fact);


?>