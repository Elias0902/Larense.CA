<?php

// llama al modelo
require_once 'app/models/UsuarioModel.php';

// llama el archivo que contiene la carga de alerta
require_once 'components/utils.php';

// zona horaria
date_default_timezone_set('America/Caracas');

// se almacena la action o la peticion http
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'listar':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Listar_Usuarios();
        }
        break;

    case 'ver':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Ver_Usuario();
        }
        break;

    case 'crear':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Crear_Usuario();
        }
        break;

    case 'actualizar':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Actualizar_Usuario();
        }
        break;

    case 'eliminar':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Eliminar_Usuario();
        }
        break;

    case 'cambiarEstado':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Cambiar_Estado();
        }
        break;

    default:
        Listar_Usuarios();
        break;
}

// funcion para listar todos los usuarios
function Listar_Usuarios() {
    // verifica si hay sesion activa
    if (!isset($_SESSION['s_usuario'])) {
        header('Location: index.php?url=autenticator&action=login');
        exit;
    }

    // crea el objeto
    $modelo = new Usuario();

    // obtiene todos los usuarios
    $usuarios = $modelo->ObtenerTodosUsuarios();

    // obtiene los roles para el filtro
    $roles = $modelo->ObtenerRoles();

    // carga la vista
    require_once 'app/views/usuariosView.php';
}

// funcion para ver un usuario especifico
function Ver_Usuario() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesion no iniciada']);
        return;
    }

    $id_usuario = $_GET['id'] ?? 0;

    $modelo = new Usuario();
    $usuario = $modelo->ObtenerUsuarioPorId($id_usuario);

    echo json_encode($usuario);
}

// funcion para crear un nuevo usuario
function Crear_Usuario() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesion no iniciada']);
        return;
    }

    $modelo = new Usuario();

    // obtiene los datos del formulario
    $nombre_usuario = filter_var($_POST['nombre_usuario'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $email_usuario = filter_var($_POST['email_usuario'] ?? '', FILTER_SANITIZE_EMAIL);
    $id_rol = intval($_POST['id_rol'] ?? 0);
    $password = $_POST['password'] ?? '';

    // validaciones basicas
    if (empty($nombre_usuario) || empty($email_usuario) || empty($password) || $id_rol == 0) {
        echo json_encode(['status' => false, 'msj' => 'Todos los campos son obligatorios']);
        return;
    }

    // valida el formato del email
    if (!filter_var($email_usuario, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => false, 'msj' => 'El correo electronico no es valido']);
        return;
    }

    // valida la contrasena
    $expre_password = '/^(?=.*[A-Z])(?=.*\.)[a-zA-Z0-9.]{6,}$/';
    if (!preg_match($expre_password, $password)) {
        echo json_encode(['status' => false, 'msj' => 'La contrasena debe tener minimo 6 caracteres, una mayuscula y un punto']);
        return;
    }

    // verifica si el usuario ya existe
    if ($modelo->ExisteUsuario($nombre_usuario, $email_usuario)) {
        echo json_encode(['status' => false, 'msj' => 'El nombre de usuario o correo ya existe']);
        return;
    }

    // crea el usuario
    $resultado = $modelo->CrearUsuario($nombre_usuario, $email_usuario, $password, $id_rol);

    // registra en bitacora
    if ($resultado['status']) {
        $modelo->RegistrarBitacora($_SESSION['s_usuario']['id_usuario'], 'USUARIOS', 'CREAR', 'Usuario creado: ' . $nombre_usuario);
    }

    echo json_encode($resultado);
}

// funcion para actualizar un usuario
function Actualizar_Usuario() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesion no iniciada']);
        return;
    }

    $modelo = new Usuario();

    // obtiene los datos del formulario
    $id_usuario = intval($_POST['id_usuario'] ?? 0);
    $nombre_usuario = filter_var($_POST['nombre_usuario'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
    $email_usuario = filter_var($_POST['email_usuario'] ?? '', FILTER_SANITIZE_EMAIL);
    $id_rol = intval($_POST['id_rol'] ?? 0);
    $password = $_POST['password'] ?? '';

    // validaciones basicas
    if ($id_usuario == 0 || empty($nombre_usuario) || empty($email_usuario) || $id_rol == 0) {
        echo json_encode(['status' => false, 'msj' => 'Todos los campos son obligatorios']);
        return;
    }

    // valida el formato del email
    if (!filter_var($email_usuario, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => false, 'msj' => 'El correo electronico no es valido']);
        return;
    }

    // verifica si el usuario ya existe con otro ID
    if ($modelo->ExisteUsuarioOtroId($nombre_usuario, $email_usuario, $id_usuario)) {
        echo json_encode(['status' => false, 'msj' => 'El nombre de usuario o correo ya existe']);
        return;
    }

    // actualiza el usuario
    $resultado = $modelo->ActualizarUsuario($id_usuario, $nombre_usuario, $email_usuario, $id_rol, $password);

    // registra en bitacora
    if ($resultado['status']) {
        $modelo->RegistrarBitacora($_SESSION['s_usuario']['id_usuario'], 'USUARIOS', 'ACTUALIZAR', 'Usuario actualizado: ' . $nombre_usuario);
    }

    echo json_encode($resultado);
}

// funcion para eliminar un usuario
function Eliminar_Usuario() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesion no iniciada']);
        return;
    }

    $id_usuario = intval($_POST['id_usuario'] ?? 0);

    // no permite eliminar el usuario actual
    if ($id_usuario == $_SESSION['s_usuario']['id_usuario']) {
        echo json_encode(['status' => false, 'msj' => 'No puedes eliminar tu propio usuario']);
        return;
    }

    $modelo = new Usuario();

    // obtiene el nombre del usuario antes de eliminarlo
    $usuario = $modelo->ObtenerUsuarioPorId($id_usuario);
    $nombre_usuario = $usuario['nombre_usuario'] ?? 'Usuario #' . $id_usuario;

    // elimina el usuario (cambia el status a 0)
    $resultado = $modelo->EliminarUsuario($id_usuario);

    // registra en bitacora
    if ($resultado['status']) {
        $modelo->RegistrarBitacora($_SESSION['s_usuario']['id_usuario'], 'USUARIOS', 'ELIMINAR', 'Usuario eliminado: ' . $nombre_usuario);
    }

    echo json_encode($resultado);
}

// funcion para cambiar el estado de un usuario
function Cambiar_Estado() {
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesion no iniciada']);
        return;
    }

    $id_usuario = intval($_POST['id_usuario'] ?? 0);
    $nuevo_estado = intval($_POST['estado'] ?? 1);

    $modelo = new Usuario();
    $resultado = $modelo->CambiarEstado($id_usuario, $nuevo_estado);

    echo json_encode($resultado);
}

?>
