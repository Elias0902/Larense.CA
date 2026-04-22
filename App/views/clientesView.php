<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Clientes</title>
    <?php
    require_once 'components/links.php';
    ?>
    <link rel="stylesheet" href="assets/css/validaciones.css" />
    <style>
        /* ==============================================
           ESTILOS PERSONALIZADOS PARA SELECT E INPUTS
           ============================================== */
        
        /* Estilos para los select */
        .form-select {
            padding: 12px 40px 12px 16px;
            font-size: 14px;
            font-weight: 500;
            color: #495057;
            background-color: #fff;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23dc3545' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 12px center;
            background-size: 16px 12px;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            appearance: none;
            min-height: 48px;
        }

        .form-select:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
            background-color: #fff;
        }

        .form-select:hover {
            border-color: #dc3545;
        }

        /* Estilos para los inputs de texto */
        .form-control {
            padding: 12px 16px;
            font-size: 14px;
            font-weight: 500;
            color: #495057;
            background-color: #fff;
            border: 2px solid #dee2e6;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.15);
            background-color: #fff;
        }

        .form-control:hover {
            border-color: #dc3545;
        }

        /* Estilos para el input de archivo (imagen) */
        .form-control[type="file"] {
            padding: 10px;
            cursor: pointer;
            background-color: #f8f9fa;
            border: 2px dashed #dee2e6;
        }

        .form-control[type="file"]:hover {
            border-color: #dc3545;
            background-color: #fff5f5;
        }

        /* Estilos para labels */
        .form-label {
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            display: block;
        }

        /* Estilos para el contenedor del input de imagen */
        .image-upload-container {
            border: 2px dashed #dee2e6;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            background: #f8f9fa;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .image-upload-container:hover {
            border-color: #dc3545;
            background: #fff5f5;
        }

        .image-upload-container input[type="file"] {
            display: none;
        }

        .image-upload-label {
            cursor: pointer;
            color: #666;
            font-weight: 500;
        }

        .image-upload-label i {
            font-size: 32px;
            color: #dc3545;
            margin-bottom: 10px;
            display: block;
        }

        /* ==============================================
           ESTILOS MODO OSCURO PARA CLIENTES
           ============================================== */
        body.dark-mode {
            background: #12131d !important;
        }

        body.dark-mode .page-header-custom {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body.dark-mode .page-header-custom h3,
        body.dark-mode .page-header-custom .fw-bold {
            color: #e7e9f0 !important;
        }

        body.dark-mode .breadcrumb-item a {
            color: #9ca3af !important;
        }

        body.dark-mode .breadcrumb-item.active {
            color: #e7e9f0 !important;
        }

        body.dark-mode .card {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body.dark-mode .card-header {
            background: transparent !important;
            border-bottom-color: #2a3041 !important;
        }

        body.dark-mode .card-title,
        body.dark-mode .card-header h4 {
            color: #e7e9f0 !important;
        }

        body.dark-mode .table thead th {
            background: #131725 !important;
            color: #e7e9f0 !important;
            border-bottom-color: #2a3041 !important;
        }

        body.dark-mode .table tbody td {
            color: #e7e9f0 !important;
            border-bottom-color: #2a3041 !important;
        }

        body.dark-mode .table tbody tr:hover {
            background: rgba(255, 255, 255, 0.05) !important;
        }

        body.dark-mode .badge {
            background: #2a3041 !important;
            color: #e7e9f0 !important;
        }

        body.dark-mode .modal-content {
            background: #1a1f2e !important;
            border-color: #2a3041 !important;
        }

        body.dark-mode .modal-header {
            background: transparent !important;
            border-bottom-color: #2a3041 !important;
        }

        body.dark-mode .modal-title {
            color: #e7e9f0 !important;
        }

        body.dark-mode .modal-body {
            background: #1a1f2e !important;
        }

        body.dark-mode .form-label {
            color: #e7e9f0 !important;
        }

        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background: #2a3041 !important;
            border-color: #3a4055 !important;
            color: #e7e9f0 !important;
        }

        body.dark-mode .form-control:focus,
        body.dark-mode .form-select:focus {
            background: #2a3041 !important;
            border-color: #cc1d1d !important;
            color: #e7e9f0 !important;
        }

        body.dark-mode .text-muted {
            color: #9ca3af !important;
        }

        body.dark-mode .alert-info {
            background: #1a4a5a !important;
            color: #6bc2d1 !important;
            border-color: #1a5a6a !important;
        }

        body.dark-mode .btn-close {
            filter: invert(1) brightness(2);
        }

        body.dark-mode .image-upload-container {
            background: #2a3041 !important;
            border-color: #3a4055 !important;
        }

        body.dark-mode .image-upload-container:hover {
            border-color: #dc3545 !important;
            background: #3a3041 !important;
        }

        body.dark-mode .image-upload-label {
            color: #9ca3af !important;
        }
    </style>
  </head>
  <body>
    <?php
    require_once 'components/menu.php';
    require_once 'components/header.php';
    ?>

    <!-- Espaciado superior para evitar choque con header -->
    <div style="padding-top: 120px;"></div>

    <div class="container-fluid px-4">
      <div class="page-inner">
        
        <!-- Header de página estilizado -->
        <div class="page-header-custom mb-4">
          <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
              <div class="icon-circle me-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fa fa-users" style="color: white; font-size: 20px;"></i>
              </div>
              <div>
                <h3 class="fw-bold mb-0" style="color: #333;">Gestión de Clientes</h3>
                <nav aria-label="breadcrumb" class="mt-1">
                  <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #dc3545;"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: #333;">Clientes</li>
                  </ol>
                </nav>
              </div>
            </div>
            <button
              class="btn btn-danger btn-round shadow-sm"
              data-bs-toggle="modal"
              data-bs-target="#clienteModal"
              style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 10px 20px;"
            >
              <i class="fa fa-plus me-2"></i>
              Registrar Cliente
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
                    <i class="fa fa-list me-2"></i>Registros de Clientes
                  </h4>
                  <div class="btn-group" id="filtrosClientes">
                    <button class="btn btn-sm filtro-btn" data-filtro="todos" style="background: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.5); color: white; font-weight: 500;">
                      <i class="fa fa-filter me-1"></i> Todos
                    </button>
                    <button class="btn btn-sm filtro-btn active" data-filtro="Activo" style="background: white; border: none; color: #dc3545; font-weight: 600;">
                      <i class="fa fa-check-circle me-1"></i> Activos
                    </button>
                    <button class="btn btn-sm filtro-btn" data-filtro="Pendiente" style="background: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.5); color: white; font-weight: 500;">
                      <i class="fa fa-clock me-1"></i> Pendientes
                    </button>
                    <button class="btn btn-sm filtro-btn" data-filtro="Anulado" style="background: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.5); color: white; font-weight: 500;">
                      <i class="fa fa-ban me-1"></i> Anulados
                    </button>
                  </div>
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
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Imagen</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Nombre</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Tipo</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Estado</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Teléfono</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Correo</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Dirección</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                          <?php 
                //verifica si cliente existe o esta vacia en dado caso que este vacia muestra clientes no 
                // registrados ya que si el usuario que realizo la pedticion no tiene el permiso en cambio 
                // si lo tiene muestra la informacion
                if(isset($clientes) && is_array($clientes) && !empty($clientes)){
                foreach ($clientes as $cliente): 
            ?>
                          <tr style="transition: all 0.2s;" data-estado="<?php echo $cliente['estado_cliente']; ?>" data-id="<?php echo $cliente['id_cliente']; ?>">
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                              <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                <?php echo $cliente['tipo_id'] . '-'  . $cliente['id_cliente']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <img src="<?php echo $cliente['img_cliente']; ?>" 
                                   style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #f0f0f0; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <?php echo $cliente['nombre_cliente']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge" style="background: #e9ecef; color: #495057; padding: 6px 12px; border-radius: 20px;">
                                <?php echo $cliente['nombre_tipo_cliente']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;" id='status'>
                              <?php 
                              $estadoClass = '';
                              $estadoIcon = '';
                              switch($cliente['estado_cliente']) {
                                case 'Activo':
                                  $estadoClass = 'background: #d4edda; color: #155724;';
                                  $estadoIcon = 'fa-check-circle';
                                  break;
                                case 'Pendiente':
                                  $estadoClass = 'background: #fff3cd; color: #856404;';
                                  $estadoIcon = 'fa-clock';
                                  break;
                                case 'Anulado':
                                  $estadoClass = 'background: #f8d7da; color: #721c24;';
                                  $estadoIcon = 'fa-ban';
                                  break;
                                default:
                                  $estadoClass = 'background: #e9ecef; color: #495057;';
                                  $estadoIcon = 'fa-question';
                              }
                              ?>
                              <span class="badge" style="<?php echo $estadoClass; ?> padding: 6px 12px; border-radius: 20px; font-weight: 500;">
                                <i class="fa <?php echo $estadoIcon; ?> me-1"></i><?php echo $cliente['estado_cliente']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666;">
                              <i class="fa fa-phone me-1" style="color: #dc3545;"></i><?php echo $cliente['tlf_cliente']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666;">
                              <i class="fa fa-envelope me-1" style="color: #dc3545;"></i><?php echo $cliente['email_cliente']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666; max-width: 200px;" class="text-truncate">
                              <i class="fa fa-map-marker me-1" style="color: #dc3545;"></i><?php echo $cliente['direccion_cliente']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <div class="btn-group" role="group">
                                <!-- Ver Detalle -->
                                <a
                                  onclick="VerDetalleCliente(<?php echo $cliente['id_cliente']; ?>)"
                                  data-bs-toggle="modal"
                                  data-bs-target="#clienteDetalleModal"      
                                  type="button"
                                  class="btn btn-sm"
                                  title='Ver Detalle'
                                  style="background: #6c757d; color: white; border-radius: 6px 0 0 6px; border: none;"
                                >
                                  <i class="fa fa-eye"></i>
                                </a>
                                <?php if ($cliente['estado_cliente'] == 'Anulado'): ?>
                                  <!-- Anulado: Solo Editar y Restaurar -->
                                  <a
                                    onclick="ObtenerCliente(<?php echo $cliente['id_cliente']; ?>)"
                                    data-bs-toggle="modal"
                                    data-bs-target="#clienteModalModificar"      
                                    type="button"
                                    class="btn btn-sm"
                                    title='Modificar'
                                    style="background: #17a2b8; color: white; border: none;"
                                  >
                                    <i class="fa fa-edit"></i>
                                  </a>
                                  <a href="#"
                                    onclick="return RestaurarCliente(event,<?php echo $cliente['id_cliente']; ?>)"
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    class="btn btn-sm"
                                    title='Restaurar'
                                    style="background: #28a745; color: white; border-radius: 0 6px 6px 0; border: none;"
                                  >
                                    <i class="fa fa-undo"></i>
                                  </a>
                                <?php elseif ($cliente['estado_cliente'] == 'Pendiente'): ?>
                                  <!-- Pendiente: Editar, Aprobar y Eliminar -->
                                  <a
                                    onclick="ObtenerCliente(<?php echo $cliente['id_cliente']; ?>)"
                                    data-bs-toggle="modal"
                                    data-bs-target="#clienteModalModificar"      
                                    type="button"
                                    class="btn btn-sm"
                                    title='Modificar'
                                    style="background: #17a2b8; color: white; border: none;"
                                  >
                                    <i class="fa fa-edit"></i>
                                  </a>
                                  <a href="#"
                                    onclick="return AprobarCliente(event,<?php echo $cliente['id_cliente']; ?>)"
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    class="btn btn-sm"
                                    title='Aprobar'
                                    style="background: #28a745; color: white; border: none;"
                                  >
                                    <i class="fa fa-check"></i>
                                  </a>
                                  <a href="#"
                                    onclick="return EliminarCliente(event,<?php echo $cliente['id_cliente']; ?>)"
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    class="btn btn-sm"
                                    title='Eliminar'
                                    style="background: #dc3545; color: white; border-radius: 0 6px 6px 0; border: none;"
                                  >
                                    <i class="fa fa-trash"></i>
                                  </a>
                                <?php else: ?>
                                  <!-- Activo: Editar y Eliminar (eliminación lógica) -->
                                  <a
                                    onclick="ObtenerCliente(<?php echo $cliente['id_cliente']; ?>)"
                                    data-bs-toggle="modal"
                                    data-bs-target="#clienteModalModificar"      
                                    type="button"
                                    class="btn btn-sm"
                                    title='Modificar'
                                    style="background: #17a2b8; color: white; border: none;"
                                  >
                                    <i class="fa fa-edit"></i>
                                  </a>
                                  <a href="#"
                                    onclick="return EliminarCliente(event,<?php echo $cliente['id_cliente']; ?>)"
                                    type="button"
                                    data-bs-toggle="tooltip"
                                    class="btn btn-sm"
                                    title='Eliminar'
                                    style="background: #dc3545; color: white; border-radius: 0 6px 6px 0; border: none;"
                                  >
                                    <i class="fa fa-trash"></i>
                                  </a>
                                <?php endif; ?>
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

          <!-- Paginación -->
          <div class="row mt-3">
            <div class="col-12">
              <div class="d-flex justify-content-between align-items-center">
                <span style="color: #666;">Mostrando 1 a 2 de 2 registros</span>
                <div class="btn-group">
                  <button class="btn btn-outline-secondary btn-sm" disabled>Anterior</button>
                  <button class="btn btn-danger btn-sm">1</button>
                  <button class="btn btn-outline-secondary btn-sm" disabled>Siguiente</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="text-center mt-4 mb-4">
          <a href="index.php?url=dashboard" class="btn btn-secondary" style="border-radius: 8px; padding: 10px 20px;">
            <i class="fa fa-home me-2"></i>Menú Principal
          </a>
        </div>

<?php
require_once 'components/footer.php';
require_once 'components/scripts.php';
?>


<!-- Modal Agregar -->
<div class="modal fade" id="clienteModal" tabindex="-1" aria-labelledby="clienteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formCliente" enctype="multipart/form-data" onsubmit="return validar_formulario()" method="post" action="index.php?url=clientes&action=agregar">
        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="clienteModalLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-plus-circle me-2"></i>Nuevo Cliente
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-id-card me-2" style="color: #dc3545;"></i>RIF del Cliente *</label>
                  <div>
                    <select name="tipo_id" id="tipo_id" class="form-select mb-2" oninput='validar_tipo_rif()' required>
                      <option value="">Seleccione el tipo</option>
                      <option value="V">V - Venezolano</option>
                      <option value="E">E - Extranjero</option>
                      <option value="J">J - Jurídico</option>
                      <option value="G">G - Gobierno</option>
                      <option value="C">C - Comunal</option>
                    </select>
                    <input type="text" class="form-control" id="rifCliente" name="rifCliente" placeholder="Número de RIF" oninput="validar_rif()" required>
                  </div>
                  <span id="errorRif" class="error-messege text-danger small"></span>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="nombreCliente" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-user me-2" style="color: #dc3545;"></i>Nombre del Cliente *</label>
                  <input type="text" class="form-control" id="nombreCliente" name="nombreCliente" placeholder="Ingrese el nombre completo" style="border-radius: 8px;" oninput="validar_nombre()" required>
                  <span id="errorCliente" class="error-messege text-danger small"></span>
                </div>
              </div>

              <div class="row">
                <?php if($_SESSION['s_usuario']['rol_usuario'] === 'Superusuario'): ?>
                <div class="col-md-6 mb-3">
                  <label for="tipoCliente" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-tags me-2" style="color: #dc3545;"></i>Tipo de Cliente *</label>
                  <select class="form-select" id="tipoCliente" name="tipoCliente" style="border-radius: 8px;" oninput='validar_tipo_cliente()' required>
                    <option value="">Seleccione el tipo</option>
                    <?php foreach ($tipoClientes as $tipo): ?>
                    <option value="<?php echo $tipo['id_tipo_cliente'] ?>"><?php echo $tipo['nombre_tipo_cliente'] ?></option>
                    <?php endforeach; ?>
                  </select>
                  <span id="errorTipoCliente" class="error-messege text-danger small"></span>
                </div>
                <?php endif; ?>

                <div class="col-md-6 mb-3">
                  <label for="tlfCliente" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-phone me-2" style="color: #dc3545;"></i>Teléfono *</label>
                  <input type="text" class="form-control" id="tlfCliente" name="tlfCliente" placeholder="Ingrese el teléfono" style="border-radius: 8px;" oninput="validar_telefono()" required>
                  <span id="errorTelefono" class="error-messege text-danger small"></span>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="emailCliente" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-envelope me-2" style="color: #dc3545;"></i>Correo Electrónico *</label>
                  <input type="email" class="form-control" id="emailCliente" name="emailCliente" placeholder="ejemplo@correo.com" style="border-radius: 8px;" oninput="validar_email()" required>
                  <span id="errorEmail" class="error-messege text-danger small"></span>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="direccionCliente" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-map-marker me-2" style="color: #dc3545;"></i>Dirección *</label>
                  <input type="text" class="form-control" id="direccionCliente" name="direccionCliente" placeholder="Ingrese la dirección completa" style="border-radius: 8px;" oninput="validar_direccion()" required>
                  <span id="errorDireccion" class="error-messege text-danger small"></span>
                </div>
              </div>

              <?php if($_SESSION['s_usuario']['rol_usuario'] === 'Superusuario'): ?>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="estadoCliente" class='form-label' style="color: #333; font-weight: 500;"><i class="fa fa-check-circle me-2" style="color: #dc3545;"></i>Estado del Cliente *</label>
                  <select name="estadoCliente" id="estadoCliente" class='form-select' style="border-radius: 8px;" oninput='validar_esatdo_cliente()' required>
                      <option value="">Seleccione el estado</option>
                      <option value="Pendiente">Pendiente</option>
                      <option value="Activo">Activo</option>
                      <option value="Anulado">Anulado</option>
                  </select>
                  <span id="errorEstado" class="error-messege text-danger small"></span>
                </div>
              </div>
              <?php endif; ?>

              <div class="mb-3">
                <label class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-image me-2" style="color: #dc3545;"></i>Imagen del Cliente *</label>
                <div class="image-upload-container">
                  <input type="file" id="imgCliente" name="imgCliente" accept="image/*" oninput='validar_img()' required>
                  <label for="imgCliente" class="image-upload-label">
                    <i class="fa fa-cloud-upload-alt"></i>
                    <span>Haz clic para seleccionar una imagen</span>
                  </label>
                </div>
                <div class="form-text text-muted mt-2">Seleccione una imagen de perfil para el cliente (JPG, PNG, GIF)</div>
                <span id="errorImagen" class="error-messege text-danger small"></span>
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
            <i class="fa fa-save me-2"></i>Guardar Cliente
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Modificar -->
<div class="modal fade" id="clienteModalModificar" tabindex="-1" aria-labelledby="clienteModalModificarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formClienteModificar" enctype="multipart/form-data" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=clientes&action=modificar">
        <input type="hidden" id="idClienteEdit" name="idClienteEdit">
        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="clienteModalModificarLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-edit me-2"></i>Modificar Cliente
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-id-card me-2" style="color: #dc3545;"></i>RIF del Cliente</label>
                  <div>
                    <input type="text" class="form-control mb-2" id="tipo_idEditDisplay" style="background: #e9ecef;" readonly>
                    <input type="hidden" name="tipo_idEdit" id="tipo_idEdit">
                    <input type="text" class="form-control" id="rifClienteEdit" name="rifClienteEdit" placeholder="Número de RIF" style="background: #e9ecef;" readonly>
                  </div>
                  <small class="text-muted">El RIF no puede modificarse</small>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="nombreClienteEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-user me-2" style="color: #dc3545;"></i>Nombre del Cliente *</label>
                  <input type="text" class="form-control" id="nombreClienteEdit" name="nombreClienteEdit" placeholder="Ingrese el nombre completo" style="border-radius: 8px;" oninput="validar_nombre_modificado()" required>
                  <span id="errorClienteEdit" class="error-messege text-danger small"></span>
                </div>
              </div>

              <div class="row">
                <?php if($_SESSION['s_usuario']['rol_usuario'] === 'Superusuario'): ?>
                <div class="col-md-6 mb-3">
                  <label for="tipoClienteEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-tags me-2" style="color: #dc3545;"></i>Tipo de Cliente *</label>
                  <select class="form-select" id="tipoClienteEdit" name="tipoClienteEdit" style="border-radius: 8px;" oninput="validar_tipo_cliente_modificado()" required>
                    <?php foreach ($tipoClien as $tipo): ?>
                    <option value="<?php echo $tipo['id_tipo_cliente'] ?>"><?php echo $tipo['nombre_tipo_cliente'] ?></option>
                    <?php endforeach; ?>
                  </select>
                  <span id="errorTipoClienteEdit" class="error-messege text-danger small"></span>
                </div>
                <?php endif; ?>

                <div class="col-md-6 mb-3">
                  <label for="tlfClienteEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-phone me-2" style="color: #dc3545;"></i>Teléfono *</label>
                  <input type="text" class="form-control" id="tlfClienteEdit" name="tlfClienteEdit" placeholder="Ingrese el teléfono" style="border-radius: 8px;" oninput="validar_telefono_modificado()" required>
                  <span id="errorTelefonoEdit" class="error-messege text-danger small"></span>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="emailClienteEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-envelope me-2" style="color: #dc3545;"></i>Correo Electrónico *</label>
                  <input type="email" class="form-control" id="emailClienteEdit" name="emailClienteEdit" placeholder="ejemplo@correo.com" style="border-radius: 8px;" oninput="validar_email_modificado()" required>
                  <span id="errorEmailEdit" class="error-messege text-danger small"></span>
                </div>

                <div class="col-md-6 mb-3">
                  <label for="direccionClienteEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-map-marker me-2" style="color: #dc3545;"></i>Dirección *</label>
                  <input type="text" class="form-control" id="direccionClienteEdit" name="direccionClienteEdit" placeholder="Ingrese la dirección completa" style="border-radius: 8px;" oninput="validar_direccion_modificado()" required>
                  <span id="errorDireccionEdit" class="error-messege text-danger small"></span>
                </div>
              </div>

              <?php if($_SESSION['s_usuario']['rol_usuario'] === 'Superusuario'): ?>
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="estadoClienteEdit" class='form-label' style="color: #333; font-weight: 500;"><i class="fa fa-check-circle me-2" style="color: #dc3545;"></i>Estado del Cliente *</label>
                  <select name="estadoClienteEdit" id="estadoClienteEdit" class='form-select' style="border-radius: 8px;" oninput='validar_esatdo_cliente_modificado()' required>
                      <option value="">Seleccione el estado</option>
                      <option value="Pendiente">Pendiente</option>
                      <option value="Activo">Activo</option>
                      <option value="Anulado">Anulado</option>
                  </select>
                  <span id="errorEstadoEdit" class="error-messege text-danger small"></span>
                </div>
              </div>
              <?php endif; ?>

              <!-- Imagen del cliente -->
              <div class="row mb-3">
                <div class="col-md-12">
                  <label class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-image me-2" style="color: #dc3545;"></i>Imagen del Cliente</label>
                  <div class="d-flex align-items-center gap-3">
                    <img id="imgPreviewEdit" src="" alt="Imagen actual" style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #dc3545; box-shadow: 0 2px 8px rgba(0,0,0,0.15);">
                    <div class="flex-grow-1">
                      <div class="image-upload-container" style="padding: 15px;">
                        <input type="file" id="imgClienteEdit" name="imgClienteEdit" accept="image/*" onchange="previewImageEdit(this)">
                        <label for="imgClienteEdit" class="image-upload-label">
                          <i class="fa fa-cloud-upload-alt"></i>
                          <span>Haz clic para cambiar la imagen (opcional)</span>
                        </label>
                      </div>
                      <div class="form-text text-muted mt-2">Seleccione una nueva imagen solo si desea cambiarla. Deje vacío para mantener la actual.</div>
                    </div>
                  </div>
                </div>
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
            <i class="fa fa-edit me-2"></i>Modificar Cliente
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="assets/js/validaciones/clientes_validaciones.js"></script>
<script src="assets/js/validaciones/clientes_validaciones_status.js"></script>
<script src="assets/js/ajax/clientes_ajax.js"></script>

<!-- Modal Ver Detalle Cliente -->
<div class="modal fade" id="clienteDetalleModal" tabindex="-1" aria-labelledby="clienteDetalleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
      
      <!-- Header -->
      <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 25px; position: relative;">
        <div class="d-flex align-items-center w-100">
          <img id="detalleImgCliente" src="" alt="" style="width: 70px; height: 70px; border-radius: 50%; border: 4px solid white; object-fit: cover; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
          <div class="ms-3" style="color: white;">
            <h4 class="mb-0 fw-bold" id="detalleNombreCliente">Nombre Cliente</h4>
            <small class="opacity-75" id="detalleRifCliente">V-12345678</small>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar" style="position: absolute; top: 20px; right: 20px;"></button>
      </div>

      <!-- Body -->
      <div class="modal-body p-4" style="background: #f8f9fa;">
        
        <!-- Tarjetas de info -->
        <div class="row mb-4">
          <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
              <div class="card-body text-center p-3">
                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Categoría</small>
                <div class="mt-2">
                  <span id="detalleCategoria" class="badge" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); color: white; padding: 8px 20px; border-radius: 20px; font-size: 0.9rem;">ORO</span>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
              <div class="card-body text-center p-3">
                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Días Crédito</small>
                <div class="mt-2">
                  <h4 class="mb-0 fw-bold text-dark" id="detalleDiasCredito">30</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
              <div class="card-body text-center p-3">
                <small class="text-muted text-uppercase fw-bold" style="font-size: 0.7rem; letter-spacing: 1px;">Reputación</small>
                <div class="mt-2">
                  <h4 class="mb-0 fw-bold" style="color: #ffc107;"><i class="fa fa-star me-1"></i><span id="detalleReputacion">9.8</span></h4>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Desempeño de Pago -->
        <div class="mb-4">
          <div class="d-flex justify-content-between align-items-center mb-2">
            <div>
              <h6 class="fw-bold mb-0 text-dark">DESEMPEÑO DE PAGO</h6>
              <small class="text-muted">Basado en el historial de pedidos finalizados</small>
            </div>
            <div class="text-end">
              <span class="badge" style="background: #00c9a7; color: white; padding: 5px 12px; border-radius: 15px;">EXCELENTE</span>
            </div>
          </div>
          <div class="progress" style="height: 12px; border-radius: 10px; background: #e9ecef;">
            <div class="progress-bar" role="progressbar" style="width: 85%; background: linear-gradient(90deg, #00c9a7 0%, #00c9a7 70%, #ffc107 70%, #ffc107 90%, #dc3545 90%); border-radius: 10px;"></div>
          </div>
          <div class="d-flex justify-content-between mt-2" style="font-size: 0.75rem;">
            <span class="text-muted">A TIEMPO <strong>(85%)</strong></span>
            <span class="text-muted">PRÓRROGA <strong>(10%)</strong></span>
            <span class="text-muted">VENCIDO <strong>(5%)</strong></span>
          </div>
        </div>

        <!-- Progreso de Fidelización -->
        <div class="card border-0 mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);">
          <div class="card-body p-3">
            <div class="d-flex align-items-center">
              <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; background: #dc3545;">
                <i class="fa fa-chart-line text-white"></i>
              </div>
              <div>
                <h6 class="fw-bold mb-1 text-dark">PROGRESO DE FIDELIZACIÓN</h6>
                <p class="mb-0 text-muted" style="font-size: 0.85rem;">
                  Este cliente ha pagado <strong>12 pedidos</strong> a tiempo. Faltan <strong style="color: #dc3545;">3 pagos puntuales</strong> adicionales para subir a categoría <strong>PREMIUM</strong> y aumentar sus días de crédito.
                </p>
              </div>
            </div>
          </div>
        </div>

        <!-- Créditos Activos y Deuda -->
        <div class="card border-0" style="border-radius: 15px; background: linear-gradient(135deg, #fff5f5 0%, #ffe0e0 100%); border: 2px solid #dc3545;">
          <div class="card-body p-4">
            <div class="row text-center">
              <div class="col-6">
                <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px; color: #666;">Créditos Activos</small>
                <h2 class="mt-2 mb-0 fw-bold" style="color: #dc3545;" id="detalleCreditosActivos">1</h2>
              </div>
              <div class="col-6" style="border-left: 2px solid #dc3545;">
                <small class="text-muted text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px; color: #666;">Deuda Total</small>
                <h2 class="mt-2 mb-0 fw-bold" style="color: #28a745;" id="detalleDeudaTotal">$150.50</h2>
              </div>
            </div>
          </div>
        </div>

        <!-- Info adicional -->
        <div class="row mt-4">
          <div class="col-md-6">
            <div class="d-flex align-items-center mb-2">
              <i class="fa fa-phone me-2" style="color: #dc3545;"></i>
              <span class="text-muted" id="detalleTelefono">+58 412-1234567</span>
            </div>
            <div class="d-flex align-items-center">
              <i class="fa fa-envelope me-2" style="color: #dc3545;"></i>
              <span class="text-muted" id="detalleEmail">cliente@email.com</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex align-items-start">
              <i class="fa fa-map-marker me-2 mt-1" style="color: #dc3545;"></i>
              <span class="text-muted" id="detalleDireccion">Dirección completa del cliente</span>
            </div>
          </div>
        </div>

      </div>

      <!-- Footer -->
      <div class="modal-footer" style="background: #f1f3f4; border-top: none; padding: 20px;">
        <button type="button" class="btn w-100 fw-bold" data-bs-dismiss="modal" style="background: #e8eaed; color: #5f6368; border: none; border-radius: 12px; padding: 12px; letter-spacing: 1px;">
          CERRAR DETALLE
        </button>
      </div>
    </div>
  </div>
</div>

<script>
// Función para ver detalle del cliente
function VerDetalleCliente(id) {
    // Aquí puedes hacer una petición AJAX para obtener los detalles del cliente
    // Por ahora, cargamos los datos de la fila como ejemplo
    const fila = document.querySelector(`tr[data-id='${id}']`);
    if (fila) {
        // En una implementación real, estos datos vendrían de una petición AJAX
        document.getElementById('detalleNombreCliente').textContent = fila.querySelector('td:nth-child(3)').textContent.trim();
        document.getElementById('detalleRifCliente').textContent = fila.querySelector('td:nth-child(1) .badge').textContent.trim();
        document.getElementById('detalleImgCliente').src = fila.querySelector('td:nth-child(2) img').src;
    }
}

// Funcionalidad de filtros de clientes
document.addEventListener('DOMContentLoaded', function() {
    const filtroBtns = document.querySelectorAll('#filtrosClientes .filtro-btn');
    const filasClientes = document.querySelectorAll('#add-row tbody tr');
    
    // Función para aplicar filtro
    function aplicarFiltro(filtro) {
        filasClientes.forEach(fila => {
            const estado = fila.getAttribute('data-estado');
            if (filtro === 'todos' || estado === filtro) {
                fila.style.display = '';
            } else {
                fila.style.display = 'none';
            }
        });
        actualizarContador();
    }
    
    filtroBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filtro = this.getAttribute('data-filtro');
            
            // Actualizar estilo de botones
            filtroBtns.forEach(b => {
                b.style.background = 'rgba(255,255,255,0.3)';
                b.style.border = '1px solid rgba(255,255,255,0.5)';
                b.style.color = 'white';
                b.classList.remove('active');
            });
            
            // Resaltar botón activo
            this.style.background = 'white';
            this.style.border = 'none';
            this.style.color = '#dc3545';
            this.classList.add('active');
            
            // Filtrar filas
            aplicarFiltro(filtro);
        });
    });
    
    // Función para actualizar el contador
    function actualizarContador() {
        const visibles = document.querySelectorAll('#add-row tbody tr:not([style*="display: none"])');
        const total = document.querySelectorAll('#add-row tbody tr');
        const contador = document.querySelector('.d-flex.justify-content-between.align-items-center span');
        if (contador) {
            contador.textContent = `Mostrando ${visibles.length} de ${total.length} registros`;
        }
    }
    
    // Por defecto, filtrar Activos al cargar la página
    aplicarFiltro('Activo');
});

