<?php
// llama al modelo conexion
require_once "ConexionModel.php";
require_once "AuditoriaModel.php";

// se difine la clase
class Cliente extends Conexion {

    // Atributos
    private $id_cliente;
    private $tipo_id;
    private $nombre_cliente;
    private $tipo_cliente;
    private $direccion_cliente;
    private $tlf_cliente;
    private $email_cliente;
    private $estado_cliente;
    private $img_cliente;



    // construcor
    public function __construct() {
        parent::__construct();
    }

    // SETTERS
    // setters para cliente
        private function setClienteData($cliente_json){

        //Verificar y decodificar JSON
        if (is_string($cliente_json)) {
            $cliente = json_decode($cliente_json, true);

            if ($cliente === null) {
                return ['status' => false, 'msj' => 'JSON inválido.'];
            }
        } elseif (is_array($cliente_json)) {
            $cliente = $cliente_json;
        } else {
            return ['status' => false, 'msj' => 'Formato de datos inválido.'];
        }

        // almacena el id en la variable para despues validar
        $id = trim($cliente['id'] ?? '');
        // valida el username si cumple con los requisitos
        if ($id === '' || !is_numeric($id) || (int)$id <= 0)  {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El rif es invalido'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->id_cliente = $id;

        //Validar tipo de identificación
        $tipo_id = trim($cliente['tipo_id'] ?? '');

        // Valida que el tipo de identificación no esté vacío
        if ($tipo_id === '') {
            return ['status' => false, 'msj' => 'Debe seleccionar un tipo de identificación.'];
        }

        // Asigna el tipo de identificación al atributo del objeto
        $this->tipo_id = $tipo_id;

        $tipo_cliente = $cliente['tipo'] ?? null; // JSON puede mandar null o 1, 2, etc.

        // Convierte a entero solo si NO es null
        if ($tipo_cliente === null || $tipo_cliente === '' || $tipo_cliente === 'null') {
            $this->tipo_cliente = null;         // para el campo id_tipo_cliente (mantener actual)
        } else {
            $this->tipo_cliente = (int)$tipo_cliente;
        }

        //Validar nombre
        $nombre_raw = $cliente['nombre'] ?? '';

        // El nombre se limpia de espacios al inicio y al final
        $nombre = trim($nombre_raw);

        // Expresión regular para validar que el nombre solo contenga letras y espacios
        $expre_nombre = '/^[a-zA-Z]+(?:\s+[a-zA-Z0-9]+)*$/';

        // Valida que el nombre no esté vacío, que solo contenga letras y espacios, y que tenga una longitud adecuada
        if ($nombre === '') {
            
            // Retorna un mensaje de error si el nombre está vacío
            return ['status' => false, 'msj' => 'Debe ingresar un nombre de cliente.'];
        }

        // Valida que el nombre solo contenga letras y espacios
        if (!preg_match($expre_nombre, $nombre)) {
            
            // Retorna un mensaje de error si el nombre contiene caracteres no permitidos
            return [
                'status' => false,
                'msj' => 'El nombre del cliente solo puede contener letras y espacios.'
            ];
        }

        if (strlen($nombre) < 2 || strlen($nombre) > 100) { // ajusta el max según tu js
            
            // Retorna un mensaje de error si el nombre no tiene la longitud adecuada
            return [
                'status' => false,
                'msj' => 'El nombre del proveedor debe tener entre 2 y 100 caracteres.'
            ];
        }

        // Asigna el nombre al atributo del objeto
        $this->nombre_cliente = $nombre;

        //Validar dirección
        $direccion_raw = $cliente['direccion'] ?? '';

        // El precio se limpia de espacios al inicio y al final, y se reemplazan comas por puntos
        $direccion = trim($direccion_raw);

        // Valida que la dirección no esté vacía
        if ($direccion === '' || strlen($direccion) < 5 || strlen($direccion) > 200) {
            return ['status' => false, 'msj' => 'Debe ingresar una dirección de cliente válida.'];
        }

        // Asigna la dirección al atributo del objeto
        $this->direccion_cliente = $direccion;

        //Validar tlf
        $tlf_raw = $cliente['tlf'] ?? '';

        // El teléfono se limpia de espacios al inicio y al final
        $tlf = trim($tlf_raw);
        $tlf_expre = '/^(0251|0212|0412|0414|0416|0422|0424|0426)\d{7}$/'; // Expresión regular para validar un número de teléfono de 8 a 9 dígitos

        // Valida que el teléfono no esté vacío y que sea un número
        if ($tlf === '' || !preg_match($tlf_expre, $tlf) || strlen($tlf) < 11 || strlen($tlf) > 11) {
            return ['status' => false, 'msj' => 'Debe ingresar un teléfono válido (ej: 0412-1234567, +584121234567).'];
        }

        // Asigna el teléfono al atributo del objeto
        $this->tlf_cliente = $tlf;

        // Validar email
        $email_raw = $cliente['email'] ?? '';

        // El email se limpia de espacios al inicio y al final
        $email = trim($email_raw);

        // Valida que el email no esté vacío y que tenga un formato válido
        if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return ['status' => false, 'msj' => 'Debe ingresar un email de cliente válido.'];
        }

        // Asigna el email al atributo del objeto
        $this->email_cliente = $email;

        //validar img
        $imagen_raw = $cliente['imagen'] ?? '';

            // El img se limpia de espacios al inicio y al final
            $imagen = trim($imagen_raw);
    
            // Valida que el img no esté vacío y que tenga un formato válido
            if ($imagen !== '' && $imagen !== null) {

            //validar que tenga extensión correcta
            $tipo = strtolower(pathinfo($imagen, PATHINFO_EXTENSION));
            $tiposPermitidos = ['jpg', 'jpeg', 'png', 'gif'];

            // Si la extensión no está en el array de tipos permitidos, retorna un mensaje de error
            if (!in_array($tipo, $tiposPermitidos)) {

                // Retorna un mensaje de error si el tipo de imagen no es permitido
                return ['status' => false, 'msj' => 'Tipo de imagen no permitido.'];
            }
        }
    
        // Asigna el email al atributo del objeto
        $this->img_cliente = $imagen;

        //valida estado del cliente
        $estado = trim($cliente['estado'] ?? '');

        // Valida que el tipo de cliente no esté vacío
        if ($estado === '') {
            return ['status' => false, 'msj' => 'Debe seleccionar un estado de cliente.'];
        }

        // Asigna el tipo de cliente al atributo del objeto
        $this->estado_cliente = $estado;

        //Si todo está bien
        return [
            'status' => true,
            'msj'  => 'Datos validados y asignados correctamente.'
        ];
    }

