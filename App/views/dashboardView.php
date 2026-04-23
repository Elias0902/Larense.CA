<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Larense CA Natys 2026</title>
    <?php
    require_once 'components/links.php';
    ?>
    <link rel="stylesheet" href="assets/css/stylesModules/dashboard.css" />
</head>
<body>
    <?php
    require_once 'components/menu.php';
    require_once 'components/header.php';
    ?>
    
    <div class="container">
        <div class="page-inner">
            <!-- Header Moderno -->
            <div class="page-header-modern">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold mb-2">Dashboard</h2>
                        <p class="mb-0 opacity-75">Gestión integral de la empresa Larense C.A</p>
                    </div>
                    <div class="col-md-4 text-md-end mt-3 mt-md-0">
                        <button class="btn btn-light btn-modern me-2">
                            <i class="fas fa-download me-2"></i>Exportar
                        </button>
                        <button class="btn btn-outline-light btn-modern">
                            <i class="fas fa-plus me-2"></i>Nuevo Cliente
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Tarjetas de Estadísticas Modernas -->
            <div class="row mb-4">
                <div class="col-sm-6 col-md-3 mb-3">
                    <div class="card stat-card-1">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="stat-label">Visitantes Totales</p>
                                    <h3 class="stat-number" id="visitantesTotales">1,294</h3>
                                    <small class="trend-up"><i class="fas fa-arrow-up me-1"></i><span id="trendVisitantes">+12.5%</span></small>
                                </div>
                                <div class="icon-big">
                                    <i class="fas fa-users fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-md-3 mb-3">
                    <div class="card stat-card-2">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="stat-label">Suscriptores</p>
                                    <h3 class="stat-number" id="suscriptores">1,303</h3>
                                    <small class="trend-up"><i class="fas fa-arrow-up me-1"></i><span id="trendSuscriptores">+8.2%</span></small>
                                </div>
                                <div class="icon-big">
                                    <i class="fas fa-user-check fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-md-3 mb-3">
                    <div class="card stat-card-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="stat-label">Ventas Totales</p>
                                    <h3 class="stat-number" id="ventasTotales">$1,345</h3>
                                    <small class="trend-up"><i class="fas fa-arrow-up me-1"></i><span id="trendVentas">+23.7%</span></small>
                                </div>
                                <div class="icon-big">
                                    <i class="fas fa-shopping-cart fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-sm-6 col-md-3 mb-3">
                    <div class="card stat-card-4">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="stat-label">Órdenes Activas</p>
                                    <h3 class="stat-number" id="ordenesActivas">576</h3>
                                    <small class="trend-down"><i class="fas fa-arrow-down me-1"></i><span id="trendOrdenes">-3.1%</span></small>
                                </div>
                                <div class="icon-big">
                                    <i class="fas fa-clipboard-list fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Gráficos y Usuarios -->
            <div class="row">
                <div class="col-md-8 mb-4">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title fw-bold mb-1">Estadísticas de Usuarios</h5>
                                    <p class="text-muted small mb-0">Evolución mensual de usuarios activos</p>
                                </div>
                                <div>
                                    <button class="btn btn-sm btn-outline-secondary btn-modern me-2">
                                        <i class="fas fa-download"></i>
                                    </button>
                                    <button class="btn btn-sm btn-outline-secondary btn-modern">
                                        <i class="fas fa-print"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="chart-container" style="min-height: 375px">
                                <canvas id="statisticsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title fw-bold mb-1">Usuarios en Línea</h5>
                                    <p class="text-muted small mb-0">Tiempo real <i class="fas fa-circle text-success" style="font-size: 8px; animation: pulse 2s infinite;"></i></p>
                                </div>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-secondary btn-modern" type="button" data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="#">Ver Detalles</a>
                                        <a class="dropdown-item" href="#">Exportar Reporte</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-4">
                                <h1 class="fw-bold text-success display-3" id="usuariosOnline">17</h1>
                                <p class="text-muted mb-3">Usuarios activos actualmente</p>
                                <div class="row text-center">
                                    <div class="col-4">
                                        <small class="text-muted d-block">Hoy</small>
                                        <strong class="text-success">+24</strong>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted d-block">Esta semana</small>
                                        <strong class="text-primary">+142</strong>
                                    </div>
                                    <div class="col-4">
                                        <small class="text-muted d-block">Mes</small>
                                        <strong class="text-info">+589</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="fas fa-users text-white" style="font-size: 1rem;"></i>
                                    </div>
                                    <div>
                                        <small class="text-muted">Máximo hoy</small>
                                        <p class="mb-0 fw-bold">23 usuarios</p>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <small class="text-muted">Promedio</small>
                                    <p class="mb-0 fw-bold">15 usuarios</p>
                                </div>
                            </div>
                            <div id="lineChart"></div>
                            <div class="mt-3 text-center">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    Actualizado hace <span id="lastUpdate">2</span> segundos
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- 4 Cards del mismo tamaño -->
            <div class="row">
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-transparent">
                            <h5 class="card-title fw-bold mb-0">Categorías de Clientes</h5>
                        </div>
                        <div class="card-body">
                            <?php
                            // Calcular total de clientes para el porcentaje
                            $totalClientes = 0;
                            foreach ($categoriasOrdenadas as $cat) {
                                $totalClientes += intval($cat['total_clientes'] ?? 0);
                            }
                            $totalClientes = max($totalClientes, 1);

                            foreach ($categoriasOrdenadas as $categoria):
                                $color = $categoria['color_config']['color'] ?? '#6c757d';
                                $bg = $categoria['color_config']['bg'] ?? '#6c757d';
                                $cantidad = intval($categoria['total_clientes'] ?? 0);
                                $porcentaje = round(($cantidad / $totalClientes) * 100);
                                $nombre = htmlspecialchars($categoria['categoria'] ?? 'Sin nombre');
                                $textColor = ($nombre === 'Oro') ? '#000' : '#fff';
                            ?>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold" style="color: <?php echo $color; ?>;"><?php echo $nombre; ?></span>
                                    <span class="badge" style="background-color: <?php echo $bg; ?>; color: <?php echo $textColor; ?>;"><?php echo $cantidad; ?></span>
                                </div>
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar" style="width: <?php echo $porcentaje; ?>%; background-color: <?php echo $bg; ?>"></div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-transparent">
                            <h5 class="card-title fw-bold mb-0">Galleta Más Vendida</h5>
                        </div>
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <?php
                                $imagenGalleta = $galletaTop['imagen'] ?? null;
                                $nombreGalleta = htmlspecialchars($galletaTop['nombre'] ?? 'Sin datos');
                                $categoriaGalleta = htmlspecialchars($galletaTop['categoria'] ?? '-');

                                if ($imagenGalleta && file_exists($imagenGalleta)):
                                ?>
                                    <img src="<?php echo $imagenGalleta; ?>" alt="<?php echo $nombreGalleta; ?>" class="mb-3" style="width: 80px; height: 80px; object-fit: cover; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                                <?php else: ?>
                                    <i class="fas fa-cookie-bite fa-3x text-warning mb-3"></i>
                                <?php endif; ?>
                                <h4 class="fw-bold"><?php echo $nombreGalleta; ?></h4>
                                <p class="text-muted small"><?php echo $categoriaGalleta; ?></p>
                            </div>
                            <div class="row text-center">
                                <div class="col-6">
                                    <h5 class="fw-bold text-success"><?php echo number_format($galletaTop['unidades'] ?? 0); ?></h5>
                                    <small class="text-muted">Unidades</small>
                                </div>
                                <div class="col-6">
                                    <h5 class="fw-bold text-primary">$<?php echo $galletaTop['ingresos'] ?? '0.00'; ?></h5>
                                    <small class="text-muted">Ingresos</small>
                                </div>
                            </div>
                            <div class="mt-3">
                                <span class="badge bg-success"><?php echo $galletaTop['variacion'] ?? '+0%'; ?> vs mes anterior</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-transparent">
                            <h5 class="card-title fw-bold mb-0">Roles y Permisos</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3 pb-2 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-0 fw-bold">Administrador</h6>
                                        <small class="text-muted">Control Total</small>
                                    </div>
                                    <i class="fas fa-user-shield text-danger"></i>
                                </div>
                            </div>
                            <div class="mb-3 pb-2 border-bottom">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-0 fw-bold">Vendedor</h6>
                                        <small class="text-muted">Ventas y Pagos</small>
                                    </div>
                                    <i class="fas fa-shopping-cart text-success"></i>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-0 fw-bold">Repartidor</h6>
                                        <small class="text-muted">Entrega</small>
                                    </div>
                                    <i class="fas fa-truck text-info"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-3 mb-4">
                    <div class="card h-100">
                        <div class="card-header bg-transparent">
                            <h5 class="card-title fw-bold mb-0">Tipos de Galleta</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-warning">Chocolate</span>
                                    <span class="badge bg-warning">42</span>
                                </div>
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar bg-warning" style="width: 42%"></div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-secondary">Coco</span>
                                    <span class="badge bg-secondary">28</span>
                                </div>
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar bg-secondary" style="width: 28%"></div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-primary">Mantequilla</span>
                                    <span class="badge bg-primary">19</span>
                                </div>
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar bg-primary" style="width: 19%"></div>
                                </div>
                            </div>
                            <div class="mb-2">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="fw-bold text-success">Vainilla</span>
                                    <span class="badge bg-success">11</span>
                                </div>
                                <div class="progress" style="height: 4px;">
                                    <div class="progress-bar bg-success" style="width: 11%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Mapa y Distribución -->
            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="card-title fw-bold mb-1">
                                        <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                        Distribución Geográfica
                                    </h5>
                                    <p class="text-muted small mb-0">Barquisimeto - Estado Lara (Zonas / Parroquias)</p>
                                </div>
                                <button class="btn btn-sm btn-outline-secondary btn-modern">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="table-responsive">
                                        <table class="table table-modern">
                                            <thead>
                                                <tr>
                                                    <th>Parroquia / Zona</th>
                                                    <th class="text-end">Usuarios</th>
                                                    <th class="text-end">Porcentaje</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr><td>El Cují</td><td class="text-end fw-bold">1,850</td><td class="text-end">28.5%</td><td class="text-end"><div class="progress"><div class="progress-bar bg-primary" style="width: 28.5%"></div></div></td></tr>
                                                <tr><td>Santa Rosa</td><td class="text-end fw-bold">1,420</td><td class="text-end">21.8%</td><td class="text-end"><div class="progress"><div class="progress-bar bg-success" style="width: 21.8%"></div></div></td></tr>
                                                <tr><td>Juan de Villegas</td><td class="text-end fw-bold">1,200</td><td class="text-end">18.4%</td><td class="text-end"><div class="progress"><div class="progress-bar bg-info" style="width: 18.4%"></div></div></td></tr>
                                                <tr><td>Concepción</td><td class="text-end fw-bold">890</td><td class="text-end">13.7%</td><td class="text-end"><div class="progress"><div class="progress-bar bg-warning" style="width: 13.7%"></div></div></td></tr>
                                                <tr><td>Unión</td><td class="text-end fw-bold">620</td><td class="text-end">9.5%</td><td class="text-end"><div class="progress"><div class="progress-bar bg-danger" style="width: 9.5%"></div></div></td></tr>
                                                <tr><td>Tamaca</td><td class="text-end fw-bold">420</td><td class="text-end">6.5%</td><td class="text-end"><div class="progress"><div class="progress-bar bg-secondary" style="width: 6.5%"></div></div></td></tr>
                                                <tr><td>Agua Viva</td><td class="text-end fw-bold">110</td><td class="text-end">1.6%</td><td class="text-end"><div class="progress"><div class="progress-bar bg-dark" style="width: 1.6%"></div></div></td></tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div id="barquisimetoMap" class="map-frame"></div>
                                    <div class="text-center mt-3">
                                        <button class="btn btn-sm btn-outline-primary btn-modern" onclick="resetMap()">
                                            <i class="fas fa-sync-alt me-1"></i>Restablecer Vista
                                        </button>
                                        <button class="btn btn-sm btn-outline-secondary btn-modern ms-2" onclick="toggleHeatmap()">
                                            <i class="fas fa-fire me-1"></i>Mapa de Calor
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Nuevos Clientes y Transacciones -->
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title fw-bold mb-0">Nuevos Clientes</h5>
                                <a href="index.php?ruta=clientes" class="btn btn-sm btn-outline-primary btn-modern">
                                    <i class="fas fa-users me-1"></i>Ver clientes
                                </a>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <?php if (!empty($ultimosClientes)): ?>
                                <?php $contador = 0; foreach ($ultimosClientes as $cliente): $contador++; $esNuevo = ($contador === 1); ?>
                                    <?php
                                    $nombre = htmlspecialchars($cliente['nombre_cliente'] ?? 'Sin nombre');
                                    $tipoCliente = htmlspecialchars($cliente['nombre_tipo_cliente'] ?? 'Cliente');
                                    $imagen = $cliente['img_cliente'] ?? null;

                                    $iniciales = '';
                                    $nombreParts = explode(' ', $nombre);
                                    foreach ($nombreParts as $part) {
                                        if (!empty($part)) {
                                            $iniciales .= strtoupper(substr($part, 0, 1));
                                            if (strlen($iniciales) >= 2) break;
                                        }
                                    }
                                    if (strlen($iniciales) < 1) $iniciales = 'CL';
                                    ?>
                                <div class="d-flex align-items-center p-2 mb-2" style="background: <?php echo $esNuevo ? '#e8f4fd' : '#f8f9fa'; ?>; border-radius: 10px; border-left: <?php echo $esNuevo ? '3px solid #177dff' : '3px solid transparent'; ?>;">
                                    <?php if ($imagen && file_exists($imagen)): ?>
                                        <img src="<?php echo $imagen; ?>" alt="<?php echo $nombre; ?>" style="width: 40px; height: 40px; object-fit: cover; border-radius: 8px; margin-right: 12px;">
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px; border-radius: 8px; background: #6c757d; color: #fff; font-size: 0.85rem; margin-right: 12px;"><?php echo $iniciales; ?></div>
                                    <?php endif; ?>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center">
                                            <?php if ($esNuevo): ?>
                                            <span class="badge bg-primary me-2" style="font-size: 0.6rem;">NUEVO</span>
                                            <?php endif; ?>
                                            <span class="fw-bold" style="font-size: 0.9rem;"><?php echo $nombre; ?></span>
                                        </div>
                                        <small class="text-muted"><?php echo $tipoCliente; ?></small>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="text-center text-muted py-3">
                                    <small>No hay clientes registrados</small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-8 mb-4">
                    <div class="card">
                        <div class="card-header bg-transparent">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title fw-bold mb-0">Historial de Transacciones</h5>
                                <button class="btn btn-sm btn-outline-secondary btn-modern">
                                    <i class="fas fa-ellipsis-v"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-modern mb-0">
                                    <thead>
                                        <tr>
                                            <th>Número de Pago</th>
                                            <th class="text-end">Fecha y Hora</th>
                                            <th class="text-end">Monto</th>
                                            <th class="text-end">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr><th><i class="fas fa-check-circle text-success me-2"></i>Payment #10231</th><td class="text-end">19 Mar 2024, 2:45pm</td><td class="text-end fw-bold">$250.00</td><td class="text-end"><span class="status-badge status-completed">Completado</span></td></tr>
                                        <tr><th><i class="fas fa-check-circle text-success me-2"></i>Payment #10232</th><td class="text-end">19 Mar 2024, 3:15pm</td><td class="text-end fw-bold">$180.00</td><td class="text-end"><span class="status-badge status-completed">Completado</span></td></tr>
                                        <tr><th><i class="fas fa-clock text-warning me-2"></i>Payment #10233</th><td class="text-end">20 Mar 2024, 10:30am</td><td class="text-end fw-bold">$320.00</td><td class="text-end"><span class="status-badge status-pending">Pendiente</span></td></tr>
                                        <tr><th><i class="fas fa-check-circle text-success me-2"></i>Payment #10234</th><td class="text-end">20 Mar 2024, 1:20pm</td><td class="text-end fw-bold">$450.00</td><td class="text-end"><span class="status-badge status-completed">Completado</span></td></tr>
                                        <tr><th><i class="fas fa-check-circle text-success me-2"></i>Payment #10235</th><td class="text-end">21 Mar 2024, 11:45am</td><td class="text-end fw-bold">$210.00</td><td class="text-end"><span class="status-badge status-completed">Completado</span></td></tr>
                                        <tr><th><i class="fas fa-clock text-warning me-2"></i>Payment #10236</th><td class="text-end">21 Mar 2024, 4:00pm</td><td class="text-end fw-bold">$590.00</td><td class="text-end"><span class="status-badge status-pending">Pendiente</span></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'components/footer.php'; ?>
    
    <!-- Scripts -->
    <script src="api/DolarApi.js"></script>
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>
    <script src="assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>
    <script src="assets/js/sweetalert2.min.js"></script>
    <script src="assets/js/Kaiadmin.min.js"></script>
    <script src="assets/js/setting-demo.js"></script>
    <script src="assets/js/demo.js"></script>
    
    <!-- Theme Manager (IMPORTANTE: para el modo oscuro) -->
    <script src="assets/js/theme-manager.js"></script>
    
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <!-- Leaflet JS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <!-- Leaflet Heat Plugin -->
    <script src="https://unpkg.com/leaflet.heat@0.2.0/dist/leaflet-heat.js"></script>
    
    <script>
        $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
            type: "line",
            height: "70",
            width: "100%",
            lineWidth: "2",
            lineColor: "#177dff",
            fillColor: "rgba(23, 125, 255, 0.14)",
        });
        
        // Mapa Interactivo de Barquisimeto
        var map;
        var heatmapLayer;
        var heatData = [];
        
        function initMap() {
            var barquisimetoCenter = [10.0667, -69.3333];
            
            map = L.map('barquisimetoMap').setView(barquisimetoCenter, 12);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap contributors | Larense C.A',
                maxZoom: 18,
            }).addTo(map);
            
            var parroquias = [
                {nombre: 'El Cují', coords: [10.0833, -69.3167], usuarios: 1850, color: '#4285F4'},
                {nombre: 'Santa Rosa', coords: [10.0667, -69.3333], usuarios: 1420, color: '#34A853'},
                {nombre: 'Juan de Villegas', coords: [10.0500, -69.3500], usuarios: 1200, color: '#FBBC05'},
                {nombre: 'Concepción', coords: [10.0800, -69.3200], usuarios: 890, color: '#17A2B8'},
                {nombre: 'Unión', coords: [10.0700, -69.3400], usuarios: 620, color: '#DC3545'},
                {nombre: 'Tamaca', coords: [10.0900, -69.3100], usuarios: 420, color: '#6C757D'},
                {nombre: 'Agua Viva', coords: [10.1000, -69.3000], usuarios: 110, color: '#28A745'}
            ];
            
            parroquias.forEach(function(parroquia) {
                var customIcon = L.divIcon({
                    className: 'custom-marker',
                    html: `<div style="background-color: ${parroquia.color}; color: white; border-radius: 50%; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px; border: 2px solid white; box-shadow: 0 2px 6px rgba(0,0,0,0.3);">${parroquia.usuarios}</div>`,
                    iconSize: [30, 30],
                    iconAnchor: [15, 15]
                });
                
                var marker = L.marker(parroquia.coords, {icon: customIcon}).addTo(map);
                
                marker.bindPopup(`
                    <div style="text-align: center; min-width: 150px;">
                        <h6 style="margin: 0; color: ${parroquia.color}; font-weight: bold;">${parroquia.nombre}</h6>
                        <p style="margin: 5px 0; font-size: 14px;">Usuarios: <strong>${parroquia.usuarios}</strong></p>
                        <small style="color: #666;">${((parroquia.usuarios / 6510) * 100).toFixed(1)}% del total</small>
                    </div>
                `);
                
                for (let i = 0; i < parroquia.usuarios / 50; i++) {
                    heatData.push([
                        parroquia.coords[0] + (Math.random() - 0.5) * 0.02,
                        parroquia.coords[1] + (Math.random() - 0.5) * 0.02,
                        0.5
                    ]);
                }
            });
            
            parroquias.forEach(function(parroquia) {
                L.circle(parroquia.coords, {
                    color: parroquia.color,
                    fillColor: parroquia.color,
                    fillOpacity: 0.1,
                    radius: parroquia.usuarios * 2
                }).addTo(map);
            });
            
            heatmapLayer = L.heatLayer(heatData, {
                radius: 25,
                blur: 15,
                maxZoom: 17,
                gradient: {
                    0.0: 'blue',
                    0.5: 'yellow', 
                    1.0: 'red'
                }
            });
        }
        
        function resetMap() {
            if (map) {
                map.setView([10.0667, -69.3333], 12);
            }
        }
        
        var heatmapVisible = false;
        function toggleHeatmap() {
            if (!map || !heatmapLayer) return;
            if (heatmapVisible) {
                map.removeLayer(heatmapLayer);
                heatmapVisible = false;
            } else {
                heatmapLayer.addTo(map);
                heatmapVisible = true;
            }
        }
        
        function animateNumber(elementId, start, end, duration, prefix = '', suffix = '') {
            const element = document.getElementById(elementId);
            if (!element) return;
            const range = end - start;
            const increment = range / (duration / 16);
            let current = start;
            
            const timer = setInterval(() => {
                current += increment;
                if ((increment > 0 && current >= end) || (increment < 0 && current <= end)) {
                    current = end;
                    clearInterval(timer);
                }
                element.textContent = prefix + Math.floor(current).toLocaleString() + suffix;
                element.classList.add('updating');
                setTimeout(() => element.classList.remove('updating'), 500);
            }, 16);
        }
        
        function updateDynamicData() {
            const visitantesActuales = parseInt(document.getElementById('visitantesTotales')?.textContent.replace(/,/g, '') || '1294');
            const nuevosVisitantes = visitantesActuales + Math.floor(Math.random() * 10) - 3;
            animateNumber('visitantesTotales', visitantesActuales, nuevosVisitantes, 1000);
            
            const trendVisitantes = (Math.random() * 20 - 5).toFixed(1);
            const trendElement = document.getElementById('trendVisitantes');
            if (trendElement) {
                trendElement.textContent = (trendVisitantes > 0 ? '+' : '') + trendVisitantes + '%';
                trendElement.className = trendVisitantes > 0 ? 'trend-up' : 'trend-down';
            }
            
            const suscriptoresActuales = parseInt(document.getElementById('suscriptores')?.textContent.replace(/,/g, '') || '1303');
            const nuevosSuscriptores = suscriptoresActuales + Math.floor(Math.random() * 5) - 2;
            animateNumber('suscriptores', suscriptoresActuales, nuevosSuscriptores, 1000);
            
            const ventasActuales = parseInt(document.getElementById('ventasTotales')?.textContent.replace(/[$,]/g, '') || '1345');
            const nuevasVentas = ventasActuales + Math.floor(Math.random() * 100) - 30;
            animateNumber('ventasTotales', ventasActuales, nuevasVentas, 1000, '$');
            
            const ordenesActuales = parseInt(document.getElementById('ordenesActivas')?.textContent.replace(/,/g, '') || '576');
            const nuevasOrdenes = ordenesActuales + Math.floor(Math.random() * 8) - 4;
            animateNumber('ordenesActivas', ordenesActuales, nuevasOrdenes, 1000);
            
            const usuariosActuales = parseInt(document.getElementById('usuariosOnline')?.textContent || '17');
            const nuevosUsuarios = Math.max(5, usuariosActuales + Math.floor(Math.random() * 6) - 3);
            animateNumber('usuariosOnline', usuariosActuales, nuevosUsuarios, 800);
        }
        
        function updateLastUpdate() {
            const now = new Date();
            const timeString = now.toLocaleTimeString('es-VE', { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            });
            const lastUpdateSpan = document.getElementById('lastUpdate');
            if (lastUpdateSpan) {
                lastUpdateSpan.textContent = timeString;
            }
        }
        
        function showDynamicNotification() {
            const notifications = [
                { type: 'success', icon: 'fa-shopping-cart', message: 'Nueva venta realizada' },
                { type: 'info', icon: 'fa-user-plus', message: 'Nuevo usuario registrado' },
                { type: 'warning', icon: 'fa-exclamation-triangle', message: 'Stock bajo en productos' },
                { type: 'success', icon: 'fa-check-circle', message: 'Pedido completado' },
                { type: 'info', icon: 'fa-chart-line', message: 'Meta de ventas alcanzada' }
            ];
            
            const notification = notifications[Math.floor(Math.random() * notifications.length)];
            
            const notificationEl = document.createElement('div');
            notificationEl.className = `alert alert-${notification.type} alert-dismissible fade show position-fixed`; 
            notificationEl.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px; animation: slideInRight 0.3s ease-out;';
            notificationEl.innerHTML = `
                <i class="fas ${notification.icon} me-2"></i>
                <strong>Notificación:</strong> ${notification.message}
                <small class="d-block mt-1">${new Date().toLocaleTimeString('es-VE')}</small>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            document.body.appendChild(notificationEl);
            
            setTimeout(() => {
                if (notificationEl.parentNode) {
                    notificationEl.remove();
                }
            }, 5000);
        }
        
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(initMap, 100);
            
            updateLastUpdate();
            
            setInterval(updateDynamicData, 5000);
            
            setInterval(() => {
                if (Math.random() > 0.5) {
                    showDynamicNotification();
                }
            }, 20000);
            
            document.querySelectorAll('.stat-card-1, .stat-card-2, .stat-card-3, .stat-card-4').forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease-out';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
            
            // Inicializar gráfico de estadísticas
            var ctx = document.getElementById('statisticsChart')?.getContext('2d');
            if (ctx) {
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                        datasets: [{
                            label: 'Usuarios Activos',
                            data: [65, 78, 90, 105, 98, 112, 125, 138, 145, 158, 162, 175],
                            borderColor: '#cc1d1d',
                            backgroundColor: 'rgba(204, 29, 29, 0.1)',
                            borderWidth: 2,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: true
                    }
                });
            }
        });
        
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>