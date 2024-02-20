<div class="row">

    <div class="col-md-10 col-lg-10">


        <div class="row" style="margin-bottom: 20px;">
            
            

        </div>


        <div class="row">

            <div class="col-md-3 col-lg-3" >
                
                <label>Buscar por estatus</label>
                <select class="form-control" id="estatus" onchange="showInfo()">
                    
                    <option value="5" selected>Todo ...</option>
                    <option value="0" selected>SIN APLICAR</option>
                    <option value="1">APLICADOS</option>
                    <option value="2">CTA. NO IDENTIFICADA</option>

                </select>

            </div>
        
            <div class="col-md-9 col-lg-9">
            

                <label>Filtrar por cliente</label>
                <div class="input-group"> 

                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                    <select  name="cliente" id="cliente" class="form-control select2-placeholer" placeholder="seleccionar cliente p/cotizacion..." tabindex="2" autofocus="true"  style="font-size: 12px;" onchange="showInfo()"></select>
                    

                </div>
                
            </div>

          

        </div>


        

    </div>

    <!-- ******** IMPORTE PPD *********** -->

    <div class="col-md-2 col-lg-2">

        <h2 style="margin-top: 10px;"></h2>

        <p style="font-weight: bold; font-size: 23px; color:green;" id="tneto"></p>

    </div>

</div>

<div class="row" style="margin-top: 20px; ">

                                                        <div class="table-responsive">

                                                            <table class="table table-striped table-bordered table-hover" id="my-table" >


                                                                <thead class="bg-thinkweb-table" style="background-color: gray; color: white;">
                                                                    
                                                                    <tr>
                                                                        <th style="font-weight: bold; min-width: 60px; text-align: center;">Acciones</th>
                                                                        <th style="font-weight: bold; min-width: 70px; text-align: center;">Estatus</th>
                                                                        <th style="font-weight: bold; min-width: 70px; text-align: center;">Fecha</th>
                                                                        <th style="font-weight: bold; min-width: 80px; text-align: center;">#Rastreo</th>
                                                                        <th style="font-weight: bold; min-width: 120px; text-align: center;">Cuenta/banco</th>
                                                                        <th style="font-weight: bold; min-width: 200px; text-align: center;">Proveedor</th>
                                                                        <th style="font-weight: bold; min-width: 90px; text-align: right;">Cargo</th>
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

                        <input type="date" name="bfecha" id="bfecha" value="<?php echo date('Y-m-d')?>" class="form-control" tabindex="3">



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
                            
                            <li>1.-  El documento consta de seis columnas: fecha,hora,#movimiento,descripcion,cargo y abono</li>
                            <li>2.-  La columna FECHA debe ser en formato ingles (año-mes-dia)</li>
                            <li>3.-  Retirar de las columnas CARGO y ABONO el simbolo de pesos($)</li>
                            <li>4.-  Buscar y remplazar las comas(,) por un espacio en blanco( )</li>
                            <li>5.-  Guardar el excel en formato CSV(delimitado por comas)</li>

                        </ul>

                    </div>

                </div>

                <hr>

                <div class="row">

                    <div class="col-md-4 col-lg-4">

                        <label>*Seleccionar una cuenta de empresa</label>
           
                        <select  name="cuenta" id="cuenta" class="form-control" placeholder="Seleccionar una cuenta..." tabindex="1" autofocus="true"  style="font-size: 12px;"></select>

                    </div>

                                <div class="col-md-4 col-lg-4" style="margin-top: 10px;"> 
                                    <!-- ADJUNTAR FIANZA-->

                                
                                    <span class="btn btn-labeled btn-primary fileinput-button">

                                            <i class="btn-label icon fa fa-paperclip"></i>

                                            <span> Actualizar estado de cuenta</span>

                                            <input id="fileupload_pdf"  accept=".csv" type="file" name="files[]" multiple>

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
<div id="modal_pagos" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">


          <div class="modal-header" style="background-color: <?php echo BGCOLOR; ?>; color: <?php echo TXTHEAD; ?>; font-weight: bold;">



            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title"><strong>Aplicar pago</strong></h4>


          </div>

            <div class="modal-body">

                <div class="row col-md-12" id="modalPagoDescription" style="margin: 0 0 10px 0;">
                    
                    <h4>El importe del abono es incorrecto, favor de revisarlo</h4>

                </div>

                <hr style="border: none; border-top: 1px solid #ccc; width: 100%; margin: 100px 0 0 0;">

                <div class="row col-md-12" id="modalPagoPagos" style="margin: 50px 0 0 0;">

                    <div class="row col-md-12">

                        <div class="col-md-6"> 
                            <label>Buscar ODC</label>
                            <div class="input-group"> 
                                <span class="input-group-addon"><i class="fa fa-archive"></i></span> 
                                <select name="modalPagoSelctODC" id="modalPagoSelctODC" class="form-control" placeholder="Seleccionar cliente para cotización..." autofocus="true"></select>
                            </div>
                        </div>

                        <div class="col-md-6"> 
                            <label>Importe</label>
                            <div class="input-group"> 
                                <input id="modalPagoNumberImporte" class="form-control" type="number"/> 
                                <span class="input-group-addon"> 
                                    <i class="glyphicon glyphicon-usd"></i> 
                                </span>
                                <span class="input-group-btn">
                                    <button class="btn btn-success" type="button" onclick="agregarFila();" style="margin-left:5px;">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </span>
                            </div>
                        </div>

                    </div>

                    <div class="row col-md-12">
                        <div class="col-md-4" style="margin-top: 35px;"> 
                            <span class="btn btn-labeled btn-primary fileinput-button">
                                <i class="btn-label icon fa fa-paperclip"></i>
                                <span> Adjuntar evidencia</span>
                                <input id="fileODC"  accept=".pdf" type="file" name="files[]" multiple>
                            </span>
                        </div>

                        <div class="col-md-4" style="margin-top: 40px;">
                            <div id="barODC" class="progress">
                                <div class="progress-bar progress-bar-primary"></div>
                            </div>
                        </div>

                        <div class="col-md-4" style="margin-top: 10px;">
                            <label>Nombre del archivo</label>
                            <input type="text" name="nameODC" id="nameODC" class="form-control" disabled>
                        </div>
                    </div>

                    <div id="containerLoading" class="row col-md-12 d-flex justify-content-center" style="margin-top: 20px; margin-left: 45%;">
                        <div id="loadingIndicator"></div>
                    </div>

                    <div id="containerTablePagos" class="row col-md-12" style="margin-top:20px;">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th scope="col">ODC</th>
                                    <th scope="col">IMPORTE</th>
                                    <th scope="col">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody id="modalPagosTable">
                                
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

          <div class="modal-footer">

            <button type="button" class="btn btn-default" onclick="cargaraTemporal()" data-dismiss="modal" id="cerrarx4">Cerrar</button>

            <button type="button" class="btn btn-success" onclick="aplicarPago()" id="btnaplicar"><i class="fa fa-check"> Aplicar</i></button>

          </div>

    </div><!-- /.modal-content -->

  </div><!-- /.modal-dialog -->