    // setters para el id de cliente
    private function setClienteID($cliente_json) {

        // valida si el json es string y lo descompone
        if (is_string($cliente_json)) {

            // se almacena el contenido del json en la variable usuario
            $cliente = json_decode($cliente_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($cliente === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        // almacena el id en la variable para despues validar
        $id = trim($cliente['id'] ?? '');
        // valida el username si cumple con los requisitos
        if ($id === '') {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El rif es invalido'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->id_cliente = $id;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    // GETTERS
    //getters para el id
    private function getClienteID() {
        
        // retorna el id a utilizar
        return $this->id_cliente;
    }

    //para el tipo de id
    private function getTipoIDCliente() {

        // retorna el tipo de id a utilizar
        return $this->tipo_id;
    }

    private function getTipoCliente() {

        // retorna el tipo de cliente a utilizar
        return $this->tipo_cliente;
    }

    // getters para el nombre
    private function getNombreCliente() {

        // retorna el nombre a utilizar
        return $this->nombre_cliente;
    }

    private function getDireccionCliente() {
        return $this->direccion_cliente;
    }

    private function getTlfCliente() {
        
        // retorna el telefono a utilizar
        return $this->tlf_cliente;
    }

    private function getEmailCliente() {

        // retorna el email a utilizar
        return $this->email_cliente;
    }

    private function getImgCliente() {

        // retorna el email a utilizar
        return $this->img_cliente;
     }

     private function getEstadoCliente() {

        // retorna el email a utilizar
        return $this->estado_cliente;
      }

    private function registrarBitacoraCliente($tipo_operacion, $descripcion, $datos_anteriores = null, $datos_nuevos = null) {
        $id_usuario = Auditoria::getUsuarioActual();
        Auditoria::logCrud(
            $id_usuario,
            'Clientes',
            $tipo_operacion,
            'clientes',
            $this->getClienteID(),
            $descripcion,
            $datos_anteriores,
            $datos_nuevos
        );
    }

    // Esta se encarga de procesar los action indiferentemente cual sea llama la funcion de 
    // validacio y luego al metodo correspondiente al action
    // donde primero recibe el action como primer parametro que son los de agregar etc.. 
    // y el objeto json como segundo parametro para las validaciones y asiganciones al objeto 
    public function manejarAccion($action, $cliente_json ){

        // maneja el action y carga la funcion correspondiente a la action
        switch($action){

            case 'agregar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setClienteData($cliente_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Guardar_Cliente();

            // termina el script    
            break;

            case 'obtener':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setClienteID($cliente_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Obtener_Cliente();

            // termina el script    
            break;

            case 'modificar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setClienteData($cliente_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Actualizar_Cliente();

            // termina el script    
            break;

            case 'eliminar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setClienteID($cliente_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Eliminar_Cliente();

            // termina el script    
            break;

            case 'consultar':

                // llama la funcion y retorna los datos
                return $this->Mostrar_Cliente();

            // termina el script
            break;

            default:

                // retorna un mensaje de error en caso de no existir la accion
                return['status' => false, 'msj' => 'Accion Invalida.'];

            // termina el script
            break;
        }
    }

    // funcion para consultar categorias
    private function Mostrar_Cliente() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // consulta los proveedores activos en la base de datos
            $query = "SELECT c.*, tc.nombre_tipo_cliente
                        FROM clientes c
                        LEFT JOIN tipos_clientes tc ON c.id_tipo_cliente = tc.id_tipo_cliente
                        WHERE c.status = 1"; //valida el estado si esta activo

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // ejecuta la sentencia
            $stmt->execute(); 

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->rowCount() > 0) {

                // almacena los datos extraidos de la base de datos 
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Clientes encontrados con exito.', 'data' => $data];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Clientes no encontrados o inactivos'];
            }

        } catch (PDOException $e) {
            
            // retorna mensaje de error del exception del pdo
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {

            // finaliza la fincion cerrando la conexion a la bd
            $this->closeConnection();
        }
    }

    // funcion para registrar categoria
    private function Guardar_Cliente() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // inserta una categoria
            $query = "INSERT INTO clientes (id_cliente, tipo_id, id_tipo_cliente, nombre_cliente, direccion_cliente, tlf_cliente, email_cliente, img_cliente, estado_cliente)
                                            VALUES (:id, :tipo_id, :tipo, :nombre, :direccion, :telefono, :email, :img, :estado)";

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':id', $this->getClienteID());
            $stmt->bindValue(':tipo_id', $this->getTipoIDCliente());
            $stmt->bindValue(':tipo', $this->getTipoCliente());
            $stmt->bindValue(':nombre', $this->getNombreCliente());
            $stmt->bindValue(':direccion', $this->getDireccionCliente());
            $stmt->bindValue(':telefono', $this->getTlfCliente());
            $stmt->bindValue(':email', $this->getEmailCliente());
            $stmt->bindValue(':img', $this->getImgCliente());
            $stmt->bindValue(':estado', $this->getEstadoCliente());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {
                $nuevoRegistro = [
                    'id_cliente' => $this->getClienteID(),
                    'tipo_id' => $this->getTipoIDCliente(),
                    'id_tipo_cliente' => $this->getTipoCliente(),
                    'nombre_cliente' => $this->getNombreCliente(),
                    'direccion_cliente' => $this->getDireccionCliente(),
                    'tlf_cliente' => $this->getTlfCliente(),
                    'email_cliente' => $this->getEmailCliente(),
                    'img_cliente' => $this->getImgCliente(),
                    'estado_cliente' => $this->getEstadoCliente()
                ];

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Cliente Registrado con exito.'];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Error al registrar Cliente.'];
            }

        } catch (PDOException $e) {
            
            // retorna mensaje de error del exception del pdo
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {

            // finaliza la fincion cerrando la conexion a la bd
            $this->closeConnection();
        }
    }

