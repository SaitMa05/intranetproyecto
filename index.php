<?php
require_once __DIR__ . '/../includes/app.php';

use MVC\Router;

// Controllers
use Controllers\DashboardController;
use Controllers\LoginController;
use Controllers\AsistenciasController;
use Controllers\PuertasManejoController;

$router = new Router();


$router->get('/dashboard', [DashboardController::class,'index']);
$router->get('/login', [LoginController::class, 'login']);
$router->get('/login/bad', [LoginController::class, 'bad']);
$router->get('/registro', [LoginController::class, 'index']);
$router->get('/login/cerrar-sesion', [LoginController::class, 'cs']);
$router->get('/asistencias', [AsistenciasController::class, 'index']);
$router->get('/puertas', [PuertasManejoController::class, 'index']);

// Post
$router->post('/registro/crear', [LoginController::class, 'crear']);
$router->post('/login/autenticar', [LoginController::class, 'autenticar']);


$router->comprobarRutas();