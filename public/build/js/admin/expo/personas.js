$(document).ready(function() {

    console.log("Personas.js");
    
    var table = $('#tablaPersonas').DataTable({
        "pageLength": 100,
        "order": [[0, "desc"]],
        "columnDefs": [
            { "width": "25%", "targets": 0, "className": "text-start" },
            { "width": "25%", "targets": 1, "className": "text-start" },  // Ancho de la primera columna
            { "width": "10%", "targets": 2, "className": "text-start" },
            { "width": "20%", "targets": 3, "className": "text-start" },
            { "width": "10%", "targets": 4, "className": "text-center" },
            { "width": "30%", "targets": 5, "className": "text-center" },  // Ancho de la primera columna
        ],
        "responsive": true
    });

    function obtenerPersonas() {
        $.ajax({
            url: '/admin/expo/personas',
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#loading').show(); // Mostrar el spinner
            },
            success: function(personasArray) {
                // console.log(personasArray);
                mostrarPersonas(personasArray);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al obtener los datos:', textStatus, errorThrown);
            },
            complete: function() {
                $('#loading').hide(); // Ocultar el spinner una vez que se completa la solicitud
            }
        });
    }

    function mostrarPersonas(personas) {
        table.clear(); // Limpia la tabla antes de agregar nuevos datos

        $.each(personas, function(index, persona) {
            
            table.row.add([
                `<td class="text-start">${persona.nombre} ${persona.apellido}</td>`,
                `<td class="text-start">${persona.email ?? "No hay email registrado"}</td>`,
                `<td class="text-start">${persona.edad}</td>`,
                `<td class="text-start">${persona.fecha}</td>`,
                `<td class="text-start">${persona.compania}</td>`,
                `<td class="text-start">${persona.nombreUsuario}</td>`,
                
            ]);
        });

        table.draw();
    }


    obtenerPersonas();


});