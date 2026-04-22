function ObtenerPago(id) {
  fetch('index.php?url=pagos&action=obtener&ID=' + id)
    .then(response => response.json())
    .then(data => {
      document.getElementById('id').value = data.id_pago;
      document.getElementById('clienteIdEdit').value = data.cliente_id;
      document.getElementById('pedidoIdEdit').value = data.pedido_id || '';
      document.getElementById('montoPagoEdit').value = data.monto;
      document.getElementById('metodoPagoEdit').value = data.metodo_pago;
      document.getElementById('referenciaPagoEdit').value = data.referencia || '';
      document.getElementById('fechaPagoEdit').value = data.fecha_pago;
      document.getElementById('observacionesPagoEdit').value = data.observaciones || '';
      document.getElementById('estadoPagoEdit').checked = data.status == 1;
    })
    .catch(error => {
      console.error('Error:', error);
    });
}
