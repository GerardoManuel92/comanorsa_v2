

	<!--<button onclick="showEditar()" value="Editar" class="btn btn-success">Habilitar</button>



	<a href="#" id="username" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">Editar texto</a>-->



<div class="row" >



							<div class="form-group col-md-2 col-sm-12 col-lg-2" style="display: none;"> 

								

									<div id="fechar" class="input-group date">



										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>  

										<input id="fecha" type="text" class="form-control" > 

										

									</div>

							</div>



							<!--<div class="col-md-1 col-lg-1">

								

								<p style="font-size: 17px; text-align: right;">Cliente: </p>



							</div>-->



				<div class="col-md-10 col-lg-10 col-xs-12">



					<div class="row">





							<div class="col-md-2 col-lg-2">

								

								<a style="color:darkblue; font-weight:bold; font-size: 17px;" href="<?php echo base_url()?>tw/php/cotizaciones/cot<?php echo $idcot; ?>.pdf" target="_blank"><i class="fa fa-file-text"></i>



									<?php



										  $idcot = $idcot;

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





								</a>



							</div>



							<div class="col-md-6 col-lg-6"> 



								

								<div class="input-group"> 



										<span class="input-group-addon"><i class="fa fa-user"></i></span> 

										<select  name="cliente" id="cliente" class="form-control select2-placeholer" placeholder="seleccionar cliente p/cotizacion..." tabindex="1" autofocus="true" onchange="showNewCliente(this.value)" style="font-size: 12px;"></select>

										<span class="input-group-btn"><button class="btn btn-success" type="button" onclick="window.open('<?php echo base_url() ?>AltaCliente/altaCliente/0','_blank')" tabindex="-1"><i class="fa fa-plus-square"></i></button></span>

								</div>

								



							</div>





							<div class="col-md-2 col-lg-2">

								

								<select class="form-control" id="moneda" name="moneda" tabindex="2" style="font-size: 12px;" onchange="tmoneda(this.value)">

									

									<option value="1">PESOS</option>

									<option value="2">DOLARES</option>



								</select>	



							</div>



							<div class="col-md-2 col-lg-2">



								<div class="input-group">



									<span class="input-group-addon">T.C.</span>

									<input type="number" name="tc" id="tc" class="form-control" value="<?php echo $info->tcambio; ?>" style="text-align: right;" tabindex="3" disabled>



								</div>	



							</div>



					</div>



					<div class="row" style="margin-top: 10px;">



							<div class="col-md-8 col-lg-8">



								<input type="text" name="bi_pro" id="bi_pro" class="form-control"  placeholder="Buscar por descripcion/clave/tag..." tabindex="4" style="font-size: 12px;">

								

							</div>



							<div class="col-md-1 col-lg-1">

								

								<button class="btn btn-success" type="button" onclick="window.open('<?php echo base_url() ?>AltaProducto/altaProducto/0','_blank')" tabindex="-1"><i class="fa fa-plus-square"></i></button>



							</div>



							<div class="col-md-2 col-lg-2">

								

								<input type="number" name="cantidad" class="form-control" id="cantidad" placeholder="cantidad..." style="text-align: right;" tabindex="5" onblur="calcularSubtotal()">



							</div>



							<div class="col-md-1 col-lg-1">

								

								<!--<input type="text" name="unidad" class="form-control" id="unidad" placeholder="UM..." disabled>--><p id="unidad" style="font-size: 22px; font-weight: bold;">U.M.</p>



							</div>



							



					</div>





					<div class="row" style="margin-top: 1px;">



						<div class="col-md-12 col-lg-12">

							

							<textarea class="form-control" id="descripcion" name="descripcion" rows="2" style="font-size: 13px;" tabindex="6" placeholder="Descripcion..."></textarea>



						</div>

						



					</div>







					<div class="row" style="margin-top: 5px;">



							<div class="col-md-2 col-lg-2" >

								

								<input type="text" name="costo" class="form-control" id="costo" placeholder="($)costo..." tabindex="7" style="text-align: right;" onblur="calcularSubtotal()">



							 </div>





							<div class="col-md-2 col-lg-2">



								<div class="input-group"> 



									<span class="input-group-addon" style="color:green; font-weight: bold;">%</span> 

									<input type="number" name="utilidad" class="form-control" id="utilidad" placeholder="utilidad..." tabindex="8" style="text-align: right;" onblur="calcularSubtotal()">



								</div>



							</div>





							<div class="col-md-2 col-lg-2">

								

								<input type="text" name="precio" class="form-control" id="precio" placeholder="($)precio..." style="text-align: right;" tabindex="9" onblur="calcularSubtotalPrecio()">



							</div>



							<div class="col-md-2 col-lg-2">



								<div class="input-group"> 



									<span class="input-group-addon" style="color:red; font-weight: bold;">-%</span>

								

									<input type="number" name="descuento" class="form-control" id="descuento" placeholder="Desc..." tabindex="10" style="text-align: right;">



								</div>



							</div>





							<div class="col-md-2 col-lg-2" style="display: none;">



									<input type="number" name="tasa" class="form-control" id="tasa" placeholder="tasa..." tabindex="-1" style="text-align: right;">





							</div>



							<div class="col-md-2 col-lg-2">

								

								<input type="text" name="total" class="form-control" id="total" placeholder="($)subtotal..." style="text-align: right;" tabindex="-1" disabled>



							</div>



							<div class="col-md-2 col-lg-2" id="btn_alta" style="display: ;" >

								

								<button class="btn btn-blue" type="button" class="form-control" onclick="ingresarPartidas()" tabindex="11" id="btn_ingresar"><i class="fa fa-arrow-right"></i></button>



								<button class="btn btn-warning" type="button" style="color: black;" class="form-control" onclick="showObs()" tabindex="-1" id="abrirobs"><i class="fa fa-eye"></i></button>



								<button class="btn btn-danger" type="button" class="form-control" style="display: none; " onclick="cerrarObs()" tabindex="-1" id="cerrarobs"><i class="fa fa-close"></i></button>



								<!--<button class="btn btn-blue" type="button" class="form-control" onclick="ingresarCot()" tabindex="9"><i class="fa fa-spinner fa-spin"></i></button>-->



							</div>



							<!--<div class="col-md-2 col-lg-2" id="btn_act" style="display: none;" >

								

								<button class="btn btn-blue" type="button" class="form-control" onclick="actualizarPartidas()" tabindex="11" id="btn_ingresar2"><i class="fa fa-arrow-right"></i></button>



								<button class="btn btn-red" type="button" class="form-control" onclick="cancelarIngreso()" tabindex="-1" id="btn_cancelar"><i class="fa fa-close"></i></button>



								<button class="btn btn-blue" type="button" class="form-control" onclick="ingresarCot()" tabindex="9"><i class="fa fa-spinner fa-spin"></i></button>



							</div>-->



							<!--<div class="col-md-2 col-lg-2">

								

								<p id="abrirobs"><a href="javascript:showObs()" style="font-weight: bold; font-size: 14px;"><i class="fa fa-pencil"></i>+observación</a></p>

								<p id="cerrarobs" style="display: none;"><a href="javascript:cerrarObs()" style="color:red;"><i class="fa fa-close"></i> cerrar observación</a></p>



							</div>-->



					</div>



					<!-- AGREGAR OBSERVACIONES Y UTILIDAD O DESCUENTO GENERAL-->



					<div class="row" id="agobs" style="display: none; margin-top: 10px;">

						

						<div class="col-md-12 col-lg-12" >

								

								<textarea id="obs" class="form-control" rows="3" placeholder="Agregar observaciones..." maxlength="300"><?php echo $info->observaciones; ?></textarea>



						</div>



						<div class="row" style="margin-top: 10px;">



							<div class="col-md-2 col-lg-2">

								

									<div class="input-group"> 



										<span class="input-group-addon" style="color:green; font-weight: bold;">%</span>

									

										<input type="number" name="gutilidad" class="form-control" id="gutilidad" placeholder="Uti_general..." style="text-align: right;">



									</div>



							</div>



							<div class="col-md-2 col-lg-2">

								

									<div class="input-group"> 



										<span class="input-group-addon" style="color:red; font-weight: bold;">-%</span>

									

										<input type="number" name="gdescuento" class="form-control" id="gdescuento" placeholder="Desc_general..."  style="text-align: right;">



									</div>



							</div>



							<div class="col-md-3 col-lg-3">

								

								<button class="btn btn-success" onclick="porcientoAll()" id="btntodos"> Aplicar a todos</button>

								<button class="btn btn-success" onclick="porcientoFal()" id="btnvacios"> Solo a faltantes</button>



							</div>



						</div>



					</div>



					<!-- MOSTRAR IMPUESTOS POR RETENCIONES -->



					<div class="row" id="retenciones" style="display:none; margin-top: 10px;">



						<div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">

							

							<label id="tit_iva"></label>

							<input type="number" id="valor_riva" disabled value="0">

							<input type="text" name="riva" id="riva" class="form-control" value="0" disabled="" style="text-align: right;">



						</div>



						<div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">

							

							<label id="tit_isr"></label>

							<input type="number" id="valor_risr" disabled value="0">

							<input type="text" name="risr" id="risr" class="form-control" value="0" disabled="" style="text-align: right;">



						</div>

						



					</div>



				</div>



				<div class="col-md-2 col-lg-2 " style="text-align: right;">

								

								<h4 style="font-weight: bold; margin-bottom: 10px;"><a href="javascript:verDetalles()" style="font-size: 11px;">(ver detalles)</a><a href="javascript:cerrarDetalles()" id="cerrar" style="display: none;"><i class="fa fa-close" style="color:red; font-weight: bold;"></i></a></h4>

								<p style="color: green; display: ; font-size: 17px;" id="tsubtotal"></p>

								<p style="color: red; display: none;" id="tdescuento"></p>

								<p style="color: darkblue; display: none;" id="tiva"></p>

								<h3 style="color:darkgreen; font-weight: bold;" id="tneto"></h3>



				</div>



							

