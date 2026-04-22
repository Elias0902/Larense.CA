<?php
// llama el archivo del modelo
require_once 'app/models/ProductoModel.php';
require_once 'app/models/CategoriaModel.php';
require_once 'app/models/PedidoModel.php';

// llama el archivo que contiene la carga de alerta
require_once 'components/utils.php';

// se almacena la action o la peticion http 
$action = isset($_GET['action']) ? $_GET['action'] : '';

// indiferentemente sea la action el switch llama la funcion correspondiente
switch($action) {

    case 'filtrar':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            FiltrarPorCategoria();
        }
        break;

    case 'usuarioIndex':
        UsuarioMarketplace();
        break;

    case 'getCredito':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            GetCreditoUsuario();
        }
        break;

    case 'misPedidos':
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            GetMisPedidos();
        }
        break;

    case 'realizarPedido':
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            RealizarPedido();
        }
        break;

    default:
        ConsultarMarketplace();
        break;
}

// funcion para consultar datos del marketplace (admin)
function ConsultarMarketplace() {
   
    // instacia el modelo
    $modelo = new Producto();
    $categoria = new Categoria();

    // para manejo de errores
    try {

        // llama la funcion que maneja las acciones en el modelo
        $resultado = $modelo->manejarAccion('consultar', null);

        // valida si existe el status del resultado y si es true 
        if (isset($resultado['status']) && $resultado['status'] === true) {

            // extrae los datos de los productos
            $productos = $resultado['data'];

            // extrae los datos de las categorias
            $categorias = $categoria->manejarAccion('consultar', null)['data'];

            // carga la vista del marketplace
            require_once 'app/views/ecommerceView.php';

            // termina el script
            exit();
        }
        else {
            // usa mensaje dinamico del modelo
            setError($resultado['msj']);

            // carga la vista con array vacio
            $productos = [];
            $categorias = [];
            require_once 'app/views/ecommerceView.php';

            // termina el script
            exit();
        }
    }
    catch (Exception $e) {

        //mensaje del exception de pdo
        error_log('Error al consultar marketplace...' . $e->getMessage());
        
        // carga la alerta
        setError('Error en operacion.');

        //termina el script
        exit();
    }
}

// funcion para filtrar productos por categoria (admin)
function FiltrarPorCategoria() {
   
    // instacia el modelo
    $modelo = new Producto();
    $categoria = new Categoria();

    // obtiene el id de categoria
    $categoria_id = isset($_GET['categoria']) ? $_GET['categoria'] : '';

    // para manejo de errores
    try {

        // llama la funcion que maneja las acciones en el modelo
        $resultado = $modelo->manejarAccion('consultar', null);

        // extrae los datos de las categorias
        $categorias = $categoria->manejarAccion('consultar', null)['data'];

        // valida si existe el status del resultado y si es true 
        if (isset($resultado['status']) && $resultado['status'] === true) {

            // extrae los datos de los productos
            $todos_productos = $resultado['data'];

            // filtra productos por categoria si se especifico
            if ($categoria_id !== '' && $categoria_id !== 'todas') {
                $productos = array_filter($todos_productos, function($prod) use ($categoria_id) {
                    return $prod['id_categoria'] == $categoria_id;
                });
            } else {
                $productos = $todos_productos;
            }

            // carga la vista del marketplace
            require_once 'app/views/ecommerceView.php';

            // termina el script
            exit();
        }
        else {
            // usa mensaje dinamico del modelo
            setError($resultado['msj']);

            // carga la vista con array vacio
            $productos = [];
            require_once 'app/views/ecommerceView.php';

            // termina el script
            exit();
        }
    }
    catch (Exception $e) {

        //mensaje del exception de pdo
        error_log('Error al filtrar marketplace...' . $e->getMessage());
        
        // carga la alerta
        setError('Error en operacion.');

        //termina el script
        exit();
    }
}

// ==============================================
// NUEVAS FUNCIONES PARA EL ROL USUARIO
// ==============================================

