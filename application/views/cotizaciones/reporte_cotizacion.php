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



		<div class="col-md-5 col-lg-4">



			<label>Buscar por cliente/empresa/total/folio/vendedor:</label>

			<div class="input-group">

				<input type="text" name="buscador" id="buscador" class="form-control" oninput="convertirAMayusculas();">

				<span class="input-group-btn">

					<button class="btn btn-warning" type="button" onclick="showInfo()"><i class="fa fa-search" style="color:black;"></i></button>

				</span>

			</div>



		</div>



		<div class="col-md-3 col-lg-3">



			<label>Buscar por estatus:</label>



			<select id="bestatus" class="form-control" onchange="showInfoEstatus()">

				<option value="6" selected>Todos...</option>

				<option value="0" style="color:darkblue;">Cotizacion</option>

				<option value="4" style="color:blue;">Pedido</option>

				<option value="2" style="color:orange;">Sin facturar</option>

				<option value="5" style="color:#581845;">En proceso de facturacion</option>

				<option value="3" style="color:darkgreen;">Finalizada</option>

			</select>



		</div>

		<!-- <div class="col-md-2 col-lg-2">
			<button type="button" class="btn btn-warning" onclick="" style="margin-top: 20px;"><i class="fa fa-refresh" style="color:white; font-weight:bold; font-size: 20px;"></i>&nbsp; Reestablecer</button><br>
		</div> -->

		<div class="col-md-2 col-lg-2">
			<button type="button" class="btn btn-success" onclick="showExcelGeneral();" style="margin-top: 20px;"><i class="fa fa-file-excel-o" style="color:white; font-weight:bold; font-size: 20px;"></i>&nbsp; Excel</button><br>
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



						<div class="col-md-12 col-lg-12" style="margin-top: 15px;">



							<label>Enviar a correo nuevo</label>

							<input type="text" id="contacto3" name="contacto3" class="form-control">



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



	<!--Basic Modal-->

	<div id="modal_pedido" class="modal fade" tabindex="-1" role="dialog">

		<div class="modal-dialog">

			<div class="modal-content">

				<div class="modal-header" style="background-color: #5682b6; color: white; font-weight: bold;">

					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

					<h4 class="modal-title" style="font-weight: bold;" id="titulo">Confirmar pedido</h4>

				</div>

				<div class="modal-body">



					<div class="row col-md-12" id="vercotizacion">



						<!--<a href="" style="color:red; font-weight: bold; font-size: 15px;"> <i class="fa fa-eye" style="color:red; font-weight: bold; font-size: 15px;"></i> Ver cotización</a>-->



					</div>



					<!--<div class="row" style="margin-top: 10px;">

	        	

	        	<div class="col-md-12 col-lg-12">

	        		

	        		<label>*Colocar enlace de la evidencia</label>

	        		<textarea class="form-control" rows="3" name="evidencia" id="evidencia"></textarea>



	        	</div>



	        </div>



	        <hr>-->



					<div class="row">



						<div class="col-md-7 col-lg-7">

							<!-- ADJUNTAR FIANZA-->





							<span class="btn btn-labeled btn-primary fileinput-button">



								<i class="btn-label icon fa fa-paperclip"></i>



								<span>Adjuntar evidencia</span>



								<input id="fileupload_pdf" accept=".pdf,.jpg,.png,.jpeg" type="file" name="files[]" multiple>



							</span>



							<div id="progress_bar_factpdf" class="progress">



								<div class="progress-bar progress-bar-primary"></div>



							</div>



						</div>



						<div class="col-md-5 col-lg-5">



							<div id="files_cfactpdf" class="files" style="margin-bottom: 10px;">*Sin evidencia</div>



							<input type="text" name="name_factpdf" id="name_factpdf" class="form-control" disabled>



						</div>





					</div>





				</div>

				<div class="modal-footer">

					<button type="button" class="btn btn-default" data-dismiss="modal" id="cerrarx">Cerrar</button>

					<button type="button" class="btn btn-success" onclick="crearPedido()">Crear pedido</button>

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

						<th style="font-weight: bold; min-width: 90px; text-align: left;">Vendedor</th>

						<th style="font-weight: bold; min-width: 60px; text-align: center;">Folio</th>

						<th style="font-weight: bold; min-width: 150px; text-align: left;">Cliente</th>

						<th style="font-weight: bold; min-width: 130px; text-align: left;">Contacto</th>

						<th style="font-weight: bold; min-width: 80px; text-align: right;">Subtotal</th>

						<th style="font-weight: bold; min-width: 80px; text-align: right;">Desc</th>

						<th style="font-weight: bold; min-width: 80px; text-align: right;">Iva</th>

						<th style="font-weight: bold; min-width: 80px; text-align: right;">Total</th>



					</tr>

				</thead>



			</table>

		</div>







	</div>