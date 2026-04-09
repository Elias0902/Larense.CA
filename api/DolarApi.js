// DolarApi.js
// Función para obtener el precio del dólar desde la API y actualizar el DOM
function obtenerPrecioDolar() {

    // Realizamos la solicitud a la API
    fetch("https://ve.dolarapi.com/v1/dolares/oficial")

    // Procesamos la respuesta y actualizamos el DOM
    .then(response => response.json())

    // Si la solicitud es exitosa, extraemos el precio y la fecha, y los mostramos en el elemento con id 'precioDolar'
    .then(data => {

        // Para verificar la estructura de la respuesta en la consola
        //console.log(data); 

        // Extraemos el precio y la fecha de la respuesta
        const precio = data.promedio;

        // Actualizamos el contenido del elemento con id 'precioDolar' para mostrar el precio del dólar
        const fecha = data.fechaActualizacion;

        // Actualizamos el texto del elemento con id 'precioDolar' para mostrar el precio del dólar
        document.getElementById('dolar_value').innerText = `${precio} Bs/$`;

    })
    // Si hay un error en la solicitud, lo manejamos aquí
    .catch(error => {

        // Mostramos un mensaje de error en la consola y actualizamos el DOM para indicar que hubo un error al cargar el precio
        console.error('Hubo un problema con la solicitud:', error);

        // Actualizamos el texto del elemento con id 'dolar_value' para indicar que hubo un error al cargar el precio
        document.getElementById('dolar_value').innerText = 'Error al cargar el precio';
    })
};

// Llamamos a la función para obtener el precio del dólar cuando se carga la página
window.onload = obtenerPrecioDolar;