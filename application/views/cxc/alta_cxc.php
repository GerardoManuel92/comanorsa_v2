
	<!--<button onclick="showEditar()" value="Editar" class="btn btn-success">Habilitar</button>

	<a href="#" id="username" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">Editar texto</a>-->


		<!-- Modal -->
<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background-color: #2f4a94;">
        <h5 class="modal-title" id="titulo"><strong style="color:white;">Añadir monto y comprobante del pago  </strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:white;">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
      		<div class="row">

      			<div class="col-md-12" style="text-align: right;">
      				
      				<h3 style="color:darkgreen; font-size: 17px; font-weight: bold;" id="info_oc"></h3>

      			</div>

      		</div>

      			<div class="row">
      				
      							<div class="col-md-12 col-lg-12"> 
									<!-- ADJUNTAR FIANZA-->

								
									<span class="btn btn-labeled btn-primary fileinput-button">

											<i class="btn-label icon fa fa-paperclip"></i>

											<span>*Adjuntar comprobante</span>

											<input id="fileupload_pdf"  accept=".pdf,.jpg,.png,.jpeg" type="file" name="files[]" multiple>

									</span>

									<div id="progress_bar_factpdf" class="progress">

										<div class="progress-bar progress-bar-primary"></div>

									</div>

								</div>

								<div class="col-md-12 col-lg-12">
									
									<div id="files_cfactpdf" class="files" style="margin-bottom: 10px;">*Sin comprobante adjunto</div>

									<input type="text" name="name_factpdf" id="name_factpdf" class="form-control" disabled>

								</div>
	      			
	      		</div>

	      		<div class="row" style="margin-top: 15px; display: none;" id="complementox">
	      			
	      			<!--<div class="col-md-12 col-lg-12" id="btncom">
	      				 
	      				<button class="btn btn-warning" style="color:black;" onclick="showComp()"> Agregar complemento</button>

	      			</div>-->

	      			<div class="col-md-12 col-lg-12" style="margin-top: 15px;">
	      				
	      							<span class="btn btn-labeled btn-primary fileinput-button">

											<i class="btn-label icon fa fa-paperclip"></i>

											<span>*Adjuntar complemento</span>

											<input id="fileupload_comp"  accept=".pdf" type="file" name="files[]" multiple>

									</span>

									<div id="progress_bar_comp" class="progress">

										<div class="progress-bar progress-bar-secondary"></div>

									</div>

									<div class="row col-md-12 col-lg-12">
										
										<div id="files_comp" class="files" style="margin-bottom: 5px;">*Sin complemento adjunto</div>

										<input type="text" name="name_comp" id="name_comp" class="form-control" disabled>

									</div>

	      			</div>

	      			<div class="col-md-12 col-lg-12" style="margin-top: 15px;">
	      				
	      							<span class="btn btn-labeled btn-primary fileinput-button">

											<i class="btn-label icon fa fa-paperclip"></i>

											<span>*XML complemento</span>

											<input id="fileupload_xml"  accept=".xml" type="file" name="files[]" multiple>

									</span>

									<div id="progress_bar_xml" class="progress">

										<div class="progress-bar progress-bar-secondary"></div>

									</div>

									<div class="row col-md-12 col-lg-12">
										
										<div id="files_xml" class="files" style="margin-bottom: 5px;">*Sin XML adjunto</div>

										<input type="text" name="name_xml" id="name_xml" class="form-control" disabled>

									</div>

	      			</div>

	      		</div>
 
	      		<div class="row" style="margin-top: 10px;">
	      			
	      			<div class="col-md-12">
	      				
	      				<label style="text-align: right;">Monto a pagar</label>
	      				<input type="number" name="pago" id="pago" class="form-control" style="text-align: right;">


	      			</div>

	      		</div>

      			
      		</div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarx">Cerrar</button>
        <button type="button" class="btn btn-primary" onclick="guardarPago()" id="btnguardar">Guardar pago</button>
      </div>
    </div>
  </div>
</div>

<div class="row">

				<div class="col-md-10 col-lg-10 col-xs-12">

					<div class="row">

							<div class="col-md-2 col-lg-2"> 

								<label>Filtrar por estatus: </label>
								<select  name="estatus" id="estatus" class="form-control" tabindex="2" onchange="showInfo()"  style="font-size: 12px;">
									
									<option value="1" style="color: darkblue; font-weight: bold;">ACTIVAS</option>
									<option value="2" style="color: darkgreen; font-weight: bold;">COBRADAS</option>
									<option value="3" selected style="color: red; font-weight: bold;">VENCIDAS</option>
									<option value="4" style="color:#E1A009; font-weight: bold;">CANCELADAS</option>

								</select>
								

							</div>

							<div class="col-md-5 col-lg-5">
			
								<label>Buscar por Factura/Cliente/:</label>
								<div class="input-group">
									<input type="text" name="buscador" id="buscador" class="form-control">
									<span class="input-group-btn">
										<button class="btn btn-warning" type="button"  onclick="showBuscar()"><i class="fa fa-search" style="color:black;"></i></button>
									</span>
								</div>

							</div>

							<div class="col-md-3 col-lg-3 " class="pull-right" style="text-align: right;">
								
								<p style="color: darkblue; display: ; font-size: 17px;" id="total"></p>
								<p style="color: green; " id="pagado"></p>
								<p style="color: red; " id="xPagar"></p>
							

							</div>

					</div>

				</div>
			
</div>

						<div class="row" style="margin-top: 20px; ">



														<div class="table-responsive">

															<table class="table table-striped table-bordered table-hover" id="my-table" >


																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">
																	
																	<tr>
																		<th style="font-weight: bold; min-width: 40px; text-align: center;">Accion</th>
																		<th style="font-weight: bold; min-width: 70px; text-align: center;">Estatus</th>
																		<th style="font-weight: bold; min-width: 60px; text-align: center;" >Documento</th>
																		<th style="font-weight: bold; min-width: 60px; text-align: center;" >Folio</th>
																		<th style="font-weight: bold; min-width: 100px;">Cliente</th>
																		<th style="font-weight: bold; min-width: 60px; text-align: center;" >Fecha</th>
																		<th style="font-weight: bold; min-width: 70px; text-align: center;">Cobrar antes de</th>
																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Subtotal</th>
																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Descuento</th>
																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Iva</th>
																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Total</th>
																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Pagado</th>
																		<th style="font-weight: bold; min-width: 50px; text-align: right;">xPagar</th>
																	    
																	</tr>
																</thead>
																					
															</table>
														</div>

						</div>
