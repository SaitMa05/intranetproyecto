<?php


define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');


function incluirTemplate( string  $nombre, bool $inicio = false ) {
    include TEMPLATES_URL . "/$nombre.php"; 
}

function estaAutenticado() {
    session_start();

    if(!$_SESSION['login']) {
        header('Location: /');
    }
}



function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}


function iniciarSession() {
    session_start();
    if(isset($_SESSION['login'])) {
        $auth = $_SESSION['login'];
        if(!$auth) {
            header('Location: /login');
        }
    }else{
        header('Location: /login');
    }
}

function adminSession() {
    if (isset($_SESSION['rol'])) {
        $rol = $_SESSION['rol'];
        
        if ($rol === 'administrador' || $rol === 'directivo' || $rol === 'ROOT') {
            // Acceso permitido
            return true;
        } else {
            header("Location: /login");
            exit;
        }
    } else {
        header("Location: /login");
        exit;
    }
}



function loginOn() {
    session_start();
    if(isset($_SESSION['login'])) {
        header('Location: /');
    }
}