// Función para restaurar cliente (cambiar de Anulado a Activo)
function RestaurarCliente(event, id) {
    event.preventDefault();
    if (confirm('¿Estás seguro de que deseas restaurar este cliente?')) {
        // Aquí puedes hacer una petición AJAX para cambiar el estado
        // o redirigir a una URL específica
        window.location.href = 'index.php?url=clientes&action=restaurar&id=' + id;
    }
    return false;
}

// Función para aprobar cliente (cambiar de Pendiente a Activo)
function AprobarCliente(event, id) {
    event.preventDefault();
    if (confirm('¿Estás seguro de que deseas aprobar este cliente?')) {
        // Aquí puedes hacer una petición AJAX para cambiar el estado
        // o redirigir a una URL específica
        window.location.href = 'index.php?url=clientes&action=aprobar&id=' + id;
    }
    return false;
}

// Función para previsualizar imagen seleccionada en el modal de editar
function previewImageEdit(input) {
    const preview = document.getElementById('imgPreviewEdit');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Cargar datos en el modal de editar cuando se abre
document.getElementById('clienteModalModificar').addEventListener('show.bs.modal', function (event) {
    // El botón que activó el modal
    const button = event.relatedTarget;
    // Extraer el ID del atributo onclick
    const onclickAttr = button.getAttribute('onclick');
    const match = onclickAttr.match(/ObtenerCliente\((\d+)\)/);
    if (match) {
        const id = match[1];
        const fila = document.querySelector(`tr[data-id='${id}']`);
        if (fila) {
            // Cargar la imagen actual en el preview
            const imgSrc = fila.querySelector('td:nth-child(2) img').src;
            document.getElementById('imgPreviewEdit').src = imgSrc;
            
            // Cargar ID del cliente en el campo hidden
            document.getElementById('idClienteEdit').value = id;
            
            // Extraer tipo_id y número de RIF del badge (formato: V-12345678)
            const rifTexto = fila.querySelector('td:nth-child(1) .badge').textContent.trim();
            const partesRif = rifTexto.split('-');
            if (partesRif.length >= 2) {
                const tipoId = partesRif[0]; // V, E, J, G, C
                const numeroRif = partesRif[1]; // 12345678
                
                // Llenar campos de tipo_id
                document.getElementById('tipo_idEditDisplay').value = tipoId;
                document.getElementById('tipo_idEdit').value = tipoId;
                
                // Llenar campo de número de RIF
                document.getElementById('rifClienteEdit').value = numeroRif;
            }
            
            // Llenar otros campos desde la fila
            document.getElementById('nombreClienteEdit').value = fila.querySelector('td:nth-child(3)').textContent.trim();
            document.getElementById('tlfClienteEdit').value = fila.querySelector('td:nth-child(6)').textContent.replace(/\s+/g, ' ').trim();
            document.getElementById('emailClienteEdit').value = fila.querySelector('td:nth-child(7)').textContent.replace(/\s+/g, ' ').trim();
            document.getElementById('direccionClienteEdit').value = fila.querySelector('td:nth-child(8)').textContent.replace(/\s+/g, ' ').trim();
        }
    }
});
</script>

  </body>
</html>