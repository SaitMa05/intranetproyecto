


const options = {
  username: "hivemq.webclient.1725757864399", // Cambia por tu usuario de HiveMQ Cloud
  password: "9g1qsZ,O0<3.FhRlSd&H", // Cambia por tu contraseña de HiveMQ Cloud
  clean: true,
  reconnectPeriod: 1000, // Intentar reconectar cada 1 segundo si se desconecta
  keepalive: 300,
  connectTimeout: 30 * 1000,
};


// Conectar al broker HiveMQ Cloud usando WebSockets
const client = mqtt.connect(
  "wss://ca7f50d185c8456b9e0c8949c05e0030.s1.eu.hivemq.cloud:8884/mqtt",
  options
);

// Evento al conectar al broker MQTT
client.on("connect", function () {
  let MQTTConectado = true;
  // console.log('Conectado a HiveMQ Cloud');
  const MQTTConnected = new CustomEvent('MQTTConectado', { detail: MQTTConectado });
  window.dispatchEvent(MQTTConnected);

  // Suscribirse al tema (opcional, puedes suscribirte si necesitas recibir mensajes también)
  client.subscribe("mi/tema", function (err) {
    if (!err) {
      console.log("Suscrito al tema mi/tema");
    } else {
      console.error("Error al suscribirse:", err);
    }
  });
});

window.addEventListener('dataSent', function(event) {
    const receivedData = event.detail;
    if (client.connected) {
        client.publish("mi/tema", receivedData);       
        console.log('Mensaje enviado:', receivedData);
        
    }
});


// Manejar errores de conexión
client.on("error", function (err) {
  console.error("Error de conexión:", err);
});

