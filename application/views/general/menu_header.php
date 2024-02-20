<!-- Main container -->
<div class="main-container">
  
  <!-- Main header -->
    <div class="main-header row">
      <div class="col-sm-6 col-xs-7 col-md-6 col-lg-6">
    
    <!-- User info -->
        <ul class="user-info pull-left">          
          <li class="profile-info dropdown"><a data-toggle="dropdown" class="dropdown-toggle" href="#" aria-expanded="false" style="color:#5384bc; font-weight: bold; font-size: 15px;"> <img width="30" class="img-circle avatar" alt="" src="<?php echo base_url()?>comanorsa/user2.png"><?php echo $this->session->userdata(NOMBRECOM); ?> <span class="caret"></span></a>
      
      <!-- User action menu -->
            <ul class="dropdown-menu">
              
              <li><a href="#/"><i class="icon-user"></i>

                <?php

                  
                  $data="nombre";
                    $tabla = "alta_departamentos";
                    $condicion = array('id' => $this->session->userdata(PUESTOCOM) );
                    $info = $this->General_Model->SelectUnafila($data,$tabla,$condicion);

                    echo $info->nombre; 


                ?>

              </a></li>
              <li><a href="mailto:<?php echo $this->session->userdata(CORREOCOM); ?>"><i class="icon-mail"></i><?php echo $this->session->userdata(CORREOCOM); ?></a></li>
              <li><a href="javascript:cerrarSesion()" style="color:red;"><i class="icon-logout"></i>Cerrar sesion</a></li>
            </ul>
      <!-- /user action menu -->
      
          </li>

          <?php 

            if ( $nommenu == "productos" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Alta productos</li>';

            }

            if ( $nommenu == "rproductos" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte de productos</li>';

            }

            if ( $nommenu == "actproductos" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Actualización de productos</li>';

            }

            if ( $nommenu == "clientes" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Alta clientes</li>';

            }

            if ( $nommenu == "rcliente" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte de clientes</li>';

            }

            if ( $nommenu == "dashboard" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Dashboard</li>';

            }

            if ( $nommenu == "act_clientes" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Actualizar cliente</li>';

            }

            if ( $nommenu == "marcas" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Alta marcas</li>';

            }

            if ( $nommenu == "bancos" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Alta Bancos</li>';

            }

            if ( $nommenu == "categoria" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Alta categorias</li>';

            }

            if ( $nommenu == "cotizacion" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Alta cotización</li>';

            }

            if ( $nommenu == "rcotizacion" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte de cotización</li>';              

            }

            if ( $nommenu == "editcotizacion" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Actualizar cotización</li>';

            }

            if ( $nommenu == "oc" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| ODC</li>';

            }

            if ( $nommenu == "asignar" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Asignar proveedor ODC</li>';

            }

            if ( $nommenu == "menuRQ" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Alta Requerimiento</li>';

            }

            if ( $nommenu == "requerimientos" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte Requerimiento</li>';

            }
            
            if ( $nommenu == "alta_occ" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Alta ODC</li>';

            }

            if ( $nommenu == "rcompras" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte compras</li>';

            }

            if ( $nommenu == "entrada" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Entradas ODC</li>';

            }

            if ( $nommenu == "entrega" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Entrega a cliente</li>';

            }

            if ( $nommenu == "cxp" ) {
              
              echo '<li style="color: #FF5733; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Cuentas por pagar(Egreso)</li>';

            }

            

            if ( $nommenu == "rremision" ) {
              
              echo '<li style="color: green; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte remisiones</li>';

            }

            if ( $nommenu == "pmvendidos" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte productos mas vendidos</li>';

            }

             if ( $nommenu == "kardex" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte Kardex</li>';

            }

            if ( $nommenu == "ncredito" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Nota de credito por devolución</li>'; 

            }

            if ( $nommenu == "ppd" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Complementos de pago</li>';

            }

            if ( $nommenu == "facturacion" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Facturar pedido</li>';

            }

            if ( $nommenu == "refacturacion" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Facturar s/timbrar</li>';

            }

            if ( $nommenu == "rcpp" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte complemento de pago</li>';

            }

            if ( $nommenu == "rcn" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte nota de credito</li>';

            }

            if ( $nommenu == "rfactura" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte de facturas</li>';

            }

            if ( $nommenu == "cxc" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Cuentas por cobrar</li>';

            }

            if ( $nommenu == "rentradas" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte de entradas</li>';

            }

            if ( $nommenu == "rentregas" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte de entregas</li>';

            }

            if ( $nommenu == "crear_factura" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Relacion de factura por cancelacion</li>';

            }

            if ( $nommenu == "nfactura" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Nueva factura</li>';

            }

            if ( $nommenu == "ncreditodesc" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Nota de credito por descuento</li>'; 

            }

            if ( $nommenu == "cxc_xcliente" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Cuentas por cobrar por cliente</li>'; 

            }

            if ( $nommenu == "ajuste_entrada" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Entrada por ajuste</li>'; 

            }

            if ( $nommenu == "Nrequerimiento" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Nuevo Requerimiento</li>'; 

            }

            if( $nommenu=="rproductoxcliente" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte de productos por cliente</li>'; 

            }

            if( $nommenu=="balance_cuentas" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Estados de cuenta</li>'; 

            }

            if( $nommenu=="cuentas_comanorsa" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Cuentas bancarias propias</li>'; 

            }

            if( $nommenu=="rentradaxajuste" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte entrada por ajuste</li>'; 

            }

            if( $nommenu=="rsalidaxajuste" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte salida por ajuste</li>'; 

            }

            if( $nommenu=="ajuste_salida" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Salida por ajuste</li>'; 

            }

            if( $nommenu=="rcotizacionxcliente" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte de cotizaciones por cliente</li>'; 

            }

            if( $nommenu=="dashproductos" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Dashboard Productos</li>'; 

            }
            if( $nommenu=="dashutilidad" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Dashboard Utilidad</li>'; 

            }
            if( $nommenu=="rpagoproveedor" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Reporte Pago a Proveedor</li>'; 

            }

            if( $nommenu=="pagoproveedor" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Pago a Proveedor</li>'; 

            }

            if( $nommenu=="rgastos" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Gastos Generales</li>'; 

            }

            if ( $nommenu == "ordenxcliente" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Orden por Cliente</li>';

            }   
            
            if ( $nommenu == "usuarios" ) {
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Gestión de usuarios y departamentos</li>';

            }

            if ( $nommenu == "nuevo_requerimiento" ) {
              
              
              echo '<li style="color: #5384bc; margin-top: 7px; margin-left: 10px; font-size: 17px; font-weight: bold;">| Nuevo Requerimiento</li>';

            }
            


          ?>

         
           



        </ul>
    <!-- /user info -->
    
      </div>

      <script src="<?php echo base_url(); ?>tw/js/generarSitemap.js"></script>

      <script type="text/javascript">	

	      var base_urlx = "<?php echo base_url(); ?>";	

      </script>

      <div class="col-sm-6 col-xs-5 col-md-6 col-lg-6" style="display: flex; justify-content: center; font-weight: bold;">

        <a href="<?php echo base_url(); ?>tw/js/visualizarSitemap.js" target="_blank" style="margin-top: 10px;">Ver mapa de sitio</a>

      </div>
    
      <div class="col-sm-6 col-xs-5">
      <div class="pull-right">

        

        <!-- User alerts -->
        <ul class="user-info pull-left">

           <?php 

            if ( $nommenu == "cotizacion" ) {
              
               echo '<li><button class="btn btn-warning btn-rounded btn-block" id="btn_finalizar" onclick="finalizarCotizacion(0)" style="color:black;"><i class="icon-check" ></i style="color:black;"> Finalizar</button></li>

                <li><button class="btn btn-success btn-rounded btn-block" id="btn_finalizar2" data-toggle="modal" data-target="#modal_pedido" style="color:white;"><i class="icon-check" ></i style="color:white;"> Adjuntar evidencia</button></li>

                <li><button class="btn btn-red btn-rounded btn-block" id="btn_cancelar" onclick="cancelarCotizacion()"><i class="icon-cancel"></i> cancelar</button></li>
                
                  <li><a href="javascript:recargar()"><i class="icon-arrows-ccw" title="Recargar" style="color:#5384bc;"></i></a></li>';

            }

            if ( $nommenu == "act_clientes" ) {
              
              echo '<li><button class="btn btn-red btn-rounded btn-block" id="btn_cancelar" onclick="cancelarActcliente()"><i class="icon-cancel"></i> cancelar</button></li>';

            }



            if ( $nommenu == "nuevo_requerimiento" ) {
              
              
               echo '<li><button class="btn btn-success btn-rounded btn-block" id="btn_finalizar" onclick="finalizarEntrada()" ><i class="icon-check" ></i style="color:white;"> Finalizar RQ</button></li>';

                      

            }


            if ( $nommenu == "oc" ) {
              
               echo '<li><button class="btn btn-warning btn-rounded btn-block" id="btn_finalizar" onclick="finalizarOc()" style="color:black;"><i class="icon-check" ></i style="color:black;"> Finalizar</button></li>
                      <li><button class="btn btn-red btn-rounded btn-block" id="btn_cancelar" onclick="cancelarOC()"><i class="icon-cancel"></i> cancelar</button></li>
                
                  <li><a href="javascript:recargar()"><i class="icon-arrows-ccw" title="Recargar" style="color:#5384bc;"></i></a></li>';

            }

            if ( $nommenu == "editcotizacion" ) {

                if ( $idestatus == 0 ) {
                  
                  echo '

                    <li><button class="btn btn-secondary btn-rounded btn-block" id="btn_nfolio" onclick="newCotizacion()"><i class="icon-star" ></i style="color:black;"> Nuevo folio</button></li>

                    <li><button class="btn btn-primary btn-rounded btn-block" id="btn_finalizaract" onclick="actCotizacion(0)"><i class="icon-arrows-ccw" ></i style="color:black;"> Actualizar</button></li>

                    <li><button class="btn btn-success btn-rounded btn-block" data-toggle="modal" data-target="#modal_pedido" style="color:white;"><i class="icon-check" ></i style="color:white;"> Actualizar y Adjuntar evidencia</button></li>


                    
                    <!--<li><button class="btn btn-warning btn-rounded btn-block" id="btn_finalizarrem" onclick="remCotizacion()" style="color:black;"><i class="icon-doc-text" ></i style="color:black;"> REMISIONAR</button></li>-->

                      <li><button class="btn btn-red btn-rounded btn-block" id="btn_cancelar" onclick="cancelarOC()" title="Cancelar actualizacion"><i class="icon-cancel"></i></button></li>


                  
                    <li><a href="javascript:recargar()"><i class="icon-arrows-ccw" title="Recargar" style="color:#5384bc;"></i></a></li>';

                } else if ( $idestatus == 4 ) {
                  
                  echo '

                    <li><button class="btn btn-secondary btn-rounded btn-block" id="btn_nfolio" onclick="newCotizacion()"><i class="icon-star" ></i style="color:black;"> Nuevo folio</button></li>

                    
                    <li><button class="btn btn-warning btn-rounded btn-block" id="btn_finalizarrem" onclick="remCotizacion()" style="color:black;"><i class="icon-doc-text" ></i style="color:black;"> REMISIONAR</button></li>

                      <li><button class="btn btn-red btn-rounded btn-block" id="btn_cancelar" onclick="cancelarOC()" title="Cancelar actualizacion"><i class="icon-cancel"></i></button></li>


                  
                    <li><a href="javascript:recargar()"><i class="icon-arrows-ccw" title="Recargar" style="color:#5384bc;"></i></a></li>';

                }else{

                  echo '

                    <li><button class="btn btn-secondary btn-rounded btn-block" id="btn_nfolio" onclick="newCotizacion()"><i class="icon-star" ></i style="color:black;"> Nuevo folio</button></li>

                      <li><button class="btn btn-red btn-rounded btn-block" id="btn_cancelar" onclick="cancelarOC()" title="Cancelar actualizacion"><i class="icon-cancel"></i></button></li>

                    <li><a href="javascript:recargar()"><i class="icon-arrows-ccw" title="Recargar" style="color:#5384bc;"></i></a></li>';

                }
              
                

            }

            if ( $nommenu == "asignar" ) {
              
               echo '<li><button class="btn btn-warning btn-rounded btn-block" id="btn_odc" data-toggle="modal" data-target="#exampleModal" style="color:black; display:none;"><i class="icon-bag" style="color:black;"></i> Alta ODC</button></li>';

            }

            

            if ( $nommenu == "entrada" ) {
              
               echo '<li><button class="btn btn-warning btn-rounded btn-block" id="btn_parcial" onclick="entradaParcial()" style="color:black;"><i class="fa fa-file-code-o" style="color:black;"></i> Realizar Entrada</button></li>';

                    //<li><button class="btn btn-success btn-rounded btn-block" id="btn_all" onclick="entradaAll()"><i class="icon-check"></i> Entrada completa</button></li>

            }

            if ( $nommenu == "entrega" ) {
              
               echo '<li><button class="btn btn-warning btn-rounded btn-block" id="btn_entrega" data-toggle="modal" data-target="#exampleModal" style="color:black;"><i class="icon-star" style="color:black;"></i> Alta entrega</button></li>';

            }

            if ( $nommenu == "ncredito" ) {

              echo '<li><button class="btn btn-success btn-rounded btn-block" id="btn_nfolio" data-toggle="modal" data-target="#modalnota" ><i class="icon-check" ></i style="color:white;"> Finalizar</button></li>

                      <li><button class="btn btn-red btn-rounded btn-block" id="btn_cancelar" onclick="cancelarNota()" title="Cancelar"><i class="icon-cancel"></i></button></li>';

            }

            if ( $nommenu == "ppd" ) {

              echo '<li><button class="btn btn-success btn-rounded btn-block" id="btn_finalizar" onclick="timbrarPago()" ><i class="icon-check" ></i style="color:white;"> Generar complemento</button></li>';

            }

            if ( $nommenu == "facturacion" ) {
              
              echo '



                    <li><button class="btn btn-success btn-rounded btn-block" id="btn_finalizarfact" onclick="simularFactura()"><i class="icon-eye" ></i style="color:black;"> Simular factura</button></li>

                  
                    <li><a href="javascript:recargar()"><i class="icon-arrows-ccw" title="Recargar" style="color:#5384bc;"></i></a></li>';

            }

            if ( $nommenu == "refacturacion" ) {
              
              echo '<li><button class="btn btn-success btn-rounded btn-block" id="btn_finalizarfact" data-toggle="modal" data-target="#modal-1"><i class="icon-bell" ></i style="color:black;"> Facturar</button></li>';

            }

            if ( $nommenu == "crear_factura" ) {
              
              echo '<li><button class="btn btn-success btn-rounded btn-block" id="btn_finalizarfact" data-toggle="modal" data-target="#modal-1"><i class="icon-bell" ></i style="color:black;"> Facturar</button></li>';

            }

            if ( $nommenu == "nfactura" ) {
              
              echo '<li><button class="btn btn-success btn-rounded btn-block" id="btn_finalizarfact" data-toggle="modal" data-target="#modal-1"><i class="icon-bell" ></i style="color:black;"> Facturar</button></li>';

            }

            if ( $nommenu == "ncreditodesc" ) {

              echo '<li><button class="btn btn-success btn-rounded btn-block" id="btn_finalizar" onclick="generarNota()" ><i class="icon-check" ></i style="color:white;"> Generar nota</button></li>

                      <li><button class="btn btn-red btn-rounded btn-block" id="btn_cancelar" onclick="cancelarNota()" title="Cancelar"><i class="icon-cancel"></i></button></li>';

            }

            
            if ( $nommenu == "ajuste_entrada" ) {

              echo '<li><button class="btn btn-success btn-rounded btn-block" id="btn_finalizar" onclick="finalizarEntrada()" ><i class="icon-check" ></i style="color:white;"> Finalizar ajuste</button></li>

                      <li><button class="btn btn-red btn-rounded btn-block" id="btn_cancelar" onclick="cancelarAjuste()" title="Cancelar"><i class="icon-cancel"></i></button></li>';

            }

            if ( $nommenu == "Nrequerimiento" ) {

              echo '<li><button class="btn btn-success btn-rounded btn-block" id="btn_finalizar" onclick="finalizarEntrada()" ><i class="icon-check" ></i style="color:white;"> Finalizar requerimiento</button></li>
                      
                      <li><button class="btn btn-warning btn-rounded btn-block" id="btn_loadMaxMin" onclick="loadMaxMin()" style="color:black;"> Cargar Max. Min.</button></li>
                      <li><button class="btn btn-red btn-rounded btn-block" id="btn_cancelar" onclick="cancelarRQ()" title="Cancelar"><i class="icon-cancel"></i></button></li>';

            }

            if ( $nommenu == "ajuste_salida" ) {

              echo '<li><button class="btn btn-success btn-rounded btn-block" id="btn_finalizar" onclick="finalizarEntrada()" ><i class="icon-check" ></i style="color:white;"> Finalizar ajuste</button></li>

                      <li><button class="btn btn-red btn-rounded btn-block" id="btn_cancelar" onclick="cancelarAjuste()" title="Cancelar"><i class="icon-cancel"></i></button></li>';

            }


            if ($nommenu=="balance_cuentas") {
              
              echo '<li><button class="btn btn-success btn-rounded btn-block" id="btn_act" data-toggle="modal" data-target="#modal_act"> <i class="fa fa-upload"></i> ACTUALIZAR ESTADO DE CUENTA</button></li>';

            }

            if( $nommenu=="rpagoproveedor" ) {
              
              echo '<li><button class="btn btn-success btn-rounded btn-block" id="btnBajarExcel" onclick="downLoadExcel();"> <i class="fa fa-download"></i> DESCARGAR EXCEL</button></li>';
              echo '<li><button class="btn btn-success btn-rounded btn-block" id="btn_act" data-toggle="modal" data-target="#modal_act"> <i class="fa fa-upload"></i> CARGAR FACTURAS</button></li>';

            }


            if( $nommenu=="pagoproveedor" ) {
              
              echo '<li><button class="btn btn-success btn-rounded btn-block" id="btn_act" data-toggle="modal" data-target="#modal_act"> <i class="fa fa-upload"></i> ACTUALIZAR ESTADO DE CUENTA</button></li>';

            }

            if ( $nommenu == "ordenxcliente" ) {
                            
              echo '<li><button class="btn btn-warning btn-rounded btn-block" id="btn_odc" data-toggle="modal" data-target="#exampleModal" style="color:black;"><i class="icon-bag" style="color:black;"></i> Asignar OC</button></li>';

            }

            if ( $nommenu == "alta_occ" ) {
                            
              echo '<li><button class="btn btn-warning btn-rounded btn-block" id="btn_odc" data-toggle="modal" data-target="#exampleModal" style="color:black;"><i class="icon-bag" style="color:black;"></i> Crear OC</button></li>';

            }

          ?>

          

          <!-- Notifications
          <li class="notifications dropdown">
            <a data-close-others="true" data-hover="dropdown" data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon-bell"></i><span class="badge badge-danger">1</span></a>
            <ul class="dropdown-menu pull-right">
              <li class="first">
                <div class="small"><a class="pull-right danger" href="#"></a> Tienes <strong>1</strong> nuevas notificaciones.</div>
              </li>
              <li>
                <ul class="dropdown-list">
                  <li class="unread notification-success"><a href="#"><i class="icon-user-add pull-right"></i><span class="block-line strong">Nueva notificacion</span><span class="block-line small"> pago pendiente a proveedor </span></a></li>
                  
                </ul>
              </li>
              <li class="external-last"> <a href="#" class="danger">Ver todas las notificaciones</a> </li>
            </ul>
          </li> -->
          <!-- /notifications -->
          
         
        </ul>
        <!-- /user alerts -->
        
      </div>
      </div>
    </div>
  <!-- /main header -->

  <!-- Main content -->
  <div class="main-content">