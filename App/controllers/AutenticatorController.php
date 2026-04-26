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
                setSuccess("Bienvenido!. Usuario autenticado correctamente.");

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

                // redirect
                header("Location: index.php?url=dashboard");
                
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
?>