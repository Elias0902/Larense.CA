<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Larense C.A</title>
    <?php
    require_once 'components/links.php';
    ?>
    <link rel="stylesheet" href="Assets/css/perfil.css">
</head>
<body>
    <?php
    require_once 'components/menu.php';
    require_once 'components/header.php';
    ?>

    <div class="container">
        <div class="profile-container">
            <div class="profile-layout">
                <!-- Columna Izquierda: Perfil -->
                <div class="profile-card">
                <!-- Header del perfil -->
                <div class="profile-header">
                    <h1 class="profile-title">Mi Perfil</h1>

                    <!-- Foto de perfil -->
                    <div class="profile-avatar-container">
                        <img src="<?php 
                        // Determinar la ruta de la imagen de perfil
                        $ruta_imagen = 'Assets/img/perfiles/default.png'; // Ruta por defecto
                        
                        // Verificar si hay imagen en el array $usuario
                        if (!empty($usuario['img_usuario'])) {
                            // Normalizar la ruta: convertir 'assets/' a 'Assets/' si es necesario
                            $ruta_imagen = $usuario['img_usuario'];
                            if (strpos($ruta_imagen, 'assets/') === 0) {
                                $ruta_imagen = 'Assets/' . substr($ruta_imagen, 7);
                            }
                            
                            // Verificar si el archivo existe
                            if (!file_exists($ruta_imagen)) {
                                $ruta_imagen = 'Assets/img/perfiles/default.png';
                            }
                        }
                        
                        echo $ruta_imagen . '?v=' . time(); // Agregar timestamp para evitar caché
                        ?>"
                             alt="Foto de perfil"
                             class="profile-avatar"
                             id="imagenPerfil">

                        <!-- Boton para opciones de imagen -->
                        <div class="avatar-overlay" onclick="toggleAvatarOptions()">
                            <i class="fas fa-camera"></i>
                        </div>

                        <!-- Menu de opciones -->
                        <div class="avatar-options" id="avatarOptions">
                            <div class="avatar-option" onclick="seleccionarImagen()">
                                <i class="fas fa-upload"></i>
                                <span>Cambiar imagen</span>
                            </div>
                            <?php 
                            if (!empty($usuario['img_usuario']) && $usuario['img_usuario'] != 'Assets/img/perfiles/default.png'): 
                            ?>
                            <div class="avatar-option delete-option" onclick="eliminarImagen()">
                                <i class="fas fa-trash"></i>
                                <span>Eliminar imagen</span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <h2 class="profile-name"><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></h2>
                    <span class="profile-role"><?php echo htmlspecialchars($usuario['nombre_rol']); ?></span>
                </div>

                <!-- Informacion del usuario -->
                <div class="profile-body">
                    <!-- Nombre de Usuario -->
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Nombre de Usuario</div>
                            <div class="info-value"><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></div>
                        </div>
                    </div>

                    <!-- Correo Electronico -->
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Correo Electronico</div>
                            <div class="info-value"><?php echo htmlspecialchars($usuario['email_usuario']); ?></div>
                        </div>
                    </div>

                    <!-- Rol -->
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-id-badge"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Rol</div>
                            <div class="info-value"><?php echo htmlspecialchars($usuario['nombre_rol']); ?></div>
                        </div>
                    </div>

                    <!-- Ultimo Acceso -->
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Ultimo acceso</div>
                            <div class="info-value"><?php echo date('d/m/Y, h:i:s a', strtotime($ultimo_acceso)); ?></div>
                        </div>
                    </div>
                </div>

                <!-- Botones de accion -->
                <div class="profile-actions">
                    <button class="btn btn-profile btn-password" onclick="abrirModalPassword()">
                        <i class="fas fa-lock"></i>
                        Cambiar Contrasena
                    </button>
                    <a href="index.php?url=dashboard" class="btn btn-profile btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Volver al Inicio
                    </a>
                </div>

                <?php
                // Solo mostrar simulación para Superusuario (1) o Administrador (2)
                $rol_usuario = $_SESSION['s_usuario']['id_rol_usuario'] ?? 0;
                if ($rol_usuario == 1 || $rol_usuario == 2):
                ?>
                <!-- Simulacion de Roles (Solo Administradores) -->
                <div class="profile-section">
                    <h6 class="text-muted mb-3"><i class="fas fa-eye me-2"></i>Simular Vista de Usuario</h6>
                    <p class="text-muted small mb-3">Cambia temporalmente tu rol para ver el sistema como otro tipo de usuario.</p>
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-outline-primary btn-sm" onclick="simularRolPerfil(3)">
                            <i class="fas fa-store me-1"></i>Ver como Vendedor
                        </button>
                        <button class="btn btn-outline-info btn-sm" onclick="simularRolPerfil(4)">
                            <i class="fas fa-user me-1"></i>Ver como Usuario
                        </button>
                        <?php if (isset($_SESSION['rol_simulado']) && $_SESSION['rol_simulado']): ?>
                        <button class="btn btn-warning btn-sm" onclick="restaurarRolPerfil()">
                            <i class="fas fa-undo me-1"></i>Restaurar mi rol (<?php echo $_SESSION['nombre_rol_original'] ?? 'Admin'; ?>)
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                </div>

                <!-- Columna Derecha: Seguridad -->
                <div class="profile-card security-section">
                <div class="security-card-header">
                    <div class="security-card-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="security-card-title">
                        <h3>Seguridad</h3>
                        <p>Metodos de verificacion</p>
                    </div>
                </div>

                <div class="security-list">
                    <!-- Email Verification -->
                    <div class="security-item">
                        <div class="security-item-icon email">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="security-item-content">
                            <h4>Email Verification</h4>
                            <p><?php echo htmlspecialchars($usuario['email_usuario']); ?></p>
                        </div>
                        <div class="security-item-status status-verified">
                            <i class="fas fa-check-circle"></i> VERIFIED
                        </div>
                    </div>

                    <!-- Phone Verification -->
                    <div class="security-item">
                        <div class="security-item-icon phone">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="security-item-content">
                            <h4>Phone Verification</h4>
                            <p><?php echo !empty($usuario['telefono_usuario']) ? htmlspecialchars($usuario['telefono_usuario']) : 'Vincula tu numero movil para mayor seguridad'; ?></p>
                        </div>
                        <div class="security-item-status <?php echo !empty($usuario['telefono_usuario']) ? 'status-verified' : 'status-pending'; ?>">
                            <i class="fas fa-<?php echo !empty($usuario['telefono_usuario']) ? 'check-circle' : 'clock'; ?>"></i>
                            <?php echo !empty($usuario['telefono_usuario']) ? 'VERIFIED' : 'PENDING'; ?>
                        </div>
                    </div>

                </div>

                <!-- Alerta de Seguridad -->
                <div class="security-alert">
                    <div class="security-alert-icon">
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div class="security-alert-content">
                        <h4>Seguridad Recomendada</h4>
                        <p>Tu cuenta tiene un nivel de seguridad medio. Te recomendamos completar la verificacion telefonica para habilitar retiros y cambios sensibles.</p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cambiar Contrasena -->
    <div class="modal fade" id="modalPassword" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-lock me-2"></i>Cambiar Contrasena
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formCambiarPassword">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Contrasena Actual</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password_actual" id="password_actual" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_actual')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nueva Contrasena</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password_nueva" id="password_nueva" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_nueva')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Minimo 6 caracteres, una mayuscula y un punto</small>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirmar Nueva Contrasena</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password_confirmar" id="password_confirmar" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmar')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Input oculto para seleccionar imagen -->
    <input type="file" id="inputImagen" accept="image/*" style="display: none;" onchange="subirImagen(this)">

    <?php require_once 'components/scripts.php'; ?>

    <script>
        // Toggle menu de opciones de avatar
        function toggleAvatarOptions() {
            const menu = document.getElementById('avatarOptions');
            menu.classList.toggle('show');
        }

        // Cierra el menu al hacer click fuera
        document.addEventListener('click', function(e) {
            const container = document.querySelector('.profile-avatar-container');
            const menu = document.getElementById('avatarOptions');
            if (container && !container.contains(e.target)) {
                menu.classList.remove('show');
            }
        });

        // Seleccionar nueva imagen
        function seleccionarImagen() {
            document.getElementById('inputImagen').click();
            document.getElementById('avatarOptions').classList.remove('show');
        }

        // Subir imagen SIN recargar la página
        function subirImagen(input) {
            if (input.files && input.files[0]) {
                const formData = new FormData();
                formData.append('img_usuario', input.files[0]);

                fetch('index.php?url=perfil&action=actualizarImagen', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Imagen actualizada',
                            text: data.msj,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        
                        // Actualizar la imagen del perfil
                        const nuevaRuta = data.imagen + '?' + new Date().getTime();
                        document.getElementById('imagenPerfil').src = nuevaRuta;

                        // Actualizar la imagen del header
                        const headerImg = document.getElementById('headerAvatarImg');
                        if (headerImg) headerImg.src = nuevaRuta;
                        
                        // Actualizar la sesión en el controlador ya se hizo
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.msj || 'Error desconocido'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al subir la imagen: ' + error.message
                    });
                });
            }
        }

        // Eliminar imagen SIN recargar la página
        function eliminarImagen() {
            document.getElementById('avatarOptions').classList.remove('show');

            Swal.fire({
                title: 'Eliminar imagen?',
                text: 'Se eliminara tu foto de perfil',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#cc1d1d',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('index.php?url=perfil&action=eliminarImagen', {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Imagen eliminada',
                                text: data.msj,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            
                            const defaultImg = 'Assets/img/perfiles/default.png';
                            const timestamp = '?' + new Date().getTime();
                            
                            // Actualizar la imagen del perfil
                            document.getElementById('imagenPerfil').src = defaultImg + timestamp;

                            // Actualizar la imagen del header
                            const headerImg = document.getElementById('headerAvatarImg');
                            if (headerImg) headerImg.src = defaultImg + timestamp;

                            // Ocultar opción de eliminar
                            const deleteOption = document.querySelector('.delete-option');
                            if (deleteOption) deleteOption.style.display = 'none';
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.msj
                            });
                        }
                    });
                }
            });
        }

        // Abrir modal de contrasena
        function abrirModalPassword() {
            const modal = new bootstrap.Modal(document.getElementById('modalPassword'));
            modal.show();
        }

        // Toggle mostrar/ocultar contrasena
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const button = input.nextElementSibling;
            const icon = button.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Cambiar contrasena
        document.getElementById('formCambiarPassword').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('index.php?url=perfil&action=cambiarPassword', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Contrasena cambiada',
                        text: data.msj,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    bootstrap.Modal.getInstance(document.getElementById('modalPassword')).hide();
                    this.reset();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.msj
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al cambiar la contrasena'
                });
            });
        });

        // ===== FUNCIONES DE SIMULACIÓN DE ROLES =====
        function simularRolPerfil(id_rol) {
            const formData = new FormData();
            formData.append('id_rol', id_rol);

            fetch('index.php?url=perfiles&action=simularRol', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Simulación activada',
                        text: data.msj,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    setTimeout(() => location.reload(), 2000);
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: data.msj });
                }
            });
        }

        function restaurarRolPerfil() {
            fetch('index.php?url=perfiles&action=restaurarRol', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Rol restaurado',
                        text: data.msj,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    setTimeout(() => location.reload(), 1500);
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: data.msj });
                }
            });
        }
    </script>

    <?php require_once 'components/footer.php'; ?>
</body>
</html>