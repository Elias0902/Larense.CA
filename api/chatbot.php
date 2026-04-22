<?php
/**
 * API Endpoint para Natys Asistente
 * Recibe mensajes del frontend y los procesa vía n8n o directamente con Python
 * Filtros de seguridad: NO revela contraseñas, claves, datos sensibles de usuarios
 * Comportamiento proactivo: informa sin necesidad de búsqueda manual
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Manejar preflight request
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Solo aceptar POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Método no permitido'
    ]);
    exit;
}

// Obtener datos del request
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['message'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Mensaje requerido'
    ]);
    exit;
}

$message = trim($input['message']);
$session_id = $input['session_id'] ?? 'default_session';

// Validar mensaje
if (empty($message)) {
    echo json_encode([
        'success' => false,
        'error' => 'El mensaje no puede estar vacio'
    ]);
    exit;
}

// === FILTRO DE SEGURIDAD: Detectar consultas sobre datos sensibles ===
$sensitive_keywords = [
    'contrasena', 'contraseña', 'password', 'clave', 'login', 'credencial',
    'acceso', 'token', 'hash', 'encriptado', 'encriptada', 'secreto',
    'correo completo', 'email completo', 'telefono completo', 'direccion exacta',
    'cedula', 'rif completo', 'documento de identidad', 'datos personales',
    'informacion privada', 'informacion confidencial', 'seguridad interna',
    'base de datos usuarios', 'listado de usuarios', 'todos los usuarios',
    'administrador clave', 'root password', 'sql', 'inyeccion', 'injection',
    'hackear', 'hack', 'explotar', 'bypass', 'omitir seguridad'
];

$message_lower = strtolower($message);
foreach ($sensitive_keywords as $keyword) {
    if (strpos($message_lower, $keyword) !== false) {
        echo json_encode([
            'success' => true,
            'response' => '🔒 <b>Informacion Protegida</b><br><br>Como Natys Asistente, no puedo proporcionar datos sensibles del sistema como contraseñas, claves de acceso, o informacion privada de usuarios.<br><br>Puedo ayudarte con consultas generales sobre:<br>• Productos y disponibilidad<br>• Estadisticas de ventas<br>• Informacion de clientes (sin datos personales)<br>• Stock e inventario<br><br>Si necesitas acceso a datos protegidos, contacta al administrador del sistema. 📧',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
        exit;
    }
}

// Configuración
$n8n_webhook_url = 'http://localhost:5678/webhook/chatbot-larence'; // Ajustar según tu n8n
$use_n8n = false; // Cambiar a true cuando configures n8n

try {
    if ($use_n8n && !empty($n8n_webhook_url)) {
        // Enviar a n8n
        $response = sendToN8n($message, $session_id, $n8n_webhook_url);
    } else {
        // Procesar localmente con PHP (fallback)
        $response = processLocally($message, $session_id);
    }
    
    echo json_encode([
        'success' => true,
        'response' => $response,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Error interno: ' . $e->getMessage()
    ]);
}

/**
 * Enviar mensaje a n8n webhook
 */
