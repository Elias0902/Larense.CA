<?php

// llama al modelo
require_once 'app/models/PerfilSistemaModel.php';

// zona horaria
date_default_timezone_set('America/Caracas');

// se almacena la action o la peticion http
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    // ===== VISTAS PRINCIPALES =====
    case 'usuarios':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Vista_Usuarios();
        }
        break;

    case 'roles':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Vista_Roles();
        }
        break;

    case 'permisos':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Vista_Permisos();
        }
        break;

    // ===== API USUARIOS =====
    case 'listarUsuarios':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Listar_Usuarios();
        }
        break;

    case 'verUsuario':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Ver_Usuario();
        }
        break;

    case 'crearUsuario':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Crear_Usuario();
        }
        break;

    case 'actualizarUsuario':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Actualizar_Usuario();
        }
        break;

    case 'eliminarUsuario':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Eliminar_Usuario();
        }
        break;

    case 'cambiarEstadoUsuario':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Cambiar_Estado_Usuario();
        }
        break;

    // ===== API ROLES =====
    case 'listarRoles':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Listar_Roles();
        }
        break;

    case 'verRol':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Ver_Rol();
        }
        break;

    case 'crearRol':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Crear_Rol();
        }
        break;

    case 'actualizarRol':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Actualizar_Rol();
        }
        break;

    case 'eliminarRol':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Eliminar_Rol();
        }
        break;

    // ===== API PERMISOS =====
    case 'obtenerMatrizPermisos':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Obtener_Matriz_Permisos();
        }
        break;

    case 'actualizarPermiso':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Actualizar_Permiso();
        }
        break;

    case 'obtenerPermisosRol':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Obtener_Permisos_Rol();
        }
        break;

    case 'verificarPermiso':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Verificar_Permiso();
        }
        break;

    // ===== SIMULACIÓN DE ROLES =====
    case 'simularRol':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Simular_Rol();
        }
        break;

    case 'restaurarRol':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Restaurar_Rol();
        }
        break;

    default:
        // Por defecto muestra la vista principal con pestañas
        Vista_Principal();
        break;
}

// ===== FUNCIONES DE VISTAS =====

// vista principal con pestañas
function Vista_Principal() {
    if (!isset($_SESSION['s_usuario'])) {
        header('Location: index.php?url=autenticator&action=login');
        exit;
    }

    $modelo = new PerfilSistema();
    $usuarios = $modelo->ObtenerTodosUsuarios();
    $roles = $modelo->ObtenerRoles();
    $modulos = $modelo->ObtenerModulos();
    $matrizPermisos = $modelo->ObtenerMatrizPermisosCompleta();

    $activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'usuarios';

    require_once 'app/views/perfilesView.php';
}

// vista específica de usuarios (redirige a principal con tab)
function Vista_Usuarios() {
    if (!isset($_SESSION['s_usuario'])) {
        header('Location: index.php?url=autenticator&action=login');
        exit;
    }
    header('Location: index.php?url=perfiles&tab=usuarios');
    exit;
}

// vista específica de roles (redirige a principal con tab)
function Vista_Roles() {
    if (!isset($_SESSION['s_usuario'])) {
        header('Location: index.php?url=autenticator&action=login');
        exit;
    }
    header('Location: index.php?url=perfiles&tab=roles');
    exit;
}

// vista específica de permisos (redirige a principal con tab)
function Vista_Permisos() {
    if (!isset($_SESSION['s_usuario'])) {
        header('Location: index.php?url=autenticator&action=login');
        exit;
    }
    header('Location: index.php?url=perfiles&tab=permisos');
    exit;
}

// ===== FUNCIONES API USUARIOS =====

// listar usuarios (JSON)
function Listar_Usuarios() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesión no iniciada']);
        return;
    }

    $modelo = new PerfilSistema();
    $usuarios = $modelo->ObtenerTodosUsuarios();

    echo json_encode(['status' => true, 'data' => $usuarios]);
}

// ver un usuario específico
function Ver_Usuario() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesión no iniciada']);
        return;
    }

    $id_usuario = $_GET['id'] ?? 0;
    $modelo = new PerfilSistema();
    $usuario = $modelo->ObtenerUsuarioPorId($id_usuario);

    echo json_encode($usuario ? ['status' => true, 'data' => $usuario] : ['status' => false, 'msj' => 'Usuario no encontrado']);
}

