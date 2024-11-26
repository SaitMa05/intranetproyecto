alert("Hola")
$(document).ready(function () {
    var current = window.location.pathname.split("/").pop();
    $('nav ul li a').each(function () {
      if ($(this).attr('href') === current) {
        $(this).parent().addClass('active');
      }
    });
});
