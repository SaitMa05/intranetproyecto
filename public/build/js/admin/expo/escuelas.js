$(document).ready(function() {

    console.log("Escuelas.js");
    
    var table = $('#tablaEscuelas').DataTable({
        "pageLength": 100,
        "order": [[0, "desc"]],
        "columnDefs": [
            { "width": "12%", "targets": 0, "className": "text-start" },
            { "width": "12%", "targets": 1, "className": "text-start" },  // Ancho de la primera columna
            { "width": "12%", "targets": 2, "className": "text-start" },  // Ancho de la primera columna
            { "width": "12%", "targets": 3, "className": "text-start" },  // Ancho de la primera columna
            { "width": "12%", "targets": 4, "className": "text-start" },  // Ancho de la primera columna
            { "width": "12%", "targets": 5, "className": "text-center" },
            { "width": "16%", "targets": 6, "className": "text-center info-table" },
            { "width": "11%", "targets": 7, "className": "text-center" },  // Ancho de la primera columna
        ],
        "responsive": true
    });

    function obtenerEscuelas() {
        $.ajax({
            url: '/admin/expo/escuelas',
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#loading').show(); // Mostrar el spinner
            },
            success: function(escuelasArray) {
                // console.log(escuelasArray);
                mostrarEscuelas(escuelasArray);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al obtener los datos:', textStatus, errorThrown);
            },
            complete: function() {
                $('#loading').hide(); // Ocultar el spinner una vez que se completa la solicitud
            }
        });
    }

    function mostrarEscuelas(escuelas) {
        table.clear(); // Limpia la tabla antes de agregar nuevos datos

        $.each(escuelas, function(index, escuela) {
            
            table.row.add([
                `<td class="text-start">${escuela.escuela}</td>`,
                `<td class="text-start">${escuela.nombre} ${escuela.apellido}</td>`,
                `<td class="text-start">${escuela.email ?? "No hay email registrado"}</td>`,
                `<td class="text-start">${escuela.edad}</td>`,
                `<td class="text-start">${escuela.fecha}</td>`,
                `<td class="text-start">${escuela.cantidad}</td>`,
                `<td class="text-start info-table">${escuela.info}</td>`,
                `<td class="text-start">${escuela.nombreUsuario}</td>`,
            ]);
        });

        table.draw();
    }


    obtenerEscuelas();


});