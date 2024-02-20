

	<!--<button onclick="showEditar()" value="Editar" class="btn btn-success">Habilitar</button>



	<a href="#" id="username" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">Editar texto</a>-->





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

	      				<input type="date" name="entrega" id="entrega" value="<?php echo date('Y-m-d'); ?>" class="form-control" >

	      				

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


<!-- MODAL PARA EL BALANCE DE COMPRAS -->

<div class="modal fade bd-example-modal-lg" id="modal_balance" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">

      <div class="modal-header" style="background-color: #2f4a94;">

        <h5 class="modal-title" id="titulo"><strong style="color:white;">Asignar a proveedor</strong></h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true" style="color:white;">&times;</span>

        </button>

      </div>

      <div class="modal-body">

      		<div class="row">

      			<div class="col-md-8 col-lg-8">
      				
      				<p style="font-size:17px;" id="ptitulo"></p>

      				<label>Seleccionar proveedor:</label>
      				<select class="form-control" id="asg_proveedor" name="asg_proveedor"></select>

      					
      				<div class="col-md-6 col-lg-6">
      					
      					<label style="text-align:right; margin-top: 12px;">Costo</label>
	      				<input type="number" name="costo" id="costo" class="form-control" style="text-align:right;" min="0">

      				</div>

      				<div class="col-md-6 col-lg-6">
      					
      					<button class="btn btn-primary" id="btn_historial" name="btn_historial" onclick="showHistorial();" style="margin-top: 35px;"><i class="fa fa-file-text-o" ></i> Historial</button>

      					<button class="btn btn-success" id="btn_asig" name="btn_asig" style="color:white; margin-top: 35px;" onclick="AsignarProveedor();"> <i class="fa fa-user-plus" style="color:white; "></i> Asignar</button>

      				</div>

	      			<input type="number" name="cant_solicitado" id="cant_solicitado" disabled style="display: none;">

	      			<input type="number" name="cant_inventario" id="cant_inventario" disabled style="display: none;">

      			</div>

      			<div class="col-md-4 col-lg-4" id="balance">
      				
      				<!--<p style="color:darkblue; font-size:14px;">Pedido: 10 Pz</p>
      				<p style="color:darkred; font-size:14px; margin-top: -10px;">Almacen: 0 Pz</p>
      				<p style="color:darkgreen; font-size:16px; margin-top: -10px;">Requerido: 10 Pz</p>-->

      			</div>

      		</div>

      		<hr>

      		<div id="productos_odc">
      			



      		</div>

      		<!--<div class="row">

      			<div class="col-md-7 col-lg-7">
      			
	      			<div class="col-md-2">
	      				
	      				<a href="https://erp.comanorsa.com.mx/tw/php/cotizaciones/cot1988.pdf" target="_blank">ODV0011988</a>

	      			</div>

	      			<div class="col-md-2">
	      				
	      				<input type="number" name="dato1988" id="dato1988" value="5" class="form-control" style="text-align: right;">

	      			</div>

	      			<div class="col-md-2">
	      				
	      				<p>Pieza</p>

	      			</div>

	      		</div>

      			<div class="col-md-5 col-lg-5">

							<img src="" class="img img-responsive" >

      			</div>


      		</div>--->

      		<!--<div class="row">
      			
      			<div class="col-md-2">
      				
      				<a href="https://erp.comanorsa.com.mx/tw/php/cotizaciones/cot1915.pdf" target="_blank">ODV0011915</a>

      			</div>

      			<div class="col-md-2">
      				
      				<input type="number" name="dato1915" id="dato1915" value="3" class="form-control" style="text-align: right;">

      			</div>

      			<div class="col-md-2">
      				
      				<p>Pieza</p>

      			</div>


      		</div>

      		<div class="row">
      			
      			<div class="col-md-2">
      				
      				<a href="https://erp.comanorsa.com.mx/tw/php/cotizaciones/cot2009.pdf" target="_blank">ODV0012009</a>

      			</div>

      			<div class="col-md-2">
      				
      				<input type="number" name="dato2009" id="dato2009" value="2" class="form-control" style="text-align: right;">

      			</div>

      			<div class="col-md-2">
      				
      				<p>Pieza</p>

      			</div>


      		</div>-->




      		

      		<!--<div class="row" style="margin-top:15px;">

	      		<div class="col-md-2 col-lg-2">
	      			
	      			<button class="btn btn-warning" id="btn_asig" name="btn_asig" style="color:#1C1614;" onclick="AsignarProveedor();"><i class="fa fa-user-plus" style="color:#1C1614;"></i> Asignar</button>

	      		</div>

	      	</div>-->

      </div>

      <div class="modal-footer">

        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrarx2">Cerrar</button>

        <!--<button type="button" class="btn btn-primary" onclick="generarOC()" id="btngenerar">Generar ODC</button>-->

      </div>

    </div>

  </div>

