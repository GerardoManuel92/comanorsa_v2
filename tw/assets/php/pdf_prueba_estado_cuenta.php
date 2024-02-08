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

    return $num.' '.$mes.' '.$anno;

}

function fechaLatin($fechax){


    $separar_fecha=explode("-", $fechax);

    return $separar_fecha[2]."/".$separar_fecha[1]."/".$separar_fecha[0];

}



/*error_reporting(E_ALL & ~E_NOTICE);

ini_set('display_errors', 0);

ini_set('log_errors', 1);*/



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





        global $cliente;

        global $comercial;

        global $rfc;

        global $idcliente;

        global $estatus;

        global $inicio;

        global $fin;

        global $nfiltro;

        global $infocomercial;

        global $inforfc;

        global $inforazon_social;

        global $infodireccion;

        global $limite;

        global $saldo_total_deudor;

        global $total_neto;



        //////// ENCABEZADO

        $this->SetDrawColor(250,250,250);

        $this->SetFillColor(243,243,243);

        $this->Rect(10, 11, 280, 22, 'DF');



        $this->Image("logo_icono.png",14,14,21,18,"PNG","http://comanorsa.com/");



        $this->SetFont('Arial','',11);



        $this->SetTextColor(0, 0, 0);

        $this->SetDrawColor(0,0,0);

        $this->SetY(15);$this->SetX(10); $this->MultiCell(190,1,$infocomercial,0,'C',0);///////TITULO





        $this->SetFont('Arial','B',8);

        $this->SetY(21);$this->SetX(10); $this->MultiCell(190,1,$inforazon_social." - RFC: ".$inforfc,0,'C',0);///////TITULO



        $this->SetFont('Arial','',8);



        $this->SetY(25);$this->SetX(10); $this->MultiCell(210,3,utf8_decode($infodireccion),0,'C',0);///////TITULO



        $this->SetFont('Arial','B',9);





        ///////************** ENCABEZADO DE TABLA



        $this->SetFont('Arial','B',14);



        $this->SetTextColor(0, 0, 0);

        //$this->SetY(40);$this->SetX(10); $this->MultiCell(190,1,utf8_decode("Estado de cuenta"),0,'C',0);///////TITULO



        $this->SetFont('Arial','',10);

        $this->SetY(40);$this->SetX(10); $this->MultiCell(190,1,utf8_decode("Cliente: ".$cliente." - ".$comercial),0,'L',0);///////TITULO

        $this->SetY(47);$this->SetX(10); $this->MultiCell(190,1,utf8_decode("RFC: ".$rfc),0,'L',0);///////TITULO


        ///////////// BALANCE

        $this->SetFont('Arial','B',11.5);
        $this->SetTextColor(4, 58, 136);

        $this->SetY(40);$this->SetX(200); $this->MultiCell(35,1,utf8_decode("Linea de credito:"),0,'L',0);///////TITULO

        $this->SetY(40);$this->SetX(240); $this->MultiCell(45,1,wims_currency($limite),0,'R',0);///////TITULO

        $this->SetTextColor(214,142,7);

        $this->SetY(47);$this->SetX(200); $this->MultiCell(40,1,utf8_decode("Saldo total deudor:"),0,'L',0);///////TITULO

        $this->SetY(47);$this->SetX(240); $this->MultiCell(45,1,wims_currency($saldo_total_deudor),0,'R',0);///////TITULO

        $this->SetTextColor(224,15,15);

        $this->SetY(54);$this->SetX(200); $this->MultiCell(40,1,utf8_decode("Saldo Vencido:"),0,'L',0);///////TITULO

        $this->SetY(54);$this->SetX(240); $this->MultiCell(45,1,wims_currency($total_neto),0,'R',0);///////TITULO

        $this->SetFont('Arial','B',12);

        $this->SetTextColor(36,151,8);

        $this->SetY(61);$this->SetX(200); $this->MultiCell(40,1,utf8_decode("Saldo disponible:"),0,'L',0);///////TITULO

        $saldo_disponible=$limite-$saldo_total_deudor;

        $this->SetY(61);$this->SetX(240); $this->MultiCell(45,1,wims_currency($saldo_disponible),0,'R',0);///////TITULO

        ///////************ ENCABEZADO DE BALANCE

        $this->SetDrawColor(134,187,224);
        $this->SetFillColor(134,187,224);
        $this->Rect(200, 11, 90, 6, 'DF');

        $this->SetFont('Arial','B',11);

        $this->SetTextColor(255, 255, 255);
        $this->SetDrawColor(0,0,0);
        $this->SetY(14);$this->SetX(210); $this->MultiCell(70,1,utf8_decode("ESTADO DE CUENTA"),0,'C',0);///////TITUL


        ////////// textos generales

        $this->SetTextColor(0,0,0);
        $this->SetFont('Arial','',11);

        $this->SetY(21);$this->SetX(230); $this->Cell(20,1,"Fecha: ",0, 0,'R', false);///////TITULO

        $this->SetY(21);$this->SetX(257); $this->Cell(30,1,obtenerFechaEnLetra(date("Y-m-d")),0, 0,'R', false);///////TITULO


        $this->SetY(27);$this->SetX(215); $this->MultiCell(35,1,"Moneda: ",0,'R',0);///////TITULO

        $this->SetY(27);$this->SetX(242); $this->MultiCell(45,1,"PESOS",0,'R',0);///////TITULO



        $this->SetFont('Arial','',11);

        $this->SetY(75);$this->SetX(10); $this->Cell(30,1,utf8_decode("Factura"),0, 0,'L', false,"http://comanorsa.com/");///////TITULO

        $this->SetY(75);$this->SetX(40); $this->MultiCell(30,1,utf8_decode("Fecha"),0,'L',0);///////TITULO

        $this->SetY(71);$this->SetX(60); $this->MultiCell(25,3,utf8_decode("Credito  (dias)"),0,'C',0);///////TITULO

        $this->SetY(71);$this->SetX(82); $this->MultiCell(30,3,utf8_decode("Dias transcurridos"),0,'C',0);///////TITULO

        $this->SetY(75);$this->SetX(115); $this->MultiCell(30,1,utf8_decode("Total"),0,'C',0);///////TITULO

        $this->SetY(71);$this->SetX(150); $this->MultiCell(25,3,utf8_decode("Total abonado"),0,'C',0);///////TITULO

        $this->SetY(69);$this->SetX(185); $this->MultiCell(25,4,utf8_decode("Total notas aplicadas"),0,'C',0);///////TITULO

        $this->SetY(75);$this->SetX(215); $this->MultiCell(30,1,utf8_decode("Por saldar"),0,'C',0);///////TITULO

        $this->SetY(75);$this->SetX(250); $this->MultiCell(30,1,utf8_decode("Estatus"),0,'C',0);///////TITULO


        /////************** 



        $this->SetDrawColor(0,0,0);

        $this->SetLineWidth(.5);

        $this->Line(10,80,290,80);



    }

    function Footer(){

        $this->SetY(2);

        $this->SetX(240);

        $this->SetFont('Arial','B',9);

        $this->SetTextColor(0,0,0);

        $this->Cell(30,10,'Hoja '.$this->PageNo().' de {nb}',0,0,'C');

    }



    public function GeneraContenido(  



        $cliente,

        $comercial,

        $rfc,

        $idcliente,

        $estatus,

        $inicio,

        $fin,

        $nfiltro,

        $infocomercial,

        $inforfc,

        $inforazon_social,

        $infodireccion,

        $limite,

        $saldo_total_deudor,

        $total_neto



    ){



        $this->AliasNbPages();

        $this->AddPage('L');

        $this->SetDrawColor(150, 25, 0);

        $this->SetFillColor(150, 25, 0);

        $this->SetLineWidth(0.3);



        include("config.php"); 

        include("includes/mysqli.php");

        include("includes/db.php");

        set_time_limit(600000);

        date_default_timezone_set('America/Mexico_City');



        $lasty=80;


        switch($estatus) {
            
            case 0:

                ///
                $sql2_doc="SELECT x.uuid,x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito,

                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos,x.obs_factura,z.folio

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.idcliente=".$idcliente."



                    UNION ALL



                    SELECT x.uuid,x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <='".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito,

                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos,x.obs_factura,z.folio

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.idcliente=".$idcliente." 

                    ORDER BY fecha DESC";


            break;
            
            case 1:

                ///ACTIVAS

                $sql2_doc="SELECT x.uuid,x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito,

                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos,x.obs_factura,z.folio

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente=".$idcliente."

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."'


                    UNION ALL


                    SELECT x.uuid,x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <='".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito,

                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos,x.obs_factura,z.folio

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente=".$idcliente."

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."' 

                    ORDER BY fecha DESC";


            break;

            case 2:

                ///////// COBRADOS

                $sql2_doc="SELECT x.uuid,x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito,

                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos,x.obs_factura,z.folio

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 1

                    AND x.idcliente=".$idcliente."


                    UNION ALL


                    SELECT x.uuid,x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <='".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito,

                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos,x.obs_factura,z.folio

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 1

                    AND x.idcliente=".$idcliente."

                    ORDER BY fecha DESC";

            break;

            case 3:

                // VENCIDAS

                $sql2_doc="SELECT x.uuid,x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito,

                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos,x.obs_factura,z.folio

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente=".$idcliente."

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."'


                    UNION ALL


                    SELECT x.uuid,x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <='".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito,

                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos,x.obs_factura,z.folio

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente=".$idcliente."

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."' 

                    ORDER BY fecha DESC";

            break;

            case 4:

                /// CANCELADAS

                $sql2_doc="SELECT x.uuid,x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito,

                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos,x.obs_factura,z.folio

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 2

                    AND x.idcliente=".$idcliente."

                    UNION ALL


                    SELECT x.uuid,x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <='".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito,

                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos,x.obs_factura,z.folio

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 2

                    AND x.idcliente=".$idcliente."

                    ORDER BY fecha DESC";

            break;

            case 5:

                $sql2_doc="SELECT x.uuid,x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,0) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito,

                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos,x.obs_factura,z.folio

                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE 

                    x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente=".$idcliente."

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."'

                    OR

                    x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente=".$idcliente."

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."'


                    UNION ALL


                    SELECT x.uuid,x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <='".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar, CONCAT_WS('/',x.pago,x.id,x.total,1) AS dpagos,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito,

                    TIMESTAMPDIFF(DAY, x.fecha, '".date('Y-m-d')."') AS dias_transcurridos,x.obs_factura,z.folio

                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE 

                    x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente=".$idcliente."

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."' 

                    OR

                    x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente=".$idcliente."

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."'

                    ORDER BY fecha ASC";

            break;

        }


        



            $buscar_doc=$db->sql_query($sql2_doc);


            while( $row_doc=$db->sql_fetchrow($buscar_doc) ){

                $fol_fact=$row_doc["fol_fact"];

                $lasty=$lasty+10;

                if ( $lasty > 180 ) {

                        $this->AddPage('L');

                        $lasty = 90;

                }

                //$this->SetY($lasty);$this->SetX(10);$this->MultiCell(25,1,$fol_fact,0,'L',0);///////TITULO
                $this->SetY($lasty);$this->SetX(10); $this->Cell(25,1,$fol_fact,0, 0,'L', false,"https://erp.comanorsa.com.mx/tw/php/facturas/".$fol_fact.".pdf");///////TITULO

                $this->SetY($lasty);$this->SetX(36); $this->MultiCell(30,1,fechaLatin($row_doc["fecha"]),0,'L',0);///////TITULO

                $dias_creditox=$row_doc["dias"];

                $dias_transx=$row_doc["dias_transcurridos"];

                $this->SetY($lasty);$this->SetX(65); $this->MultiCell(15,1,$dias_creditox,0,'C',0);///////TITULO 

                $pagada=$row_doc["pago"];

                if($pagada==0){


                    if($dias_transx>$dias_creditox) {
                      
                        $this->SetTextColor(224,15,15);

                        $this->SetY($lasty);$this->SetX(240); $this->MultiCell(38,1,"VENCIDA",0,'R',0);///////TITULO

                    }else{

                        $this->SetTextColor(4, 58, 136);
                    
                        

                        $this->SetY($lasty);$this->SetX(240); $this->MultiCell(38,1,"ACTIVA",0,'R',0);///////TITULO

                    }

                }else{

                    $this->SetTextColor(36,151,8);

                    $dias_transx=0;

                    $this->SetY($lasty);$this->SetX(240); $this->MultiCell(38,1,"PAGADA",0,'R',0);///////TITULO

                }

                $this->SetY($lasty);$this->SetX(86); $this->MultiCell(15,1,$dias_transx,0,'C',0);///////TITULO

                $this->SetTextColor(0, 0, 0); 


                $this->SetY($lasty);$this->SetX(100); $this->MultiCell(38,1,wims_currency($row_doc["total"]),0,'R',0);///////TITULO



                //////////***************** SUMATORIA DE TODO LOS COBROS DEL SISTEMA PUE,PPD y pagos fuera del sistema

                /////////////************* REVISAR LOS PAGOS DE LA FACTURA 



            

                $sql_pagos="SELECT a.pago AS pagado, 

                (SELECT x.idcpd FROM alta_datos_ppd x WHERE x.id=a.idppd) AS iddatocpp

                FROM alta_pagos_ppd a WHERE a.idfactura=".$row_doc["id"]." AND a.tipo=".$row_doc["tipox"];



                $buscar_pagos=$db->sql_query($sql_pagos);



                $npago=0;


                $pago_factura_ppd=0;


                while( $row_pagos=$db->sql_fetchrow($buscar_pagos) ){


                    
                                  

                    ////VALIDAR QUE EL COMPLEMENTO DE PAGO ESTE FACTURADO 



                    $sql_pagos2="SELECT a.estatus

                    FROM alta_ppd a WHERE a.id=".$row_pagos["iddatocpp"];

                    $buscar_pagos2=$db->sql_query($sql_pagos2);

                    $row_pagos2=$db->sql_fetchrow($buscar_pagos2);


                    if ( $row_pagos2["estatus"] == 1 ) {

                        $pago_factura_ppd=$pago_factura_ppd+$row_pagos["pagado"];

                    }


                }


                /////////// REVISAR PAGO EXTERNO AL SISTEMA

                $sql3="SELECT SUM(total) AS totalx FROM `alta_pago_cxc` WHERE idfactura=".$row_doc['id']." AND tipo=".$row_doc['tipox'];
                $buscar3=$db->sql_query($sql3);
                $row3=$db->sql_fetchrow($buscar3);


                $pago_factura_ppd=$pago_factura_ppd+$row3["totalx"];



                $this->SetY($lasty);$this->SetX(139); $this->MultiCell(35,1,wims_currency($pago_factura_ppd),0,'R',0);///////TITULOtotncredito

                $this->SetY($lasty);$this->SetX(178); $this->MultiCell(35,1,wims_currency($row_doc["totncredito"]),0,'R',0);///////TITULOtotncredito


                $xsaldar=$row_doc["total"]-$pago_factura_ppd-$row_doc["totncredito"];

                $this->SetY($lasty);$this->SetX(213); $this->MultiCell(35,1,wims_currency($xsaldar),0,'R',0);///////TITULOtotncredito

            }



    }       



}





