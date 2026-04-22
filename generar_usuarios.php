<?php
/**
 * Script para generar usuarios de prueba
 * Accede desde: http://localhost/larence/generar_usuarios.php
 */

require_once 'app/models/ConexionModel.php';

// Generar hash de la contraseña
$password = 'Elias.09';
$password_hash = password_hash($password, PASSWORD_DEFAULT);

// Usuarios de prueba a crear
$usuarios = [
    // Usuario principal del sistema (Elias)
    ['@Elias09', 'eliasarmas0902@gmail.com', 1, 1],

    // Superadmin
    ['@admin_principal', 'admin@larence.com', 1, 1],

    // Administradores
    ['@gerente_01', 'gerente01@larence.com', 2, 1],
    ['@admin_ventas', 'ventas@larence.com', 2, 1],

    // Vendedores
    ['@vendedor_juan', 'juan@larence.com', 4, 1],
    ['@vendedor_maria', 'maria@larence.com', 4, 1],
    ['@vendedor_carlos', 'carlos@larence.com', 4, 1],

    // Usuarios regulares
    ['@repartidor_01', 'repartidor01@larence.com', 3, 1],
    ['@repartidor_02', 'repartidor02@larence.com', 3, 1],
    ['@almacen_01', 'almacen@larence.com', 3, 1],

    // Inactivos
    ['@ex_empleado', 'exempleado@larence.com', 4, 0],
];

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Usuarios de Prueba - Larense C.A</title>
    <?php require_once 'components/links.php'; ?>
    <style>
        body {
            background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
            min-height: 100vh;
            padding: 40px 20px;
        }
        .container-card {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }
        .header-section {
            text-align: center;
            margin-bottom: 30px;
        }
        .header-section h1 {
            color: #cc1d1d;
            font-weight: 700;
        }
        .password-box {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 30px;
            border-left: 4px solid #cc1d1d;
        }
        .password-label {
            font-size: 0.85rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .password-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: #cc1d1d;
            margin: 10px 0;
        }
        .hash-value {
            font-family: monospace;
            font-size: 0.8rem;
            background: #e9ecef;
            padding: 10px;
            border-radius: 8px;
            word-break: break-all;
            color: #495057;
        }
        .table-users {
            margin-top: 20px;
        }
        .table-users th {
            background: #cc1d1d;
            color: white;
            border: none;
        }
        .btn-generate {
            background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 10px;
            font-weight: 600;
            font-size: 1rem;
        }
        .btn-generate:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(204, 29, 29, 0.4);
            color: white;
        }
        .alert-custom {
            border-radius: 12px;
            padding: 15px 20px;
        }
        .role-badge {
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        .role-1 { background: #dc3545; color: white; }
        .role-2 { background: #6f42c1; color: white; }
        .role-3 { background: #0dcaf0; color: white; }
        .role-4 { background: #198754; color: white; }
        .status-badge {
            padding: 5px 10px;
            border-radius: 10px;
            font-size: 0.75rem;
        }
        .status-1 { background: #d1f2eb; color: #198754; }
        .status-0 { background: #fadbd8; color: #e74c3c; }
    </style>
</head>
<body>
    <div class="container-card">
        <div class="header-section">
            <h1><i class="fas fa-users-cog me-2"></i>Generar Usuarios de Prueba</h1>
            <p class="text-muted">Esta herramienta inserta usuarios de prueba en la base de datos</p>
        </div>

        <div class="password-box">
            <div class="password-label">Contraseña para todos los usuarios</div>
            <div class="password-value"><i class="fas fa-key me-2"></i><?php echo $password; ?></div>
            <div class="hash-value">Hash: <?php echo $password_hash; ?></div>
        </div>

        <h5 class="mb-3"><i class="fas fa-list me-2 text-danger"></i>Usuarios a crear:</h5>

        <div class="table-responsive">
            <table class="table table-users table-hover">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Correo</th>
                        <th>Rol</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $roles = [1 => 'Superadmin', 2 => 'Admin', 3 => 'Usuario', 4 => 'Vendedor'];
                    foreach($usuarios as $u):
                        $rol_nombre = $roles[$u[2]] ?? 'Usuario';
                        $esPrincipal = ($u[0] == '@Elias09');
                    ?>
                    <tr <?php echo $esPrincipal ? 'style="background: #fff3cd; font-weight: bold;"' : ''; ?>>
                        <td>
                            <strong><?php echo $u[0]; ?></strong>
                            <?php if($esPrincipal): ?>
                                <span class="badge bg-danger ms-2">TU USUARIO</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo $u[1]; ?></td>
                        <td><span class="role-badge role-<?php echo $u[2]; ?>"><?php echo $rol_nombre; ?></span></td>
                        <td><span class="status-badge status-<?php echo $u[3]; ?>"><?php echo $u[3] ? 'Activo' : 'Inactivo'; ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="text-center mt-4">
            <form method="POST">
                <button type="submit" name="generar" class="btn btn-generate">
                    <i class="fas fa-plus-circle me-2"></i>Insertar Usuarios en BD
                </button>
            </form>
        </div>

        <?php
        if (isset($_POST['generar'])) {
            try {
                $conexion = new Conexion();
                $insertados = 0;
                $errores = [];

                foreach($usuarios as $usuario) {
                    try {
                        // Verifica si el usuario ya existe
                        $sql_check = "SELECT id_usuario FROM usuarios WHERE nombre_usuario = ? OR email_usuario = ?";
                        $stmt_check = $conexion->connSeguridad->prepare($sql_check);
                        $stmt_check->execute([$usuario[0], $usuario[1]]);

                        if ($stmt_check->rowCount() > 0) {
                            $errores[] = "{$usuario[0]}: Ya existe";
                            continue;
                        }

                        // Inserta el usuario
                        $sql = "INSERT INTO usuarios (nombre_usuario, password_usuario, email_usuario, id_rol_usuario, status)
                                VALUES (?, ?, ?, ?, ?)";
                        $stmt = $conexion->connSeguridad->prepare($sql);
                        $stmt->execute([$usuario[0], $password_hash, $usuario[1], $usuario[2], $usuario[3]]);
                        $insertados++;

                    } catch (PDOException $e) {
                        $errores[] = "{$usuario[0]}: " . $e->getMessage();
                    }
                }

                echo '<div class="mt-4">';
                if ($insertados > 0) {
                    echo '<div class="alert alert-success alert-custom">
                            <i class="fas fa-check-circle me-2"></i><strong>¡' . $insertados . ' usuarios insertados correctamente!</strong>
                          </div>';
                }
                if (count($errores) > 0) {
                    echo '<div class="alert alert-warning alert-custom">
                            <i class="fas fa-exclamation-triangle me-2"></i><strong>Advertencias:</strong><br>';
                    foreach($errores as $error) {
                        echo "• {$error}<br>";
                    }
                    echo '</div>';
                }
                echo '</div>';

            } catch (Exception $e) {
                echo '<div class="alert alert-danger alert-custom mt-4">
                        <i class="fas fa-times-circle me-2"></i><strong>Error:</strong> ' . $e->getMessage() . '
                      </div>';
            }
        }
        ?>

        <div class="mt-4 pt-3 border-top text-center">
            <a href="index.php?url=usuarios" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left me-2"></i>Ir a Control de Usuarios
            </a>
        </div>
    </div>
</body>
</html>
