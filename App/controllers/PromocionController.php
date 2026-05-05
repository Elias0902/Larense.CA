<?php
    // llama el archivo del modelo
    require_once 'app/models/PromocionModel.php';
    require_once 'app/models/ProductoModel.php';
    require_once 'app/models/PermisoModel.php';
    require_once 'app/models/BitacoraModel.php';

    // llama el archivo que contiene la carga de alerta
    require_once 'components/utils.php';

    //zona horaria
    date_default_timezone_set('America/Caracas');

    // se almacena la action o la peticion http
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

        case 'obtener_productos':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                ObtenerProductos();
            }
        break;

        case 'eliminar':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                Eliminar();
            }
        break;

        case 'cambiar_estado':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                CambiarEstado();
            }
        break;

        case 'consultar_estado':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                ConsultarEstado();
            }
        break;

        default:
            Consultar();
        break;
    }

    // funcion para consultar datos
    function Consultar() {
        $modelo = new Promocion();
        $producto = new Producto();
        $permiso = new Permiso();
        $bitacora = new Bitacora();
        
        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Promociones',
            'permiso' => 'Consultar',
           'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);


        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {

            // se ejecuta accion permitida
            
            try {

                // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                // primer para metro la accion y luego el objeto usuario_json
                $resultado = $modelo->manejarAccion('consultar', null);

                // valida si exixtes el staus del resultado y si es true 
                if (isset($resultado['status']) && $resultado['status'] === true) {

                    // se extrae las promociones 
                    $promociones = $resultado['data'];

                    // se extrae los productos
                    $prod = $productos = $producto->manejarAccion('consultar', null)['data'];
                    
                    // se arma el json para la bitacora
                    $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Promociones',
                        'accion' => 'Consultar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha Consultado los datos en dashboard de las promociones en el sistema.',
                        'fecha' => $fecha
                    ]);

                    // se registra la accion en la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                    // se llama la vista
                    require_once 'app/views/promocionesView.php';
                    
                    // se termian el script
                    exit();
                } 
                else {

                    // usa mensaje dinamico del modelo
                    setError($resultado['msj']);

                    // se extrae los productos
                    $prod = $productos = $producto->manejarAccion('consultar', null)['data'];

                    //carga la vista
                    require_once 'app/views/promocionesView.php';

                    // termina el script
                    exit();
                }
            } catch (Exception $e) {

                // se captura el error y se muestra un mensaje de error
                error_log('Error al consultar promociones...' . $e->getMessage());
                
                // se muestra un mensaje de error
                setError('Error en operacion.');
                
                // se termina el script
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

    // funcion para guardar datos
    function Agregar() {

        // se instancioa el modelo
        $modelo = new Promocion();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Promociones',
            'permiso' => 'Agregar',
        'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la action 
        // y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {

            // se ejecuta accion permitida

                // obtiene y sanitiza los valores
                $nombre = filter_var($_POST['nombrePromocion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
                $descripcion = filter_var($_POST['descripcionPromocion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
                $tipo = filter_var($_POST['tipoPromocion'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
                $valor = filter_var($_POST['valorPromocion'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
                $fecha_inicio = filter_var($_POST['fechaInicio'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
                $fecha_fin = filter_var($_POST['fechaFin'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
                $estado = isset($_POST['estadoPromocion']) ? '1' : '0';
                $productos = $_POST['productos'] ?? []; // obtiene los productos seleccionados

                // valida si los campos no estan vacios
                if (empty($nombre) || empty($productos) || empty($descripcion) || empty($tipo) || empty($valor) || empty($fecha_inicio) || empty($fecha_fin)) {
                    
                    // se muestra un mensaje de error
                    setError('Todos los campos son requeridos. No se puede enviar vacíos.');
                    
                    // redirige a la vista de promociones
                    header('Location: index.php?url=promociones');
                    
                    // se termina el script
                    exit();
                }

                // se arma el json
                $promocion_json = json_encode([
                    'nombre' => $nombre,
                    'descripcion' => $descripcion,
                    'tipo' => $tipo,
                    'valor' => $valor,
                    'productos' => $productos,
                    'fecha_inicio' => $fecha_inicio,
                    'fecha_fin' => $fecha_fin,
                    'estado' => $estado
                ]);
                 //print_r($promocion_json);

                try {

                    // llam la funcion que agregar los datos
                    $resultado = $modelo->manejarAccion('agregar', $promocion_json);
                    
                    // valida si existe el estatus y si es true
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // muestra mensaje de exito
                        setSuccess($resultado['msj']);

                        // se arma el json de la bitacora
                        $bitacora_json = json_encode([
                            'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                            'modulo' => 'Promociones',
                            'accion' => 'Agregar',
                            'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                                'ha agregado una nueva promoción' . ' ' . 
                                'con el nombre:' . ' ' . $nombre . ' ' .
                                'descripcion:' . ' ' . $descripcion . ' ' . 
                                'de tipo:' . ' '. $tipo . ' ' .
                                'con valor:' . ' ' . $valor . ' ' .
                                'con los siguientes productos:' . ' ' . implode(', ', $productos) . ' ' .
                                'con fecha de inicio:' . ' ' . $fecha_inicio . ' ' .
                                'y fecha de fin:' . ' ' . $fecha_fin . ' ' .
                                'y estado:' . ' ' . ($estado ? 'Activo' : 'Inactivo') . ' ' .
                                'en el sistema.',
                            'fecha' => $fecha
                        ]);

                        // se registra la bitacora
                        $bitacora->manejarAccion('agregar', $bitacora_json);

                    } 
                    else {

                        // en caso de error se muentra mensaje de error
                        setError($resultado['msj']);

                        // redirige a la vista de promociones
                        header('Location: index.php?url=promociones');

                        // se termina el script
                        exit();

                    }
                } catch (Exception $e) {

                    // se captura el error y se muestra un mensaje de error
                    error_log('Error al registrar promoción...' . $e->getMessage());
                    
                    // se muestra un mensaje de error
                    setError('Error en operacion.');
                }

                // redirige a la vista de promociones
                header('Location: index.php?url=promociones');
                
                // se termina el script
                exit();
            }
        
        //muestra un modal de info que dice acceso no permitido
        setError("Error acceso no permitido");

        //redirecciona a la vista de 403
        header('Location: index.php?url=403');

        // termina el script
        exit();

    }

    // funcion para modificar datos
    function Actualizar() {

        // instacia el modelo
        $modelo = new Promocion();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Promociones',
            'permiso' => 'Modificar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la accion requerida
        if (isset($status['status']) && $status['status'] === true) {

            // obtiene y sanitiza los valores
            $id = $_POST['id'] ?? '';
            $nombre = filter_var($_POST['nombrePromocionEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $descripcion = filter_var($_POST['descripcionPromocionEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $tipo = filter_var($_POST['tipoPromocionEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $valor = filter_var($_POST['valorPromocionEdit'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $fecha_inicio = filter_var($_POST['fechaInicioEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $fecha_fin = filter_var($_POST['fechaFinEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $estado = isset($_POST['estadoPromocionEdit']) ? '1' : '0';
            $productos = $_POST['productosEdit'] ?? []; // obtiene los productos seleccionados

            // valida si los campos no estan vacios
            if (empty($id) || empty($productos) || empty($nombre) || empty($descripcion) || empty($tipo) || empty($valor) || empty($fecha_inicio) || empty($fecha_fin)) {
                
                // mensare de rror
                setError('Todos los campos son requeridos. No se puede enviar vacíos.');
                
                // redirige
                header('Location: index.php?url=promociones');
                
                // termina el script
                exit();
            }

            // se arma el json
            $promocion_json = json_encode([
                'id' => $id,
                'nombre' => $nombre,
                'descripcion' => $descripcion,
                'productos' => $productos,
                'tipo' => $tipo,
                'valor' => $valor,
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'estado' => $estado
            ]);
            //print_r($promocion_json);

            try {

                // llama la funcion de modificar promocion
                $resultado = $modelo->manejarAccion('modificar', $promocion_json);
                
                // valida si esxixte el status ysi es true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    
                    // mensaje de exito
                    setSuccess($resultado['msj']);

                    // se almacena para la bitacora
                    $data_bitacora = $resultado['data_bitacora'];

                    // se arma el json de bitacora
                    $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Promociones',
                        'accion' => 'Modificar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                           'ha modificado la siguiente promocion' . ' ' . 
                            'PR-00' . $id . ' ' .
                            $nombre . ' ' .
                            $descripcion . ' ' .
                            implode(', ', $productos) . ' ' .
                            $tipo . ' ' .
                            $valor . ' ' .
                            $estado . ' ' .
                            $fecha_inicio . ' ' .
                            $fecha_fin . ' ' .
                            ' ' . 'en el sistema.',
                        'fecha' => $fecha
                    ]);

                //realiza la insercion de la bitacora
                $bitacora->manejarAccion('agregar', $bitacora_json);
                
                } else {

                    // mensaje de error
                    setError($resultado['msj']);
                }
            } catch (Exception $e) {

                // mensaje dinamico de error
                error_log('Error al actualizar promoción...' . $e->getMessage());
                
                // mensaje de error generico
                setError('Error en operacion.');
            }

        // redirige
        header('Location: index.php?url=promociones');
        
        // termina el script
        exit();
    }

        //muestra un modal de info que dice acceso no permitido
        header("Location: index.php?url=403");
        
        // termina el script
        exit();
    }


    // function para obtener un dato
    function Obtener() {

        // instancia el modelo
        $modelo = new Promocion();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // sinatiza los datos
        $id = $_GET['ID'] ?? '';

        // valida el id
        if (empty($id)) {

            // mensaje de error
            setError('ID vacío.');

            // redirige
            header('Location: index.php?url=promociones');
            
            // termina el script
            exit();
        }

        // se arma el json 
        $promocion_json = json_encode([
            'id' => $id
        ]);

        // se llama la funcion de obtener al modelo
        $resultado = $modelo->manejarAccion('obtener', $promocion_json);
        
        // obtiene los datos de la promocion
        $promocion = $resultado['data'];

        // se almacena para la bitacora
        $data_bitacora = $resultado['data_bitacora'];

        // se arma el json de bitacora
        $bitacora_json = json_encode([
            'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
            'modulo' => 'Promociones',
            'accion' => 'Obtener',
            'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
            'ha Obtenido la siguiente promocion' . ' ' . 
            'PR-00' . $data_bitacora['id_promocion'] . ' ' . 
                $data_bitacora['nombre_promocion'] . ' ' . 
                $data_bitacora['descripcion_promocion'] . ' ' . 
                $data_bitacora['id_producto'] . ' ' . 
                $data_bitacora['fecha_inicio'] . ' ' . 
                $data_bitacora['fecha_fin'] . ' ' . 
                $data_bitacora['tipo_descuento'] . ' ' . 
                $data_bitacora['valor_descuento'] . ' ' . 
                $data_bitacora['estado'] . ' ' . 
                ' ' . 'en el sistema.',
            'fecha' => $fecha
        ]);

        //realiza la insercion de la bitacora
        $bitacora->manejarAccion('agregar', $bitacora_json);

        // retorna el resultado en formato json
        echo json_encode($promocion);
        
        // detiene la ejecucion del script
        exit();
    }

    // funcion para eliminar un dato
    function Eliminar() {

        // instancia el modelo
        $modelo = new Promocion();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Promociones',
            'permiso' => 'Eliminar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la accion requerida
        if (isset($status['status']) && $status['status'] === true) {
        
        // sinatiza los valores
        $id = $_GET['ID'] ?? '';

        // valida el id
        if (empty($id)) {

            // mensaje de error
            setError('ID vacío.');

            // redirige
            header('Location: index.php?url=promociones');
            
            // termina el script
            exit();
        }

        // se arma el json
        $promocion_json = json_encode([
            'id' => $id
        ]);

        try {

            // llama a la funcion eliminar del modelo
            $resultado = $modelo->manejarAccion('eliminar', $promocion_json);

            // valida si exixte el status y si es true
            if (isset($resultado['status']) && $resultado['status'] === true) {
                
                // mensaje de exito
                setSuccess($resultado['msj']);

                // se almacena para la bitacora
                $data_bitacora = $resultado['data_bitacora'];

                // se arma el json de bitacora
                $bitacora_json = json_encode([
                    'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                    'modulo' => 'Promociones',
                    'accion' => 'Eliminar',
                    'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                    'ha Eliminado la siguiente promocion' . ' ' . 
                    'PR-00' . $data_bitacora['id_promocion'] . ' ' . 
                        $data_bitacora['nombre_promocion'] . ' ' . 
                        $data_bitacora['descripcion_promocion'] . ' ' . 
                        $data_bitacora['id_producto'] . ' ' . 
                        $data_bitacora['fecha_inicio'] . ' ' . 
                        $data_bitacora['fecha_fin'] . ' ' . 
                        $data_bitacora['tipo_descuento'] . ' ' . 
                        $data_bitacora['valor_descuento'] . ' ' . 
                        $data_bitacora['estado'] . ' ' . 
                        ' ' . 'en el sistema.',
                    'fecha' => $fecha
                ]);

                //realiza la insercion de la bitacora
                $bitacora->manejarAccion('agregar', $bitacora_json);

            } else {

                // mensaje de exito
                setError($resultado['msj']);

                // redirige ai se cumple todo
                header('Location: index.php?url=promociones');
            
            // detiene la ejecucion del script
            exit();
        }
        }catch (Exception $e) {

            // registra el error en el log del servidor
            error_log('Error al registrar...' . $e->getMessage());
            
            // usa mensaje dinamico del modelo
            setError('Error en operacion.');
        }

            // redirige ai se cumple todo
            header('Location: index.php?url=promociones');
            
            // detiene la ejecucion del script
            exit();
        }

        //muestra un modal de info que dice acceso no permitido
        header("Location: index.php?url=403");

        // termina el script
        exit();
    }

    // funcion para cambiar estado
    function CambiarEstado() {

        // instacia el modelo
        $modelo = new Promocion();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Promociones',
            'permiso' => 'Modificar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la accion requerida
        if (isset($status['status']) && $status['status'] === true) {

        // sinatiza los datos
        $id = $_POST['id'] ?? '';
        $nuevo_estado = $_POST['nuevo_estado'] ?? '';

        //valida los datos
        if (empty($id) || $nuevo_estado === '') {

            // mensaje de error
            setError('Datos incompletos.');
            
            //redirige
            header('Location: index.php?url=promociones');
            
            // termina el script
            exit();
        }

        //se arma el json
        $promocion_json = [
            'id' => $id,
            'nuevo_estado' => $nuevo_estado
        ];

        try {

            //llama la funcio de cambiar estado al modelo
            $resultado = $modelo->manejarAccion('cambiar_estado', $promocion_json);

            // valida si el status existie y si es true
            if (isset($resultado['status']) && $resultado['status'] === true) {

                // mensaje de exito
                setSuccess($resultado['msj']);

                // se almacena para la bitacora
                $data_bitacora = $resultado['data_bitacora'];

                // se arma el json de bitacora
                $bitacora_json = json_encode([
                    'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                    'modulo' => 'Promociones',
                    'accion' => 'Cambiar Estado',
                    'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                    'ha cambiado el estado de la siguiente promocion' . ' ' . 
                    'PR-00' . $data_bitacora['id_promocion'] . ' ' . 
                        $data_bitacora['nombre_promocion'] . ' ' . 
                        $data_bitacora['descripcion_promocion'] . ' ' . 
                        $data_bitacora['id_producto'] . ' ' . 
                        $data_bitacora['fecha_inicio'] . ' ' . 
                        $data_bitacora['fecha_fin'] . ' ' . 
                        $data_bitacora['tipo_descuento'] . ' ' . 
                        $data_bitacora['valor_descuento'] . ' ' . 
                        $data_bitacora['estado'] . ' ' . 
                        ' ' . 'en el sistema.',
                    'fecha' => $fecha
                ]);

                //realiza la insercion de la bitacora
                $bitacora->manejarAccion('agregar', $bitacora_json);

            } else {

                // mensaje de error
                setError($resultado['msj']);

                // redirige ai esta condicion no se cumple
                header('Location: index.php?url=promociones');
                }
            }
            catch (Exception $e) {

                // registra el error en el log del servidor
                error_log('Error al registrar...' . $e->getMessage());
                
                // usa mensaje dinamico del modelo
                setError('Error en operacion.');
            }

            // redirige ai se cumple todo
            header('Location: index.php?url=promociones');
            
            // detiene la ejecucion del script
            exit();
        }

        //muestra un modal de info que dice acceso no permitido
        header("Location: index.php?url=403");

        // termina el script
        exit();
    }

    function ConsultarEstado() {

        $modelo = new Promocion();

        // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
        // primer para metro la accion y luego el objeto usuario_json
        $resultado = $modelo->manejarAccion('consultar_estado', null);

        // retorna el resultado en formato json
        echo json_encode($resultado);
        
        // detiene la ejecucion del script
        exit();

}
?>
