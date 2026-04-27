<?php
    // llama el archivo que contiene la config
    require_once __DIR__ . '/../../config/config.php';

    // Define la clase Conexion
    class Conexion {
        protected $connNegocio; // Propiedad para almacenar la conexión PDO a la BD del negocio
        protected $connSeguridad; // Propiedad para almacenar la conexión PDO a la BD de seguridad

        // Constructor de la clase
        public function __construct() {
            
            // Llama al método getConnectionNegocio al crear una instancia de la clase
            $this->getConnectionNegocio();
            
            // Llama al método getConnectionSeguridad al crear una instancia de la clase
            $this->getConnectionSeguridad();
        }

        // Método para obtener la conexión a la base de datos del negocio
        protected function getConnectionNegocio() {
            
            // Inicializa la propiedad connNegocio en null
            $this->connNegocio = null;

            try {
                
                // Crea una nueva conexión PDO
                $this->connNegocio = new PDO(
                    "mysql:host=" . DB_HOST_NEGOCIO . ";dbname=" . DB_NAME_NEGOCIO,
                    DB_USER_NEGOCIO,
                    DB_PASS_NEGOCIO,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {

                // mensaje de error en caso de que la conexión falle
                die("Error de conexión: " . $e->getMessage());
            }

            // Devuelve la conexión PDO a la base de datos del negocio
            return $this->connNegocio;
        }

        // Método para obtener la conexión a la base de datos de seguridad
        protected function getConnectionSeguridad() {
            
            // Inicializa la propiedad connSeguridad en null
            $this->connSeguridad = null;

            try {
                
                // Crea una nueva conexión PDO
                $this->connSeguridad = new PDO(
                    "mysql:host=" . DB_HOST_SECURITY . ";dbname=" . DB_NAME_SECURITY,
                    DB_USER_SECURITY,
                    DB_PASS_SECURITY,
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
            } catch (PDOException $e) {

                // mensaje de error en caso de que la conexión falle
                die("Error de conexión: " . $e->getMessage());
            }

            // Devuelve la conexión PDO a la base de datos de seguridad
            return $this->connSeguridad;
        }

        protected function closeConnection() {
            
            // Inicializa la propiedad connNegocio en null
            $this->connNegocio = null;
            
            // Inicializa la propiedad connSeguridad en null
            $this->connSeguridad = null;
            
            //return $this->connNegocio;
        }
    }
?>