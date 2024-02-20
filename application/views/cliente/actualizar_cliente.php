<div class="row">

			<div class="col-lg-12">

				<div class="panel panel-default" style="border-color: #5682b6; border-width: 1.5px; border-style: solid; background-color: #F8FFFF">

					<div class="panel-heading clearfix" style="background-color: #5682b6; color: white;" >



						<h3 class="panel-title" style="font-weight: bold;">Actualizar cliente</h3>

						<ul class="panel-tool-options"> 

							<li><a href="javascript:recargar()"><i class="icon-arrows-ccw" title="Recargar" style="color:white;"></i></a></li>

							<li><a data-rel="collapse" href="#"><i class="icon-down-open" title="Cerrar/Abrir" style="color:white;"></i></a></li>

							

						</ul>

					</div>

					<div class="panel-body" style="margin-top: 10px;">



						<div class="row">



							<input type="number" style="display: none;" name="idcliente" disabled id="idcliente" value="<?php echo $info_cliente->id ?>" >



							<div class="col-md-4 col-lg-4 col-xs-12"> 



								<label>*Nombre fiscal</label>

								<input type="text" name="nfiscal" id="nfiscal" class="form-control" autofocus value="<?php echo $info_cliente->nombre ?>" placeholder="nombre fiscal..." tabindex="1">



							</div>



							<div class="col-md-5 col-lg-5 col-xs-12"> 



								<label>Nombre comercial</label>

								<input type="text" name="ncomercial" id="ncomercial" class="form-control"  placeholder="nombre comercial..." tabindex="2" value="<?php echo $info_cliente->comercial ?>">



							</div>



							<div class="col-md-3 col-lg-3 col-xs-12"> 



								<label id="txtrfc">*RFC</label>

								<input type="text" name="rfc" id="rfc" class="form-control"  onblur="vRfc(this.value)" placeholder="RFC SAT..."  value="<?php echo $info_cliente->rfc ?>" tabindex="3">



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

								

								<h3>Dirección cliente</h3>



							</div>



							<div class="col-md-4 col-lg-4 col-xs-12"> 



								<label>Calle</label>

								<input type="text" name="calle" id="calle" class="form-control"  placeholder="calle cliente..." tabindex="8" value="<?php echo $info_cliente->calle; ?>">



							</div>



							<div class="col-md-2 col-lg-2 col-xs-12"> 



								<label>No.Exterior</label>

								<input type="text" name="ext" id="ext" class="form-control"  placeholder="#exterior cliente..." tabindex="9"

								value="<?php echo $info_cliente->exterior; ?>">



							</div>



							<div class="col-md-2 col-lg-2 col-xs-12"> 



								<label>No.Interior</label>

								<input type="text" name="int" id="int" class="form-control"  placeholder="#interior cliente..." tabindex="10" value="<?php echo $info_cliente->interior; ?>">



							</div>



							<div class="col-md-4 col-lg-4 col-xs-12"> 



								<label>Colonia</label>

								<input type="text" name="colonia" id="colonia" class="form-control"  placeholder="colonia cliente..." tabindex="11" value="<?php echo $info_cliente->colonia; ?>">



							</div>



						</div>



						<hr>



						<div class="row">

							

							<div class="col-md-3 col-lg-3 col-xs-12"> 



								<label>Municipio</label>

								<input type="text" name="municipio" id="municipio" class="form-control"  placeholder="municipio cliente..." tabindex="12" value="<?php echo $info_cliente->municipio; ?>">



							</div>



							<div class="col-md-3 col-lg-3 col-xs-12"> 



								<label>Estado</label>

								<input type="text" name="estado" id="estado" class="form-control"  placeholder="estado cliente..." tabindex="13" value="<?php echo $info_cliente->estado; ?>">



							</div>



							<div class="col-md-2 col-lg-2 col-xs-12"> 



								<label>C.P.</label>

								<input type="text" name="cp" id="cp" class="form-control"  placeholder="codigo postal..." tabindex="14" value="<?php echo $info_cliente->cp; ?>">



							</div>

							<div class="col-md-4 col-lg-4 col-xs-12"> 



								<label>Referencia</label>

								<input type="text" name="ref" id="ref" class="form-control"  placeholder="referencia ubicacion..." tabindex="15" value="<?php echo $info_cliente->referencia; ?>">

							</div>



							<!--<div class="col-md-4 col-lg-4 col-xs-12"> 



								<label>Referencia</label>

								<div class="input-group">

									<input type="text" name="ref" id="ref" class="form-control"  placeholder="referencia ubicacion..." tabindex="15" value="<?php echo $info_cliente->referencia; ?>">

									<span class="input-group-btn">

										<button class="btn btn-success" type="button" id="btnanadir2" tabindex="16" onclick="sumarDir()" title="Añadir direccion"><i class="fa fa-plus"></i></button>

									</span>

								</div>




							</div>-->



						</div>



						<div class="row"  style="margin-top: 20px;">



							<div class="col-md-12">



								<h3>Lista de direcciones:</h3>



							</div>

									

								<div class="cards-container box-view" id="lista_direccion">



									<!--<div class="card">

					

											

											<div class="card-header">

											

												

												<div class="card-photo">

													<img class="img-circle avatar" src="comanorsa/casa.png" alt="John Henderson" title="John Henderson">

												</div>

												

												

												<div class="card-short-description">

													<h5><span class="user-name"><a href="#/">Direccion #1 </a></span><a href="javascript:eliminarDir()"><span class="badge badge-danger"><i class="fa fa-trash"></i></span></a></h5>

													<p>Calle monterrey #47, Col.Jardines de guadalupe, Nezahualcoyotl Estado de Mexico Cp.57140</p>

												</div>

											

												

											</div>

										

											<div class="card-content">

												

												<ul class="list-inline list-action" style="color: darkblue; font-weight: bold; font-size: 14px;">

													<li>Descuento: 20% |</a></li>

													<li>Credito: 7 dias |</a></li>

													<li>Limite de credito: $150,000</a></li>

												</ul>

											</div>

											

											

									</div>-->

					

								</div>



						</div>



						<hr>


						<div class="row">



							<div class="col-md-12">

								

								<h3>Datos comerciales</h3>



							</div>



							<div class="col-md-3 col-lg-3 col-xs-12"> 



								<label>Descuento(%)</label>

								<input type="number" style="text-align: right;" value="<?php echo $info_cliente->descuento; ?>" name="descuento" id="descuento" class="form-control"  placeholder="descuento a cliente..." tabindex="16" >



							</div>



							<div class="col-md-3 col-lg-3 col-xs-12"> 



								<label>Dias credito</label>

								<input type="number" style="text-align: right;" value="<?php echo $info_cliente->credito; ?>" name="dias" id="dias" class="form-control"  placeholder="dias de credito..." tabindex="17">



							</div>



							<div class="col-md-4 col-lg-4 col-xs-12"> 



								<label>Limite de credito</label>

								<input type="number" style="text-align: right;" value="<?php echo $info_cliente->limite; ?>" name="limite" id="limite" class="form-control"  placeholder="limite de credito..." tabindex="18">



							</div>


						</div>



						<hr>



						<div class="row" >



							<div class="col-md-12">

								

								<h3>Datos fiscales</h3>



							</div>



							<div class="col-md-6 col-lg-6 col-xs-12"> 



								<label>Forma de pago(<strong>SAT</strong>)</label>

								<select name="fpago" id="fpago" class="select2-placeholer form-control" tabindex="19"></select>



							</div>



							<div class="col-md-6 col-lg-6 col-xs-12"> 



								<label>Uso de CFDI(<strong>SAT</strong>)</label>

								<select name="cfdi" id="cfdi" class="select2-placeholer form-control" tabindex="20"></select>



							</div>



							<div class="col-md-12 col-lg-12 col-xs-12" style="margin-top: 10px;"> 



								<label>Regimen fiscal(<strong>SAT</strong>)</label>

								<select name="regimen" id="regimen" class="select2-placeholer form-control" tabindex="21"></select>



							</div>



						</div>





						<div class="row" style="margin-top: 15px; ">

							



							<button class="btn btn-warning btn-rounded btn-block" id="btn_finalizar" tabindex="21" onclick="actCli()" style="color:black;"><i class="icon-right"></i> Actualizar cliente</button>



						</div>

						

					</div>

					



				</div>



				



			</div>



			

			

</div>