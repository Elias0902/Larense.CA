<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> Pagos</title>
    <?php
    require_once 'components/links.php';
    ?>
    <link rel="stylesheet" href="assets/css/validaciones.css" />
    <link rel="stylesheet" href="assets/css/stylesModules/pagos.css" />
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
                <i class="fa fa-dollar-sign" style="color: white; font-size: 20px;"></i>
              </div>
              <div>
                <h3 class="fw-bold mb-0" style="color: #333;">Gestión de Pagos</h3>
                <nav aria-label="breadcrumb" class="mt-1">
                  <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #dc3545;"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: #333;">Pagos</li>
                  </ol>
                </nav>
              </div>
            </div>
            <button
              class="btn btn-danger btn-round shadow-sm"
              data-bs-toggle="modal"
              data-bs-target="#pagoModal"
              style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 10px 20px;"
            >
              <i class="fa fa-plus me-2"></i>
              Registrar Pago
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
                    <i class="fa fa-list me-2"></i>Registro de Pagos
                  </h4>
                  <!-- Filtros de estado -->
                  <div class="btn-group" id="filtrosPagos">
                    <button class="btn btn-sm filtro-btn active" data-filtro="todos" style="background: white; border: none; color: #dc3545; font-weight: 600;">
                      <i class="fa fa-filter me-1"></i> Todos
                    </button>
                    <button class="btn btn-sm filtro-btn" data-filtro="completado" style="background: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.5); color: white; font-weight: 500;">
                      <i class="fa fa-check-circle me-1"></i> Completados
                    </button>
                    <button class="btn btn-sm filtro-btn" data-filtro="pendiente" style="background: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.5); color: white; font-weight: 500;">
                      <i class="fa fa-clock me-1"></i> Pendientes
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
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">#</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Cliente</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Monto</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Método</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Referencia</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Fecha</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Estado</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                          <?php
                if(isset($pagos) && is_array($pagos) && !empty($pagos)){
                foreach ($pagos as $pago):
                    $estado_class = $pago['status'] == 1 ? 'badge-success' : 'badge-warning';
                    $estado_texto = $pago['status'] == 1 ? 'Completado' : 'Pendiente';
                    $cliente_nombre = $pago['nombre_cliente'] . ' ' . $pago['apellido_cliente'];

                    // Icono según método de pago
                    $icono_metodo = '';
                    switch($pago['metodo_pago']) {
                        case 'efectivo': $icono_metodo = '<i class="fa fa-money-bill-wave text-success"></i>'; break;
                        case 'transferencia': $icono_metodo = '<i class="fa fa-university text-primary"></i>'; break;
                        case 'debito': $icono_metodo = '<i class="fa fa-credit-card text-info"></i>'; break;
                        case 'credito': $icono_metodo = '<i class="fa fa-credit-card text-danger"></i>'; break;
                        case 'biopago': $icono_metodo = '<i class="fa fa-fingerprint text-warning"></i>'; break;
                        case 'pago_movil': $icono_metodo = '<i class="fa fa-mobile-alt text-success"></i>'; break;
                        case 'zelle': $icono_metodo = '<i class="fa fa-envelope text-primary"></i>'; break;
                        default: $icono_metodo = '<i class="fa fa-dollar-sign"></i>';
                    }
            ?>
                          <tr style="transition: all 0.2s;" data-id="<?php echo $pago['id_pago']; ?>" data-estado="<?php echo $pago['status'] == 1 ? 'completado' : 'pendiente'; ?>">
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                              <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                PAG-00<?php echo $pago['id_pago']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <i class="fa fa-user me-1" style="color: #dc3545;"></i><?php echo $cliente_nombre; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 20px;">
                                $<?php echo number_format($pago['monto'], 2); ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge" style="background: #e9ecef; color: #495057; padding: 6px 12px; border-radius: 20px;">
                                <?php echo $icono_metodo . ' ' . ucfirst(str_replace('_', ' ', $pago['metodo_pago'])); ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <?php echo $pago['referencia'] ? $pago['referencia'] : '<span class="text-muted">-</span>'; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <i class="fa fa-calendar me-1" style="color: #dc3545;"></i><?php echo date('d/m/Y', strtotime($pago['fecha_pago'])); ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge <?php echo $estado_class; ?>" style="padding: 6px 12px; border-radius: 20px;">
                                <?php echo $estado_texto; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <div class="btn-group" role="group">
                                <!-- Ver Detalle -->
                                <a
                                  onclick="VerDetallePago(<?php echo $pago['id_pago']; ?>)"
                                  data-bs-toggle="modal"
                                  data-bs-target="#pagoDetalleModal"      
                                  type="button"
                                  class="btn btn-sm"
                                  title='Ver Detalle'
                                  style="background: #6c757d; color: white; border-radius: 6px 0 0 6px; border: none;"
                                >
                                  <i class="fa fa-eye"></i>
                                </a>
                                <a
                                  onclick="ObtenerPago(<?php echo $pago['id_pago']; ?>)"
                                  data-bs-toggle="modal"
                                  data-bs-target="#pagoModalModificar"
                                  type="button"
                                  class="btn btn-sm"
                                  title='Modificar'
                                  style="background: #ffc107; color: #212529; border: none;"
                                >
                                  <i class="fa fa-edit"></i>
                                </a>
                                <a href="#"
                                  onclick="return EliminarPago(event,<?php echo $pago['id_pago']; ?>)"
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
            echo "<tr><td colspan='8'>No hay pagos registrados.</td></tr>";
        } ?>
                        </tbody>
                      </table>
                    </div>
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

