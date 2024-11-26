$(document).ready(function() {
    // Función para obtener las puertas desde el servidor con AJAX
    function obtenerPuertas() {
        $.ajax({
            url: '/puertas', // URL del controlador que devuelve los datos
            method: 'GET',
            dataType: 'json',
            success: function(puertasConMovimientos) {
                mostrarPuertas(puertasConMovimientos); // Llamar a la función para mostrar los datos
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al obtener los datos:', textStatus, errorThrown);
            }
        });
    }

    // Función para mostrar las puertas en el DOM
    function mostrarPuertas(puertas) {
        const $contenedorPuertas = $('.puertas-cont'); // Seleccionar el contenedor
        $('#loading').show();
        // Limpiar el contenido previo
        $contenedorPuertas.empty();
        window.addEventListener('MQTTConectado', function(event) {
            $('#loading').hide();
            receivedData = event.detail;            
            $.each(puertas, function(index, puerta) {
                let historialHtml = ''; // Variable para almacenar el historial de cada puerta
                    
                const puertaElement = `
                <div class="d-grid puerta mb-2">
                    <button type="button" value="${puerta.id}" data-id="${puerta.id}" data-nombre="${puerta.nombre}" class="btn btn-puertas btnAbrir p-2">${puerta.nombre}</button>
                    <div class="historial">
                        ${historialHtml}
                    </div>
                </div>
                `;
                
                // Añadir los elementos de cada puerta al contenedor
                $contenedorPuertas.append(puertaElement);
            });
        });
        
    }

    // Evento click para los botones de abrir puertas con SweetAlert
    $(document).on('click', '.btnAbrir', function() {
        const puertaId = $(this).val();
        const puertaNombre = $(this).data('nombre');
        
        // SweetAlert de confirmación 
        Swal.fire({
            title: `¿Está seguro de que desea abrir la puerta "${puertaNombre}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Confirmar',
            cancelButtonText: 'Cancelar'
            
        }).then((result) => {
            if (result.isConfirmed) {
                // Si el usuario confirma, realiza el envío de datos
                const fkPuertas = $(this).data('id');
                const puertaNombre = $(this).data('nombre');

                $.ajax({
                    url: '/puertas/movimiento', // Cambia esto a la URL de tu servidor
                    type: 'POST',
                    data: { fkPuertas: fkPuertas },
                    dataType: 'json',
                    beforeSend: function() {
                        $('#loading').show(); // Mostrar el spinner
                    },
                    success: function(response) {
                        if (response.status) {
                            toastr.success(response.message + " " + puertaNombre, 'Éxito');
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error en la solicitud AJAX:", error);
                    },
                    complete: function() {
                        $('#loading').hide(); // Ocultar el spinner una vez que se completa la solicitud
                    }
                });

                const event = new CustomEvent('dataSent', { detail: puertaNombre });
                window.dispatchEvent(event);
            }
        });
    });
    
    // Llamar a la función para obtener los datos al cargar la página
    obtenerPuertas();
});
