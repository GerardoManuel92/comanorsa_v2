<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default" style="border-color: #5682b6; border-width: 1.5px; border-style: solid; background-color: #F8FFFF">
					<div class="panel-heading clearfix" style="background-color: #5682b6; color: white;" >

						<h3 class="panel-title" style="font-weight: bold;">Alta categoria</h3>
						<ul class="panel-tool-options"> 
							<li><a href="javascript:recargar()"><i class="icon-arrows-ccw" title="Recargar" style="color:white;"></i></a></li>
							<li><a data-rel="collapse" href="#"><i class="icon-down-open" title="Cerrar/Abrir" style="color:white;"></i></a></li>
							
						</ul>
					</div>
					<div class="panel-body" style="margin-top: 10px;">

						<div class="row" >

							<div class="col-md-9 col-lg-9 col-xs-12"> 

								<label>*Categoria</label>
								<input type="text" name="categoria" id="categoria" class="form-control" autofocus placeholder="categoria nueva..." tabindex="1">

							</div>

							<div class="col-md-3 col-lg-3 col-xs-12" id="btnguardar">
							
								<label>Acción</label>
								<button class="btn btn-blue btn-rounded btn-block" id="btn_finalizar" tabindex="2" onclick="altaNewCategoria()"><i class="icon-right"></i> Ingresar categoria</button>

							</div>

							<div class="col-md-2 col-lg-2 col-xs-12" id="btnactualizar" style="display: none;">
							
								<label>Acción</label>
								<button class="btn btn-warning btn-rounded btn-block" id="btn_actualizar" tabindex="2" onclick="Actcat()" style="color:black;"><i class="icon-right"></i> Act. categoria</button>
								<button class="btn btn-danger btn-rounded btn-block" tabindex="3" onclick="cerrarAct()"><center><i class="icon-cancel"> Cerrar</i></center></button>

							</div>

						</div>


						<div class="row" style="margin-top: 20px; ">

														<div class="table-responsive">

															<table class="table table-striped table-bordered table-hover" id="my-table" >


																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">
																	
																	<tr>

																		<th style="font-weight: bold; min-width: 90px; text-align: center;">Acciones</th>
																		<th style="font-weight: bold; min-width: 400px; text-align: center;">Categoria</th>
																	    
																	</tr>
																</thead>
																					
															</table>
														</div>

						</div>		
						
					</div>
					

				</div>

				

			</div>

			
			
</div>