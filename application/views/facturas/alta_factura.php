<div class="row" >



							<div class="form-group col-md-2 col-sm-12 col-lg-2" style="display: none;"> 

								

									<div id="fechar" class="input-group date">



										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>  

										<input id="fecha" type="text" class="form-control" > 

										

									</div>

							</div>



							<!--<div class="col-md-1 col-lg-1">

								

								<p style="font-size: 17px; text-align: right;">Cliente: </p>



							</div>-->



				<div class="col-md-10 col-lg-10 col-xs-12">



					<div class="row">





							<div class="col-md-8 col-lg-8"> 



								

								<div class="input-group"> 



										<span class="input-group-addon"><i class="fa fa-user"></i></span> 

										<select  name="cliente" id="cliente" class="form-control select2-placeholer" placeholder="seleccionar cliente p/cotizacion..." tabindex="1"  style="font-size: 12px;" onchange="verDatosCli()"></select>

										<span class="input-group-btn"><button class="btn btn-success" type="button" onclick="window.open('<?php echo base_url() ?>AltaCliente/altaCliente/0','_blank')" tabindex="-1"><i class="fa fa-plus-square"></i></button></span>

								</div>

								



							</div>





							<div class="col-md-2 col-lg-2">

								

								<select class="form-control" id="moneda" name="moneda" tabindex="2" style="font-size: 12px;" onchange="tmoneda(this.value)">

									

									<option value="1">PESOS</option>

									<option value="2">DOLARES</option>



								</select>	



							</div>



							<div class="col-md-2 col-lg-2">



								<div class="input-group">



									<span class="input-group-addon">T.C.</span>

									<input type="number" name="tc" id="tc" class="form-control" style="text-align: right;" value="1" tabindex="3" disabled>



								</div>	



							</div>



					</div>



					<div class="row" style="margin-top: 10px;">



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





					<div class="row" style="margin-top: 1px;">



						<div class="col-md-12 col-lg-12">

							

							<textarea class="form-control" id="descripcion" name="descripcion" rows="2" style="font-size: 13px;" tabindex="6" placeholder="Descripcion..."></textarea>



						</div>

						



					</div>







					<div class="row" style="margin-top: 5px;">



							<div class="col-md-2 col-lg-2" >

								

								<div class="input-group">

								<input type="text" name="costo" class="form-control" id="costo" placeholder="($)costo..." tabindex="7" style="text-align: right;" onblur="calcularSubtotal()">

								<span style="font-size: 12px; color:red; font-weight: bold; display: none;" id="txt_costo">*Agregue un costo valido</span>

								</div>



							 </div>





							<div class="col-md-2 col-lg-2">



								<div class="input-group"> 



									<span class="input-group-addon" style="color:green; font-weight: bold;">%</span> 

									<input type="number" name="utilidad" class="form-control" id="utilidad" placeholder="utilidad..." tabindex="8" style="text-align: right;" onblur="calcularSubtotal()">



								</div>



							</div>





							<div class="col-md-2 col-lg-2">

								

								<input type="text" name="precio" class="form-control" id="precio" placeholder="($)precio..." style="text-align: right;" tabindex="9" onblur="calcularSubtotalPrecio()">



							</div>



							<div class="col-md-2 col-lg-2">



								<div class="input-group"> 



									<span class="input-group-addon" style="color:red; font-weight: bold;">-%</span>

								

									<input type="number" name="descuento" class="form-control" id="descuento" placeholder="Desc..." tabindex="10" style="text-align: right;">



								</div>



							</div>





							<div class="col-md-2 col-lg-2" style="display: none;">



									<input type="number" name="tasa" class="form-control" id="tasa" placeholder="tasa..." tabindex="-1" style="text-align: right;">





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



						<div class="row" style="margin-top: 10px;">



							<div class="col-md-2 col-lg-2">

								

									<div class="input-group"> 



										<span class="input-group-addon" style="color:green; font-weight: bold;">%</span>

									

										<input type="number" name="gutilidad" class="form-control" id="gutilidad" placeholder="Uti_general..." style="text-align: right;">



									</div>



							</div>



							<div class="col-md-2 col-lg-2">

								

									<div class="input-group"> 



										<span class="input-group-addon" style="color:red; font-weight: bold;">-%</span>

									

										<input type="number" name="gdescuento" class="form-control" id="gdescuento" placeholder="Desc_general..."  style="text-align: right;">



									</div>



							</div>



							<div class="col-md-3 col-lg-3">

								

								<button class="btn btn-success" onclick="porcientoAll()" id="btntodos"> Aplicar a todos</button>

								<button class="btn btn-success" onclick="porcientoFal()" id="btnvacios"> Solo a faltantes</button>



							</div>



						</div>



					</div>



					<!-- MOSTRAR IMPUESTOS POR RETENCIONES -->



					<div class="row" id="retenciones" style="display:none; margin-top: 10px;">



						<div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">

							

							<label id="tit_iva"></label>

							<input type="number" id="valor_riva" disabled value="0">

							<input type="text" name="riva" id="riva" class="form-control" value="0" disabled="" style="text-align: right;">



						</div>



						<div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">

							

							<label id="tit_isr"></label>

							<input type="number" id="valor_risr" disabled value="0">

							<input type="text" name="risr" id="risr" class="form-control" value="0" disabled="" style="text-align: right;">



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

																		<th style="font-weight: bold; min-width: 30px; text-align: center;">No.</th>

																		<th style="font-weight: bold; min-width: 40px; text-align: right;">Cant</th>

																		<th style="font-weight: bold; min-width: 70px; text-align: center;">Clave</th>

																		<th style="font-weight: bold; min-width: 400px;">Descripcion</th>

																		<th style="font-weight: bold; min-width: 40px; text-align: center;">UM</th>

																		<th style="font-weight: bold; min-width: 70px; text-align: right;">Precio</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Iva(%)</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Des(%).</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Utl(%).</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Tc.</th>

																		<th style="font-weight: bold; min-width: 80px; text-align: right;">Subtotal</th>

																	    

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

	        <h4 class="modal-title"><strong>Alta facturación</strong></h4>



	      </div>

		    <div class="modal-body">



		      	<div class="row" id="namefactura" style="display: none;">

		      		

		      		<div class="col-md-12">

		      			

		      			<label>*Nombre emisor de la factura(editable)</label>

		      			<input type="text" name="name_factura" class="form-control" id="name_factura" value="VENTAS PUBLICO GENERAL">



		      		</div>



		      	</div>



		      	<hr>

		        

		      	<div class="row">



		      		

		      		

		      		<div class="col-md-6">

		      			

		      			<label>*Metodo de pago</label>

		      			<select id="mpago" class="form-control" onchange="estatusFpago(this.value)"></select>



		      		</div>



		      		<div class="col-md-6">

		      			

		      			<label>*Forma de pago</label>

		      			<select id="fpago" class="form-control" ></select>



		      		</div>



		      		<div class="col-md-9" style="margin-top: 10px;">

		      			

		      			<label>*Uso de CFDI</label>

		      			<select id="cfdi" class="form-control" ></select>



		      		</div>



		      		<div class="col-md-3" style="text-align: right; margin-top: 10px;">

		      			

		      			<label>Dias credito</label>

		      			<input type="number" name="credito" class="form-control" id="credito" style="text-align: right;" >



		      		</div>







		      	</div>



		      	<hr>



		      	<div class="row">



		      							<div class="col-md-7 col-lg-7"> 

											<!-- ADJUNTAR FIANZA-->



										

											<span class="btn btn-labeled btn-primary fileinput-button">



													<i class="btn-label icon fa fa-paperclip"></i>



													<span>Adjuntar ODC del cliente</span>



													<input id="fileupload_pdf"  accept=".pdf,.jpg,.png,.jpeg" type="file" name="files[]" multiple>



											</span>



											<div id="progress_bar_factpdf" class="progress">



												<div class="progress-bar progress-bar-primary"></div>



											</div>



										</div>



										<div class="col-md-5 col-lg-5">

											

											<div id="files_cfactpdf" class="files" style="margin-bottom: 10px;">*Sin ODC adjunta</div>



											<input type="text" name="name_factpdf" id="name_factpdf" class="form-control" disabled>



										</div>

			      			 



		      	</div>


		      	<hr>

		      	<div class="row" id="creditox">

		      		<div class="col-md-12">
		      			
		      			<h3 style="font-weight: bold; color:darkblue; ">Credito</h3>

		      		</div>

		      		<div class="col-md-12">

		      			<input type="number" name="limite" style="display: none;" id="limite" class="form-control" value="0" disabled hidden >

			      	</div>

			      	<div class="col-md-6 col-lg-6 col-xs-12" id="pagosx">
			      		


			      	</div>

			      	<div class="col-md-6 col-lg-6 col-xs-12" id="datos_factura">
			      		


			      	</div>

		      	</div>

		      	<hr>

		      	<div class="row" id="alertax">

		      		<!--<div class="col-md-12 col-lg-12">


				      	<h4 style="color:red; font-size:17px; font-weight:bold;">Factura no autorizada, limite de credito excedido</h4>

									
						<div class="col-md-6 col-lg-6 col-xs-12">

							<label>*Ingresar contraseña admin</label>
							<div class="input-group"> 
								<input type="password" class="form-control" id="passadmin" name="passadmin">
								<span class="input-group-btn"><button class="btn btn-primary" type="button" onclick="habilitarFact()">Habilitar facturacion</button></span>
							</div>


						</div>

						
						

					</div>-->

			      

			    </div>



			</div>







	      <div class="modal-footer">

	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

	        <button type="button" class="btn btn-success" onclick="finalizarFactura()" id="btnfactura"><i class="fa fa-check"> Facturar</i></button>

	      </div>

    </div><!-- /.modal-content -->

  </div><!-- /.modal-dialog -->

</div><!-- /.modal -->

<!--End Basic Modal-->







