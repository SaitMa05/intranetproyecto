$(document).ready(function() {

    $.fn.dataTable.ext.errMode = 'none';

    var table = $('#tablaAsistencias').DataTable({
        "pageLength": 50,
        "columnDefs": [
            { "width": "90%", "targets": 0 },  // Ancho de la primera columna
            { "width": "10%", "targets": 1 },  // Ancho de la segunda columna
        ],
        "responsive": true
    });

    $('#tablaAsistencias').on('error.dt', function(e, settings, techNote, message) {
        alertaMensaje("No hay alumnos registrados en este curso", "error");
        return;
    });

    $('#cursos').change(function() {
        var curso_id = $(this).val();
        var textoCursoSeleccionado = $(this).find('option:selected').text();  // Obtiene el texto visible de la opción seleccionada.
        $('.texto-curso').html(`Alumnos de ${textoCursoSeleccionado}`);
        if (curso_id !== "") {
            $.ajax({
                url: 'asistencias/alumnos',
                method: 'POST',
                data: { cursos: curso_id },
                dataType: 'json',
                success: function(response) {
                    table.clear().draw();

                    if (Array.isArray(response) && response.length > 0) {
                        $.each(response, function(index, alumno) {
                            var fila = "<tr>" +
                                "<td>" + alumno.nombre + " " + alumno.apellido + "</td>" +
                                "<td class='asistencia-confirma text-center'>" +
                                    "<input type='hidden' name='asistencia[" + alumno.id + "]' value='0'>" +
                                    "<input type='checkbox' name='asistencia[" + alumno.id + "]' class='asistencia-checkbox' data-id='" + alumno.id + "' value='1'>" +
                                "</td>" +
                                "<td class='asistencia-confirma text-center'>" +
                                    "<input type='hidden' name='media[" + alumno.id + "]' value='0'>" +
                                    "<input type='checkbox' name='media[" + alumno.id + "]' class='media-checkbox' data-id='" + alumno.id + "' value='1'>" +
                                "</td>" +
                                "<td class='asistencia-confirma text-center'>" +
                                    "<input type='hidden' name='cuarto[" + alumno.id + "]' value='0'>" +
                                    "<input type='checkbox' name='cuarto[" + alumno.id + "]' class='cuarto-checkbox' data-id='" + alumno.id + "' value='1'>" +
                                "</td>" +
                                "<td class='asistencia-confirma text-center'>" +
                                    "<input type='hidden' name='tardanza[" + alumno.id + "]' value='0'>" +
                                    "<input type='checkbox' name='tardanza[" + alumno.id + "]' class='tardanza-checkbox' data-id='" + alumno.id + "' value='1'>" +
                                "</td>" +
                                "</tr>";

                            table.row.add($(fila)).draw(false);
                        });

                        agregarComportamientoCheckboxes();
                    } else {
                        table.row.add($("<tr><td colspan='5'>No se encontraron alumnos para este curso.</td></tr>")).draw(false);
                    }
                },
                error: function() {
                    alertaMensaje("Error al cargar los alumnos", "error");
                    table.row.add($("<tr><td colspan='5'>Error al cargar los alumnos.</td></tr>")).draw(false);
                }
            });
        } else {
            table.clear().draw();
            table.row.add($("<tr><td colspan='5'>Por favor, seleccione un curso.</td></tr>")).draw(false);
        }
    });

    $('#formAsistencia').on('submit', function(e) {
        e.preventDefault();  // Evita el envío tradicional del formulario.
    
        var ausentes = [];  // Array para almacenar los alumnos ausentes.
    
        // Itera todas las filas (incluidas las no visibles debido a la paginación).
        $('#tablaAsistencias').DataTable().rows().nodes().each(function(row) {
            var $row = $(row);  // Convierte la fila a un objeto jQuery.
            var nombreAlumno = $row.find('td:first').text();  // Obtiene el nombre del alumno en la fila actual.

            // Comprueba si algún checkbox en la fila está marcado.
            var asistenciaMarcada = $row.find('.asistencia-checkbox').is(':checked');
            var mediaMarcada = $row.find('.media-checkbox').is(':checked');
            var cuartoMarcada = $row.find('.cuarto-checkbox').is(':checked');
            var tardanzaMarcada = $row.find('.tardanza-checkbox').is(':checked');

            // Si ningún checkbox está marcado, se considera ausente.
            if (!asistenciaMarcada && !mediaMarcada && !cuartoMarcada && !tardanzaMarcada) {
                ausentes.push(nombreAlumno);
            }
        });
    
        // Actualiza el contenido del modal
        if (ausentes.length === 0) {
            // Mostrar mensaje de "Todos los alumnos están presentes" en la lista.
            $('.infoModalForm ul').html('<li>No hay ausentes. ¡Qué grupo más responsable o había prueba?</li>');
        } else {
            // Mostrar la lista de alumnos ausentes.
            var ausentesList = ausentes.map(function(ausente) {
                return '<li>' + ausente + '</li>';
            }).join('');
            $('.infoModalForm ul').html(ausentesList);
        }
    
        // Muestra el detalle escrito en el textarea dentro del modal.
        var detalle = $('textarea[name="detalles"]').val();
        $('.infoModalForm p').text(detalle || 'No se proporcionaron detalles.');
    
        // Abre el modal de verificación.
        $('#verificacionModal').modal('show');
    });
    
    $('#confirmarEnvio').on('click', function() {
        var formData = $('#formAsistencia').serialize();  // Serializa el formulario completo.
        
        $.ajax({
            url: '/asistencias/enviar',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function(response) {
                console.log("Respuesta recibida:", response);
                if (response.status) {
                    toastr.success(response.message, 'Éxito');
                    resetForm();
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function(xhr, status, error) {
                console.error("Error en la solicitud AJAX:", error);
            }
        });

        $('#verificacionModal').modal('hide'); // Cerrar el modal después de confirmar.
    });

    function agregarComportamientoCheckboxes() {
        $('.asistencia-checkbox').on('change', function() {
            var alumnoId = $(this).data('id');
            if ($(this).is(':checked')) {
                desmarcarOtrosCheckboxes(alumnoId, '.asistencia-checkbox');
            }
        });
        $('.media-checkbox').on('change', function() {
            var alumnoId = $(this).data('id');
            if ($(this).is(':checked')) {
                desmarcarOtrosCheckboxes(alumnoId, '.media-checkbox');
            }
        });
        $('.cuarto-checkbox').on('change', function() {
            var alumnoId = $(this).data('id');
            if ($(this).is(':checked')) {
                desmarcarOtrosCheckboxes(alumnoId, '.cuarto-checkbox');
            }
        });
        $('.tardanza-checkbox').on('change', function() {
            var alumnoId = $(this).data('id');
            if ($(this).is(':checked')) {
                desmarcarOtrosCheckboxes(alumnoId, '.tardanza-checkbox');
            }
        });
    }

    function desmarcarOtrosCheckboxes(alumnoId, currentClass) {
        ['.asistencia-checkbox', '.media-checkbox', '.cuarto-checkbox', '.tardanza-checkbox'].forEach(function(selector) {
            if (selector !== currentClass) {
                $(selector + '[data-id="' + alumnoId + '"]').prop('checked', false);
            }
        });
    }

    function resetForm() {
        $('#formAsistencia')[0].reset(); // Resetea el formulario.
    }
});
