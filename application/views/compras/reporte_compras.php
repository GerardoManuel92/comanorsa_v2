	<div class="row">

		

		<div class="col-md-5 col-lg-5">

			

			<label>Buscar por proveedor/solicito/total/folio</label>

			<div class="input-group">

				<input type="text" name="buscador" id="buscador" class="form-control">

				<span class="input-group-btn">

					<button class="btn btn-warning" type="button"  onclick="loadFiltroAll()"><i class="fa fa-search" style="color:black;"></i></button>

				</span>

			</div>



		</div>



		<div class="col-md-3 col-lg-3">



			<label>Buscar por estatus:</label>



			<select id="bestatus" class="form-control" onchange="loadFiltroEntrelazado()">

				<option value="6" selected>Todos...</option>
				<option value="0" style="color:#8D27B0; font-weight: bold;">ODC</option>
				<option value="1" style="color:green; font-weight: bold;">Entrada</option>
				<option value="2" style="color:red; font-weight: bold;">Cancelada</option>
				<option value="3" style="color:#B7950B; font-weight: bold;">Entrada Parcial</option>
				<option value="4" style="color:blue; font-weight: bold;">Parcial Finalizada</option>
				<option value="5" style="color:blue; font-weight: bold;">Finalizada sin Entradas</option> x

			</select>



		</div>

		<div class="col-md-3 col-lg-3">

			<div class="col-md-3 col-lg-3">
				<button type="button" class="btn btn-success" onclick="showExcelFiltrado();" style="margin-top: 20px;"><i class="fa fa-file-excel-o" style="color:white; font-weight:bold; font-size: 20px;"></i>&nbsp; Excel</button><br>
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



						<th style="font-weight: bold; min-width: 50px; text-align: center;">Recibir</th>

						<th style="font-weight: bold; min-width: 60px; text-align: center;">Estatus</th>

						<th style="font-weight: bold; min-width: 60px; text-align: center;">Fecha</th>

						<th style="font-weight: bold; min-width: 50px; text-align: center;">Folio</th>

						<th style="font-weight: bold; min-width: 120px; text-align: left;">Solicito</th>

						<th style="font-weight: bold; min-width: 140px; text-align: left;">Proveedor</th>

						<th style="font-weight: bold; min-width: 70px; text-align: right;">Subtotal</th>

						<th style="font-weight: bold; min-width: 70px; text-align: right;">Descuento</th>

						<th style="font-weight: bold; min-width: 70px; text-align: right;">Iva</th>

						<th style="font-weight: bold; min-width: 70px; text-align: right;">Total</th>



					</tr>

				</thead>



			</table>

		</div>







	</div>
