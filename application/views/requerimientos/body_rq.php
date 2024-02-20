<div class="row" >
		


				<div class="col-md-10 col-lg-10 col-xs-12">



					


					<div class="row" style="margin-top: 15px;">

					

							<div class="col-md-11 col-lg-11">



								<input type="text" name="bi_pro" id="bi_pro" class="form-control"  placeholder="Buscar por descripcion/clave/tag..." tabindex="1" style="font-size: 12px;" autofocus="true">

								

							</div>



							<div class="col-md-1 col-lg-1">

								

								<button class="btn btn-success" type="button" onclick="window.open('<?php echo base_url() ?>AltaProducto/altaProducto/0','_blank')" tabindex="-1"><i class="fa fa-plus-square"></i></button>



							</div>

					</div>


					<div class="row" style="margin-top:15px;">

							<div class="col-md-2 col-lg-2">

								

								<div class="input-group">

								<input type="number" name="maximo" class="form-control" id="maximo" placeholder="maximo..." style="text-align: right;" tabindex="-1" disabled style="background-color:green;">

								

								</div>



							</div>

							<div class="col-md-2 col-lg-2">

								

								<div class="input-group">

								<input type="number" name="minimo" class="form-control" id="minimo" placeholder="minimo..." style="text-align: right;" tabindex="-1" disabled>

								
								</div>



							</div>


							<div class="col-md-3 col-lg-3">

								

								<div class="input-group">

									<input type="number" name="cantidad" class="form-control" id="cantidad" placeholder="cantidad..." style="text-align: right;" tabindex="2">
									<span class="input-group-btn">

										<button class="btn btn-blue" type="button" class="form-control" onclick="ingresarPartidas()" tabindex="3" id="btn_ingresar"><i class="fa fa-arrow-right"></i></button>

									</span>

								</div>



							</div>



							<div class="col-md-1 col-lg-1">

								

								<!--<input type="text" name="unidad" class="form-control" id="unidad" placeholder="UM..." disabled>--><p id="unidad" style="font-size: 22px; font-weight: bold;">U.M.</p>



							</div>



							



					</div>





					<div class="row" style="margin-top: 0px;">



						<div class="col-md-12 col-lg-12">

							

							<textarea class="form-control" id="descripcion" name="descripcion" rows="2" style="font-size: 13px;" tabindex="6" placeholder="Descripcion..." disabled></textarea>



						</div>			


					</div>

					


				

					<!-- AGREGAR OBSERVACIONES Y UTILIDAD O DESCUENTO GENERAL-->



					<div class="row" id="agobs" style="display: none; margin-top: 10px;">

						

						<div class="row">



							<div class="col-md-12 col-lg-12" >

									

									<textarea id="obs" class="form-control" rows="3" placeholder="Agregar observaciones..." maxlength="300"></textarea>



							</div>



						</div>



					


					</div>





				</div>



				<div class="col-md-2 col-lg-2 " style="text-align: right;">

								

								

								<p style="color: green; display: ; font-size: 17px;" id="tsubtotal"></p>

								<p style="color: red; display: none;" id="tdescuento"></p>

								<!-- <p style="color: darkblue; display: none;" id="tiva"></p> -->

								<h3 style="color:darkgreen; font-weight: bold;" id="tneto"></h3>



				</div>



							

</div>


<div class="row" style="margin-top: 20px; ">



														<div class="table-responsive">



															<table class="table table-striped table-bordered table-hover" id="my-table" >





																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

																	

																	<tr>

																		<th style="font-weight: bold; min-width: 50px; text-align: center;"></th>																	

																		<th style="font-weight: bold; min-width: 100px; text-align: center;">Clave</th>

																		<th style="font-weight: bold; min-width: 350px;">Descripcion</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: center;">UM</th>

																		<th style="font-weight: bold; min-width: 100px; text-align: right;">Cantidad</th>																	

																	</tr>

																</thead>

																					

															</table>

														</div>



						</div>