$pdf = new PDF();



include("config.php"); 

include("includes/mysqli.php");

include("includes/db.php");

set_time_limit (600000);

date_default_timezone_set('America/Mexico_City');



//$folio_fact = "A7055";

$idcliente=trim($_POST["cliente"]);

$estatus=trim($_POST["estx"]);

//$inicio='';//trim($_POST["finicial"]);

//$fin='';//trim($_POST["finicial"]);

//$nfiltro=1;



//$folio_fact = "A7055";

/*$idcliente=trim($_POST["buscar"]);

$estatus=trim($_POST["estatusx"]);

$inicio=trim($_POST["inicio"]);

$fin=trim($_POST["fin"]);

$nfiltro=trim($_POST["nfiltrox"]);*/



/////////////***************** DATOS GENERALES 



$sql_info = "SELECT comercial,rfc,razon_social,direccion FROM `datos_generales` WHERE id = 2";

$buscar_info = $db->sql_query($sql_info);

$row_info = $db->sql_fetchrow($buscar_info);



$infocomercial = utf8_decode($row_info["comercial"]);

$inforfc = utf8_decode($row_info["rfc"]);

$inforazon_social = utf8_decode($row_info["razon_social"]);

$infodireccion = utf8_decode($row_info["direccion"]);



//////// CLIENTE 



