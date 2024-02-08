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



        global $folio;

        global $fecha;

        global $observaciones;

        global $usuario;

        global $comercial;

        global $contacto;

        global $folioX;

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

      

        ///////***************** ENCABEZADO



        $this->SetDrawColor(250,250,250);

        $this->SetFillColor(243,243,243);

        $this->Rect(10, 11, 190, 22, 'DF');



        $this->Image("logo_icono.png",14,14,21,18,"PNG","http://comanorsa.com/");



        $this->SetFont('Arial','',11);



        $this->SetTextColor(0, 0, 0);

        $this->SetDrawColor(0,0,0);

        $this->SetY(15);$this->SetX(40); $this->MultiCell(85,1,$infocomercial,0,'C',0);///////TITULO





        $this->SetFont('Arial','B',7);

        $this->SetY(21);$this->SetX(40); $this->MultiCell(85,1,$inforazon_social." ".$inforfc,0,'L',0);///////TITULO



        $this->SetFont('Arial','',7);



        $this->SetY(24);$this->SetX(40); $this->MultiCell(85,3,utf8_decode($infodireccion),0,'L',0);///////TITULO



        $this->SetFont('Arial','B',8);



        $this->SetY(21);$this->SetX(130); $this->MultiCell(30,1,utf8_decode("Folio:"),0,'L',0);///////

        //$this->SetY(29);$this->SetX(130); $this->MultiCell(30,1,utf8_decode("Moneda:"),0,'L',0);///////

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

        $this->SetY(20);$this->SetX(165); $this->MultiCell(35,1,$folioX,0,'R',0);///////



        $this->SetFont('Arial','B',12);



        ////////////// INFORMACION DE LA RQ



        $this->SetDrawColor(250,250,250);

        $this->SetFillColor(243,243,243);

        $this->Rect(10, 34, 190, 12, 'DF');



        $this->SetFont('Arial','B',8);

        $this->SetTextColor(0, 0, 0);

        $this->SetDrawColor(0,0,0);



        //$this->SetY(37);$this->SetX(14); $this->MultiCell(9,2,"Correo: ",0,'L',0);///////TITULO

        //$this->SetY(43);$this->SetX(14); $this->MultiCell(150,0,"Domicilio:",0,'L',0);///////TITULO

        $this->SetY(37);$this->SetX(14); $this->MultiCell(15,2,"Usuario:",0,'L',0);///////TITULO

        //$this->SetY(52);$this->SetX(82); $this->MultiCell(25,2,"Metodo de pago: ",0,'L',0);///////TITULO



        /*$this->SetY(64);$this->SetX(50); $this->MultiCell(140,0,"Entregar a:".,0,'R',0);///////TITULO*/



        $this->SetFont('Arial','',8);

        //$this->SetY(37);$this->SetX(22); $this->MultiCell(30,2,strtoupper($rfc),0,'L',0);///////TITULO

        //$this->SetY(42);$this->SetX(28); $this->MultiCell(170,2,strtoupper( utf8_decode($direccion) ),0,'L',0);///////TITULO

        $this->SetY(37);$this->SetX(50); $this->MultiCell(130,2,strtoupper( utf8_decode($usuario) ),0,'L',0);///////TITULO

        //$this->SetY(52);$this->SetX(105); $this->MultiCell(88,2,utf8_decode("Pago en una sola exhibición"),0,'L',0);///////TITULO





        $this->SetDrawColor(134,187,224);

        $this->SetFillColor(134,187,224);

        $this->Rect(130, 11, 70, 6, 'DF');



        $this->SetFont('Arial','B',11);



        $this->SetTextColor(255, 255, 255);

        $this->SetDrawColor(0,0,0);

        $this->SetY(15);$this->SetX(130); $this->MultiCell(70,1,utf8_decode("Ajuste de entrada"),0,'C',0);///////TITULO



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

        $this->Rect(10, 47, 190, 5, 'DF');



        $this->SetFont('Arial', 'B', 8);

        $this->SetTextColor(255, 255, 255);



        $this->SetY(50.2);

        $this->SetX(12);

        $this->MultiCell(25, 0, 'IMAGEN',0,'C',1); ///////importe con letra



        $this->SetY(50.2);

        $this->SetX(38);

        $this->MultiCell(25, 0, 'CANTIDAD', 0, 'R', 1); ///////importe con letra



        $this->SetY(50.2);

        $this->SetX(64);

        $this->MultiCell(55, 0, 'DECRIPCION', 0, 'L', 1); ///////importe con letra



        $this->SetY(50.2);

        $this->SetX(141);

        $this->MultiCell(27, 0, 'UNITARIO', 0, 'R', 1); ///////importe con letra



        $this->SetY(50.2);

        $this->SetX(169);

        $this->MultiCell(29, 0, 'IMPORTE', 0, 'R', 1); ///////importe con letra





        $this->SetTextColor(0,0,0);

        

        $this->SetFont('Arial','',6);

        $this->SetY(48);







    }

    function Footer(){

        $this->SetY(2);

        $this->SetX(167);

        $this->SetFont('Arial','B',9);

        $this->SetTextColor(0,0,0);

        $this->Cell(30,10,'Hoja '.$this->PageNo().' de {nb}',0,0,'C');

    }



    public function GeneraContenido(  



        $folio,

        $fecha,

        $observaciones,

        $usuario,

        $correo,

        $contacto,

        $direccion,

        $fpago,

        $telefonos,

        $rfc,

        $infocomercial,

        $inforfc,

        $inforazon_social,

        $infodireccion,

        $moneda,

        $tcambio,

        $folioX



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


            $selectPart = "SELECT a.cantidad,a.costo,a.tot_total,b.nparte,b.descripcion, a.iva, a.tot_iva, a.cantidad,b.nparte AS clave,c.marca AS marcax, b.img, a.idparte, d.abr AS unidad, e.observaciones as motivo
                            FROM partes_ajuste_entrada a, alta_productos b, alta_marca c, sat_catalogo_unidades d, alta_ajuste_entrada e
                            WHERE
                            a.idparte=b.id 
                            AND e.id = a.idajuste
                            AND b.idmarca = c.id
                            AND b.idunidad=d.id
                            AND a.idajuste=".$folio."
                            AND a.estatus=0";



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

            $total_lineas = strlen( utf8_decode( strtoupper($row['descripcion']) ) );

            $nlineas = ceil($total_lineas/48)*5;

            $this->SetFont('Arial','',7);



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



            $suma_subtotal = $suma_subtotal+($row['costo']*$row['cantidad']);

            $suma_iva = /* $suma_iva+ */round($row['iva'],2);

            $suma_descuento = $suma_descuento+round($row['tot_iva'],2);



            //$descuentos = $suma_subtotal-$suma_descuento+$suma_iva;



            $suma_total = $suma_total+$row['tot_total'];

            

            

            if ($valor_incremento > 270) {



                $this->AddPage();



                $valory = $valor_init;



                $last_y = 65;



                $this->SetY($valory+5);$this->SetX(64);$this->MultiCell(85,$InterLigne,utf8_decode("CLAVE: ".$row['clave']."\n"."MARCA: ".$row['marcax']."\n".strtoupper($row['descripcion']) ),0,'J',0,0);



                if ( $row["img"] == 1 ) {



                    $nombre_fichero  = "../../comanorsa/productos/".$row["idparte"].".jpg";



                    ////************ COLOCAR IMAGEN 

                    if ( file_exists($nombre_fichero) ) {



                        $this->Image($nombre_fichero,9,$valory+4,30,25,"JPG","http://comanorsa.com/");



                    } else {



                        $this->Image("no_disponible.jpg",9,$valory+4,30,25,"JPG","http://comanorsa.com/");



                        

                    }



                }else{



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

                $this->SetX(169);$this->MultiCell(29,0,wims_currency($row['costo']*$row['cantidad']), 0, 'R', 0);



               // if( $row['tcambio'] == 1 ) {

                    

                    $this->SetY($valory+11);

                    $this->SetTextColor(0, 0, 0);    

                    $this->SetFont('Arial','B',7);    

                    $this->SetX(152);$this->MultiCell(20,0,"MXN", 0, 'C', 0);



                //}elseif( $row['tcambio'] > 1) {

                    

                   // $this->SetY($valory+11);

                    //$this->SetTextColor(255, 0, 0); 

                    //$this->SetFont('Arial','B',7);

                    //$this->SetX(152);$this->MultiCell(20,0,"USD TC ".$row['tcambio'], 0, 'C', 0);



                //}



                $valory = $last_y+$nlineas;



            }else{



                $this->SetY($valory+4);$this->SetX(64);$this->MultiCell(85,$InterLigne,utf8_decode("CLAVE: ".$row['clave']."\n"."MARCA: ".$row['marcax']."\n".strtoupper($row['descripcion']) ),0,'J',0,0);



                if ( $row["img"] == 1 ) {



                    $nombre_fichero  = "../../comanorsa/productos/".$row["idparte"].".jpg";



                    ////************ COLOCAR IMAGEN 

                    if ( file_exists($nombre_fichero) ) {



                        $this->Image($nombre_fichero,9,$valory+4,30,25,"JPG","http://comanorsa.com/");



                    } else {



                        $this->Image("no_disponible.jpg",9,$valory+4,30,25,"JPG","http://comanorsa.com/");



                        

                    }



                }else{



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

                $this->SetX(169);$this->MultiCell(29,0,wims_currency($row['costo']*$row['cantidad']), 0, 'R', 0);



                //if( $row['tcambio'] == 1 ) {

                    

                    $this->SetY($valory+11);

                    $this->SetTextColor(0, 0, 0);    

                    $this->SetFont('Arial','B',7);    

                    $this->SetX(152);$this->MultiCell(20,0,"MXN", 0, 'C', 0);



                //}elseif( $row['tcambio'] > 1) {

                    

                   // $this->SetY($valory+11);

                   // $this->SetTextColor(255, 0, 0); 

                   // $this->SetFont('Arial','B',7);

                   // $this->SetX(152);$this->MultiCell(20,0,"USD TC ".$row['tcambio'], 0, 'C', 0);



                //}



                $valory = $valor_incremento;



            }





        }





        //////////////////////////////////////////////*********** FOOTER



        /*$valory_final = $this->GetY(); 



        if ( $valory_final > 240 ) {

            





        }*/





        /*$this->SetDrawColor(0,0,0);

        $this->SetFillColor(255,255,255);

        $this->Rect(10, $last_y+10, 190, 36, 'DF');//240*/





        //$valory_totales = $this->GetY();



        if ( $valory > 240 ) {

            

            $this->AddPage();

            $last_y = 65;



            $this->SetFont('Arial', 'B', 9);

            $this->SetTextColor(0, 0, 0);



            $this->SetX(17);



            $this->SetFont('Arial', 'B', 7);

            $this->SetY($last_y+12);

            $this->MultiCell(120, 5, "Motivo: ".$observaciones,0, 'L', 0); ///////importe con letra



            ///////******* SUBTOTAL



            $this->SetFont('Arial', '', 9);

            $this->SetY($last_y+17);

            $this->SetX(125);

            $this->MultiCell(30, 0, 'Subtotal', 0, 'R', 0); ///////importe con letra



           

            $this->SetY($last_y+23);

            $this->SetX(125);

            $this->MultiCell(30, 0, 'Costo de IVA', 0, 'R', 0); ///////importe con letra



           

            $this->SetY($last_y+29);

            $this->SetX(125);

            $this->MultiCell(30, 0, 'Iva', 0, 'R', 0); ///////importe con letra





            $this->SetY($last_y+35      );

            $this->SetX(125);

            $this->MultiCell(30, 0, 'Total', 0, 'R', 0); ///////importe con letra





            ////////// CALCULO 



            $total = $suma_subtotal-$suma_descuento;

            /*$iva = $total-$suma_subtotal;*/

            

            $this->SetY($last_y+17);

            $this->SetX(145);

            $this->MultiCell(50, 0, wims_currency($suma_subtotal), 0, 'R', 0); ///////SUBTOTAL



            $this->SetTextColor(226, 16, 16);



            $this->SetY($last_y+23);

            $this->SetX(145);

            $this->MultiCell(50, 0, "+ ".wims_currency($suma_descuento), 0, 'R', 0); ///////IVA



            $this->SetTextColor(0, 0, 0);

            $this->SetY($last_y+29);

            $this->SetX(145);

            $this->MultiCell(50, 0, /* wims_currency */($suma_iva), 0, 'R', 0); ///////TOTAL



            $this->SetFont('Arial', 'B', 11);

            $this->SetY($last_y+35);

            $this->SetX(145);

            $this->MultiCell(50, 0, wims_currency($total), 0, 'R', 0); ///////TOTAL



            $this->SetFont('Arial', 'B', 6);

            $this->SetY($last_y+40);



            //////////******************** MONEDA Y TIPO DE CAMBIO 

            switch ($moneda) {



                case 1:

                    

                    $infomoneda = "PESOS";



                break;

                

                case 2:

                    

                    $infomoneda = "DOLARES";



                break;

            }





            $this->MultiCell(185, 3, letras2($total,$infomoneda), 0, 'R', 0); ///////importe con letra



            $this->SetFont('Arial', '', 7);

            $this->SetTextColor(27, 97, 218);

            $this->SetY($last_y+35);



            if ( dias_hasta_fin_mes() > 4 ) {

            

                $dias = 5;



            }else{



                $dias = dias_hasta_fin_mes();



            }



            //$this->MultiCell(120, 3, utf8_decode("**Vigencia: ".$dias." días hábiles del mes en curso o hasta agotar existencias, imágenes con fines ilustrativos el producto real puede variar"), 0, 'L', 0); ///////importe con letra



        }else{





            $this->SetFont('Arial', 'B', 9);

            $this->SetTextColor(0, 0, 0);



            $this->SetX(17);



            $this->SetFont('Arial', 'B', 7);

            $this->SetY($last_y+12);

            $this->MultiCell(120, 5, "Motivo: ".$observaciones,0, 'L', 0); ///////importe con letra



            ///////******* SUBTOTAL



            $this->SetFont('Arial', '', 9);

            $this->SetY($last_y+17);

            $this->SetX(125);

            $this->MultiCell(30, 0, 'Subtotal', 0, 'R', 0); ///////importe con letra



           

            $this->SetY($last_y+23);

            $this->SetX(125);

            $this->MultiCell(30, 0, 'Costo de IVA', 0, 'R', 0); ///////importe con letra



           

            $this->SetY($last_y+29);

            $this->SetX(125);

            $this->MultiCell(30, 0, 'Iva', 0, 'R', 0); ///////importe con letra





            $this->SetY($last_y+35      );

            $this->SetX(125);

            $this->MultiCell(30, 0, 'Total', 0, 'R', 0); ///////importe con letra





            ////////// CALCULO 



            $total = $suma_subtotal+$suma_descuento;

            /*$iva = $total-$suma_subtotal;*/

            

            $this->SetY($last_y+17);

            $this->SetX(145);

            $this->MultiCell(50, 0, wims_currency($suma_subtotal), 0, 'R', 0); ///////SUBTOTAL



            $this->SetTextColor(226, 16, 16);



            $this->SetY($last_y+23);

            $this->SetX(145);

            $this->MultiCell(50, 0, "+ ".wims_currency($suma_descuento), 0, 'R', 0); ///////IVA



            $this->SetTextColor(0, 0, 0);

            $this->SetY($last_y+29);

            $this->SetX(145);

            $this->MultiCell(50, 0, /* wims_currency */($suma_iva), 0, 'R', 0); ///////TOTAL



            $this->SetFont('Arial', 'B', 11);

            $this->SetY($last_y+35);

            $this->SetX(145);

            $this->MultiCell(50, 0, wims_currency($total), 0, 'R', 0); ///////TOTAL



            



            



            



            $this->SetFont('Arial', 'B', 6);

            $this->SetY($last_y+40);



            //////////******************** MONEDA Y TIPO DE CAMBIO 

            switch ($moneda) {



                case 1:

                    

                    $infomoneda = "PESOS";



                break;

                

                case 2:

                    

                    $infomoneda = "DOLARES";



                break;

            }





            $this->MultiCell(185, 3, letras2($total,$infomoneda), 0, 'R', 0); ///////importe con letra



            $this->SetFont('Arial', '', 7);

            $this->SetTextColor(27, 97, 218);

            $this->SetY($last_y+35);



            if ( dias_hasta_fin_mes() > 4 ) {

            

                $dias = 5;



            }else{



                $dias = dias_hasta_fin_mes();



            }



            //$this->MultiCell(120, 3, utf8_decode("**Vigencia: ".$dias." días hábiles del mes en curso o hasta agotar existencias, imágenes con fines ilustrativos el producto real puede variar"), 0, 'L', 0); ///////importe con letra





        }



        ////////************** AVCTUALIZAR LOS IMPORTES DE LA ODC



        $sql_upt="UPDATE alta_cotizacion SET subtotal='".$suma_subtotal."', descuento='".$suma_descuento."', iva='".$suma_iva."', total='".$total."' WHERE id=".$folio;

        $db->sql_query($sql_upt);



    }       



}





