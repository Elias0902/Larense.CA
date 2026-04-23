<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - Larense C.A</title>
    <?php
    require_once 'components/links.php';
    ?>
    <style>
        .profile-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .profile-layout {
            display: grid;
            grid-template-columns: 380px 1fr;
            gap: 25px;
            align-items: start;
        }

        @media (max-width: 992px) {
            .profile-layout {
                grid-template-columns: 1fr;
            }
        }

        .profile-card {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            margin-top: 20px;
        }

        .profile-header {
            background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
            color: white;
            padding: 30px;
            text-align: center;
            position: relative;
        }

        .profile-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .profile-avatar-container {
            position: relative;
            display: inline-block;
            margin-bottom: 15px;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
            background: #f0f0f0;
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
        }

        /* Modal para ver imagen ampliada */
        .image-modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            animation: fadeIn 0.3s ease;
        }

        .image-modal.active {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .image-modal-content {
            max-width: 80%;
            max-height: 80%;
            border-radius: 10px;
            animation: zoomIn 0.3s ease;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.5);
        }

        .image-modal-close {
            position: absolute;
            top: 30px;
            right: 40px;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
            z-index: 10001;
        }

        .image-modal-close:hover {
            color: #cc1d1d;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes zoomIn {
            from { transform: scale(0.8); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .avatar-overlay {
            position: absolute;
            bottom: 0;
            right: 0;
            background: rgba(0, 0, 0, 0.7);
            width: 35px;
            height: 35px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid white;
        }

        .avatar-overlay:hover {
            background: rgba(0, 0, 0, 0.9);
            transform: scale(1.1);
        }

        .avatar-overlay i {
            color: white;
            font-size: 14px;
        }

        .profile-name {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .profile-role {
            font-size: 0.9rem;
            opacity: 0.9;
            background: rgba(255, 255, 255, 0.2);
            padding: 4px 12px;
            border-radius: 15px;
            display: inline-block;
        }

        .profile-body {
            padding: 30px;
        }

        .info-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }

        .info-icon i {
            color: white;
            font-size: 18px;
        }

        .info-content {
            flex: 1;
        }

        .info-label {
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 3px;
        }

        .info-value {
            font-size: 1rem;
            font-weight: 600;
            color: #1a1b2b;
        }

        .profile-actions {
            display: flex;
            gap: 15px;
            padding: 0 30px 30px;
        }

        .btn-profile {
            flex: 1;
            padding: 12px 20px;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-password {
            background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
            color: white;
            border: none;
        }

        .btn-password:hover {
            background: linear-gradient(135deg, #a81717 0%, #6b0f0f 100%);
            transform: translateY(-2px);
            color: white;
        }

        .btn-back {
            background: #f3f4f6;
            color: #374151;
            border: 1px solid #e5e7eb;
        }

        .btn-back:hover {
            background: #e5e7eb;
            transform: translateY(-2px);
            color: #374151;
        }

        /* Modal para cambiar contrasena */
        .modal-content {
            border-radius: 20px;
            border: none;
        }

        .modal-header {
            background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
            color: white;
            border-radius: 20px 20px 0 0;
        }

        .modal-title {
            font-weight: 600;
        }

        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #e5e7eb;
        }

        .form-control:focus {
            border-color: #cc1d1d;
            box-shadow: 0 0 0 3px rgba(204, 29, 29, 0.1);
        }

        .btn-save {
            background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
            color: white;
            border: none;
            border-radius: 12px;
            padding: 10px 25px;
            font-weight: 600;
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #a81717 0%, #6b0f0f 100%);
            color: white;
        }

        /* Menu de opciones de imagen */
        .avatar-options {
            position: absolute;
            top: 130px;
            left: 50%;
            transform: translateX(-50%);
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
            padding: 10px 0;
            min-width: 180px;
            z-index: 1000;
            display: none;
        }

        .avatar-options.show {
            display: block;
        }

        .avatar-option {
            padding: 10px 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s ease;
            color: #333;
            font-size: 0.95rem;
            font-weight: 500;
        }

        .avatar-option:hover {
            background: #f3f4f6;
            color: #000;
        }

        .avatar-option i {
            color: #cc1d1d;
            width: 20px;
            font-size: 1rem;
        }

        .avatar-option.delete-option:hover {
            background: #fee2e2;
        }

        .avatar-option.delete-option i {
            color: #dc3545;
        }

        /* Seccion de Seguridad */
        .security-section {
            margin-top: 25px;
        }

        .security-card-header {
            padding: 25px;
            border-bottom: 1px solid #f0f0f0;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .security-card-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .security-card-icon i {
            color: white;
            font-size: 20px;
        }

        .security-card-title {
            flex: 1;
        }

        .security-card-title h3 {
            font-size: 1.1rem;
            font-weight: 600;
            color: #1a1b2b;
            margin: 0;
        }

        .security-card-title p {
            font-size: 0.85rem;
            color: #6b7280;
            margin: 0;
        }

        .badge-2fa {
            background: #ecfdf5;
            color: #059669;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .security-list {
            padding: 0;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .security-list {
                grid-template-columns: 1fr;
            }
        }

        .security-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 25px 15px;
            background: #fafafa;
            border-radius: 16px;
            transition: all 0.2s ease;
            border: 2px solid transparent;
        }

        .security-item:hover {
            background: #f0f0f0;
            border-color: #e5e7eb;
            transform: translateY(-2px);
        }

        .security-item-icon {
            width: 55px;
            height: 55px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0;
            margin-bottom: 12px;
            flex-shrink: 0;
        }

        .security-item-icon i {
            font-size: 24px;
        }

        .security-item-icon.email {
            background: #ecfdf5;
            color: #10b981;
        }

        .security-item-icon.phone {
            background: #fef3c7;
            color: #f59e0b;
        }

        .security-item-icon.id {
            background: #eff6ff;
            color: #3b82f6;
        }

        .security-item-icon i {
            font-size: 18px;
        }

        .security-item-content {
            flex: 1;
            width: 100%;
        }

        .security-item-content h4 {
            font-size: 1rem;
            font-weight: 600;
            color: #1a1b2b;
            margin: 0 0 6px 0;
        }

        .security-item-content p {
            font-size: 0.8rem;
            color: #6b7280;
            margin: 0;
            word-break: break-word;
        }

        .security-item-status {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            font-size: 0.7rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
            margin-top: 12px;
            padding: 6px 12px;
            border-radius: 20px;
            background: white;
        }

        .status-verified {
            color: #10b981;
            background: #ecfdf5;
        }

        .status-pending {
            color: #f59e0b;
            background: #fffbeb;
        }

        .status-pending-secondary {
            color: #9ca3af;
            background: #f3f4f6;
        }


        .security-actions {
            padding: 20px 25px;
            border-top: 1px solid #f0f0f0;
        }

        .btn-configure {
            background: #1a1b2b;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 12px 20px;
            font-weight: 600;
            font-size: 0.9rem;
            width: 100%;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-configure:hover {
            background: #2d2f45;
            color: white;
            transform: translateY(-1px);
        }

        .security-alert {
            background: #fffbeb;
            border-top: 1px solid #fcd34d;
            padding: 18px 25px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .security-alert-icon {
            width: 32px;
            height: 32px;
            background: #fbbf24;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .security-alert-icon i {
            color: white;
            font-size: 14px;
        }

        .security-alert-content h4 {
            font-size: 0.9rem;
            font-weight: 600;
            color: #92400e;
            margin: 0 0 3px 0;
        }

        .security-alert-content p {
            font-size: 0.8rem;
            color: #b45309;
            margin: 0;
            line-height: 1.4;
        }

        /* Method options in modal */
        .method-option {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 18px;
            margin-bottom: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .method-option:hover {
            border-color: #cc1d1d;
            background: #fef2f2;
        }

        .method-option-icon {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .method-option-icon.sms {
            background: #ecfdf5;
            color: #10b981;
        }

        .method-option-icon.app {
            background: #eff6ff;
            color: #3b82f6;
        }

        .method-option-icon.email-2fa {
            background: #fef3c7;
            color: #f59e0b;
        }

        .method-option-content h4 {
            font-size: 0.95rem;
            font-weight: 600;
            color: #1a1b2b;
            margin: 0 0 2px 0;
        }

        .method-option-content p {
            font-size: 0.8rem;
            color: #6b7280;
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 576px) {
            .profile-container {
                padding: 10px;
            }

            .profile-actions {
                flex-direction: column;
            }

            .profile-header {
                padding: 20px;
            }

            .profile-title {
                font-size: 1.5rem;
            }

            .profile-name {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <?php
    require_once 'components/menu.php';
    require_once 'components/header.php';
    ?>

    <div class="container">
        <div class="profile-container">
            <div class="profile-layout">
                <!-- Columna Izquierda: Perfil -->
                <div class="profile-card">
                <!-- Header del perfil -->
                <div class="profile-header">
                    <h1 class="profile-title">Mi Perfil</h1>

                    <!-- Foto de perfil -->
                    <div class="profile-avatar-container">
                        <img src="<?php echo !empty($usuario['imagen_perfil']) ? $usuario['imagen_perfil'] : 'assets/img/profile.jpg'; ?>"
                             alt="Foto de perfil"
                             class="profile-avatar"
                             id="imagenPerfil"
                             onclick="abrirModalImagen()"
                             title="Click para ver más grande">

                        <!-- Boton para opciones de imagen -->
                        <div class="avatar-overlay" onclick="toggleAvatarOptions()">
                            <i class="fas fa-camera"></i>
                        </div>

                        <!-- Menu de opciones -->
                        <div class="avatar-options" id="avatarOptions">
                            <div class="avatar-option" onclick="seleccionarImagen()">
                                <i class="fas fa-upload"></i>
                                <span>Cambiar imagen</span>
                            </div>
                            <?php if (!empty($usuario['imagen_perfil'])): ?>
                            <div class="avatar-option delete-option" onclick="eliminarImagen()">
                                <i class="fas fa-trash"></i>
                                <span>Eliminar imagen</span>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <h2 class="profile-name"><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></h2>
                    <span class="profile-role"><?php echo htmlspecialchars($usuario['nombre_rol']); ?></span>
                </div>

                <!-- Informacion del usuario -->
                <div class="profile-body">
                    <!-- Nombre de Usuario -->
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Nombre de Usuario</div>
                            <div class="info-value"><?php echo htmlspecialchars($usuario['nombre_usuario']); ?></div>
                        </div>
                    </div>

                    <!-- Correo Electronico -->
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Correo Electronico</div>
                            <div class="info-value"><?php echo htmlspecialchars($usuario['email_usuario']); ?></div>
                        </div>
                    </div>

                    <!-- Rol -->
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-id-badge"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Rol</div>
                            <div class="info-value"><?php echo htmlspecialchars($usuario['nombre_rol']); ?></div>
                        </div>
                    </div>

                    <!-- Ultimo Acceso -->
                    <div class="info-item">
                        <div class="info-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="info-content">
                            <div class="info-label">Ultimo acceso</div>
                            <div class="info-value"><?php echo date('d/m/Y, h:i:s a', strtotime($ultimo_acceso)); ?></div>
                        </div>
                    </div>
                </div>

                <!-- Botones de accion -->
                <div class="profile-actions">
                    <button class="btn btn-profile btn-password" onclick="abrirModalPassword()">
                        <i class="fas fa-lock"></i>
                        Cambiar Contrasena
                    </button>
                    <a href="index.php?url=dashboard" class="btn btn-profile btn-back">
                        <i class="fas fa-arrow-left"></i>
                        Volver al Inicio
                    </a>
                </div>

                <?php
                // Solo mostrar simulación para Superusuario (1) o Administrador (2)
                $rol_usuario = $_SESSION['s_usuario']['id_rol_usuario'] ?? 0;
                if ($rol_usuario == 1 || $rol_usuario == 2):
                ?>
                <!-- Simulacion de Roles (Solo Administradores) -->
                <div class="profile-section mt-4">
                    <h6 class="text-muted mb-3"><i class="fas fa-eye me-2"></i>Simular Vista de Usuario</h6>
                    <p class="text-muted small mb-3">Cambia temporalmente tu rol para ver el sistema como otro tipo de usuario.</p>
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-outline-primary btn-sm" onclick="simularRolPerfil(3)">
                            <i class="fas fa-store me-1"></i>Ver como Vendedor
                        </button>
                        <button class="btn btn-outline-info btn-sm" onclick="simularRolPerfil(4)">
                            <i class="fas fa-user me-1"></i>Ver como Usuario
                        </button>
                        <?php if (isset($_SESSION['rol_simulado']) && $_SESSION['rol_simulado']): ?>
                        <button class="btn btn-warning btn-sm" onclick="restaurarRolPerfil()">
                            <i class="fas fa-undo me-1"></i>Restaurar mi rol (<?php echo $_SESSION['nombre_rol_original'] ?? 'Admin'; ?>)
                        </button>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
                </div>

                <!-- Columna Derecha: Seguridad -->
                <div class="profile-card security-section">
                <div class="security-card-header">
                    <div class="security-card-icon">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                    <div class="security-card-title">
                        <h3>Verificacion de Seguridad (2FA)</h3>
                        <p>Estado de tus metodos de verificacion</p>
                    </div>
                    <span class="badge-2fa">
                        <i class="fas fa-check-circle"></i> 2FA
                    </span>
                </div>

                <div class="security-list">
                    <!-- Email Verification -->
                    <div class="security-item">
                        <div class="security-item-icon email">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="security-item-content">
                            <h4>Email Verification</h4>
                            <p><?php echo htmlspecialchars($usuario['email_usuario']); ?></p>
                        </div>
                        <div class="security-item-status status-verified">
                            <i class="fas fa-check-circle"></i> VERIFIED
                        </div>
                    </div>

                    <!-- Phone Verification -->
                    <div class="security-item">
                        <div class="security-item-icon phone">
                            <i class="fas fa-mobile-alt"></i>
                        </div>
                        <div class="security-item-content">
                            <h4>Phone Verification</h4>
                            <p><?php echo !empty($usuario['telefono_usuario']) ? htmlspecialchars($usuario['telefono_usuario']) : 'Vincula tu numero movil para mayor seguridad'; ?></p>
                        </div>
                        <div class="security-item-status <?php echo !empty($usuario['telefono_usuario']) ? 'status-verified' : 'status-pending'; ?>">
                            <i class="fas fa-<?php echo !empty($usuario['telefono_usuario']) ? 'check-circle' : 'clock'; ?>"></i>
                            <?php echo !empty($usuario['telefono_usuario']) ? 'VERIFIED' : 'PENDING'; ?>
                        </div>
                    </div>

                    <!-- ID Verification -->
                    <div class="security-item">
                        <div class="security-item-icon id">
                            <i class="fas fa-fingerprint"></i>
                        </div>
                        <div class="security-item-content">
                            <h4>ID Verification</h4>
                            <p>Verificacion de identidad oficial</p>
                        </div>
                        <div class="security-item-status status-pending-secondary">
                            PENDING
                        </div>
                    </div>
                </div>

                <!-- Boton Configurar -->
                <div class="security-actions">
                    <button class="btn btn-configure" onclick="abrirModalConfigurar()">
                        <i class="fas fa-cog"></i> Configurar Nuevo Metodo
                    </button>
                </div>

                <!-- Alerta de Seguridad -->
                <div class="security-alert">
                    <div class="security-alert-icon">
                        <i class="fas fa-exclamation"></i>
                    </div>
                    <div class="security-alert-content">
                        <h4>Seguridad Recomendada</h4>
                        <p>Tu cuenta tiene un nivel de seguridad medio. Te recomendamos completar la verificacion telefonica para habilitar retiros y cambios sensibles.</p>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Cambiar Contrasena -->
    <div class="modal fade" id="modalPassword" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-lock me-2"></i>Cambiar Contrasena
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formCambiarPassword">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Contrasena Actual</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password_actual" id="password_actual" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_actual')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Nueva Contrasena</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password_nueva" id="password_nueva" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_nueva')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            <small class="text-muted">Minimo 6 caracteres, una mayuscula y un punto</small>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Confirmar Nueva Contrasena</label>
                            <div class="input-group">
                                <input type="password" class="form-control" name="password_confirmar" id="password_confirmar" required>
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmar')">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Input oculto para seleccionar imagen -->
    <input type="file" id="inputImagen" accept="image/*" style="display: none;" onchange="subirImagen(this)">

    <!-- Modal Configurar Metodo 2FA -->
    <div class="modal fade" id="modalConfigurar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-cog me-2"></i>Configurar Nuevo Metodo
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <p class="text-muted mb-4">Selecciona un metodo de verificacion adicional para aumentar la seguridad de tu cuenta.</p>

                    <div class="method-option" onclick="seleccionarMetodo('sms')">
                        <div class="method-option-icon sms">
                            <i class="fas fa-sms"></i>
                        </div>
                        <div class="method-option-content">
                            <h4>SMS Verification</h4>
                            <p>Recibe codigos de verificacion por mensaje de texto</p>
                        </div>
                    </div>

                    <div class="method-option" onclick="seleccionarMetodo('app')">
                        <div class="method-option-icon app">
                            <i class="fas fa-mobile"></i>
                        </div>
                        <div class="method-option-content">
                            <h4>Authenticator App</h4>
                            <p>Usa Google Authenticator o similar para generar codigos</p>
                        </div>
                    </div>

                    <div class="method-option" onclick="seleccionarMetodo('email')">
                        <div class="method-option-icon email-2fa">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="method-option-content">
                            <h4>Email 2FA</h4>
                            <p>Recibe codigos de verificacion en tu correo electronico</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal SMS -->
    <div class="modal fade" id="modalSMS" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">
                        <i class="fas fa-sms me-2"></i>Verificacion SMS
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="formSMS">
                        <div class="mb-3">
                            <label class="form-label fw-semibold">Numero de Telefono</label>
                            <div class="input-group">
                                <span class="input-group-text">+58</span>
                                <input type="tel" class="form-control" name="telefono" id="telefono"
                                       placeholder="4121234567" maxlength="10" required>
                            </div>
                            <small class="text-muted">Ingresa tu numero sin el codigo de pais</small>
                        </div>
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-save">
                                <i class="fas fa-paper-plane me-2"></i>Enviar Codigo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'components/scripts.php'; ?>

    <script>
        // Toggle menu de opciones de avatar
        function toggleAvatarOptions() {
            const menu = document.getElementById('avatarOptions');
            menu.classList.toggle('show');
        }

        // Cierra el menu al hacer click fuera
        document.addEventListener('click', function(e) {
            const container = document.querySelector('.profile-avatar-container');
            const menu = document.getElementById('avatarOptions');
            if (!container.contains(e.target)) {
                menu.classList.remove('show');
            }
        });

        // Seleccionar nueva imagen
        function seleccionarImagen() {
            document.getElementById('inputImagen').click();
            document.getElementById('avatarOptions').classList.remove('show');
        }

        // Subir imagen
        function subirImagen(input) {
            if (input.files && input.files[0]) {
                const formData = new FormData();
                formData.append('imagen_perfil', input.files[0]);

                // Debug: mostrar que se esta enviando
                console.log('Enviando imagen:', input.files[0].name);

                fetch('index.php?url=perfil&action=actualizarImagen', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    console.log('Response status:', response.status);
                    return response.json();
                })
                .then(data => {
                    console.log('Respuesta del servidor:', data);
                    if (data.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Imagen actualizada',
                            text: data.msj,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        // Actualizar la imagen inmediatamente con la nueva ruta (con cache-buster)
                        const nuevaRuta = data.imagen + '?' + new Date().getTime();
                        console.log('Nueva ruta de imagen:', nuevaRuta);

                        // Actualizar imagen principal del perfil
                        document.getElementById('imagenPerfil').src = nuevaRuta;

                        // Actualizar imagen del header si existe
                        const headerImg = document.getElementById('headerAvatarImg');
                        if (headerImg) headerImg.src = nuevaRuta;

                        // Actualizar sesion mediante AJAX para que persista
                        fetch('index.php?url=perfil&action=ver', { method: 'GET' })
                            .then(() => console.log('Sesion actualizada'));

                        // Opcional: recargar para sincronizar todo (descomentar si se prefiere)
                        // setTimeout(() => location.reload(), 2000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: data.msj || 'Error desconocido al actualizar la imagen'
                        });
                    }
                })
                .catch(error => {
                    console.error('Error en fetch:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error al subir la imagen: ' + error.message
                    });
                });
            }
        }

        // Eliminar imagen
        function eliminarImagen() {
            document.getElementById('avatarOptions').classList.remove('show');

            Swal.fire({
                title: 'Eliminar imagen?',
                text: 'Se eliminara tu foto de perfil',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#cc1d1d',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Si, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('index.php?url=perfil&action=eliminarImagen', {
                        method: 'POST'
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Imagen eliminada',
                                text: data.msj,
                                timer: 2000,
                                showConfirmButton: false
                            });
                            // Actualizar a imagen por defecto sin recargar
                            const defaultImg = 'assets/img/profile.jpg';
                            document.getElementById('imagenPerfil').src = defaultImg;

                            // Actualizar imagen del header si existe
                            const headerImg = document.getElementById('headerAvatarImg');
                            if (headerImg) headerImg.src = defaultImg;

                            // Ocultar opcion de eliminar del menu
                            const avatarOptions = document.getElementById('avatarOptions');
                            const deleteOption = avatarOptions.querySelector('.delete-option');
                            if (deleteOption) deleteOption.style.display = 'none';

                            // Opcional: recargar para sincronizar todo
                            // setTimeout(() => location.reload(), 2000);
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.msj
                            });
                        }
                    });
                }
            });
        }

        // Abrir modal de contrasena
        function abrirModalPassword() {
            const modal = new bootstrap.Modal(document.getElementById('modalPassword'));
            modal.show();
        }

        // Toggle mostrar/ocultar contrasena
        function togglePassword(inputId) {
            const input = document.getElementById(inputId);
            const icon = input.nextElementSibling.querySelector('i');

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Cambiar contrasena
        document.getElementById('formCambiarPassword').addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch('index.php?url=perfil&action=cambiarPassword', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Contrasena cambiada',
                        text: data.msj,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    bootstrap.Modal.getInstance(document.getElementById('modalPassword')).hide();
                    this.reset();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.msj
                    });
                }
            })
            .catch(error => {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error al cambiar la contrasena'
                });
            });
        });

        // ===== FUNCIONES DE SIMULACIÓN DE ROLES =====
        function simularRolPerfil(id_rol) {
            const formData = new FormData();
            formData.append('id_rol', id_rol);

            fetch('index.php?url=perfiles&action=simularRol', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Simulación activada',
                        text: data.msj,
                        timer: 2000,
                        showConfirmButton: false
                    });
                    setTimeout(() => location.reload(), 2000);
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: data.msj });
                }
            });
        }

        function restaurarRolPerfil() {
            fetch('index.php?url=perfiles&action=restaurarRol', {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.status) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Rol restaurado',
                        text: data.msj,
                        timer: 1500,
                        showConfirmButton: false
                    });
                    setTimeout(() => location.reload(), 1500);
                } else {
                    Swal.fire({ icon: 'error', title: 'Error', text: data.msj });
                }
            });
        }

        // ===== FUNCIONES DE SEGURIDAD 2FA =====
        function abrirModalConfigurar() {
            const modal = new bootstrap.Modal(document.getElementById('modalConfigurar'));
            modal.show();
        }

        function seleccionarMetodo(metodo) {
            bootstrap.Modal.getInstance(document.getElementById('modalConfigurar')).hide();

            if (metodo === 'sms') {
                setTimeout(() => {
                    const modalSMS = new bootstrap.Modal(document.getElementById('modalSMS'));
                    modalSMS.show();
                }, 300);
            } else {
                Swal.fire({
                    icon: 'info',
                    title: 'Proximamente',
                    text: 'Esta funcion estara disponible pronto.',
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        }

        // Formulario SMS
        document.getElementById('formSMS')?.addEventListener('submit', function(e) {
            e.preventDefault();

            const telefono = document.getElementById('telefono').value;

            // Validar formato
            if (!/^[0-9]{10}$/.test(telefono)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Numero invalido',
                    text: 'Ingresa un numero de 10 digitos valido.'
                });
                return;
            }

            // Simular envio
            Swal.fire({
                icon: 'success',
                title: 'Codigo Enviado',
                text: 'Se ha enviado un codigo de verificacion al +58 ' + telefono,
                timer: 2000,
                showConfirmButton: false
            });

            bootstrap.Modal.getInstance(document.getElementById('modalSMS')).hide();
            this.reset();
        });

        // Solo permitir numeros en el campo telefono
        document.getElementById('telefono')?.addEventListener('input', function(e) {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        // ===== FUNCIONES DE MODAL DE IMAGEN =====
        function abrirModalImagen() {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImagen');
            const perfilImg = document.getElementById('imagenPerfil');

            modalImg.src = perfilImg.src;
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function cerrarModalImagen(event) {
            if (event) event.stopPropagation();
            const modal = document.getElementById('imageModal');
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Cerrar modal con tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('imageModal');
                if (modal.classList.contains('active')) {
                    cerrarModalImagen();
                }
            }
        });
    </script>

    <!-- Modal para ver imagen ampliada -->
    <div id="imageModal" class="image-modal" onclick="cerrarModalImagen(event)">
        <span class="image-modal-close" onclick="cerrarModalImagen(event)">&times;</span>
        <img class="image-modal-content" id="modalImagen" onclick="event.stopPropagation()">
    </div>

    <?php require_once 'components/footer.php'; ?>
</body>
</html>
