<!-- End Sidebar -->
<?php
require_once "components/links.php";
//require_once "components/scripts.php";
require_once "components/alerts.php";

// Cargar modelo de roles si hay sesion activa
$roles_disponibles = [];
if (isset($_SESSION['s_usuario'])) {
    require_once "app/models/PerfilSistemaModel.php";
    $perfilModel = new PerfilSistema();
    $roles_disponibles = $perfilModel->ObtenerRoles();
}

// Funcion para obtener icono segun nombre de rol
function getIconoRol($nombre_rol) {
    $nombre_lower = strtolower($nombre_rol);
    if (strpos($nombre_lower, 'admin') !== false) return 'fa-user-shield';
    if (strpos($nombre_lower, 'gerente') !== false || strpos($nombre_lower, 'manager') !== false) return 'fa-user-tie';
    if (strpos($nombre_lower, 'vendedor') !== false || strpos($nombre_lower, 'ventas') !== false) return 'fa-store';
    if (strpos($nombre_lower, 'repartidor') !== false || strpos($nombre_lower, 'delivery') !== false || strpos($nombre_lower, 'mensajero') !== false) return 'fa-truck';
    if (strpos($nombre_lower, 'cliente') !== false || strpos($nombre_lower, 'customer') !== false) return 'fa-user';
    if (strpos($nombre_lower, 'cajero') !== false || strpos($nombre_lower, 'cashier') !== false) return 'fa-cash-register';
    if (strpos($nombre_lower, 'super') !== false) return 'fa-crown';
    return 'fa-user-circle';
}
?>
<?php require_once "components/chatbot.php"; // Charlotte Chatbot ?>

<!-- CSS del Header -->
<link rel="stylesheet" href="assets/css/header.css">

