<div class="row">



	<div class="col-md-9 col-lg-9">



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

				<div class="col-md-3 col-lg-4">
					<button type="button" class="btn btn-success" onclick="showExcel();"><i class="fa fa-file-excel-o" style="color:white; font-weight:bold; font-size: 20px;"></i>&nbsp; Excel</button>
					<!-- <a href="javascript:showExcel();" style="color:green; font-weight:bold;"><i class="fa fa-file-excel-o" style="color:green; font-weight:bold; font-size: 20px;"></i> Excel</a> -->
				</div>




				<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">



					<tr>



						<th style="font-weight: bold; min-width: 50px; text-align: center;">Acciones</th>



						<th style="font-weight: bold; min-width: 70px; text-align: center;">Estatus</th>

						<th style="font-weight: bold; min-width: 120px; text-align: left;">Proveedor</th>

						<th style="font-weight: bold; min-width: 120px; text-align: left;">Comercial</th>

						<th style="font-weight: bold; min-width: 80px; text-align: center;">RFC</th>

						<th style="font-weight: bold; min-width: 100px; text-align: center;">Fpago</th>

						<th style="font-weight: bold; min-width: 100px; text-align: center;">Cfdi</th>

						<th style="font-weight: bold; min-width: 100px; text-align: center;">Dirección</th>

						<th style="font-weight: bold; min-width: 100px; text-align: center;">Dias crédito</th>

						<th style="font-weight: bold; min-width: 100px; text-align: center;">Límite</th>



					</tr>

				</thead>



			</table>

		</div>





	</div>



	<div class="col-md-3 col-lg-3">



		<div class="panel panel-default">

			<div class="panel-heading no-border clearfix">

				<h3 class="panel-title" style="font-weight: bold;">Lista de contactos</h3>



				<!--<ul class="panel-tool-options"> 

								<li class="dropdown">

									<a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"><i class="icon-cog icon-2x"></i></a>

									<ul class="dropdown-menu dropdown-menu-right">

										<li><a href="#"><i class="icon-arrows-ccw"></i> Update data</a></li>

										<li><a href="#"><i class="icon-list"></i> Detailed log</a></li>

										<li><a href="#"><i class="icon-chart-pie"></i> Statistics</a></li>

										<li class="divider"></li>

										<li><a href="#"><i class="icon-cancel"></i> Clear list</a></li>

									</ul>

								 </li>

							</ul>-->

			</div>

			<!-- panel body -->

			<div class="panel-body">



				<p style="color:darkblue;" id="ccliente"></p>

				<p id="cdireccion"></p>

				<p id="climite"></p>

				<p id="cdias"></p>



				<ul class="list-item member-list" id="lista_contacto">

					<!--<li>

									<div class="user-avatar">

										<img title="" alt="" class="img-circle avatar" src="comanorsa/usuario.png">

									</div>

									<div class="user-detail">

										<h5>Rafael Angel</h5>

										<p>Gerente</p>

										<p><a href="tel:5567654150"><i class="fa fa-phone"></i> 55 6756 7843</a></p>

										<p><a href="mailto:thinkweb.com.mx"><i class="fa fa-envelope"></i> prueba@gmail.com</a></p>

									</div>

								</li>

								-->

				</ul>



			</div>

		</div>



	</div>

	<div class="modal fade bd-example-modal-lg" id="modalAccounts" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
<<<<<<< HEAD

		<div class="modal-dialog modal-lg" role="document">

			<div class="modal-content">

				<div class="modal-header" style="background-color: #2f4a94;">

					<h4 class="modal-title" id="titulo_modal"></h4>

					<button type="button" class="close" data-dismiss="modal" aria-label="Close">

						<span aria-hidden="true" style="color:white;">&times;</span>

					</button>

				</div>

				<div class="modal-body">
=======
>>>>>>> b25016bbad051d7d16e8a6ead90fe88805c250a2

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


							<div class="col-md-8 col-lg-8">
								
								<label>Selecciona un banco</label>
								<select class="form-control" id="lista_banco" name="lista_banco" tabindex="23"> </select>

							</div>

							<div class="col-md-3 col-lg-3">
								
								<label>Cuenta bancaria</label>
								

								<div class="input-group">

									<input type="number" name="cuenta" id="cuenta" class="form-control" tabindex="24">

									<span class="input-group-btn">

										<button class="btn btn-success" type="button"  tabindex="25" onclick="altaCuentas()" title="Añadir cuenta"><i class="fa fa-plus"></i></button>

									</span>

								</div>

							</div>
	      			

	      		</div>


	      		<hr>

	      		<div class="row">

	      			<h4 style="margin-right:20px;">&nbsp;&nbsp;&nbsp;&nbsp;Lista de cuentas </h4>


		      		<div class="cards-container box-view"  style="margin-top: 20px;" id="view_banco">



					</div>


				</div>



	      </div>

	      <div class="modal-footer">

	        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarx">Cerrar</button>

	      </div>

	    </div>

	  </div>

	</div>


					<div class="row">


						<div class="col-md-8 col-lg-8">

							<label>Selecciona un banco</label>
							<select class="form-control" id="lista_banco" name="lista_banco" tabindex="23"> </select>

						</div>

						<div class="col-md-3 col-lg-3">

							<label>Cuenta bancaria</label>


							<div class="input-group">

								<input type="number" name="cuenta" id="cuenta" class="form-control" tabindex="24">

								<span class="input-group-btn">

									<button class="btn btn-success" type="button" tabindex="25" onclick="altaCuentas()" title="Añadir cuenta"><i class="fa fa-plus"></i></button>

								</span>

							</div>

						</div>


					</div>


					<hr>

					<div class="row">

						<h4 style="margin-right:20px;">&nbsp;&nbsp;&nbsp;&nbsp;Lista de cuentas </h4>


						<div class="cards-container box-view" style="margin-top: 20px;" id="view_banco">



						</div>


					</div>



				</div>

				<div class="modal-footer">

					<button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarx">Cerrar</button>

				</div>

			</div>

		</div>

	</div>

</div>