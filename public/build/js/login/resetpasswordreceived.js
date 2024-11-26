$(document).ready(function() { 

    $('#formResetPasswordReceived').on('submit', function (e) {
        e.preventDefault(); // Evita que el formulario se envíe de la manera tradicional
    
        let formData = $('#formResetPasswordReceived').serialize(); // Serializa los datos del formulario

        if (!validarFormulario(formData)) {
            return;
        }
        
        $.ajax({
            url: '/resetpasswordreceived/actualizar', // Cambia esto por la URL de tu servidor
            type: 'POST',
            data: formData,
            dataType: 'json',
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (response) {
                // Verificamos la respuesta
                if (response.success) {
                    toastr.success(response.message, 'Éxito');

                    resetForm();
                    setTimeout(function () {
                        window.location.href = '/login';
                    }, 2000);                
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            complete: function () {
                $('#loading').hide();
            },
            error: function (xhr, status, error) {
                toastr.error('Error en la solicitud', 'Error');
                console.error('Error:', error);
            }
        });
    });

    function validarFormulario(formData) {
        let passwordConfirm = $('#passwordConfirm').val();
        let password = $('#password').val();
        
    
        if (password === '' || passwordConfirm === '') {
            toastr.error('Todos los campos son obligatorios', 'Error');
            return false;
        }

        // const passwordRegex = /^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*(),.?":{}|<>])[A-Za-z\d!@#$%^&*(),.?":{}|<>]{8,}$/;
    
        // if (!passwordRegex.test(password)) {
        //     toastr.error('La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial', 'Error');
        //     return false;
        // }

        if (password !== passwordConfirm) {
            toastr.error('Las contraseñas no coinciden', 'Error');
            console.log(password);
            console.log(passwordConfirm);
                        
            return false;
        }
    
    
        return true;
    }
    function resetForm() {
        $('#formResetPasswordReceived')[0].reset(); // Resetea el formulario
    }

});