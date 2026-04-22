function ObtenerProduccion(id) {
    fetch('index.php?url=producciones&action=obtener&ID=' + id)
        .then(response => response.json())
        .then(data => {

            console.log(data);

            // llena los campos del formulario con los datos obtenidos
            document.getElementById('idEdit').value = data.id_produccion || '';
            document.getElementById('productoProduccionEdit').value = data.id_producto || '';
            document.getElementById('cantidadProduccionEdit').value = data.cantidad_producida || '';
            
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