// funcion para el marketplace del usuario (con crédito)
function UsuarioMarketplace() {
    
    // Verificar que el usuario tenga rol Usuario (id_rol = 3)
    session_start();
    if(!isset($_SESSION['id_rol']) || $_SESSION['id_rol'] != 3) {
        header('Location: index.php?url=dashboard');
        exit;
    }
    
    // instancia los modelos
    $productoModel = new Producto();
    $categoriaModel = new Categoria();
    $creditoModel = new Credito();

    try {
        // Obtener productos activos con stock > 0
        $resultadoProductos = $productoModel->manejarAccion('consultarActivos', null);
        
        // Obtener categorías activas
        $categorias = $categoriaModel->manejarAccion('consultarActivas', null)['data'];
        
        // Obtener crédito del usuario
        $idUsuario = $_SESSION['id_usuario'];
        $credito = $creditoModel->obtenerCreditoPorUsuario($idUsuario);
        
        // Preparar datos para la vista
        $productos = [];
        if (isset($resultadoProductos['status']) && $resultadoProductos['status'] === true) {
            // Filtrar solo productos con stock > 0 y activos
            $todosProductos = $resultadoProductos['data'];
            foreach($todosProductos as $prod) {
                if($prod['stock'] > 0 && $prod['status'] == 1) {
                    $productos[] = $prod;
                }
            }
        }
        
        $data = [
            'productos' => $productos,
            'categorias' => $categorias,
            'creditoLimite' => $credito['limite'] ?? 500,
            'creditoUtilizado' => $credito['utilizado'] ?? 0,
            'creditoDisponible' => ($credito['limite'] ?? 500) - ($credito['utilizado'] ?? 0)
        ];
        
        // Cargar la vista específica para usuario
        require_once 'app/views/ecommerce_usuario.php';
        exit();
        
    } catch (Exception $e) {
        error_log('Error en UsuarioMarketplace: ' . $e->getMessage());
        setError('Error al cargar el marketplace');
        header('Location: index.php?url=dashboard');
        exit();
    }
}

// funcion para obtener crédito del usuario (AJAX)
function GetCreditoUsuario() {
    header('Content-Type: application/json');
    session_start();
    
    if(!isset($_SESSION['id_usuario'])) {
        echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
        exit;
    }
    
    $creditoModel = new Credito();
    $idUsuario = $_SESSION['id_usuario'];
    
    try {
        $credito = $creditoModel->obtenerCreditoPorUsuario($idUsuario);
        
        $creditoInfo = [
            'limite' => floatval($credito['limite'] ?? 500),
            'utilizado' => floatval($credito['utilizado'] ?? 0),
            'disponible' => floatval(($credito['limite'] ?? 500) - ($credito['utilizado'] ?? 0))
        ];
        
        echo json_encode(['success' => true, 'credito' => $creditoInfo]);
        
    } catch (Exception $e) {
        error_log('Error en GetCreditoUsuario: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error al obtener crédito']);
    }
    exit;
}

// funcion para obtener pedidos del usuario (AJAX)
function GetMisPedidos() {
    header('Content-Type: application/json');
    session_start();
    
    if(!isset($_SESSION['id_usuario'])) {
        echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
        exit;
    }
    
    $pedidoModel = new Pedido();
    $idUsuario = $_SESSION['id_usuario'];
    
    try {
        $pedidos = $pedidoModel->obtenerPedidosPorUsuario($idUsuario);
        
        // Mapear estados para colores
        $estadosColores = [
            'Pendiente' => '#f59e0b',
            'Procesando' => '#3b82f6',
            'Enviado' => '#8b5cf6',
            'Entregado' => '#10b981',
            'Cancelado' => '#ef4444'
        ];
        
        foreach($pedidos as &$pedido) {
            $pedido['estado_color'] = $estadosColores[$pedido['estado']] ?? '#6b7280';
            
            // Obtener detalles del pedido
            $detalles = $pedidoModel->obtenerDetallesPedido($pedido['id_pedido']);
            $detallesText = '';
            foreach($detalles as $detalle) {
                $detallesText .= "{$detalle['cantidad']}x {$detalle['nombre_producto']}\n";
            }
            $pedido['detalles'] = nl2br($detallesText);
        }
        
        echo json_encode(['success' => true, 'pedidos' => $pedidos]);
        
    } catch (Exception $e) {
        error_log('Error en GetMisPedidos: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error al obtener pedidos', 'pedidos' => []]);
    }
    exit;
}

