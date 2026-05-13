<?php
// llama al modelo conexion
require_once "ConexionModel.php";

// se define la clase
class Pedido extends Conexion {

    // Atributos
    private $pedido_id;
    private $pedido_cliente_id;
    private $pedido_dias_credito;
    private $pedido_fecha;
    private $pedido_estado;
    private $pedido_promocion_id;
    private $pedido_telefono;
    private $pedido_direccion_entrega;
    private $pedido_observaciones;
    private $pedido_total;
    private $productos = [];
    private $cantidades = [];
    private $precios = [];

    // constructor
    public function __construct() {
        parent::__construct();
    }

    // SETTER para datos completos
    private function setPedidoUpdateData($pedido_json) {

        // valida si el json es string y lo descompone
        if (is_string($pedido_json)) {
            $pedido = json_decode($pedido_json, true);
            if ($pedido === null) {
                return ['status' => false, 'msj' => 'JSON inválido.'];
            }
        } elseif (is_array($pedido_json)) {
            $pedido = $pedido_json;
        } else {
            return ['status' => false, 'msj' => 'Formato de datos inválido.'];
        }

        // expresiones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $expre_telefono = '/^[0-9]{4}-[0-9]{7}$/';
        $expre_fecha = '/^\d{4}-\d{2}-\d{2}$/';
        $expre_decimal = '/^\d+(\.\d{1,2})?$/';

        // Validar ID
        $id = trim($pedido['id'] ?? '');
        if ($id !== '' && (!preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0)) {
            return ['status' => false, 'msj' => 'El ID del pedido es invalido'];
        }
        $this->pedido_id = $id;

        // Validar cliente_id
        $cliente_id = trim($pedido['cliente_id'] ?? '');
        if ($cliente_id === '' || !preg_match($expre_id, $cliente_id) || strlen($cliente_id) > 10 || $cliente_id < 0) {
            return ['status' => false, 'msj' => 'El ID del cliente es invalido'];
        }
        $this->pedido_cliente_id = $cliente_id;

        // Validar fecha
        $fecha = trim($pedido['fecha'] ?? '');
        if ($fecha === '' || !preg_match($expre_fecha, $fecha)) {
            return ['status' => false, 'msj' => 'La fecha debe tener formato YYYY-MM-DD.'];
        }
        $this->pedido_fecha = $fecha;

        // Validar estado
        $estado = trim($pedido['estado'] ?? '');
        if ($estado === '') {
            return ['status' => false, 'msj' => 'El estado del pedido es inválido. Debe seleccionar un uno.'];
        }
        $this->pedido_estado = $estado;

        // Validar teléfono (opcional)
        $telefono = trim($pedido['telefono'] ?? '');
        if ($telefono !== '' && !preg_match($expre_telefono, $telefono)) {
            return ['status' => false, 'msj' => 'El teléfono debe tener formato: 04XX-XXXXXXX'];
        }
        $this->pedido_telefono = $telefono;
        
        // Validar dirección de entrega (opcional)
        $direccion = trim($pedido['direccion_entrega'] ?? '');
        if (strlen($direccion) > 300) {
            return ['status' => false, 'msj' => 'La dirección no puede exceder 300 caracteres.'];
        }
        $this->pedido_direccion_entrega = $direccion;

        // Validar observaciones (opcional)
        $observaciones = trim($pedido['observaciones'] ?? '');
        if (strlen($observaciones) > 500) {
            return ['status' => false, 'msj' => 'Las observaciones no pueden exceder 500 caracteres.'];
        }
        $this->pedido_observaciones = $observaciones;

        return ['status' => true, 'msj' => 'Datos validados y asignados correctamente.'];
    }

