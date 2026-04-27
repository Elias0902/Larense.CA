<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Promociones y Descuentos</title>
    <?php
    require_once 'components/links.php';
    ?>
    <link rel="stylesheet" href="assets/css/validaciones.css" />
    <link rel="stylesheet" href="assets/css/stylesModules/promociones.css" />
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
                <i class="fa fa-gift" style="color: white; font-size: 20px;"></i>
              </div>
              <div>
                <h3 class="fw-bold mb-0" style="color: #333;">Promociones y Descuentos</h3>
                <nav aria-label="breadcrumb" class="mt-1">
                  <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #dc3545;"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: #333;">Promociones</li>
                  </ol>
                </nav>
              </div>
            </div>
            <button
              class="btn btn-danger btn-round shadow-sm"
              data-bs-toggle="modal"
              data-bs-target="#promocionModal"
              style="background: #dc3545; border: none; padding: 10px 20px;"
            >
              <i class="fa fa-plus me-2"></i>
              Nueva Promoción
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
                    <i class="fa fa-tags me-2"></i>Administración de Ofertas y Cupones
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
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">#</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Código</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Nombre</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Tipo</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Valor</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Vigencia</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Estado</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                          <?php
                if(isset($promociones) && is_array($promociones) && !empty($promociones)){
                foreach ($promociones as $promocion):
                    $estado_class = $promocion['status'] == 1 ? 'background: #d4edda; color: #155724;' : 'background: #f8d7da; color: #721c24;';
                    $estado_texto = $promocion['status'] == 1 ? 'Activa' : 'Inactiva';
            ?>
                          <tr style="transition: all 0.2s;">
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                              <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                PRO-00<?php echo $promocion['id_promocion']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 600; color: #dc3545;">
                              <i class="fa fa-ticket-alt me-1"></i><?php echo $promocion['codigo_promocion'] ?? 'N/A'; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #333;">
                              <?php echo $promocion['nombre_promocion']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge" style="background: #f8d7da; color: #721c24; padding: 6px 12px; border-radius: 20px; font-weight: 500;">
                                <?php echo ucfirst(str_replace('_', ' ', $promocion['tipo_descuento'])); ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 600; color: #dc3545;">
                              <?php echo $promocion['tipo_descuento'] == 'porcentaje' ? $promocion['valor_descuento'] . '%' : ($promocion['tipo_descuento'] == '2x1' ? '2x1' : $promocion['valor_descuento']); ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666;">
                              <i class="fa fa-calendar-alt me-1" style="color: #dc3545;"></i>
                              <?php echo date('d/m/Y', strtotime($promocion['fecha_inicio'])) . ' - ' . date('d/m/Y', strtotime($promocion['fecha_fin'])); ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge" style="<?php echo $estado_class; ?> padding: 6px 12px; border-radius: 20px; font-weight: 500;">
                                <?php echo $estado_texto; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <div class="btn-group" role="group">
                                <a
                                onclick="ObtenerPromocion(<?php echo $promocion['id_promocion']; ?>); return false;"
                                type="button"
                                class="btn btn-sm"
                                title='Modificar'
                                style="background: #dc3545; color: white; border-radius: 6px 0 0 6px; border: none;"
                                >
                                  <i class="fa fa-edit"></i>
                                </a>
                                <a href="#"
                                 onclick="return EliminarPromocion(event,<?php echo $promocion['id_promocion']; ?>)"
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
            echo "<tr><td colspan='8' class='text-center py-4'><div class='alert alert-info'><i class='fa fa-info-circle me-2'></i>No hay promociones registradas.</div></td></tr>";
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
<div class="modal fade" id="promocionModal" tabindex="-1" aria-labelledby="promocionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formPromocion" onsubmit="return validar_formulario()" method="post" action="index.php?url=promociones&action=agregar">
        <div class="modal-header" style="background: #dc3545; border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="promocionModalLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-gift me-2"></i>Nueva Promoción
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="codigoPromocion" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-ticket-alt me-2" style="color: #dc3545;"></i>Código *</label>
                <input type="text" class="form-control" id="codigoPromocion" name="codigoPromocion" placeholder="Ej: 2x1, 10%, VERANO" style="border-radius: 8px;" oninput="validar_codigo()" required>
                <span id="errorCodigo" class="error-messege text-danger small"></span>
                <small class="form-text text-muted">Código corto que identifica la promoción</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="tipoPromocion" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-tag me-2" style="color: #dc3545;"></i>Tipo *</label>
                <select class="form-select" id="tipoPromocion" name="tipoPromocion" style="border-radius: 8px;" onchange="actualizarPlaceholder()" required>
                  <option value="">Seleccione...</option>
                  <option value="porcentaje">Porcentaje (%)</option>
                  <option value="2x1">2x1 (Dos por uno)</option>
                  <option value="monto_fijo">Monto Fijo ($)</option>
                </select>
                <span id="errorTipo" class="error-messege text-danger small"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group mb-3">
                <label for="nombrePromocion" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-heading me-2" style="color: #dc3545;"></i>Nombre *</label>
                <input type="text" class="form-control" id="nombrePromocion" name="nombrePromocion" placeholder="Ej: 2x1 Galletas de Avena" style="border-radius: 8px;" oninput="validar_nombre()" required>
                <span id="errorNombre" class="error-messege text-danger small"></span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label for="valorPromocion" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-percent me-2" style="color: #dc3545;"></i>Valor *</label>
                <input type="number" class="form-control" id="valorPromocion" name="valorPromocion" placeholder="10" step="0.01" min="0" max="100" style="border-radius: 8px;" oninput="validar_valor()" required>
                <span id="errorValor" class="error-messege text-danger small"></span>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="descripcionPromocion" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-align-left me-2" style="color: #dc3545;"></i>Descripción *</label>
            <textarea class="form-control" id="descripcionPromocion" name="descripcionPromocion" rows="2" placeholder="Describe la promoción..." style="border-radius: 8px;" oninput="validar_descripcion()" required></textarea>
            <span id="errorDescripcion" class="error-messege text-danger small"></span>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="fechaInicio" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-calendar me-2" style="color: #dc3545;"></i>Inicio *</label>
                <input type="date" class="form-control" id="fechaInicio" name="fechaInicio" style="border-radius: 8px;" oninput="validar_fechas()" required>
                <span id="errorFechaInicio" class="error-messege text-danger small"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="fechaFin" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-calendar-check me-2" style="color: #dc3545;"></i>Fin *</label>
                <input type="date" class="form-control" id="fechaFin" name="fechaFin" style="border-radius: 8px;" oninput="validar_fechas()" required>
                <span id="errorFechaFin" class="error-messege text-danger small"></span>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="estadoPromocion" name="estadoPromocion" checked style="cursor: pointer;">
              <label class="form-check-label" for="estadoPromocion" style="color: #333; font-weight: 500;"><i class="fa fa-power-off me-2" style="color: #dc3545;"></i>Promoción Activa</label>
            </div>
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
            <i class="fa fa-save me-2"></i>Guardar Promoción
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Modificar -->
<div class="modal fade" id="promocionModalModificar" tabindex="-1" aria-labelledby="promocionModalModificarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formPromocionModificar" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=promociones&action=modificar">
        <div class="modal-header" style="background: #dc3545; border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="promocionModalModificarLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-edit me-2"></i>Modificar Promoción
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <input type="hidden" class="form-control" id="id" name="id" required>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="codigoPromocionEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-ticket-alt me-2" style="color: #dc3545;"></i>Código *</label>
                <input type="text" class="form-control" id="codigoPromocionEdit" name="codigoPromocion" placeholder="Ej: 2x1, 10%, VERANO" style="border-radius: 8px;" oninput="validar_codigo_modificado()" required>
                <span id="errorCodigoEdit" class="error-messege text-danger small"></span>
                <small class="form-text text-muted">Código corto que identifica la promoción</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="tipoPromocionEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-tag me-2" style="color: #dc3545;"></i>Tipo *</label>
                <select class="form-select" id="tipoPromocionEdit" name="tipoPromocion" style="border-radius: 8px;" onchange="actualizarPlaceholderEdit()" required>
                  <option value="">Seleccione...</option>
                  <option value="porcentaje">Porcentaje (%)</option>
                  <option value="2x1">2x1 (Dos por uno)</option>
                  <option value="monto_fijo">Monto Fijo ($)</option>
                </select>
                <span id="errorTipoEdit" class="error-messege text-danger small"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-8">
              <div class="form-group mb-3">
                <label for="nombrePromocionEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-heading me-2" style="color: #dc3545;"></i>Nombre *</label>
                <input type="text" class="form-control" id="nombrePromocionEdit" name="nombrePromocion" placeholder="Ej: 2x1 Galletas de Avena" style="border-radius: 8px;" oninput="validar_nombre_modificado()" required>
                <span id="errorNombreEdit" class="error-messege text-danger small"></span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label for="valorPromocionEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-percent me-2" style="color: #dc3545;"></i>Valor *</label>
                <input type="number" class="form-control" id="valorPromocionEdit" name="valorPromocion" placeholder="10" step="0.01" min="0" max="100" style="border-radius: 8px;" oninput="validar_valor_modificado()" required>
                <span id="errorValorEdit" class="error-messege text-danger small"></span>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="descripcionPromocionEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-align-left me-2" style="color: #dc3545;"></i>Descripción *</label>
            <textarea class="form-control" id="descripcionPromocionEdit" name="descripcionPromocion" rows="2" placeholder="Describe la promoción..." style="border-radius: 8px;" oninput="validar_descripcion_modificado()" required></textarea>
            <span id="errorDescripcionEdit" class="error-messege text-danger small"></span>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="fechaInicioEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-calendar me-2" style="color: #dc3545;"></i>Inicio *</label>
                <input type="date" class="form-control" id="fechaInicioEdit" name="fechaInicio" style="border-radius: 8px;" oninput="validar_fechas_modificado()" required>
                <span id="errorFechaInicioEdit" class="error-messege text-danger small"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="fechaFinEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-calendar-check me-2" style="color: #dc3545;"></i>Fin *</label>
                <input type="date" class="form-control" id="fechaFinEdit" name="fechaFin" style="border-radius: 8px;" oninput="validar_fechas_modificado()" required>
                <span id="errorFechaFinEdit" class="error-messege text-danger small"></span>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="estadoPromocionEdit" name="estadoPromocion" style="cursor: pointer;">
              <label class="form-check-label" for="estadoPromocionEdit" style="color: #333; font-weight: 500;"><i class="fa fa-power-off me-2" style="color: #dc3545;"></i>Promoción Activa</label>
            </div>
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
            <i class="fa fa-edit me-2"></i>Modificar Promoción
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="assets/js/validaciones/promociones_validaciones.js"></script>
<script src="assets/js/ajax/promociones_ajax.js"></script>
<script src="assets/js/animacionesJs/dashboard_promociones.js"></script>

  </body>
</html>
