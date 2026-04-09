function ObtenerProducto(id) {
    fetch('index.php?url=productos&action=obtener&ID=' + id)
        .then(response => response.json())
        .then(data => {

            //console.log(data);

            // llena los campos del formulario con los datos obtenidos
            document.getElementById('idEdit').value = data.id_producto || '';
            document.getElementById('nombreProductoEdit').value = data.nombre_producto || '';
            document.getElementById('nombreCategoriaEdit').value = data.id_categoria || '';
            document.getElementById('precioProductoEdit').value = parseFloat(data.precio_venta) || '';
            document.getElementById('stockProductoEdit').value = parseInt(data.stock) || '';
            document.getElementById('fechaRegistroProductoEdit').value = data.fecha_registro || '';
            document.getElementById('fechaVencimientoProductoEdit').value = data.fecha_vencimiento || '';
            
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo cargar el producto.',
            });
        });
}