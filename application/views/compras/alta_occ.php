		<!-- Modal -->

		<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

<div class="modal-dialog modal-md" role="document">

  <div class="modal-content">

	<div class="modal-header" style="background-color: #2f4a94;">

	  <h5 class="modal-title" id="titulo"><strong style="color:white;">Generar ODC a: Papeleria el mexiquense</strong></h5>

	  <button type="button" class="close" data-dismiss="modal" aria-label="Close">

		<span aria-hidden="true" style="color:white;">&times;</span>

	  </button>

	</div>

	<div class="modal-body">

	  

			<div class="row">



				<div class="col-md-12" style="text-align: right;">

					

					<h3 style="color:darkgreen; font-size: 17px; font-weight: bold;" id="tneto2"></h3>



				</div>



				<div class="row col-md-12">



				   <!--<div class="col-md-3 col-lg-3">



						<label>*Moneda</label>

						<select id="moneda" class="form-control">

							

							<option value="1">Pesos</option>

							<option value="2">Dolares</option>	



						</select>

						

					</div>-->

					

					<div class="col-md-7 col-lg-7">



						<label>*Fecha de entrega</label>

						<input type="date" name="entrega" id="entrega" class="form-control" >

						

					</div>



					<div class="col-md-5 col-lg-5">

						

						<label>Dias de credito</label>

						<input type="number" name="dias" id="dias" class="form-control" value="0" style="text-align: right;">



					</div>



					<div class="col-md-12" style="margin-top: 10px;">

						

						<label>Observaciones:</label>

						<textarea class="form-control" id="obs" rows="3" name="obs" maxlength="250"></textarea>



					</div>



				</div>



				

			</div>



	</div>

	<div class="modal-footer">

	  <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarx">Cerrar</button>

	  <button type="button" class="btn btn-primary" onclick="generarOC()" id="btngenerar">Generar ODC</button>

	</div>

  </div>

</div>

</div>


<div class="row">

	<div class="col-md-6 col-lg-6"> 	
		
		Selecciona un proveedor:
		<div class="input-group"> 



				<span class="input-group-addon"><i class="fa fa-user"></i></span> 

				<select  name="selectProveedor" id="selectProveedor" class="form-control select2-placeholer" placeholder="seleccionar proveedor p/oc..." tabindex="1"  style="font-size: 12px;" autofocus onchange="loadPartidas()"></select>

		</div>


	</div>

	<div class="col-md-5 col-lg-5 " class="pull-right" style="text-align: right;">
															

		<p style="color: green; display: ; font-size: 17px;" id="tsubtotal"></p>

		<p style="color: red; display: none;" id="tdescuento"></p>

		<p style="color: darkblue; display: none;" id="tiva"></p>

		<h3 style="color:darkgreen; font-weight: bold;" id="tneto"> </h3>



	</div>

</div>







	<div class="row" style="margin-top:50px;">



														<div class="table-responsive">



															<table class="table table-striped table-bordered table-hover" id="my-table" >





																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

																	

																	<tr>

																		<th style="font-weight: bold; min-width: 50px; text-align: center;">Acciones</th>

																		<!--<th style="font-weight: bold; min-width: 200px; text-align: center;">Proveedor</th>-->

																	    <th style="font-weight: bold; min-width: 300px; text-align: center;">Producto</th>

																	    <th style="font-weight: bold; min-width: 70px; text-align: center;">Cantidad</th>																	   

																	    <th style="font-weight: bold; min-width: 80px; text-align: right;">Costo</th>	
																		
																		<th style="font-weight: bold; min-width: 70px; text-align: center;">Desc(%)</th>

																	    <th style="font-weight: bold; min-width: 60px; text-align: center;">Iva(%)</th>

																	    <th style="font-weight: bold; min-width: 100px; text-align: right;">Subtotal</th>																	

																	</tr>

																</thead>

																					

															</table>

														</div>



										



	</div>			