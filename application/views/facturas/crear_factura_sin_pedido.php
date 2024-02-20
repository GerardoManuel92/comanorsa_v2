
	<!--<button onclick="showEditar()" value="Editar" class="btn btn-success">Habilitar</button>

	<a href="#" id="username" data-type="text" data-pk="1" data-url="/post" data-title="Enter username">Editar texto</a>-->

<div class="row">

				<div class="col-md-9 col-lg-9">
					
					<div class="col-md-12">
		      			<h3>Datos del receptor</h3>
		      		</div>

		      		<div class="col-md-2">

		      			<a style="color:red; font-weight: bold;" href="<?php echo base_url()?>tw/php/facturas/<?php echo $info->serie.''.$info->folio?>.pdf" target="_blank"><i class="fa fa-file-text"></i> 

		      				<?php

                              echo $info->serie.''.$info->folio;

                            ?>
						</a>

		      		</div>

		      		<div class="col-md-5">
		      				
		      			<p id="nreceptor"><?php echo $info->cliente; ?></p>	

		      		</div>

		      		<div class="col-md-3">
		      				
		      			<p id="nrfc"><?php echo $info->rfc; ?></p>	

		      		</div>

		      		<div class="col-md-2">
		      			
		      			<p id="ncp"></p>

		      		</div>

		      		<div class="col-md-12">
		      			
		      			<p id="nregimen"></p>

		      		</div>

				</div>

				<div class="col-md-3 col-lg-3 pull-right" style="text-align: right;">
								
								<h4 style="font-weight: bold; margin-bottom: 10px;"><a href="javascript:verDetalles()" style="font-size: 11px;">(ver detalles)</a><a href="javascript:cerrarDetalles()" id="cerrar" style="display: none;"><i class="fa fa-close" style="color:red; font-weight: bold;"></i></a></h4>
								<p style="color: green; display: ; font-size: 17px;" id="tsubtotal"></p>
								<p style="color: red; display: none;" id="tdescuento"></p>
								<p style="color: darkblue; display: none;" id="tiva"></p>
								<h3 style="color:darkgreen; font-weight: bold;" id="tneto"></h3>

				</div>
							
</div>


