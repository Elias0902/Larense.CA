<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Proveedores</title>
    <?php
    require_once 'components/links.php';
    ?>
    <link rel="stylesheet" href="assets/css/validaciones.css" />
    <link rel="stylesheet" href="assets/css/stylesModules/proveedores.css" />
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
                <i class="fa fa-truck" style="color: white; font-size: 20px;"></i>
              </div>
              <div>
                <h3 class="fw-bold mb-0" style="color: #333;">Gestión de Proveedores</h3>
                <nav aria-label="breadcrumb" class="mt-1">
                  <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #dc3545;"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: #333;">Proveedores</li>
                  </ol>
                </nav>
              </div>
            </div>
            <button
              class="btn btn-success btn-round shadow-sm"
              data-bs-toggle="modal"
              data-bs-target="#proveedorModal"
              style="background: #dc3545; border: none; padding: 10px 20px;"
            >
              <i class="fa fa-plus me-2"></i>
              Registrar Proveedor
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
                    <i class="fa fa-list me-2"></i>Registros de Proveedores
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
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">RIF</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Nombre</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Dirección</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Teléfono</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Email</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                          <?php 
                //verifica si proveedor existe o esta vacia
                if(isset($proveedores) && is_array($proveedores) && !empty($proveedores)){
                foreach ($proveedores as $proveedor): 
            ?>
                          <tr style="transition: all 0.2s;">
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                              <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                <?php echo $proveedor['tipo_id'].$proveedor['id_proveedor']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <i class="fa fa-building me-1" style="color: #dc3545;"></i><?php echo $proveedor['nombre_proveedor']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666;">
                              <i class="fa fa-map-marker me-1" style="color: #dc3545;"></i><?php echo $proveedor['direccion_proveedor']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666;">
                              <i class="fa fa-phone me-1" style="color: #dc3545;"></i><?php echo $proveedor['tlf_proveedor']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; color: #666;">
                              <i class="fa fa-envelope me-1" style="color: #dc3545;"></i><?php echo $proveedor['email_proveedor']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <div class="btn-group" role="group">
                                <a
                                onclick="ObtenerProveedor(<?php echo $proveedor['id_proveedor']; ?>)"
                                data-bs-toggle="modal"
                                data-bs-target="#proveedorModalModificar"      
                                type="button"
                                class="btn btn-sm"
                                title='Modificar'
                                style="background: #17a2b8; color: white; border-radius: 6px 0 0 6px; border: none;"
                                >
                                  <i class="fa fa-edit"></i>
                                </a>
                                <a href="#"
                                 onclick="return EliminarProveedor(event,<?php echo $proveedor['id_proveedor']; ?>)"
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
            echo "<tr><td colspan='6' class='text-center py-4'><div class='alert alert-info'><i class='fa fa-info-circle me-2'></i>No hay proveedores registrados.</div></td></tr>";
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
<div class="modal fade" id="proveedorModal" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formProveedor" onsubmit="return validar_formulario()" method="post" action="index.php?url=proveedores&action=agregar">
        <div class="modal-header" style="background: #dc3545; border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="proveedorModalLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-plus-circle me-2"></i>Nuevo Proveedor
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="id_proveedor" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-id-card me-2" style="color: #dc3545;"></i>RIF del Proveedor *</label>
              <div class="d-flex align-items-center gap-2">
                <select name="tipo_id" id="tipo_id" class="form-select" style="max-width: 80px; border-radius: 8px;" oninput="validar_tipo_id()" required>
                    <option value="J-">J-</option>
                    <option value="G-">G-</option>
                    <option value="C-">C-</option>
                </select>
                <input type="text" class="form-control" id="id_proveedor" name="id_proveedor" placeholder="Número de RIF" style="border-radius: 8px;" oninput="validar_id_proveedor()" required>
              </div>
              <span id='errorIdProveedor' class="error-messege text-danger small"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label for="nombreProveedor" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-building me-2" style="color: #dc3545;"></i>Nombre del Proveedor *</label>
              <input type="text" class="form-control" id="nombreProveedor" name="nombreProveedor" placeholder="Ingrese el nombre" style="border-radius: 8px;" oninput="validar_nombre()" required>
              <span id="errornombreProveedor" class="error-messege text-danger small"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="tlfProveedor" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-phone me-2" style="color: #dc3545;"></i>Teléfono *</label>
              <input type="text" class="form-control" id="tlfProveedor" name="tlfProveedor" placeholder="Ingrese el teléfono" style="border-radius: 8px;" oninput="validar_telefono()" required>
              <span id="errorTlfProveedor" class="error-messege text-danger small"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label for="emailProveedor" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-envelope me-2" style="color: #dc3545;"></i>Email *</label>
              <input type="email" class="form-control" id="emailProveedor" name="emailProveedor" placeholder="ejemplo@correo.com" style="border-radius: 8px;" oninput="validar_email()" required>
              <span id="errorEmailProveedor" class="error-messege text-danger small"></span>
            </div>
          </div>

          <div class="mb-3">
            <label for="direccionProveedor" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-map-marker me-2" style="color: #dc3545;"></i>Dirección *</label>
            <input type="text" class="form-control" id="direccionProveedor" name="direccionProveedor" placeholder="Ingrese la dirección completa" style="border-radius: 8px;" oninput="validar_direccion()" required>
            <span id="errorDireccionProveedor" class="error-messege text-danger small"></span>
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
            <i class="fa fa-save me-2"></i>Guardar Proveedor
          </button>
        </div>
      </form>
    </div>
  </div>
</div>


<!-- Modal Modificar -->
<div class="modal fade" id="proveedorModalModificar" tabindex="-1" aria-labelledby="proveedorModalModificarLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" style="border-radius: 12px; overflow: hidden; border: none;">
      <form id="formProveedor" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=proveedores&action=modificar">
        <div class="modal-header" style="background: #dc3545; border: none; padding: 20px 25px;">
          <h5 class="modal-title" id="proveedorModalModificarLabel" style="color: white; font-weight: 600;">
            <i class="fa fa-edit me-2"></i>Modificar Proveedor
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body" style="padding: 25px; background: #f8f9fa;">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="id_proveedor" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-id-card me-2" style="color: #dc3545;"></i>RIF del Proveedor</label>
              <div class="d-flex align-items-center gap-2">
                <select name="tipo_idEdit" id="tipo_idEdit" class="form-select" style="max-width: 80px; border-radius: 8px;" required>
                    <option value="J-">J-</option>
                    <option value="G-">G-</option>
                    <option value="C-">C-</option>
                </select>
                <input type="text" class="form-control" id="id_proveedorEdit" name="id_proveedorEdit" placeholder="Número de RIF" style="border-radius: 8px; background: #e9ecef;" readonly>
              </div>
              <small class="text-muted">El RIF no puede modificarse</small>
            </div>

            <div class="col-md-6 mb-3">
              <label for="nombreProveedorEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-building me-2" style="color: #dc3545;"></i>Nombre del Proveedor *</label>
              <input type="text" class="form-control" id="nombreProveedorEdit" name="nombreProveedorEdit" placeholder="Ingrese el nombre" style="border-radius: 8px;" oninput="validar_nombre_modificado()" required>
              <span id="errorProveedorEdit" class="error-messege text-danger small"></span>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="tlfProveedorEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-phone me-2" style="color: #dc3545;"></i>Teléfono *</label>
              <input type="text" class="form-control" id="tlfProveedorEdit" name="tlfProveedorEdit" placeholder="Ingrese el teléfono" style="border-radius: 8px;" oninput="validar_telefono_modificado()" required>
              <span id="errorTlfProveedorEdit" class="error-messege text-danger small"></span>
            </div>

            <div class="col-md-6 mb-3">
              <label for="emailProveedorEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-envelope me-2" style="color: #dc3545;"></i>Email *</label>
              <input type="email" class="form-control" id="emailProveedorEdit" name="emailProveedorEdit" placeholder="ejemplo@correo.com" style="border-radius: 8px;" oninput="validar_email_modificado()" required>
              <span id="errorEmailProveedorEdit" class="error-messege text-danger small"></span>
            </div>
          </div>

          <div class="mb-3">
            <label for="direccionProveedorEdit" class="form-label" style="color: #333; font-weight: 500;"><i class="fa fa-map-marker me-2" style="color: #dc3545;"></i>Dirección *</label>
            <input type="text" class="form-control" id="direccionProveedorEdit" name="direccionProveedorEdit" placeholder="Ingrese la dirección completa" style="border-radius: 8px;" oninput="validar_direccion_modificada()" required>
            <span id="errorDireccionProveedorEdit" class="error-messege text-danger small"></span>
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
            <i class="fa fa-edit me-2"></i>Modificar Proveedor
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="assets/js/validaciones/proveedores_validaciones.js"></script>
<script src="assets/js/ajax/proveedores_ajax.js"></script>
<script src="asset/js/animacionesJs/dashboard_proveedores.js"></script>

  </body>
</html>