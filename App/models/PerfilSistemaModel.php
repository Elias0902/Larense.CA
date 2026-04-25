<?php

// llama al modelo conexion
require_once "ConexionModel.php";

class PerfilSistema extends Conexion {

    // constructor
    public function __construct() {
        parent::__construct();
    }

    // ==================== MÉTODOS PARA USUARIOS ====================

    // obtener todos los usuarios con su rol
    public function ObtenerTodosUsuarios() {
        try {
            $sql = "SELECT u.id_usuario, u.nombre_usuario, u.email_usuario,
                           u.id_rol_usuario, r.nombre_rol, u.status, u.img_usuario
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

    // obtener un usuario por ID
    public function ObtenerUsuarioPorId($id_usuario) {
        try {
            $sql = "SELECT u.id_usuario, u.nombre_usuario, u.email_usuario,
                           u.id_rol_usuario, r.nombre_rol, u.status, u.img_usuario
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

    // El resto de métodos se mantienen igual...
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

    public function CrearUsuario($nombre_usuario, $email_usuario, $password, $id_rol) {
        try {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (nombre_usuario, email_usuario, password_usuario, id_rol_usuario, status, img_usuario)
                    VALUES (:nombre_usuario, :email_usuario, :password, :id_rol, 1, 'Assets/img/perfiles/default.png')";

            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':nombre_usuario', $nombre_usuario, PDO::PARAM_STR);
            $stmt->bindParam(':email_usuario', $email_usuario, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password_hash, PDO::PARAM_STR);
            $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Usuario creado correctamente', 'id' => $this->connSeguridad->lastInsertId()];
            } else {
                return ['status' => false, 'msj' => 'Error al crear el usuario'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        }
    }

    public function ActualizarUsuario($id_usuario, $nombre_usuario, $email_usuario, $id_rol, $password = '') {
        try {
            if (!empty($password)) {
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
                return ['status' => true, 'msj' => 'Usuario actualizado correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al actualizar el usuario'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        }
    }

    public function EliminarUsuario($id_usuario) {
        try {
            $sql = "UPDATE usuarios SET status = 0 WHERE id_usuario = :id_usuario";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Usuario eliminado correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al eliminar el usuario'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        }
    }

    public function CambiarEstadoUsuario($id_usuario, $nuevo_estado) {
        try {
            $sql = "UPDATE usuarios SET status = :status WHERE id_usuario = :id_usuario";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':status', $nuevo_estado, PDO::PARAM_INT);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

            if ($stmt->execute()) {
                $estado_texto = $nuevo_estado == 1 ? 'activado' : 'desactivado';
                return ['status' => true, 'msj' => 'Usuario ' . $estado_texto . ' correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al cambiar el estado'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        }
    }

    // ==================== MÉTODOS PARA ROLES ====================

    public function ObtenerRoles() {
        try {
            $sql = "SELECT id_rol, nombre_rol, status FROM roles WHERE status = 1 ORDER BY nombre_rol";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function ObtenerRolPorId($id_rol) {
        try {
            $sql = "SELECT id_rol, nombre_rol, status FROM roles WHERE id_rol = :id_rol";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return null;
        }
    }

    public function CrearRol($nombre_rol) {
        try {
            $sql = "INSERT INTO roles (nombre_rol, status) VALUES (:nombre_rol, 1)";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':nombre_rol', $nombre_rol, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $id_rol = $this->connSeguridad->lastInsertId();
                $this->InicializarPermisosRol($id_rol);
                return ['status' => true, 'msj' => 'Rol creado correctamente', 'id' => $id_rol];
            } else {
                return ['status' => false, 'msj' => 'Error al crear el rol'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        }
    }

    public function ActualizarRol($id_rol, $nombre_rol) {
        try {
            $sql = "UPDATE roles SET nombre_rol = :nombre_rol WHERE id_rol = :id_rol";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':nombre_rol', $nombre_rol, PDO::PARAM_STR);
            $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Rol actualizado correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al actualizar el rol'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        }
    }

    public function EliminarRol($id_rol) {
        try {
            $sql = "SELECT COUNT(*) as total FROM usuarios WHERE id_rol_usuario = :id_rol AND status = 1";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado['total'] > 0) {
                return ['status' => false, 'msj' => 'No se puede eliminar el rol porque hay usuarios asignados a él'];
            }

            $sql = "UPDATE roles SET status = 0 WHERE id_rol = :id_rol";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Rol eliminado correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al eliminar el rol'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        }
    }

    // ==================== MÉTODOS PARA MÓDULOS ====================

    public function ObtenerModulos() {
        try {
            $sql = "SELECT id_modulo, nombre_modulo FROM modulos ORDER BY id_modulo";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    // ==================== MÉTODOS PARA PERMISOS ====================

    private function InicializarPermisosRol($id_rol) {
        try {
            $modulos = $this->ObtenerModulos();
            $sql = "INSERT INTO accesos (id_rol, id_modulo, id_permiso, status) VALUES (:id_rol, :id_modulo, 2, 1)";
            $stmt = $this->connSeguridad->prepare($sql);

            foreach ($modulos as $modulo) {
                $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
                $stmt->bindParam(':id_modulo', $modulo['id_modulo'], PDO::PARAM_INT);
                $stmt->execute();
            }
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function ObtenerPermisosRol($id_rol) {
        try {
            $sql = "SELECT a.id_modulo, a.id_permiso, m.nombre_modulo
                    FROM accesos a
                    INNER JOIN modulos m ON a.id_modulo = m.id_modulo
                    WHERE a.id_rol = :id_rol AND a.status = 1";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
            $stmt->execute();
            $permisos = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $matriz = [];
            foreach ($permisos as $p) {
                $matriz[$p['id_modulo']][$p['id_permiso']] = true;
            }
            return $matriz;
        } catch (PDOException $e) {
            return [];
        }
    }

    public function ObtenerMatrizPermisosCompleta() {
        try {
            $sql = "SELECT a.id_rol, a.id_modulo, a.id_permiso, r.nombre_rol, m.nombre_modulo
                    FROM accesos a
                    INNER JOIN roles r ON a.id_rol = r.id_rol
                    INNER JOIN modulos m ON a.id_modulo = m.id_modulo
                    WHERE a.status = 1 AND r.status = 1
                    ORDER BY a.id_rol, a.id_modulo, a.id_permiso";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return [];
        }
    }

    public function ActualizarPermiso($id_rol, $id_modulo, $id_permiso, $activo) {
        try {
            if ($activo) {
                $sql = "SELECT id_accesos FROM accesos 
                        WHERE id_rol = :id_rol AND id_modulo = :id_modulo AND id_permiso = :id_permiso";
                $stmt = $this->connSeguridad->prepare($sql);
                $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
                $stmt->bindParam(':id_modulo', $id_modulo, PDO::PARAM_INT);
                $stmt->bindParam(':id_permiso', $id_permiso, PDO::PARAM_INT);
                $stmt->execute();

                if ($stmt->rowCount() == 0) {
                    $sql = "INSERT INTO accesos (id_rol, id_modulo, id_permiso, status) 
                            VALUES (:id_rol, :id_modulo, :id_permiso, 1)";
                    $stmt = $this->connSeguridad->prepare($sql);
                    $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
                    $stmt->bindParam(':id_modulo', $id_modulo, PDO::PARAM_INT);
                    $stmt->bindParam(':id_permiso', $id_permiso, PDO::PARAM_INT);
                    $stmt->execute();
                } else {
                    $sql = "UPDATE accesos SET status = 1 
                            WHERE id_rol = :id_rol AND id_modulo = :id_modulo AND id_permiso = :id_permiso";
                    $stmt = $this->connSeguridad->prepare($sql);
                    $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
                    $stmt->bindParam(':id_modulo', $id_modulo, PDO::PARAM_INT);
                    $stmt->bindParam(':id_permiso', $id_permiso, PDO::PARAM_INT);
                    $stmt->execute();
                }
            } else {
                $sql = "UPDATE accesos SET status = 0 
                        WHERE id_rol = :id_rol AND id_modulo = :id_modulo AND id_permiso = :id_permiso";
                $stmt = $this->connSeguridad->prepare($sql);
                $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
                $stmt->bindParam(':id_modulo', $id_modulo, PDO::PARAM_INT);
                $stmt->bindParam(':id_permiso', $id_permiso, PDO::PARAM_INT);
                $stmt->execute();
            }

            return ['status' => true, 'msj' => 'Permiso actualizado correctamente'];
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        }
    }

    public function VerificarPermiso($id_rol, $id_modulo, $id_permiso) {
        try {
            $sql = "SELECT COUNT(*) as tiene FROM accesos 
                    WHERE id_rol = :id_rol AND id_modulo = :id_modulo 
                    AND id_permiso = :id_permiso AND status = 1";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':id_rol', $id_rol, PDO::PARAM_INT);
            $stmt->bindParam(':id_modulo', $id_modulo, PDO::PARAM_INT);
            $stmt->bindParam(':id_permiso', $id_permiso, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado['tiene'] > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    // ==================== MÉTODOS PARA BITÁCORA ====================

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
            // No hacer nada si falla la bitácora
        }
    }

    public function ObtenerUltimoAcceso($id_usuario) {
        try {
            $sql = "SELECT fecha_bitacora FROM bitacoras 
                    WHERE id_usuario = :id_usuario AND accion = 'LOGIN'
                    ORDER BY fecha_bitacora DESC LIMIT 1";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            return $resultado ? $resultado['fecha_bitacora'] : date('Y-m-d H:i:s');
        } catch (PDOException $e) {
            return date('Y-m-d H:i:s');
        }
    }
}

?>