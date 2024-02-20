<div class="row" >
		


				<div class="col-md-10 col-lg-10 col-xs-12">



					<div class="row">

							<div class="col-md-7 col-lg-7"> 

								<div class="input-group"> 

										<select  name="proveedor" id="proveedor" class="form-control select2-placeholer" placeholder="seleccionar proveedor" tabindex="1"  style="font-size: 12px;"></select>

										<span class="input-group-btn"><button class="btn btn-success" type="button" onclick="window.open('<?php echo base_url() ?>AltaProveedor/altaProveedor/0','_blank')" tabindex="-1"><i class="fa fa-plus-square"></i></button></span>

								</div>

								



							</div>



							

							<div class="col-md-3 col-lg-3">

											
											<span class="btn btn-labeled btn-primary fileinput-button" style="display: none;">



													<i class="btn-label icon fa fa-paperclip"></i>



													<span>*Adjuntar comprobante</span>



													<input id="fileupload_pdf"  accept=".pdf" type="file" name="files[]" multiple>



											</span>

										

											<div id="progress_bar_factpdf" class="progress" >



												<div class="progress-bar progress-bar-primary"></div>



											</div>
								

							</div>



							<div class="col-md-2 col-lg-2">
								
								<input type="text" style="display: none;" name="name_archivo" id="name_archivo" class="form-control" placeholder="Comprobante..." tabindex="3" disabled>
								
							</div>
							


					</div>


					<div class="row" style="margin-top: 0px;">

						
					<div class="col-md-12 col-lg-12">

						

						<textarea class="form-control" id="motivo" name="motivo" rows="2" style="font-size: 13px;" tabindex="7" placeholder="Motivo..."></textarea>



					</div>

					</div>

					<div class="row" style="margin-top: 15px;">

					

							<div class="col-md-8 col-lg-8">



								<input type="text" name="bi_pro" id="bi_pro" class="form-control"  placeholder="Buscar por descripcion/clave/tag..." tabindex="4" style="font-size: 12px;" autofocus="true">

								

							</div>



							<div class="col-md-1 col-lg-1">

								

								<button class="btn btn-success" type="button" onclick="window.open('<?php echo base_url() ?>AltaProducto/altaProducto/0','_blank')" tabindex="-1"><i class="fa fa-plus-square"></i></button>



							</div>



							<div class="col-md-2 col-lg-2">

								

								<div class="input-group">

								<input type="number" name="cantidad" class="form-control" id="cantidad" placeholder="cantidad..." style="text-align: right;" tabindex="5" onblur="calcularSubtotal()">

								<span style="font-size: 12px; color:red; font-weight: bold; display: none;" id="txt_cantidad">*Agregue una cantidad valida</span>

								</div>



							</div>



							<div class="col-md-1 col-lg-1">

								

								<!--<input type="text" name="unidad" class="form-control" id="unidad" placeholder="UM..." disabled>--><p id="unidad" style="font-size: 22px; font-weight: bold;">U.M.</p>



							</div>



							



					</div>





					<div class="row" style="margin-top: 0px;">



						<div class="col-md-12 col-lg-12">

							

							<textarea class="form-control" id="descripcion" name="descripcion" rows="2" style="font-size: 13px;" tabindex="6" placeholder="Descripcion..." disabled></textarea>



						</div>			


					</div>

					


					<div class="row" style="margin-top: 15px;">



							<div class="col-md-2 col-lg-2" >

								<div class="col-md-2 col-lg-2" style="display: none;">

									<input type="number" name="tasa" class="form-control" id="tasa" placeholder="tasa..." tabindex="-1" style="text-align: right;">

								</div>

								<div class="input-group">

								<input type="text" name="costo" class="form-control" id="costo" placeholder="($)costo..." tabindex="8" style="text-align: right;">

								<span style="font-size: 12px; color:red; font-weight: bold; display: none;" id="txt_costo">*Agregue un costo valido</span>

								</div>



							 </div>



	

							<div class="col-md-2 col-lg-2">

								

								<input type="text" name="total" class="form-control" id="total" placeholder="($)subtotal..." style="text-align: right;" tabindex="-1" disabled>



							</div>



							<div class="col-md-2 col-lg-2" id="btn_alta" style="display: ;" >

								

								<button class="btn btn-blue" type="button" class="form-control" onclick="ingresarPartidas()" tabindex="11" id="btn_ingresar"><i class="fa fa-arrow-right"></i></button>



								<button class="btn btn-warning" type="button" style="color: black;" class="form-control" onclick="showObs()" tabindex="-1" id="abrirobs"><i class="fa fa-eye"></i></button>



								<button class="btn btn-danger" type="button" class="form-control" style="display: none; " onclick="cerrarObs()" tabindex="-1" id="cerrarobs"><i class="fa fa-close"></i></button>



								<!--<button class="btn btn-blue" type="button" class="form-control" onclick="ingresarCot()" tabindex="9"><i class="fa fa-spinner fa-spin"></i></button>-->



							</div>



							<!--<div class="col-md-2 col-lg-2" id="btn_act" style="display: none;" >

								

								<button class="btn btn-blue" type="button" class="form-control" onclick="actualizarPartidas()" tabindex="11" id="btn_ingresar2"><i class="fa fa-arrow-right"></i></button>



								<button class="btn btn-red" type="button" class="form-control" onclick="cancelarIngreso()" tabindex="-1" id="btn_cancelar"><i class="fa fa-close"></i></button>



								<button class="btn btn-blue" type="button" class="form-control" onclick="ingresarCot()" tabindex="9"><i class="fa fa-spinner fa-spin"></i></button>



							</div>-->



							<!--<div class="col-md-2 col-lg-2">

								

								<p id="abrirobs"><a href="javascript:showObs()" style="font-weight: bold; font-size: 14px;"><i class="fa fa-pencil"></i>+observación</a></p>

								<p id="cerrarobs" style="display: none;"><a href="javascript:cerrarObs()" style="color:red;"><i class="fa fa-close"></i> cerrar observación</a></p>



							</div>-->



					</div>





					<!-- AGREGAR OBSERVACIONES Y UTILIDAD O DESCUENTO GENERAL-->



					<div class="row" id="agobs" style="display: none; margin-top: 10px;">

						

						<div class="row">



							<div class="col-md-12 col-lg-12" >

									

									<textarea id="obs" class="form-control" rows="3" placeholder="Agregar observaciones..." maxlength="300"></textarea>



							</div>



						</div>



					


					</div>





				</div>



				<div class="col-md-2 col-lg-2 " style="text-align: right;">

								

								<h4 style="font-weight: bold; margin-bottom: 10px;"><a href="javascript:verDetalles()" style="font-size: 11px;">(ver detalles)</a><a href="javascript:cerrarDetalles()" id="cerrar" style="display: none;"><i class="fa fa-close" style="color:red; font-weight: bold;"></i></a></h4>

								<p style="color: green; display: ; font-size: 17px;" id="tsubtotal"></p>

								<p style="color: red; display: none;" id="tdescuento"></p>

								<p style="color: darkblue; display: none;" id="tiva"></p>

								<h3 style="color:darkgreen; font-weight: bold;" id="tneto"></h3>



				</div>



							

</div>


<div class="row" style="margin-top: 20px; ">



														<div class="table-responsive">



															<table class="table table-striped table-bordered table-hover" id="my-table" >





																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

																	

																	<tr>

																		<th style="font-weight: bold; min-width: 30px; text-align: center;"></th>

																		

																		<th style="font-weight: bold; min-width: 40px; text-align: right;">Cant</th>

																		<th style="font-weight: bold; min-width: 90px; text-align: center;">Clave</th>

																		<th style="font-weight: bold; min-width: 200px;">Descripcion</th>

																		<th style="font-weight: bold; min-width: 40px; text-align: center;">UM</th>

																		<th style="font-weight: bold; min-width: 70px; text-align: right;">Costo</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: center;">Iva(%)</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Subtotal</th>

																		

																	</tr>

																</thead>

																					

															</table>

														</div>



						</div>