    // funcion para obtener un registro
    private function Obtener_Cliente() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // actualiza el status la categoria
            $query = "SELECT c.*, tc.nombre_tipo_cliente
                        FROM clientes c
                        LEFT JOIN tipos_clientes tc ON tc.id_tipo_cliente = c.id_tipo_cliente 
                        WHERE id_cliente = :id AND c.status = 1";

            // prepar la sentencia 
            $stmt = $conn->prepare($query); 

            // vincula los parametros
            $stmt->bindValue(":id", $this->getClienteID());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                // obtiene los datos de la consulta
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Cliente encontrado con exito.', 'data' => $data, 'data_bitacora' => $data];
            }
            else {

                // retiorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Cliente no encontrado error.'];
            }

        } catch (PDOException $e) {
            
            // retorna mensaje de error del exception del pdo
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {

            // finaliza la fincion cerrando la conexion a la bd
            $this->closeConnection();
        }
    }

    // funcion para modificar categoria
    private function Actualizar_Cliente() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // Verificar si se proporcionó una nueva imagen
            $nuevaImagen = $this->getImgCliente();
            $tieneNuevaImagen = !empty($nuevaImagen);

            // Verificar si se proporcionó tipo_cliente
            $tieneTipoCliente = $this->tipo_cliente !== null;

            // Obtener datos actuales antes de actualizar para la bitácora
            $consultaAntigua = $conn->prepare("SELECT * FROM clientes WHERE id_cliente = :id");
            $consultaAntigua->bindValue(':id', $this->getClienteID());
            $consultaAntigua->execute();
            $datos_anteriores = $consultaAntigua->fetch(PDO::FETCH_ASSOC);

            // Construir la consulta según si hay nueva imagen y/o tipo_cliente
            if ($tieneNuevaImagen && $tieneTipoCliente) {
                $query = "UPDATE clientes
                            SET tipo_id = :tipo_id,
                            id_tipo_cliente = :id_tipo_cliente,
                            nombre_cliente = :nombre, 
                            direccion_cliente = :direccion, 
                            tlf_cliente = :telefono, 
                            email_cliente = :email,
                            img_cliente = :imagen,
                            estado_cliente = :estado
                            WHERE id_cliente = :id";
            } elseif ($tieneNuevaImagen && !$tieneTipoCliente) {
                $query = "UPDATE clientes
                            SET tipo_id = :tipo_id,
                            nombre_cliente = :nombre, 
                            direccion_cliente = :direccion, 
                            tlf_cliente = :telefono, 
                            email_cliente = :email,
                            img_cliente = :imagen,
                            estado_cliente = :estado
                            WHERE id_cliente = :id";
            } elseif (!$tieneNuevaImagen && $tieneTipoCliente) {
                $query = "UPDATE clientes
                            SET tipo_id = :tipo_id,
                            id_tipo_cliente = :id_tipo_cliente,
                            nombre_cliente = :nombre, 
                            direccion_cliente = :direccion, 
                            tlf_cliente = :telefono, 
                            email_cliente = :email,
                            estado_cliente = :estado
                            WHERE id_cliente = :id";
            } else {
                $query = "UPDATE clientes
                            SET tipo_id = :tipo_id,
                            nombre_cliente = :nombre, 
                            direccion_cliente = :direccion, 
                            tlf_cliente = :telefono, 
                            email_cliente = :email,
                            estado_cliente = :estado
                            WHERE id_cliente = :id";
            }

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':id', $this->getClienteID());
            $stmt->bindValue(':tipo_id', $this->getTipoIDCliente());
            $stmt->bindValue(':nombre', $this->getNombreCliente());
            $stmt->bindValue(':direccion', $this->getDireccionCliente());
            $stmt->bindValue(':telefono', $this->getTlfCliente());
            $stmt->bindValue(':email', $this->getEmailCliente());
            $stmt->bindValue(':estado', $this->getEstadoCliente());

            // Solo vincular tipo_cliente si se proporcionó
            if ($tieneTipoCliente) {
                $stmt->bindValue(':id_tipo_cliente', $this->getTipoCliente());
            }

            // Solo vincular imagen si se proporcionó una nueva
            if ($tieneNuevaImagen) {
                $stmt->bindValue(':imagen', $nuevaImagen);
            }

            // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {
                $datos_nuevos = [
                    'id_cliente' => $this->getClienteID(),
                    'tipo_id' => $this->getTipoIDCliente(),
                    'id_tipo_cliente' => $this->getTipoCliente(),
                    'nombre_cliente' => $this->getNombreCliente(),
                    'direccion_cliente' => $this->getDireccionCliente(),
                    'tlf_cliente' => $this->getTlfCliente(),
                    'email_cliente' => $this->getEmailCliente(),
                    'img_cliente' => $tieneNuevaImagen ? $nuevaImagen : null,
                    'estado_cliente' => $this->getEstadoCliente()
                ];

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Cliente Actualizado con exito.', 'data_bitacora' => $datos_anteriores];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Error al actualizar Cliente.'];
            }

        } catch (PDOException $e) {
            
            // retorna mensaje de error del exception del pdo
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {

            // finaliza la fincion cerrando la conexion a la bd
            $this->closeConnection();
        }
    }

    // funcion para elimanar un registro
    private function Eliminar_Cliente() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // Obtener datos actuales antes de eliminar (para bitacora)
            $query_select = "SELECT * FROM clientes 
                                    WHERE id_cliente = :id 
                                    AND status = 1";

            // oeroara la sentencia
            $stmt_select = $conn->prepare($query_select);

            // vincula los parametros
            $stmt_select->bindValue(':id', $this->getClienteID());

            // ejecuta la sentencia
            $stmt_select->execute();

            // se almacena arry asocc en la var
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);

            // actualiza el status la categoria
            $query = "UPDATE clientes
                        SET status = 0
                        WHERE id_cliente = :id";

            // prepar la sentencia 
            $stmt = $conn->prepare($query); 

            // vincula los parametros
            $stmt->bindValue(":id", $this->getClienteID());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Cliente Eliminado con exito.', 'data_bitacora' => $datos_anteriores];
            }
            else {

                // retiorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Cliente no eliminado error.'];
            }

        } catch (PDOException $e) {
            
            // retorna mensaje de error del exception del pdo
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {

            // finaliza la fincion cerrando la conexion a la bd
            $this->closeConnection();
        }
    }

    // funcion para obtener los ultimos clientes registrados
    public function Ultimos_Clientes($limite = 5) {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT c.*, tc.nombre_tipo_cliente
                      FROM clientes c
                      LEFT JOIN tipos_clientes tc ON c.id_tipo_cliente = tc.id_tipo_cliente
                      WHERE c.status = 1
                      ORDER BY c.id_cliente DESC
                      LIMIT :limite";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Últimos clientes encontrados', 'data' => $data];
            } else {
                return ['status' => false, 'msj' => 'No hay clientes registrados'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }
}

?>