    private function setPedidoData($pedido_json) {

        // valida si el json es string y lo descompone
        if (is_string($pedido_json)) {
            $pedido = json_decode($pedido_json, true);
            if ($pedido === null) {
                return ['status' => false, 'msj' => 'JSON inválido.'];
            }
        } elseif (is_array($pedido_json)) {
            $pedido = $pedido_json;
        } else {
            return ['status' => false, 'msj' => 'Formato de datos inválido.'];
        }

        // expresiones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $expre_telefono = '/^[0-9]{4}-[0-9]{7}$/';
        $expre_fecha = '/^\d{4}-\d{2}-\d{2}$/';
        $expre_decimal = '/^\d+(\.\d{1,2})?$/';

        // Validar cliente_id
        $cliente_id = trim($pedido['cliente_id'] ?? '');
        if ($cliente_id === '' || !preg_match($expre_id, $cliente_id) || strlen($cliente_id) > 10 || $cliente_id < 0) {
            return ['status' => false, 'msj' => 'El ID del cliente es invalido'];
        }
        $this->pedido_cliente_id = $cliente_id;

        // Validar dias credito
        $dias = trim($pedido['dias_credito'] ?? '');
        $this->pedido_dias_credito = $dias;

        // Validar fecha
        $fecha = trim($pedido['fecha'] ?? '');
        if ($fecha === '' || !preg_match($expre_fecha, $fecha)) {
            return ['status' => false, 'msj' => 'La fecha debe tener formato YYYY-MM-DD.'];
        }
        $this->pedido_fecha = $fecha;

        // Validar estado
        $estado = trim($pedido['estado'] ?? '');
        if ($estado === '') {
            return ['status' => false, 'msj' => 'El estado del pedido es inválido. Debe seleccionar un uno.'];
        }
        $this->pedido_estado = $estado;

        // Validar promoción_id (opcional)
        $promocion_id = trim($pedido['promocion_id'] ?? '');
        $this->pedido_promocion_id = $promocion_id ?: null;

        // Validar teléfono (opcional)
        $telefono = trim($pedido['telefono'] ?? '');
        if ($telefono !== '' && !preg_match($expre_telefono, $telefono)) {
            return ['status' => false, 'msj' => 'El teléfono debe tener formato: 04XX-XXXXXXX'];
        }
        $this->pedido_telefono = $telefono;
        
        // Validar dirección de entrega (opcional)
        $direccion = trim($pedido['direccion_entrega'] ?? '');
        if (strlen($direccion) > 300) {
            return ['status' => false, 'msj' => 'La dirección no puede exceder 300 caracteres.'];
        }
        $this->pedido_direccion_entrega = $direccion;

        // Validar observaciones (opcional)
        $observaciones = trim($pedido['observaciones'] ?? '');
        if (strlen($observaciones) > 500) {
            return ['status' => false, 'msj' => 'Las observaciones no pueden exceder 500 caracteres.'];
        }
        $this->pedido_observaciones = $observaciones;

        // Validar total
        $total = trim($pedido['total'] ?? '');
        if ($total === '' || !is_numeric($total) || $total < 0) {
            return ['status' => false, 'msj' => 'El total del pedido es invalido.'];
        }
        if (!preg_match($expre_decimal, $total)) {
            return ['status' => false, 'msj' => 'El total debe tener máximo 2 decimales.'];
        }
        $this->pedido_total = $total;

        // Validar productos (ARRAY)
        $productos_raw = $pedido['productos'] ?? [];
        if (!is_array($productos_raw)) {
            $productos_raw = [$productos_raw];  // convertir string único a array
        }

        $producto = array_filter(array_map('trim', $productos_raw), function($p) {
            return !empty($p);
        });

        if (empty($producto)) {
            return ['status' => false, 'msj' => 'Debe seleccionar al menos un producto.'];
        }

        $this->productos = $producto;  // array limpio ["7", "6"]

        // Validar cantidades (ARRAY)
        $cantidad_raw = $pedido['cantidades'] ?? [];
        if (!is_array($cantidad_raw)) {
            $cantidad_raw = [$cantidad_raw];  // convertir string único a array
        }

        $cantidad = array_filter(array_map('trim', $cantidad_raw), function($p) {
            return !empty($p);
        });

        if (empty($cantidad)) {
            return ['status' => false, 'msj' => 'Debe seleccionar al menos un producto.'];
        }

        $this->cantidades = $cantidad;  // array limpio ["7", "6"]

        // Validar precios (ARRAY)
        $precio_raw = $pedido['precios'] ?? [];
        if (!is_array($precio_raw)) {
            $precio_raw = [$precio_raw];
        }

        $precio = array_filter(array_map(function($p) {
            $p = trim($p);
            return $p !== '' ? round((float)$p, 2) : null;
        }, $precio_raw));

        if (empty($precio)) {
            return ['status' => false, 'msj' => 'Debe seleccionar al menos un producto.'];
        }

        $this->precios = $precio;

        return ['status' => true, 'msj' => 'Datos validados y asignados correctamente.'];
    }

        private function setPedidoEstado($pedido_json) {
        if (is_string($pedido_json)) {
            $pedido = json_decode($pedido_json, true);
            if ($pedido === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        } else {
            $pedido = $pedido_json;
        }

        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $id = trim($pedido['id'] ?? '');
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0) {
            return ['status' => false, 'msj' => 'El ID del pedido es invalido'];
        }
        $this->pedido_id = $id;

        $estado = trim($pedido['nuevo_estado'] ?? '');
        if ($id === '') {
            return ['status' => false, 'msj' => 'El estado del pedido es invalido'];
        }
        $this->pedido_estado = $estado;

        return ['status' => true, 'msj' => 'ID validado correctamente.'];
    }

    // SETTER para ID
    private function setPedidoID($pedido_json) {
        if (is_string($pedido_json)) {
            $pedido = json_decode($pedido_json, true);
            if ($pedido === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        } else {
            $pedido = $pedido_json;
        }

        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $id = trim($pedido['id'] ?? '');
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0) {
            return ['status' => false, 'msj' => 'El ID del pedido es invalido'];
        }
        $this->pedido_id = $id;

        return ['status' => true, 'msj' => 'ID validado correctamente.'];
    }

    // GETTERS
    private function getPedidoID() {
        return $this->pedido_id;
    }

    private function getPedidoClienteID() {
        return $this->pedido_cliente_id;
    }

    private function getPedidoCredito() {
        return $this->pedido_dias_credito;
    }

    private function getPedidoFecha() {
        return $this->pedido_fecha;
    }

    private function getPedidoEstado() {
        return $this->pedido_estado;
    }

    private function getPedidoPromocionID() {
        return $this->pedido_promocion_id;
    }

    private function getPedidoTelefono() {
        return $this->pedido_telefono;
    }

    private function getPedidoDireccion() {
        return $this->pedido_direccion_entrega;
    }