$pdf = new PDF();



include("config.php"); 

include("includes/mysqli.php");

include("includes/db.php");

set_time_limit (600000);

date_default_timezone_set('America/Mexico_City');



$folio =trim($_POST["folio"]);
//$folio = 28;


$query = 'SELECT a.fecha, a.observaciones, b.nombre AS usuario, b.correo AS correo, b.telefono AS telefono
            FROM alta_ajuste_entrada a, alta_usuarios b
            WHERE
            a.idusuario=b.id
            AND a.idusuario=b.id
            AND a.id ='.$folio;



$buscar = $db->sql_query($query);

$row2 = $db->sql_fetchrow($buscar);

    

$fecha = obtenerFechaEnLetra($row2["fecha"]);

$observaciones = utf8_decode($row2["observaciones"]);

$usuario = ($row2["usuario"]);

$correo = utf8_decode($row2["correo"]);

$contacto = utf8_decode($row2["telefono"]);



$direccion = "";


/*
$dir = 'SELECT calle,exterior,interior,colonia,municipio,estado,cp FROM `direccion_clientes` WHERE idcliente=(SELECT x.idcliente FROM alta_cotizacion x WHERE x.id='.$folio.') LIMIT 0,1';

$buscar_dir = $db->sql_query($dir);

$row_dir = $db->sql_fetchrow($buscar_dir);
*/


