let tasaDolar = 0;
let convertida = false;  // Estado toggle: true=convertida, false=original

function ObtenerUltimaTasa() {
    fetch('index.php?url=tasa&action=obtenerUltima')
        .then(response => response.json())
        .then(data => {
            if (data.status) {
                tasaDolar = parseFloat(data.monto_tasa);  // FIX: data.data.monto_tasa
                console.log('Tasa:', tasaDolar);
            }
        })
        .catch(error => console.error('Error:', error));
}

function toggleConversion() {
    convertida = !convertida;  // Cambia estado
    
    const celdasPrecio = document.querySelectorAll('.conversion');
    
    celdasPrecio.forEach(celda => {
        let precioTexto = celda.textContent.trim();
        let precioOriginal = parseFloat(precioTexto.replace(/[^\d.]/g, ''));
        
        if (!isNaN(precioOriginal) && tasaDolar > 0) {
            if (convertida) {
                // → CONVERTIDO ($ a BS)
                let precioDolar = (precioOriginal * tasaDolar).toFixed(2);
                celda.innerHTML = `<span>BS${precioDolar}</span>`;
            } else {
                // → ORIGINAL ($)
                let precio = (precioOriginal / tasaDolar).toFixed(2);
                celda.innerHTML = `<span>$${precio}</span>`;
            }
        }
    });
    
    // Cambia texto del botón
    const boton = event.target;
    if (convertida) {
        boton.innerHTML = '<i class="fas fa-dollar-sign"></i> BS → $ (ON)';
        boton.style.background = 'linear-gradient(135deg, #ffc107 0%, #e0a800 100%)';
    } else {
        boton.innerHTML = '<i class="fas fa-bolt"></i> $ → BS (OFF)';
        boton.style.background = 'linear-gradient(135deg, #dc3545 0%, #c82333 100%)';
    }
}

// Carga tasa al iniciar
ObtenerUltimaTasa();