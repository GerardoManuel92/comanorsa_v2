			<div class="row" >





				<div class="col-md-9 col-lg-9 col-xs-12">



					<!--<div class="row">



						<div class="col-md-2"> 

									

							<label>*Documento</label>

							<select class="form-control" id="tipo" name="tipo" >

								

								<option value="2" >Factura</option>

								<option value="1" >Remisión</option>



							</select> 



						</div>

						

						<div class="col-md-2"> 



							<label>*Folio</label>

									<div class="input-group"> 

										<input type="text" class="form-control" id="folio"  autofocus style="text-align: right;"> 

										<span class="input-group-btn"><button class="btn btn-warning" type="button" onclick="showDocumento()"><i class="fa fa-search" style="color:black;"></i></button></span>

									</div>

						</div>



					</div> -->





					<div class="row">

							

							<strong style="color:darkblue;"> <a href="<?php echo base_url() ?>tw/php/cotizaciones/cot<?php echo $info->idcotizacion; ?>.pdf" target="_blank" style="color: #8D27B0;" id="idcotx"><i class="fa fa-file-text" style="color:darkblue; font-size:25px; "></i></a> <strong style="font-size:25px;" id="documento">



							<?php 



							  $idcot = $info->idcotizacion;

                              $folio = 0;

                              $inicio = 10000;

                              $nuevo = $inicio+$idcot;



                              switch ( strlen($nuevo) ) {



                                  case 5:

                                      

                                      $folio = "ODV00".$nuevo;



                                  break;



                                  case 6:

                                      

                                      $folio = "ODV0".$nuevo;



                                  break;



                                  case 7:

                                      

                                      $folio = "ODV".$nuevo;



                                  break;



                                  default:



                                      $folio = "s/asignar";



                                  break;



                              }



                              echo $folio;



							?>

								



							</strong> 



							</strong>



								<strong id="clientex">Cliente: <?php echo $info->cliente." - ".$info->comercial ?> | 



									<?php



										if ( $info->odcx != "" ) {

											

											echo '<a style="color:darkblue; font-weight: bold;" href="'.base_url().'tw/js/upload_odc/files/'.$info->odcx.'" target="_blank">ODC del cliente:&nbsp; <i class="fa fa-file-text" style="color: blue;"> ODC</i> </a>';



										}



									?>



									

								</strong>

								

							</strong>



					</div>



					<div class="row">

							

							<strong style="color:darkblue;" id="fecha">Fecha: <?php echo obtenerFechaEnLetra($info->fecha) ?></strong> | <strong id="vendedor">Vendedor: <?php echo $info->vendedor?></strong>



					</div>





					<div class="row" style="margin-top: 10px;">

						

						<!-- <div class="col-md-4">

							

							<label>ODC Asignadas</label>

							<div class="input-group"> 

								<span class="input-group-btn">

								<button class="btn btn-primary" type="button" onclick="verOc()"><i class="fa fa-eye"></i></button>

								</span>

								<select id="lista_odc" class="form-control"></select>

									

							</div>



						</div> -->



						<div class="col-md-4">

							

							<label>Facturas</label>

							<div class="input-group"> 

								<span class="input-group-btn">

								<button class="btn btn-success" type="button" onclick="vetFactura()"><i class="fa fa-eye"></i></button>

								</span>

								<select id="lista_factura" class="form-control" onchange="showEntregas()"></select>

								<span class="input-group-btn">

								<button class="btn" type="button" onclick="verOdcCliente()" style="background-color: darkblue;"><i class="fa fa-file-text" style="color:white;"></i></button>

								</span>

									

							</div>



						</div>



						<div class="col-md-4">

							

							<label>Entregas</label>

							<div class="input-group"> 

								<span class="input-group-btn">

								<button class="btn btn-default" type="button" onclick="verEntrega()"><i class="fa fa-eye"></i></button>

								</span>

								<select id="lista_entrega" class="form-control"></select>

									

							</div>



						</div>



					</div>





					<div class="row" style="margin-top: 10px;">



						<strong style="color:darkblue;" id="observaciones">Observaciones: <?php echo $info->observaciones ?></strong>  



					</div>



				</div>



				<div class="col-md-3 col-lg-3 ">

								

								

								<p style="color: green; display: ; font-size: 17px;" id="tsubtotal"></p>

								<p style="color: red; display: none;" id="tdescuento"></p>

								<p style="color: darkblue; display: none;" id="tiva"></p>

								<h3 style="color:darkgreen; font-weight: bold;" id="tneto"> </h3>



				</div>



				



							

			</div>

						



						<div class="row" style="margin-top: 20px; ">



							



														<div class="table-responsive">



															<table class="table table-striped table-bordered table-hover" id="my-table" >





																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

																	

																	<tr>

																		

																		<th style="font-weight: bold; min-width: 50px; text-align: left;">#</th>

																		<th style="font-weight: bold; min-width: 300px; text-align: left;">Descripcion</th>

																		<th style="font-weight: bold; min-width: 60px; text-align: center;">Pedido</th>

																		<th style="font-weight: bold; min-width: 60px; text-align: center;">Unidad</th>

																		<th style="font-weight: bold; min-width: 60px; text-align: center;">Facturado</th>

																		<th style="font-weight: bold; min-width: 60px; text-align: center;">Almacen</th>

																		<th style="font-weight: bold; min-width: 60px; text-align: right;">Entrada</th>

																		<th style="font-weight: bold; min-width: 60px; text-align: right;">Entregado</th>

																		<th style="font-weight: bold; min-width: 60px; text-align: right;">xEntregar </th>

																		<th style="font-weight: bold; min-width: 60px; text-align: right;">Estatus</th>

																		

																	</tr>

																</thead>

																					

															</table>

														</div>



						</div>