</div>



<!--<div class="row">

			<div class="col-lg-12">

				<div class="panel panel-default" style="border-color: <?php //echo BGCOLOR ?>; border-width: 1.5px; border-style: solid; background-color: <?php //echo BGCOLORDEGRADE; ?>" >

					<div class="panel-heading clearfix" style="background-color: <?php //echo BGCOLOR; ?>; color: <?php //echo TXTHEAD; ?>;" >



						<h3 class="panel-title" style="font-weight: bold;">Alta cotización</h3>

						<ul class="panel-tool-options"> 



							<li><button class="btn btn-warning btn-rounded btn-block" id="btn_finalizar" onclick="finalizarCotizacion()" style="color:black;"><i class="icon-check" ></i style="color:black;"> Finalizar</button></li>

							<li><button class="btn btn-red btn-rounded btn-block" id="btn_cancelar" onclick="cancelarCotizacion()"><i class="icon-cancel"></i> cancelar</button></li>

							<li><a href="javascript:recargar()"><i class="icon-arrows-ccw" title="Recargar" style="color:<?php //echo TXTHEAD; ?>;"></i></a></li>

							<li><a data-rel="collapse" href="#"><i class="icon-down-open" title="Cerrar/Abrir" style="color:<?php //echo TXTHEAD; ?>;"></i></a></li>

							

						</ul>

					</div>

					<div class="panel-body" style="margin-top: 10px;">



						

						

					</div>

					



				</div>



				



			</div>



			

						

</div>-->



					<div class="row">

						

						<div class="col-md-3 col-lg-3"> 



								<label>Filtrar por documento sin asignar</label>

								<select  name="documento" id="documento" class="form-control" tabindex="1" autofocus="true"  style="font-size: 12px;"></select>

								



							</div>



						<div class="col-md-5 col-lg-5">

															
							<label>Seleccione un proveedor para asignar</label>
							<select  name="proveedor_asig" id="proveedor_asig" class="form-control select2-placeholer" tabindex="3" style="font-size: 12px; border-style: solid; border-color:#4DD358;"></select>




						</div>

						<div class="col-md-3 col-lg-3" style="margin-top:27px;">

															

							<button class="btn btn-success" id="btn_asignar" onclick="asignarPartidas()">Asignar proveedor</button>



						</div>



					</div>



						<div class="row" style="margin-top: 20px; ">



														<div class="table-responsive">



															<table class="table table-striped table-bordered table-hover" id="my-table" >





																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

																	

																	<tr>

																		<th style="font-weight: bold; min-width: 40px; text-align: center;"></th>

																		<!-- <th style="font-weight: bold; min-width: 40px; text-align: center;"></th> -->

																		<th style="font-weight: bold; min-width: 60px; text-align: center;">Documento</th>

																		<th style="font-weight: bold; min-width: 60px;">Clave</th>

																		<th style="font-weight: bold; min-width: 150px;">Descripcion</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: center;">Asignado</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: center;">Asignar</th>																		

																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Costo Proveedor</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Venta</th>

																		<th style="font-weight: bold; min-width: 40px; text-align: right;">Des(%)</th>

																		<th style="font-weight: bold; min-width: 40px; text-align: right;">IVA(%)</th>

																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Subtotal</th>

																		

																	    

																	</tr>

																</thead>

																					

															</table>

														</div>



						</div>

