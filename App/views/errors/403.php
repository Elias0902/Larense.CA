<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <title>403 - Zona Restringida | Acceso Denegado</title>
  <link rel="stylesheet" href="assets/css/style403.css">
  <?php require_once 'components/links.php'; ?>
</head>
<body>

<div class="wrapper">
  <div class="text_group">
    <p class="text_403">403</p>
    <p class="text_restricted">¡Alto ahí, viajero!</p>
    <div class="space-tag">Esta zona está reservada para personal autorizado. Tus credenciales no tienen permiso para orbitar aquí.</div>
    <a href="?url=dashboard" class="btn-return">Regresar a Base (Dashboard)</a>
  </div>
  <div class="window_group">
    <div class="window_403" id="spaceWindow">
      <div class="stars" id="starsContainer"></div>
      
      <div class="giant-astronaut" id="astroChaser">
        <svg class="astro-svg" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="50" cy="40" r="23" fill="#EAF4FF" stroke="#7BA0C5" stroke-width="2.5" />
          <ellipse cx="50" cy="40" rx="15" ry="13" fill="#0F212F" stroke="#E94560" stroke-width="2.2" />
          <rect x="36" y="58" width="28" height="28" rx="12" fill="#1A1A2E" stroke="#E94560" stroke-width="2" />
          <rect x="36" y="70" width="28" height="6" fill="#E94560" rx="3" />
          <path d="M30 60 L18 72 L20 78 L28 72 L36 66" fill="#1A1A2E" stroke="#E94560" stroke-width="2" />
          <path d="M70 60 L82 72 L80 78 L72 72 L64 66" fill="#1A1A2E" stroke="#E94560" stroke-width="2" />
          <line x1="50" y1="19" x2="50" y2="6" stroke="#E94560" stroke-width="2.5" />
          <circle cx="50" cy="4" r="4" fill="#FF0000" />
        </svg>
      </div>
    </div>
  </div>
</div>

<script src="assets/js/animacionesJs/403.js"></script>
</body>
</html>