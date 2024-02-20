<!DOCTYPE html>
<html lang="en">


<!-- Mirrored from coderthemes.com/jidox/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 06 Feb 2024 19:16:59 GMT -->

<head>
    <meta charset="utf-8" />
    <title>Dashboard | Jidox - Material Design Admin & Dashboard Template</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?php echo base_url() ?>tw/assets/images/favicon.ico">

    <link rel="stylesheet" href="<?php echo base_url() ?>tw/css/map.css">


    <!-- Datatables css -->
    <link href="<?php echo base_url() ?>tw/assets/vendor/datatables.net-bs5/css/dataTables.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>tw/assets/vendor/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>tw/assets/vendor/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>tw/assets/vendor/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>tw/assets/vendor/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url() ?>tw/assets/vendor/datatables.net-select-bs5/css/select.bootstrap5.min.css" rel="stylesheet" type="text/css" />

    <!-- Select2 css -->
    <link href="<?php echo base_url() ?>tw/assets/vendor/select2/css/select2.min.css" rel="stylesheet" type="text/css" />

    <!-- Daterangepicker css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>tw/assets/vendor/daterangepicker/daterangepicker.css">

    <!-- Vector Map css -->
    <link rel="stylesheet" href="<?php echo base_url() ?>tw/assets/vendor/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css">

    <!-- Theme Config Js -->
    <script src="<?php echo base_url() ?>tw/assets/js/config.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- App css -->
    <link href="<?php echo base_url() ?>tw/assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- Icons css -->
    <link href="<?php echo base_url() ?>tw/assets/css/icons.min.css" rel="stylesheet" type="text/css" />


    <link rel="stylesheet" href="<?php echo base_url() ?>node_modules/sweetalert2/dist/sweetalert2.min.css">


    <style type="text/css">
        .alignCenter {

            text-align: center;
            color: black;
            font-weight: bold;
        }

        .alignRight {

            text-align: right;
            color: black;
            font-weight: bold;


        }

        .header_form {

            background-color: #5384bc;

        }

        .fontText {

            font-size: 11px;
            font-weight: bold;

        }

        .fontText2 {

            font-size: 12px;
            font-weight: bold;

        }

        .fontText2red {

            text-align: right;
            color: red;
            font-weight: bold;

        }

        .fontText2green {

            text-align: right;
            color: green;
            font-weight: bold;

        }

        .fontText2blue {

            text-align: right;
            color: blue;
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

        .fontText2center {

            font-size: 12px;
            text-align: center;
            font-weight: bold;

        }

        .fontText3 {

            font-size: 13px;
            font-weight: bold;

        }

        .fontText16 {

            font-size: 16px;
            font-weight: bold;

        }

        .fontText4 {

            font-size: 15px;
            color: darkblue;
            font-weight: bold;

        }

        .bgcolor1 {

            background-color: #029b17;

        }

        .color_red {

            color: red;
            font-weight: bold;

        }

        .color_green {

            color: green;
            font-weight: bold;

        }

        .color_dark {

            color: black;
            font-weight: bold;

        }

        .color_blue {

            color: blue;
            font-weight: bold;

        }

        .bold {

            font-weight: bold;

        }

        .color_compras {

            color: #8D27B0;
            font-weight: bold;
            font-size: 17px;

        }

        .bgcolor_compras {

            background-color: rgb(141, 39, 176, .1);
            font-weight: bold;

        }


        .color_entradas {

            color: #C70039;
            font-weight: bold;
            font-size: 17px;

        }

        .bgcolor_entradas {

            background-color: rgb(199, 0, 57, .1);
            font-weight: bold;

        }

        .color_darkgreen {

            color: #229360;
            font-weight: bold;
            font-size: 17px;

        }

        .color_darkblue {

            color: darkblue;
            font-weight: bold;
            font-size: 17px;

        }

        .color_darkred {

            color: red;
            font-weight: bold;
            font-size: 17px;

        }

        .bgcolor_darkred {

            background-color: rgb(242, 32, 31, .1);

        }

        .bgcolor_darkgreen {

            background-color: rgb(34, 147, 96, .1);

        }

        .bgcolor_darkblue {

            background-color: rgb(34, 147, 96, .1);

        }

        .bgdocumento {

            background-color: rgb(255, 195, 0, .1);

        }

        .color_entradas {

            color: rgb(123, 36, 28);
            font-weight: bold;
            font-size: 17px;

        }

        .bgcolor_entradas {

            background-color: rgb(123, 36, 28, .1);

        }

        .color_documentos {

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

        .dataTables_info {

            /*font-weight:bold;*/
            font-size: 17px;
            margin-bottom: 8px;
            color: darkblue;

        }

        #my-table_paginate ul {
            display: flex;
            flex-direction: row;
            
            
        }

        #my-table_paginate ul li {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 5px 10px;
            
        }

        #my-table_paginate li{
            background-color: #9E9C9C;
        }

        #my-table_paginate ul li.previous a,
        #my-table_paginate ul li.next a {
            background-color: #9E9C9C;
            /* Color de fondo para anterior y siguiente */
            color: white;
            font-weight: bold;
        }

        #my-table_paginate ul li.active a {
            background-color: #9E9C9C;
            /* Color de fondo para la página actual */
            color: #ffffff;
            font-weight: bold;
            /* Color de texto para la página actual */
        }
    </style>



</head>