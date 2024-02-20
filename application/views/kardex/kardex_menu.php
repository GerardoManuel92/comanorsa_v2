	<div class="row">

		

		<div class="col-md-8 col-lg-8">

			

			<h3>Descripción:</h3>

			<p><?php echo $info->descrip;?></p>



		</div>



		<div class="col-md-3 col-lg-3 pull-right" style="text-align: right;">

			

			<p style="font-size: 20px; color:darkgreen; font-weight: bold;">Total entradas:&nbsp;&nbsp;&nbsp;&nbsp; <?php echo floatval($info->totentrada)." ".$info->abr;?></p>
			<p style="font-size: 20px; color:red; font-weight: bold;">Total salidas:&nbsp;&nbsp;&nbsp;&nbsp; <?php echo floatval($info->totentrega)." ".$info->abr;?></p>
			<p style="font-size: 20px; color:blue; font-weight: bold;">Total asignado:&nbsp;&nbsp;&nbsp;&nbsp; <?php echo floatval($info->totasignado)." ".$info->abr;?></p>
			<p style="font-size: 20px; color:#C6005A; font-weight: bold;">Almacen:&nbsp;&nbsp;&nbsp;&nbsp; <?php echo round($info->totentrada-$info->totentrega-$info->totasignado,2)." ".$info->abr;?></p>





		</div>



	</div>



						<div class="row" style="margin-top: 20px; ">



							



														<div class="table-responsive">



															<table class="table table-striped table-bordered table-hover" id="my-table" >





																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

																	

																	<tr>
																																				

																		<th style="font-weight: bold; min-width: 120px; text-align: left;">Fecha</th>

																		<th style="font-weight: bold; min-width: 150px; text-align: center;">Movimiento</th>

																		<th style="font-weight: bold; min-width: 100px; text-align: center;">Folio</th>

																		<th style="font-weight: bold; min-width: 90px; text-align: center;">Cantidad</th>

																		<th style="font-weight: bold; min-width: 90px; text-align: right;">Unidad</th>

																		<th style="font-weight: bold; min-width: 150px; text-align: right;">Usuario</th>
																		

																	</tr>

																</thead>

																					

															</table>

														</div>



						</div>