<?php
require_once 'components/footer.php';
require_once 'components/scripts.php';
?>

<!-- Modal Agregar -->
<div class="modal fade" id="pagoModal" tabindex="-1" aria-labelledby="pagoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formPago" onsubmit="return validar_formulario()" method="post" action="index.php?url=pagos&action=agregar">
        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="pagoModalLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-dollar-sign me-2"></i>Registrar Pago
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="clienteId" class="form-label"><b>Cliente <span class="text-danger">*</span></b></label>
                <select class="form-select" id="clienteId" name="clienteId" onchange="validar_cliente()" required>
                  <option value="">Seleccione un cliente...</option>
                  <?php
                  if(isset($clientes) && is_array($clientes) && !empty($clientes)) {
                      foreach($clientes as $cliente) {
                          echo '<option value="' . $cliente['id_cliente'] . '">' . $cliente['nombre_cliente'] . ' ' . $cliente['apellido_cliente'] . '</option>';
                      }
                  }
                  ?>
                </select>
                <span id="errorCliente" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="pedidoId" class="form-label"><b>Pedido (Opcional)</b></label>
                <input type="number" class="form-control" id="pedidoId" name="pedidoId" placeholder="Número de pedido">
                <small class="form-text text-muted">Dejar vacío si es pago general</small>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label for="montoPago" class="form-label"><b>Monto <span class="text-danger">*</span></b></label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" class="form-control" id="montoPago" name="montoPago" placeholder="0.00" step="0.01" min="0.01" oninput="validar_monto()" required>
                </div>
                <span id="errorMonto" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label for="metodoPago" class="form-label"><b>Método de Pago <span class="text-danger">*</span></b></label>
                <select class="form-select" id="metodoPago" name="metodoPago" onchange="validar_metodo()" required>
                  <option value="">Seleccione...</option>
                  <option value="efectivo">💵 Efectivo</option>
                  <option value="transferencia">🏦 Transferencia</option>
                  <option value="debito">💳 Débito</option>
                  <option value="credito">💳 Crédito</option>
                  <option value="biopago">👆 Biopago</option>
                  <option value="pago_movil">📱 Pago Móvil</option>
                  <option value="zelle">📧 Zelle</option>
                </select>
                <span id="errorMetodo" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label for="fechaPago" class="form-label"><b>Fecha de Pago <span class="text-danger">*</span></b></label>
                <input type="date" class="form-control" id="fechaPago" name="fechaPago" oninput="validar_fecha()" required>
                <span id="errorFecha" class="error-messege"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="referenciaPago" class="form-label"><b>Referencia</b></label>
                <input type="text" class="form-control" id="referenciaPago" name="referenciaPago" placeholder="Número de referencia / transacción" maxlength="50" oninput="validar_referencia()">
                <span id="errorReferencia" class="error-messege"></span>
                <small class="form-text text-muted">Requerido para transferencias, Zelle, etc.</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <div class="form-check form-switch mt-4">
                  <input class="form-check-input" type="checkbox" id="estadoPago" name="estadoPago" checked>
                  <label class="form-check-label" for="estadoPago"><b>Pago Completado</b></label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="observacionesPago" class="form-label"><b>Observaciones</b></label>
            <textarea class="form-control" id="observacionesPago" name="observacionesPago" rows="2" placeholder="Notas adicionales sobre el pago..." maxlength="500" oninput="validar_observaciones()"></textarea>
            <span id="errorObservaciones" class="error-messege"></span>
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
            <i class="fa fa-save me-2"></i>Registrar Pago
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Modificar -->
<div class="modal fade" id="pagoModalModificar" tabindex="-1" aria-labelledby="pagoModalModificarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formPagoModificar" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=pagos&action=modificar">
        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="pagoModalModificarLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-edit me-2"></i>Modificar Pago
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <input type="hidden" class="form-control" id="id" name="id" required>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="clienteIdEdit" class="form-label"><b>Cliente <span class="text-danger">*</span></b></label>
                <select class="form-select" id="clienteIdEdit" name="clienteId" onchange="validar_cliente_modificado()" required>
                  <option value="">Seleccione un cliente...</option>
                  <?php
                  if(isset($clientes) && is_array($clientes) && !empty($clientes)) {
                      foreach($clientes as $cliente) {
                          echo '<option value="' . $cliente['id_cliente'] . '">' . $cliente['nombre_cliente'] . ' ' . $cliente['apellido_cliente'] . '</option>';
                      }
                  }
                  ?>
                </select>
                <span id="errorClienteEdit" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="pedidoIdEdit" class="form-label"><b>Pedido (Opcional)</b></label>
                <input type="number" class="form-control" id="pedidoIdEdit" name="pedidoId" placeholder="Número de pedido">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label for="montoPagoEdit" class="form-label"><b>Monto <span class="text-danger">*</span></b></label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" class="form-control" id="montoPagoEdit" name="montoPago" placeholder="0.00" step="0.01" min="0.01" oninput="validar_monto_modificado()" required>
                </div>
                <span id="errorMontoEdit" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label for="metodoPagoEdit" class="form-label"><b>Método de Pago <span class="text-danger">*</span></b></label>
                <select class="form-select" id="metodoPagoEdit" name="metodoPago" onchange="validar_metodo_modificado()" required>
                  <option value="">Seleccione...</option>
                  <option value="efectivo">💵 Efectivo</option>
                  <option value="transferencia">🏦 Transferencia</option>
                  <option value="debito">💳 Débito</option>
                  <option value="credito">💳 Crédito</option>
                  <option value="biopago">👆 Biopago</option>
                  <option value="pago_movil">📱 Pago Móvil</option>
                  <option value="zelle">📧 Zelle</option>
                </select>
                <span id="errorMetodoEdit" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label for="fechaPagoEdit" class="form-label"><b>Fecha de Pago <span class="text-danger">*</span></b></label>
                <input type="date" class="form-control" id="fechaPagoEdit" name="fechaPago" oninput="validar_fecha_modificado()" required>
                <span id="errorFechaEdit" class="error-messege"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="referenciaPagoEdit" class="form-label"><b>Referencia</b></label>
                <input type="text" class="form-control" id="referenciaPagoEdit" name="referenciaPago" placeholder="Número de referencia / transacción" maxlength="50" oninput="validar_referencia_modificado()">
                <span id="errorReferenciaEdit" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <div class="form-check form-switch mt-4">
                  <input class="form-check-input" type="checkbox" id="estadoPagoEdit" name="estadoPago">
                  <label class="form-check-label" for="estadoPagoEdit"><b>Pago Completado</b></label>
                </div>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="observacionesPagoEdit" class="form-label"><b>Observaciones</b></label>
            <textarea class="form-control" id="observacionesPagoEdit" name="observacionesPago" rows="2" placeholder="Notas adicionales sobre el pago..." maxlength="500" oninput="validar_observaciones_modificado()"></textarea>
            <span id="errorObservacionesEdit" class="error-messege"></span>
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
            <i class="fa fa-edit me-2"></i>Modificar Pago
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Ver Detalle Pago -->
<div class="modal fade" id="pagoDetalleModal" tabindex="-1" aria-labelledby="pagoDetalleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
      
      <!-- Header -->
      <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 25px; position: relative;">
        <div class="d-flex align-items-center w-100">
          <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            <i class="fa fa-dollar-sign" style="font-size: 30px; color: #dc3545;"></i>
          </div>
          <div class="ms-3" style="color: white;">
            <h4 class="mb-0 fw-bold" id="detalleIdPago">PAG-001</h4>
            <small class="opacity-75" id="detalleFechaPago">01/01/2024</small>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar" style="position: absolute; top: 20px; right: 20px;"></button>
      </div>

      <!-- Body -->
      <div class="modal-body p-4" style="background: #f8f9fa;">
        
        <!-- Info Principal -->
        <div class="row mb-4">
          <div class="col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
              <div class="card-body text-center p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                  <i class="fa fa-user text-white" style="font-size: 24px;"></i>
                </div>
                <small class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">Cliente</small>
                <h5 class="mb-0 fw-bold text-dark" id="detalleClientePago">Nombre Cliente</h5>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
              <div class="card-body text-center p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                  <i class="fa fa-dollar-sign text-white" style="font-size: 24px;"></i>
                </div>
                <small class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">Monto</small>
                <h3 class="mb-0 fw-bold text-dark" id="detalleMontoPago">$0.00</h3>
              </div>
            </div>
          </div>
        </div>

        <!-- Estado -->
        <div class="card border-0 mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);">
          <div class="card-body p-4">
            <div class="d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; background: #dc3545;">
                  <i class="fa fa-info-circle text-white" style="font-size: 20px;"></i>
                </div>
                <div>
                  <h6 class="fw-bold mb-1 text-dark">ESTADO DEL PAGO</h6>
                  <span class="badge" id="detalleEstadoPago" style="padding: 8px 15px; border-radius: 20px; font-size: 0.9rem;">Completado</span>
                </div>
              </div>
              <div class="text-end">
                <small class="text-muted d-block">Método</small>
                <span id="detalleMetodoPago" class="badge" style="background: #e9ecef; color: #495057; padding: 6px 12px; border-radius: 20px;">Efectivo</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Info adicional -->
        <div class="row">
          <div class="col-md-6">
            <div class="d-flex align-items-center mb-2">
              <i class="fa fa-hashtag me-2" style="color: #dc3545;"></i>
              <span class="text-muted" id="detalleReferenciaPago">Ref: 123456</span>
            </div>
            <div class="d-flex align-items-center">
              <i class="fa fa-calendar me-2" style="color: #dc3545;"></i>
              <span class="text-muted" id="detalleFechaCompleta">01/01/2024</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex align-items-start">
              <i class="fa fa-shopping-cart me-2 mt-1" style="color: #dc3545;"></i>
              <span class="text-muted" id="detallePedidoPago">Pedido: -</span>
            </div>
          </div>
        </div>

        <!-- Observaciones -->
        <div class="mt-4">
          <h6 class="fw-bold mb-2 text-dark">Observaciones</h6>
          <div class="p-3" style="background: white; border-radius: 10px;">
            <span class="text-muted" id="detalleObservacionesPago">Sin observaciones</span>
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

<!-- JavaScript para filtros -->
<script>
// Funcionalidad de filtros de pagos
document.addEventListener('DOMContentLoaded', function() {
    const filtroBtns = document.querySelectorAll('#filtrosPagos .filtro-btn');
    const filasPagos = document.querySelectorAll('#add-row tbody tr');
    
    // Función para aplicar filtro
    function aplicarFiltro(filtro) {
        filasPagos.forEach(fila => {
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
});

// Función placeholder para VerDetallePago
function VerDetallePago(id) {
    // Aquí implementar la lógica para mostrar detalles del pago
    console.log('Ver detalle del pago:', id);
}
</script>

<script src="assets/js/validaciones/pagos_validaciones.js"></script>
<script src="assets/js/ajax/pagos_ajax.js"></script>

  </body>
</html>
