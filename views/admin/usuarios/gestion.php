<div class="table-puertas p-4">
    <div class="cont-table-puerta">
        <div class="cont-puertas">
            <h2 class="py-2">Gestion de Usuarios</h2>
            <button class="btn btnCrear text-start btn-orange btn-sm">
                <i title="Crear" id="btnCrear" class="bi bi-pencil">Crear nuevo Usuario</i>
            </button>
        </div>
    </div>

    <table id="tablaUsuariosGestion" class="display" style="width:100%">
        <thead class="mb-4">
            <tr>
                <th>Nombre</th>
                <th>Nombre de Usuario</th>
                <th>D.N.I</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Rol</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="usuarios-listar">
            <br>
        </tbody>
    </table>
</div>

<div class="modal fade" id="verificacionModalEditar" tabindex="-1" aria-labelledby="verificacionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verificacionModalLabel">Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/admin/usuarios/editar" class="formEditar" method="POST">
                    <input type="hidden" name="id" id="usuario-id">
                    <div class="mb-3 text-start">
                        <h4>Nombre:</h4>
                        <input type="text" class="form-control form-control rounded-0" id="usuario-nombre" name="nombre" class="form-control">
                    </div>
                    <div class="mb-3 text-start">
                        <h4>Apellido:</h4>
                        <input type="text" class="form-control form-control rounded-0" id="usuario-apellido" name="apellido" class="form-control">
                    </div>
                    <div class="mb-3 text-start">
                        <h4>Nombre de Usuario:</h4>
                        <input type="text" class="form-control form-control rounded-0" id="usuario-nombreUsuario" name="nombreUsuario" class="form-control">
                    </div>
                    <div class="mb-3 text-start">
                        <h4>D.N.I:</h4>
                        <input type="text" class="form-control form-control rounded-0" id="usuario-dni" name="dni" class="form-control">
                    </div>
                    <div class="mb-3 text-start">
                        <h4>Telefono:</h4>
                        <input type="text" class="form-control form-control rounded-0" id="usuario-telefono" name="telefono" class="form-control">
                    </div>
                    <div class="mb-3 text-start">
                        <h4>E-Mail:</h4>
                        <input type="email" class="form-control form-control rounded-0" id="usuario-email" name="email" class="form-control">
                    </div>
                    <div class="mb-3 text-start">
                        <h4>Rol:</h4>
                        <select name="rol" class="form-select rounded-0" id="rol-select">
                            <option value=""></option>
                            <?php foreach ($rolsArray as $rol): ?>
                                <?php if ($rol['nombre'] !== "ROOT"): ?>
                                    <option value="<?= $rol['id'] ?>"><?= $rol['nombre'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" id="confirmarEnvioEditar" class="btn btn-orange">Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="verificacionModalCrear" tabindex="-1" aria-labelledby="verificacionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verificacionModalLabel">Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/admin/usuarios/crear" class="formCrear" enctype="multipart/form-data"  method="POST">
                    <input type="hidden" name="id" id="usuario-id">
                    <div class="mb-3 text-start">
                        <h4>Nombre:</h4>
                        <input type="text" class="form-control form-control rounded-0" id="usuario-nombre" name="nombre" class="form-control">
                    </div>
                    <div class="mb-3 text-start">
                        <h4>Apellido:</h4>
                        <input type="text" class="form-control form-control rounded-0" id="usuario-apellido" name="apellido" class="form-control">
                    </div>
                    <div class="mb-3 text-start">
                        <h4>Nombre de Usuario:</h4>
                        <input type="text" class="form-control form-control rounded-0" id="usuario-nombreUsuario" name="nombreUsuario" class="form-control">
                    </div>
                    <div class="mb-3 text-start">
                        <h4>D.N.I:</h4>
                        <input type="text" class="form-control form-control rounded-0" id="usuario-dni" name="dni" class="form-control">
                    </div>
                    <div class="mb-3 text-start">
                        <h4>Telefono:</h4>
                        <input type="text" class="form-control form-control rounded-0" id="usuario-telefono" name="telefono" class="form-control">
                    </div>
                    <div class="mb-3 text-start">
                        <h4>E-Mail:</h4>
                        <input type="email" class="form-control form-control rounded-0" id="usuario-email" name="email" class="form-control">
                    </div>
                    <div class="mb-3 text-start">
                        <h4>Contrasena:</h4>
                        <input type="password" class="form-control form-control rounded-0" id="usuario-password" name="password" class="form-control">
                    </div>
                    <div class="mb-3 text-start">
                        <h4>Confirmar Contrasena:</h4>
                        <input type="password" class="form-control form-control rounded-0" id="usuario-passwordConfirm" name="passwordConfirm" class="form-control">
                    </div>
                    <div class="mb-3 text-start">
                        <h4>Rol:</h4>
                        <select name="rol" class="form-select rounded-0" id="rol-select">
                            <option value=""></option>
                            <?php foreach ($rolsArray as $rol): ?>
                                <?php if ($rol['nombre'] !== "ROOT"): ?>
                                    <option value="<?= $rol['id'] ?>"><?= $rol['nombre'] ?></option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" id="confirmarEnvioCrear" class="btn btn-orange">Crear</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script src="../../build/js/admin/usuarios/gestion.js"></script>