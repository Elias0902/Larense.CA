function ObtenerTipoCliente(id) {

  fetch('index.php?url=tipos_clientes&action=obtener&ID=' + id)
    
    .then(response => response.json())
    
    .then(data => {
    
        //console.log(data);
    
        document.getElementById('id').value = data.id_tipo_cliente;
        document.getElementById('nombreTipoClienteEdit').value = data.nombre_tipo_cliente;
        document.getElementById('diaCreditosEdit').value = data.dias_credito;
    
    })
    
    .catch(error => {
    
      console.error('Error:', error);
    
    });
  
  }