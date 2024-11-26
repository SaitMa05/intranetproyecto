$(document).ready(function () {

  $(".paginado").addClass("estadisticas");

  obtenerTipoPersonas();
  horarioPico();
  personasSolas();
  edadPromedio();
  edadMasAlta();

  function obtenerTipoPersonas() {
    // console.log(Chart.version);
    $.ajax({
      url: '/admin/expo/estadisticas',
      method: 'GET',
      dataType: 'json',
      beforeSend: function() {
        $('#loading').show(); // Mostrar el spinner
      },
      success: function (response) {
        // console.log(response);

        const filteredData = response['tiposPersonas'].filter(item => item.tipo !== 'total_general');

        // Creamos los arrays para labels y datos
        const labels = filteredData.map(item => item.tipo);
        const data = filteredData.map(item => parseInt(item.total, 10)); // Convertimos los totales a números
        const chartData = {
          labels: labels, // ['personas', 'empresa', 'escuela']
          datasets: [{
            data: data, // [4, 92, 41]
            backgroundColor: ['#FF6384', '#36A2EB', '#FF9100'], // Colores para cada categoría
            color: 'white'
          }]
        };
        var ctx = document.getElementById('tiposPersonas').getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'doughnut',
          data: chartData,
          options: {
            responsive: false,
            plugins: {
              legend: {
                display: true,
                labels: {
                  color: 'white', // Cambia el color del texto de las etiquetas
                }
              }
            }
          }
        });
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error('Error al obtener los datos:', textStatus, errorThrown);
      },
      complete: function() {
        $('#loading').hide(); // Ocultar el spinner una vez que se completa la solicitud
      }
    });
  }
  function horarioPico() {
    // console.log(Chart.version);
    $.ajax({
      url: '/admin/expo/estadisticas',
      method: 'GET',
      dataType: 'json',
      beforeSend: function() {
        $('#loading').show(); // Mostrar el spinner
      },
      success: function (response) {
        const horarioPicoData = response['horarioPico'];

        // Crear arrays para etiquetas y datos
        const labels = horarioPicoData.map(item => item.hora); // Etiquetas son las horas
        const data = horarioPicoData.map(item => parseInt(item.totalPersonas, 10)); // Datos son el total de personas

        const chartData = {
          labels: labels, // ['2024-11-16 16:00:00', '2024-11-16 19:00:00', '2024-11-16 20:00:00']
          datasets: [{
            label: 'Personas por horario',
            data: data, // [341, 548, 31]
            backgroundColor: '#FF9100', // Color con opacidad para la línea
            borderColor: '#FF9100',
            borderWidth: 2,
            tension: 0.3 // Suavizar la línea
          }]
        };

        var ctx = document.getElementById('horarioPico').getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'line',
          data: chartData,
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: true,
                labels: {
                  color: 'white', // Cambiar color del texto en leyenda
                }
              }
            },
            scales: {
              x: {
                ticks: {
                  color: 'white' // Cambiar color de etiquetas eje X
                }
              },
              y: {
                ticks: {
                  color: 'white' // Cambiar color de etiquetas eje Y
                }
              }
            }
          }
        });
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error('Error al obtener los datos:', textStatus, errorThrown);
      },
      complete: function() {
        $('#loading').hide(); // Ocultar el spinner una vez que se completa la solicitud
      }
    });
  }
  function personasSolas(){
    // console.log(Chart.version);
    $.ajax({
      url: '/admin/expo/estadisticas',
      method: 'GET',
      dataType: 'json',
      beforeSend: function() {
        $('#loading').show(); // Mostrar el spinner
      },
      success: function (response) {

        let personasSolas = parseInt(response['personasSolas'][0]['personasSolasData'], 10);
        let personasConAcompanantes = parseInt(response['personasSolas'][0]['personasConAcompanantes'], 10);
        
          const data = [
            personasSolas,
            personasConAcompanantes
        ];
        // console.log(data);
        
        
        const chartData = {
          labels: ['Personas Solas', 'Personas con Acompañantes'], // Etiquetas para la gráfica
          datasets: [{
              data: data,
              backgroundColor: ['#FF6384', '#36A2EB'], // Colores para las barras
          }]
      };
      
        var ctx = document.getElementById('personasSolas').getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'doughnut',
          data: chartData,
          options: {
            responsive: false,
            plugins: {
              legend: {
                display: true,
                labels: {
                  color: 'white', // Cambia el color del texto de las etiquetas
                }
              }
            }
          }
        });
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error('Error al obtener los datos:', textStatus, errorThrown);
      },
      complete: function() {
        $('#loading').hide(); // Ocultar el spinner una vez que se completa la solicitud
      }
    });
  }
  function edadPromedio() {
    // console.log(Chart.version);
    $.ajax({
      url: '/admin/expo/estadisticas',
      method: 'GET',
      dataType: 'json',
      beforeSend: function() {
        $('#loading').show(); // Mostrar el spinner
      },
      success: function (response) {
        const personasEdadData = response['personasEdad'];        

        // Crear arrays para etiquetas y datos
        const labels = personasEdadData.map(item => item.rangoEdad); // Etiquetas son las horas
        const data = personasEdadData.map(item => parseInt(item.totalPersonas, 10)); // Datos son el total de personas

        const chartData = {
          labels: labels, // ['2024-11-16 16:00:00', '2024-11-16 19:00:00', '2024-11-16 20:00:00']
          datasets: [{
            label: 'Personas por rango de edad',
            data: data, // [341, 548, 31]
            backgroundColor: '#FF9100', // Color con opacidad para la línea
            borderColor: '#FF9100',
            borderWidth: 2,
            tension: 0.3 // Suavizar la línea
          }]
        };

        var ctx = document.getElementById('personasEdad').getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'line',
          data: chartData,
          options: {
            responsive: true,
            plugins: {
              legend: {
                display: true,
                labels: {
                  color: 'white', // Cambiar color del texto en leyenda
                }
              }
            },
            scales: {
              x: {
                ticks: {
                  color: 'white' // Cambiar color de etiquetas eje X
                }
              },
              y: {
                ticks: {
                  color: 'white' // Cambiar color de etiquetas eje Y
                }
              }
            }
          }
        });
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error('Error al obtener los datos:', textStatus, errorThrown);
      },
      complete: function() {
        $('#loading').hide(); // Ocultar el spinner una vez que se completa la solicitud
      }
    });
  }
  function edadMasAlta(){
    $.ajax({
      url: '/admin/expo/estadisticas',
      method: 'GET',
      dataType: 'json',
      beforeSend: function() {
        $('#loading').show(); // Mostrar el spinner
      },
      success: function (response) {
        console.log(response['edades']);
        
        const filteredData = response['edades']
        
        // Creamos los arrays para labels y datos
        const labels = filteredData.map(item => item.edad);
        const data = filteredData.map(item => parseInt(item.totalPersonas, 10)); // Convierte el total a números
        
        console.log(labels);
        const chartData = {
          labels: labels,
          datasets: [{
            label: 'Edades',
            data: data, // [4, 92, 41]
            backgroundColor: '#FF9100', // Colores para cada categoría
            borderColor: 'gray',
            borderWidth: 1,
            color: 'white'
          }]
        };
        var ctx = document.getElementById('edadesTodas').getContext('2d');
        var myChart = new Chart(ctx, {
          type: 'bar',
          data: chartData,
          options: {
            responsive: false,
            scales:{
              x: {
                ticks: {
                  color: 'white' // Cambiar color de etiquetas eje X
                }
              },
              y: {
                ticks: {
                  color: 'white' // Cambiar color de etiquetas eje Y
                }
              }
            },
            plugins: {
              legend: {
                display: true,
                labels: {
                  color: 'white', // Cambia el color del texto de las etiquetas
                }
              }
            }
          }
        });
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error('Error al obtener los datos:', textStatus, errorThrown);
      },
      complete: function() {
        $('#loading').hide(); // Ocultar el spinner una vez que se completa la solicitud
      }
    });
  }

});

