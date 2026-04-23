<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Cuentas por Pagar</title>
    <?php
    require_once 'components/links.php';
    ?>
    <link rel="stylesheet" href="assets/css/validaciones.css" />
    <link rel="stylesheet" href="assets/css/stylesModules/pagar.css" />
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
                <i class="fa fa-file-invoice-dollar" style="color: white; font-size: 20px;"></i>
              </div>
              <div>
                <h3 class="fw-bold mb-0" style="color: #333;">Gestión de Cuentas por Pagar</h3>
                <nav aria-label="breadcrumb" class="mt-1">
                  <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #dc3545;"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: #333;">Cuentas por Pagar</li>
                  </ol>
                </nav>
              </div>
            </div>
            <button
              class="btn btn-primary btn-round shadow-sm"
              data-bs-toggle="modal"
              data-bs-target="#pagarModal"
              style="background: #dc3545; border: none; padding: 10px 20px;"
            >
              <i class="fa fa-plus me-2"></i>
              Nueva Cuenta
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
                    <i class="fa fa-list me-2"></i>Gestión de Deudas con Proveedores
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
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Proveedor</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Monto</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Saldo</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Emisión</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Vencimiento</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Estado</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                          <?php
                if(isset($cuentas) && is_array($cuentas) && !empty($cuentas)){
                foreach ($cuentas as $cuenta):
                    $estado_class = '';
                    $estado_texto = '';
                    
                    switch($cuenta['estado']) {
                        case 'pendiente':
                            $estado_class = 'badge-warning';
                            $estado_texto = 'Pendiente';
                            break;
                        case 'parcial':
                            $estado_class = 'badge-info';
                            $estado_texto = 'Pago Parcial';
                            break;
                        case 'pagada':
                            $estado_class = 'badge-success';
                            $estado_texto = 'Pagada';
                            break;
                        case 'vencida':
                            $estado_class = 'badge-danger';
                            $estado_texto = 'Vencida';
                            break;
                        case 'anulada':
                            $estado_class = 'badge-secondary';
                            $estado_texto = 'Anulada';
                            break;
                        default:
                            $estado_class = 'badge-secondary';
                            $estado_texto = ucfirst($cuenta['estado']);
                    }
                    
                    // Verificar si está vencida
                    $hoy = date('Y-m-d');
                    $vencida = ($cuenta['fecha_vencimiento'] < $hoy && $cuenta['estado'] != 'pagada' && $cuenta['estado'] != 'anulada');
                    if ($vencida) {
                        $estado_class = 'badge-danger';
                        $estado_texto = 'Vencida';
                    }
                    
                    $saldo_class = $cuenta['saldo'] > 0 ? 'text-danger' : 'text-success';
            ?>
                          <tr style="transition: all 0.2s;">
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                              <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                CP-00<?php echo $cuenta['id_cuenta_pagar']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <i class="fa fa-truck me-1" style="color: #28a745;"></i><?php echo $cuenta['nombre_proveedor']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 600; color: #dc3545;">
                              $<?php echo number_format($cuenta['monto'], 2); ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 600;" class="<?php echo $saldo_class; ?>">
                              $<?php echo number_format($cuenta['saldo'], 2); ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666;">
                              <i class="fa fa-calendar me-1" style="color: #dc3545;"></i><?php echo date('d/m/Y', strtotime($cuenta['fecha_emision'])); ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666;">
                              <?php if($vencida): ?>
                                <span class="text-danger"><i class="fa fa-exclamation-circle me-1"></i><?php echo date('d/m/Y', strtotime($cuenta['fecha_vencimiento'])); ?></span>
                              <?php else: ?>
                                <i class="fa fa-calendar-check me-1" style="color: #28a745;"></i><?php echo date('d/m/Y', strtotime($cuenta['fecha_vencimiento'])); ?>
                              <?php endif; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge" style="
                                <?php 
                                switch($cuenta['estado']) {
                                  case 'pendiente': echo 'background: #fff3cd; color: #856404;'; break;
                                  case 'parcial': echo 'background: #f8d7da; color: #721c24;'; break;
                                  case 'pagada': echo 'background: #d4edda; color: #155724;'; break;
                                  case 'vencida': echo 'background: #f8d7da; color: #721c24;'; break;
                                  case 'anulada': echo 'background: #e2e3e5; color: #383d41;'; break;
                                  default: echo 'background: #e9ecef; color: #495057;';
                                }
                                ?> padding: 6px 12px; border-radius: 20px; font-weight: 500;">
                                <?php echo $estado_texto; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <div class="btn-group" role="group">
                                <?php if($cuenta['saldo'] > 0 && $cuenta['estado'] != 'anulada'): ?>
                                <button
                                  onclick="RegistrarPagoCuentaPagar(<?php echo $cuenta['id_cuenta_pagar']; ?>, <?php echo $cuenta['saldo']; ?>)"
                                  type="button"
                                  class="btn btn-sm"
                                  title='Registrar Pago'
                                  data-bs-toggle="tooltip"
                                  style="background: #28a745; color: white; border-radius: 6px 0 0 6px; border: none;"
                                >
                                  <i class="fa fa-dollar-sign"></i>
                                </button>
                                <?php endif; ?>
                                <a
                                onclick="ObtenerCuentaPagar(<?php echo $cuenta['id_cuenta_pagar']; ?>)"
                                data-bs-toggle="modal"
                                data-bs-target="#pagarModalModificar"
                                type="button"
                                class="btn btn-sm"
                                title='Modificar'
                                style="background: #dc3545; color: white; border: none;<?php echo ($cuenta['saldo'] > 0 && $cuenta['estado'] != 'anulada') ? '' : 'border-radius: 6px 0 0 6px;'; ?>"
                                >
                                  <i class="fa fa-edit"></i>
                                </a>
                                <a href="#"
                                 onclick="return EliminarCuentaPagar(event,<?php echo $cuenta['id_cuenta_pagar']; ?>)"
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
            echo "<tr><td colspan='8' class='text-center py-4'><div class='alert alert-info'><i class='fa fa-info-circle me-2'></i>No hay cuentas por pagar registradas.</div></td></tr>";
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
<div class="modal fade" id="pagarModal" tabindex="-1" aria-labelledby="pagarModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formPagar" onsubmit="return validar_formulario()" method="post" action="index.php?url=pagar&action=agregar">
        <div class="modal-header" style="background: #dc3545; border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="pagarModalLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-receipt me-2"></i><font color="red">Nueva Cuenta por Pagar</font>
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="proveedorId" class="form-label"><b>Proveedor <span class="text-danger">*</span></b></label>
                <select class="form-select" id="proveedorId" name="proveedorId" onchange="validar_proveedor()" required>
                  <option value="">Seleccione un proveedor...</option>
                  <?php
                  if(isset($proveedores) && is_array($proveedores) && !empty($proveedores)) {
                      foreach($proveedores as $proveedor) {
                          echo '<option value="' . $proveedor['id_proveedor'] . '">' . $proveedor['nombre_proveedor'] . '</option>';
                      }
                  }
                  ?>
                </select>
                <span id="errorProveedor" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="compraId" class="form-label"><b>Compra Relacionada (Opcional)</b></label>
                <input type="number" class="form-control" id="compraId" name="compraId" placeholder="Número de compra">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="montoCuenta" class="form-label"><b>Monto Total <span class="text-danger">*</span></b></label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" class="form-control" id="montoCuenta" name="montoCuenta" placeholder="0.00" step="0.01" min="0.01" oninput="actualizarSaldo(); validar_monto()" required>
                </div>
                <span id="errorMonto" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="saldoCuenta" class="form-label"><b>Saldo Pendiente</b></label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" class="form-control" id="saldoCuenta" name="saldoCuenta" placeholder="0.00" step="0.01" min="0" readonly>
                </div>
                <small class="form-text text-muted">Se actualiza automáticamente con el monto</small>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="fechaEmision" class="form-label"><b>Fecha de Emisión <span class="text-danger">*</span></b></label>
                <input type="date" class="form-control" id="fechaEmision" name="fechaEmision" oninput="validar_fecha_emision()" required>
                <span id="errorFechaEmision" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="fechaVencimiento" class="form-label"><b>Fecha de Vencimiento <span class="text-danger">*</span></b></label>
                <input type="date" class="form-control" id="fechaVencimiento" name="fechaVencimiento" oninput="validar_fechas()" required>
                <span id="errorFechaVencimiento" class="error-messege"></span>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="descripcionCuenta" class="form-label"><b>Descripción <span class="text-danger">*</span></b></label>
            <textarea class="form-control" id="descripcionCuenta" name="descripcionCuenta" rows="2" placeholder="Concepto de la deuda..." maxlength="300" oninput="validar_descripcion()" required></textarea>
            <span id="errorDescripcion" class="error-messege"></span>
          </div>
          <div class="form-group mb-3">
            <label for="estadoCuenta" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-tag me-2" style="color: #dc3545;"></i>Estado</label>
            <select class="form-select" id="estadoCuenta" name="estadoCuenta" style="border-radius: 8px;">
              <option value="pendiente">🟡 Pendiente</option>
              <option value="parcial">🔵 Pago Parcial</option>
              <option value="pagada">🟢 Pagada</option>
              <option value="vencida">🔴 Vencida</option>
            </select>
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
            <i class="fa fa-save me-2"></i>Guardar Cuenta
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Modificar -->
<div class="modal fade" id="pagarModalModificar" tabindex="-1" aria-labelledby="pagarModalModificarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formPagarModificar" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=pagar&action=modificar">
        <div class="modal-header" style="background: #dc3545; border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="pagarModalModificarLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-edit me-2"></i>Modificar Cuenta por Pagar
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="id" name="id" required>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="proveedorIdEdit" class="form-label"><b>Proveedor <span class="text-danger">*</span></b></label>
                <select class="form-select" id="proveedorIdEdit" name="proveedorId" onchange="validar_proveedor_modificado()" required>
                  <option value="">Seleccione un proveedor...</option>
                  <?php
                  if(isset($proveedores) && is_array($proveedores) && !empty($proveedores)) {
                      foreach($proveedores as $proveedor) {
                          echo '<option value="' . $proveedor['id_proveedor'] . '">' . $proveedor['nombre_proveedor'] . '</option>';
                      }
                  }
                  ?>
                </select>
                <span id="errorProveedorEdit" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="compraIdEdit" class="form-label"><b>Compra Relacionada</b></label>
                <input type="number" class="form-control" id="compraIdEdit" name="compraId" placeholder="Número de compra">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="montoCuentaEdit" class="form-label"><b>Monto Total <span class="text-danger">*</span></b></label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" class="form-control" id="montoCuentaEdit" name="montoCuenta" placeholder="0.00" step="0.01" min="0.01" oninput="actualizarSaldoModificado(); validar_monto_modificado()" required>
                </div>
                <span id="errorMontoEdit" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="saldoCuentaEdit" class="form-label"><b>Saldo Pendiente</b></label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" class="form-control" id="saldoCuentaEdit" name="saldoCuenta" placeholder="0.00" step="0.01" min="0">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="fechaEmisionEdit" class="form-label"><b>Fecha de Emisión <span class="text-danger">*</span></b></label>
                <input type="date" class="form-control" id="fechaEmisionEdit" name="fechaEmision" oninput="validar_fecha_emision_modificado()" required>
                <span id="errorFechaEmisionEdit" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="fechaVencimientoEdit" class="form-label"><b>Fecha de Vencimiento <span class="text-danger">*</span></b></label>
                <input type="date" class="form-control" id="fechaVencimientoEdit" name="fechaVencimiento" oninput="validar_fechas_modificado()" required>
                <span id="errorFechaVencimientoEdit" class="error-messege"></span>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="descripcionCuentaEdit" class="form-label"><b>Descripción <span class="text-danger">*</span></b></label>
            <textarea class="form-control" id="descripcionCuentaEdit" name="descripcionCuenta" rows="2" placeholder="Concepto de la deuda..." maxlength="300" oninput="validar_descripcion_modificado()" required></textarea>
            <span id="errorDescripcionEdit" class="error-messege"></span>
          </div>
          <div class="form-group mb-3">
            <label for="estadoCuentaEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-tag me-2" style="color: #dc3545;"></i>Estado</label>
            <select class="form-select" id="estadoCuentaEdit" name="estadoCuenta" style="border-radius: 8px;">
              <option value="pendiente">🟡 Pendiente</option>
              <option value="parcial">🔵 Pago Parcial</option>
              <option value="pagada">🟢 Pagada</option>
              <option value="vencida">🔴 Vencida</option>
              <option value="anulada">⚪ Anulada</option>
            </select>
          </div>
        </div>
        <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6; padding: 20px 25px;">
          <button type="button" class="btn" data-bs-dismiss="modal" style="background: #6c757d; color: white; border-radius: 8px; padding: 10px 25px;">
            <i class="fa fa-times me-2"></i>Cancelar
          </button>
          <button type="submit" class="btn" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); color: #212529; border-radius: 8px; padding: 10px 25px;">
            <i class="fa fa-edit me-2"></i>Modificar Cuenta
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="assets/js/validaciones/pagar_validaciones.js"></script>
<script src="assets/js/ajax/pagar_ajax.js"></script>

  </body>
</html>
