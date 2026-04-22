function ObtenerMateriaPrima(id) {
    fetch('index.php?url=materias_primas&action=obtener&ID=' + id)
        .then(response => response.json())
        .then(data => {

            console.log(data);

            // llena los campos del formulario con los datos obtenidos
            document.getElementById('idEdit').value = data.id_materia_prima || '';
            document.getElementById('nombreMateriaPrimaEdit').value = data.nombre_materia_prima || '';
            document.getElementById('descripcionMateriaPrimaEdit').value = data.descripcion_materia_prima || '';
            document.getElementById('stockMateriaPrimaEdit').value = data.stock_actual || '';
            document.getElementById('unidadMedidaEdit').value = data.id_unidad_medida || '';
            document.getElementById('proveedorMateriaPrimaEdit').value = data.id_proveedor || '';
            
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