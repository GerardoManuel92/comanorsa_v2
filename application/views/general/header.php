<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="<?php echo ENCABEZADOERP; ?>">
<meta name="keywords" content="<?php echo ENCABEZADOERP; ?>">

<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta http-equiv="Expires" content="0">

<title>ERP COMANORSA</title>
<!-- Site favicon -->
<link rel='shortcut icon' type='image/x-icon' href='<?php echo base_url(); ?>comanorsa/logo.ico' />
<!-- /site favicon -->

<!-- Entypo font stylesheet -->
<link href="<?php echo base_url(); ?>tw/css/entypo.css" rel="stylesheet">
<!-- /entypo font stylesheet -->

<!-- Font awesome stylesheet -->
<link href="<?php echo base_url(); ?>tw/css/font-awesome.min.css" rel="stylesheet">
<!-- /font awesome stylesheet -->

<!-- Bootstrap stylesheet min version -->
<link href="<?php echo base_url(); ?>tw/css/bootstrap.min.css?v=2" rel="stylesheet">
<!-- /bootstrap stylesheet min version -->

<!-- Mouldifi core stylesheet -->
<link href="<?php echo base_url(); ?>tw/css/mouldifi-core.css?v=6" rel="stylesheet">
<!-- /mouldifi core stylesheet -->

<link href="<?php echo base_url(); ?>tw/css/mouldifi-forms.css" rel="stylesheet">







<style type="text/css">
  
	.alignCenter{

		text-align: center;
		color:black;
		font-weight:bold;
	}

	.alignRight{

		text-align: right;
		color:black;
		font-weight:bold;
		

	}

	.header_form{

		background-color: #5384bc;

	}

	.fontText{

		font-size: 11px;
		font-weight: bold;

	}

	.fontText2{

		font-size: 12px;
		font-weight: bold;

	}

	.fontText2red{

		text-align: right;
		color:red;
		font-weight: bold;

	}

	.fontText2green{

	text-align: right;
	color:green;
	font-weight: bold;

	}

	.fontText2blue{

		text-align: right;
		color:blue;
		font-weight: bold;

	}

	.fontWithBackgroundGreen {
		background-color: #c3e6c2; 
		font-weight: bold;
		text-align: center;
		padding: 10px;
	}

	.fontWithBackgroundRed {
		background-color: #ffcccc;
		font-weight: bold;
		text-align: center;
		padding: 10px;
	}

	.fontWithBackgroundYellow {
		background-color: #FFE552;
		font-weight: bold;
		text-align: center;
		padding: 10px;
	}

	.fontText2center{

		font-size: 12px;
		text-align: center;
		font-weight: bold;

	}

	.fontText3{

		font-size: 13px;
		font-weight: bold;

	}

	.fontText16{

		font-size: 16px;
		font-weight: bold;

	}

	.fontText4{

		font-size: 15px;
		color:darkblue;
		font-weight: bold;

	}

	.bgcolor1{

		background-color: #029b17;

	}

	.color_red{

		color:red;
		font-weight: bold;

	}

	.color_green{

		color:green;
		font-weight: bold;

	}
	
	.color_dark{

		color:black;
		font-weight: bold;
		
	}

	.color_blue{

		color:blue;
		font-weight: bold;

	}

	.bold{

		font-weight: bold;

	}

	.color_compras{

		color: #8D27B0;
		font-weight: bold;
		font-size: 17px;

	}

	.bgcolor_compras{

		background-color: rgb(141,39,176,.1);
		font-weight: bold;

	}


	.color_entradas{

		color: #C70039;
		font-weight: bold;
		font-size: 17px;

	}

	.bgcolor_entradas{

		background-color: rgb(199,0,57,.1);
		font-weight: bold;

	}

	.color_darkgreen{

		color: #229360;
		font-weight: bold;
		font-size: 17px;

	}

	.color_darkblue{

		color: darkblue;
		font-weight: bold;
		font-size: 17px;

	}

	.color_darkred{

		color: red;
		font-weight: bold;
		font-size: 17px;

	}

	.bgcolor_darkred{

		background-color: rgb(242,32,31,.1);

	}

	.bgcolor_darkgreen{

		background-color: rgb(34,147,96,.1);

	}

	.bgcolor_darkblue{

		background-color: rgb(34,147,96,.1);

	}

	.bgdocumento{

		background-color: rgb(255,195,0,.1);

	}

	.color_entradas{

		color: rgb(123, 36, 28);
		font-weight: bold;
		font-size: 17px;

	}

	.bgcolor_entradas{

		background-color: rgb(123,36,28,.1);

	}

	.color_documentos{

		font-weight: bold;
		font-size: 17px;

	}

	:root {
		--color-background: #FFFFFF; 
		--color-primary: #5682b6; 
	}

	@keyframes loading {
		0% {
			transform: rotate(0deg);
		}

		100% {
			transform: rotate(360deg);
		}
	}

	#loadingIndicator {
	border: 6px solid var(--color-background);
	border-radius: 50%;
	border-top-color: var(--color-primary);
	border-bottom-color: var(--color-primary);
	width: 50px;
	height: 50px;
	animation: loading 1.5s infinite linear;
	}

	#lblPagoReconocido {
		position: fixed;
		top: 20%;
		left: 50%;
		transform: translate(-50%, -50%);
		background-color: #fff;
		padding: 20px;
		border: 1px solid #ccc;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
		z-index: 999;
	}

	#lblPagoCancelado {
		position: fixed;
		top: 20%;
		left: 50%;
		transform: translate(-50%, -50%);
		background-color: #fff;
		padding: 20px;
		border: 1px solid #ccc;
		box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
		z-index: 999;
	}

	.oculto {
		display: none;
	}

	.card-horizontal {
		display: flex;
		flex: 1 1 auto;
	}

	#tableData {
		border-collapse: collapse;
		width: 100%;
	}

	.dataTables_info{

		/*font-weight:bold;*/
		font-size: 17px;
		margin-bottom: 8px;
		color: darkblue;

	}

</style>

