<?php

// llama al modelo conexion
require_once "ConexionModel.php";

class Perfil extends Conexion {

    // constructor
    public function __construct() {
        parent::__construct();
    }

    // metodo para obtener los datos del usuario (incluye telefono)
    public function ObtenerUsuarioSeguridad($id_usuario) {
        try {
            $sql = "SELECT u.id_usuario, u.nombre_usuario, u.email_usuario,
                           u.id_rol_usuario, r.nombre_rol, u.img_usuario,
                           u.telefono_usuario
                    FROM usuarios u
                    INNER JOIN roles r ON u.id_rol_usuario = r.id_rol
                    WHERE u.id_usuario = :id_usuario AND u.status = 1";

            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                return $resultado;
            } else {
                return [
                    'id_usuario' => $id_usuario,
                    'nombre_usuario' => $_SESSION['s_usuario']['nombre_usuario'] ?? 'Usuario',
                    'email_usuario' => $_SESSION['s_usuario']['email_usuario'] ?? '',
                    'id_rol_usuario' => $_SESSION['s_usuario']['id_rol_usuario'] ?? 0,
                    'nombre_rol' => 'Usuario',
                    'img_usuario' => 'Assets/img/default.PNG',
                    'telefono_usuario' => null
                ];
            }
        } catch (PDOException $e) {
            return [
                'id_usuario' => $id_usuario,
                'nombre_usuario' => $_SESSION['s_usuario']['nombre_usuario'] ?? 'Usuario',
                'email_usuario' => $_SESSION['s_usuario']['email_usuario'] ?? '',
                'id_rol_usuario' => $_SESSION['s_usuario']['id_rol_usuario'] ?? 0,
                'nombre_rol' => 'Usuario',
                'img_usuario' => 'Assets/img/default.PNG',
                'telefono_usuario' => null
            ];
        }
    }

    // metodo para obtener los datos del usuario
    public function ObtenerUsuario($id_usuario) {
        try {
            $sql = "SELECT u.id_usuario, u.nombre_usuario, u.email_usuario,
                           u.id_rol_usuario, r.nombre_rol, u.img_usuario
                    FROM usuarios u
                    INNER JOIN roles r ON u.id_rol_usuario = r.id_rol
                    WHERE u.id_usuario = :id_usuario AND u.status = 1";

            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                return $resultado;
            } else {
                return [
                    'id_usuario' => $id_usuario,
                    'nombre_usuario' => $_SESSION['s_usuario']['nombre_usuario'] ?? 'Usuario',
                    'email_usuario' => $_SESSION['s_usuario']['email_usuario'] ?? '',
                    'id_rol_usuario' => $_SESSION['s_usuario']['id_rol_usuario'] ?? 0,
                    'nombre_rol' => 'Usuario',
                    'img_usuario' => 'Assets/img/default.PNG'
                ];
            }
        } catch (PDOException $e) {
            return [
                'id_usuario' => $id_usuario,
                'nombre_usuario' => $_SESSION['s_usuario']['nombre_usuario'] ?? 'Usuario',
                'email_usuario' => $_SESSION['s_usuario']['email_usuario'] ?? '',
                'id_rol_usuario' => $_SESSION['s_usuario']['id_rol_usuario'] ?? 0,
                'nombre_rol' => 'Usuario',
                'img_usuario' => 'Assets/img/default.PNG'
            ];
        }
    }

    // metodo para obtener el ultimo acceso del usuario
    public function ObtenerUltimoAcceso($id_usuario) {
        try {
            $sql = "SELECT fecha_bitacora 
                    FROM bitacoras 
                    WHERE id_usuario = :id_usuario AND accion = 'LOGIN'
                    ORDER BY fecha_bitacora DESC 
                    LIMIT 1";

            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                return $resultado['fecha_bitacora'];
            } else {
                return date('Y-m-d H:i:s');
            }
        } catch (PDOException $e) {
            return date('Y-m-d H:i:s');
        }
    }

    // metodo para actualizar la imagen de perfil
    public function ActualizarImagen($id_usuario, $ruta_imagen) {
        try {
            $sql = "UPDATE usuarios SET img_usuario = :img_usuario WHERE id_usuario = :id_usuario";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':img_usuario', $ruta_imagen, PDO::PARAM_STR);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Imagen actualizada correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al actualizar la imagen'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        }
    }

    // metodo para eliminar la imagen de perfil
    public function EliminarImagen($id_usuario) {
        try {
            $sql = "UPDATE usuarios SET img_usuario = 'Assets/img/default.PNG' WHERE id_usuario = :id_usuario";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Imagen eliminada correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al eliminar la imagen'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        }
    }

    // metodo para cambiar la contrasena
    public function CambiarPassword($id_usuario, $password_actual, $password_nueva) {
        try {
            // verifica la contrasena actual
            $sql = "SELECT password_usuario FROM usuarios WHERE id_usuario = :id_usuario";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$resultado) {
                return ['status' => false, 'msj' => 'Usuario no encontrado'];
            }

            // verifica la contrasena actual con password_verify
            if (!password_verify($password_actual, $resultado['password_usuario'])) {
                return ['status' => false, 'msj' => 'Contrasena actual incorrecta'];
            }

            // valida la nueva contrasena
            $expre_password = '/^(?=.*[A-Z])(?=.*\.)[a-zA-Z0-9.]{6,}$/';
            if (!preg_match($expre_password, $password_nueva)) {
                return ['status' => false, 'msj' => 'La nueva contrasena debe tener minimo 6 caracteres, una mayuscula y un punto'];
            }

            // hashea la nueva contrasena
            $password_hash = password_hash($password_nueva, PASSWORD_DEFAULT);

            // actualiza la contrasena
            $sql = "UPDATE usuarios SET password_usuario = :password WHERE id_usuario = :id_usuario";
            $stmt = $this->connSeguridad->prepare($sql);
            $stmt->bindParam(':password', $password_hash, PDO::PARAM_STR);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return ['status' => true, 'msj' => 'Contrasena cambiada correctamente'];
            } else {
                return ['status' => false, 'msj' => 'Error al cambiar la contrasena'];
            }
        } catch (PDOException $e) {
            return ['status' => false, 'msj' => 'Error: ' . $e->getMessage()];
        }
    }
}

?>