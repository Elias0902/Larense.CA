<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Natys - Recuperar Contraseña</title>
    
    <?php 
    require_once "components/links.php";
    require_once "components/alerts.php";
    ?>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #cc1d1d;
            --primary-hover: #a81717;
            --text-dark: #1a1b2b;
            --text-gray: #6b7280;
            --bg-gray: #f4f6f9;
            --border-color: #e5e7eb;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #e8ebf2;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
            overflow-x: hidden;
            transition: background-color 0.3s ease;
        }

        body.dark-mode {
            background-color: #1a1b2b;
        }

        /* Toggle switch */
        .theme-toggle {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background: white;
            border-radius: 50px;
            padding: 8px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .theme-toggle:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 16px rgba(0,0,0,0.2);
        }

        .theme-toggle .toggle-switch {
            width: 50px;
            height: 26px;
            background: #e5e7eb;
            border-radius: 13px;
            position: relative;
            transition: background 0.3s ease;
        }

        .theme-toggle.dark .toggle-switch {
            background: var(--primary-color);
        }

        .theme-toggle .toggle-slider {
            width: 22px;
            height: 22px;
            background: white;
            border-radius: 50%;
            position: absolute;
            top: 2px;
            left: 2px;
            transition: transform 0.3s ease;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .theme-toggle.dark .toggle-slider {
            transform: translateX(24px);
        }

        .theme-toggle i {
            font-size: 14px;
            color: var(--text-gray);
        }

        .theme-toggle.dark i.fa-sun {
            color: var(--primary-color);
        }

        .theme-toggle:not(.dark) i.fa-moon {
            color: var(--primary-color);
        }

        .container {
            background-color: #ffffff;
            width: 100%;
            max-width: 1100px;
            min-height: 650px;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            display: flex;
            position: relative;
            overflow: hidden;
        }

        .left-panel, .right-panel {
            width: 50%;
            transition: transform 0.7s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
        }

        .left-panel {
            background-color: #ffffff;
            padding: 40px 50px;
            display: flex;
            flex-direction: column;
            z-index: 2; 
        }

        .right-panel {
            background-color: var(--bg-gray);
            padding: 40px;
            display: flex;
            flex-direction: column;
            z-index: 1;
        }

        .back-btn {
            background: none;
            border: none;
            color: var(--text-gray);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 30px;
            width: fit-content;
            transition: color 0.3s, transform 0.3s;
        }

        .back-btn:hover {
            color: var(--primary-color);
            transform: translateX(-3px);
        }

        .back-btn svg { width: 18px; height: 18px; }

        .form-wrapper {
            position: relative;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h1 {
            font-size: 32px;
            color: var(--text-dark);
            margin-bottom: 30px;
            text-align: center;
        }

        .form-group { margin-bottom: 20px; }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 8px;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
            isolation: isolate;
        }

        .input-group .input-icon-left {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-gray);
            z-index: 10;
            pointer-events: none;
            transition: color 0.3s ease;
            font-size: 14px;
        }

        .input-group .input-icon-right {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-gray);
            z-index: 5;
            pointer-events: none;
            transition: color 0.3s ease;
            font-size: 14px;
        }

        .input-group .input-icon-right.error {
            color: #dc3545;
        }

        .input-group .input-icon-right.success {
            color: #28a745;
        }

        .form-control {
            width: 100%;
            padding: 12px 40px 12px 40px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 14px;
            outline: none;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .form-control:focus { 
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(204, 29, 29, 0.1);
        }

        .form-control.is-valid {
            border-color: #28a745;
        }

        .form-control.is-invalid {
            border-color: #dc3545;
        }

        .submit-btn {
            width: 100%;
            padding: 14px;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s, transform 0.2s;
            margin-bottom: 20px;
            box-shadow: 0 4px 12px rgba(204, 29, 29, 0.2);
        }

        .submit-btn:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }

        .bottom-text {
            text-align: center;
            font-size: 14px;
            color: var(--text-gray);
            margin-top: 10px;
        }

        .forgot-link, .switch-link {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            transition: opacity 0.3s;
        }

        .forgot-link:hover, .switch-link:hover {
            text-decoration: underline;
            opacity: 0.8;
        }

        .system-info {
            align-self: flex-end;
            text-align: right;
            max-width: 350px;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        }
        .system-info h3 {
            font-size: 16px;
            color: var(--text-dark);
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
        }
        .system-info p {
            font-size: 13px;
            color: var(--text-gray);
            line-height: 1.5;
        }
        .illustration-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        /* Estilos modo oscuro para recuperar */
        body.dark-mode .container {
            background-color: #1a1f2e;
        }

        body.dark-mode .left-panel {
            background-color: #1a1f2e;
        }

        body.dark-mode .right-panel {
            background-color: #131725;
        }

        body.dark-mode h1,
        body.dark-mode .form-group label,
        body.dark-mode .system-info h3,
        body.dark-mode .system-info p {
            color: #e7e9f0 !important;
        }

        body.dark-mode .form-control {
            background-color: #2a3041;
            border-color: #3a4055;
            color: #ffffff;
        }

        body.dark-mode .form-control::placeholder {
            color: #ffffff;
        }

        body.dark-mode .form-control::-webkit-input-placeholder {
            color: #ffffff;
        }

        body.dark-mode .form-control::-moz-placeholder {
            color: #ffffff;
        }

        body.dark-mode .form-control:-ms-input-placeholder {
            color: #ffffff;
        }

        body.dark-mode .input-icon-left {
            color: #e7e9f0;
        }

        body.dark-mode .input-icon-right {
            color: #e7e9f0;
        }

        body.dark-mode .form-control:focus {
            border-color: #cc1d1d;
            box-shadow: 0 0 0 3px rgba(204, 29, 29, 0.2);
        }

        body.dark-mode .theme-toggle {
            background: #2a3041;
        }

        body.dark-mode .theme-toggle .toggle-switch {
            background: #3a4055;
        }

        body.dark-mode .system-info {
            background: #131725;
        }

        body.dark-mode .bottom-text {
            color: #9ca3af;
        }

        @media (max-width: 768px) {
            .container { flex-direction: column; min-height: auto; }
            .left-panel, .right-panel { width: 100%; padding: 30px 20px; }
            .right-panel { display: none; }
        }
    </style>
