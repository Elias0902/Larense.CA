<div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" style="background-color: black;">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" style="background-color: black;">
            <a href="index.php?url=dashboard" class="logo">
              <img
                src="assets/img/natys.png"
                alt="navbar brand"
                class="navbar-brand"
                height="60"
                width="130"
              />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item ">
                <a href="index.php?url=dashboard">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="index.php?url=ecommerce">
                  <i class="fas fa-store"></i>
                  <p>Ecommerce</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="index.php?url=notificaciones">
                  <i class="fas fa-bell"></i>
                  <p>Notificaciones</p>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section"><i class="fa fa-briefcase"></i> Administracion</h4>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#catalogo">
                  <i class="fa fa-th, fa fa-th-list" aria-hidden="true"></i>
                  <p>Catalogo</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="catalogo">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="index.php?url=categorias">
                        <i class="fa fa-list-alt"></i>
                        <span class="sub-item">Categorias</span>
                      </a>
                    </li>
                    <li>
                      <a href="index.php?url=productos">
                        <i class="fa fa-cubes"></i>
                        <span class="sub-item">Productos</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#inventario">
                  <i class="fa fa-th, fa fa-warehouse" aria-hidden="true"></i>
                  <p>Inventario</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="inventario">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="index.php?url=materias_primas">
                        <i class="fa fa-archive"></i>
                        <span class="sub-item">Materias Primas</span>
                      </a>
                    </li>
                    <li>
                      <a href="index.php?url=producciones">
                        <i class="fa fa-industry"></i>
                        <span class="sub-item">Producciones</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#socios">
                  <i class="fa fa-handshake" aria-hidden="true"></i>
                  <p>Socios</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="socios">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="index.php?url=tipos_clientes">
                        <i class="fa fa-user-tag"></i>
                        <span class="sub-item">Tipos de Clientes</span>
                      </a>
                    </li>
                    <li>
                      <a href="index.php?url=clientes">
                        <i class="fa fa-users"></i>
                        <span class="sub-item">Clientes</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a href="index.php?url=proveedores">
                  <i class="fa fa-truck"></i>
                  <p>Proveedores</p>
                  <span class="caret"></span>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section"><i class="fa fa-file-invoice"></i> Facturacion / Ordenes</h4>
              </li>
              <li class="nav-item">
                <a href="index.php?url=pedidos">
                  <i class="fas fa-shopping-basket"></i>
                  <p>Pedidos</p>
                  <span class="caret"></span>
                </a>
              </li>
              <li class="nav-item">
                <a href="index.php?url=promociones">
                  <i class="fa fa-gift"></i>
                  <p>Promociones</p>
                  <span class="caret"></span>
                </a>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="index.php?url=compras">
                  <i class="fa fa-shopping-cart"></i>
                  <p>Compras</p>
                  <span class="caret"></span>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section"><i class="fa fa-dollar-sign"></i> Finanzas</h4>
              </li>
              <li class="nav-item">
                <a href="index.php?url=pagos">
                  <i class="fa fa-dollar-sign"></i>
                  <p>Pagos</p>
                  <span class="caret"></span>
                </a>
              </li>
               <li class="nav-item">
                <a data-bs-toggle="collapse" href="#cuenta">
                  <i class="fa fa-bank" aria-hidden="true"></i>
                  <p>Cuentas</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="cuenta">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="index.php?url=cobrar">
                        <i class="fa fa-file-invoice-dollar"></i>
                        <span class="sub-item">Cuentas por Cobrar</span>
                      </a>
                    </li>
                    <li>
                      <a href="index.php?url=pagar">
                        <i class="fa fa-receipt"></i>
                        <span class="sub-item">Cuentas por Pagar</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section"><i class="fa fa-dolly"></i> Logistica</h4>
              </li>
               <li class="nav-item">
                <a href="index.php?url=entregas">
                  <i class="fa fa-map-marker-alt"></i>
                  <p>Entregas</p>
                  <span class="caret"></span>
                </a>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section"><i class="fa fa-cog"></i> Configuracion</h4>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#sistema">
                  <i class="fa fa-desktop"></i>
                  <p>Sistema</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="sistema">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="index.php?url=usuario">
                        <i class="fa fa-user-circle"></i>
                        <span class="sub-item">Usuarios</span>
                      </a>
                    </li>
                    <li>
                      <a href="index.php?url=roles">
                        <i class="fa fa-id-card"></i>
                        <span class="sub-item">Roles</span>
                      </a>
                    </li>
                    <li>
                      <a href="index.php?ulr=seguridad">
                        <i class="fa fa-shield-alt"></i>
                        <span class="sub-item">Seguridad</span>
                      </a>
                    </li>
                    <li>
                    <li>
                      <a href="index.php?ulr=bitacora">
                        <i class="fa fa-file-text"></i>
                        <span class="sub-item">Bitacora</span>
                      </a>
                    </li>
                    <li>
                      <a href="index.php?ulr=mantenimiento"> 
                        <i class="fa fa-database"></i>
                        <span class="sub-item">mantenimiento</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section"><i class="fa fa-file-word"></i> Documentos</h4>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#reportes">
                  <i class="fa fa-file"></i>
                  <p>Reportes</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="reportes">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="index.php?url=reportes_generales">
                        <i class="fa fa-file-text"></i>
                        <span class="sub-item">Generales / Parametrizados</span>
                      </a>
                    </li>
                    <li>
                      <a href="index.php?ulr=reportes_estadisticos">
                        <i class="fa fa-chart-bar"></i>
                        <span class="sub-item">Estadisticos</span>
                      </a>
                    </li>
                    <li>
                      <a href="index.php?ulr=facturas">
                        <i class="fa fa-file-invoice-dollar"></i>
                        <span class="sub-item">Facturas</span>
                      </a>
                    </li>
                    <li>
                      <a href="index.php?ulr=documuentos"> 
                        <i class="fa fa-file-pdf"></i>
                        <span class="sub-item">DOCS / XLS / PDF</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
              <li class="nav-section">
                <span class="sidebar-mini-icon">
                  <i class="fa fa-ellipsis-h"></i>
                </span>
                <h4 class="text-section"><i class="fa fa-question-circle"></i> Ayuda</h4>
              </li>
              <li class="nav-item">
                <a data-bs-toggle="collapse" href="#manual">
                  <i class="fa fa-folder-open"></i>
                  <p>Manuales</p>
                  <span class="caret"></span>
                </a>
                <div class="collapse" id="manual">
                  <ul class="nav nav-collapse">
                    <li>
                      <a href="index.php?url=manual">
                        <i class="fa fa-book-open"></i>
                        <span class="sub-item">Manual</span>
                      </a>
                    </li>
                    <li>
                      <a href="index.php?ulr=manual_form">
                        <i class="fa fa-file-alt"></i>
                        <span class="sub-item">Formularios</span>
                      </a>
                    </li>
                    <li>
                      <a href="index.php?ulr=manual_facturas">
                        <i class="fa fa-file-text"></i>
                        <span class="sub-item">Facturas</span>
                      </a>
                    </li>
                  </ul>
                </div>
              </li>
          </div>
        </div>
      </div>