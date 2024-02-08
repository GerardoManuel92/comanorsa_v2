 <!-- ============================================================== -->
 <!-- Start Page Content here -->
 <!-- ============================================================== -->

 <div class="content-page">
     <div class="content">

         <!-- Start Content-->
         <div class="container-fluid">

             <div class="row">
                 <div class="col-lg-6">
                     <div class="page-title-box justify-content-between d-flex align-items-lg-center flex-lg-row flex-column">
                         <h4 class="page-title">Alta cotización</h4>
                     </div>
                 </div>
                 <!-- <div class="col-lg-6" style="display: flex; justify-content: center; align-items: center;">
                     <div class="page-title-box justify-content-between d-flex align-items-lg-center flex-lg-row flex-column" style="column-gap: 10px;">
                         <button class="btn btn-warning" type="button" style="font-weight: bold;"><i class="ri-check-line"></i>&nbsp;FINALIZAR</button>
                         <button class="btn btn-success" type="button" style="font-weight: bold;"><i class="ri-attachment-fill"></i>&nbsp;ADJUNTAR EVIDENCIA</button>
                         <button class="btn btn-danger" type="button" style="font-weight: bold;"><i class="ri-close-fill"></i>&nbsp;CANCELAR</button>
                     </div>
                 </div> -->
             </div>

             <div class="card">
                 <div class="card-body">
                     <div class="row">
                         <div class="col-lg-10">
                             <!-- <h4 class="header-title">Floating labels</h4> -->
                             <div class="row">
                                 <div class="col-lg-8 col-md-12">
                                     <div class="input-group flex-nowrap">
                                         <span class="input-group-text" id="basic-addon1"><i class="ri-user-3-fill"></i></span>
                                         <select class="form-select control select2-placeholer" id="cliente" data-toggle="select2" placeholder="seleccionar cliente p/cotizacion...">

                                         </select>
                                         <button class="btn btn-success" type="button"><i class="ri-add-fill" style="font-weight: bold;"></i></button>
                                     </div>
                                 </div>
                                 <div class="col-lg-2 col-md-6">

                                     <div class="mb-3">
                                         <select class="form-select mb-3">
                                             <option value="0">Pesos</option>
                                             <option value="1">Dolares</option>
                                         </select>
                                     </div>
                                 </div>
                                 <div class="col-lg-2 col-md-6 col-xs-12">
                                     <div class="mb-3">
                                         <!-- <label class="form-label">Static</label> -->
                                         <div class="input-group flex-nowrap">
                                             <span class="input-group-text" id="basic-addon1">T.C.</span>
                                             <input type="text" class="form-control" value="1" disabled>
                                         </div>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-lg-6 col-xs-12">
                                     <div class="mb-3">
                                        <input type="text" name="bi_pro" id="bi_pro" class="form-control"  placeholder="Buscar por descripcion/clave/tag..." tabindex="4" style="font-size: 14px;" autofocus="true">         
                                     </div>
                                 </div>                                 
                                 <div class="col-lg-2 col-md-6 col-xs-12">
                                     <div class="mb-3">
                                        <div class="input-group">
                                            <input type="number" name="cantidad" class="form-control" id="cantidad" placeholder="cantidad..." style="text-align: right;" tabindex="5" onblur="calcularSubtotal()">
                                            <span style="font-size: 12px; color:red; font-weight: bold; display: none;" id="txt_cantidad">*Agregue una cantidad valida</span>

                                        </div>
                                     </div>
                                 </div>
                                 <div class="col-lg-2">
                                     <div class="mb-3">
                                         <p id="unidad" style="font-size: 22px; font-weight: bold;">U.M.</p>
                                     </div>
                                 </div>
                             </div>

                             <div class="row">
                                 <div class="col-lg-10 col-md-12 col-xs-12">
                                     <div class="mb-3">
                                         <textarea class="form-control" id="descripcion" name="descripcion" rows="2" placeholder="Descripcion..."></textarea>
                                     </div>
                                 </div>
                             </div>

                             <div class="row">
                                 <div class="col-lg-2 col-md-6 col-xs-12">
                                     <div class="mb-3">
                                        <div class="input-group">
                                            <input type="text" name="costo" class="form-control" id="costo" placeholder="($)costo..." tabindex="7" style="text-align: right;" onblur="calcularSubtotal()">
                                            <span style="font-size: 12px; color:red; font-weight: bold; display: none;" id="txt_costo">*Agregue un costo valido</span>
                                        </div>
                                     </div>
                                 </div>
                                 <div class="col-lg-2">
                                     <div class="mb-3">
                                         <div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="basic-addon1" style="color: green; font-weight: bold;">%</span>
                                            <input type="number" name="utilidad" class="form-control" id="utilidad" placeholder="utilidad..." tabindex="8" style="text-align: right;" onblur="calcularSubtotal()">
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-lg-2 col-md-6 col-xs-12">
                                     <div class="mb-3">
                                        <input type="text" name="precio" class="form-control" id="precio" placeholder="($)precio..." style="text-align: right;" tabindex="9" onblur="calcularSubtotalPrecio()">
                                     </div>
                                 </div>
                                 <div class="col-lg-2">
                                     <div class="mb-3">
                                         <div class="input-group flex-nowrap">
                                            <span class="input-group-text" id="basic-addon1" style="color: red; font-weight: bold;">-%</span>	
                                            <input type="number" name="descuento" class="form-control" id="descuento" placeholder="Desc..." tabindex="10" style="text-align: right;">
                                         </div>
                                     </div>
                                 </div>
                                 <div class="col-lg-2" style="display: none;">
                                    <div class="mb-3">
                                        <input type="number" name="tasa" class="form-control" id="tasa" placeholder="tasa..." tabindex="-1" style="text-align: right;">
                                    </div>
                                 </div>
                                 <div class="col-lg-2 col-md-6 col-xs-12">
                                     <div class="mb-3">
                                        <input type="text" name="total" class="form-control" id="total" placeholder="($)subtotal..." style="text-align: right;" tabindex="-1" disabled>
                                     </div>
                                 </div>
                                 <div class="col-lg-2 col-md-6 col-xs-12">
                                     <div class="mb-3">
                                         <button class="btn btn-primary" type="button" class="form-control" onclick="ingresarPartidas()" tabindex="11" id="btn_ingresar"><i class="ri-arrow-right-line" style="font-weight: bold;"></i></button>
                                         <button class="btn btn-warning" type="button"><i class="ri-eye-fill" style="color: black; font-weight: bold;"></i></button>
                                     </div>
                                 </div>
                             </div>

                             <div class="row" id="retenciones" style="display:none; margin-top: 10px;">

						        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">							

							        <label id="tit_iva"></label>

							        <input type="number" id="valor_riva" disabled value="0">

							        <input type="text" name="riva" id="riva" class="form-control" value="0" disabled="" style="text-align: right;">



						        </div>



						        <div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">

							

							        <label id="tit_isr"></label>

							        <input type="number" id="valor_risr" disabled value="0">

							        <input type="text" name="risr" id="risr" class="form-control" value="0" disabled="" style="text-align: right;">



						        </div>

						
                                <div class="form-group col-md-2 col-sm-12 col-lg-2" style="display: none;"> 

								

									<div id="fechar" class="input-group date">



										<span class="input-group-addon"><i class="fa fa-calendar"></i></span>  

										<input id="fecha" type="text" class="form-control" > 

										

									</div>

                                    <div class="col-md-12 col-lg-12" >

									

									<textarea id="obs" class="form-control" rows="3" placeholder="Agregar observaciones..." maxlength="300"></textarea>



							</div>

							</div>


					        </div>

                         </div>
                         <div class="col-lg-2" style="text-align: center;">
                             <div class="row">
                                 <div class="mb-3">
                                    <h4 style="font-weight: bold; margin-bottom: 10px;"><a href="javascript:verDetalles()" style="font-size: 11px;">(ver detalles)</a><a href="javascript:cerrarDetalles()" id="cerrar" style="display: none;"><i class="fa fa-close" style="color:red; font-weight: bold;"></i></a></h4>

                                    <p style="color: green; display: ; font-size: 17px;" id="tsubtotal"></p>

                                    <p style="color: red; display: none;" id="tdescuento"></p>

                                    <p style="color: darkblue; display: none;" id="tiva"></p>

                                    <h3 style="color:darkgreen; font-weight: bold;" id="tneto"></h3>

                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="card-body">
                     <div class="row">
                         <div class="col-lg-12">
                             <div class="card">
                                 <div class="card-body">

                                     <table id="my-table" class="table table-striped w-100 nowrap">
                                         <thead style="background-color: #505050;">
                                         <tr>

                                            <th style="font-weight: bold; min-width: 30px; text-align: center; color : white;"></th>

                                            <th style="font-weight: bold; min-width: 30px; text-align: center; color : white;">No.</th>

                                            <th style="font-weight: bold; min-width: 40px; text-align: center; color : white;">Cant</th>

                                            <th style="font-weight: bold; min-width: 70px; text-align: center; color : white;">Clave</th>

                                            <th style="font-weight: bold; min-width: 400px; color : white;">Descripcion</th>

                                            <th style="font-weight: bold; min-width: 40px; text-align: center; color : white;">UM</th>

                                            <th style="font-weight: bold; min-width: 70px; text-align: center; color : white;">Precio</th>

                                            <th style="font-weight: bold; min-width: 50px; text-align: center; color : white;">Iva(%)</th>

                                            <th style="font-weight: bold; min-width: 50px; text-align: center; color : white;">Des(%).</th>

                                            <th style="font-weight: bold; min-width: 50px; text-align: center; color : white;">Utl(%).</th>

                                            <th style="font-weight: bold; min-width: 50px; text-align: center; color : white;">Tc.</th>

                                            <th style="font-weight: bold; min-width: 80px; text-align: center; color : white;">Subtotal</th>



</tr>
                                         </thead>
                                         
                                     </table>

                                 </div> <!-- end card body-->
                             </div> <!-- end card -->
                         </div><!-- end col-->
                     </div>
                 </div>
             </div>