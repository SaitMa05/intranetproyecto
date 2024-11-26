<h2 class="text-center text-white mt-4">Registro</h2>
<form class="formLogin rounded-0" id="formRegistro" enctype="multipart/form-data" action="/registro/crear" method="post">
    <div class="mb-3">
        <label for="nombre" class="form-label text-white">Nombre</label>
        <input type="text" class="form-control rounded-0" id="nombre" name="nombre" placeholder="Ingresa tu nombre"
            required>
    </div>
    <div class="mb-3">
        <label for="apellido" class="form-label text-white">Apellido</label>
        <input type="text" class="form-control rounded-0" id="apellido" name="apellido"
            placeholder="Ingresa tu apellido" required>
    </div>
    <div class="mb-3">
        <label for="userName" class="form-label text-white">Nombre de Usuario</label>
        <input type="text" class="form-control rounded-0" id="userName" name="nombreUsuario"
            placeholder="Ingresa tu nombre de usuario" required>
    </div>
    <div class="mb-3">
        <label for="dni" class="form-label text-white">DNI</label>
        <input type="text" class="form-control rounded-0" id="dni" name="dni" placeholder="Ingresa tu DNI" required>
    </div>
    <div class="mb-3">
        <label for="telefono" class="form-label text-white">Teléfono</label>
        <input type="tel" class="form-control rounded-0" id="telefono" name="telefono" placeholder="Ingresa tu teléfono"
            required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label text-white">Email</label>
        <input type="email" class="form-control rounded-0" id="email" name="email" placeholder="Ingresa tu email"
            required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label text-white">Contraseña</label>
        <input type="password" class="form-control rounded-0" id="password" name="password"
            placeholder="Ingresa tu contraseña" required>
    </div>
    <div class="mb-3">
        <label for="confirmarPassword" class="form-label text-white">Confirmar Contraseña</label>
        <input type="password" class="form-control rounded-0" id="passwordConfirm" name="passwordConfirm"
            placeholder="Confirma tu contraseña" required>
    </div>
    <div class="mb-3">
        <label for="dni1" class="form-label text-white">Foto del Dni por Delante</label>
        <input type="file" class="form-control rounded-0" id="dni1" name="dni1" accept="image/*" required>
    </div>
    <div class="mb-3">
        <label for="dni2" class="form-label text-white">Foto del Dni por Atrás</label>
        <input type="file" class="form-control rounded-0" id="dni2" name="dni2" accept="image/*" required>
    </div>
    <div class="mb-3">
        <label for="dni3" class="form-label text-white">Foto de usted con el DNI</label>
        <input type="file" class="form-control rounded-0" id="dni3" name="dni3" accept="image/*" required>
    </div>

     <div class="mb-3">
        <label for="fkRol" class="form-label text-white">Rol de la Escuela:</label>
        <select class="form-select rounded-0" style="" name="fkRol" id="fkRol">
            <option value="" disabled selected> -- Seleccionar --</option>
            <?php foreach ($rolsArray as $rol): ?>
                <?php if ($rol['nombre'] !== "ROOT"): ?>
                    <option value="<?= $rol['id'] ?>"><?= $rol['nombre'] ?></option>
                <?php endif; ?>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-orange w-100 rounded-0">Registrarse</button>
</form>

<script src="../build/js/login/registro.js"></script>