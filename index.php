<?php
session_start();//inicializa la session
require_once 'config/timeout.php';// Carga configuración de timeout de inactividad
require_once 'vendor/autoload.php';//llama a composer
use app\controllers\FrontController;//Llama el FrontController
$frontcontroller = new FrontController();//Intancia la clase FrontController
?>