<?php
    // llama el archivo del modelo
    require_once 'app/models/ClienteModel.php'; // para clientes
    require_once 'app/models/TipoClienteModel.php'; // para los tipos de clientes
    require_once 'app/models/BitacoraModel.php'; // para la bitacora
    require_once 'app/models/PermisoModel.php'; // para los permisos

    // llama el archivo que contiene la carga de alerta
    require_once 'components/utils.php';

    //zona horaria
    date_default_timezone_set('America/Caracas');

    // se almacena la action o la peticion http 
    //$action = '';
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    // indiferentemente sea la action el switch llama la funcion correspondiente
    switch($action) {

        case 'agregar':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                Agregar();
            }
        break;

        case 'modificar':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                Actualizar();
            }
        break;

        case 'obtener':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                Obtener();
            }
        break;

        case 'eliminar':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                Eliminar();
            }
        break;

        default:
            Consultar();
        break;
    }

    // funcion para consultar datos
    function Consultar() {
       
        // instacia el modelo
        $modelo = new Cliente();
        $tipoCliente = new TipoCliente();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');


        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Clientes',
            'permiso' => 'Consultar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);


        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {
            
            // Ejecutar acción permitida*/

            // para manejo de errores
            try {

                // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                // primer para metro la accion y luego el objeto usuario_json
                $resultado = $modelo->manejarAccion('consultar', null);

                // valida si exixtes el staus del resultado y si es true 
                if (isset($resultado['status']) && $resultado['status'] === true) {

                    // usa mensaje dinamico del modelo
                    //setSuccess($resultado['msj']);
                    
                    // extrae los datos de los productos
                    $clientes = $resultado['data'];

                    // extrae los datos de las categorias
                    $tipoClien = $tipoClientes = $tipoCliente->manejarAccion('consultar', null)['data'];

                    // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Clientes',
                        'accion' => 'Consultar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha Consultado los datos en el dashboard de clientes en el sistema',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                    //carga la vista
                    require_once 'app/views/clientesView.php';

                    // termina el script
                    exit();
                }
                else {
                                
                    // usa mensaje dinamico del modelo
                    setError($resultado['msj']);
                    $tipoClien = $tipoClientes = $tipoCliente->manejarAccion('consultar', null)['data'];

                    //carga la vista
                    require_once 'app/views/clientesView.php';

                    // termina el script
                    exit();
                }
            }
            catch (Exception $e) {

                //mensaje del exception de pdo
                error_log('Error al registrar...' . $e->getMessage());
                
                // carga la alerta
                setError('Error en operacion.');

                //termina el script
                exit();
            }
        }
    
    //muestra un modal de info que dice acceso no permitido
    setError("Error acceso no permitido");

    //redirect
    header('Location: index.php?url=403');
                
    // termina el script
    exit();
    
}

    //funcion para guardar datos
    function Agregar() {

        // instacia el modelo
        $modelo = new Cliente();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');


        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Clientes',
            'permiso' => 'Agregar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {
            
            // Ejecutar acción permitida*/

            // obtiene y sinatiza los valores
            $id_cliente = filter_var($_POST['rifCliente'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $tipo_id = filter_var($_POST['tipo_id'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $nombre_cliente = filter_var($_POST['nombreCliente'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $tipo_cliente = filter_var($_POST['tipoCliente'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $telefono_cliente = filter_var($_POST['tlfCliente'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $correo_cliente = filter_var($_POST['emailCliente'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $direccion_cliente = filter_var($_POST['direccionCliente'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $estado_cliente = filter_var($_POST['estadoCliente'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $imagen_cliente = $_FILES['imgCliente'] ?? null;

            // Si las var no recibio valor 
            $estado_cliente = $estado_cliente ?: 'Pendiente'; // 'Pendiente' será el default
            
            //si no recibe valor
            if($tipo_cliente === '' || $tipo_cliente === null){
                
                $tipo_cliente = null; // 'null' será el default
            }
            else {

                $tipo_cliente = (int)$tipo_cliente; // aseguramos que sea entero
            }


            // Validación de la imagen
            if (isset($_FILES['imgCliente']) && $_FILES['imgCliente']['error'] == 0) {
                $imagen = $_FILES['imgCliente'];

                // Validación del tipo de archivo
                $tipoArchivo = pathinfo($imagen['name'], PATHINFO_EXTENSION);
                $tiposPermitidos = array('jpg', 'jpeg', 'png', 'gif');

                // Verificar el tipo de archivo
                if (!in_array(strtolower($tipoArchivo), $tiposPermitidos)) {

                    //manda mensaje de error
                    setError("Sólo se permiten archivos de tipo JPG, JPEG, PNG y GIF.");
                    
                    //redirec   
                    header("Location: index.php?url=clientes");
                    
                    //termina el script
                    exit();
                }           

            // Subir la imagen al directorio destino
            $directorioSubida = 'assets/img/clientes/';
        
            // Verificar si el directorio de subida existe, si no, crearlo
            if (!empty($imagen['name'])) {
                $nombreArchivo = basename($imagen['name']);
                $rutaSubida = $directorioSubida . $nombreArchivo;
        
                // Mover el archivo subido al directorio de destino
                if (move_uploaded_file($imagen['tmp_name'], $rutaSubida)) {
                    
                    // La imagen se ha subido correctamente
                    // Guarda el nombre de la imagen para usarlo en la base de datos
                    $imagen_cliente  = $rutaSubida; 

                } else {

                    // Error al subir la imagen
                    setError("Error al subir la imagen.");

                    //redirec
                    header("Location: index.php?url=clientes");

                    //termina el script
                    exit();
                }
            } 
            } 
            else{

                // Si no se sube imagen, deja este campo vacío
                $imagen_cliente = ''; 
            }

            // valida si los campos no estan vacios
            if (empty($nombre_cliente) || empty($tipo_id) || empty($id_cliente) || empty($telefono_cliente) || empty($correo_cliente) || empty($direccion_cliente) || empty($imagen_cliente ) || empty($estado_cliente)) {

                // manda mensaje de error
                setError('Todos los campos son requeridos no se puede enviar vacios.');

                //redirec
                header('Location: index.php?url=clientes');

                //termina el script
                exit();
            }
            

            // se arma el josn
            $cliente_json = json_encode([
                'nombre' => $nombre_cliente,
                'tipo_id' => $tipo_id,
                'id' => $id_cliente,
                'tipo' => $tipo_cliente,
                'tlf' => $telefono_cliente,
                'email' => $correo_cliente,
                'direccion' => $direccion_cliente,
                'imagen' => $imagen_cliente,
                'estado' => $estado_cliente
            ]);
            //print_r($cliente_json);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('agregar', $cliente_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Clientes',
                        'accion' => 'Agregar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha registrado el siguiente Cliente' . ' ' .
                            'C.I / RIF' . ' ' . $tipo_id . '-' . $id_cliente . ' ' .  
                            'Nombre' . ' ' . $nombre_cliente . ' ' .
                            'Tlf' . ' ' . $telefono_cliente . ' ' . 
                            'Email' . ' ' . $correo_cliente . ' ' . 
                            'Direcion' . ' ' . $direccion_cliente . ' ' . 
                            'Estado' . ' ' . $estado_cliente . ' ' . 'en el sistema.',
                            'fecha' => $fecha
                        ]);

                        //realiza la insercion de la bitacora
                        $bitacora->manejarAccion('agregar', $bitacora_json);

                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=clientes');

                    }
                }
                catch (Exception $e) {

                    //mensaje del exception de pdo
                    error_log('Error al registrar...' . $e->getMessage());
                    
                    // carga la alerta
                    setError('Error en operacion.');
                }

            //redirect
            header('Location: index.php?url=clientes');
            
            // termina el script
            exit();
        }

    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida");

    //redirect
    header('Location: index.php?url=403');
            
    // termina el script
    exit();
        
    }

    //funcion para modificar datos
    function Actualizar() {

         // instacia el modelo
        $modelo = new Cliente();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');


        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Clientes',
            'permiso' => 'Modificar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {
            
            // Ejecutar acción permitida*/

            // obtiene y sinatiza los valores
            $id_cliente = filter_var($_POST['idClienteEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $tipo_id = filter_var($_POST['tipo_idEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $nombre_cliente = filter_var($_POST['nombreClienteEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $tipo_cliente = filter_var($_POST['tipoClienteEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $telefono_cliente = filter_var($_POST['tlfClienteEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $correo_cliente = filter_var($_POST['emailClienteEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $direccion_cliente = filter_var($_POST['direccionClienteEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $estado_cliente = filter_var($_POST['estadoClienteEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $imagen_cliente = null; // Por defecto null para mantener la imagen actual
            
            // Si no recibe tipo_cliente (solo Superusuario puede cambiarlo), asignar null para mantener el actual
            $tipo_cliente = $tipo_cliente ?: null;
            
            // Si no recibe estado, usar 'Activo' como default
            $estado_cliente = $estado_cliente ?: 'Activo';
            
            // Manejo de la imagen (solo si se subió una nueva)
            if (isset($_FILES['imgClienteEdit']) && $_FILES['imgClienteEdit']['error'] == 0 && !empty($_FILES['imgClienteEdit']['name'])) {
                $imagen = $_FILES['imgClienteEdit'];

                // Validación del tipo de archivo
                $tipoArchivo = pathinfo($imagen['name'], PATHINFO_EXTENSION);
                $tiposPermitidos = array('jpg', 'jpeg', 'png', 'gif');

                // Verificar el tipo de archivo
                if (!in_array(strtolower($tipoArchivo), $tiposPermitidos)) {
                    setError("Sólo se permiten archivos de tipo JPG, JPEG, PNG y GIF.");
                    header("Location: index.php?url=clientes");
                    exit();
                }           

                // Subir la imagen al directorio destino
                $directorioSubida = 'assets/img/clientes/';
            
                // Verificar si el directorio de subida existe, si no, crearlo
                if (!empty($imagen['name'])) {
                    $nombreArchivo = basename($imagen['name']);
                    $rutaSubida = $directorioSubida . $nombreArchivo;
            
                    // Mover el archivo subido al directorio de destino
                    if (move_uploaded_file($imagen['tmp_name'], $rutaSubida)) {
                        $imagen_cliente = $rutaSubida; 
                    } else {
                        setError("Error al subir la imagen.");
                        header("Location: index.php?url=clientes");
                        exit();
                    }
                }
            }
            
            // valida si los campos requeridos no estan vacios
            if (empty($nombre_cliente) || empty($id_cliente) || empty($tipo_id) || empty($telefono_cliente) || empty($correo_cliente) || empty($direccion_cliente) || empty($estado_cliente)) {

                // manda mensaje de error
                setError('Los campos Nombre, RIF, Teléfono, Email y Dirección son requeridos.');

                //redirec
                header('Location: index.php?url=clientes');

                //termina el script
                exit();
            }

            // se arma el josn
            $cliente_data = [
                'id' => $id_cliente,
                'nombre' => $nombre_cliente,
                'tipo_id' => $tipo_id,
                'tipo' => $tipo_cliente,
                'tlf' => $telefono_cliente,
                'email' => $correo_cliente,
                'direccion' => $direccion_cliente,
                'estado' => $estado_cliente
            ];
            
            // Solo incluir imagen si se subió una nueva
            if ($imagen_cliente !== null) {
                $cliente_data['imagen'] = $imagen_cliente;
            }
            
            $cliente_json = json_encode($cliente_data);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('modificar', $cliente_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        // se almacena para la bitacora
                        $data_bitacora = $resultado['data_bitacora'];

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Clientes',
                        'accion' => 'Modificar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha modificado el siguiente Cliente' . ' ' .
                            'C.I / RIF' . ' ' . $data_bitacora['tipo_id'] . '-' . $data_bitacora['id_cliente'] . ' ' .  
                            'Nombre' . ' ' . $data_bitacora['nombre_cliente'] . ' ' .
                            'Tlf' . ' ' . $data_bitacora['tlf_cliente'] . ' ' . 
                            'Email' . ' ' . $data_bitacora['email_cliente'] . ' ' . 
                            'Direcion' . ' ' . $data_bitacora['direccion_cliente'] . ' ' . 
                            'Estado' . ' ' . $data_bitacora['estado_cliente'] . ' ' .
                            'Por los siguientes datos nuevos' . ' ' . 
                            'C.I / RIF' . ' ' . $tipo_id . '-' . $id_cliente . ' ' .  
                            'Nombre' . ' ' . $nombre_cliente . ' ' .
                            'Tlf' . ' ' . $telefono_cliente . ' ' . 
                            'Email' . ' ' . $correo_cliente . ' ' . 
                            'Direcion' . ' ' . $direccion_cliente . ' ' . 
                            'Estado' . ' ' . $estado_cliente . ' ' . 'en el sistema.',
                        'fecha' => $fecha
                        ]);

                        //realiza la insercion de la bitacora
                        $bitacora->manejarAccion('agregar', $bitacora_json);

                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=clientes');

                    }
                }
                catch (Exception $e) {

                    //mensaje del exception de pdo
                    error_log('Error al registrar...' . $e->getMessage());
                    
                    // carga la alerta
                    setError('Error en operacion.');
                }

            //redirect
            header('Location: index.php?url=clientes');
            
            // termina el script
            exit();
        }

    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida");

    //redirect
    header('Location: index.php?url=403');
            
    // termina el script
    exit();

    }

    // function para obtener un dato
    function Obtener() {

        // instacia el modelo
        $modelo = new Cliente();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        $id = $_GET['ID'];

         // valida si los campos no estan vacios
        if (empty($id)) {

            // manda mensaje de error
            setError('Todos los campos son requeridos no se puede enviar vacios.');

            //redirec
            header('Location: index.php?url=clientes');

            //termina el script
            exit();
        }

            // se arma el josn
            $cliente_json = json_encode([
                'id' => $id
            ]);

            $resultado = $modelo->manejarAccion('obtener', $cliente_json);

            // se almacena para la vista
            $cliente = $resultado['data'];

            // se almacena para la bitacora
            $data_bitacora = $resultado['data_bitacora'];

            // se arma el json de bitacora
            $bitacora_json = json_encode([
                'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                'modulo' => 'Clientes',
                'accion' => 'Obtener',
                'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                    'ha obtenido el siguiente Cliente' . ' ' .
                    'C.I / RIF' . ' ' . $data_bitacora['tipo_id'] . '-' . $data_bitacora['id_cliente'] . ' ' .  
                    'Nombre' . ' ' . $data_bitacora['nombre_cliente'] . ' ' .
                    'Tlf' . ' ' . $data_bitacora['tlf_cliente'] . ' ' . 
                    'Email' . ' ' . $data_bitacora['email_cliente'] . ' ' . 
                    'Direcion' . ' ' . $data_bitacora['direccion_cliente'] . ' ' . 
                    'Estado' . ' ' . $data_bitacora['estado_cliente'] . ' ' .
                    'en el sistema.',
                'fecha' => $fecha
                ]);

                //realiza la insercion de la bitacora
                $bitacora->manejarAccion('agregar', $bitacora_json);

            echo json_encode($cliente);

            exit();
    }

    // funcion para eliminar un dato
    function Eliminar() {

         // instacia el modelo
        $modelo = new Cliente();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');


        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Clientes',
            'permiso' => 'Eliminar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {
            
            // Ejecutar acción permitida

            // obtiene y sinatiza los valores
            $id_cliente = $_GET['ID'];

            // valida si los campos no estan vacios
            if (empty($id_cliente)) {

                // manda mensaje de error
                setError('ID vacio.');

                //redirec
                header('Location: index.php?url=clientes');

                //termina el script
                exit();
            }

            // se arma el josn
            $cliente_json = json_encode([
                'id' => $id_cliente
            ]);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('eliminar', $cliente_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        // se almacena para la bitacora
                        $data_bitacora = $resultado['data_bitacora'];

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Clientes',
                        'accion' => 'Eliminar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha eliminado el siguiente cliente' . ' ' .
                            'C.I / RIF' . ' ' . $data_bitacora['tipo_id'] . '-' . $data_bitacora['id_cliente'] . ' ' .  
                            'Nombre' . ' ' . $data_bitacora['nombre_cliente'] . ' ' .
                            'Tlf' . ' ' . $data_bitacora['tlf_cliente'] . ' ' . 
                            'Email' . ' ' . $data_bitacora['email_cliente'] . ' ' . 
                            'Direcion' . ' ' . $data_bitacora['direccion_cliente'] . ' ' . 
                            'Estado' . ' ' . $data_bitacora['estado_cliente'] . ' ' . 'en el sistema.',
                        'fecha' => $fecha
                        ]);

                        //realiza la insercion de la bitacora
                        $bitacora->manejarAccion('agregar', $bitacora_json);

                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=clientes');

                    }
                }
                catch (Exception $e) {

                    //mensaje del exception de pdo
                    error_log('Error al registrar...' . $e->getMessage());
                    
                    // carga la alerta
                    setError('Error en operacion.');
                }

        //redirect
        header('Location: index.php?url=clientes');

        // termina el script
        exit();

    }

    //muestra un modal de info que dice acceso no permitido
    setError("Error accion no permitida");

    //redirect
    header('Location: index.php?url=403');
            
    // termina el script
    exit();    
    
}
?>