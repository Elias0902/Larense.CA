<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Larense C.A</title>
    <?php require_once 'components/links.php'; ?>
    <link rel="stylesheet" href="assets/css/usuarioStyle.css">
</head>
<body>
    <?php require_once 'components/menu.php'; ?>
    <?php require_once 'components/header.php'; ?>

     <!-- Espaciado superior -->
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
                <h3 class="fw-bold mb-0" style="color: #333;">Gestión de Usuarios</h3>
                <nav aria-label="breadcrumb" class="mt-1">
                  <ol class="breadcrumb mb-0" style="background: none; padding: 0;">
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #dc3545;"><i class="icon-home"></i></a></li>
                    <li class="breadcrumb-item"><a href="index.php?url=dashboard" style="color: #666;">Dashboard</a></li>
                    <li class="breadcrumb-item active" style="color: #333;">Usuarios</li>
                  </ol>
                </nav>
              </div>
            </div>
            <button
              class="btn btn-danger btn-round shadow-sm"
              data-bs-toggle="modal"
              data-bs-target="#usuarioModal"
              style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); border: none; padding: 10px 20px;"
            >
              <i class="fa fa-plus me-2"></i>
              Registrar Usuario
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
                    <i class="fa fa-list me-2"></i>Registros de Usuarios
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
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">IMG</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Nombre</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Email</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545;">Rol</th>
                        <th style="padding: 15px; color: #dc3545; font-weight: 600; border-bottom: 2px solid #dc3545; text-align: center;">Acciones</th>
                      </tr>
                    </thead>
                    <tbody>
                          <?php 
                //verifica si cliente existe o esta vacia en dado caso que este vacia muestra clientes no 
                // registrados ya que si el usuario que realizo la pedticion no tiene el permiso en cambio 
                // si lo tiene muestra la informacion
                if(isset($usuarios) && is_array($usuarios) && !empty($usuarios)){
                foreach ($usuarios as $usuario): 
            ?>
                          <tr style="transition: all 0.2s;" data-id="<?php echo $usuario['id_usuario']; ?>">
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500;">
                              <span class="badge" style="background: #dc3545; color: white; padding: 6px 10px; border-radius: 6px;">
                                US-00<?php echo $usuario['id_usuario']; ?>
                              </span>
                            </td>
                            <td style="padding: 15px; vertical-align: middle;">
                              <img src="<?php echo $usuario['img_usuario']; ?>" 
                                   style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%; border: 2px solid #f0f0f0; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <?php echo $usuario['nombre_usuario']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <?php echo $usuario['email_usuario']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; font-weight: 500; color: #333;">
                              <?php echo $usuario['nombre_rol']; ?>
                            </td>
                            <td style="padding: 15px; vertical-align: middle; text-align: center;">
                              <div class="btn-group" role="group">
                                <!-- Ver Detalle -->
                                <a
                                  onclick="VerDetalleUsuario(<?php echo $usuario['id_usuario']; ?>)"
                                  data-bs-toggle="modal"
                                  data-bs-target="#usuarioDetalleModal"      
                                  type="button"
                                  class="btn btn-sm"
                                  title='Ver Detalle'
                                  style="background: #6c757d; color: white; border-radius: 6px 0 0 6px; border: none;"
                                >
                                  <i class="fa fa-eye"></i>
                                </a>
                                <a
                                  onclick="ObtenerUsuario(<?php echo $usuario['id_usuario']; ?>)"
                                  data-bs-toggle="modal"
                                  data-bs-target="#usuarioModalModificar"      
                                  type="button"
                                  class="btn btn-sm"
                                  title='Modificar'
                                  style="background: #ffc107; color: #212529; border: none;"
                                >
                                  <i class="fa fa-edit"></i>
                                </a>
                                <a href="#"
                                  onclick="return EliminarUsuario(event,<?php echo $usuario['id_usuario']; ?>)"
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

    <!-- Modal Crear/Editar Usuario -->
    <div class="modal fade" id="usuarioModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitulo">
                        <i class="fas fa-user-plus me-2"></i>Nuevo Usuario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formUsuario" onsubmit="return validar_formulario()" method="post" action="index.php?url=usuarios&action=agregar">
                        <input type="hidden" name="id_usuario" id="id_usuario">

                        <div class="mb-3">
                            <label class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" name="nombre_usuario" id="nombre_usuario" oninput='username_validacion()' required>
                            <span id="errorUsername" class="error-messege text-danger small"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo Electronico</label>
                            <input type="email" class="form-control" name="email_usuario" id="email_usuario" oninput='email_validacion()' required>
                            <span id="errorEmail" class="error-messege text-danger small"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rol</label>
                            <select class="form-select" name="id_rol" id="id_rol" oninput='validar_rol()' required>
                                <option value="">Selecciona un rol</option>
                                <?php foreach($roles as $rol): ?>
                                <option value="<?php echo $rol['id_rol']; ?>">
                                    <?php echo htmlspecialchars($rol['nombre_rol']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <span id="errorRol" class="error-messege text-danger small"></span>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contrasena <small class="text-muted" id="passwordHelp">(Dejar en blanco para mantener actual)</small></label>
                            <input type="password" class="form-control" name="password" id="password" oninput='password_validacion()' required>
                            <span id="errorPW" class="error-messege text-danger small"></span>
                            <small class="text-muted">Minimo 6 caracteres, una mayuscula y un punto</small>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-save me-2"></i>Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal MODIFICAR Usuario -->
<div class="modal fade" id="usuarioModalModificar" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTituloModificar">
                    <i class="fas fa-user-edit me-2"></i>Modificar Usuario
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                <form id="formUsuarioModificar" onsubmit="return validar_formulario_modificado()" method="post" action="index.php?url=usuarios&action=modificar">
                    <!-- ID OCULTO (IMPORTANTE) -->
                    <input type="hidden" name="id_usuarioEdit" id="id_usuarioEdit">

                    <div class="mb-3">
                        <label class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" name="nombre_usuarioEdit" id="nombre_usuarioEdit" oninput='validar_nombre_modificado()' required>
                        <span id="errorUsernameEdit" class="error-messege text-danger small"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" name="email_usuarioEdit" id="email_usuarioEdit" oninput='validar_email_modificado()' required>
                        <span id="errorEmailEdit" class="error-messege text-danger small"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Rol</label>
                        <select class="form-select" name="id_rolEdit" id="id_rolEdit" oninput='validar_rol_modificado()' required>
                            <option value="">Selecciona un rol</option>
                            <?php foreach($roles as $rol): ?>
                            <option value="<?php echo $rol['id_rol']; ?>">
                                <?php echo htmlspecialchars($rol['nombre_rol']); ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                        <span id="errorRolEdit" class="error-messege text-danger small"></span>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nueva Contraseña 
                            <small class="text-muted">(Dejar en blanco para NO cambiar)</small>
                        </label>
                        <input type="password" class="form-control" name="passwordEdit" id="passwordEdit" placeholder="Nueva contraseña" oninput='validar_password_modificado()' required>
                        <span id="errorPWMod" class="error-messege text-danger small"></span>
                        <small class="text-muted">Mínimo 6 caracteres (solo si cambias contraseña)</small>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="limpiarModalModificar()">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>Modificar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    <script src="assets/js/validaciones/usuarios_validaciones.js"></script>
    <script src="assets/js/ajax/usuarios_ajax.js"></script>
    <script src="assets/js/animacionesJs/dashboard_usuarios.js"></script>

    <?php require_once 'components/scripts.php'; ?>
    <?php require_once 'components/footer.php'; ?>
</body>
</html>