<div class="main-panel">
    <div class="main-header">
        <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
                <a href="index.php?url=dashboard" class="logo">
                    <img src="assets/img/Kaiadmin.png" width="100" alt="navbar brand" class="navbar-brand" height="20" />
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
        <!-- Navbar Header -->
        <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
            <div class="container-fluid">
                <div class="d-flex align-items-center ms-4">
                    <a href="index.php?url=dashboard" class="navbar-brand d-flex align-items-center text-decoration-none me-3">
                        <img src="Assets/img/natys/natys.png" alt="Natys" width="80" height="80" class="me-2" style="border-radius: 8px; object-fit: contain;">
                    </a>
                </div>
                <ul class="navbar-nav topbar-nav align-items-center">
                    <li>
                        <span class="dolar_group">
                            <span class="tasa_text">Tasa BCV: </span>
                            <span class="valor_text" id="dolar_value"><b>0.00 Bs/$</b></span>
                        </span>
                    </li>
                    <li class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button" aria-expanded="false" aria-haspopup="true">
                            <i class="fa fa-search"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-search animated fadeIn">
                            <form class="navbar-left navbar-form nav-search">
                                <div class="input-group">
                                    <input type="text" placeholder="Search ..." class="form-control" />
                                </div>
                            </form>
                        </ul>
                    </li>
                    
                    <!-- Carrito Dropdown -->
                    <li class="nav-item topbar-icon dropdown hidden-caret">
                        <a class="nav-link dropdown-toggle cart-icon" href="#" id="cartDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-shopping-cart fa-lg"></i>
                            <span class="cart-badge" id="headerCartCount">0</span>
                        </a>
                        <ul class="dropdown-menu cart-dropdown animated fadeIn" aria-labelledby="cartDropdown" id="cartDropdownMenu">
                            <li>
                                <div class="cart-header">
                                    <span><i class="fas fa-shopping-cart me-2"></i>Mi Carrito</span>
                                    <button class="btn-vaciar" onclick="vaciarCarritoHeader()">
                                        <i class="fas fa-trash-alt me-1"></i>Vaciar
                                    </button>
                                </div>
                            </li>
                            <li>
                                <div class="cart-items" id="cartItemsList">
                                    <div class="cart-empty">
                                        <i class="fas fa-shopping-cart"></i>
                                        <p>Tu carrito está vacío</p>
                                        <small>¡Agrega algunos productos!</small>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <div class="cart-footer" id="cartFooter" style="display: none;">
                                    <div class="cart-total">
                                        <span>Total:</span>
                                        <span id="headerCartTotal">$0.00</span>
                                    </div>
                                    <button class="btn-cart-checkout" onclick="irAlCarrito()">
                                        <i class="fas fa-credit-card me-2"></i>Proceder al Pago
                                    </button>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <!-- Notificaciones -->
                    <li class="nav-item topbar-icon dropdown hidden-caret">
                        <a class="nav-link dropdown-toggle" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell"></i>
                            <span class="notification" id="notificationBadge">0</span>
                        </a>
                        <ul class="dropdown-menu notif-box animated fadeIn" aria-labelledby="notifDropdown">
                            <li>
                                <div class="dropdown-title">
                                    Tienes <span id="notificationCount">0</span> notificaciones nuevas
                                </div>
                            </li>
                            <li>
                                <div class="notif-scroll scrollbar-outer">
                                    <div class="notif-center" id="notificationList">
                                        <div class="text-center py-4" id="noNotifications">
                                            <i class="fas fa-bell-slash fa-2x text-muted mb-2"></i>
                                            <p class="text-muted">No tienes notificaciones nuevas</p>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <a class="see-all" href="index.php?url=notificaciones">
                                    Ver todas las notificaciones<i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                    </li>
                    
                    <!-- Toggle Theme -->
                    <li class="nav-item topbar-icon dropdown hidden-caret">
                        <button id="theme-toggle" type="button" class="btn btn-toggle theme-toggle-nav" title="Modo oscuro/claro" onclick="toggleTheme()">
                            <i class="fas fa-moon"></i>
                        </button>
                    </li>
                    
                    <!-- Perfil Usuario -->
                    <li class="nav-item topbar-user dropdown hidden-caret">
                        <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                            <div class="avatar-sm">
                                <img src="<?php 
                                if (!empty($_SESSION['s_usuario']['img_usuario']) && file_exists($_SESSION['s_usuario']['img_usuario'])) {
                                    echo $_SESSION['s_usuario']['img_usuario'];
                                } else {
                                    echo 'Assets/img/perfiles/default.png';
                                }
                                ?>" alt="..." class="avatar-img rounded-circle" id="headerAvatarImg" />
                            </div>
                            <div class="profile-username d-flex flex-column">
                                <span class="fw-bold"><?php echo $_SESSION['s_usuario']['nombre_usuario']?></span>
                                <small class="text-white-50" style="font-size: 0.75rem;"><?php echo $_SESSION['s_usuario']['email_usuario']?></small>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-user animated fadeIn">
                            <div class="dropdown-user-scroll scrollbar-outer">
                                <li>
                                    <a class="dropdown-item" href="index.php?url=perfil&action=ver"><i class="fas fa-user-circle me-2"></i>Mi Perfil</a>

                                    <!-- Submenu Ver como -->
                                    <?php if (isset($_SESSION['s_usuario']['id_rol_usuario']) && in_array($_SESSION['s_usuario']['id_rol_usuario'], [1, 2])): ?>
                                    <div class="menu-item-with-submenu" id="simularMenu">
                                        <a class="dropdown-item has-submenu" href="#" onclick="toggleSubmenu(event, 'simularSubmenu'); return false;">
                                            <i class="fas fa-eye me-2"></i>
                                            <span>Ver como</span>
                                            <i class="fas fa-chevron-right submenu-arrow"></i>
                                        </a>
                                        <div class="submenu-panel" id="simularSubmenu">
                                            <div class="submenu-header">
                                                <a class="dropdown-item submenu-back" href="#" onclick="toggleSubmenu(event, 'simularSubmenu'); return false;">
                                                    <i class="fas fa-arrow-left me-2"></i> Volver
                                                </a>
                                            </div>
                                            <div class="submenu-content">
                                                <?php foreach ($roles_disponibles as $rol): ?>
                                                <a class="dropdown-item" href="#" onclick="simularVista(<?php echo $rol['id_rol']; ?>, '<?php echo htmlspecialchars($rol['nombre_rol']); ?>'); return false;">
                                                    <i class="fas <?php echo getIconoRol($rol['nombre_rol']); ?> me-2"></i><?php echo htmlspecialchars($rol['nombre_rol']); ?>
                                                </a>
                                                <?php endforeach; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item text-danger" href="index.php?url=autenticator&action=cerrar"><i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión</a>
                                </li>
                            </div>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>
        <!-- End Navbar -->
    </div>

<!-- Modal del Carrito -->
<div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%); color: white;">
                <h5 class="modal-title" id="cartModalLabel">
                    <i class="fas fa-shopping-cart me-2"></i>Mi Carrito de Compras
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="cartModalBody">
                <div class="text-center py-5">
                    <i class="fas fa-shopping-cart fa-4x text-muted mb-3"></i>
                    <h5>Tu carrito está vacío</h5>
                    <p class="text-muted">¡Agrega algunos productos para continuar!</p>
                </div>
            </div>
            <div class="modal-footer" id="cartModalFooter" style="display: none;">
                <!-- Se llena dinámicamente -->
            </div>
        </div>
    </div>
</div>

<!-- JavaScript del Header -->
<script src="assets/js/header.js"></script>