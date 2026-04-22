// funcion para optener los roles
function ObtenerRoles() {

    // url del ajax
  fetch('index.php?url=roles&action=')
    
  // reponse de la peticion
    .then(response => response.json())
    
    // apunte de la data
    .then(data => {
    
      //console.log(data);

      // llama la funcion para k=llenar el select
    poblarSelectRoles(data)
    
    })
    
    // en caso de error
    .catch(error => {
    
    // imprime el error
      console.error('Error:', error);
    
    });
  
}

// funcion para llenar el select 
function poblarSelectRoles(roles) {

    // se define contante del selector
    const select = document.getElementById('rolSelectPermisos');
    
    // Limpiar todas las opciones excepto la primera
    select.innerHTML = '<option value="">Seleccione un Rol</option>';
    
    // Remover el option vacío que tienes
    const optionVacio = select.querySelector('#id_rol');
    
    // verifica si esta vacio
    if (optionVacio) {

        // remueve si esta vacio
        optionVacio.remove();
    }
    
    // Llenar con tus 4 roles (solo los activos)
    roles.forEach(rol => {

        // verifica el status
        if (rol.status === 1) {

            // se define la option
            const option = document.createElement('option');
            option.value = rol.id_rol;           // value = 1,2,3,4
            option.textContent = rol.nombre_rol;  // texto = "Superusuario", etc.
            select.appendChild(option);
        }
    });
}

// llama la funcion por defecto cada ves que se carga la pagina
ObtenerRoles();