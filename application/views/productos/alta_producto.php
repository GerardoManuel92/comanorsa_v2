<div class="row">

			<div class="col-lg-12">

				<div class="panel panel-default" style="border-color: #5682b6; border-width: 1.5px; border-style: solid; background-color: #F8FFFF">

					<div class="panel-heading clearfix" style="background-color: #5682b6; color: white;" >



						<h3 class="panel-title" style="font-weight: bold;"><?php echo $titulox; ?></h3>

						<ul class="panel-tool-options"> 

							<li><a href="javascript:recargar()"><i class="icon-arrows-ccw" title="Recargar" style="color:white;"></i></a></li>

							<li><a data-rel="collapse" href="#"><i class="icon-down-open" title="Cerrar/Abrir" style="color:white;"></i></a></li>

							

						</ul>

					</div>

					<div class="panel-body" style="margin-top: 10px;">



						<div class="row" >



							<div class="col-md-4 col-lg-4">



								<div class="row" id="imgpro">

								

									<center><img src="<?php echo base_url()?>comanorsa/productos/0.jpg"></center>



								</div>







							</div>





							<div class="col-md-8 col-lg-8">



								<div class="row">



									<div class="col-md-6 col-lg-6"> 

										<!-- ADJUNTAR FIANZA-->



										<span class="btn btn-labeled btn-primary fileinput-button">



												<i class="btn-label icon fa fa-paperclip"></i>



												<span>*Adjuntar imagen</span>



												<input id="fileupload_pdf"  accept=".jpg" type="file" name="files[]" multiple>



										</span>



										<div id="progress_bar_factpdf" class="progress">



											<div class="progress-bar progress-bar-primary"></div>



										</div>



									</div>



									<div class="col-md-6 col-lg-6">

										

										<label>*Nombre de la imagen</label>

										<input type="text" name="name_factpdf" id="name_factpdf" class="form-control" disabled>



									</div>



								</div>



								<div class="row" style="margin-top: 15px;">

								

									<div class="col-md-4 col-lg-4"> 



									<label>Cbarras</label>

									<input type="number" name="cbarras" id="cbarras" class="form-control" autofocus placeholder="codigo barras..." tabindex="1">



									</div>



									<div class="col-md-4 col-lg-4 "> 



										<label id="txtclave">*No.de parte</label>

										<input type="text" name="clave" id="clave" class="form-control"  placeholder="No. parte proveedor..." tabindex="2" onblur="vClave(this.value)">



									</div>



									<div class="col-md-4 col-lg-4 "> 



										<label>*Unidad(<strong>SAT</strong>)</label>

										<select name="unidad" id="unidad" class="select2-placeholer form-control" tabindex="3"></select>



									</div>



								</div>



								<div class="row" style="margin-top: 15px;">



									<div class="col-md-12 col-lg-12 "> 



										<label>*Clave(<strong>SAT</strong>)</label>

										<input type="text" name="bi_clave" id="bi_clave" class="form-control"  placeholder="SAT clave..." tabindex="4">



									</div>



								</div>



								<div class="row" style="margin-top: 15px;">



									<div class="col-md-6 col-lg-6 "> 



										<label>*Marca</label>

										<!--<select class="form-control" id="marca" name="marca"></select>-->



										<div class="input-group"> 

												<select class="form-control select2-placeholer" id="marca" name="marca" tabindex="5"></select>

												<span class="input-group-btn"><button class="btn btn-success" type="button" onclick="window.open('<?php echo base_url() ?>AltaMarca/altaMarca/0','_blank')" tabindex="-1"><i class="fa fa-plus-square"></i></button></span>

										</div>



									</div>

									

									<div class="col-md-6 col-lg-6 "> 



										<label>*Categoria</label>

										<div class="input-group"> 

												<select class="form-control select2-placeholer" id="categoria" name="categoria" onchange="showSubcategoria(this.value)" tabindex="6"></select>

												<span class="input-group-btn"><button class="btn btn-success" type="button" onclick="window.open('<?php echo base_url() ?>AltaCategoria/altaCategoria/0','_blank')" tabindex="-1"><i class="fa fa-plus-square"></i></button></span>

										</div>



									</div>



									

								</div>



							</div>

							



						</div>

						



						<hr>



						<div class="row">

							

							<div class="col-md-12 col-lg-12 col-xs-12"> 



								<label>*Descripción</label>

								<input type="text" name="descrip" id="descrip" class="form-control" placeholder="descripcion del producto(280 caracteres)..." tabindex="8">



							</div>



						</div>



						<hr>



						<div class="row">

							

							



							<div class="col-md-2 col-lg-2 col-xs-12"> 



								<label id="titulo_costo" >*Costo</label>

								<input type="number" name="costo" id="costo" class="form-control"  placeholder="($)costo..." tabindex="9" style="text-align: right;" onblur="calcularCosto()">



							</div>



							<div class="col-md-1 col-lg-1 col-xs-12"> 



								<label id="txtutilidad" >Utilidad</label>

								<input type="number" name="utilidad" id="utilidad" class="form-control"  placeholder="(%)utilidad..." tabindex="10" style="text-align: right;" onblur="calcularCosto()">



							</div>



							<div class="col-md-2 col-lg-2 col-xs-12"> 



								<label>Precio</label>

								<input type="number" name="precio" id="precio" class="form-control" value="0" placeholder="($)precio..." tabindex="11" style="text-align: right;" disabled>



							</div>



							<div class="col-md-2 col-lg-2 col-xs-12">

								

								<label>*Iva</label>

								<select class="form-control" id="iva" tabindex="12" onchange="calcularCosto()">

									

									<option value="1" selected>General</option>

									<option value="2" style="color:red">Excento</option>

									<option value="3">Por producto</option>



								</select>



							</div>



							<div class="col-md-1 col-lg-1 col-xs-12"> 



								<label>Tasa(%)</label>

								<input type="number" name="tasa" id="tasa" class="form-control" value="0" placeholder="Tasa(%)..." tabindex="-1" disabled style="text-align: right;" onblur="calcularCosto()">



							</div>



							<div class="col-md-2 col-lg-2 col-xs-12"> 



								<label>Precio c/impuesto</label>

								<input type="number" name="cimpuesto" id="cimpuesto" class="form-control" value="0" placeholder="($)costo neto..." tabindex="13" style="text-align: right;" disabled>



							</div>





							<div class="col-md-2 col-lg-2 col-xs-12"> 



								<label>*Moneda</label>

								<select class="form-control" id="moneda" tabindex="14">

									

									<option value="1">MXN</option>

									<option value="2">USD</option>



								</select>



							</div>

							



						</div>



						<hr>



						<div class="row">



							<h4 style="font-weight: bold; margin-left: 10px;">Retenciones</h4>



							<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">

								

								<label> <input type="checkbox" id="iva_tasa" onclick="selectIva()"> IVA</label> 

								<label> Valor(%)</label>

	      						<input type="number" name="riva_valor" class="form-control" id="riva_valor" value="0" style="text-align: right;" disabled>



							</div>



							<div class="col-md-3 col-lg-3 col-sm-6 col-xs-12">

								

								<label> <input type="checkbox" id="risr_tasa" onclick="selectisrRet()"> ISR</label> 

								<label> Valor(%)</label>

	      						<input type="number" name="risr_valor" class="form-control" id="risr_valor" value="0" style="text-align: right;" disabled>



							</div>



						</div>



						<hr>





						<div class="row" >



							<div class="col-md-1 col-lg-1 col-xs-12"> 



								<label>Maximo</label>

								<input type="number" name="maximo" id="maximo" class="form-control" value="0" placeholder="maximo almacen..." tabindex="15" style="text-align: right;">



							</div>



							<div class="col-md-1 col-lg-1 col-xs-12"> 



								<label>Minimo</label>

								<input type="number" name="minimo" id="minimo" class="form-control" value="0" placeholder="minimo almacen..." tabindex="16" style="text-align: right;">



							</div>



							<div class="col-md-3 col-lg-3 col-xs-12"> 



								<label>Tags</label>

								

								<div class="input-group"> 

										<input type="text" name="tag" id="tag" class="form-control" placeholder="Tag o coincidencia..." tabindex="17">

										<span class="input-group-btn"><button class="btn btn-red" type="button" tabindex="18" onclick="sumarTag()">Ingresar</button></span>

								</div>



							</div>



							<div class="col-md-7 col-lg-7 col-xs-12" id="viewtags">



								



							</div>







						</div>





						<div class="row" style="margin-top: 15px; ">

							



							<button class="btn btn-blue btn-rounded btn-block" id="btn_finalizar" tabindex="19" onclick="altaPartida()"><i class="icon-right"></i> Ingresar producto</button>



						</div>

						

					</div>

					



				</div>



				



			</div>



			

			

</div>