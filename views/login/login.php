
<h2 class="text-center text-white my-4">Iniciar Sesion</h2>
<form class="formLogin rounded-0" id="formLogin" action="/login/autenticar" method="post" w-60>
    <div class="mb-3">
        <label for="userName" class="form-label text-white">Nombre de Usuario o E-Mail</label>
        <input type="text" class="form-control rounded-0" id="nombreUsuario" name="nombreUsuario"  placeholder="Ingresa tu nombre de usuario o E-mail" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label text-white">Contraseña</label>
        <input type="password" class="form-control rounded-0" id="password" name="password" placeholder="Ingresa tu contraseña" required>
    </div>
    <button type="buttom" class="btn btn-orange w-100 rounded-0">Iniciar Sesion</button>
    <div class="password-link  text-end mt-3">
        <a href="/resetpassword" style="font-size: 14px;" class="text-white">Haz olvidado tu contraseña?</a>
    </div>
</form>

<script src="../build/js/login/login.js"></script>