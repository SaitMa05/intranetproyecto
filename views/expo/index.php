<h2 class="text-center text-white my-4">Expo Asistencias</h2>
<form class="formLogin rounded-0" id="formExpo" action="/expoasistencia/enviar" method="POST" w-60>
    <div class="mb-3">
        <label for="nombre" class="form-label text-white">Nombre</label>
        <input type="text" class="form-control rounded-0" id="nombre" name="nombre"  placeholder="Ingresa el nombre de la persona" required>
    </div>
    <div class="mb-3">
        <label for="apellido" class="form-label text-white">Apellido</label>
        <input type="text" class="form-control rounded-0" id="apellido" name="apellido"  placeholder="Ingresa el apellido de la persona" required>
    </div>
    <div class="mb-3">
        <label for="edad" class="form-label text-white">Edad</label>
        <input type="text" class="form-control rounded-0" id="edad" name="edad"  placeholder="Ingresa la Edad de la persona" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label text-white">E-Mail</label>
        <input type="email" class="form-control rounded-0" id="email" name="email"  placeholder="Ingresa el Email de la persona (Opcional)">
    </div>
    <div class="mb-3" id="entidades">
        <label class="form-label text-white">Pertenece a:</label>
        <input type="text" class="form-control rounded-0 mb-3" name="escuela" id="escuela" placeholder="Escuela (Opcional)">
        <input type="text" class="form-control rounded-0" name="empresa" id="empresa" placeholder="Empresa (Opcional)">
        <input type="number" class="form-control rounded-0 mt-2" min="0" name="cantidad" id="cantidad" placeholder="Cantidad de personas que vienen con la escuela o la empresa">

        <textarea class="mt-2 form-control" name="info" id="info" placeholder="Informacion Extra (Opcional)"></textarea>
    </div>
    <div id="acompañantes" class="mb-3">
        <label class="form-label text-white">Acompañantes:</label>
        <button type="button" id="btnAcompañante" class="btn btn-blue text-white w-100 rounded-0" onclick="agregarAcompañante()">Añadir Acompañante</button>
    </div>
    <button type="buttom" class="btn btn-orange w-100 rounded-0">Enviar Datos</button>
</form>

<script src="/../build/js/expo/index.js"></script>