</head>
<body>

    <!-- Theme Toggle -->
    <div class="theme-toggle" id="theme-toggle" onclick="toggleTheme()">
        <i class="fa fa-sun"></i>
        <div class="toggle-switch">
            <div class="toggle-slider"></div>
        </div>
        <i class="fa fa-moon"></i>
    </div>

    <div class="container" id="main-container">
        
        <div class="left-panel">
            
            <button id="btn-volver" class="back-btn" type="button" onclick="window.history.back()">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="19" y1="12" x2="5" y2="12"></line>
                    <polyline points="12 19 5 12 12 5"></polyline>
                </svg>
                Volver
            </button>

            <div class="form-wrapper">
                
                <div class="form-view active">
                    <h1>Recuperar Contraseña</h1>
                    <p style="text-align: center; color: var(--text-gray); margin-bottom: 25px; font-size: 14px;">
                        Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.
                    </p>
                    
                    <form class="formulario user" onsubmit="return formulario_validaciones()" action="index.php?url=autenticator&action=recuperar" method="post">
                        
                        <div class="form-group">
                            <label>Correo Electrónico</label>
                            <div class="input-group">
                                <i class="fa fa-envelope input-icon-left"></i>
                                <input type="email" class="form-control input_email" name="email" id="email" placeholder="correo@ejemplo.com" oninput="email_validacion()" required>
                                <span id="icono-validacionEmail" class="input-icon-right"></span>
                            </div>
                            <span id="errorEmail" class="error-messege" style="color: red; font-size: 12px; margin-top: 4px; display: block;"></span>
                        </div>
                        
                        <button type="submit" class="submit-btn">ENVIAR EMAIL &rarr;</button>
                    </form>

                    <div class="bottom-text">
                        <a href="index.php?url=autenticator&action=login" class="switch-link">Volver al inicio de sesión</a>
                    </div>
                    
                    <div class="bottom-text">
                        ¿No tienes cuenta? <a href="index.php?url=autenticator&action=register" class="switch-link">Regístrate aquí</a>
                    </div>
                </div>

            </div>
        </div>

        <div class="right-panel">
            <div class="system-info">
                <h3>🏢 La Larense C.A. (Natys)</h3>
                <p>Sistema de Gestión de Pedidos, Créditos y Compras. Plataforma integral para gestionar solicitudes de clientes, controlar inventario y coordinar entregas.</p>
            </div>
            
            <div class="illustration-container">
                <img src="assets/img/natys/natys.png" alt="Ilustración Sistema" style="max-width: 100%; opacity: 0.9;">
            </div>
        </div>

    </div>
    <script src="assets/js/validaciones/recuperar_validaciones.js"></script>
    <?php require_once "components/scripts.php"; ?>
</body>
</html>