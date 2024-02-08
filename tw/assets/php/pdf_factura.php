<?php
/******************************************************
 * FATURACION ELECTRONICA CFDI V3.3                   *
 * ENERO 2016                                         *
 * http://www.webalamedida.com.mx                     *
 * by Alejandro Monzon Cortes                         *
 ******************************************************/
require_once('fpdf/fpdf.php');
require_once('fpdf/letras.php');
require_once 'phpqrcode/qrlib.php';
function wims_currency($number)
{
    if ($number < 0) {
        $print_number = "-$ " . str_replace('-', '', number_format($number, 2, ".", ",")) . "";
    } else {
        $print_number = "$ " . number_format($number, 2, ".", ",");
    }
    return $print_number;
}

class PDF extends FPDF
{
    public function Header()
    {
        parent::Header();
        global $noCertificadoSAT;
        global $ErS;
        global $folio;
        global $fol;
        global $nCEmisor;
        global $fechaActual;
        global $RrS;
        global $nCSAT;
        global $fp;
        global $m;
        global $ft;
        global $pathLogo;
        global $c;
        global $sde;
        global $sds;
        global $Erfc;
        global $Rrfc;
        global $t;
        global $UUID;
        global $cuenta;
        global $entrega;
        global $oc;
        global $tipoFactura;
        global $fatura;
        global $metodoPAgo;
        global $idVenta;
        global $serieFolio;
        global $oc;
        global $condicion;
        global $dias;
        global $id_factura;

        $this->SetFont('Arial', '', 7);
        $this->Image($pathLogo, 5, 15, 65, 50);
        $this->SetDrawColor(150, 25, 0);
        $this->SetFillColor(150, 25, 0);
        $this->SetLineWidth(0.3);
        $this->Rect(141, 17 - 7, 54, 4, 'DF');
        $this->Rect(141, 17 - 7, 54, 10, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(19 - 7);
        $this->SetX(142);
        $this->MultiCell(54, 0, 'FOLIO FISCAL', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 6);
        $this->SetY(24 - 7);
        $this->SetX(141);
        $this->MultiCell(54, 0, $UUID, 0, 'C', 0);
        //////////////////////////////////////////////EMISOR
        $this->SetFont('Arial', '', 7);
        ////$this->Rect(posicion x,posicion y-7,largo,ancho,'DF');
        $this->Rect(72, 17 - 7, 69, 4, 'DF');
        $this->Rect(72, 17 - 7, 69, 30, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(19 - 7);
        $this->SetX(72);
        $this->MultiCell(68, 0, 'EMISOR', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetY(23 - 7);
        $this->SetX(72);
        $this->MultiCell(68, 2.5, $ErS, 0, 'L', 0);
        $this->Rect(72, 47 - 7, 69, 4, 'DF');
        $this->Rect(72, 47 - 7, 69, 30, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(49 - 7);
        $this->SetX(72);
        $this->MultiCell(69, 0, 'RECEPTOR', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetY(53 - 7);
        $this->SetX(72);
        $this->MultiCell(69, 2.5, $RrS . "Entrega en " . $entrega, 0, 'L', 0);
    //////////////////////////////////////////////numero de factura
        $this->Rect(141, 27 - 7, 54, 4, 'DF');
        $this->Rect(141, 27 - 7, 54, 10, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(29 - 7);
        $this->SetX(142);
        $this->MultiCell(54, 0, 'NUMERO DE FACTURA', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetY(34 - 7);
        $this->SetX(141);
        $this->MultiCell(54, 0, $serieFolio, 0, 'C', 0);
    //////////////////////////////////////////////numero de serie  del csd del emisor
        $this->Rect(141, 37 - 7, 54, 4, 'DF');
        $this->Rect(141, 37 - 7, 54, 10, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(39 - 7);
        $this->SetX(142);
        $this->MultiCell(54, 0, 'NUMERO DE SERIE DEL CSD DEL EMISOR', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetY(44 - 7);
        $this->SetX(141);
        $this->MultiCell(54, 0, $nCEmisor, 0, 'C', 0);
    //////////////////////////////////////////////para fecha y hora de emision
        $this->Rect(141, 47 - 7, 54, 4, 'DF');
        $this->Rect(141, 47 - 7, 54, 10, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(49 - 7);
        $this->SetX(142);
        $this->MultiCell(54, 0, 'FECHA Y HORA DE EMISION', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetY(54 - 7);
        $this->SetX(141);
        $this->MultiCell(54, 0, $fechaActual, 0, 'C', 0);
    //////////////////////////////////////////////TIPO DE CFDI
        $this->Rect(141, 57 - 7, 54, 4, 'DF');
        $this->Rect(141, 57 - 7, 54, 10, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(59 - 7);
        $this->SetX(142);
        $this->MultiCell(54, 0, 'TIPO DE CFDI', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetY(64 - 7);
        $this->SetX(141);
        $this->MultiCell(54, 0, $tipoFactura, 0, 'C', 0);
    //////////////////////////////////////////////RECEPTOR
        //////////////////////////////////////////////CUENTA
        $this->Rect(141, 67 - 7, 27, 4, 'DF');
        $this->Rect(141, 67 - 7, 27, 10, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(69 - 7);
        $this->SetX(142);
        $this->MultiCell(27, 0, 'CUENTA TRANSF.', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetY(74 - 7);
        $this->SetX(140);
        $this->MultiCell(27, 0, '', 0, 'C', 0);
    //////////////////////////////////////////////oc
        $this->Rect(168, 67 - 7, 27, 4, 'DF');
        $this->Rect(168, 67 - 7, 27, 10, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(69 - 7);
        $this->SetX(169);
        $this->MultiCell(27, 0, 'ORDEN COMPRA', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetY(74 - 7);
        $this->SetX(169);
        $this->MultiCell(27, 0, $oc, 0, 'C', 0);
        ////////////cambios///////////
        //////////////////////////////////////////////NUMERO DE SERIE CSD DEL SAT
        $this->Rect(4, 70, 40, 4, 'DF');
        $this->Rect(4, 70, 40, 10, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(72);
        $this->SetX(4);
        $this->MultiCell(37, 0, 'No. DE SERIE CSD DEL SAT', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetY(77);
        $this->SetX(4);
        $this->MultiCell(37, 0, $noCertificadoSAT, 0, 'C', 0);
    //////////////////////////////////////////////FORMA DE PAGO
        //////////////////////////////////////////////FORMA DE PAGO
        $this->Rect(44, 70, 38, 4, 'DF');
        $this->Rect(44, 70, 38, 10, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(72);
        $this->SetX(44);
        $this->MultiCell(38, 0, 'FORMA DE PAGO', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', '', 6);
        $this->SetY(77);
        $this->SetX(44);
        $this->MultiCell(40, 0, $fp, 0, 'C', 0);
    //////////////////////////////////////////////MONEDA
        $this->SetFont('Arial', '', 7);
        $this->Rect(81.7, 70, 37.4, 4, 'DF');
        $this->Rect(81.7, 70, 37.4, 10, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(72);
        $this->SetX(81.7);
        $this->MultiCell(37.4, 0, 'METODO DE PAGO', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetY(77);
        $this->SetX(81.7);
        $this->MultiCell(37, 0, $metodoPAgo, 0, 'C', 0);
    //////////////////////////////////////////////MONEDA
        $this->Rect(119.1, 70, 20, 4, 'DF');
        $this->Rect(119.1, 70, 20, 10, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(72);
        $this->SetX(119.1);
        $this->MultiCell(20, 0, 'MONEDA', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetY(77);
        $this->SetX(119.1);
        $this->MultiCell(20, 0, $m, 0, 'C', 0);
    //////////////////////////////////////////////FECHA Y HORA DE CERTIFICACION
        $this->Rect(139.1, 70, 55.7, 4, 'DF');
        $this->Rect(139.1, 70, 55.7, 10, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(72);
        $this->SetX(139.1);
        $this->MultiCell(55.7, 0, 'CONDICIONES DE PAGO', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetY(77);
        $this->SetX(139.1);
        $this->MultiCell(55.7, 0, $condicion, 0, 'C', 0);
    //////////////////////////////////////////////CANTIDAD
        $this->Rect(4, 82, 10, 4, 'DF');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(84);
        $this->SetX(4);
        $this->MultiCell(10, 0, 'CANT', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
    //////////////////////////////////////////////MEDIDA
        $this->Rect(14, 82, 10, 4, 'DF');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(84);
        $this->SetX(13);
        $this->MultiCell(10, 0, 'UM', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
    //////////////////////////////////////////////CLAVE
        $this->Rect(20, 82, 20, 4, 'DF');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(84);
        $this->SetX(20);
        $this->MultiCell(17, 0, 'CLAVE', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
    //////////////////////////////////////////////CONCEPTO
        $this->Rect(40, 82, 97, 4, 'DF');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(84);
        $this->SetX(40);
        $this->MultiCell(105, 0, 'CONCEPTO', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
    //////////////////////////////////////////////PRECIO UNITARIO
        $this->Rect(137, 82, 18, 4, 'DF');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(84);
        $this->SetX(137);
        $this->MultiCell(18, 0, 'PRECIO', 0, 'R', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
    //////////////////////////////////////////////desceunto
        $this->Rect(155, 82, 12, 4, 'DF');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(84);
        $this->SetX(155);
        $this->MultiCell(13, 0, 'DESC', 0, 'R', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
    //////////////////////////////////////////////IMPORTE
        $this->Rect(167, 82, 28, 4, 'DF');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(84);
        $this->SetX(170);
        $this->MultiCell(25, 0, 'IMPORTE', 0, 'R', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
    //////////////////////////////////////////////
        //////////////////////////////////////////////
        $this->Line(4, 82, 4, 92);
        $this->Line(14, 82, 14, 92);
        $this->Line(23, 82, 23, 92);
        $this->Line(46, 82, 46, 92);
        $this->Line(137, 82, 137, 92);
        $this->Line(167, 82, 167, 92);
        $this->Line(155, 82, 155, 92);
        $this->Line(195, 82, 195, 92);
        $this->SetFont('Arial', '', 6);
        $this->Rect(4.5, 240, 155, 4, 'DF');
        $this->Rect(4.5, 240, 155, 13, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(242);
        $this->SetX(8);
        $this->MultiCell(155, 0, 'CADENA ORIGINAL DEL COMPLEMENTO DE CERTIFICACION DEL SAT', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetTextColor(0, 0, 0);
        $this->SetY(245);
        $this->SetX(6);
        $this->MultiCell(154, 2.5, $c, 0, 'C', 0); ///////cadena original
        $this->SetY(243);
        $this->Rect(4.5, 253, 155, 4, 'DF');
        $this->Rect(4.5, 253, 155, 13, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(255);
        $this->SetX(8);
        $this->MultiCell(155, 0, 'SELLO DIGITAL DEL EMISOR', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetY(258);
        $this->SetX(6);
        $this->MultiCell(154, 2.5, $sde, 0, 'C', 0); ///////sello digital del emisor
        $this->SetY(256.5);
        $this->Rect(4.5, 266, 155, 4, 'DF');
        $this->Rect(4.5, 266, 155, 13, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->SetY(268);
        $this->SetX(8);
        $this->MultiCell(155, 0, 'SELLO DIGITAL DEL SAT', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetY(271);
        $this->SetX(6);
        $this->MultiCell(154, 2.5, $sds, 0, 'C', 0); ///////sello digital del sat
        $this->SetFont('Arial', '', 5);
        $this->SetY(288);
        $this->SetX(8);
        $this->MultiCell(200, 0, 'ESTE DOCUMENTO ES UNA REPRESENTACION IMPRESA DE UN CFDI', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 255);
        $this->SetY(292);
        $this->SetX(8);
        $this->MultiCell(200, 0, 'SISTEMA ERP - www.ferreterialaqueretana.com -', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        /*$codeContents  = "?re=".$Erfc."&rr=";
        $codeContents .= $Rrfc."&tt=";
        $codeContents .= $t."&id=";
        $codeContents .= $UUID."";
        $targetDir     = 'codigosQR';
        if(!file_exists($targetDir)){
        @mkdir($targetDir, 0777);
        }*/
        $targetDir = 'factura_qr/codigo' . $id_factura . '.jpg';

        //QRcode::png($codeContents,$targetDir, QR_ECLEVEL_L, 3);
        $this->Image($targetDir, 163, 243, 35);
        /**************para las letras de la factura************************/
        /*        $this->SetFont('Arial','B',70);
        $this->SetY(100);
        $this->SetX(5);
        $this->SetTextColor(176,196,222);
        $this->MultiCell(200,40,"FACTURA SIN VALIDEZ OFICIAL",0,'C',0);
         *//**********************************************************************/
        $this->SetY(288);
        $this->SetX(8);
        $this->Link(100, 288, 10, 5, 'http://www.ferreterialaqueretana.com');
        //$this->SetY(288);$this->SetX(8); $this->Link(113,288,14,5,'http://facturaspymes.com');
        $this->SetFont('Arial', '', 6);
        $this->SetY(87);
    }
    public function Footer()
    {
        $this->SetY(2);
        $this->SetX(167);
        $this->SetFont('Arial', 'B', 9);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(30, 10, 'Hoja ' . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }

    public function GeneraContenido($id_factura,$desc, $oc, $cuenta, $entrega, $pathLogo, $fatura, $fechaActual, $ErS, $RrS, $noCertificadoSAT, $nCEmisor, $fp, $m, $ft, $c, $sde, $sds, $t, $s, $i, $vector, $count, $Erfc, $Rrfc, $UUID, $folio, $tipoFactura, $metodoPAgo, $observacionest, $idVenta, $serieFolio, $condicion, $dias)
    {
        set_time_limit(600000);

        $totalLetra = letras2($t, $m);
        //$s=$cfdi->wims_currency($s);
        //$i=$cfdi->wims_currency($i);
        //$t=$cfdi->wims_currency($t);
        $this->AliasNbPages();
        $this->AddPage();
        $this->SetDrawColor(150, 25, 0);
        $this->SetFillColor(150, 25, 0);
        $this->SetLineWidth(0.3);
        ///////////////////partidas
        //$replace=array('<','>','&','"','\'',"'");
        //$match=array('&lt;','&gt;','&amp;','&quot;','&apos;','&quot;');
        include "config.php";
        include "includes/mysqli.php";
        include "includes/db.php";
        set_time_limit(600000);
        date_default_timezone_set('America/Mexico_City');

        //$idfac = $_POST["alta1"];
        //$serieFolio = "Q51";//$_POST["alta2"];

        /*$sql2 = "SELECT
        a.id,
        a.costo,
        a.cantidad,
        b.descripcion,
        b.unidad,
        b.clave,
        a.descuento
        FROM
        clientes_124_ventas_partes_mostrador AS a ,
        clientes_124_catalogo_materiales AS b
        WHERE
        a.idParte =  b.id AND
        a.idVenta =  '$idVenta' and a.retirado = 0";
        $buscar = $db->sql_query($sql2);
        while ($row = $db->sql_fetchrow($buscar)) {
            $this->ln(3);
            //$id=$row['id'];
            $vunt = round($row['costo'], 2);
            $v    = round(($vunt / 1.16), 2);
            $ca   = $row['cantidad'];
            $d    = $row['descripcion'];

            $replacex   = array('<', '>', '&', '"', '\'', '¨');
            $matchx     = array('&lt;', '&gt;', '&amp;', '&quot;', '&apos;', '&quot;');
            $d          = str_replace($matchx, $replacex, $d);
            $u          = $row['unidad'];
            $cl         = $row['clave'];
            $descuentop = $row['descuento'];
            $im         = $ca * $v;

            
            $this->SetFont('Arial', '', 7);

            $this->SetX(4);
            $this->MultiCell(10, 0, $ca, 0, 'R', 0); /////cantidad
            $val = $this->GetY();
            $this->SetY($val);

            $this->SetX(170);
            $this->MultiCell(24, 0, wims_currency(round($im, 2)), 0, 'R', 0); /////////importe
            $this->SetX(136);
            $this->MultiCell(18, 0, wims_currency(round($v, 2)), 0, 'R', 0); /////////precio unitario
            $this->SetX(14);
            $this->MultiCell(9, 0, $u, 0, 'C', 0); ///////medida
            $this->SetX(23);
            $this->MultiCell(23, 0, $cl, 0, 'C', 0); ///////medida
            $this->SetX(156);
            $this->MultiCell(12, 0, $descuentop . " %", 0, 'C', 0); ///////medida
            //$this->SetX(20); $this->MultiCell(20,0,$cl,0,'C',0);///////medida
            $this->SetY($val - 1.5);
            $this->SetX(46);
            $this->MultiCell(93, 2.5, utf8_decode($d), 0, 'L', 0); ////////concepto
            $val2 = $this->GetY();
            $this->Line(4, $val - 5, 4, $val2 + 2);
            $this->Line(14, $val - 5, 14, $val2 + 2);
            $this->Line(23, $val - 5, 23, $val2 + 2);
            $this->Line(46, $val - 5, 46, $val2 + 2);
            $this->Line(137, $val - 5, 137, $val2 + 2);
            $this->Line(167, $val - 5, 167, $val2 + 2);
            $this->Line(155, $val - 5, 155, $val2 + 2);
            $this->Line(195, $val - 5, 195, $val2 + 2);
            if ($val2 > 210) {
                $this->Line(4.5, $val2 + 2, 195, $val2 + 2);
                $this->AddPage();
            } else {
                $this->Line(4.5, $val2 + 2, 195, $val2 + 2);
            }
            $this->ln(1);
        }
        $this->Line(4.5, $val2 + 2, 195, $val2 + 2);
        $this->ln(1);

        $this->Rect(137, $this->GetY(), 30, 4, 'DF');
        $this->Line(195, $this->GetY(), 195, $this->GetY() + 12);

        $this->ln(2);
        $this->SetTextColor(255, 255, 255);
        $this->SetX(138.7);
        $this->MultiCell(27, 0, 'DESCUENTO %', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 8);
        $this->SetX(7);
        $this->MultiCell(125, 0, "TOTAL EN LETRA: " . $totalLetra, 0, 'L', 0); ///////importe con letra

        if ($desc == 0) {
        } else {
            $this->SetX(167);
            $this->MultiCell(28, 0, $desc, 0, 'R', 0); //////subtotal
        }
        $this->SetFont('Arial', '', 7);
        $this->Rect(137, $this->GetY() + 2, 30, 4, 'DF');
        $this->Line(160, $this->GetY() + 2, 195, $this->GetY() + 2);
        $this->ln(4);
        $this->SetTextColor(255, 255, 255);
        $valory = $this->GetY();
        $this->SetX(138.7);
        $this->MultiCell(27, 0, 'SUBTOTAL', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetX(167);
        $this->MultiCell(28, 0, wims_currency($s), 0, 'R', 0); //////subtotal
        $this->Rect(137, $this->GetY() + 2, 27, 4, 'DF');
        $this->Line(160, $this->GetY() + 2, 195, $this->GetY() + 2);

        $this->ln(4);

        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->MultiCell(130, 0, '**CUENTA. DE DEPOSITO :0105124409 / CLABE:012680001051244099 - BANCOMER ', 0, 'C', 0); ///////Cuentas Bancaria
        $this->Rect(138.7, $this->GetY() - 2, 28, 4, 'DF');
        $this->SetTextColor(255, 255, 255);
        $this->SetX(138.7);
        $this->MultiCell(27, 0, 'IVA 16.0%', 0, 'C', 0); ///////importe con letra
        $this->Line(160, $this->GetY() + 2, 195, $this->GetY() + 2);
        $this->SetTextColor(0, 0, 0);

        $this->SetX(167);
        $this->MultiCell(28, 0, wims_currency($i), 0, 'R', 0); //////total iva
        $this->ln(4);
        $this->Rect(137, $this->GetY() - 2, 30, 4, 'DF');
        $this->Rect(164, $this->GetY() - 2, 31, 4, 'D');
        $this->SetTextColor(255, 255, 255);
        $this->Line(161, $this->GetY() + 2, 195, $this->GetY() + 2);
        $this->SetX(138.7);
        $this->MultiCell(27, 0, 'TOTAL', 0, 'C', 0); ///////importe con letra
        $this->SetTextColor(0, 0, 0);
        $this->SetX(167);
        $this->MultiCell(28, 0, wims_currency($t), 0, 'R', 0); //////////total

        $this->SetY($valory);
        /*$this->SetX(4); $this->MultiCell(120,2.5,"Por este pagare me(nos) obligo(amos) a cubrir incondicionalmente a la orden de Proveedores Industriales Chimalhuacan, S.A de C.V. En el Estado de México en la fecha de vencimiento indicada al pie del documento, si no fuere puntualmente cubierto a su vencimiento, pagare además intereses moratorios a las razon de _______% mensual hasta cubrir el saldo total.",'L',0);///////importe con letra*/

        /*$this->ln(3);
        $this->SetFont('Arial','B',8);
        $this->SetX(10); $this->MultiCell(125,3,"**NOTA: ESTA FACTURA CANCELA Y SUSTITUYE A LA FACTURA Q333",0,'L',0);

        $this->SetY(85);

        */

    }
}

$pdf = new PDF();

include "config.php";
include "includes/mysqli.php";
include "includes/db.php";
set_time_limit(600000);
date_default_timezone_set('America/Mexico_City');
//////////////////***********************************DATOS VENTA
$id_factura = 1;//trim($_POST["alta1"]);////este es feferido al id de la tabla alta_factura no al folio y serie de la misma

//////////////****************************** DATOS DEL EMISOR

$sql="SELECT iva,rfc,razon_social,calle,exterior,interior,colonia,localidad,municipio,estado,pais,cp,regimen,serie_factura FROM `datos_generales` WHERE estatus = 0";
$buscar = $db->sql_query($sql);
$row = $db->sql_fetchrow($buscar);

$Erfc = trim($row["rfc"]);
$ErazonSocial = trim($row["razon_social"]);
$Ecalle = trim($row["calle"]);
$EnumExterior = trim($row["exterior"]);
$Ecolonia = trim($row["colonia"]);
//$Emunicipio = trim($row["localidad"]);
$Eestado = trim($row["estado"]);
$Epais = trim($row["pais"]);
$Ecp = trim($row["cp"]);
$Emunicipio = trim($row["municipio"]);
$EregimenFiscal = trim($row["regimen"]);
$Email = "";
$serie_factura = trim($row["serie_factura"]);

////////////********************************** DATOS DEL CLIENTE
$sql2="SELECT b.clave as fpago, a.rfc, a.nombre,c.clave AS cfdi, a.calle, a.exterior, a.interior, a.colonia, a.municipio, a.estado, a.cp   
FROM 
alta_cotizacion x,alta_clientes a,sat_catalogo_fpago b, sat_catalogo_cfdi c
WHERE 
x.idcliente=a.id
AND a.idfpago=b.id
AND a.idcfdi=c.id
AND x.id =".$id_factura;
$buscar2 = $db->sql_query($sql2);
$row2 = $db->sql_fetchrow($buscar2);

$ti_fpago = trim($row2["fpago"]);
$Rrfc = trim($row2["rfc"]);///////************* RFC DE PRUEBA
$RrazonSocial = trim($row2["nombre"]);
$uso_cfdi = trim($row2["cfdi"]);
$Rcalle = utf8_decode( trim($row2["calle"]) );

$RnumExterior = utf8_decode( trim($row2["exterior"]) );
$interior_receptor = utf8_decode( trim($row2["interior"]) );
$Rcolonia = utf8_decode( trim($row2["colonia"]) );
$Rmunicipio = utf8_decode( trim($row2["municipio"]) );
$Restado = utf8_decode( trim($row2["estado"]) );
$Rpais = utf8_decode( trim("Mexico") );
$Rcp = utf8_decode( trim($row2["cp"]) );
$Rmail = "";
$Rtelefono ="";
$ti_lexpedicion = $Rcp;
///////////////////************************** DATOS DE LA FACTURA

$sql3="SELECT a.fecha,a.hora,a.subtotal,a.iva,a.total,a.moneda,a.tcambio,b.clave,a.cadena,c.folio
FROM `alta_factura` a, sat_metodo_pago b, folio_factura c
WHERE
a.idmpago=b.id
AND a.idfolio=c.id
AND a.id=".$id_factura;
$buscar3 = $db->sql_query($sql3);
$row3 = $db->sql_fetchrow($buscar3);

$ti_fecha = date("Y-m-d");
$ti_hora = date("H:i:s");
$fecha_hoy  = date("Y-m-d");
$hora_hoy   = date("H:i:s");
$fecha_fact = $fecha_hoy . '  ' . $hora_hoy;

$ti_total = $row3["subtotal"];
$ti_iva = $row3["iva"];
$ti_totiva = $row3["iva"];
$ti_neto = $row3["total"];
$ti_metodo = $row3["clave"];
$cadena_original = $row3["cadena"];
$cpago           = "";
$dias            = $row['dias_pago'];
$oc = "ocprueba";
$ti_idcliente = "";

$impuesto_iva = "002";
$tcambio = $row3["tcambio"];

if( $row3["moneda"] == 1 ){

    /// pesos
    $moneda = "MXN";

}elseif ( $row3["moneda"] == 2 ) {
    
    /// USD
    $moneda = "USD";

}

$folio_factura = trim($row3["folio"]);
$serieFolio = $serie_factura."".$folio_factura;

/////////////***********
$ErS = 'Razon Social: ' . $ErazonSocial . "\n";
$ErS .= 'RFC: ' . $Erfc . "\n";
$ErS .= 'Regimen Fiscal: ' . $EregimenFiscal . "\n";
$ErS .= 'Domicilio: ' . $Ecalle . ' ' . $EnumExterior . ', ' . $Ecolonia . ', ' . $Emunicipio . ', ' . $Eestado . ', ' . $Epais . ', Cp. ' . $Ecp . ', Mail ' . $Email . ', telefono 4425430701' . "\n";
$RrS = 'Razon Social: ' . $RrazonSocial . "\n";
$RrS .= 'RFC: ' . $Rrfc . "\n";
$RrS .= 'Domicilio: ' . $Rcalle . ' ' . $RnumExterior . ' Int.' . $interior_receptor . ', ' . $Rcolonia . ', ' . $Rmunicipio . ', ' . $Restado . ', ' . $Rpais . ', Cp. ' . $Rcp . ' Tel ' . $Rtelefono . ', Mail ' . $Rmail . "\n";

//////////////////*****************

$xml = simplexml_load_file('factura_comprobante/comprobante'.$id_factura.'.xml');
foreach ($xml->xpath('//cfdi:Comprobante') as $cfdiComprobante) {
    $atributos      = $cfdiComprobante->attributes();
    $noCertificadox = $atributos['NoCertificado'];
}
//////////////***************
$dom = new DOMDocument('1.0', 'utf-8'); // Creamos el Objeto DOM
$dom->load('factura_comprobante/comprobante'.$id_factura.'.xml'); // Definimos la ruta de nuestro XML
// Recorremos el XML Tag por Tag para encontrar los elementos buscados
// Obtenemos el Machote(Estructura) del XML desde la web de SAT
foreach ($dom->getElementsByTagNameNS('http://www.sat.gob.mx/TimbreFiscalDigital', '*') as $elemento) {
    $UUID             = $elemento->getAttribute('UUID');
    $noCertificadoSAT = $elemento->getAttribute('NoCertificadoSAT');
    $FechaTimbrado    = $elemento->getAttribute('FechaTimbrado');
    $selloCFD         = $elemento->getAttribute('SelloCFD');
    $selloSAT         = $elemento->getAttribute('SelloSAT');
    // etc...
}
////////////**************
$fatura      = $serieFolio; //$serie.$folio;
$nCEmisor    = $noCertificadox; //$EnoCertificado;
$fp          = $ti_fpago;
$m           = $moneda; //$moneda;
$ft          = date("Y-m-d"); ///$FechaTimbrado;
$c           = $cadena_original; //$cadena_original;//$cadenaOriginalSAT;
$sde         = $selloCFD; //$selloFirmado;
$sds         = $selloSAT; //$selloSAT;
$t           = round($ti_neto, 2);
$s           = round($ti_total, 2);
$i           = round($ti_totiva, 2);
$pathLogo    = 'logo.png';
$tipoFactura = "Factura";
$fechaActual = $fecha_fact;
$metodoPAgo  = $ti_metodo;


////////////********************************** DATOS DE LA FACTURA ANTERIOR **************************************************
$ti_comprobante  = "Comprobante";//"row['comprobante']";
$condicion= "Contado";

/*switch ($cpago) {

    case 1:
        $condicion = "CONTADO";
        break;
    case 2:
        $condicion = "Un 10% a contado y lo demas a Credito";
        break;
    case 3:
        $condicion = "Un 20% a contado y lo demas a Credito";
        break;
    case 4:
        $condicion = "Un 30% a contado y lo demas a Credito";
        break;
    case 5:
        $condicion = "Un 40% a contado y lo demas a Credito";
        break;
    case 6:
        $condicion = "Un 50% a contado y lo demas a Credito";
        break;
    case 7:
        $condicion = "CREDITO" . ' - ' . $dias . ' DIAS';
        break;

    default:
        $condicion = "Sin Especificar";
        break;

}*/


$pdf->GeneraContenido($id_factura,$desc, $oc, $cuenta, $entrega, $pathLogo, $fatura, $fechaActual, $ErS, $RrS, $noCertificadoSAT, $nCEmisor, $fp, $m, $ft, $c, $sde, $sds, $t, $s, $i, $vector, $count, $Erfc, $Rrfc, $UUID, $folio, $tipoFactura, $metodoPAgo, $observacionest, $idVenta, $serieFolio, $condicion, $dias);




//$nombrearchivo = "facturas/" . $fatura . ".pdf";
//$pdf->Output($nombrearchivo, 'F');
$pdf->Output();

//$arrayName = array('IMPRIME' => $fatura);

//echo json_encode($arrayName);
