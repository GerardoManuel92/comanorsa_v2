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
                         <h4 class="page-title">Alta cliente</h4>
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
                         <div class="col-lg-12">
                             <!-- <h4 class="header-title">Floating labels</h4> -->
                             <div class="row">
                                 <div class="col-md-4 col-lg-4 col-xs-12">
                                     <div class="mb-3">
                                         <label for="">*Nombre fiscal</label>
                                         <input type="text" name="nfiscal" id="nfiscal" class="form-control" autofocus placeholder="nombre fiscal..." tabindex="1">
                                     </div>
                                 </div>

                                 <div class="col-md-5 col-lg-5 col-xs-12">
                                     <div class="mb-3">
                                         <label>Nombre comercial</label>
                                         <input type="text" name="ncomercial" id="ncomercial" class="form-control" placeholder="nombre comercial..." tabindex="2">
                                     </div>
                                 </div>
                                 <div class="col-lg-3 col-md-3 col-xs-12">
                                     <div class="mb-3">
                                         <label id="txtrfc">*RFC</label>
                                         <input type="text" name="rfc" id="rfc" class="form-control" onblur="vRfc(this.value)" placeholder="RFC SAT..." tabindex="3">
                                     </div>
                                 </div>
                             </div>
                             <hr>
                             <div class="row">
                                 <div class="col-lg-3 col-md-3 col-xs-12">
                                     <div class="mb-3">
                                         <label>Contacto</label>
                                         <input type="text" name="contacto" id="contacto" class="form-control" placeholder="contacto proveedor..." tabindex="4">
                                     </div>
                                 </div>
                                 <div class="col-lg-2 col-md-2 col-xs-12">
                                     <div class="mb-3">
                                         <label>Departamento</label>
                                         <input type="text" name="depa" id="depa" class="form-control" placeholder="departamento proveedor..." tabindex="5">
                                     </div>
                                 </div>
                                 <div class="col-lg-2 col-md-2 col-xs-12">
                                     <div class="mb-3">
                                         <label>Telefono</label>
                                         <input type="text" name="telefono" id="telefono" class="form-control" placeholder="telefono proveedor..." tabindex="6">
                                     </div>
                                 </div>
                                 <div class="col-lg-2 col-md-2 col-xs-12">
                                     <div class="mb-3">
                                         <label>Correo</label>
                                         <input type="text" name="correo" id="correo" class="form-control" placeholder="correo..." tabindex="7">
                                     </div>
                                 </div>
                                 <div class="col-lg-2 col-md-2 col-xs-12">
                                     <div class="mb-3">
                                         <label>Acciones</label>
                                         <button class="btn btn-success" onclick="sumarContacto()" id="btnanadir" tabindex="8">Añadir contacto</button>
                                     </div>
                                 </div>
                             </div>
                             <div class="row">
                                 <div class="col-md-12">

                                     <h3>Lista de contactos</h3>

                                 </div>

                                 <div class="cards-container box-view" id="lista_contacto"> </div>
                             </div>
                             <hr>
                             <div class="row">
                                 <div class="col-md-12">

                                     <div class="mb-3">

                                         <h3>Dirección cliente</h3>

                                     </div>

                                 </div>

                                 <div class="col-md-4 col-lg-4 col-xs-12">

                                     <div class="mb-3">

                                         <label>Calle</label>

                                         <input type="text" name="calle" id="calle" class="form-control" placeholder="calle cliente..." tabindex="8">

                                     </div>

                                 </div>

                                 <div class="col-md-2 col-lg-2 col-xs-12">

                                     <div class="mb-3">

                                         <label>No.Exterior</label>

                                         <input type="text" name="ext" id="ext" class="form-control" placeholder="#exterior cliente..." tabindex="9">

                                     </div>

                                 </div>

                                 <div class="col-md-2 col-lg-2 col-xs-12">

                                     <div class="mb-3">

                                         <label>No.Interior</label>

                                         <input type="text" name="int" id="int" class="form-control" placeholder="#interior cliente..." tabindex="10">

                                     </div>

                                 </div>

                                 <div class="col-md-4 col-lg-4 col-xs-12">

                                     <div class="mb-3">

                                         <label>Colonia</label>

                                         <input type="text" name="colonia" id="colonia" class="form-control" placeholder="colonia cliente..." tabindex="11">

                                     </div>

                                 </div>
                             </div>
                             <hr>
                             <div class="row">



                                 <div class="col-md-3 col-lg-3 col-xs-12">

                                     <div class="mb-3">

                                         <label>Municipio</label>

                                         <input type="text" name="municipio" id="municipio" class="form-control" placeholder="municipio cliente..." tabindex="12">

                                     </div>

                                 </div>



                                 <div class="col-md-3 col-lg-3 col-xs-12">

                                     <div class="mb-3">

                                         <label>Estado</label>

                                         <input type="text" name="estado" id="estado" class="form-control" placeholder="estado cliente..." tabindex="13">

                                     </div>

                                 </div>



                                 <div class="col-md-2 col-lg-2 col-xs-12">

                                     <div class="mb-3">

                                         <label>C.P.</label>

                                         <input type="text" name="cp" id="cp" class="form-control" placeholder="codigo postal..." tabindex="14">

                                     </div>

                                 </div>

                                 <div class="col-md-4 col-lg-4 col-xs-12">
                                     <div class="mb-3">

                                         <label>Referencia</label>

                                         <input type="text" name="ref" id="ref" class="form-control" placeholder="referencia ubicacion..." tabindex="15">
                                     </div>
                                 </div>
                             </div>


                             <div class="row" style="margin-top: 20px;">

                                 <div class="col-md-12">

                                     <div class="mb-3">

                                         <h3>Lista de direcciones:</h3>

                                     </div>

                                 </div>



                                 <div class="cards-container box-view" id="lista_direccion">



                                 </div>



                             </div>



                             <hr>



                             <div class="row">

                                 <div class="col-md-12">

                                     <div class="mb-3">

                                         <h3>Datos comerciales</h3>

                                     </div>

                                 </div>



                                 <div class="col-md-3 col-lg-3 col-xs-12">

                                     <div class="mb-3">

                                         <label>Descuento(%)</label>

                                         <input type="number" style="text-align: right;" value="0" name="descuento" id="descuento" class="form-control" placeholder="descuento a cliente..." tabindex="17">

                                     </div>

                                 </div>



                                 <div class="col-md-3 col-lg-3 col-xs-12">

                                     <div class="mb-3">

                                         <label>Dias credito</label>

                                         <input type="number" style="text-align: right;" value="0" name="dias" id="dias" class="form-control" placeholder="dias de credito..." tabindex="18">

                                     </div>

                                 </div>



                                 <div class="col-md-4 col-lg-4 col-xs-12">

                                     <div class="mb-3">

                                         <label>Limite de credito</label>

                                         <input type="number" style="text-align: right;" value="0" name="limite" id="limite" class="form-control" placeholder="limite de credito..." tabindex="19">

                                     </div>

                                 </div>

                             </div>

                             <hr>

                             <div class="row">


                                 <div class="col-md-12">

                                     <div class="mb-3">

                                         <h3>Datos fiscales</h3>

                                     </div>

                                 </div>



                                 <div class="col-md-6 col-lg-6 col-xs-12">

                                     <div class="mb-3">

                                         <label>Forma de pago(<strong>SAT</strong>)</label>

                                         <select name="fpago" id="fpago" class="select2-placeholer form-control" tabindex="20"></select>

                                     </div>

                                 </div>



                                 <div class="col-md-6 col-lg-6 col-xs-12">

                                     <div class="mb-3">

                                         <label>Uso de CFDI(<strong>SAT</strong>)</label>

                                         <select name="cfdi" id="cfdi" class="select2-placeholer form-control" tabindex="21"></select>

                                     </div>

                                 </div>



                                 <div class="col-md-12 col-lg-12 col-xs-12" style="margin-top: 10px;">

                                     <div class="mb-3">

                                         <label>Regimen fiscal(<strong>SAT</strong>)</label>

                                         <select name="regimen" id="regimen" class="select2-placeholer form-control" tabindex="22"></select>

                                     </div>

                                 </div>

                             </div>

                             <div class="row" style="margin-top: 15px; ">



                                 <button class="btn btn-success btn-rounded btn-block" id="btn_finalizar" tabindex="26" onclick="altaCli()"><i class="ri-arrow-right-line"></i> Ingresar cliente</button>



                             </div>


                         </div>

                     </div>
                 </div>

             </div>