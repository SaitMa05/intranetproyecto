$(document).ready(function() {
    
    console.log('Admin puertas');
    
    $.fn.dataTable.ext.errMode = 'none';
    let allPuertas = [];
    var table = $('#tablaPuertas').DataTable({
        "pageLength": 10,
        "columnDefs": [
            { "width": "90%", "targets": 0, "className": "text-start" },  // Ancho de la primera columna
            { "width": "10%", "targets": 1 },  // Ancho de la segunda columna
        ],
        "responsive": true
    });

    function obtenerPuertas() {
        $.ajax({
            url: '/admin/puertas',
            method: 'GET',
            dataType: 'json',
            success: function(puertasConMovimientos) {
                allPuertas = puertasConMovimientos;
                mostrarPuertas(puertasConMovimientos);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al obtener los datos:', textStatus, errorThrown);
            }
        });
    }

    function mostrarPuertas(puertas) {
        table.clear(); // Limpia la tabla antes de agregar nuevos datos

        $.each(puertas, function(index, puerta) {
            console.log(puerta);
            
            table.row.add([
                `<td class="text-start">${puerta.nombre}</td>`,
                `
                <div class="d-flex justify-content-center gap-2">
                    <button class="btn btn-orange btn-sm btnEditar" data-id="${puerta.id}" data-nombre="${puerta.nombre}" data-descripcion="${puerta.descripcion}" >
                        <i class="bi bi-pencil-square"></i>
                    </button>
                    <button class="btn btn-danger btn-sm btnEliminar" data-id="${puerta.id}">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
                `
            ]);
        });

        table.draw();
    }

    // Evento para el botón Editar (delegación de eventos)
    $('#tablaPuertas tbody').on('click', '.btnEditar', function(e) {        
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const descripcion = $(this).data('descripcion');
        
        

        $('#puerta-id').val(id);
        $('#puerta-nombre').val(nombre);
        $('#puerta-descripcion').val(descripcion);
        $('#verificacionModalEditar').modal('show');
    });

    $('#tablaPuertas tbody').on('click', '.btnEliminar', function(e) {
        e.preventDefault(); // Prevenir la acción por defecto del botón si es un <a> o un submit
    const id = $(this).data('id'); // Obtener el ID del elemento
    
    // Mostrar la alerta de confirmación
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '',
        cancelButtonColor: ''
    }).then((result) => {
        if (result.isConfirmed) {
            // Aquí podrías hacer la eliminación con AJAX
            $.ajax({
                url: '/admin/puertas/eliminar', // Cambia esta URL a tu endpoint real
                method: 'POST', // Método que uses para eliminar (GET, POST, DELETE, etc.)
                data: { id: id },
                success: function(response) {
                    response = JSON.parse(response);
                    toastr.success(response.message, 'Éxito');
                    obtenerPuertas();
                    mostrarPuertas(allPuertas);
                },
                error: function() {
                    Swal.fire(
                        'Error',
                        'Ocurrió un error al intentar eliminar el registro.',
                        'error'
                    );
                }
            });
        }
    });
        
    });

    $('#confirmarEnvioEditar').click(function(){
        $('.formEditar').on('submit', function(e) {
            e.preventDefault(); // Evita el envío normal del formulario
    
            let formData = $(this).serialize(); // Serializa los datos del formulario
    
            $.ajax({
                url: '/admin/puertas/editar', // Usa la URL del atributo action
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#verificacionModalEditar').modal('hide'); // Cierra el modal
                        toastr.success(response.message, 'Éxito');
                        obtenerPuertas();
                        mostrarPuertas(allPuertas);

                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error al editar la puerta:', textStatus, errorThrown);
                }
            });
        });
    });




    $('#btnCrear').click(function() {
        $('#verificacionModalCrear').modal('show');
    });

    $('#confirmarEnvioCrear').click(function() {
        
        $('.formCrear').submit(function(e) {
            e.preventDefault();
        
            
            let formData = $(this).serialize();
    
            $.ajax({
                url: '/admin/puertas/crear',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        $('#verificacionModalCrear').modal('hide');
                        toastr.success(response.message, 'Éxito');
                        obtenerPuertas();
                        mostrarPuertas(allPuertas);
                    } else {
                        toastr.error(response.message, 'Error');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error al crear la puerta:', textStatus, errorThrown);
                }
            });
        });
    });
    

    obtenerPuertas();

});