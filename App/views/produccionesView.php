<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Producciones</title>
    <?php
    require_once 'components/links.php';
    ?>
    <link rel="stylesheet" href="assets/css/validaciones.css" />
    <link rel="stylesheet" href="assets/css/stylesModules/producciones.css" />
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
                <i class="fa fa-industry" style="color: white; font-size: 20px;"></i>
              </div>
              <div>
                <h3 class="fw-bold mb-0" style="color: #333;">Gestión de Producciones</h3>
                <nav aria-label="breadcrumb" class="mt-1">
                  <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #dc3545;"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: #333;">Producciones</li>
                  </ol>
                </nav>
              </div>
            </div>
            <button
              class="btn btn-round shadow-sm"
              data-bs-toggle="modal"
              data-bs-target="#produccionModal"
              style="background: #dc3545; border: none; padding: 10px 20px; color: white;"
            >
              <i class="fa fa-plus me-2"></i>
              Nueva Producción
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
                    <i class="fa fa-list me-2"></i>Registros de Producciones
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
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">ID</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Producto</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Cantidad Producida</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                          <?php 
                if(isset($producciones) && is_array($producciones) && !empty($producciones)){
                foreach ($producciones as $prod): 
            ?>
                          <tr style="transition: all 0.2s;">
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                              <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                PROD-00<?php echo $prod['id_produccion']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <i class="fa fa-box me-1" style="color: #dc3545;"></i><?php echo $prod['nombre_producto']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <?php
                                $cantidad = $prod['cantidad_producida'];
                                if ($cantidad < 10) {
                                    $bgColor = '#dc3545';
                                    $textColor = '#ffffff';
                                    $estado = 'Stock Bajo';
                                } elseif ($cantidad <= 20) {
                                    $bgColor = '#ffc107';
                                    $textColor = '#000000';
                                    $estado = 'Stock Medio';
                                } else {
                                    $bgColor = '#28a745';
                                    $textColor = '#ffffff';
                                    $estado = 'Stock Alto';
                                }
                              ?>
                              <span class="badge" style="background: <?php echo $bgColor; ?>; color: <?php echo $textColor; ?>; padding: 6px 12px; border-radius: 20px; font-weight: 500;" title="<?php echo $estado; ?>">
                                <i class="fa fa-cubes me-1"></i><?php echo $cantidad; ?> unidades
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <div class="btn-group" role="group">
                                <a
                                onclick="ObtenerProduccion(<?php echo $prod['id_produccion']; ?>)"
                                data-bs-toggle="modal"
                                data-bs-target="#produccionModalModificar"      
                                type="button"
                                class="btn btn-sm"
                                title='Modificar'
                                style="background: #17a2b8; color: white; border-radius: 6px 0 0 6px; border: none;"
                                >
                                  <i class="fa fa-edit"></i>
                                </a>
                                <a href="#"
                                  onclick="return EliminarProduccion(event, <?php echo $prod['id_produccion']; ?>);"
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
            echo "<tr><td colspan='4' class='text-center py-4'><div class='alert alert-info'><i class='fa fa-info-circle me-2'></i>No hay producciones registradas.</div></td></tr>";
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
<div class="modal fade" id="produccionModal" tabindex="-1" aria-labelledby="produccionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formProduccion" enctype="multipart/form-data" onsubmit="return validar_formulario()" method="post" action="index.php?url=producciones&action=agregar">
        <div class="modal-header" style="background: #dc3545; border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="produccionModalLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-plus-circle me-2"></i>Nueva Producción
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="productoProduccion" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-box me-2" style="color: #dc3545;"></i>Producto *</label>
              <select name="productoProduccion" id="productoProduccion" class="form-select" style="border-radius: 8px;" oninput="validar_producto()" required>
                <option value="">Seleccione un producto</option>
                <?php foreach ($productos as $producto): ?>
                <option value="<?php echo $producto['id_producto'] ?>"><?php echo $producto['nombre_producto']; ?></option>
                <?php endforeach; ?>
              </select>
              <span id="errorProducto" class="error-messege text-dredr small"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label for="cantidadProduccion" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-cubes me-2" style="color: #dc3545;"></i>Cantidad Producida *</label>
              <input type="number" class="form-control" id="cantidadProduccion" name="cantidadProduccion" placeholder="Ingrese la cantidad" style="border-radius: 8px;" oninput="validar_cantidad()" required>
              <span id="errorCantidad" class="error-messege text-dredr small"></span>
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
          <button type="submit" class="btn" style="background: #dc3545; color: white; border-radius: 8px; padding: 10px 25px;">
            <i class="fa fa-save me-2"></i>Guardar Producción
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Modificar -->
<div class="modal fade" id="produccionModalModificar" tabindex="-1" aria-labelledby="produccionModalModificarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formProduccionModificar" enctype="multipart/form-data" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=producciones&action=modificar">
        <div class="modal-header" style="background: #dc3545; border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="produccionModalModificarLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-edit me-2"></i>Modificar Producción
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <input type="hidden" class="form-control" id="idEdit" name="idEdit" required>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="productoProduccionEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-box me-2" style="color: #dc3545;"></i>Producto *</label>
              <select name="productoProduccionEdit" id="productoProduccionEdit" class="form-select" style="border-radius: 8px;" oninput="validar_producto_modificado()" required>
                <option value="">Seleccione un producto</option>
                <?php foreach ($productos as $producto): ?>
                <option value="<?php echo $producto['id_producto'] ?>"><?php echo $producto['nombre_producto']; ?></option>
                <?php endforeach; ?>
              </select>
              <span id="errorProductoEdit" class="error-messege text-dredr small"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label for="cantidadProduccionEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-cubes me-2" style="color: #dc3545;"></i>Cantidad Producida *</label>
              <input type="number" class="form-control" id="cantidadProduccionEdit" name="cantidadProduccionEdit" placeholder="Ingrese la cantidad" style="border-radius: 8px;" oninput="validar_cantidad_modificado()" required>
              <span id="errorCantidadEdit" class="error-messege text-dredr small"></span>
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
          <button type="submit" class="btn" style="background: #dc3545; color: white; border-radius: 8px; padding: 10px 25px;">
            <i class="fa fa-edit me-2"></i>Modificar Producción
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="assets/js/validaciones/produccion_validaciones.js"></script>
<script src="assets/js/ajax/produccion_ajax.js"></script>
<script src="assets/js/animacionesJs/dashboard_producciones.js"></script>

  </body>
</html>