$calle = "calle";

$colonia = "colonia";

$exterior = "exterior";

$interior = "interior";

$municipio = "municipio";

$estado = "estado";

$cp = "cp";



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



if ( $estado != "" ) {

    

    $direccion.=" Cp.".$cp;



}





$fpago = "fpago";

$telefonos ="telefonos";

$correo ="correo";

$rfc =$correo;

$moneda = "moneda";

$tcambio = "tcambio";

//////////************** CREAR FOLIO ODV0010000

$folioX = 0;

$inicio = 10000;

$nuevo = $inicio+$folio;



switch ( strlen($nuevo) ) {



    case 5:

        

        $folioX = "APE00".$nuevo;



    break;



    case 6:

        

        $folioX = "APE0".$nuevo;



    break;



    case 7:

        

        $folioX = "APE".$nuevo;



    break;



    default:



        $folioX = "s/asignar";



    break;



}



/////////////***************** DATOS GENERALES 



$sql_info = "SELECT comercial,rfc,razon_social,direccion FROM `datos_generales` WHERE id = 2";

$buscar_info = $db->sql_query($sql_info);

$row_info = $db->sql_fetchrow($buscar_info);



$infocomercial = utf8_decode($row_info["comercial"]);

$inforfc = utf8_decode($row_info["rfc"]);

$inforazon_social = utf8_decode($row_info["razon_social"]);

$infodireccion = utf8_decode($row_info["direccion"]);



$pdf->GeneraContenido(



    $folio,

    $fecha,

    $observaciones,

    $usaurio,

    $correo,

    $contacto,

    $direccion,

    $fpago,

    $telefonos,

    $rfc,

    $infocomercial,

    $inforfc,

    $inforazon_social,

    $infodireccion,

    $moneda,

    $tcambio, 

    $folioX





);



$nombrearchivo = "ajustes/".$folioX.".pdf";

$pdf->Output($nombrearchivo, 'F');

//pdf->Output();

$sql = "UPDATE `alta_ajuste_entrada` SET `documento` = '".$folioX."' WHERE `id`=".$folio;
$db->sql_query($sql);

echo json_encode($folioX,$folio);





?>