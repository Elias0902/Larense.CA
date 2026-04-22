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
    if (!empty($_SESSION['s_usuario']['imagen_perfil'])) {
        $usuario['imagen_perfil'] = $_SESSION['s_usuario']['imagen_perfil'];
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

    // Debug: log de informacion del archivo recibido
    error_log('Actualizar_Imagen - FILES recibido: ' . print_r($_FILES, true));

    // verifica si se subio un archivo
    if (!isset($_FILES['imagen_perfil'])) {
        error_log('Actualizar_Imagen - No se recibio archivo en imagen_perfil');
        echo json_encode(['status' => false, 'msj' => 'No se recibio ninguna imagen']);
        return;
    }

    $imagen = $_FILES['imagen_perfil'];

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
        error_log('Actualizar_Imagen - ' . $error_msg);
        echo json_encode(['status' => false, 'msj' => $error_msg]);
        return;
    }

    // valida el tipo de archivo por extension y mime type
    $tipos_permitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
    $extensiones_permitidas = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    $extension = strtolower(pathinfo($imagen['name'], PATHINFO_EXTENSION));

    if (!in_array($imagen['type'], $tipos_permitidos) || !in_array($extension, $extensiones_permitidas)) {
        error_log('Actualizar_Imagen - Tipo no permitido: ' . $imagen['type'] . ', extension: ' . $extension);
        echo json_encode(['status' => false, 'msj' => 'Tipo de archivo no permitido. Solo JPG, PNG, GIF o WEBP']);
        return;
    }

    // valida el tamaño (maximo 2MB)
    if ($imagen['size'] > 2 * 1024 * 1024) {
        error_log('Actualizar_Imagen - Archivo muy grande: ' . $imagen['size'] . ' bytes');
        echo json_encode(['status' => false, 'msj' => 'El archivo es demasiado grande. Maximo 2MB']);
        return;
    }

    // crea el directorio si no existe
    $directorio = 'Assets/img/perfiles/';
    if (!file_exists($directorio)) {
        if (!mkdir($directorio, 0777, true)) {
            error_log('Actualizar_Imagen - No se pudo crear el directorio: ' . $directorio);
            echo json_encode(['status' => false, 'msj' => 'Error al crear directorio de destino']);
            return;
        }
    }

    // verificar permisos de escritura
    if (!is_writable($directorio)) {
        error_log('Actualizar_Imagen - Directorio no escribible: ' . $directorio);
        echo json_encode(['status' => false, 'msj' => 'Error de permisos en el servidor']);
        return;
    }

    // genera nombre unico
    $nombre_archivo = 'perfil_' . $id_usuario . '_' . time() . '.' . $extension;
    $ruta_destino = $directorio . $nombre_archivo;

    // eliminar imagen anterior si existe
    $usuario_actual = $modelo->ObtenerUsuario($id_usuario);
    if (!empty($usuario_actual['imagen_perfil']) && file_exists($usuario_actual['imagen_perfil'])) {
        unlink($usuario_actual['imagen_perfil']);
        error_log('Actualizar_Imagen - Imagen anterior eliminada: ' . $usuario_actual['imagen_perfil']);
    }

    // mueve el archivo
    if (move_uploaded_file($imagen['tmp_name'], $ruta_destino)) {
        error_log('Actualizar_Imagen - Archivo movido exitosamente a: ' . $ruta_destino);

        // actualiza en la base de datos
        $resultado = $modelo->ActualizarImagen($id_usuario, $ruta_destino);

        if ($resultado['status']) {
            // actualiza la sesion
            $_SESSION['s_usuario']['imagen_perfil'] = $ruta_destino;
            error_log('Actualizar_Imagen - Imagen actualizada en BD y sesion');
            echo json_encode(['status' => true, 'msj' => 'Imagen actualizada correctamente', 'imagen' => $ruta_destino]);
        } else {
            // Si fallo la BD, eliminar el archivo subido
            unlink($ruta_destino);
            error_log('Actualizar_Imagen - Error en BD: ' . $resultado['msj']);
            echo json_encode(['status' => false, 'msj' => 'Error al guardar en base de datos: ' . $resultado['msj']]);
        }
    } else {
        error_log('Actualizar_Imagen - Error al mover archivo de ' . $imagen['tmp_name'] . ' a ' . $ruta_destino);
        echo json_encode(['status' => false, 'msj' => 'Error al mover el archivo subido']);
    }
}

// funcion para eliminar la imagen de perfil
function Eliminar_Imagen() {
    // Asegurar que la respuesta sea siempre JSON
    header('Content-Type: application/json');

    if (!isset($_SESSION['s_usuario'])) {
        echo json_encode(['status' => false, 'msj' => 'Sesion no iniciada']);
        return;
    }

    $modelo = new Perfil();
    $id_usuario = $_SESSION['s_usuario']['id_usuario'];

    // obtiene la imagen actual
    $usuario = $modelo->ObtenerUsuario($id_usuario);

    error_log('Eliminar_Imagen - Imagen actual: ' . ($usuario['imagen_perfil'] ?? 'null'));

    // elimina el archivo fisico si existe
    if (!empty($usuario['imagen_perfil']) && file_exists($usuario['imagen_perfil'])) {
        if (unlink($usuario['imagen_perfil'])) {
            error_log('Eliminar_Imagen - Archivo eliminado: ' . $usuario['imagen_perfil']);
        } else {
            error_log('Eliminar_Imagen - No se pudo eliminar archivo: ' . $usuario['imagen_perfil']);
        }
    }

    // actualiza la base de datos
    $resultado = $modelo->EliminarImagen($id_usuario);

    if ($resultado['status']) {
        // actualiza la sesion
        unset($_SESSION['s_usuario']['imagen_perfil']);
        error_log('Eliminar_Imagen - Imagen eliminada de BD y sesion');
        echo json_encode(['status' => true, 'msj' => 'Imagen eliminada correctamente']);
    } else {
        error_log('Eliminar_Imagen - Error en BD: ' . $resultado['msj']);
        echo json_encode($resultado);
    }
}

// funcion para cambiar la contrasena
function Cambiar_Password() {
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
