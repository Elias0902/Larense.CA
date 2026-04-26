<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> Pedidos</title>
    <?php
    require_once 'components/links.php';
    ?>
    <link rel="stylesheet" href="assets/css/validaciones.css" />
    <link rel="stylesheet" href="assets/css/stylesModules/pedidos.css" />
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
                <i class="fa fa-shopping-cart" style="color: white; font-size: 20px;"></i>
              </div>
              <div>
                <h3 class="fw-bold mb-0" style="color: #333;">Gestión de Pedidos</h3>
                <nav aria-label="breadcrumb" class="mt-1">
                  <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #dc3545;"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: #333;">Pedidos</li>
                  </ol>
                </nav>
              </div>
            </div>
            <button
              class="btn btn-danger btn-round shadow-sm"
              data-bs-toggle="modal"
              data-bs-target="#pedidoModal"
              style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 10px 20px;"
            >
              <i class="fa fa-plus me-2"></i>
              Registrar Pedido
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
                    <i class="fa fa-list me-2"></i>Órdenes de Clientes
                  </h4>
                  <!-- Filtros de estado -->
                  <div class="btn-group" id="filtrosPedidos">
                    <button class="btn btn-sm filtro-btn active" data-filtro="todos" style="background: white; border: none; color: #dc3545; font-weight: 600;">
                      <i class="fa fa-filter me-1"></i> Todos
                    </button>
                    <button class="btn btn-sm filtro-btn" data-filtro="pendiente" style="background: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.5); color: white; font-weight: 500;">
                      <i class="fa fa-clock me-1"></i> Pendientes
                    </button>
                    <button class="btn btn-sm filtro-btn" data-filtro="procesando" style="background: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.5); color: white; font-weight: 500;">
                      <i class="fa fa-cog me-1"></i> Procesando
                    </button>
                    <button class="btn btn-sm filtro-btn" data-filtro="enviado" style="background: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.5); color: white; font-weight: 500;">
                      <i class="fa fa-truck me-1"></i> Enviados
                    </button>
                    <button class="btn btn-sm filtro-btn" data-filtro="entregado" style="background: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.5); color: white; font-weight: 500;">
                      <i class="fa fa-check-circle me-1"></i> Entregados
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
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Fecha</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Total</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Promoción</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Estado</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                          <?php
                if(isset($pedidos) && is_array($pedidos) && !empty($pedidos)){
                foreach ($pedidos as $pedido):
                    $estado_class = '';
                    $estado_texto = '';
                    $estado_icono = '';
                    
                    switch($pedido['estado']) {
                        case 'pendiente':
                            $estado_class = 'badge-warning';
                            $estado_texto = 'Pendiente';
                            $estado_icono = '<i class="fa fa-clock"></i>';
                            break;
                        case 'procesando':
                            $estado_class = 'badge-info';
                            $estado_texto = 'Procesando';
                            $estado_icono = '<i class="fa fa-cog fa-spin"></i>';
                            break;
                        case 'enviado':
                            $estado_class = 'badge-primary';
                            $estado_texto = 'Enviado';
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
                            $estado_texto = ucfirst($pedido['estado']);
                            $estado_icono = '<i class="fa fa-question"></i>';
                    }
                    
                    $cliente_nombre = $pedido['nombre_cliente'];
                    $promocion_info = $pedido['codigo_promocion'] ? '<span class="badge badge-info">' . $pedido['codigo_promocion'] . '</span>' : '<span class="text-muted">-</span>';
            ?>
                          <tr style="transition: all 0.2s;" data-id="<?php echo $pedido['id_pedido']; ?>" data-estado="<?php echo $pedido['estado']; ?>">
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                              <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                PED-00<?php echo $pedido['id_pedido']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <i class="fa fa-user me-1" style="color: #dc3545;"></i><?php echo $cliente_nombre; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <i class="fa fa-calendar me-1" style="color: #dc3545;"></i><?php echo date('d/m/Y', strtotime($pedido['fecha_pedido'])); ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 20px;">
                                $<?php echo number_format($pedido['total'], 2); ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;"><?php echo $promocion_info; ?></td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge <?php echo $estado_class; ?>" style="padding: 6px 12px; border-radius: 20px;">
                                <?php echo $estado_icono . ' ' . $estado_texto; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <div class="btn-group" role="group">
                                <!-- Ver Detalle -->
                                <a
                                  onclick="VerDetallePedido(<?php echo $pedido['id_pedido']; ?>)"
                                  data-bs-toggle="modal"
                                  data-bs-target="#pedidoDetalleModal"      
                                  type="button"
                                  class="btn btn-sm"
                                  title='Ver Detalle'
                                  style="background: #6c757d; color: white; border-radius: 6px 0 0 6px; border: none;"
                                >
                                  <i class="fa fa-eye"></i>
                                </a>
                                <!-- Cambiar Estado Dropdown -->
                                <div class="btn-group">
                                  <button type="button" class="btn btn-sm dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" title="Cambiar Estado" style="background: #17a2b8; color: white; border: none; border-radius: 0;">
                                    <i class="fa fa-exchange-alt"></i>
                                  </button>
                                  <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#" onclick="CambiarEstadoPedido(<?php echo $pedido['id_pedido']; ?>, 'pendiente')">🟡 Pendiente</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="CambiarEstadoPedido(<?php echo $pedido['id_pedido']; ?>, 'procesando')">🔵 Procesando</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="CambiarEstadoPedido(<?php echo $pedido['id_pedido']; ?>, 'enviado')">🚚 Enviado</a></li>
                                    <li><a class="dropdown-item" href="#" onclick="CambiarEstadoPedido(<?php echo $pedido['id_pedido']; ?>, 'entregado')">✅ Entregado</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item text-danger" href="#" onclick="CambiarEstadoPedido(<?php echo $pedido['id_pedido']; ?>, 'cancelado')">❌ Cancelar</a></li>
                                  </ul>
                                </div>
                                <a
                                  onclick="ObtenerPedido(<?php echo $pedido['id_pedido']; ?>)"
                                  data-bs-toggle="modal"
                                  data-bs-target="#pedidoModalModificar"
                                  type="button"
                                  class="btn btn-sm"
                                  title='Modificar'
                                  style="background: #ffc107; color: #212529; border: none;"
                                >
                                  <i class="fa fa-edit"></i>
                                </a>
                                <a href="#"
                                  onclick="return EliminarPedido(event,<?php echo $pedido['id_pedido']; ?>)"
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
            echo "<tr><td colspan='7'>No hay pedidos registrados.</td></tr>";
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
<div class="modal fade" id="pedidoModal" tabindex="-1" aria-labelledby="pedidoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formPedido" onsubmit="return validar_formulario()" method="post" action="index.php?url=pedidos&action=agregar">
        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="pedidoModalLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-shopping-cart me-2"></i>Nuevo Pedido
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
                <label for="fechaPedido" class="form-label"><b>Fecha del Pedido <span class="text-danger">*</span></b></label>
                <input type="date" class="form-control" id="fechaPedido" name="fechaPedido" oninput="validar_fecha()" required>
                <span id="errorFecha" class="error-messege"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="totalPedido" class="form-label"><b>Total del Pedido <span class="text-danger">*</span></b></label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" class="form-control" id="totalPedido" name="totalPedido" placeholder="0.00" step="0.01" min="0.01" oninput="validar_total()" required>
                </div>
                <span id="errorTotal" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="estadoPedido" class="form-label"><b>Estado del Pedido</b></label>
                <select class="form-select" id="estadoPedido" name="estadoPedido">
                  <option value="pendiente">🟡 Pendiente</option>
                  <option value="procesando">🔵 Procesando</option>
                  <option value="enviado">🚚 Enviado</option>
                  <option value="entregado">✅ Entregado</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="promocionId" class="form-label"><b>Promoción Aplicada</b></label>
                <select class="form-select" id="promocionId" name="promocionId">
                  <option value="">Sin promoción</option>
                  <?php
                  if(isset($promociones) && is_array($promociones) && !empty($promociones)) {
                      foreach($promociones as $promocion) {
                          echo '<option value="' . $promocion['id_promocion'] . '">' . $promocion['codigo_promocion'] . ' - ' . $promocion['nombre_promocion'] . '</option>';
                      }
                  }
                  ?>
                </select>
                <small class="form-text text-muted">Seleccione una promoción activa</small>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="telefonoPedido" class="form-label"><b>Teléfono de Contacto</b></label>
                <input type="text" class="form-control" id="telefonoPedido" name="telefonoPedido" placeholder="0412-1234567" maxlength="12" oninput="formatear_telefono(); validar_telefono()">
                <span id="errorTelefono" class="error-messege"></span>
                <small class="form-text text-muted">Formato: 04XX-XXXXXXX</small>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="direccionPedido" class="form-label"><b>Dirección de Entrega</b></label>
            <textarea class="form-control" id="direccionPedido" name="direccionPedido" rows="2" placeholder="Calle, Casa/Edificio, Ciudad, Estado..." maxlength="300" oninput="validar_direccion()"></textarea>
            <span id="errorDireccion" class="error-messege"></span>
          </div>
          <div class="form-group mb-3">
            <label for="observacionesPedido" class="form-label"><b>Observaciones</b></label>
            <textarea class="form-control" id="observacionesPedido" name="observacionesPedido" rows="2" placeholder="Notas adicionales sobre el pedido..." maxlength="500" oninput="validar_observaciones()"></textarea>
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
            <i class="fa fa-save me-2"></i>Crear Pedido
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Modificar -->
<div class="modal fade" id="pedidoModalModificar" tabindex="-1" aria-labelledby="pedidoModalModificarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formPedidoModificar" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=pedidos&action=modificar">
        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="pedidoModalModificarLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-edit me-2"></i>Modificar Pedido
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
                <label for="fechaPedidoEdit" class="form-label"><b>Fecha del Pedido <span class="text-danger">*</span></b></label>
                <input type="date" class="form-control" id="fechaPedidoEdit" name="fechaPedido" oninput="validar_fecha_modificado()" required>
                <span id="errorFechaEdit" class="error-messege"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="totalPedidoEdit" class="form-label"><b>Total del Pedido <span class="text-danger">*</span></b></label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" class="form-control" id="totalPedidoEdit" name="totalPedido" placeholder="0.00" step="0.01" min="0.01" oninput="validar_total_modificado()" required>
                </div>
                <span id="errorTotalEdit" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="estadoPedidoEdit" class="form-label"><b>Estado del Pedido</b></label>
                <select class="form-select" id="estadoPedidoEdit" name="estadoPedido">
                  <option value="pendiente">🟡 Pendiente</option>
                  <option value="procesando">🔵 Procesando</option>
                  <option value="enviado">🚚 Enviado</option>
                  <option value="entregado">✅ Entregado</option>
                  <option value="cancelado">❌ Cancelado</option>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="promocionIdEdit" class="form-label"><b>Promoción Aplicada</b></label>
                <select class="form-select" id="promocionIdEdit" name="promocionId">
                  <option value="">Sin promoción</option>
                  <?php
                  if(isset($promociones) && is_array($promociones) && !empty($promociones)) {
                      foreach($promociones as $promocion) {
                          echo '<option value="' . $promocion['id_promocion'] . '">' . $promocion['codigo_promocion'] . ' - ' . $promocion['nombre_promocion'] . '</option>';
                      }
                  }
                  ?>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="telefonoPedidoEdit" class="form-label"><b>Teléfono de Contacto</b></label>
                <input type="text" class="form-control" id="telefonoPedidoEdit" name="telefonoPedido" placeholder="0412-1234567" maxlength="12" oninput="formatear_telefono_modificado(); validar_telefono_modificado()">
                <span id="errorTelefonoEdit" class="error-messege"></span>
              </div>
            </div>
          </div>
          <div class="form-group mb-3">
            <label for="direccionPedidoEdit" class="form-label"><b>Dirección de Entrega</b></label>
            <textarea class="form-control" id="direccionPedidoEdit" name="direccionPedido" rows="2" placeholder="Calle, Casa/Edificio, Ciudad, Estado..." maxlength="300" oninput="validar_direccion_modificado()"></textarea>
            <span id="errorDireccionEdit" class="error-messege"></span>
          </div>
          <div class="form-group mb-3">
            <label for="observacionesPedidoEdit" class="form-label"><b>Observaciones</b></label>
            <textarea class="form-control" id="observacionesPedidoEdit" name="observacionesPedido" rows="2" placeholder="Notas adicionales sobre el pedido..." maxlength="500" oninput="validar_observaciones_modificado()"></textarea>
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
            <i class="fa fa-edit me-2"></i>Modificar Pedido
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Ver Detalle Pedido -->
<div class="modal fade" id="pedidoDetalleModal" tabindex="-1" aria-labelledby="pedidoDetalleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
      
      <!-- Header -->
      <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 25px; position: relative;">
        <div class="d-flex align-items-center w-100">
          <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            <i class="fa fa-shopping-cart" style="font-size: 30px; color: #dc3545;"></i>
          </div>
          <div class="ms-3" style="color: white;">
            <h4 class="mb-0 fw-bold" id="detalleIdPedido">PED-001</h4>
            <small class="opacity-75" id="detalleFechaPedido">01/01/2024</small>
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
                <h5 class="mb-0 fw-bold text-dark" id="detalleClientePedido">Nombre Cliente</h5>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
              <div class="card-body text-center p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                  <i class="fa fa-dollar-sign text-white" style="font-size: 24px;"></i>
                </div>
                <small class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">Total</small>
                <h3 class="mb-0 fw-bold text-dark" id="detalleTotalPedido">$0.00</h3>
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
                  <h6 class="fw-bold mb-1 text-dark">ESTADO DEL PEDIDO</h6>
                  <span class="badge" id="detalleEstadoPedido" style="padding: 8px 15px; border-radius: 20px; font-size: 0.9rem;">Pendiente</span>
                </div>
              </div>
              <div class="text-end">
                <small class="text-muted d-block">Promoción</small>
                <span id="detallePromocionPedido" class="badge badge-info">-</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Info adicional -->
        <div class="row">
          <div class="col-md-6">
            <div class="d-flex align-items-center mb-2">
              <i class="fa fa-phone me-2" style="color: #dc3545;"></i>
              <span class="text-muted" id="detalleTelefonoPedido">+58 412-1234567</span>
            </div>
            <div class="d-flex align-items-center">
              <i class="fa fa-calendar me-2" style="color: #dc3545;"></i>
              <span class="text-muted" id="detalleFechaCompleta">01/01/2024</span>
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex align-items-start">
              <i class="fa fa-map-marker me-2 mt-1" style="color: #dc3545;"></i>
              <span class="text-muted" id="detalleDireccionPedido">Dirección de entrega</span>
            </div>
          </div>
        </div>

        <!-- Observaciones -->
        <div class="mt-4">
          <h6 class="fw-bold mb-2 text-dark">Observaciones</h6>
          <div class="p-3" style="background: white; border-radius: 10px;">
            <span class="text-muted" id="detalleObservaciones">Sin observaciones</span>
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
// Funcionalidad de filtros de pedidos
document.addEventListener('DOMContentLoaded', function() {
    const filtroBtns = document.querySelectorAll('#filtrosPedidos .filtro-btn');
    const filasPedidos = document.querySelectorAll('#add-row tbody tr');
    
    // Función para aplicar filtro
    function aplicarFiltro(filtro) {
        filasPedidos.forEach(fila => {
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

// Función placeholder para VerDetallePedido
function VerDetallePedido(id) {
    // Aquí implementar la lógica para mostrar detalles del pedido
    console.log('Ver detalle del pedido:', id);
}
</script>

<script src="assets/js/validaciones/pedidos_validaciones.js"></script>
<script src="assets/js/ajax/pedidos_ajax.js"></script>

  </body>
</html>
