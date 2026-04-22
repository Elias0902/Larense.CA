<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Notificaciones</title>
    <?php
    require_once 'components/links.php';
    ?>
    <link rel="stylesheet" href="assets/css/validaciones.css" />
    <style>
        /* ==============================================
           ESTILOS PARA MODO OSCURO - NOTIFICACIONES
           ============================================== */
        body.dark-mode .page-header-custom h3 {
            color: #ffffff !important;
        }
        
        body.dark-mode .page-header-custom .breadcrumb-item.active {
            color: #9ca3af !important;
        }
        
        body.dark-mode .card {
            background-color: #1a1f2e !important;
            border-color: #3a4051 !important;
        }
        
        body.dark-mode .card-header {
            background-color: #2a3041 !important;
            color: #ffffff !important;
            border-color: #3a4051 !important;
        }
        
        body.dark-mode .card-body {
            background-color: #1a1f2e !important;
            color: #e7e9f0 !important;
        }
        
        body.dark-mode .table {
            background-color: #1a1f2e !important;
            color: #e7e9f0 !important;
        }
        
        body.dark-mode .table thead th {
            background-color: #2a3041 !important;
            color: #ffffff !important;
            border-color: #3a4051 !important;
        }
        
        body.dark-mode .table tbody tr {
            background-color: #1a1f2e !important;
        }
        
        body.dark-mode .table tbody tr td {
            background-color: transparent !important;
            color: #e7e9f0 !important;
        }
        
        body.dark-mode .table tbody tr:nth-child(even) {
            background-color: #222838 !important;
        }
        
        body.dark-mode .table tbody tr:hover {
            background-color: #2a3041 !important;
        }
        
        /* Alert en modo oscuro */
        body.dark-mode .alert {
            background-color: #2a3041 !important;
            border-color: #3a4051 !important;
            color: #e7e9f0 !important;
        }
        
        body.dark-mode .alert-info {
            background-color: #1e3a5f !important;
            border-color: #2a4d7d !important;
            color: #a3d4ff !important;
        }
        
        /* Estilos para modo oscuro usando data-background-color */
        body[data-background-color="dark"] .page-header-custom h3 {
            color: #ffffff !important;
        }
        
        body[data-background-color="dark"] .page-header-custom .breadcrumb-item.active {
            color: #9ca3af !important;
        }
        
        body[data-background-color="dark"] .card {
            background-color: #1a1f2e !important;
            border-color: #3a4051 !important;
        }
        
        body[data-background-color="dark"] .card-header {
            background-color: #2a3041 !important;
            color: #ffffff !important;
            border-color: #3a4051 !important;
        }
        
        body[data-background-color="dark"] .card-body {
            background-color: #1a1f2e !important;
            color: #e7e9f0 !important;
        }
        
        body[data-background-color="dark"] .table {
            background-color: #1a1f2e !important;
            color: #e7e9f0 !important;
        }
        
        body[data-background-color="dark"] .table thead th {
            background-color: #2a3041 !important;
            color: #ffffff !important;
            border-color: #3a4051 !important;
        }
        
        body[data-background-color="dark"] .table tbody tr {
            background-color: #1a1f2e !important;
        }
        
        body[data-background-color="dark"] .table tbody tr td {
            background-color: transparent !important;
            color: #e7e9f0 !important;
        }
        
        body[data-background-color="dark"] .table tbody tr:nth-child(even) {
            background-color: #222838 !important;
        }
        
        body[data-background-color="dark"] .table tbody tr:hover {
            background-color: #2a3041 !important;
        }
        
        body[data-background-color="dark"] .alert {
            background-color: #2a3041 !important;
            border-color: #3a4051 !important;
            color: #e7e9f0 !important;
        }
        
        body[data-background-color="dark"] .alert-info {
            background-color: #1e3a5f !important;
            border-color: #2a4d7d !important;
            color: #a3d4ff !important;
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
              <div class="icon-circle me-3" style="background: #dc3545; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fa fa-bell" style="color: white; font-size: 20px;"></i>
              </div>
              <div>
                <h3 class="fw-bold mb-0" style="color: #333;">Gestión de Notificaciones</h3>
                <nav aria-label="breadcrumb" class="mt-1">
                  <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #dc3545;"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: #333;">Notificaciones</li>
                  </ol>
                </nav>
              </div>
            </div>
            <button
              class="btn btn-info btn-round shadow-sm"
              data-bs-toggle="modal"
              data-bs-target="#notificacionModal"
              style="background: #dc3545; border: none; padding: 10px 20px;"
            >
              <i class="fa fa-plus me-2"></i>
              Nueva Notificación
            </button>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="card shadow border-0" style="border-radius: 12px; overflow: hidden;">
              <!-- Header de tabla con color -->
              <div class="card-header py-3" style="background: #dc3545; border: none;">
                <div class="d-flex align-items-center justify-content-between">
                  <h4 class="card-title mb-0" style="color: white; font-weight: 600;">
                    <i class="fa fa-list me-2"></i>Registros de Notificaciones
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
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Usuario</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Descripción</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Enlace</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Fecha</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                          <?php 
                if(isset($notificaciones) && is_array($notificaciones) && !empty($notificaciones)){
                foreach ($notificaciones as $notificacion): 
            ?>
                          <tr style="transition: all 0.2s;">
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                              <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                NOT-00<?php echo $notificacion['id_notificaciones']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <i class="fa fa-user me-1" style="color: #dc3545;"></i><?php echo $notificacion['nombre_usuario']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666; max-width: 300px;" class="text-truncate">
                              <?php echo $notificacion['descripcion_notificacion']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <?php if(!empty($notificacion['enlace'])): ?>
                                <a href="<?php echo $notificacion['enlace']; ?>" target="_blank" class="btn btn-sm" style="background: #f8d7da; color: #721c24; border-radius: 20px; text-decoration: none;">
                                  <i class="fa fa-external-link-alt me-1"></i>Ver enlace
                                </a>
                              <?php else: ?>
                                <span class="badge" style="background: #e9ecef; color: #6c757d; padding: 6px 12px; border-radius: 20px;">Sin enlace</span>
                              <?php endif; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666;">
                              <i class="fa fa-clock me-1" style="color: #dc3545;"></i><?php echo date('d/m/Y H:i', strtotime($notificacion['fecha_notificacion'])); ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <div class="btn-group" role="group">
                                <a
                                onclick="ObtenerNotificacion(<?php echo $notificacion['id_notificaciones']; ?>)"
                                data-bs-toggle="modal"
                                data-bs-target="#notificacionModalModificar"      
                                type="button"
                                class="btn btn-sm"
                                title='Modificar'
                                style="background: #dc3545; color: white; border-radius: 6px 0 0 6px; border: none;"
                                >
                                  <i class="fa fa-edit"></i>
                                </a>
                                <a href="#"
                                 onclick="return EliminarNotificacion(event,<?php echo $notificacion['id_notificaciones']; ?>)"
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
            endforeach; 
        } else {
            echo "<tr><td colspan='6' class='text-center py-4'><div class='alert alert-info'><i class='fa fa-info-circle me-2'></i>No hay notificaciones registradas.</div></td></tr>";
        } ?>
                        </tbody>
                      </table>
                    </div>
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

        </div>
<?php
require_once 'components/footer.php';
require_once 'components/scripts.php';
?>


<!-- Modal Agregar -->
<div class="modal fade" id="notificacionModal" tabindex="-1" aria-labelledby="notificacionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formNotificacion" onsubmit="return validar_formulario()" method="post" action="index.php?url=notificaciones&action=agregar">
        <div class="modal-header" style="background: #dc3545; border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="notificacionModalLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-plus-circle me-2"></i>Nueva Notificación
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <div class="mb-3">
            <label for="idUsuario" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-user me-2" style="color: #dc3545;"></i>ID Usuario *</label>
            <input type="number" class="form-control" id="idUsuario" name="idUsuario" placeholder="Ingrese el ID del usuario" style="border-radius: 8px;" oninput="validar_id_usuario()" required>
            <span id="errorIdUsuario" class="error-messege text-danger small"></span>
          </div>

          <div class="mb-3">
            <label for="descripcionNotificacion" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-align-left me-2" style="color: #dc3545;"></i>Descripción *</label>
            <input type="text" class="form-control" id="descripcionNotificacion" name="descripcionNotificacion" placeholder="Ingrese la descripción" style="border-radius: 8px;" oninput="validar_descripcion()" required>
            <span id="errorDescripcion" class="error-messege text-danger small"></span>
          </div>

          <div class="mb-3">
            <label for="enlaceNotificacion" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-link me-2" style="color: #dc3545;"></i>Enlace (Opcional)</label>
            <input type="text" class="form-control" id="enlaceNotificacion" name="enlaceNotificacion" placeholder="https://ejemplo.com" style="border-radius: 8px;" oninput="validar_enlace()">
            <span id="errorEnlace" class="error-messege text-danger small"></span>
          </div>

          <!-- Nota informativa -->
          <div class="alert alert-info d-flex align-items-center" role="alert" style="border-radius: 8px; background: #f8d7da; border: none;">
            <i class="fa fa-info-circle me-2" style="color: #721c24;"></i>
            <small style="color: #721c24;"><strong>Nota:</strong> Los campos marcados con * son obligatorios.</small>
          </div>
        </div>
        <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6; padding: 20px 25px;">
          <button type="button" class="btn" data-bs-dismiss="modal" style="background: #6c757d; color: white; border-radius: 8px; padding: 10px 25px;">
            <i class="fa fa-times me-2"></i>Cancelar
          </button>
          <button type="submit" class="btn" style="background: #dc3545; color: white; border-radius: 8px; padding: 10px 25px;">
            <i class="fa fa-save me-2"></i>Guardar Notificación
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Modificar -->
<div class="modal fade" id="notificacionModalModificar" tabindex="-1" aria-labelledby="notificacionModalModificarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formNotificacionModificar" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=notificaciones&action=modificar">
        <div class="modal-header" style="background: #dc3545; border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="notificacionModalModificarLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-edit me-2"></i>Modificar Notificación
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <input type="hidden" class="form-control" id="id" name="id" required>

          <div class="mb-3">
            <label for="idUsuarioEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-user me-2" style="color: #dc3545;"></i>ID Usuario *</label>
            <input type="number" class="form-control" id="idUsuarioEdit" name="idUsuario" placeholder="Ingrese el ID del usuario" style="border-radius: 8px;" oninput="validar_id_usuario_modificado()" required>
            <span id="errorIdUsuarioEdit" class="error-messege text-danger small"></span>
          </div>

          <div class="mb-3">
            <label for="descripcionNotificacionEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-align-left me-2" style="color: #dc3545;"></i>Descripción *</label>
            <input type="text" class="form-control" id="descripcionNotificacionEdit" name="descripcionNotificacion" placeholder="Ingrese la descripción" style="border-radius: 8px;" oninput="validar_descripcion_modificado()" required>
            <span id="errorDescripcionEdit" class="error-messege text-danger small"></span>
          </div>

          <div class="mb-3">
            <label for="enlaceNotificacionEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-link me-2" style="color: #dc3545;"></i>Enlace (Opcional)</label>
            <input type="text" class="form-control" id="enlaceNotificacionEdit" name="enlaceNotificacion" placeholder="https://ejemplo.com" style="border-radius: 8px;" oninput="validar_enlace_modificado()">
            <span id="errorEnlaceEdit" class="error-messege text-danger small"></span>
          </div>

          <!-- Nota informativa -->
          <div class="alert alert-info d-flex align-items-center" role="alert" style="border-radius: 8px; background: #f8d7da; border: none;">
            <i class="fa fa-info-circle me-2" style="color: #721c24;"></i>
            <small style="color: #721c24;"><strong>Nota:</strong> Los campos marcados con * son obligatorios.</small>
          </div>
        </div>
        <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6; padding: 20px 25px;">
          <button type="button" class="btn" data-bs-dismiss="modal" style="background: #6c757d; color: white; border-radius: 8px; padding: 10px 25px;">
            <i class="fa fa-times me-2"></i>Cancelar
          </button>
          <button type="submit" class="btn" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); color: #212529; border-radius: 8px; padding: 10px 25px;">
            <i class="fa fa-edit me-2"></i>Modificar Notificación
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="assets/js/validaciones/notificaciones_validaciones.js"></script>
<script src="assets/js/ajax/notificaciones_ajax.js"></script>

  </body>
</html>
