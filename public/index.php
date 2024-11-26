<?php
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;

// Controllers
use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\AsistenciasController;
use Controllers\PuertasManejoController;
use Controllers\AdminController;
use Controllers\PuertasController;
use Controllers\ExpoController;
use Controllers\UsuariosController;


$router = new Router();


$router->get('/dashboard', [DashboardController::class,'index']);
$router->get('/login', [LoginController::class, 'login']);
$router->get('/login/bad', [LoginController::class, 'bad']);
$router->get('/registro', [LoginController::class, 'index']);
$router->get('/login/cerrar-sesion', [LoginController::class, 'cs']);
$router->get('/asistencias', [AsistenciasController::class, 'index']);
$router->get('/puertas', [PuertasManejoController::class, 'index']);
$router->get('/admin', [AdminController::class, 'index']);
$router->get('/admin/asistencias', [AdminController::class, 'asistencias']);
$router->get('/resetpassword', [LoginController::class, 'resetPassword']);
$router->get('/resetpasswordreceived', [LoginController::class, 'resetPasswordReceived']);
$router->get('/emailsend', [LoginController::class, 'emailsend']);
$router->get('/admin/puertas', [PuertasController::class, 'index']);
$router->get('/admin/puertas/movimientos', [PuertasController::class, 'movimientos']);
$router->get('/expoasistencia', [ExpoController::class, 'index']);
$router->get('/admin/expo/estadisticas', [ExpoController::class, 'estadisticas']);
$router->get('/admin/expo/personas', [ExpoController::class, 'personas']);
$router->get('/admin/expo/empresas', [ExpoController::class, 'empresas']);
$router->get('/admin/expo/escuelas', [ExpoController::class, 'escuelas']);
$router->get('/admin/usuarios/aceptar', [UsuariosController::class, 'aceptar']);
$router->get('/admin/usuarios/gestion', [UsuariosController::class, 'gestion']);


// Post
$router->post('/registro/crear', [LoginController::class, 'crear']);
$router->post('/login/autenticar', [LoginController::class, 'autenticar']);
$router->post('/asistencias/alumnos', [AsistenciasController::class, 'alumnosPorCurso']);
$router->post('/asistencias/enviar', [AsistenciasController::class, 'enviar']);
$router->post('/puertas/movimiento', [PuertasManejoController::class, 'movimiento']);
$router->post('/puertas/token', [PuertasManejoController::class, 'token']);
$router->post('/resetpassword/enviarEmail', [LoginController::class, 'enviarEmail']);
$router->post('/admin/puertas/crear', [PuertasController::class, 'crear']);
$router->post('/admin/puertas/editar', [PuertasController::class, 'editar']);
$router->post('/admin/puertas/eliminar', [PuertasController::class, 'eliminar']);
$router->post('/expoasistencia/enviar', [ExpoController::class, 'enviar']);
$router->post('/resetpasswordreceived/actualizar', [LoginController::class, 'actualizar']);
$router->post('/admin/usuarios/confirmar', [UsuariosController::class, 'confirmar']);
$router->post('/admin/usuarios/eliminar', [UsuariosController::class, 'eliminar']);
$router->post('/admin/usuarios/editar', [UsuariosController::class, 'editar']);
$router->post('/admin/usuarios/crear', [UsuariosController::class, 'crear']);


$router->comprobarRutas();