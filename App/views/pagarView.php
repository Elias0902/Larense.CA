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
                if(isset($cuentasPagar) && is_array($cuentasPagar) && !empty($cuentasPagar)){
                foreach ($cuentasPagar as $cuenta):
                    $estado_class = '';
                    $estado_texto = '';
                    
                    switch($cuenta['estado_pago']) {
                        case 'Por Pagar':
                            $estado_class = 'badge-warning';
                            $estado_texto = 'Por Pagar';
                            break;
                        case 'Pagado':
                            $estado_class = 'badge-success';
                            $estado_texto = 'Pagada';
                            break;
                        default:
                            $estado_class = 'badge-secondary';
                            $estado_texto = ucfirst($cuenta['estado_pago']);
                    }
                    
                    // Verificar si está vencida
                    $hoy = date('Y-m-d');
                    $vencida = ($cuenta['fecha_vencimiento'] < $hoy && $cuenta['estado_cuenta'] != 'pagada' && $cuenta['estado'] != 'anulada');
                    if ($vencida) {
                        $estado_class = 'badge-danger';
                        $estado_texto = 'Vencida';
                    }
            ?>
                          <tr style="transition: all 0.2s;">
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                              <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                CC-00<?php echo $cuenta['id_cuenta_x_pagar']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <i class="fa fa-user me-1" style="color: #dc3545;"></i><?php echo $cuenta['tipo_id'] . $cuenta['id_proveedor'] . ' ' . $cuenta['nombre_proveedor'];?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 600; color: #dc3545;">
                              $<?php echo number_format($cuenta['monto_total'], 2); ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 600;" class="<?php echo $saldo_class; ?>">
                              $<?php echo number_format($cuenta['saldo_pendiente'], 2); ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666;">
                              <i class="fa fa-calendar me-1" style="color: #dc3545;"></i><?php echo date('d/m/Y', strtotime($cuenta['fecha_emision'])); ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666;">
                              <?php if($vencida): ?>
                                <span class="text-danger"><i class="fa fa-exclamation-circle me-1"></i><?php echo date('d/m/Y', strtotime($cuenta['fecha_vencimiento'])); ?></span>
                              <?php else: ?>
                                <i class="fa fa-calendar-check me-1" style="color: #dc3545;"></i><?php echo date('d/m/Y', strtotime($cuenta['fecha_vencimiento'])); ?>
                              <?php endif; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge <?php echo $estado_class; ?>" style="
                                <?php 
                                switch($cuenta['estado_pago']) {
                                  case 'Por Pagar': echo 'color: black;'; break;
                                  case 'Pagado': echo 'background:  #28a745; color: white;'; break;
                                  default: echo 'background: #e9ecef; color: #495057;';
                                }
                                ?> padding: 6px 12px; border-radius: 20px; font-weight: 500;">
                                <?php echo $estado_texto; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <div class="btn-group" role="group">
                                <?php if($cuenta['saldo_pendiente'] > 0 && $cuenta['estado_pago'] != 'anulada'): ?>
                                <button
                                  onclick="ObtenerCuentaPagar(<?php echo $cuenta['id_cuenta_x_pagar']; ?>)"
                                  data-bs-toggle="modal"
                                  data-bs-target="#PagoModal"
                                  type="button"
                                  class="btn btn-sm"
                                  title='Registrar Pago'
                                  data-bs-toggle="tooltip"
                                  style="background: #dc3545; color: white; border-radius: 6px 0 0 6px; border: none;"
                                >
                                  <i class="fa fa-dollar-sign"></i>
                                </button>
                                <?php endif; ?>
                              </div>
                            </td>
                          </tr>
                                      <?php
            endforeach;
        } else {
            echo "<tr><td colspan='8' class='text-center py-4'><div class='alert alert-info'><i class='fa fa-info-circle me-2'></i>No hay cuentas por cobrar registradas.</div></td></tr>";
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


<!-- Modal Registrar Pago -->
<div class="modal fade" id="PagoModal" tabindex="-1" aria-labelledby="pagoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formCobrarModificar" onsubmit="return validar_formulario()" method="post" action="index.php?url=pagar&action=registrar_pago">
        <div class="modal-header" style="background: #dc3545; border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="pagoModalLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-edit me-2"></i>Registrar Pago
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <input type="hidden" class="form-control" id="id" name="id" required>
          <input type="hidden" class="form-control" id="id_proveedor" name="id_proveedor" required>
          <div class="row">
            <div class="col-md-12">
              <div class="form-group mb-3">
                <label for="clienteIdEdit" class="form-label"><b>Proveedor <span class="text-danger">*</span></b></label>
                <input type="text" class="form-control" id="proveedorPago" name="proveedorPago" placeholder="Deuda"readonly>
                <span id="errorClientePago" class="error-messege"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="montoCuentaEdit" class="form-label"><b>Monto a Pagar <span class="text-danger">*</span></b></label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" class="form-control" id="montoPago" name="montoPago" placeholder="0.00" step="0.01" min="0.01" oninput="validar_monto()" required>
                </div>
                <span id="errorMontoPago" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="saldoCuentaEdit" class="form-label"><b>Monto Total</b></label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" class="form-control" id="montoTotal" name="montoTotal" placeholder="0.00" step="0.01" min="0" readonly require>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="fechaEmisionEdit" class="form-label"><b>Fecha<span class="text-danger">*</span></b></label>
                <input type="date" class="form-control" id="fechaPago" name="fechaPago" oninput="validar_fecha()" required>
                <span id="errorFechaPago" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="fechaVencimientoEdit" class="form-label"><b>Nro de Referencia <span class="text-danger">*</span></b></label>
                <input type="number" class="form-control" id="nroReferencia" name="nroReferencia" oninput="validar_nroReferencia()" required>
                <span id="errorNroReferencia" class="error-messege"></span>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="descripcionCuentaEdit" class="form-label"><b>Concepto <span class="text-danger">*</span></b></label>
            <textarea class="form-control" id="concepto" name="concepto" rows="2" placeholder="Concepto de la deuda..." maxlength="300" oninput="validar_concepto()" required></textarea>
            <span id="errorConcepto" class="error-messege"></span>
          </div>
          <div class="form-group mb-3">
            <label for="estadoCuentaEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-tag me-2" style="color: #dc3545;"></i>Metodo de Pago</label>
            <select class="form-select" id="metodoPago" name="metodoPago" onchange="validar_metodo()" style="border-radius: 8px;" required>
              <option value="">Seleccione metodo de pago</option>
                <?php
                  if(isset($metodos) && is_array($metodos) && !empty($metodos)) {
                      foreach($metodos as $metodo) {
                          echo '<option value="' . $metodo['id_metodo_pago'] . '">' . $metodo['nombre_metodo'] . '</option>';
                      }
                  }
                  ?>
            </select>
            <span id="errorMetodoPago" class="error-messege"></span>
          </div>
        </div>
        <div class="modal-footer" style="background: #f8f9fa; border-top: 1px solid #dee2e6; padding: 20px 25px;">
          <button type="button" class="btn" data-bs-dismiss="modal" style="background: #6c757d; color: white; border-radius: 8px; padding: 10px 25px;">
            <i class="fa fa-times me-2"></i>Cancelar
          </button>
          <button type="submit" class="btn" style="background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%); color: #212529; border-radius: 8px; padding: 10px 25px;">
            <i class="fa fa-edit me-2"></i>Registrar Pago
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
