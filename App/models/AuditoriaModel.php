<?php
/**
 * Modelo de Auditoria - Registra todas las transacciones de la base de datos
 * 
 * Este modelo permite:
 * - Registro automatico de todas las operaciones CRUD
 * - Almacenamiento de datos anteriores y nuevos (para recuperacion)
 * - Auditoria completa de acciones de usuarios
 * - Registro de IP y user agent
 * - Deteccion de operaciones fallidas
 */

require_once "ConexionModel.php";

class Auditoria extends Conexion {
    
    // Atributos de la bitacora
    private $id_bitacora;
    private $id_usuario;
    private $modulo;
    private $accion;
    private $tabla_afectada;
    private $registro_id;
    private $tipo_operacion;
    private $descripcion;
    private $datos_anteriores;
    private $datos_nuevos;
    private $ip_address;
    private $user_agent;
    private $resultado;
    private $error_mensaje;
    private $fecha_bitacora;
    
    private $error;

    // Tipos de operaciones soportadas
    const OP_INSERT = 'INSERT';
    const OP_UPDATE = 'UPDATE';
    const OP_DELETE = 'DELETE';
    const OP_SELECT = 'SELECT';
    const OP_LOGIN = 'LOGIN';
    const OP_LOGOUT = 'LOGOUT';
    const OP_EXPORT = 'EXPORT';
    const OP_IMPORT = 'IMPORT';

    // Resultados posibles
    const RES_EXITOSO = 'EXITOSO';
    const RES_FALLIDO = 'FALLIDO';

    public function __construct() {
        parent::__construct();
        $this->error = null;
        $this->limpiarDatos();
    }

    /**
     * Limpia todos los datos del objeto para reutilizacion
     */
    private function limpiarDatos() {
        $this->id_bitacora = null;
        $this->id_usuario = null;
        $this->modulo = null;
        $this->accion = null;
        $this->tabla_afectada = null;
        $this->registro_id = null;
        $this->tipo_operacion = self::OP_SELECT;
        $this->descripcion = null;
        $this->datos_anteriores = null;
        $this->datos_nuevos = null;
        $this->ip_address = $this->getClientIP();
        $this->user_agent = $this->getUserAgent();
        $this->resultado = self::RES_EXITOSO;
        $this->error_mensaje = null;
        $this->fecha_bitacora = null;
    }

    // ==================== SETTERS ====================

    public function setIdUsuario($id_usuario) {
        $this->id_usuario = $id_usuario;
        return $this;
    }

    public function setModulo($modulo) {
        $this->modulo = $modulo;
        return $this;
    }

    public function setAccion($accion) {
        $this->accion = $accion;
        return $this;
    }

    public function setTablaAfectada($tabla) {
        $this->tabla_afectada = $tabla;
        return $this;
    }

    public function setRegistroId($id) {
        $this->registro_id = $id;
        return $this;
    }

    public function setTipoOperacion($tipo) {
        $tipos_validos = [self::OP_INSERT, self::OP_UPDATE, self::OP_DELETE, 
                         self::OP_SELECT, self::OP_LOGIN, self::OP_LOGOUT,
                         self::OP_EXPORT, self::OP_IMPORT];
        
        if (in_array($tipo, $tipos_validos)) {
            $this->tipo_operacion = $tipo;
        }
        return $this;
    }

    public function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function setDatosAnteriores($datos) {
        if (is_array($datos) || is_object($datos)) {
            $this->datos_anteriores = json_encode($datos);
        } else {
            $this->datos_anteriores = $datos;
        }
        return $this;
    }

    public function setDatosNuevos($datos) {
        if (is_array($datos) || is_object($datos)) {
            $this->datos_nuevos = json_encode($datos);
        } else {
            $this->datos_nuevos = $datos;
        }
        return $this;
    }

    public function setResultado($resultado) {
        $this->resultado = $resultado === self::RES_EXITOSO ? self::RES_EXITOSO : self::RES_FALLIDO;
        return $this;
    }

    public function setErrorMensaje($mensaje) {
        $this->error_mensaje = $mensaje;
        $this->resultado = self::RES_FALLIDO;
        return $this;
    }

    // ==================== GETTERS ====================

    public function getError() {
        return $this->error;
    }

    public function getIdBitacora() {
        return $this->id_bitacora;
    }

    // ==================== METODOS DE AUDITORIA ====================

