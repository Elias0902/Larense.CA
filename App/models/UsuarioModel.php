<?php

// llama al modelo conexion
require_once "ConexionModel.php";
require_once "AuditoriaModel.php";

class Usuario extends Conexion {

    // atributos
    private $id_usuario;
    private $nombre_usuario;
    private $email_usuario;
    private $password_usuario;
    private $id_rol_usuario;
    private $status;

    // constructor
    public function __construct() {
        parent::__construct();
    }

    // metodo para obtener todos los usuarios
    public function ObtenerTodosUsuarios() {
        try {
            $sql = "SELECT u.id_usuario, u.nombre_usuario, u.email_usuario,
                           u.id_rol_usuario, r.nombre_rol, u.status, u.imagen_perfil
                    FROM usuarios u
                    INNER JOIN roles r ON u.id_rol_usuario = r.id_rol
                    ORDER BY u.id_usuario DESC";

            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // metodo para obtener un usuario por ID
    public function ObtenerUsuarioPorId($id_usuario) {
        try {
            $sql = "SELECT u.id_usuario, u.nombre_usuario, u.email_usuario,
                           u.id_rol_usuario, r.nombre_rol, u.status, u.imagen_perfil
                    FROM usuarios u
                    INNER JOIN roles r ON u.id_rol_usuario = r.id_rol
                    WHERE u.id_usuario = :id_usuario";

            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    // metodo para obtener los roles
    public function ObtenerRoles() {
        try {
            $sql = "SELECT id_rol, nombre_rol FROM roles WHERE status = 1 ORDER BY nombre_rol";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // metodo para verificar si un usuario ya existe
    public function ExisteUsuario($nombre_usuario, $email_usuario) {
        try {
            $sql = "SELECT COUNT(*) as total FROM usuarios
                    WHERE (nombre_usuario = :nombre_usuario OR email_usuario = :email_usuario)
                    AND status = 1";

            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
            $stmt->bindParam(':email_usuario', $email_usuario, PDO::PARAM_STR);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'] > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    // metodo para verificar si un usuario ya existe con otro ID
    public function ExisteUsuarioOtroId($nombre_usuario, $email_usuario, $id_usuario) {
        try {
            $sql = "SELECT COUNT(*) as total FROM usuarios
                    WHERE (nombre_usuario = :nombre_usuario OR email_usuario = :email_usuario)
                    AND id_usuario != :id_usuario AND status = 1";

            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
            $stmt->bindParam(':email_usuario', $email_usuario, PDO::PARAM_STR);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['total'] > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    // metodo para crear un nuevo usuario
    public function CrearUsuario($nombre_usuario, $email_usuario, $password, $id_rol) {
        try {
            // hashea la contrasena
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (nombre_usuario, email_usuario, password_usuario, id_rol_usuario, status)
                    VALUES (:nombre_usuario, :email_usuario, :password, :id_rol, 1)";

            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
            $stmt->bindParam(':email_usuario', $email_usuario, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password_hash, PDO::PARAM_STR);
            $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $id_creado = $this->connSeguridad->lastInsertId();
                
                // Registrar en bitacora
                Auditoria::logCrud(
                    Auditoria::getUsuarioActual(),
                    'Usuarios',
                    Auditoria::OP_INSERT,
                    'usuarios',
                    $id_creado,
                    'Usuario creado: ' . $nombre_usuario . ' (Rol: ' . $id_rol . ')',
                    null,
                    ['id_usuario' => $id_creado, 'nombre_usuario' => $nombre_usuario, 'email_usuario' => $email_usuario, 'id_rol_usuario' => $id_rol, 'status' => 1]
                );
                
                return ['status' => true, 'msj' => 'Usuario creado correctamente', 'id' => $id_creado];
            } else {
                
                // Registrar error en bitacora
                Auditoria::logError(
                    Auditoria::getUsuarioActual(),
                    'Usuarios',
                    'usuarios',
                    Auditoria::OP_INSERT,
                    'Error al ejecutar query de insercion',
                    ['nombre_usuario' => $nombre_usuario, 'email_usuario' => $email_usuario, 'id_rol' => $id_rol]
                );
                
                return ['status' => false, 'msj' => 'Error al crear el usuario'];
            }
        } catch (PDOException $e) {
            
            // Registrar error en bitacora
            Auditoria::logError(
                Auditoria::getUsuarioActual(),
                'Usuarios',
                'usuarios',
                Auditoria::OP_INSERT,
                $e->getMessage(),
                ['nombre_usuario' => $nombre_usuario, 'email_usuario' => $email_usuario, 'id_rol' => $id_rol]
            );
            
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        }
    }

    // metodo para actualizar un usuario
    public function ActualizarUsuario($id_usuario, $nombre_usuario, $email_usuario, $id_rol, $password = '') {
        try {
            // Obtener datos actuales antes de actualizar (para bitacora)
            $sql_select = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
            $stmt_select = $this->connSeguridad->prepare($sql_select);
            $stmt_select->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt_select->execute();
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);
            
            // si se proporciono una nueva contrasena, la actualiza tambien
            if (!empty($password)) {
                $expre_password = '/^(?=.*[A-Z])(?=.*\.)[a-zA-Z0-9.]{6,}$/';
                if (!preg_match($expre_password, $password)) {
                    return ['status' => false, 'msj' => 'La contrasena debe tener minimo 6 caracteres, una mayuscula y un punto'];
                }

                $password_hash = password_hash($password, PASSWORD_DEFAULT);

                $sql = "UPDATE usuarios
                        SET nombre_usuario = :nombre_usuario,
                            email_usuario = :email_usuario,
                            id_rol_usuario = :id_rol,
                            password_usuario = :password
                        WHERE id_usuario = :id_usuario";

                $stmt = $this->connSeguridad->prepare($sql);
                $stmt->bindParam(':password', $password_hash, PDO::PARAM_STR);
            } else {
                $sql = "UPDATE usuarios
                        SET nombre_usuario = :nombre_usuario,
                            email_usuario = :email_usuario,
                            id_rol_usuario = :id_rol
                        WHERE id_usuario = :id_usuario";

                $stmt = $this->connSeguridad->prepare($sql);
            }

            $stmt->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
            $stmt->bindParam(':email_usuario', $email_usuario, PDO::PARAM_STR);
            $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

            if ($stmt->execute()) {
                
                // Datos nuevos para auditoria
                $datos_nuevos = [
                    'id_usuario' => $id_usuario,
                    'nombre_usuario' => $nombre_usuario,
                    'email_usuario' => $email_usuario,
                    'id_rol_usuario' => $id_rol
                ];
                if (!empty($password)) {
                    $datos_nuevos['password_cambiado'] = true;
                }
                
                // Registrar en bitacora
                Auditoria::logCrud(
                    Auditoria::getUsuarioActual(),
                    'Usuarios',
                    Auditoria::OP_UPDATE,
                    'usuarios',
                    $id_usuario,
                    'Usuario actualizado: ' . $nombre_usuario . ($datos_anteriores && $datos_anteriores['id_rol_usuario'] != $id_rol ? ' (Cambio de rol de ' . $datos_anteriores['id_rol_usuario'] . ' a ' . $id_rol . ')' : ''),
                    $datos_anteriores,
                    $datos_nuevos
                );
                
                return ['status' => true, 'msj' => 'Usuario actualizado correctamente'];
            } else {
                
                // Registrar error en bitacora
                Auditoria::logError(
                    Auditoria::getUsuarioActual(),
                    'Usuarios',
                    'usuarios',
                    Auditoria::OP_UPDATE,
                    'Error al ejecutar query de actualizacion',
                    ['id_usuario' => $id_usuario, 'nombre_usuario' => $nombre_usuario, 'id_rol' => $id_rol]
                );
                
                return ['status' => false, 'msj' => 'Error al actualizar el usuario'];
            }
        } catch (PDOException $e) {
            
            // Registrar error en bitacora
            Auditoria::logError(
                Auditoria::getUsuarioActual(),
                'Usuarios',
                'usuarios',
                Auditoria::OP_UPDATE,
                $e->getMessage(),
                ['id_usuario' => $id_usuario, 'nombre_usuario' => $nombre_usuario, 'id_rol' => $id_rol]
            );
            
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        }
    }

    // metodo para eliminar un usuario (cambia el status a 0)
    public function EliminarUsuario($id_usuario) {
        try {
            // Obtener datos actuales antes de eliminar (para bitacora)
            $sql_select = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
            $stmt_select = $this->connSeguridad->prepare($sql_select);
            $stmt_select->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt_select->execute();
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);
            
            $sql = "UPDATE usuarios SET status = 0 WHERE id_usuario = :id_usuario";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

            if ($stmt->execute()) {
                
                // Registrar en bitacora
                Auditoria::logCrud(
                    Auditoria::getUsuarioActual(),
                    'Usuarios',
                    Auditoria::OP_DELETE,
                    'usuarios',
                    $id_usuario,
                    'Usuario eliminado (status=0): ' . ($datos_anteriores['nombre_usuario'] ?? 'ID ' . $id_usuario),
                    $datos_anteriores,
                    ['id_usuario' => $id_usuario, 'status' => 0, 'nombre_usuario' => $datos_anteriores['nombre_usuario'] ?? null]
                );
                
                return ['status' => true, 'msj' => 'Usuario eliminado correctamente'];
            } else {
                
                // Registrar error en bitacora
                Auditoria::logError(
                    Auditoria::getUsuarioActual(),
                    'Usuarios',
                    'usuarios',
                    Auditoria::OP_DELETE,
                    'Error al ejecutar query de eliminacion',
                    ['id_usuario' => $id_usuario]
                );
                
                return ['status' => false, 'msj' => 'Error al eliminar el usuario'];
            }
        } catch (PDOException $e) {
            
            // Registrar error en bitacora
            Auditoria::logError(
                Auditoria::getUsuarioActual(),
                'Usuarios',
                'usuarios',
                Auditoria::OP_DELETE,
                $e->getMessage(),
                ['id_usuario' => $id_usuario]
            );
            
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        }
    }

    // metodo para cambiar el estado de un usuario
    public function CambiarEstado($id_usuario, $nuevo_estado) {
        try {
            // Obtener datos actuales antes de cambiar estado (para bitacora)
            $sql_select = "SELECT * FROM usuarios WHERE id_usuario = :id_usuario";
            $stmt_select = $this->connSeguridad->prepare($sql_select);
            $stmt_select->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt_select->execute();
            $datos_anteriores = $stmt_select->fetch(PDO::FETCH_ASSOC);
            
            $sql = "UPDATE usuarios SET status = :status WHERE id_usuario = :id_usuario";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':status', $nuevo_estado, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $estado_texto = $nuevo_estado == 1 ? 'activado' : 'desactivado';
                
                // Registrar en bitacora
                Auditoria::logCrud(
                    Auditoria::getUsuarioActual(),
                    'Usuarios',
                    Auditoria::OP_UPDATE,
                    'usuarios',
                    $id_usuario,
                    'Usuario ' . $estado_texto . ': ' . ($datos_anteriores['nombre_usuario'] ?? 'ID ' . $id_usuario),
                    $datos_anteriores,
                    ['id_usuario' => $id_usuario, 'status' => $nuevo_estado, 'nombre_usuario' => $datos_anteriores['nombre_usuario'] ?? null]
                );
                
                return ['status' => true, 'msj' => 'Usuario ' . $estado_texto . ' correctamente'];
            } else {
                
                // Registrar error en bitacora
                Auditoria::logError(
                    Auditoria::getUsuarioActual(),
                    'Usuarios',
                    'usuarios',
                    Auditoria::OP_UPDATE,
                    'Error al cambiar estado del usuario',
                    ['id_usuario' => $id_usuario, 'nuevo_estado' => $nuevo_estado]
                );
                
                return ['status' => false, 'msj' => 'Error al cambiar el estado'];
            }
        } catch (PDOException $e) {
            
            // Registrar error en bitacora
            Auditoria::logError(
                Auditoria::getUsuarioActual(),
                'Usuarios',
                'usuarios',
                Auditoria::OP_UPDATE,
                $e->getMessage(),
                ['id_usuario' => $id_usuario, 'nuevo_estado' => $nuevo_estado]
            );
            
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        }
    }

    // metodo para registrar en bitacora
    public function RegistrarBitacora($id_usuario, $modulo, $accion, $descripcion) {
        try {
            $sql = "INSERT INTO bitacoras (id_usuario, modulo, accion, descripcion, fecha_bitacora)
                    VALUES (:id_usuario, :modulo, :accion, :descripcion, NOW())";

            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':modulo', $modulo, PDO::PARAM_STR);
            $stmt->bindParam(':accion', $accion, PDO::PARAM_STR);
            $stmt->bindParam(':descripcion', $descripcion, PDO::PARAM_STR);
            $stmt->execute();
        } catch (PDOException $e) {
            // no hace nada si falla la bitacora
        }
    }
}

?>
