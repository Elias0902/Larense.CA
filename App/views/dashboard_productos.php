<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Natys: Productos</title>
    <?php
    require_once 'components/links.php';
    ?>
    <link rel="stylesheet" href="assets/css/validaciones.css" />
  </head>
  <body>
    <?php
    require_once 'components/menu.php';
    require_once 'components/header.php';
    ?>
      <div class="container">
          <div class="page-inner">
            <div class="page-header">
              <h3 class="fw-bold mb-3">Productos</h3>
              <ul class="breadcrumbs mb-3">
                <li class="nav-home">
                  <a href="ndex.php?url=dashboard">
                    <i class="icon-home"></i>
                  </a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="index.php?url=dashboard">Dashboard</a>
                </li>
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="index.php?url=productos">Productos</a>
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center justify-content-between">
                      <h4 class="card-title">Registros</h4>
                      <button
                        class="btn btn-outline-success btn-round ms-auto"
                        data-bs-toggle="modal"
                        data-bs-target="#productoModal"
                      >
                        <i class="fa fa-plus"></i>
                        Agregar
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table
                        id="add-row"
                        class="display table table-striped table-hover"
                      >
                        <thead>
                          <tr>
                              <th>#</th>
                            <th>Img</th>
                            <th>Nombre</th>
                            <th>Categoria</th>
                            <th>Precio</th>
                            <th>Stock</th>
                            <th>F. Registro</th>
                            <th>F. Vecimiento</th>
                            <th style="width: 10%">Accion</th>
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
                          <tr>
                            <td>COD-00<?php echo $producto['id_producto']; ?></td>
                            <td><img src="<?php echo $producto['img']; ?>" width="60" height="60"></td>
                            <td><?php echo $producto['nombre_producto']; ?></td>
                            <td><?php echo $producto['nombre_categoria']; ?></td>
                            <td><?php echo $producto['precio_venta']; ?>$</td>
                            <td id='stock'><?php echo $producto['stock']; ?> Cajas</td>
                            <td><?php echo $producto['fecha_registro']; ?></td>
                            <td><?php echo $producto['fecha_vencimiento']; ?></td>
                            <td>
                              <div class="form-button-action">
                                <a
                                onclick="ObtenerProducto(<?php echo $producto['id_producto']; ?>)"
                                data-bs-toggle="modal"
                                data-bs-target="#productoModalModificar"      
                                type="button"
                                class="btn btn-link btn-primary btn-lg"
                                title='Modificar'
                                >
                                  <i class="fa fa-edit"></i>
                                </a>
                                <a href="#"
                                  onclick="return EliminarProducto(event, <?php echo $producto['id_producto']; ?>);"
                                  type="button"
                                  data-bs-toggle="tooltip"
                                  class="btn btn-link btn-danger"
                                  title='Eliminar'
                                >
                                  <i class="fa fa-times"></i>
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
<?php
require_once 'components/footer.php';
require_once 'components/scripts.php';
?>


<!-- Modal -->
<div class="modal fade" id="productoModal" tabindex="-1" aria-labelledby="productoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formProducto" enctype="multipart/form-data" onsubmit="return validar_formulario()" method="post" action="index.php?url=productos&action=agregar">
        <div class="modal-header">
          <h5 class="modal-title" id="categoriaModalLabel">Agregar Nuevo Producto</h5>
          <button type="button" class="fa fa-close btn btn-outline-dark btn-round ms-auto" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
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
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button type="button" class="btn btn-outline-danger btn-round" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-outline-success btn-round">Guardar</button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Modificar -->
<div class="modal fade" id="productoModalModificar" tabindex="-1" aria-labelledby="productoModalModificarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formProductoModificar" enctype="multipart/form-data" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=productos&action=modificar">
        <div class="modal-header">
          <h5 class="modal-title" id="productoModalModificarLabel">Modificar Producto</h5>
          <button type="button" class="fa fa-close btn btn-outline-dark btn-round ms-auto" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
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
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button type="button" class="btn btn-outline-danger btn-round" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-outline-warning btn-round">Modificar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="assets/js/validaciones/productos_validaciones.js"></script>
<script src="assets/js/validaciones/productos_validaciones_status_stock.js"></script>
<script src="assets/js/ajax/productos_ajax.js"></script>

  </body>
</html>