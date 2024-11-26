<main>
    <div class="list-group lista-index">
        <? $rol = $_SESSION['rol'];
        if($rol !== "TEMPORAL"){
        ?>
            <a href="/puertas" class="list-group-item text-center list-group-item-action mb-2">Abrir Puertas</a>
            <a href="/asistencias" class="list-group-item text-center list-group-item-action mb-2">Tomar Asistencias</a>
            <a href="/expoasistencia" class="list-group-item text-center list-group-item-action mb-2">Tomar Asistencias Expo</a>
        <? }else{ ?>
            <a href="/expoasistencia" class="list-group-item text-center list-group-item-action mb-2">Tomar Asistencias Expo</a>
        <? } ?>
    </div>
</main>