<?php
// llama al modelo conexion
require_once "ConexionModel.php";

// se define la clase
class Compra extends Conexion {

    // Atributos
    private $compra_id;
    private $compra_proveedor_id;
    private $compra_dias_credito;
    private $compra_fecha;
    private $compra_estado;
    private $compra_telefono;
    private $compra_direccion;
    private $compra_observaciones;
    private $compra_total;
    private $materiasPrimas = [];
    private $cantidades = [];
    private $precios = [];

    // constructor
    public function __construct() {
        parent::__construct();
    }

    // SETTER para datos completos
    private function setCompraUpdateData($compra_json) {

        // valida si el json es string y lo descompone
        if (is_string($compra_json)) {
            $compra = json_decode($compra_json, true);
            if ($compra === null) {
                return ['status' => false, 'msj' => 'JSON inválido.'];
            }
        } elseif (is_array($compra_json)) {
            $compra = $compra_json;
        } else {
            return ['status' => false, 'msj' => 'Formato de datos inválido.'];
        }

        // expresiones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $expre_telefono = '/^[0-9]{4}-[0-9]{7}$/';
        $expre_fecha = '/^\d{4}-\d{2}-\d{2}$/';
        $expre_decimal = '/^\d+(\.\d{1,2})?$/';

        // Validar ID
        $id = trim($compra['id'] ?? '');
        if ($id !== '' && (!preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0)) {
            return ['status' => false, 'msj' => 'El ID de la compra es invalido'];
        }
        $this->compra_id = $id;

        // Validar cliente_id
        $proveedor_id = trim($compra['proveedor_id'] ?? '');
        if ($proveedor_id === '' || !preg_match($expre_id, $proveedor_id) || strlen($proveedor_id) > 10 || $cproveedor_id < 0) {
            return ['status' => false, 'msj' => 'El ID del proveedpr es invalido'];
        }
        $this->compra_proveedor_id = $proveedor_id;

        // Validar fecha
        $fecha = trim($compra['fecha'] ?? '');
        if ($fecha === '' || !preg_match($expre_fecha, $fecha)) {
            return ['status' => false, 'msj' => 'La fecha debe tener formato YYYY-MM-DD.'];
        }
        $this->compra_fecha = $fecha;

        // Validar estado
        $estado = trim($compra['estado'] ?? '');
        if ($estado === '') {
            return ['status' => false, 'msj' => 'El estado de la compra es inválido. Debe seleccionar un uno.'];
        }
        $this->compra_estado = $estado;

        // Validar teléfono (opcional)
        $telefono = trim($compra['telefono'] ?? '');
        if ($telefono !== '' && !preg_match($expre_telefono, $telefono)) {
            return ['status' => false, 'msj' => 'El teléfono debe tener formato: 04XX-XXXXXXX'];
        }
        $this->compra_telefono = $telefono;
        
        // Validar dirección de entrega (opcional)
        $direccion = trim($compra['direccion'] ?? '');
        if (strlen($direccion) > 300) {
            return ['status' => false, 'msj' => 'La dirección no puede exceder 300 caracteres.'];
        }
        $this->compra_direccion = $direccion;

        // Validar observaciones (opcional)
        $observaciones = trim($compra['observaciones'] ?? '');
        if (strlen($observaciones) > 500) {
            return ['status' => false, 'msj' => 'Las observaciones no pueden exceder 500 caracteres.'];
        }
        $this->compra_observaciones = $observaciones;

        return ['status' => true, 'msj' => 'Datos validados y asignados correctamente.'];
    }

