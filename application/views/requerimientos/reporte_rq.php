	<div class="row">

		

		<!-- <div class="col-md-5 col-lg-5">

			

			



		</div> -->



		<div class="col-md-3 col-lg-3">

			

			<label>Buscar por estatus:</label>

			

				<select id="bestatus" class="form-control" onchange="loadFiltroEst()">

					<option value="6">Todos...</option>
					<option value="0" style="color:green; font-weight: bold;" selected>Activas</option>
					<option value="1" style="color:red; font-weight: bold;">Canceladas</option>

				</select>



		</div>



	</div>



	<div class="row" style="margin-top:10px;">

		<div class="col-md-8 col-lg-8">

			<div class="table-responsive">

				<table class="table table-striped table-bordered table-hover" id="my-table" >

					<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">															

						<tr>
							<th style="font-weight: bold; min-width: 50px; text-align: center;">Acciones</th>
							<th style="font-weight: bold; min-width: 80px; text-align: center;">Estatus</th>
							<th style="font-weight: bold; min-width: 80px; text-align: center;">Fecha</th>
							<th style="font-weight: bold; min-width: 300px; text-align: center;">Solicito</th>
							<th style="font-weight: bold; min-width: 100px; text-align: center;">Documento</th>																	    																	
						</tr>

					</thead>																					

				</table>

			</div>

		</div>


	<div class="col-md-4 col-lg-4">	

		<div class="panel panel-default">

			   <div class="panel-heading no-border clearfix"> 

				   <h3 class="panel-title" style="font-weight: bold;">Desglose de Requerimiento</h3>



				   <!--<ul class="panel-tool-options"> 

					   <li class="dropdown">

						   <a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false"><i class="icon-cog icon-2x"></i></a>

						   <ul class="dropdown-menu dropdown-menu-right">

							   <li><a href="#"><i class="icon-arrows-ccw"></i> Update data</a></li>

							   <li><a href="#"><i class="icon-list"></i> Detailed log</a></li>

							   <li><a href="#"><i class="icon-chart-pie"></i> Statistics</a></li>

							   <li class="divider"></li>

							   <li><a href="#"><i class="icon-cancel"></i> Clear list</a></li>

						   </ul>

						</li>

				   </ul>--> 

			   </div> 

			   <!-- panel body --> 

			   <div class="panel-body">



				   <h4><p style="color:darkblue;" id="documento"></p></h4>
				   <h4><p id="solicito"></p></h4>
				   <h4><p id="fecha"></p></h4>

				   <ul class="list-item member-list" id="lista_contacto">

					   <!--<li>

						   <div class="user-avatar">

							   <img title="" alt="" class="img-circle avatar" src="comanorsa/usuario.png">

						   </div>

						   <div class="user-detail">

							   <h5>Rafael Angel</h5>

							   <p>Gerente</p>

							   <p><a href="tel:5567654150"><i class="fa fa-phone"></i> 55 6756 7843</a></p>

							   <p><a href="mailto:thinkweb.com.mx"><i class="fa fa-envelope"></i> prueba@gmail.com</a></p>

						   </div>

					   </li>

					   -->

				   </ul>

				   

			   </div>

		   </div>



	</div>

	</div>			

	