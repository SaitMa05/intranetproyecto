$(document).ready(function () {

    obtenerUsuarios();


    $.fn.dataTable.ext.errMode = 'none';
    let allUser = [];

    var table = $('#tablaUsuariosGestion').DataTable({
        "pageLength": 10,
        "columnDefs": [
            { "width": "16%", "targets": 0, "className": "text-start" },  // Ancho de la primera columna
            { "width": "16%", "targets": 1, "className": "text-start" },  // Ancho de la segunda columna
            { "width": "16%", "targets": 2, "className": "text-start" },
            { "width": "16%", "targets": 3, "className": "text-start" },
            { "width": "16%", "targets": 4, "className": "text-start" },
            { "width": "16%", "targets": 5, "className": "text-start" },
            { "width": "16%", "targets": 6, "className": "text-start" },
        ],
        "responsive": true
    });
    function obtenerUsuarios() {
        $.ajax({
            url: '/admin/usuarios/gestion',
            method: 'GET',
            dataType: 'json',
            success: function (usuariosArray) {
                // console.log(usuariosArray);
                allUser = usuariosArray['usuariosArray'];
                mostrarUsuarios(usuariosArray['usuariosArray']);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error al obtener los datos:', textStatus, errorThrown);
            }
        });
    }

    function mostrarUsuarios(usuarios) {
        table.clear(); // Limpia la tabla antes de agregar nuevos datos

        $.each(usuarios, function (index, usuario) {
            // console.log(usuario);

            table.row.add([
                `<td class="text-start">${usuario.nombre} ${usuario.apellido}</td>`,
                `<td class="text-start">${usuario.nombreUsuario}</td>`,
                `<td class="text-start">${usuario.dni}</td>`,
                `<td class="text-start">${usuario.telefono}</td>`,
                `<td class="text-start">${usuario.email}</td>`,
                `<td class="text-start">${usuario.nombreRol}</td>`,
                `<td>
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-orange btn-sm btnEditar" data-id="${usuario.id}" data-nombre="${usuario.nombre}" 
                        data-apellido="${usuario.apellido}" data-nombreusuario="${usuario.nombreUsuario}" data-dni="${usuario.dni}" data-telefono="${usuario.telefono}" data-email="${usuario.email}"
                        data-dni1="${usuario.dni1}" data-dni2="${usuario.dni2}" data-dni3="${usuario.dni3}"  data-nombrerol="${usuario.nombreRol}">
                            <i class="bi bi-pencil-square"></i>
                        </button>

                        <button class="btn btn-danger btn-sm btnEliminar" data-id="${usuario.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>`
            ]);

        });

        table.draw();
    }

    $('#tablaUsuariosGestion tbody').on('click', '.btnEditar', function (e) {
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        const apellido = $(this).data('apellido');
        const nombreUsuario = $(this).data('nombreusuario');
        const dni = $(this).data('dni');
        const telefono = $(this).data('telefono');
        const email = $(this).data('email');
        const nombreRol = $(this).data('nombrerol');


        $('#rol-select option').each(function () {
            if ($(this).text() === nombreRol) {
                $(this).prop('selected', true);
            }
        });

        $('#usuario-id').val(id);
        $('#usuario-nombre').val(nombre);
        $('#usuario-apellido').val(apellido);
        $('#usuario-nombreUsuario').val(nombreUsuario);
        $('#usuario-dni').val(dni);
        $('#usuario-telefono').val(telefono);
        $('#usuario-email').val(email);
        $('#usuario-nombrerol').val(nombreRol);

        $('#verificacionModalEditar').modal('show');
    });

    $('#tablaUsuariosGestion tbody').on('click', '.btnEliminar', function (e) {
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
                    url: '/admin/usuarios/eliminar', // Cambia esta URL a tu endpoint real
                    method: 'POST', // Método que uses para eliminar (GET, POST, DELETE, etc.)
                    data: { id: id },
                    success: function (response) {
                        response = JSON.parse(response);
                        if (response.success) {
                            toastr.success(response.message, 'Éxito');
                            obtenerUsuarios();
                            mostrarUsuarios(allUser);
                        } else {
                            toastr.error(response.message, 'Error');
                        }
                    },
                    error: function () {
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

    $('.formEditar').on('submit', function (e) {
        e.preventDefault(); // Evita el envío normal del formulario

        let formData = $(this).serialize(); // Serializa los datos del formulario

        if (!validarFormularioEditar(formData)) {
            return;
        }

        $.ajax({
            url: '/admin/usuarios/editar', // Usa la URL del atributo action
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (response) {

                if (response.success) {
                    toastr.success(response.message, 'Éxito');
                    $('#verificacionModalEditar').modal('hide'); // Cierra el modal
                    obtenerUsuarios();
                    mostrarUsuarios(allUser);

                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            complete: function () {
                $('#loading').hide();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error al editar la puerta:', textStatus, errorThrown);
            }
        });
    });

    $('#btnCrear').click(function () {
        $('#verificacionModalCrear').modal('show');
    });

    $('.formCrear').submit(function (e) {
        e.preventDefault();

        var formData = new FormData(this);

        if (!validarFormularioCrear(formData)) {
            return;
        }

        $.ajax({
            url: '/admin/usuarios/crear',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (response) {
                if (response.success) {
                    $('#verificacionModalCrear').modal('hide');
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
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error al crear la puerta:', textStatus, errorThrown);
            }
        });
    });

    function validarFormularioEditar(formData) {

        const { nombre, apellido, nombreUsuario, dni, telefono, email } = formData.split('&').reduce((obj, item) => {
            const [key, value] = item.split('=');
            obj[key] = value;
            return obj;
        }, {});


        if (nombre === '' || apellido === '' || nombreUsuario === '' || email === '') {
            toastr.error('Todos los campos son obligatorios', 'Error');
            return false;
        }

        if (dni.length !== 8 || isNaN(dni)) {
            toastr.error('El DNI debe ser válido', 'Error');
            return false;
        }

        if (telefono.length < 6 || isNaN(telefono)) {
            toastr.error('El teléfono debe ser válido', 'Error');
            return false;
        }


        return true;
    }

    function validarFormularioCrear(formData) {
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });
        const { nombre, apellido, nombreUsuario, dni, telefono, email, password, passwordConfirm, rol } = data;

        if (nombreUsuario === '' || email === '' || password === '') {
            toastr.error('Todos los campos son obligatorios', 'Error');
            return false;
        }

        if (dni.length !== 8 || isNaN(dni)) {
            toastr.error('El DNI debe ser válido', 'Error');
            return false;
        }

        if (telefono.length < 6 || isNaN(telefono)) {
            toastr.error('El teléfono debe ser válido', 'Error');
            return false;
        }

        // Expresión regular para validar la contraseña
        const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,}$/;

        if (!passwordRegex.test(password)) {
            toastr.error('La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial', 'Error');
            return false;
        }

        if (password !== passwordConfirm) {
            toastr.error('Las contraseñas no coinciden', 'Error');
            return false;
        }

        if (rol === '') {
            toastr.error('Debe seleccionar un rol', 'Error');
            return false;
        }

        return true;
    }

});