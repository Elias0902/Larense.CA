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