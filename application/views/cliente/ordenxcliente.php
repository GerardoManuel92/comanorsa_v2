<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-md" role="document">

    <div class="modal-content">

      <div class="modal-header" style="background-color: #5384bc;">

        <h3 class="modal-title" id="titulo"><strong style="color:white;">Asignar OC a cliente </strong></h3>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true" style="color:white;">&times;</span>

        </button>

      </div>

      <div class="modal-body">

      		<div class="row">
    
	      			<div class="col-md-6 col-lg-6">

	      				<label>Folio de OC:</label>
	      				<input type="text" name="folio" id="folio" class="form-control" >	      			

	      			</div>

					  <div class="col-md-6 col-lg-6"> 
			
					  	<label>Fecha: </label>
						<div id="datepicker" 
							class="input-group date" 
							data-date-format="mm-dd-yyyy"> 
							<input id="dateValue" name="dateValue" class="form-control" type="text" readonly /> 
							<span class="input-group-addon"> 
								<i class="glyphicon glyphicon-calendar"></i> 
							</span> 
						</div>

					</div>

	      	</div>

			  <div class="row" style="margin-top: 10px;">
				<div class="col-md-12 col-lg-12">
					Cliente:
					<div class="row"> 
						<div class="col-md-12">
							<div class="input-group">
								<span class="input-group-addon"><i class="fa fa-user"></i></span>
								<div class="col-md-12" style="padding: 0;">
									<select name="clienteASG" id="clienteASG" class="form-control select2-placeholer" placeholder="seleccionar cliente p/asignar..." style="font-size: 12px; width: 100%;" autofocus></select>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
	      	
			<div class="row" style="margin-top: 10px;">

	      						<div class="col-md-7 col-lg-7"> 

									<!-- ADJUNTAR FIANZA-->								

									<span class="btn btn-labeled btn-primary fileinput-button">

											<i class="btn-label icon fa fa-paperclip"></i>
											<span>*Adjuntar evidencia recepcion</span>
											<input id="fileupload_pdf"  accept=".pdf,.jpg,.png,.jpeg" type="file" name="files[]" multiple>

									</span>

									<div id="progress_bar_factpdf" class="progress">

										<div class="progress-bar progress-bar-primary"></div>

									</div>

								</div>

								<div class="col-md-5 col-lg-5">
							
									<div id="files_cfactpdf" class="files" style="margin-bottom: 10px;">*Sin evidencia adjunta</div>
									<input type="text" name="name_factpdf" id="name_factpdf" class="form-control" disabled>

								</div>	      			

	      	</div>

			  <div class="row">
			  
			  	<div class="col-md-12 col-lg-12">					
					<label>Observaciones:</label>  			
				</div>

			  	<div class="col-md-12 col-lg-12">					
					<textarea name="observaciones" id="observaciones" rows="3" cols="87" class="form-control"></textarea>    			
				</div>

			</div>

      </div>

      <div class="modal-footer">

        <!-- <button class="btn btn-warning btn-rounded btn-block" id="btn_parcial" onclick="entradaParcial()" style="color:black;" disabled><i class="fa fa-file-code-o" style="color:black;" ></i> Entrega parcial</button> -->

        <button class="btn btn-success btn-rounded btn-block" id="btn_all" onclick="asignarOC()"><i class="icon-check"></i> Asignar OC</button>

      </div>

    </div>

  </div>

</div>


<div class="row">

		<div class="col-md-5 col-lg-5"> 


		<button data-toggle="modal" data-target="#modal_estatus" id="btn_estatus" style="display: none;">ver ventana estatus</button>
			
		<label>Filtrar por cliente:</label>
			<div class="input-group"> 

					<span class="input-group-addon"><i class="fa fa-user"></i></span> 

					<select  name="cliente" id="cliente" class="form-control select2-placeholer" placeholder="seleccionar cliente p/cotizacion..." tabindex="1"  style="font-size: 12px;" autofocus onchange="loadPartidas()"></select>

			</div>
			
		</div>

		<div class="col-md-3 col-lg-3">

			

			<label>Filtrar por estatus:</label>			

				<select id="estatus" class="form-control" onchange="loadPartidas()">

					<option value="6" selected>Todos...</option> 

					<option value="1" style="color:darkgreen;">Asignado</option>

					<option value="0" style="color:darkred;">Cancelado</option>

				</select>



		</div>

		

</div>


<div class="row" style="margin-top:20px;">



													<div class="table-responsive">



														<table class="table table-striped table-bordered table-hover" id="my-table" >





															<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

																

																<tr>



																	<th style="font-weight: bold; min-width: 70px; text-align: center;">Acciones</th>

																	<th style="font-weight: bold; min-width: 70px; text-align: center;">Estatus</th>

																	<th style="font-weight: bold; min-width: 400px; text-align: center;">Cliente</th>

																	<th style="font-weight: bold; min-width: 90px; text-align: center;">Factura</th>

																	<th style="font-weight: bold; min-width: 90px; text-align: center;">Orden de Compra</th>

																	<th style="font-weight: bold; min-width: 100px; text-align: center;">Folio</th>

																	<th style="font-weight: bold; min-width: 100px; text-align: center;">Evidencia</th>
																	

																</tr>

															</thead>

																				

														</table>

													</div>



									



</div>			