    /**
     * Registra una operacion en la bitacora
     * Compatible con estructura antigua y nueva
     * 
     * @return bool True si se registro correctamente, False en caso de error
     */
    public function registrar() {
        try {
            $conn = $this->getConnectionSeguridad();
            
            // Verificar si las columnas nuevas existen
            $checkCol = $conn->query("SHOW COLUMNS FROM bitacoras LIKE 'tipo_operacion'");
            $columnasNuevasExisten = $checkCol->rowCount() > 0;
            
            if ($columnasNuevasExisten) {
                // Usar estructura completa con nuevas columnas
                $query = "INSERT INTO bitacoras (
                            id_usuario, modulo, accion, tabla_afectada, registro_id,
                            tipo_operacion, descripcion, datos_anteriores, datos_nuevos,
                            ip_address, user_agent, resultado, error_mensaje, fecha_bitacora
                        ) VALUES (
                            :id_usuario, :modulo, :accion, :tabla_afectada, :registro_id,
                            :tipo_operacion, :descripcion, :datos_anteriores, :datos_nuevos,
                            :ip_address, :user_agent, :resultado, :error_mensaje, NOW()
                        )";
                
                $stmt = $conn->prepare($query);
                $stmt->bindParam(":id_usuario", $this->id_usuario);
                $stmt->bindParam(":modulo", $this->modulo);
                $stmt->bindParam(":accion", $this->accion);
                $stmt->bindParam(":tabla_afectada", $this->tabla_afectada);
                $stmt->bindParam(":registro_id", $this->registro_id);
                $stmt->bindParam(":tipo_operacion", $this->tipo_operacion);
                $stmt->bindParam(":descripcion", $this->descripcion);
                $stmt->bindParam(":datos_anteriores", $this->datos_anteriores);
                $stmt->bindParam(":datos_nuevos", $this->datos_nuevos);
                $stmt->bindParam(":ip_address", $this->ip_address);
                $stmt->bindParam(":user_agent", $this->user_agent);
                $stmt->bindParam(":resultado", $this->resultado);
                $stmt->bindParam(":error_mensaje", $this->error_mensaje);
            } else {
                // Usar estructura antigua (compatibilidad)
                $query = "INSERT INTO bitacoras (
                            id_usuario, modulo, accion, descripcion, fecha_bitacora
                        ) VALUES (
                            :id_usuario, :modulo, :accion, :descripcion, NOW()
                        )";
                
                $stmt = $conn->prepare($query);
                $stmt->bindParam(":id_usuario", $this->id_usuario);
                $stmt->bindParam(":modulo", $this->modulo);
                
                // Combinar accion y tipo_operacion en la descripcion para compatibilidad
                $accionCompleta = $this->accion;
                if ($this->tabla_afectada) {
                    $accionCompleta .= " [Tabla: " . $this->tabla_afectada . "]";
                }
                if ($this->tipo_operacion) {
                    $accionCompleta .= " [Op: " . $this->tipo_operacion . "]";
                }
                $stmt->bindParam(":accion", $accionCompleta);
                
                // Combinar descripcion con datos extras
                $descripcionCompleta = $this->descripcion;
                if ($this->error_mensaje) {
                    $descripcionCompleta .= " ERROR: " . $this->error_mensaje;
                }
                $stmt->bindParam(":descripcion", $descripcionCompleta);
            }
            
            $resultado = $stmt->execute();
            
            // Limpiar datos para siguiente uso
            $this->limpiarDatos();
            
