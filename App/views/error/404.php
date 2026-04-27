<?php
// Iniciar sesión si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Determinar redirección según el rol del usuario
$redireccion = 'index.php?url=dashboard'; // Por defecto para empresa

if (isset($_SESSION['s_usuario']['id_rol_usuario'])) {
    // Si es cliente o rol sin acceso a dashboard, redirigir a ecommerce
    require_once 'app/models/PerfilSistemaModel.php';
    $perfilModel = new PerfilSistema();
    $tiene_permiso_dashboard = $perfilModel->VerificarPermiso($_SESSION['s_usuario']['id_rol_usuario'], 20, 2);

    if (!$tiene_permiso_dashboard) {
        $redireccion = 'index.php?url=ecommerce';
    }
} else {
    // Si no está logueado, redirigir a login
    $redireccion = 'index.php?url=autenticator';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <title>404 - Lost in Space | Astronauta Persigue al Mouse</title>
  <link rel="stylesheet" href="assets/css/style404.css">
      <?php
    require_once 'components/links.php';
    ?>
</head>
<body>

<div class="wrapper">
  <div class="text_group">
    <p class="text_404">404</p>
    <p class="text_lost">No me estan pagando por eso no hice esta pagina</p>
    <div class="space-tag">No existe la pagina, pero puedes jugar con el astronauta baila</div>
    <a href="<?php echo $redireccion; ?>" class="btn-return">Volver</a>
  </div>
  <div class="window_group">
    <div class="window_404" id="spaceWindow">
      <!-- Estrellas generadas dinámicamente -->
      <div class="stars" id="starsContainer"></div>
      <!-- Planeta decorativo -->
      <div class="distant-planet"></div>

      <!-- ASTRONAUTA GIGANTE QUE PERSIGUE EL CURSOR -->
      <div class="giant-astronaut" id="astroChaser">
        <svg class="astro-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
          <!-- Casco espacial con brillo -->
          <circle cx="50" cy="40" r="23" fill="#EAF4FF" stroke="#7BA0C5" stroke-width="2.5" />
          <!-- Visor reflectante estilo espejo -->
          <ellipse cx="50" cy="40" rx="15" ry="13" fill="#0F212F" stroke="#FFD966" stroke-width="2.2" />
          <circle cx="44" cy="36" r="3" fill="#FFFFFF" opacity="0.9" />
          <circle cx="57" cy="37" r="2.2" fill="#FFFFFF" opacity="0.7" />
          <!-- Traje espacial mejorado (azul profundo) -->
          <rect x="36" y="58" width="28" height="28" rx="12" fill="#1F6390" stroke="#144A6B" stroke-width="2" />
          <rect x="36" y="70" width="28" height="6" fill="#FFB347" rx="3" />
          <!-- Brazos con movimiento -->
          <path d="M30 60 L18 72 L20 78 L28 72 L36 66" fill="#1F6390" stroke="#144A6B" stroke-width="2" stroke-linejoin="round" />
          <path d="M70 60 L82 72 L80 78 L72 72 L64 66" fill="#1F6390" stroke="#144A6B" stroke-width="2" stroke-linejoin="round" />
          <!-- Manoplas grandes -->
          <circle cx="18" cy="78" r="6.5" fill="#D9E6F5" stroke="#6E8FB2" stroke-width="1.8" />
          <circle cx="82" cy="78" r="6.5" fill="#D9E6F5" stroke="#6E8FB2" stroke-width="1.8" />
          <!-- Piernas espaciales -->
          <rect x="38" y="84" width="11" height="14" rx="5" fill="#195A7C" />
          <rect x="51" y="84" width="11" height="14" rx="5" fill="#195A7C" />
          <ellipse cx="43" cy="98" rx="8" ry="5" fill="#C28B3B" />
          <ellipse cx="57" cy="98" rx="8" ry="5" fill="#C28B3B" />
          <!-- Mochila propulsora con detalle -->
          <rect x="43" y="48" width="14" height="17" rx="6" fill="#4882A7" stroke="#235B7C" stroke-width="1.8" />
          <circle cx="50" cy="56" r="2.5" fill="#FFE484" />
          <!-- Antena graciosa con luz roja -->
          <line x1="50" y1="19" x2="50" y2="6" stroke="#AFC7E5" stroke-width="2.5" stroke-linecap="round" />
          <circle cx="50" cy="4" r="4" fill="#FF5E5E" />
          <circle cx="50" cy="4" r="2" fill="#FFAAAA" />
        </svg>
      </div>

      <!-- capas reflectantes -->
      <div class="window-reflection"></div>
      <div class="inner-ring"></div>
    </div>
  </div>
</div>

<script src="assets/js/animacionesJs/404.js"></script>
</body>
</html>