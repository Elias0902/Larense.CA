<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title> Categorias</title>
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

    <!-- Espaciado superior para evitar choque con header -->
    <div style="padding-top: 120px;"></div>

    <div class="container-fluid px-4">
      <div class="page-inner">
        
        <!-- Header de página estilizado -->
        <div class="page-header-custom mb-4">
          <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex align-items-center">
              <div class="icon-circle me-3" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                <i class="fa fa-tags" style="color: white; font-size: 20px;"></i>
              </div>
              <div>
                <h3 class="fw-bold mb-0" style="color: #333;">Gestión de Categorías</h3>
                <nav aria-label="breadcrumb" class="mt-1">
                  <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #dc3545;"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: #333;">Categorías</li>
                  </ol>
                </nav>
              </div>
            </div>
            <button
              class="btn btn-danger btn-round shadow-sm"
              data-bs-toggle="modal"
              data-bs-target="#categoriaModal"
              style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 10px 20px;"
            >
              <i class="fa fa-plus me-2"></i>
              Registrar Categoría
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
                    <i class="fa fa-list me-2"></i>Registros de Categorías
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
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                          <?php 
                //verifica si cliente existe o esta vacia en dado caso que este vacia muestra clientes no 
                // registrados ya que si el usuario que realizo la pedticion no tiene el permiso en cambio 
                // si lo tiene muestra la informacion
                if(isset($categorias) && is_array($categorias) && !empty($categorias)){
                foreach ($categorias as $categoria): 
            ?>
                          <tr style="transition: all 0.2s;" data-id="<?php echo $categoria['id_categoria']; ?>">
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                              <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                CAT-00<?php echo $categoria['id_categoria']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <i class="fa fa-tag me-1" style="color: #dc3545;"></i><?php echo $categoria['nombre_categoria']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <div class="btn-group" role="group">
                                <!-- Ver Detalle -->
                                <a
                                  onclick="VerDetalleCategoria(<?php echo $categoria['id_categoria']; ?>)"
                                  data-bs-toggle="modal"
                                  data-bs-target="#categoriaDetalleModal"      
                                  type="button"
                                  class="btn btn-sm"
                                  title='Ver Detalle'
                                  style="background: #6c757d; color: white; border-radius: 6px 0 0 6px; border: none;"
                                >
                                  <i class="fa fa-eye"></i>
                                </a>
                                <a
                                  onclick="ObtenerCategoria(<?php echo $categoria['id_categoria']; ?>)"
                                  data-bs-toggle="modal"
                                  data-bs-target="#categoriaModalModificar"      
                                  type="button"
                                  class="btn btn-sm"
                                  title='Modificar'
                                  style="background: #ffc107; color: #212529; border: none;"
                                >
                                  <i class="fa fa-edit"></i>
                                </a>
                                <a href="#"
                                  onclick="return EliminarCategoria(event,<?php echo $categoria['id_categoria']; ?>)"
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
<div class="modal fade" id="categoriaModal" tabindex="-1" aria-labelledby="categoriaModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formCategoria" onsubmit="return validar_formulario()" method="post" action="index.php?url=categorias&action=agregar">
        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="categoriaModalLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-plus-circle me-2"></i>Nueva Categoría
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <div class="mb-3">
            <label for="nombreCategoria" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-tag me-2" style="color: #dc3545;"></i>Nombre de categoría *</label>
            <input type="text" class="form-control" id="nombreCategoria" name="nombreCategoria" placeholder="Ingrese el nombre de la categoría" style="border-radius: 8px;" oninput="validar_nombre()" required>
            <span id="errorCategoria" class="error-messege text-danger small"></span>
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
            <i class="fa fa-save me-2"></i>Guardar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Modificar -->
<div class="modal fade" id="categoriaModalModificar" tabindex="-1" aria-labelledby="categoriaModalModificarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formCategoriaModificar" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=categorias&action=modificar">
        <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="categoriaModalModificarLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-edit me-2"></i>Modificar Categoría
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <input type="hidden" class="form-control" id="id" name="id" placeholder="" required>
          <div class="mb-3">
            <label for="nombreCategoriaEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-tag me-2" style="color: #dc3545;"></i>Nombre de categoría *</label>
            <input type="text" class="form-control" id="nombreCategoriaEdit" name="nombreCategoria" placeholder="Ingrese el nombre" style="border-radius: 8px;" oninput="validar_nombre_modificado()" required>
            <span id="errorCategoriaEdit" class="error-messege text-danger small"></span>
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
            <i class="fa fa-edit me-2"></i>Modificar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Ver Detalle Categoría -->
<div class="modal fade" id="categoriaDetalleModal" tabindex="-1" aria-labelledby="categoriaDetalleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 20px; overflow: hidden; border: none; box-shadow: 0 20px 60px rgba(0,0,0,0.3);">
      
      <!-- Header -->
      <div class="modal-header" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 25px; position: relative;">
        <div class="d-flex align-items-center w-100">
          <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; background: white; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">
            <i class="fa fa-tags" style="font-size: 30px; color: #dc3545;"></i>
          </div>
          <div class="ms-3" style="color: white;">
            <h4 class="mb-0 fw-bold" id="detalleNombreCategoria">Nombre Categoría</h4>
            <small class="opacity-75" id="detalleIdCategoria">CAT-001</small>
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
                  <i class="fa fa-box text-white" style="font-size: 24px;"></i>
                </div>
                <small class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">Productos Asignados</small>
                <h2 class="mb-0 fw-bold text-dark" id="detalleProductosCategoria">0</h2>
              </div>
            </div>
          </div>
          <div class="col-md-6 mb-3">
            <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
              <div class="card-body text-center p-4">
                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px; background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                  <i class="fa fa-dollar-sign text-white" style="font-size: 24px;"></i>
                </div>
                <small class="text-muted text-uppercase fw-bold d-block mb-2" style="font-size: 0.7rem; letter-spacing: 1px;">Valor en Inventario</small>
                <h3 class="mb-0 fw-bold text-dark" id="detalleValorCategoria">$0.00</h3>
              </div>
            </div>
          </div>
        </div>

        <!-- Descripción -->
        <div class="card border-0 mb-4" style="border-radius: 15px; background: linear-gradient(135deg, #f8d7da 0%, #f5c6cb 100%);">
          <div class="card-body p-4">
            <div class="d-flex align-items-center mb-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; background: #dc3545;">
                <i class="fa fa-info-circle text-white" style="font-size: 20px;"></i>
              </div>
              <h5 class="fw-bold mb-0 text-dark">Información de la Categoría</h5>
            </div>
            <p class="mb-0 text-muted" style="font-size: 0.95rem;">
              Esta categoría agrupa productos similares para facilitar la organización y búsqueda en el catálogo.
            </p>
          </div>
        </div>

        <!-- Características -->
        <div class="row">
          <div class="col-md-12">
            <h6 class="fw-bold mb-3 text-dark text-uppercase" style="font-size: 0.8rem; letter-spacing: 1px;">Características</h6>
            <div class="row">
              <div class="col-md-6 mb-2">
                <div class="d-flex align-items-center p-2" style="background: white; border-radius: 10px;">
                  <i class="fa fa-check-circle me-2" style="color: #28a745;"></i>
                  <span class="text-muted">Organización de productos</span>
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <div class="d-flex align-items-center p-2" style="background: white; border-radius: 10px;">
                  <i class="fa fa-check-circle me-2" style="color: #28a745;"></i>
                  <span class="text-muted">Filtrado en catálogo</span>
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <div class="d-flex align-items-center p-2" style="background: white; border-radius: 10px;">
                  <i class="fa fa-check-circle me-2" style="color: #28a745;"></i>
                  <span class="text-muted">Reportes por categoría</span>
                </div>
              </div>
              <div class="col-md-6 mb-2">
                <div class="d-flex align-items-center p-2" style="background: white; border-radius: 10px;">
                  <i class="fa fa-check-circle me-2" style="color: #28a745;"></i>
                  <span class="text-muted">Estadísticas de ventas</span>
                </div>
              </div>
            </div>
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

<script src="assets/js/validaciones/categorias_validaciones.js"></script>
<script src="assets/js/ajax/categorias_ajax.js"></script>
<script src="assets/js/animacionesJs/dashboard_categorias.js"></script>

  </body>
</html>