    private function setCompraData($compra_json) {

        // valida si el json es string y lo descompone
        if (is_string($compra_json)) {
            $compra = json_decode($compra_json, true);
            if ($compra === null) {
                return ['status' => false, 'msj' => 'JSON inválido.'];
            }
        } elseif (is_array($compra_json)) {
            $compra = $compra_json;
        } else {
            return ['status' => false, 'msj' => 'Formato de datos inválido.'];
        }

        // expresiones regulares y validaciones
        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $expre_telefono = '/^[0-9]{4}-[0-9]{7}$/';
        $expre_fecha = '/^\d{4}-\d{2}-\d{2}$/';
        $expre_decimal = '/^\d+(\.\d{1,2})?$/';

        // Validar cliente_id
        $proveedor_id = trim($compra['proveedor_id'] ?? '');
        if ($proveedor_id === '' || !preg_match($expre_id, $proveedor_id) || strlen($proveedor_id) > 10 || $proveedor_id < 0) {
            return ['status' => false, 'msj' => 'El ID del proveedpr es invalido'];
        }
        $this->compra_proveedor_id = $proveedor_id;

        // Validar dias credito
        $dias = trim($compra['dias_credito'] ?? '');
        if ($dias === '') {
            return ['status' => false, 'msj' => 'El dia es invalido'];
        }
        $this->compra_dias_credito = $dias;

        // Validar fecha
        $fecha = trim($compra['fecha'] ?? '');
        if ($fecha === '' || !preg_match($expre_fecha, $fecha)) {
            return ['status' => false, 'msj' => 'La fecha debe tener formato YYYY-MM-DD.'];
        }
        $this->compra_fecha = $fecha;

        // Validar estado
        $estado = trim($compra['estado'] ?? '');
        if ($estado === '') {
            return ['status' => false, 'msj' => 'El estado de la compra es inválido. Debe seleccionar un uno.'];
        }
        $this->compra_estado = $estado;

        // Validar observaciones (opcional)
        $observaciones = trim($compra['observaciones'] ?? '');
        if (strlen($observaciones) > 300) {
            return ['status' => false, 'msj' => 'Las observaciones no pueden exceder 300 caracteres.'];
        }
        $this->compra_observaciones = $observaciones;

        // Validar total
        $total = trim($compra['total'] ?? '');
        if ($total === '' || !is_numeric($total) || $total < 0) {
            return ['status' => false, 'msj' => 'El total de la compra es invalido.'];
        }
        if (!preg_match($expre_decimal, $total)) {
            return ['status' => false, 'msj' => 'El total debe tener máximo 2 decimales.'];
        }
        $this->compra_total = $total;

        // Validar productos (ARRAY)
        $materiaPrimas_raw = $compra['materiasPrimas'] ?? [];
        if (!is_array($materiaPrimas_raw)) {
            $materiaPrimas_raw = [$materiaPrimas_raw];  // convertir string único a array
        }

        $materiaPrima = array_filter(array_map('trim', $materiaPrimas_raw), function($p) {
            return !empty($p);
        });

        if (empty($materiaPrima)) {
            return ['status' => false, 'msj' => 'Debe seleccionar al menos una materia prima.'];
        }

        $this->materiasPrimas = $materiaPrima;  // array limpio ["7", "6"]

        // Validar cantidades (ARRAY)
        $cantidad_raw = $compra['cantidades'] ?? [];
        if (!is_array($cantidad_raw)) {
            $cantidad_raw = [$cantidad_raw];  // convertir string único a array
        }

        $cantidad = array_filter(array_map('trim', $cantidad_raw), function($p) {
            return !empty($p);
        });

        if (empty($cantidad)) {
            return ['status' => false, 'msj' => 'Debe seleccionar al menos una materia prima.'];
        }

        $this->cantidades = $cantidad;  // array limpio ["7", "6"]

        // Validar precios (ARRAY)
        $precio_raw = $compra['precios'] ?? [];
        if (!is_array($precio_raw)) {
            $precio_raw = [$precio_raw];
        }

        $precio = array_filter(array_map(function($p) {
            $p = trim($p);
            return $p !== '' ? round((float)$p, 2) : null;
        }, $precio_raw));

        if (empty($precio)) {
            return ['status' => false, 'msj' => 'Debe seleccionar al menos una materia prima.'];
        }

        $this->precios = $precio;

        return ['status' => true, 'msj' => 'Datos validados y asignados correctamente.'];
    }

