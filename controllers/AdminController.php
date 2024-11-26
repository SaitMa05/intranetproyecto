<?php
namespace Controllers;
use Controller;
use MVC\Router;

class AdminController{


    public static function index(Router $router){
        iniciarSession();
        adminSession();

        $nombre = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
        $email = $_SESSION['email'];
        $titulo = "Administración";

        $router->renderAdmin('admin/index', [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'titulo' => $titulo
        ]);
    }

    public static function asistencias(Router $router){
        iniciarSession();


        $nombre = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
        $email = $_SESSION['email'];
        $titulo = "Administración";

        $router->renderAdmin('admin/asistencias', [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'titulo' => $titulo
        ]);
    }



}