<div class="row">
	<div class="col-md-3 col-lg-3" style="display: flex; flex-direction: row; column-gap: 20px;">



		<label>Categoria:</label>



		<select id="bcategoria" class="form-control" onchange="validaCombo(); showInfoCategoria();">



		</select>


	</div>
	<div class="col-md-3 col-lg-3" style="display: flex; flex-direction: row; column-gap: 20px;">



		<label>Marca:</label>



		<select id="bmarca" class="form-control" onload="showInfoCategoria()" onchange="validaCombo(); showInfoCategoria();" data-placeholder="Todas...">



		</select>


	</div>

	<div class="col-md-3 col-lg-4">
		<button type="button" class="btn btn-warning" onclick="reestablecer();">Reestablecer</button>
		<button type="button" class="btn btn-success" onclick="showexcel();"><i class="fa fa-file-excel-o" style="color:white; font-weight:bold; font-size: 20px;"></i>&nbsp; Excel</button>
	</div>
</div>
<div class="row">



	<div class="table-responsive">



		<table class="table table-striped table-bordered table-hover" id="my-table">

		<style>
			@media (min-width: 768px) {
				#my-table_filter{
					margin-left: 0px;
					width: 30%;
					margin-top: 20px;
				}

				#my-table_paginate{
					margin-left: 500px;
					width: 45%;
					margin-top: -35px;
				}

				#my-table_length{
					margin-left: 0;
					width: 40%;
					margin-top: 20px;
				}

				#my-table_info{
					margin-left: 300px;
					width: 40%;
					margin-top: -45px;
				}
			}
		</style>





			<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">



				<tr>



					<th style="font-weight: bold; min-width: 70px; text-align: center;">Acciones</th>

					<th style="font-weight: bold; min-width: 100px; text-align: center;">Imagen</th>

					<th style="font-weight: bold; min-width: 90px; text-align: center;">No.Parte</th>

					<th style="font-weight: bold; min-width: 300px; text-align: center;">Descripcion</th>

					<th style="font-weight: bold; min-width: 90px; text-align: center;">Unidad</th>

					<th style="font-weight: bold; min-width: 90px; text-align: center;">Marca</th>

					<th style="font-weight: bold; min-width: 100px; text-align: center;">Categoria</th>

					<th style="font-weight: bold; min-width: 70px; text-align: right;">Costo</th>

					<th style="font-weight: bold; min-width: 60px; text-align: center;">Iva</th>



				</tr>

			</thead>



		</table>

	</div>







</div>