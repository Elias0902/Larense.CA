<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> Compras</title>
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
                <h3 class="fw-bold mb-0" style="color: #333;">Gestión de Compras</h3>
                <nav aria-label="breadcrumb" class="mt-1">
                  <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #dc3545;"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: #333;">Compras</li>
                  </ol>
                </nav>
              </div>
            </div>
            <button
              class="btn btn-danger btn-round shadow-sm"
              data-bs-toggle="modal"
              data-bs-target="#compraModal"
              style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 10px 20px;"
            >
              <i class="fa fa-plus me-2"></i>
              Registrar Compra
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
                    <i class="fa fa-list me-2"></i>Órdenes
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
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Proveedor</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Materia Prima</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Cantidad</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Total</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Pago</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Tasa</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Fecha</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                          <?php
                if(isset($compras) && is_array($compras) && !empty($compras)){
                foreach ($compras as $compra):
                    $estado_class = '';
                    $estado_texto = '';
                    $estado_icono = '';
                    
                    switch($compra['pago']) {
                        case 'Pendiente':
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
                            $estado_texto = ucfirst($compra['pago']);
                            $estado_icono = '<i class="fa fa-question"></i>';
                    }

                    switch($compra['pago']) {
                        case 'Por Pagar':
                            $estadoPago_class = 'badge-warning';
                            //$estado_texto = 'Pendiente';
                            $estadoPago_icono = '<i class="fa fa-clock"></i>';
                            break;
                        case 'Pagado':
                            $estadoPago_class = 'badge-success';
                            //$estado_texto = 'Entregado';
                            $estadoPago_icono = '<i class="fa fa-check-circle"></i>';
                            break;
                        default:
                            $estadoPago_class = 'badge-secondary';
                            $estadoPago_texto = ucfirst($compra['pago']);
                            $estadoPago_icono = '<i class="fa fa-question"></i>';
                    }
            ?>
                          <tr style="transition: all 0.2s;" data-id="<?php echo $compra['id_compra']; ?>" data-estado="<?php echo $compra['pago']; ?>">
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                              <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                CP-00<?php echo $compra['id_compra']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <i class="fa fa-user me-1" style="color: #dc3545;"></i><?php echo $compra['tipo_id'] . '-' . $compra['id_proveedor'] . ' ' . $compra['nombre_proveedor']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <i class="fa fa-cubes me-1" style="color: #dc3545;"></i><br><?php echo $compra['materiaPrima']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge" style="background: #ffc107; color: black; padding: 6px 12px; border-radius: 20px; font-weight: 500;">
                                <i class="fa fa-cubes me-1" style="color: #dc3545;"></i><br><?php echo $compra['cantidades']; ?><br> unidades
                              </span>
                              </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 20px;">
                                $<?php echo number_format($compra['monto_total_compra'], 2); ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge <?php echo $estadoPago_class; ?>" style=" color: black; padding: 6px 12px; border-radius: 20px;">
                                <?php echo $estadoPago_icono . ' ' . $compra['pago']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 20px;">
                                $<?php echo number_format($compra['monto_tasa'], 2); ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <i class="fa fa-calendar me-1" style="color: #dc3545;"></i><?php echo date('d/m/Y', strtotime($compra['fecha_compra'])); ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <div class="btn-group" role="group">
                                <a href="#"
                                  onclick="return EliminarCompra(event,<?php echo $compra['id_compra']; ?>)"
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
            echo "<tr><td colspan='7'>No hay compras registradas.</td></tr>";
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


<!-- Modal Modificar -->
<div class="modal fade" id="compraModalModificar" tabindex="-1" aria-labelledby="compraModalModificarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formPedidoModificar" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=compras&action=modificar">
        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="pedidoModalModificarLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-edit me-2"></i>Modificar Compra
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <input type="hidden" class="form-control" id="idEdit" name="id" required>
          
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="clienteIdEdit" class="form-label"><b>Proveedor <span class="text-danger">*</span></b></label>
                <select class="form-select select-readonly" id="proveedorIdEdit" name="proveedorId" onchange="validar_proveedor_modificado()" readonly>
                  <option value="">Seleccione un proveedor...</option>
                  <?php
                  if(isset($prov) && is_array($prov) && !empty($$prov)) {
                      foreach($$prov as $proveedor) {
                        echo '<option value="' . $proveedor['id_proveedor'] . '">'
                            . $proveedor['tipo_id'] . '-' . $proveedor['id_proveedor'] . ' ' . $proveedor['nombre_proveedor']
                            . '</option>';
                      }
                  }
                  ?>
                </select>
                <span id="errorProveedorEdit" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="diasCreditoEdit" class="form-label"><b>Días Crédito <span class="text-danger">*</span></b></label>
                <input type="number" class="form-control" id="diasCreditoEdit" name="diasCredito" require>
                <span id="errorCreditoEdit" class="error-messege"></span>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="fechaPedidoEdit" class="form-label"><b>Fecha de la Compra <span class="text-danger">*</span></b></label>
                <input type="date" class="form-control" id="fechaCompraEdit" name="fechaCompra" oninput="validar_fecha_modificado()" required>
                <span id="errorFechaEdit" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="estadoPedidoEdit" class="form-label"><b>Estado de la Compra</b></label>
                <select class="form-select" id="estadoCompraEdit" name="estadoCompra">
                  <?php
                  if (isset($estadoCompra) && is_array($estadoCompra) && !empty($estadoCompra)) {
                      foreach ($estadoCompra as $estado) {
                          echo '<option value="' . $estado['id_estado_pago'] . '">'
                              . $estado['nombre_estado'] . '</option>';
                      }
                  }
                  ?>
                </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="telefonoPedidoEdit" class="form-label"><b>Teléfono de Contacto</b></label>
                <input type="text" class="form-control" id="telefonoCompraEdit" name="telefonoCompra" placeholder="0412-1234567" maxlength="12" oninput="formatear_telefono_modificado(); validar_telefono_modificado()">
                <span id="errorTelefonoEdit" class="error-messege"></span>
                <small class="form-text text-muted">Formato: 04XX-XXXXXXX</small>
              </div>
            </div>
          </div>

          <div class="form-group mb-3">
            <label for="direccionPedidoEdit" class="form-label"><b>Dirección</b></label>
            <textarea class="form-control" id="direccionCompraEdit" name="direccionCompra" rows="2" placeholder="Calle, Casa/Edificio, Ciudad, Estado..." maxlength="300" oninput="validar_direccion_modificado()"></textarea>
            <span id="errorDireccionEdit" class="error-messege"></span>
          </div>

          <div class="form-group mb-3">
            <label for="observacionesPedidoEdit" class="form-label"><b>Observaciones</b></label>
            <textarea class="form-control" id="observacionesCompraEdit" name="observacionesPCompra" rows="2" placeholder="Notas adicionales sobre la compra..." maxlength="500" oninput="validar_observaciones_modificado()"></textarea>
            <span id="errorObservacionesEdit" class="error-messege"></span>
          </div>

          <div class="row align-items-center">
            <div class="col-md-4">
              <div class="form-group mb-3">
                <label for="subtotalEdit" class="form-label"><b>Subtotal <span class="text-danger">*</span></b></label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" class="form-control" id="subtotalEdit" readonly name="subtotalPedido" placeholder="0.00" step="0.01" min="0">
                </div>
                <span id="errorSubtotalEdit" class="error-messege"></span>
              </div>
            </div>

            <div class="col-md-4 d-flex align-items-center mb-3">
              <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" id="aplicarIvaEdit" onchange="actualizarTotalConIvaEdit()">
                <label class="form-check-label" for="aplicarIvaEdit">
                  Aplicar IVA <b>(16%)</b>
                </label>
              </div>
            </div>

            <div class="col-md-4">
              <div class="form-group mb-3">
                <label for="totalPedidoEdit" class="form-label"><b>Total de la Compra <span class="text-danger">*</span></b></label>
                <div class="input-group">
                  <span class="input-group-text">$</span>
                  <input type="number" class="form-control" id="totalCompraEdi" readonly name="totalCompra" placeholder="0.00" step="0.01" min="0.01">
                </div>
                <span id="errorTotalEdit" class="error-messege"></span>
              </div>
            </div>
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
            <i class="fa fa-edit me-2"></i>Modificar Compra
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Agregar -->
<div class="modal fade" id="compraModal" tabindex="-1" aria-labelledby="compraModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formPedido" onsubmit="return validar_formulario()" method="post" action="index.php?url=compras&action=agregar">
        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="pedidoModalLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-shopping-cart me-2"></i>Nueva Compra
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <div class="row">
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="clienteId" class="form-label"><b>Proveedor <span class="text-danger">*</span></b></label>
                <select class="form-select" id="proveedorId" name="proveedorId" onchange="validar_proveedor()" required>
                  <option value="">Seleccione un poveedor...</option>
                  <?php
                  if(isset($proveedores) && is_array($proveedores) && !empty($proveedores)) {
                      foreach($proveedores as $proveedor) {
                        echo '<option value="' . $proveedor['id_proveedor'] . '">'
                              . $proveedor['tipo_id'] . '' . $proveedor['id_proveedor'] . ' ' . $proveedor['nombre_proveedor']
                              . '</option>';
                    }
                  }
                  ?>
                </select>
                <span id="errorProveedor" class="error-messege"></span>
              </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="diasCredito" class="form-label"><b>Días Crédito <span class="text-danger">*</span></b></label>
                <input type="number" class="form-control" id="diasCredito" name="diasCredito" oninput='validar_diasCredito()' required>
                <span id="errorCredito" class="error-messege"></span>
              </div>
            </div>
          <div class="row">
           <div class="col-md-6"> 
            <div class="form-group mb-3">
                <label for="fechaPedido" class="form-label"><b>Fecha de la Compra<span class="text-danger">*</span></b></label>
                <input type="date" class="form-control" id="fechaCompra" name="fechaCompra" oninput="validar_fecha()" required>
                <span id="errorFecha" class="error-messege"></span>
            </div>
            </div>
            <div class="col-md-6">
              <div class="form-group mb-3">
                <label for="estadoPedido" class="form-label"><b>Estado de la Compra</b></label>
                <select class="form-select" id="estadoCompra" name="estadoCompra">
                  <?php
                    if (isset($estadoCompra) && is_array($estadoCompra) && !empty($estadoCompra)) {
                        foreach ($estadoCompra as $estado) {
                            echo '<option value="' . $estado['id_estado_pago'] . '">'
                                . $estado['nombre_estado'] . '</option>';
                        }
                    }
                    ?>
                </select>
              </div>
            </div>
          </div>
          <div class="row">
          <div class="form-group mb-3">
            <label for="observacionesPedido" class="form-label"><b>Observaciones</b></label>
            <textarea class="form-control" id="observacionesCompra" name="observacionesCompra" rows="2" placeholder="Notas adicionales sobre el pedido..." maxlength="500" oninput="validar_observaciones()"></textarea>
            <span id="errorObservaciones" class="error-messege"></span>
          </div>
          </div>
          <div class="row align-items-center" id="contenedorMateriaPrima">
            <div class="col-md-8 mb-3">
              <div class="form-group">
                <label for="productos" class="form-label"><b>Materias Primas *</b></label>
                <select class="form-select" id="materiasPrimas" onchange="validar_materiaPrima(); cargarPrecioMateriaPrima()">
                  <option value="">Seleccione una materia prima</option>
                  <?php
                  if(isset($materiasPrimas) && is_array($materiasPrimas) && !empty($materiasPrimas)){
                    foreach ($materiasPrimas as $materiaPrima):
                  ?>
                    <option value="<?php echo $materiaPrima['id_materia_prima']; ?>">
                      <?php echo $materiaPrima['nombre_materia_prima']; ?>
                    </option>
                  <?php
                    endforeach;
                  }
                  ?>
                </select>
                <span id="errorMateriaPrima" class="error-messege text-danger small"></span>
              </div>
            </div>

            <div class="col-md-2 mb-3">
              <label for="cantidadProducto" class="form-label" style="color: #333; font-weight: 500;">
                <i class="fa fa-cubes me-2" style="color: #dc3545;"></i>Cantidad *
              </label>
              <input type="number" class="form-control" id="cantidadMateriaPrima" placeholder="00" style="border-radius: 8px;" oninput="validar_cantidad(); actualizarPrecioProducto()">
              <span id="errorCantidad" class="error-messege text-danger small"></span>
            </div>

            <div class="col-md-2 mb-3">
              <label for="precioProducto" class="form-label" style="color: #333; font-weight: 500;">
                <i class="fa fa-dollar me-2" style="color: #dc3545;"></i>Precio *
              </label>
              <input type="number" class="form-control" id="precioMateriaPrima" placeholder="0.00" style="border-radius: 8px;" oninput="validar_precio(); actualizarPrecioProducto()">
              <span id="errorPrecio" class="error-messege text-danger small"></span>
            </div>
          </div>

            <div>
            <button type="button" class="btn btn-outline-success" style="margin-bottom: 1rem; width: 100%; align-items: center;" onclick="agregarMateriaPrima()">
              <i class="fa fa-plus me-2"></i>Agregar Matria Prima
            </button>
          </div>
            <div class="row align-items-center">
              <div class="col-md-4">
                <div class="form-group mb-3">
                  <label for="subtotalPedido" class="form-label"><b>Subtotal <span class="text-danger">*</span></b></label>
                  <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="subtotal" readonly name="subtotalCompra" placeholder="0.00" step="0.01" min="0">
                  </div>
                  <span id="errorSubtotal" class="error-messege"></span>
                </div>
              </div>

              <div class="col-md-4 d-flex align-items-center mb-3">
                <div class="form-check mt-4">
                  <input class="form-check-input" type="checkbox" id="aplicarIva" onchange="actualizarTotalConIva()">
                  <label class="form-check-label" for="aplicarIva">
                    Aplicar IVA <b>(16%)</b>
                  </label>
                </div>
              </div>

              <div class="col-md-4">
                <div class="form-group mb-3">
                  <label for="totalPedido" class="form-label"><b>Total de la Compra <span class="text-danger">*</span></b></label>
                  <div class="input-group">
                    <span class="input-group-text">$</span>
                    <input type="number" class="form-control" id="total" readonly name="totalCompra" placeholder="0.00" step="0.01" min="0.01" oninput="validar_total()" required>
                  </div>
                  <span id="errorTotal" class="error-messege"></span>
                </div>
              </div>
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
            <i class="fa fa-save me-2"></i>Crear Compra
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

<script src="assets/js/validaciones/compras_validaciones.js"></script>
<script src="assets/js/ajax/compras_ajax.js"></script>
<script src="assets/js/animacionesJS/compra.js"></script>

  </body>
</html>
