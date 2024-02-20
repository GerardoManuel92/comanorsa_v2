<div class="row">



	<div class="col-md-5 col-lg-5">



		<label>Buscar por cliente/empresa/total/folio/UUID:</label>

		<div class="input-group">

			<input type="text" name="buscador" id="buscador" oninput="convertirAMayusculas();" class="form-control">

			<span class="input-group-btn">

				<button class="btn btn-warning" type="button" onclick="loadFiltroAll()"><i class="fa fa-search" style="color:black;"></i></button>

			</span>

		</div>



	</div>



	<div class="col-md-3 col-lg-3">



		<label>Buscar por estatus:</label>



		<select id="bestatus" class="form-control" onchange="loadFiltroEntrelazado()">

			<option value="6" selected>Todos...</option>

			<option value="0" style="color:orange;">Sin timbrar</option>

			<option value="1" style="color:darkgreen;">Facturadas</option>

			<option value="2" style="color:red;">Canceladas</option>

		</select>



	</div>

	<div class="col-md-3 col-lg-3">
		<button type="button" class="btn btn-success" onclick="showExcelFiltrado();" style="margin-top: 20px;"><i class="fa fa-file-excel-o" style="color:white; font-weight:bold; font-size: 20px;"></i>&nbsp; Excel</button><br>
	</div>



	<button data-toggle="modal" data-target="#modal_estatus" id="btn_estatus" style="display: none;">ver ventana estatus</button>



</div>



<!--Basic Modal-->

<div id="modal_enviar" class="modal fade" tabindex="-1" role="dialog">

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header" style="background-color: #5682b6; color: white; font-weight: bold;">

				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h4 class="modal-title" style="font-weight: bold;" id="titulo">Enviar factura</h4>

			</div>

			<div class="modal-body">



				<div class="row col-md-12" id="vercotizacion">



					<!--<a href="" style="color:red; font-weight: bold; font-size: 15px;"> <i class="fa fa-eye" style="color:red; font-weight: bold; font-size: 15px;"></i> Ver cotización</a>-->



				</div>



				<div class="row" style="margin-top: 10px;">



					<div class="col-md-12 col-lg-12">



						<label>*Enviar factura a </label>

						<select id="contacto1" name="contacto1" class="form-control"></select>



					</div>



					<div class="col-md-12 col-lg-12" style="margin-top: 15px;">



						<label>Copiar a </label>

						<select id="contacto2" name="contacto2" class="form-control"></select>



					</div>



					<div class="col-md-12 col-lg-12" style="margin-top: 15px;">



						<label>Enviar a correo nuevo</label>

						<input type="text" id="contacto3" name="contacto3" class="form-control">



					</div>





				</div>

			</div>

			<div class="modal-footer">

				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

				<button type="button" class="btn btn-success" onclick="enviarCorreo()">Enviar</button>

			</div>

		</div><!-- /.modal-content -->

	</div><!-- /.modal-dialog -->

</div><!-- /.modal -->

<!--End Basic Modal-->



<!--Basic Modal-->

<div id="modal_cancelar" class="modal fade" tabindex="-1" role="dialog">

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header" style="background-color: #5682b6; color: white; font-weight: bold;">

				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h4 class="modal-title" style="font-weight: bold;" id="titulo">Cancelar factura</h4>

			</div>

			<div class="modal-body">



				<div class="row col-lg-12 col-md-12 col-xs-12">







					<div class="row">



						<div class="col-md-2 col-lg-2" id="dfactura">



							<a href=""><i class="fa fa-document-o"></i> </a>



						</div>

						<div class="col-md-10 col-lg-10">

							<label>*Seleccionar motivo de cancelación</label>

							<select class="form-control" id="ocancelacion" name="ocancelacion" onchange="mostrarFactura(this.value)"></select>

						</div>



					</div>



					<hr>





					<div class="row" id="select_factura" style="display: ">



						<div class="col-md-12">



							<label>Buscar por cliente/empresa/total/folio/UUID:</label>

							<div class="input-group">

								<input type="text" name="buscador_cancelar" id="buscador_cancelar" class="form-control">

								<span class="input-group-btn">

									<button class="btn btn-warning" type="button" onclick="loadFiltroCancelar()"><i class="fa fa-search" style="color:black;"></i></button>

								</span>

							</div>



						</div>



						<br>



						<div class="col-md-12" style="margin-top: 12px;">



							<label>Seleccionar factura</label>

							<div class="input-group">



								<span class="input-group-btn">

									<button class="btn btn-success" type="button" onclick="vetFactura()"><i class="fa fa-eye"></i></button>

								</span>

								<select id="lista_factura" name="lista_factura" class="form-control"></select>





							</div>



						</div>





					</div>





					<hr>



					<div class="col-md-12 col-lg-12">

						<label>Observación</label>

						<textarea class="form-control" rows="3" id="obs" name="obs"></textarea>



					</div>



				</div>



			</div>

			<div class="modal-footer" style="margin-top: 15px;">

				<button type="button" class="btn btn-default" data-dismiss="modal" id="cerrarx">Cerrar</button>

				<button type="button" class="btn btn-danger" onclick="cancelarFact()" id="btn_cancelar"> Cancelar factura</button>

			</div>

		</div><!-- /.modal-content -->

	</div><!-- /.modal-dialog -->

</div><!-- /.modal -->

<!--End Basic Modal-->



<!--Basic Modal-->

<div id="modal_estatus" class="modal fade" tabindex="-1" role="dialog">

	<div class="modal-dialog">

		<div class="modal-content">

			<div class="modal-header" style="background-color: #5682b6; color: white; font-weight: bold;">

				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h4 class="modal-title" style="font-weight: bold;" id="titulo3">Estatus de la Factura</h4>

			</div>

			<div class="modal-body">



				<div class="row">



					<div class="col-md-12 col-lg-12">



						<p id="datos_cfdi"></p>



					</div>



					<div class="col-md-12 col-lg-12">



						<h4 id="est_cfdi" style="font-weight: bold;">Estatus actual:</h4>





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

<!--End Basic Modal-->







<div class="row">



	<div class="table-responsive">



		<table class="table table-striped table-bordered table-hover" id="my-table">

			<style>
				@media (min-width: 768px) {				

					#my-table_info {
						margin-left: 300px;
						width: 40%;
						margin-top: -45px;
					}
				}
			</style>




			<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">



				<tr>



					<th style="font-weight: bold; min-width: 50px; text-align: center;">Acciones</th>

					<th style="font-weight: bold; min-width: 60px; text-align: center;">Estatus</th>

					<th style="font-weight: bold; min-width: 60px; text-align: center;">Fecha</th>

					<th style="font-weight: bold; min-width: 90px; text-align: left;">Vendedor</th>

					<th style="font-weight: bold; min-width: 60px; text-align: center;">Cotizacion</th>

					<th style="font-weight: bold; min-width: 60px; text-align: center;">Folio</th>

					<th style="font-weight: bold; min-width: 150px; text-align: left;">Cliente</th>

					<th style="font-weight: bold; min-width: 130px; text-align: left;">Contacto</th>

					<th style="font-weight: bold; min-width: 60px; text-align: right;">Credito</th>

					<th style="font-weight: bold; min-width: 70px; text-align: right;">Total</th>

					<th style="font-weight: bold; min-width: 50px; text-align: right;">Moneda</th>



				</tr>

			</thead>



		</table>

	</div>







</div>