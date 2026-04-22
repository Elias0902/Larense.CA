// funcion para obtener los permisos del rol
function ObtenerPermisosRol(id) {
      //console.log(id);

      // url de la peticion
  fetch('index.php?url=permisos&action=obtener&ID=' + id)
    
  // response de la peticion
    .then(response => response.json())
    
    // data
    .then(data => {
    
      //console.log(data);
    
      // llama la funcion de llenar tabla
      llenarTablaPermisos(data);
    
    })
    
    // manejo de error
    .catch(error => {
    
        // mprime msj de error
      console.error('Error:', error);
    
    });
  
}

// funcion para jjenar tabla de permisos
function llenarTablaPermisos(data) {
    const tbody = document.getElementById("tbodyPermisos");
    tbody.innerHTML = "";

    const modulos = {};
    data.forEach(item => {
        if (!modulos[item.id_modulo]) {
            modulos[item.id_modulo] = { nombre: item.nombre_modulo, permisos: {} };
        }
        modulos[item.id_modulo].permisos[item.id_permiso] = item.status;
    });

    const permisos = [{id:1,nombre:"Agregar"},{id:2,nombre:"Consultar"},{id:3,nombre:"Modificar"},{id:4,nombre:"Eliminar"}];

    Object.keys(modulos).forEach(idModulo => {
        const modulo = modulos[idModulo];
        let fila = `<tr data-modulo="${idModulo}"><td><div style="font-weight:700;color:#1a1a2e;font-size:0.8rem;text-transform:uppercase;">${modulo.nombre}</div></td>`;

        permisos.forEach(permiso => {
            const activo = modulo.permisos[permiso.id] == 1 ? 'active' : '';
            fila += `<td class="text-center">
    <div class="permiso-check ${activo}" 
         onclick="togglePermisoAjax(this)" 
         data-modulo="${idModulo}" 
         data-permiso="${permiso.id}" 
         data-id-rol="${data[0].id_rol}">
        <i class="fas fa-check"></i>
    </div>
    </td>`;
        });

        fila += '</tr>';
        tbody.innerHTML += fila;
    });
}

// 🔥 FUNCIÓN AJAX DIRECTA (para oninput)
function togglePermisoAjax(permisoElement) {
    const idModulo = permisoElement.dataset.modulo;
    const idPermiso = permisoElement.dataset.permiso;
    const idRol = permisoElement.dataset.idRol;
    const nuevoStatus = permisoElement.classList.contains('active') ? 0 : 1;

    const datosJson = {
        id_rol: parseInt(idRol),
        id_modulo: parseInt(idModulo),
        id_permiso: parseInt(idPermiso),
        status: nuevoStatus
    };

    // Loading
    permisoElement.classList.add('updating');

    fetch('index.php?url=permisos&action=actualizar', {
        method: 'POST',
        headers: {'Content-Type': 'application/json'},
        body: JSON.stringify(datosJson)
    })
    //console.log(datosJson)
    .then(response => response.json())
    .then(res => {
        if (!res.success) {
           //SweetAlert2 ÉXITO
            Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: 'Permiso modificado correctamente',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                });

                //REFRESCAR TABLA EN TIEMPO REAL
                ObtenerPermisosRol(idRol);
                
        } else {
            //SweetAlert2 ERROR
            Swal.fire({
                icon: 'error',
                title: '¡Error!',
                text: res.msj || 'Error desconocido',
                confirmButtonText: 'OK'
            });
        }
        permisoElement.classList.remove('updating');
    })
    .catch(e => {
        console.error(e);
        permisoElement.classList.remove('updating');
    });
}