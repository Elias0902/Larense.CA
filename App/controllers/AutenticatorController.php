<?php

    require 'vendor/autoload.php'; // o manual: PHPMailer.php, SMTP.php, Exception.php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;


    //llama a los modelos
    require_once __DIR__ . '/../models/AutenticatorModel.php'; // al modelo de Autenticator
    require_once __DIR__ . '/../models/BitacoraModel.php'; // llama al modelo bitacora
    
    // llama el archivo que contiene la carga de alerta
    require_once __DIR__ . '/../../components/utils.php';

    //zona horaria
    date_default_timezone_set('America/Caracas');

    // se almacena la action o la peticion http 
    //$action = '';
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    // indiferentemente sea la action el switch llama la funcion correspondiente
    switch ($action) {

        case 'registrar':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                Registrar();
            }
        break;

        case 'register':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                Register_Views();
            }
        break;

        case 'ingresar':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                Iniciar_Sesion();
            }
        break;

        case 'login':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                Login_Views();
            }
        break;

        case 'recuperar':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                Recuperar();
            }
        break;

        case 'verificar':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                //Verificar_Token();
                Verificar_Views();
            }

        break;

        case 'cambiar':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                Cambiar();
            }
        break;

        case 'ajustes':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                Recuperar_Views();
            }
        break;

        case 'obtener':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                Obtener();
            }
        break;

        case 'cerrar':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                Cerrar_Session();
            }
        break;

        case 'simular_rol':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                Simular_Rol();
            }
        break;

        case 'restaurar_rol':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                Restaurar_Rol();
            }
        break;

        case 'login_prueba':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                Login_Prueba();
            }
        break;

        default:
            Login_Views();
        break;
    }

    // funcion para registrar un nuevo usuario para el sistema
    function Registrar() {

        // crea el objeto
        $modelo = new Autenticator();
        $bitacora = new Bitacora(); // se crea el modelo bitacora

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        //obtiene los valores y lo sinatiza
        $username = filter_var($_POST['username'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $password = filter_var($_POST['password'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

        // valida si todo los los campos esta vacios
        if (empty($username) && empty($email) && empty($password)) {
            setError('Todos los campos no pueden ser enviados vacios.');
            header('Location: index.php?url=autenticator&action=register');
            exit();
        }

        // se arma el objeto json del usuario
        $usuario_json = json_encode([
            'username' => $username,
            'email' => $email,
            'password' => $password,
            'rol' => '3'
        ]);

        try {

            // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
            // primer para metro la accion y luego el objeto usuario_json
            $resultado = $modelo->manejarAccion('agregar', $usuario_json);

            // valida si exixtes el staus del resultado y si es true 
            if (isset($resultado['status']) && $resultado['status'] === true) {

                // usa el mensaje dinamico del modelo
                setSuccess($resultado['msj']);

                // se arma el json de bitacora
                    $bitacora_json = json_encode([
                        'id_usuario' => null,
                        'modulo' => 'Autenticator',
                        'accion' => 'Registrarse',
                        'descripcion' => 'El usuario:' . ' ' . $username . ' ' . 'se ha registrado en el sistema.',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);
            }
            else {
                
                // Error: usa mensaje dinamico o generico
                $mensajeError = $resultado['msj'] ?? 'Error al registrar...';
                setError($mensajeError);

                //redirect
                header('Location: index.php?url=autenticator&action=');
            }
        }
        catch (Exception $e) {

            //mensaje del exception de pdo
            error_log('Error al registrar...' . $e->getMessage());
            setError('Error en operacion.');
        }

        //redirect
        header('Location: index.php?url=autenticator&action=');
        exit();
    }

    // funcion para iniciar session en el sistema
    function Iniciar_Sesion() {

        // crea el objeto
        $modelo = new Autenticator();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        //obtiene y sinatiza los datos
        $username = filter_var($_POST['username'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
        $password = filter_var($_POST['password'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

        // valida si los campos no estan vacios
        if (empty($username) || empty($password)) {

            setError("Todos los campos no pueden ser enviados vacios.");
            header("Location: index.php?url=atenticator?action=");
            exit();
        }

        // se arma el json del usuario
        $usuario_json = json_encode([
            'username' => $username,
            'password' => $password
        ]);

        // obtiene los datos del usuario del modelo
        $resultado = $modelo->manejarAccion('ingresar',$usuario_json);

        // valida si el resulatdo es true
        if ($resultado['status']) {

            // almacena los datos del usuario 
            $usuario = $resultado['data'];

            // verifica la password utilizando password_verify
            if (password_verify($password, $usuario['password_usuario'])) {

                // se asegura que la session este iniciada
                if (session_status() === PHP_SESSION_NONE) {

                    // se inicializa la session
                    session_start();
                }

                // se inicializa la variables de session
                $_SESSION['s_usuario'] = [
                    'id_usuario' => $usuario['id_usuario'],
                    'nombre_usuario' => $usuario['nombre_usuario'],
                    'email_usuario' => $usuario['email_usuario'],
                    'id_rol_usuario' => $usuario['id_rol_usuario'],
                    'rol_usuario' => $usuario['nombre_rol'],
                    'img_usuario' => $usuario['img_usuario'] ?? null,
                ];

                // mensaje de bienvenida
                setSuccess("Bienvenido! " . $usuario['nombre_usuario'] . ". Usuario autenticado correctamente.");

                // se arma el json de bitacora
                $bitacora_json = json_encode([
                    'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                    'modulo' => 'Autenticator',
                    'accion' => 'LOGIN',
                    'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 'ha iniciado session en el sistema.',
                    'fecha' => $fecha
                ]);

                //realiza la insercion de la bitacora
                $bitacora->manejarAccion('agregar', $bitacora_json);

                // redirect según el rol del usuario
                if ($usuario['id_rol_usuario'] == 3) {
                    // Rol de usuario normal -> redirigir al ecommerce
                    header("Location: index.php?url=ecommerce");
                } else {
                    // Roles 1 y 2 (admin) -> redirigir al dashboard
                    header("Location: index.php?url=dashboard");
                }
                
                // termina el script una vez redereccionado el usuario
                exit();
            }
            else {
                
                //mensaje de error en autenticacion
                setError("Datos incorrectos intentelo de nuevo.");

                // redirect
                header("Location: index.php?url=autenticator&action=");

                // termina el script
                exit();
            }
        }
        else {

            // mensaje de error en consulta de usuario
            setError("Usuario no encontrado intentelo de nuevo o cree una cuenta.");

            // redirect
            header("Location: index.php?url=autenticator&action=");

            //termina el script
            exit();
        }
    }

    // funcion para cerrar session de un usuario
    function Cerrar_Session() {

        // se crea el modelo bitacora
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // verifica si es por inactividad
        $motivo = $_GET['motivo'] ?? '';
        $es_inactividad = ($motivo === 'inactividad');

        // inicializa la session
        session_start();

     // guarda el id y nombre antes de destruir la session
        $id_usuario = $_SESSION['s_usuario']['id_usuario'] ?? null;
        $nombre_usuario = $_SESSION['s_usuario']['nombre_usuario'] ?? 'Desconocido';

        // Limpiar variables de simulación de rol
        unset($_SESSION['simulando_rol']);
        unset($_SESSION['rol_original']);

        // destruye la session
        session_destroy();

        // se arma el json de bitacora
        if ($es_inactividad) {
            $bitacora_json = json_encode([
                'id_usuario' => $id_usuario,
                'modulo' => 'Autenticator',
                'accion' => 'Cerrar Session por Inactividad',
                'descripcion' => 'El usuario:' . ' ' . $nombre_usuario . ' ' . 'ha sido deslogueado por inactividad en el sistema.',
                'fecha' => $fecha
            ]);
            setError('Su sesión ha sido cerrada por inactividad.');
        } else {
            $bitacora_json = json_encode([
                'id_usuario' => $id_usuario,
                'modulo' => 'Autenticator',
                'accion' => 'Cerrar Session',
                'descripcion' => 'El usuario:' . ' ' . $nombre_usuario . ' ' . 'ha Cerrado session en el sistema.',
                'fecha' => $fecha
            ]);
        }

        //realiza la insercion de la bitacora
        $bitacora->manejarAccion('agregar', $bitacora_json);

        // redirect - ir directamente al login para evitar landing
        header('location:index.php?url=autenticator');

        // termina el script
        exit();
    }

    // funcion que llama la vista de registrar usuario
    function Register_Views() {
        require_once __DIR__ . '/../views/register.php';
    }

    // funcion que llama la vista de iniciar session usuario
    function Login_Views() {
        require_once __DIR__ . '/../views/login.php';
    }

    // funcion que llama la vista de recuperar usuario
    function Recuperar_Views() {
        require_once __DIR__ . '/../views/recuperar.php';
    }

    //fucion que llama la vista de verificar token
    function Verificar_Views() {
        require_once __DIR__ . '/../views/verificar.php';
    }

    //funcion para cambiar la password de un usuario
    function Cambiar() {
        
        //crea el objeto
        $modelo = new Autenticator();
        $bitacora = new Bitacora(); // se crea el modelo bitacora

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

            //obtiene y sinatiza los datos
            $username = filter_var($_POST['username'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $password = filter_var($_POST['password'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $codigo = filter_var($_POST['codigo'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $token = $_GET['token'] ?? '';
    
            // valida si los campos no estan vacios
            if (empty($username) || empty($password) || empty($codigo)) {
    
                //mensaje de error
                setError("Todos los campos no pueden ser enviados vacios.");
                
                //redirect
                header("Location: index.php?url=atenticator&action=verificar&token=$token");
                
                //termina el script
                exit();
            }
    
            // se arma el json del usuario
            $usuario_json = json_encode([
                'username' => $username,
                'password' => $password,
                'codigo' => $codigo,
                'token' => $token
            ]);

            try {
    
                // llama la funcion que maneja las acciones en el modelo donde pasa como 
                // primer para metro la accion y luego el objeto usuario_json
                $resultado = $modelo->manejarAccion('cambiar', $usuario_json);
    
                // valida si exixtes el staus del resultado y si es true 
                if (isset($resultado['status']) && $resultado['status'] === true) {
    
                    // usa el mensaje dinamico del modelo
                    setSuccess($resultado['msj']);

                    // se arma el json de bitacora
                    $bitacora_json = json_encode([
                        'id_usuario' => null,
                        'modulo' => 'Autenticator',
                        'accion' => 'Cambio de Clave',
                        'descripcion' => 'El usuario:' . ' ' . $username . ' ' . 'ha realizado un cambio de clave en el sistema.',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                    //redirect
                    header('Location: index.php?url=autenticator&action=login');
                }
                else {
                    
                    // Error: usa mensaje dinamico o generico
                    $mensajeError = $resultado['msj'] ?? 'Error al cambiar password...';
                    setError($mensajeError);
    
                    //redirect
                    header('Location: index.php?url=autenticator&action=verificar&token=' . urlencode($token));
                }
            }
            catch (Exception $e) {
    
                //mensaje del exception de pdo
                error_log('Error al cambiar password...' . $e->getMessage());
                setError('Error en operacion.');
    
                //redirect
                header('Location: index.php?url=autenticator&action=verificar&token=' . urlencode($token));
            }
    
            //termina el script
            exit();
    }

    // funcion para recuperar la cuenta de un usuario
    function Recuperar() {

    //se instacia el modelo
    $modelo = new Autenticator();

    //obtienes y sinatiza los datos
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    //valida si el campo email esta vacio
    if(empty($email)) {

        //mensaje de error
        setError("El campo email no puede estar vacio.");

        //redirect
        header("Location: index.php?url=autenticator&action=recuperar");

        //termina el script
        exit();
    }

    //se arma el json del email
    $email_json = json_encode([
        'email' => $email
    ]);

    try {

            // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
            // primer para metro la accion y luego el objeto usuario_json
            $resultado = $modelo->manejarAccion('recuperar', $email_json);

            // valida si exixtes el staus del resultado y si es true 
            if (isset($resultado['status']) && $resultado['status'] === true) {

                // usa el mensaje dinamico del modelo
                setSuccess($resultado['msj']);

                //redirect
                header('Location: index.php?url=autenticator&action=');
            }
            else {
                
                // Error: usa mensaje dinamico o generico
                $mensajeError = $resultado['msj'] ?? 'Error al recuperar usuario...';
                setError($mensajeError);

                //redirect
                header('Location: index.php?url=autenticator&action=ajustes');
            }
        }
        catch (Exception $e) {

            //mensaje del exception de pdo
            error_log('Error al registrar...' . $e->getMessage());
            setError('Error en operacion.');
        }

        //redirect
        //header('Location: index.php?url=autenticator&action=login');
        exit();

    }

    // función para simular un rol diferente
    function Simular_Rol() {
        // Iniciar sesión solo si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Cargar modelo de permisos para verificar acceso al dashboard
        require_once __DIR__ . '/../models/PerfilSistemaModel.php';
        $perfilModel = new PerfilSistema();

        // Verificar si el usuario está logueado y tiene permisos (roles 1 y 2 pueden simular)
        if (!isset($_SESSION['s_usuario']['id_rol_usuario'])) {
            error_log("ERROR: Usuario no logueado o sin rol");
            header('Content-Type: application/json');
            echo json_encode(['status' => false, 'msj' => 'Usuario no logueado']);
            exit();
        }

        if (!in_array($_SESSION['s_usuario']['id_rol_usuario'], [1, 2])) {
            error_log("ERROR: Rol no permitido: " . $_SESSION['s_usuario']['id_rol_usuario']);
            header('Content-Type: application/json');
            echo json_encode(['status' => false, 'msj' => 'No tienes permisos para simular roles. Tu rol actual: ' . $_SESSION['s_usuario']['rol_usuario']]);
            exit();
        }

        // Obtener el rol a simular
        $id_rol_simular = filter_var($_POST['id_rol'] ?? 0, FILTER_SANITIZE_NUMBER_INT);
        $nombre_rol_simular = filter_var($_POST['nombre_rol'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

        error_log("Rol a simular - ID: $id_rol_simular, Nombre: $nombre_rol_simular");

        if (empty($id_rol_simular)) {
            error_log("ERROR: ID de rol vacío");
            header('Content-Type: application/json');
            echo json_encode(['status' => false, 'msj' => 'Rol no válido']);
            exit();
        }

        // Verificar si el rol a simular tiene acceso al dashboard
        $tiene_permiso_dashboard = $perfilModel->VerificarPermiso($id_rol_simular, 20, 2);

        // Guardar el rol original si no se ha guardado
        if (!isset($_SESSION['rol_original'])) {
            $_SESSION['rol_original'] = [
                'id_rol_usuario' => $_SESSION['s_usuario']['id_rol_usuario'],
                'rol_usuario' => $_SESSION['s_usuario']['rol_usuario']
            ];
            error_log("Rol original guardado: " . $_SESSION['rol_original']['rol_usuario']);
        }

        // Cambiar temporalmente el rol en la sesión
        $_SESSION['s_usuario']['id_rol_usuario'] = $id_rol_simular;
        $_SESSION['s_usuario']['rol_usuario'] = $nombre_rol_simular;
        $_SESSION['simulando_rol'] = true;

        error_log("Rol cambiado exitosamente a: $nombre_rol_simular");

        header('Content-Type: application/json');
        echo json_encode([
            'status' => true,
            'msj' => 'Simulando vista como: ' . $nombre_rol_simular,
            'tiene_permiso_dashboard' => $tiene_permiso_dashboard
        ]);
        exit();
    }

    // función para restaurar el rol original
    function Restaurar_Rol() {
        // Iniciar sesión solo si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si está simulando un rol
        if (!isset($_SESSION['simulando_rol']) || $_SESSION['simulando_rol'] !== true) {
            header('Content-Type: application/json');
            echo json_encode(['status' => false, 'msj' => 'No estás simulando ningún rol']);
            exit();
        }

        // Verificar si existe el rol original
        if (!isset($_SESSION['rol_original'])) {
            header('Content-Type: application/json');
            echo json_encode(['status' => false, 'msj' => 'No se encontró el rol original']);
            exit();
        }

        // Restaurar el rol original
        $_SESSION['s_usuario']['id_rol_usuario'] = $_SESSION['rol_original']['id_rol_usuario'];
        $_SESSION['s_usuario']['rol_usuario'] = $_SESSION['rol_original']['rol_usuario'];

        // Limpiar variables de simulación
        unset($_SESSION['simulando_rol']);
        unset($_SESSION['rol_original']);

        header('Content-Type: application/json');
        echo json_encode(['status' => true, 'msj' => 'Vista restaurada a tu rol original']);
        exit();
    }

    // función para login de prueba (sin validación de contraseña)
    function Login_Prueba() {
        // crea el objeto
        $modelo = new Autenticator();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // obtiene el usuario seleccionado
        $username = filter_var($_POST['username'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

        // valida si el campo no está vacío
        if (empty($username)) {
            setError("Usuario no especificado.");
            header("Location: index.php?url=autenticator&action=");
            exit();
        }

        // se arma el json del usuario
        $usuario_json = json_encode([
            'username' => $username,
            'password' => 'Elias.09' // contraseña dummy, no se valida
        ]);

        // obtiene los datos del usuario del modelo
        $resultado = $modelo->manejarAccion('ingresar', $usuario_json);

        // valida si el resultado es true
        if ($resultado['status']) {
            // almacena los datos del usuario
            $usuario = $resultado['data'];

            // se asegura que la session este iniciada
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }

            // se inicializa la variables de session
            $_SESSION['s_usuario'] = [
                'id_usuario' => $usuario['id_usuario'],
                'nombre_usuario' => $usuario['nombre_usuario'],
                'email_usuario' => $usuario['email_usuario'],
                'id_rol_usuario' => $usuario['id_rol_usuario'],
                'rol_usuario' => $usuario['nombre_rol'],
                'img_usuario' => $usuario['img_usuario'] ?? null,
            ];

            // mensaje de bienvenida
            setSuccess("Bienvenido! " . $usuario['nombre_usuario'] . ". Login de prueba exitoso.");

            // se arma el json de bitacora
            $bitacora_json = json_encode([
                'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                'modulo' => 'Autenticator',
                'accion' => 'LOGIN PRUEBA',
                'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 'ha iniciado session en el sistema (MODO PRUEBA).',
                'fecha' => $fecha
            ]);

            // realiza la insercion de la bitacora
            $bitacora->manejarAccion('agregar', $bitacora_json);

            // redirect según el rol del usuario
            if ($usuario['id_rol_usuario'] == 3) {
                // Rol de usuario normal -> redirigir al ecommerce
                header("Location: index.php?url=ecommerce");
            } else {
                // Roles 1 y 2 (admin) -> redirigir al dashboard
                header("Location: index.php?url=dashboard");
            }

            // termina el script una vez redereccionado el usuario
            exit();
        } else {
            // mensaje de error en consulta de usuario
            setError("Usuario no encontrado para prueba.");
            header("Location: index.php?url=autenticator&action=");
            exit();
        }
    }
?>