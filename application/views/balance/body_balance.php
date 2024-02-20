<div class="row">

    <div class="col-md-10 col-lg-10">


        <div class="row" style="margin-bottom: 20px;">



        </div>


        <div class="row">

            <div class="col-md-3 col-lg-3">

                <label>Buscar por estatus</label>
                <select class="form-control" id="estatus" onchange="showInfo()">

                    <option value="0" selected>SIN APLICAR</option>
                    <option value="3">ABONO S/APLICAR</option>
                    <option value="4">ABONO S/IDENTIFICAR</option>
                    <option value="5">ABONO C/FACTURAS PUE</option>
                    <option value="1">APLICADOS</option>
                    <option value="2">TODOS</option>

                </select>

            </div>

            <div class="col-md-6 col-lg-6">


                <label>Filtrar por cliente</label>
                <div class="input-group">

                    <span class="input-group-addon"><i class="fa fa-user"></i></span>
                    <select name="cliente" id="cliente" class="form-control select2-placeholer" placeholder="seleccionar cliente p/cotizacion..." tabindex="2" autofocus="true" style="font-size: 12px;" onchange="showInfo()"></select>


                </div>

            </div>

            <div class="col-md-3 col-lg-3">
                
                <button type="button" class="btn btn-success" onclick="showExcel();" style="margin-top: 20px;"><i class="fa fa-file-excel-o" style="color:white; font-weight:bold; font-size: 20px;"></i>&nbsp; Excel</button>

            </div>

        </div>




    </div>

    <!-- ******** IMPORTE PPD *********** -->

    <div class="col-md-2 col-lg-2">

        <h2 style="margin-top: 10px;">Total:</h2>

        <p style="font-weight: bold; font-size: 23px; color:green;" id="tneto"></p>

    </div>

</div>

<div class="row" style="margin-top: 20px; ">

    <div class="table-responsive">

        <table class="table table-striped table-bordered table-hover" id="my-table">
            <style>
                @media (min-width: 768px) {
                    #my-table_filter {
                        margin-left: -30px;
                        width: 30%;
                        margin-top: 20px;
                    }

                    #my-table_paginate {
                        margin-left: 500px;
                        width: 45%;
                        margin-top: -35px;
                    }

                    #my-table_length {
                        margin-left: 20px;
                        width: 40%;
                        margin-top: 20px;
                    }

                    #my-table_info {
                        margin-left: 500px;
                        width: 40%;
                        margin-top: -45px;
                    }
                }
            </style>

            <thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

                <tr>
                    <th style="font-weight: bold; min-width: 60px; text-align: center;">Acciones</th>
                    <th style="font-weight: bold; min-width: 70px; text-align: center;">Estatus</th>
                    <th style="font-weight: bold; min-width: 70px; text-align: center;">Fecha</th>
                    <th style="font-weight: bold; min-width: 80px; text-align: center;">#Rastreo</th>
                    <th style="font-weight: bold; min-width: 120px; text-align: center;">Cuenta/banco</th>
                    <th style="font-weight: bold; min-width: 100px; text-align: left;">Cliente/Proveedor</th>
                    <th style="font-weight: bold; min-width: 90px; text-align: right;">Cargo</th>
                    <th style="font-weight: bold; min-width: 90px; text-align: right;">Abono</th>
                    <th style="font-weight: bold; min-width: 90px; text-align: center;">Forma de pago</th>

                </tr>
            </thead>

        </table>
    </div>

</div>

<!--Basic Modal-->

