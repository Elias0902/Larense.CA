<?php
    namespace app\controllers;
    // se esablece la clase frontcontroller
    class FrontController{

        //Atrivuto del objeto
        private $controller;

        // se estable el constructor
        public function __construct(){
            
            //Se llama o ejecuta directamente o automaticamente la funcion
            $this->Direction();
        }

        //funcion que se encarga de establecer o contruir la direccions
        private function Direction(){

            //se almacena la peticion de la url
            $controller = isset($_GET['url']) ? $_GET['url'] : '';

            //valida la session y si la peticion controlador es igual o 
            //diferente a la predeterminada
            if(!isset($_SESSION['s_usuario']) && $controller != 'autenticator') {
                
                //si la session no esta iniciada redirige al login
                require_once 'app/controllers/AutenticatorController.php';
                
                //aqui termina el script
                exit();
            }

            //Llama al achivo que contiene la rutas url
            require_once "config/route.php";
            
            //valida si el controller tiene una url
            if($controller == ''){
            
                // si el controller esta vacio carga por defecto el login
                require_once 'app/controllers/AutenticatorController.php';
                
                //termina el script
                exit();
            }

            //en caso de tener una url el controller
            else{

                //valida si existe la url en el arry de url del archivo route.php
                if(isset($rutas[$controller])){

                    //construlle la url dinamicamente desde el arry de url del
                    // achivo route.php
                    require_once $rutas[$controller];
                    
                    //termina el script
                    exit();
                }

                //en caso contrario de que no este la url carga una pagina de error
                require_once 'app/views/errors/404.php';
                
                //terina el scrpit
                exit();
            }
        }

    }

?>