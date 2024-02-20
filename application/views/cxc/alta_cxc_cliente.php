

	<!--<button onclick="showEditar()" value="Editar" class="btn btn-success">Habilitar</button>



	<a href="#" id="username" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">Editar texto</a>-->





<!-- MODAL COBRO -->

<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-lg" role="document">

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

									<div class="col-md-12 col-lg-12">
										
										<label>Seleccionar movimiento</label>
										<select class="form-control" id="lista_movimientos" name="lista_movimientos" onchange="verSaldo(this.value)"></select>

									</div>


									<input type="number" name="monto_pago" id="monto_pago" value="0" class="form-control" disabled style="display:none;">

		      			

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

	      				<input type="number" name="pago" id="pago" class="form-control" style="text-align: right;" disabled>



	      				<input type="number" name="totpago" id="totpago" class="form-control" style="text-align: right; display: none;" disabled>





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

<div class="modal fade bd-example-modal-lg" id="modal_pagos" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header" style="background-color: #2f4a94;">

        <h5 class="modal-title" id="titulo3"><strong style="color:white;">Pagos de factura</strong></h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true" style="color:white;">&times;</span>

        </button>

      </div>

      <div class="modal-body">


	      		<div class="row">


	      			<div class="col-md-7 col-lg-7" style="text-align: right;">


	      				<p style="font-size:17px;" id="mpfpago">Forma de pago: &nbsp;&nbsp;Pago en una sola exhibicion</p>

	      			</div>

	      			<div class="col-md-5 col-lg-5" style="text-align: right;">


	      				<p style="font-size:17px; color:darkblue; font-weight:bold;" id="mpinfo"></p>

	      			</div>



	      		</div>


	      		<hr>


	      		<div class="row" style="text-align:center;" id="pagos_factura">
	      			
	      			

	      		</div>



      			

      </div>



      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarx">Cerrar</button>

        <button type="button" class="btn btn-primary" onclick="guardarPago()" id="btnguardar">Guardar pago</button>

      </div>

    </div>

  </div>

</div>


<!-- MODAL -->

<!--<div class="modal fade bd-example-modal-lg" id="modalnota" tabindex="-1" role="dialog" aria-labelledby="notaModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header" style="background-color: #2f4a94;">

        <h5 class="modal-title" id="titulo"><strong style="color:white;">Nota de credito  </strong></h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true" style="color:white;">&times;</span>

        </button>

      </div>

      	<div class="modal-body">

        

      		<div class="row">

      				

      							<div class="col-md-12 col-lg-12"> 



								

									<span class="btn btn-labeled btn-primary fileinput-button">



											<i class="btn-label icon fa fa-paperclip"></i>



											<span>*Adjuntar NC</span>



											<input id="fileupload_nc"  accept=".xml" type="file" name="files[]" multiple>



									</span>



									<div id="progress_bar_nc" class="progress">



										<div class="progress-bar progress-bar-primary"></div>



									</div>



								</div>



								<div class="col-md-12 col-lg-12">

									

									<div id="files_nc" class="files" style="margin-bottom: 10px;">*Sin NC adjunta</div>



									<input type="text" name="name_nc" id="name_nc" class="form-control" disabled>



								</div>

	      			

	      	</div>



	      	<hr>



	      	<div class="row" id="datos_nota" style="display:none; ">



	      		<div class="col-md-12">

	      		

		      		<h4 id="titulo_nota">Datos de la nota de credito </h4>



		      		<p id="cliente_nota"></p>

		      		<p id="folio_nota"></p>

		      		<p id="factura_nota"></p>

		      		<p id="total_nota"></p>

		      		<p id="fpago_nota"></p>



		      		<input style="display: none;" type="number" name="idfactura_nota" id="idfactura_nota" disabled>

		      		<input style="display: none;" type="number" name="tipo_factura" id="tipo_factura" disabled>



		      	</div>



	      	</div>

      			

      	</div>



      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarx2">Cerrar</button>

        <button type="button" class="btn btn-primary" onclick="guardarNota()" id="btnguardar">Agregar Nota</button>

      </div>

    </div>

  </div>

