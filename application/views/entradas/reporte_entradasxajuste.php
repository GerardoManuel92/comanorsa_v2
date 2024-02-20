<div class="row">


	<div class="col-md-5 col-lg-5">

		<label>Buscar por proveedor:</label>
		<select name="proveedor" id="proveedor" class="form-control select2-placeholer" placeholder="seleccionar cliente p/cotizacion..." onchange="showInfo()" style="font-size: 12px;"></select>

	</div>
	<div class="col-md-4 col-lg-4">

		<label for="">Estatus</label>

		<select class="form-control" name="bestatus" id="bestatus" onchange="showInfo();">

			<option value="2" style="font-weight: bold;" selected>Todos...</option>

			<option value="0" style="color:green; font-weight: bold;">Activa</option>

			<option value="1" style="color:red; font-weight: bold;">Cancelada</option>

		</select>

	</div>
	<div class="col-md-3 col-lg-3">
		<button type="button" class="btn btn-success" onclick="showExcel();" style="margin-top: 20px;"><i class="fa fa-file-excel-o" style="color:white; font-weight:bold; font-size: 20px;"></i>&nbsp; Excel</button>
		<!-- <a href="javascript:showExcel();" style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold; font-size: 20px;"></i> Excel</a> -->
	</div>

</div>

<div class="modal fade bd-example-modal-lg" id="modal_partidas" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

	<div class="modal-dialog" role="document">

		<div class="modal-content">

			<div class="modal-header" style="background-color: #2f4a94;">

				<h5 class="modal-title" id="titulo3"><strong style="color:white;">Partidas del ajuste</strong></h5>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">

					<span aria-hidden="true" style="color:white;">&times;</span>

				</button>

			</div>

			<div class="modal-body" id="partidas_ajuste">


				<!--<div class="row">

	      			<div class="col-md-12 col-lg-12">

		      			<h4>101273-101273 / ROTOMARTILLO 1/2" PROFESIONALES 600W -</h4>

		      			<p>Cantidad: 10pz | Costo: $100 mxn | Subtotal: $1,000 mxn</p>

	      			</div>	

	      		</div>


	      		<hr>

	      		<div class="row">

	      			<div class="col-md-12 col-lg-12">

		      			<h4>101273-101273 / ROTOMARTILLO 1/2" PROFESIONALES 600W -</h4>

		      			<p>Cantidad: 10pz | Costo: $100 mxn | Subtotal: $1,000 mxn</p>

	      			</div>	

	      		</div>

	      		<hr>-->


			</div>



			<div class="modal-footer">

				<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarx">Cerrar</button>

				<!--<button type="button" class="btn btn-primary" onclick="guardarPago()" id="btnguardar">Guardar pago</button>-->

			</div>

		</div>

	</div>

</div>

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

					<th style="font-weight: bold; min-width: 50px; text-align: center;">Estatus</th>

					<th style="font-weight: bold; min-width: 70px; text-align: center;">Fecha</th>

					<th style="font-weight: bold; min-width: 50px; text-align: center;">Folio</th>

					<th style="font-weight: bold; min-width: 200px; text-align: left;">Motivo</th>

					<th style="font-weight: bold; min-width: 200px; text-align: left;">Proveedor</th>

					<th style="font-weight: bold; min-width: 100px; text-align: left;">Almaceno</th>

					<th style="font-weight: bold; min-width: 80px; text-align: right;">Total</th>

					<th style="font-weight: bold; min-width: 50px; text-align: right;">Documento</th>
				</tr>

			</thead>



		</table>

	</div>


</div>