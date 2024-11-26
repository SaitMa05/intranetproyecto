$(document).ready(function() {

    console.log('Admin Movimientos');
    
    $.fn.dataTable.ext.errMode = 'none';
    let allMovimientos = [];
    var table = $('#tablaMovimientos').DataTable({
        "pageLength": 25,
        "columnDefs": [
            { "width": "25%", "targets": 0, "className": "text-start" },
            { "width": "25%", "targets": 1, "className": "text-start" },  // Ancho de la primera columna
            { "width": "20%", "targets": 2, "className": "text-start" },  // Ancho de la primera columna
        ],
        "responsive": true
    });

    function obtenerMovimiento() {
        $.ajax({
            url: '/admin/puertas/movimientos',
            method: 'GET',
            dataType: 'json',
            success: function(movimientosArray) {
                allMovimientos = movimientosArray;
                mostrarMovimientos(movimientosArray);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al obtener los datos:', textStatus, errorThrown);
            }
        });
    }

    function mostrarMovimientos(movimientos) {
        table.clear(); // Limpia la tabla antes de agregar nuevos datos

        $.each(movimientos, function(index, movimiento) {
            table.row.add([
                `<td class="text-start">${movimiento.nombreUsuario} ${movimiento.apellidoUsuario}</td>`,
                `<td class="text-start">${movimiento.nombrePuerta}</td>`,
                `<td class="text-start">${movimiento.fechaApertura}</td>`,
            ]);
        });

        table.draw();
    }


    obtenerMovimiento();
}()); 