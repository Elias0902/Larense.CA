function ObtenerCuentaPagar(id) {
  fetch('index.php?url=pagar&action=obtener&ID=' + id)
    .then(response => response.json())
    .then(data => {
      document.getElementById('id').value = data.id_cuenta_pagar;
      document.getElementById('proveedorIdEdit').value = data.proveedor_id;
      document.getElementById('compraIdEdit').value = data.compra_id || '';
      document.getElementById('montoCuentaEdit').value = data.monto;
      document.getElementById('saldoCuentaEdit').value = data.saldo;
      document.getElementById('fechaEmisionEdit').value = data.fecha_emision;
      document.getElementById('fechaVencimientoEdit').value = data.fecha_vencimiento;
      document.getElementById('descripcionCuentaEdit').value = data.descripcion;
      document.getElementById('estadoCuentaEdit').value = data.estado;
    })
    .catch(error => {
      console.error('Error:', error);
    });
}

function RegistrarPagoCuentaPagar(id, saldoActual) {
  Swal.fire({
    title: 'Registrar Pago',
    text: `Saldo pendiente: $${saldoActual.toFixed(2)}`,
    input: 'number',
    inputLabel: 'Monto a pagar:',
    inputPlaceholder: '0.00',
    inputAttributes: {
      min: 0.01,
      max: saldoActual,
      step: 0.01
    },
    showCancelButton: true,
    confirmButtonText: 'Registrar Pago',
    cancelButtonText: 'Cancelar',
    inputValidator: (value) => {
      if (!value || value <= 0) {
        return 'El monto debe ser mayor a 0';
      }
      if (value > saldoActual) {
        return 'El monto no puede exceder el saldo pendiente';
      }
    }
  }).then((result) => {
    if (result.isConfirmed) {
      // Crear formulario temporal para enviar POST
      const form = document.createElement('form');
      form.method = 'POST';
      form.action = 'index.php?url=pagar&action=registrar_pago';
      
      const inputId = document.createElement('input');
      inputId.type = 'hidden';
      inputId.name = 'id';
      inputId.value = id;
      
      const inputMonto = document.createElement('input');
      inputMonto.type = 'hidden';
      inputMonto.name = 'monto_pago';
      inputMonto.value = result.value;
      
      form.appendChild(inputId);
      form.appendChild(inputMonto);
      document.body.appendChild(form);
      form.submit();
    }
  });
}
