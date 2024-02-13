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
                        <h4 class="page-title">Alta usuarios</h4>
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
                                <div class="col-md-4 col-lg-3 col-xs-12">
                                    <div class="mb-3">
                                        <label>*Nombre</label>
                                        <input type="text" name="nombre" id="nombre" class="form-control" autofocus placeholder="Nombre completo..." tabindex="1" oninput="convertirAMayusculas();">
                                    </div>
                                </div>

                                <div class="col-md-4 col-lg-3 col-xs-12">
                                    <div class="mb-3">
                                        <label>Correo</label>
                                        <input type="email" name="correo" id="correo" class="form-control" autofocus placeholder="Correo electrónico" tabindex="2">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-12">
                                    <div class="mb-3">
                                        <label>Telefono</label>
                                        <input type="tel" name="telefono" id="telefono" class="form-control" autofocus placeholder="Número telefónico" tabindex="3">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-12">
                                    <div class="mb-3">
                                        <label>*Usuario</label>
                                        <input type="tel" name="usuario" id="usuario" class="form-control" autofocus placeholder="Usuario sistema" tabindex="4">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-xs-12">
                                    <div class="mb-3">
                                        <label>*Contraseña</label>
                                        <input type="password" name="password" id="password" class="form-control" autofocus placeholder="Contraseña sistema" tabindex="5">
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6 col-xs-12">
                                    <div class="mb-3">
                                        <label>Departamento</label>
                                        <div class="input-group flex-nowrap">
                                            <select class="form-select" id="departamento" style="width: 250px;" tabindex="6">

                                            </select>
                                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modalDepartamentos"><i class="ri-add-fill" style="font-weight: bold;"></i></button>
                                            <!-- <button class="btn btn-success" type="button" data-toggle="modal" data-target="#modalDepartamentos" tabindex="-1"><i class="ri-add-fill" style="font-weight: bold;"></i></button> -->
                                            <button class="btn btn-warning" type="button" data-bs-toggle="modal" data-bs-target="#modalSubmenus" onclick="showDepa();" id="editDepa" tabindex="-1"><i class="ri-pencil-fill" style="font-weight: bold;"></i></button>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2 col-lg-2 col-xs-12" style="display: contents;">
                                    <div class="mb-3">

                                        <button type="button" class="btn btn-success" style="margin-top: 20px;" onclick="altaUsuario();" id="btncrear"><i class="ri-user-fill" style="font-weight: bold;" tabindex="7"></i>&nbsp; Agregar</button>

                                        <button type="button" class="btn btn-warning" style="margin-top: 20px; color:black; font-weight: bold;" onclick="modificarUsuario();" id="btnedit"><i class="ri-pencil-fill" style="font-weight: bold;"></i>&nbsp; Modificar</button>

                                        <button type="button" class="btn btn-danger" style="margin-top: 20px; color:white; font-weight: bold;" onclick="limpiar();" id="btncancelar"><i class="ri-close-fill" style="font-weight: bold;"></i></i>&nbsp; Cancelar</button>
                                    </div>
                                </div>
                            </div>



                        </div>

                    </div>
                    <div class="row" style="margin-top:30px;">

                        <h3 class="panel-title" style="font-weight: bold;">Usuarios registrados: <span id="totalDivs"></span></h3>

                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-xs-12">
                                <div class="mb-3">
                                    <label>Buscar por</label>
                                    <div class="input-group flex-nowrap">
                                        <input type="text" name="busqueda" id="busqueda" class="form-control" autofocus placeholder="Nombre/Telefono/Correo/Usuario" tabindex="8">
                                        <button class="btn btn-warning" type="button" style="color: black;" onclick="showUsuarios();" tabindex="9"><i class="ri-search-2-line" style="font-weight: bold;"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-4 col-xs-12">

                                <label>Departamento</label>

                                <select class="form-select control select2-placeholer" id="buscar_departamento" style="width: 250px;" onchange="showUsuarios();" tabindex="10">

                                </select>
                            </div>

                            <div class="col-lg-4 col-md-4 col-xs-12">
                                <button class="btn btn-warning" type="button" style="color: black; margin-top:25px;" onclick="limpiarFiltros();"><i class="fa fa-refresh" aria-hidden="true"></i>&nbsp;&nbsp;REESTABLECER</button>

                            </div>
                        </div>

                        <br><br>

                        <div class="row" id="divUsuarios">



                        </div>

                    </div>

                </div>