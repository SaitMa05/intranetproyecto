<!-- <h2 class="text-center text-white my-4">Coloque su email para recuperar su usuario</h2> -->
<form class="formLogin rounded-0" id="formResetPasswordReceived" action="/resetpasswordreceived/actualizar" method="POST" w-60>
    <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token']); ?>">
    <div class="mb-3">
        <label for="password" class="form-label text-white">Contraseña</label>
        <input type="password" class="form-control rounded-0" id="password" name="password"  placeholder="Ingresa tu nueva Contraseña" required>
    </div>
    <div class="mb-3">
        <label for="passwordConfirm" class="form-label text-white">Confirmar Contraseña</label>
        <input type="password" class="form-control rounded-0" id="passwordConfirm"  placeholder="Confirma tu nueva Contraseña" >
    </div>
    <button type="buttom" class="btn btn-orange w-100 rounded-0">Enviar</button>
</form>

<script src="../build/js/login/resetpasswordreceived.js"></script>