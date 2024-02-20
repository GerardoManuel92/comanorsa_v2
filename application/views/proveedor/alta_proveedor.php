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



							<div class="col-md-4 col-lg-4 col-xs-12"> 



								<label>*Nombre fiscal</label>

								<input type="text" name="nfiscal" id="nfiscal" class="form-control" autofocus placeholder="nombre fiscal..." tabindex="1">



							</div>



							<div class="col-md-5 col-lg-5 col-xs-12"> 



								<label>Nombre comercial</label>

								<input type="text" name="ncomercial" id="ncomercial" class="form-control"  placeholder="nombre comercial..." tabindex="2">



							</div>



							<div class="col-md-3 col-lg-3 col-xs-12"> 



								<label id="txtrfc">*RFC</label>

								<input type="text" name="rfc" id="rfc" class="form-control"  onblur="vRfc(this.value)" placeholder="RFC SAT..." tabindex="3">



							</div>



						</div>



						<hr>



						<div class="row">



							<div class="col-md-3 col-lg-3 col-xs-12"> 



								<label>Contacto</label>

								<input type="text" name="contacto" id="contacto" class="form-control"  placeholder="contacto proveedor..." tabindex="4">



							</div>



							<div class="col-md-2 col-lg-2 col-xs-12"> 



								<label>Departamento</label>

								<input type="text" name="depa" id="depa" class="form-control"  placeholder="departamento proveedor..." tabindex="5">



							</div>



							<div class="col-md-2 col-lg-2 col-xs-12"> 



								<label>Telefono</label>

								<input type="text" name="telefono" id="telefono" class="form-control"  placeholder="telefono proveedor..." tabindex="6">



							</div>

					



							<div class="col-md-3 col-lg-3 col-xs-12"> 



								<label>Correo</label>

								<input type="text" name="correo" id="correo" class="form-control"  placeholder="correo..." tabindex="7">



							</div>



							<div class="col-md-2 col-lg-2 col-xs-12">

								

								<label>Acciones</label>

								<button class="btn btn-success" onclick="sumarContacto()" id="btnanadir" tabindex="8">Añadir contacto</button>



							</div>



						</div>



						<div class="row"  style="margin-top: 20px;">



							<div class="col-md-12">



								<h3>Lista de contactos</h3>



							</div>

									

								<div class="cards-container box-view" id="lista_contacto">







				

								</div>



						</div>



						<hr>



						<div class="row">

							

							<div class="col-md-12">

								

								<h3>Dirección proveedor</h3>



							</div>



							<div class="col-md-4 col-lg-4 col-xs-12"> 



								<label>Calle</label>

								<input type="text" name="calle" id="calle" class="form-control"  placeholder="calle proveedor..." tabindex="9">



							</div>



							<div class="col-md-2 col-lg-2 col-xs-12"> 



								<label>No.Exterior</label>

								<input type="text" name="ext" id="ext" class="form-control"  placeholder="#exterior proveedor..." tabindex="10">



							</div>



							<div class="col-md-2 col-lg-2 col-xs-12"> 



								<label>No.Interior</label>

								<input type="text" name="int" id="int" class="form-control"  placeholder="#interior proveedor..." tabindex="11">



							</div>



							<div class="col-md-4 col-lg-4 col-xs-12"> 



								<label>Colonia</label>

								<input type="text" name="colonia" id="colonia" class="form-control"  placeholder="colonia proveedor..." tabindex="12">



							</div>



						</div>

						<br>


						<div class="row">

							

							<div class="col-md-3 col-lg-3 col-xs-12"> 



								<label>Municipio</label>

								<input type="text" name="municipio" id="municipio" class="form-control"  placeholder="municipio proveedor..." tabindex="13">



							</div>



							<div class="col-md-3 col-lg-3 col-xs-12"> 



								<label>Estado</label>

								<input type="text" name="estado" id="estado" class="form-control"  placeholder="estado proveedor..." tabindex="14">



							</div>



							<div class="col-md-2 col-lg-2 col-xs-12"> 



								<label>C.P.</label>

								<input type="text" name="cp" id="cp" class="form-control"  placeholder="codigo postal..." tabindex="15">



							</div>



							<div class="col-md-4 col-lg-4 col-xs-12"> 



								<label>Referencia</label>

								<input type="text" name="ref" id="ref" class="form-control"  placeholder="referencia ubicacion..." tabindex="16">



							</div>



						</div>



						<hr>





						<div class="row" >



							<div class="col-md-12">

								

								<h3>Datos fiscales y comerciales</h3>



							</div>



							<div class="col-md-4 col-lg-4 col-xs-12"> 



								<label>Forma de pago(<strong>SAT</strong>)</label>

								<select name="fpago" id="fpago" class="select2-placeholer form-control" tabindex="17"></select>



							</div>



							<div class="col-md-4 col-lg-4 col-xs-12"> 



								<label>Uso de CFDI(<strong>SAT</strong>)</label>

								<select name="cfdi" id="cfdi" class="select2-placeholer form-control" tabindex="18"></select>



							</div>



							<div class="col-md-2 col-lg-2 col-xs-12">

								

								<label>Dias de credito</label>

								<input type="number" name="dias" id="dias" class="form-control" value="0" style="text-align: right;">



							</div>

							<div class="col-md-2 col-lg-2 col-xs-12">

								

								<label>Limite de credito</label>

								<input type="number" name="limite" id="limite" class="form-control" value="0" style="text-align: right;">



							</div>



						</div>





						<div class="row" style="margin-top: 15px; ">

							



							<button class="btn btn-blue btn-rounded btn-block" id="btn_finalizar" tabindex="19" onclick="altaPro()"><i class="icon-right"></i> Ingresar proveedor</button>



						</div>

						

					</div>

					



				</div>



				



			</div>



			

			

</div>