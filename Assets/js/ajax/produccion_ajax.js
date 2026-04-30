function ObtenerProduccion(id) {
    fetch('index.php?url=producciones&action=obtener&ID=' + id)
        .then(response => response.json())
        .then(data => {

            console.log(data);

            // llena los campos del formulario con los datos obtenidos
            document.getElementById('idEdit').value = data.id_produccion || '';
            document.getElementById('motivoProduccionEdit').value = data.motivo_produccion || '';
            document.getElementById('productoProduccionEdit').value = data.id_producto || '';
            document.getElementById('cantidadProductoEdit').value = data.cantidad_producida || '';
            document.getElementById('materiaPrimaEdit').value = data.id_materia_prima || '';
            document.getElementById('cantidadProduccionEdit').value = data.cantidad_utilizada || '';
            document.getElementById('observacionProduccionEdit').value = data.observacion || '';
            document.getElementById('fechaProduccionEdit').value = data.fecha_produccion || '';
            
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo cargar la producción.',
            });
        });
}
