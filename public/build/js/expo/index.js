$(document).ready(function () {

    $('#formExpo').submit(function (e) {
        e.preventDefault();


        let formData = $(this).serialize();
        if (!validarFormulario(formData)) {
            return;
        }

        $.ajax({
            url: 'expoasistencia/enviar',
            type: 'POST',
            data: formData,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    toastr.success(response.message, 'Éxito');
                    resetForm();
                    limpiarCampos();
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error('Error al enviar los datos:', textStatus, errorThrown);
            }
        });
    });


    function resetForm() {
        $('#formExpo')[0].reset();
        $('#escuela, #empresa').prop('disabled', false); // Rehabilita ambos campos
        $('#cantidad').prop('disabled', true);
        $('#info').prop('disabled', true);
        $('#acompañantes').show();
    }

    function validarFormulario(formData) {
        const parsedData = formData.split('&').reduce((obj, item) => {
            const [key, value] = item.split('=').map(decodeURIComponent);
            if (key.includes('acompañantes')) {
                const match = key.match(/acompañantes\[(\d+)\]\[nombre\]/);
                if (match) {
                    const index = match[1];
                    if (!obj['acompañantes']) obj['acompañantes'] = [];
                    obj['acompañantes'][index] = value.trim();
                }
            } else {
                obj[key] = value.trim();
            }
            return obj;
        }, {});
    
        const { nombre, apellido, edad, escuela, empresa, cantidad, info, acompañantes } = parsedData;
    
        // Validaciones básicas
        if (!nombre) {
            toastr.error('El campo de Nombre es obligatorio', 'Error');
            return false;
        }
        if (!apellido) {
            toastr.error('El campo de Apellido es obligatorio', 'Error');
            return false;
        }
        if (!edad || isNaN(edad) || edad <= 0) {
            toastr.error('El campo de Edad es obligatorio y debe ser un número mayor a 0', 'Error');
            return false;
        }
    
        // Validación de acompañantes
        if (acompañantes && acompañantes.length > 0) {
            if (acompañantes.some(a => a === '')) {
                toastr.error('No puede haber campos vacíos en los acompañantes', 'Error');
                return false;
            }
        }
    
        // Validación de que solo uno de los campos, escuela o empresa, tenga valor
        if (escuela && escuela.trim() !== '' && empresa && empresa.trim() !== '') {
            toastr.error('Solo uno de los campos Escuela o Empresa puede tener valor, no ambos.', 'Error');
            return false;
        }
    
        // Validación para mostrar alerta si no hay valor en escuela ni empresa pero se usa info
        if ((!escuela || escuela.trim() === '') && (!empresa || empresa.trim() === '') && info && info.trim() !== '') {
            toastr.error('El campo Info solo se puede usar si hay valores en Escuela o Empresa.', 'Error');
            return false;
        }
    
        // Validación de cantidad si escuela o empresa tienen valor
        if ((escuela && escuela.trim() !== '') || (empresa && empresa.trim() !== '')) {
            if (!cantidad || isNaN(cantidad) || cantidad <= 0) {
                toastr.error('El campo de Cantidad es obligatorio si hay Escuela o Empresa', 'Error');
                return false;
            }
        }
    
        return true;
    }
    
    
    $('#cantidad').prop('disabled', true);
    $('#info').prop('disabled', true);


    $('#escuela, #empresa').on('input', function () {

        const escuelaValue = $('#escuela').val().trim();
        const empresaValue = $('#empresa').val().trim();

        if (escuelaValue !== '' || empresaValue !== '') {
            $('#acompañantes').hide(); // Oculta el botón si hay valor en escuela o empresa
            $('#cantidad').prop('disabled', false);
            $('#info').prop('disabled', false);
        } else {
            $('#acompañantes').show(); // Muestra el botón si ambos están vacíos
            $('#cantidad').prop('disabled', true);
            $('#info').prop('disabled', true);
        }
    });
    $('#escuela').on('input', function () {
        if ($(this).val().trim() !== '') {
            $('#empresa').prop('disabled', true); // Deshabilita empresa si escuela tiene contenido
        } else {
            $('#empresa').prop('disabled', false); // Habilita empresa si escuela está vacía
        }
    });

    $('#empresa').on('input', function () {
        if ($(this).val().trim() !== '') {
            $('#escuela').prop('disabled', true); // Deshabilita escuela si empresa tiene contenido
        } else {
            $('#escuela').prop('disabled', false); // Habilita escuela si empresa está vacía
        }
    });

})



let contador = 0; // Inicializa el contador

function agregarAcompañante() {
    const div = document.createElement('div');
    div.setAttribute('id', `acompañante-${contador}`);

    div.innerHTML = `
        <input type="text" class="form-control mt-2 rounded-0" name="acompañantes[${contador}][nombre]" placeholder="Nombre Completo del acompañante">
        <button type="button" class="btn btn-danger mt-2 rounded-0" onclick="eliminarAcompañante(${contador})">Eliminar</button>
    `;

    document.getElementById('acompañantes').appendChild(div);
    contador++;

    // Deshabilitar los campos de escuela y empresa
    $('#escuela, #empresa').prop('disabled', true);
}

function eliminarAcompañante(id) {
    const div = document.getElementById(`acompañante-${id}`);
    if (div) {
        div.remove();
        contador--;
    }

    // Habilitar los campos de escuela y empresa si no hay acompañantes
    if (contador === 0) {
        $('#escuela, #empresa').prop('disabled', false);
    }
}
function limpiarCampos() {
    document.getElementById('acompañantes').innerHTML = `
        <label class="form-label text-white">Acompañantes:</label>
        <button type="button" class="btn btn-blue text-white w-100 rounded-0" onclick="agregarAcompañante()">Añadir Acompañante</button>
    `;
    contador = 0;
}

