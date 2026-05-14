function ObtenerEntrega(id) {
  fetch('index.php?url=entregas&action=obtener&ID=' + id)
    .then(response => response.json())
    .then(data => {
      // Usar los nombres de campo correctos según tu base de datos
      document.getElementById('id').value = data.id_entregas || data.id_entrega;
      document.getElementById('clienteIdEdit').value = data.cliente_id || data.id_clientes;
      document.getElementById('pedidoIdEdit').value = data.id_pedido || data.pedido_id || '';
      document.getElementById('direccionEntregaEdit').value = data.direccion || data.direccion_entrega || '';
      document.getElementById('telefonoEntregaEdit').value = data.telefono_contacto || data.tlf_cliente || '';
      document.getElementById('repartidorEntregaEdit').value = data.repartidor || '';
      
      // Formatear fecha para input datetime-local
      let fechaProgramada = data.fecha_programada || data.fecha_entrega_programada;
      if (fechaProgramada) {
        document.getElementById('fechaProgramadaEdit').value = fechaProgramada.replace(' ', 'T').substring(0, 16);
      }
      
      document.getElementById('estadoEntregaEdit').value = data.estado || 'pendiente';
      document.getElementById('observacionesEntregaEdit').value = data.observaciones || '';
    })
    .catch(error => {
      console.error('Error:', error);
      Swal.fire({
        title: 'Error',
        text: 'No se pudo cargar la información de la entrega',
        icon: 'error',
        confirmButtonText: 'Aceptar'
      });
    });
}

function ConfirmarEntrega(id) {
  Swal.fire({
    title: '¿Confirmar Entrega?',
    text: "¿Estás seguro de que esta entrega ha sido completada?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#28a745',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Sí, confirmar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      // Crear formulario temporal para enviar POST
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = 'index.php?url=entregas&action=confirmar_entrega';
      
      const inputId = document.createElement('input');
      inputId.type = 'hidden';
      inputId.name = 'id';
      inputId.value = id;
      
      form.appendChild(inputId);
      document.body.appendChild(form);
      form.submit();
    }
  });
}

function EliminarEntrega(event, id) {
  event.preventDefault();
  Swal.fire({
    title: '¿Eliminar Entrega?',
    text: "Esta acción marcará la entrega como eliminada. ¿Deseas continuar?",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#dc3545',
    cancelButtonColor: '#6c757d',
    confirmButtonText: 'Sí, eliminar',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = 'index.php?url=entregas&action=eliminar&ID=' + id;
    }
  });
  return false;
}