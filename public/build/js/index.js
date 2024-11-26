$(document).ready(function () {
    navActive();
    // Mostrar el loading cuando se navega fuera de la página
 // Mostrar el loading cuando se navega fuera de la página
  $(window).on('beforeunload', function() {
    $('#loading').show();  // Mostrar el loading
  });

  // Mostrar el loading cuando se hace clic en un enlace
  $('a').on('click', function(event) {
    $('#loading').show();  // Mostrar el loading cuando se hace clic en un enlace
  });

  // Ocultar el loading cuando la página haya terminado de cargar
  $(window).on('load', function() {
    $('#loading').hide();  // Ocultar el loading una vez que la nueva página ha cargado
  });

  // Manejar el botón "Atrás" o "Adelante" en el historial del navegador
  $(window).on('pageshow', function(event) {
    if (event.originalEvent.persisted) {
        // La página se cargó desde el caché (cuando se usa el botón "Atrás")
        $('#loading').hide();  // Asegurarse de ocultar el loading
    }
  });
});


function navActive(){
    var current = '/';
    current += window.location.pathname.split("/").pop();   
    $('.navbar-nav .nav-link').each(function () {        
      if ($(this).attr('href') === current) {                
        $(this).addClass('active');
      }
    });
}


function alertaMensaje(mensaje, tipo){
    if(tipo == 'success'){
        toastr.success(mensaje, 'Éxito');
    }else if(tipo == 'error'){
        toastr.error(mensaje, 'Error');
    }else if(tipo == 'warning'){
        toastr.warning(mensaje, 'Advertencia');
    }else if(tipo == 'info'){
        toastr.info(mensaje, 'Información');
    }
}