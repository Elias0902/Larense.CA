<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Documentacion del Sistema - Larense C.A.</title>
    <?php require_once 'components/links.php'; ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .code-block { background: #f8f9fa; border-left: 4px solid #1572E8; padding: 15px; font-family: monospace; font-size: 12px; max-height: 400px; overflow: auto; border-radius: 0 8px 8px 0; }
        .doc-section { margin-bottom: 30px; }
        .module-card { transition: transform 0.2s; border: none; border-radius: 12px; overflow: hidden; }
        .module-card:hover { transform: translateY(-5px); }
        .doc-header { background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%); }
    </style>
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
                        <div class="icon-circle me-3" style="background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                            <i class="fa fa-code" style="color: white; font-size: 20px;"></i>
                        </div>
                        <div>
                            <h3 class="fw-bold mb-0" style="color: #333;">Documentacion del Sistema</h3>
                            <nav aria-label="breadcrumb" class="mt-1">
                                <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #6f42c1;"><i class="icon-home"></i></a></li>
                                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                                    <li class="breadcrumb-item active" style="color: #333;">Documentacion</li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resumen del Sistema -->
            <div class="doc-section">
                <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header py-3" style="background: linear-gradient(135deg, #1572E8 0%, #0d5ab8 100%); border: none;">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle me-3" style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-info-circle" style="color: white; font-size: 18px;"></i>
                            </div>
                            <h4 class="card-title mb-0" style="color: white; font-weight: 600;">Resumen del Sistema</h4>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <p><i class="fa fa-cube text-primary me-2"></i><strong>Nombre:</strong> Sistema de Gestion Larense C.A.</p>
                                <p><i class="fa fa-file-alt text-info me-2"></i><strong>Descripcion:</strong> Sistema integral para la gestion de pedidos, creditos, compras, inventario y facturacion.</p>
                            </div>
                            <div class="col-md-6">
                                <p><i class="fa fa-code text-success me-2"></i><strong>Tecnologias:</strong> PHP 8+, MySQL, Bootstrap 5, JavaScript, Composer</p>
                                <p><i class="fa fa-sitemap text-warning me-2"></i><strong>Arquitectura:</strong> MVC (Modelo-Vista-Controlador)</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Estructura de Carpetas -->
            <div class="doc-section">
                <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header py-3" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); border: none;">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle me-3" style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-folder-tree" style="color: white; font-size: 18px;"></i>
                            </div>
                            <h4 class="card-title mb-0" style="color: white; font-weight: 600;">Estructura del Proyecto</h4>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-6">
                                <pre class="code-block">
/larence/
├── App/
│   ├── controllers/     # Controladores MVC
│   ├── models/          # Modelos de datos
│   └── views/           # Vistas HTML/PHP
├── Assets/              # CSS, JS, Imagenes
├── api/                 # Endpoints API
├── bd/                  # Base de datos / SQL
├── chatbot_service/     # Servicio de chatbot
├── components/          # Componentes reutilizables
├── config/              # Configuracion
├── helpers/             # Funciones auxiliares
├── src/                 # Recursos adicionales
└── vendor/              # Dependencias Composer
                                </pre>
                            </div>
                            <div class="col-md-6">
                                <h5 style="color: #28a745; font-weight: 600;"><i class="fa fa-info-circle me-2"></i>Descripcion de Modulos</h5>
                                <ul class="list-group">
                                    <li class="list-group-item"><i class="fas fa-cube text-primary me-2"></i> <strong>App/</strong> - Logica de negocio (MVC)</li>
                                    <li class="list-group-item"><i class="fas fa-palette text-warning me-2"></i> <strong>Assets/</strong> - Recursos frontend</li>
                                    <li class="list-group-item"><i class="fas fa-database text-info me-2"></i> <strong>bd/</strong> - Scripts SQL</li>
                                    <li class="list-group-item"><i class="fas fa-puzzle-piece text-success me-2"></i> <strong>components/</strong> - Componentes UI</li>
                                    <li class="list-group-item"><i class="fas fa-cog text-secondary me-2"></i> <strong>config/</strong> - Configuracion del sistema</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modulos del Sistema -->
            <div class="doc-section">
                <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header py-3" style="background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); border: none;">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle me-3" style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-th-large" style="color: white; font-size: 18px;"></i>
                            </div>
                            <h4 class="card-title mb-0" style="color: white; font-weight: 600;">Modulos del Sistema</h4>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <div class="card module-card shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="icon-circle mx-auto mb-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-users" style="color: white; font-size: 24px;"></i>
                                        </div>
                                        <h6 class="fw-bold">Clientes</h6>
                                        <small class="text-muted">Gestion de clientes y tipos</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card module-card shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="icon-circle mx-auto mb-3" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-box" style="color: white; font-size: 24px;"></i>
                                        </div>
                                        <h6 class="fw-bold">Productos</h6>
                                        <small class="text-muted">Catalogo y categorias</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card module-card shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="icon-circle mx-auto mb-3" style="background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-shopping-cart" style="color: white; font-size: 24px;"></i>
                                        </div>
                                        <h6 class="fw-bold">Pedidos</h6>
                                        <small class="text-muted">Gestion de pedidos</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card module-card shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="icon-circle mx-auto mb-3" style="background: linear-gradient(135deg, #17a2b8 0%, #117a8b 100%); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-truck" style="color: white; font-size: 24px;"></i>
                                        </div>
                                        <h6 class="fw-bold">Proveedores</h6>
                                        <small class="text-muted">Gestion de proveedores</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card module-card shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="icon-circle mx-auto mb-3" style="background: linear-gradient(135deg, #6c757d 0%, #545b62 100%); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-industry" style="color: white; font-size: 24px;"></i>
                                        </div>
                                        <h6 class="fw-bold">Materia Prima</h6>
                                        <small class="text-muted">Inventario de materiales</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card module-card shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="icon-circle mx-auto mb-3" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-dollar-sign" style="color: white; font-size: 24px;"></i>
                                        </div>
                                        <h6 class="fw-bold">Cuentas por Cobrar</h6>
                                        <small class="text-muted">Gestion de creditos</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card module-card shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="icon-circle mx-auto mb-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-money-bill-wave" style="color: white; font-size: 24px;"></i>
                                        </div>
                                        <h6 class="fw-bold">Cuentas por Pagar</h6>
                                        <small class="text-muted">Pagos a proveedores</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <div class="card module-card shadow-sm">
                                    <div class="card-body text-center">
                                        <div class="icon-circle mx-auto mb-3" style="background: linear-gradient(135deg, #1572E8 0%, #0d5ab8 100%); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                            <i class="fa fa-file-alt" style="color: white; font-size: 24px;"></i>
                                        </div>
                                        <h6 class="fw-bold">Reportes</h6>
                                        <small class="text-muted">Excel, Word, PDF</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Base de Datos -->
            <div class="doc-section">
                <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header py-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none;">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle me-3" style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-database" style="color: white; font-size: 18px;"></i>
                            </div>
                            <h4 class="card-title mb-0" style="color: white; font-weight: 600;">Base de Datos</h4>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted mb-3">Tablas principales del sistema:</p>
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" style="border-radius: 8px; overflow: hidden;">
                                <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                    <tr>
                                        <th style="color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Tabla</th>
                                        <th style="color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Descripcion</th>
                                        <th style="color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Relaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="transition: all 0.2s;">
                                        <td><code style="background: #f8f9fa; padding: 4px 8px; border-radius: 4px;">usuarios</code></td>
                                        <td>Usuarios del sistema</td>
                                        <td><span class="badge" style="background: #e9ecef; color: #495057;">roles, perfiles</span></td>
                                    </tr>
                                    <tr style="transition: all 0.2s;">
                                        <td><code style="background: #f8f9fa; padding: 4px 8px; border-radius: 4px;">clientes</code></td>
                                        <td>Informacion de clientes</td>
                                        <td><span class="badge" style="background: #e9ecef; color: #495057;">tipos_clientes, pedidos</span></td>
                                    </tr>
                                    <tr style="transition: all 0.2s;">
                                        <td><code style="background: #f8f9fa; padding: 4px 8px; border-radius: 4px;">productos</code></td>
                                        <td>Catalogo de productos</td>
                                        <td><span class="badge" style="background: #e9ecef; color: #495057;">categorias, materia_prima</span></td>
                                    </tr>
                                    <tr style="transition: all 0.2s;">
                                        <td><code style="background: #f8f9fa; padding: 4px 8px; border-radius: 4px;">pedidos</code></td>
                                        <td>Registro de pedidos</td>
                                        <td><span class="badge" style="background: #e9ecef; color: #495057;">clientes, detalle_pedidos</span></td>
                                    </tr>
                                    <tr style="transition: all 0.2s;">
                                        <td><code style="background: #f8f9fa; padding: 4px 8px; border-radius: 4px;">proveedores</code></td>
                                        <td>Datos de proveedores</td>
                                        <td><span class="badge" style="background: #e9ecef; color: #495057;">compras, pagos</span></td>
                                    </tr>
                                    <tr style="transition: all 0.2s;">
                                        <td><code style="background: #f8f9fa; padding: 4px 8px; border-radius: 4px;">cuentas_cobrar</code></td>
                                        <td>Cuentas por cobrar</td>
                                        <td><span class="badge" style="background: #e9ecef; color: #495057;">clientes, pagos</span></td>
                                    </tr>
                                    <tr style="transition: all 0.2s;">
                                        <td><code style="background: #f8f9fa; padding: 4px 8px; border-radius: 4px;">cuentas_pagar</code></td>
                                        <td>Cuentas por pagar</td>
                                        <td><span class="badge" style="background: #e9ecef; color: #495057;">proveedores, pagos</span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- API Endpoints -->
            <div class="doc-section">
                <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header py-3" style="background: linear-gradient(135deg, #ffc107 0%, #d39e00 100%); border: none;">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle me-3" style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-plug" style="color: white; font-size: 18px;"></i>
                            </div>
                            <h4 class="card-title mb-0" style="color: white; font-weight: 600;">API Endpoints</h4>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <p class="text-muted mb-3">Endpoints disponibles para integraciones:</p>
                        <pre class="code-block">
POST   /api/auth/login              - Autenticacion de usuarios
POST   /api/auth/logout             - Cierre de sesion
GET    /api/clientes                - Listar clientes
POST   /api/clientes                - Crear cliente
GET    /api/productos               - Listar productos
POST   /api/pedidos                 - Crear pedido
GET    /api/reportes/excel          - Generar reporte Excel
GET    /api/reportes/pdf            - Generar reporte PDF
                        </pre>
                    </div>
                </div>
            </div>

            <!-- Dependencias -->
            <div class="doc-section">
                <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header py-3" style="background: linear-gradient(135deg, #6c757d 0%, #545b62 100%); border: none;">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle me-3" style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-cubes" style="color: white; font-size: 18px;"></i>
                            </div>
                            <h4 class="card-title mb-0" style="color: white; font-weight: 600;">Dependencias (Composer)</h4>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered" style="border-radius: 8px; overflow: hidden;">
                                <thead style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);">
                                    <tr>
                                        <th style="color: #6c757d; font-weight: 600; border-bottom: 2px solid #6c757d;">Paquete</th>
                                        <th style="color: #6c757d; font-weight: 600; border-bottom: 2px solid #6c757d;">Version</th>
                                        <th style="color: #6c757d; font-weight: 600; border-bottom: 2px solid #6c757d;">Proposito</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="transition: all 0.2s;">
                                        <td><code style="background: #f8f9fa; padding: 4px 8px; border-radius: 4px;">phpmailer/phpmailer</code></td>
                                        <td><span class="badge" style="background: #17a2b8; color: white;">^7.0</span></td>
                                        <td>Envio de correos electronicos</td>
                                    </tr>
                                    <tr style="transition: all 0.2s;">
                                        <td><code style="background: #f8f9fa; padding: 4px 8px; border-radius: 4px;">setasign/fpdf</code></td>
                                        <td><span class="badge" style="background: #17a2b8; color: white;">^1.8</span></td>
                                        <td>Generacion de documentos PDF</td>
                                    </tr>
                                    <tr style="transition: all 0.2s;">
                                        <td><code style="background: #f8f9fa; padding: 4px 8px; border-radius: 4px;">phpoffice/phpspreadsheet</code></td>
                                        <td><span class="badge" style="background: #28a745; color: white;">^1.29</span></td>
                                        <td>Generacion de archivos Excel</td>
                                    </tr>
                                    <tr style="transition: all 0.2s;">
                                        <td><code style="background: #f8f9fa; padding: 4px 8px; border-radius: 4px;">phpoffice/phpword</code></td>
                                        <td><span class="badge" style="background: #28a745; color: white;">^0.18</span></td>
                                        <td>Generacion de documentos Word</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Version -->
            <div class="doc-section">
                <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
                    <div class="card-header py-3" style="background: linear-gradient(135deg, #6f42c1 0%, #5a32a3 100%); border: none;">
                        <div class="d-flex align-items-center">
                            <div class="icon-circle me-3" style="background: rgba(255,255,255,0.2); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fa fa-code-branch" style="color: white; font-size: 18px;"></i>
                            </div>
                            <h4 class="card-title mb-0" style="color: white; font-weight: 600;">Version del Sistema</h4>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <div class="row">
                            <div class="col-md-4 text-center mb-3">
                                <div class="icon-circle mx-auto mb-2" style="background: linear-gradient(135deg, #1572E8 0%, #0d5ab8 100%); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-tag" style="color: white; font-size: 24px;"></i>
                                </div>
                                <h5 class="fw-bold text-primary">Version</h5>
                                <p class="mb-0">1.0.0</p>
                            </div>
                            <div class="col-md-4 text-center mb-3">
                                <div class="icon-circle mx-auto mb-2" style="background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-calendar" style="color: white; font-size: 24px;"></i>
                                </div>
                                <h5 class="fw-bold text-success">Ultima Actualizacion</h5>
                                <p class="mb-0"><?php echo date('d/m/Y'); ?></p>
                            </div>
                            <div class="col-md-4 text-center mb-3">
                                <div class="icon-circle mx-auto mb-2" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                    <i class="fa fa-building" style="color: white; font-size: 24px;"></i>
                                </div>
                                <h5 class="fw-bold text-danger">Desarrollado por</h5>
                                <p class="mb-0">Larense C.A.</p>
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
