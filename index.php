<?php
    //inicializa la session
    session_start();

    //llama a composer
    require_once 'vendor/autoload.php';
    
    //Llama el FrontController
    use app\controllers\FrontController;

    //Intancia la clase FrontController
    $frontcontroller = new FrontController();
?>