<div id="modal-1" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">





            <div class="modal-header" style="background-color: <?php echo BGCOLOR; ?>; color: <?php echo TXTHEAD; ?>; font-weight: bold;">



                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                <h4 class="modal-title"><strong>Editar movimiento</strong></h4>



            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12 col-lg-12">

                        <label>Descripcion</label>
                        <textarea class="form-control" id="descrip" name="descrip" rows="3"></textarea>

                    </div>

                </div>

                <div class="row" style="margin-top: 18px;">

                    <div class="col-md-4 col-lg-4">

                        <label>Forma de pago</label>
                        <select class="form-control" id="fpago" name="fpago" onchange="showinfoPago(this.value)"></select>

                    </div>


                    <div class="col-md-2">


                        <label>*Fecha</label>

                        <input type="date" name="bfecha" id="bfecha" value="<?php echo date('Y-m-d') ?>" class="form-control" tabindex="3">



                    </div>

                    <div class="col-md-2 col-lg-2">

                        <label>*Hora</label>

                        <input type="time" name="bhora" id="bhora" class="form-control" tabindex="4">

                    </div>


                    <div class="col-md-4 col-lg-4">



                        <label>*#Movimiento</label>

                        <input type="number" name="movimiento" id="movimiento" class="form-control" tabindex="5">


                    </div>




                </div>

                <div class="row" style="margin-top: 18px;">


                    <div class="col-md-4 col-lg-4">



                        <label>*#Rastreo</label>

                        <input type="text" name="rastreo" id="rastreo" class="form-control" tabindex="6">


                    </div>

                    <div class="col-md-4 col-lg-4">



                        <label>*#Cuenta</label>

                        <input type="number" name="cuenta_banco" id="cuenta_banco" class="form-control" tabindex="7">


                    </div>


                    <div class="col-md-2 col-lg-2">

                        <label>*Tipo</label>

                        <select class="form-control" id="tipo" name="tipo" tabindex="8">

                            <option value="1"> Cargo </option>
                            <option value="2"> Abono </option>

                        </select>



                    </div>

                    <div class="col-md-2 col-lg-2">

                        <label style="text-align: right;">*Importe</label>
                        <input type="number" name="importe" id="importe" class="form-control" style="text-align: right;" tabindex="9">

                    </div>


                </div>




            </div>







            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrarx3">Cerrar</button>

                <button type="button" class="btn btn-success" onclick="actualizarMov()" id="btnfactura"><i class="fa fa-check"> Actualizar</i></button>

            </div>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->


<!--Basic Modal-->
-
<div id="modal_act" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <div class="modal-header" style="background-color: <?php echo BGCOLOR; ?>; color: <?php echo TXTHEAD; ?>; font-weight: bold;">



                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                <h4 class="modal-title"><strong>Editar movimiento</strong></h4>


            </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12 col-lg-12 col-xs-12">

                        <h4 style="font-weight: bold;">Indicaciones para crear el documento que actualizara la cuenta bancaria:</h4>

                        <ul>

                            <li>1.- El documento consta de seis columnas: fecha,hora,#movimiento,descripcion,cargo y abono</li>
                            <li>2.- La columna FECHA debe ser en formato ingles (año-mes-dia)</li>
                            <li>3.- Retirar de las columnas CARGO y ABONO el simbolo de pesos($)</li>
                            <li>4.- Buscar y remplazar las comas(,) por un espacio en blanco( )</li>
                            <li>5.- Guardar el excel en formato CSV(delimitado por comas)</li>

                        </ul>

                    </div>

                </div>

                <hr>

                <div class="row">

                    <div class="col-md-4 col-lg-4">

                        <label>*Seleccionar una cuenta de empresa</label>

                        <select name="cuenta" id="cuenta" class="form-control" placeholder="Seleccionar una cuenta..." tabindex="1" autofocus="true" style="font-size: 12px;"></select>

                    </div>

                    <div class="col-md-4 col-lg-4" style="margin-top: 10px;">
                        <!-- ADJUNTAR FIANZA-->


                        <span class="btn btn-labeled btn-primary fileinput-button">

                            <i class="btn-label icon fa fa-paperclip"></i>

                            <span> Actualizar estado de cuenta</span>

                            <input id="fileupload_pdf" accept=".csv" type="file" name="files[]" multiple>

                        </span>

                        <div id="progress_bar_factpdf" class="progress">

                            <div class="progress-bar progress-bar-primary"></div>

                        </div>

                    </div>

                    <div class="col-md-4 col-lg-4" style="margin-top: 10px;">

                        <!--<div id="files_cfactpdf" class="files" style="margin-bottom: 10px;">*Sin adjunto</div>-->

                        <label>Nombre del archivo</label>

                        <input type="text" name="name_factpdf" id="name_factpdf" class="form-control" disabled>
                        <!--<span class="input-group-addon"><button class="btn btn-success" id="btncargar" onclick="actCuenta()">actualizar</button></span>-->



                    </div>


                    <!--<div class="col-md-2 col-lg-2">
                                    
                                    <button class="btn btn-success" id="btncargar" style="margin-top: 30px;">actualizar</button>

                                </div>-->


                </div>

            </div>




            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrarx2">Cerrar</button>

                <button type="button" class="btn btn-success" onclick="actCuenta()" id="btncargar"><i class="fa fa-check"> Actualizar</i></button>

            </div>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<!--Basic Modal-->
