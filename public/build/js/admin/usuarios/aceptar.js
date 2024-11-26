$(document).ready(function() {

    obtenerUsuarios();

    $.fn.dataTable.ext.errMode = 'none';
    let allUser = [];
    var table = $('#tablaUsuariosAceptar').DataTable({
        "pageLength": 10,
        "columnDefs": [
            { "width": "30%", "targets": 0, "className": "text-start" },  // Ancho de la primera columna
            { "width": "40%", "targets": 1, "className": "text-start" },  // Ancho de la segunda columna
            { "width": "20%", "targets": 2, "className": "text-start" },  
            { "width": "10%", "targets": 3 },  
        ],
        "responsive": true
    });
    function obtenerUsuarios() {
        $.ajax({
            url: '/admin/usuarios/aceptar',
            method: 'GET',
            dataType: 'json',
            success: function(usuariosArray) {
                allUser = usuariosArray;
                mostrarUsuarios(usuariosArray);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('Error al obtener los datos:', textStatus, errorThrown);
            }
        });
    }

    function mostrarUsuarios(usuarios) {
        table.clear(); // Limpia la tabla antes de agregar nuevos datos

        $.each(usuarios, function(index, usuario) {
            // console.log(usuario);
            
            table.row.add([
                `<td class="text-start">${usuario.nombre} ${usuario.apellido}</td>`,
                `<td class="text-start">${usuario.dni}</td>`,
                `<td class="text-start">${usuario.fechaCreacion}</td>`,
                `<td>
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-danger btn-sm btnVer" data-id="${usuario.id}" data-nombre="${usuario.nombre}" 
                        data-apellido="${usuario.apellido}" data-nombreusuario="${usuario.nombreUsuario}" data-dni="${usuario.dni}" data-telefono="${usuario.telefono}" data-email="${usuario.email}"
                        data-dni1="${usuario.dni1}" data-dni2="${usuario.dni2}" data-dni3="${usuario.dni3}"  data-nombrerol="${usuario.nombreRol}">
                            <i class="bi bi-info-circle"></i>
                        </button>
                    </div>
                </td>`
            ]);
        });

        table.draw();
    }

    $('#tablaUsuariosAceptar tbody').on('click', '.btnVer', function(e) {        
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const apellido = $(this).data('apellido');
        const nombreUsuario = $(this).data('nombreusuario');
        const dni = $(this).data('dni');
        const telefono = $(this).data('telefono');
        const email = $(this).data('email');
        const dni1 = $(this).data('dni1');
        const dni2 = $(this).data('dni2');
        const dni3 = $(this).data('dni3');
        const nombreRol = $(this).data('nombrerol');


        let nombreCompleto = nombre + ' ' + apellido;
        

        $('#usuario-id').val(id);
        $('#usuario-email-form').val(email);

        $('#usuario-nombre').text(nombreCompleto);
        $('#usuario-nombreUsuario').text(nombreUsuario);
        $('#usuario-dni').text(dni);
        $('#usuario-telefono').text(telefono);
        $('#usuario-email').text(email);
        $('#usuario-nombrerol').text(nombreRol);
        $('#usuario-dni1').text(dni1);
        $('#usuario-dni1').attr('src', `../../imagenes/${dni1}`);
        $('#usuario-dni2').attr('src', `../../imagenes/${dni2}`);
        $('#usuario-dni3').attr('src', `../../imagenes/${dni3}`);

        $('#verificacionModal').modal('show');
    });

    
    $('#confirmarEnvioAceptar').click(function(){
        $('.formAceptar').on('submit', function(e) {
            e.preventDefault(); // Evita el envío normal del formulario
    
            let formData = $(this).serialize(); // Serializa los datos del formulario
    
            Swal.fire({
                title: '¿Estás seguro?',
                text: "",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, Aceptar',
                cancelButtonText: 'Cancelar',
                confirmButtonColor: '',
                cancelButtonColor: ''
            }).then((result) => {
                if (result.isConfirmed) {
                    // Aquí podrías hacer la eliminación con AJAX
                    $.ajax({
                        url: '/admin/usuarios/confirmar', // Usa la URL del atributo action
                        type: 'POST',
                        data: formData,
                        dataType: 'json',
                        beforeSend: function () {
                            $('#loading').show();
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#verificacionModal').modal('hide'); // Cierra el modal
                                toastr.success(response.message, 'Éxito');
                                obtenerUsuarios();
                                mostrarUsuarios(allUser);
                            } else {
                                toastr.error(response.message, 'Error');
                            }
                        },
                        complete: function () {
                            $('#loading').hide();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Error al editar la puerta:', textStatus, errorThrown);
                        }
                    });
                }
            });

        });
    });
    $('#confirmarEliminar').click(function(){
    
            let formData = $("#usuario-id").val(); // Serializa los datos del formulario
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
                        url: '/admin/usuarios/eliminar', // Usa la URL del atributo action
                        type: 'POST',
                        data: {id: formData},
                        dataType: 'json',
                        success: function(response) {
                            if (response.success) {
                                $('#verificacionModal').modal('hide'); // Cierra el modal
                                toastr.success(response.message, 'Éxito');
                                obtenerUsuarios();
                                mostrarUsuarios(allUser);
                            } else {
                                toastr.error(response.message, 'Error');
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            console.error('Error al editar la puerta:', textStatus, errorThrown);
                        }
                    });
                }
            });
    });


});