function sendToN8n($message, $session_id, $webhook_url) {
    $data = [
        'message' => $message,
        'session_id' => $session_id,
        'timestamp' => date('Y-m-d H:i:s'),
        'user_info' => getUserInfo()
    ];
    
    $ch = curl_init($webhook_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json'
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($http_code === 200 && $response) {
        $decoded = json_decode($response, true);
        return $decoded['response'] ?? $decoded['message'] ?? $response;
    }
    
    throw new Exception('Error en comunicación con n8n');
}

/**
 * Procesar mensaje localmente (fallback sin n8n)
 */
function processLocally($message, $session_id) {
    $message_lower = strtolower($message);
    
    // Respuestas básicas integradas (fallback)
    $responses = [
        'hola' => '¡Hola! Soy Natys Asistente 👋 Estoy aqui para mantenerte informado sobre todo el sistema. Preguntame lo que necesites.',
        'hi' => '¡Hola! 👋 ¿En qué puedo ayudarte?',
        'buenos dias' => '¡Buenos días! ☀️ ¿Qué necesitas consultar?',
        'buenas tardes' => '¡Buenas tardes! 🌤️ ¿En qué te ayudo?',
        'buenas noches' => '¡Buenas noches! 🌙 ¿Necesitas algo?',
        'ayuda' => 'Puedo ayudarte con:<br>📦 Consultar productos y stock<br>📊 Ver estadísticas de ventas<br>🍪 Galletas más vendidas<br>👥 Información de clientes<br><br>¿Qué te gustaría saber?',
        'help' => 'Puedo ayudarte con consultas sobre productos, ventas, clientes y más. ¿Qué necesitas?',
        'quien eres' => 'Soy <b>Natys Asistente</b> 🤖 Conozco a fondo todo el sistema de Larense C.A: productos, inventario, ventas, clientes y mas. Mi proposito es mantenerte informado de manera proactiva y profesional. Estoy programada para usar siempre un lenguaje respetuoso y nunca proporcionar datos sensibles como contraseñas o informacion privada de usuarios.',
        'natys' => '¡Asi es! 🎀 Estoy aqui para servirte y mantenerte informado sobre todo lo que sucede en el sistema.'
    ];
    
    // Buscar coincidencias exactas primero
    foreach ($responses as $key => $response) {
        if ($message_lower === $key || strpos($message_lower, $key) !== false) {
            return $response;
        }
    }
    
    // Consultas específicas del sistema (simuladas - conectar con DB real)
    if (strpos($message_lower, 'producto') !== false || strpos($message_lower, 'galleta') !== false || strpos($message_lower, 'stock') !== false) {
        return getProductosInfo();
    }
    
    if (strpos($message_lower, 'venta') !== false || strpos($message_lower, 'vendido') !== false) {
        return getVentasInfo();
    }
    
    if (strpos($message_lower, 'cliente') !== false || strpos($message_lower, 'usuario') !== false) {
        return getClientesInfo();
    }
    
    if (strpos($message_lower, 'precio') !== false || strpos($message_lower, 'costo') !== false) {
        return 'Para consultar precios específicos, por favor accede al módulo de Productos o dime el nombre del producto que te interesa. 💰';
    }
    
    if (strpos($message_lower, 'inventario') !== false || strpos($message_lower, 'existencia') !== false) {
        return getInventarioInfo();
    }
    
    if (strpos($message_lower, 'gracias') !== false || strpos($message_lower, 'thank') !== false) {
        return '¡De nada! 😊 Estoy aquí para lo que necesites. ¿Algo más en que pueda ayudarte?';
    }
    
    if (strpos($message_lower, 'adios') !== false || strpos($message_lower, 'bye') !== false || strpos($message_lower, 'hasta luego') !== false) {
        return '¡Hasta luego! 👋 Que tengas un excelente día. Vuelve cuando necesites ayuda.';
    }
    
    // Respuesta por defecto proactiva
    return 'Entiendo tu consulta. Como <b>Natys Asistente</b>, conozco el sistema de Larense C.A a fondo.<br><br>Actualmente puedo informarte sobre:<br>📦 <b>Productos:</b> Disponibles, agotados, precios<br>📊 <b>Inventario:</b> Stock en tiempo real, alertas<br>💰 <b>Ventas:</b> Pedidos de hoy, semana, mes<br>👥 <b>Clientes:</b> Total por categoria<br>📈 <b>Estadisticas:</b> Lo mas vendido<br><br>🔒 <i>Nota: Por seguridad, no proporciono datos sensibles como contraseñas o informacion privada.</i><br><br>¿Que te gustaria saber? Solo preguntame y te informo de inmediato. 😊';
}

/**
 * Obtener información de productos desde la base de datos
 */
function getProductosInfo() {
    try {
        require_once __DIR__ . '/../config/config.php';
        
        $pdo = new PDO(
            "mysql:host=" . DB_HOST_NEGOCIO . ";dbname=" . DB_NAME_NEGOCIO . ";charset=utf8mb4",
            DB_USER_NEGOCIO,
            DB_PASS_NEGOCIO,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        
        // Contar productos totales
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM productos WHERE estado = 'activo'");
        $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        // Obtener algunos productos
        $stmt = $pdo->query("SELECT nombre_producto, stock_producto, precio_producto FROM productos WHERE estado = 'activo' LIMIT 5");
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $response = "📦 <strong>Información de Productos</strong><br><br>";
        $response .= "Total de productos activos: <strong>{$total}</strong><br><br>";
        
        if (count($productos) > 0) {
            $response .= "<strong>Algunos productos disponibles:</strong><br>";
            foreach ($productos as $prod) {
                $response .= "• {$prod['nombre_producto']} - Stock: {$prod['stock_producto']} - {$prod['precio_producto']} $<br>";
            }
        }
        
        return $response;
        
    } catch (PDOException $e) {
        return "📦 Actualmente tenemos productos registrados en el sistema.<br><br>Para información detallada de stock y precios, accede al módulo de <strong>Productos</strong> en el menú lateral.<br><br>Categorías disponibles: Chocolate, Coco, Mantequilla, Vainilla. 🍪";
    }
}

/**
 * Obtener información de ventas
 */
function getVentasInfo() {
    return "📊 <strong>Información de Ventas</strong><br><br>" .
           "Las ventas se registran en el módulo de Pedidos.<br><br>" .
           "Puedes consultar:<br>" .
           "• Ventas por período<br>" .
           "• Pedidos pendientes<br>" .
           "• Clientes frecuentes<br>" .
           "• Productos más vendidos<br><br>" .
           "Accede al <strong>Dashboard</strong> para ver estadísticas en tiempo real. 📈";
}

/**
 * Obtener información de clientes
 */
function getClientesInfo() {
    return "👥 <strong>Información de Clientes</strong><br><br>" .
           "El sistema gestiona clientes con diferentes categorías:<br>" .
           "• 🥉 Bronce<br>" .
           "• 🥈 Plata<br>" .
           "• 🥇 Oro<br>" .
           "• 💎 Premium<br>" .
           "• 👑 VIP<br>" .
           "• ✨ Platino<br><br>" .
           "Cada categoría tiene beneficios y descuentos especiales. 🎁";
}

/**
 * Obtener información de inventario
 */
function getInventarioInfo() {
    return "📋 <strong>Inventario</strong><br><br>" .
           "El control de inventario incluye:<br>" .
           "• Materia prima<br>" .
           "• Productos terminados<br>" .
           "• Stock en tiempo real<br>" .
           "• Alertas de stock bajo<br><br>" .
           "Consulta el módulo de <strong>Inventario</strong> para gestión detallada. 📦";
}

/**
 * Obtener información del usuario actual
 */
function getUserInfo() {
    session_start();
    return [
        'usuario' => $_SESSION['s_usuario']['nombre_usuario'] ?? 'Invitado',
        'rol' => $_SESSION['s_usuario']['rol_usuario'] ?? 'Usuario',
        'email' => $_SESSION['s_usuario']['email_usuario'] ?? ''
    ];
}
