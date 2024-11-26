<h2 class="text-center text-white my-4">Coloque su email para recuperar su usuario</h2>
<form class="formLogin rounded-0" id="formResetPassword" action="/resetpassword/enviarEmail" method="post" w-60>
    <div class="mb-3">
        <label for="userName" class="form-label text-white">E-Mail</label>
        <input type="text" class="form-control rounded-0" id="email" name="email"  placeholder="Ingresa tu nombre de usuario o E-mail" required>
    </div>
    <button type="buttom" class="btn btn-orange w-100 rounded-0">Enviar</button>
</form>

<script src="../build/js/login/resetpassword.js"></script>
