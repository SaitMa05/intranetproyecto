<div class="table-puertas p-4">
    <div class="cont-table-puerta">
        <div class="cont-puertas">
            <h2 class="py-2">Listado de Usuarios Por Aceptar</h2>
        </div>
    </div>

    <table id="tablaUsuariosAceptar" class="display" style="width:100%">
        <thead class="mb-4">
            <tr>
                <th>Nombre</th>
                <th>D.N.I</th>
                <th>Fecha de Creacion</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="usuarios-listar">
            <br>
        </tbody>
    </table>
</div>

<div class="modal fade" id="verificacionModal" tabindex="-1" aria-labelledby="verificacionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verificacionModalLabel">Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/admin/usuarios/confirmar" class="formAceptar" method="POST">
                <input type="hidden" name="id" id="usuario-id">
                <input type="hidden" name="email" id="usuario-email-form">
                <div class="mb-3 text-start">
                    <h4>Nombre:</h4>
                    <p id="usuario-nombre"></p>
                </div>
                <div class="mb-3 text-start">
                    <h4>Nombre de Usuario:</h4>
                    <p id="usuario-nombreUsuario"></p>
                </div>
                <div class="mb-3 text-start">
                    <h4>D.N.I:</h4>
                    <p id="usuario-dni"></p>
                </div>
                <div class="mb-3 text-start">
                    <h4>Telefono:</h4>
                    <p id="usuario-telefono"></p>
                </div>
                <div class="mb-3 text-start">
                    <h4>E-Mail:</h4>
                    <p id="usuario-email"></p>
                </div>
                <div class="mb-3 text-start">
                    <h4>Rol:</h4>
                    <p id="usuario-nombrerol"></p>
                </div>
                <div class="mb-3 text-start">
                    <h4>D.N.I Imagens:</h4>
                    <img class="mb-2" src="" width="300" id="usuario-dni1" alt="">
                    <img class="mb-2" src="" width="300" id="usuario-dni2" alt="">
                    <img class="mb-2" src="" width="300" id="usuario-dni3" alt="">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="confirmarEliminar">Eliminar Usuario</button>
                <button type="submit" id="confirmarEnvioAceptar" class="btn btn-orange">Aceptar Usuario</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script src="../../build/js/admin/usuarios/aceptar.js"></script>
