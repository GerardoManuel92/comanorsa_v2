<?php

## ENABLE SoapClient on PHP 7.3.x ## 
/*
	Do the following:

	1. Locate php.ini in your apache bin folder, I.e Apache/bin/php.ini
	2. Remove the ; from the beginning of extension=soap  (extension=php_soap.dll in older versions) 
	3. Restart your Apache server
	4. Look up your phpinfo(); again and check if you see a similar picture to the one above
*/
	namespace TIMBRADORXPRESS\API;

	class Conexion
	{
    	private $wsdl;
    	private $client;
    	private $response;

		public function __construct($url)
		{
			$this->wsdl = $url;
			$this->client = new \SoapClient($this->wsdl);
			$this->response = NULL;
		}

		public function operacion_timbrar($apikey, $cfdi)
		{
			$res = $this->client->timbrar($apikey, $cfdi);

			$this->response = array(
				'operacion' => 'timbrar',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'cfdi' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_timbrar3($apikey, $cfdi)
		{
			$res = $this->client->timbrar3($apikey, $cfdi);

			$this->response = array(
				'operacion' => 'timbrar3',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'cfdi' => $res->data);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_timbrar_sellar($apikey, $xmlCFDI, $keyPEM)
		{
			$res = $this->client->timbrarConSello($apikey, $xmlCFDI, $keyPEM);

			/*$this->response = array(
				'operacion' => 'timbrarSellando',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'cfdi' => $res->data
				);*/

			$arreglo = array(
				'operacion' => 'timbrarSellando',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'cfdi' => $res->data
				);

			return $arreglo;
			
			//return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);


		}

		public function operacion_timbrarTFD($apikey, $cfdi)
		{
			$res = $this->client->timbrarTFD($apikey, $cfdi);

			$this->response = array(
				'operacion' => 'timbrarTFD',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'timbre' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_consultar_creditos($apikey)
		{
			$res = $this->client->consultarCreditosDisponibles($apikey);

			$this->response = array(
				'operacion' => 'consultar_creditos',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'creditos' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_consultarEstadoSAT($apikey, $uuid, $rfcEmisor, $rfcReceptor, $total)
		{
			$res = $this->client->consultarEstadoSAT($apikey, $uuid, $rfcEmisor, $rfcReceptor, $total);

			$this->response = array(
				'operacion' => 'consultarEstadoSAT',
				'Codigo del SAT' => $res->CodigoEstatus,
				'Tipo de Cancelación' => $res->EsCancelable,
				'Estado' => $res->Estado,
				'Solicitud de cancelacion' => $res->EstatusCancelacion
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_cancelar($apikey, $keyCSD, $cerCSD, $passCSD, $uuid, $rfcEmisor, $rfcReceptor, $total, $motivo, $folioSustitucion, $folio_factura)
		{
			$res = $this->client->cancelar2($apikey, $keyCSD, $cerCSD, $passCSD, $uuid, $rfcEmisor, $rfcReceptor, $total, $motivo, $folioSustitucion);

			## RESPUESTA ORIGINAL DEL SERVICIO ##
			//var_dump($res);

			$acuse = NULL;

			if ( $res->status == "success" ){

				$resData = json_decode($res->data);
				//$acuse = $resData->acuse;

				$acuse="0%".$resData->acuse;

			}else{

				//$acuse=null;

				//$resData = json_decode($res->data);
				$acuse="1%".$res->message."%".$res->code;
				//$acuse="false";

				//$acuse=$res->message;



			}

			/*$arreglo = array(
				'operacion' => 'cancelar',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'acuse' => $acuse,
				'resultado' => $res->status
				);*/
			
			
			//return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);

			return $acuse;

		}

		public function operacion_cancelarPFX($apikey, $pfxB64, $passPFX, $uuid, $rfcEmisor, $rfcReceptor, $total)
		{
			$res = $this->client->cancelarPFX($apikey, $pfxB64, $passPFX, $uuid, $rfcEmisor, $rfcReceptor, $total);

			## RESPUESTA ORIGINAL DEL SERVICIO ##
			//var_dump($res);

			$acuse = NULL;

			if ( $res->status == "success" )
			{
				$resData = json_decode($res->data);
				$acuse = $resData->acuse;
			}

			$this->response = array(
				'operacion' => 'cancelar',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'acuse' => $acuse,
				'resultado' => $res->status
				);

			## GUARDAR ACUSE EN DIRECTORIO ACTUAL ##
			//file_put_contents('rsc/acuse_cancelacion.xml', $acuse);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_timbrarTXT($apikey, $txtB64, $keyPEM, $cerPEM)
		{
			$res = $this->client->timbrarTXT($apikey, $txtB64, $keyPEM, $cerPEM);

			$this->response = array(
				'operacion' => 'timbrarTXT',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'datos' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_timbrarTXT2($apikey, $txtB64, $keyPEM, $cerPEM, $plantilla, $logoB64)
		{
			$res = $this->client->timbrarTXT2($apikey, $txtB64, $keyPEM, $cerPEM, $plantilla, $logoB64);

			$this->response = array(
				'operacion' => 'timbrarTXT2',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'datos' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_timbrarJSON($apikey, $jsonB64, $keyPEM, $cerPEM)
		{
			$res = $this->client->timbrarJSON($apikey, $jsonB64, $keyPEM, $cerPEM);

			$this->response = array(
				'operacion' => 'timbrarJSON',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'datos' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}

		public function operacion_timbrarJSON2($apikey, $jsonB64, $keyPEM, $cerPEM, $plantilla, $logoB64)
		{
			$res = $this->client->timbrarJSON2($apikey, $jsonB64, $keyPEM, $cerPEM, $plantilla, $logoB64);

			$this->response = array(
				'operacion' => 'timbrarJSON2',
				'codigo' => $res->code,
				'mensaje' => $res->message,
				'datos' => $res->data
				);
			
			return json_encode($this->response, JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT);
		}
	}
?>