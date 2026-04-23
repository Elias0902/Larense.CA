<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seguridad - Larense C.A</title>
    <?php require_once 'components/links.php'; ?>
    <link rel="stylesheet" href="assets/css/stylesModules/seguridad.css" />
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
