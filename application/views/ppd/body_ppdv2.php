<div class="row">

    <div class="col-md-10 col-lg-10">

        <div class="row">
        
            <div class="col-md-9 col-lg-9">
            
                <div class="input-group"> 

                    <span class="input-group-addon"><i class="fa fa-user"></i></span> 
                    <select  name="cliente" id="cliente" class="form-control select2-placeholer" placeholder="seleccionar cliente p/cotizacion..." tabindex="1" autofocus="true"  style="font-size: 12px;" onchange="showPpd(this.value)"></select>
                    <span class="input-group-btn"><button class="btn btn-success" type="button" onclick="window.open('<?php echo base_url() ?>AltaCliente/altaCliente/0','_blank')" tabindex="-1"><i class="fa fa-plus-square"></i></button></span>

                </div>
                
            </div>

            <div class="col-md-3 col-lg-3">
                
                <button class="btn btn-success" onclick="verFormulario()" >+Agregar</button>

            </div>

        </div>

        <div class="row">
            
            <div class="col-md-3 col-lg-3" style="margin-top: 10px;">

                <label>Concepto</label>
                <select class="form-control" id="fpago" tabindex="2"></select>

            </div>

            <div class="col-md-2 col-lg-2" style="margin-top: 10px;">

                <label>#Operacion</label>
                <input type="text" name="noperacion" id="noperacion" class="form-control" tabindex="3">

            </div>

            <div class="col-md-3 col-lg-3" style="margin-top: 10px;">

                <label>Fecha</label>
                <input type="date" name="fecha" id="fecha" class="form-control" tabindex="4">

            </div>

            <div class="col-md-3 col-lg-3" style="margin-top: 10px;">

                <label>RFC</label>
                <input type="text" name="rfc" id="rfc" class="form-control" tabindex="5">

            </div>

        </div>

        <div class="row">
            
            <div class="col-md-3 col-lg-3" style="margin-top: 10px;">

                <label>Banco</label>
                <input type="text" name="banco" id="banco" class="form-control" tabindex="6">

            </div>

            <div class="col-md-2 col-lg-2" style="margin-top: 10px;">

                <label>Cuenta</label>
                <input type="text" name="cuenta" id="cuenta" class="form-control" tabindex="7">

            </div>

            <div class="col-md-3 col-lg-3" style="margin-top: 10px;">

                <label>Moneda</label>
                <input type="text" name="moneda" id="moneda" class="form-control" value="PESOS" disabled>

            </div>

            <div class="col-md-3 col-lg-3" style="margin-top: 10px;">

                <label>RFC banco beneficiario</label>
                <input type="text" name="brfc" id="brfc" class="form-control" tabindex="9" value="BBA940707IE1">

            </div>

        </div>

        <div class="row">

            <div class="col-md-2 col-lg-2" style="margin-top: 10px;">

                <label>Cuenta beneficiario</label>
                <input type="text" name="bcuenta" id="bcuenta" class="form-control" tabindex="10" value="030180900007074540">

            </div>

                                <div class="col-md-8 col-lg-8" style="margin-top: 10px;"> 
                                    <!-- ADJUNTAR FIANZA-->

                                
                                    <span class="btn btn-labeled btn-primary fileinput-button">

                                            <i class="btn-label icon fa fa-paperclip"></i>

                                            <span>Adjuntar comprobante</span>

                                            <input id="fileupload_pdf"  accept=".pdf,.jpg,.png,.jpeg" type="file" name="files[]" multiple>

                                    </span>

                                    <div id="progress_bar_factpdf" class="progress">

                                        <div class="progress-bar progress-bar-primary"></div>

                                    </div>

                                </div>

                                <div class="col-md-2 col-lg-2" style="margin-top: 10px;">
                                    
                                    <div id="files_cfactpdf" class="files" style="margin-bottom: 10px;">*Sin adjunto</div>

                                    <input type="text" name="name_factpdf" id="name_factpdf" class="form-control" disabled>

                                </div>


        </div>

    </div>

    <!-- ******** IMPORTE PPD *********** -->

    <div class="col-md-2 col-lg-2">

        <h2 style="margin-top: 10px;">Total:</h2>

        <p style="font-weight: bold; font-size: 23px; color:green;" id="tneto"></p>

    </div>

</div>

<div class="row" style="margin-top: 20px; ">

                                                        <div class="table-responsive">

                                                            <table class="table table-striped table-bordered table-hover" id="my-table" >


                                                                <thead class="bg-thinkweb-table" style="background-color: gray; color: white;">
                                                                    
                                                                    <tr>
                                                                        <th style="font-weight: bold; min-width: 60px; text-align: center;">Fecha</th>
                                                                        <th style="font-weight: bold; min-width: 85px; text-align: center;">Folio</th>
                                                                        <th style="font-weight: bold; min-width: 90px; text-align: right;">Total</th>
                                                                        <th style="font-weight: bold; min-width: 80px; text-align: center;">No.Parc.</th>
                                                                        <th style="font-weight: bold; min-width: 90px; text-align: right;">T.Cobrado</th>
                                                                        <th style="font-weight: bold; min-width: 90px; text-align: right;">X pagar</th>
                                                                        <th style="font-weight: bold; min-width: 90px; text-align: right;">Abono</th>

                                                                        <th style="font-weight: bold; min-width: 90px; text-align: right;">Saldo posterior</th>
                                                                        
                                                                        
                                                                    </tr>
                                                                </thead>
                                                                                    
                                                            </table>
                                                        </div>

</div>