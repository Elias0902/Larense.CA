<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Bitácora</title>
    <?php
    require_once 'components/links.php';
    ?>
    <link rel="stylesheet" href="assets/css/validaciones.css" />
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
                <i class="fa fa-clipboard-list" style="color: white; font-size: 20px;"></i>
              </div>
              <div>
                <h3 class="fw-bold mb-0" style="color: #333;">Registro de Bitácora</h3>
                <nav aria-label="breadcrumb" class="mt-1">
                  <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #dc3545;"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: #333;">Bitácora</li>
                  </ol>
                </nav>
              </div>
            </div>
            <button class="btn btn-round shadow-sm" onclick="location.reload()" style="background: #dc3545; border: none; padding: 10px 20px; color: white;">
              <i class="fa fa-refresh me-2"></i>Actualizar
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
                    <i class="fa fa-list me-2"></i>Registros de Bitácora
                  </h4>
                </div>
              </div>       
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table id="add-row" class="display table table-hover mb-0" style="width: 100%;">
                    <thead>
                      <tr style="background: #f8f9fa;">
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">#</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Usuario</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Fecha</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Módulo</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Accion</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Descripción</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                        <tbody>
                          <?php 
                          if (isset($bitacoras) && !empty($bitacoras) && is_array($bitacoras)): 
                            $contador = 1;
                            foreach ($bitacoras as $registro): 
                          ?>
                          <tr>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                              <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                BT-00<?php echo htmlspecialchars($registro['id_bitacora']); ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <i class="fa fa-user me-1" style="color: #dc3545;"></i>
                              <?php echo htmlspecialchars($registro['nombre_usuario'] ?? ($registro['id_usuario'] ?? 'Sistema')); ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666;">
                              <i class="fa fa-clock me-1" style="color: #dc3545;"></i>
                              <?php 
                              if(isset($registro['fecha_bitacora']) && !empty($registro['fecha_bitacora'])) {
                                  $fecha = new DateTime($registro['fecha_bitacora']);
                                  echo $fecha->format('d/m/Y H:i:s');
                              } else {
                                  echo 'N/A';
                              }
                              ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge" style="background: #e9ecef; color: #c82333; padding: 6px 12px; border-radius: 20px; font-weight: 500;">
                                <i class="fa fa-cube me-1"></i><?php echo htmlspecialchars($registro['modulo'] ?? 'N/A'); ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge" style="background: #e9ecef; color: #c82333; padding: 6px 12px; border-radius: 20px; font-weight: 500;">
                                <i class="fa-check me-1"></i><?php echo htmlspecialchars($registro['accion'] ?? 'N/A'); ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666; max-width: 300px;" class="text-truncate" title="<?php echo htmlspecialchars($registro['descripcion'] ?? ''); ?>">
                              <?php echo htmlspecialchars($registro['descripcion'] ?? 'N/A'); ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <button type="button" class="btn btn-sm" 
                                      onclick="ObtenerBitacora(<?php echo $registro['id_bitacora']; ?>)"
                                      data-bs-toggle="modal"
                                      data-bs-target="#bitacoraModal" title="Ver Detalle"
                                      style="background: #dc3545; color: white; border-radius: 6px; border: none;">
                                <i class="fa fa-eye"></i>
                              </button>
                            </td>
                          </tr>
                          <?php 
                            endforeach;
                          else: 
                          ?>
                          <tr>
                            <td colspan="9" class="text-center py-4">
                              <div class="alert alert-info" style="border-radius: 8px;">
                                <i class="fa fa-info-circle me-2"></i>No hay registros en la bitácora
                              </div>
                            </td>
                          </tr>
                          <?php endif; ?>
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

<!-- Modal Bitacora -->
<div class="modal fade" id="bitacoraModal" tabindex="-1" aria-labelledby="bitacoraModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formBitacoraModificar" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=bitacora&action=modificar">
        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="bitacoraModalLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-edit me-2"></i>Detalles de la Bitacora
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>

        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <input type="hidden" class="form-control" id="id_bitacora" name="id_bitacora" required>

          <div class="mb-3">
            <label for="nombre_usuario" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-user me-2" style="color: #dc3545;"></i>Usuario</label>
            <input type="text" class="form-control" id="nombre_usuario" readonly style="border-radius: 8px;">
          </div>

          <div class="mb-3">
            <label for="modulo" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-cogs me-2" style="color: #dc3545;"></i>Módulo</label>
            <input type="text" class="form-control" id="modulo" readonly style="border-radius: 8px;">
          </div>

          <div class="mb-3">
            <label for="accion" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-info-circle me-2" style="color: #dc3545;"></i>Acción</label>
            <input type="text" class="form-control" id="accion" readonly style="border-radius: 8px;">
          </div>

          <div class="mb-3">
            <label for="descripcion" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-align-left me-2" style="color: #dc3545;"></i>Descripción</label>
            <textarea class="form-control" id="descripcion" rows="3" readonly style="border-radius: 8px;"></textarea>
          </div>

          <div class="mb-3">
            <label for="fecha_bitacora" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-calendar-alt me-2" style="color: #dc3545;"></i>Fecha</label>
            <input type="text" class="form-control" id="fecha_bitacora" readonly style="border-radius: 8px;">
          </div>
        </div>

        <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6; padding: 20px 25px;">
          <button type="button" class="btn" data-bs-dismiss="modal" style="background: #6c757d; color: white; border-radius: 8px; padding: 10px 25px;">
            <i class="fa fa-times me-2"></i>Cancelar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="assets/js/ajax/bitacoras_ajax.js"></script>

<style>
.text-center {
    text-align: center;
}
.mt-3 {
    margin-top: 1rem;
}
</style>
<script src="assets/js/animacionesJs/dashboard_bitacora.js"></script>
  </body>
</html>