    private function getPedidoObservaciones() {
        return $this->pedido_observaciones;
    }

    private function getPedidoTotal() {
        return $this->pedido_total;
    }

    private function getPedidoProducto() {
        return $this->productos;
    }

    private function getPedidoCantidad() {
        return $this->cantidades;
    }

    private function getPedidoPrecio() {
        return $this->precios;
    }

    // Manejador de acciones
    public function manejarAccion($action, $pedido_json) {
        switch($action) {

            case 'agregar':
            
                // almacena y llama validacion
                $validacion = $this->setPedidoData($pedido_json);
                
                // valida validacion
                if (!$validacion['status']) {
                    
                    // retorna validacion
                    return $validacion;
                }

                // retorna valor de la funcion
                return $this->Guardar_Pedido();

            break;

            case 'obtener':

                // almacena y llama validacion
                $validacion = $this->setPedidoID($pedido_json);
                
                // valida validacion
                if (!$validacion['status']) {
                    
                // retorna valor de la funcion
                    return $validacion;
                }

                // retorna valor de la funcion
                return $this->Obtener_Pedido();

            break;

            case 'obtener_productos':

                // almacena y llama validacion
                $validacion = $this->setPedidoID($pedido_json);

                // valida validacion
                if (!$validacion['status']) {

                    // retorna valor de la funcion
                    return $validacion;
                }

                // retorna valor de la funcion
                return $this->Obtener_Productos_Pedido();

            break;

            case 'modificar':

                // almacena y llama validacion
                $validacion = $this->setPedidoUpdateData($pedido_json);

                 // valida validacion
                if (!$validacion['status']) {

                    // retorna valor de la funcion
                    return $validacion;
                }

                // retorna valor de la funcion
                return $this->Actualizar_Pedido();
                
            break;

            case 'eliminar':

                // almacena y llama validacion
                $validacion = $this->setPedidoID($pedido_json);

                // valida validacion
                if (!$validacion['status']) {

                // retorna valor de la funcion
                    return $validacion;
                }

                // retorna valor de la funcion
                return $this->Eliminar_Pedido();

            break;

            case 'consultar':

                // retorna valor de la funcion
                return $this->Mostrar_Pedido();

            break;

            case 'consultar_estado':

                // retorna valor de la funcion
                return $this->Mostrar_Estado();

            break;

            case 'cambiar_estado':

                // almacena y llama validacion
                $validacion = $this->setPedidoEstado($pedido_json);

                // valida validacion
                if (!$validacion['status']) {

                // retorna valor de la funcion
                    return $validacion;
                }

                // retorna valor de la funcion
                return $this->Cambiar_Estado_Pedido();
            break;

            default:
                return ['status' => false, 'msj' => 'Accion Invalida.'];
            break;
        }
    }

