<div class="row" >
				
				<input type="number" name="idfactura" id="idfactura" value="<?php echo $rowsql1->id; ?>" class="form-control" style="display: none;" disabled>
				<input type="number" name="idcotizacion" id="idcotizacion" value="<?php echo $rowsql1->idcotizacion; ?>" class="form-control" style="display: none;" disabled>


				<div class="col-md-9 col-lg-9 col-xs-12">

					<div class="row" style="margin-left: 5px;">
						
						<h4 style="color:black;"><strong>Cliente:</strong> <?php echo $rowsql1->cliente; ?> | <a style="color:#5384bc; font-weight: bold;" href="<?php echo base_url()?>tw/php/facturas/fact<?php echo $rowsql1->id; ?>.pdf" target="_blank"><i class="fa fa-file-text"></i> <?php echo $rowsql1->folio; ?></a></h4>
						<p><strong>Empresa: </strong> <?php echo $rowsql1->comercial; ?></p>
						<p><strong style="color:#5384bc; font-size: 17px;">Total: <?php echo wims_currency($rowsql1->total); ?> </strong>  <strong>Moneda: </strong><?php   if ( $rowsql1->moneda == 1 ){ echo 'PESOS'; }else{ echo 'DOLARES&nbsp;|&nbsp;Tipo de cambio:&nbsp;'.$rowsql1->tcambio; } ?></p>

					</div>

				</div>

				<div class="col-md-3 col-lg-3 " style="text-align: right;">
								
								<h4 style="font-weight: bold; margin-bottom: 10px;"><a href="javascript:verDetalles()" style="font-size: 11px;">(ver detalles)</a><a href="javascript:cerrarDetalles()" id="cerrar" style="display: none;"><i class="fa fa-close" style="color:red; font-weight: bold;"></i></a></h4>
								<p style="color: green; display: ; font-size: 17px;" id="tsubtotal"></p>
								<p style="color: red; display: none;" id="tdescuento"></p>
								<p style="color: darkblue; display: none;" id="tiva"></p>
								<h3 style="color:darkgreen; font-weight: bold;" id="tneto">Total nota: $0.00</h3>

				</div>

							
</div>

<!--Basic Modal-->
<div id="modalnota" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header" style="background-color: <?php echo BGCOLOR; ?>; color: <?php echo TXTHEAD; ?>; font-weight: bold;">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong>Alta nota de credito</strong></h4>

      </div>
      <div class="modal-body">
        
      	<div class="row">
      		
      		<div class="col-md-12">
      			
      			<label>*Forma de pago</label>
      			<select id="fpago" class="form-control" ></select>

      		</div>

      		<div class="col-md-12" style="margin-top: 10px;">
      			
      			<label>Observaciones</label>
      			<textarea id="obs" name="obs" class="form-control" rows="3"></textarea>

      		</div>

      	</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="generarNota()" id="btnfactura"><i class="fa fa-check"> Timbrar nota</i></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="row" style="margin-top: 20px; ">

														<div class="table-responsive">

															<table class="table table-striped table-bordered table-hover" id="my-table" >


																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">
																	
																	<tr>
																		<th style="font-weight: bold; min-width: 40px; text-align: right;">Devolucion</th>
																		<th style="font-weight: bold; min-width: 60px; text-align: center;">Clave</th>
																		<th style="font-weight: bold; min-width: 350px; text-align: left;">Descripcion</th>
																		<th style="font-weight: bold; min-width: 40px; text-align: right;">Cantidad factura</th>
																		<th style="font-weight: bold; min-width: 40px; text-align: right;">Cantidad Notas</th>
																		<th style="font-weight: bold; min-width: 40px; text-align: center;">UM</th>
																		<th style="font-weight: bold; min-width: 70px; text-align: right;">Precio</th>
																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Iva(%)</th>
																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Des(%).</th>
																		<th style="font-weight: bold; min-width: 80px; text-align: right;">Subtotal</th>
																	    
																	</tr>
																</thead>
																					
															</table>
														</div>

</div>