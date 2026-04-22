<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguridad - Larense C.A</title>
    <?php require_once 'components/links.php'; ?>
    <style>
        .security-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .security-header {
            margin-bottom: 25px;
        }

        .security-title {
            font-size: 1.8rem;
            font-weight: 700;
            color: #1a1b2b;
            margin-bottom: 5px;
        }

        .security-subtitle {
            font-size: 0.95rem;
            color: #6b7280;
        }

        .security-card {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            margin-bottom: 20px;
        }

        .security-card-header {
            padding: 20px 25px;
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

        .security-item {
            display: flex;
            align-items: center;
            padding: 20px 25px;
            border-bottom: 1px solid #f5f5f5;
            transition: background 0.2s ease;
        }

        .security-item:last-child {
            border-bottom: none;
        }

        .security-item:hover {
            background: #fafafa;
        }

        .security-item-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 18px;
            flex-shrink: 0;
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
            font-size: 20px;
        }

        .security-item-content {
            flex: 1;
        }

        .security-item-content h4 {
            font-size: 1rem;
            font-weight: 600;
            color: #1a1b2b;
            margin: 0 0 3px 0;
        }

        .security-item-content p {
            font-size: 0.85rem;
            color: #6b7280;
            margin: 0;
        }

        .security-item-status {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-verified {
            color: #10b981;
        }

        .status-pending {
            color: #f59e0b;
        }

        .status-pending-secondary {
            color: #9ca3af;
        }

        .btn-configure {
            background: #1a1b2b;
            color: white;
            border: none;
            border-radius: 10px;
            padding: 14px 24px;
            font-weight: 600;
            font-size: 0.95rem;
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
            border: 1px solid #fcd34d;
            border-radius: 12px;
            padding: 18px 22px;
            display: flex;
            align-items: flex-start;
            gap: 15px;
        }

        .security-alert-icon {
            width: 36px;
            height: 36px;
            background: #fbbf24;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .security-alert-icon i {
            color: white;
            font-size: 16px;
        }

        .security-alert-content h4 {
            font-size: 0.95rem;
            font-weight: 600;
            color: #92400e;
            margin: 0 0 5px 0;
        }

        .security-alert-content p {
            font-size: 0.85rem;
            color: #b45309;
            margin: 0;
            line-height: 1.5;
        }

        .btn-back-profile {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 15px;
            transition: color 0.2s ease;
        }

        .btn-back-profile:hover {
            color: #cc1d1d;
        }

        /* Modal styles */
        .modal-content {
            border-radius: 16px;
            border: none;
        }

        .modal-header {
            background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%);
            color: white;
            border-radius: 16px 16px 0 0;
        }

        .btn-close-white {
            filter: invert(1) grayscale(100%) brightness(200%);
        }

        .method-option {
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 15px;
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
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
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
            font-size: 1rem;
            font-weight: 600;
            color: #1a1b2b;
            margin: 0 0 3px 0;
        }

        .method-option-content p {
            font-size: 0.85rem;
            color: #6b7280;
            margin: 0;
        }

        @media (max-width: 576px) {
            .security-container {
                padding: 15px;
            }

            .security-title {
                font-size: 1.5rem;
            }

            .security-item {
                padding: 15px 20px;
            }

            .security-item-icon {
                width: 40px;
                height: 40px;
            }
        }
    </style>
</head>
<body>
    <?php require_once 'components/menu.php'; ?>
    <?php require_once 'components/header.php'; ?>

    <div class="container">
        <div class="security-container">
            <!-- Back button -->
            <a href="index.php?url=perfil&action=ver" class="btn-back-profile">
                <i class="fas fa-arrow-left"></i> Volver al Perfil
            </a>

            <!-- Header -->
            <div class="security-header">
                <h1 class="security-title">Seguridad</h1>
                <p class="security-subtitle">Gestion integral de la empresa Larense C.A</p>
            </div>

            <!-- 2FA Card -->
            <div class="security-card">
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

                <!-- Configure Button -->
                <div class="p-4">
                    <button class="btn btn-configure" onclick="abrirModalConfigurar()">
                        <i class="fas fa-cog"></i> Configurar Nuevo Metodo
                    </button>
                </div>
            </div>

            <!-- Security Alert -->
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

    <!-- Modal Configurar Metodo -->
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
                            <button type="submit" class="btn btn-primary" style="background: linear-gradient(135deg, #cc1d1d 0%, #8b1515 100%); border: none;">
                                <i class="fas fa-paper-plane me-2"></i>Enviar Codigo
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require_once 'components/scripts.php'; ?>

    <script src="assets/js/animacionesJs/dashboard_seguridad.js"></script>
    <?php require_once 'components/footer.php'; ?>
</body>
</html>
