<?php

	//// test do while

	$almacen= 4;
	$pedido=8;

	$total_asignadas=2;

	$solicitados=$pedido-$total_asignadas;

	$producto1=2;
	$producto2=1;
	$producto3=3;

	$i=0;


	if($almacen > $solicitados OR $almacen==$solicitados){

		//// el almacen cubreo todo lo del pedido LA LIMITANTES ES EL PEDIDO

		//echo "La cantidad solicitada par pedido es: ".$solicitados."<br><br>";

		if($total_asignadas>0) {

			$pedido_consumido=$solicitados;

			

			do {

				switch($i) {



					case 0:
						// code...

						$pedido_consumido=$pedido_consumido-$producto1;

						echo $pedido_consumido." despues del primer consumo<br>";

					break;

					case 1:
						

						$pedido_consumido=$pedido_consumido-$producto2;

						echo $pedido_consumido." despues del segundo consumo<br>";

					break;

					case 2:
						
						$pedido_consumido=$pedido_consumido-$producto3;

						echo $pedido_consumido." despues del tercer consumo<br>";

					break;
					
					
				}
			  
				

				if($pedido_consumido<0) {
						
					$pedido_consumido=0;

				}


				$i=$i+1;


			} while ($pedido_consumido>0);

			

				//
		}elseif($total_asignadas=0) {
			
			/// UPDATE QUE LA CANTIDAD ASIGNADA EN AUTOMATICO  SEA IGUAL A LA CANTIDAD DEL PEDIDO 

		}



	}elseif($almacen>0 AND $almacen<$solicitados){
		
	
		///////// ALMACEN NO CUBRE EL PEDIDO LA LIMITANTE ES LA CANTIDAD DE ALMACEN 

		$almacen_consumido=$almacen;

			do {

				switch($i) {



					case 0:
						// code...

						$almacen_consumido=$almacen_consumido-$producto1;

						echo $almacen_consumido." despues del primer consumo de almacen<br>";

					break;

					case 1:
						

						$almacen_consumido=$almacen_consumido-$producto2;

						echo $almacen_consumido." despues del segundo consumo de almacen<br>";

					break;

					case 2:
						
						$almacen_consumido=$almacen_consumido-$producto3;

						echo $almacen_consumido." despues del tercer consumo de almacen<br>";

					break;
					
					
				}
			  
				

				if($almacen_consumido<0) {
						
					$almacen_consumido=0;

				}


				$i=$i+1;


			} while ($almacen_consumido>0);

	}

	
    

?>