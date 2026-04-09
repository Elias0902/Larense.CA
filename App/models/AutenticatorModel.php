<?php

        // 1. Descarga PHPMailer: https://github.com/PHPMailer/PHPMailer
       
       use PHPMailer\PHPMailer\PHPMailer;
       use PHPMailer\PHPMailer\SMTP;
       use PHPMailer\PHPMailer\Exception;
       require 'vendor/autoload.php'; // o manual: PHPMailer.php, SMTP.php, Exception.php

// llama al modelo conexion
require_once "ConexionModel.php";

class Autenticator extends Conexion {

    // atributos
    private $usuario_id;
    private $usuario_name;
    private $usuario_email;
    private $usuario_password;
    private $usuario_rol;
    private $codigo;
    private $token;

    // construcor
    public function __construct() {
        parent::__construct();
    }

    // metodo que me valida y asigna los datos del objeto recibido para la funcion registrar
    private function setUsuarioData($usuario_json) {

        // valida si el json es string y lo descompone
        if (is_string($usuario_json)) {

            // se almacena el contenido del json en la variable usuario
            $usuario = json_decode($usuario_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($usuario === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        // expreciones regulares y validaciones
        $expre_username = '/^[a-zA-Z0-9@_]+$/'; //para el usernmae
        $expre_email = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'; // para el email
        $expre_password = '/^(?=.*[A-Z])(?=.*\.)[a-zA-Z0-9.]{6,}$/'; // para el password
        $expre_numeric = '/^\d+$/'; // para los numeros

        // almacena el username en la variable para despues validar
        $username = trim($usuario['username'] ?? '');
        // valida el username si cumple con los requisitos
        if ($username === '' || !preg_match($expre_username, $username) || strlen($username) > 20 || strlen($username) < 5) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'EL nombre de usuario es invalido debe tener minimo 5 y maximo 20 caracteres y debe tener un @ y/o un _  ej:@usuario_123 .'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->usuario_name = $username;

        // almacena el email en la variable para despues validar
        $email = trim($usuario['email'] ?? '');
        // valida el email si cumple con los requisitos
        if ($email === '' || !preg_match($expre_email, $email) || strlen($email) > 60 || strlen($email) < 7) {
            //retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El email es invalido debe tener minimo 7 y maximo 60 caracteres y debe tener un @ y un .com  ej: example@email.com .'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->usuario_email = $email;

        // almacena la password en la variable para despues validar
        $password = trim($usuario['password'] ?? '');
        // valida la password si cumple con todos los requisitos
        if ($password === '' || !preg_match($expre_password, $password) || strlen($password) > 11 || strlen($password) < 6) {
            //retorna un arry de status con el mensaje en caso de error
            return['status' => false, 'msj' => 'La password es invalida debe tener minimo 6 y maximo 11 caracteres y debe tener un caracter mayuscula y un .  ej: Example12. .'];
        }

        // encripta la password una ves validada
        $password_hash = password_hash($password, PASSWORD_DEFAULT); 

        // asigna el valor al atributo del objeto si todo salio bien
        $this->usuario_password = $password_hash;

        // almacena el rol en la variable para despues validar
        $rol = trim($usuario['rol'] ?? '');
        // valida el rol si cumple con todos los requisitos
        if ($rol === '' && !preg_match($expre_numeric, $rol)) {
            //retorna un arry de status con el mensaje en caso de error 
            return['status' => true, 'msj' => 'El rol es invalido intentenlo de nuevo.'];
        }

        // asigna el valor en el atributo del objeto si todo salio bien
        $this->usuario_rol = $rol;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    // metodo que me valida y asigna los datos del objeto recibido para la funcion iniciar session
    private function setUsuarioLoginData($usuario_json) {

        // valida si el json es string y lo descompone
        if (is_string($usuario_json)) {

            // se almacena el contenido del json en la variable usuario
            $usuario = json_decode($usuario_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($usuario === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        // expreciones regulares y validaciones
        $expre_username = '/^[a-zA-Z0-9@_]+$/'; //para el usernmae
        $expre_password = '/^(?=.*[A-Z])(?=.*\.)[a-zA-Z0-9.]{6,}$/'; // para el password

        // almacena el username en la variable para despues validar
        $username = trim($usuario['username'] ?? '');
        // valida el username si cumple con los requisitos
        if ($username === '' || !preg_match($expre_username, $username) || strlen($username) > 20 || strlen($username) < 5) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'EL nombre de usuario es invalido debe tener minimo 5 y maximo 20 caracteres y debe tener un @ y/o un _  ej:@usuario_123 .'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->usuario_name = $username;

        // almacena la password en la variable para despues validar
        $password = trim($usuario['password'] ?? '');
        // valida la password si cumple con todos los requisitos
        if ($password === '' || !preg_match($expre_password, $password) || strlen($password) > 11 || strlen($password) < 6) {
            //retorna un arry de status con el mensaje en caso de error
            return['status' => false, 'msj' => 'La password es invalida debe tener minimo 6 y maximo 11 caracteres y debe tener un caracter mayuscula y un .  ej: Example12. .'];
        }

        // encripta la password una ves validada
        $password_hash = password_hash($password, PASSWORD_DEFAULT); 

        // asigna el valor al atributo del objeto si todo salio bien
        $this->usuario_password = $password_hash;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.'];
    }

    // metodo que me valida y asigna los datos del objeto recibido para la funcion recuperar
    private function setUsuarioUpdateData($usuario_json) {

         // valida si el json es string y lo descompone
        if (is_string($usuario_json)) {

            // se almacena el contenido del json en la variable usuario
            $usuario = json_decode($usuario_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($usuario === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        $expre_email = '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/'; // para el email

        // almacena el email en la variable para despues validar
        $email = trim($usuario['email'] ?? '');
        // valida el email si cumple con los requisitos
        if ($email === '' || !preg_match($expre_email, $email) || strlen($email) > 60 || strlen($email) < 7) {
            //retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El email es invalido debe tener minimo 7 y maximo 60 caracteres y debe tener un @ y un .com  ej: example@email.com .'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->usuario_email = $email;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    //metodo que me valida y asigna datos para el cambio de password del usuario
    private function setUsuarioPasswordData($usuario_json) {
            // valida si el json es string y lo descompone
            if (is_string($usuario_json)) {
    
                // se almacena el contenido del json en la variable usuario
                $usuario = json_decode($usuario_json, true);
                
                // valida que el json cumpla con el formato requerido
                if ($usuario === null) {
    
                    // retorna un arry con el mensaje y el status
                    return ['status' => false, 'msj' => 'JSON invalido.'];
                }
            }
    
            // expreciones regulares y validaciones
        $expre_username = '/^[a-zA-Z0-9@_]+$/'; //para el usernmae
        $expre_password = '/^(?=.*[A-Z])(?=.*\.)[a-zA-Z0-9.]{6,}$/'; // para el password
        $expre_codigo = '/^\d{6}$/'; // para el codigo de recuperacion

        // almacena el username en la variable para despues validar
        $username = trim($usuario['username'] ?? '');
        // valida el username si cumple con los requisitos
        if ($username === '' || !preg_match($expre_username, $username) || strlen($username) > 20 || strlen($username) < 5) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'EL nombre de usuario es invalido debe tener minimo 5 y maximo 20 caracteres y debe tener un @ y/o un _  ej:@usuario_123 .'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->usuario_name = $username;

        // almacena la password en la variable para despues validar
        $password = trim($usuario['password'] ?? '');
        // valida la password si cumple con todos los requisitos
        if ($password === '' || !preg_match($expre_password, $password) || strlen($password) > 11 || strlen($password) < 6) {
            //retorna un arry de status con el mensaje en caso de error
            return['status' => false, 'msj' => 'La password es invalida debe tener minimo 6 y maximo 11 caracteres y debe tener un caracter mayuscula y un .  ej: Example12. .'];
        }

        // encripta la password una ves validada
        $password_hash = password_hash($password, PASSWORD_DEFAULT); 

        // asigna el valor al atributo del objeto si todo salio bien
        $this->usuario_password = $password_hash;

        // almacena el codigo en la variable para despues validar
        $codigo = trim($usuario['codigo'] ?? '');

        // valida el codigo si cumple con todos los requisitos
        if ($codigo === '' || !preg_match($expre_codigo, $codigo)) {
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El codigo es invalido debe tener 6 digitos numericos.'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->codigo = $codigo;

        //almacena el token en la variable para despues validar
        $token = trim($usuario['token'] ?? '');

        // valida el token si cumple con todos los requisitos
        if ($token === ''  || strlen($token) !== 64) {
            
            // retorna un arry de status con el mensaje en caso de error
            return ['status' => false, 'msj' => 'El token es invalido.'];
        }

        // asigna el valor al atributo del objeto si todo salio bien
        $this->token = $token;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.'];
    }


    // metodo que me valida y asigna los datos del objeto recibido para la funcion obtener
    private function setUsuarioID($usuario_json) {

         // valida si el json es string y lo descompone
        if (is_string($usuario_json)) {

            // se almacena el contenido del json en la variable usuario
            $usuario = json_decode($usuario_json, true);
            
            // valida que el json cumpla con el formato requerido
            if ($usuario === null) {

                // retorna un arry con el mensaje y el status
                return ['status' => false, 'msj' => 'JSON invalido.'];
            }
        }

        $expre_numeric = '/^\d+$/'; // para los numeros

        // almacena el id en la variable para despues validar
        $id = trim($usuario['id'] ?? '');
        // valida el rol si cumple con todos los requisitos
        if ($id === '' || !preg_match($expre_numeric, $id)) {
            //retorna un arry de status con el mensaje en caso de error 
            return['status' => false, 'msj' => 'El id es invalido intentenlo de nuevo.'];
        }

        // asigna el valor en el atributo del objeto si todo salio bien
        $this->usuario_id = $id;

        // retorna true si todo fue validado y asignado correctamente
        return['status' => true, 'msj' => 'Datos validados y asignados correctamente.']; 
    }

    // GETTERS

    // para el id
    private function getID() {

        // retorna el id
        return $this->usuario_id;
    }

    // para el username
    private function getUsername() {

        // retorna el username
        return $this->usuario_name;
    }

    // para el email
    private function getEmail() {

        // retorna el email
        return $this->usuario_email;
    }

    // para el password
    private function getPassword() {

        //retorna el password
        return $this->usuario_password;
    }

    // para el rol
    private function getRol() {

        //retorna el rol
        return $this->usuario_rol;
    }

    //para el codigo
    private function getCodigo() {

        //retorna el codigo
        return $this->codigo;
    }

    //para el token
    private function getToken() {

        //retorna el token
        return $this->token;
    }   

    // Esta se encarga de procesar los action indiferentemente cual sea llama la funcion de 
    // validacio y luego al metodo correspondiente al action
    // donde primero recibe el action como primer parametro que son los de agregar etc.. 
    // y el objeto json como segundo parametro para las validaciones y asiganciones al objeto 
    public function manejarAccion($action, $usuario_json) {

        switch($action) {
            case 'agregar':
                
                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setUsuarioData($usuario_json);
                
                // valida si el status es true o false
                if (!$validacion['status']) {
                
                    // retorna el status con el mensaje
                    return $validacion;
                }
                
                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Registrar_Usuario();

            // termina el script    
            break;

            case 'ingresar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setUsuarioLoginData($usuario_json);

                // valida si el status es true o false
                if (!$validacion['status']) {

                    //retorna el status con el mensaje
                    return $validacion;
                }

                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Iniciar_Session();

            // termina el script
            break;

            case 'recuperar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setUsuarioUpdateData($usuario_json);

                //valida si el status es true o false
                if (!$validacion['status']) {

                    //retorna el status con el mensaje
                    return $validacion;
                }

                // llama la funcion si todo sale bien y retorna el resultado 
                return $this->Recuperar_Usuario();

            // termina el script
            break;

            case 'cambiar':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setUsuarioPasswordData($usuario_json);

                //valida si el status es true o false
                if (!$validacion['status']) {

                    //retorna el status con el mensaje
                    return $validacion;
                }

                // llama la funcion si todo sale bien y retorna el resultado 
                return $this->Cambiar_Password();

            // termina el script
            break;

            case 'obtener':

                // almacena el status de la respuesta de la funcion de validacion
                $validacion = $this->setUsuarioID($usuario_json);

                // valida si el status es true o false
                if (!$validacion['status']) {

                    //retorna el status con el mensaje
                    return $validacion;
                }

                // llama la funcion si todo sale bien y retorna el resultado
                return $this->Obtener_Usuario();

            // termina el script
            break;

            default:

                // retorna un mensaje de error en caso de no existir la accion
                return['status' => false, 'msj' => 'Accion Invalida.'];

            // termina el script
            break;
        }
    }

    //METODOS

    // metodo para regisrar un usuario 
    private function Registrar_Usuario() {

        // la conexion es null por defecto
        $this->closeConnection();

        // para el manejo de errores
        try {

            // llamo y la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();

            // consulta si existe el usuario
            $query = "SELECT * FROM usuarios WHERE nombre_usuario = :nombre_usuario";
            
            // prepara la sentencia sql
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':nombre_usuario', $this->getUsername());

            // ejecuta la sentecia
            $stmt->execute();

            // valida si se ejecuto y si existe el usuario
            if ($stmt->rowCount() == 0) {

                // inserta un nuevo usuario
                $query = "INSERT INTO usuarios (nombre_usuario, email_usuario, password_usuario, id_rol_usuario)
                                        VALUES (:nombre_usuario, :email_usuario, :password_usuario, :id_rol_usuario)";
                
                // prepara la sentencia sql
                $stmt = $conn->prepare($query);

                // vincula los parametros con las variables
                $stmt->bindValue(':nombre_usuario', $this->getUsername());
                $stmt->bindValue(':email_usuario', $this->getEmail());
                $stmt->bindValue(':password_usuario', $this->getPassword());
                $stmt->bindValue(':id_rol_usuario', $this->getRol());
        
                // valida si se ejecuto la sentencia y si es true
                if ($stmt->execute()) {

                    //retorna el status true con el mensaje
                    return['status' => true, 'msj' => 'Usuario registrado correctamente Ahora Inicie session en el sistema.'];
                }
                else {

                    // retorna el status false con el mensaje 
                    return['status' => false, 'msj' => 'Error al regisrar el usuario intentelo de nuevo.']; 
                }
            }
            else {

                // retorna el status false con el mensaje
                return['status' => false, 'msj' => 'Error el usuario ya esxiste'];
            }
        }
        catch(PDOException $e) {

            // retorna mensaje de error del exception del pdo
            return['status' => false, 'msj' => 'Error en la consulta' . $e->getMessage()];
        }
        finally {

            // finaliza la funcion cerrando la conexion a la bd
            $this->closeConnection();
        }
    }

    // funcion para iniciar session un usuario
    private function Iniciar_Session() {

        // la conxecion es null por defecto
        $this->closeConnection();

        // para manejo de errores
        try {
            
            // llamo la funcion y creo la conexion
            $conn = $this->getConnectionSeguridad();

            // consulta el usuario que inicia session
            $query = "SELECT u.*, r.nombre_rol
                        FROM usuarios u
                        LEFT JOIN roles r ON u.id_rol_usuario = r.id_rol
                        WHERE nombre_usuario = :username
                        AND u.status = 1"; //valida el estado del usuario si esta activo

            // prepar la sentencia 
            $stmt = $conn->prepare($query);

            // vincula los parametros
            $stmt->bindValue(':username', $this->getUsername());

            // ejecuta la sentencia
            $stmt->execute(); 

            // se valida si se ejecuto la sentencia y si es true
            if ($stmt->rowCount() === 1) {

                // almacena los datos extraidos de la base de datos 
                $data = $stmt->fetch(PDO::FETCH_ASSOC);

                //retorna el status con el mensaje y los datos de usuario
                return['status' => true, 'msj' => 'Usuario encontrado con exito.', 'data' => $data];
            }
            else {

                // reti=rona un status de error con un mensaje 
                return['status' => false, 'msj' => 'Usuario no encontrado o inactivo'];
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

    // funcion para recuperar un usuario
    private function Recuperar_Usuario() {
        
        //la conexion esta cerrada
        $this->closeConnection();
        
        try {

            //se crea la conexion
            $conn = $this->getConnectionSeguridad();
            
            //busca el usuario mediante el email
            $query = "SELECT * FROM usuarios WHERE email_usuario = :email";
            $stmt = $conn->prepare($query);
            $stmt->bindValue(':email', $this->getEmail());
            
            $stmt->execute();
            
            // si se encuentra el usuario
            if ($stmt->rowCount() === 1) {

                //se almacenan los datos del usuario obtenidos
                $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

                //se obtiene el id del usuario para generar el codigo de recuperacion
                $usuario_id = $usuario['id_usuario'];
                
                //se genera un cidigo de 6 digitos y un token unico de 64 caracteres
                //y se calcula una fecha de expiracion de 15 min para el codigo
                $codigo = sprintf("%06d", mt_rand(100000, 999999));  // 483920
                $token = bin2hex(random_bytes(32));                  // 64 chars
                $expira = date('Y-m-d H:i:s', strtotime('+60 minutes'));
                $json = json_encode([
                    'usuario_id' => $usuario_id,
                    'codigo' => $codigo,
                    'token' => $token,
                    'expira' => $expira
                ]);
                
                //LIMPIAR códigos anteriores del usuario
                $stmt_clean = $conn->prepare("DELETE FROM recuperar_codigos WHERE id_usuario = ?");
                $stmt_clean->execute([$usuario_id]);
                
                //GUARDAR NUEVO código + token
                $stmt_insert = $conn->prepare("
                    INSERT INTO recuperar_codigos (id_usuario, codigo, token, expira, usado) 
                    VALUES (?, ?, ?, ?, 0)
                ");
                $stmt_insert->execute([$usuario_id, $codigo, $token, $expira]);
                
                //ENVIAR EMAIL
                $resetUrl = "http://localhost/larence/index.php?url=autenticator&action=verificar&token=" . $token;
                $this->enviarCodigoEmail($this->usuario_email, $codigo, $resetUrl);
                
                //retorna un mensaje de Cliente recibe email
                return [
                    'status' => true, 
                    'msj' => 'Código de 6 dígitos enviado a tu email (15 min)', 
                    'data' => $usuario
                ];
            } 
            else {

                //retorna un mensaje de error si el email no esta registrado
                return [
                    'status' => false, 
                    'msj' => 'Email no registrado', 
                    'data' => null
                ];
            }
        } catch (PDOException $e) {
                    
            // retorna mensaje de error del exception del pdo
            error_log('Error recuperación: ' . $e->getMessage());

            //retorna un mensaje de error generico para el cliente
            return ['status' => false, 'msj' => 'Error en base de datos'];
        } 
        finally {

            //finaliza la función cerrando la conexión a la bd
            $this->closeConnection();
        }
    }

    // función para enviar el código de recuperación por email usando PHPMailer
    private function enviarCodigoEmail($email, $codigo, $resetUrl) {

        // crea una instancia de PHPMailer
        $mail = new PHPMailer(true);
        
        try {

            //CONFIGURACIÓN SMTP GMAIL
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'moises2005pereira@gmail.com';     // GMAIL del sistema
            $mail->Password   = 'glir tswr elhu iwcr'; // ← APP PASSWORD del gmail del sistema
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            
            //REMITENTE
            $mail->setFrom('moises2005pereira@gmail.com', 'Natys');
            $mail->addAddress($email);
            $mail->addReplyTo('moises2005pereira@gmail.com', 'Soporte Natys');
            
            //CONTENIDO HTML
            $mail->isHTML(true);
            $mail->Subject = '🔐 Tu código de recuperación - Natys';
            $mail->Body    = $this->getEmailTemplate($codigo, $resetUrl);
            $mail->AltBody = "Tu código: $codigo. Enlace: $resetUrl";
            
            //ENVÍA EL EMAIL
            $mail->send();

            //retorna true si el email se envió correctamente
            return true;
            
        } catch (Exception $e) {

            //Email falla = BD sigue funcionando
            error_log("Email error: {$mail->ErrorInfo}");

            //retorna false si el email no se pudo enviar
            return false;
        }
    }

    // función para generar el template del email con el código y el enlace de recuperación
    private function getEmailTemplate($codigo, $resetUrl) {
        
    //plantilla HTLM con estilos para el correo de recuperacion
    return "
        <!DOCTYPE html>
        <html>
        <head><meta charset='UTF-8'></head>
        <body style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px;'>
            <h2 style='color: #007bff;'>🔐 Código de recuperación</h2>
            <div style='background: linear-gradient(135deg, #007bff, #0056b3); color: white; padding: 30px; text-align: center; border-radius: 15px;'>
                <h1 style='font-size: 4em; margin: 0;'>$codigo</h1>
                <p style='font-size: 1.2em;'>Tu código de verificación</p>
            </div>
            <p style='margin: 25px 0;'>Este código es válido por <strong>15 minutos</strong>.</p>
            
            <a href='$resetUrl' style='background: #28a745; color: white; padding: 18px 40px; text-decoration: none; border-radius: 10px; font-weight: bold; font-size: 1.1em; display: inline-block; box-shadow: 0 4px 15px rgba(40,167,69,0.3);'>
                🔑 Recuperar contraseña ahora
            </a>
            
            <hr style='margin: 40px 0; border: none; border-top: 1px solid #eee;'>
            <p style='color: #666; font-size: 14px; text-align: center;'>
                Si no solicitaste este código, puedes ignorar este mensaje.
            </p>
            <p style='color: #007bff; font-size: 12px; text-align: center;'>
                Natys - Barquisimeto, Lara
            </p>
        </body>
        </html>";
    }

    //funcion para cambiar la paswword de un usuario
    private function Cambiar_Password() {

        //la conexion esta cerrada
        $this->closeConnection();
        
        try {

            //se crea la conexion
            $conn = $this->getConnectionSeguridad();
            
            // INICIO TRANSACCIÓN para atomicidad
            $conn->beginTransaction();
            
            //VALIDAR USERNAME EXISTENTE Y ACTIVO
            $query_usuario = "SELECT id_usuario FROM usuarios 
                            WHERE nombre_usuario = :username AND status = 1";
            $stmt_usuario = $conn->prepare($query_usuario);
            $stmt_usuario->bindValue(':username', $this->getUsername());
            $stmt_usuario->execute();
            
            //si encuentra el usuario se almacena en una variable
            $usuario = $stmt_usuario->fetch(PDO::FETCH_ASSOC);
            
            //si no lo encuentra o no esta vacio revierte la transaccion
            if (!$usuario) {

                //revierte la transaccion
                $conn->rollBack();

                //retorna un mensaje de error para el cliente
                return ['status' => false, 'msj' => 'Usuario no encontrado o inactivo.'];
            }
            
            //se almacena el id del usuario
            $usuario_id = $usuario['id_usuario'];
            
            //VALIDAR CÓDIGO Y TOKEN (exactamente 1 fila)
            $query_validar = "SELECT * FROM recuperar_codigos 
                            WHERE id_usuario = :usuario_id 
                            AND codigo = :codigo 
                            AND token = :token 
                            AND usado = 0 
                            AND expira > NOW()
                            LIMIT 1";
            $stmt_validar = $conn->prepare($query_validar);
            $stmt_validar->bindValue(':usuario_id', $usuario_id);
            $stmt_validar->bindValue(':codigo', $this->getCodigo());
            $stmt_validar->bindValue(':token', $this->getToken());
            $stmt_validar->execute();
            
            // Si no se encuentra exactamente 1 registro, el código/token 
            // es inválido, expirado o ya usado
            if ($stmt_validar->rowCount() !== 1) {

                // revierte la transaccion
                $conn->rollBack();

                //retorna un mensaje de error para el cliente
                return ['status' => false, 'msj' => 'Código o token inválido/expirado/usado.'];
            }
            
            //MARCAR CÓDIGO COMO USADO
            $update_codigo = $conn->prepare("UPDATE recuperar_codigos 
                                            SET usado = 1 
                                            WHERE id_usuario = :usuario_id 
                                            AND codigo = :codigo 
                                            AND token = :token");
            $update_codigo->bindValue(':usuario_id', $usuario_id);
            $update_codigo->bindValue(':codigo', $this->getCodigo());
            $update_codigo->bindValue(':token', $this->getToken());
            
            // Si no se pudo marcar como usado, algo salió mal
            if (!$update_codigo->execute()) {

                // revierte la transaccion
                $conn->rollBack();

                //retorna un mensaje de error para el cliente
                return ['status' => false, 'msj' => 'Error al procesar código de verificación.'];
            }
            
            //ACTUALIZAR PASSWORD
            $query_password = "UPDATE usuarios SET password_usuario = :password 
                            WHERE id_usuario = :id";
            $stmt_password = $conn->prepare($query_password);
            $stmt_password->bindValue(':password', $this->getPassword());
            $stmt_password->bindValue(':id', $usuario_id);
            
            // Si se ejecuta correctamente, confirma la transacción. Si no, revierte todo.
            if ($stmt_password->execute()) {

                // confirma la transaccion
                $conn->commit();

                //retorna un mensaje de exito para el cliente
                return ['status' => true, 'msj' => 'Contraseña actualizada exitosamente.'];
            } 
            else {

                // revierte la transaccion
                $conn->rollBack();

                //retorna un mensaje de error para el cliente
                return ['status' => false, 'msj' => 'Error al actualizar contraseña.'];
            }
            
        } catch (PDOException $e) {

            // retorna mensaje de error del exception del pdo
            error_log('Error cambio password: ' . $e->getMessage());

            //retorna un mensaje de error generico para el cliente
            return ['status' => false, 'msj' => 'Error en base de datos.'];
        } 
        finally {

            //finaliza la función cerrando la conexión a la bd
            $this->closeConnection();
        }
    }

}
?>