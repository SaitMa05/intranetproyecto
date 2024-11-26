    <form class="row g-4 mb-4 formAsistencias">
        <div class="col-md-4">
            <label for="validationDefault01" class="form-label text-white">Rol:</label>
            <p class="form-control" style="font-size: 16x;"><?=$rol?></p>
        </div>
        <div class="col-md-6">
            <label for="validationDefault02" class="form-label text-white">Nombre:</label>
            <p class="form-control" style="font-size: 16px;"><?= $nombre . " " . $apellido?></p>
        </div>
        <!-- <div class="col-md-4">
            <label for="validationDefaultUsername" class="form-label text-white">Fecha:</label>
            <div class="input-group">
                <input type="datetime-local" class="form-control" name="fecha" style="font-size: 16px;" id="validationDefaultUsername" aria-describedby="inputGroupPrepend2" required>
            </div>
        </div> -->
        <div class="col-md-2">
            <label for="cursos" class="form-label text-white">Curso:</label>
            <select class="form-select" id="cursos" name="cursos" required>
                <option selected disabled value="">-- Seleccionar --</option>
                <? if($cursos){ ?>
                    <? foreach($cursos as $curso): ?>
                        <option value="<?= $curso->id?>"><?= $curso->year . " " . $curso->division ?></option>
                    <? endforeach; ?>
                <? }else{ ?>
                    <option value="">No hay cursos disponibles</option>
                <?}?>
            </select>
        </div>
        <!-- <div class="col-12 text-end mb-4">
            <button class="btn btn-orange btnCursos" type="buttom">Seleccionar</button>
        </div> -->
    </form>


    <div class="container table-asistencia p-4 my-4">
        <h2 class="py-4 texto-curso">Alumnos</h2>
        <form action="/asistencias/enviar" method="POST" id="formAsistencia">
            <table id="tablaAsistencias" class="display" style="width:100%">
                <thead class="mb-4">
                    <tr>
                        <th>Nombre</th>
                        <th>Asistencia</th>
                        <th>1/2</th>
                        <th>1/4</th>
                        <th>Tardanza</th>
                    </tr>
                </thead>
                <tbody id="alumnos">
                <br>
                </tbody>
            </table>
            <div class="detalles">
                <h4>Detalles: </h4>
                <textarea name="detalles" id=""></textarea>
            </div>
            <div class="col-12 text-end my-4 px-3">
                <button class="btn btn-orange" type="buttom">Enviar Asistencia</button>
            </div>
        </form>
    </div>


    <div class="modal fade" id="verificacionModal" tabindex="-1" aria-labelledby="verificacionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="verificacionModalLabel">Verificar Asistencia</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Está seguro de que desea enviar esta asistencia?</p>
                <div class="infoModalForm">
                    <h2>Ausentes: </h2>
                    <ul>
                        <li>Alumno 1</li>
                        <li>Alumno 2</li>
                        <li>Alumno</li>
                    </ul>
                    <h3>Detalle:</h3>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati excepturi error reprehenderit unde magni laborum quae cumque illo esse voluptates, sit modi dolorem voluptatibus dicta iure deserunt in sint? Natus!e</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" id="confirmarEnvio" class="btn btn-orange">Confirmar y Enviar</button>
            </div>
        </div>
    </div>
    </div>

    <script src="../build/js/asistencias/index.js"></script>
</main>