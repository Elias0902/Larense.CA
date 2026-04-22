function initClienteStatus() {
    // Selector para celdas de estado
    const statusCells = document.querySelectorAll('td[id="status"]');
    
    statusCells.forEach(cell => {
        const statusText = cell.textContent.trim();
        
        // Configuración de colores por estado
        let bgColor, dotColor, shadowColor, textColor;
        
        switch(statusText) {
            case 'Activo':
                bgColor = 'linear-gradient(45deg, #008719, #28a745)';
                dotColor = '#00cc44';
                shadowColor = '#0BDA51';
                textColor = 'white';
                break;
            case 'Pendiente':
                bgColor = 'linear-gradient(45deg, #ae7d00, #ffc107)';
                dotColor = '#ff8800';
                shadowColor = '#ffaa00';
                textColor = 'white';
                break;
            case 'Anulado':
                bgColor = 'linear-gradient(45deg, #dc3545, #ff0000)';
                dotColor = '#ff0000';
                shadowColor = '#ff4444';
                textColor = 'white';
                break;
            default:
                bgColor = 'linear-gradient(45deg, #6c757d, #6c757d)';
                dotColor = '#6c757d';
                shadowColor = '#adb5bd';
                textColor = 'white';
        }
        
        // ✅ Crea el badge completo
        cell.innerHTML = `
            <div class="status-badge" 
                 data-status="${statusText}"
                 style="
                    padding: 0.5rem;
                    border-radius: 20px;
                    font-weight: 500;
                    display: inline-flex;
                    align-items: center;
                    gap: 0.5rem;
                    background: ${bgColor};
                    color: ${textColor};
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    border: 1px solid rgba(255,255,255,0.2);
                    margin: 0;
                    font-size: 14px;
                    cursor: pointer;
                 "
            >
                <span style="font-size: 16px; font-weight: bold;">${statusText}</span>
                <div class="status-dot" 
                     style="

                     "></div>
            </div>
        `;
    });
}

// ✅ CSS CORREGIDO - Animación universal para todos los dots
function addStatusStyles() {
    const style = document.createElement('style');
    style.textContent = `
        @keyframes pulse {
            0% { 
                box-shadow: 0 0 0 0 rgba(255,255,255,0.7); 
                transform: scale(1);
            }
            70% { 
                box-shadow: 0 0 0 12px rgba(255,255,255,0); 
                transform: scale(1.1);
            }
            100% { 
                box-shadow: 0 0 0 0 rgba(255,255,255,0); 
                transform: scale(1);
            }
        }
        @media (max-width: 768px) {
            .status-badge {
                padding: 0.4rem 0.8rem !important;
                font-size: 13px !important;
            }
        }
    `;
    document.head.appendChild(style);
}

// Inicializar TODO
document.addEventListener('DOMContentLoaded', function() {
    addStatusStyles();  // ✅ CSS primero
    initClienteStatus(); // ✅ Luego badges
});