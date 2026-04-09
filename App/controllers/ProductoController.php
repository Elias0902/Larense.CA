<?php
    // llama el archivo del modelo
    require_once 'app/models/ProductoModel.php';
    require_once 'app/models/CategoriaModel.php';
    require_once 'app/models/PermisoModel.php';
    //require_once 'app/models/BitacoraModel.php';

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
        $modelo = new Producto();
        $categoria = new Categoria();
        /*$permiso = new Permiso();
        //$bitacora = new Bitacora();

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Productos',
            'permiso' => 'Consultar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);


        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] == 1) {
            
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
                    $productos = $resultado['data'];

                    // extrae los datos de las categorias
                    $cat = $categorias = $categoria->manejarAccion('consultar', null)['data'];

                    //carga la vista
                    require_once 'app/views/dashboard_productos.php';

                    // termina el script
                    exit();
                }
                else {
                                
                    // usa mensaje dinamico del modelo
                    setError($resultado['msj']);

                    //carga la vista
                    require_once 'app/views/dashboard_productos.php';

                    // termina el script
                    //exit();
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
    //setError("Error acceso no permitido");

    //redirect
    //require_once 'app/views/dashboard_productos.php';
                
    // termina el script
    //exit();
    
//}

    //funcion para guardar datos
    function Agregar() {

        // instacia el modelo
        $modelo = new Producto();
        /*$permiso = new Permiso();
        //$bitacora = new Bitacora();

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Productos',
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
            $nombre_producto = filter_var($_POST['nombreProducto'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $categoria_producto = filter_var($_POST['nombreCategoria'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $precio_producto = filter_var($_POST['precioProducto'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $stock_producto = filter_var($_POST['stockProducto'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $fecha_registro_producto = filter_var($_POST['fechaRegistroProducto'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $fecha_vencimiento_producto = filter_var($_POST['fechaVencimientoProducto'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $imagen_producto = $_FILES['imagenProducto'] ?? null;

            // Validación de la imagen
            if (isset($_FILES['imagenProducto']) && $_FILES['imagenProducto']['error'] == 0) {
                $imagen = $_FILES['imagenProducto'];

                // Validación del tipo de archivo
                $tipoArchivo = pathinfo($imagen['name'], PATHINFO_EXTENSION);
                $tiposPermitidos = array('jpg', 'jpeg', 'png', 'gif');

                // Verificar el tipo de archivo
                if (!in_array(strtolower($tipoArchivo), $tiposPermitidos)) {

                    //manda mensaje de error
                    setError("Sólo se permiten archivos de tipo JPG, JPEG, PNG y GIF.");
                    
                    //redirec   
                    header("Location: index.php?url=productos");
                    
                    //termina el script
                    exit();
                }           

            // Subir la imagen al directorio destino
            $directorioSubida = 'assets/img/productos/';
        
            // Verificar si el directorio de subida existe, si no, crearlo
            if (!empty($imagen['name'])) {
                $nombreArchivo = basename($imagen['name']);
                $rutaSubida = $directorioSubida . $nombreArchivo;
        
                // Mover el archivo subido al directorio de destino
                if (move_uploaded_file($imagen['tmp_name'], $rutaSubida)) {
                    
                    // La imagen se ha subido correctamente
                    // Guarda el nombre de la imagen para usarlo en la base de datos
                    $imagen_producto = $rutaSubida; 

                } else {

                    // Error al subir la imagen
                    setError("Error al subir la imagen.");

                    //redirec
                    header("Location: index.php?url=productos");

                    //termina el script
                    exit();
                }
            } 
            } 
            else{

                // Si no se sube imagen, deja este campo vacío
                $imagen_producto = ''; 
            }

            // valida si los campos no estan vacios
            if (empty($nombre_producto) || empty($categoria_producto) || empty($precio_producto) || empty($stock_producto) || empty($fecha_registro_producto) || empty($fecha_vencimiento_producto) || empty($imagen_producto)) {

                // manda mensaje de error
                setError('Todos los campos son requeridos no se puede enviar vacios.');

                //redirec
                header('Location: index.php?url=productos');

                //termina el script
                exit();
            }
            

            // se arma el josn
            $producto_json = json_encode([
                'nombre' => $nombre_producto,
                'categoria' => $categoria_producto,
                'precio' => $precio_producto,
                'stock' => $stock_producto,
                'fecha_registro' => $fecha_registro_producto,
                'fecha_vencimiento' => $fecha_vencimiento_producto,
                'imagen' => $imagen_producto
            ]);
            //print_r($producto_json);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('agregar', $producto_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        // se arma json de bitacora
                        /*$bitacora_json = json_encode([
                            'usuario_id' => $_SESSION['s_usuario']['usuario_id'],
                            'modulo' => 'Productos',
                            'titulos' => 'Registro de Productos',
                            'descripcion' => 'El usuario: ' . $_SESSION['s_usuario']['usuario_nombre'] . ', realizo 
                                                un registro del siguiente producto: ' . $proucto_json['nombre'] . ', en 
                                                el modulo de productos.',
                            'fecha' => date('Y-m-d H:i:s')
                        ]);

                        // realiza la insercion de la bitacora
                        $bitacora->manejarAccion('agregar', $bitacora_json);*/
                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=productos');

                    }
                }
                catch (Exception $e) {

                    //mensaje del exception de pdo
                    error_log('Error al registrar...' . $e->getMessage());
                    
                    // carga la alerta
                    setError('Error en operacion.');
                }

            //redirect
            header('Location: index.php?url=productos');
            
            // termina el script
            exit();
        }

    //muestra un modal de info que dice acceso no permitido
    //setError("Error accion no permitida");

    //redirect
    //header('Location: index.php?url=productoss');
            
    // termina el script
    //exit();
        
    //}

    //funcion para modificar datos
    function Actualizar() {

         // instacia el modelo
        $modelo = new Producto();
        /*$permiso = new Permiso();
        //$bitacora = new Bitacora();

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Productos',
            'permiso' => 'Modificar',
            'rol' => $_SESSION['s_usuario']['usuario_rol_id']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] == 1) {
            
            // Ejecutar acción permitida*/

            // obtiene y sinatiza los valores
            $id = $_POST['idEdit'];
            $nombre_producto = filter_var($_POST['nombreProductoEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $categoria_producto = filter_var($_POST['nombreCategoriaEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $precio_producto = filter_var($_POST['precioProductoEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $stock_producto = filter_var($_POST['stockProductoEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $fecha_registro_producto = filter_var($_POST['fechaRegistroProductoEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);
            $fecha_vencimiento_producto = filter_var($_POST['fechaVencimientoProductoEdit'] ?? '', FILTER_SANITIZE_SPECIAL_CHARS);

            // valida si los campos no estan vacios
            if (empty($nombre_producto) || empty($id) || empty($categoria_producto) || empty($precio_producto) || empty($stock_producto) || empty($fecha_registro_producto) || empty($fecha_vencimiento_producto)) {

                // manda mensaje de error
                setError('Todos los campos son requeridos no se puede enviar vacios.');

                //redirec
                header('Location: index.php?url=productos');

                //termina el script
                exit();
            }

            // se arma el josn
            $producto_json = json_encode([
                'id' => $id,
                'nombre' => $nombre_producto,
                'categoria' => $categoria_producto,
                'precio' => $precio_producto,
                'stock' => $stock_producto,
                'fecha_registro' => $fecha_registro_producto,
                'fecha_vencimiento' => $fecha_vencimiento_producto
            ]);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('modificar', $producto_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);

                        // se arma json de bitacora
                        /*$bitacora_json = json_encode([
                            'usuario_id' => $_SESSION['s_usuario']['usuario_id'],
                            'modulo' => 'Productos',
                            'titulos' => 'Registro de Producto',
                            'descripcion' => 'El usuario: ' . $_SESSION['s_usuario']['usuario_nombre'] . ', realizo 
                                                un registro del siguiente producto: ' . $producto_json['nombre'] . ', en 
                                                el modulo de productos.',
                            'fecha' => date('Y-m-d H:i:s')
                        ]);

                        // realiza la insercion de la bitacora
                        $bitacora->manejarAccion('agregar', $bitacora_json);*/
                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=productos');

                    }
                }
                catch (Exception $e) {

                    //mensaje del exception de pdo
                    error_log('Error al registrar...' . $e->getMessage());
                    
                    // carga la alerta
                    setError('Error en operacion.');
                }

            //redirect
            header('Location: index.php?url=productos');
            
            // termina el script
            exit();
        }

    //muestra un modal de info que dice acceso no permitido
    //setError("Error accion no permitida");

    //redirect
    //header('Location: index.php?url=productos');
            
    // termina el script
    //exit();

    //}

    // function para obtener un dato
    function Obtener() {

        // instacia el modelo
        $modelo = new Producto();

        $id = $_GET['ID'];

         // valida si los campos no estan vacios
        if (empty($id)) {

            // manda mensaje de error
            setError('Todos los campos son requeridos no se puede enviar vacios.');

            //redirec
            header('Location: index.php?url=productos');

            //termina el script
            exit();
        }

            // se arma el josn
            $producto_json = json_encode([
                'id' => $id
            ]);

            $resultado = $modelo->manejarAccion('obtener', $producto_json);

            $producto = $resultado['data'];

            echo json_encode($producto);

            exit();
    }

    // funcion para eliminar un dato
    function Eliminar() {

         // instacia el modelo
        $modelo = new Producto();
        /*$permiso = new Permiso();
        //$bitacora = new Bitacora();

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Productos',
            'permiso' => 'Eliminar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);

        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] == 1) {
            
            // Ejecutar acción permitida*/

            // obtiene y sinatiza los valores
            $id_producto = $_GET['ID'];

            // valida si los campos no estan vacios
            if (empty($id_producto)) {

                // manda mensaje de error
                setError('ID vacio.');

                //redirec
                header('Location: index.php?url=productos');

                //termina el script
                exit();
            }

            // se arma el josn
            $producto_json = json_encode([
                'id' => $id_producto
            ]);

                // para manejo de errores
                try {

                    // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                    // primer para metro la accion y luego el objeto usuario_json
                    $resultado = $modelo->manejarAccion('eliminar', $producto_json);

                    // valida si exixtes el staus del resultado y si es true 
                    if (isset($resultado['status']) && $resultado['status'] === true) {

                        // usa mensaje dinamico del modelo
                        setSuccess($resultado['msj']);
                    }
                    else {
                                    
                        // usa mensaje dinamico del modelo
                        setError($resultado['msj']);

                        //redirect
                        header('Location: index.php?url=prdouctos');

                    }
                }
                catch (Exception $e) {

                    //mensaje del exception de pdo
                    error_log('Error al registrar...' . $e->getMessage());
                    
                    // carga la alerta
                    setError('Error en operacion.');
                }

        //redirect
        header('Location: index.php?url=productos');

        // termina el script
        exit();

    }

    //muestra un modal de info que dice acceso no permitido
    //setError("Error accion no permitida");

    //redirect
    //header('Location: index.php?url=productos');
            
    // termina el script
    //exit();    
    
//}
?>