<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default" style="border-color: <?php echo BGCOLOR ?>; border-width: 1.5px; border-style: solid; background-color: <?php echo BGCOLORDEGRADE; ?>" >
					<div class="panel-heading clearfix" style="background-color: <?php echo BGCOLOR; ?>; color: white;" >

						<h3 class="panel-title" style="font-weight: bold;"><?php echo $titulox; ?></h3>
						<ul class="panel-tool-options"> 
							<li><a href="javascript:recargar()"><i class="icon-arrows-ccw" title="Recargar" style="color:white;"></i></a></li>
							<li><a data-rel="collapse" href="#"><i class="icon-down-open" title="Cerrar/Abrir" style="color:white;"></i></a></li>
							
						</ul>
					</div>
					<div class="panel-body" style="margin-top: 10px;">

						<div class="row" >

							<div class="col-md-4 col-lg-4 col-xs-12"> 

								<label>*Categoria</label>
								<select  name="categoria" id="categoria" class="form-control select2-placeholer" autofocus placeholder="categoria nueva..." tabindex="1" autofocus></select>

							</div>

							<div class="col-md-5 col-lg-5 col-xs-12"> 

								<label>*Subcategoria</label>
								<input type="text" name="subcategoria" id="subcategoria" class="form-control" autofocus placeholder="subcategoria nueva..." tabindex="2">

							</div>

							<div class="col-md-3 col-lg-3 col-xs-12">
							
								<label>Acción</label>
								<button class="btn btn-blue btn-rounded btn-block" id="btn_finalizar" tabindex="3" onclick="altaNewSubcategoria()"><i class="icon-right"></i> Ingresar subcategoria</button>

							</div>

						</div>


						<div class="row" style="margin-top: 20px; ">

														<div class="table-responsive">

															<table class="table table-striped table-bordered table-hover" id="my-table" >


																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">
																	
																	<tr>

																		<th style="font-weight: bold; min-width: 90px; text-align: center;">Acciones</th>
																		<th style="font-weight: bold; min-width: 200px; text-align: center;">Subcategoria</th>
																		<th style="font-weight: bold; min-width: 200px; text-align: center;">Categoria</th>
																	    
																	</tr>
																</thead>
																					
															</table>
														</div>

						</div>		
						
					</div>
					

				</div>

				

			</div>

			
			
</div>