<?php
// llama al modelo conexion
require_once "ConexionModel.php";
require_once "AuditoriaModel.php";

// se difine la clase
class Producto extends Conexion {

    // Atributos
    private $id_producto;
    private $nombre_producto;
    private $categoria_producto;
    private $precio_producto;
    private $stock_producto;
    private $fecha_registro_producto;
    private $fecha_vencimiento_producto;
    private $imagen_producto;



    // construcor
    public function __construct() {
        parent::__construct();
    }

    // SETTERS
    // setters para producto
        private function setProductoData($producto_json){

        //Verificar y decodificar JSON
        if (is_string($producto_json)) {
            $producto = json_decode($producto_json, true);

            if ($producto === null) {
                return ['status' => false, 'msj' => 'JSON inválido.'];
            }
        } elseif (is_array($producto_json)) {
            $producto = $producto_json;
        } else {
            return ['status' => false, 'msj' => 'Formato de datos inválido.'];
        }

        //Validar nombre
        $nombre_raw = $producto['nombre'] ?? '';

        // El nombre se limpia de espacios al inicio y al final
        $nombre = trim($nombre_raw);

        // Expresión regular para validar que el nombre solo contenga letras y espacios
        $expre_nombre = '/^[a-zA-Z0-9\s]+$/';

        // Valida que el nombre no esté vacío, que solo contenga letras y espacios, y que tenga una longitud adecuada
        if ($nombre === '') {
            
            // Retorna un mensaje de error si el nombre está vacío
            return ['status' => false, 'msj' => 'Debe ingresar un nombre de producto.'];
        }

        // Valida que el nombre solo contenga letras y espacios
        if (!preg_match($expre_nombre, $nombre)) {
            
            // Retorna un mensaje de error si el nombre contiene caracteres no permitidos
            return [
                'status' => false,
                'msj' => 'El nombre del producto solo puede contener letras y espacios.'
            ];
        }

        if (strlen($nombre) < 2 || strlen($nombre) > 100) { // ajusta el max según tu js
            
            // Retorna un mensaje de error si el nombre no tiene la longitud adecuada
            return [
                'status' => false,
                'msj' => 'El nombre del producto debe tener entre 2 y 100 caracteres.'
            ];
        }

        // Asigna el nombre al atributo del objeto
        $this->nombre_producto = $nombre;

        //Validar categoría
        $categoria = trim($producto['categoria'] ?? '');

        // Valida que la categoría no esté vacía
        if ($categoria === '') {

            // Retorna un mensaje de error si la categoría está vacía
            return ['status' => false, 'msj' => 'Debe seleccionar una categoría.'];
        }

        // Asigna la categoría al atributo del objeto
        $this->categoria_producto = $categoria;

        //Validar precio
        $precio_raw = $producto['precio'] ?? '';

        // El precio se limpia de espacios al inicio y al final, y se reemplazan comas por puntos
        $precio = str_replace(',', '.', trim($precio_raw));

        // Valida que el precio no esté vacío, que sea un número y que sea mayor que cero
        if ($precio === '' || !is_numeric($precio) || $precio <= 0) {

            // Retorna un mensaje de error si el precio no es válido
            return ['status' => false, 'msj' => 'El precio debe ser un número mayor que cero.'];
        }

        // Asigna el precio al atributo del objeto
        $this->precio_producto = (float)$precio;

        //Validar stock
        $stock_raw = $producto['stock'] ?? '';

        // El stock se limpia de espacios al inicio y al final
        $stock = trim($stock_raw);

        // Valida que el stock no esté vacío, que sea un número entero y que sea mayor o igual a cero
        if ($stock === '' || !is_numeric($stock) || (int)$stock < 0) {

            // Retorna un mensaje de error si el stock no es válido
            return ['status' => false, 'msj' => 'El stock debe ser un número entero no negativo.'];
        }

        // Asigna el stock al atributo del objeto
        $this->stock_producto = (int)$stock;

        // Validar fecha de registro (date en formato Y-m-d)
        $fecha_raw = $producto['fecha_registro'] ?? '';

        // La fecha se limpia de espacios al inicio y al final
        $fecha = trim($fecha_raw);

        // Valida que la fecha de registro no esté vacía
        if ($fecha === '') {
            return ['status' => false, 'msj' => 'Debe ingresar la fecha de registro.'];
        }

        // Valida que la fecha de registro tenga el formato correcto y sea una fecha válida
        $fechaObj = DateTime::createFromFormat('Y-m-d', $fecha);

        // El método createFromFormat devuelve false si la fecha no es válida o no coincide con el formato
        if ($fechaObj === false || $fechaObj->format('Y-m-d') !== $fecha) {

            // Retorna un mensaje de error si la fecha de registro no es válida
            return ['status' => false, 'msj' => 'Fecha de registro no válida.'];
        }

        // Valida que la fecha de registro no sea futura
        $hoy = new DateTime();
        if ($fechaObj > $hoy) {

            // Retorna un mensaje de error si la fecha de registro es futura
            return ['status' => false, 'msj' => 'La fecha de registro no puede ser futura.'];
        }

        // Asigna la fecha de registro al atributo del objeto
        $this->fecha_registro_producto = $fecha;

        // Validar fecha de vencimiento (si se envía)
        $fechaV_raw = $producto['fecha_vencimiento'] ?? '';

        // La fecha de vencimiento se limpia de espacios al inicio y al final
        $fechaV = trim($fechaV_raw);

        // Si se envía una fecha de vencimiento, se valida que tenga el formato correcto, sea una fecha válida y no sea anterior a la fecha de registro
        if ($fechaV !== '') {

            // Valida que la fecha de vencimiento tenga el formato correcto y sea una fecha válida
            $fechaVObj = DateTime::createFromFormat('Y-m-d', $fechaV);

            // El método createFromFormat devuelve false si la fecha no es válida o no coincide con el formato
            if ($fechaVObj === false || $fechaVObj->format('Y-m-d') !== $fechaV) {

                // Retorna un mensaje de error si la fecha de vencimiento no es válida
                return ['status' => false, 'msj' => 'Fecha de vencimiento no válida.'];
            }

            // Valida que la fecha de vencimiento no sea anterior a la fecha de registro
            $fechaRObj = new DateTime($this->fecha_registro_producto);

            // Si la fecha de vencimiento es anterior a la fecha de registro, retorna un mensaje de error
            if ($fechaVObj < $fechaRObj) {

                // Retorna un mensaje de error si la fecha de vencimiento es anterior a la fecha de registro
                return [
                    'status' => false,
                    'msj' => 'La fecha de vencimiento no puede ser anterior a la fecha de registro.'
                ];
            }

            // Asigna la fecha de vencimiento al atributo del objeto
            $this->fecha_vencimiento_producto = $fechaV;
        } else {
            $this->fecha_vencimiento_producto = null;
        }

        //Validar imagen (ruta / nombre, no el archivo físico)
        $imagen = trim($producto['imagen'] ?? '');

        // permites que sea vacío (sin imagen) o una ruta válida
        // si quieres validar que NO esté vacía, quita el `|| $imagen === ''`
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

        // Asigna la ruta de la imagen al atributo del objeto
        $this->imagen_producto = $imagen;

        //Si todo está bien
        return [
            'status' => true,
            'msj'  => 'Datos validados y asignados correctamente.'
        ];
    }

