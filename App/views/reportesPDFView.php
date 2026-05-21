<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Reportes PDF - Sistema Larense</title>
    <?php require_once 'components/links.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/stylesModules/reportes.css" />
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
                            <h3 class="fw-bold mb-0" style="color: #333;">Generador de Reportes PDF</h3>
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
                                            <form action="index.php?url=reportesPDF&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
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
                                            <form action="index.php?url=reportesPDF&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
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
                                            <form action="index.php?url=reportePDFs&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
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
                                            <form action="index.php?url=reportesPDF&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="clientes">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Tipo de Cliente</label>
                                                        <select name="tipo_cliente" class="form-select">
                                                            <option value="">Seleccione una opcion</option>
                                                            <?php
                                                                if (isset($tipos) && is_array($tipos) && !empty($tipos)) {
                                                                    foreach ($tipos as $tipo) {
                                                                        echo '<option value="' . $tipo['id_tipo_cliente'] . '">'
                                                                            . $tipo['nombre_tipo_cliente'] . '</option>';
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="">Seleccione una opcion</option>
                                                            <option value="Activo">Activo</option>
                                                            <option value="Pendiente">Pendiente</option>
                                                            <option value="Anulado">Anulado</option>
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

                                <!-- Tipos Clientes -->
                                <div class="col-md-6 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-users me-2"></i>Tipo Clientes</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportesPDF&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="tipo_clientes">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Dias Credito</label>
                                                        <select name="dias" class="form-select">
                                                            <option value="">Seleccione una opcion</option>
                                                            <option value="7">7</option>
                                                            <option value="15">15</option>
                                                            <option value="30">30</option>
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
                                            <form action="index.php?url=reportePDFs&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="productos">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Categoria</label>
                                                        <select name="categoria" class="form-select">
                                                            <option value="">Seleccione una opcion</option>
                                                            <?php
                                                                if (isset($categorias) && is_array($categorias) && !empty($categorias)) {
                                                                    foreach ($categorias as $categoria) {
                                                                        echo '<option value="' . $categoria['id_categoria'] . '">'
                                                                            . $categoria['nombre_categoria'] . '</option>';
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Filtrar por:</label>
                                                        <select name="filtro" class="form-select">
                                                            <option value="">Seleccione una opcion</option>
                                                            <option value="vencido">Vencidos</option>
                                                            <option value="bajo">Stock Bajo</option>
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
                                            <form action="index.php?url=reportesPDF&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="categorias">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Ordenar por</label>
                                                        <select name="orden" class="form-select">
                                                            <option value="">Seleccione una opcion</option>
                                                            <option value="productos">Cantidad de Productos</option>
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
                                <div class="col-md-6 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header "
                                            <h5 class="mb-0"><i class="fa fa-industry me-2"></i>Materia Prima</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportesPDF&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="materia_prima">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Nivel de Stock</label>
                                                        <select name="filtro" class="form-select">
                                                            <option value="">Seleccione una opcion</option>
                                                            <option value="bajo">Bajo</option>
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
                                            <h5 class="mb-0"><i class="fa fa-warehouse me-2"></i>Produccion</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportesPDF&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="produccion">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Fecha</label>
                                                          <input class="form-control" type="date" name="fecha">
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
                                <div class="col-md-6 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header "
                                            <h5 class="mb-0"><i class="fa fa-truck me-2"></i>Proveedores</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportesPDF&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="proveedores">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Filtar por:</label>
                                                        <select name="filtro" class="form-select">
                                                            <option value="">Seleccione una opcion</option>
                                                            <option value="materia">Materia Prima</option>
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

                                <!-- Usuarios -->
                                <div class="col-md-6 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-users-cog me-2"></i>Usuarios</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportesPDF&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="usuarios">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Rol</label>
                                                        <select name="filtro" class="form-select">
                                                            <option value="">Seleccione una opcion</option>
                                                            <?php
                                                                if (isset($roles) && is_array($roles) && !empty($roles)) {
                                                                    foreach ($roles as $rol) {
                                                                        echo '<option value="' . $rol['id_rol'] . '">'
                                                                            . $rol['nombre_rol'] . '</option>';
                                                                    }
                                                                }
                                                            ?>
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
                                            <form action="index.php?url=reportesPDF&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="pedidos">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="">Seleccione una opcion</option>
                                                            <?php
                                                                if (isset($estadoPedido) && is_array($estadoPedido) && !empty($estadoPedido)) {
                                                                    foreach ($estadoPedido as $estado) {
                                                                        echo '<option value="' . $estado['id_estado_pedido'] . '">'
                                                                            . $estado['nombre_estado'] . '</option>';
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Filtar por:</label>
                                                        <select name="filtro" class="form-select">
                                                            <option value="">Seleccione una opcion</option>
                                                            <option value="clienteMas">Cliente con mas pedidos</option>
                                                            <option value="clienteMenos">Cliente con menos pedidos</option>
                                                            <option value="conPromo">Con promociones</option>
                                                            <option value="sinPromo">Sin promociones</option>
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

                                <!-- Promociones -->
                                <div class="col-md-4 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header "
                                            <h5 class="mb-0"><i class="fa fa-percent me-2"></i>Promociones</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportesPDF&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="promociones">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="">Seleccione una opcion</option>
                                                            <option value="1">Activa</option>
                                                            <option value="0">Inactiva</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Tipo de Descuento</label>
                                                        <select name="filtro" class="form-select">
                                                            <option value="">Seleccione una opcion</option>
                                                            <option value="porcentaje">Por Porcentaje</option>
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
                                            <form action="index.php?url=reportesPDF&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="compras">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="">Seleccione una opcion</option>
                                                            <<?php
                                                                if (isset($estadoPago) && is_array($estadoPago) && !empty($estadoPago)) {
                                                                    foreach ($estadoPago as $estado) {
                                                                        echo '<option value="' . $estado['id_estado_pago'] . '">'
                                                                            . $estado['nombre_estado'] . '</option>';
                                                                    }
                                                                }
                                                            ?>
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

                                <!-- Pagos -->
                                <div class="col-md-4 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-money-bill-wave me-2"></i>Pagos</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportesPDF&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="pagos">
                                                
                                                <div class="filter-section">
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Cobros -->
                                <div class="col-md-4 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-hand-holding-usd me-2"></i>Cobrar</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportesPDF&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="cobrar">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="">Seleccione una opcion</option>
                                                            <option value="Pagado">Pagado</option>
                                                            <option value="Por Pagar">Por Pagar</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button type="submit" class="btn btn-generate w-100">
                                                    <i class="fas fa-file-pdf me-2"></i>PDF
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                

                                <!-- Pagar -->
                                <div class="col-md-4 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-money-bill-wave me-2"></i>Pagar</h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="index.php?url=reportesPDF&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="pagar">
                                                
                                                <div class="filter-section">
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="">Seleccione una opcion</option>
                                                            <option value="Pagado">Pagadas</option>
                                                            <option value="Por Pagar">Por Pagar</option>
                                                        </select>
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
                                            <form action="index.php?url=reportesPDF&action=pdf" method="GET" target="_blank">
                                                <input type="hidden" name="url" value="reportesPDF">
                                                <input type="hidden" name="action" value="pdf">
                                                <input type="hidden" name="tipo" value="entregas">
                                                
                                                <div class="filter-section">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-2">
                                                            <label class="form-label fw-bold">Fecha</label>
                                                            <input type="date" name="fecha" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="mb-2">
                                                        <label class="form-label fw-bold">Estado de Entrega</label>
                                                        <select name="estado" class="form-select">
                                                            <option value="">Seleccione una opcion</option>
                                                            <<?php
                                                                if (isset($estadoEntrega) && is_array($estadoEntrega) && !empty($estadoEntrega)) {
                                                                    foreach ($estadoEntrega as $estado) {
                                                                        echo '<option value="' . $estado['id_estado_entrega'] . '">'
                                                                            . $estado['nombre_estado'] . '</option>';
                                                                    }
                                                                }
                                                            ?>
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
                                <h4>Otros Documentos</h4>
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
</body>
</html>
