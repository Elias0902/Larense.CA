<?php
    // llama el archivo del modelo
    require_once 'app/models/CompraModel.php';
    require_once 'app/models/ProveedorModel.php';
    require_once 'app/models/MateriaPrimaModel.php';
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

        case 'obtenerMateriaProveedor':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                ObtenerMateriaProveedor();
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

        // se instacia el modelo
        $modelo = new Compra();//compra
        $proveedor = new Proveedor(); //proveedor
        $materiaPrima = new MateriaPrima();//promocion
        $permiso = new Permiso();//permiso
        $bitacora = new Bitacora();//bitacora

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Compras',
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

                    // Obtener compras
                    $compras = $resultado['data'];

                    // Obtener proveedores para el select
                    $prov = $proveedores = $proveedor->manejarAccion('consultar', null)['data'];

                    // Obtener matrias primas para el select
                    $materia = $materiasPrimas = $materiaPrima->manejarAccion('consultar', null)['data'];

                    // Obtener estado de compra para el select
                    $estadoCompra = $modelo->manejarAccion('consultar_estado', null)['data'];

                    // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Compras',
                        'accion' => 'Consultar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha Consultado los datos en el dashboard de compras en el sistema',
                            'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                    //carga la vista
                    require_once 'app/views/comprasView.php';
                    
                    // termina el script
                    exit();
                }    
                else {
                            
                // usa mensaje dinamico del modelo
                //setError($resultado['msj']);

                // Obtener pedidos
                //$compras = $resultado['data'];

                // Obtener clientes para el select
                $prov = $proveedores = $proveedor->manejarAccion('consultar', null)['data'];

                // Obtener promociones activas para el select
                $materiasPrimas = $materiaPrima->manejarAccion('consultar', null)['data'];

                // Obtener estado de compra para el select
                $estadoCompra = $modelo->manejarAccion('consultar_estado', null)['data'];

                //carga la vista
                require_once 'app/views/comprasView.php';

                // termina el script
                exit();
                }
            } catch (Exception $e) {

                // msj de error dinamico
                error_log('Error al consultar pedidos...' . $e->getMessage());
                    
                // msj de error
                setError('Error en operacion.');

                //carga a vista 
                require_once 'app/views/comprasView.php';
                    
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
        $modelo = new Compra();//compra
        $permiso = new Permiso();//permiso
        $bitacora = new Bitacora();//bitacora

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Compras',
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
            $proveedor_id = filter_var($_POST['proveedorId'] ?? '', FILTER_SANITIZE_NUMBER_INT);
            $dias_credito = filter_var($_POST['diasCredito'] ?? '', FILTER_SANITIZE_NUMBER_INT);
            $fecha_compra = filter_var($_POST['fechaCompra'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $estado = filter_var($_POST['estadoCompra'] ?? 'pendiente', FILTER_SANITIZE_SPECIAL_CHARS);
            $observaciones = filter_var($_POST['observacionesCompra'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $total = filter_var($_POST['totalCompra'] ?? '', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);

            // obtiene los arry de productos seleccionados
            $materiasPrimas = $_POST['materiasPrimas'] ?? [];
            $cantidades = $_POST['cantidades'] ?? [];
            $precios = $_POST['precios'] ?? [];

            // valida si los campos requeridos no estan vacios
            if (empty($proveedor_id) || empty($dias_credito) || empty($fecha_compra) || empty($estado) || empty($observaciones) || empty($total) || empty($materiasPrimas) || empty($cantidades) || empty($precios)) {
                
                // msj de error
                setError('Todos los campos son requeridos.');
                
                // redirige
                header('Location: index.php?url=compras');
                
                //termina el script
                exit();
            }

            // se arma el json
            $compra_json = json_encode([
                'proveedor_id' => $proveedor_id,
                'dias_credito' => $dias_credito,
                'fecha' => $fecha_compra,
                'estado' => $estado,
                'observaciones' => $observaciones,
                'total' => $total,
                'materiasPrimas' => $materiasPrimas,
                'cantidades' => $cantidades,
                'precios' => $precios
            ]);
            //print_r($compra_json);

            try {

                // llama la funcion que maneja las acciones en el modelo
                $resultado = $modelo->manejarAccion('agregar', $compra_json);

                // valida si exixtes el staus del resultado y si es true
                if (isset($resultado['status']) && $resultado['status'] === true) {
                    setSuccess($resultado['msj']);

                    // se almacena para la bitacora
                        $data_bitacora = $resultado['data_bitacora'];

                        // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Compras',
                        'accion' => 'Agregar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha agregado la siguiente Compra' . ' ' .
                            'proveedor' . ' ' . $proveedor_id . ' ' . 
                            'Materia Prima' . ' ' . $materiasPrimas . ' ' . 
                            'Cantidad' . ' ' . $cantidades . ' ' . 
                            'Precio' . ' ' . $precios . ' ' . 
                            'total' . ' ' . $total . ' ' . 
                            'observacion' . ' ' . $observaciones . ' ' . 
                            'Fecha' . ' ' . $fecha_compra . ' ' . 
                            ' ' . 'en el sistema.',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                } else {

                    // msj de error
                    setError($resultado['msj']);

                    // redirige ai esta condicion no se cumple
                    header('Location: index.php?url=compras');

                    // termina la ejecucion del script
                    exit();
                }
            } catch (Exception $e) {

                // msj de error dinamico del sistema
                error_log('Error al registrar compra...' . $e->getMessage());
                
                // msj de error
                setError('Error en operacion.');
            }

        // redirige
        header('Location: index.php?url=compras');
        
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
        $modelo = new Compra();
        $bitacora = new Bitacora();//bitacora

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        $id = $_GET['ID'] ?? '';

        header('Content-Type: application/json');

    if (empty($id)) {

            // manda mensaje de error
            setError('Todos los campos son requeridos no se puede enviar vacios.');

            //redirec
            header('Location: index.php?url=compras');

            //termina el script
            exit();
        }

    $compra_json = json_encode(['id' => $id]);

    $resultado = $modelo->manejarAccion('obtener', $compra_json);

    if (!$resultado['status']) {
        echo json_encode($resultado);
        exit();
    }

    $compra = $resultado['data'];

        // se almacena para la bitacora
        $data_bitacora = $resultado['data_bitacora'];

        // se arma el json de bitacora
        $bitacora_json = json_encode([
            'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
            'modulo' => 'Compras',
            'accion' => 'Obtener',
            'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
            'ha obtenido el siguiente pedido' . ' ' .
            'Codigo' . ' ' . $data_bitacora['id_compra'] . ' ' . 
            'Nombre' . ' ' . $data_bitacora['tipo_id'] . '-' . $data_bitacora['id_proveedor'] . ' ' . $data_bitacora['nombre_proveedor'] . ' ' . 
            'Materia Prima' . ' ' . $data_bitacora['materiaPrima'] . ' ' . 
            'Cantidad' . ' ' . $data_bitacora['cantidades'] . ' ' . 
            'total' . ' ' . $data_bitacora['monto_total_compra'] . ' ' . 
            'Fecha' . ' ' . $data_bitacora['fecha_compra'] . ' ' . 
            ' ' . 'en el sistema.',
        'fecha' => $fecha
        ]);

        //realiza la insercion de la bitacora
        $bitacora->manejarAccion('agregar', $bitacora_json);


        echo json_encode($compra);  // ← SOLO JSON
 
        exit();
    }

     // function para obtener un dato
    function ObtenerMateriaProveedor() {

        // instacia el modelo
        $modelo = new Compra();
        $bitacora = new Bitacora();//bitacora

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        $id = $_GET['ID'] ?? '';

        header('Content-Type: application/json');

    if (empty($id)) {

            // manda mensaje de error
            setError('Todos los campos son requeridos no se puede enviar vacios.');

            //redirec
            header('Location: index.php?url=compras');

            //termina el script
            exit();
        }

    $compra_json = json_encode(['id' => $id]);

    $resultado = $modelo->manejarAccion('obtenerMateria', $compra_json);

    if (!$resultado['status']) {
        echo json_encode($resultado);
        exit();
    }

    $materia = $resultado['data'];

    echo json_encode($materia);  // ← SOLO JSON
 
    exit();
}

    // funcion para eliminar un dato
    function Eliminar() {

        // se instacia el modelo
        $modelo = new Compra();//predio
        $permiso = new Permiso();//permiso
        $bitacora = new Bitacora();//bitacora

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Compras',
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
                header('Location: index.php?url=compras');
                
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
                        'modulo' => 'Compras',
                        'accion' => 'Eliminar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha eliminado la siguiente compra' . ' ' .
                            'Codigo' . ' ' . $data_bitacora['id_compra'] . ' ' . 
                            'Nombre' . ' ' . $data_bitacora['tipo_id'] . '-' . $data_bitacora['id_proveedor'] . ' ' . $data_bitacora['nombre_proveedor'] . ' ' . 
                            'Mayerias Primas' . ' ' . $data_bitacora['materiaPrima'] . ' ' . 
                            'Cantidad' . ' ' . $data_bitacora['cantidades'] . ' ' . 
                            'total' . ' ' . $data_bitacora['monto_total_compra'] . ' ' . 
                            'Fecha' . ' ' . $data_bitacora['fecha_compra'] . ' ' . 
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
                error_log('Error al eliminar Compra...' . $e->getMessage());

                //msj generico
                setError('Error en operacion.');
            }

        // redirige
        header('Location: index.php?url=compras');
        
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
