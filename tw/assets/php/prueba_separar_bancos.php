<?php


	$texto='SPEI Recibido:  Institucion contraparte: BBVA MEXICO Ordenante: VISNAV  ARCHITECTS  SA DE CV Cuenta Ordenante: 012180001116894871    RFC Ordenante: VAA0702098E1  Referencia: 7573  Hora: 15:26:48  Clave de Rastreo: BNET01002305230033313697 Concepto del Pago: ANGEL DE ORIENTE 7573  Recibo # 116924627';

	$texto2='SPEI Recibido: | Institucion contraparte: BBVA MEXICO Ordenante: EUROMUNDO SA DE CV Cuenta Ordenante: 012180001028453504  |  RFC Ordenante: EUR911109LA5 | Referencia: 1105230 | Hora: 17:01:14 | Clave de Rastreo: 002601002305110000874694 Concepto del Pago: EUROMUNDO SA DE CV | Recibo # 115853567';

	$texto3='SPEI Recibido: | Institucion contraparte: BANAMEX Ordenante: EXXONMOBIL MEXICO SA DE CV Cuenta Ordenante: 002180002209570558  |  RFC Ordenante: EME970101A45 | Referencia: 3803071 | Hora: 12:26:14 | Clave de Rastreo: 085904665310313139 Concepto del Pago: 155620000334092 | Recibo # 115811065';

	$texto4='SPEI Recibido: | Institucion contraparte: HSBC Ordenante: MUNSA MOLINOS | S A | DE C V Cuenta Ordenante: 021320040276860706  |  RFC Ordenante: MMO820212US6 | Referencia: 805 | Hora: 21:01:40 | Clave de Rastreo: HSBC068530 Concepto del Pago: PAGO F 8162 | Recibo # 115684025';

	$texto5='SPEI Recibido: | Institucion contraparte: BBVA MEXICO Ordenante: OPERADORA CENTRAL DE | ESTACIONAMIENTOS S Cuenta Ordenante: 012180001654569752  |  RFC Ordenante: OCE9412073L3 | Referencia: 50523 | Hora: 14:42:02 | Clave de Rastreo: 002601002305050000148492 Concepto del Pago: COMERCIALIZADORA ANGEL | Recibo # 115332410';

	$texto6='SPEI Recibido: | Institucion contraparte: BBVA MEXICO Ordenante: LAC TRAVEL SERVICES | SA DE CV Cuenta Ordenante: 012180001841506515  |  RFC Ordenante: LTS050606EY8 | Referencia: 405238 | Hora: 16:36:04 | Clave de Rastreo: 002601002305040000939091 Concepto del Pago: LAC TRAVEL SERVICES | Recibo # 115216740';

	$texto7='SPEI Recibido: | Institucion contraparte: HSBC Ordenante: MUNSA MOLINOS | S A | DE C V Cuenta Ordenante: 021320040276860706  |  RFC Ordenante: MMO820212US6 | Referencia: 205 | Hora: 16:45:54 | Clave de Rastreo: HSBC396368 Concepto del Pago: PAGO F 8058 | Recibo # 115109864';

	$texto8='SPEI Recibido: | Institucion contraparte: INTERCAM BANCO Ordenante: MANUFACTURA ESPECIAL Y PROYECTOS INDUSTR Cuenta Ordenante: 136180018898000182  |  RFC Ordenante: MEP201207S33 | Referencia: 6412178 | Hora: 13:26:44 | Clave de Rastreo: 136-02/05/2023/02-0016412178 Concepto del Pago: PAGO FACTURA | Recibo # 114965095';

	$texto9='Entrega de Recursos por 1,392.00 mxn de la cuenta 27635184 Cheqsi-1 Suc. plutarc BDL7880 | Ordenante SEBASTIAN | ALVAREZ TOSTADO | Hora: 13:15:24 | Recibo # 779633020093';

	$texto10='Devolucion - Deposito por POS por 0.56 mxn | Recibo # 5006952026322';

	$select=$texto;

	echo $select."<br>----------------------------------------------------------<br><br>";

	$separar=explode(":", $select);

	if ( count($separar)>5 ) {


		$separar_cuenta=trim($separar[4]);

		$cuenta=substr($separar_cuenta,0,18);

		echo "No.de cuenta:".$cuenta."<br>";

		//////************** CLAVE DE RASTREO 

		$rseparar=explode("Rastreo:", $select);

		$rseparar_crastreo=trim($rseparar[1]);

		$rseparar2=explode(" ", $rseparar_crastreo);

		echo "Clave de rastreo:".trim($rseparar2[0]);

	}
	

?>