<!--Basic Modal-->
<div id="modal-1" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header" style="background-color: <?php echo BGCOLOR; ?>; color: <?php echo TXTHEAD; ?>; font-weight: bold;">

        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><strong>Alta facturación</strong></h4>

      </div>
      <div class="modal-body">

      	<div class="row" id="namefactura" style="display: none;">
      		
      		<div class="col-md-12">
      			
      			<label>*Nombre emisor de la factura(editable)</label>
      			<input type="text" name="name_factura" class="form-control" id="name_factura" value="VENTAS PUBLICO GENERAL">

      		</div>

      	</div>

      	<hr>
        
      	<div class="row">

      		
      		
      		<div class="col-md-6">
      			
      			<label>*Metodo de pago</label>
      			<select id="mpago" class="form-control" onchange="estatusFpago(this.value)"></select>

      		</div>

      		<div class="col-md-6">
      			
      			<label>*Forma de pago</label>
      			<select id="fpago" class="form-control" ></select>

      		</div>

      		<div class="col-md-9" style="margin-top: 10px;">
      			
      			<label>*Uso de CFDI</label>
      			<select id="cfdi" class="form-control" ></select>

      		</div>

      		<div class="col-md-3" style="text-align: right; margin-top: 10px;">
      			
      			<label>Dias credito</label>
      			<input type="number" name="credito" class="form-control" id="credito" style="text-align: right;" value="<?php 



      			$separar = explode('/',$info->limitex); 

      			echo $separar[0];


      			?>" >

      		</div>

      		<!--<div class="row col-md-12 col-lg-12" id="impuestos" style="margin-top: 10px;">
					      			
      			<div class="col-md-12">
					<div class="tabs-container">
						<ul class="nav nav-tabs">
							<li class="active"><a aria-expanded="false" href="#trasladables" data-toggle="tab">Trasladados</a></li>
							<li class=""><a aria-expanded="true" href="#retenidos" data-toggle="tab">Retenidos</a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane active" id="trasladables">
								<div class="panel-body">

									<div class="col-md-6 col-lg-6">
										
										<h4 style="font-weight: bold;">Iva trasladado</h4>

										<div class="col-md-6"><label> <input type="checkbox" id="iva_tasa" checked="true" onclick="selectIva()"> Tasa</label></div>
	      								<div class="col-md-6"><label> <input type="checkbox" id="iva_excento" onclick="selectivaExc()"> Excento</label></div>

	      								<div class="col-md-12 col-lg-12">
	      									
	      									<label>Base</label>
	      									<input type="text" name="iva_base" class="form-control" id="iva_base" style="text-align: right;" disabled>

	      								</div>

	      								<div class="col-md-12 col-lg-12">
	      									
	      									<label>Valor(%)</label>
	      									<input type="number" name="iva_valor" class="form-control" id="iva_valor" onblur="calcularIva()" value="16" style="text-align: right;">

	      								</div>

	      								<div class="col-md-12 col-lg-12">
	      									
	      									<label>Importe</label>
	      									<input type="text" name="iva_importe" class="form-control" onblur="calcularIva()" id="iva_importe" style="text-align: right;" disabled>

	      								</div>

									</div>

								</div>
							</div>
							<div class="tab-pane" id="retenidos">
								<div class="panel-body">
									
									<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 col-xl-6">
      					
										<h4 style="font-weight: bold;">Retención de IVA</h4>

				      					<label> <input type="checkbox" id="riva_tasa"  onclick="selectivaRet()"> Tasa</label>

				      					<div class="col-md-12 col-lg-12">
	      									
	      									<label>Base</label>
	      									<input type="text" name="riva_base" class="form-control" id="riva_base" style="text-align: right;">

	      								</div>

	      								<div class="col-md-12 col-lg-12">
	      									
	      									<label>Valor</label>
	      									<input type="number" name="riva_valor" class="form-control" id="riva_valor" style="text-align: right;">

	      								</div>

	      								<div class="col-md-12 col-lg-12">
	      									
	      									<label>Importe</label>
	      									<input type="text" name="riva_importe" class="form-control" id="riva_importe" style="text-align: right;" disabled>

	      								</div>
				      					
				      				</div>

				      				<div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 col-xl-6">
      					
				      					<h4 style="font-weight: bold;">Retención de ISR</h4>

				      					<label> <input type="checkbox" id="risr_tasa" onclick="selectisrRet()"> Tasa</label>

				      					<div class="col-md-12 col-lg-12">
	      									
	      									<label>Base</label>
	      									<input type="text" name="risr_base" class="form-control" id="risr_base" style="text-align: right;">

	      								</div>

	      								<div class="col-md-12 col-lg-12">
	      									
	      									<label>Valor</label>
	      									<input type="number" name="risr_valor" class="form-control" id="risr_valor" style="text-align: right;">

	      								</div>

	      								<div class="col-md-12 col-lg-12">
	      									
	      									<label>Importe</label>
	      									<input type="text" name="risr_importe" class="form-control" id="risr_importe" style="text-align: right;" disabled>

	      								</div>
				      					
				      				</div>

								</div>
							</div>
						</div>
					</div>
				</div>
      				
      				

      		</div>-->

      	</div>

      	<hr>

      	<div class="row">

      							<div class="col-md-7 col-lg-7"> 
									<!-- ADJUNTAR FIANZA-->

								
									<span class="btn btn-labeled btn-primary fileinput-button">

											<i class="btn-label icon fa fa-paperclip"></i>

											<span>Adjuntar ODC del cliente</span>

											<input id="fileupload_pdf"  accept=".pdf,.jpg,.png,.jpeg" type="file" name="files[]" multiple>

									</span>

									<div id="progress_bar_factpdf" class="progress">

										<div class="progress-bar progress-bar-primary"></div>

									</div>

								</div>

								<div class="col-md-5 col-lg-5">
									
									<div id="files_cfactpdf" class="files" style="margin-bottom: 10px;">*Sin ODC adjunta</div>

									<input type="text" name="name_factpdf" id="name_factpdf" class="form-control" disabled>

								</div>
	      			 

      	</div>

      	<hr>

      	<div class="row" id="creditox">

      		<div class="col-md-12">

      			<input type="number" name="limite" style="display: none;" id="limite" class="form-control" value="<?php 

      			$separar = explode('/',$info->limitex);

      			echo $separar[1]-($info->totfactura+$info->totremision) 



      			?>" disabled hidden >
      		
	      		<h3 style="font-weight: bold; color:darkblue;" >Credito</h3>

	      		<p style="color: darkblue; font-weight: bold;">Limite de credito: <strong style="font-size: 19px;">

	      		<?php

	      			$separar = explode('/',$info->limitex); 

	      			echo wims_currency($separar[1]); 

	      		?>
	      			
	      		</strong> mxn</p>

	      		<p style="color:darkgreen; font-weight: bold;">Saldo por cobrar: <strong style="font-size: 19px;"><?php echo wims_currency($info->totfactura+$info->totremision); ?></strong> mxn</p>
	      		<p style="color:red; font-weight: bold;">Saldo vencido: <strong style="font-size: 19px;"><?php echo wims_currency($info->sfvencido+$info->srvencido); ?></strong> mxn</p>
	      		<p style="color:black; font-weight: bold;">Credito activo: 
	      			<strong style="font-size: 19px;"><?php

	      				$separar = explode('/',$info->limitex);	

	      				$activo = $separar[1]-($info->totfactura+$info->totremision);

	      				echo wims_currency($activo);

	      			?></strong>

	      		 mxn</p>

	      		<p style="color:red" id="alertax">
	      			


	      		</p>

	      	</div>
      		

      	</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-success" onclick="factCotizacion()" id="btnfactura"><i class="fa fa-check"> Facturar</i></button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--End Basic Modal-->


						<div class="row" style="margin-top: 20px; ">

														<div class="table-responsive">

															<table class="table table-striped table-bordered table-hover" id="my-table" >


																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">
																	
																	<tr>
																		<th style="font-weight: bold; min-width: 30px; text-align: center;"></th>
																		<th style="font-weight: bold; min-width: 30px; text-align: center;">No.</th>
																		<th style="font-weight: bold; min-width: 40px; text-align: right;">Cant</th>
																		<th style="font-weight: bold; min-width: 70px; text-align: center;">Clave</th>
																		<th style="font-weight: bold; min-width: 400px;">Descripcion</th>
																		<th style="font-weight: bold; min-width: 40px; text-align: center;">UM</th>
																		<th style="font-weight: bold; min-width: 70px; text-align: right;">Precio</th>
																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Iva(%)</th>
																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Des(%).</th>
																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Utl(%).</th>
																		<th style="font-weight: bold; min-width: 50px; text-align: right;">Tc.</th>
																		<th style="font-weight: bold; min-width: 80px; text-align: right;">Subtotal</th>
																	    
																	</tr>
																</thead>
																					
															</table>
														</div>

						</div>
