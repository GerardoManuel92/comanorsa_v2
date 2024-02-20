
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

			<!--<li><a href="#"><i class="fa fa-spinner fa-spin"></i><span class="title">Cargando...</span></a></li>-->


			<?php

								$sql="SELECT a.iddepa,a.idsubmenu,b.idmenu,b.url AS url_ubmenu,b.nombre AS submenu, c.oden, c.nombre AS menu, c.url AS url_menu, c.icono 
								FROM menus_departamento a, submenus b, menus c
								WHERE 
								a.idsubmenu=b.id
								AND b.idmenu=c.id
								AND a.estatus = 0
								AND b.estatus = 0
								AND a.iddepa = ".$this->session->userdata(PUESTOCOM)."
								ORDER BY c.oden,a.idsubmenu ASC";

								$info = $this->General_Model->infoxQuery($sql);

								if ( $info != null ) {

									$conteo = 0;
									$conteo_submenu = 0;
									$submenu_anterior = 0;
									$menu = 0;
									$menux = 0;

									$crear_menu =""; 
									
									foreach ($info as $row) {
										
										$iddepa = $row->iddepa;
										$idsubmenu = $row->idsubmenu;
										$idmenu = $row->idmenu;
										$url_submenu = $row->url_ubmenu;
										$nombre_submenu = $row->submenu;
										$oden = $row->oden;
										$nombre_menu = $row->menu;
										$url_menu = $row->url_menu;
										$icono = $row->icono;


										//$crear_menu.= "";//$url_menu."<br>";

										//////////*********** INICIAMOS MENUS 

										if ( $conteo == 0 ) {

											///////////INICIO DEL MENU

											if ( $url_menu == "index" ) {
												
												//$urlmenu = "";
												$crear_menu.='<li class="has-sub"><a href="index.html"><i class="'.$icono.'"></i><span class="title">'.$nombre_menu.'</span> </a>';

											}else{

												//$urlmenu = $url_menu;
												$crear_menu.='<li><a href="'.base_url().''.$url_menu.'"><i class="'.$icono.'"></i><span class="title">'.$nombre_menu.'</span> </a>';

											}
											
											$menux = $idmenu;
											//$menu = $idmenu;

												///// CREAMOS SUBMENUS 

												if ( $url_submenu == "null" ) {
													
													/////// NO EXISTE SUBMENU
													$submenu_anterior = 1;///no existe submenu

													//$crear_menu.='<alex>';

												}else{

													////// EXISTE SUBMENU

														///// INCIAMOS SUBMENU NUEVO 
														if ( $conteo_submenu == 0 ) {
																
															$crear_menu.='<ul class="nav collapse"><li><a href="'.base_url().''.$url_submenu.'"><span class="title">'.$nombre_submenu.'</span></a></li>';

														}else{

															$crear_menu.='<li><a href="'.base_url().''.$url_submenu.'"><span class="title">'.$nombre_submenu.'</span></a></li>';
																
														}

														$submenu_anterior = 0;///existe submenu
														$conteo_submenu = $conteo_submenu+1;
												}


										}else{


											if ( $menux != $idmenu ) {
												
												////////// CERRAMOS Y CREAMOS EL NUEVO MENU

													//// ENLACE DEL MENU  
													if ( $url_menu == "index" ) {
													
														$urlmenu = "index.html";

													}else{

														$urlmenu = "base_url()".$url_menu;

													}


														////// REVISAMOS SI EL SUBMENU EXISTE y de no existir cambiamos el cierre 
														if ( $submenu_anterior == 0 ) {
															
															//// EXISTE SUBMENU
															$crear_menu.='</ul></li><li><a href="'.$urlmenu.'"><i class="'.$icono.'"></i><span class="title">'.$nombre_menu.'</span> </a>';

														}else{

															//// NO EXISTE SUBMENU
															$crear_menu.='</li><li><a href="'.$urlmenu.'"><i class="'.$icono.'"></i><span class="title">'.$nombre_menu.'</span> </a>';

														}

														$conteo_submenu = 0;
														$menux = $idmenu;

											}

												///// CREAMOS SUBMENUS 

												if ( $url_submenu == "null" ) {
													
													/////// NO EXISTE SUBMENU
													$submenu_anterior = 1;///no existe submenu

													//$crear_menu.='<alex>';

												}else{

													////// EXISTE SUBMENU

														///// INCIAMOS SUBMENU NUEVO 
														if ( $conteo_submenu == 0 ) {
																
															$crear_menu.='<ul class="nav collapse"><li><a href="'.base_url().''.$url_submenu.'"><span class="title">'.$nombre_submenu.'</span></a></li>';

														}else{

															$crear_menu.='<li><a href="'.base_url().''.$url_submenu.'"><span class="title">'.$nombre_submenu.'</span></a></li>';
																
														}

														$submenu_anterior = 0;///existe submenu
														$conteo_submenu = $conteo_submenu+1;
												}


										}


										$conteo = $conteo+1;

									}

								}


								if ( $submenu_anterior == 0 ) {
									
									////// EXISTE SUBMENU
									$crear_menu.= '</ul></li>';

								}else{

									////// NO EXISTE MENU 
									$crear_menu.= '</li>';

								}


								//echo '<textarea class="form-control" rows="50">'.$crear_menu.'</textarea>';

								echo $crear_menu;


							?>

			<!-- TEST MENU  
					
			<li><a href="https://www.thinkweb.com.mx/erp_comanorsa/Dashboard "><i class="icon-gauge"></i><span class="title">Dashboard</span> </a></ul></li>

			<li><a href="https://www.thinkweb.com.mx/erp_comanorsa/index.html "><i class="icon-box"></i><span class="title">Catalogos</span> </a><ul class="nav collapse"><li><a href="https://www.thinkweb.com.mx/erp_comanorsa/AltaProducto/altaProducto/0"><span class="title">Alta de productos</span></a></li><li><a href="https://www.thinkweb.com.mx/erp_comanorsa/Rproducto"><span class="title">Reporte de productos</span></a></li></ul></li><li><a href="https://www.thinkweb.com.mx/erp_comanorsa/index.html "><i class="icon-users"></i><span class="title">Proveedores</span> </a><ul class="nav collapse"><li><a href="https://www.thinkweb.com.mx/erp_comanorsa/AltaProveedor/altaProveedor/0"><span class="title">Alta de proveedores</span></a></li><li><a href="https://www.thinkweb.com.mx/erp_comanorsa/Rproveedores"><span class="title">Reporte proveedores</span></a></li></ul></li>-->



		</ul>
		<!-- /main navigation -->		
  </div>
  <!-- /page sidebar -->