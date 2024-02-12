<style>
    #modalSubmenus {
        max-height: 95%;
        overflow-y: auto; /* Habilitar el scroll vertical si es necesario */
    }

    .modal-body {
        max-height: calc(95% - 120px); /* Ajustar según la altura de la cabecera y el pie de página */
        overflow-y: auto; /* Habilitar el scroll vertical si es necesario */
    }

    /* Restringe el tamaño del modal en pantallas pequeñas */
    @media (max-width: 768px) {
        #modalSubmenus {
            max-height: 80%;
        }

        .modal-body {
            max-height: calc(80% - 120px);
        }
    }
</style>

<div class="modal fade bd-example-modal-lg" id="modalSubmenus" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">

    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header" style="background-color: #2f4a94;">

                <h4 class="modal-title" id="titulo_modal" style="color : white; font-weight: bold;">Editar menus departamento <span id="iddept" hidden></span></h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                    <span aria-hidden="true" style="color:white;">&times;</span>

                </button>

            </div>

            <div class="modal-body">


                <div class="row" style="margin: auto;">

                    <div class="col-md-4 col-lg-4">

                        <label for="">Departamento</label>
                        <!-- <input class="form-control" type="text" name="iddept" id="iddept" style="visibility: hidden;"> -->
                        <input class="form-control" type="text" name="nombre_depax" id="nombre_depax" disabled>
                        <!-- <span id="nombre_depax"></span> -->

                    </div>

                    <div class="col-md-4 col-lg-4">

                        <label for="">Menu</label>
                        <select class="form-control" name="menu_modal" id="menu_modal2" onchange="mostrarSubmenus();">

                        </select>

                    </div>

                    <div class="col-md-3 col-lg-3">
                        <label for="">Submenu</label>
                        <div class="input-group">

                            <select class="custom-select form-control" id="submenu_modal2" style="width: 250px;">

                            </select>

                            <div class="input-group-append">
                                <button class="btn btn-info" type="button" onclick="AgregaNvoSubmenu();"><i class="fa fa-plus" aria-hidden="true"></i></button>
                            </div>
                        </div>

                    </div>

                </div>

                <br><br>

                <div class="row" style="margin: auto;">

                    <div class="col-md-12 col-lg-12" style="max-height: 100%;">



                        <div class="table-responsive" style="max-height: 400px;">



                            <table class="table table-dark" id="submenusTable">




                                <thead class="bg-thinkweb-table" style="background-color: gray; color: white;">



                                    <tr>



                                        <th style="font-weight: bold; min-width: 50px; text-align: center;">Acciones</th>

                                        <th style="font-weight: bold; min-width: 250px; text-align: center;">Departamento</th>                                        

                                        <th style="font-weight: bold; min-width: 250px; text-align: center;">Menu</th>

                                        <th style="font-weight: bold; min-width: 250px; text-align: center;">Submenu</th>


                                    </tr>

                                </thead>

                                <tbody>



                                </tbody>

                            </table>

                        </div>





                    </div>

                </div>

                <div class="modal-footer">

                    

                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="cerrar_modaly">Cerrar</button>

                </div>


            </div>



        </div>

    </div>

</div>