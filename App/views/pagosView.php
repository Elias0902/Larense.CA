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
                        <button class="btn btn-sm filtro-btn active" data-filtro="clientes" style="background: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.5); color: white; font-weight: 500;">
                            <i class="fa fa-users me-1"></i> Clientes
                        </button>
                        <button class="btn btn-sm filtro-btn" data-filtro="proveedores" style="background: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.5); color: white; font-weight: 500;">
                            <i class="fa fa-truck me-1"></i> Proveedores
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <!-- Tabla de Clientes -->
                    <table id="tablaClientes" class="display table table-hover mb-0 pagos-table" style="width: 100%;">
                        <thead>
                            <tr style="background: #f8f9fa;">
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">#</th>
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Pedido</th>
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Cliente</th>
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Monto</th>
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Método</th>
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Referencia</th>
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Concepto</th>
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Fecha</th>
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($pagos_clientes) && is_array($pagos_clientes) && !empty($pagos_clientes)): ?>
                                <?php foreach ($pagos_clientes as $pago): ?>
                                    <?php
                                    $estado_class = 'badge-success';
                                    $estado_texto = 'Pagado';

                                    // Icono según método de pago
                                    $icono_metodo = '';
                                    switch($pago['nombre_metodo']) {
                                        case 'Efectivo': $icono_metodo = '<i class="fa fa-money-bill-wave text-success"></i>'; break;
                                        case 'Transferencia': $icono_metodo = '<i class="fa fa-university text-primary"></i>'; break;
                                        case 'Debito': $icono_metodo = '<i class="fa fa-credit-card text-info"></i>'; break;
                                        case 'Credito': $icono_metodo = '<i class="fa fa-credit-card text-danger"></i>'; break;
                                        case 'Biopago': $icono_metodo = '<i class="fa fa-fingerprint text-warning"></i>'; break;
                                        case 'Pago Movil': $icono_metodo = '<i class="fa fa-mobile-alt text-success"></i>'; break;
                                        case 'Zelle': $icono_metodo = '<i class="fa fa-envelope text-primary"></i>'; break;
                                        default: $icono_metodo = '<i class="fa fa-dollar-sign"></i>';
                                    }
                                    ?>
                                    <tr style="transition: all 0.2s;">
                                        <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                                            <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                                PAG-<?php echo str_pad($pago['id_pago'], 4, '0', STR_PAD_LEFT); ?>
                                            </span>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                                            <span class="badge" style="background: #17a2b8; color: white; padding: 6px 10px; border-radius: 6px;">
                                                PD-<?php echo str_pad($pago['ID'], 4, '0', STR_PAD_LEFT); ?>
                                            </span>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                                            <i class="fa fa-user me-1" style="color: #dc3545;"></i>
                                            <?php echo $pago['tipo_id'] . '-' . $pago['id'] . ' ' . $pago['nombre']; ?>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle;">
                                            <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 20px;">
                                                $<?php echo number_format($pago['monto_pago'], 2); ?>
                                            </span>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle;">
                                            <span class="badge" style="background: #e9ecef; color: #495057; padding: 6px 12px; border-radius: 20px;">
                                                <?php echo $icono_metodo . ' ' . ucfirst(str_replace('_', ' ', $pago['nombre_metodo'])); ?>
                                            </span>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle;">
                                            <?php echo $pago['nro_referencia'] ? $pago['nro_referencia'] : '<span class="text-muted">-</span>'; ?>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle;">
                                            <?php echo $pago['concepto'] ? $pago['concepto'] : '<span class="text-muted">-</span>'; ?>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle;">
                                            <i class="fa fa-calendar me-1" style="color: #dc3545;"></i>
                                            <?php echo date('d/m/Y', strtotime($pago['fecha_pago'])); ?>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle;">
                                            <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 20px;">
                                                <i class="fa fa-check-circle me-1"></i> Pagado
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fa fa-inbox fa-2x mb-2"></i>
                                            <p>No hay pagos de clientes registrados</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <!-- Tabla de Proveedores -->
                    <table id="tablaProveedores" class="display table table-hover mb-0 pagos-table" style="width: 100%; display: none;">
                        <thead>
                            <tr style="background: #f8f9fa;">
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">#</th>
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Compra</th>
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Proveedor</th>
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Monto</th>
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Método</th>
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Referencia</th>
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Concepto</th>
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Fecha</th>
                                <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($pagos_proveedores) && is_array($pagos_proveedores) && !empty($pagos_proveedores)): ?>
                                <?php foreach ($pagos_proveedores as $pago): ?>
                                    <?php
                                    $estado_class = 'badge-success';
                                    $estado_texto = 'Pagado';

                                    // Icono según método de pago
                                    $icono_metodo = '';
                                    switch($pago['nombre_metodo']) {
                                        case 'Efectivo': $icono_metodo = '<i class="fa fa-money-bill-wave text-success"></i>'; break;
                                        case 'Transferencia': $icono_metodo = '<i class="fa fa-university text-primary"></i>'; break;
                                        case 'Debito': $icono_metodo = '<i class="fa fa-credit-card text-info"></i>'; break;
                                        case 'Credito': $icono_metodo = '<i class="fa fa-credit-card text-danger"></i>'; break;
                                        case 'Biopago': $icono_metodo = '<i class="fa fa-fingerprint text-warning"></i>'; break;
                                        case 'Pago Movil': $icono_metodo = '<i class="fa fa-mobile-alt text-success"></i>'; break;
                                        case 'Zelle': $icono_metodo = '<i class="fa fa-envelope text-primary"></i>'; break;
                                        default: $icono_metodo = '<i class="fa fa-dollar-sign"></i>';
                                    }
                                    ?>
                                    <tr style="transition: all 0.2s;">
                                        <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                                            <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                                PAG-<?php echo str_pad($pago['id_pago_proveedor'], 4, '0', STR_PAD_LEFT); ?>
                                            </span>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                                            <span class="badge" style="background: #17a2b8; color: white; padding: 6px 10px; border-radius: 6px;">
                                                COMP-<?php echo str_pad($pago['ID'], 4, '0', STR_PAD_LEFT); ?>
                                            </span>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                                            <i class="fa fa-building me-1" style="color: #dc3545;"></i>
                                            <?php echo $pago['tipo_id'] . '-' . $pago['id'] . ' ' . $pago['nombre']; ?>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle;">
                                            <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 20px;">
                                                $<?php echo number_format($pago['monto_pago'], 2); ?>
                                            </span>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle;">
                                            <span class="badge" style="background: #e9ecef; color: #495057; padding: 6px 12px; border-radius: 20px;">
                                                <?php echo $icono_metodo . ' ' . ucfirst(str_replace('_', ' ', $pago['nombre_metodo'])); ?>
                                            </span>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle;">
                                            <?php echo $pago['nro_referencia'] ? $pago['nro_referencia'] : '<span class="text-muted">-</span>'; ?>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle;">
                                            <?php echo $pago['concepto'] ? $pago['concepto'] : '<span class="text-muted">-</span>'; ?>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle;">
                                            <i class="fa fa-calendar me-1" style="color: #dc3545;"></i>
                                            <?php echo date('d/m/Y', strtotime($pago['fecha_pago'])); ?>
                                        </td>
                                        <td style="padding: 15px; vertical-align: middle;">
                                            <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 20px;">
                                                <i class="fa fa-check-circle me-1"></i> Pagado
                                            </span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fa fa-inbox fa-2x mb-2"></i>
                                            <p>No hay pagos de proveedores registrados</p>
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
                          echo '<option value="' . $cliente['id_cliente'] . '">' . $cliente['nombre_cliente'] . '</option>';
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
                          echo '<option value="' . $cliente['id_cliente'] . '">' . $cliente['nombre_cliente'] . '</option>';
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
// Sistema de filtros para pagos
let dataTableClientes = null;
let dataTableProveedores = null;

