<?php

function textOracion($x, $valor){

	if($valor == 0){

		$valortxt = ucwords(strtolower($x));

	}else{

		$valortxt = strtoupper($x);

	}
	

	return $valortxt;

}

function obtenerFechaEnLetra($fecha){
    $num = date("j", strtotime($fecha));
    $anno = date("Y", strtotime($fecha));
    $mes = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $mes = $mes[(date('m', strtotime($fecha))*1)-1];
    return $num.' de '.$mes.' del '.$anno;
}

function moneda($number) { 
   if ($number < 0) { 
     $print_number = "($ " . str_replace('-', '', number_format ($number, 2, ".", ",")) . ")"; 
    } else { 
     $print_number = "$ " .  number_format ($number, 2, ".", ","); 
   } 
   return $print_number; 
} 


function fechaIngles($fechaIni){
$inicio=explode("/",$fechaIni);
$cod=strlen($inicio[1]);
if($cod==1){
$inicio[1]="0".$inicio[1];
}
return $inicio[2]."-".$inicio[1]."-".$inicio[0];
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

function diferenciaDias($fecha_inicial , $fecha_final ){


        $date1 = new DateTime($fecha_inicial);
        $date2 = new DateTime($fecha_final);
        $diff = $date1->diff($date2);

        return $diff->days;

}

?>