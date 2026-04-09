<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/login.css">
    <?php 
    require_once "components/links.php";
    require_once "components/alerts.php";
    ?>
    <title>Larense CA : recuperar</title>
</head>
<body style='
  background-color: black;
  background-size: cover;
  background-position: center;
'>
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10 col-md-12 mx-auto">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <h1 class="h2 text-gray-900 "><b>Bienvenido</b></h1>
                                <img class="logo m-5" src="assets/img/natys.png" width='330' alt="logo">
                                </div>
                            </div>
                            <div class="col-lg-6">
                            <div class="divider-vertical"></div>
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4"><b>Recuperar Usuario</b></h1>
                                    </div>
                                    <form class="formulario user" onsubmit="return formulario_validaciones()" action="index.php?url=autenticator&action=cambiar&<?php echo 'token=' . htmlspecialchars($_GET['token']); ?>" method="post">
                                        <div class="form-group">
                                            <div class="input-group">
                                                    <i class="fa fa-user d-flex align-items-center"></i>
                                                    <input
                                                    type="text"
                                                    class="input_username"
                                                    placeholder="Ingrese su Username"
                                                    aria-label="Username"
                                                    aria-describedby="basic-addon1"
                                                    name='username' id='username' required
                                                    oninput="username_validacion()"
                                                    >
                                                <span id="icono-validacionUsername" class="input-icon"></span>
                                                <span id="errorUsername" class="error-messege"></span>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <i class="fa fa-lock d-flex align-items-center"></i>
                                                <input class="input_pw" type="password" name="password" id="password" placeholder="Ingrese su nueva password" required oninput="password_validacion()">
                                                <span id="icono-validacionPW" class="input-icon"></span>
                                                <span id="errorPW" class="error-messege"></span>
                                            </div>
                                        <div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                
                                                <input class="input_pw" type="text" name="codigo" id="codigo" placeholder="ingrese codigo" required oninput="codigo_validacion()">
                                                <span id="icono-validacionCOD" class="input-icon"></span>
                                                <span id="errorCOD" class="error-messege"></span>
                                            </div>
                                        </div>
                                        <br>
                                        <button class="btn_ingresar" type="">CAMBIAR CONTRASEÑA</button>
                                    
                                    <br>
                                    <center>
                                        <a class='btn btn-link' style='color:red' href="index.php?url=autenticator&action=login">Iniciar Session</a>
                                        </center>
                                    <center>
                                        <a class='btn btn-link' style='color:red' href="index.php?url=autenticator&action=register"><p style='color:black'>¿No tienes cuenta crea una?</p>Registrate</a>
                                    </center>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/validaciones/verificar_validaciones.js"></script>
    <?php require_once "components/scripts.php"; ?>
</body>
</html>