

<div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

  <div class="modal-dialog modal-md" role="document">

    <div class="modal-content">

      <div class="modal-header" style="background-color: #5384bc;">

        <h3 class="modal-title" id="titulo"><strong style="color:white;">Alta entrega </strong></h3>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          <span aria-hidden="true" style="color:white;">&times;</span>

        </button>

      </div>

      <div class="modal-body">

        

      		<div class="row">



      			

	      			<div class="col-md-12 col-lg-12">



	      				<label>Recibido por</label>

	      				<input type="text" name="recibio" id="recibio" class="form-control" >

	      				

	      			</div>



	      	</div>



	      	<div class="row" style="margin-top: 10px;">





	      						<div class="col-md-7 col-lg-7"> 

									<!-- ADJUNTAR FIANZA-->



								

									<span class="btn btn-labeled btn-primary fileinput-button">



											<i class="btn-label icon fa fa-paperclip"></i>



											<span>*Adjuntar evidencia recepcion</span>



											<input id="fileupload_pdf"  accept=".pdf,.jpg,.png,.jpeg" type="file" name="files[]" multiple>



									</span>



									<div id="progress_bar_factpdf" class="progress">



										<div class="progress-bar progress-bar-primary"></div>



									</div>



								</div>



								<div class="col-md-5 col-lg-5">

									

									<div id="files_cfactpdf" class="files" style="margin-bottom: 10px;">*Sin evidencia adjunta</div>



									<input type="text" name="name_factpdf" id="name_factpdf" class="form-control" disabled>



								</div>

	      			



	      	</div>







      </div>

      <div class="modal-footer">

        <!-- <button class="btn btn-warning btn-rounded btn-block" id="btn_parcial" onclick="entradaParcial()" style="color:black;" disabled><i class="fa fa-file-code-o" style="color:black;" ></i> Entrega parcial</button> -->

        <button class="btn btn-success btn-rounded btn-block" id="btn_all" onclick="entradaAll()"><i class="icon-check"></i> Realizar entrega</button>

      </div>

    </div>

  </div>

</div>



<div class="row" >





				<div class="col-md-9 col-lg-9 col-xs-12">





					<div class="col-md-12">



						<div class="col-md-2"> 

									

							<label>*Documento</label>

							<select class="form-control" id="tipo" name="tipo" >

								

								<option value="2" >Factura</option>

								<option value="1" >Remisión</option>



							</select> 



						</div>

						

						<div class="col-md-2"> 



							<label>*Folio</label>

									<div class="input-group"> 

										<input type="text" class="form-control" id="folio"  autofocus style="text-align: right;"> 

										<span class="input-group-btn"><button class="btn btn-warning" type="button" onclick="showDocumento()"><i class="fa fa-search" style="color:black;"></i></button></span>

									</div>

						</div>



						<div class="col-md-8" >

					

							<label>Observaciones para la entrega</label>

							<textarea id="obs" class="form-control" name="obs" rows="1" autofocus maxlength="250"></textarea>



						</div>



					</div>



					<div class="row col-md-12">



						

							

							<strong style="color:darkblue;"> <strong style="font-size:30px;" id="documento"></strong> <strong id="clientex">&nbsp;&nbsp;&nbsp;Cliente:</strong>  | <strong style="color:darkblue;" id="vendedor">Vendedor:</strong>   | <a href="<?php echo base_url() ?>tw/php/ordencompra/odc.pdf" target="_blank" style="color: #8D27B0;" id="formato"><i class="fa fa-file-text" style="color: #8D27B0;"> Documento</i></a>



						



							<br>

							

							<strong style="color:darkblue;" id="fecha">Realizada:</strong>



							<br>



							<strong style="color:darkblue;" id="observaciones" name="observaciones">Observaciones :</strong>  



					</div>



				</div>



				<div class="col-md-3 col-lg-3 ">

								

								

								<p style="color: green; display: ; font-size: 17px;" id="tsubtotal"></p>

								<p style="color: red; display: none;" id="tdescuento"></p>

								<p style="color: darkblue; display: none;" id="tiva"></p>

								<h3 style="color:darkgreen; font-weight: bold;" id="tneto"> </h3>



				</div>



				



							

</div>



<div class="row" style="margin-top: 20px; ">



														<div class="table-responsive">



															<table class="table table-striped table-bordered table-hover" id="my-table" >





																<thead class="bg-thinkweb-table" style="background-color: gray; color: white;">

																	

																	<tr>

																		

																		<th style="font-weight: bold; min-width: 20px; text-align: left; font-size: 12px;">Orden</th>

																		<th style="font-weight: bold; min-width: 250px; text-align: center; font-size: 12px;">Descripcion</th>

																		<th style="font-weight: bold; min-width: 60px; text-align: center; font-size: 12px;">Vendido</th>

																		<th style="font-weight: bold; min-width: 60px; text-align: center; font-size: 12px;">Almacen</th>

																		<th style="font-weight: bold; min-width: 60px; text-align: center; font-size: 12px;">Entregas</th>

																		<th style="font-weight: bold; min-width: 60px; text-align: right; font-size: 12px;">Entrega</th>

																		<th style="font-weight: bold; min-width: 80px; text-align: right; font-size: 12px;">Precio</th>

																		<th style="font-weight: bold; min-width: 80px; text-align: right; font-size: 12px;">Descuento</th>

																		<th style="font-weight: bold; min-width: 80px; text-align: right; font-size: 12px;">Iva</th>

																		<th style="font-weight: bold; min-width: 80px; text-align: right; font-size: 12px;">Subtotal</th>

																	    

																	</tr>

																</thead>

																					

															</table>

														</div>



						</div>