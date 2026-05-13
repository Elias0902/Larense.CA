function ObtenerCompra(id) {
    fetch('index.php?url=compras&action=obtener&ID=' + id)
        .then(response => response.json())
        .then(data => {
            console.log('Datos recibidos:', data);
            
            // Llenar campos básicos
            document.getElementById('idEdit').value = data.id_pedido || '';
            document.getElementById('proveedorIdEdit').value = data.id_proveedor || '';
            document.getElementById('fechaCompraEdit').value = data.fecha_compra ? data.fecha_compra.split(' ')[0] : '';
            document.getElementById('estadoCompraEdit').value = data.id_estado_pago || '';
            document.getElementById('observacionesCompraEdit').value = data.observacion || '';
            
            var modal = new bootstrap.Modal(document.getElementById('compraModalModificar'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo cargar la compra.' });
            var modal = new bootstrap.Modal(document.getElementById('compraModalModificar'));
            modal.show();
        });
}