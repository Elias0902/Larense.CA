function ObtenerCliente(id) {
    fetch('index.php?url=clientes&action=obtener&ID=' + id)
        .then(response => response.json())
        .then(data => {

            console.log(data);

            // llena los campos del formulario con los datos obtenidos
            document.getElementById('tipo_idEdit').value = data.tipo_id || '';
            document.getElementById('rifClienteEdit').value = data.id_cliente || '';
            document.getElementById('nombreClienteEdit').value = data.nombre_cliente || '';
            document.getElementById('tipoClienteEdit').value = data.id_tipo_cliente || '';
            document.getElementById('direccionClienteEdit').value = data.direccion_cliente || '';
            document.getElementById('tlfClienteEdit').value = data.tlf_cliente || '';
            document.getElementById('emailClienteEdit').value = data.email_cliente || '';            
            document.getElementById('estadoClienteEdit').value = data.estado_cliente || '';
            document.getElementById('imgPreviewEdit').src = data.img_cliente || '';
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo cargar el cliente.',
            });
        });
}