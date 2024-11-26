<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="icon" href="../../build/img/logo.avif">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <title><?= $titulo ?? 'E.E.S.T N1' ?></title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="../../build/css/app.css">
    <!-- <link rel="stylesheet" href="../../build/css/app.css"> -->
</head>

<body class="p-3 m-0 border-0 bd-example m-0 border-0">

    <nav class="navbar navbar-dark p-0">
        <div class="container-fluid">
            <a class="navbar-brand" href="/"><img width="60" height="60" src="../../build/img/logo.png" alt="Logo"> E.E.S.T
                N1</a>
            <button class="navbar-toggler menu" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasDarkNavbar"
                aria-labelledby="offcanvasDarkNavbarLabel">

                <? if (isset($_SESSION['login'])): ?>
                    <a class="text-decoration-none" href="">
                        <div class="offcanvas-header gap-2">
                            <img src="https://letsenhance.io/static/8f5e523ee6b2479e26ecc91b9c25261e/1015f/MainAfter.jpg"
                                class="object-fit-cover align-self-start mr-3 rounded-circle" alt="User Avatar" width="60"
                                height="60">
                            <div class="media-body">
                                <h6 class="m-0 text-white"> <?= $nombre . " " . $apellido ?> </h6>
                                <div>
                                    <p class="m-0 text-white" style="font-size: 12px;"><?= $email ?></p>
                                </div>
                            </div>
                        </div>
                    </a>
                <? endif; ?>

                <div class="offcanvas-header">
                    <h5 class="offcanvas-title text-white" id="offcanvasDarkNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <hr class="text-white">
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <? if (!isset($_SESSION['login'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="/registro">Registro</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/login">Login</a>
                            </li>
                        <? endif; ?>

                        <? if (isset($_SESSION['login'])): ?>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/">Inicio</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/">Perfil</a>
                            </li>
                            <?
                                $rol = $_SESSION['rol'];
                                if ($rol === 'administrador' || $rol === 'directivo' || $rol === 'ROOT'):
                                ?>
                                <li class="nav-item">
                                    <a class="nav-link" aria-current="page" href="/admin">Administracion</a>
                                </li>
                            <? endif; ?>
                            <li class="nav-item">
                                <a class="nav-link" aria-current="page" href="/login/cerrar-sesion">Cerrar Sesion</a>
                            </li>
                        <? endif; ?>
                        </form>
                </div>
            </div>
        </div>
    </nav>
    <hr class="line-nav">

    <div id="loading" style="display: none;">
        <div class="spinner"></div>
    </div>

    <div class="admin-page">
        <div class="admin-cont-page">

            <div class="sidebar">
                <a class="dashboard-menu" href="/admin">
                    <div class="menu-item" data-target="#puertasSubMenu">
                        <i class="fas fa-door-open"></i> Dashboard
                    </div>
                </a>
                <!-- Movimientos -->
                <div class="menu-item dropdown-toggle" data-toggle="collapse" data-target="#puertasSubMenu">
                    <i class="fas fa-door-open"></i> Puertas
                </div>
                <div class="collapse" id="puertasSubMenu">
                    <a class="dropdown-item" href="/admin/puertas">Gestionar Puertas</a>
                    <a class="dropdown-item" href="/admin/puertas/movimientos">Movimientos</a>
                </div>

                <!-- Dashboard -->
                <div class="menu-item dropdown-toggle" data-toggle="collapse" data-target="#asistenciasSubMenu">
                    <i class="fas fa-user-check"></i> Asistencias
                </div>
                <div class="collapse" id="asistenciasSubMenu">
                    <a class="dropdown-item" href="/admin/asistencias">Gestionar Alumnos</a>
                    <a class="dropdown-item" href="">Pendientes</a>
                    <a class="dropdown-item" href="">Ver asistencias</a>
                </div>

                <!-- Configuraciones -->
                <div class="menu-item dropdown-toggle" data-toggle="collapse" data-target="#configSubmenu">
                    <i class="fas fa-cog"></i> Configuraciones
                </div>
                <div class="collapse" id="configSubmenu">
                    <p>Aun no hay nada</p>
                </div>

                <div class="menu-item dropdown-toggle" data-toggle="collapse" data-target="#expoSubMenu">
                    <i class="fas fa-flask"></i> Exposicion
                </div>
                <div class="collapse" id="expoSubMenu">
                    <a class="dropdown-item" href="/admin/expo/estadisticas">Estadisticas</a>
                    <a class="dropdown-item" href="/admin/expo/personas">Personas que Asistieron</a>
                    <a class="dropdown-item" href="/admin/expo/empresas">Empresas que Asistieron</a>
                    <a class="dropdown-item" href="/admin/expo/escuelas">Escuelas que Asistieron</a>
                </div>

                <!-- Usuarios -->
                <div class="menu-item dropdown-toggle" data-toggle="collapse" data-target="#usuariosSubmenu">
                    <i class="fas fa-user"></i> Usuarios
                </div>
                <div class="collapse" id="usuariosSubmenu">
                    <!-- <a class="dropdown-item" href="">Nuevo Usuario</a> -->
                    <a class="dropdown-item" href="/admin/usuarios/gestion">Gestión de Usuarios</a>
                    <a class="dropdown-item" href="/admin/usuarios/aceptar">Aceptar Usuarios</a>
                    <a class="dropdown-item" href="">Gestión de Rols</a>
                </div>
            </div>

            <div class="paginado">
                <main>
                    <?= $contenidoAdmin ?>
                </main>
            </div>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../build/js/index.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>