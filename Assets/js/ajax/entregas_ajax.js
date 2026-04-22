function ObtenerEntrega(id) {
  fetch('index.php?url=entregas&action=obtener&ID=' + id)
    .then(response => response.json())
    .then(data => {
      document.getElementById('id').value = data.id_entrega;
      document.getElementById('clienteIdEdit').value = data.cliente_id;
      document.getElementById('pedidoIdEdit').value = data.pedido_id || '';
      document.getElementById('direccionEntregaEdit').value = data.direccion;
      document.getElementById('telefonoEntregaEdit').value = data.telefono_contacto || '';
      document.getElementById('repartidorEntregaEdit').value = data.repartidor || '';
      document.getElementById('fechaProgramadaEdit').value = data.fecha_programada.replace(' ', 'T').substring(0, 16);
      document.getElementById('estadoEntregaEdit').value = data.estado;
      document.getElementById('observacionesEntregaEdit').value = data.observaciones || '';
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

function ConfirmarEntrega(id) {
  Swal.fire({
    title: '¿Confirmar Entrega?',
    text: "¿Estás seguro de que esta entrega ha sido completada?",
    icon: 'question',
    showCancelButton: true,
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
