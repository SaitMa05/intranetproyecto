$(document).ready(function() {

    console.log("Empresas.js");
    
    var table = $('#tablaEmpresas').DataTable({
        "pageLength": 100,
        "order": [[0, "desc"]],
        "columnDefs": [
            { "width": "12%", "targets": 0, "className": "text-start" },
            { "width": "12%", "targets": 1, "className": "text-start" },  // Ancho de la primera columna
            { "width": "12%", "targets": 2, "className": "text-start" },  // Ancho de la primera columna
            { "width": "12%", "targets": 3, "className": "text-start" },  // Ancho de la primera columna
            { "width": "12%", "targets": 4, "className": "text-start" },  // Ancho de la primera columna
            { "width": "12%", "targets": 5, "className": "text-center" },
            { "width": "16%", "targets": 6, "className": "text-start info-table" },  // Ancho de la primera columna
            { "width": "12%", "targets": 7, "className": "text-center" },   // Ancho de la primera columna
        ],
        "responsive": true
    });

    function obtenerEmpresas() {
        $.ajax({
            url: '/admin/expo/empresas',
            method: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('#loading').show(); // Mostrar el spinner
            },
            success: function(empresasArray) {
                // console.log(empresasArray);
                mostrarEmpresas(empresasArray);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al obtener los datos:', textStatus, errorThrown);
            },
            complete: function() {
                $('#loading').hide(); // Ocultar el spinner una vez que se completa la solicitud
            }
        });
    }

    function mostrarEmpresas(escuelas) {
        table.clear(); // Limpia la tabla antes de agregar nuevos datos

        $.each(escuelas, function(index, escuela) {
            
            table.row.add([
                `<td class="text-start">${escuela.empresa}</td>`,
                `<td class="text-start">${escuela.nombre} ${escuela.apellido}</td>`,
                `<td class="text-start">${escuela.email ?? "No hay email registrado"}</td>`,
                `<td class="text-start">${escuela.edad}</td>`,
                `<td class="text-start">${escuela.fecha}</td>`,
                `<td class="text-start">${escuela.cantidad}</td>`,
                `<td class="text-start">${escuela.info}</td>`,
                `<td class="text-start">${escuela.nombreUsuario}</td>`,
                
            ]);
        });

        table.draw();
    }


    obtenerEmpresas();


});