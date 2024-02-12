<div id="modalDepartamentos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-success">

                <h4 class="modal-title" id="titulo_modal" style="color : white; font-weight: bold;">Crear nuevo departamento<!--  <p id="iduser" hidden><?php echo $iduser; ?> --></p>
                </h4>

                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close">

                    <!-- <span aria-hidden="true" style="color:white;">&times;</span> -->

                </button>


            </div>

            <div class="modal-body">


                <div class="row" style="margin: auto;">

                    <div class="col-md-4 col-lg-4">

                        <label for="">Departamento</label>
                        <input class="form-control" type="text" name="txtdepartamento" id="txtdepartamento" oninput="convertirAMayusculas();">

                    </div>

                    <div class="col-md-4 col-lg-4">

                        <label for="">Menu</label>
                        <select class="form-control" name="menu_modal" id="menu_modal" onchange="mostrarSubmenus();">

                        </select>

                    </div>

                    <div class="col-md-3 col-lg-3">
                        <label for="">Submenu</label>
                        <div class="input-group">

                            <select class="custom-select form-control" id="submenu_modal" style="width: 250px;">

                            </select>

                            <div class="input-group-append">
                                <button class="btn btn-info" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            </div>
                        </div>

                    </div>

                </div>

                <br><br>

                <div class="row" style="margin: auto;">

                    <div class="col-md-12 col-lg-12">



                        <div class="table-responsive">



                            <table class="table table-striped table-bordered table-hover" id="my-table" charset="UTF-8">




                                <thead class="bg-thinkweb-table" style="background-color: gray; color: white;">



                                    <tr>



                                        <th style="font-weight: bold; min-width: 50px; text-align: center;">Acciones</th>



                                        <th style="font-weight: bold; min-width: 250px; text-align: left;">Menu</th>

                                        <th style="font-weight: bold; min-width: 250px; text-align: left;">Submenu</th>


                                    </tr>

                                </thead>

                                <tbody>



                                </tbody>



                            </table>

                        </div>





                    </div>

                </div>

                <div class="modal-footer">

                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success"><i class="ri-save-fill"></i>&nbsp; Guardar</button>

                    <!-- <button type="button" class="btn btn-success"><i class="fa fa-floppy-o" aria-hidden="true"></i>&nbsp; Guardar</button>

                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar_modalx">Cerrar</button> -->

                </div>


            </div>



        </div>

    </div>

</div>