$sql="SELECT a.nombre,a.comercial,a.rfc,a.limite FROM alta_clientes a WHERE a.id=".$idcliente;

$buscar=$db->sql_query($sql);

$row=$db->sql_fetchrow($buscar);



$cliente=$row["nombre"];

$comercial=$row["comercial"];

$rfc=$row["rfc"];

$limite=$row["limite"];



/////////// BALANCE DE SALDOS 


///***  TOTAL ENCABEZADOS SOLO SALDO VENCIDO ***********//////////////////



        $sql ="SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito



                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$idcliente."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."' 



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito



                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago=0

                    AND x.idcliente='".$idcliente."'

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."' ";



                    //echo $sql;

        $total=0;



        $total_neto=0;

        //$total_ncredito=0;

        $prepare2=$db->sql_prepare($sql);
        $datos_vencidas=$db->sql_numrows($prepare2);


        if( $datos_vencidas>0 ){

            
            $buscar=$db->sql_query($sql);

            while( $row= $db->sql_fetchrow($buscar) ){



                $pagox=$row["pago"];



          

                    

                    $sumatotal = 0;

                                

                    $sql2="SELECT a.pago AS pagado, 

                          (SELECT x.idcpd FROM alta_datos_ppd x WHERE x.id=a.idppd) AS iddatocpp

                          FROM alta_pagos_ppd a WHERE a.idfactura=".$row['id']." AND a.tipo=".$row['tipox'];

                          $buscar2=$db->sql_query($sql2);

                            while( $row2= $db->sql_fetchrow($buscar2) ){



                                $sql3="SELECT a.estatus

                                  FROM alta_ppd a WHERE a.id=".$row2['iddatocpp'];

                                  $buscar3=$db->sql_query($sql3);

                                while( $row3= $db->sql_fetchrow($buscar3) ){





                                    if ( $row3["estatus"] == 1 ) {

                                                          

                                          $sumatotal=$sumatotal+$row2["pagado"];



                                      }



                                }



                            }



                    $total=$total+$sumatotal;



                    //////////************ SUMAR LOS PAGOS FUERA DEL SISTEMA



                    $sql3="SELECT SUM(totalx) AS totalx FROM `alta_pago_cxc` WHERE idfactura=".$row['id']." AND tipo=".$row['tipox'];

                    $buscar3=$db->sql_query($sql3);

                        $row3=$db->sql_fetchrow($buscar3);



                    $total=$total+$row3["totalx"];




                    $total_neto=$total_neto+$row["total"];



                    //$total_ncredito=$total_ncredito+$row["totncredito"];



            }


        }



      ///***  TOTAL ENCABEZADOS SOLO SALDO ACTIVO ***********//////////////////



          $sql_act ="SELECT x.id, x.pago, x.fecha, '0' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar,

                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=0) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=0) ) AS totncredito



                    FROM alta_factura x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente='".$idcliente."' 

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."' 



                    UNION ALL



                    SELECT x.id, x.pago, x.fecha, '1' AS tipox, 'Factura' AS documento, y.nombre AS cliente, x.subtotal, x.descuento, x.iva, x.total,

                    CONCAT_WS('/',x.id,x.pago,x.estatus) AS boton,

                    DATE_ADD(x.fecha,INTERVAL x.dias DAY) AS fcobro,x.dias,

                    CONCAT_WS( '/',IF( DATE_ADD(x.fecha,INTERVAL x.dias DAY) <= '".date('Y-m-d')."',1,0 ),x.pago,x.estatus ) AS est_pago,

                    CONCAT_WS('',z.serie,z.folio) AS fol_fact, '0' AS cobrado, '0' AS xpagar,



                    ( (SELECT IFNULL(SUM(z.importe),0) FROM aplicacion_pagos_nc z WHERE z.idfactura=x.id AND z.estatus=0 AND z.tipo=1) + (SELECT IFNULL(SUM(w.importe),0) FROM aplicacion_pagos_nc_fuera_sistema w WHERE w.idfactura=x.id AND w.estatus=0 AND w.tipo=1) ) AS totncredito



                    FROM alta_factura_sustitucion x, alta_clientes y, folio_factura z

                    WHERE x.idcliente=y.id

                    AND x.idfolio=z.id

                    AND x.estatus = 1

                    AND x.pago = 0

                    AND x.idcliente='".$idcliente."' 

                    AND DATE_ADD(x.fecha,INTERVAL x.dias DAY) > '".date('Y-m-d')."' ";





        $total_act=0;



        $total_neto_act=0;

      


        $buscar_act=$db->sql_query($sql_act);

        while( $row_act= $db->sql_fetchrow($buscar_act) ){



            $pago_act=$row_act["pago"];



            if ( $pago_act==0 ) {

                

                $sumatotal_act = 0;

                            

                $sql2_act="SELECT a.pago AS pagado, 

                (SELECT x.idcpd FROM alta_datos_ppd x WHERE x.id=a.idppd) AS iddatocpp

                FROM alta_pagos_ppd a WHERE a.idfactura=".$row_act['id']." AND a.tipo=".$row_act['tipox'];

                $buscar2_act=$db->sql_query($sql2_act);

                while( $row2_act= $db->sql_fetchrow($buscar2_act) ){



                    $sql3_act="SELECT a.estatus

                    FROM alta_ppd a WHERE a.id=".$row2_act['iddatocpp'];

                    $buscar3_act=$db->sql_query($sql3_act);

                    while( $row3_act= $db->sql_fetchrow($buscar3_act) ){





                        if ( $row3_act["estatus"] == 1 ) {

                                            

                            $sumatotal_act=$sumatotal_act+$row2_act["pagado"];



                        }



                    }



                }



                $total_act=$total_act+$sumatotal_act;



                //////////************ SUMAR LOS PAGOS FUERA DEL SISTEMA



                $sql4_act="SELECT SUM(totalx) AS totalx FROM `alta_pago_cxc` WHERE idfactura=".$row_act['id']." AND tipo=".$row_act['tipox'];

                $buscar4_act=$db->sql_query($sql4_act);

                $row4_act=$db->sql_fetchrow($buscar4_act);



                $total_act=$total_act+$row4_act["totalx"];



            }elseif( $pago_act==1 ) {

                

                $total_act=$total_act+$row_act["total"];



            }



            $total_neto_act=$total_neto_act+$row_act["total"];



            //$total_ncredito_act=$total_ncredito_act+$row_act["totncredito"];



        }

        ///////// SALDO TOTAL_DEUDOR = TOTAL SALDO VENCIDO - TOTAL SALDO ACTIVO 

        $saldo_total_deudor=$total_neto+$total_neto_act;





$pdf->GeneraContenido(



    $cliente,

    $comercial,

    $rfc,

    $idcliente,

    $estatus,

    $inicio,

    $fin,

    $nfiltro,

    $infocomercial,

    $inforfc,

    $inforazon_social,

    $infodireccion,

    $limite,

    $saldo_total_deudor,

    $total_neto



);



$nombrearchivo = "estado_cuenta/edc".$idcliente.".pdf";

$nombrearchivo="Estado de cuenta".substr($cliente,1,15).".pdf";

$pdf->Output($nombrearchivo, 'F');

//$pdf->Output();

echo json_encode($idcliente);





?>