// crear usuario
function Crear_Usuario() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesión no iniciada']);
        return;
    }

    $modelo = new PerfilSistema();

    $nombre_usuario = filter_var($_POST['nombre_usuario'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $email_usuario = filter_var($_POST['email_usuario'] ?? '', FILTER_SANITIZE_EMAIL);
    $id_rol = intval($_POST['id_rol'] ?? 0);
    $password = $_POST['password'] ?? '';

    // validaciones
    if (empty($nombre_usuario) || empty($email_usuario) || empty($password) || $id_rol == 0) {
        echo json_encode(['status' => false, 'msj' => 'Todos los campos son obligatorios']);
        return;
    }

    if (!filter_var($email_usuario, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => false, 'msj' => 'El correo electrónico no es válido']);
        return;
    }

    $expre_password = '/^(?=.*[A-Z])(?=.*\.)[a-zA-Z0-9.]{6,}$/';
    if (!preg_match($expre_password, $password)) {
        echo json_encode(['status' => false, 'msj' => 'La contraseña debe tener mínimo 6 caracteres, una mayúscula y un punto']);
        return;
    }

    if ($modelo->ExisteUsuario($nombre_usuario, $email_usuario)) {
        echo json_encode(['status' => false, 'msj' => 'El nombre de usuario o correo ya existe']);
        return;
    }

    $resultado = $modelo->CrearUsuario($nombre_usuario, $email_usuario, $password, $id_rol);

    if ($resultado['status']) {
        $modelo->RegistrarBitacora($_SESSION['s_usuario']['id_usuario'], 'PERFILES', 'CREAR', 'Usuario creado: ' . $nombre_usuario);
    }

    echo json_encode($resultado);
}

// actualizar usuario
function Actualizar_Usuario() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesión no iniciada']);
        return;
    }

    $modelo = new PerfilSistema();

    $id_usuario = intval($_POST['id_usuario'] ?? 0);
    $nombre_usuario = filter_var($_POST['nombre_usuario'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $email_usuario = filter_var($_POST['email_usuario'] ?? '', FILTER_SANITIZE_EMAIL);
    $id_rol = intval($_POST['id_rol'] ?? 0);
    $password = $_POST['password'] ?? '';

    if ($id_usuario == 0 || empty($nombre_usuario) || empty($email_usuario) || $id_rol == 0) {
        echo json_encode(['status' => false, 'msj' => 'Todos los campos son obligatorios']);
        return;
    }

    if (!filter_var($email_usuario, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => false, 'msj' => 'El correo electrónico no es válido']);
        return;
    }

    if ($modelo->ExisteUsuarioOtroId($nombre_usuario, $email_usuario, $id_usuario)) {
        echo json_encode(['status' => false, 'msj' => 'El nombre de usuario o correo ya existe']);
        return;
    }

    $resultado = $modelo->ActualizarUsuario($id_usuario, $nombre_usuario, $email_usuario, $id_rol, $password);

    if ($resultado['status']) {
        $modelo->RegistrarBitacora($_SESSION['s_usuario']['id_usuario'], 'PERFILES', 'ACTUALIZAR', 'Usuario actualizado: ' . $nombre_usuario);
    }

    echo json_encode($resultado);
}

// eliminar usuario
function Eliminar_Usuario() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesión no iniciada']);
        return;
    }

    $id_usuario = intval($_POST['id_usuario'] ?? 0);

    if ($id_usuario == $_SESSION['s_usuario']['id_usuario']) {
        echo json_encode(['status' => false, 'msj' => 'No puedes eliminar tu propio usuario']);
        return;
    }

    $modelo = new PerfilSistema();
    $usuario = $modelo->ObtenerUsuarioPorId($id_usuario);
    $nombre_usuario = $usuario['nombre_usuario'] ?? 'Usuario #' . $id_usuario;

    $resultado = $modelo->EliminarUsuario($id_usuario);

    if ($resultado['status']) {
        $modelo->RegistrarBitacora($_SESSION['s_usuario']['id_usuario'], 'PERFILES', 'ELIMINAR', 'Usuario eliminado: ' . $nombre_usuario);
    }

    echo json_encode($resultado);
}

