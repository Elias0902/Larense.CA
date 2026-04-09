<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Natys: Proveedores</title>
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
              <h3 class="fw-bold mb-3">Proveedores</h3>
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
                  <a href="index.php?url=proveedores">Proveedores</a>
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
                        data-bs-target="#proveedorModal"
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
                            <th>RIF</th>
                            <th>Nombre</th>
                            <th>Direccion</th>
                            <th>Tlf</th>
                            <th>Email</th>
                            <th style="width: 10%">Accion</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                //verifica si cliente existe o esta vacia en dado caso que este vacia muestra clientes no 
                // registrados ya que si el usuario que realizo la pedticion no tiene el permiso en cambio 
                // si lo tiene muestra la informacion
                if(isset($proveedores) && is_array($proveedores) && !empty($proveedores)){
                foreach ($proveedores as $proveedor): 
            ?>
                          <tr>
                            <td><?php echo $proveedor['tipo_id'].$proveedor['id_proveedor']; ?></td>
                            <td><?php echo $proveedor['nombre_proveedor']; ?></td>
                            <td><?php echo $proveedor['direccion_proveedor']; ?></td>
                            <td><?php echo $proveedor['tlf_proveedor']; ?></td>
                            <td><?php echo $proveedor['email_proveedor']; ?></td>
                            <td>
                              <div class="form-button-action">
                                <a
                                onclick="ObtenerProveedor(<?php echo $proveedor['id_proveedor']; ?>)"
                                data-bs-toggle="modal"
                                data-bs-target="#proveedorModalModificar"      
                                type="button"
                                class="btn btn-link btn-primary btn-lg"
                                title='Modificar'
                                >
                                  <i class="fa fa-edit"></i>
                                </a>
                                <a href="#"
                                 onclick="return EliminarProveedor(event,<?php echo $proveedor['id_proveedor']; ?>)"
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
<div class="modal fade" id="proveedorModal" tabindex="-1" aria-labelledby="proveedorModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formProveedor" onsubmit="return validar_formulario()" method="post" action="index.php?url=proveedores&action=agregar">
        <div class="modal-header">
          <h5 class="modal-title" id="proveedorModalLabel">Agregar Nuevo Proveedor</h5>
          <button type="button" class="fa fa-close btn btn-outline-dark btn-round ms-auto" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <label for="id_proveedor"><b>Rif de proveedor</b></label>
            <div class="d-flex align-items-center">
            <select name="tipo_id" id="tipo_id" class="form-control w-25 mr-2" oninput="validar_tipo_id()" required>
                <option value="J-">J-</option>
                <option value="G-">G-</option>
                <option value="C-">C-</option>
            </select>
            <span id='errorTipoId' class="error-messege"></span>
            <input type="text" class="form-control" id="id_proveedor" name="id_proveedor" oninput="validar_id_proveedor()" required>
            </div>
            <span id='errorIdProveedor' class="error-messege"></span>
            <br>

            <label for="nombreProveedor" class="form-label"><b>Nombre de proveedor</b></label>
            <input type="text" class="form-control" id="nombreProveedor" name="nombreProveedor" placeholder="Ingrese el nombre" oninput="validar_nombre()" required>
            <span id="errornombreProveedor" class="error-messege"></span>
            <br>

            <label for="direccionProveedor" class="form-label"><b>Direccion de proveedor</b></label>
            <input type="text" class="form-control" id="direccionProveedor" name="direccionProveedor" placeholder="Ingrese la direccion" oninput="validar_direccion()" required>
            <span id="errorDireccionProveedor" class="error-messege"></span>
            <br>

            <label for="tlfProveedor" class="form-label"><b>Telefono de proveedor</b></label>
            <input type="text" class="form-control" id="tlfProveedor" name="tlfProveedor" placeholder="Ingrese el telefono" oninput="validar_telefono()" required>
            <span id="errorTlfProveedor" class="error-messege"></span>
            <br>

            <label for="emailProveedor" class="form-label"><b>Email de proveedor</b></label>
            <input type="email" class="form-control" id="emailProveedor" name="emailProveedor" placeholder="Ingrese el email" oninput="validar_email()" required>
            <span id="errorEmailProveedor" class="error-messege"></span>
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
<div class="modal fade" id="proveedorModalModificar" tabindex="-1" aria-labelledby="proveedorModalModificarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formProveedor" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=proveedores&action=modificar">
        <div class="modal-header">
          <h5 class="modal-title" id="proveedorModalModificarLabel">Modificar Proveedor</h5>
          <button type="button" class="fa fa-close btn btn-outline-dark btn-round ms-auto" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <label for="id_proveedor" class="form-label"><b>Rif de proveedor</b></label>
            <div class="d-flex align-items-center">
                <select name="tipo_idEdit" id="tipo_idEdit" class="form-control w-25 mr-2" required>
                <option value="J-">J-</option>
                <option value="G-">G-</option>
                <option value="C-">C-</option>
            </select>
            <span id="errorTipoIdEdit" class="error-messege"></span>
            <input type="text" class="form-control" id="id_proveedorEdit" name="id_proveedorEdit" placeholder="" oninput="validar_id_proveedor_modificado()" required>
            </div>
            <span id='errorIdProveedorEdit' class="error-messege"></span>
            <br>

            <label for="nombreProveedor" class="form-label"><b>Nombre de proveedor</b></label>
            <input type="text" class="form-control" id="nombreProveedorEdit" name="nombreProveedorEdit" placeholder="Ingrese el nombre" oninput="validar_nombre_modificado()" required>
            <span id="errorProveedorEdit" class="error-messege"></span>
            <br>

            <label for="direccionProveedor" class="form-label"><b>Direccion de proveedor</b></label>
            <input type="text" class="form-control" id="direccionProveedorEdit" name="direccionProveedorEdit" placeholder="Ingrese la direccion" oninput="validar_direccion_modificada()" required>
            <span id="errorDireccionProveedorEdit" class="error-messege"></span>
            <br>

            <label for="tlfProveedor" class="form-label"><b>Telefono de proveedor</b></label>
            <input type="text" class="form-control" id="tlfProveedorEdit" name="tlfProveedorEdit" placeholder="Ingrese el telefono" oninput="validar_telefono_modificado()" required>
            <span id="errorTlfProveedorEdit" class="error-messege"></span>
            <br>

            <label for="emailProveedor" class="form-label"><b>Email de proveedor</b></label>
            <input type="email" class="form-control" id="emailProveedorEdit" name="emailProveedorEdit" placeholder="Ingrese el email" oninput="validar_email_modificado()" required>
            <span id="errorEmailProveedorEdit" class="error-messege"></span>
        </div>
        <div class="modal-footer d-flex justify-content-center">
          <button type="button" class="btn btn-outline-danger btn-round" data-bs-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-outline-warning btn-round">Modificar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script src="assets/js/validaciones/proveedores_validaciones.js"></script>
<script src="assets/js/ajax/proveedores_ajax.js"></script>

  </body>
</html>