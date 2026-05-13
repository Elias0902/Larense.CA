function ObtenerCuentaPagar(id) {
  //console.log(id);
  fetch('index.php?url=pagar&action=obtener&ID=' + id)
    .then(response => response.json())
    .then(data => {
      //console.log(data);
      document.getElementById('id').value = data.id_cuenta_x_pagar;
      document.getElementById('id_proveedor').value = data.id_proveedor;
      document.getElementById('proveedorPago').value = data.nombre_proveedor;
      document.getElementById('montoTotal').value = data.monto_total;
    })
    .catch(error => {
      console.error('Error:', error);
    });
}