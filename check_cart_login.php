<?php
// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Verificar si el usuario está logueado
if (!isset($_SESSION['s_usuario'])) {
    // No está logueado - guardar mensaje y redirigir al login
    $_SESSION['message'] = 'Inicia sesión para poder comprar nuestros productos';
    $_SESSION['message_type'] = 'warning';
    header('Location: index.php?url=autenticator');
    exit();
} else {
    // Está logueado - redirigir al ecommerce
    header('Location: ecommerce.php');
    exit();
}
?>
