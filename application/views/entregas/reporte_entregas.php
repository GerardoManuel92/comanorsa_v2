	<!--<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default" style="border-color: #5682b6; border-width: 1.5px; border-style: solid; background-color: #F8FFFF">
					<div class="panel-heading clearfix" style="background-color: #5682b6; color: white;">
						<h3 class="panel-title" style="font-weight: bold;"><i class="fa fa-doc"></i> Reporte cotizaciones</h3>
						
					</div>
					<div class="panel-body">

						<div class="row">
							
							<div class="col-md-3 col-lg-3">
								
								<label>Buscar por folio</label>
								<div class="input-group"> 
									<input type="number" class="form-control" id="folio" name="folio"> 
									<span class="input-group-btn"><button class="btn btn-success" type="button" onclick="showFolio()"><i class="fa fa-search"></i></button></span>
								</div>

							</div>

							<div class="col-md-5 col-lg-5">
								
								<label>Buscar por cliente</label>
								<select class="form-control select2-placeholer" id="cliente" name="cliente" style="border-radius: 5px; border-style: solid; border-color: #F1C40F;" onchange="showInfo()"></select>

							</div>

							<div class="col-md-4 col-lg-4">

								<label id="titvndedor">Buscar por vendedor</label>
								<select class="form-control" id="vendedor" name="vendedor" style="background-color: #FDF2E9;" onchange="showInfo()"></select>

							</div>

						</div>


					</div>

				</div>
			</div>
	</div>-->

	<div class="row">

<<<<<<< HEAD
		<div class="col-md-5 col-lg-4">

			<label>Buscar por Entrega/Folio/Factura/Cliente/Entrego/Recibio:</label>
			<div class="input-group">
				<input type="text" name="buscador" id="buscador" class="form-control" oninput="convertirAMayusculas();">
=======
		<div class="col-md-5 col-lg-">

			<label>Buscar por Entrega/Folio/Factura/Cliente/Entrego/Recibio:</label>
			<div class="input-group">
				<input type="text" name="buscador" id="buscador" class="form-control">
>>>>>>> ca63c84eed77a5e94e01248e21a910616fd27e73
				<span class="input-group-btn">
					<button class="btn btn-warning" type="button" onclick="showInfo()"><i class="fa fa-search" style="color:black;"></i></button>
				</span>
			</div>

		</div>

<<<<<<< HEAD
		<div class="col-md-4 col-lg-4">

			<label for="">Estatus</label>

			<select class="form-control" name="bestatus" id="bestatus" onchange="showInfo();">

				<option value="2" style="font-weight: bold;" selected>Todos...</option>

				<option value="0" style="color:green; font-weight: bold;">Activa</option>

				<option value="1" style="color:red; font-weight: bold;">Cancelada</option>

			</select>

		</div>

		<div class="col-md-4 col-lg-4">
=======
		<div class="col-md-3 col-lg-4">
>>>>>>> ca63c84eed77a5e94e01248e21a910616fd27e73
			<button type="button" class="btn btn-success" onclick="showExcel();" style="margin-top: 20px;"><i class="fa fa-file-excel-o" style="color:white; font-weight:bold; font-size: 20px;"></i>&nbsp; Excel</button>
			<!-- <a href="javascript:showExcel();" style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold; font-size: 20px;"></i> Excel</a> -->
		</div>

	</div>

	<!--Basic Modal-->
	<div id="modal_enviar" class="modal fade" tabindex="-1" role="dialog">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header" style="background-color: #5682b6; color: white; font-weight: bold;">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title" style="font-weight: bold;" id="titulo">Enviar cotizacion</h4>
				</div>
				<div class="modal-body">

					<div class="row col-md-12" id="vercotizacion">

						<!--<a href="" style="color:red; font-weight: bold; font-size: 15px;"> <i class="fa fa-eye" style="color:red; font-weight: bold; font-size: 15px;"></i> Ver cotización</a>-->

					</div>

					<div class="row" style="margin-top: 10px;">

						<div class="col-md-12 col-lg-12">

							<label>*Enviar cotizacion a </label>
							<select id="contacto1" name="contacto1" class="form-control"></select>

						</div>

						<div class="col-md-12 col-lg-12" style="margin-top: 15px;">

							<label>Copiar a </label>
							<select id="contacto2" name="contacto2" class="form-control"></select>

						</div>


					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
					<button type="button" class="btn btn-success" onclick="enviarCorreo()">Enviar</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	<!--End Basic Modal-->

	<div class="row">

		<div class="table-responsive">

			<table class="table table-striped table-bordered table-hover" id="my-table">

				<style>
					@media (min-width: 768px) {
						#my-table_info {
							margin-left: 300px;
							width: 40%;
							margin-top: -45px;
						}
					}
				</style>


				<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

					<tr>

						<th style="font-weight: bold; min-width: 50px; text-align: center;">Acciones</th>
						<th style="font-weight: bold; min-width: 60px; text-align: center;">Estatus</th>
						<th style="font-weight: bold; min-width: 60px; text-align: center;">Fecha</th>
