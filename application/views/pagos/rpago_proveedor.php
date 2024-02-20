
	<div class="row">

		

		<div class="col-md-5 col-lg-5">

			

			<label>Buscar por proveedor/folio/total:</label>

			<div class="input-group">

				<input type="text" name="buscador" id="buscador" class="form-control">

				<span class="input-group-btn">

					<button class="btn btn-warning" type="button"  onclick="showInfo()"><i class="fa fa-search" style="color:black;"></i></button>

				</span>

			</div>



		</div>



		<div class="col-md-3 col-lg-3">

			

			<label>Buscar por estatus:</label>

			

				<select id="bestatus" class="form-control" onchange="showInfoEstatus()">

					<option value="6" selected>Todos...</option> 

					<option value="1" style="color:green;">Pagado</option>

					<option value="0" style="color:red;">No pagado</option>

					<option value="3" style="color:#B69A00;">No asignado</option>

				</select>



		</div>



	</div>

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
                            
                            <li>1.-  El documento consta de siete columnas: ODC, Folio, UUID,Fecha, Subtotal, IVA y Total</li>
                            <li>2.-  La columna FECHA debe ser en formato ingles (año-mes-dia)</li>
                            <li>3.-  Retirar de las columnas SUBTOTAL, IVA y TOTAL el simbolo de pesos($)</li>
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

                                            <span> Actualizar pagos a ODC</span>

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

<div id="modal_pago" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">

  <div class="modal-dialog modal-lg">

    <div class="modal-content">


          <div class="modal-header" style="background-color: <?php echo BGCOLOR; ?>; color: <?php echo TXTHEAD; ?>; font-weight: bold;">



            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            <h4 class="modal-title"><strong>Facturas</strong></h4>


          </div>

            <div class="modal-body">

                <div class="row">

                    <div class="col-md-12 col-lg-12 col-xs-12">
                    
                        <h4 style="font-weight: bold;">Descripción:</h4>

                        <div id="modalPagoDescription">

						</div>

                    </div>

                </div>

                <hr>

                <div class="row">

					<div id="loadTable">

						<div id="loadTable" style="margin-left: 20px; margin-rigth:20px;">
							<div class="container-fluid">
								<div class="row">
									<div class="col-12 mt-3">
										<div class="card">
											<div class="card-horizontal">
												<div class="card-body">
													<h4 class="card-title">Información de las facturas</h4>
												</div>
											</div>
											<div class="card-footer">
												<small class="text-muted">
												<table id="tableData">
													<thead>
														<tr>
															<th>Folio</th>
															<th>UUID</th>
															<th>Fecha</th>
															<th>Subtotal</th>
															<th>IVA</th>
															<th>Total</th>
														</tr>
													</thead>
													<tbody id="tableBodyFacturas">
														
													</tbody>
												</table>
												</small>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>

                </div>

            </div>




          <div class="modal-footer">

          <button type="button" class="btn btn-success" onclick="finalizarODC()" id="finalizarODC"><i class="fa fa-check"> Finalizar ODC</i></button>
		  <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrarx2">Cerrar</button>           

          </div>

    </div><!-- /.modal-content -->

  </div><!-- /.modal-dialog -->

</div><!-- /.modal -->



<!--Basic Modal-->


	<div class="row">



														<div class="table-responsive">



															<table class="table table-striped table-bordered table-hover" id="my-table" >





																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

																	

																	<tr>



																		<th style="font-weight: bold; min-width: 50px; text-align: center;">Acciones</th>

																		<th style="font-weight: bold; min-width: 60px; text-align: center;">Estatus</th>

																	    <th style="font-weight: bold; min-width: 100px; text-align: center;">ODC</th>

																	    <th style="font-weight: bold; min-width: 200px; text-align: left;">PROVEEDOR</th>

																	    <th style="font-weight: bold; min-width: 150px; text-align: right;">TOTAL</th>

																	    <th style="font-weight: bold; min-width: 150px; text-align: right;">PAGADO</th>

																	    <th style="font-weight: bold; min-width: 150px; text-align: right;">POR PAGAR</th>


																	</tr>

																</thead>

																					

															</table>

														</div>



										



	</div>			