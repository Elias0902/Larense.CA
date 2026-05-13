<?php
    // llama el archivo del modelo
    require_once 'app/models/PedidoModel.php';
    require_once 'app/models/ClienteModel.php';
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

        case 'obtener_productos':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                ObtenerProductos();
            }
        break;

        default:
            Consultar();
        break;
    }

    // funcion para consultar datos
    function Consultar() {

        // se instacia el modelo
        $modelo = new Pedido();//predio
        $cliente = new Cliente(); //cliente
        $promocion = new Promocion();//promocion
        $producto = new Producto();//producto
        $permiso = new Permiso();//permiso
        $bitacora = new Bitacora();//bitacora

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Pedidos',
            'permiso' => 'Consultar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);


        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {
            
            // Ejecutar acción permitida

            try {

                // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                // primer para metro la accion y luego el objeto usuario_json
                $resultado = $modelo->manejarAccion('consultar', null);

                // valida si exixtes el staus del resultado y si es true 
                if (isset($resultado['status']) && $resultado['status'] === true) {

                    // usa mensaje dinamico del modelo
                    //setSuccess($resultado['msj']);

                    // Obtener pedidos
                    $pedidos = $resultado['data'];

                    // Obtener clientes para el select
                    $clien = $clientes = $cliente->manejarAccion('consultarCliente', null)['data'];

                    // Obtener promociones activas para el select
                    $promo = $promociones = $promocion->manejarAccion('consultar', null)['data'];

                    // Obtener productos para el select
                    $prod = $productos = $producto->manejarAccion('consultar', null)['data'];
                    
                    // Obtener estado de pedido para el select
                    $estadoPed = $estadoPedido = $modelo->manejarAccion('consultar_estado', null)['data'];

                    // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Pedidos',
                        'accion' => 'Consultar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha Consultado los datos en el dashboard de pedidos en el sistema',
                            'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                    //carga la vista
                    require_once 'app/views/pedidosView.php';
                    
                    // termina el script
                    exit();
                }    
                else {
                            
                // usa mensaje dinamico del modelo
                setError($resultado['msj']);

                // Obtener clientes para el select
                $clientes = $cliente->manejarAccion('consultar', null)['data'];

                    // Obtener promociones activas para el select
                $promociones = $promocion->manejarAccion('consultar', null)['data'];

                    // Obtener productos para el select
                $productos = $producto->manejarAccion('consultar', null)['data'];

                // Obtener estado de pedido para el select
                $estadoPedido = $modelo->manejarAccion('consultar_estado', null)['data'];

                //carga la vista
                require_once 'app/views/pedidosView.php';

                // termina el script
                exit();
                }
            } catch (Exception $e) {

                // msj de error dinamico
                error_log('Error al consultar pedidos...' . $e->getMessage());
                    
                // msj de error
                setError('Error en operacion.');

                //carga a vista 
                require_once 'app/views/pedidosView.php';
                    
                // termina el script
                exit();
            }

        //muestra un modal de info que dice acceso no permitido
        setError("Error acceso no permitido");

        //redirect
        header('Location: index.php?url=403');
                
        // termina el script
        exit();
    
    }
}

    // funcion para guardar datos
    function Agregar() {

        // se instacia el modelo
        $modelo = new Pedido();//predio
        $permiso = new Permiso();//permiso
        $bitacora = new Bitacora();//bitacora

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Pedidos',
            'permiso' => 'Agregar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);


        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {
            
            // Ejecutar acción permitida           

            // obtiene y sanitiza los valores
            $cliente_id = filter_var($_POST['clienteId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
            $dias_Credito = filter_var($_POST['diasCredito'] ?? '', FILTER_SANITIZE_NUMBER_INT);
            $fecha_pedido = filter_var($_POST['fechaPedido'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $estado = filter_var($_POST['estadoPedido'] ?? 'pendiente', FILTER_SANITIZE_SPECIAL_CHARS);
            $promocion_id = filter_var($_POST['promocionId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
            $telefono = filter_var($_POST['telefonoPedido'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $direccion = filter_var($_POST['direccionPedido'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $observaciones = filter_var($_POST['observacionesPedido'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $total = filter_var($_POST['totalPedido'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

            // obtiene los arry de productos seleccionados
            $productos = $_POST['productos'] ?? [];
            $cantidades = $_POST['cantidades'] ?? [];
            $precios = $_POST['precios'] ?? [];

            // valida si los campos requeridos no estan vacios
            if (empty($cliente_id) || empty($fecha_pedido) || empty($estado) || empty($telefono) ||empty($direccion) || empty($observaciones) || empty($total) || empty($productos) || empty($cantidades) || empty($precios)) {
                
                // msj de error
                setError('Todos los campos son requeridos.');
                
                // redirige
                header('Location: index.php?url=pedidos');
                
                //termina el script
                exit();
            }

            // se arma el json
            $pedido_json = json_encode([
                'cliente_id' => $cliente_id,
                'dias_credito' => $dias_Credito,
                'fecha' => $fecha_pedido,
                'estado' => $estado,
                'promocion_id' => $promocion_id,
                'telefono' => $telefono,
                'direccion_entrega' => $direccion,
                'observaciones' => $observaciones,
                'total' => $total,
                'productos' => $productos,
                'cantidades' => $cantidades,
                'precios' => $precios
            ]);
            //print_r($pedido_json);

            try {

                // llama la funcion que maneja las acciones en el modelo
                $resultado = $modelo->manejarAccion('agregar', $pedido_json);

                // valida si exixtes el staus del resultado y si es true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    setSuccess($resultado['msj']);

                    // se almacena para la bitacora
                        $data_bitacora = $resultado['data_bitacora'];

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Pedidos',
                        'accion' => 'Agregar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha agregado el siguiente pedido' . ' ' .
                            'cliente' . ' ' . $cliente_id . ' ' . 
                            'Promocion' . ' ' . $promocion_id . ' ' . 
                            'Productos' . ' ' . $roducto . ' ' . 
                            'Cantidad' . ' ' . $cantidades . ' ' . 
                            'Precio' . ' ' . $precios . ' ' . 
                            'total' . ' ' . $total . ' ' . 
                            'telefono' . ' ' . $telefono . ' ' . 
                            'direccion' . ' ' . $direccion . ' ' . 
                            'observacion' . ' ' . $observaciones . ' ' . 
                            'Fecha' . ' ' . $fecha_pedido . ' ' . 
                            ' ' . 'en el sistema.',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                } else {

                    // msj de error
                    setError($resultado['msj']);

                    // redirige ai esta condicion no se cumple
                    header('Location: index.php?url=pedidos');

                    // termina la ejecucion del script
                    exit();
                }
            } catch (Exception $e) {

                // msj de error dinamico del sistema
                error_log('Error al registrar pedido...' . $e->getMessage());
                
                // msj de error
                setError('Error en operacion.');
            }

        // redirige
        header('Location: index.php?url=pedidos');
        
        // termina el script
        exit();
    }
    
        //redirige
        header("Location: index.php?url=403");
        
        // termina el script
        exit();
 }

    // funcion para modificar datos
    function Actualizar() {

        // se instacia el modelo
        $modelo = new Pedido();//predio
        $permiso = new Permiso();//permiso
        $bitacora = new Bitacora();//bitacora

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Pedidos',
            'permiso' => 'Modificar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);


        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {
            
            // Ejecutar acción permitida           

            // obtiene y sanitiza los valores
            $id = $_POST['id'] ?? '';
            $cliente_id = filter_var($_POST['clienteId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
            $fecha_pedido = filter_var($_POST['fechaPedido'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $estado = filter_var($_POST['estadoPedido'] ?? 'pendiente', FILTER_SANITIZE_SPECIAL_CHARS);
            $telefono = filter_var($_POST['telefonoPedido'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $direccion = filter_var($_POST['direccionPedido'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $observaciones = filter_var($_POST['observacionesPedido'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

            // valida si los campos requeridos no estan vacios
            if (empty($id) || empty($cliente_id) || empty($fecha_pedido) || empty($estado) || empty($telefono) ||empty($direccion) || empty($observaciones)) {
                
                // msj de error
                setError('Todos los campos son requeridos.');
                
                // redirige
                header('Location: index.php?url=pedidos');
                
                //termina el script
                exit();
            }

            // se arma el json
            $pedido_json = json_encode([
                'id' => $id,
                'cliente_id' => $cliente_id,
                'fecha' => $fecha_pedido,
                'estado' => $estado,
                'telefono' => $telefono,
                'direccion_entrega' => $direccion,
                'observaciones' => $observaciones
            ]);
            //print_r($pedido_json);

            try {

                // llama la funcion que maneja las acciones en el modelo
                $resultado = $modelo->manejarAccion('modificar', $pedido_json);

                // valida si exixtes el staus del resultado y si es true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    setSuccess($resultado['msj']);

                    // se almacena para la bitacora
                        $data_bitacora = $resultado['data_bitacora'];

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Pedidos',
                        'accion' => 'Modificar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha modificado el siguiente pedido' . ' ' .
                            'PED-00' . ' ' . $id . ' ' . 
                            'cliente' . ' ' . $cliente_id . ' ' . 
                            'estado' . ' ' . $estado . ' ' . 
                            'telefono' . ' ' . $telefono . ' ' . 
                            'direccion' . ' ' . $direccion . ' ' . 
                            'observacion' . ' ' . $observaciones . ' ' . 
                            'Fecha' . ' ' . $fecha_pedido . ' ' . 
                            ' ' . 'en el sistema.',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);
                
                } 
                else {

                    // mensaje de error
                    setError($resultado['msj']);

                    //redirige
                    header("Location: index.php?url=pedidos");

                    //terina el script
                    exit();

                }
            } catch (Exception $e) {

                // error log
                error_log('Error al actualizar pedido...' . $e->getMessage());

                // mensaje de error generico
                setError('Error en operacion.');
            }

        // redirige
        header('Location: index.php?url=pedidos');
        
        // termina el script
        exit();
    }
    
    //redirige
    header("Location: index.php?url=403");
        
    // termina el script
    exit();
}

    // function para obtener un dato
    function Obtener() {

        // instacia el modelo
        $modelo = new Pedido();
        $bitacora = new Bitacora();//bitacora

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        $id = $_GET['ID'] ?? '';

        header('Content-Type: application/json');

    if (empty($id)) {

            // manda mensaje de error
            setError('Todos los campos son requeridos no se puede enviar vacios.');

            //redirec
            header('Location: index.php?url=pedidos');

            //termina el script
            exit();
        }

    $pedido_json = json_encode(['id' => $id]);

    $resultado = $modelo->manejarAccion('obtener', $pedido_json);

    if (!$resultado['status']) {
        echo json_encode($resultado);
        exit();
    }

    $pedido = $resultado['data'];

        // se almacena para la bitacora
        $data_bitacora = $resultado['data_bitacora'];

        // se arma el json de bitacora
        $bitacora_json = json_encode([
            'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
            'modulo' => 'Pedidos',
            'accion' => 'Obtener',
            'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
            'ha obtenido el siguiente pedido' . ' ' .
            'Codigo' . ' ' . $data_bitacora['id_pedido'] . ' ' . 
            'Nombre' . ' ' . $data_bitacora['tipo_id'] . '-' . $data_bitacora['id_cliente'] . ' ' . $data_bitacora['nombre_cliente'] . ' ' . 
            'Productos' . ' ' . $data_bitacora['productos'] . ' ' . 
            'Cantidad' . ' ' . $data_bitacora['cantidades'] . ' ' . 
            'total' . ' ' . $data_bitacora['monto_total_pedido'] . ' ' . 
            'Fecha' . ' ' . $data_bitacora['fecha_pedido'] . ' ' . 
            ' ' . 'en el sistema.',
        'fecha' => $fecha
        ]);

        //realiza la insercion de la bitacora
        $bitacora->manejarAccion('agregar', $bitacora_json);


        echo json_encode($pedido);  // ← SOLO JSON
 
        exit();
    }

    // funcion para eliminar un dato
    function Eliminar() {

        // se instacia el modelo
        $modelo = new Pedido();//predio
        $permiso = new Permiso();//permiso
        $bitacora = new Bitacora();//bitacora

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Pedidos',
            'permiso' => 'Eliminar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);


        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {

            //accion permitida
            $id = $_GET['ID'] ?? '';

            // valida el is
            if (empty($id)) {

                // msj de error
                setError('ID vacío.');
                
                // redirige
                header('Location: index.php?url=pedidos');
                
                // termina el script
                exit();
            }

            //se ara json
            $pedido_json = json_encode(['id' => $id]);

            try {

                // llama la funcion de modelo
                $resultado = $modelo->manejarAccion('eliminar', $pedido_json);

                // valida si exite y si es true el status
                if (isset($resultado['status']) && $resultado['status'] === true) {

                    // msj de exito
                    setSuccess($resultado['msj']);

                    // se almacena para la bitacora
                        $data_bitacora = $resultado['data_bitacora'];

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Pedidos',
                        'accion' => 'Eliminar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha eliminado el siguiente pedido' . ' ' .
                            'Codigo' . ' ' . $data_bitacora['id_pedido'] . ' ' . 
                            'Nombre' . ' ' . $data_bitacora['tipo_id'] . '-' . $data_bitacora['id_cliente'] . ' ' . $data_bitacora['nombre_cliente'] . ' ' . 
                            'Productos' . ' ' . $data_bitacora['productos'] . ' ' . 
                            'Cantidad' . ' ' . $data_bitacora['cantidades'] . ' ' . 
                            'total' . ' ' . $data_bitacora['monto_total_pedido'] . ' ' . 
                            'Fecha' . ' ' . $data_bitacora['fecha_pedido'] . ' ' . 
                            ' ' . 'en el sistema.',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                } else {

                    //msj de error
                    setError($resultado['msj']);

                }
            } catch (Exception $e) {

                // error log
                error_log('Error al eliminar pedido...' . $e->getMessage());

                //msj generico
                setError('Error en operacion.');
            }

        // redirige
        header('Location: index.php?url=pedidos');
        
        // termina el script
        exit();
    }

    // redirige
    header('Location: index.php?url=403');
        
    // termina el script
    exit();
 }

    // funcion para cambiar estado
    function CambiarEstado() {

        // se instacia el modelo
        $modelo = new Pedido();//predio
        $permiso = new Permiso();//permiso
        $bitacora = new Bitacora();//bitacora

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Pedidos',
            'permiso' => 'Modificar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);


        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {

            //accion permitida

            // obtiene los datos
            $id = $_POST['id'] ?? '';
            $nuevo_estado = $_POST['nuevo_estado'] ?? '';

            // valida los datos
            if (empty($id) || $nuevo_estado === '') {

                //msj de error
                setError('Datos incompletos.');

                //redirige
                header('Location: index.php?url=pedidos');

                //termina el script
                exit();
            }

            // se arma json
            $pedido_json = json_encode([
                'id' => $id,
                'nuevo_estado' => $nuevo_estado
            ]);

            try {

                // llama la funcion del modelo
                $resultado = $modelo->manejarAccion('cambiar_estado', $pedido_json);

                // valida si existe y si es true
                if (isset($resultado['status']) && $resultado['status'] === true) {

                    //msj de exito
                    setSuccess($resultado['msj']);

                    // se almacena para la bitacora
                        $data_bitacora = $resultado['data_bitacora'];

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Pedidos',
                        'accion' => 'Cambiar Estado del Pedido',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha cambiado el estado del siguiente pedido' . ' ' .
                            'Codigo' . ' ' . $data_bitacora['id_pedido'] . ' ' . 
                            'Nombre' . ' ' . $data_bitacora['tipo_id'] . '-' . $data_bitacora['id_cliente'] . ' ' . $data_bitacora['nombre_cliente'] . ' ' . 
                            'Productos' . ' ' . $data_bitacora['productos'] . ' ' . 
                            'Cantidad' . ' ' . $data_bitacora['cantidades'] . ' ' . 
                            'total' . ' ' . $data_bitacora['monto_total_pedido'] . ' ' . 
                            'Fecha' . ' ' . $data_bitacora['fecha_pedido'] . ' ' . 
                            ' ' . 'en el sistema.',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                } else {

                    // msj de error
                    setError($resultado['msj']);

                }
            } catch (Exception $e) {

                // msj log
                error_log('Error al cambiar estado del pedido...' . $e->getMessage());

                // msj generico
                setError('Error en operacion.');
            }

        // redirige
        header('Location: index.php?url=pedidos');
        
        // termina el script
        exit();
    }
    
    // msj generico
    setError('No tiene permiso para la accion.');

    // redirige
    header('Location: index.php?url=pedidos');
        
    // termina el script
    exit();
 }

?>