        private function setCompraEstado($compra_json) {
        if (is_string($compra_json)) {
            $compra = json_decode($compra_json, true);
            if ($compra === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        } else {
            $compra = $compra_json;
        }

        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $id = trim($compra['id'] ?? '');
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0) {
            return ['status' => false, 'msj' => 'El ID del la compra es invalido'];
        }
        $this->compra_id = $id;

        $estado = trim($compra['nuevo_estado'] ?? '');
        if ($id === '') {
            return ['status' => false, 'msj' => 'El estado de la compra es invalido'];
        }
        $this->compra_estado = $estado;

        return ['status' => true, 'msj' => 'ID validado correctamente.'];
    }

    private function setCompraProveedor($compra_json) {
        if (is_string($compra_json)) {
            $compra = json_decode($compra_json, true);
            if ($compra === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        } else {
            $compra = $compra_json;
        }

        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $id = trim($compra['id'] ?? '');
        if ($id === '') {
            return ['status' => false, 'msj' => 'El ID es invalido'];
        }
        $this->compra_proveedor_id = $id;

        return ['status' => true, 'msj' => 'ID validado correctamente.'];
    }

    // SETTER para ID
    private function setCompraID($compra_json) {
        if (is_string($compra_json)) {
            $compra = json_decode($compra_json, true);
            if ($compra === null) {
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        } else {
            $compra = $compra_json;
        }

        $expre_id = '/^(0|[1-9][0-9]*)$/';
        $id = trim($compra['id'] ?? '');
        if ($id === '' || !preg_match($expre_id, $id) || strlen($id) > 10 || $id < 0) {
            return ['status' => false, 'msj' => 'El ID de la compra es invalido'];
        }
        $this->compra_id = $id;

        return ['status' => true, 'msj' => 'ID validado correctamente.'];
    }

    // GETTERS
    private function getCompraID() {
        return $this->compra_id;
    }

    private function getCompraProveedorID() {
        return $this->compra_proveedor_id;
    }

    private function getCompraCredito() {
        return $this->compra_dias_credito;
    }

    private function getCompraFecha() {
        return $this->compra_fecha;
    }

    private function getCompraEstado() {
        return $this->compra_estado;
    }

    private function getCompraObservaciones() {
        return $this->compra_observaciones;
    }

    private function getCompraTotal() {
        return $this->compra_total;
    }

    private function getCompraMateriaPrima() {
        return $this->materiasPrimas;
    }

    private function getCompraCantidad() {
        return $this->cantidades;
    }

    private function getCompraPrecio() {
        return $this->precios;
    }

    // Manejador de acciones
    public function manejarAccion($action, $compra_json) {
        switch($action) {

            case 'agregar':
            
                // almacena y llama validacion
                $validacion = $this->setCompraData($compra_json);
                
                // valida validacion
                if (!$validacion['status']) {
                    
                    // retorna validacion
                    return $validacion;
                }

                // retorna valor de la funcion
                return $this->Guardar_Compra();

            break;

            case 'obtener':

                // almacena y llama validacion
                $validacion = $this->setCompraID($compra_json);
                
                // valida validacion
                if (!$validacion['status']) {
                    
                // retorna valor de la funcion
                    return $validacion;
                }

                // retorna valor de la funcion
                return $this->Obtener_Compra();

            break;

            case 'obtenerMateria':

                // almacena y llama validacion
                $validacion = $this->setCompraProveedor($compra_json);
                
                // valida validacion
                if (!$validacion['status']) {
                    
                // retorna valor de la funcion
                    return $validacion;
                }

                // retorna valor de la funcion
                return $this->Obtener_Materia_Proveedor();

            break;

            case 'eliminar':

                // almacena y llama validacion
                $validacion = $this->setCompraID($compra_json);

                // valida validacion
                if (!$validacion['status']) {

                // retorna valor de la funcion
                    return $validacion;
                }

                // retorna valor de la funcion
                return $this->Eliminar_Compra();

            break;

            case 'consultar':

                // retorna valor de la funcion
                return $this->Mostrar_Compra();

            break;

            case 'consultar_estado':

                // retorna valor de la funcion
                return $this->Mostrar_Estado();

            break;

            default:
                return ['status' => false, 'msj' => 'Accion Invalida.'];
            break;
        }
    }

    // Función para consultar pedidos
    private function Mostrar_Compra() {

        // conexion cerrada
        $this->closeConnection();

        try {

            // establece conexion
            $conn = $this->getConnectionNegocio();

            // consulta para mostrar compra
            $query = "SELECT c.*,
                             pg.nombre_estado as pago,
                             pr.nombre_proveedor,
                             pr.tipo_id,
                             t.monto_tasa,
                             mp.id_materia_prima,
                             GROUP_CONCAT(dc.cantidad SEPARATOR '<br> ') as cantidades,
                             GROUP_CONCAT(mp.nombre_materia_prima SEPARATOR '<br> ') as materiaPrima
                             FROM compras c
                             LEFT JOIN detalle_compras dc ON dc.id_compra = c.id_compra
                             LEFT JOIN materia_prima mp ON mp.id_materia_prima = dc.id_materia_prima
                             LEFT JOIN proveedores pr ON pr.id_proveedor = c.id_proveedor 
                             LEFT JOIN estado_pago pg ON pg.id_estado_pago = c.id_estado_pago
                             LEFT JOIN tasa_dia t ON t.id_tasa = c.id_tasa
                      WHERE c.status = 1
                      GROUP BY c.id_compra
                      ORDER BY c.id_compra DESC";

            //prepara la consulta
            $stmt = $conn->prepare($query);

            //ejecuta la sentencia
            $stmt->execute();

            // valida si se ejecuto
            if ($stmt->rowCount() > 0) {

                // se almacena los datos en una var
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // msj de exito
                return ['status' => true, 'msj' => 'Compras encontrados con éxito.', 'data' => $data];
            } else {

                // msj de error
                return ['status' => false, 'msj' => 'No hay Compras registrados.'];
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
                      FROM estado_pago";

            //prepara la consulta
            $stmt = $conn->prepare($query);
            
            //ejecuta la consulta
            $stmt->execute();

            // valida si se ejecuto la consu;ta
            if ($stmt->rowCount() > 0) {

                // se almacena los datos
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                
                // msj de exito
                return ['status' => true, 'msj' => 'Estado Compra encontrados con exito.', 'data' => $data];
            } else {

                // msj de error
                return ['status' => false, 'msj' => 'No hay estado compra registrados.'];
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
    private function Guardar_Compra() {

    // conexion cerrada
    $this->closeConnection();

    try {
        // establece la conexion
        $conn = $this->getConnectionNegocio();

        // Iniciar transacción
        $conn->beginTransaction();

        // almacena los arrays de materias primas
        $materiasPrimas = $this->getCompraMateriaPrima();
        $cantidades = $this->getCompraCantidad();
        $precios = $this->getCompraPrecio();

        // valida si es array
        if (!is_array($materiasPrimas)) $materiasPrimas = [$materiasPrimas];
        if (!is_array($cantidades)) $cantidades = [$cantidades];
        if (!is_array($precios)) $precios = [$precios];

        // valida que coincidan
        if (
            empty($materiasPrimas) ||
            count($materiasPrimas) !== count($cantidades) ||
            count($materiasPrimas) !== count($precios)
        ) {

            // revierte transaccion
            $conn->rollBack();

            // msj de error
            return ['status' => false, 'msj' => 'Materias primas, cantidades y precios no coinciden'];
        }

        // valida que haya al menos una materia prima
        if (count($materiasPrimas) === 0) {

            // revierte transaccion
            $conn->rollBack();

            //retorna msj de error
            return ['status' => false, 'msj' => 'Debe agregar al menos una materia prima'];
        }

        // inicializa var para el detalle
        $detalleCompra = [];
        $totalCalculado = 0;

        // bucle para recorrer el array
        for ($i = 0; $i < count($materiasPrimas); $i++) {
            $materiaPrimaId = trim((string)$materiasPrimas[$i]);
            $cantidad = (float)$cantidades[$i];
            $precioRecibido = round((float)$precios[$i], 2);

            // valida cantidad
            if ($cantidad <= 0) {

                // revierte transaccion
                $conn->rollBack();

                // retorna msj de error
                return ['status' => false, 'msj' => 'Las cantidades deben ser mayores a cero.'];
            }

            // valida precio
            if ($precioRecibido <= 0) {

                // revuerte transaccion
                $conn->rollBack();

                //retorna msj de error
                return ['status' => false, 'msj' => 'Los precios deben ser mayores a cero.'];
            }

            // calcula subtotal
            $subtotal = $cantidad * $precioRecibido;
            $totalCalculado += $subtotal;

            // almacena en array de detalle
            $detalleCompra[] = [
                'materia_prima_id' => $materiaPrimaId,
                'cantidad' => $cantidad,
                'precio' => $precioRecibido,
                'subtotal' => $subtotal
            ];
        }

        // valida el total calculado con el total recibido
        $totalRecibido = (float)$this->getCompraTotal();
        
        // Redondear para comparación (evitar problemas con decimales)
        $totalCalculado = round($totalCalculado, 2);
        $totalRecibido = round($totalRecibido, 2);

        if ($totalCalculado !== $totalRecibido) {

            // revierte transaccion
            $conn->rollBack();

            // retorna msj de error
            return ['status' => false, 'msj' => "El total calculado ($totalCalculado) no coincide con el total recibido ($totalRecibido)."];
        }

        // Obtener tasa del día (si aplica para compras)
        $queryTasa = "SELECT * FROM tasa_dia 
            WHERE status = 1 
            ORDER BY id_tasa DESC, fecha_tasa DESC 
            LIMIT 1";

        // prepara consulta
        $stmtTasa = $conn->prepare($queryTasa);

        // ejecuta la consulta
        $stmtTasa->execute();

        // obtiene tasa
        $tasaData = $stmtTasa->fetch(PDO::FETCH_ASSOC);

        // akmacena la tasa
        $idTasa = $tasaData ? $tasaData['id_tasa'] : null;

        // consulta para insertar compra
        $queryInsert = "INSERT INTO compras (id_proveedor, fecha_compra, id_estado_pago, monto_total_compra, observaciones, id_tasa) 
                                VALUES (:proveedor_id, :fecha, :estado, :total, :observaciones, :tasa)";
        
        // prepara la consulta
        $stmtInsert = $conn->prepare($queryInsert);

        // vincula los datos
        $stmtInsert->bindValue(':proveedor_id', $this->getCompraProveedorID());
        $stmtInsert->bindValue(':fecha', $this->getCompraFecha());
        $stmtInsert->bindValue(':estado', $this->getCompraEstado());
        $stmtInsert->bindValue(':total', $this->getCompraTotal());
        $stmtInsert->bindValue(':observaciones', $this->getCompraObservaciones());
        $stmtInsert->bindValue(':tasa', $idTasa);

        // ejecuta la sentencia
        $stmtInsert->execute();
            
        // Obtener el ID de la compra recién insertada
        $ultimo_id = $conn->lastInsertId();

        // bucle para insertar los detalles de la compra y actualizar el stock de materias primas
        foreach ($detalleCompra as $detalle) {
            $idMateriaPrima = $detalle['materia_prima_id'];
            $cantidad = $detalle['cantidad'];
            $precio = $detalle['precio'];
            $subtotal = $detalle['subtotal'];

            // consulta para insertar el detalle de la compra
            $queryInsertDetalle = "INSERT INTO detalle_compras (id_compra, id_materia_prima, cantidad, precio_unitario) 
                                                        VALUES (:id_compra, :id_materia_prima, :cantidad, :precio)";
                         
            // prepara la consulta
            $stmtInsertDetalle = $conn->prepare($queryInsertDetalle);

            // vincula los datos
            $stmtInsertDetalle->bindValue(':id_compra', $ultimo_id);
            $stmtInsertDetalle->bindValue(':id_materia_prima', $idMateriaPrima);
            $stmtInsertDetalle->bindValue(':cantidad', $cantidad);
            $stmtInsertDetalle->bindValue(':precio', $precio);

            // ejecuta la consulta
            $stmtInsertDetalle->execute();
            
            // consulta para obtener el stock actual de la materia prima
            $queryStock = "SELECT stock_actual 
                          FROM materia_prima 
                          WHERE id_materia_prima = :id_materia_prima";

            // prepra la consulta
            $stmtStock = $conn->prepare($queryStock);

            // vincula los dats
            $stmtStock->bindValue(':id_materia_prima', $idMateriaPrima);

            //ejecuta la consulta
            $stmtStock->execute();

            // obtien y almacena los datos
            $stockActual = $stmtStock->fetch(PDO::FETCH_ASSOC)['stock_actual'] ?? 0;

            // ACTUALIZAR STOCK: En compras se SUMA al stock existente
            $nuevoStock = $stockActual + $cantidad;

            // consulta para actualizar el stock de la materia prima
            $queryUpdateStock = "UPDATE materia_prima 
                                SET stock_actual = :nuevoStock 
                                WHERE id_materia_prima = :id_materia_prima";
            
            // prepara la consulta
            $stmtUpdateStock = $conn->prepare($queryUpdateStock);

            // vincula los datos 
            $stmtUpdateStock->bindValue(':id_materia_prima', $idMateriaPrima);
            $stmtUpdateStock->bindValue(':nuevoStock', $nuevoStock);

            // ejecuta la consulta
            $stmtUpdateStock->execute();
        }

        // Obtener datos
            $fecha = $this->getCompraFecha();  // "2026-05-07"
            $dias = (int)$this->getCompraCredito();  // 15

            //CÁLCULO
            $fechaInicio = new DateTime($fecha);
            $fechaInicio->add(new DateInterval('P' . $dias . 'D'));  // +15 días
            $vencimiento = $fechaInicio->format('Y-m-d');  // "2026-05-22"

            // se define estado
            $estado = 1;

            //consulta para registrar cuenta pagar
            $queryInsertCuenta = "INSERT INTO cuenta_x_pagar (id_compra, id_proveedor, monto_total, saldo_pendiente, fecha_emision, fecha_vencimiento, estado_pago)
                                        VALUES (:id_compra, :proveedor_id, :monto, :saldo, :fecha, :vencimiento, :estado)";
            
            // prepara la consulta
            $stmtInsertCuenta = $conn->prepare($queryInsertCuenta);

            // vincula los datos
            $stmtInsertCuenta->bindValue(':id_compra', $ultimo_id);
            $stmtInsertCuenta->bindValue(':proveedor_id', $this->getCompraProveedorID());
            $stmtInsertCuenta->bindValue(':monto', $this->getCompraTotal());
            $stmtInsertCuenta->bindValue(':saldo', $this->getCompraTotal());
            $stmtInsertCuenta->bindValue(':fecha', $this->getCompraFecha());
            $stmtInsertCuenta->bindValue(':vencimiento', $vencimiento);
            $stmtInsertCuenta->bindValue(':estado', $estado);

            // ejecuta la sentencia
            $stmtInsertCuenta->execute();

            // si todo se ejecuta correctamente se confirma la transaccion
            $conn->commit();;

        // retorna msj de exito
        return ['status' => true, 'msj' => 'Compra guardada exitosamente.'];
        
    } catch (PDOException $e) {
        
        // valida si hay un error en alguna consulta
        if (isset($conn) && $conn->inTransaction()) {

            // Revierte la transacción si hay un error
            $conn->rollBack();
        }

        // msj de error dinámico
        return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()
        ];
    } finally {

        // cierra la conexion
        $this->closeConnection();
    }
}

    // Función para obtener un pedido
    private function Obtener_Compra() {

        // conexion cerrada
        $this->closeConnection();

        try {

            // establece conecion
            $conn = $this->getConnectionNegocio();

            //consulta para obtener
            $query = "SELECT c.*,
                             pg.nombre_estado as pago,
                             pr.nombre_proveedor,
                             pr.tipo_id,
                             t.monto_tasa,
                             mp.id_materia_prima,
                             GROUP_CONCAT(dc.cantidad SEPARATOR '<br> ') as cantidades,
                             GROUP_CONCAT(mp.nombre_materia_prima SEPARATOR '<br> ') as materiaPrima
                             FROM compras c
                             LEFT JOIN detalle_compras dc ON dc.id_compra = c.id_compra
                             LEFT JOIN materia_prima mp ON mp.id_materia_prima = dc.id_materia_prima
                             LEFT JOIN proveedores pr ON pr.id_proveedor = c.id_proveedor 
                             LEFT JOIN estado_pago pg ON pg.id_estado_pago = c.id_estado_pago
                             LEFT JOIN tasa_dia t ON t.id_tasa = c.id_tasa
                      WHERE c.id_compra = :id_compra
                      GROUP BY c.id_compra
                      ORDER BY c.id_compra DESC";

            //prepara la consulta
            $stmt = $conn->prepare($query);

            //vincula los datos
            $stmt->bindValue(':id_compra', $this->getCompraID());

            //ejecuta la sentencia
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Compra encontrado con éxito.', 'data' => $data, 'data_bitacora' => $data];
            } else {
                return ['status' => false, 'msj' => 'Compra no encontrado.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    private function Obtener_Materia_Proveedor() {

        // conexion cerrada
        $this->closeConnection();
        
        try {

            // establece conexion
            $conn = $this->getConnectionNegocio();
            
            // consulta para obtener
            $query = "SELECT *
                            FROM materia_prima
                            WHERE CAST(id_proveedor AS CHAR) = :id_proveedor 
                            AND status = 1";

            //prepara la consulta
            $stmt = $conn->prepare($query);

            //vincula los datos
            $stmt->bindValue(':id_proveedor', $this->getCompraProveedorID());

            //ejecuta la sentencia
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return ['status' => true, 'msj' => 'Encontrado con éxito.', 'data' => $data, 'data_bitacora' => $data];
            } else {
                return ['status' => false, 'msj' => 'No encontrado.'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
        } finally {
            $this->closeConnection();
        }
    }

    // Función para eliminar (desactivar) pedido
    private function Eliminar_Compra() {

    // conexion cerrada
    $this->closeConnection();

    try {
        // establece conexion
        $conn = $this->getConnectionNegocio();

        // Iniciar transacción
        $conn->beginTransaction();

        // Obtener datos antiguos para bitácora
        $query = "SELECT c.*,
                             pg.nombre_estado as pago,
                             pr.nombre_proveedor,
                             pr.tipo_id,
                             t.monto_tasa,
                             mp.id_materia_prima,
                             GROUP_CONCAT(dc.cantidad SEPARATOR '<br> ') as cantidades,
                             GROUP_CONCAT(mp.nombre_materia_prima SEPARATOR '<br> ') as materiaPrima
                             FROM compras c
                             LEFT JOIN detalle_compras dc ON dc.id_compra = c.id_compra
                             LEFT JOIN materia_prima mp ON mp.id_materia_prima = dc.id_materia_prima
                             LEFT JOIN proveedores pr ON pr.id_proveedor = c.id_proveedor 
                             LEFT JOIN estado_pago pg ON pg.id_estado_pago = c.id_estado_pago
                             LEFT JOIN tasa_dia t ON t.id_tasa = c.id_tasa
                      WHERE c.id_compra = :id_compra
                      GROUP BY c.id_compra
                      ORDER BY c.id_compra DESC";

        // prepara la consulta
        $stmt = $conn->prepare($query);

        // vincula los datos
        $stmt->bindValue(':id_compra', $this->getCompraID());

        // ejecuta la sentencia
        $stmt->execute();

        // almacena los datos
        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        // valida que exista la compra
        if (!$data) {

            // revierte transaccion
            $conn->rollBack();

            // retorna msj de error
            return ['status' => false, 'msj' => 'No se encontró la compra.'];
        }

        // consulta para obtener detalle de la compra
        $queryDetalle = "SELECT * FROM detalle_compras WHERE id_compra = :id_compra";

        // prepara la consulta
        $stmtDetalle = $conn->prepare($queryDetalle);

        // vincula los datos
        $stmtDetalle->bindValue(':id_compra', $this->getCompraID());

        // ejecuta la consulta
        $stmtDetalle->execute();

        // almacena los datos
        $dataDetalle = $stmtDetalle->fetchAll(PDO::FETCH_ASSOC);

        // valida el detalle
        if (empty($dataDetalle)) {

            // revierte
            $conn->rollBack();

            // msj de error
            return ['status' => false, 'msj' => 'No se encontraron detalles de la compra.'];
        }

        // Restaurar stock para CADA materia prima de la compra (RESTAR stock porque se elimina la compra)
        foreach ($dataDetalle as $detalle) {
            // se define y almacena array
            $idMateriaPrima = $detalle['id_materia_prima'];
            $cantidad = (float) $detalle['cantidad'];

            // consulta para verificar stock actual de la materia prima
            $queryStock = "SELECT stock_actual 
                          FROM materia_prima
                          WHERE id_materia_prima = :id_materia_prima";

            // prepara la consulta
            $stmtStock = $conn->prepare($queryStock);

            // vincula los datos
            $stmtStock->bindValue(':id_materia_prima', $idMateriaPrima);

            // ejecuta la consulta
            $stmtStock->execute();

            // se almacena stock actual
            $stockActual = $stmtStock->fetchColumn() ?: 0;

            // IMPORTANTE: Al eliminar una compra, RESTAMOS el stock que se había sumado
            // porque la compra ya no existe y ese material no debe estar en inventario
            $nuevoStock = $stockActual - $cantidad;

            // Validar que no quede stock negativo
            if ($nuevoStock < 0) {

                // revierte
                $conn->rollBack();

                // retorna msj de error
                return ['status' => false, 'msj' => 'Error: Al eliminar la compra, el stock quedaría negativo. Stock actual: ' . $stockActual . ', Cantidad a restar: ' . $cantidad
                ];
            }
            
            // consulta para actualizar stock (RESTAR cantidad de la materia prima)
            $queryUpdateStock = "UPDATE materia_prima
                                SET stock_actual = :nuevo_stock 
                                WHERE id_materia_prima = :id_materia_prima";
            
            // prepara la consulta
            $stmtUpdateStock = $conn->prepare($queryUpdateStock);

            // vincula los datos
            $stmtUpdateStock->bindValue(':nuevo_stock', $nuevoStock);
            $stmtUpdateStock->bindValue(':id_materia_prima', $idMateriaPrima);

            // ejecuta y valida
            if (!$stmtUpdateStock->execute()) {

                // revierte la transaccion
                $conn->rollBack();

                // msj de error
                return ['status' => false, 'msj' => 'Error al restaurar stock de la materia prima ID: ' . $idMateriaPrima];
            }
        }

        // Si existe cuenta por pagar, actualizar su estado (opcional)
        $queryCuenta = "UPDATE cuenta_x_pagar 
                       SET status = 0 
                       WHERE id_compra = :id_compra AND status = 1";

        // prepara la consulta
        $stmtCuenta = $conn->prepare($queryCuenta);

        // vincula datos
        $stmtCuenta->bindValue(':id_compra', $this->getCompraID());

        // ejecuta la consulta
        $stmtCuenta->execute();

        // consulta para eliminar compra (soft delete)
        $queryCompra = "UPDATE compras SET status = 0 WHERE id_compra = :id_compra";

        // prepara la consulta
        $stmtCompra = $conn->prepare($queryCompra);

        // vincula datos
        $stmtCompra->bindValue(':id_compra', $this->getCompraID());

        // valida y ejecuta
        if ($stmtCompra->execute()) {

            // confirma transaccion
            $conn->commit();

            // msj de exito
            return ['status' => true, 'msj' => 'Compra eliminada con éxito.', 'data_bitacora' => $data];
        } else {

            // revierte transaccion
            $conn->rollBack();

            // msj de error
            return ['status' => false, 'msj' => 'Error al eliminar la compra.'];
        }
        
    } catch (PDOException $e) {

        // valida si hay transacción activa
        if (isset($conn) && $conn->inTransaction()) {

            // revierte
            $conn->rollBack();
        }
        
        // msj de error del sistema
        return ['status' => false, 'msj' => 'Error en la consulta: ' . $e->getMessage()];
    } finally {

        // cierra conexion
        $this->closeConnection();
    }
}

}
?>
