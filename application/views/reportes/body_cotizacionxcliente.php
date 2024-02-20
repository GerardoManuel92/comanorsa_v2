	<div class="row">

		<div class="row">

			<div class="col-md-10 col-lg-10">


				<button data-toggle="modal" data-target="#modal_estatus" id="btn_estatus" style="display: none;">ver ventana estatus</button>


				<div class="input-group">



					<span class="input-group-addon"><i class="fa fa-user"></i></span>

					<select name="cliente" id="cliente" class="form-control select2-placeholer" placeholder="seleccionar cliente p/cotizacion..." tabindex="1" style="font-size: 12px;" autofocus onchange="buscarxCliente(this.value)"></select>

				</div>


			</div>
			<div class="col-md-2 col-lg-2">
				<button type="button" class="btn btn-success" id="btnExcel" onclick="showexcel();"><i class="fa fa-file-excel-o" style="color:white; font-weight:bold; font-size: 20px;"></i>&nbsp; Excel</button><br>
			</div>

		</div>


		<div class="row col-lg-12 col-md-12" style="margin-top: 20px; ">



			<div class="table-responsive">



				<table class="table table-striped table-bordered table-hover" id="my-table">


					<style>
						@media (min-width: 768px) {
							#my-table_filter {
								margin-left: 0px;
								width: 20%;
								margin-top: 20px;
							}

							#my-table_paginate {
								margin-left: 500px;
								width: 40%;
								margin-top: -35px;
							}

							#my-table_length {
								margin-left: 0;
								width: 40%;
								margin-top: 20px;
							}

							#my-table_info {
								margin-left: 300px;
								width: 40%;
								margin-top: -45px;
							}
						}
					</style>


					<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">



						<tr>

							<th style="font-weight: bold; min-width: 30px; text-align: center;"></th>

							<th style="font-weight: bold; min-width: 70px; text-align: right;">Cantidad</th>

							<th style="font-weight: bold; min-width: 80px; text-align: center;">Clave</th>

							<th style="font-weight: bold; min-width: 550px;">Descripcion</th>

							<th style="font-weight: bold; min-width: 80px; text-align: center;">Marca</th>


						</tr>

					</thead>



				</table>

			</div>



		</div>


		<!--Basic Modal-->

		<div id="modal_estatus" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">

			<div class="modal-dialog">

				<div class="modal-content">

					<div class="modal-header" style="background-color: #5682b6; color: white; font-weight: bold;">

						<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

						<h4 class="modal-title" style="font-weight: bold;" id="titulo3">Producto por factura</h4>

					</div>

					<div class="modal-body">

						<div class="row">

							<div class="col-md-12 col-lg-12 col-xs-12">

								<p style="color:black;" id="descrip_producto"></p>

							</div>

						</div>

						<hr>

						<div class="row">

							<div class="col-md-12 col-lg-12 col-xs-12" id="lista_ventas">

								<p> <a href="<?php echo base_url(); ?>tw/php/facturas/BDL8071.pdf" target="_blank" style="color:black; font-size: 17px;">BDL8956</a> - 6 Pza | <strong style="font-size:16px;">$ 2,584.35 mxn</strong></p>

								<p> <a href="" target="_blank">BDL8956</a> - 6 Pza</p>

								<p> <a href="" target="_blank">BDL8956</a> - 6 Pza</p>

							</div>

						</div>


					</div>


					<!--Basic Modal-->

					<div id="modal_estatus" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">

					  <div class="modal-dialog">

					    <div class="modal-content">

					      <div class="modal-header" style="background-color: #5682b6; color: white; font-weight: bold;">

					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

					        <h4 class="modal-title" style="font-weight: bold;" id="titulo3">Producto por factura</h4>

					      </div>

					      <div class="modal-body">

					      	<div class="row">

						      	<div class="col-md-12 col-lg-12 col-xs-12">
						      		
						      		<p style="color:black;" id="descrip_producto"></p>

						      	</div>

						    </div>

						    <hr>

						    <div class="row">

						      	<div class="col-md-12 col-lg-12 col-xs-12" id="lista_ventas">
						      		
						      		<p> <a href="<?php echo base_url(); ?>tw/php/facturas/BDL8071.pdf" target="_blank" style="color:black; font-size: 17px;">BDL8956</a> - 6 Pza  |  <strong style="font-size:16px;">$ 2,584.35 mxn</strong></p>

						      		<p> <a href="" target="_blank">BDL8956</a> - 6 Pza</p>

						      		<p> <a href="" target="_blank">BDL8956</a> - 6 Pza</p>

						      	</div>

						    </div>


					      </div>

					      <div class="modal-footer">

					        <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrarx">Cerrar</button>

					        <!--<button type="button" class="btn btn-danger" onclick="cancelarFact()" id="btn_cancelar"> Cancelar factura</button>-->

					      </div>

					    </div><!-- /.modal-content -->

					  </div><!-- /.modal-dialog -->

					</div><!-- /.modal -->

	</div>