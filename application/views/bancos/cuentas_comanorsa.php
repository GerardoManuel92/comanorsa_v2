<div class="row">

			<div class="col-lg-12">

				<div class="panel panel-default" style="border-color: #5682b6; border-width: 1.5px; border-style: solid; background-color: #F8FFFF">

					<div class="panel-heading clearfix" style="background-color: #5682b6; color: white;" >



						<h3 class="panel-title" style="font-weight: bold;"><?php echo $titulox; ?></h3>

						<ul class="panel-tool-options"> 

							<li><a href="javascript:recargar()"><i class="icon-arrows-ccw" title="Recargar" style="color:white;"></i></a></li>

							<li><a data-rel="collapse" href="#"><i class="icon-down-open" title="Cerrar/Abrir" style="color:white;"></i></a></li>

							

						</ul>

					</div>

					<div class="panel-body" style="margin-top: 10px;">



						<div class="row" >



							<div class="col-md-12 col-lg-12 col-xs-12"> 

								<label>*Selecciona una institucion bancaria</label>

								<select class="form-control select2" id="lista_banco" name="lista_banco" tabindex="1"></select>

							</div>

						</div>

						<div class="row" style="margin-top: 15px;">


							<div class="col-md-2 col-lg-2">
								
								<label>*RFC</label>

								<input type="text" name="rfc" id="rfc" class="form-control" placeholder="RFC..." tabindex="2">

							</div>

							<div class="col-md-3 col-lg-3">
								
								<label>*Cuenta</label>

								<input type="number" name="cuenta" id="cuenta" class="form-control" placeholder="Clave..." tabindex="3">

							</div>


							<div class="col-md-2 col-lg-2" style="text-align: right;">
								
								<label>*Saldo inicial</label>

								<input style="text-align: right;" type="number" name="inicial" id="inicial" class="form-control" placeholder=" $0.00" tabindex="4">

							</div>



							<div class="col-md-2 col-lg-2">
								
								<label>*Moneda</label>

								<input type="text" name="moneda" id="moneda" value="PESOS" class="form-control" tabindex="5" disabled>

							</div>

							



							<div class="col-md-2 col-lg-2 col-xs-12" id="btnguardar">

							

								<label>Acción</label>

								<button class="btn btn-blue btn-rounded btn-block" id="btn_finalizar" tabindex="6" onclick="altaCuenta()"><i class="icon-right"></i> Ingresar</button>



							</div>



							<div class="col-md-3 col-lg-3 col-xs-12" id="btnactualizar" style="display: none;">

							

								<label>Acción</label>

								<button class="btn btn-warning btn-rounded btn-block" id="btn_actualizar" tabindex="7" onclick="actCuenta()" style="color:black;"><i class="icon-right"></i> Actualizar</button>

								<button class="btn btn-danger btn-rounded btn-block" tabindex="8" onclick="cerrarAct()"><center><i class="icon-cancel"> Cerrar</i></center></button>



							</div>



						</div>





						<div class="row" style="margin-top: 20px; ">



														<div class="table-responsive">



															<table class="table table-striped table-bordered table-hover" id="my-table" >





																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

																	

																	<tr>



																		<th style="font-weight: bold; min-width: 70px; text-align: center;">Acciones</th>

																		<th style="font-weight: bold; min-width: 70px; text-align: center;">Estatus</th>

																		<th style="font-weight: bold; min-width: 80px; text-align: center;">RFC</th>

																		<th style="font-weight: bold; min-width: 100px; text-align: center;">Cuenta</th>

																		<th style="font-weight: bold; min-width: 150px; text-align: center;">Banco</th>

																		<th style="font-weight: bold; min-width: 90px; text-align: right;">Saldo inicial</th>

																		<th style="font-weight: bold; min-width: 80px; text-align: center;">Moneda</th>

																	    

																	</tr>

																</thead>

																					

															</table>

														</div>



						</div>		

						

					</div>

					



				</div>



				



			</div>



			

			

</div>