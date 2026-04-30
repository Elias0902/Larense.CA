<?php
    // llama el archivo del modelo
    require_once 'app/models/PermisoModel.php';
    require_once 'app/models/BitacoraModel.php';

    // llama el archivo que contiene la carga de alerta
    require_once 'components/utils.php';

    //zona horaria
    date_default_timezone_set('America/Caracas');

    // se almacena la action o la peticion http 
    //$action = '';
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    // indiferentemente sea la action el switch llama la funcion correspondiente
    switch($action) {

        case 'obtener':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                Obtener();
            }
        break;

        case 'obtener_modulo':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                ObtenerModulo();
            }
        break;

        case 'actualizar':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                Actualizar();
            }
        break;
    }

    // function para obtener un dato
    function Obtener() {

        // instacia el modelo
        $modelo = new Permiso();

        $id = $_GET['ID'];

         // valida si los campos no estan vacios
        if (empty($id)) {

            // manda mensaje de error
            setError('Todos los campos son requeridos no se puede enviar vacios.');

            //redirec
            header('Location: index.php?url=roles');

            //termina el script
            exit();
        }

            // se arma el josn
            $permiso_json = json_encode([
                'id' => $id
            ]);

            $resultado = $modelo->manejarAccion('obtener', $permiso_json);

            $permisos = $resultado['data'];

            echo json_encode($permisos);

            exit();
    }

    // function para obtener un dato
function ObtenerModulo() {

    // instacia el modelo
    $modelo = new Permiso();

    $id = $_GET['ID'];

     // valida si los campos no estan vacios
    if (empty($id)) {

        // manda mensaje de error
        setError('Todos los campos son requeridos no se puede enviar vacios.');

        //redirec
        header('Location: index.php?url=roles');

        //termina el script
        exit();
    }

        // se arma el josn
        $permiso_json = json_encode([
            'id' => $id
        ]);

        $resultado = $modelo->manejarAccion('obtener_modulo', $permiso_json);

        $permisos = $resultado['data'];

        echo json_encode($permisos);

        exit();
}

    // function para obtener un dato
function Actualizar() {

    header('Content-Type: application/json');

    $modelo = new Permiso();
    $bitacora = new Bitacora();

    // se almacena la fecha en la var
    $fecha = (new DateTime())->format('Y-m-d H:i:s');

    
    $datos = json_decode(file_get_contents('php://input'), true);
    
    
    //echo "<script>console.log(" . json_encode($datos) . ");</script>";

    // se arma el json
    $permiso_json = json_encode([
        'modulo' => 'Permisos',
        'permiso' => 'Modificar',
        'rol' => $_SESSION['s_usuario']['id_rol_usuario']
    ]);

     // captura el resultado de la consulta
        $status = $modelo->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {
            
            // Ejecutar acción permitida*/

            // para manejo de errores
            try {

                    $resultado = $modelo->manejarAccion('actualizar', json_encode($datos));
                    
                    // ENVIAR resultado COMPLETO del modelo
                    echo json_encode($resultado);
                    exit();
                
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
    
    header("Location: index.php?url=403");
    exit();
    
}
?>