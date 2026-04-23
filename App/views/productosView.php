<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> Productos</title>
    <?php
    require_once 'components/links.php';
    ?>
    <link rel="stylesheet" href="assets/css/validaciones.css" />
    <link rel="stylesheet" href="assets/css/stylesModules/productos.css" />
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
                <i class="fa fa-box-open" style="color: white; font-size: 20px;"></i>
              </div>
              <div>
                <h3 class="fw-bold mb-0" style="color: #333;">Gestión de Productos</h3>
                <nav aria-label="breadcrumb" class="mt-1">
                  <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #dc3545;"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: #333;">Productos</li>
                  </ol>
                </nav>
              </div>
            </div>
            <button
              class="btn btn-danger btn-round shadow-sm"
              data-bs-toggle="modal"
              data-bs-target="#productoModal"
              style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 10px 20px;"
            >
              <i class="fa fa-plus me-2"></i>
              Registrar Producto
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
                    <i class="fa fa-list me-2"></i>Catálogo de Productos
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
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545; text-align: center;">Imagen</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Nombre</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Categoría</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Precio</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Stock</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">F. Registro</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">F. Venc.</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                          <?php 
                //verifica si cliente existe o esta vacia en dado caso que este vacia muestra clientes no 
                // registrados ya que si el usuario que realizo la pedticion no tiene el permiso en cambio 
                // si lo tiene muestra la informacion
                if(isset($productos) && is_array($productos) && !empty($productos)){
                foreach ($productos as $producto): 
            ?>
                          <tr style="transition: all 0.2s;" data-id="<?php echo $producto['id_producto']; ?>">
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                              <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                COD-00<?php echo $producto['id_producto']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <img src="<?php echo $producto['img']; ?>" width="60" height="60" style="border-radius: 8px; border: 2px solid #dc3545; object-fit: cover;">
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <i class="fa fa-box me-1" style="color: #dc3545;"></i><?php echo $producto['nombre_producto']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge" style="background: #6c757d; color: white; padding: 6px 12px; border-radius: 20px;">
                                <i class="fa fa-tag me-1"></i><?php echo $producto['nombre_categoria']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge" style="background: #28a745; color: white; padding: 6px 12px; border-radius: 20px;">
                                $<?php echo number_format($producto['precio_venta'], 2); ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <span class="badge" style="background: #17a2b8; color: white; padding: 6px 12px; border-radius: 20px;" id='stock'>
                                <i class="fa fa-cubes me-1"></i><?php echo $producto['stock']; ?> Cajas
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <i class="fa fa-calendar me-1" style="color: #dc3545;"></i><?php echo $producto['fecha_registro']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <i class="fa fa-calendar-times me-1" style="color: #dc3545;"></i><?php echo $producto['fecha_vencimiento']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <div class="btn-group" role="group">
                                <!-- Ver Detalle -->
                                <a
                                  onclick="VerDetalleProducto(<?php echo $producto['id_producto']; ?>)"
                                  data-bs-toggle="modal"
                                  data-bs-target="#productoDetalleModal"      
                                  type="button"
                                  class="btn btn-sm"
                                  title='Ver Detalle'
                                  style="background: #6c757d; color: white; border-radius: 6px 0 0 6px; border: none;"
                                >
                                  <i class="fa fa-eye"></i>
                                </a>
                                <a
                                  onclick="ObtenerProducto(<?php echo $producto['id_producto']; ?>)"
                                  data-bs-toggle="modal"
                                  data-bs-target="#productoModalModificar"      
                                  type="button"
                                  class="btn btn-sm"
                                  title='Modificar'
                                  style="background: #ffc107; color: #212529; border: none;"
                                >
                                  <i class="fa fa-edit"></i>
                                </a>
                                <a href="#"
                                  onclick="return EliminarProducto(event, <?php echo $producto['id_producto']; ?>);"
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
            //Imprime esta informacion en caso de estar vacia la variable             
            endforeach; 
        } else {
            echo "<tr><td colspan='6'>No hay registros.</td></tr>";
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


<!-- Modal -->
<div class="modal fade" id="productoModal" tabindex="-1" aria-labelledby="productoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formProducto" enctype="multipart/form-data" onsubmit="return validar_formulario()" method="post" action="index.php?url=productos&action=agregar">
        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="productoModalLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-plus-circle me-2"></i>Nuevo Producto
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
              <label for="nombreCategoria" class="form-label"><b>Nombre de Producto</b></label>
              <input type="text" class="form-control" id="nombreProducto" name="nombreProducto" placeholder="Ingrese el nombre" oninput="validar_nombre()" required>
              <span id="errorProducto" class="error-messege"></span>
              <br>
              
              <label for="nombreCategoria" class="form-label"><b>Categoria</b></label>
               <select name="nombreCategoria" id="nombreCategoria" class="form-control" oninput="validar_categoria()" required>
                <option value="">Seleccione una categoria</option>
                <?php foreach ($categorias as $categorias): ?>
                <option value="<?php echo $categorias['id_categoria'] ?>"><?php echo $categorias['nombre_categoria'] ?></option>
                <?php endforeach; ?>
               </select>
              <span id="errorCategoria" class="error-messege"></span>
              <br>

              <label for="nombreCategoria" class="form-label"><b>Precio</b></label>
              <input type="text" class="form-control" id="precioProducto" name="precioProducto" placeholder="Ingrese el precio" oninput="validar_precio()" required>
              <span id="errorPrecio" class="error-messege"></span>
              <br>
              
              <label for="nombreCategoria" class="form-label"><b>Stock</b></label>
              <input type="text" class="form-control" id="stockProducto" name="stockProducto" placeholder="Ingrese el stock" oninput="validar_stock()" required>
              <span id="errorStock" class="error-messege"></span>
              <br>
              
              <label for="nombreCategoria" class="form-label"><b>Fecha de Registro</b></label>
              <input type="date" class="form-control" id="fechaRegistroProducto" name="fechaRegistroProducto" placeholder="Ingrese la fecha de registro" oninput="validar_fecha()" required>
              <span id="errorFechaRegistro" class="error-messege"></span>
              <br>
              
              <label for="nombreCategoria" class="form-label"><b>Fecha de Vencimiento</b></label>
              <input type="date" class="form-control" id="fechaVencimientoProducto" name="fechaVencimientoProducto" placeholder="Ingrese la fecha de vencimiento" oninput="validar_fecha_vencimiento()" required>
              <span id="errorFechaVencimiento" class="error-messege"></span>
              <br>
              
              <label for="nombreCategoria" class="form-label"><b>Imagen</b></label>
              <input type="file" multiple class="form-control" id="imagenProducto" name="imagenProducto" placeholder="Ingrese la URL de la imagen" oninput="validar_imagen()" required>
              <span id="errorImagen" class="error-messege"></span>
              <br>
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
            <i class="fa fa-save me-2"></i>Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Modificar -->
<div class="modal fade" id="productoModalModificar" tabindex="-1" aria-labelledby="productoModalModificarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formProductoModificar" enctype="multipart/form-data" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=productos&action=modificar">
        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="productoModalModificarLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-edit me-2"></i>Modificar Producto
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <!-- ID oculto -->
          <input type="hidden" class="form-control" id="idEdit" name="idEdit" required>
          
          <!-- Nombre Producto -->
          <label for="nombreProductoEdit" class="form-label"><b>Nombre de Producto</b></label>
          <input type="text" class="form-control" id="nombreProductoEdit" name="nombreProductoEdit" placeholder="Ingrese el nombre" oninput="validar_nombre_modificado()" required>
          <span id="errorProductoEdit" class="error-messege"></span>
          <br>
          
          <!-- Categoría -->
          <label for="nombreCategoriaEdit" class="form-label"><b>Categoría</b></label>
          <select name="nombreCategoriaEdit" id="nombreCategoriaEdit" class="form-control" oninput="validar_categoria_modificado()" required>
            <option value="">Seleccione una categoría</option>
            <?php foreach ($cat as $cat): ?>
            <option value="<?php echo $cat['id_categoria']; ?>"><?php echo $cat['nombre_categoria']; ?></option>
            <?php endforeach; ?>
          </select>
          <span id="errorCategoriaEdit" class="error-messege"></span>
          <br>

          <!-- Precio -->
          <label for="precioProductoEdit" class="form-label"><b>Precio</b></label>
          <input type="text" class="form-control" id="precioProductoEdit" name="precioProductoEdit" placeholder="Ingrese el precio" oninput="validar_precio_modificado()" required>
          <span id="errorPrecioEdit" class="error-messege"></span>
          <br>
          
          <!-- Stock -->
          <label for="stockProductoEdit" class="form-label"><b>Stock</b></label>
          <input type="text" class="form-control" id="stockProductoEdit" name="stockProductoEdit" placeholder="Ingrese el stock" oninput="validar_stock_modificado()" required>
          <span id="errorStockEdit" class="error-messege"></span>
          <br>
          
          <!-- Fecha Registro -->
          <label for="fechaRegistroProductoEdit" class="form-label"><b>Fecha de Registro</b></label>
          <input type="date" class="form-control" id="fechaRegistroProductoEdit" name="fechaRegistroProductoEdit" placeholder="Ingrese la fecha de registro" oninput="validar_fecha_modificado()" required>
          <span id="errorFechaRegistroEdit" class="error-messege"></span>
          <br>
          
          <!-- Fecha Vencimiento -->
          <label for="fechaVencimientoProductoEdit" class="form-label"><b>Fecha de Vencimiento</b></label>
          <input type="date" class="form-control" id="fechaVencimientoProductoEdit" name="fechaVencimientoProductoEdit" placeholder="Ingrese la fecha de vencimiento" oninput="validar_fecha_vencimiento_modificado()" required>
          <span id="errorFechaVencimientoEdit" class="error-messege"></span>
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
            <i class="fa fa-edit me-2"></i>Modificar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Ver Detalle Producto -->
<div class="modal fade" id="productoDetalleModal" tabindex="-1" aria-labelledby="productoDetalleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
      
      <!-- Header -->
      <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 25px; position: relative;">
        <div class="d-flex align-items-center w-100">
          <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.2); overflow: hidden;">
            <img id="detalleImgProducto" src="" alt="Producto" style="width: 100%; height: 100%; object-fit: cover;">
          </div>
          <div class="ms-3" style="color: white;">
            <h4 class="mb-0 fw-bold" id="detalleNombreProducto">Nombre Producto</h4>
            <small class="opacity-75" id="detalleIdProducto">COD-001</small>
          </div>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar" style="position: absolute; top: 20px; right: 20px;"></button>
      </div>

      <!-- Body -->
      <div class="modal-body p-4" style="background: #f8f9fa;">
        
        <!-- Info Principal -->
        <div class="row mb-4">
          <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
              <div class="card-body text-center p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                  <i class="fa fa-dollar-sign text-white" style="font-size: 24px;"></i>
                </div>
                <small class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">Precio</small>
                <h3 class="mb-0 fw-bold text-dark" id="detallePrecioProducto">$0.00</h3>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
              <div class="card-body text-center p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #17a2b8 0%, #0c7c8a 100%);">
                  <i class="fa fa-cubes text-white" style="font-size: 24px;"></i>
                </div>
                <small class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">Stock</small>
                <h3 class="mb-0 fw-bold text-dark" id="detalleStockProducto">0 Cajas</h3>
              </div>
            </div>
          </div>
          <div class="col-md-4 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
              <div class="card-body text-center p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #ffc107 0%, #ff9800 100%);">
                  <i class="fa fa-tag text-white" style="font-size: 24px;"></i>
                </div>
                <small class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">Categoría</small>
                <h5 class="mb-0 fw-bold text-dark" id="detalleCategoriaProducto">Categoría</h5>
              </div>
            </div>
          </div>
        </div>

        <!-- Fechas -->
        <div class="card border-0 mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);">
          <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; background: #dc3545;">
                <i class="fa fa-calendar-alt text-white" style="font-size: 20px;"></i>
              </div>
              <h5 class="fw-bold mb-0 text-dark">Fechas Importantes</h5>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="d-flex align-items-center mb-2">
                  <i class="fa fa-calendar-check me-2" style="color: #28a745;"></i>
                  <span class="text-muted">Registro: <strong id="detalleFechaRegistro">01/01/2024</strong></span>
                </div>
              </div>
              <div class="col-md-6">
                <div class="d-flex align-items-center mb-2">
                  <i class="fa fa-calendar-times me-2" style="color: #dc3545;"></i>
                  <span class="text-muted">Vencimiento: <strong id="detalleFechaVencimiento">01/12/2024</strong></span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Estado del stock -->
        <div class="row mb-4">
          <div class="col-md-12">
            <h6 class="fw-bold mb-3 text-dark text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Disponibilidad</h6>
            <div class="progress" style="height: 30px; border-radius: 15px; background: #e9ecef;">
              <div id="detalleStockBar" class="progress-bar" role="progressbar" style="width: 75%; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 15px;">
                Stock Disponible
              </div>
            </div>
            <small class="text-muted mt-2 d-block">El stock se actualiza automáticamente con cada venta</small>
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

<script>
// Función placeholder para VerDetalleProducto
function VerDetalleProducto(id) {
    console.log('Ver detalle del producto:', id);
}
</script>

<script src="assets/js/validaciones/productos_validaciones.js"></script>
<script src="assets/js/validaciones/productos_validaciones_status_stock.js"></script>
<script src="assets/js/ajax/productos_ajax.js"></script>
<script src="assets/js/animacionesJs/dashboard_productos.js"></script>

  </body>
</html>