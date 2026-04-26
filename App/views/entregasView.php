<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Gestión de Entregas</title>
    <?php
    require_once 'components/links.php';
    ?>
    <link rel="stylesheet" href="assets/css/validaciones.css" />
    <link rel="stylesheet" href="assets/css/stylesModules/entregas.css" />
  </head>
  <body>
    <?php
    require_once 'components/menu.php';
    require_once 'components/header.php';
    ?>

    <!-- Espacio superior para evitar choque con header -->
    <div style="padding-top: 120px;"></div>

    <div class="container-fluid px-4">
      <div class="page-inner">
        
        <!-- Header de página estilizado -->
        <div class="page-header-custom mb-4">
          <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
              <div class="icon-circle me-3" style="background: #dc3545; width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fa fa-shipping-fast" style="color: white; font-size: 20px;"></i>
              </div>
              <div>
                <h3 class="fw-bold mb-0" style="color: #333;">Gestión de Entregas</h3>
                <nav aria-label="breadcrumb" class="mt-1">
                  <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #721c24;"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: #333;">Entregas</li>
                  </ol>
                </nav>
              </div>
            </div>
            <button
              class="btn btn-round shadow-sm"
              data-bs-toggle="modal"
              data-bs-target="#entregaModal"
              style="background: #dc3545; border: none; padding: 10px 20px; color: white;"
            >
              <i class="fa fa-plus me-2"></i>
              Nueva Entrega
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
                    <i class="fa fa-list me-2"></i>Despacho Físico de Pedidos
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
                        <th style="padding: 15px; color: #721c24; font-weight: 600; border-bottom: 2px solid #721c24;">#</th>
                        <th style="padding: 15px; color: #721c24; font-weight: 600; border-bottom: 2px solid #721c24;">Pedido</th>
                        <th style="padding: 15px; color: #721c24; font-weight: 600; border-bottom: 2px solid #721c24;">Cliente</th>
                        <th style="padding: 15px; color: #721c24; font-weight: 600; border-bottom: 2px solid #721c24;">Teléfono</th>
                        <th style="padding: 15px; color: #721c24; font-weight: 600; border-bottom: 2px solid #721c24;">Dirección</th>
                        <th style="padding: 15px; color: #721c24; font-weight: 600; border-bottom: 2px solid #721c24;">Fecha Programada</th>
                        <th style="padding: 15px; color: #721c24; font-weight: 600; border-bottom: 2px solid #721c24;">Estado</th>
                        <th style="padding: 15px; color: #721c24; font-weight: 600; border-bottom: 2px solid #721c24; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                          <?php
                if(isset($entregas) && is_array($entregas) && !empty($entregas)){
                foreach ($entregas as $entrega):
                    $estado_class = '';
                    $estado_texto = '';
                    $estado_icono = '';
                    
                    switch($entrega['estado']) {
                        case 'pendiente':
                            $estado_class = 'badge-warning';
                            $estado_texto = 'Pendiente';
                            $estado_icono = '<i class="fa fa-clock"></i>';
                            break;
                        case 'en_ruta':
                            $estado_class = 'badge-info';
                            $estado_texto = 'En Ruta';
                            $estado_icono = '<i class="fa fa-truck"></i>';
                            break;
                        case 'entregado':
                            $estado_class = 'badge-success';
                            $estado_texto = 'Entregado';
                            $estado_icono = '<i class="fa fa-check-circle"></i>';
                            break;
                        case 'cancelado':
                            $estado_class = 'badge-danger';
                            $estado_texto = 'Cancelado';
                            $estado_icono = '<i class="fa fa-times-circle"></i>';
                            break;
                        default:
                            $estado_class = 'badge-secondary';
                            $estado_texto = ucfirst($entrega['estado']);
                            $estado_icono = '<i class="fa fa-question"></i>';
                    }
                    
                    $cliente_nombre = isset($entrega['nombre_cliente']) 
                        ? $entrega['nombre_cliente'] 
                        : 'Cliente ID: ' . $entrega['cliente_id'];
                    $pedido_numero = $entrega['pedido_id'] ? '#' . $entrega['pedido_id'] : '<span class="text-muted">Sin pedido</span>';
            ?>
                          <tr style="transition: all 0.2s;">
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                              <span class="badge" style="background: #721c24; color: white; padding: 6px 10px; border-radius: 6px;">
                                ENT-00<?php echo isset($entrega['id_entrega']) ? $entrega['id_entrega'] : (isset($entrega['id_entregas']) ? $entrega['id_entregas'] : 'N/A'); ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <?php echo $pedido_numero; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <i class="fa fa-user me-1" style="color: #721c24;"></i><?php echo $cliente_nombre; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666;">
                              <i class="fa fa-phone me-1" style="color: #721c24;"></i><?php echo $entrega['telefono_contacto'] ?: '<span class="text-muted">-</span>'; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666; max-width: 200px;" class="text-truncate">
                              <i class="fa fa-map-marker me-1" style="color: #721c24;"></i><?php echo $entrega['direccion']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666;">
                              <i class="fa fa-calendar me-1" style="color: #721c24;"></i><?php echo date('d/m/Y h:i A', strtotime($entrega['fecha_programada'])); ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge" style="
                                <?php 
                                switch($entrega['estado']) {
                                  case 'pendiente': echo 'background: #fff3cd; color: #856404;'; break;
                                  case 'en_ruta': echo 'background: #d1ecf1; color: #0c5460;'; break;
                                  case 'entregado': echo 'background: #d4edda; color: #155724;'; break;
                                  case 'cancelado': echo 'background: #f8d7da; color: #721c24;'; break;
                                  default: echo 'background: #f8d7da; color: #495057;';
                                }
                                ?> padding: 6px 12px; border-radius: 20px; font-weight: 500;">
                                <?php echo $estado_icono . ' ' . $estado_texto; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <div class="btn-group" role="group">
                                <?php if($entrega['estado'] !== 'entregado' && $entrega['estado'] !== 'cancelado'): ?>
                                <button
                                  onclick="ConfirmarEntrega(<?php echo $entrega['id_entrega']; ?>)"
                                  type="button"
                                  class="btn btn-sm"
                                  title='Confirmar Entrega'
                                  data-bs-toggle="tooltip"
                                  style="background: #721c24; color: white; border-radius: 6px 0 0 6px; border: none;"
                                >
                                  <i class="fa fa-check"></i>
                                </button>
                                <?php endif; ?>
                                <a
                                onclick="ObtenerEntrega(<?php echo $entrega['id_entrega']; ?>)"
                                data-bs-toggle="modal"
                                data-bs-target="#entregaModalModificar"
                                type="button"
                                class="btn btn-sm"
                                title='Modificar'
                                style="background: #17a2b8; color: white; border: none;<?php echo ($entrega['estado'] !== 'entregado' && $entrega['estado'] !== 'cancelado') ? '' : 'border-radius: 6px 0 0 6px;'; ?>"
                                >
                                  <i class="fa fa-edit"></i>
                                </a>
                                <a href="#"
                                 onclick="return EliminarEntrega(event,<?php echo $entrega['id_entrega']; ?>)"
                                  type="button"
                                  data-bs-toggle="tooltip"
                                  class="btn btn-sm"
                                  title='Eliminar'
                                  style="background: #721c24; color: white; border-radius: 0 6px 6px 0; border: none;"
                                >
                                  <i class="fa fa-trash"></i>
                                </a>
                              </div>
                            </td>
                          </tr>
                                      <?php
            endforeach;
        } else {
            echo "<tr><td colspan='8' class='text-center py-4'><div class='alert alert-info'><i class='fa fa-info-circle me-2'></i>No hay entregas registradas.</div></td></tr>";
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
<div class="modal fade" id="entregaModal" tabindex="-1" aria-labelledby="entregaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formEntrega" onsubmit="return validar_formulario()" method="post" action="index.php?url=entregas&action=agregar">
        <div class="modal-header" style="background: #dc3545; border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="entregaModalLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-truck me-2"></i>Programar Nueva Entrega
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
                <small class="form-text text-muted">Dejar vacío si es entrega general</small>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="direccionEntrega" class="form-label"><b>Dirección de Entrega <span class="text-danger">*</span></b></label>
            <textarea class="form-control" id="direccionEntrega" name="direccionEntrega" rows="2" placeholder="Calle, Casa/Edificio, Ciudad, Estado..." oninput="validar_direccion()" required></textarea>
            <span id="errorDireccion" class="error-messege"></span>
            <small class="form-text text-muted">Dirección completa donde se realizará la entrega</small>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="telefonoEntrega" class="form-label"><b>Teléfono de Contacto</b></label>
                <input type="text" class="form-control" id="telefonoEntrega" name="telefonoEntrega" placeholder="0412-1234567" maxlength="12" oninput="formatear_telefono(); validar_telefono()">
                <span id="errorTelefono" class="error-messege"></span>
                <small class="form-text text-muted">Formato: 04XX-XXXXXXX</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="repartidorEntrega" class="form-label"><b>Repartidor Asignado</b></label>
                <input type="text" class="form-control" id="repartidorEntrega" name="repartidorEntrega" placeholder="Nombre del repartidor">
                <small class="form-text text-muted">Persona encargada de la entrega</small>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="fechaProgramada" class="form-label"><b>Fecha y Hora Programada <span class="text-danger">*</span></b></label>
                <input type="datetime-local" class="form-control" id="fechaProgramada" name="fechaProgramada" oninput="validar_fecha()" required>
                <span id="errorFecha" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="estadoEntrega" class="form-label"><b>Estado Inicial</b></label>
                <select class="form-select" id="estadoEntrega" name="estadoEntrega">
                  <option value="pendiente">🟡 Pendiente</option>
                  <option value="en_ruta">🔵 En Ruta</option>
                  <option value="entregado">🟢 Entregado</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="observacionesEntrega" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-sticky-note me-2" style="color: #721c24;"></i>Observaciones</label>
            <textarea class="form-control" id="observacionesEntrega" name="observacionesEntrega" rows="2" placeholder="Notas adicionales sobre la entrega..." maxlength="500" oninput="validar_observaciones()" style="border-radius: 8px;"></textarea>
            <span id="errorObservaciones" class="error-messege text-danger small"></span>
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
          <button type="submit" class="btn" style="background: #dc3545; color: white; border-radius: 8px; padding: 10px 25px;">
            <i class="fa fa-save me-2"></i>Programar Entrega
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Modificar -->
<div class="modal fade" id="entregaModalModificar" tabindex="-1" aria-labelledby="entregaModalModificarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formEntregaModificar" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=entregas&action=modificar">
        <div class="modal-header" style="background: #dc3545; border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="entregaModalModificarLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-edit me-2"></i>Modificar Entrega
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
          <div class="form-group mb-3">
            <label for="direccionEntregaEdit" class="form-label"><b>Dirección de Entrega <span class="text-danger">*</span></b></label>
            <textarea class="form-control" id="direccionEntregaEdit" name="direccionEntrega" rows="2" placeholder="Calle, Casa/Edificio, Ciudad, Estado..." oninput="validar_direccion_modificado()" required></textarea>
            <span id="errorDireccionEdit" class="error-messege"></span>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="telefonoEntregaEdit" class="form-label"><b>Teléfono de Contacto</b></label>
                <input type="text" class="form-control" id="telefonoEntregaEdit" name="telefonoEntrega" placeholder="0412-1234567" maxlength="12" oninput="formatear_telefono_modificado(); validar_telefono_modificado()">
                <span id="errorTelefonoEdit" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="repartidorEntregaEdit" class="form-label"><b>Repartidor Asignado</b></label>
                <input type="text" class="form-control" id="repartidorEntregaEdit" name="repartidorEntrega" placeholder="Nombre del repartidor">
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="fechaProgramadaEdit" class="form-label"><b>Fecha y Hora Programada <span class="text-danger">*</span></b></label>
                <input type="datetime-local" class="form-control" id="fechaProgramadaEdit" name="fechaProgramada" oninput="validar_fecha_modificado()" required>
                <span id="errorFechaEdit" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="estadoEntregaEdit" class="form-label"><b>Estado</b></label>
                <select class="form-select" id="estadoEntregaEdit" name="estadoEntrega">
                  <option value="pendiente">🟡 Pendiente</option>
                  <option value="en_ruta">🔵 En Ruta</option>
                  <option value="entregado">🟢 Entregado</option>
                  <option value="cancelado">🔴 Cancelado</option>
                </select>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="observacionesEntregaEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-sticky-note me-2" style="color: #721c24;"></i>Observaciones</label>
            <textarea class="form-control" id="observacionesEntregaEdit" name="observacionesEntrega" rows="2" placeholder="Notas adicionales sobre la entrega..." maxlength="500" oninput="validar_observaciones_modificado()" style="border-radius: 8px;"></textarea>
            <span id="errorObservacionesEdit" class="error-messege text-danger small"></span>
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
            <i class="fa fa-edit me-2"></i>Modificar Entrega
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="assets/js/validaciones/entregas_validaciones.js"></script>
<script src="assets/js/ajax/entregas_ajax.js"></script>

  </body>
</html>
