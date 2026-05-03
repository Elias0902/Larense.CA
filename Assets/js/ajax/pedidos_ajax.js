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

      // Obtener productos asociados al pedido
      fetch('index.php?url=pedidos&action=obtener_productos&ID=' + id)
        .then(response => response.json())
        .then(productos => {
          // Deseleccionar todos los productos primero
          const selectProductos = document.getElementById('productosEdit');
          for (let i = 0; i < selectProductos.options.length; i++) {
            selectProductos.options[i].selected = false;
          }

          // Seleccionar los productos asociados
          if (Array.isArray(productos)) {
            productos.forEach(producto => {
              for (let i = 0; i < selectProductos.options.length; i++) {
                if (selectProductos.options[i].value == producto.id_producto) {
                  selectProductos.options[i].selected = true;
                  break;
                }
              }
            });
          }

          // Abrir el modal después de cargar los datos
          var modal = new bootstrap.Modal(document.getElementById('pedidoModalModificar'));
          modal.show();
        })
        .catch(error => {
          console.error('Error al obtener productos:', error);
          // Abrir el modal aunque falle la carga de productos
          var modal = new bootstrap.Modal(document.getElementById('pedidoModalModificar'));
          modal.show();
        });
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