</div>-->



<div class="modal fade bd-example-modal-lg" id="modalnota" tabindex="-1" role="dialog" aria-labelledby="notaModalLabel" aria-hidden="true">

  <div class="modal-dialog" role="document">

    <div class="modal-content">

      <div class="modal-header" style="background-color: #2f4a94;">

        <h5 class="modal-title" id="titulo"><strong style="color:white;">Nota de credito  </strong></h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true" style="color:white;">&times;</span>

        </button>

      </div>

      	<div class="modal-body">


      		<div class="row">
      			
      			<div class="col-md-8 col-lg-8" id="factura_pagar" name="factura_pagar">
      				


      			</div>

      			<div class="col-md-4 col-lg-4" style="text-align: right;">

      				<label>Saldo por cobrar</label>
      				<input type="text" name="xpagar" id="xpagar" class="form-control" disabled style="text-align: right;">
      				

      			</div>

      		</div>
        
      		<div class="row">

      			<div class="col-md-12 col-lg-12">
      				
      				<label>Selecione la forma de implementarla</label>
      				<select class="form-control" id="forma" name="forma" onchange="ShowTnota(this.value)">  

      					<option value="0" selected>Seleccionar</option>
      					<option value="1" >Añadir</option>

      				</select>

      			</div>
      			

      		</div>


      		<div class="row" id="subir_nota" style="display: none; margin-top: 15px;">

      				

      							<div class="col-md-12 col-lg-12"> 



								

									<span class="btn btn-labeled btn-primary fileinput-button">



											<i class="btn-label icon fa fa-paperclip"></i>



											<span>*Adjuntar NC</span>



											<input id="fileupload_nc"  accept=".xml" type="file" name="files[]" multiple>



									</span>



									<div id="progress_bar_nc" class="progress">



										<div class="progress-bar progress-bar-primary"></div>



									</div>



								</div>



								<div class="col-md-12 col-lg-12">

									

									<div id="files_nc" class="files" style="margin-bottom: 10px;">*Sin NC adjunta</div>



									<input type="text" name="name_nc" id="name_nc" class="form-control" disabled>



								</div>

	      			

	      	</div>

	      	<div class="row" id="select_nota" style="display:; margin-top: 15px;">
	      		
	      		<!-- MOSTRAMOS LAS NOTAS APLICADAS AL CLIENTE SELECCIONADO EN EL FILTREO ANTERIOR-->

	      		<div class="co-md-12 col-lg-12">

		      		<label>*Seleccione la nota a aplicar</label>


		      		<div class="input-group">
		      			<select class="form-control" id="lista_notas" name="lista_notas"></select>
		      			<span class="input-group-btn">

		      				<button class="btn btn-primary" id="btn_ntc" name="btn_ntc" onclick="showNc()"><i class="fa fa-eye"></i></button>

		      			</span>
		      		</div>

	      		</div>

	      	</div>



	      	<hr>



	      	<div class="row" id="datos_nota" style="display:none; ">



	      		<div class="col-md-12">

	      		

		      		<h4 id="titulo_nota">Datos de la nota de credito </h4>



		      		<p id="cliente_nota"></p>

		      		<p id="folio_nota"></p>

		      		<p id="factura_nota"></p>

		      		<p id="total_nota"></p>

		      		<p id="fpago_nota"></p>



		      		<input style="display: none;" type="number" name="idfactura_nota" id="idfactura_nota" disabled>

		      		<input style="display: none;" type="number" name="tipo_factura" id="tipo_factura" disabled>



		      	</div>



	      	</div>

      			

      	</div>



      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarx2">Cerrar</button>

        <button type="button" class="btn btn-primary" onclick="guardarNota()" id="btnguardar">Agregar Nota</button>

      </div>

    </div>

  </div>

</div>


