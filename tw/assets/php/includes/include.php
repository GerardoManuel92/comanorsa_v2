<?php 
  function tipoImagen($esTipo){
  static $ext;
  switch ($esTipo) {
  case "image/pjpeg":
  $ext="jpg";
  break;
  case "image/bmp":
  $ext="bmp";
  break;
  case "image/gif":
  $ext="gif";
  break;
  default:
  $ext="archivo no valido";
  break;
  }
 return $ext;
  }
function get_type_text($type){
switch ($type){
case 1:
$return_text="Escribe el Nombre de tu escuela y la Bienvenida";
break;
case 2:
$return_text="Escribe lo que podemos encontrar en tu pagina";
break;
case 3:
$return_text="Escribe el texto que encontraremos en el Periódico mural";
break;
case 4:
$return_text="Escribe el contenido del Peridico Mural";
break;
case 5:
$return_text="Escribe el texto que encontraremos en Festivales y concursos";
break;
case 6:
$return_text="Escribe el contenido de Festivales y concursos";
break;
case 7:
$return_text="Escribe el texto que encontraremos en Libro Colectivo";
break;
case 8:
$return_text="Escribe el contenido del Libro Colectivo";
break;
case 9:
$return_text="Escribe el texto que encontraremos en Museo escolar";
break;
case 10:
$return_text="Escribe el contenido del Museo escolar";
break;
case 11:
$return_text="Escribe el texto que encontraremos en proyectos extra curriculares";
break;
case 12:
$return_text="Escribe el contenido de proyectos extra curriculares";
break;
case 13:
$return_text="Escribe el texto que encontraremos en noticias y avisos";
break;
case 14:
$return_text="Escribe el contenido de noticias y avisos";
break;
case 15:
$return_text="Escribe el texto que encontraremos en Comentarios";
break;
case 16:
$return_text="Escribe el contenido en Comentarios";
break;
case 17:
$return_text="Escribe el contenido en Comentarios";
break;
case 18:
$return_text="Escribe el contenido en Comentarios";
break;
case 19:
$return_text="Escribe el texto que encontraremos en Calendario";
break;
case 20:
$return_text="Escribe el contenido en Calendario";
break;
case 21:
$return_text="Escribe el texto que encontraremos en Calificaciones";
break;
case 22:
$return_text="Escribe el contenido en Calificaciones";
break;
case 23:
$return_text="Escribe el texto que encontraremos en Noticias";
break;
case 24:
$return_text="Escribe el contenido en Noticias";
break;
}
return $return_text;
}
function get_correct_file($type){
switch ($type){
case 1:
$return_file="aat.php";
break;
case 2:
$return_file="header.php";
break;
case 3:
$return_file="at.php";
break;
case 4:
$return_file="bt.php";
break;
case 5:
$return_file="ct.php";
break;
case 6:
$return_file="dt.php";
break;
case 7:
$return_file="et.php";
break;
case 8:
$return_file="ft.php";
break;
case 9:
$return_file="gt.php";
break;
case 10:
$return_file="ht.php";
break;
case 11:
$return_file="it.php";
break;
case 12:
$return_file="jt.php";
break;
case 13:
$return_file="kt.php";
break;
case 14:
$return_file="lt.php";
break;
case 15:
$return_file="mt.php";
break;
case 16:
$return_file="ot.php";
break;
case 17:
$return_file="lot.php";
break;
case 18:
$return_file="mot.php";
break;
case 19:
$return_file="jul.php";
break;
case 20:
$return_file="ag.php";
break;
case 21:
$return_file="set.php";
break;
case 22:
$return_file="act.php";
break;
case 23:
$return_file="ese.php";
break;
case 24:
$return_file="dul.php";
break;
}
return $return_file;
}

function get_correct_file_top($type){
switch ($type){
case 1:
$return_file="menu1.php";
break;
case 2:
$return_file="menu2.php";
break;
case 3:
$return_file="menu3.php";
break;
case 4:
$return_file="menu4.php";
break;
case 5:
$return_file="menu5.php";
break;
case 6:
$return_file="menu6.php";
break;
}
return $return_file;
}
function get_text_file($nuevoModulo){
switch ($nuevoModulo){
case 0:
$return_text_file="";
break;
case 1:
$return_text_file="<a href=am.php>Periodico mural</a>";
break;
case 2:
$return_text_file="<a href=festivales.php>festivales y concursos</a>";
break;
case 3:
$return_text_file="<a href=libro.php>libro colectivo</a>";
break;
case 4:
$return_text_file="<a href=museo.php>museo escolar</a>";
break;
case 5:
$return_text_file="<a href=proyectos.php>proyectos extra curriculares</a>";
break;
case 6:
$return_text_file="<a href=avisos.php>noticias y avisos</a>";
break;
case 7:
$return_text_file="<a href=comentarios.php>comentarios</a>";
break;
}
return $return_text_file;
}
function get_url($folder){
$me = $_SERVER['PHP_SELF']; 
$Apathweb = explode("/", $me); 
$myFileName = array_pop($Apathweb); 
$pathweb = implode("/", $Apathweb); 
$myURL = "http://".$_SERVER['HTTP_HOST'].$pathweb."/".$folder."/"; 
return $myURL; 
}
function get_physical($folder){
$pathfile = getcwd (); 
strstr( PHP_OS, "WIN") ? $strPathSeparator = "\\" : $strPathSeparator = "/"; 
$myPhysical = $pathfile.$strPathSeparator.$folder;//.$myFileName; 
return $myPhysical; 
}
function get_date(){
$mes=date("n");
$dia=date("j");
$year=date("Y");
$meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fecha=$dia. " de ".$meses[$mes]. " del ".$year;
return $fecha;
}
function get_dateshort(){

 $date=date("j")."/".date("n")."/".date("Y");
 return $date;
}
function get_timeunix(){
$mes=date("n");
$dia=date("j");
$year=date("Y");
$timenow = mktime(0,0,0,$mes,$dia,$year); 
return $timenow;
}
function get_month(){
$getmeses=array("","Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
return $getmeses;
}
function get_date1($year,$mes,$dia){
switch($mes){
case "01" :
$mes1=1;
break;
case "02" :
$mes1=2;
break;
case "03" :
$mes1=3;
break;
case "04" :
$mes1=4;
break;
case "05" :
$mes1=5;
break;
case "06" :
$mes1=6;
break;
case "07" :
$mes1=7;
break;
case "08" :
$mes1=8;
break;
case "09" :
$mes1=9;
break;
case "10" :
$mes1=10;
break;
case "11" :
$mes1=11;
break;
case "12" :
$mes1=12;
break;
}
$meses=array("Ene","Feb","Mar","Abr","May","Jun","Jul","Agos","Sept","Oct","Nov","Dic");
//$meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
$fecha=$dia. "-".$meses[$mes1]. "-".$year;
return $fecha;
}
?>