<div class="row" >





				<div class="col-md-9 col-lg-9 col-xs-12">



					<div class="row col-md-12">



							<input type="number" name="idoc" id="idoc" disabled hidden value="<?php echo $info->id; ?>">

							

							<strong style="color:darkblue;"> <strong style="font-size:30px;">OC#<?php echo $info->id; ?></strong>  &nbsp;&nbsp;&nbsp;Proveedor:</strong> <?php echo $info->proveedor; ?> | <strong style="color:darkblue;">Solicita:</strong>  <?php echo $info->comprador; ?> | <a href="<?php echo base_url() ?>tw/php/ordencompra/odc<?php echo $info->id; ?>.pdf" target="_blank" style="color: #8D27B0;"><i class="fa fa-file-text" style="color: #8D27B0;"> ODC</i></a>


							<br>

							

							<strong style="color:darkblue;">Realizada:</strong>  <?php echo obtenerFechaEnLetra($info->fecha); ?> | <strong style="color:darkblue;">Entrega:</strong>  <?php echo obtenerFechaEnLetra($info->fentrega); ?>



							<br>



							<strong style="color:darkblue;">Observaciones :</strong>  <?php echo $info->observaciones; ?>



					</div>



				</div>



				<div class="col-md-3 col-lg-3 ">

								

								

								<p style="color: green; display: ; font-size: 17px;" id="tsubtotal"></p>

								<p style="color: red; display: none;" id="tdescuento"></p>

								<p style="color: darkblue; display: none;" id="tiva"></p>

								<h3 style="color:darkgreen; font-weight: bold;" id="tneto"> </h3>



				</div>



				<div class="col-md-12" style="margin-top: 10px;">

					

					<label>Observaciones para la entrada</label>

					<textarea id="obs" class="form-control" name="obs" rows="1" autofocus maxlength="250"></textarea>



				</div>



							

</div>



<div class="row" style="margin-top: 20px; ">



														<div class="table-responsive">



															<table class="table table-striped table-bordered table-hover" id="my-table" >





																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

																	

																	<tr>

																		<th style="font-weight: bold; min-width: 60px; text-align: left;">Accion</th>

																		<th style="font-weight: bold; min-width: 300px; text-align: left;">Descripcion</th>

																		<th style="font-weight: bold; min-width: 80px; text-align: left;">Cotizacion</th>

																		<!--<th style="font-weight: bold; min-width: 80px; text-align: left;">Documento</th>-->

																		<th style="font-weight: bold; min-width: 65px; text-align: center;">Cantidad ODC</th>

																		<th style="font-weight: bold; min-width: 65px; text-align: center;">Entradas Realizadas</th>

																		<th style="font-weight: bold; min-width: 60px; text-align: center;">Entrada</th>

																		<th style="font-weight: bold; min-width: 70px; text-align: right;">Costo</th>

																		<!--<th style="font-weight: bold; min-width: 70px; text-align: right;">Descuento(%)</th>-->

																		<th style="font-weight: bold; min-width: 70px; text-align: right;">Iva(%)</th>

																		<th style="font-weight: bold; min-width: 70px; text-align: right;">Subtotal</th>

																	    

																	</tr>

																</thead>

																					

															</table>

														</div>



</div>


<div id="modal_info" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">

					  <div class="modal-dialog modal-lg">

					    <div class="modal-content">

					      <div class="modal-header" style="background-color: #5682b6; color: white; font-weight: bold;">

					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

					        <h4 class="modal-title" style="font-weight: bold;" id="titulo3">Añadir informacion al producto</h4>

					      </div>

					    <div class="modal-body">

					      	<div class="row">

						      	<div class="col-md-12">

						      		<h4>Producto</h4>

						      		<p style="font-weight: 600; font-size: 17px;" id="titulo_info">F148

										Archivo expandible Oxford carta colores surtidos 1 pza (BLANCO Y AZUL)
									</p>

						      	</div>

						    </div>

						  
						    <div class="row" id="lista_info">

						      	<!--<div class="col-md-6 col-lg-6 col-xs-12" >
						      		

						      		<label>Añadir info</label>
						      		<div class="form-group"> 
										
										
											<div class="input-group"> 
												<span class="input-group-addon">1.-</span>
												<input type="text" class="form-control"> 
												
											</div>
										 
									</div>

						      	</div>


						      	<div class="col-md-6 col-lg-6 col-xs-6" >
						      		

									<label>Añadir info</label>
						      		<div class="form-group"> 
										
										
											<div class="input-group"> 
												<span class="input-group-addon">2.-</span>
												<input type="text" class="form-control"> 
												
											</div>
										
									</div>

						      	</div>

						      	<div class="col-md-6 col-lg-6 col-xs-12" >
						      		

						      		<label>Añadir info</label>
						      		<div class="form-group"> 
										
										
											<div class="input-group"> 
												<span class="input-group-addon">2.-</span>
												<input type="text" class="form-control"> 
												
											</div>
										 
									</div>

						      	</div>-->

						    </div>


					    </div>

					      <div class="modal-footer">

					        <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrarx">Cerrar</button>

					        <button type="button" class="btn btn-danger" onclick="agregarInfo()" id="btn_info">Agregar info</button>

					      </div>

					    </div><!-- /.modal-content -->

					  </div><!-- /.modal-dialog -->

					</div><!-- /.modal -->