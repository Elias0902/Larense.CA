<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Gestión de Entregas</title>
    <?php
    require_once 'components/links.php';
    ?>
    <link rel="stylesheet" href="assets/css/validaciones.css" />
    <style>
      .estado-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.85rem;
      }
      .estado-pendiente { background: #fff3cd; color: #856404; }
      .estado-en_ruta { background: #d1ecf1; color: #0c5460; }
      .estado-entregado { background: #d4edda; color: #155724; }
      .estado-cancelado { background: #f8d7da; color: #721c24; }
      .table-hover tbody tr:hover {
        background-color: #f8f9fa;
        transform: scale(1.01);
        transition: all 0.2s;
      }
      .btn-action {
        transition: all 0.2s;
      }
      .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      }
      .filtro-btn {
        transition: all 0.3s ease;
      }
      .filtro-btn:hover {
        transform: translateY(-2px);
      }
    </style>
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
              <div class="icon-circle me-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fa fa-shipping-fast" style="color: white; font-size: 20px;"></i>
              </div>
              <div>
                <h3 class="fw-bold mb-0" style="color: #333;">Gesti&oacute;n de Entregas</h3>
                <nav aria-label="breadcrumb" class="mt-1">
                  <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #dc3545;"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: #333;">Entregas</li>
                  </ol>
                </nav>
              </div>
            </div>
            <button
              class="btn btn-danger btn-round shadow-sm"
              data-bs-toggle="modal"
              data-bs-target="#entregaModal"
              style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 10px 20px;"
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
              <div class="card-header py-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none;">
                <div class="d-flex align-items-center justify-content-between">
                  <h4 class="card-title mb-0" style="color: white; font-weight: 600;">
                    <i class="fa fa-list me-2"></i>Despacho F&iacute;sico de Pedidos
                  </h4>
                  <div class="btn-group" id="filtrosEntregas">
                    <button class="btn btn-sm filtro-btn" data-filtro="todos" style="background: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.5); color: white; font-weight: 500;">
                      <i class="fa fa-filter me-1"></i> Todos
                    </button>
                    <button class="btn btn-sm filtro-btn" data-filtro="pendiente" style="background: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.5); color: white; font-weight: 500;">
                      <i class="fa fa-clock me-1"></i> Pendientes
                    </button>
                    <button class="btn btn-sm filtro-btn" data-filtro="en_ruta" style="background: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.5); color: white; font-weight: 500;">
                      <i class="fa fa-truck me-1"></i> En Ruta
                    </button>
                    <button class="btn btn-sm filtro-btn" data-filtro="entregado" style="background: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.5); color: white; font-weight: 500;">
                      <i class="fa fa-check-circle me-1"></i> Entregados
                    </button>
                    <button class="btn btn-sm filtro-btn" data-filtro="cancelado" style="background: rgba(255,255,255,0.3); border: 1px solid rgba(255,255,255,0.5); color: white; font-weight: 500;">
                      <i class="fa fa-ban me-1"></i> Cancelados
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
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Pedido</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Dirección</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Teléfono</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Repartidor</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Fecha Programada</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Estado</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php if (isset($entregas) && is_array($entregas) && !empty($entregas)): ?>
                        <?php foreach ($entregas as $index => $entrega): 

                        $estado_class = '';
                        $estado_texto = '';
                        $estado_icono = '';

                          switch($entrega['estado']) {
                        case 'Por entregar':
                            $estado_class = 'badge-warning';
                            $estado_texto = 'Pendiente';
                            $estado_icono = '<i class="fa fa-clock"></i>';
                            break;
                        case 'Procesando':
                            $estado_class = 'badge-info';
                            $estado_texto = 'Procesando';
                            $estado_icono = '<i class="fa fa-cog fa-spin"></i>';
                            break;
                        case 'Enviado':
                            $estado_class = 'badge-primary';
                            $estado_texto = 'Enviado';
                            $estado_icono = '<i class="fa fa-truck"></i>';
                            break;
                        case 'Entregado':
                            $estado_class = 'badge-success';
                            $estado_texto = 'Entregado';
                            $estado_icono = '<i class="fa fa-check-circle"></i>';
                            break;
                        case 'Cancelado':
                            $estado_class = 'badge-danger';
                            $estado_texto = 'Cancelado';
                            $estado_icono = '<i class="fa fa-times-circle"></i>';
                            break;
                        default:
                            $estado_class = 'badge-secondary';
                            $estado_texto = ucfirst($pedido['nombre_estado']);
                            $estado_icono = '<i class="fa fa-question"></i>';
                    }
                        ?>
                          <tr data-estado="<?php echo $entrega['estado']; ?>">
                            <td><?php echo $index + 1; ?></td>
                            <td><?php echo isset($entrega['cliente_nombre']) ? htmlspecialchars($entrega['cliente_nombre']) : 'N/A'; ?></td>
                            <td><?php echo isset($entrega['pedido_id']) ? "Pedido #" . $entrega['pedido_id'] : "N/A"; ?></td>
                            <td><?php echo htmlspecialchars($entrega['direccion']); ?></td>
                            <td><?php echo htmlspecialchars($entrega['telefono_contacto']); ?></td>
                            <td><?php echo htmlspecialchars($entrega['repartidor']); ?></td>
                            <td><?php echo date('d/m/Y H:i', strtotime($entrega['fecha_programada'])); ?></td>
                            <td>
                              <span class="badge <?php echo $estado_class; ?>">
                                <?php echo ucfirst($entrega['estado']); ?>
                              </span>
                            </td>
                            <td>
                              <button class="btn btn-warning btn-sm btn-action" onclick="ObtenerEntrega(<?php echo $entrega['id_entregas']; ?>)" data-bs-toggle="modal" data-bs-target="#entregaModalModificar">
                                <i class="fa fa-edit"></i>
                              </button>
                              <button class="btn btn-danger btn-sm btn-action" onclick="EliminarEntrega(event, <?php echo $entrega['id_entregas']; ?>)">
                                <i class="fa fa-trash"></i>
                              </button>
                              <button class="btn btn-success btn-sm btn-action" onclick="ConfirmarEntrega(<?php echo $entrega['id_entregas']; ?>)">
                                <i class="fa fa-check"></i>
                              </button>
                            </td>
                          </tr>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <tr>
                          <td colspan="9" class="text-center">No hay entregas registradas</td>
                        </tr>
                      <?php endif; ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Paginación -->
        <div class="row mt-3">
          <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
              <span style="color: #666;">Mostrando <?php echo isset($entregas) ? count($entregas) : 0; ?> de <?php echo isset($entregas) ? count($entregas) : 0; ?> registros</span>
              <div class="btn-group">
                <button class="btn btn-outline-secondary btn-sm" disabled>Anterior</button>
                <button class="btn btn-danger btn-sm">1</button>
                <button class="btn btn-outline-secondary btn-sm" disabled>Siguiente</button>
              </div>
            </div>
          </div>
        </div>

        <div class="text-center mt-4 mb-4">
          <a href="index.php?url=dashboard" class="btn btn-secondary" style="border-radius: 8px; padding: 10px 20px;">
            <i class="fa fa-home me-2"></i>Men&uacute; Principal
          </a>
        </div>

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
      <form id="formEntrega" enctype="multipart/form-data" onsubmit="return validar_formulario()" method="post" action="index.php?url=entregas&action=agregar">
        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="entregaModalLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-truck me-2"></i>Programar Nueva Entrega
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="clienteId" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-user me-2" style="color: #dc3545;"></i>Cliente <span class="text-danger">*</span></label>
              <select class="form-select" id="clienteId" name="clienteId" onchange="cargarPedidosPorCliente()" style="border-radius: 8px;" required>
                <option value="">Seleccione un cliente...</option>
                <?php
                if(isset($clientes) && is_array($clientes) && !empty($clientes)) {
                    foreach($clientes as $cliente) {
                        $nombre_completo = ($cliente['nombre_cliente'] ?? '') . ' ' . ($cliente['apellido_cliente'] ?? '');
                        echo '<option value="' . ($cliente['id_cliente'] ?? '') . '">' . htmlspecialchars(trim($nombre_completo)) . ' - ' . ($cliente['tlf_cliente'] ?? '') . '</option>';
                    }
                }
                ?>
              </select>
              <span id="errorCliente" class="error-messege text-danger small"></span>
            </div>
            <div class="col-md-6 mb-3">
              <label for="pedidoId" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-shopping-cart me-2" style="color: #dc3545;"></i>Pedido (Opcional)</label>
              <select class="form-select" id="pedidoId" name="pedidoId" style="border-radius: 8px;">
                <option value="">Seleccione un pedido...</option>
              </select>
              <small class="form-text text-muted">Opcional - Asociar a un pedido existente</small>
            </div>
          </div>
          <div class="mb-3">
            <label for="direccionEntrega" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-map-marker me-2" style="color: #dc3545;"></i>Direcci&oacute;n de Entrega <span class="text-danger">*</span></label>
            <textarea class="form-control" id="direccionEntrega" name="direccionEntrega" rows="2" placeholder="Calle, Casa/Edificio, Ciudad, Estado..." style="border-radius: 8px;" oninput="validar_direccion()" required></textarea>
            <span id="errorDireccion" class="error-messege text-danger small"></span>
            <small class="form-text text-muted">Direcci&oacute;n completa donde se realizar&aacute; la entrega</small>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="telefonoEntrega" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-phone me-2" style="color: #dc3545;"></i>Tel&eacute;fono de Contacto</label>
              <input type="text" class="form-control" id="telefonoEntrega" name="telefonoEntrega" placeholder="0412-1234567" maxlength="12" style="border-radius: 8px;" oninput="formatear_telefono(); validar_telefono()">
              <span id="errorTelefono" class="error-messege text-danger small"></span>
              <small class="form-text text-muted">Formato: 04XX-XXXXXXX</small>
            </div>
            <div class="col-md-6 mb-3">
              <label for="repartidorEntrega" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-user-circle me-2" style="color: #dc3545;"></i>Repartidor Asignado</label>
              <input type="text" class="form-control" id="repartidorEntrega" name="repartidorEntrega" placeholder="Nombre del repartidor" style="border-radius: 8px;">
              <small class="form-text text-muted">Persona encargada de la entrega</small>
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="fechaProgramada" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-calendar me-2" style="color: #dc3545;"></i>Fecha y Hora Programada <span class="text-danger">*</span></label>
              <input type="datetime-local" class="form-control" id="fechaProgramada" name="fechaProgramada" style="border-radius: 8px;" oninput="validar_fecha()" required>
              <span id="errorFecha" class="error-messege text-danger small"></span>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="estadoEntrega" class="form-label"><b>Estado Inicial</b></label>
                <select class="form-select" id="estadoEntrega" name="estadoEntrega">
                  <option value="1">Entregado</option>
                  <option value="2">Por entregar</option>
                </select>
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label for="observacionesEntrega" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-sticky-note me-2" style="color: #dc3545;"></i>Observaciones</label>
            <textarea class="form-control" id="observacionesEntrega" name="observacionesEntrega" rows="2" placeholder="Notas adicionales sobre la entrega..." maxlength="500" style="border-radius: 8px;" oninput="validar_observaciones()"></textarea>
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
          <button type="submit" class="btn" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border-radius: 8px; padding: 10px 25px;">
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
      <form id="formEntregaModificar" enctype="multipart/form-data" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=entregas&action=modificar">
        <input type="hidden" id="id" name="id">
        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="entregaModalModificarLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-edit me-2"></i>Modificar Entrega
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="clienteIdEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-user me-2" style="color: #dc3545;"></i>Cliente <span class="text-danger">*</span></label>
              <select class="form-select" id="clienteIdEdit" name="clienteId" onchange="cargarPedidosPorClienteEdit()" style="border-radius: 8px;" required>
                <option value="">Seleccione un cliente...</option>
                <?php
                if(isset($clientes) && is_array($clientes) && !empty($clientes)) {
                    foreach($clientes as $cliente) {
                        $nombre_completo = ($cliente['nombre_cliente'] ?? '') . ' ' . ($cliente['apellido_cliente'] ?? '');
                        echo '<option value="' . ($cliente['id_cliente'] ?? '') . '">' . htmlspecialchars(trim($nombre_completo)) . ' - ' . ($cliente['tlf_cliente'] ?? '') . '</option>';
                    }
                }
                ?>
              </select>
              <span id="errorClienteEdit" class="error-messege text-danger small"></span>
            </div>
            <div class="col-md-6 mb-3">
              <label for="pedidoIdEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-shopping-cart me-2" style="color: #dc3545;"></i>Pedido (Opcional)</label>
              <select class="form-select" id="pedidoIdEdit" name="pedidoId" style="border-radius: 8px;">
                <option value="">Seleccione un pedido...</option>
              </select>
              <small class="form-text text-muted">Opcional - Asociar a un pedido existente</small>
            </div>
          </div>
          <div class="mb-3">
            <label for="direccionEntregaEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-map-marker me-2" style="color: #dc3545;"></i>Direcci&oacute;n de Entrega <span class="text-danger">*</span></label>
            <textarea class="form-control" id="direccionEntregaEdit" name="direccionEntrega" rows="2" placeholder="Calle, Casa/Edificio, Ciudad, Estado..." style="border-radius: 8px;" oninput="validar_direccion_modificado()" required></textarea>
            <span id="errorDireccionEdit" class="error-messege text-danger small"></span>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="telefonoEntregaEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-phone me-2" style="color: #dc3545;"></i>Tel&eacute;fono de Contacto</label>
              <input type="text" class="form-control" id="telefonoEntregaEdit" name="telefonoEntrega" placeholder="0412-1234567" maxlength="12" style="border-radius: 8px;" oninput="formatear_telefono_modificado(); validar_telefono_modificado()">
              <span id="errorTelefonoEdit" class="error-messege text-danger small"></span>
            </div>
            <div class="col-md-6 mb-3">
              <label for="repartidorEntregaEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-user-circle me-2" style="color: #dc3545;"></i>Repartidor Asignado</label>
              <input type="text" class="form-control" id="repartidorEntregaEdit" name="repartidorEntrega" placeholder="Nombre del repartidor" style="border-radius: 8px;">
            </div>
          </div>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="fechaProgramadaEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-calendar me-2" style="color: #dc3545;"></i>Fecha y Hora Programada <span class="text-danger">*</span></label>
              <input type="datetime-local" class="form-control" id="fechaProgramadaEdit" name="fechaProgramada" style="border-radius: 8px;" oninput="validar_fecha_modificado()" required>
              <span id="errorFechaEdit" class="error-messege text-danger small"></span>
            </div>
            <div class="col-md-6 mb-3">
              <label for="estadoEntregaEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-tag me-2" style="color: #dc3545;"></i>Estado</label>
              <select class="form-select" id="estadoEntregaEdit" name="estadoEntrega" style="border-radius: 8px;">
                <option value="pendiente">🟡 Pendiente</option>
                <option value="en_ruta">🔵 En Ruta</option>
                <option value="entregado">🟢 Entregado</option>
                <option value="cancelado">🔴 Cancelado</option>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label for="observacionesEntregaEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-sticky-note me-2" style="color: #dc3545;"></i>Observaciones</label>
            <textarea class="form-control" id="observacionesEntregaEdit" name="observacionesEntrega" rows="2" placeholder="Notas adicionales sobre la entrega..." maxlength="500" style="border-radius: 8px;" oninput="validar_observaciones_modificado()"></textarea>
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
<script>
// Funcionalidad de filtros de entregas
document.addEventListener('DOMContentLoaded', function() {
    const filtroBtns = document.querySelectorAll('#filtrosEntregas .filtro-btn');
    const filasEntregas = document.querySelectorAll('#add-row tbody tr[data-estado]');
    
    function aplicarFiltro(filtro) {
        let contador = 0;
        filasEntregas.forEach(fila => {
            const estado = fila.getAttribute('data-estado');
            if (filtro === 'todos' || estado === filtro) {
                fila.style.display = '';
                contador++;
            } else {
                fila.style.display = 'none';
            }
        });
        
        // Actualizar contador
        const contadorSpan = document.querySelector('.d-flex.justify-content-between.align-items-center span');
        if (contadorSpan) {
            contadorSpan.textContent = `Mostrando ${contador} de ${filasEntregas.length} registros`;
        }
    }
    
    filtroBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const filtro = this.getAttribute('data-filtro');
            
            filtroBtns.forEach(b => {
                b.style.background = 'rgba(255,255,255,0.3)';
                b.style.border = '1px solid rgba(255,255,255,0.5)';
                b.style.color = 'white';
            });
            
            this.style.background = 'white';
            this.style.border = 'none';
            this.style.color = '#dc3545';
            
            aplicarFiltro(filtro);
        });
    });
    
    // Por defecto, mostrar todos o pendientes
    aplicarFiltro('todos');
});

