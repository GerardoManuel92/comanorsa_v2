<?php

	
	function redondedoFloat($cantidad,$decimales){

        	return number_format((float)$cantidad, $decimales, '.', '');

    }

	$operacion=redondedoFloat( (0/100),2 );

	echo $operacion; 

?> 