<<<<<<< HEAD
						<th style="font-weight: bold; min-width: 90px; text-align: center;">Folio</th>
						<th style="font-weight: bold; min-width: 60px; text-align: center;">Factura</th>
=======
						<th style="font-weight: bold; min-width: 90px; text-align: center;">Factura</th>
						<!-- <th style="font-weight: bold; min-width: 60px; text-align: center;">Factura</th> -->
>>>>>>> ca63c84eed77a5e94e01248e21a910616fd27e73
						<th style="font-weight: bold; min-width: 150px; text-align: left;">Cliente</th>
						<th style="font-weight: bold; min-width: 120px; text-align: center;">Entregó</th>
						<th style="font-weight: bold; min-width: 120px; text-align: center;">Recibió</th>
						<th style="font-weight: bold; min-width: 200px; text-align: left;">Observaciones</th>


					</tr>
				</thead>

			</table>
		</div>

	</div>

	<div class="modal fade bd-example-modal-lg" id="modalPartidas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

		<div class="modal-dialog modal-lg" role="document">

			<div class="modal-content">

				<div class="modal-header" style="background-color: #2f4a94;">

					<h4 class="modal-title" id="titulo_modal"></h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">

						<span aria-hidden="true" style="color:white;">&times;</span>

					</button>

				</div>

				<div class="modal-body">



					<div class="row">


						<div class="col-md-12 col-lg-12">

							<label hidden>Clave: <span id="span_clave" style="font-weight: bold;" hidden></span></label>

							<!-- <select class="form-control" id="lista_banco" name="lista_banco" tabindex="23"> </select> -->

						</div>

						<div class="col-md-12 col-lg-12">

							<h1 style="margin-right:20px; text-align:center;">&nbsp;&nbsp;&nbsp;&nbsp;Lista de partidas </h1>
							<table class="table table-striped table-bordered table-hover" id="my-table_modal">

								<style>
									@media (min-width: 768px) {
										#my-table_modal {

											width: 1200px;

										}

										#my-table_modal_length {
											margin-left: 0;
											width: 40%;
											margin-top: 20px;
										}

										#my-table_modal_info {
											margin-left: 300px;
											width: 40%;
											margin-top: -45px;
										}

									}
								</style>

								<!-- <div class="col-md-3 col-lg-4">
									<button type="button" class="btn btn-success" onclick="showExcel();"><i class="fa fa-file-excel-o" style="color:white; font-weight:bold; font-size: 20px;"></i>&nbsp; Excel</button>
									
								</div> -->




								<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">



									<tr>

										<th style="font-weight: bold; min-width: 100px; text-align: center;">NParte</th>

										<th style="font-weight: bold; min-width: 420px; text-align: center;">Descripcion</th>

										<th style="font-weight: bold; min-width: 70px; text-align: center;">Cantidad</th>

										<th style="font-weight: bold; min-width: 100px; text-align: center;">Unidad</th>




									</tr>

								</thead>



							</table>
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