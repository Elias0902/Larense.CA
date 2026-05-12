function ObtenerCuentaCobrar(id) {
  //console.log(id);
  fetch('index.php?url=cobrar&action=obtener&ID=' + id)
    .then(response => response.json())
    .then(data => {
      //console.log(data);
      document.getElementById('id').value = data.id_cuenta_x_cobrar;
      document.getElementById('id_cliente').value = data.id_cliente;
      document.getElementById('clientePago').value = data.nombre_cliente;
      document.getElementById('montoTotal').value = data.monto_total;
    })
    .catch(error => {
      console.error('Error:', error);
    });
}