    private function setUpdateProductoData($producto_json){

        //Verificar y decodificar JSON
        if (is_string($producto_json)) {
            $producto = json_decode($producto_json, true);

            if ($producto === null) {
                return ['status' => false, 'msj' => 'JSON inválido.'];
            }
        } elseif (is_array($producto_json)) {
            $producto = $producto_json;
        } else {
            return ['status' => false, 'msj' => 'Formato de datos inválido.'];
        }

                // expreciones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/'; // para el id

        // almacena el id en la variable para despues validar
        $id = trim($producto['id'] ?? '');
        // valida el username si cumple con los requisitos
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || strlen($id) < 0) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El id del producto es invalido'];
        }

        // Asigna el ID al atributo del objeto
        $this->id_producto = $id;

        //Validar nombre
        $nombre_raw = $producto['nombre'] ?? '';

        // El nombre se limpia de espacios al inicio y al final
        $nombre = trim($nombre_raw);

        // Expresión regular para validar que el nombre solo contenga letras y espacios
        $expre_nombre = '/^[a-zA-Z0-9\s]+$/';

        // Valida que el nombre no esté vacío, que solo contenga letras y espacios, y que tenga una longitud adecuada
        if ($nombre === '') {
            
            // Retorna un mensaje de error si el nombre está vacío
            return ['status' => false, 'msj' => 'Debe ingresar un nombre de producto.'];
        }

        // Valida que el nombre solo contenga letras y espacios
        if (!preg_match($expre_nombre, $nombre)) {
            
            // Retorna un mensaje de error si el nombre contiene caracteres no permitidos
            return [
                'status' => false,
                'msj' => 'El nombre del producto solo puede contener letras y espacios.'
            ];
        }

        if (strlen($nombre) < 2 || strlen($nombre) > 100) { // ajusta el max según tu js
            
            // Retorna un mensaje de error si el nombre no tiene la longitud adecuada
            return [
                'status' => false,
                'msj' => 'El nombre del producto debe tener entre 2 y 100 caracteres.'
            ];
        }

        // Asigna el nombre al atributo del objeto
        $this->nombre_producto = $nombre;

        //Validar categoría
        $categoria = trim($producto['categoria'] ?? '');

        // Valida que la categoría no esté vacía
        if ($categoria === '') {

            // Retorna un mensaje de error si la categoría está vacía
            return ['status' => false, 'msj' => 'Debe seleccionar una categoría.'];
        }

        // Asigna la categoría al atributo del objeto
        $this->categoria_producto = $categoria;

        //Validar precio
        $precio_raw = $producto['precio'] ?? '';

        // El precio se limpia de espacios al inicio y al final, y se reemplazan comas por puntos
        $precio = str_replace(',', '.', trim($precio_raw));

        // Valida que el precio no esté vacío, que sea un número y que sea mayor que cero
        if ($precio === '' || !is_numeric($precio) || $precio <= 0) {

            // Retorna un mensaje de error si el precio no es válido
            return ['status' => false, 'msj' => 'El precio debe ser un número mayor que cero.'];
        }

        // Asigna el precio al atributo del objeto
        $this->precio_producto = (float)$precio;

        //Validar stock
        $stock_raw = $producto['stock'] ?? '';

        // El stock se limpia de espacios al inicio y al final
        $stock = trim($stock_raw);

        // Valida que el stock no esté vacío, que sea un número entero y que sea mayor o igual a cero
        if ($stock === '' || !is_numeric($stock) || (int)$stock < 0) {

            // Retorna un mensaje de error si el stock no es válido
            return ['status' => false, 'msj' => 'El stock debe ser un número entero no negativo.'];
        }

        // Asigna el stock al atributo del objeto
        $this->stock_producto = (int)$stock;

        // Validar fecha de registro (date en formato Y-m-d)
        $fecha_raw = $producto['fecha_registro'] ?? '';

        // La fecha se limpia de espacios al inicio y al final
        $fecha = trim($fecha_raw);

        // Valida que la fecha de registro no esté vacía
        if ($fecha === '') {
            return ['status' => false, 'msj' => 'Debe ingresar la fecha de registro.'];
        }

        // Valida que la fecha de registro tenga el formato correcto y sea una fecha válida
        $fechaObj = DateTime::createFromFormat('Y-m-d', $fecha);

        // El método createFromFormat devuelve false si la fecha no es válida o no coincide con el formato
        if ($fechaObj === false || $fechaObj->format('Y-m-d') !== $fecha) {

            // Retorna un mensaje de error si la fecha de registro no es válida
            return ['status' => false, 'msj' => 'Fecha de registro no válida.'];
        }

        // Valida que la fecha de registro no sea futura
        $hoy = new DateTime();
        if ($fechaObj > $hoy) {

            // Retorna un mensaje de error si la fecha de registro es futura
            return ['status' => false, 'msj' => 'La fecha de registro no puede ser futura.'];
        }

        // Asigna la fecha de registro al atributo del objeto
        $this->fecha_registro_producto = $fecha;

        // Validar fecha de vencimiento (si se envía)
        $fechaV_raw = $producto['fecha_vencimiento'] ?? '';

        // La fecha de vencimiento se limpia de espacios al inicio y al final
        $fechaV = trim($fechaV_raw);

        // Si se envía una fecha de vencimiento, se valida que tenga el formato correcto, sea una fecha válida y no sea anterior a la fecha de registro
        if ($fechaV !== '') {

            // Valida que la fecha de vencimiento tenga el formato correcto y sea una fecha válida
            $fechaVObj = DateTime::createFromFormat('Y-m-d', $fechaV);

            // El método createFromFormat devuelve false si la fecha no es válida o no coincide con el formato
            if ($fechaVObj === false || $fechaVObj->format('Y-m-d') !== $fechaV) {

                // Retorna un mensaje de error si la fecha de vencimiento no es válida
                return ['status' => false, 'msj' => 'Fecha de vencimiento no válida.'];
            }

            // Valida que la fecha de vencimiento no sea anterior a la fecha de registro
            $fechaRObj = new DateTime($this->fecha_registro_producto);

            // Si la fecha de vencimiento es anterior a la fecha de registro, retorna un mensaje de error
            if ($fechaVObj < $fechaRObj) {

                // Retorna un mensaje de error si la fecha de vencimiento es anterior a la fecha de registro
                return [
                    'status' => false,
                    'msj' => 'La fecha de vencimiento no puede ser anterior a la fecha de registro.'
                ];
            }

            // Asigna la fecha de vencimiento al atributo del objeto
            $this->fecha_vencimiento_producto = $fechaV;
        } else {
            $this->fecha_vencimiento_producto = null;
        }

        //Si todo está bien
        return [
            'status' => true,
            'msj'  => 'Datos validados y asignados correctamente.'
        ];
    }

    // setters para el id de la categoria
    private function setProductoID($producto_json) {

        // valida si el json es string y lo descompone
        if (is_string($producto_json)) {

            // se almacena el contenido del json en la variable usuario
            $producto = json_decode($producto_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($producto === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        // expreciones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/'; // para el id

        // almacena el id en la variable para despues validar
        $id = trim($producto['id'] ?? '');
        // valida el username si cumple con los requisitos
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || strlen($id) < 0) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El id del producto es invalido'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->id_producto = $id;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    // GETTERS
    //getters para el id
    private function getProdutoID() {
        
        // retorna el id a utilizar
        return $this->id_producto;
    }

    // getters para el nombre
    private function getProductoNombre() {

        // retorna el nombre a utilizar
        return $this->nombre_producto;
    }

    private function getCategoriaProducto() {
        return $this->categoria_producto;
    }

    private function getPrecioProducto() {
        return $this->precio_producto;
    }

    private function getStockProducto() {
        return $this->stock_producto;
    }

    private function getFechaRegistroProducto() {
        return $this->fecha_registro_producto;
    }

    private function getFechaVencimientoProducto() {
        return $this->fecha_vencimiento_producto;
    }

    private function getImagenProducto() {
        return $this->imagen_producto;
    }

    // Esta se encarga de procesar los action indiferentemente cual sea llama la funcion de 
    // validacio y luego al metodo correspondiente al action
    // donde primero recibe el action como primer parametro que son los de agregar etc.. 
    // y el objeto json como segundo parametro para las validaciones y asiganciones al objeto 
    public function manejarAccion($action, $producto_json ){

        // maneja el action y carga la funcion correspondiente a la action
        switch($action){

            case 'agregar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setProductoData($producto_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Guardar_Producto();

            // termina el script    
            break;

            case 'obtener':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setProductoID($producto_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Obtener_Producto();

            // termina el script    
            break;

            case 'modificar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setUpdateProductoData($producto_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Actualizar_Producto();

            // termina el script    
            break;

            case 'eliminar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setProductoID($producto_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Eliminar_Producto();

            // termina el script    
            break;

            case 'consultar':

                // llama la funcion y retorna los datos
                return $this->Mostrar_Producto();

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
    private function Mostrar_Producto() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // consulta los productos activos en la base de datos
            $query = "SELECT p.*, c.nombre_categoria
                        FROM productos p
                        INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                        WHERE p.status = 1"; //valida el estado si esta activo

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // ejecuta la sentencia
            $stmt->execute(); 

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->rowCount() > 0) {

                // almacena los datos extraidos de la base de datos 
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Productos encontradas con exito.', 'data' => $data];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'productos no encontradas o inactivas'];
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
    private function Guardar_Producto() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // inserta una categoria
            $query = "INSERT INTO productos (nombre_producto, precio_venta, stock, fecha_registro, fecha_vencimiento, id_categoria, img)
                                            VALUES (:nombre, :precio, :stock, :fecha_registro, :fecha_vencimiento, :id_categoria, :imagen)";

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':nombre', $this->getProductoNombre());
            $stmt->bindValue(':precio', $this->getPrecioProducto());
            $stmt->bindValue(':stock', $this->getStockProducto());
            $stmt->bindValue(':fecha_registro', $this->getFechaRegistroProducto());
            $stmt->bindValue(':fecha_vencimiento', $this->getFechaVencimientoProducto());
            $stmt->bindValue(':id_categoria', $this->getCategoriaProducto());
            $stmt->bindValue(':imagen', $this->getImagenProducto());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Producto Registrado con exito.'];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Error al registrar producto.'];
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
    private function Obtener_Producto() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();

            // actualiza el status la categoria
            $query = "SELECT *
                        FROM productos
                        WHERE id_producto = :id AND status = 1";

            // prepar la sentencia 
            $stmt = $conn->prepare($query); 

            // vincula los parametros
            $stmt->bindValue(":id", $this->getProdutoID());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                // obtiene los datos de la consulta
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Producto encontrado con exito.', 'data' => $data, 'data_bitacora' => $data];
            }
            else {

                // retiorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Producto no encontrado error.'];
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
    private function Actualizar_Producto() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();
            
            // Obtener datos actuales antes de actualizar (para bitacora)
            $query_select = "SELECT * FROM productos 
                                    WHERE id_producto = :id 
                                    AND status = 1";

            // prepara la sentencia
            $stmt_select = $conn->prepare($query_select);

            // vincula los parametros
            $stmt_select->bindValue(':id', $this->getProdutoID());

            // ejecuta la sentencia
            $stmt_select->execute();

            // se almacena los datos anteriores
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);

            // inserta una categoria
            $query = "UPDATE productos 
                        SET nombre_producto = :nombre, 
                        precio_venta = :precio, 
                        stock = :stock, 
                        fecha_registro = :fecha_registro, 
                        fecha_vencimiento = :fecha_vencimiento, 
                        id_categoria = :id_categoria
                        WHERE id_producto = :id ";

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':id', $this->getProdutoID());
            $stmt->bindValue(':nombre', $this->getProductoNombre());
            $stmt->bindValue(':precio', $this->getPrecioProducto());
            $stmt->bindValue(':stock', $this->getStockProducto());
            $stmt->bindValue(':fecha_registro', $this->getFechaRegistroProducto());
            $stmt->bindValue(':fecha_vencimiento', $this->getFechaVencimientoProducto());
            $stmt->bindValue(':id_categoria', $this->getCategoriaProducto());
             
            // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Producto Actualizada con exito.', 'data_bitacora' => $datos_anteriores];
            }
            else {

                // retorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Error al actualizar producto.'];
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
    private function Eliminar_Producto() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionNegocio();
            
            // Obtener datos actuales antes de eliminar (para bitacora)
            $query_select = "SELECT * FROM productos 
                                    WHERE id_producto = :id 
                                    AND status = 1";

            // prepala la sentencia
            $stmt_select = $conn->prepare($query_select);

            // vincula los parametros
            $stmt_select->bindValue(':id', $this->getProdutoID());
            
            // ejecuta la sentencia
            $stmt_select->execute();

            // se almacena los datos para la bitacora
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);

            // actualiza el status la categoria
            $query = "UPDATE productos
                        SET status = 0
                        WHERE id_producto = :id";

            // prepar la sentencia 
            $stmt = $conn->prepare($query); 

            // vincula los parametros
            $stmt->bindValue(":id", $this->getProdutoID());

             // se valida si se ejecuto la sentencia y si es true
            if ($stmt->execute()) {
                

                //retorna el status con el mensaje y los datos
                return['status' => true, 'msj' => 'Producto Eliminada con exito.', 'data_bitacora' => $datos_anteriores];
            }
            else {

                // retiorna un status de error con un mensaje 
                return['status' => false, 'msj' => 'Producto no eliminado error.'];
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

    // funcion para obtener el producto mas vendido
    public function Producto_Mas_Vendido() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT 
                        p.id_producto,
                        p.nombre_producto,
                        p.img as imagen_producto,
                        c.nombre_categoria,
                        COALESCE(SUM(dp.cantidad), 0) as total_vendido,
                        COALESCE(SUM(dp.cantidad * dp.precio_unitario), 0) as total_ingresos
                      FROM productos p
                      INNER JOIN categorias c ON p.id_categoria = c.id_categoria
                      LEFT JOIN detalle_pedidos dp ON p.id_producto = dp.id_producto
                      LEFT JOIN pedidos ped ON dp.id_pedido = ped.id_pedido AND ped.status = 1
                      WHERE p.status = 1
                      GROUP BY p.id_producto, p.nombre_producto, p.img, c.nombre_categoria
                      ORDER BY total_vendido DESC
                      LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Producto más vendido encontrado', 'data' => $data];
            } else {
                return ['status' => false, 'msj' => 'No hay ventas registradas'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }
}

?>