// funcion para realizar un pedido (AJAX)
function RealizarPedido() {
    header('Content-Type: application/json');
    session_start();
    
    if(!isset($_SESSION['id_usuario'])) {
        echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
        exit;
    }
    
    // Obtener datos del POST
    $data = json_decode(file_get_contents('php://input'), true);
    
    if(!$data || !isset($data['productos']) || empty($data['productos'])) {
        echo json_encode(['success' => false, 'message' => 'No hay productos en el pedido']);
        exit;
    }
    
    $idUsuario = $_SESSION['id_usuario'];
    $productos = $data['productos'];
    $total = floatval($data['total']);
    $metodoPago = $data['metodo_pago'];
    $direccion = trim($data['direccion']);
    $notas = trim($data['notas'] ?? '');
    $referencia = trim($data['referencia'] ?? '');
    
    // Validaciones
    if(empty($direccion)) {
        echo json_encode(['success' => false, 'message' => 'La dirección de entrega es requerida']);
        exit;
    }
    
    if($metodoPago === 'transferencia' && empty($referencia)) {
        echo json_encode(['success' => false, 'message' => 'El número de referencia es requerido para transferencias']);
        exit;
    }
    
    // Verificar crédito si paga con crédito
    if($metodoPago === 'credito') {
        $creditoModel = new Credito();
        $credito = $creditoModel->obtenerCreditoPorUsuario($idUsuario);
        $disponible = ($credito['limite'] ?? 500) - ($credito['utilizado'] ?? 0);
        
        if($total > $disponible) {
            echo json_encode(['success' => false, 'message' => 'Crédito insuficiente para realizar esta compra']);
            exit;
        }
    }
    
    // Verificar stock de productos
    $productoModel = new Producto();
    foreach($productos as $producto) {
        $stockActual = $productoModel->obtenerStock($producto['id']);
        if($stockActual < $producto['cantidad']) {
            echo json_encode(['success' => false, 'message' => "Stock insuficiente para {$producto['nombre']}"]);
            exit;
        }
    }
    
    $pedidoModel = new Pedido();
    
    try {
        // Iniciar transacción
        $pedidoModel->iniciarTransaccion();
        
        // Determinar estado de pago
        $idEstadoPago = ($metodoPago === 'credito') ? 2 : 1; // 2 = Pagado, 1 = Pendiente
        
        // Crear el pedido
        $pedidoData = [
            'id_usuario' => $idUsuario,
            'monto_total' => $total,
            'direccion_entrega' => $direccion,
            'notas' => $notas,
            'metodo_pago' => $metodoPago,
            'referencia' => $referencia,
            'id_estado_pedido' => 1, // 1 = Pendiente
            'id_estado_pago' => $idEstadoPago
        ];
        
        $pedidoId = $pedidoModel->crearPedido($pedidoData);
        
        if(!$pedidoId) {
            throw new Exception('Error al crear el pedido');
        }
        
        // Agregar detalles del pedido y actualizar stock
        foreach($productos as $producto) {
            $detalleData = [
                'id_pedido' => $pedidoId,
                'id_producto' => $producto['id'],
                'cantidad' => $producto['cantidad'],
                'precio_unitario' => $producto['precio']
            ];
            $pedidoModel->agregarDetallePedido($detalleData);
            
            // Actualizar stock
            $productoModel->actualizarStock($producto['id'], $producto['cantidad']);
        }
        
        // Si paga con crédito, actualizar crédito utilizado
        if($metodoPago === 'credito') {
            $creditoModel = new Credito();
            $creditoModel->actualizarCreditoUtilizado($idUsuario, $total);
        }
        
        // Confirmar transacción
        $pedidoModel->confirmarTransaccion();
        
        // Obtener nuevo crédito disponible
        $creditoModel = new Credito();
        $credito = $creditoModel->obtenerCreditoPorUsuario($idUsuario);
        $nuevoCredito = [
            'limite' => floatval($credito['limite'] ?? 500),
            'utilizado' => floatval($credito['utilizado'] ?? 0),
            'disponible' => floatval(($credito['limite'] ?? 500) - ($credito['utilizado'] ?? 0))
        ];
        
        echo json_encode([
            'success' => true,
            'message' => 'Pedido realizado con éxito',
            'pedido_id' => $pedidoId,
            'nuevoCredito' => $nuevoCredito
        ]);
        
    } catch (Exception $e) {
        $pedidoModel->revertirTransaccion();
        error_log('Error en RealizarPedido: ' . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Error al procesar el pedido: ' . $e->getMessage()]);
    }
    exit;
}
?>