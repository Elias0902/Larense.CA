<?php

// llama al modelo
require_once 'app/models/PerfilModel.php';

// zona horaria
date_default_timezone_set('America/Caracas');

// se almacena la action o la peticion http
$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'ver':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            Ver_Perfil();
        }
        break;

    case 'actualizarImagen':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Actualizar_Imagen();
        }
        break;

    case 'eliminarImagen':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Eliminar_Imagen();
        }
        break;

    case 'cambiarPassword':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            Cambiar_Password();
        }
        break;

    default:
        Ver_Perfil();
        break;
}

// funcion para ver el perfil del usuario
function Ver_Perfil() {
    // verifica si hay sesion activa
    if (!isset($_SESSION['s_usuario'])) {
        header('Location: index.php?url=autenticator&action=login');
        exit;
    }

    // crea el objeto
    $modelo = new Perfil();

    // obtiene el ID del usuario de la sesion
    $id_usuario = $_SESSION['s_usuario']['id_usuario'] ?? 0;

    // obtiene los datos del usuario (con info de seguridad)
    $datos_usuario = $modelo->ObtenerUsuarioSeguridad($id_usuario);

    // obtiene el ultimo acceso desde la bitacora
    $ultimo_acceso = $modelo->ObtenerUltimoAcceso($id_usuario);

    // almacena en variables para la vista
    $usuario = $datos_usuario;
    $ultimo_acceso = $ultimo_acceso;

    // Priorizar la imagen de la sesión si existe (más actualizada)
    if (!empty($_SESSION['s_usuario']['img_usuario'])) {
        $usuario['img_usuario'] = $_SESSION['s_usuario']['img_usuario'];
    }

    // Si no hay imagen en la sesión pero sí en la BD, actualizar sesión
    if (empty($usuario['img_usuario']) || $usuario['img_usuario'] == '') {
        $usuario['img_usuario'] = 'Assets/img/default.PNG';
        $_SESSION['s_usuario']['img_usuario'] = 'Assets/img/default.PNG';
    }

    // carga la vista
    require_once 'app/views/mi_perfil.php';
}

// funcion para actualizar la imagen de perfil
function Actualizar_Imagen() {
    // Asegurar que la respuesta sea siempre JSON
    header('Content-Type: application/json');

    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesion no iniciada']);
        return;
    }

    $modelo = new Perfil();
    $id_usuario = $_SESSION['s_usuario']['id_usuario'];

    // verifica si se subio un archivo
    if (!isset($_FILES['img_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'No se recibio ninguna imagen']);
        return;
    }

    $imagen = $_FILES['img_usuario'];

    // Verificar errores de subida
    if ($imagen['error'] !== 0) {
        $error_msg = 'Error al subir archivo: ';
        switch ($imagen['error']) {
            case UPLOAD_ERR_INI_SIZE:
                $error_msg .= 'El archivo excede el tamaño permitido por PHP';
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $error_msg .= 'El archivo excede el tamaño del formulario';
                break;
            case UPLOAD_ERR_PARTIAL:
                $error_msg .= 'El archivo se subio parcialmente';
                break;
            case UPLOAD_ERR_NO_FILE:
                $error_msg .= 'No se selecciono ningun archivo';
                break;
            default:
                $error_msg .= 'Codigo de error: ' . $imagen['error'];
        }
        echo json_encode(['status' => false, 'msj' => $error_msg]);
        return;
    }

    // valida el tipo de archivo
    $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

    if (!in_array($imagen['type'], $tipos_permitidos) || !in_array($extension, $extensiones_permitidas)) {
        echo json_encode(['status' => false, 'msj' => 'Tipo de archivo no permitido. Solo JPG, PNG, GIF o WEBP']);
        return;
    }

    // valida el tamaño (maximo 2MB)
    if ($imagen['size'] > 2 * 1024 * 1024) {
        echo json_encode(['status' => false, 'msj' => 'El archivo es demasiado grande. Maximo 2MB']);
        return;
    }

    // crea el directorio si no existe
    $directorio = 'Assets/img/perfiles/';
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }

    // genera nombre unico
    $nombre_archivo = 'perfil_' . $id_usuario . '_' . time() . '.' . $extension;
    $ruta_destino = $directorio . $nombre_archivo;

    // eliminar imagen anterior si existe y no es la imagen por defecto
    $usuario_actual = $modelo->ObtenerUsuario($id_usuario);
    if (!empty($usuario_actual['img_usuario']) && 
        file_exists($usuario_actual['img_usuario']) && 
        $usuario_actual['img_usuario'] != 'Assets/img/default.PNG') {
        unlink($usuario_actual['img_usuario']);
    }

    // mueve el archivo
    if (move_uploaded_file($imagen['tmp_name'], $ruta_destino)) {
        // actualiza en la base de datos
        $resultado = $modelo->ActualizarImagen($id_usuario, $ruta_destino);

        if ($resultado['status']) {
            // actualiza la sesion
            $_SESSION['s_usuario']['img_usuario'] = $ruta_destino;
            echo json_encode(['status' => true, 'msj' => 'Imagen actualizada correctamente', 'imagen' => $ruta_destino]);
        } else {
            if (file_exists($ruta_destino)) {
                unlink($ruta_destino);
            }
            echo json_encode(['status' => false, 'msj' => 'Error al guardar en base de datos: ' . $resultado['msj']]);
        }
    } else {
        echo json_encode(['status' => false, 'msj' => 'Error al mover el archivo subido']);
    }
}

// funcion para eliminar la imagen de perfil
function Eliminar_Imagen() {
    header('Content-Type: application/json');

    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesion no iniciada']);
        return;
    }

    $modelo = new Perfil();
    $id_usuario = $_SESSION['s_usuario']['id_usuario'];

    // obtiene la imagen actual
    $usuario = $modelo->ObtenerUsuario($id_usuario);

    // elimina el archivo fisico si existe y no es la imagen por defecto
    if (!empty($usuario['img_usuario']) && 
        file_exists($usuario['img_usuario']) && 
        $usuario['img_usuario'] != 'Assets/img/default.PNG') {
        unlink($usuario['img_usuario']);
    }

    // actualiza la base de datos
    $resultado = $modelo->EliminarImagen($id_usuario);

    if ($resultado['status']) {
        // actualiza la sesion
        $_SESSION['s_usuario']['img_usuario'] = 'Assets/img/default.PNG';
        echo json_encode(['status' => true, 'msj' => 'Imagen eliminada correctamente']);
    } else {
        echo json_encode($resultado);
    }
}

// funcion para cambiar la contrasena
function Cambiar_Password() {
    header('Content-Type: application/json');
    
    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesion no iniciada']);
        return;
    }

    $modelo = new Perfil();
    $id_usuario = $_SESSION['s_usuario']['id_usuario'];

    // obtiene los datos del formulario
    $password_actual = $_POST['password_actual'] ?? '';
    $password_nueva = $_POST['password_nueva'] ?? '';
    $password_confirmar = $_POST['password_confirmar'] ?? '';

    // validaciones
    if (empty($password_actual) || empty($password_nueva) || empty($password_confirmar)) {
        echo json_encode(['status' => false, 'msj' => 'Todos los campos son obligatorios']);
        return;
    }

    if ($password_nueva !== $password_confirmar) {
        echo json_encode(['status' => false, 'msj' => 'Las contrasenas nuevas no coinciden']);
        return;
    }

    // valida la contrasena actual
    $resultado = $modelo->CambiarPassword($id_usuario, $password_actual, $password_nueva);

    echo json_encode($resultado);
}

?>