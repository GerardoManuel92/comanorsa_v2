<div id="lblPagoReconocido" class="oculto">
	<p>Pago reconocido</p>
</div>
<div id="lblPagoCancelado" class="oculto">
	<p>Pago cancelado</p>
</div>
	<div class="row">

		

		<div class="col-md-5 col-lg-5">

			

			<label>Buscar por descripción/total:</label>

			<div class="input-group">

				<input type="text" name="buscador" id="buscador" class="form-control">

				<span class="input-group-btn">

					<button class="btn btn-warning" type="button"  onclick="showInfo()"><i class="fa fa-search" style="color:black;"></i></button>

				</span>

			</div>



		</div>



		<div class="col-md-3 col-lg-3">

			

			<label>Buscar por estatus:</label>

			

				<select id="bestatus" class="form-control" onchange="showInfo()">

					<option value="6" selected>Todos...</option> 

					<option value="0" style="color:red;">Activo</option>

					<option value="1" style="color:green;">Aplicado</option>

					<!-- <option value="3" style="color:#B69A00;">Cancelado</option> -->

				</select>



		</div>



	</div>


<!--Basic Modal-->



	<!--Basic Modal-->

	<div id="modalDescripcion" class="modal fade" tabindex="-1" role="dialog">

	  <div class="modal-dialog">

	    <div class="modal-content">

	      <div class="modal-header" style="background-color: #5682b6; color: white; font-weight: bold;">

	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

	        <h4 class="modal-title" style="font-weight: bold;" id="titulo">Realizar pago</h4>

	      </div>


			<div class="modal-body">
				<div class="row col-md-12" id="verDescripcion" style="margin: 0 0 10px 0;">
					
				</div>
				
				<hr style="border: none; border-top: 1px solid #ccc; width: 100%; margin: 40px 0 0 0;">

			</div>


	      <div class="modal-footer">

	        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

	      </div>

	    </div><!-- /.modal-content -->

	  </div><!-- /.modal-dialog -->

	</div><!-- /.modal -->

	<!--End Basic Modal-->




	<div class="row">



														<div class="table-responsive">



															<table class="table table-striped table-bordered table-hover" id="my-table" >





																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

																	

																	<tr>

																		<th style="font-weight: bold; min-width: 50px; text-align: center;">Acciones</th>

																		<th style="font-weight: bold; min-width: 80px; text-align: center;">Estatus</th>

																	    <th style="font-weight: bold; min-width: 100px; text-align: center;">FECHA</th>

																	    <th style="font-weight: bold; min-width: 700px; text-align: left;">DESCRIPCIÓN</th>

																	    <th style="font-weight: bold; min-width: 100px; text-align: right;">IMPORTE</th>
																	

																	</tr>

																</thead>

																					

															</table>

														</div>



										



	</div>			