</div><!-- /.modal -->


<div class="modal fade bd-example-modal-lg" id="modalAccounts" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

        <div class="modal-header" style="background-color: #2f4a94;">

        <h4 class="modal-title" id="titulo_modal" style="font-weight: bold; color: white;">Alta de Cuentas</h4>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

            <span aria-hidden="true" style="color:white;">&times;</span>

        </button>

        </div>

        <div class="modal-body">

        

                <div class="row">

                    <div class="row col-md-12" id="modalAccountDescription" style="margin: 0 0 10px 0;">
                    
                            <h4>El importe del abono es incorrecto, favor de revisarlo</h4>

                        </div>

                        <hr style="border: none; border-top: 1px solid #ccc; width: 100%; margin: 100px 0 0 0;">


                        <div class="col-md-6 col-lg-6" style="margin-top: 20px;">
                            
                            <label>Selecciona un banco</label>
                            <select class="form-control" id="modalAccountsBanco" name="modalAccountsBanco" tabindex="23"> </select>

                        </div>

                    
                        <div class="col-md-6 col-lg-6" style="margin-top: 20px;">
                            
                            <label>Cuenta bancaria</label>
                            

                            <div class="input-group">

                                <input type="number" name="modalAccounsCuenta" id="modalAccounsCuenta" class="form-control" tabindex="24">

                                <span class="input-group-btn">

                                    <button class="btn btn-success" type="button"  tabindex="25" onclick="actualizarCuenta()" title="Añadir cuenta"><i class="fa fa-plus"></i></button>

                                </span>

                            </div>

                        </div>

                        <div class="col-md-8 col-lg-8">
                            
                            <label>Selecciona un proveedor</label>
                            <select class="form-control" id="modalAccountsProveedor" name="modalAccountsProveedor" tabindex="23"> </select>

                        </div>
                    

                </div>


                <hr>


        </div>

        <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarx">Cerrar</button>

        </div>

    </div>

    </div>

</div>


<div class="modal fade bd-example-modal-lg" id="modalODC" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

	  <div class="modal-dialog modal-lg" role="document">

	    <div class="modal-content">

	      <div class="modal-header" style="background-color: #2f4a94;">

	        <h4 class="modal-title" id="titulo_modal"></h4>

	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

	          <span aria-hidden="true" style="color:white;">&times;</span>

	        </button>

	      </div>

	      <div class="modal-body">

                <div class="row col-md-12" id="modalODCDescription" style="margin: 0 0 10px 0;">
                    
                    <h4>El importe del abono es incorrecto, favor de revisarlo</h4>

                </div>

	      		<div class="row">

	      			<h4 style="margin-right:20px;">&nbsp;&nbsp;&nbsp;&nbsp;Lista ODC pagadas:  <!-- <a id="enlaceEvidencia" href="#" style="color: blue; font-weight: bold;">Ver evidencia</a> --> </h4>

                      <hr>
		      		<div class="cards-container box-view"  style="margin-top: 20px;" id="viewODC">


					</div>


				</div>



	      </div>

	      <div class="modal-footer">

	        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarx">Cerrar</button>

	      </div>

	    </div>

	  </div>

</div>


