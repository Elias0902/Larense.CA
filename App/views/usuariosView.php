<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios - Larense C.A</title>
    <?php require_once 'components/links.php'; ?>
    <style>
        .page-header {
            background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
            color: white;
            padding: 25px 30px;
            border-radius: 15px;
            margin-bottom: 25px;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 5px;
        }

        .page-subtitle {
            opacity: 0.9;
            font-size: 0.95rem;
        }

        .btn-add {
            background: white;
            color: #cc1d1d;
            border: none;
            padding: 10px 20px;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-add:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .card-users {
            background: white;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            overflow: hidden;
        }

        .card-header-custom {
            background: #f8f9fa;
            padding: 20px;
            border-bottom: 1px solid #e9ecef;
        }

        .table-users {
            margin-bottom: 0;
        }

        .table-users thead th {
            background: #f8f9fa;
            border: none;
            font-weight: 600;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 15px;
            color: #6c757d;
        }

        .table-users tbody td {
            padding: 15px;
            vertical-align: middle;
            border-bottom: 1px solid #f0f0f0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-avatar {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #e9ecef;
        }

        .user-avatar-placeholder {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 1.1rem;
        }

        .user-name {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 2px;
        }

        .user-email {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .role-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .role-superadmin {
            background: #dc3545;
            color: white;
        }

        .role-admin {
            background: #6f42c1;
            color: white;
        }

        .role-vendedor {
            background: #198754;
            color: white;
        }

        .role-usuario {
            background: #0dcaf0;
            color: white;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .status-active {
            background: #d1f2eb;
            color: #198754;
        }

        .status-inactive {
            background: #fadbd8;
            color: #e74c3c;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 2px;
            transition: all 0.2s ease;
        }

        .btn-edit {
            background: #e3f2fd;
            color: #1976d2;
        }

        .btn-edit:hover {
            background: #1976d2;
            color: white;
        }

        .btn-delete {
            background: #ffebee;
            color: #d32f2f;
        }

        .btn-delete:hover {
            background: #d32f2f;
            color: white;
        }

        .search-box {
            position: relative;
        }

        .search-box input {
            padding-left: 40px;
            border-radius: 10px;
            border: 1px solid #e9ecef;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .filter-select {
            border-radius: 10px;
            border: 1px solid #e9ecef;
            padding: 8px 15px;
        }

        /* Modal styles */
        .modal-header {
            background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
            color: white;
        }

        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        .form-label {
            font-weight: 600;
            color: #495057;
        }

        .form-control, .form-select {
            border-radius: 10px;
            padding: 10px 15px;
            border: 1px solid #e9ecef;
        }

        .form-control:focus, .form-select:focus {
            border-color: #cc1d1d;
            box-shadow: 0 0 0 3px rgba(204, 29, 29, 0.1);
        }

        .btn-save {
            background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
            color: white;
            border: none;
            border-radius: 10px;
            padding: 10px 25px;
            font-weight: 600;
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #a81717 0%, #6b0f0f 100%);
            color: white;
        }

        .stats-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: #cc1d1d;
        }

        .stats-label {
            font-size: 0.9rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <?php require_once 'components/menu.php'; ?>
    <?php require_once 'components/header.php'; ?>

    <div class="container">
        <div class="page-inner">
            <!-- Header -->
            <div class="page-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h1 class="page-title">
                            <i class="fas fa-users me-2"></i>Control de Usuarios
                        </h1>
                        <p class="page-subtitle mb-0">Gestiona los usuarios del sistema y sus permisos</p>
                    </div>
                    <button class="btn btn-add" onclick="abrirModalCrear()">
                        <i class="fas fa-plus me-2"></i>Nuevo Usuario
                    </button>
                </div>
            </div>

            <!-- Stats -->
            <div class="row mb-4">
                <?php
                $total_usuarios = count($usuarios);
                $activos = count(array_filter($usuarios, fn($u) => $u['status'] == 1));
                $inactivos = count(array_filter($usuarios, fn($u) => $u['status'] == 0));
                ?>
                <div class="col-md-4 mb-3">
                    <div class="stats-card">
                        <div class="stats-number"><?php echo $total_usuarios; ?></div>
                        <div class="stats-label">Total Usuarios</div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stats-card">
                        <div class="stats-number text-success"><?php echo $activos; ?></div>
                        <div class="stats-label">Usuarios Activos</div>
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="stats-card">
                        <div class="stats-number text-danger"><?php echo $inactivos; ?></div>
                        <div class="stats-label">Usuarios Inactivos</div>
                    </div>
                </div>
            </div>

            <!-- Filtros -->
            <div class="card-users mb-4">
                <div class="card-header-custom">
                    <div class="row align-items-center">
                        <div class="col-md-6 mb-2 mb-md-0">
                            <div class="search-box">
                                <i class="fas fa-search"></i>
                                <input type="text" class="form-control" id="buscarUsuario" placeholder="Buscar usuario...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2 justify-content-md-end">
                                <select class="form-select filter-select" id="filtroRol" style="width: auto;">
                                    <option value="">Todos los roles</option>
                                    <?php foreach($roles as $rol): ?>
                                    <option value="<?php echo htmlspecialchars($rol['nombre_rol']); ?>">
                                        <?php echo htmlspecialchars($rol['nombre_rol']); ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <select class="form-select filter-select" id="filtroEstado" style="width: auto;">
                                    <option value="">Todos los estados</option>
                                    <option value="1">Activos</option>
                                    <option value="0">Inactivos</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de usuarios -->
            <div class="card-users">
                <div class="table-responsive">
                    <table class="table table-users" id="tablaUsuarios">
                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th>Rol</th>
                                <th>Estado</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($usuarios as $usuario): ?>
                            <tr data-rol="<?php echo htmlspecialchars($usuario['nombre_rol']); ?>" data-estado="<?php echo $usuario['status']; ?>">
                                <td>
                                    <div class="user-info">
                                        <?php if(!empty($usuario['imagen_perfil'])): ?>
                                        <img src="<?php echo $usuario['imagen_perfil']; ?>" alt="Avatar" class="user-avatar">
                                        <?php else: ?>
                                        <div class="user-avatar-placeholder">
                                            <?php echo strtoupper(substr($usuario['nombre_usuario'], 0, 1)); ?>
                                        </div>
                                        <?php endif; ?>
                                        <div>
                                            <div class="user-name"><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></div>
                                            <div class="user-email"><?php echo htmlspecialchars($usuario['email_usuario']); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="role-badge role-<?php echo strtolower(str_replace(' ', '', $usuario['nombre_rol'])); ?>">
                                        <?php echo htmlspecialchars($usuario['nombre_rol']); ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="status-badge <?php echo $usuario['status'] == 1 ? 'status-active' : 'status-inactive'; ?>">
                                        <i class="fas fa-<?php echo $usuario['status'] == 1 ? 'check' : 'times'; ?> me-1"></i>
                                        <?php echo $usuario['status'] == 1 ? 'Activo' : 'Inactivo'; ?>
                                    </span>
                                </td>
                                <td class="text-end">
                                    <button class="btn-action btn-edit" onclick="editarUsuario(<?php echo $usuario['id_usuario']; ?>)" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <?php if($usuario['id_usuario'] != $_SESSION['s_usuario']['id_usuario']): ?>
                                    <button class="btn-action btn-delete" onclick="eliminarUsuario(<?php echo $usuario['id_usuario']; ?>, '<?php echo htmlspecialchars($usuario['nombre_usuario']); ?>')" title="Eliminar">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear/Editar Usuario -->
    <div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitulo">
                        <i class="fas fa-user-plus me-2"></i>Nuevo Usuario
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formUsuario">
                        <input type="hidden" name="id_usuario" id="id_usuario">

                        <div class="mb-3">
                            <label class="form-label">Nombre de Usuario</label>
                            <input type="text" class="form-control" name="nombre_usuario" id="nombre_usuario" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Correo Electronico</label>
                            <input type="email" class="form-control" name="email_usuario" id="email_usuario" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Rol</label>
                            <select class="form-select" name="id_rol" id="id_rol" required>
                                <option value="">Selecciona un rol</option>
                                <?php foreach($roles as $rol): ?>
                                <option value="<?php echo $rol['id_rol']; ?>">
                                    <?php echo htmlspecialchars($rol['nombre_rol']); ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Contrasena <small class="text-muted" id="passwordHelp">(Dejar en blanco para mantener actual)</small></label>
                            <input type="password" class="form-control" name="password" id="password">
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

    <?php require_once 'components/scripts.php'; ?>

    <script>
        // Buscar usuarios
        document.getElementById('buscarUsuario').addEventListener('input', function() {
            filtrarTabla();
        });

        // Filtro por rol
        document.getElementById('filtroRol').addEventListener('change', function() {
            filtrarTabla();
        });

        // Filtro por estado
        document.getElementById('filtroEstado').addEventListener('change', function() {
            filtrarTabla();
        });

        function filtrarTabla() {
            const busqueda = document.getElementById('buscarUsuario').value.toLowerCase();
            const rolFiltro = document.getElementById('filtroRol').value;
            const estadoFiltro = document.getElementById('filtroEstado').value;
            const filas = document.querySelectorAll('#tablaUsuarios tbody tr');

            filas.forEach(fila => {
                const texto = fila.textContent.toLowerCase();
                const rol = fila.getAttribute('data-rol');
                const estado = fila.getAttribute('data-estado');

                const coincideBusqueda = texto.includes(busqueda);
                const coincideRol = !rolFiltro || rol === rolFiltro;
                const coincideEstado = !estadoFiltro || estado === estadoFiltro;

                fila.style.display = coincideBusqueda && coincideRol && coincideEstado ? '' : 'none';
            });
        }

        // Abrir modal para crear
        function abrirModalCrear() {
            document.getElementById('formUsuario').reset();
            document.getElementById('id_usuario').value = '';
            document.getElementById('modalTitulo').innerHTML = '<i class="fas fa-user-plus me-2"></i>Nuevo Usuario';
            document.getElementById('passwordHelp').style.display = 'none';
            document.getElementById('password').required = true;
            new bootstrap.Modal(document.getElementById('modalUsuario')).show();
        }

        // Abrir modal para editar
        function editarUsuario(id) {
            fetch(`index.php?url=usuarios&action=ver&id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data) {
                        document.getElementById('id_usuario').value = data.id_usuario;
                        document.getElementById('nombre_usuario').value = data.nombre_usuario;
                        document.getElementById('email_usuario').value = data.email_usuario;
                        document.getElementById('id_rol').value = data.id_rol_usuario;
                        document.getElementById('password').value = '';
                        document.getElementById('passwordHelp').style.display = 'inline';
                        document.getElementById('password').required = false;
                        document.getElementById('modalTitulo').innerHTML = '<i class="fas fa-user-edit me-2"></i>Editar Usuario';
                        new bootstrap.Modal(document.getElementById('modalUsuario')).show();
                    }
                });
        }

        // Guardar usuario
        document.getElementById('formUsuario').addEventListener('submit', function(e) {
            e.preventDefault();

            const id = document.getElementById('id_usuario').value;
            const formData = new FormData(this);
            const url = id ? 'index.php?url=usuarios&action=actualizar' : 'index.php?url=usuarios&action=crear';

            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Guardado',
                        text: data.msj,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    bootstrap.Modal.getInstance(document.getElementById('modalUsuario')).hide();
                    setTimeout(() => location.reload(), 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.msj
                    });
                }
            });
        });

        // Eliminar usuario
        function eliminarUsuario(id, nombre) {
            Swal.fire({
                title: 'Eliminar usuario?',
                text: `Se eliminara a: ${nombre}`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d32f2f',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    const formData = new FormData();
                    formData.append('id_usuario', id);

                    fetch('index.php?url=usuarios&action=eliminar', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Eliminado',
                                text: data.msj,
                                timer: 1500,
                                showConfirmButton: false
                            });
                            setTimeout(() => location.reload(), 1500);
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
    </script>

    <?php require_once 'components/footer.php'; ?>
</body>
</html>
