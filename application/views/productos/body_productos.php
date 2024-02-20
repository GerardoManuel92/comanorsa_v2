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
                        <h4 class="page-title">Productos</h4>
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
                                <div class="col-md-6 col-lg-3 col-xs-12">

                                    <div class="mb-3">

                                        <label>Categoria</label>

                                        <select name="bcategoria" id="bcategoria" class="select2-placeholer form-control" tabindex="1" onchange="validaCombo(); showInfoCategoria();"></select>

                                    </div>

                                </div>
                                <div class="col-md-6 col-lg-3 col-xs-12">

                                    <div class="mb-3">

                                        <label>Marca</label>

                                        <select name="bmarca" id="bmarca" class="select2-placeholer form-control" tabindex="2" onload="showInfoCategoria();" onchange="validaCombo(); showInfoCategoria();" data-placeholder="Todas..."></select>

                                    </div>

                                </div>
                                <div class="col-md-3 col-lg-3">

                                    <button type="button" class="btn btn-warning" onclick="reestablecer();" style="margin-top: 22px;"><i class="ri-restart-line"></i>&nbsp; Reestablecer</button>

                                    <button type="button" class="btn btn-success" onclick="showexcel();" style="margin-top: 22px;"><i class="ri-file-excel-2-fill"></i>&nbsp; Excel</button>

                                </div>
                                <div class="col-md-3 col-lg-3">

                                    <button type="button" class="btn btn-info" style="margin-top: 22px;"><i class="ri-add-fill"></i>&nbsp; Nuevo producto</button>

                                    

                                </div>
                            </div>
                            <hr>
                            <div class="row">

                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table id="my-table" class="table table-striped nowrap row-border order-column w-100">
                                                    <style>
                                                        @media (min-width: 768px) {
                                                            #my-table_filter {
                                                                margin-left: 0px;
                                                                width: 20%;
                                                                margin-top: 20px;
                                                            }

                                                            #my-table_paginate {
                                                                margin-left: 500px;
                                                                width: 40%;
                                                                margin-top: -35px;
                                                            }

                                                            #my-table_length {
                                                                margin-left: 0;
                                                                width: 40%;
                                                                margin-top: 20px;
                                                            }

                                                            #my-table_info {
                                                                margin-left: 300px;
                                                                width: 40%;
                                                                margin-top: -45px;
                                                            }
                                                        }
                                                    </style>
                                                    <thead style="background-color: #505050;">
                                                        <tr>

                                                            <th style="font-weight: bold; min-width: 30px; text-align: center; color : white;">Acciones</th>

                                                            <th style="font-weight: bold; min-width: 30px; text-align: center; color : white;">Imágen</th>

                                                            <th style="font-weight: bold; min-width: 40px; text-align: center; color : white;">No. Parte</th>

                                                            <th style="font-weight: bold; min-width: 70px; text-align: center; color : white;">Descripción</th>

                                                            <th style="font-weight: bold; min-width: 40px; color : white;">Unidad</th>

                                                            <th style="font-weight: bold; min-width: 40px; text-align: center; color : white;">Marca</th>

                                                            <th style="font-weight: bold; min-width: 70px; text-align: center; color : white;">Categoría</th>

                                                            <th style="font-weight: bold; min-width: 50px; text-align: center; color : white;">Costo</th>

                                                            <th style="font-weight: bold; min-width: 50px; text-align: center; color : white;">IVA</th>



                                                        </tr>
                                                    </thead>

                                                </table>
                                            </div>
                                        </div> <!-- end card body-->
                                    </div> <!-- end card -->
                                </div><!-- end col-->
                            </div>

                        </div>



                    </div>

                </div>
            </div>

        </div>