    // Función para consultar pedidos
    private function Mostrar_Pedido() {

        // conexion cerrada
        $this->closeConnection();

        try {

            // establece conexion
            $conn = $this->getConnectionNegocio();

            // consulta para mostrar pedido
            $query = "SELECT p.*,
                             ep.nombre_estado,
                             c.nombre_cliente,
                             c.tipo_id,
                             pg.nombre_estado as pago,
                             t.monto_tasa,
                             COALESCE(pm.nombre_promocion, 'Sin Promoción') as nombre_promocion,
                             GROUP_CONCAT(dp.cantidad SEPARATOR '<br> ') as cantidades,
                             GROUP_CONCAT(pr.nombre_producto SEPARATOR '<br> ') as productos
                             FROM pedidos p
                             LEFT JOIN detalle_pedidos dp ON dp.id_pedido = p.id_pedido
                             LEFT JOIN productos pr ON dp.id_producto = pr.id_producto
                             LEFT JOIN estado_pedido ep ON ep.id_estado_pedido = p.id_estado_pedido
                             LEFT JOIN clientes c ON c.id_cliente = p.id_cliente 
                             LEFT JOIN promociones pm ON pm.id_promocion = p.id_promocion
                             LEFT JOIN estado_pago pg ON pg.id_estado_pago = p.id_estado_pago
                             LEFT JOIN tasa_dia t ON t.id_tasa = p.id_tasa
                      WHERE p.status = 1
                      GROUP BY p.id_pedido
                      ORDER BY p.id_pedido DESC";

            //prepara la consulta
            $stmt = $conn->prepare($query);

            //ejecuta la sentencia
            $stmt->execute();

            // valida si se ejecuto
            if ($stmt->rowCount() > 0) {

                // se almacena los datos en una var
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // msj de exito
                return ['status' => true, 'msj' => 'Pedidos encontrados con éxito.', 'data' => $data];
            } else {

                // msj de error
                return ['status' => false, 'msj' => 'No hay pedidos registrados.'];
            }
        } catch (PDOException $e) {

            // msj dinamico de error
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {

            // cierra la conexion
            $this->closeConnection();
        }
    }

    private function Mostrar_Estado() {

        // conexion serrada
        $this->closeConnection();
        try {

            // establece conexion
            $conn = $this->getConnectionNegocio();
            
            // consulta para estado
            $query = "SELECT *
                      FROM estado_pedido";

            //prepara la consulta
            $stmt = $conn->prepare($query);
            
            //ejecuta la consulta
            $stmt->execute();

            // valida si se ejecuto la consu;ta
            if ($stmt->rowCount() > 0) {

                // se almacena los datos
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // msj de exito
                return ['status' => true, 'msj' => 'Estado Pedidos encontrados con exito.', 'data' => $data];
            } else {

                // msj de error
                return ['status' => false, 'msj' => 'No hay estado pedidos registrados.'];
            }
        } catch (PDOException $e) {

            // msj de error dinamico
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {

            // cierra la conexion
            $this->closeConnection();
        }
    }

    // Función para guardar pedido
    private function Guardar_Pedido() {

        // conexion cerrada
        $this->closeConnection();

        try {

            // establece la cinexion
            $conn = $this->getConnectionNegocio();

            // Iniciar transacción
            $conn->beginTransaction();

            // se almacena promocion
            $promoId = $this->getPedidoPromocionID();

            // se define si viene  o no
            $promo = !empty($promoId) ? (int)$promoId : 0;

            // valida si hay promo
            if ($promo > 0){

                // se consulta los productos en promocion
            $queryPromo = "SELECT p.*,
                                    GROUP_CONCAT(dp.id_producto) AS id_producto 
                                    FROM promociones p
                                    INNER JOIN detalle_promocion dp ON dp.id_promocion = p.id_promocion
                                    WHERE p.id_promocion = :id_promocion
                                    AND p.status = 1
                                    GROUP BY p.id_promocion";

            // prepara la consulta
            $stmtPromo = $conn->prepare($queryPromo);

            // vincula los datos
            $stmtPromo->bindValue(':id_promocion', $this->getPedidoPromocionID());

            // ejecuta la conulta
            $stmtPromo->execute();

            //obtiene los datos
            $dataPromo = $stmtPromo->fetch(PDO::FETCH_ASSOC);

            // valida la promo
            if (!$dataPromo) {

                // revierte transaccion
                $conn->rollBack();

                //msj de error
                return ['status' => false, 'msj' => 'La promoción no existe o no está activa.'];
            }

            // se almacena los datos
            $tipo_promocion = $dataPromo['tipo_descuento'];
            $valor_promocion = (float)($dataPromo['valor_descuento'] ?? 0);
            $estado_promocion = (int)($dataPromo['estado'] ?? 0);

            $producto_promoArray = !empty($dataPromo['id_producto'])
                ? array_map('trim', explode(',', $dataPromo['id_producto']))
                : [];

        }

            // valida si esta activa la promo
            if ($promo > 0 && $estado_promocion === 1) {

                // almacena los arry
                $productos = $this->getPedidoProducto();
                $cantidades = $this->getPedidoCantidad();
                $precios = $this->getPedidoPrecio();

                // valia si es arry
                if (!is_array($productos)) $productos = [$productos];
                if (!is_array($cantidades)) $cantidades = [$cantidades];
                if (!is_array($precios)) $precios = [$precios];

                // valida que coincidan
                if (
                    empty($productos) ||
                    count($productos) !== count($cantidades) ||
                    count($productos) !== count($precios)
                ) {

                    // revierte transaccion
                    $conn->rollBack();

                    // msj de error
                    return ['status' => false, 'msj' => 'Productos, cantidades y precios no coinciden'];
                }

                // inicializa var
                $detallePedido = [];
                $totalCalculado = 0;

                // bucle para recorre el array
                for ($i = 0; $i < count($productos); $i++) {
                    $productoId = trim((string)$productos[$i]);
                    $cantidad = (float)$cantidades[$i];
                    $precioRecibido = round((float)$precios[$i], 2);

                    // valida cantidad
                    if ($cantidad <= 0) {

                        // revierte transaccion
                        $conn->rollBack();

                        // msj de error
                        return ['status' => false, 'msj' => 'Las cantidades deben ser mayores a cero.'];
                    }

                    // establece precio
                    $precioCalculado = $precioRecibido;

                    // Aplica cálculo solo si el producto está en la promo
                    if ($promo && in_array($productoId, $producto_promoArray, true)) {

                        //optiene el tipo promo
                        $tipo = strtolower(trim($dataPromo['tipo_descuento'] ?? ''));

                        //obtiene el valor de tipo promo
                        $valor = (float)($dataPromo['valor_descuento'] ?? 0);

                        //valida el tipo de promo
                        if ($tipo_promocion === '2x1') {

                            //calcula y define el precio unitario
                            $precioUnitario = $precioRecibido;

                            //define el precio calculado
                            $precioCalculado = round(ceil($cantidad / 2) * $precioUnitario, 2);
                        } // en caso de ser otra promocion
                        elseif ($tipo_promocion === 'porcentaje') {

                            // define el precio calculado en %
                            $precioCalculado = round($precioRecibido - ($precioRecibido * $valor / 100), 2);
                        }
                    }

                    // se establece array del detalle pedido
                    $detallePedido[] = [
                        'producto_id' => $productoId,
                        'cantidad' => $cantidad,
                        'precio' => $precioCalculado
                    ];

                    // se define el total
                    $totalCalculado = $this->getPedidoTotal();
                }

                // se define total con .00
                $totalCalculado = $this->getPedidoTotal();

                $totalRecibido = $this->getPedidoTotal();

                // valida el total calculado
                if ($totalCalculado !== $totalRecibido) {

                    //revierte trnsaccion
                    $conn->rollBack();

                    //msj de error
                    return ['status' => false, 'msj' => 'El total calculado no coincide con el total recibido.'];
                }
            }

            // Si no hay promoción, aquí simplemente se omiten todos los cálculos; 
            // el pedido se guarda tal cual 
            
            $queryTasa = "SELECT * FROM tasa_dia 
                WHERE status = 1 
                ORDER BY id_tasa DESC, fecha_tasa DESC 
                LIMIT 1";

            // prepara la consulta
            $stmtTasa = $conn->prepare($queryTasa);

            // ejecuta la sentencia
            $stmtTasa->execute();

            $tasaData = $stmtTasa->fetch(PDO::FETCH_ASSOC);

            $idTasa = $tasaData['id_tasa'];

            // consulta para insertar pedido
            $queryInsert = "INSERT INTO pedidos (id_cliente, fecha_pedido, id_estado_pedido, monto_total_pedido, direccion_entrega, tlf_contacto, observaciones, id_promocion, id_tasa, id_estado_pago)
                                        VALUES (:cliente_id, :fecha, :estado, :total, :direccion, :telefono, :observaciones, :promocion_id, :tasa, 1)";
            
            // prepara la consulta
            $stmtInsert = $conn->prepare($queryInsert);

            // vincula los datos
            $stmtInsert->bindValue(':cliente_id', $this->getPedidoClienteID());
            $stmtInsert->bindValue(':fecha', $this->getPedidoFecha());
            $stmtInsert->bindValue(':estado', $this->getPedidoEstado());
            $stmtInsert->bindValue(':total', $this->getPedidoTotal());
            $stmtInsert->bindValue(':direccion', $this->getPedidoDireccion());
            $stmtInsert->bindValue(':telefono', $this->getPedidoTelefono());
            $stmtInsert->bindValue(':observaciones', $this->getPedidoObservaciones());
            $stmtInsert->bindValue(':promocion_id', $this->getPedidoPromocionID());
            $stmtInsert->bindValue(':tasa', $idTasa);

            // ejecuta la sentencia
            $stmtInsert->execute();
                
            // Obtener el ID del pedido recién insertado
            $ultimo_id = $conn->lastInsertId();

            // obtener arrys 
            $productos = $this->getPedidoProducto();  // array [1, 2, 3]
            $cantidades = $this->getPedidoCantidad();  // array [10.5, 20.0, 5.0]
            $precios = $this->getPedidoPrecio();  // array [10.5, 20.0, 5.0]
        
            // valida que los arrays de productos, cantidades y precio no esten vacios y tengan la misma cantidad de elementos
            if (
                empty($productos) ||
                count($productos) !== count($cantidades) ||
                count($productos) !== count($precios)
            ) {

                // revierte transaccion
                $conn->rollBack();

                //msj de error
                return ['status' => false, 'msj' => 'Productos, cantidades y precios no coinciden'];
            }
        
            // bucle para insertar los detalles de la produccion y actualizar el stock de materia prima y producto
            foreach ($productos as $index => $idProducto) {
            $cantidadProducto = $cantidades[$index];
            $precioProducto = $precios[$index];

            // consulta para insertar el detalle de la produccion
                $queryInsertDetallePedido = "INSERT INTO detalle_pedidos (id_pedido, id_producto, cantidad, precio_unitario) 
                                                                    VALUES (:id_pedido, :id_producto, :cantidad, :precio)";
                                                    
                // se prepara la consulta
                $stmtInsertDetallePedido = $conn->prepare($queryInsertDetallePedido);

                // se asignan los valores a los parametros de la consulta
                $stmtInsertDetallePedido->bindValue(':id_pedido', $ultimo_id);
                $stmtInsertDetallePedido->bindValue(':id_producto', $idProducto);
                $stmtInsertDetallePedido->bindValue(':cantidad', $cantidadProducto);
                $stmtInsertDetallePedido->bindValue(':precio', $precioProducto);

                // se ejecuta la consulta
                $stmtInsertDetallePedido->execute();
                
                //consulta para obtener el stcok actual de la materia prima
                $queryStockProducto = "SELECT stock
                                            FROM productos
                                            WHERE id_producto = :id_producto";

                // se prepara la consulta
                $stmtStockProducto  = $conn->prepare($queryStockProducto );

                // se asignan los valores a los parametros de la consulta
                $stmtStockProducto ->bindValue(':id_producto', $idProducto);

                // se ejecuta la consulta
                $stmtStockProducto ->execute();

                // se obtiene el stock actual del producto
                $stockActual = $stmtStockProducto ->fetch(PDO::FETCH_ASSOC)['stock'];

                // se valida si el stock actual es suficiente para la cantidad utilizada
                if ($stockActual < $cantidadProducto) {

                    // Revierte la transacción si el stock no es suficiente
                    $conn->rollBack();  

                    // se retorna un mensaje de error si el stock no es suficiente
                    return ['status' => false, 'msj' => 'Stock insuficiente para el producto seleccionado. Stock actual: ' . $stockActual];
                }

                // se define el nuevo stock de la materia prima despues de la produccion
                $nuevoStock = $stockActual - $cantidadProducto;

                // consulta para actualizar el stock de la materia prima
                $queryUpdateStockProducto  = "UPDATE productos 
                                                SET stock = :nuevoStock 
                                                WHERE id_producto = :id_producto";
                
                // se prepara la consulta
                $stmtUpdateStockProducto  = $conn->prepare($queryUpdateStockProducto );

                // se asignan los valores a los parametros de la consulta
                $stmtUpdateStockProducto ->bindValue(':id_producto', $idProducto);
                $stmtUpdateStockProducto ->bindValue(':nuevoStock', $nuevoStock);

                // se ejecuta la consulta
                $stmtUpdateStockProducto ->execute();
            }

            // Obtener datos
            $fecha = $this->getPedidoFecha();  // "2026-05-07"
            $dias = (int)$this->getPedidoCredito() ?: 15;  // 15

            //CÁLCULO
            $fechaInicio = new DateTime($fecha);
            $fechaInicio->add(new DateInterval('P' . $dias . 'D'));  // +15 días
            $vencimiento = $fechaInicio->format('Y-m-d');  // "2026-05-22"

            // se define estado
            $estado = "Por Pagar";

            //consulta para registrar cuenta cobra
            $queryInsertCuenta = "INSERT INTO cuenta_x_cobrar (id_pedido, id_cliente, monto_total, saldo_pendiente, fecha_emision, fecha_vencimiento, estado_cuenta)
                                        VALUES (:id_pedido, :cliente_id, :monto, :saldo, :fecha, :vencimiento, :estado)";
            
            // prepara la consulta
            $stmtInsertCuenta = $conn->prepare($queryInsertCuenta);

            // vincula los datos
            $stmtInsertCuenta->bindValue(':id_pedido', $ultimo_id);
            $stmtInsertCuenta->bindValue(':cliente_id', $this->getPedidoClienteID());
            $stmtInsertCuenta->bindValue(':monto', $this->getPedidoTotal());
            $stmtInsertCuenta->bindValue(':saldo', $this->getPedidoTotal());
            $stmtInsertCuenta->bindValue(':fecha', $this->getPedidoFecha());
            $stmtInsertCuenta->bindValue(':vencimiento', $vencimiento);
            $stmtInsertCuenta->bindValue(':estado', $estado);

            // ejecuta la sentencia
            $stmtInsertCuenta->execute();

            // si todo se ejecuta correctamente se confirma la transaccion
            $conn->commit();

            // msj de exito
            return ['status' => true, 'msj' => 'Pedido guardado exitosamente.'];
        } catch (PDOException $e) {
        
            // valida si hay un error en alguna consulta
            if ($conn->inTransaction()) {

                // Revierte la transacción si hay un error
                $conn->rollBack();
            }

            // msj de error dinamico
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {

            // cierra la conexion
            $this->closeConnection();
        }
    }

    // Función para obtener un pedido
    private function Obtener_Pedido() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT p.*,
                             ep.nombre_estado,
                             c.nombre_cliente,
                             c.tipo_id,
                             pg.nombre_estado as pago,
                             t.monto_tasa,
                             COALESCE(pm.nombre_promocion, 'Sin Promoción') as nombre_promocion,
                             GROUP_CONCAT(dp.precio_unitario SEPARATOR ', ') as precio,
                             GROUP_CONCAT(dp.cantidad SEPARATOR '<br> ') as cantidades,
                             GROUP_CONCAT(pr.nombre_producto SEPARATOR '<br> ') as productos
                             FROM pedidos p
                             LEFT JOIN detalle_pedidos dp ON dp.id_pedido = p.id_pedido
                             LEFT JOIN productos pr ON dp.id_producto = pr.id_producto
                             LEFT JOIN estado_pedido ep ON ep.id_estado_pedido = p.id_estado_pedido
                             LEFT JOIN clientes c ON c.id_cliente = p.id_cliente 
                             LEFT JOIN promociones pm ON pm.id_promocion = p.id_promocion
                             LEFT JOIN estado_pago pg ON pg.id_estado_pago = p.id_estado_pago
                             LEFT JOIN tasa_dia t ON t.id_tasa = p.id_tasa
                      WHERE p.id_pedido = :id_pedido
                      GROUP BY p.id_pedido
                      ORDER BY p.id_pedido DESC";

            //prepara la consulta
            $stmt = $conn->prepare($query);

            //vincula los datos
            $stmt->bindValue(':id_pedido', $this->getPedidoID());

            //ejecuta la sentencia
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Pedido encontrado con éxito.', 'data' => $data, 'data_bitacora' => $data];
            } else {
                return ['status' => false, 'msj' => 'Pedido no encontrado.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para actualizar pedido
    private function Actualizar_Pedido() {

        // conexion cerrada
        $this->closeConnection();

        try {

            // establece conexion
            $conn = $this->getConnectionNegocio();

            // consulta para modificar pedido
            $query = "UPDATE pedidos 
                      SET id_cliente = :cliente_id,
                          fecha_pedido = :fecha,
                          id_estado_pedido = :estado,
                          direccion_entrega = :direccion,
                          tlf_contacto = :telefono,
                          observaciones = :observaciones
                      WHERE id_pedido = :id";

            // prepara la consulta
            $stmt = $conn->prepare($query);

            // vincula los datos
            $stmt->bindValue(':id', $this->getPedidoID());
            $stmt->bindValue(':cliente_id', $this->getPedidoClienteID());
            $stmt->bindValue(':fecha', $this->getPedidoFecha());
            $stmt->bindValue(':estado', $this->getPedidoEstado());
            $stmt->bindValue(':direccion', $this->getPedidoDireccion());
            $stmt->bindValue(':telefono', $this->getPedidoTelefono());
            $stmt->bindValue(':observaciones', $this->getPedidoObservaciones());

            // ejecula y valida 
            if ($stmt->execute()) {

                // retorna mensaje de exito
                return ['status' => true, 'msj' => 'Pedido actualizado con éxito.'];
            } else {

                //retorna mensaje de error
                return ['status' => false, 'msj' => 'Error al actualizar el pedido.'];
            }
        } catch (PDOException $e) {

            // retorna mensaje de error con exception
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } 
        finally {

            //cierra la conexion
            $this->closeConnection();
        }
    }

    // Función para eliminar (desactivar) pedido
    private function Eliminar_Pedido() {

        // conexion cerrada
        $this->closeConnection();

        try {

            // establece conexion
            $conn = $this->getConnectionNegocio();

            // Iniciar transacción
            $conn->beginTransaction();

            // para datos antiguos de bitacora
            $query = "SELECT p.*,
                             ep.nombre_estado,
                             c.nombre_cliente,
                             c.tipo_id,
                             pg.nombre_estado as pago,
                             t.monto_tasa,
                             COALESCE(pm.nombre_promocion, 'Sin Promoción') as nombre_promocion,
                             GROUP_CONCAT(dp.cantidad SEPARATOR '<br> ') as cantidades,
                             GROUP_CONCAT(pr.nombre_producto SEPARATOR '<br> ') as productos
                             FROM pedidos p
                             LEFT JOIN detalle_pedidos dp ON dp.id_pedido = p.id_pedido
                             LEFT JOIN productos pr ON dp.id_producto = pr.id_producto
                             LEFT JOIN estado_pedido ep ON ep.id_estado_pedido = p.id_estado_pedido
                             LEFT JOIN clientes c ON c.id_cliente = p.id_cliente 
                             LEFT JOIN promociones pm ON pm.id_promocion = p.id_promocion
                             LEFT JOIN estado_pago pg ON pg.id_estado_pago = p.id_estado_pago
                             LEFT JOIN tasa_dia t ON t.id_tasa = p.id_tasa
                      WHERE p.id_pedido = :id_pedido
                      GROUP BY p.id_pedido
                      ORDER BY p.id_pedido DESC";

            //prepara la consulta
            $stmt = $conn->prepare($query);

            //vincula los datos
            $stmt->bindValue(':id_pedido', $this->getPedidoID());

            //ejecuta la sentencia
            $stmt->execute();

            //almacena los datos
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            //consulta para obtener detalle del pedido
            $queryDetalle = "SELECT * FROM detalle_pedidos WHERE id_pedido = :id";

            //prepara la consulta
            $stmtDetalle = $conn->prepare($queryDetalle);

            //vincula los datos
            $stmtDetalle->bindValue(':id', $this->getPedidoID());

            // ejecula la consulta
            $stmtDetalle->execute();

            // almacena los datos
            $dataDetalle = $stmtDetalle->fetchAll(PDO::FETCH_ASSOC);

            // valida el detalle
            if (empty($dataDetalle)) {

                //revierte
                $conn->rollBack();

                //msj de error
                return ['status' => false, 'msj' => 'No se encontraron detalles del pedido.'];
            }

            // Restaurar stock para CADA producto del pedido
            foreach ($dataDetalle as $detalle) {

                // se define y almacena array
                $idProducto = $detalle['id_producto'];
                $cantidad = (float) $detalle['cantidad'];

                // consulta para Verificar stock actual
                $queryStock = "SELECT stock 
                                FROM productos 
                                WHERE id_producto = :id_producto";

                //prepara la consulta
                $stmtStock = $conn->prepare($queryStock);

                // vincula los datos
                $stmtStock->bindValue(':id_producto', $idProducto);

                // ejecuta la consulta
                $stmtStock->execute();

                // se almacena sctock actual
                $stockActual = $stmtStock->fetchColumn() ?: 0;

                // se calcula el nuevo stock
                $nuevoStock = $stockActual + $cantidad;
                
                // consulta para Actualizar stock (sumar cantidad del pedido eliminado)
                $queryUpdateStock = "UPDATE productos SET stock = :nuevo_stock WHERE id_producto = :id_producto";
                
                // prepara la consulta
                $stmtUpdateStock = $conn->prepare($queryUpdateStock);

                //vincula los datos
                $stmtUpdateStock->bindValue(':nuevo_stock', $nuevoStock);
                $stmtUpdateStock->bindValue(':id_producto', $idProducto);

                // ejecuta y valida
                if (!$stmtUpdateStock->execute()) {

                    // revierte la transaccion
                    $conn->rollBack();

                    // msj de error
                    return ['status' => false, 'msj' => 'Error al restaurar stock del producto ID: ' . $idProducto];
                }
            }

            // consulta para eliminar cuenta cobrar
            $queryCuenta = "UPDATE cuenta_x_cobrar SET status = 0 WHERE id_pedido = :id";

            //prepara la consulta
            $stmtCuenta = $conn->prepare($queryCuenta);

            // vincula datos
            $stmtCuenta->bindValue(':id', $this->getPedidoID());

            // ejecuta la consulta
            $stmtCuenta->execute();

            // consulta para eliminar pedido
            $queryPedido = "UPDATE pedidos SET status = 0 WHERE id_pedido = :id";

            //prepara la consulta
            $stmtPedido = $conn->prepare($queryPedido);

            // vincula datos
            $stmtPedido->bindValue(':id', $this->getPedidoID());

            //valida y ejecuta
            if ($stmtPedido->execute()) {

                //confirma transaccion
                $conn->commit();

                // msj de exito
                return ['status' => true, 'msj' => 'Pedido eliminado con éxito.', 'data_bitacora' => $data];
            } 
            else {

                // revierte transaccion
                $conn->rollBack();

                // msj de error
                return ['status' => false, 'msj' => 'Error al eliminar el pedido.'];
            }
        } catch (PDOException $e) {

            //msj de error del sistema
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {

            //cierra conexion
            $this->closeConnection();
        }
    }

    // Función para cambiar estado del pedido
    private function Cambiar_Estado_Pedido() {

        // conexion cerrada
        $this->closeConnection();

        try {

            // establece conexion
            $conn = $this->getConnectionNegocio();

            // consulta para cambar estado
            $query = "UPDATE pedidos SET id_estado_pedido = :estado WHERE id_pedido = :id";

            //prepara la consulta
            $stmt = $conn->prepare($query);

            // vincula los datos
            $stmt->bindValue(':id', $this->getPedidoID());
            $stmt->bindValue(':estado', $this->getPedidoEstado());

            // ejecula y valida
            if ($stmt->execute()) {

                // msj de exito
                return ['status' => true, 'msj' => 'Estado del pedido actualizado'];
            } else {

                // msj de error
                return ['status' => false, 'msj' => 'Error al cambiar el estado del pedido.'];
            }
        } catch (PDOException $e) {
            
            //msj dinamico de error
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {

            //cierra conexion
            $this->closeConnection();
        }
    }

    // Función para guardar productos asociados a un pedido
    private function Guardar_Productos_Pedido($productos) {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $id_pedido = $this->getPedidoID();

            // Primero eliminar los productos existentes para este pedido
            $query_delete = "DELETE FROM detalle_pedidos WHERE id_pedido = :id_pedido";
            $stmt_delete = $conn->prepare($query_delete);
            $stmt_delete->bindValue(':id_pedido', $id_pedido);
            $stmt_delete->execute();

            // Insertar los nuevos productos
            if (!empty($productos) && is_array($productos)) {
                $query_insert = "INSERT INTO detalle_pedidos (id_pedido, id_producto, cantidad, precio_unitario) 
                                 VALUES (:id_pedido, :id_producto, :cantidad, :precio_unitario)";
                $stmt_insert = $conn->prepare($query_insert);

                foreach ($productos as $producto) {
                    $stmt_insert->bindValue(':id_pedido', $id_pedido);
                    $stmt_insert->bindValue(':id_producto', $producto['id_producto']);
                    $stmt_insert->bindValue(':cantidad', $producto['cantidad']);
                    $stmt_insert->bindValue(':precio_unitario', $producto['precio_unitario']);
                    $stmt_insert->execute();
                }
            }

            return ['status' => true, 'msj' => 'Productos asociados correctamente.'];
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error al asociar productos: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para obtener productos de un pedido
    private function Obtener_Productos_Pedido() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT dp.id_detalle_pedido, dp.id_producto, dp.cantidad, dp.precio_unitario, 
                             p.nombre_producto, p.precio_venta
                      FROM detalle_pedidos dp
                      INNER JOIN productos p ON dp.id_producto = p.id_producto
                      WHERE dp.id_pedido = :id_pedido AND p.status = 1";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id_pedido', $this->getPedidoID());
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return ['status' => true, 'msj' => 'Productos encontrados.', 'data' => $data];
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error al obtener productos: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para eliminar productos de un pedido
    private function Eliminar_Productos_Pedido() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "DELETE FROM detalle_pedidos WHERE id_pedido = :id_pedido";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':id_pedido', $this->getPedidoID());

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Productos eliminados correctamente.'];
            } else {
                return ['status' => false, 'msj' => 'Error al eliminar productos.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error al eliminar productos: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para obtener todos los pedidos con sus productos
    private function Mostrar_Pedidos_Con_Productos() {
        $this->closeConnection();
        try {
            $conn = $this->getConnectionNegocio();
            $query = "SELECT p.*,
                             (SELECT GROUP_CONCAT(pr.nombre_producto SEPARATOR ', ')
                              FROM detalle_pedidos dp
                              INNER JOIN productos pr ON dp.id_producto = pr.id_producto
                              WHERE dp.id_pedido = p.id_pedido AND pr.status = 1) as productos
                      FROM pedidos p
                      WHERE p.status = 1
                      ORDER BY p.id_pedido DESC";
            $stmt = $conn->prepare($query);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Pedidos encontrados con éxito.', 'data' => $data];
            } else {
                return ['status' => false, 'msj' => 'No hay pedidos registrados.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }
}
?>
