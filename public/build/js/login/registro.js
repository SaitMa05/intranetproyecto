$(document).ready(function() {
    $('#formRegistro').on('submit', function(e) {
        e.preventDefault(); // Evita que el formulario se envíe de la manera tradicional

        var formData = new FormData(this); // Serializa los datos del formulario
        if (!validarFormulario(formData)) {
            return;
        }
        
        $.ajax({
            url: '/registro/crear', // Cambia esto por la URL de tu servidor
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json', // Indicamos que esperamos una respuesta JSON
            beforeSend: function() {
                $('#loading').show();
            },
            success: function(response) {
                if (response.status) {
                    toastr.success(response.message, 'Éxito');
                    setTimeout(function() {
                        redirect('/login'); // Función para redirigir después de un tiempo
                    }, 2000);
                    resetForm(); // Resetea el formulario si todo salió bien
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            complete: function() {
                $('#loading').hide();
            },
            error: function(xhr, status, error) {
                toastr.error('¡Error al registrar!', 'Error');
                console.error('Error:', error);
            }
        });
    });

    function redirect(url) {
        window.location.href = url; // Simple redirección
    }

    function resetForm() {
        $('#formRegistro')[0].reset(); // Resetea el formulario
    }

    function validarFormulario(formData) {
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });
        const { nombre, apellido, nombreUsuario, dni, telefono, email, password, passwordConfirm } = data;
    
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
    
        // // Expresión regular para validar la contraseña
        // const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,}$/;
    
        // if (!passwordRegex.test(password)) {
        //     toastr.error('La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial', 'Error');
        //     return false;
        // }
    
        if (password !== passwordConfirm) {
            toastr.error('Las contraseñas no coinciden', 'Error');
            return false;
        }
    
        return true;
    }
    

    
    
});
