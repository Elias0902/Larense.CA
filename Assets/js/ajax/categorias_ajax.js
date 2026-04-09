function ObtenerCategoria(id) {

  fetch('index.php?url=categorias&action=obtener&ID=' + id)
    
    .then(response => response.json())
    
    .then(data => {
    
      //console.log(data);
    
      document.getElementById('id').value = data.id_categoria;
    
      document.getElementById('nombreCategoriaEdit').value = data.nombre_categoria;
    
    })
    
    .catch(error => {
    
      console.error('Error:', error);
    
    });
  
  }