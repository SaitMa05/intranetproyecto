$(document).ready(function () {
    // console.log("Desde login.js");

    $('#formLogin').on('submit', function (e) {
        e.preventDefault(); // Evita que el formulario se envíe de la manera tradicional

        var formData = $(this).serialize(); // Serializa los datos del formulario

        if (!validarFormulario(formData)) {
            return;
        }

        $.ajax({
            url: '/login/autenticar', // Cambia esto por la URL de tu servidor
            type: 'POST',
            data: formData,
            dataType: 'json', // Indicamos que esperamos una respuesta JSON
            beforeSend: function () {
                $('#loading').show();
            },
            success: function (response) {
                // Verificamos la respuesta
                if (response.success) {
                    toastr.success(response.message, 'Éxito');
                    window.location.href = '/'; // Redirigimos al inicio
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


});

function validarFormulario(formData) {
    // Ejemplo simple:
    const { nombreUsuario, password } = formData.split('&').reduce((obj, item) => {
        const [key, value] = item.split('=');
        obj[key] = value;
        return obj;
    }, {});

    if (nombreUsuario === '' || password === '') {
        toastr.error('Todos los campos son obligatorios', 'Error');
        return false;
    }


    return true;
}
