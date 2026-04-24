<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Obtener módulos accesibles del usuario
$modulos_accesibles = [];
if (isset($_SESSION['s_usuario']['id_rol_usuario'])) {
    require_once 'app/models/PermisoModel.php';
    $permiso = new Permiso();
    $permiso_json = json_encode(['id' => $_SESSION['s_usuario']['id_rol_usuario']]);
    $resultado = $permiso->manejarAccion('obtener_modulos', $permiso_json);
    if ($resultado['status']) {
        foreach ($resultado['data'] as $modulo) {
            $modulos_accesibles[] = $modulo['nombre_modulo'];
        }
    }
}

// Función helper para verificar si un módulo es accesible
function tieneAcceso($modulo_nombre, $modulos_accesibles) {
    return in_array($modulo_nombre, $modulos_accesibles);
}
?>

<div class="wrapper">
    <!-- Sidebar -->
<div class="sidebar" style="background-color: #000000ff;">
  <div class="sidebar-logo">
    <!-- Logo Header -->
    <div class="logo-header" style="background-color: #000000ff; display: flex; justify-content: center; align-items: center; flex-direction: column; padding: 10px 0;">
      <a href="index.php?url=dashboard" class="logo" style="display: block; text-align: center;">
      </a>
      <div class="nav-toggle" style="margin-top: 15px;">
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
        <li class="nav-item">
          <a href="index.php?url=dashboard">
            <i class="fas fa-home"></i>
            <p>Dashboard</p>
          </a>
        </li>
        <?php if (tieneAcceso('Ecommerce', $modulos_accesibles)): ?>
        <li class="nav-item">
          <a href="index.php?url=ecommerce">
            <i class="fas fa-store"></i>
            <p>Ecommerce</p>
          </a>
        </li>
        <?php endif; ?>
        <?php if (tieneAcceso('Notificaciones', $modulos_accesibles)): ?>
        <li class="nav-item">
          <a href="index.php?url=notificaciones">
            <i class="fas fa-bell"></i>
            <p>Notificaciones</p>
          </a>
        </li>
        <li class="nav-item">
          <a href="index.php?url=tasa">
            <i class="fas fa-dollar"></i>
            <p>Tasa Cambiaria</p>
          </a>
        </li>
        <?php endif; ?>
        <?php if (tieneAcceso('Clientes', $modulos_accesibles) || tieneAcceso('Tipos Clientes', $modulos_accesibles)): ?>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section"><i class="fa fa-briefcase"></i> Administracion</h4>
        </li>
        <?php endif; ?>
        <?php if (tieneAcceso('Tipos Clientes', $modulos_accesibles) || tieneAcceso('Clientes', $modulos_accesibles)): ?>
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#socios">
            <i class="fa fa-handshake" aria-hidden="true"></i>
            <p>Socios</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="socios">
            <ul class="nav nav-collapse">
              <?php if (tieneAcceso('Tipos Clientes', $modulos_accesibles)): ?>
              <li>
                <a href="index.php?url=tipos_clientes">
                  <i class="fa fa-user-tag"></i>
                  <span class="sub-item">Tipos de Clientes</span>
                </a>
              </li>
              <?php endif; ?>
              <?php if (tieneAcceso('Clientes', $modulos_accesibles)): ?>
              <li>
                <a href="index.php?url=clientes">
                  <i class="fa fa-users"></i>
                  <span class="sub-item">Clientes</span>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </div>
        </li>
        <?php endif; ?>
        <?php if (tieneAcceso('Categorias', $modulos_accesibles) || tieneAcceso('Productos', $modulos_accesibles)): ?>
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#catalogo">
            <i class="fa fa-th, fa fa-th-list" aria-hidden="true"></i>
            <p>Catalogo</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="catalogo">
            <ul class="nav nav-collapse">
              <?php if (tieneAcceso('Categorias', $modulos_accesibles)): ?>
              <li>
                <a href="index.php?url=categorias">
                  <i class="fa fa-list-alt"></i>
                  <span class="sub-item">Categorias</span>
                </a>
              </li>
              <?php endif; ?>
              <?php if (tieneAcceso('Productos', $modulos_accesibles)): ?>
              <li>
                <a href="index.php?url=productos">
                  <i class="fa fa-cubes"></i>
                  <span class="sub-item">Productos</span>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </div>
        </li>
        <?php endif; ?>
        <?php if (tieneAcceso('Materias Prima', $modulos_accesibles) || tieneAcceso('Producciones', $modulos_accesibles)): ?>
        <li class="nav-item">
          <a data-bs-toggle="collapse" href="#inventario">
            <i class="fa fa-th, fa fa-warehouse" aria-hidden="true"></i>
            <p>Inventario</p>
            <span class="caret"></span>
          </a>
          <div class="collapse" id="inventario">
            <ul class="nav nav-collapse">
              <?php if (tieneAcceso('Materias Prima', $modulos_accesibles)): ?>
              <li>
                <a href="index.php?url=materias_primas">
                  <i class="fa fa-archive"></i>
                  <span class="sub-item">Materias Primas</span>
                </a>
              </li>
              <?php endif; ?>
              <?php if (tieneAcceso('Producciones', $modulos_accesibles)): ?>
              <li>
                <a href="index.php?url=producciones">
                  <i class="fa fa-industry"></i>
                  <span class="sub-item">Producciones</span>
                </a>
              </li>
              <?php endif; ?>
            </ul>
          </div>
        </li>
        <?php endif; ?>
        <?php if (tieneAcceso('Proveedores', $modulos_accesibles)): ?>
        <li class="nav-item">
          <a href="index.php?url=proveedores">
            <i class="fa fa-truck"></i>
            <p>Proveedores</p>
          </a>
        </li>
        <?php endif; ?>
        <?php if (tieneAcceso('Pedidos', $modulos_accesibles) || tieneAcceso('Promociones', $modulos_accesibles)): ?>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section"><i class="fa fa-file-invoice"></i> Facturacion / Ordenes</h4>
        </li>
        <?php endif; ?>
        <?php if (tieneAcceso('Pedidos', $modulos_accesibles)): ?>
        <li class="nav-item">
          <a href="index.php?url=pedidos">
            <i class="fas fa-shopping-basket"></i>
            <p>Pedidos</p>
          </a>
        </li>
        <?php endif; ?>
        <?php if (tieneAcceso('Promociones', $modulos_accesibles)): ?>
        <li class="nav-item">
          <a href="index.php?url=promociones">
            <i class="fa fa-gift"></i>
            <p>Promociones</p>
          </a>
        </li>
        <?php endif; ?>
        <?php if (tieneAcceso('Pagos', $modulos_accesibles)): ?>
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
        <?php endif; ?>
        <?php if (tieneAcceso('Entregas', $modulos_accesibles)): ?>
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
          </a>
        </li>
        <?php endif; ?>
        <?php if (tieneAcceso('Roles', $modulos_accesibles) || tieneAcceso('Usuarios', $modulos_accesibles) || tieneAcceso('Bitacoras', $modulos_accesibles)): ?>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section"><i class="fa fa-cog"></i> Configuracion</h4>
        </li>
        <?php endif; ?>
        <?php if (tieneAcceso('Roles', $modulos_accesibles)): ?>
        <li class="nav-item">
          <a href="index.php?url=roles">
            <i class="fas fa-user-shield"></i>
            <p>Roles y Permisos</p>
          </a>
        </li>
        <?php endif; ?>
        <?php if (tieneAcceso('Usuarios', $modulos_accesibles)): ?>
        <li class="nav-item">
          <a href="index.php?url=usuarios">
            <i class="fas fa-users"></i>
            <p>Usuarios</p>
          </a>
        </li>
        <?php endif; ?>
        <?php if (tieneAcceso('Bitacoras', $modulos_accesibles)): ?>
        <li class="nav-item">
          <a href="index.php?url=bitacora">
            <i class="fa fa-file-text"></i>
            <p>Bitácora</p>
          </a>
        </li>
        <?php endif; ?>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section"><i class="fa fa-file-word"></i> Documentos</h4>
        </li>
        <li class="nav-item">
          <a href="index.php?url=reportes">
            <i class="fa fa-file-alt"></i>
            <p>Reportes</p>
          </a>
        </li>
        <li class="nav-section">
          <span class="sidebar-mini-icon">
            <i class="fa fa-ellipsis-h"></i>
          </span>
          <h4 class="text-section"><i class="fa fa-question-circle"></i> Ayuda</h4>
        </li>
        <li class="nav-item">
          <a href="index.php?url=manual">
            <i class="fa fa-book-open"></i>
            <p>Manual de Usuario</p>
          </a>
        </li>
        <!-- Botón Cerrar Sesión -->
        <li class="nav-item" style="margin-top: 20px;">
          <a href="index.php?url=autenticator&action=cerrar" style="display: flex; align-items: center; padding: 10px 15px; color: #dc3545; text-decoration: none; transition: all 0.2s ease;">
            <i class="fas fa-sign-out-alt" style="margin-right: 10px; width: 20px; text-align: center;"></i>
            <p style="margin: 0; font-size: 13px;">Cerrar Sesión</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