document.addEventListener('DOMContentLoaded', function() {
    // Mostrar clientes por defecto
    mostrarFiltro('clientes');
    
    // Agregar event listeners a los botones de filtro
    const botonesFiltro = document.querySelectorAll('.filtro-btn');
    botonesFiltro.forEach(boton => {
        boton.addEventListener('click', function() {
            const filtro = this.getAttribute('data-filtro');
            
            // Actualizar clase active en botones
            botonesFiltro.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Mostrar tabla correspondiente
            mostrarFiltro(filtro);
            
            // Guardar filtro en localStorage
            localStorage.setItem('filtroPagos', filtro);
        });
    });
    
    // Cargar último filtro seleccionado
    const ultimoFiltro = localStorage.getItem('filtroPagos');
    if (ultimoFiltro) {
        mostrarFiltro(ultimoFiltro);
        // Activar el botón correspondiente
        const botonActivo = document.querySelector(`.filtro-btn[data-filtro="${ultimoFiltro}"]`);
        if (botonActivo) {
            document.querySelectorAll('.filtro-btn').forEach(btn => btn.classList.remove('active'));
            botonActivo.classList.add('active');
        }
    }
});

function destruirDataTable(tablaId) {
    if ($.fn.DataTable && $.fn.dataTable.isDataTable(tablaId)) {
        $(tablaId).DataTable().destroy();

    }
}

function inicializarDataTable(tablaId) {
    if ($.fn.DataTable) {
        return $(tablaId).DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json'
            },
            pageLength: 10,
            responsive: true,
            destroy: true,
            autoWidth: false
        });
    }
    return null;
}

function mostrarFiltro(tipo) {
    const tablaClientes = document.getElementById('tablaClientes');
    const tablaProveedores = document.getElementById('tablaProveedores');
    
    if (tipo === 'clientes') {
        // Destruir DataTable de proveedores si existe (pero no vaciar)
        if (dataTableProveedores) {
            destruirDataTable('#tablaProveedores');
            dataTableProveedores = null;
        }
        
        // Mostrar tabla de clientes
        tablaClientes.style.display = 'table';
        tablaProveedores.style.display = 'none';
        
        // Inicializar DataTable de clientes si no existe
        if (!dataTableClientes) {
            dataTableClientes = inicializarDataTable('#tablaClientes');
        } else {
            // Si ya existe, solo ajustar
            setTimeout(function() {
                if (dataTableClientes) {
                    dataTableClientes.columns.adjust();
                    dataTableClientes.responsive.recalc();
                }
            }, 100);
        }
    } else {
        // Destruir DataTable de clientes si existe (pero no vaciar)
        if (dataTableClientes) {
            destruirDataTable('#tablaClientes');
            dataTableClientes = null;
        }
        
        // Mostrar tabla de proveedores
        tablaClientes.style.display = 'none';
        tablaProveedores.style.display = 'table';
        
        // Inicializar DataTable de proveedores si no existe
        if (!dataTableProveedores) {
            dataTableProveedores = inicializarDataTable('#tablaProveedores');
        } else {
            // Si ya existe, solo ajustar
            setTimeout(function() {
                if (dataTableProveedores) {
                    dataTableProveedores.columns.adjust();
                    dataTableProveedores.responsive.recalc();
                }
            }, 100);
        }
    }
}
</script>

<script src="assets/js/validaciones/pagos_validaciones.js"></script>
<script src="assets/js/ajax/pagos_ajax.js"></script>

  </body>
</html>
