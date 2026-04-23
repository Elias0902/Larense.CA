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