</div>







	<!--Basic Modal-->

	<div id="modal_pedido" class="modal fade" tabindex="-1" role="dialog">

	  <div class="modal-dialog">

	    <div class="modal-content">

	      <div class="modal-header" style="background-color: #5682b6; color: white; font-weight: bold;">

	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

	        <h4 class="modal-title" style="font-weight: bold;" id="titulo">Confirmar pedido</h4>

	      </div>

	      <div class="modal-body">



	      	<div class="row col-md-12" id="vercotizacion">

	      			

 				<!--<a href="" style="color:red; font-weight: bold; font-size: 15px;"> <i class="fa fa-eye" style="color:red; font-weight: bold; font-size: 15px;"></i> Ver cotización</a>-->



	      	</div>



	        <!--<div class="row" style="margin-top: 10px;">

	        	

	        	<div class="col-md-12 col-lg-12">

	        		

	        		<label>*Colocar enlace de la evidencia</label>

	        		<textarea class="form-control" rows="3" name="evidencia" id="evidencia"></textarea>



	        	</div>



	        </div>



	        <hr>-->



	        <div class="row">



      							<div class="col-md-7 col-lg-7"> 

									<!-- ADJUNTAR FIANZA-->



								

									<span class="btn btn-labeled btn-primary fileinput-button">



											<i class="btn-label icon fa fa-paperclip"></i>



											<span>Adjuntar evidencia</span>



											<input id="fileupload_pdf"  accept=".pdf,.jpg,.png,.jpeg" type="file" name="files[]" multiple>



									</span>



									<div id="progress_bar_factpdf" class="progress">



										<div class="progress-bar progress-bar-primary"></div>



									</div>



								</div>



								<div class="col-md-5 col-lg-5">

									

									<div id="files_cfactpdf" class="files" style="margin-bottom: 10px;">*Sin evidencia</div>



									<input type="text" name="name_factpdf" id="name_factpdf" class="form-control" disabled>



								</div>

	      			 



      		</div>





	      </div>

	      <div class="modal-footer">

	        <button type="button" class="btn btn-default" data-dismiss="modal" id="cerrarx">Cerrar</button>

	        <button type="button" class="btn btn-success" id="btnpedido" onclick="actCotizacion(1)">Crear pedido</button>

	      </div>

	    </div><!-- /.modal-content -->

	  </div><!-- /.modal-dialog -->

	</div><!-- /.modal -->






						<div class="row" style="margin-top: 20px; ">



														<div class="table-responsive">



															<table class="table table-striped table-bordered table-hover" id="my-table" >





																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

																	

																	<tr>

																		
																		<th style="font-weight: bold; min-width: 30px; text-align: center;"></th>

																		<th style="font-weight: bold; min-width: 30px; text-align: center;">No.</th>

																		<th style="font-weight: bold; min-width: 40px; text-align: right;">Cant</th>

																		<th style="font-weight: bold; min-width: 70px; text-align: center;">Clave</th>

																		<th style="font-weight: bold; min-width: 400px;">Descripcion</th>

																		<th style="font-weight: bold; min-width: 40px; text-align: center;">UM</th>

																		<th style="font-weight: bold; min-width: 70px; text-align: right;">Precio</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Iva(%)</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Des(%).</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Utl(%).</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Tc.</th>

																		<th style="font-weight: bold; min-width: 80px; text-align: right;">Subtotal</th>


																	</tr>

																</thead>

																					

															</table>

														</div>



						</div>

