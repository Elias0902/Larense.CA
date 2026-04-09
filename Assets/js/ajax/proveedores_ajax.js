function ObtenerProveedor(id) {
    fetch('index.php?url=proveedores&action=obtener&ID=' + id)
        .then(response => response.json())
        .then(data => {

            //console.log(data);

            // llena los campos del formulario con los datos obtenidos
            document.getElementById('id_proveedorEdit').value = data.id_proveedor || '';
            document.getElementById('tipo_idEdit').value = data.tipo_id || '';
            document.getElementById('nombreProveedorEdit').value = data.nombre_proveedor || '';
            document.getElementById('direccionProveedorEdit').value = data.direccion_proveedor || '';
            document.getElementById('tlfProveedorEdit').value = data.tlf_proveedor || '';
            document.getElementById('emailProveedorEdit').value = data.email_proveedor || '';            
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo cargar el proveedor.',
            });
        });
}