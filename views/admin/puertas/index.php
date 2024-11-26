<div class="table-puertas p-4">
    <div class="cont-table-puerta">
        <div class="cont-puertas">
            <h2 class="py-2">Listado de Puertas</h2>
            <button class="btn btnCrear text-start btn-orange btn-sm">
                <i title="Crear" id="btnCrear" class="bi bi-pencil">Crear Nueva Puerta</i>
            </button>
        </div>
    </div>

    <table id="tablaPuertas" class="display" style="width:100%">
        <thead class="mb-4">
            <tr>
                <th>Nombre</th>
                <th></th>
            </tr>
        </thead>
        <tbody id="puertas-admin">
            <br>
            <!-- <tr>
                <td class="text-start"></td>
                <td>
                    <div class="d-flex justify-content-center gap-2">
                        <button class="btn btn-orange btn-sm">
                            <i title="Editar" class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-danger btn-sm">
                            <i title="Eliminar" class="bi bi-trash"></i>
                        </button>
                    </div>
                </td>
            </tr> -->
        </tbody>
    </table>
</div>


<div class="modal fade" id="verificacionModalEditar" tabindex="-1" aria-labelledby="verificacionModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verificacionModalLabel">Editar Puerta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="puerta-nombre">Editar Puerta</p>
                <form action="/admin/puertas/editar" class="formEditar" method="POST">
                <input type="hidden" name="id" id="puerta-id">
                <div class="mb-3">
                    <label for="puerta-nombre" class="form-label">Editar nombre de la puerta</label>
                    <input type="text" class="form-control form-control rounded-0" name="nombre" id="puerta-nombre"
                        placeholder="Cambiar el nombre de la puerta">
                </div>

                <div class="mb-3">
                    <label for="puerta-descripcion" class="form-label">Editar descripción de la puerta</label>
                    <input type="text" class="form-control form-control rounded-0" name="descripcion" id="puerta-descripcion"
                        placeholder="Cambiar la descripción de la puerta">
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
                <h5 class="modal-title" id="verificacionModalLabel">Crear Puerta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Crear Puerta</p>
                
                <form action="/admin/puertas/crear" class="formCrear" method="POST">
                    <div class="mb-3">
                        <label for="puerta-nombre" class="form-label">Nombre de la Puerta</label>
                        <input type="text" class="form-control form-control rounded-0" name="nombre" id="puerta-nombre"
                            placeholder="Cambiar el nombre de la puerta">
                    </div>

                    <div class="mb-3">
                        <label for="puerta-descripcion" class="form-label">Descripcion de la Puerta</label>
                        <input type="text" class="form-control form-control rounded-0" name="descripcion" id="puerta-descripcion"
                            placeholder="Cambiar la descripción de la puerta">
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" id="confirmarEnvioCrear" class="btn btn-orange">Crear</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="../build/js/admin/puertas/index.js"></script>