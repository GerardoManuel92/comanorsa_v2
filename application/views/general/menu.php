
</head>
<body>

<!-- Page container -->
<div class="page-container sidebar-collapsed">

  <!-- Page Sidebar -->
  <div class="page-sidebar" style="background-color: #474949;">
  
  		<!-- Site header  -->
		<header class="site-header" style="background-color: white;">
		  <center>
		  	<div class="site-logo"><a href="index.html"><img width="80%" src="<?php echo base_url(); ?>comanorsa/logo.png" alt="Mouldifi" title="Mouldifi" class="hidden-xs"></a>
		  	</div>

		  <div class="sidebar-collapse hidden-xs"><a class="sidebar-collapse-icon" href="#"><i class="icon-menu"></i></a></div>
		  <div class="sidebar-mobile-menu visible-xs"><a data-target="#side-nav" data-toggle="collapse" class="mobile-menu-icon" href="#"><i class="icon-menu"></i></a></div></center>
		</header>
		<!-- /site header -->
		
		<!-- Main navigation -->
		<!-- Main navigation -->
		<ul id="side-nav" class="main-menu navbar-collapse collapse">


			<?php 

				///////************** ERP COMANORSA MENU POR DEPARTAMENTOS

				switch ( $this->session->userdata(PUESTOCOM) ) {

					case 1:

						# ADMINISTRACION


			?>
					<li><a href="<?php echo base_url(); ?>Dashboard"><i class="icon-gauge"></i><span class="title">Dashboard</span> </a></li>

					<li class="has-sub"><a href="index.html"><i class="icon-box"></i><span class="title">Catalogos</span></a>
						<ul class="nav collapse">
							<li><a href="<?php echo base_url() ?>AltaProducto/altaProducto/0"><span class="title">Alta de productos</span></a></li>
							<li><a href="<?php echo base_url() ?>Rproducto"><span class="title">Reporte de productos</span></a></li>
							<li><a href="<?php echo base_url() ?>AltaMarca/altaMarca/0"><span class="title">Alta de marcas</span></a></li>
							<li><a href="<?php echo base_url() ?>AltaCategoria/altaCategoria/0"><span class="title">Alta de categorias</span></a></li>
							
						</ul>
					</li>

					<li class="has-sub"><a href="index.html"><i class="icon-users"></i><span class="title">Proveedores</span></a>
						<ul class="nav collapse">
							<li><a href="<?php echo base_url() ?>AltaProveedor/altaProveedor/0"><span class="title">Alta de proveedores</span></a></li>
							<li><a href="<?php echo base_url() ?>Rproveedores"><span class="title">Reporte proveedores</span></a></li>
						</ul>
					</li>

					<li class="has-sub"><a href="index.html"><i class="icon-user-add"></i><span class="title">Clientes</span></a>
						<ul class="nav collapse">
							<li><a href="<?php echo base_url() ?>AltaCliente/altaCliente/0"><span class="title">Alta de cliente</span></a></li>
							<li><a href="<?php echo base_url() ?>Rclientes"><span class="title">Reporte de clientes</span></a></li>
						</ul>
					</li>

					<li class="has-sub"><a href="index.html"><i class="icon-doc-text"></i><span class="title">Ventas</span></a>
						<ul class="nav collapse">
							<li><a href="<?php echo base_url() ?>AltaCotizacion"><span class="title">Alta Cotización</span></a></li>
							<li><a href="<?php echo base_url() ?>Rcotizacion"><span class="title">Reporte cotización</span></a></li>
							<li><a href="<?php echo base_url() ?>Rremisiones"><span class="title">Reporte remisiones</span></a></li>
							<li><a href="<?php echo base_url() ?>Rfacturas"><span class="title">Reporte facturas</span></a></li>
						</ul>
					</li>

					<li class="has-sub"><a href="index.html"><i class="icon-bag"></i><span class="title">Compras</span></a>
						<ul class="nav collapse">
							<li><a href="<?php echo base_url() ?>Asignaroc"><span class="title">Asignar proveedor a ODC</span></a></li>
							<li><a href="<?php echo base_url() ?>Rcompras"><span class="title">Reporte de compras</span></a></li>
						</ul>
					</li>


					<li class="has-sub"><a href="index.html"><i class="icon-database"></i><span class="title">Almacen</span></a>
						<ul class="nav collapse">
							
							<li><a href="<?php echo base_url() ?>Pmvendidos"><span class="title">Productos mas vendido</span></a></li>
						</ul>
					</li>

					<li class="has-sub"><a href="index.html"><i class="icon-paper-plane"></i><span class="title">Entrega</span></a>
						<ul class="nav collapse">							
							<li><a href="<?php echo base_url() ?>Centrega"><span class="title">Alta de entrega</span></a></li>
							<li><a href="<?php echo base_url() ?>Rentregas"><span class="title">Reporte de entregas</span></a></li>
						</ul>
					</li>

					<li class="has-sub"><a href="index.html"><i class="icon-credit-card"></i><span class="title">Contabilidad</span></a>
						<ul class="nav collapse">
							
							<li style="background-color: red; color: white;"><a href="<?php echo base_url() ?>Ccxp"><span class="title" style="color: white;">Cuentas por pagar</span></a></li>
							<li style="background-color: darkgreen; color: white;"><a href="<?php echo base_url() ?>Ccxc"><span class="title" style="color: white;">Cuentas por cobrar</span></a></li>
						</ul>
					</li>

					



			<?php

					break;
					
					case 2:

						#ventas


			?>

					<li><a href="<?php echo base_url(); ?>Dashboard"><i class="icon-gauge"></i><span class="title">Dashboard</span> </a></li>
					<li class="has-sub"><a href="index.html"><i class="icon-box"></i><span class="title">Catalogos</span></a>
						<ul class="nav collapse">
							<li><a href="<?php echo base_url() ?>AltaProducto/altaProducto/0"><span class="title">Alta de productos</span></a></li>
							<li><a href="<?php echo base_url() ?>Rproducto"><span class="title">Reporte de productos</span></a></li>
							<li><a href="<?php echo base_url() ?>AltaMarca/altaMarca/0"><span class="title">Alta de marcas</span></a></li>
							<li><a href="<?php echo base_url() ?>AltaCategoria/altaCategoria/0"><span class="title">Alta de categorias</span></a></li>
							
						</ul>
					</li>


					<li class="has-sub"><a href="index.html"><i class="icon-user-add"></i><span class="title">Clientes</span></a>
						<ul class="nav collapse">
							<li><a href="<?php echo base_url() ?>AltaCliente/altaCliente/0"><span class="title">Alta de cliente</span></a></li>
							<li><a href="<?php echo base_url() ?>Rclientes"><span class="title">Reporte de clientes</span></a></li>
						</ul>
					</li>

					<li class="has-sub"><a href="index.html"><i class="icon-doc-text"></i><span class="title">Ventas</span></a>
						<ul class="nav collapse">
							<li><a href="<?php echo base_url() ?>AltaCotizacion"><span class="title">Alta Cotización</span></a></li>
							<li><a href="<?php echo base_url() ?>Rcotizacion"><span class="title">Reporte cotizacion</span></a></li>
							<li><a href="<?php echo base_url() ?>Rremisiones"><span class="title">Reporte remisiones</span></a></li>
							<li><a href="<?php echo base_url() ?>Rfacturas"><span class="title">Reporte facturas</span></a></li>
						</ul>
					</li>


			<?php

					break;

					default:




					break;

				}



			?>


			
					
			
		</ul>
		<!-- /main navigation -->		
  </div>
  <!-- /page sidebar -->