// Función para cargar pedidos por cliente en el modal de agregar
function cargarPedidosPorCliente() {
    const clienteId = document.getElementById('clienteId').value;
    const pedidoSelect = document.getElementById('pedidoId');
    
    if (!clienteId) {
        pedidoSelect.innerHTML = '<option value="">Seleccione un pedido...</option>';
        return;
    }
    
    fetch(`index.php?url=entregas&action=obtener_pedidos_por_cliente&cliente_id=${clienteId}`)
        .then(response => response.json())
        .then(data => {
            pedidoSelect.innerHTML = '<option value="">Seleccione un pedido...</option>';
            if (data.status && data.data && data.data.length > 0) {
                data.data.forEach(pedido => {
                    const option = document.createElement('option');
                    option.value = pedido.id_pedido;
                    const fecha = new Date(pedido.fecha_pedido).toLocaleDateString();
                    option.textContent = `Pedido #${pedido.id_pedido} - ${pedido.nombre_estado_pedido || 'Sin estado'} - ${fecha} - $${pedido.monto_total_pedido}`;
                    pedidoSelect.appendChild(option);
                });
            } else {
                pedidoSelect.innerHTML = '<option value="">No hay pedidos disponibles para este cliente</option>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            pedidoSelect.innerHTML = '<option value="">Error al cargar pedidos</option>';
        });
}

// Función para cargar pedidos por cliente en el modal de editar
function cargarPedidosPorClienteEdit() {
    const clienteId = document.getElementById('clienteIdEdit').value;
    const pedidoSelect = document.getElementById('pedidoIdEdit');
    const currentPedidoId = document.getElementById('pedidoIdEdit').getAttribute('data-current-pedido') || '';
    
    if (!clienteId) {
        pedidoSelect.innerHTML = '<option value="">Seleccione un pedido...</option>';
        return;
    }
    
    fetch(`index.php?url=entregas&action=obtener_pedidos_por_cliente&cliente_id=${clienteId}`)
        .then(response => response.json())
        .then(data => {
            pedidoSelect.innerHTML = '<option value="">Seleccione un pedido...</option>';
            if (data.status && data.data && data.data.length > 0) {
                data.data.forEach(pedido => {
                    const option = document.createElement('option');
                    option.value = pedido.id_pedido;
                    const fecha = new Date(pedido.fecha_pedido).toLocaleDateString();
                    option.textContent = `Pedido #${pedido.id_pedido} - ${pedido.nombre_estado_pedido || 'Sin estado'} - ${fecha} - $${pedido.monto_total_pedido}`;
                    if (currentPedidoId && pedido.id_pedido == currentPedidoId) {
                        option.selected = true;
                    }
                    pedidoSelect.appendChild(option);
                });
            } else {
                pedidoSelect.innerHTML = '<option value="">No hay pedidos disponibles para este cliente</option>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            pedidoSelect.innerHTML = '<option value="">Error al cargar pedidos</option>';
        });
}

// Función para confirmar entrega
function ConfirmarEntrega(id) {
    if (confirm('¿Estás seguro de confirmar esta entrega como ENTREGADA? Esta acción actualizará el estado del pedido a "Entregado" y no podrá deshacerse.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php?url=entregas&action=confirmar_entrega';
        
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'id';
        input.value = id;
        
        form.appendChild(input);
        document.body.appendChild(form);
        form.submit();
    }
}

// Función para cambiar estado
function CambiarEstado(id, nuevoEstado) {
    let mensaje = '';
    switch(nuevoEstado) {
        case 'pendiente': mensaje = '¿Estás seguro de cambiar el estado a PENDIENTE?'; break;
        case 'en_ruta': mensaje = '¿Estás seguro de cambiar el estado a EN RUTA?'; break;
        case 'entregado': mensaje = '¿Estás seguro de cambiar el estado a ENTREGADO? Esto actualizará el pedido.'; break;
        case 'cancelado': mensaje = '¿Estás seguro de cancelar esta entrega?'; break;
        default: mensaje = '¿Estás seguro de cambiar el estado?';
    }
    
    if (confirm(mensaje)) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = 'index.php?url=entregas&action=cambiar_estado';
        
        const inputId = document.createElement('input');
        inputId.type = 'hidden';
        inputId.name = 'id';
        inputId.value = id;
        
        const inputEstado = document.createElement('input');
        inputEstado.type = 'hidden';
        inputEstado.name = 'nuevo_estado';
        inputEstado.value = nuevoEstado;
        
        form.appendChild(inputId);
        form.appendChild(inputEstado);
        document.body.appendChild(form);
        form.submit();
    }
}

// Función para eliminar entrega
function EliminarEntrega(event, id) {
    event.preventDefault();
    if (confirm('¿Estás seguro de eliminar esta entrega? Esta acción es irreversible.')) {
        window.location.href = `index.php?url=entregas&action=eliminar&ID=${id}`;
    }
    return false;
}

// Función para obtener entrega y cargar en modal de modificar
function ObtenerEntrega(id) {
    fetch(`index.php?url=entregas&action=obtener&ID=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }
            
            document.getElementById('id').value = data.id_entregas;
            document.getElementById('clienteIdEdit').value = data.cliente_id;
            document.getElementById('direccionEntregaEdit').value = data.direccion;
            document.getElementById('telefonoEntregaEdit').value = data.telefono_contacto || '';
            document.getElementById('repartidorEntregaEdit').value = data.repartidor || '';
            document.getElementById('observacionesEntregaEdit').value = data.observaciones || '';
            document.getElementById('estadoEntregaEdit').value = data.estado;
            
            // Formatear fecha para input datetime-local
            if (data.fecha_programada) {
                const fecha = new Date(data.fecha_programada);
                const fechaFormateada = fecha.toISOString().slice(0, 16);
                document.getElementById('fechaProgramadaEdit').value = fechaFormateada;
            }
            
            // Guardar el pedido actual para seleccionarlo después
            if (data.id_pedido) {
                document.getElementById('pedidoIdEdit').setAttribute('data-current-pedido', data.id_pedido);
            }
            
            // Cargar pedidos del cliente
            setTimeout(() => {
                cargarPedidosPorClienteEdit();
            }, 100);
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al obtener los datos de la entrega');
        });
}

// Funciones de validación (puedes implementarlas según necesites)
function validar_formulario() {
    // Implementar validaciones del formulario de agregar
    return true;
}

function validar_formulario_modificado() {
    // Implementar validaciones del formulario de modificar
    return true;
}

function validar_direccion() {}
function validar_telefono() {}
function validar_fecha() {}
function validar_observaciones() {}
function validar_direccion_modificado() {}
function validar_telefono_modificado() {}
function validar_fecha_modificado() {}
function validar_observaciones_modificado() {}
function formatear_telefono() {}
function formatear_telefono_modificado() {}
</script>
  </body>
</html>