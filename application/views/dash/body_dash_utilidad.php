<style type="text/css">

	.lista_scrholl {
		height: 400px;
		overflow-y: scroll;
	}

</style>

<div class="row">

	<div class="col-md-3 col-lg-3"> 
		

		Fecha de Inicio:
		<div id="datepickerStart" 
			class="input-group date" 
			data-date-format="mm-dd-yyyy"> 
			<input id="valueStart" class="form-control" type="text" readonly /> 
			<span class="input-group-addon"> 
				<i class="glyphicon glyphicon-calendar"></i> 
			</span> 
		</div>

	</div>

	<div class="col-md-4 col-lg-4">

		Fecha final:
		<div class="input-group"> 
			<div id="datepickerEnd" class="input-group date" data-date-format="mm-dd-yyyy"> 
				<input id="valueEnd" class="form-control" type="text" readonly /> <span class="input-group-addon"> 
					<i class="glyphicon glyphicon-calendar"></i> 
				</span>
			</div>
					<span class="input-group-btn"><button class="btn btn-success" type="button" onclick="filtrarFecha();" tabindex="-1" style="margin-left:5px;"><i class="fa fa-search"></i></button></span>
					<span class="input-group-btn"><button class="btn btn-warning" type="button" onclick="location.reload();" tabindex="-1" style="margin-left:5px;"><i class="fa fa-refresh" ></i></button></span>
				
			

		</div>


	</div>
	
	
</div>


<div class="row" style="margin-top: 20px; ">


				<div class="col-md-6 col-lg-6"> 
					
					<div class="panel panel-danger">
						<div class="panel-heading clearfix" style="background-color: #E10707; color:white; font-weight: bold;"> 
							<div class="panel-title">Productos con mayor utilidad generada</div> 
							<ul class="panel-tool-options"> 
								
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>

							</ul> 
						</div> 
						<!-- panel body --> 
						<div class="panel-body">
							


							<div class="row" style="margin-top: 20px; ">



														<div class="table-responsive">



															<table class="table table-striped table-bordered table-hover" id="my-table" >





																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

																	

																	<tr>

																		<th style="font-weight: bold; min-width: 80px; text-align: left;">CLAVE</th>
																		
																		<th style="font-weight: bold; min-width: 300px; text-align: center;">PRODUCTO</th>

																		<th style="font-weight: bold; min-width: 80px; text-align: right;">UTILIDAD</th>

																		<th style="font-weight: bold; min-width: 30px; text-align: right;">VER</th>

																	</tr>

																</thead>

																					

															</table>

														</div>	
														
														

							</div> 														
						

						</div> 
						
					</div> 
					
				</div>

				<div class="col-md-6 col-lg-6"> 
					<div class="panel panel-success">
						<div class="panel-heading clearfix" style="background-color: #85C1E9; color:white; font-weight: bold;"> 
							<div class="panel-title">Clientes con mayor utilidad generada</div> 
							<ul class="panel-tool-options"> 
								
								<li><a data-rel="collapse" href="#"><i class="icon-down-open"></i></a></li>
								<li><a data-rel="reload" href="#"><i class="icon-arrows-ccw"></i></a></li>

							</ul> 
						</div> 
						<!-- panel body --> 
						<div class="panel-body">
							


							<div class="row" style="margin-top: 20px; ">



														<div class="table-responsive">



															<table class="table table-striped table-bordered table-hover" id="my-table2" >





																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

																	

																	<tr>

																		<th style="font-weight: bold; min-width: 80px; text-align: left;">COMERCIAL</th>
																		
																		<th style="font-weight: bold; min-width: 300px; text-align: center;">CLIENTE</th>

																		<th style="font-weight: bold; min-width: 80px; text-align: right;">UTILIDAD</th>

																		<th style="font-weight: bold; min-width: 30px; text-align: right;">VER</th>

																	</tr>

																</thead>

																					

															</table>

														</div>	
														
														

							</div> 														
						

						</div> 
						
					</div> 
					
				</div>
				<button data-toggle="modal" data-target="#modal_estatus" id="btn_estatus" style="display: none;">ver ventana estatus</button>					
						
					<!--Basic Modal-->

					<div id="modal_estatus" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">

					  <div class="modal-dialog modal-lg">

					    <div class="modal-content">

					      <div class="modal-header" style="background-color: #5682b6; color: white; font-weight: bold;">

					        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

					        <h4 class="modal-title" style="font-weight: bold;" id="titulo3">Facturas de clientes</h4>

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