// cambiar estado de usuario
function Cambiar_Estado_Usuario() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesión no iniciada']);
        return;
    }

    $id_usuario = intval($_POST['id_usuario'] ?? 0);
    $nuevo_estado = intval($_POST['estado'] ?? 1);

    $modelo = new PerfilSistema();
    $resultado = $modelo->CambiarEstadoUsuario($id_usuario, $nuevo_estado);

    echo json_encode($resultado);
}

// ===== FUNCIONES API ROLES =====

// listar roles
function Listar_Roles() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesión no iniciada']);
        return;
    }

    $modelo = new PerfilSistema();
    $roles = $modelo->ObtenerRoles();

    echo json_encode(['status' => true, 'data' => $roles]);
}

// ver un rol específico
function Ver_Rol() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesión no iniciada']);
        return;
    }

    $id_rol = $_GET['id'] ?? 0;
    $modelo = new PerfilSistema();
    $rol = $modelo->ObtenerRolPorId($id_rol);

    echo json_encode($rol ? ['status' => true, 'data' => $rol] : ['status' => false, 'msj' => 'Rol no encontrado']);
}

// crear rol
function Crear_Rol() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesión no iniciada']);
        return;
    }

    $nombre_rol = filter_var($_POST['nombre_rol'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($nombre_rol)) {
        echo json_encode(['status' => false, 'msj' => 'El nombre del rol es obligatorio']);
        return;
    }

    $modelo = new PerfilSistema();
    $resultado = $modelo->CrearRol($nombre_rol);

    if ($resultado['status']) {
        $modelo->RegistrarBitacora($_SESSION['s_usuario']['id_usuario'], 'PERFILES', 'CREAR_ROL', 'Rol creado: ' . $nombre_rol);
    }

    echo json_encode($resultado);
}

// actualizar rol
function Actualizar_Rol() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesión no iniciada']);
        return;
    }

    $id_rol = intval($_POST['id_rol'] ?? 0);
    $nombre_rol = filter_var($_POST['nombre_rol'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

    if ($id_rol == 0 || empty($nombre_rol)) {
        echo json_encode(['status' => false, 'msj' => 'Todos los campos son obligatorios']);
        return;
    }

    $modelo = new PerfilSistema();
    $resultado = $modelo->ActualizarRol($id_rol, $nombre_rol);

    if ($resultado['status']) {
        $modelo->RegistrarBitacora($_SESSION['s_usuario']['id_usuario'], 'PERFILES', 'ACTUALIZAR_ROL', 'Rol actualizado: ' . $nombre_rol);
    }

    echo json_encode($resultado);
}

// eliminar rol
function Eliminar_Rol() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesión no iniciada']);
        return;
    }

    $id_rol = intval($_POST['id_rol'] ?? 0);

    $modelo = new PerfilSistema();
    $rol = $modelo->ObtenerRolPorId($id_rol);
    $nombre_rol = $rol['nombre_rol'] ?? 'Rol #' . $id_rol;

    $resultado = $modelo->EliminarRol($id_rol);

    if ($resultado['status']) {
        $modelo->RegistrarBitacora($_SESSION['s_usuario']['id_usuario'], 'PERFILES', 'ELIMINAR_ROL', 'Rol eliminado: ' . $nombre_rol);
    }

    echo json_encode($resultado);
}

// ===== FUNCIONES API PERMISOS =====

// obtener matriz completa de permisos
function Obtener_Matriz_Permisos() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesión no iniciada']);
        return;
    }

    $modelo = new PerfilSistema();
    $matriz = $modelo->ObtenerMatrizPermisosCompleta();
    $roles = $modelo->ObtenerRoles();
    $modulos = $modelo->ObtenerModulos();

    echo json_encode([
        'status' => true,
        'matriz' => $matriz,
        'roles' => $roles,
        'modulos' => $modulos
    ]);
}

// actualizar un permiso específico
function Actualizar_Permiso() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesión no iniciada']);
        return;
    }

    $id_rol = intval($_POST['id_rol'] ?? 0);
    $id_modulo = intval($_POST['id_modulo'] ?? 0);
    $id_permiso = intval($_POST['id_permiso'] ?? 0);
    $activo = intval($_POST['activo'] ?? 0);

    if ($id_rol == 0 || $id_modulo == 0 || $id_permiso == 0) {
        echo json_encode(['status' => false, 'msj' => 'Parámetros inválidos']);
        return;
    }

    $modelo = new PerfilSistema();
    $resultado = $modelo->ActualizarPermiso($id_rol, $id_modulo, $id_permiso, $activo);

    if ($resultado['status']) {
        $accion = $activo ? 'ACTIVAR_PERMISO' : 'DESACTIVAR_PERMISO';
        $modelo->RegistrarBitacora($_SESSION['s_usuario']['id_usuario'], 'PERFILES', $accion, "Rol: $id_rol, Módulo: $id_modulo, Permiso: $id_permiso");
    }

    echo json_encode($resultado);
}

