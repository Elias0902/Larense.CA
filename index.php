<?php
    // Configuración de sesión persistente
    ini_set('session.cookie_lifetime', 86400); // 24 horas
    ini_set('session.gc_maxlifetime', 86400);    // 24 horas
    ini_set('session.cookie_path', '/');
    ini_set('session.cookie_httponly', 1);

    //inicializa la session
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Si no hay sesión iniciada y no se solicita una ruta específica, mostrar landing
    if (!isset($_SESSION['s_usuario']) && !isset($_GET['url'])) {
        header('Location: App/views/landing.php');
        exit();
    }

    //llama a composer
    require_once 'vendor/autoload.php';

    // Carga configuración de timeout de inactividad
    require_once 'config/timeout.php';

    //Llama el FrontController
    use app\controllers\FrontController;

    //Intancia la clase FrontController
    $frontcontroller = new FrontController();
?>