<div class="row">



				<div class="col-md-9 col-lg-9 col-xs-12">



					<div class="row">



							<div class="col-md-7 col-lg-7">

			

								<label>Buscar por Factura/Cliente/:</label>

								<select  name="cliente" id="cliente" class="form-control select2-placeholer" placeholder="seleccionar cliente p/cotizacion..." onchange="showxCliente()" style="font-size: 12px;"></select>



							</div>



							<div class="col-md-2 col-lg-2">

								

								<!--<button class="btn btn-primary" data-toggle="modal" data-target="#modalnota" style="margin-top: 23px;" >Añadir NC</button>-->



							</div>



					</div>



					<div class="row" style="margin-top: 20px;">



							<div class="col-md-2 col-lg-2"> 



								<label>Filtrar por estatus: </label>

								<select  name="estatus" id="estatus" class="form-control" tabindex="2" onchange="showxCliente()"  style="font-size: 12px;">

									

									<option value="0" selected style="color: darkblue; font-weight: bold;">TODAS</option>

									<option value="5" style="font-weight: bold;">ACTIVAS Y VENCIDAS</option>

									<option value="1" style="color: darkblue; font-weight: bold;">ACTIVAS</option>

									<option value="2" style="color: darkgreen; font-weight: bold;">COBRADAS</option>

									<option value="3" style="color: red; font-weight: bold;">VENCIDAS</option>

									<option value="4" style="color:#E1A009; font-weight: bold;">CANCELADAS</option>



								</select>

								



							</div>







							<div class="col-md-2 col-lg-2">

								

								<label>Fecha inicial:</label>

								<input type="date" name="incial" id="incial" class="form-control">



							</div>



							<div class="col-md-2 col-lg-2">

								

								<label>Fecha final:</label>

								<input type="date" name="final" id="final" class="form-control">



							</div>





							<div class="col-md-6 col-lg-6" style="margin-top: 24px;">

								

								<button class="btn btn-warning" style="color:black;" onclick="buscarxFecha()"><i class="fa fa-search"></i> Buscar</button>

								<button class="btn btn-danger" onclick="generarPdf()">Generar PDF</button>

								<button class="btn btn-success" onclick="generarExcel()">Estado de cuenta EXCEL</button>



							</div>







					</div>



				</div>



				<div class="col-md-3 col-lg-3 col-xs-12">

					

					<div class="col-md-12 col-lg-12 " class="pull-right" style="text-align: right;" id="pagosx">

								

								<!--<p style="color: darkblue; display: ; font-size: 18px; font-weight: bold;">Total: $ 0.00</p>

								<p style="color: green; font-weight: bold; font-size: 17px; " >Pagado: $ 0.00</p>

								<p style="color: red; font-weight: bold; font-size: 17px; " >Por cobrar: $ 0.00</p>-->

							



					</div>



				</div>

			

</div>



						<div class="row" style="margin-top: 20px; ">







														<div class="table-responsive">



															<table class="table table-striped table-bordered table-hover" id="my-table" >





																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

																	

																	<tr>

																		<th style="font-weight: bold; min-width: 40px; text-align: center; text-transform: capitalize;">Accion</th>

																		<th style="font-weight: bold; min-width: 60px; text-align: center; text-transform: capitalize;">Estatus</th>

																		

																		<th style="font-weight: bold; min-width: 60px; text-align: center; text-transform: capitalize;" >Factura</th>

																		

																		<th style="font-weight: bold; min-width: 50px; text-align: center; text-transform: capitalize;" >Fecha</th>

																		<th style="font-weight: bold; min-width: 40px; text-align: center; text-transform: capitalize;">Dias credito</th>

																		<th style="font-weight: bold; min-width: 60px; text-align: center; text-transform: capitalize;">Cobrar antes de</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: right; text-transform: capitalize;">Subtotal</th>

																		<th title="Descuento" style="font-weight: bold; min-width: 40px; text-align: right; text-transform: capitalize;">Desc.</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: right;">IVA</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: right; text-transform: capitalize;">Total</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: right; text-transform: capitalize;">Total N.C.</th>

																		<th style="font-weight: bold; min-width: 60px; text-align: right; text-transform: capitalize;">Pagado</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: right; text-transform: capitalize;">xPagar</th>

																	    

																	</tr>

																</thead>

																					

															</table>

														</div>



						</div>