-
<div id="modal_facturas" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">


            <div class="modal-header" style="background-color: <?php echo BGCOLOR; ?>; color: <?php echo TXTHEAD; ?>; font-weight: bold;">



                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

                <h4 class="modal-title"><strong>Aplicar pago</strong></h4>


            </div>

            <div class="modal-body">

                <div class="row" id="error_factura" style="display: none;">

                    <h4>El importe del abono es incorrecto, favor de revisarlo</h4>

                </div>



                <div class="row" id="facturas">



                    <div class="row col-md-12">

                        <div class="col-md-9" id="infopago">

                            <!--<h4 style="font-weight: bold:">Facturas a aplicar</h4>

                            <p>Javier Alejandro Monzon Cortes | Fecha: 5 de junio 2023 , Hora:18:23:54hrs</p>
                            <p> #movimiento:2962108122812 | Banco:SANTANDER S.A. DE C.V ............. <strong style="font-size: 17px;">$23,456.44</strong></p>-->

                        </div>

                        <div class="col-md-3 col-lg-3" id="inforestante">


                            <!--<p style="font-weight: bold; font-size: 17px;">Saldo restante: <br>$ 45,897.90</p> -->

                        </div>

                    </div>


                    <div class="row" id="info_facturas">


                        <!--<div class=" col-md-12" style="margin-top: 15px;">

                            <div class="col-md-6 col-lg-6">
                                
                                <label>Información:</label>
                                <p>BDL6734 | Credito: 30 Dias | Transcurridos: 90 Dias</p>

                            </div>

                            <div class="col-md-3 col-lg-3" style="text-align: right;">
                                
                                <label>Total x saldar</label>
                                <input type="text" id="totfact2" name="totfact2"  style="text-align: right;" disabled value="$4,569.00">

                            </div>

                            <div class="col-md-3 col-lg-3" style="text-align: right;">
                                
                                <label>Saldo aplicado</label>
                                <input type="text" id="saldofact2" name="saldofact2" style="text-align: right;" >

                            </div>

                        </div>

                   

                        <div class=" col-md-12" style="margin-top: 15px;">

                            <div class="col-md-6 col-lg-6">
                                
                                <label>Información:</label>
                                <p>BDL6734 | Credito: 30 Dias | Transcurridos: 90 Dias</p>

                            </div>

                            <div class="col-md-3 col-lg-3" style="text-align: right;">
                                
                                <label>Total factura</label>
                                <input type="text" id="totfact2" name="totfact2"  style="text-align: right;" disabled value="$4,569.00">

                            </div>

                            <div class="col-md-3 col-lg-3" style="text-align: right;">
                                
                                <label>Saldo aplicado</label>
                                <input type="text" id="saldofact2" name="saldofact2" style="text-align: right;" >

                            </div>

                        </div>

                        <div class=" col-md-12" style="margin-top: 15px;">

                            <div class="col-md-6 col-lg-6">
                                
                                <label>Información:</label>
                                <p>BDL6734 | Credito: 30 Dias | Transcurridos: 90 Dias</p>

                            </div>

                            <div class="col-md-3 col-lg-3" style="text-align: right;">
                                
                                <label>Total factura</label>
                                <input type="text" id="totfact2" name="totfact2"  style="text-align: right;" disabled value="$4,569.00">

                            </div>

                            <div class="col-md-3 col-lg-3" style="text-align: right;">
                                
                                <label>Saldo aplicado</label>
                                <input type="text" id="saldofact2" name="saldofact2" style="text-align: right;" >

                            </div>

                        </div>-->


                    </div>

                    <div class="row" id="notificacion_saldos">



                    </div>



                </div>





            </div>

            <div class="modal-footer">

                <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrarx4">Cerrar</button>

                <button type="button" class="btn btn-success" onclick="aplicarPago()" id="btnaplicar"><i class="fa fa-check"> Aplicar</i></button>

            </div>

        </div><!-- /.modal-content -->

    </div><!-- /.modal-dialog -->

</div><!-- /.modal -->