// obtener permisos de un rol específico
function Obtener_Permisos_Rol() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesión no iniciada']);
        return;
    }

    $id_rol = $_GET['id'] ?? 0;
    $modelo = new PerfilSistema();
    $permisos = $modelo->ObtenerPermisosRol($id_rol);

    echo json_encode(['status' => true, 'permisos' => $permisos]);
}

// verificar si tiene un permiso específico
function Verificar_Permiso() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesión no iniciada']);
        return;
    }

    $id_rol = $_GET['rol'] ?? 0;
    $id_modulo = $_GET['modulo'] ?? 0;
    $id_permiso = $_GET['permiso'] ?? 0;

    $modelo = new PerfilSistema();
    $tiene = $modelo->VerificarPermiso($id_rol, $id_modulo, $id_permiso);

    echo json_encode(['status' => true, 'tiene_permiso' => $tiene]);
}

// ===== FUNCIONES DE SIMULACIÓN DE ROLES =====

// simular un rol (para administradores)
function Simular_Rol() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesión no iniciada']);
        return;
    }

    // Solo administradores pueden simular
    $rol_actual = $_SESSION['s_usuario']['id_rol_usuario'] ?? 0;
    if ($rol_actual != 1 && $rol_actual != 2) { // 1=Superusuario, 2=Administrador
        echo json_encode(['status' => false, 'msj' => 'No tienes permisos para simular roles']);
        return;
    }

    $id_rol_simular = intval($_POST['id_rol'] ?? 0);

    if ($id_rol_simular == 0) {
        echo json_encode(['status' => false, 'msj' => 'Rol inválido']);
        return;
    }

    // Guardar el rol original si no está guardado
    if (!isset($_SESSION['rol_original'])) {
        $_SESSION['rol_original'] = $_SESSION['s_usuario']['id_rol_usuario'];
        $_SESSION['nombre_rol_original'] = $_SESSION['s_usuario']['nombre_rol'] ?? 'Usuario';
    }

    // Obtener información del rol a simular
    $modelo = new PerfilSistema();
    $rol = $modelo->ObtenerRolPorId($id_rol_simular);

    if (!$rol) {
        echo json_encode(['status' => false, 'msj' => 'Rol no encontrado']);
        return;
    }

    // Cambiar el rol en la sesión
    $_SESSION['s_usuario']['id_rol_usuario'] = $id_rol_simular;
    $_SESSION['s_usuario']['nombre_rol'] = $rol['nombre_rol'] . ' (Simulado)';
    $_SESSION['rol_simulado'] = true;

    $modelo->RegistrarBitacora($_SESSION['s_usuario']['id_usuario'], 'PERFILES', 'SIMULAR_ROL', 'Simulando rol: ' . $rol['nombre_rol']);

    echo json_encode(['status' => true, 'msj' => 'Ahora estás viendo como: ' . $rol['nombre_rol']]);
}

// restaurar el rol original
function Restaurar_Rol() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesión no iniciada']);
        return;
    }

    if (!isset($_SESSION['rol_original'])) {
        echo json_encode(['status' => false, 'msj' => 'No hay rol para restaurar']);
        return;
    }

    $modelo = new PerfilSistema();

    // Restaurar el rol original
    $_SESSION['s_usuario']['id_rol_usuario'] = $_SESSION['rol_original'];
    $_SESSION['s_usuario']['nombre_rol'] = $_SESSION['nombre_rol_original'];

    unset($_SESSION['rol_original']);
    unset($_SESSION['nombre_rol_original']);
    unset($_SESSION['rol_simulado']);

    $modelo->RegistrarBitacora($_SESSION['s_usuario']['id_usuario'], 'PERFILES', 'RESTAURAR_ROL', 'Rol restaurado al original');

    echo json_encode(['status' => true, 'msj' => 'Rol restaurado correctamente']);
}

?>