</div>

<style>
/* Solo estilos para el sidebar - no afecta al resto de la página */
.sidebar {
  background-color: #000000ff !important;
}

.sidebar .logo-header {
  background-color: #000000ff !important;
  display: flex;
  justify-content: center;
  align-items: center;
  flex-direction: column;
  padding: 20px 0;
}

.sidebar .logo {
  display: block;
  text-align: center;
}

.sidebar .navbar-brand {
  display: block;
  margin: 0 auto;
  width: 90px !important;
  height: 90px !important;
  object-fit: contain !important;
}

.sidebar .nav-item > a {
  transition: all 0.2s ease;
  border-left: 3px solid transparent;
}

.sidebar .nav-item > a:hover {
  background-color: rgba(255, 255, 255, 0.05);
  border-left-color: #cc1d1d;
  color: #cc1d1d !important;
}

.sidebar .nav-item > a:hover i {
  color: #cc1d1d !important;
}

.sidebar .nav-collapse a:hover {
  background-color: rgba(255, 255, 255, 0.03);
  color: #ffffff !important;
}

/* Scrollbar solo para el sidebar */
.sidebar-wrapper::-webkit-scrollbar {
  width: 5px;
}

.sidebar-wrapper::-webkit-scrollbar-track {
  background: #000000ff;
}

.sidebar-wrapper::-webkit-scrollbar-thumb {
  background: #000000ff;
  border-radius: 3px;
}

.sidebar-wrapper::-webkit-scrollbar-thumb:hover {
  background: #cc1d1d;
}
</style>