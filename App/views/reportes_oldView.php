<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Reportes - Sistema Larense</title>
    <?php require_once 'components/links.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <?php require_once 'components/menu.php'; ?>
    <?php require_once 'components/header.php'; ?>

    <div style="padding-top: 120px;"></div>

    <div class="container-fluid px-4">
        <div class="page-inner">
            
            <!-- Header de pagina estilizado -->
            <div class="page-header-custom mb-4">
                <div class="d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle me-3" style="background: linear-gradient(135deg, #1572E8 0%, #0d5ab8 100%); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fa fa-file-alt" style="color: white; font-size: 20px;"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0" style="color: #333;">Modulo de Reportes</h3>
                            <nav aria-label="breadcrumb" class="mt-1">
                                <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #1572E8;"><i class="icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                                    <li class="breadcrumb-item active" style="color: #333;">Reportes</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCION: DASHBOARD & ESTADISTICAS -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                        <div class="card-header py-3" style="background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%); border: none;">
                            <h4 class="card-title mb-0" style="color: white; font-weight: 600;">
                                <i class="fa fa-tachometer-alt me-2"></i>Dashboard & Estadisticas Generales
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-chart-line" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #6f42c1;">Resumen de Dashboard</h5>
                                            </div>
                                            <p class="text-muted small">Estadisticas generales del sistema, graficos y metricas principales.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=dashboard" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=word&tipo=dashboard" class="btn btn-primary btn-sm" style="flex: 1;"><i class="fas fa-file-word"></i> Word</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=dashboard" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #e83e8c 0%, #d11a6e 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-shopping-bag" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #e83e8c;">Reporte Ecommerce</h5>
                                            </div>
                                            <p class="text-muted small">Ventas online, carritos abandonados, conversiones y metricas de tienda.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=ecommerce" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=word&tipo=ecommerce" class="btn btn-primary btn-sm" style="flex: 1;"><i class="fas fa-file-word"></i> Word</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=ecommerce" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCION: NOTIFICACIONES -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                        <div class="card-header py-3" style="background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); border: none;">
                            <h4 class="card-title mb-0" style="color: white; font-weight: 600;">
                                <i class="fa fa-bell me-2"></i>Notificaciones
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-bell" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #17a2b8;">Historial de Notificaciones</h5>
                                            </div>
                                            <p class="text-muted small">Reporte de notificaciones enviadas, alertas y mensajes del sistema.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=notificaciones" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=word&tipo=notificaciones" class="btn btn-primary btn-sm" style="flex: 1;"><i class="fas fa-file-word"></i> Word</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=notificaciones" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCION: ADMINISTRACION -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                        <div class="card-header py-3" style="background: linear-gradient(135deg, #fd7e14 0%, #e56b0a 100%); border: none;">
                            <h4 class="card-title mb-0" style="color: white; font-weight: 600;">
                                <i class="fa fa-cog me-2"></i>Administracion
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <!-- Catalogo -->
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-users" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #dc3545;">Clientes</h5>
                                            </div>
                                            <p class="text-muted small">Reportes completos de clientes registrados en el sistema.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=clientes" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=clientes" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-box" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #28a745;">Productos</h5>
                                            </div>
                                            <p class="text-muted small">Catalogo de productos, categorias y precios.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=productos" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=productos" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #6c757d 0%, #545b62 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-users-cog" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #6c757d;">Usuarios</h5>
                                            </div>
                                            <p class="text-muted small">Usuarios del sistema, roles y permisos asignados.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=usuarios" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=usuarios" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #20c997 0%, #17a689 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-tags" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #20c997;">Categorias</h5>
                                            </div>
                                            <p class="text-muted small">Categorias de productos y clasificacion.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=categorias" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=categorias" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <!-- Inventario y Socios -->
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-warehouse" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #6f42c1;">Inventario</h5>
                                            </div>
                                            <p class="text-muted small">Stock actual, movimientos de inventario y alertas de bajo stock.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=inventario" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=inventario" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-industry" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #ffc107;">Materia Prima</h5>
                                            </div>
                                            <p class="text-muted small">Inventario de materiales y recursos de produccion.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=materia_prima" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=materia_prima" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-truck" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #17a2b8;">Proveedores</h5>
                                            </div>
                                            <p class="text-muted small">Proveedores registrados, contactos y evaluaciones.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=proveedores" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=proveedores" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCION: FACTURACION / ORDENES -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                        <div class="card-header py-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none;">
                            <h4 class="card-title mb-0" style="color: white; font-weight: 600;">
                                <i class="fa fa-file-invoice-dollar me-2"></i>Facturacion / Ordenes
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-shopping-cart" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #dc3545;">Pedidos</h5>
                                            </div>
                                            <p class="text-muted small">Historial de pedidos, estados y detalles de compras.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=pedidos" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=pedidos" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #e83e8c 0%, #d11a6e 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-percent" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #e83e8c;">Promociones</h5>
                                            </div>
                                            <p class="text-muted small">Promociones activas, descuentos aplicados y campanas.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=promociones" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=promociones" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-cart-plus" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #6f42c1;">Compras</h5>
                                            </div>
                                            <p class="text-muted small">Ordenes de compra a proveedores y recepciones.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=compras" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=compras" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCION: FINANZAS -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                        <div class="card-header py-3" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); border: none;">
                            <h4 class="card-title mb-0" style="color: white; font-weight: 600;">
                                <i class="fa fa-dollar-sign me-2"></i>Finanzas
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-hand-holding-usd" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #28a745;">Cobros</h5>
                                            </div>
                                            <p class="text-muted small">Cuentas por cobrar y pagos recibidos.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=cobros" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=cobros" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-money-bill-wave" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #dc3545;">Pagos</h5>
                                            </div>
                                            <p class="text-muted small">Cuentas por pagar y pagos a proveedores.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=pagos" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=pagos" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-file-invoice" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #17a2b8;">Facturas</h5>
                                            </div>
                                            <p class="text-muted small">Facturas emitidas y estados de pago.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=facturas" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=facturas" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-chart-pie" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #6f42c1;">Estado de Cuenta</h5>
                                            </div>
                                            <p class="text-muted small">Balance general y estado financiero.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=estado_cuenta" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=estado_cuenta" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCION: LOGISTICA -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                        <div class="card-header py-3" style="background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); border: none;">
                            <h4 class="card-title mb-0" style="color: white; font-weight: 600;">
                                <i class="fa fa-shipping-fast me-2"></i>Logistica
                            </h4>
                        </div>
                        <div class="card-body p-4">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-shipping-fast" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #17a2b8;">Entregas</h5>
                                            </div>
                                            <p class="text-muted small">Historial de entregas, estados de envio y transportistas.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=entregas" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=word&tipo=entregas" class="btn btn-primary btn-sm" style="flex: 1;"><i class="fas fa-file-word"></i> Word</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=entregas" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="card h-100 shadow-sm border-0" style="border-radius: 10px;">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <div class="icon-circle me-3" style="background: linear-gradient(135deg, #6c757d 0%, #545b62 100%); width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fa fa-truck-loading" style="color: white; font-size: 18px;"></i>
                                                </div>
                                                <h5 class="mb-0 fw-bold" style="color: #6c757d;">Produccion</h5>
                                            </div>
                                            <p class="text-muted small">Ordenes de produccion y estado de fabricacion.</p>
                                            <div class="d-flex gap-2">
                                                <a href="index.php?url=reportes&action=excel&tipo=produccion" class="btn btn-success btn-sm" style="flex: 1;"><i class="fas fa-file-excel"></i> Excel</a>
                                                <a href="index.php?url=reportes&action=word&tipo=produccion" class="btn btn-primary btn-sm" style="flex: 1;"><i class="fas fa-file-word"></i> Word</a>
                                                <a href="index.php?url=reportes&action=pdf&tipo=produccion" class="btn btn-danger btn-sm" style="flex: 1;"><i class="fas fa-file-pdf"></i> PDF</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reportes Parametrizados y Estadisticas -->
            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                        <div class="card-header py-3" style="background: linear-gradient(135deg, #1572E8 0%, #0d5ab8 100%); border: none;">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle me-3" style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-filter" style="color: white; font-size: 18px;"></i>
                                </div>
                                <h4 class="card-title mb-0" style="color: white; font-weight: 600;">Reportes Parametrizados</h4>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <form id="formReporteParametrizado">
                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="color: #1572E8;"><i class="fa fa-list me-2"></i>Tipo de Reporte</label>
                                    <select class="form-select" id="tipoReporte" style="border-radius: 8px; border: 2px solid #e9ecef;">
                                        <option value="">Seleccione...</option>
                                        <option value="clientes">Clientes</option>
                                        <option value="productos">Productos</option>
                                        <option value="pedidos">Pedidos</option>
                                        <option value="ventas">Ventas</option>
                                        <option value="inventario">Inventario</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold" style="color: #1572E8;"><i class="fa fa-calendar me-2"></i>Fecha Desde</label>
                                        <input type="date" class="form-control" id="fechaDesde" style="border-radius: 8px; border: 2px solid #e9ecef;">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold" style="color: #1572E8;"><i class="fa fa-calendar me-2"></i>Fecha Hasta</label>
                                        <input type="date" class="form-control" id="fechaHasta" style="border-radius: 8px; border: 2px solid #e9ecef;">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold" style="color: #1572E8;"><i class="fa fa-download me-2"></i>Formato de Exportacion</label>
                                    <div class="d-flex gap-2">
                                        <button type="button" class="btn btn-success" onclick="generarReporte('excel')" style="flex: 1; border-radius: 8px;">
                                            <i class="fas fa-file-excel"></i> Excel
                                        </button>
                                        <button type="button" class="btn btn-primary" onclick="generarReporte('word')" style="flex: 1; border-radius: 8px;">
                                            <i class="fas fa-file-word"></i> Word
                                        </button>
                                        <button type="button" class="btn btn-danger" onclick="generarReporte('pdf')" style="flex: 1; border-radius: 8px;">
                                            <i class="fas fa-file-pdf"></i> PDF
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                        <div class="card-header py-3" style="background: linear-gradient(135deg, #6c757d 0%, #545b62 100%); border: none;">
                            <div class="d-flex align-items-center">
                                <div class="icon-circle me-3" style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-chart-line" style="color: white; font-size: 18px;"></i>
                                </div>
                                <h4 class="card-title mb-0" style="color: white; font-weight: 600;">Estadisticas Rapidas</h4>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="list-group list-group-flush">
                                <a href="index.php?url=reportes&action=excel&tipo=clientes" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                                    <div class="icon-circle me-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-users" style="color: white; font-size: 16px;"></i>
                                    </div>
                                    <span class="fw-bold">Total de Clientes Activos</span>
                                    <span class="ms-auto badge" style="background: #dc3545; color: white;">Excel</span>
                                </a>
                                <a href="index.php?url=reportes&action=excel&tipo=productos" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                                    <div class="icon-circle me-3" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-box" style="color: white; font-size: 16px;"></i>
                                    </div>
                                    <span class="fw-bold">Stock de Productos</span>
                                    <span class="ms-auto badge" style="background: #28a745; color: white;">Excel</span>
                                </a>
                                <a href="index.php?url=reportes&action=excel&tipo=pedidos" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                                    <div class="icon-circle me-3" style="background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-shopping-cart" style="color: white; font-size: 16px;"></i>
                                    </div>
                                    <span class="fw-bold">Pedidos del Mes</span>
                                    <span class="ms-auto badge" style="background: #ffc107; color: white;">Excel</span>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                                    <div class="icon-circle me-3" style="background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-dollar-sign" style="color: white; font-size: 16px;"></i>
                                    </div>
                                    <span class="fw-bold">Ventas Totales</span>
                                    <span class="ms-auto badge" style="background: #17a2b8; color: white;">Proximamente</span>
                                </a>
                                <a href="#" class="list-group-item list-group-item-action d-flex align-items-center py-3">
                                    <div class="icon-circle me-3" style="background: linear-gradient(135deg, #fd7e14 0%, #e56b0a 100%); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                        <i class="fa fa-exclamation-triangle" style="color: white; font-size: 16px;"></i>
                                    </div>
                                    <span class="fw-bold">Productos con Bajo Stock</span>
                                    <span class="ms-auto badge" style="background: #fd7e14; color: white;">Proximamente</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'components/scripts.php'; ?>
    <script>
        function generarReporte(formato) {
            const tipo = document.getElementById('tipoReporte').value;
            if (!tipo) {
                alert('Seleccione un tipo de reporte');
                return;
            }
            window.location.href = 'index.php?url=reportes&action=' + formato + '&tipo=' + tipo;
        }
    </script>
</body>
</html>
