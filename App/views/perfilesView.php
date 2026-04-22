<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Perfiles, Roles y Permisos - Larense C.A</title>
    <?php require_once 'components/links.php'; ?>
    <style>
        body {
            background-color: #f8f9fa;
        }

        /* ===== HEADER ESTILIZADO ===== */
        .page-header-custom {
            background: white;
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .icon-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .icon-circle i {
            font-size: 16px;
        }

        /* ===== CARDS ===== */
        .card-custom {
            border-radius: 12px;
            overflow: hidden;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }

        .card-header-gradient {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            padding: 12px 20px;
        }

        .card-header-gradient h4 {
            color: white;
            font-weight: 600;
            margin: 0;
        }

        /* ===== TABLAS ===== */
        .table-custom thead th {
            background: #f8f9fa;
            color: #dc3545;
            font-weight: 600;
            border-bottom: 2px solid #dc3545;
            padding: 10px 12px;
            text-transform: uppercase;
            font-size: 0.8rem;
            letter-spacing: 0.5px;
        }

        .table-custom tbody td {
            padding: 8px 12px;
            vertical-align: middle;
        }

        .table-custom tbody tr {
            transition: all 0.2s;
        }

        .table-custom tbody tr:hover {
            background: #f8f9fa;
        }

        /* ===== BADGES ===== */
        .badge-custom {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.8rem;
        }

        .badge-rojo {
            background: #dc3545;
            color: white;
        }

        .badge-gris {
            background: #e9ecef;
            color: #495057;
        }

        .badge-activo {
            background: #d4edda;
            color: #155724;
        }

        .badge-inactivo {
            background: #f8d7da;
            color: #721c24;
        }

        /* ===== BOTONES ===== */
        .btn-accion {
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.75rem;
            transition: all 0.2s;
        }

        .btn-ver {
            background: #6c757d;
            color: white;
        }

        .btn-editar {
            background: #17a2b8;
            color: white;
        }

        .btn-eliminar {
            background: #dc3545;
            color: white;
        }

        .btn-restaurar {
            background: #28a745;
            color: white;
        }

        .btn-accion:hover {
            opacity: 0.85;
            color: white;
        }

        .btn-registrar {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .btn-outline-custom {
            border: 1px solid #dc3545;
            color: #dc3545;
            background: transparent;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .btn-outline-custom:hover {
            background: #dc3545;
            color: white;
        }

        .btn-dark-custom {
            background: #1a1a2e;
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.2s;
        }

        .btn-dark-custom:hover {
            background: #2d2d44;
            color: white;
        }

        .btn-registrar:hover {
            opacity: 0.9;
            color: white;
        }

        /* ===== USUARIOS SIDEBAR ===== */
        .users-sidebar {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            overflow: hidden;
            height: calc(50vh - 80px);
            min-height: 280px;
            display: flex;
            flex-direction: column;
        }

        .users-sidebar-header {
            padding: 12px 15px;
            border-bottom: 1px solid #e9ecef;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }

        .users-sidebar-header h5 {
            color: white;
            font-weight: 600;
            margin: 0;
        }

        .users-search {
            padding: 10px 12px;
            border-bottom: 1px solid #e9ecef;
        }

        .users-search input {
            width: 100%;
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #e9ecef;
            background: #f8f9fa;
            font-size: 0.9rem;
        }

        .users-search input:focus {
            outline: none;
            border-color: #dc3545;
            background: white;
        }

        .users-list {
            flex: 1;
            overflow-y: auto;
            padding: 8px;
        }

        .user-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.2s;
            margin-bottom: 4px;
        }

        .user-item:hover {
            background: #f8f9fa;
        }

        .user-item.active {
            background: #fee2e2;
            border: 1px solid #dc3545;
        }

        .user-avatar-placeholder {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 0.85rem;
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            font-weight: 600;
            color: #333;
            font-size: 0.85rem;
        }

        .user-role {
            font-size: 0.75rem;
            color: #6c757d;
        }

        /* ===== DETALLE PANEL ===== */
        .detail-panel {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            padding: 20px;
            min-height: calc(50vh - 80px);
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
        }

        .empty-state-icon {
            width: 60px;
            height: 60px;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        .empty-state-icon i {
            font-size: 1.5rem;
            color: #dc3545;
        }

        .empty-state h4 {
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .empty-state p {
            color: #6c757d;
        }

        /* ===== PERMISOS TABLE ===== */
        .permisos-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            overflow: hidden;
            margin-top: 15px;
        }

        .permisos-header-custom {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            padding: 12px 20px;
            color: white;
        }

        .permisos-header-custom h4 {
            margin: 0;
            font-weight: 600;
        }

        .permiso-check {
            width: 20px;
            height: 20px;
            border-radius: 4px;
            border: 2px solid #dc3545;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.2s;
            color: white;
            font-size: 0.7rem;
        }

        .permiso-check.active {
            background: #dc3545;
        }

        .permiso-check.disabled {
            background: #e9ecef;
            border-color: #e9ecef;
            cursor: not-allowed;
        }

        /* ===== ROLES CARDS ===== */
        .roles-container {
            margin-top: 15px;
        }

        .role-card-custom {
            background: white;
            border-radius: 10px;
            padding: 12px 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
            transition: all 0.2s;
        }

        .role-card-custom:hover {
            border-color: #dc3545;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.15);
        }

        .role-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .role-title {
            font-weight: 600;
            color: #333;
        }

        .role-modules {
            color: #6c757d;
            font-size: 0.8rem;
            margin-bottom: 10px;
        }

        .role-modules strong {
            color: #dc3545;
        }

        /* ===== MODALES ===== */
        .modal-header-custom {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            padding: 20px;
            border: none;
        }

        .modal-title-custom {
            font-weight: 600;
            margin: 0;
        }

        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
        }

        .form-control-custom {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #e9ecef;
        }

        .form-control-custom:focus {
            outline: none;
            border-color: #dc3545;
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        .btn-guardar-custom {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            color: white;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
        }

        .btn-guardar-custom:hover {
            opacity: 0.9;
            color: white;
        }

        /* ===== SIMULACIÓN ALERT ===== */
        .simulation-alert {
            background: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: none;
        }

        .simulation-alert.show {
            display: block;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 768px) {
            .users-sidebar {
                height: auto;
                max-height: 400px;
            }
        }

        /* ==============================================
           ESTILOS MODO OSCURO PARA PERFILES
           ============================================== */
        body.dark-mode {
            background: #12131d !important;
        }

        body.dark-mode .page-header-custom {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body.dark-mode .page-header-custom h4,
        body.dark-mode .page-header-custom .fw-bold {
            color: #e7e9f0 !important;
        }

        body.dark-mode .page-header-custom p {
            color: #9ca3af !important;
        }

        body.dark-mode .card-custom {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body.dark-mode .card-header-gradient h4 {
            color: #e7e9f0 !important;
        }

        body.dark-mode .table-custom thead th {
            background: #131725 !important;
            color: #e7e9f0 !important;
            border-bottom-color: #2a3041 !important;
        }

        body.dark-mode .table-custom tbody td {
            color: #e7e9f0 !important;
            border-bottom-color: #2a3041 !important;
        }

        body.dark-mode .table-custom tbody tr:hover {
            background: rgba(255, 255, 255, 0.05) !important;
        }

        body.dark-mode .users-sidebar {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body.dark-mode .users-sidebar-header {
            background: #1a1f2e !important;
            border-bottom-color: #2a3041 !important;
        }

        body.dark-mode .users-sidebar-header h5 {
            color: #e7e9f0 !important;
        }

        body.dark-mode .users-search input {
            background: #2a3041 !important;
            border-color: #3a4055 !important;
            color: #e7e9f0 !important;
        }

        body.dark-mode .users-search input:focus {
            background: #2a3041 !important;
            border-color: #cc1d1d !important;
        }

        body.dark-mode .user-item:hover {
            background: #2a3041 !important;
        }

        body.dark-mode .user-item.active {
            background: #2a3041 !important;
            border-color: #cc1d1d !important;
        }

        body.dark-mode .user-name {
            color: #e7e9f0 !important;
        }

        body.dark-mode .user-role {
            color: #9ca3af !important;
        }

        body.dark-mode .detail-panel {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body.dark-mode .empty-state h4 {
            color: #e7e9f0 !important;
        }

        body.dark-mode .empty-state p {
            color: #9ca3af !important;
        }

        body.dark-mode .permisos-container {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body.dark-mode .permisos-header-custom {
            background: #1a1f2e !important;
            border-bottom-color: #2a3041 !important;
        }

        body.dark-mode .permisos-header-custom h4 {
            color: #e7e9f0 !important;
        }

        body.dark-mode .role-card-custom {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body.dark-mode .role-card-custom:hover {
            border-color: #cc1d1d !important;
        }

        body.dark-mode .role-title {
            color: #e7e9f0 !important;
        }

        body.dark-mode .role-modules {
            color: #9ca3af !important;
        }

        body.dark-mode .role-modules strong {
            color: #cc1d1d !important;
        }

        body.dark-mode .modal-header-custom {
            background: #1a1f2e !important;
            border-bottom-color: #2a3041 !important;
        }

        body.dark-mode .modal-title-custom {
            color: #e7e9f0 !important;
        }

        body.dark-mode .modal-content {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body.dark-mode .form-label {
            color: #e7e9f0 !important;
        }

        body.dark-mode .form-control-custom {
            background: #2a3041 !important;
            border-color: #3a4055 !important;
            color: #e7e9f0 !important;
        }

        body.dark-mode .form-control-custom:focus {
            background: #2a3041 !important;
            border-color: #cc1d1d !important;
            color: #e7e9f0 !important;
        }

        body.dark-mode .text-muted {
            color: #9ca3af !important;
        }

        body.dark-mode h2,
        body.dark-mode h3 {
            color: #e7e9f0 !important;
        }

        body.dark-mode .btn-close {
            filter: invert(1) brightness(2);
        }
    </style>
</head>
<body>
    <?php require_once 'components/menu.php'; ?>
    <?php require_once 'components/header.php'; ?>

    <!-- Espaciado superior -->
    <div style="padding-top: 120px;"></div>

    <div class="container-fluid px-4">
        <div class="page-inner">

            <!-- Header de página estilizado -->
            <div class="page-header-custom mb-3">
                <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                    <div class="d-flex align-items-center">
                        <div class="icon-circle me-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);">
                            <i class="fas fa-user-shield" style="color: white;"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0" style="color: #333; font-size: 1.1rem;">Seguridad</h4>
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
                    <button class="btn btn-dark-custom"
                        data-bs-toggle="modal"
                        data-bs-target="#rolModal"
                        style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 10px 20px;">
                        <i class="fas fa-user-plus me-1"></i>
                        NUEVO ROL
                    </button>
                </div>
            </div>

            <div class="row">
          <div class="col-md-12">
            <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
              <!-- Header de tabla con color -->
              <div class="card-header py-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none;">
                <div class="d-flex align-items-center justify-content-between">
                  <h4 class="card-title mb-0" style="color: white; font-weight: 600;">
                    <i class="fa fa-list me-2"></i>Registros de Roles
                  </h4>
                </div>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table
                    id="add-row"
                    class="display table table-hover mb-0"
                    style="width: 100%;"
                  >
                    <thead>
                      <tr style="background: #f8f9fa;">
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">ID</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Nombre</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                          <?php 
                //verifica si cliente existe o esta vacia en dado caso que este vacia muestra clientes no 
                // registrados ya que si el usuario que realizo la pedticion no tiene el permiso en cambio 
                // si lo tiene muestra la informacion
                if(isset($roles) && is_array($roles) && !empty($roles)){
                foreach ($roles as $rol): 
            ?>
                          <tr style="transition: all 0.2s;" data-id="<?php echo $rol['id_rol']; ?>">
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                              <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                RL-00<?php echo $rol['id_rol']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <i class="fa fa-tag me-1" style="color: #dc3545;"></i><?php echo $rol['nombre_rol']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <div class="btn-group" role="group">
                                <!-- Ver Detalle -->
                                <a
                                  onclick="VerDetalleRol(<?php echo $rol['id_rol']; ?>)"
                                  data-bs-toggle="modal"
                                  data-bs-target="#rolDetalleModal"      
                                  type="button"
                                  class="btn btn-sm"
                                  title='Ver Detalle'
                                  style="background: #6c757d; color: white; border-radius: 6px 0 0 6px; border: none;"
                                >
                                  <i class="fa fa-eye"></i>
                                </a>
                                <a
                                  onclick="ObtenerRol(<?php echo $rol['id_rol']; ?>)"
                                  data-bs-toggle="modal"
                                  data-bs-target="#rolModalModificar"      
                                  type="button"
                                  class="btn btn-sm"
                                  title='Modificar'
                                  style="background: #ffc107; color: #212529; border: none;"
                                >
                                  <i class="fa fa-edit"></i>
                                </a>
                                <a href="#"
                                  onclick="return EliminarRol(event,<?php echo $$rol['id_rol']; ?>)"
                                  type="button"
                                  data-bs-toggle="tooltip"
                                  class="btn btn-sm"
                                  title='Eliminar'
                                  style="background: #dc3545; color: white; border-radius: 0 6px 6px 0; border: none;"
                                >
                                  <i class="fa fa-trash"></i>
                                </a>
                              </div>
                            </td>
                          </tr>
                        <?php
                        //Imprime esta informacion en caso de estar vacia la variable             
                        endforeach; 
                        } else {
                            echo "<tr><td colspan='6'>No hay registros.</td></tr>";
                        } ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
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
                                <option value="">Seleccione un Rol</option>
                                <option id='id_rol' value=""></option>
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



    <!-- MODAL ROL (Crear/Editar) -->
    <div class="modal fade" id="rolModal" tabindex="-1" aria-labelledby="rolModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
        <form id="formCategoria" onsubmit="return validar_formulario()" method="post" action="index.php?url=roles&action=agregar">
            <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 20px 25px;">
            <h5 class="modal-title" id="categoriaModalLabel" style="color: white; font-weight: 600;">
                <i class="fa fa-plus-circle me-2"></i>Nuevo Rol
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
            <div class="mb-3">
                <label for="nombreRol" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-tag me-2" style="color: #dc3545;"></i>Nombre de Rol *</label>
                <input type="text" class="form-control" id="nombreRol" name="nombreRol" placeholder="Ingrese el nombre del rol" style="border-radius: 8px;" oninput="validar_nombre()" required>
                <span id="errorRol" class="error-messege text-danger small"></span>
            </div>
            <!-- Nota informativa -->
            <div class="alert alert-info d-flex align-items-center" role="alert" style="border-radius: 8px; background: #d1ecf1; border: none;">
                <i class="fa fa-info-circle me-2" style="color: #0c5460;"></i>
                <small style="color: #0c5460;"><strong>Nota:</strong> Los campos marcados con * son obligatorios.</small>
            </div>
            </div>
            <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6; padding: 20px 25px;">
            <button type="button" class="btn" data-bs-dismiss="modal" style="background: #6c757d; color: white; border-radius: 8px; padding: 10px 25px;">
                <i class="fa fa-times me-2"></i>Cancelar
            </button>
            <button type="submit" class="btn" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border-radius: 8px; padding: 10px 25px;">
                <i class="fa fa-save me-2"></i>Guardar
            </button>
            </div>
        </form>
        </div>
    </div>
    </div>

        <!-- Modal Modificar -->
    <div class="modal fade" id="rolModalModificar" tabindex="-1" aria-labelledby="rolModalModificarLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
        <form id="formRolModificar" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=roles&action=modificar">
            <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 20px 25px;">
            <h5 class="modal-title" id="categoriaModalModificarLabel" style="color: white; font-weight: 600;">
                <i class="fa fa-edit me-2"></i>Modificar Rol
            </h5>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
            <input type="hidden" class="form-control" id="id" name="id" placeholder="" required>
            <div class="mb-3">
                <label for="nombreRolEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-tag me-2" style="color: #dc3545;"></i>Nombre de Rol *</label>
                <input type="text" class="form-control" id="nombreRolEdit" name="nombreRol" placeholder="Ingrese el nombre" style="border-radius: 8px;" oninput="validar_nombre_modificado()" required>
                <span id="errorCategoriaEdit" class="error-messege text-danger small"></span>
            </div>
            <!-- Nota informativa -->
            <div class="alert alert-info d-flex align-items-center" role="alert" style="border-radius: 8px; background: #d1ecf1; border: none;">
                <i class="fa fa-info-circle me-2" style="color: #0c5460;"></i>
                <small style="color: #0c5460;"><strong>Nota:</strong> Los campos marcados con * son obligatorios.</small>
            </div>
            </div>
            <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6; padding: 20px 25px;">
            <button type="button" class="btn" data-bs-dismiss="modal" style="background: #6c757d; color: white; border-radius: 8px; padding: 10px 25px;">
                <i class="fa fa-times me-2"></i>Cancelar
            </button>
            <button type="submit" class="btn" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); color: #212529; border-radius: 8px; padding: 10px 25px;">
                <i class="fa fa-edit me-2"></i>Modificar
            </button>
            </div>
        </form>
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

    <script src="assets/js/ajax/permisos_ajax.js"></script>
    <script src="assets/js/ajax/roles_ajax.js"></script>
    <script src="assets/js/animacionesJs/dashboard_perfiles.js"></script>
    <?php require_once 'components/scripts.php'; ?>
    <?php //require_once 'components/footer.php'; ?>
</body>
</html>
