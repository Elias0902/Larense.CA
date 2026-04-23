<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Materias Primas</title>
    <?php
    require_once 'components/links.php';
    ?>
    <link rel="stylesheet" href="assets/css/validaciones.css" />
    <link rel="stylesheet" href="assets/css/select.css" />

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
                <i class="fa fa-cubes" style="color: white; font-size: 20px;"></i>
              </div>
              <div>
                <h3 class="fw-bold mb-0" style="color: #333;">Gestión de Materias Primas</h3>
                <nav aria-label="breadcrumb" class="mt-1">
                  <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #dc3545;"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: #333;">Materias Primas</li>
                  </ol>
                </nav>
              </div>
            </div>
            <button
              class="btn btn-round shadow-sm"
              data-bs-toggle="modal"
              data-bs-target="#materiaPrimaModal"
              style="background: #dc3545; border: none; padding: 10px 20px; color: white;"
            >
              <i class="fa fa-plus me-2"></i>
              Nueva Materia Prima
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
                    <i class="fa fa-list me-2"></i>Registros de Materias Primas
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
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Nombre</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Descripción</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Stock</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Proveedor</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                          <?php 
                if(isset($materiaPrima) && is_array($materiaPrima) && !empty($materiaPrima)){
                foreach ($materiaPrima as $mp): 
            ?>
                          <tr style="transition: all 0.2s;">
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                              <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                MP-00<?php echo $mp['id_materia_prima']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <i class="fa fa-cube me-1" style="color: #dc3545;"></i><?php echo $mp['nombre_materia_prima']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666;">
                              <?php echo $mp['descripcion_materia_prima']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <?php
                                $stock = $mp['stock_actual'];
                                if ($stock < 10) {
                                    $bgColor = '#dc3545';
                                    $textColor = '#ffffff';
                                    $estado = 'Stock Bajo';
                                } elseif ($stock <= 20) {
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
                                <i class="fa fa-boxes me-1"></i><?php echo $stock . " " . $mp['nombre_medida']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666;">
                              <i class="fa fa-truck me-1" style="color: #28a745;"></i><?php echo $mp['tipo_id'] . $mp['id_proveedor'] . ' - ' . $mp['nombre_proveedor']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <div class="btn-group" role="group">
                                <a
                                onclick="ObtenerMateriaPrima(<?php echo $mp['id_materia_prima']; ?>)"
                                data-bs-toggle="modal"
                                data-bs-target="#materiaPrimaModalModificar"      
                                type="button"
                                class="btn btn-sm"
                                title='Modificar'
                                style="background: #17a2b8; color: white; border-radius: 6px 0 0 6px; border: none;"
                                >
                                  <i class="fa fa-edit"></i>
                                </a>
                                <a href="#"
                                  onclick="return EliminarMateriaPrima(event, <?php echo $mp['id_materia_prima']; ?>);"
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
            echo "<tr><td colspan='6' class='text-center py-4'><div class='alert alert-info'><i class='fa fa-info-circle me-2'></i>No hay materias primas registradas.</div></td></tr>";
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
<div class="modal fade" id="materiaPrimaModal" tabindex="-1" aria-labelledby="materiaPrimaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formMateriaPrima" enctype="multipart/form-data" onsubmit="return validar_formulario()" method="post" action="index.php?url=materias_primas&action=agregar">
        <div class="modal-header" style="background: #dc3545; border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="materiaPrimaModalLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-plus-circle me-2"></i>Nueva Materia Prima
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="nombreMateriaPrima" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-cube me-2" style="color: #dc3545;"></i>Nombre *</label>
              <input type="text" class="form-control" id="nombreMateriaPrima" name="nombreMateriaPrima" placeholder="Ingrese el nombre" style="border-radius: 8px;" oninput="validar_nombre()" required>
              <span id="errorMateriaPrima" class="error-messege text-dredr small"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label for="descripcionMateriaPrima" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-align-left me-2" style="color: #dc3545;"></i>Descripción *</label>
              <input type="text" class="form-control" id="descripcionMateriaPrima" name="descripcionMateriaPrima" placeholder="Ingrese la descripción" style="border-radius: 8px;" oninput="validar_descripcion()" required>
              <span id="errorDescripcion" class="error-messege text-dredr small"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="stockMateriaPrima" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-boxes me-2" style="color: #dc3545;"></i>Stock *</label>
              <input type="text" class="form-control" id="stockMateriaPrima" name="stockMateriaPrima" placeholder="Ingrese el stock" style="border-radius: 8px;" oninput="validar_stock()" required>
              <span id="errorStock" class="error-messege text-dredr small"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label for="unidadMedida" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-ruler me-2" style="color: #dc3545;"></i>Unidad de Medida *</label>
              <select name="unidadMedida" id="unidadMedida" class="form-select" style="border-radius: 8px;" oninput="validar_unidad_medida()" required>
                <option value="">Seleccione una unidad</option>
                <?php foreach ($unidades_medida as $unidad): ?>
                <option value="<?php echo $unidad['id_unidad_medida'] ?>"><?php echo $unidad['nombre_medida'] ?></option>
                <?php endforeach; ?>
              </select>
              <span id="errorMedida" class="error-messege text-dredr small"></span>
            </div>
          </div>

          <div class="mb-3">
            <label for="proveedorMateriaPrima" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-truck me-2" style="color: #dc3545;"></i>Proveedor *</label>
            <select name="proveedorMateriaPrima" id="proveedorMateriaPrima" class="form-select" style="border-radius: 8px;" oninput="validar_proveedor()" required>
              <option value="">Seleccione un proveedor</option>
              <?php foreach ($proveedores as $proveedor): ?>
              <option value="<?php echo $proveedor['id_proveedor'] ?>"><?php echo $proveedor['tipo_id'] . $proveedor['id_proveedor'] . ' - ' . $proveedor['nombre_proveedor'] ?></option>
              <?php endforeach; ?>
            </select>
            <span id="errorProveedor" class="error-messege text-dredr small"></span>
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
            <i class="fa fa-save me-2"></i>Guardar Materia Prima
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Modificar -->
<div class="modal fade" id="materiaPrimaModalModificar" tabindex="-1" aria-labelledby="materiaPrimaModalModificarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formMateriaPrimaModificar" enctype="multipart/form-data" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=materias_primas&action=modificar">
        <div class="modal-header" style="background: #dc3545; border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="materiaPrimaModalModificarLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-edit me-2"></i>Modificar Materia Prima
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <input type="hidden" class="form-control" id="idEdit" name="idEdit" required>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="nombreMateriaPrimaEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-cube me-2" style="color: #dc3545;"></i>Nombre *</label>
              <input type="text" class="form-control" id="nombreMateriaPrimaEdit" name="nombreMateriaPrimaEdit" placeholder="Ingrese el nombre" style="border-radius: 8px;" oninput="validar_nombre_modificado()" required>
              <span id="errorMateriaPrimaEdit" class="error-messege text-dredr small"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label for="descripcionMateriaPrimaEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-align-left me-2" style="color: #dc3545;"></i>Descripción *</label>
              <input type="text" class="form-control" id="descripcionMateriaPrimaEdit" name="descripcionMateriaPrimaEdit" placeholder="Ingrese la descripción" style="border-radius: 8px;" oninput="validar_descripcion_modificado()" required>
              <span id="errorDescripcionEdit" class="error-messege text-dredr small"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="stockMateriaPrimaEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-boxes me-2" style="color: #dc3545;"></i>Stock *</label>
              <input type="text" class="form-control" id="stockMateriaPrimaEdit" name="stockMateriaPrimaEdit" placeholder="Ingrese el stock" style="border-radius: 8px;" oninput="validar_stock_modificado()" required>
              <span id="errorStockEdit" class="error-messege text-dredr small"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label for="unidadMedidaEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-ruler me-2" style="color: #dc3545;"></i>Unidad de Medida *</label>
              <select name="unidadMedidaEdit" id="unidadMedidaEdit" class="form-select" style="border-radius: 8px;" oninput="validar_unidad_medida_modificado()" required>
                <option value="">Seleccione una unidad</option>
                <?php foreach ($medida as $unidad): ?>
                <option value="<?php echo $unidad['id_unidad_medida'] ?>"><?php echo $unidad['nombre_medida'] ?></option>
                <?php endforeach; ?>
              </select>
              <span id="errorMedidaEdit" class="error-messege text-dredr small"></span>
            </div>
          </div>

          <div class="mb-3">
            <label for="proveedorMateriaPrimaEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-truck me-2" style="color: #dc3545;"></i>Proveedor *</label>
            <select name="proveedorMateriaPrimaEdit" id="proveedorMateriaPrimaEdit" class="form-select" style="border-radius: 8px;" oninput="validar_proveedor_modificado()" required>
              <option value="">Seleccione un proveedor</option>
              <?php foreach ($prov as $proveedor): ?>
              <option value="<?php echo $proveedor['id_proveedor'] ?>"><?php echo $proveedor['tipo_id'] . $proveedor['id_proveedor'] . ' - ' . $proveedor['nombre_proveedor'] ?></option>
              <?php endforeach; ?>
            </select>
            <span id="errorProveedorEdit" class="error-messege text-dredr small"></span>
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
            <i class="fa fa-edit me-2"></i>Modificar Materia Prima
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="assets/js/validaciones/materiaPrima_validaciones.js"></script>
<script src="assets/js/validaciones/materiaPrima_validaciones_status_stock.js"></script>
<script src="assets/js/ajax/materiaPrima_ajax.js"></script>

  </body>
</html>