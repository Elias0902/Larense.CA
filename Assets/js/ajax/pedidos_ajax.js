function ObtenerPedido(id) {
    fetch('index.php?url=pedidos&action=obtener&ID=' + id)
        .then(response => response.json())
        .then(data => {
            console.log('Datos recibidos:', data);
            
            inicializarModalModificar();
            
            // Llenar campos básicos
            document.getElementById('idEdit').value = data.id_pedido || '';
            document.getElementById('clienteIdEdit').value = data.id_cliente || '';
            document.getElementById('fechaPedidoEdit').value = data.fecha_pedido ? data.fecha_pedido.split(' ')[0] : '';
            document.getElementById('estadoPedidoEdit').value = data.id_estado_pedido || '';
            document.getElementById('promocionIdEdit').value = data.id_promocion || '';
            document.getElementById('telefonoPedidoEdit').value = data.tlf_contacto || '';
            document.getElementById('direccionPedidoEdit').value = data.direccion_entrega || '';
            document.getElementById('observacionesPedidoEdit').value = data.observaciones || '';
            
            cargarDiasCreditoEdit();
            cargarPromocionesEdit();
            
            setTimeout(() => {
                if (typeof validar_cliente_modificado === 'function') validar_cliente_modificado();
                // ... resto de validaciones
            }, 500);
            
            var modal = new bootstrap.Modal(document.getElementById('pedidoModalModificar'));
            modal.show();
        })
        .catch(error => {
            console.error('Error:', error);
            inicializarModalModificar();
            Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo cargar el pedido.' });
            var modal = new bootstrap.Modal(document.getElementById('pedidoModalModificar'));
            modal.show();
        });
}