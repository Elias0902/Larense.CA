
// Asignar evento al botón
document.getElementById('btnExportarPDF').addEventListener('click', exportarPDF);

// funcion ajax para ver los graficos estadsticos
function VerReporteGraficoMateriaPrimas(){

    // llama a la funciones ajax
    materiaPrimaStock();
    consumoMateriaPrimaProduccion();
    costoMateriaPrimaPorProduccion();
}


    function Crear() {
        fetch('index.php?url=reportesETD&action=etd&tipo=categorias&orden=productos')
            .then(response => response.json())
            .then(data => {
                console.log(data); // Para verificar que llega bien

                // 1. Extraer los nombres y totales del array
                const labels = data.map(item => item.Nombre);
                const valores = data.map(item => item.TotalProductos);

                // 2. Obtener el contexto del canvas
                const ctx = document.getElementById('barChart').getContext('2d');

                // 3. Destruir el gráfico anterior si existe (para evitar duplicados)
                if (window.barChartInstance) {
                    window.barChartInstance.destroy();
                }

                // 4. Crear el gráfico de barras
                window.barChartInstance = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,          // ['Galletas', 'Postres', 'Reposteria']
                        datasets: [{
                            label: 'Total Productos',
                            data: valores,        // [7, 1, 0]
                            backgroundColor: '#36A2EB',
                            borderColor: '#1E88E5',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,   // Empieza desde 0
                                title: { display: true, text: 'Cantidad de productos' }
                            },
                            x: {
                                title: { display: true, text: 'Categorías' }
                            }
                        },
                        plugins: {
                            legend: { position: 'top' },
                            tooltip: { callbacks: {
                                label: (context) => `${context.dataset.label}: ${context.raw} productos`
                            }}
                        }
                    }
                });
            })
            .catch(error => {
                console.error('Error al cargar los datos:', error);
                // Opcional: mostrar un mensaje en el canvas
                document.getElementById('barChart').insertAdjacentHTML('afterend', 
                    '<p style="color:red">Error al cargar los datos del reporte.</p>');
            });
    }

// funcion asincrona para exportar reporte estadisico en pdf
async function exportarPDF() {

    // Mostrar un mensaje de carga (opcional)
    const btn = document.getElementById('btnExportarPDF');
    const textoOriginal = btn.innerText;
    btn.innerText = 'Generando PDF...';
    btn.disabled = true;

    // Capturar el elemento que quieres exportar
    const elemento = document.getElementById('reporte-container');

    // Configuración para html2canvas
    const canvas = await html2canvas(elemento, {
        scale: 2,              // Mayor calidad (2 = doble resolución)
        backgroundColor: '#ffffff',
        logging: false,
        useCORS: true          // Si usas imágenes externas
    });

    // Convertir canvas a imagen
    const imgData = canvas.toDataURL('image/png', 1.0);

    // Crear PDF en orientación vertical (p) y tamaño A4
    const { jsPDF } = window.jspdf;
    const pdf = new jsPDF('p', 'mm', 'a4');

    // Dimensiones de la página A4 (210mm x 297mm)
    const pdfWidth = 210;
    const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
    let position = 0;
    let heightLeft = pdfHeight;

    // Agregar imagen (ajustando el ancho al 100%)
    pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
    heightLeft -= pdfHeight;

    // Si el contenido es más largo que una página, agregar más páginas
    while (heightLeft > 0) {
        position = heightLeft - pdfHeight;
        pdf.addPage();
        pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
        heightLeft -= pdfHeight;
    }

    // Guardar el archivo
    pdf.save('reporte_estadistico.pdf');

    // Restaurar botón
    btn.innerText = textoOriginal;
    btn.disabled = false;
}