<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Reportes ETD- Sistema Larense</title>
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
                            <h3 class="fw-bold mb-0" style="color: #333;">Generador de Reportes Estadisticos</h3>
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

               <!-- 3. ADMINISTRACION - CATALOGO -->
                <div class="mt-4">
                    <h3 class="mb-3">
                        <i class="fa fa-cog me-2"></i> Administracion - Catalogo
                    </h3>
                    <div class="row">

                                <!-- Clientes -->
                                <div class="col-md-3 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-users me-2"></i>Clientes</h5>
                                        </div>
                                        <div class="card-body">
                                            <button onclick="verReporteGraficoClientes()" class="btn btn-generate w-100">
                                                <i class="fas fa-chart-bar me-2"></i>Ver reporte gráfico
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Tipos Clientes -->
                                <div class="col-md-3 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-users me-2"></i>Tipo Clientes</h5>
                                        </div>
                                        <div class="card-body">
                                            <button onclick="verReporteGraficoTipoClientes()" class="btn btn-generate w-100">
                                                <i class="fas fa-chart-bar me-2"></i>Ver reporte gráfico
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Productos -->
                                <div class="col-md-3 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-box me-2"></i>Productos</h5>
                                        </div>
                                        <div class="card-body">
                                            <button onclick="verReporteGraficoProductos()" class="btn btn-generate w-100">
                                                <i class="fas fa-chart-bar me-2"></i>Ver reporte gráfico
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Categorias -->
                                <div class="col-md-3 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-tags me-2"></i>Categorias</h5>
                                        </div>
                                        <div class="card-body">
                                            <button onclick='verReporteGraficoCategorias()' class="btn btn-generate w-100">
                                                <i class="fas fa-chart-bar me-2"></i>Ver reporte gráfico
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Materia Prima -->
                                <div class="col-md-3 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-industry me-2"></i>Materia Prima</h5>
                                        </div>
                                        <div class="card-body">
                                            <button onclick="verReporteGraficoMateriaPrima()" class="btn btn-generate w-100">
                                                <i class="fas fa-chart-bar me-2"></i>Ver reporte gráfico
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Produccion -->
                                <div class="col-md-3 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-warehouse me-2"></i>Producción</h5>
                                        </div>
                                        <div class="card-body">
                                            <button onclick="verReporteGraficoProduccion()" class="btn btn-generate w-100">
                                                <i class="fas fa-chart-bar me-2"></i>Ver reporte gráfico
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Proveedores -->
                                <div class="col-md-3 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-truck me-2"></i>Proveedores</h5>
                                        </div>
                                        <div class="card-body">
                                            <button onclick="verReporteGraficoProveedores()" class="btn btn-generate w-100">
                                                <i class="fas fa-chart-bar me-2"></i>Ver reporte gráfico
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Usuarios -->
                                <div class="col-md-3 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-users-cog me-2"></i>Usuarios</h5>
                                        </div>
                                        <div class="card-body">
                                            <button onclick="verReporteGraficoUsuarios()" class="btn btn-generate w-100">
                                                <i class="fas fa-chart-bar me-2"></i>Ver reporte gráfico
                                            </button>
                                        </div>
                                    </div>
                                </div>

                      </div>
                </div>

                <!-- 5. FACTURACION / ORDENES -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fa fa-file-invoice-dollar me-2"></i> Facturación / Órdenes</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">

                                <!-- Pedidos -->
                                <div class="col-md-4 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-shopping-cart me-2"></i>Pedidos</h5>
                                        </div>
                                        <div class="card-body">
                                            <button onclick="verReporteGraficoPedidos()" class="btn btn-generate w-100">
                                                <i class="fas fa-chart-bar me-2"></i>Ver reporte gráfico
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Promociones -->
                                <div class="col-md-4 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-percent me-2"></i>Promociones</h5>
                                        </div>
                                        <div class="card-body">
                                            <button onclick="verReporteGraficoPromociones()" class="btn btn-generate w-100">
                                                <i class="fas fa-chart-bar me-2"></i>Ver reporte gráfico
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Compras -->
                                <div class="col-md-4 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-cart-plus me-2"></i>Compras</h5>
                                        </div>
                                        <div class="card-body">
                                            <button onclick="verReporteGraficoCompras()" class="btn btn-generate w-100">
                                                <i class="fas fa-chart-bar me-2"></i>Ver reporte gráfico
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- 6. FINANZAS -->
                <div class="mt-4">
                    <div class="card-header bg-white">
                    <h3 class="mb-3">
                        <i class="fa fa-dollar-sign me-2"></i> Finanzas
                    </h3>
                    <div class="row">

                                <!-- Pagos -->
                                <div class="col-md-4 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-money-bill-wave me-2"></i>Pagos</h5>
                                        </div>
                                        <div class="card-body">
                                            <button onclick="verReporteGraficoPagos()" class="btn btn-generate w-100">
                                                <i class="fas fa-chart-bar me-2"></i>Ver reporte gráfico
                                            </button>
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
                                            <button onclick="verReporteGraficoCobros()" class="btn btn-generate w-100">
                                                <i class="fas fa-chart-bar me-2"></i>Ver reporte gráfico
                                            </button>
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
                                            <button onclick="verReporteGraficoPagar()" class="btn btn-generate w-100">
                                                <i class="fas fa-chart-bar me-2"></i>Ver reporte gráfico
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                    </div>
                </div>

                <!-- 7. LOGISTICA -->
                <div class="card mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fa fa-shipping-fast me-2"></i> Logística</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">

                                <!-- Entregas -->
                                <div class="col-md-6 mb-3">
                                    <div class="card report-card h-100">
                                        <div class="card-header">
                                            <h5 class="mb-0"><i class="fa fa-shipping-fast me-2"></i>Entregas</h5>
                                        </div>
                                        <div class="card-body">
                                            <button onclick="verReporteGraficoEntregas()" class="btn btn-generate w-100">
                                                <i class="fas fa-chart-bar me-2"></i>Ver reporte gráfico
                                            </button>
                                        </div>
                                    </div>
                                </div>                               
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL GENÉRICO PARA REPORTES GRÁFICOS -->
<div class="modal fade" id="reporteModal" tabindex="-1" aria-labelledby="reporteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered"> <!-- modal-xl para más espacio -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="reporteModalLabel">📊 Reporte</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="modalReporteBody">
                <!-- Contenedor dinámico que incluirá gráficos y tablas -->
                <div id="contenidoReporte">
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Cargando...</span>
                        </div>
                        <p>Cargando datos...</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" id="btnExportarPDFModal" class="btn btn-primary">
                    <i class="fas fa-file-pdf me-2"></i>Exportar a PDF
                </button>
            </div>
        </div>
    </div>
</div>

    <?php require_once 'components/scripts.php'; ?>
</body>
</html>
