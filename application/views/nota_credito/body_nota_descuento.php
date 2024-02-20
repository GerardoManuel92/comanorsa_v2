<div class="row" style="margin-bottom: 20px;" >
				
				<input type="number" name="idfactura" id="idfactura" value="<?php echo $rowsql1->id; ?>" class="form-control" style="display: none;" disabled>
				<input type="number" name="idcotizacion" id="idcotizacion" value="<?php echo $rowsql1->idcotizacion; ?>" class="form-control" style="display:none;" disabled>
				<input type="number" name="idtotal" id="idtotal" value="<?php

					$falta=$rowsql1->total-$rowsql1->totnota;
					echo $falta; 

				?>" class="form-control" style="display:none;" disabled>


				<div class="col-md-9 col-lg-9 col-xs-12">

					<div class="row" style="margin-left: 5px;">
						
						<h4 style="color:black;"><strong>Cliente:</strong> <?php echo $rowsql1->cliente; ?> | <a style="color:#5384bc; font-weight: bold;" href="<?php echo base_url()?>tw/php/facturas/<?php echo $rowsql1->folio; ?>.pdf" target="_blank"><i class="fa fa-file-text"></i> <?php echo $rowsql1->folio; ?></a></h4>
						<p><strong>Empresa: </strong> <?php echo $rowsql1->comercial; ?></p>
						<p><strong style="color:#5384bc; font-size: 17px;">Total factura: <?php echo wims_currency($rowsql1->total); ?> </strong>  <strong>Moneda: </strong><?php   if ( $rowsql1->moneda == 1 ){ echo 'PESOS'; }else{ echo 'DOLARES&nbsp;|&nbsp;Tipo de cambio:&nbsp;'.$rowsql1->tcambio; } ?></p>

						<p><strong style="color:#5384bc; font-size: 17px;">Total Notas credito: <?php echo wims_currency($rowsql1->totnota); ?> </strong>  <strong>Moneda: </strong><?php   if ( $rowsql1->moneda == 1 ){ echo 'PESOS'; }else{ echo 'DOLARES&nbsp;|&nbsp;Tipo de cambio:&nbsp;'.$rowsql1->tcambio; } ?></p>

					</div>

					<hr>

					<div class="row" style="margin-left: 5px;">
						

						<h4>Descuento aplicado a factura</h4>
						<div class="col-md-5">
							
							<label>Descuento neto | <strong>Moneda: </strong><?php   if ( $rowsql1->moneda == 1 ){ echo 'PESOS'; }else{ echo 'DOLARES&nbsp;|&nbsp;Tipo de cambio:&nbsp;'.$rowsql1->tcambio; } ?></label>
							<input type="number" name="desc" id="desc" class="form-control" style="text-align: right;" autofocus onblur="calcularTotalx()">

						</div>

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



