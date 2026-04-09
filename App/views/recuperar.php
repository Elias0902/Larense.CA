<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/login.css">
    <?php 
    require_once "components/links.php";
    require_once "components/alerts.php";
    ?>
    <title> Larense CA : Enviar Email</title>
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
                <div class="o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <h1 class="h2 text-gray-900 "><b>Bienvenido</b></h1>
                                <img class="logo m-5" src="assets/img/natys.png" width="330" alt="logo">
                                </div>
                            </div>
                            <div class="col-lg-6">
                            <div class="divider-vertical"></div>
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4"><b>Enviar Email de Recuperación</b></h1>
                                    </div>
                                    <form class="formulario user" onsubmit="return formulario_validaciones()" action="index.php?url=autenticator&action=recuperar" method="post">
                                        <div class="form-group">
                                            <div class="input-group">
                                                    <i class="fa fa-user d-flex align-items-center"></i></span>
                                                    <input
                                                    type="text"
                                                    class="input_username"
                                                    placeholder="Username@example.com"
                                                    aria-label="Email"
                                                    aria-describedby="basic-addon1"
                                                    name='email' id='email' 
                                                    oninput="email_validacion()"
                                                    required
                                                    />
                                                <span id="icono-validacionEmail" class="input-icon"></span>
                                                <span id="errorEmail" class="error-messege"></span>
                                            </div>
                                        </div>
                                        <center>
                                            <a class='btn btn-link' style='color:red' href="index.php?url=autenticator&action=login">Iniciar Session</a>
                                        </center>
                                        <br>
                                        <button class="btn_ingresar" type="submit">ENVIAR EMAIL</button>
                                    </form>
                                    <br>
                                    <center>
                                        <a class='btn btn-link' style='color:red' href="index.php?url=autenticator&action=register"><p style='color:black'>¿No tienes cuenta crea una?</p>Registrate</a>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                        
        </div>
    </div>
    <script src="assets/js/validaciones/recuperar_validaciones.js"></script>
    <?php require_once "components/scripts.php"; ?>
</body>
</html>