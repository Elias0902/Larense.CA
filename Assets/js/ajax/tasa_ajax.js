function ObtenerTasa(id) {

  fetch('index.php?url=tasa&action=obtener&ID=' + id)
    
    .then(response => response.json())
    
    .then(data => {
    
      //console.log(data);
    
      document.getElementById('id').value = data.id_tasa;
    
      document.getElementById('montoTasaEdit').value = data.monto_tasa;
    
    })
    
    .catch(error => {
    
      console.error('Error:', error);
    
    });
  
  }