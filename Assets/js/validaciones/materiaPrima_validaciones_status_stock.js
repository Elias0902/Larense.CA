function initStockStatus() {
    const stockCells = document.querySelectorAll('td[id="stock"]');
    
    stockCells.forEach(cell => {
        const stockText = cell.textContent.trim();
        const stockMatch = stockText.match(/(\d+)/);
        
        if (stockMatch) {
            const stock = parseInt(stockMatch[0]);
            
            // Configuración de colores por rango
            let bgColor, dotColor, textColor, shadowColor;
            
            if (stock >= 60) {
                // Verde (Alto)
                bgColor = 'linear-gradient(45deg, #008719, #008719)';
                dotColor = '#00cc44';
                shadowColor = '#0BDA51';
                textColor = 'white';
            } else if (stock >= 30) {
                // Amarillo (Medio)
                bgColor = 'linear-gradient(45deg, #ae7d00, #ae7d00)';
                dotColor = '#ff8800';
                shadowColor = '#ffaa00';
                textColor = 'white';
            } else {
                // Rojo (Bajo)
                bgColor = 'linear-gradient(45deg, #ff0000, #ff0000)';
                dotColor = '#ff0000';
                shadowColor = '#ff4444';
                textColor = 'white';
            }
            
            // Crea el badge completo
            cell.innerHTML = `
                <div style="
                    padding: 0.5rem;
                    border-radius: 20px;
                    font-weight: 500;
                    display: inline-flex;
                    align-items: center;
                    gap: 0.5rem;
                    background: ${bgColor};
                    color: ${textColor};
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    cursor: pointer;
                    margin: 0;
                    font-size: 14px;
                "
                >
                    <span>${stock}</span> Cajas
                    <span style="
                        border-radius: 50%;
                        background: ${dotColor};
                        box-shadow: 0 0 10px ${shadowColor};
                    "></span>
                </div>
            `;
        }
    });
}
 
// Inicializar cuando carga la página
document.addEventListener('DOMContentLoaded', function() {
    initStockStatus();
});