            return $resultado;
            
        } catch(PDOException $e) {
            $this->error = "Error en registrar auditoria: " . $e->getMessage();
            error_log($this->error);
            return false;
        } finally {
            $this->closeConnection();
        }
    }

    /**
     * Metodo estatico para registro rapido de auditoria
     * 
     * @param int|null $id_usuario ID del usuario o null si es operacion de sistema
     * @param string $modulo Nombre del modulo (ej: 'Productos', 'Usuarios')
     * @param string $accion Descripcion de la accion realizada
     * @param string $tabla_afectada Nombre de la tabla afectada
     * @param int|null $registro_id ID del registro afectado
     * @param string $tipo_operacion Tipo: INSERT, UPDATE, DELETE, etc.
     * @param array|null $datos_anteriores Datos antes del cambio
     * @param array|null $datos_nuevos Datos despues del cambio
     * @param string $descripcion Descripcion detallada (opcional)
     * @return bool
     */
    public static function log(
        $id_usuario,
        $modulo,
        $accion,
        $tabla_afectada = null,
        $registro_id = null,
        $tipo_operacion = self::OP_SELECT,
        $datos_anteriores = null,
        $datos_nuevos = null,
        $descripcion = null
    ) {
        $auditoria = new self();
        
        $auditoria->setIdUsuario($id_usuario)
                  ->setModulo($modulo)
                  ->setAccion($accion)
                  ->setTablaAfectada($tabla_afectada)
                  ->setRegistroId($registro_id)
                  ->setTipoOperacion($tipo_operacion)
                  ->setDescripcion($descripcion ?: $accion);
        
        if ($datos_anteriores !== null) {
            $auditoria->setDatosAnteriores($datos_anteriores);
        }
        
        if ($datos_nuevos !== null) {
            $auditoria->setDatosNuevos($datos_nuevos);
        }
        
        return $auditoria->registrar();
    }

    /**
     * Registra un login de usuario
     */
    public static function logLogin($id_usuario, $nombre_usuario, $exitoso = true, $error = null) {
        return self::log(
            $id_usuario,
            'Autenticacion',
            $exitoso ? 'Inicio de sesion exitoso' : 'Intento de login fallido',
            'usuarios',
            $id_usuario,
            self::OP_LOGIN,
            null,
            ['nombre_usuario' => $nombre_usuario, 'exitoso' => $exitoso],
            $error ?: 'Usuario inicio sesion en el sistema'
        );
    }

    /**
     * Registra un logout de usuario
     */
    public static function logLogout($id_usuario) {
        return self::log(
            $id_usuario,
            'Autenticacion',
            'Cierre de sesion',
            'usuarios',
            $id_usuario,
            self::OP_LOGOUT,
            null,
            null,
            'Usuario cerro sesion'
        );
    }

    /**
     * Registra una operacion CRUD exitosa
     */
    public static function logCrud(
        $id_usuario,
        $modulo,
        $tipo_operacion,
        $tabla_afectada,
        $registro_id,
        $descripcion,
        $datos_anteriores = null,
        $datos_nuevos = null
    ) {
        $acciones = [
            self::OP_INSERT => 'Registro creado',
            self::OP_UPDATE => 'Registro actualizado',
            self::OP_DELETE => 'Registro eliminado',
            self::OP_SELECT => 'Consulta realizada'
        ];
        
        return self::log(
            $id_usuario,
            $modulo,
            $acciones[$tipo_operacion] ?? 'Operacion realizada',
            $tabla_afectada,
            $registro_id,
            $tipo_operacion,
            $datos_anteriores,
            $datos_nuevos,
            $descripcion
        );
    }

    /**
     * Registra un error o fallo en una operacion
     */
    public static function logError(
        $id_usuario,
        $modulo,
        $tabla_afectada,
        $tipo_operacion,
        $mensaje_error,
        $datos_intentados = null
    ) {
        $auditoria = new self();
        
        $auditoria->setIdUsuario($id_usuario)
                  ->setModulo($modulo)
                  ->setAccion('Operacion fallida')
                  ->setTablaAfectada($tabla_afectada)
                  ->setTipoOperacion($tipo_operacion)
                  ->setDescripcion('Error: ' . $mensaje_error)
                  ->setErrorMensaje($mensaje_error)
                  ->setResultado(self::RES_FALLIDO);
        
        if ($datos_intentados !== null) {
            $auditoria->setDatosNuevos($datos_intentados);
        }
        
        return $auditoria->registrar();
    }

    // ==================== CONSULTAS DE AUDITORIA ====================

    /**
     * Obtiene todos los registros de auditoria con filtros opcionales
     * Compatible con estructura antigua y nueva
     */
    public function obtenerAuditorias($filtros = [], $limite = 100, $offset = 0) {
        try {
            $conn = $this->getConnectionSeguridad();
            
            // Verificar si las columnas nuevas existen
            $checkCol = $conn->query("SHOW COLUMNS FROM bitacoras LIKE 'tipo_operacion'");
            $columnasNuevasExisten = $checkCol->rowCount() > 0;
            
            $where = [];
            $params = [];
            
            if (!empty($filtros['id_usuario'])) {
                $where[] = "b.id_usuario = :id_usuario";
                $params[':id_usuario'] = $filtros['id_usuario'];
            }
            
            if (!empty($filtros['modulo'])) {
                $where[] = "b.modulo = :modulo";
                $params[':modulo'] = $filtros['modulo'];
            }
            
            if ($columnasNuevasExisten && !empty($filtros['tipo_operacion'])) {
                $where[] = "b.tipo_operacion = :tipo_operacion";
                $params[':tipo_operacion'] = $filtros['tipo_operacion'];
            }
            
            if ($columnasNuevasExisten && !empty($filtros['tabla_afectada'])) {
                $where[] = "b.tabla_afectada = :tabla_afectada";
                $params[':tabla_afectada'] = $filtros['tabla_afectada'];
            }
            
            if (!empty($filtros['fecha_desde'])) {
                $where[] = "b.fecha_bitacora >= :fecha_desde";
                $params[':fecha_desde'] = $filtros['fecha_desde'];
            }
            
            if (!empty($filtros['fecha_hasta'])) {
                $where[] = "b.fecha_bitacora <= :fecha_hasta";
                $params[':fecha_hasta'] = $filtros['fecha_hasta'];
            }
            
            if ($columnasNuevasExisten && !empty($filtros['resultado'])) {
                $where[] = "b.resultado = :resultado";
                $params[':resultado'] = $filtros['resultado'];
            }
            
            $sql_where = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
            
            if ($columnasNuevasExisten) {
                // Estructura completa con nuevas columnas
                $query = "SELECT 
                            b.id_bitacora,
                            b.id_usuario,
                            u.nombre_usuario,
                            b.modulo,
                            b.accion,
                            b.tabla_afectada,
                            b.registro_id,
                            b.tipo_operacion,
                            b.descripcion,
                            b.datos_anteriores,
                            b.datos_nuevos,
                            b.ip_address,
                            b.user_agent,
                            b.resultado,
                            b.error_mensaje,
                            b.fecha_bitacora
                        FROM bitacoras b
                        LEFT JOIN usuarios u ON b.id_usuario = u.id_usuario
                        $sql_where
                        ORDER BY b.fecha_bitacora DESC
                        LIMIT :limite OFFSET :offset";
            } else {
                // Estructura antigua - compatibilidad
                $query = "SELECT 
                            b.id_bitacora,
                            b.id_usuario,
                            u.nombre_usuario,
                            b.modulo,
                            b.accion,
                            NULL as tabla_afectada,
                            NULL as registro_id,
                            'SELECT' as tipo_operacion,
                            b.descripcion,
                            NULL as datos_anteriores,
                            NULL as datos_nuevos,
                            NULL as ip_address,
                            NULL as user_agent,
                            'EXITOSO' as resultado,
                            NULL as error_mensaje,
                            b.fecha_bitacora
                        FROM bitacoras b
                        LEFT JOIN usuarios u ON b.id_usuario = u.id_usuario
                        $sql_where
                        ORDER BY b.fecha_bitacora DESC
                        LIMIT :limite OFFSET :offset";
            }
            
            $stmt = $conn->prepare($query);
            
            foreach ($params as $key => $value) {
                $stmt->bindValue($key, $value);
            }
            
            $stmt->bindValue(':limite', (int)$limite, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
            
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            $this->error = "Error en obtenerAuditorias: " . $e->getMessage();
            error_log($this->error);
            return false;
        } finally {
            $this->closeConnection();
        }
    }

    /**
     * Obtiene estadisticas de auditoria
     * Compatible con estructura antigua y nueva
     */
    public function obtenerEstadisticas($fecha_desde = null, $fecha_hasta = null) {
        try {
            $conn = $this->getConnectionSeguridad();
            
            // Verificar si las columnas nuevas existen
            $checkCol = $conn->query("SHOW COLUMNS FROM bitacoras LIKE 'tipo_operacion'");
            $columnasNuevasExisten = $checkCol->rowCount() > 0;
            
            $where = "";
            $params = [];
            
            if ($fecha_desde && $fecha_hasta) {
                $where = "WHERE fecha_bitacora BETWEEN :desde AND :hasta";
                $params[':desde'] = $fecha_desde;
                $params[':hasta'] = $fecha_hasta;
            }
            
            if ($columnasNuevasExisten) {
                // Total de operaciones por tipo (con columnas nuevas)
                $query1 = "SELECT tipo_operacion, COUNT(*) as total 
                          FROM bitacoras $where 
                          GROUP BY tipo_operacion";
                $stmt1 = $conn->prepare($query1);
                foreach ($params as $key => $value) {
                    $stmt1->bindValue($key, $value);
                }
                $stmt1->execute();
                $por_tipo = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                
                // Total de exitosos vs fallidos
                $query2 = "SELECT resultado, COUNT(*) as total 
                          FROM bitacoras $where 
                          GROUP BY resultado";
                $stmt2 = $conn->prepare($query2);
                foreach ($params as $key => $value) {
                    $stmt2->bindValue($key, $value);
                }
                $stmt2->execute();
                $por_resultado = $stmt2->fetchAll(PDO::FETCH_ASSOC);
            } else {
                // Datos simulados para estructura antigua
                $por_tipo = [['tipo_operacion' => 'SELECT', 'total' => 0]];
                $por_resultado = [['resultado' => 'EXITOSO', 'total' => 0]];
            }
            
            // Operaciones por modulo (siempre disponible)
            $query3 = "SELECT modulo, COUNT(*) as total 
                      FROM bitacoras $where 
                      GROUP BY modulo ORDER BY total DESC LIMIT 10";
            $stmt3 = $conn->prepare($query3);
            foreach ($params as $key => $value) {
                $stmt3->bindValue($key, $value);
            }
            $stmt3->execute();
            $por_modulo = $stmt3->fetchAll(PDO::FETCH_ASSOC);
            
            // Usuarios mas activos (siempre disponible)
            $query4 = "SELECT b.id_usuario, u.nombre_usuario, COUNT(*) as total 
                      FROM bitacoras b 
                      LEFT JOIN usuarios u ON b.id_usuario = u.id_usuario
                      $where 
                      GROUP BY b.id_usuario ORDER BY total DESC LIMIT 10";
            $stmt4 = $conn->prepare($query4);
            foreach ($params as $key => $value) {
                $stmt4->bindValue($key, $value);
            }
            $stmt4->execute();
            $por_usuario = $stmt4->fetchAll(PDO::FETCH_ASSOC);
            
            return [
                'por_tipo' => $por_tipo,
                'por_resultado' => $por_resultado,
                'por_modulo' => $por_modulo,
                'por_usuario' => $por_usuario
            ];
            
        } catch(PDOException $e) {
            $this->error = "Error en obtenerEstadisticas: " . $e->getMessage();
            error_log($this->error);
            return false;
        } finally {
            $this->closeConnection();
        }
    }

    /**
     * Obtiene el historial completo de un registro especifico
     */
    public function obtenerHistorialRegistro($tabla, $registro_id) {
        try {
            $conn = $this->getConnectionSeguridad();
            
            $query = "SELECT 
                        b.*,
                        u.nombre_usuario
                    FROM bitacoras b
                    LEFT JOIN usuarios u ON b.id_usuario = u.id_usuario
                    WHERE b.tabla_afectada = :tabla 
                    AND b.registro_id = :registro_id
                    ORDER BY b.fecha_bitacora ASC";
            
            $stmt = $conn->prepare($query);
            $stmt->bindParam(':tabla', $tabla);
            $stmt->bindParam(':registro_id', $registro_id, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch(PDOException $e) {
            $this->error = "Error en obtenerHistorialRegistro: " . $e->getMessage();
            error_log($this->error);
            return false;
        } finally {
            $this->closeConnection();
        }
    }

    // ==================== METODOS AUXILIARES ====================

    /**
     * Obtiene la IP del cliente
     */
    private function getClientIP() {
        $ip_keys = ['HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 
                   'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 
                   'REMOTE_ADDR'];
        
        foreach ($ip_keys as $key) {
            if (!empty($_SERVER[$key])) {
                $ip = $_SERVER[$key];
                if (strpos($ip, ',') !== false) {
                    $ips = explode(',', $ip);
                    $ip = trim($ips[0]);
                }
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
        
        return '0.0.0.0';
    }

    /**
     * Obtiene el User Agent del cliente
     */
    private function getUserAgent() {
        return isset($_SERVER['HTTP_USER_AGENT']) ? substr($_SERVER['HTTP_USER_AGENT'], 0, 255) : 'Unknown';
    }

    /**
     * Obtiene el ID del usuario actual de la sesion
     */
    public static function getUsuarioActual() {
        if (isset($_SESSION['s_usuario']['id_usuario'])) {
            return $_SESSION['s_usuario']['id_usuario'];
        }
        if (isset($_SESSION['s_usuario']['usuario_id'])) {
            return $_SESSION['s_usuario']['usuario_id'];
        }
        if (isset($_SESSION['id_usuario'])) {
            return $_SESSION['id_usuario'];
        }
        return null;
    }
}
?>
