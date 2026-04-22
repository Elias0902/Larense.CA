<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Reportes - Sistema Larense</title>
    <?php require_once 'components/links.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Color corporativo uniforme */
        :root { --color-primary: #cc1d1d; --color-primary-dark: #a81818; --color-primary-light: #e84545; }
        
        /* Acordeon compacto y uniforme */
        .accordion-item { border: none; margin-bottom: 10px; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .accordion-button { background: var(--color-primary); color: white; font-weight: 600; padding: 12px 15px; font-size: 14px; border: none; }
        .accordion-button:not(.collapsed) { background: var(--color-primary-dark); color: white; box-shadow: none; }
        .accordion-button:hover { background: var(--color-primary-dark); }
        .accordion-button::after { filter: brightness(0) invert(1); width: 1rem; height: 1rem; }
        .accordion-button i { margin-right: 8px; width: 16px; text-align: center; }
        .accordion-body { padding: 15px; background: #fff; }
        
        /* Cards de reporte mas compactas */
        .report-card { border: 1px solid #e9ecef; border-radius: 8px; transition: all 0.2s; margin-bottom: 10px; }
        .report-card:hover { box-shadow: 0 4px 12px rgba(204, 29, 29, 0.15); border-color: var(--color-primary-light); }
        .report-card .card-header { background: var(--color-primary); color: white; padding: 10px 15px; font-size: 13px; border: none; border-radius: 7px 7px 0 0; }
        .report-card .card-body { padding: 12px; }
        
        /* Seccion de filtros */
        .filter-section { background: #fafafa; border-radius: 6px; padding: 12px; margin-bottom: 12px; border: 1px solid #eee; }
        .filter-section label { font-size: 12px; color: #555; margin-bottom: 4px; }
        
        /* Boton generar uniforme */
        .btn-generate { background: var(--color-primary); border: none; color: white; font-weight: 600; font-size: 13px; padding: 10px; border-radius: 6px; transition: all 0.2s; }
        .btn-generate:hover { background: var(--color-primary-dark); color: white; transform: translateY(-1px); box-shadow: 0 3px 8px rgba(204, 29, 29, 0.3); }
        
        /* Selects estilizados */
        .form-select, .form-control { 
            border: 1px solid #ddd; 
            border-radius: 6px; 
            font-size: 13px; 
            padding: 8px 12px;
            transition: all 0.2s;
        }
        .form-select:focus, .form-control:focus { 
            border-color: var(--color-primary); 
            box-shadow: 0 0 0 0.2rem rgba(204, 29, 29, 0.15); 
            outline: none;
        }
        .form-select:hover, .form-control:hover { border-color: var(--color-primary-light); }
        
        /* Header de pagina */
        .page-header-custom { margin-bottom: 20px; }
        .page-header-custom .icon-circle { 
            background: var(--color-primary) !important; 
            width: 45px !important; 
            height: 45px !important; 
        }
        .page-header-custom h3 { font-size: 22px; color: #333; }
        .breadcrumb-item a { color: var(--color-primary) !important; }
        
        /* Botones de exportacion rapida */
        .btn-outline-success { 
            border-color: var(--color-primary); 
            color: var(--color-primary); 
            font-size: 13px; 
            padding: 8px 12px;
        }
        .btn-outline-success:hover { 
            background: var(--color-primary); 
            border-color: var(--color-primary); 
            color: white;
        }
        
        /* Titulos de seccion */
        .section-title { 
            color: var(--color-primary); 
            font-size: 14px; 
            font-weight: 600; 
            margin-bottom: 15px; 
            padding-bottom: 8px; 
            border-bottom: 2px solid var(--color-primary-light);
        }
        
        /* ==============================================
           ESTILOS PARA MODO OSCURO - REPORTES
           ============================================== */
        body.dark-mode .accordion-body {
            background: #1a1f2e !important;
            color: #e7e9f0 !important;
        }
        
        body.dark-mode .filter-section {
            background: #2a3041 !important;
            border-color: #3a4051 !important;
        }
        
        body.dark-mode .filter-section label {
            color: #e7e9f0 !important;
        }
        
        body.dark-mode .report-card {
            background-color: #1a1f2e !important;
            border-color: #3a4051 !important;
        }
        
        body.dark-mode .report-card .card-body {
            background-color: #1a1f2e !important;
            color: #e7e9f0 !important;
        }
        
        body.dark-mode .form-select,
        body.dark-mode .form-control {
            background-color: #2a3041 !important;
            border-color: #3a4051 !important;
            color: #e7e9f0 !important;
        }
        
        body.dark-mode .form-select:focus,
        body.dark-mode .form-control:focus {
            background-color: #2a3041 !important;
            border-color: #177dff !important;
            color: #e7e9f0 !important;
        }
        
        body.dark-mode .form-select:hover,
        body.dark-mode .form-control:hover {
            border-color: #3a4051 !important;
        }
        
        body.dark-mode .page-header-custom h3 {
            color: #ffffff !important;
        }
        
        body.dark-mode .page-header-custom .breadcrumb-item.active {
            color: #9ca3af !important;
        }
        
        body.dark-mode .page-header-custom .icon-circle {
            background: var(--color-primary) !important;
        }
        
        /* Estilos para modo oscuro usando data-background-color */
        body[data-background-color="dark"] .accordion-body {
            background: #1a1f2e !important;
            color: #e7e9f0 !important;
        }
        
        body[data-background-color="dark"] .filter-section {
            background: #2a3041 !important;
            border-color: #3a4051 !important;
        }
        
        body[data-background-color="dark"] .filter-section label {
            color: #e7e9f0 !important;
        }
        
        body[data-background-color="dark"] .report-card {
            background-color: #1a1f2e !important;
            border-color: #3a4051 !important;
        }
        
        body[data-background-color="dark"] .report-card .card-body {
            background-color: #1a1f2e !important;
            color: #e7e9f0 !important;
        }
        
        body[data-background-color="dark"] .form-select,
        body[data-background-color="dark"] .form-control {
            background-color: #2a3041 !important;
            border-color: #3a4051 !important;
            color: #e7e9f0 !important;
        }
        
        body[data-background-color="dark"] .form-select:focus,
        body[data-background-color="dark"] .form-control:focus {
            background-color: #2a3041 !important;
            border-color: #177dff !important;
            color: #e7e9f0 !important;
        }
        
        body[data-background-color="dark"] .form-select:hover,
        body[data-background-color="dark"] .form-control:hover {
            border-color: #3a4051 !important;
        }
        
        body[data-background-color="dark"] .page-header-custom h3 {
            color: #ffffff !important;
        }
        
        body[data-background-color="dark"] .page-header-custom .breadcrumb-item.active {
            color: #9ca3af !important;
        }
        
        body[data-background-color="dark"] .page-header-custom .icon-circle {
            background: var(--color-primary) !important;
        }
    </style>
</head>
<body>
    <?php require_once 'components/menu.php'; ?>
    <?php require_once 'components/header.php'; ?>

    <div style="padding-top: 120px;"></div>

    <div class="container-fluid px-4">
        <div class="page-inner">
            
            <!-- Header de pagina -->
            <div class="page-header-custom mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle me-3 d-flex align-items-center justify-content-center">
                            <i class="fa fa-file-alt" style="color: white; font-size: 26px;"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0" style="color: #333;">Generador de Reportes</h3>
                            <nav aria-label="breadcrumb" class="mt-1">
                                <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                                    <li class="breadcrumb-item"><a href="index.php?url=dashboard"><i class="icon-home"></i></a></li>
                                    <li class="breadcrumb-item active" style="color: #333;">Reportes con Filtros</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ACORDEON DE MODULOS -->
            <div class="accordion" id="accordionReportes">

                <!-- 1. DASHBOARD & ESTADISTICAS -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDashboard">
                            <i class="fa fa-tachometer-alt"></i> Dashboard & Estadisticas
                        </button>
                    </h2>
                    <div id="collapseDashboard" class="accordion-collapse collapse show" data-bs-parent="#accordionReportes">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-chart-line me-2"></i>Resumen General del Sistema</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="dashboard">
                                                
                                                <div class="filter-section">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label fw-bold">Fecha Desde</label>
                                                            <input type="date" name="fecha_desde" class="form-control">
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label fw-bold">Fecha Hasta</label>
                                                            <input type="date" name="fecha_hasta" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Tipo de Resumen</label>
                                                        <select name="filtro_tipo" class="form-select">
                                                            <option value="completo">Resumen Completo</option>
                                                            <option value="ventas">Solo Ventas</option>
                                                            <option value="clientes">Solo Clientes</option>
                                                            <option value="productos">Solo Productos</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>Generar Reporte PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card report-card h-100">
                                        <div class="card-header" >
                                            <h5 class="mb-0"><i class="fa fa-shopping-bag me-2"></i>Reporte Ecommerce</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="ecommerce">
                                                
                                                <div class="filter-section">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label fw-bold">Mes</label>
                                                            <select name="mes" class="form-select">
                                                                <option value="">Todos los meses</option>
                                                                <option value="1">Enero</option>
                                                                <option value="2">Febrero</option>
                                                                <option value="3">Marzo</option>
                                                                <option value="4">Abril</option>
                                                                <option value="5">Mayo</option>
                                                                <option value="6">Junio</option>
                                                                <option value="7">Julio</option>
                                                                <option value="8">Agosto</option>
                                                                <option value="9">Septiembre</option>
                                                                <option value="10">Octubre</option>
                                                                <option value="11">Noviembre</option>
                                                                <option value="12">Diciembre</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label fw-bold">Año</label>
                                                            <select name="anio" class="form-select">
                                                                <option value="2024">2024</option>
                                                                <option value="2025">2025</option>
                                                                <option value="2026">2026</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado de Ventas</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="todas">Todas</option>
                                                            <option value="completadas">Completadas</option>
                                                            <option value="pendientes">Pendientes</option>
                                                            <option value="canceladas">Canceladas</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>Generar Reporte PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 2. NOTIFICACIONES -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseNotif">
                            <i class="fa fa-bell"></i> Notificaciones
                        </button>
                    </h2>
                    <div id="collapseNotif" class="accordion-collapse collapse" data-bs-parent="#accordionReportes">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card report-card">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-bell me-2"></i>Historial de Notificaciones</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="notificaciones">
                                                
                                                <div class="filter-section">
                                                    <div class="row">
                                                        <div class="col-md-4 mb-2">
                                                            <label class="form-label fw-bold">Fecha Desde</label>
                                                            <input type="date" name="fecha_desde" class="form-control">
                                                        </div>
                                                        <div class="col-md-4 mb-2">
                                                            <label class="form-label fw-bold">Fecha Hasta</label>
                                                            <input type="date" name="fecha_hasta" class="form-control">
                                                        </div>
                                                        <div class="col-md-4 mb-2">
                                                            <label class="form-label fw-bold">Tipo de Notificacion</label>
                                                            <select name="tipo_notif" class="form-select">
                                                                <option value="todas">Todas</option>
                                                                <option value="pedidos">Pedidos</option>
                                                                <option value="pagos">Pagos</option>
                                                                <option value="sistema">Sistema</option>
                                                                <option value="alertas">Alertas</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label fw-bold">Estado</label>
                                                            <select name="estado" class="form-select">
                                                                <option value="todas">Todas</option>
                                                                <option value="leidas">Leidas</option>
                                                                <option value="no_leidas">No Leidas</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label fw-bold">Usuario</label>
                                                            <select name="usuario" class="form-select">
                                                                <option value="todos">Todos</option>
                                                                <option value="admin">Administradores</option>
                                                                <option value="vendedores">Vendedores</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>Generar Reporte PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. ADMINISTRACION - CATALOGO -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdmin">
                            <i class="fa fa-cog"></i> Administracion - Catalogo
                        </button>
                    </h2>
                    <div id="collapseAdmin" class="accordion-collapse collapse" data-bs-parent="#accordionReportes">
                        <div class="accordion-body">
                            <div class="row">
                                <!-- Clientes -->
                                <div class="col-md-6 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-users me-2"></i>Clientes</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="clientes">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Filtrar por Mes</label>
                                                        <select name="mes" class="form-select">
                                                            <option value="">Todos los meses</option>
                                                            <option value="1">Enero</option>
                                                            <option value="2">Febrero</option>
                                                            <option value="3">Marzo</option>
                                                            <option value="4">Abril</option>
                                                            <option value="5">Mayo</option>
                                                            <option value="6">Junio</option>
                                                            <option value="7">Julio</option>
                                                            <option value="8">Agosto</option>
                                                            <option value="9">Septiembre</option>
                                                            <option value="10">Octubre</option>
                                                            <option value="11">Noviembre</option>
                                                            <option value="12">Diciembre</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Tipo de Cliente</label>
                                                        <select name="tipo_cliente" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="natural">Natural</option>
                                                            <option value="juridico">Juridico</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="activo">Activo</option>
                                                            <option value="inactivo">Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>Generar PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Productos -->
                                <div class="col-md-6 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-box me-2"></i>Productos</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="productos">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Categoria</label>
                                                        <select name="categoria" class="form-select">
                                                            <option value="todas">Todas</option>
                                                            <option value="galletas">Galletas</option>
                                                            <option value="postres">Postres</option>
                                                            <option value="panaderia">Panaderia</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Stock</label>
                                                        <select name="stock" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="disponible">Con Stock</option>
                                                            <option value="bajo">Stock Bajo</option>
                                                            <option value="agotado">Agotado</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Rango de Precio</label>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <input type="number" name="precio_min" class="form-control" placeholder="Min">
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="number" name="precio_max" class="form-control" placeholder="Max">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>Generar PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Usuarios -->
                                <div class="col-md-6 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-users-cog me-2"></i>Usuarios</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="usuarios">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Rol</label>
                                                        <select name="rol" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="admin">Administrador</option>
                                                            <option value="vendedor">Vendedor</option>
                                                            <option value="cajero">Cajero</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="activo">Activo</option>
                                                            <option value="inactivo">Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>Generar PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Categorias -->
                                <div class="col-md-6 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-tags me-2"></i>Categorias</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="categorias">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="activo">Activo</option>
                                                            <option value="inactivo">Inactivo</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Ordenar por</label>
                                                        <select name="orden" class="form-select">
                                                            <option value="nombre">Nombre</option>
                                                            <option value="productos">Cantidad de Productos</option>
                                                            <option value="fecha">Fecha de Creacion</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>Generar PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 4. ADMINISTRACION - INVENTARIO Y PROVEEDORES -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInventario">
                            <i class="fa fa-warehouse"></i> Inventario & Proveedores
                        </button>
                    </h2>
                    <div id="collapseInventario" class="accordion-collapse collapse" data-bs-parent="#accordionReportes">
                        <div class="accordion-body">
                            <div class="row">
                                <!-- Inventario -->
                                <div class="col-md-4 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header "
                                            <h5 class="mb-0"><i class="fa fa-warehouse me-2"></i>Inventario</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="inventario">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Tipo de Movimiento</label>
                                                        <select name="movimiento" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="entradas">Entradas</option>
                                                            <option value="salidas">Salidas</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Periodo</label>
                                                        <select name="periodo" class="form-select">
                                                            <option value="hoy">Hoy</option>
                                                            <option value="semana">Esta Semana</option>
                                                            <option value="mes">Este Mes</option>
                                                            <option value="anio">Este Año</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>Generar PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Materia Prima -->
                                <div class="col-md-4 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header "
                                            <h5 class="mb-0"><i class="fa fa-industry me-2"></i>Materia Prima</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="materia_prima">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Tipo de Material</label>
                                                        <select name="tipo" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="harina">Harina</option>
                                                            <option value="azucar">Azucar</option>
                                                            <option value="mantequilla">Mantequilla</option>
                                                            <option value="huevos">Huevos</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Nivel de Stock</label>
                                                        <select name="stock" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="suficiente">Suficiente</option>
                                                            <option value="bajo">Bajo</option>
                                                            <option value="critico">Critico</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>Generar PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Proveedores -->
                                <div class="col-md-4 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header "
                                            <h5 class="mb-0"><i class="fa fa-truck me-2"></i>Proveedores</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="proveedores">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Tipo de Proveedor</label>
                                                        <select name="tipo" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="materia_prima">Materia Prima</option>
                                                            <option value="insumos">Insumos</option>
                                                            <option value="servicios">Servicios</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="activo">Activo</option>
                                                            <option value="inactivo">Inactivo</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>Generar PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 5. FACTURACION / ORDENES -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFactura">
                            <i class="fa fa-file-invoice-dollar"></i> Facturacion / Ordenes
                        </button>
                    </h2>
                    <div id="collapseFactura" class="accordion-collapse collapse" data-bs-parent="#accordionReportes">
                        <div class="accordion-body">
                            <div class="row">
                                <!-- Pedidos -->
                                <div class="col-md-4 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-shopping-cart me-2"></i>Pedidos</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="pedidos">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Mes</label>
                                                        <select name="mes" class="form-select">
                                                            <option value="">Todos los meses</option>
                                                            <option value="1">Enero</option>
                                                            <option value="2">Febrero</option>
                                                            <option value="3">Marzo</option>
                                                            <option value="4">Abril</option>
                                                            <option value="5">Mayo</option>
                                                            <option value="6">Junio</option>
                                                            <option value="7">Julio</option>
                                                            <option value="8">Agosto</option>
                                                            <option value="9">Septiembre</option>
                                                            <option value="10">Octubre</option>
                                                            <option value="11">Noviembre</option>
                                                            <option value="12">Diciembre</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="pendiente">Pendiente</option>
                                                            <option value="procesando">Procesando</option>
                                                            <option value="completado">Completado</option>
                                                            <option value="cancelado">Cancelado</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Cliente</label>
                                                        <input type="text" name="cliente" class="form-control" placeholder="Nombre del cliente">
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>Generar PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Promociones -->
                                <div class="col-md-4 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header "
                                            <h5 class="mb-0"><i class="fa fa-percent me-2"></i>Promociones</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="promociones">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="todos">Todas</option>
                                                            <option value="activas">Activas</option>
                                                            <option value="vencidas">Vencidas</option>
                                                            <option value="proximas">Proximas</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Tipo de Descuento</label>
                                                        <select name="descuento" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="porcentaje">Por Porcentaje</option>
                                                            <option value="monto">Por Monto</option>
                                                            <option value="2x1">2x1</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>Generar PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Compras -->
                                <div class="col-md-4 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header "
                                            <h5 class="mb-0"><i class="fa fa-cart-plus me-2"></i>Compras</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="compras">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Proveedor</label>
                                                        <input type="text" name="proveedor" class="form-control" placeholder="Nombre del proveedor">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="pendiente">Pendiente</option>
                                                            <option value="recibido">Recibido</option>
                                                            <option value="parcial">Parcial</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Mes</label>
                                                        <select name="mes" class="form-select">
                                                            <option value="">Todos</option>
                                                            <?php for($i=1; $i<=12; $i++): ?>
                                                                <option value="<?php echo $i; ?>"><?php echo date('F', mktime(0,0,0,$i,1)); ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>Generar PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 6. FINANZAS -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFinanzas">
                            <i class="fa fa-dollar-sign"></i> Finanzas
                        </button>
                    </h2>
                    <div id="collapseFinanzas" class="accordion-collapse collapse" data-bs-parent="#accordionReportes">
                        <div class="accordion-body">
                            <div class="row">
                                <!-- Cobros -->
                                <div class="col-md-3 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-hand-holding-usd me-2"></i>Cobros</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="cobros">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Mes</label>
                                                        <select name="mes" class="form-select">
                                                            <option value="">Todos</option>
                                                            <?php for($i=1; $i<=12; $i++): ?>
                                                                <option value="<?php echo $i; ?>"><?php echo date('F', mktime(0,0,0,$i,1)); ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="pendiente">Pendiente</option>
                                                            <option value="pagado">Pagado</option>
                                                            <option value="vencido">Vencido</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Cliente</label>
                                                        <input type="text" name="cliente" class="form-control" placeholder="Nombre">
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Pagos -->
                                <div class="col-md-3 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-money-bill-wave me-2"></i>Pagos</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="pagos">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Mes</label>
                                                        <select name="mes" class="form-select">
                                                            <option value="">Todos</option>
                                                            <?php for($i=1; $i<=12; $i++): ?>
                                                                <option value="<?php echo $i; ?>"><?php echo date('F', mktime(0,0,0,$i,1)); ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="pendiente">Pendiente</option>
                                                            <option value="pagado">Pagado</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Proveedor</label>
                                                        <input type="text" name="proveedor" class="form-control" placeholder="Nombre">
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Facturas -->
                                <div class="col-md-3 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-file-invoice me-2"></i>Facturas</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="facturas">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Mes</label>
                                                        <select name="mes" class="form-select">
                                                            <option value="">Todos</option>
                                                            <?php for($i=1; $i<=12; $i++): ?>
                                                                <option value="<?php echo $i; ?>"><?php echo date('F', mktime(0,0,0,$i,1)); ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="todos">Todas</option>
                                                            <option value="emitida">Emitida</option>
                                                            <option value="pagada">Pagada</option>
                                                            <option value="anulada">Anulada</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Rango Monto</label>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <input type="number" name="monto_min" class="form-control" placeholder="Min">
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="number" name="monto_max" class="form-control" placeholder="Max">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Estado de Cuenta -->
                                <div class="col-md-3 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header "
                                            <h5 class="mb-0"><i class="fa fa-chart-pie me-2"></i>Estado de Cuenta</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="estado_cuenta">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Periodo</label>
                                                        <select name="periodo" class="form-select">
                                                            <option value="mensual">Mensual</option>
                                                            <option value="trimestral">Trimestral</option>
                                                            <option value="semestral">Semestral</option>
                                                            <option value="anual">Anual</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Mes/Año</label>
                                                        <input type="month" name="mes_anio" class="form-control">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Incluir</label>
                                                        <div class="form-check">
                                                            <input type="checkbox" name="incluir_cobros" class="form-check-input" checked>
                                                            <label class="form-check-label">Cobros</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input type="checkbox" name="incluir_pagos" class="form-check-input" checked>
                                                            <label class="form-check-label">Pagos</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 7. LOGISTICA -->
                <div class="accordion-item">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseLogistica">
                            <i class="fa fa-shipping-fast"></i> Logistica
                        </button>
                    </h2>
                    <div id="collapseLogistica" class="accordion-collapse collapse" data-bs-parent="#accordionReportes">
                        <div class="accordion-body">
                            <div class="row">
                                <!-- Entregas -->
                                <div class="col-md-6 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header "
                                            <h5 class="mb-0"><i class="fa fa-shipping-fast me-2"></i>Entregas</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="entregas">
                                                
                                                <div class="filter-section">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label fw-bold">Fecha Desde</label>
                                                            <input type="date" name="fecha_desde" class="form-control">
                                                        </div>
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label fw-bold">Fecha Hasta</label>
                                                            <input type="date" name="fecha_hasta" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado de Entrega</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="pendiente">Pendiente</option>
                                                            <option value="en_camino">En Camino</option>
                                                            <option value="entregado">Entregado</option>
                                                            <option value="devuelto">Devuelto</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Transportista</label>
                                                        <input type="text" name="transportista" class="form-control" placeholder="Nombre">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Zona</label>
                                                        <select name="zona" class="form-select">
                                                            <option value="todas">Todas</option>
                                                            <option value="norte">Norte</option>
                                                            <option value="sur">Sur</option>
                                                            <option value="este">Este</option>
                                                            <option value="oeste">Oeste</option>
                                                            <option value="centro">Centro</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>Generar PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Produccion -->
                                <div class="col-md-6 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header "
                                            <h5 class="mb-0"><i class="fa fa-truck-loading me-2"></i>Produccion</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportes&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportes">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="produccion">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Mes</label>
                                                        <select name="mes" class="form-select">
                                                            <option value="">Todos</option>
                                                            <?php for($i=1; $i<=12; $i++): ?>
                                                                <option value="<?php echo $i; ?>"><?php echo date('F', mktime(0,0,0,$i,1)); ?></option>
                                                            <?php endfor; ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="todos">Todos</option>
                                                            <option value="planificado">Planificado</option>
                                                            <option value="en_proceso">En Proceso</option>
                                                            <option value="completado">Completado</option>
                                                            <option value="cancelado">Cancelado</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Producto</label>
                                                        <input type="text" name="producto" class="form-control" placeholder="Nombre del producto">
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Linea de Produccion</label>
                                                        <select name="linea" class="form-select">
                                                            <option value="todas">Todas</option>
                                                            <option value="galletas">Galletas</option>
                                                            <option value="postres">Postres</option>
                                                            <option value="panaderia">Panaderia</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>Generar PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- BOTONES DE EXPORTACION RAPIDA -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                        <div class="card-header py-3" style="border: none;">
                            <h4 class="card-title mb-0" style="color: white; font-weight: 600;">
                                <i class="fa fa-bolt me-2"></i>Exportacion Rapida
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <a href="index.php?url=reportes&action=excel&tipo=clientes" class="btn btn-outline-success w-100">
                                        <i class="fas fa-file-excel me-2"></i>Clientes (Excel)
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="index.php?url=reportes&action=excel&tipo=productos" class="btn btn-outline-success w-100">
                                        <i class="fas fa-file-excel me-2"></i>Productos (Excel)
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="index.php?url=reportes&action=excel&tipo=pedidos" class="btn btn-outline-success w-100">
                                        <i class="fas fa-file-excel me-2"></i>Pedidos (Excel)
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="index.php?url=reportes&action=excel&tipo=ventas" class="btn btn-outline-success w-100">
                                        <i class="fas fa-file-excel me-2"></i>Ventas (Excel)
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <?php require_once 'components/scripts.php'; ?>
    <script src="assets/js/animacionesJs/dashboard_reportes.js"></script>
</body>
</html>
