function ObtenerPedido(id) {
  fetch('index.php?url=pedidos&action=obtener&ID=' + id)
    .then(response => response.json())
    .then(data => {
      document.getElementById('id').value = data.id_pedido;
      document.getElementById('clienteIdEdit').value = data.cliente_id;
      document.getElementById('fechaPedidoEdit').value = data.fecha_pedido;
      document.getElementById('totalPedidoEdit').value = data.total;
      document.getElementById('estadoPedidoEdit').value = data.estado;
      document.getElementById('promocionIdEdit').value = data.promocion_id || '';
      document.getElementById('telefonoPedidoEdit').value = data.telefono_contacto || '';
      document.getElementById('direccionPedidoEdit').value = data.direccion_entrega || '';
      document.getElementById('observacionesPedidoEdit').value = data.observaciones || '';
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

function CambiarEstadoPedido(id, nuevoEstado) {
  const estadoTextos = {
    'pendiente': 'Pendiente',
    'procesando': 'Procesando',
    'enviado': 'Enviado',
    'entregado': 'Entregado',
    'cancelado': 'Cancelado'
  };

  Swal.fire({
    title: '¿Cambiar Estado?',
    text: `¿Deseas cambiar el estado del pedido a "${estadoTextos[nuevoEstado]}"?`,
    icon: 'question',
    showCancelButton: true,
    confirmButtonText: 'Sí, cambiar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      // Crear formulario temporal para enviar POST
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = 'index.php?url=pedidos&action=cambiar_estado';
      
      const inputId = document.createElement('input');
      inputId.type = 'hidden';
      inputId.name = 'id';
      inputId.value = id;
      
      const inputEstado = document.createElement('input');
      inputEstado.type = 'hidden';
      inputEstado.name = 'nuevo_estado';
      inputEstado.value = nuevoEstado;
      
      form.appendChild(inputId);
      form.appendChild(inputEstado);
      document.body.appendChild(form);
      form.submit();
    }
  });
}
