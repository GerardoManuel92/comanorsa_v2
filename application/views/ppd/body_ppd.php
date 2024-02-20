<div class="row" >		

		

				<!--<div class="col-md-12 col-lg-12 col-xs-12">

					<label>*Selecciona un cliente </label>
					<select  name="cliente" id="cliente" class="form-control select2-placeholer" placeholder="seleccionar cliente p/ agregar complemento..." tabindex="1" autofocus="true"  style="font-size: 12px;" onchange="showFacturas(this.value)"></select>
 
				</div>	-->		

</div>

<input type="number" name="idcliente" id="idcliente" value="<?php echo $idcliente; ?>" disabled="true" hidden>

<!--<div class="row" id="info_cliente" style="margin-top: 10px; text-align: center;">
						
						<div class="panel-body">
								<center><div class="speed-analyzer">
									<div class="speed-score" style="color:darkblue; font-weight: bold;">
										<strong class="score" style="color:darkblue; font-weight: bold;">$ 0.00</strong>
										<span class="uppercase">Saldo total</span>
									</div>
									<div class="speed-score" style="color:darkgreen; font-weight: bold;">
										<strong class="score" style="color:darkgreen; font-weight: bold;">$ 0.00</strong>
										<span class="uppercase">Saldo pagado</span>
									</div>
									<div class="speed-score" style="color:red; font-weight: bold;">
										<strong class="score" style="color:red; font-weight: bold;">$ 0.00</strong>
										<span class="uppercase">Por pagar</span>
									</div>

								</div></center>
						</div>

</div>-->

<!--Basic Modal-->
<div id="modal1" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: <?php echo BGCOLOR; ?>; color: <?php echo TXTHEAD; ?>; font-weight: bold;">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong>Alta complemento de pago</strong></h4>

      </div>
      <div class="modal-body">
        
      	<div class="row">
      		
      		<div class="col-md-3">
      			
      			<label>*Fecha</label>
      			<input type="date" name="fecha" id="fecha" onblur="validarFecha(this.value)" class="form-control" >

      		</div>

      		<div class="col-md-4">
      			
      			<label>*Forma de pago</label>
      			<select class="form-control" id="fpago" name="fpago"></select>

      		</div>

      		<div class="col-md-3">
      			
      			<label>*Moneda</label>
      			<select id="moneda" name="moneda" class="form-control" onchange="tCambio(this.value)">
      				
      				<option value="1" selected>Pesos</option>
      				<option value="2">Dolares</option>

      			</select>

      		</div>

      		<div class="col-md-2">
      			
      			<label>Tipo cambio</label>
      			<input type="number" id="tcambio" name="tcambio" class="form-control"  style="text-align: right;" disabled>

      		</div>

      		


      	</div>

      	<div class="row" style="margin-top: 20px;">

      		<div class="col-md-3">
      			
      			<label>#Pago</label>
      			<input type="number" name="npago" class="form-control" id="npago" style="text-align: right;" disabled>

      		</div>
      		
      		<div class="col-md-4" style="text-align: right;">
      			
      			<label>Saldo anterior</label>
      			<input type="text" name="saldo" id="saldo" class="form-control"  style="text-align: right;" disabled>

      		</div>

      		<div class="col-md-5" style="text-align: right;">
      			
      			<label>*Importe a comprobar</label>
      			<div class="input-group">	      			
	      			<input type="number" name="pagado" id="pagado" class="form-control"  style="text-align: right;" >
	      			<span class="input-group-btn"><button class="btn btn-success" type="button" onclick="ingresarPago()" ><i class="fa fa-arrow-right"></i></button></span>
	      		</div>

      		</div>

      		<!--<div class="col-md-4" style="text-align: right;">
      			
      			<label>*Saldo posterior</label>
      			<input type="number" name="diferencia" id="diferencia" class="form-control"  style="text-align: right;" disabled>

      		</div>-->

      	</div>

      	<hr>

      	<div class="row" id="cpagos" style="margin-left: 10px;">
      		
      		<!--<div class="col-md-8">
      			
      			<h4><a href="#" style="color:red;"><i class="fa fa-trash" style="color: red:"></i></a>&nbsp; Pago No.3 </h4>
      			<p>Fecha de pago: 28 de febrero 2022</p>
      			<p>Moneda: Pesos | T.Cambio: 20.54 | Forma de pago: </p>
      			<p>Saldo anterior: $4,500.25 | Saldo posterior: $2,500.00</p>

      		</div>

      		<div class="col-md-4">
      			
      			<p style="text-align: right; color:darkgreen; font-weight:bold; font-size:22px;" > Pagado <br>$ 2,000.25</p>

      		</div>-->

      		

      	</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="row" style="margin-top: 20px; ">

														<div class="table-responsive">

															<table class="table table-striped table-bordered table-hover" id="my-table" >


																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">
																	
																	<tr>
																		<th style="font-weight: bold; min-width: 30px; text-align: center;">Accion</th>
																		<th style="font-weight: bold; min-width: 250px; text-align: center;">UUID</th>
																		<th style="font-weight: bold; min-width: 60px; text-align: center;">Folio</th>
																		<th style="font-weight: bold; min-width: 100px; text-align: center;">Fecha</th>
																		<th style="font-weight: bold; min-width: 90px; text-align: right;">Total</th>
																		<th style="font-weight: bold; min-width: 80px; text-align: center;">No. Pagos</th>
																		<th style="font-weight: bold; min-width: 90px; text-align: right;">Pagado</th>
																		<th style="font-weight: bold; min-width: 90px; text-align: right;">x Pagar</th>
																		
																	    
																	</tr>
																</thead>
																					
															</table>
														</div>

						</div>


