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
    <style>
        /* ==============================================
           ESTILOS DEL HEADER - MODO CLARO (Rojo #cc1d1d)
           ============================================== */
        .navbar-header {
            background: #cc1d1d !important;
            border-bottom: none !important;
        }

        .logo-header[data-background-color="dark"],
        .logo-header {
            background: #cc1d1d !important;
        }

        .navbar-header .nav-link {
            color: #ffffff !important;
        }

        .navbar-header .nav-link:hover {
            color: #f0f0f0 !important;
        }

        /* ==============================================
           ESTILOS DEL HEADER - MODO OSCURO (Negro #000000)
           ============================================== */
        body.dark-mode .navbar-header {
            background: #000000 !important;
        }

        body.dark-mode .logo-header[data-background-color="dark"],
        body.dark-mode .logo-header {
            background: #000000 !important;
        }

        /* Dropdown profesional estilo sistema */
        .dropdown-user {
            min-width: 280px;
            padding: 0;
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            overflow: hidden;
        }

        .dropdown-user-scroll {
            max-height: 400px;
        }

        .dropdown-user .user-box {
            padding: 25px 20px;
            background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
            text-align: center;
            border-radius: 0 0 12px 12px;
        }

        .dropdown-user .user-box .avatar-lg {
            width: 70px;
            height: 70px;
            margin: 0 auto 12px;
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            overflow: hidden;
        }

        .dropdown-user .user-box .avatar-lg img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dropdown-user .user-box h4 {
            color: #ffffff;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 6px;
            line-height: 1.3;
        }

        .dropdown-user .user-box p {
            color: rgba(255,255,255,0.9);
            font-size: 12px;
            margin-bottom: 8px;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
        }

        .dropdown-user .user-box .badge {
            font-size: 11px;
            font-weight: 500;
            padding: 4px 10px;
            background: rgba(255,255,255,0.2) !important;
            color: #ffffff;
        }

        .dropdown-user .dropdown-divider {
            margin: 0;
            border-color: #f0f0f0;
        }

        .dropdown-user .dropdown-item {
            padding: 12px 20px;
            color: #4a5568;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s ease;
            border-left: 3px solid transparent;
        }

        .dropdown-user .dropdown-item:hover {
            background: #fef2f2;
            color: #cc1d1d;
            border-left-color: #cc1d1d;
        }

        .dropdown-user .dropdown-item i {
            width: 20px;
            text-align: center;
            color: #cc1d1d;
            transition: all 0.2s ease;
        }

        .dropdown-user .dropdown-item:hover i {
            transform: translateX(3px);
        }

        .dropdown-user .dropdown-item.text-danger {
            color: #dc2626;
        }

        .dropdown-user .dropdown-item.text-danger i {
            color: #dc2626;
        }

        /* Dropdown de notificaciones estilizado */
        .notif-box {
            min-width: 320px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            overflow: hidden;
        }

        .notif-box .dropdown-title {
            padding: 15px 20px;
            background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
            color: #ffffff;
            font-weight: 600;
            font-size: 14px;
        }

        .notif-box .notif-center a {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            border-bottom: 1px solid #f5f5f5;
            transition: all 0.2s ease;
            text-decoration: none;
            color: #4a5568;
        }

        .notif-box .notif-center a:hover {
            background: #fef2f2;
        }

        .notif-box .notif-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
        }

        .notif-box .notif-primary { background: #fee2e2; color: #cc1d1d; }
        .notif-box .notif-success { background: #d1fae5; color: #059669; }
        .notif-box .notif-danger { background: #fee2e2; color: #dc2626; }

        .notif-box .notif-content {
            flex: 1;
        }

        .notif-box .notif-content .block {
            font-size: 13px;
            font-weight: 500;
            color: #1f2937;
        }

        .notif-box .notif-content .time {
            font-size: 12px;
            color: #9ca3af;
        }

        .notif-box .see-all {
            display: block;
            padding: 12px 20px;
            text-align: center;
            color: #cc1d1d;
            font-weight: 500;
            font-size: 13px;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .notif-box .see-all:hover {
            background: #fef2f2;
        }

        /* Dropdown del carrito */
        .cart-dropdown {
            min-width: 380px;
            max-width: 450px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            overflow: hidden;
        }

        .cart-header {
            padding: 15px 20px;
            background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
            color: white;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .cart-header .btn-vaciar {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .cart-header .btn-vaciar:hover {
            background: rgba(255,255,255,0.3);
        }

        .cart-items {
            max-height: 350px;
            overflow-y: auto;
        }

        .cart-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
            transition: background 0.2s ease;
        }

        .cart-item:hover {
            background: #fef2f2;
        }

        .cart-item-img {
            width: 50px;
            height: 50px;
            border-radius: 10px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .cart-item-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cart-item-img i {
            font-size: 24px;
            color: #9ca3af;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-name {
            font-weight: 600;
            font-size: 14px;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .cart-item-price {
            font-size: 13px;
            color: #cc1d1d;
            font-weight: 500;
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .cart-item-qty {
            width: 30px;
            text-align: center;
            font-weight: 600;
            font-size: 14px;
        }

        .cart-qty-btn {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            background: white;
            cursor: pointer;
            transition: all 0.2s;
            font-weight: bold;
        }

        .cart-qty-btn:hover {
            background: #cc1d1d;
            color: white;
            border-color: #cc1d1d;
        }

        .cart-remove-btn {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            transition: all 0.2s;
            padding: 5px;
        }

        .cart-remove-btn:hover {
            color: #dc2626;
        }

        .cart-footer {
            padding: 15px 20px;
            border-top: 1px solid #e5e7eb;
            background: #f9fafb;
        }

        .cart-total {
            display: flex;
            justify-content: space-between;
            font-weight: 700;
            margin-bottom: 12px;
            font-size: 16px;
        }

        .cart-total span:last-child {
            color: #cc1d1d;
        }

        .cart-empty {
            text-align: center;
            padding: 40px 20px;
            color: #9ca3af;
        }

        .cart-empty i {
            font-size: 48px;
            margin-bottom: 15px;
        }

        .btn-cart-checkout {
            background: #cc1d1d;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 10px;
            width: 100%;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-cart-checkout:hover {
            background: #8b1515;
            transform: translateY(-2px);
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #cc1d1d;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Quick actions dropdown */
        .quick-actions {
            min-width: 280px;
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            overflow: hidden;
        }

        .quick-actions .quick-actions-header {
            padding: 15px 20px;
            background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
        }

        .quick-actions .quick-actions-header .title {
            color: #ffffff;
            font-weight: 600;
            font-size: 14px;
            display: block;
        }

        .quick-actions .quick-actions-header .subtitle {
            color: rgba(255,255,255,0.8);
            font-size: 12px;
        }

        .quick-actions .quick-actions-item {
            padding: 15px;
            text-align: center;
            transition: all 0.2s ease;
            text-decoration: none;
            display: block;
        }

        .quick-actions .quick-actions-item:hover {
            background: #fef2f2;
            transform: translateY(-2px);
        }

        .quick-actions .quick-actions-item .avatar-item {
            width: 45px;
            height: 45px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            color: #ffffff;
            font-size: 18px;
        }

        .quick-actions .quick-actions-item .text {
            font-size: 12px;
            font-weight: 500;
            color: #4a5568;
        }

        .dolar_group {
            background: rgba(255, 255, 255, 0.1) !important;
            padding: 8px 15px !important;
            border-radius: 20px !important;
            color: #ffffff !important;
            margin-right: 15px !important;
        }
        
        .tasa_text {
            color: #ffffff !important;
            font-weight: 500 !important;
        }
        
        .valor_text {
            color: #ffffff !important;
            font-weight: bold !important;
        }
        
        .notification {
            background: #ffffff !important;
            color: #cc1d1d !important;
        }
        
        .profile-username {
            color: #ffffff !important;
            max-width: 200px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display: inline-block;
        }

        .profile-username .op-7 {
            opacity: 0.8 !important;
        }
        
        /* Botones de toggle */
        .btn-toggle {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
        }
        
        .btn-toggle:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
        }
        
        .topbar-toggler {
            background: rgba(255, 255, 255, 0.1) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
        }
        
        .topbar-toggler:hover {
            background: rgba(255, 255, 255, 0.2) !important;
            color: #ffffff !important;
        }

        .theme-toggle-nav {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            color: #ffffff;
            transition: all 0.25s ease;
        }

        .theme-toggle-nav:hover {
            background: rgba(255, 255, 255, 0.22);
            color: #ffffff;
        }

        .theme-toggle-nav.dark {
            background: #ffffff;
            color: #1a1b2b;
            border-color: rgba(0, 0, 0, 0.12);
        }

        /* Estilos del modo oscuro - Globales */
        body.dark-mode {
            background: #000000ff !important;
            color: #e7e9f0;
        }

        body.dark-mode .main-panel,
        body.dark-mode .page-inner,
        body.dark-mode .page-header-modern,
        body.dark-mode .navbar,
        body.dark-mode .main-header,
        body.dark-mode .submenu-panel,
        body.dark-mode .dropdown-menu,
        body.dark-mode .notif-box,
        body.dark-mode .cart-dropdown,
        body.dark-mode .quick-actions,
        body.dark-mode .dropdown-user,
        body.dark-mode .page-header {
            background: #181d2d !important;
            border-color: #2a3041 !important;
            color: #e7e9f0 !important;
        }

        body.dark-mode .navbar-brand,
        body.dark-mode .navbar-nav .nav-link,
        body.dark-mode .profile-username,
        body.dark-mode .dropdown-item,
        body.dark-mode .dropdown-title,
        body.dark-mode .notif-content .block,
        body.dark-mode .notif-content .time,
        body.dark-mode .quick-actions .quick-actions-item .text,
        body.dark-mode .dolar_group,
        body.dark-mode .submenu-back,
        body.dark-mode .page-header-modern h2,
        body.dark-mode .page-header-modern p,
        body.dark-mode .cart-item-name,
        body.dark-mode .cart-item-price {
            color: #e7e9f0 !important;
        }

        /* Estilos submenu-back en modo oscuro */
        body.dark-mode .submenu-header {
            background: #181d2d !important;
            border-bottom-color: #2a3041 !important;
        }

        body.dark-mode .submenu-back {
            background: #181d2d !important;
            color: #e7e9f0 !important;
        }

        body.dark-mode .submenu-back:hover {
            background: #2a3041 !important;
            color: #e7e9f0 !important;
        }

        body.dark-mode .submenu-back i {
            color: #9ca3af !important;
        }

        body.dark-mode .cart-item {
            border-bottom-color: #2a3041;
        }

        body.dark-mode .cart-footer {
            background: #1a1f2e;
            border-top-color: #2a3041;
        }

        body.dark-mode .cart-qty-btn {
            background: #2a3041;
            border-color: #3a4055;
            color: #e7e9f0;
        }

        body.dark-mode .btn-toggle,
        body.dark-mode .topbar-toggler {
            background: rgba(255, 255, 255, 0.12) !important;
            border-color: rgba(255, 255, 255, 0.12) !important;
            color: #e7e9f0 !important;
        }

        /* Submenu estilo Facebook - cubre todo el dropdown */
        .menu-item-with-submenu {
            position: static;
        }

        .dropdown-item.has-submenu {
            display: flex;
            align-items: center;
            justify-content: flex-start;
        }

        .dropdown-item.has-submenu span {
            flex: none;
        }

        .dropdown-item.has-submenu .submenu-arrow {
            font-size: 12px;
            color: #9ca3af;
            transition: transform 0.2s ease;
            margin-left: auto;
        }

        .dropdown-item.has-submenu:hover .submenu-arrow {
            color: #cc1d1d;
            transform: translateX(3px);
        }

        .submenu-panel {
            display: none;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            min-width: 280px;
            height: 100%;
            min-height: 100%;
            background: #ffffff;
            z-index: 9999;
            overflow-y: auto;
            animation: slideInRight 0.25s ease-out;
            border-radius: 8px;
        }

        .submenu-panel.active {
            display: block;
        }

        @keyframes slideInRight {
            from {
                transform: translateX(100%);
            }
            to {
                transform: translateX(0);
            }
        }

        @keyframes slideOutLeft {
            from {
                transform: translateX(0);
            }
            to {
                transform: translateX(100%);
            }
        }

        .submenu-panel.closing {
            animation: slideOutLeft 0.25s ease-out forwards;
        }

        /* Header fijo del submenu */
        .submenu-header {
            position: sticky;
            top: 0;
            background: #ffffff;
            z-index: 10000;
            border-bottom: 1px solid #f0f0f0;
        }

        .submenu-back {
            font-weight: 600;
            color: #1a1b2b !important;
            padding: 15px 20px !important;
        }

        .submenu-back:hover {
            background: #f3f4f6 !important;
            color: #1a1b2b !important;
            border-left-color: transparent !important;
        }

        .submenu-back i {
            color: #6b7280 !important;
        }

        /* Contenido del submenu con padding */
        .submenu-content {
            padding: 8px 0;
        }

        /* Icono carrito en navbar */
        .cart-icon {
            position: relative;
            cursor: pointer;
        }
    </style>
      <div class="main-panel">
        <div class="main-header">
          <div class="main-header-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="dark">
              <a href="index.php?url=dashboard" class="logo">
                <img
                  src="assets/img/natys/natys.png" width="100"
                  alt="navbar brand"
                  class="navbar-brand"
                  height="20"
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
          <!-- Navbar Header -->
          <nav
            class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
          >
            <div class="container-fluid">
              <div class="d-flex align-items-center me-auto">
                <a href="index.php?url=dashboard" class="navbar-brand d-flex align-items-center text-decoration-none me-3">
                  <img src="assets/img/natys/natys.png" alt="Natys" width="80" height="80" class="me-2" style="border-radius: 8px; object-fit: contain;">
                </a>
              </div>
              <ul class="navbar-nav topbar-nav align-items-center">
                <li>
                  <span class="dolar_group">
                    <span class="tasa_text">Tasa BCV: </span>
                    <span class="valor_text" id="dolar_value"><b>0.00 Bs/$</b></span>
                  </span>
                </li>
                <li
                  class="nav-item topbar-icon dropdown hidden-caret d-flex d-lg-none"
                >
                  <a
                    class="nav-link dropdown-toggle"
                    data-bs-toggle="dropdown"
                    href="#"
                    role="button"
                    aria-expanded="false"
                    aria-haspopup="true"
                  >
                    <i class="fa fa-search"></i>
                  </a>
                  <ul class="dropdown-menu dropdown-search animated fadeIn">
                    <form class="navbar-left navbar-form nav-search">
                      <div class="input-group">
                        <input
                          type="text"
                          placeholder="Search ..."
                          class="form-control"
                        />
                      </div>
                    </form>
                  </ul>
                </li>
                
                <!-- Carrito Dropdown (visible para todos los roles) -->
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link dropdown-toggle cart-icon"
                    href="#"
                    id="cartDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="fas fa-shopping-cart fa-lg"></i>
                    <span class="cart-badge" id="headerCartCount">0</span>
                  </a>
                  <ul
                    class="dropdown-menu cart-dropdown animated fadeIn"
                    aria-labelledby="cartDropdown"
                    id="cartDropdownMenu"
                  >
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
                        <!-- Los items del carrito se cargarán dinámicamente -->
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

                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <a
                    class="nav-link dropdown-toggle"
                    href="#"
                    id="notifDropdown"
                    role="button"
                    data-bs-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false"
                  >
                    <i class="fa fa-bell"></i>
                    <span class="notification" id="notificationBadge">0</span>
                  </a>
                  <ul
                    class="dropdown-menu notif-box animated fadeIn"
                    aria-labelledby="notifDropdown"
                  >
                    <li>
                      <div class="dropdown-title">
                        Tienes <span id="notificationCount">0</span> notificaciones nuevas
                      </div>
                    </li>
                    <li>
                      <div class="notif-scroll scrollbar-outer">
                        <div class="notif-center" id="notificationList">
                          <!-- Las notificaciones se cargarán dinámicamente -->
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
                <li class="nav-item topbar-icon dropdown hidden-caret">
                  <button id="theme-toggle" type="button" class="btn btn-toggle theme-toggle-nav" title="Modo oscuro/ claro" onclick="toggleTheme()">
                    <i class="fas fa-moon"></i>
                  </button>
                </li>
                <li class="nav-item topbar-user dropdown hidden-caret">
                  <a
                    class="dropdown-toggle profile-pic"
                    data-bs-toggle="dropdown"
                    href="#"
                    aria-expanded="false"
                  >
                    <div class="avatar-sm">
                      <img
                        src="<?php 
                        if (!empty($_SESSION['s_usuario']['imagen_perfil']) && file_exists($_SESSION['s_usuario']['imagen_perfil'])) {
                            echo $_SESSION['s_usuario']['imagen_perfil'];
                        } else {
                            echo 'Assets/img/default.PNG';
                        }
                        ?>"
                        alt="..."
                        class="avatar-img rounded-circle"
                        id="headerAvatarImg"
                      />
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

                        <!-- Submenu Ver como - simulacion de roles (solo para Superusuario y Administrador) -->
                        <?php if (isset($_SESSION['s_usuario']['id_rol_usuario']) && in_array($_SESSION['s_usuario']['id_rol_usuario'], [1, 2])): ?>
                        <div class="menu-item-with-submenu" id="simularMenu">
                            <a class="dropdown-item has-submenu" href="#" onclick="toggleSubmenu(event, 'simularSubmenu'); return false;">
                                <i class="fas fa-eye me-2"></i>
                                <span>Ver como</span>
                                <i class="fas fa-chevron-right submenu-arrow"></i>
                            </a>
                            <div class="submenu-panel" id="simularSubmenu">
                                <!-- Header fijo con flecha volver -->
                                <div class="submenu-header">
                                    <a class="dropdown-item submenu-back" href="#" onclick="toggleSubmenu(event, 'simularSubmenu'); return false;">
                                        <i class="fas fa-arrow-left me-2"></i> Volver
                                    </a>
                                </div>
                                <!-- Contenido del submenu - roles dinamicos -->
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

<script>
// ==============================================
// FUNCIONES DEL CARRITO PARA EL HEADER
// ==============================================

// Obtener carrito del localStorage
function getCarrito() {
    return JSON.parse(localStorage.getItem('carrito_usuario')) || [];
}

// Guardar carrito en localStorage
function saveCarrito(carrito) {
    localStorage.setItem('carrito_usuario', JSON.stringify(carrito));
    actualizarContadorHeader();
    
    // Disparar evento para actualizar otras partes
    const event = new CustomEvent('cartUpdated');
    document.dispatchEvent(event);
}

// Actualizar contador del carrito en el header
function actualizarContadorHeader() {
    const carrito = getCarrito();
    const totalItems = carrito.reduce((sum, item) => sum + item.cantidad, 0);
    const cartBadge = document.getElementById('headerCartCount');
    if (cartBadge) {
        cartBadge.innerText = totalItems;
        cartBadge.style.display = totalItems > 0 ? 'flex' : 'none';
    }
}

// Mostrar carrito en el dropdown
function mostrarCarritoEnHeader() {
    const carrito = getCarrito();
    const cartItemsList = document.getElementById('cartItemsList');
    const cartFooter = document.getElementById('cartFooter');
    const headerCartTotal = document.getElementById('headerCartTotal');
    
    if (!cartItemsList) return;
    
    if (carrito.length === 0) {
        cartItemsList.innerHTML = `
            <div class="cart-empty">
                <i class="fas fa-shopping-cart"></i>
                <p>Tu carrito está vacío</p>
                <small>¡Agrega algunos productos!</small>
            </div>
        `;
        if (cartFooter) cartFooter.style.display = 'none';
        return;
    }
    
    if (cartFooter) cartFooter.style.display = 'block';
    
    let html = '';
    let total = 0;
    
    carrito.forEach((item, index) => {
        const subtotal = item.precio * item.cantidad;
        total += subtotal;
        
        html += `
            <div class="cart-item" data-index="${index}">
                <div class="cart-item-img">
                    ${item.img ? `<img src="${item.img}" alt="${item.nombre}">` : '<i class="fas fa-cookie-bite"></i>'}
                </div>
                <div class="cart-item-info">
                    <div class="cart-item-name">${item.nombre}</div>
                    <div class="cart-item-price">$${item.precio.toFixed(2)} c/u</div>
                </div>
                <div class="cart-item-actions">
                    <button class="cart-qty-btn" onclick="modificarCantidadHeader(${index}, -1)">-</button>
                    <span class="cart-item-qty">${item.cantidad}</span>
                    <button class="cart-qty-btn" onclick="modificarCantidadHeader(${index}, 1)">+</button>
                    <button class="cart-remove-btn" onclick="eliminarDelCarritoHeader(${index})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `;
    });
    
    cartItemsList.innerHTML = html;
    if (headerCartTotal) headerCartTotal.innerText = `$${total.toFixed(2)}`;
}

// Vaciar carrito completo
function vaciarCarritoHeader() {
    if (confirm('¿Estás seguro de que deseas vaciar todo el carrito?')) {
        const carrito = [];
        saveCarrito(carrito);
        mostrarCarritoEnHeader();
        mostrarToastHeader('Carrito vaciado correctamente', 'info');
    }
}

// Modificar cantidad desde el header
function modificarCantidadHeader(index, cambio) {
    const carrito = getCarrito();
    if (!carrito[index]) return;
    
    const item = carrito[index];
    const nuevaCantidad = item.cantidad + cambio;
    
    if (nuevaCantidad < 1) {
        eliminarDelCarritoHeader(index);
        return;
    }
    
    if (nuevaCantidad > item.stock) {
        mostrarToastHeader(`No hay suficiente stock de "${item.nombre}"`, 'error');
        return;
    }
    
    item.cantidad = nuevaCantidad;
    saveCarrito(carrito);
    mostrarCarritoEnHeader();
    mostrarToastHeader(`Cantidad actualizada: ${item.cantidad}`, 'success');
}

// Eliminar del carrito desde el header
function eliminarDelCarritoHeader(index) {
    const carrito = getCarrito();
    const producto = carrito[index];
    carrito.splice(index, 1);
    saveCarrito(carrito);
    mostrarCarritoEnHeader();
    mostrarToastHeader(`"${producto.nombre}" eliminado del carrito`, 'info');
}

// Ir al carrito
function irAlCarrito() {
    const dropdownElement = document.querySelector('.cart-dropdown');
    if (dropdownElement && dropdownElement.parentElement) {
        const bsDropdown = bootstrap.Dropdown.getInstance(dropdownElement.parentElement);
        if (bsDropdown) bsDropdown.hide();
    }
    
    const event = new CustomEvent('openCartModal');
    document.dispatchEvent(event);
    
    setTimeout(() => {
        const currentUrl = window.location.href;
        if (!currentUrl.includes('ecommerce')) {
            window.location.href = 'index.php?url=ecommerce&action=usuarioIndex';
        }
    }, 300);
}

// Mostrar toast notificaciones
function mostrarToastHeader(mensaje, tipo = 'success') {
    const existingToast = document.querySelector('.toast-header-custom');
    if (existingToast) existingToast.remove();
    
    const toast = document.createElement('div');
    toast.className = 'toast-header-custom';
    toast.style.cssText = `
        position: fixed;
        bottom: 20px;
        right: 20px;
        background: ${tipo === 'success' ? '#10b981' : (tipo === 'error' ? '#ef4444' : '#f59e0b')};
        color: white;
        padding: 12px 20px;
        border-radius: 12px;
        z-index: 9999;
        animation: slideInRight 0.3s ease;
        font-size: 14px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    `;
    toast.innerHTML = `<i class="fas ${tipo === 'success' ? 'fa-check-circle' : (tipo === 'error' ? 'fa-exclamation-circle' : 'fa-info-circle')} me-2"></i>${mensaje}`;
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 300);
    }, 3000);
}

// Recargar carrito al abrir dropdown
document.addEventListener('DOMContentLoaded', function() {
    actualizarContadorHeader();
    
    const cartDropdown = document.getElementById('cartDropdown');
    if (cartDropdown) {
        cartDropdown.addEventListener('click', function() {
            setTimeout(() => {
                mostrarCarritoEnHeader();
            }, 100);
        });
    }
    
    window.addEventListener('storage', function(e) {
        if (e.key === 'carrito_usuario') {
            actualizarContadorHeader();
            const dropdownMenu = document.getElementById('cartDropdownMenu');
            if (dropdownMenu && dropdownMenu.classList.contains('show')) {
                mostrarCarritoEnHeader();
            }
        }
    });
    
    document.addEventListener('cartUpdated', function() {
        actualizarContadorHeader();
        const dropdownMenu = document.getElementById('cartDropdownMenu');
        if (dropdownMenu && dropdownMenu.classList.contains('show')) {
            mostrarCarritoEnHeader();
        }
    });
});

// Funcion para cambiar idioma
function toggleLanguage() {
    Swal.fire({
        icon: 'info',
        title: 'Selector de Idioma',
        text: 'Funcion en desarrollo. Idiomas disponibles: Español, English.',
        timer: 2000,
        showConfirmButton: false
    });
}

// Funcion para simular vista con un rol especifico
function simularVista(id_rol, nombre_rol) {
    Swal.fire({
        icon: 'info',
        title: 'Ver como ' + nombre_rol,
        text: 'Simulando vista de ' + nombre_rol + '... (Funcion en desarrollo)',
        timer: 2000,
        showConfirmButton: false
    });

    console.log('Simulando rol ID:', id_rol, 'Nombre:', nombre_rol);
}

// Funcion para mostrar/ocultar submenu con animacion
function toggleSubmenu(event, submenuId) {
    event.stopPropagation();
    const submenu = document.getElementById(submenuId);
    if (!submenu) return;

    if (submenu.classList.contains('active')) {
        submenu.classList.add('closing');
        setTimeout(() => {
            submenu.classList.remove('active', 'closing');
        }, 250);
    } else {
        submenu.classList.add('active');
    }
}

// Cerrar submenu al hacer clic fuera
document.addEventListener('click', function(e) {
    const submenus = document.querySelectorAll('.submenu-panel.active');
    submenus.forEach(function(submenu) {
        if (!submenu.contains(e.target) && !e.target.closest('.has-submenu')) {
            submenu.classList.add('closing');
            setTimeout(() => {
                submenu.classList.remove('active', 'closing');
            }, 250);
        }
    });
});

// Cerrar submenu cuando se cierra el dropdown principal
$(document).on('hidden.bs.dropdown', '.dropdown', function () {
    const submenus = document.querySelectorAll('.submenu-panel');
    submenus.forEach(function(submenu) {
        submenu.classList.remove('active', 'closing');
    });
});

// ==============================================
// FUNCIONES DE NOTIFICACIONES PARA EL HEADER
// ==============================================

// Cargar notificaciones al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    cargarNotificaciones();
});

// Función para cargar notificaciones via AJAX
function cargarNotificaciones() {
    fetch('index.php?url=notificaciones&action=obtener_header')
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                mostrarNotificaciones(data.data);
            } else {
                console.log('Error al cargar notificaciones:', data.msj);
                mostrarNotificaciones([]);
            }
        })
        .catch(error => {
            console.error('Error al cargar notificaciones:', error);
            mostrarNotificaciones([]);
        });
}

// Función para mostrar notificaciones en el header
function mostrarNotificaciones(notificaciones) {
    const badge = document.getElementById('notificationBadge');
    const count = document.getElementById('notificationCount');
    const list = document.getElementById('notificationList');
    const noNotif = document.getElementById('noNotifications');
    
    // Actualizar badge
    badge.textContent = notificaciones.length;
    count.textContent = notificaciones.length;
    
    // Limpiar lista
    list.innerHTML = '';
    
    if (notificaciones.length === 0) {
        list.appendChild(noNotif);
        noNotif.style.display = 'block';
        return;
    }
    
    noNotif.style.display = 'none';
    
    // Agregar notificaciones
    notificaciones.forEach(notif => {
        const notifElement = document.createElement('a');
        notifElement.href = notif.enlace || '#';
        notifElement.className = 'notif-link';
        
        // Calcular tiempo transcurrido
        const fecha = new Date(notif.fecha_notificacion);
        const ahora = new Date();
        const diffMs = ahora - fecha;
        const diffMins = Math.floor(diffMs / 60000);
        const diffHoras = Math.floor(diffMins / 60);
        const diffDias = Math.floor(diffHoras / 24);
        
        let tiempoTexto = '';
        if (diffMins < 1) tiempoTexto = 'Ahora mismo';
        else if (diffMins < 60) tiempoTexto = `Hace ${diffMins} minuto${diffMins > 1 ? 's' : ''}`;
        else if (diffHoras < 24) tiempoTexto = `Hace ${diffHoras} hora${diffHoras > 1 ? 's' : ''}`;
        else tiempoTexto = `Hace ${diffDias} día${diffDias > 1 ? 's' : ''}`;
        
        notifElement.innerHTML = `
            <div class="notif-icon notif-primary">
                <i class="fa fa-bell"></i>
            </div>
            <div class="notif-content">
                <span class="block">${notif.descripcion_notificacion}</span>
                <span class="time">${tiempoTexto}</span>
            </div>
        `;
        
        list.appendChild(notifElement);
    });
}

// Actualizar notificaciones cada 30 segundos
setInterval(cargarNotificaciones, 30000);

</script>