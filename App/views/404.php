<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
  <title>404 - Lost in Space | Astronauta Persigue al Mouse</title>
      <?php
    require_once 'components/links.php';
    ?>
  <style>
    /* ----- FUENTE Y RESET ----- */
    @import url("https://fonts.googleapis.com/css2?family=Comic+Neue:wght@300;400;700;800&display=swap");

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      cursor: default;
    }

    body {
      background: linear-gradient(145deg, #d9e2ec 0%, #eef2f7 100%);
      font-family: "Comic Neue", cursive;
      overflow-x: hidden;
      min-height: 100vh;
    }

    /* ----- WRAPPER PRINCIPAL ----- */
    .wrapper {
      min-width: 100vw;
      min-height: 100vh;
      display: flex;
      flex-wrap: wrap;
      text-align: center;
      align-items: center;
      background: radial-gradient(circle at 20% 40%, #eef2f7, #dfe6ed);
      position: relative;
      overflow: hidden;
    }

    /* ----- TEXTO 404 (con brillo) ----- */
    .text_group {
      text-align: center;
      z-index: 10;
      backdrop-filter: blur(2px);
      transition: transform 0.2s;
    }
    .text_404 {
      font-family: "Comic Neue", cursive;
      font-size: 10em;
      font-weight: 800;
      background: linear-gradient(135deg, #1f2c38, #2a3f4e);
      background-clip: text;
      -webkit-background-clip: text;
      color: transparent;
      text-shadow: 4px 4px 12px rgba(0,0,0,0.1);
      letter-spacing: 8px;
    }
    .text_lost {
      font-family: "Comic Neue", cursive;
      font-size: 2em;
      font-weight: 500;
      line-height: 1.4;
      color: #2c4a5e;
      background: rgba(255,255,245,0.3);
      display: inline-block;
      padding: 0 1rem;
      border-radius: 60px;
      backdrop-filter: blur(4px);
    }
    .space-tag {
      font-size: 1rem;
      margin-top: 20px;
      color: #5f7f9e;
      font-weight: 400;
      letter-spacing: 1px;
    }

    /* ----- BOTÓN DE RETORNO ----- */
    .btn-return {
      display: inline-block;
      margin-top: 30px;
      padding: 12px 32px;
      background: linear-gradient(135deg, #1f6390 0%, #144a6b 100%);
      color: #fff;
      font-family: "Comic Neue", cursive;
      font-size: 1.1rem;
      font-weight: 600;
      text-decoration: none;
      border-radius: 50px;
      border: none;
      cursor: pointer;
      box-shadow: 0 4px 15px rgba(31, 99, 144, 0.3);
      transition: all 0.3s ease;
    }
    .btn-return:hover {
      transform: translateY(-3px);
      box-shadow: 0 8px 25px rgba(31, 99, 144, 0.4);
      background: linear-gradient(135deg, #2372a3 0%, #1a5580 100%);
    }
    .btn-return:active {
      transform: translateY(-1px);
    }

    /* ----- VENTANA ESPACIAL (window con estrellas) ----- */
    .window_group {
      display: flex;
      justify-content: center;
      align-items: center;
      z-index: 8;
    }
    .window_404 {
      width: 380px;
      height: 480px;
      border-radius: 180px 180px 160px 160px;
      box-shadow: -12px -12px 0px 8px rgba(160, 170, 180, 0.5),
                  14px 14px 0px 6px rgba(255, 255, 245, 0.8),
                  inset 0px 0px 35px rgba(0,0,0,0.4);
      background: radial-gradient(circle at 30% 20%, #02021a, #000000);
      position: relative;
      overflow: hidden;
      transition: transform 0.2s ease;
      cursor: crosshair;
    }
    .window_404:hover {
      transform: scale(1.01);
    }

    /* ----- ESTRELLAS (campo estelar en movimiento) ----- */
    .stars {
      position: absolute;
      top: 0;
      left: 0;
      width: 200%;
      height: 100%;
      background: transparent;
      will-change: left;
      animation: flyby 35s linear infinite;
      pointer-events: none;
      z-index: 1;
    }
    .star {
      position: absolute;
      border-radius: 50%;
      background: #ffffff;
      box-shadow: 0 0 6px rgba(255,245,180,0.9);
      will-change: transform, opacity;
    }
    .star::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(255, 250, 210, 0.95);
      filter: blur(1.2px);
      border-radius: inherit;
    }

    /* ----- PLANETA DISTANTE (decorativo) ----- */
    .distant-planet {
      position: absolute;
      top: 12%;
      right: 10%;
      width: 55px;
      height: 55px;
      background: radial-gradient(circle at 35% 35%, #f7e5b5, #c28b3b);
      border-radius: 50%;
      box-shadow: 0 0 20px rgba(255, 200, 80, 0.7);
      z-index: 5;
      opacity: 0.85;
      animation: planetFloat 6s infinite alternate;
      pointer-events: none;
    }
    @keyframes planetFloat {
      0% { transform: translateY(0px) scale(1); opacity: 0.7; }
      100% { transform: translateY(-10px) scale(1.05); opacity: 1; }
    }
    .distant-planet::after {
      content: "";
      position: absolute;
      top: -12px;
      left: -20px;
      width: 95px;
      height: 28px;
      border-radius: 50%;
      border: 2px solid rgba(255,210,90,0.5);
      transform: rotate(-25deg);
      pointer-events: none;
    }

    /* ----- ASTRONAUTA GIGANTE QUE PERSIGUE AL PUNTERO ----- */
    .giant-astronaut {
      position: absolute;
      width: 150px;
      height: 150px;
      z-index: 30;
      pointer-events: none;  /* para que no interfiera con el mouse, pero sigue la posición del cursor dentro de la ventana */
      filter: drop-shadow(0 15px 25px rgba(0, 0, 0, 0.6));
      transition: all 0.08s linear; /* movimiento ultra suave */
      will-change: left, top;
      transform-origin: center;
    }
    
    /* versión grande en desktop */
    .astro-svg {
      width: 100%;
      height: 100%;
      display: block;
      animation: gentleBob 2.2s infinite ease-in-out;
      filter: drop-shadow(0 0 6px rgba(255,215,0,0.4));
    }
    
    @keyframes gentleBob {
      0% { transform: translateY(0px) rotate(0deg); }
      50% { transform: translateY(-4px) rotate(3deg); }
      100% { transform: translateY(0px) rotate(0deg); }
    }
    
    /* reflejo de ventana */
    .window-reflection {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border-radius: inherit;
      pointer-events: none;
      background: radial-gradient(circle at 25% 30%, rgba(255,255,245,0.1) 0%, rgba(0,0,0,0.25) 90%);
      z-index: 15;
    }
    
    /* anillo sutil interior */
    .inner-ring {
      position: absolute;
      bottom: 6%;
      left: 6%;
      width: 88%;
      height: 88%;
      border-radius: 50%;
      border: 2px solid rgba(255,215,130,0.3);
      pointer-events: none;
      z-index: 14;
      animation: pulseRing 4s infinite alternate;
    }
    @keyframes pulseRing {
      0% { opacity: 0.2; transform: scale(0.96); border-color: rgba(255,215,150,0.2);}
      100% { opacity: 0.7; transform: scale(1.02); border-color: rgba(255,215,150,0.8);}
    }
    
    /* Animación del cielo estelar */
    @keyframes flyby {
      0% { left: 0%; }
      100% { left: -100%; }
    }

    /* ----- RESPONSIVE: ajustes para diferentes tamaños ----- */
    @media only screen and (min-width: 1080px) {
      .wrapper {
        justify-content: flex-start;
        padding: 0 6%;
      }
      .text_group {
        flex: 0 0 32%;
        margin-left: 8%;
        text-align: left;
      }
      .window_group {
        flex: 1 0 38%;
        margin-left: 6%;
      }
      .window_404 {
        width: 400px;
        height: 500px;
      }
      .giant-astronaut {
        width: 170px;
        height: 170px;
      }
    }
    @media only screen and (max-width: 1079px) {
      .wrapper {
        flex-direction: column;
        gap: 2rem;
        padding: 2rem 1rem;
      }
      .text_group {
        width: 100%;
        text-align: center;
      }
      .text_404 {
        font-size: 5.5rem;
      }
      .text_lost {
        font-size: 1.6rem;
      }
      .window_404 {
        width: 320px;
        height: 420px;
        margin: 0 auto;
      }
      .giant-astronaut {
        width: 130px;
        height: 130px;
      }
    }
    @media only screen and (max-width: 480px) {
      .text_404 {
        font-size: 3.8rem;
      }
      .text_lost {
        font-size: 1.3rem;
      }
      .window_404 {
        width: 280px;
        height: 370px;
      }
      .giant-astronaut {
        width: 110px;
        height: 110px;
      }
    }
    
    /* Reducción de movimiento si el usuario lo prefiere */
    @media (prefers-reduced-motion: reduce) {
      .stars, .giant-astronaut, .distant-planet, .astro-svg {
        animation: none !important;
        transition: none !important;
      }
      .giant-astronaut {
        left: 30% !important;
        top: 40% !important;
      }
    }
    
    /* efecto de brillo extra al perseguir */
    @keyframes chaseGlow {
      0% { filter: drop-shadow(0 0 5px #ffcc66); }
      100% { filter: drop-shadow(0 0 18px #ffaa33); }
    }
    .chasing-effect {
      animation: chaseGlow 0.3s infinite alternate;
    }
  </style>
</head>
<body>

<div class="wrapper">
  <div class="text_group">
    <p class="text_404">404</p>
    <p class="text_lost">No me estan pagando por eso no hice esta pagina</p>
    <div class="space-tag">No existe la pagina, pero puedes jugar con el astronauta baila</div>
    <a href="?url=dashboard" class="btn-return">Volver al Dashboard</a>
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

<script>
  (function() {
    // ---------- 1. GENERACIÓN DE 100 ESTRELLAS CON PARPADEO ÚNICO ----------
    const starsContainer = document.getElementById('starsContainer');
    if (!starsContainer) return;
    starsContainer.innerHTML = '';
    
    function randomRange(min, max) {
      return Math.floor(Math.random() * (max - min + 1)) + min;
    }
    
    const starCount = 100;
    const styleSheet = document.createElement('style');
    document.head.appendChild(styleSheet);
    let keyframesCSS = '';
    const starsFragment = document.createDocumentFragment();
    
    for (let i = 1; i <= starCount; i++) {
      const star = document.createElement('div');
      star.classList.add('star');
      const size = randomRange(1, 4);
      star.style.width = `${size}px`;
      star.style.height = `${size}px`;
      
      const leftPercent = randomRange(0, 100);
      star.style.left = `${leftPercent}%`;
      const topPercent = randomRange(0, 100);
      star.style.top = `${topPercent}%`;
      
      const animName = `twinkleStar${i}`;
      const duration = randomRange(4, 14);
      const delay = randomRange(0, 9000) / 1000;
      star.style.animation = `${animName} ${duration}s linear infinite`;
      star.style.animationDelay = `${delay}s`;
      
      const keyframeRule = `
        @keyframes ${animName} {
          0% { transform: scale(1, 1); opacity: 1; }
          12% { transform: scale(0.2, 0.2); opacity: 0.4; }
          24% { transform: scale(1, 1); opacity: 1; }
          35% { transform: scale(0.5, 0.5); opacity: 0.7; }
          50% { transform: scale(1, 1); opacity: 1; }
          68% { transform: scale(0.3, 0.3); opacity: 0.5; }
          85% { transform: scale(0.9, 0.9); opacity: 0.9; }
          100% { transform: scale(1, 1); opacity: 1; }
        }
      `;
      keyframesCSS += keyframeRule;
      starsFragment.appendChild(star);
    }
    starsContainer.appendChild(starsFragment);
    if (keyframesCSS) styleSheet.textContent = keyframesCSS;
    
    // ---------- 2. ASTRONAUTA GIGANTE QUE PERSIGUE EL MOUSE DENTRO DE LA VENTANA ----------
    const astronaut = document.getElementById('astroChaser');
    const windowElement = document.getElementById('spaceWindow');
    
    if (!astronaut || !windowElement) return;
    
    // Configuración de persecución
    let targetX = 30;   // porcentaje objetivo X
    let targetY = 40;   // porcentaje objetivo Y
    let currentLeftPercent = 30;
    let currentTopPercent = 40;
    
    // factores de suavizado (persecución estilo "follow" con retardo)
    let followSpeed = 0.18;   // suavizado, más bajo = más lento, más alto = más rápido (0.12 - 0.28)
    
    // límites para evitar que el astronauta se salga de la ventana (con márgenes)
    let minLeft = 5;
    let maxLeft = 75;
    let minTop = 5;
    let maxTop = 75;
    
    // Función para actualizar límites según el tamaño actual de la ventana y del astronauta
    function updateBounds() {
      if (!windowElement || !astronaut) return;
      const parentRect = windowElement.getBoundingClientRect();
      const astroWidth = astronaut.offsetWidth;
      const astroHeight = astronaut.offsetHeight;
      if (parentRect.width > 0) {
        const maxLeftPx = parentRect.width - astroWidth - 10;
        const minLeftPx = 10;
        maxLeft = (maxLeftPx / parentRect.width) * 100;
        minLeft = (minLeftPx / parentRect.width) * 100;
        
        const maxTopPx = parentRect.height - astroHeight - 10;
        const minTopPx = 10;
        maxTop = (maxTopPx / parentRect.height) * 100;
        minTop = (minTopPx / parentRect.height) * 100;
      }
      // valores seguros
      minLeft = Math.max(2, Math.min(minLeft, 25));
      maxLeft = Math.min(85, Math.max(maxLeft, 55));
      minTop = Math.max(2, Math.min(minTop, 20));
      maxTop = Math.min(82, Math.max(maxTop, 70));
    }
    
    // Establecer posición inicial centrada pero algo offset
    function initPosition() {
      updateBounds();
      currentLeftPercent = (minLeft + maxLeft) / 2;
      currentTopPercent = (minTop + maxTop) / 2;
      targetX = currentLeftPercent;
      targetY = currentTopPercent;
      applyPosition();
    }
    
    function applyPosition() {
      if (astronaut) {
        astronaut.style.left = `${currentLeftPercent}%`;
        astronaut.style.top = `${currentTopPercent}%`;
      }
    }
    
    // Convertir coordenadas del mouse (dentro de windowElement) a porcentajes relativos
    function getMousePositionInPercent(e) {
      const rect = windowElement.getBoundingClientRect();
      // obtener coordenadas relativas al elemento
      let mouseX = e.clientX - rect.left;
      let mouseY = e.clientY - rect.top;
      // calcular porcentaje respecto al ancho/alto del contenedor
      let percentX = (mouseX / rect.width) * 100;
      let percentY = (mouseY / rect.height) * 100;
      // restringir a los límites para que el astronauta no se escape de la ventana
      percentX = Math.min(maxLeft, Math.max(minLeft, percentX));
      percentY = Math.min(maxTop, Math.max(minTop, percentY));
      return { x: percentX, y: percentY };
    }
    
    // Evento de movimiento del mouse DENTRO de la ventana espacial
    let lastMouseMove = 0;
    windowElement.addEventListener('mousemove', (e) => {
      // actualizar el objetivo de persecución
      const { x, y } = getMousePositionInPercent(e);
      targetX = x;
      targetY = y;
      
      // efecto visual: añadir brillo mientras persigue (activa clase temporal)
      if (astronaut && !astronaut.classList.contains('chasing-effect')) {
        astronaut.classList.add('chasing-effect');
        setTimeout(() => {
          if (astronaut) astronaut.classList.remove('chasing-effect');
        }, 400);
      }
      lastMouseMove = Date.now();
    });
    
    // Si el mouse sale de la ventana, el astronauta se relaja y se mueve lentamente al centro
    windowElement.addEventListener('mouseleave', () => {
      // restaurar objetivo hacia el centro de la ventana, pero de forma gradual
      const centerX = (minLeft + maxLeft) / 2;
      const centerY = (minTop + maxTop) / 2;
      targetX = centerX;
      targetY = centerY;
    });
    
    // bucle de animación para seguir al puntero con suavizado
    let animationFrameId = null;
    
    function followCursorAnimation() {
      // Interpolación lineal hacia el objetivo
      let dx = targetX - currentLeftPercent;
      let dy = targetY - currentTopPercent;
      
      // actualizar posición actual suavemente
      currentLeftPercent += dx * followSpeed;
      currentTopPercent += dy * followSpeed;
      
      // asegurar límites
      currentLeftPercent = Math.min(maxLeft, Math.max(minLeft, currentLeftPercent));
      currentTopPercent = Math.min(maxTop, Math.max(minTop, currentTopPercent));
      
      // aplicar posición al astronauta
      applyPosition();
      
      // pequeña rotación dinámica según la dirección de movimiento (efecto divertido)
      if (astronaut) {
        const angle = Math.atan2(dy, dx) * (180 / Math.PI);
        // limitar rotación máxima a 12 grados para que no se vea demasiado loco
        let limitedAngle = Math.min(15, Math.max(-15, angle * 0.5));
        // aplicar rotación suave al svg interno (o al contenedor)
        const svgElement = astronaut.querySelector('.astro-svg');
        if (svgElement) {
          svgElement.style.transform = `rotate(${limitedAngle}deg)`;
        }
      }
      
      animationFrameId = requestAnimationFrame(followCursorAnimation);
    }
    
    // Ajustar límites al redimensionar
    let resizeTimeout;
    window.addEventListener('resize', () => {
      if (resizeTimeout) clearTimeout(resizeTimeout);
      resizeTimeout = setTimeout(() => {
        updateBounds();
        // ajustar el objetivo y la posición actual para que no quede fuera
        currentLeftPercent = Math.min(maxLeft, Math.max(minLeft, currentLeftPercent));
        currentTopPercent = Math.min(maxTop, Math.max(minTop, currentTopPercent));
        targetX = Math.min(maxLeft, Math.max(minLeft, targetX));
        targetY = Math.min(maxTop, Math.max(minTop, targetY));
        applyPosition();
      }, 150);
    });
    
    // Inicializar todo
    updateBounds();
    initPosition();
    
    // Ajuste adicional: velocidad de persecución un poco más rápida para dar sensación de "persecución ágil"
    followSpeed = 0.22;   // respuesta rápida pero suave
    
    // Iniciar el bucle de seguimiento
    followCursorAnimation();
    
    // Efecto adicional: pequeñas chispas cuando el astronauta se mueve rápido (diversión)
    let lastX = currentLeftPercent, lastY = currentTopPercent;
    setInterval(() => {
      if (!astronaut || !windowElement) return;
      const speed = Math.hypot(currentLeftPercent - lastX, currentTopPercent - lastY);
      if (speed > 1.5) {
        // generar una pequeña estela de partículas
        const trail = document.createElement('div');
        trail.style.position = 'absolute';
        trail.style.width = '7px';
        trail.style.height = '7px';
        trail.style.background = 'radial-gradient(circle, #ffdd88, #ffaa44)';
        trail.style.borderRadius = '50%';
        trail.style.pointerEvents = 'none';
        trail.style.zIndex = '28';
        trail.style.filter = 'blur(1.5px)';
        const rectAstro = astronaut.getBoundingClientRect();
        const parentRect = windowElement.getBoundingClientRect();
        const relativeLeft = ((rectAstro.left - parentRect.left) / parentRect.width) * 100;
        const relativeTop = ((rectAstro.top - parentRect.top) / parentRect.height) * 100;
        trail.style.left = `${relativeLeft + (Math.random() * 8 - 4)}%`;
        trail.style.top = `${relativeTop + 20}%`;
        windowElement.appendChild(trail);
        trail.style.animation = 'fadeTrailFast 0.5s ease-out forwards';
        setTimeout(() => trail.remove(), 500);
      }
      lastX = currentLeftPercent;
      lastY = currentTopPercent;
    }, 300);
    
    const trailKeyframes = document.createElement('style');
    trailKeyframes.textContent = `
      @keyframes fadeTrailFast {
        0% { opacity: 0.9; transform: scale(1); background: #ffdd99; }
        100% { opacity: 0; transform: scale(2.2) translate(8px, -12px); background: #ffaa44; }
      }
    `;
    document.head.appendChild(trailKeyframes);
    
    // Agregar interacción extra: Si haces clic en la ventana, el astronauta se sobresalta (salta)
    windowElement.addEventListener('click', (e) => {
      if (astronaut) {
        astronaut.style.transform = 'scale(1.08)';
        setTimeout(() => {
          if (astronaut) astronaut.style.transform = '';
        }, 200);
        // también un pequeño brillo intenso
        const glowDiv = document.createElement('div');
        glowDiv.style.position = 'absolute';
        glowDiv.style.width = '100%';
        glowDiv.style.height = '100%';
        glowDiv.style.background = 'radial-gradient(circle, rgba(255,220,100,0.3), transparent)';
        glowDiv.style.pointerEvents = 'none';
        glowDiv.style.borderRadius = 'inherit';
        glowDiv.style.zIndex = '35';
        astronaut.appendChild(glowDiv);
        setTimeout(() => glowDiv.remove(), 300);
      }
    });
    
    console.log("🚀✨ ASTRONAUTA GIGANTE ACTIVADO: ¡Sigue al mouse dentro de la ventana espacial!");
  })();
</script>
</body>
</html>