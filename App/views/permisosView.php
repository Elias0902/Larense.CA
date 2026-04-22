<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Perfiles, Roles y Permisos - Larense C.A</title>
    <?php require_once 'components/links.php'; ?>
</head>
<body>
    <?php require_once 'components/menu.php'; ?>
    <?php require_once 'components/header.php'; ?>

    <!-- Espaciado superior -->
    <div style="padding-top: 120px;"></div>

    <div class="container-fluid px-4">
        <div class="page-inner">
            
            <!-- Alerta de simulación -->
            <div id="simulationAlert" class="simulation-alert">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <i class="fas fa-eye me-2"></i>
                        <strong>Modo Simulación:</strong> Estás viendo el sistema como <span id="simulatedRoleName"></span>
                    </div>
                    <button class="btn btn-sm btn-dark" onclick="restaurarRol()">
                        <i class="fas fa-undo me-1"></i>Restaurar mi rol
                    </button>
                </div>
            </div>

            <!-- Header de página estilizado -->
            <div class="page-header-custom mb-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle me-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                            <i class="fas fa-user-shield" style="color: white;"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0" style="color: #333; font-size: 1.1rem;">Perfiles</h4>
                            <p class="mb-0" style="color: #6c757d; font-size: 0.8rem;">Gestión integral de la empresa Larense C.A</p>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Header de Roles y Permisos con botones de acción -->
            <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <div>
                        <h2 class="mb-0" style="color: #1a1a2e; font-weight: 800; font-size: 1.6rem; letter-spacing: -0.5px;">
                            <span style="color: #1a1a2e;">ROLES</span> <span style="color: #dc3545;">Y PERMISOS</span>
                        </h2>
                        <div style="width: 40px; height: 3px; background: #dc3545; margin-top: 4px;"></div>
                        <p class="mb-0" style="color: #6c757d; font-size: 0.75rem; letter-spacing: 1px; margin-top: 4px; text-transform: uppercase;">Gestión de Acceso y Seguridad</p>
                    </div>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-dark-custom" onclick="abrirModalUsuario()">
                        <i class="fas fa-user-plus me-1"></i>
                        NUEVO USUARIO
                    </button>
                    <button class="btn btn-outline-custom" onclick="abrirModalBibliotecaCasos()">
                        <i class="fas fa-book me-1"></i>
                        BIBLIOTECA DE CASOS
                    </button>
                    <button class="btn btn-outline-secondary" style="border-radius: 20px; font-weight: 600; font-size: 0.85rem; padding: 8px 16px;" onclick="exportarAuditoria()">
                        <i class="fas fa-file-export me-1"></i>
                        EXPORTAR AUDITORÍA
                    </button>
                </div>
            </div>

            <!-- Contenido Principal -->
            <div class="row">
                <!-- Panel Lateral de Usuarios -->
                <div class="col-lg-3 mb-4">
                    <div class="users-sidebar">
                        <div class="users-sidebar-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center gap-2">
                                <h5 style="font-size: 0.8rem; margin: 0;">USUARIOS REGISTRADOS</h5>
                                <i class="fas fa-users" style="font-size: 0.9rem;"></i>
                            </div>
                        </div>
                        <div class="users-search">
                            <div class="position-relative">
                                <i class="fas fa-search position-absolute" style="left: 10px; top: 50%; transform: translateY(-50%); color: #6c757d; font-size: 0.8rem;"></i>
                                <input type="text" id="buscarUsuario" placeholder="Buscar usuario..." onkeyup="filtrarUsuarios()" style="padding-left: 30px;">
                            </div>
                        </div>
                        <div class="users-list" id="usersList">
                            <?php foreach($usuarios as $usuario): ?>
                            <div class="user-item" onclick="seleccionarUsuario(<?php echo $usuario['id_usuario']; ?>)" data-id="<?php echo $usuario['id_usuario']; ?>">
                                <div class="user-avatar-placeholder">
                                    <?php echo strtoupper(substr($usuario['nombre_usuario'], 0, 1)); ?>
                                </div>
                                <div class="user-info">
                                    <div class="user-name"><?php echo strtoupper(htmlspecialchars($usuario['nombre_usuario'])); ?></div>
                                    <div class="user-role"><?php echo htmlspecialchars($usuario['nombre_rol']); ?></div>
                                </div>
                                <i class="fas fa-chevron-right" style="color: #6c757d; font-size: 0.7rem;"></i>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <!-- Panel Central -->
                <div class="col-lg-9">
                    <!-- Panel de Detalle -->
                    <div id="userDetailPanel" class="detail-panel mb-4" style="border: 2px dashed #e9ecef; background: #fafbfc;">
                        <div class="empty-state" style="padding: 60px 20px;">
                            <div style="width: 60px; height: 60px; background: #e9ecef; border-radius: 12px; display: flex; align-items: center; justify-content: center; margin: 0 auto 20px;">
                                <i class="far fa-user" style="font-size: 1.8rem; color: #adb5bd;"></i>
                            </div>
                            <h4 style="color: #adb5bd; font-weight: 600; font-size: 1rem; letter-spacing: 0.5px; text-transform: uppercase;">SELECCIONE UN USUARIO</h4>
                            <p style="color: #adb5bd; font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.3px; max-width: 300px; margin: 0 auto;">Elija un usuario de la lista de la izquierda para gestionar sus detalles y permisos individuales.</p>
                        </div>
                    </div>

                    <!-- Tabla Permisos -->
                    <div class="permisos-container">
                        <div class="permisos-header-custom d-flex justify-content-between align-items-center flex-wrap gap-2" style="background: #f8f9fa; color: #333; padding: 15px 20px;">
                            <div>
                                <h4 style="font-size: 0.95rem; color: #1a1a2e; font-weight: 700; margin: 0; text-transform: uppercase;">MATRIZ DE PERMISOS POR ROL (CRUD)</h4>
                                <small style="color: #6c757d; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.5px;">Configuración Global de Accesos</small>
                            </div>
                            <select id="rolSelectPermisos" class="form-select" style="width: auto; background: white; color: #333; border: 1px solid #dee2e6; font-size: 0.8rem; font-weight: 600; padding: 6px 30px 6px 12px;" oninput="ObtenerPermisosRol(this.value)">
                                <option value="1">SUPER ADMIN</option>
                                <option value="4">Vendedor</option>
                                <option value="3">Repartidor</option>
                                <option value="4">Cliente</option>
                            </select>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-custom mb-0">
                                <thead>
                                    <tr>
                                        <th>Módulo</th>
                                        <th class="text-center">Agregar</th>
                                        <th class="text-center">Consultar</th>
                                        <th class="text-center">Modificar</th>
                                        <th class="text-center">Eliminar</th>
                                    </tr>
                                </thead>
                                <tbody id="tbodyPermisos">

                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- MODAL USUARIO (Crear/Editar) -->
    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border: none;">
                <div class="modal-header-custom">
                    <h5 class="modal-title-custom" id="modalUsuarioTitulo">
                        <i class="fas fa-user-plus me-2"></i>Registrar Usuario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formUsuario">
                        <input type="hidden" name="id_usuario" id="id_usuario">

                        <div class="mb-3">
                            <label class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control form-control-custom" name="nombre_usuario" id="nombre_usuario" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control form-control-custom" name="email_usuario" id="email_usuario" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rol</label>
                            <select class="form-control form-control-custom" name="id_rol" id="id_rol_usuario" required>
                                <option value="">Selecciona un rol</option>
                                <?php foreach($roles as $rol): ?>
                                <option value="<?php echo $rol['id_rol']; ?>"><?php echo htmlspecialchars($rol['nombre_rol']); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contraseña <small class="text-muted" id="passwordHelp">(Dejar en blanco para mantener actual)</small></label>
                            <input type="password" class="form-control form-control-custom" name="password" id="password">
                            <small class="text-muted">Mínimo 6 caracteres, una mayúscula y un punto</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-guardar-custom">
                                <i class="fas fa-save me-2"></i>Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL ROL (Crear/Editar) -->
    <div class="modal fade" id="modalRol" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="border-radius: 12px; border: none;">
                <div class="modal-header-custom">
                    <h5 class="modal-title-custom" id="modalRolTitulo">
                        <i class="fas fa-id-card me-2"></i>Registrar Rol
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formRol">
                        <input type="hidden" name="id_rol" id="id_rol">

                        <div class="mb-3">
                            <label class="form-label">Nombre del Rol</label>
                            <input type="text" class="form-control form-control-custom" name="nombre_rol" id="nombre_rol" required placeholder="Ej: Vendedor, Supervisor, etc.">
                        </div>

                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Al crear un rol nuevo, se inicializarán con permisos de solo lectura en todos los módulos. Luego podrás configurar los permisos CRUD.
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-guardar-custom">
                                <i class="fas fa-save me-2"></i>Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL BIBLIOTECA DE CASOS (Permisos Especiales) -->
    <div class="modal fade" id="modalBibliotecaCasos" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content" style="border-radius: 12px; border: none;">
                <div class="modal-header-custom">
                    <h5 class="modal-title-custom">
                        <i class="fas fa-book me-2"></i>Biblioteca de Casos Especiales
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="alert alert-info mb-3" style="font-size: 0.85rem;">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Casos Especiales:</strong> Gestiona permisos especiales para usuarios que requieren accesos particulares fuera de su rol asignado.
                    </div>

                    <!-- Lista de casos especiales existentes -->
                    <div class="mb-3">
                        <h6 class="fw-bold mb-2" style="font-size: 0.9rem; color: #333;">Casos Registrados</h6>
                        <div id="listaCasosEspeciales" class="list-group" style="max-height: 200px; overflow-y: auto;">
                            <!-- Los casos se cargarán dinámicamente -->
                            <div class="list-group-item d-flex justify-content-between align-items-center" style="padding: 10px 15px;">
                                <div>
                                    <div style="font-weight: 600; font-size: 0.85rem;">Usuario: Carlos Mendez</div>
                                    <small style="color: #6c757d; font-size: 0.75rem;">Permiso especial: Acceso a módulo de Reportes</small>
                                </div>
                                <button class="btn btn-sm btn-outline-danger" onclick="eliminarCasoEspecial(1)" style="font-size: 0.75rem; padding: 3px 8px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                            <div class="list-group-item d-flex justify-content-between align-items-center" style="padding: 10px 15px;">
                                <div>
                                    <div style="font-weight: 600; font-size: 0.85rem;">Usuario: María López</div>
                                    <small style="color: #6c757d; font-size: 0.75rem;">Permiso especial: Acceso temporal a Gestión de Proveedores</small>
                                </div>
                                <button class="btn btn-sm btn-outline-danger" onclick="eliminarCasoEspecial(2)" style="font-size: 0.75rem; padding: 3px 8px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <hr class="my-3">

                    <!-- Formulario para nuevo caso especial -->
                    <h6 class="fw-bold mb-3" style="font-size: 0.9rem; color: #333;">Registrar Nuevo Caso Especial</h6>
                    <form id="formCasoEspecial">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-size: 0.8rem; font-weight: 600;">Usuario</label>
                                <select class="form-control form-control-custom" id="casoUsuario" required style="font-size: 0.85rem;">
                                    <option value="">Selecciona un usuario</option>
                                    <?php foreach($usuarios as $usuario): ?>
                                    <option value="<?php echo $usuario['id_usuario']; ?>"><?php echo htmlspecialchars($usuario['nombre_usuario']); ?> (<?php echo htmlspecialchars($usuario['nombre_rol']); ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-size: 0.8rem; font-weight: 600;">Módulo a Habilitar</label>
                                <select class="form-control form-control-custom" id="casoModulo" required style="font-size: 0.85rem;">
                                    <option value="">Selecciona un módulo</option>
                                    <option value="clientes">Clientes</option>
                                    <option value="productos">Productos</option>
                                    <option value="pedidos">Pedidos</option>
                                    <option value="pagos">Pagos</option>
                                    <option value="usuarios">Usuarios y Permisos</option>
                                    <option value="bitacora">Bitácora</option>
                                    <option value="proveedores">Gestión de Proveedores</option>
                                    <option value="compras">Compras / Materia Prima</option>
                                    <option value="promociones">Promociones y Descuentos</option>
                                    <option value="reportes">Reportes</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-size: 0.8rem; font-weight: 600;">Tipo de Permiso</label>
                                <select class="form-control form-control-custom" id="casoTipoPermiso" required style="font-size: 0.85rem;">
                                    <option value="lectura">Solo Lectura</option>
                                    <option value="total">CRUD Completo (Crear, Leer, Actualizar, Eliminar)</option>
                                    <option value="personalizado">Personalizado</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-size: 0.8rem; font-weight: 600;">Vigencia</label>
                                <select class="form-control form-control-custom" id="casoVigencia" required style="font-size: 0.85rem;">
                                    <option value="permanente">Permanente</option>
                                    <option value="temporal">Temporal (30 días)</option>
                                    <option value="sesion">Solo esta sesión</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label" style="font-size: 0.8rem; font-weight: 600;">Motivo / Justificación</label>
                            <textarea class="form-control form-control-custom" id="casoMotivo" rows="2" placeholder="Describe el motivo de este permiso especial..." required style="font-size: 0.85rem;"></textarea>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="font-size: 0.85rem;">Cerrar</button>
                            <button type="submit" class="btn btn-guardar-custom" style="font-size: 0.85rem;">
                                <i class="fas fa-save me-2"></i>Guardar Caso Especial
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- TEMPLATE PARA DETALLE DE USUARIO -->
    <template id="userDetailTemplate">
        <div class="has-content w-100">
            <div class="d-flex align-items-center gap-4 mb-4">
                <div id="detailAvatar" style="width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: 600;"></div>
                <div>
                    <h3 id="detailName" class="mb-1" style="font-size: 1.5rem; font-weight: 700; color: #333;"></h3>
                    <div class="d-flex gap-2 align-items-center">
                        <span id="detailRole" class="badge badge-custom"></span>
                        <span id="detailStatus" class="badge badge-custom"></span>
                    </div>
                </div>
            </div>

            <div class="row mb-4">
                <div class="col-md-6 mb-3">
                    <div style="font-size: 0.75rem; color: #6c757d; text-transform: uppercase; margin-bottom: 4px;">ID de Usuario</div>
                    <div id="detailId" style="font-weight: 600; color: #333;"></div>
                </div>
                <div class="col-md-6 mb-3">
                    <div style="font-size: 0.75rem; color: #6c757d; text-transform: uppercase; margin-bottom: 4px;">Correo Electrónico</div>
                    <div id="detailEmail" style="font-weight: 600; color: #333;"></div>
                </div>
                <div class="col-md-6 mb-3">
                    <div style="font-size: 0.75rem; color: #6c757d; text-transform: uppercase; margin-bottom: 4px;">Último Acceso</div>
                    <div id="detailLastAccess" style="font-weight: 600; color: #333;"></div>
                </div>
            </div>

            <div class="d-flex gap-2 mb-4">
                <button class="btn btn-registrar" id="btnEditarUsuario">
                    <i class="fas fa-edit me-2"></i>Editar Usuario
                </button>
                <button class="btn btn-outline-danger" id="btnEliminarUsuario">
                    <i class="fas fa-trash me-2"></i>Eliminar
                </button>
            </div>

            <!-- Botones de simulación (solo para administradores) -->
            <div id="simulationButtons" class="pt-4 border-top">
                <h6 style="font-size: 0.875rem; color: #6c757d; margin-bottom: 12px;">
                    <i class="fas fa-eye me-2"></i>Simular Vista de Usuario
                </h6>
                <div class="d-flex gap-2 flex-wrap">
                    <button class="btn btn-outline-secondary btn-sm" onclick="simularRol(3)">
                        <i class="fas fa-store me-1"></i>Ver como Vendedor
                    </button>
                    <button class="btn btn-outline-secondary btn-sm" onclick="simularRol(4)">
                        <i class="fas fa-user me-1"></i>Ver como Usuario
                    </button>
                </div>
            </div>
        </div>
    </template>

    <script src="assets/js/ajax/permisos_ajax.js"></script>
    <script src="assets/js/animacionesJs/dashboard_permisos.js"></script>
    <?php require_once 'components/scripts.php'; ?>
    <?php require_once 'components/footer.php'; ?>
</body>
</html>