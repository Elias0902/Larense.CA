<?php
    // llama el archivo del modelo
    require_once 'app/models/BitacoraModel.php';
    require_once 'app/models/PermisoModel.php';

    // llama el archivo que contiene la carga de alerta
    require_once 'components/utils.php';

    //zona horaria
    date_default_timezone_set('America/Caracas');

    // se almacena la action o la peticion http 
    //$action = '';
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    // indiferentemente sea la action el switch llama la funcion correspondiente
    switch($action) {

        case 'agregar':
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                Agregar();
            }
        break;

        case 'obtener':
            if ($_SERVER['REQUEST_METHOD'] == 'GET') {
                Obtener();
            }
        break;

        default:
            Consultar();
        break;
    }

    // funcion para consultar datos
    function Consultar() {
       
        // instacia el modelo
        $modelo = new Bitacora();
        $permiso = new Permiso();
        $bitacora = new Bitacora();

        // se almacena la fecha en la var
        $fecha = (new DateTime())->format('Y-m-d H:i:s');

        // se arma el json
        $permiso_json = json_encode([
            'modulo' => 'Categorias',
            'permiso' => 'Consultar',
            'rol' => $_SESSION['s_usuario']['id_rol_usuario']
        ]);


        // captura el resultado de la consulta
        $status = $permiso->manejarAccion("verificar", $permiso_json);

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if (isset($status['status']) && $status['status'] === true) {
            
            // Ejecutar acción permitida

            // para manejo de errores
            try {

                // lla ma la funcion que maneja las acciones en el modelo donde pasa como 
                // primer para metro la accion y luego el objeto usuario_json
                $resultado = $modelo->manejarAccion('consultar', null);

                // valida si exixtes el staus del resultado y si es true 
                if (isset($resultado['status']) && $resultado['status'] === true) {

                    // usa mensaje dinamico del modelo
                    //setSuccess($resultado['msj']);

                    // extrae los datos
                    $bitacoras = $resultado['data'];

                    // se arma el json de bitacora
                        $bitacora_json = json_encode([
                        'id_usuario' => $_SESSION['s_usuario']['id_usuario'],
                        'modulo' => 'Bitacoras',
                        'accion' => 'Consultar',
                        'descripcion' => 'El usuario:' . ' ' . $_SESSION['s_usuario']['nombre_usuario'] . ' ' . 
                            'ha Consultado los datos en el dashboard de bitaoras en el sistema',
                        'fecha' => $fecha
                    ]);

                    //realiza la insercion de la bitacora
                    $bitacora->manejarAccion('agregar', $bitacora_json);

                    //carga la vista
                    require_once 'app/views/bitacoraView.php';

                    // termina el script
                    exit();
                }
                else {
                                
                    // usa mensaje dinamico del modelo
                    setError($resultado['msj']);

                    //carga la vista
                    require_once 'app/views/bitacoraView.php';

                    // termina el script
                    exit();
                }
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
    //muestra un modal de info que dice acceso no permitido
    setError("Error acceso no permitido");

    //redirect
    require_once 'app/views/bitacoraView.php';
                
    // termina el script
    exit();
    
}

    //funcion para guardar datos
    function Agregar() {}

    // function para obtener un dato
    function Obtener() {

        // instacia el modelo
        $modelo = new Bitacora();

        $id = $_GET['ID'];

         // valida si los campos no estan vacios
        if (empty($id)) {

            // manda mensaje de error
            setError('Todos los campos son requeridos no se puede enviar vacios.');

            //redirec
            header('Location: index.php?url=bitacora');

            //termina el script
            exit();
        }

            // se arma el josn
            $bitacora_json = json_encode([
                'id' => $id
            ]);

            $resultado = $modelo->manejarAccion('obtener', $bitacora_json);

            $bitacoras = $resultado['data'];

            echo json_encode($bitacoras);

            exit();
    }

?>