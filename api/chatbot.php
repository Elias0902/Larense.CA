<?php
/**
 * API Endpoint para Natys Asistente
 * Conecta con microservicio Python (FastAPI + OpenAI)
 * Filtros de seguridad: NO revela contraseñas, claves, datos sensibles
 */

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Método no permitido']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);
if (!$input || !isset($input['message'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Mensaje requerido']);
    exit;
}

$message = trim($input['message']);
$session_id = $input['session_id'] ?? 'default_session';

if (empty($message)) {
    echo json_encode(['success' => false, 'error' => 'El mensaje no puede estar vacío']);
    exit;
}

// ========== FILTRO DE SEGURIDAD (lo mantienes igual) ==========
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
            'response' => '🔒 <b>Información Protegida</b><br><br>Como Natys Asistente, no puedo proporcionar datos sensibles del sistema... (tu mensaje original)',
            'timestamp' => date('Y-m-d H:i:s')
        ]);
        exit;
    }
}

// ========== CONFIGURACIÓN DEL MICROSERVICIO PYTHON ==========
$python_microservice_url = 'http://localhost:5000/api/v1/chat'; // Ajusta IP/puerto
$chatbot_api_key = 'NatysIA'; // La misma que pusiste en el .env del microservicio

// Obtener ID del usuario desde la sesión (si está logueado)
session_start();
$user_id = $_SESSION['s_usuario']['id_usuario'] ?? $_SESSION['user_id'] ?? null;
// Si no hay usuario autenticado, puedes usar un ID genérico o null (el microservicio debería manejarlo)
if (!$user_id) {
    $user_id = 0; // o podrías usar un guest id
}

// ========== LLAMADA AL MICROSERVICIO PYTHON ==========
try {
    $response = callPythonMicroservice($message, $session_id, $user_id, $python_microservice_url, $chatbot_api_key);
    
    echo json_encode([
        'success' => true,
        'response' => $response,
        'timestamp' => date('Y-m-d H:i:s')
    ]);
    
} catch (Exception $e) {
    // Fallback opcional: si el microservicio falla, puedes usar el procesamiento local o devolver error
    // Por ahora devolvemos un mensaje amigable
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'El asistente está teniendo problemas técnicos. Por favor, intenta más tarde.'
    ]);
}

/**
 * Llama al microservicio Python (FastAPI)
 */
function callPythonMicroservice($message, $session_id, $user_id, $url, $api_key) {
    $payload = [
        'message' => $message,
        'session_id' => $session_id,
        'user_id' => $user_id
    ];
    
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'X-API-Key: ' . $api_key
    ]);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30); // 30 segundos máximo
    
    $response = curl_exec($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curl_error = curl_error($ch);
    curl_close($ch);
    
    if ($curl_error) {
        throw new Exception("Error de conexión: " . $curl_error);
    }
    
    if ($http_code !== 200) {
        throw new Exception("El microservicio respondió con código $http_code");
    }
    
    $decoded = json_decode($response, true);
    if (!$decoded || !isset($decoded['response'])) {
        throw new Exception("Respuesta inválida del microservicio");
    }
    
    // La respuesta del microservicio puede venir en HTML, texto plano o markdown.
    // Como tu frontend espera HTML (p.ej. <b>, <br>), asumimos que ya viene formateado.
    // Si el microservicio devuelve markdown, puedes convertirlo aquí con Parsedown o similar.
    return $decoded['response'];
}