<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <title>403 - Zona Restringida | Acceso Denegado</title>
  <?php require_once 'components/links.php'; ?>
  <style>
    /* ----- FUENTE Y RESET ----- */
    @import url("https://fonts.googleapis.com/css2?family=Comic+Neue:wght@300;400;700;800&display=swap");

    * { margin: 0; padding: 0; box-sizing: border-box; cursor: default; }

    body {
      background: linear-gradient(145deg, #1a1a2e 0%, #16213e 100%);
      font-family: "Comic Neue", cursive;
      overflow-x: hidden;
      min-height: 100vh;
      color: #fff;
    }

    /* ----- WRAPPER PRINCIPAL ----- */
    .wrapper {
      min-width: 100vw;
      min-height: 100vh;
      display: flex;
      flex-wrap: wrap;
      text-align: center;
      align-items: center;
      background: radial-gradient(circle at 20% 40%, #1b262c, #0f4c75);
      position: relative;
      overflow: hidden;
    }

    /* ----- TEXTO 403 (Advertencia) ----- */
    .text_group {
      text-align: center;
      z-index: 10;
      backdrop-filter: blur(2px);
      transition: transform 0.2s;
    }
    .text_403 {
      font-family: "Comic Neue", cursive;
      font-size: 10em;
      font-weight: 800;
      background: linear-gradient(135deg, #e94560, #a21232);
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
      text-shadow: 0px 0px 20px rgba(233, 69, 96, 0.4);
      letter-spacing: 8px;
    }
    .text_restricted {
      font-family: "Comic Neue", cursive;
      font-size: 2em;
      font-weight: 500;
      line-height: 1.4;
      color: #f1f1f1;
      background: rgba(233, 69, 96, 0.15);
      display: inline-block;
      padding: 0.5rem 1.5rem;
      border-radius: 60px;
      backdrop-filter: blur(4px);
      border: 1px solid rgba(233, 69, 96, 0.3);
    }
    .space-tag {
      font-size: 1.1rem;
      margin-top: 20px;
      color: #94a3b8;
      font-weight: 400;
      letter-spacing: 1px;
    }

    /* ----- BOTÓN DE RETORNO (Rojizo/Seguridad) ----- */
    .btn-return {
      display: inline-block;
      margin-top: 30px;
      padding: 12px 32px;
      background: linear-gradient(135deg, #e94560 0%, #a21232 100%);
      color: #fff;
      font-family: "Comic Neue", cursive;
      font-size: 1.1rem;
      font-weight: 600;
      text-decoration: none;
      border-radius: 50px;
      border: none;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(233, 69, 96, 0.3);
      transition: all 0.3s ease;
    }
    .btn-return:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(233, 69, 96, 0.5);
      background: linear-gradient(135deg, #ff4d6d 0%, #c9184a 100%);
    }

    /* ----- VENTANA ESPACIAL ----- */
    .window_group { display: flex; justify-content: center; align-items: center; z-index: 8; }
    .window_403 {
      width: 380px;
      height: 480px;
      border-radius: 180px 180px 160px 160px;
      box-shadow: -12px -12px 0px 8px rgba(30, 41, 59, 0.5),
                  14px 14px 0px 6px rgba(233, 69, 96, 0.1),
                  inset 0px 0px 35px rgba(0,0,0,0.6);
      background: radial-gradient(circle at 30% 20%, #02021a, #000000);
      position: relative;
      overflow: hidden;
      cursor: crosshair;
    }

    .stars { position: absolute; width: 200%; height: 100%; animation: flyby 35s linear infinite; z-index: 1; }
    .star { position: absolute; border-radius: 50%; background: #ffffff; }

    /* ----- ASTRONAUTA "CENTINELA" ----- */
    .giant-astronaut {
      position: absolute;
      width: 150px;
      height: 150px;
      z-index: 30;
      pointer-events: none;
      filter: drop-shadow(0 15px 25px rgba(0, 0, 0, 0.6));
      transition: all 0.08s linear;
    }
    
    .astro-svg { width: 100%; height: 100%; animation: gentleBob 2.2s infinite ease-in-out; }
    
    @keyframes gentleBob {
      0% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-4px) rotate(3deg); }
      100% { transform: translateY(0px) rotate(0deg); }
    }

    @keyframes flyby { 0% { left: 0%; } 100% { left: -100%; } }

    /* ----- RESPONSIVE ----- */
    @media only screen and (min-width: 1080px) {
      .wrapper { justify-content: flex-start; padding: 0 6%; }
      .text_group { flex: 0 0 40%; margin-left: 5%; text-align: left; }
      .window_403 { width: 400px; height: 500px; }
    }

    @media only screen and (max-width: 1079px) {
      .wrapper { flex-direction: column; gap: 2rem; padding: 2rem 1rem; }
      .text_403 { font-size: 5.5rem; }
    }
  </style>
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

<script>
  // El mismo script de animación del astronauta y estrellas que proporcionaste
  // Funciona perfectamente para el efecto de persecución.
  (function() {
    const starsContainer = document.getElementById('starsContainer');
    const starCount = 100;
    for (let i = 0; i < starCount; i++) {
      const star = document.createElement('div');
      star.classList.add('star');
      const size = Math.random() * 3;
      star.style.width = `${size}px`;
      star.style.height = `${size}px`;
      star.style.left = `${Math.random() * 100}%`;
      star.style.top = `${Math.random() * 100}%`;
      star.style.opacity = Math.random();
      starsContainer.appendChild(star);
    }

    const astronaut = document.getElementById('astroChaser');
    const windowElement = document.getElementById('spaceWindow');
    let targetX = 50, targetY = 50, curX = 50, curY = 50;

    windowElement.addEventListener('mousemove', (e) => {
      const rect = windowElement.getBoundingClientRect();
      targetX = ((e.clientX - rect.left) / rect.width) * 100;
      targetY = ((e.clientY - rect.top) / rect.height) * 100;
    });

    function animate() {
      curX += (targetX - curX) * 0.1;
      curY += (targetY - curY) * 0.1;
      // Límites básicos para que no se salga
      const boundedX = Math.max(10, Math.min(75, curX));
      const boundedY = Math.max(10, Math.min(75, curY));
      astronaut.style.left = `${boundedX}%`;
      astronaut.style.top = `${boundedY}%`;
      requestAnimationFrame(animate);
    }
    animate();
  })();
</script>
</body>
</html>