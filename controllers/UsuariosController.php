<?php

namespace Controllers;
use MVC\Router;
use Model\LoginModel;
use Model\EmailModel;

class UsuariosController{
    public static function aceptar(Router $router)
    {
        iniciarSession();
        adminSession();

        $nombre = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
        $email = $_SESSION['email'];
        $titulo = "Aceptar Usuarios";

        $usuariosModel = new LoginModel();
        $usuarios = $usuariosModel->obtenerNoAceptados(); 
        $usuariosArray = [];

        // Asociar los movimientos con las puertas
        foreach ($usuarios as $usuario) {
            $usuarioData = [ // Cambiar el nombre de la variable para claridad
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'apellido' => $usuario->apellido,
                'nombreUsuario' => $usuario->nombreUsuario,
                'dni' => $usuario->dni,
                'telefono' => $usuario->telefono,
                'email' => $usuario->email,
                'fechaCreacion' => $usuario->fechaCreacion,
                'dni1' => $usuario->dni1,
                'dni2' => $usuario->dni2,
                'dni3' => $usuario->dni3,
                'nombreRol' => $usuario->nombreRol,

            ];

            $usuariosArray[] = $usuarioData; // Agregar al array principal
        }

        
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')  {
            header('Content-Type: application/json');
            echo json_encode($usuariosArray); // Devolver la lista de puertas con sus movimientos
            exit;
        }


        $router->renderAdmin('admin/usuarios/aceptar', [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'titulo' => $titulo,
        ]);
    }

    public static function confirmar(){
        iniciarSession();
        adminSession();

        $usuarioSession = $_SESSION['nombreUsuario'];
        

            $email = new EmailModel();

            $emailUsuario = $_POST['email'];

    
            $loginModel = new LoginModel([
                'id' => $_POST['id'],
                'aceptadoPor' => $usuarioSession,
                'email' => $emailUsuario
            ]);
            
            
            $loginModel->aceptar();
    
            $emailVerificado = $loginModel->obtenerPorEmail();
    
            if ($emailVerificado) {
    
                $destinatorio = $emailUsuario;
                $asunto = 'Cuenta Aceptada';
    
                $cuerpo = "Su cuenta ha sido aceptada, puede ingresar a la plataforma con su usuario y contraseña";

                $email->enviar($destinatorio, $asunto, $cuerpo);
            }
            echo json_encode([
                'success' => true,
                'message' => 'Usuario aceptado'
            ]);
            exit;
        
    }
    public static function eliminar(){
        iniciarSession();
        adminSession();

        $usuarioSession = $_SESSION['nombreUsuario'];
        
        $loginModel = new LoginModel([
            'id' => $_POST['id'],
            'eliminadoPor' => $usuarioSession
        ]);
        
        $loginModel->eliminar();

        echo json_encode([
            'success' => true,
            'message' => 'Usuario eliminado correctamente'
        ]);
        exit;
    }

    public static function gestion(Router $router){
        iniciarSession();
        adminSession();

        $nombre = $_SESSION['nombre'];
        $apellido = $_SESSION['apellido'];
        $email = $_SESSION['email'];
        $titulo = "Gestionar Usuarios";

        $loginModel = new LoginModel();
        $usuarios = $loginModel->obtenerTodos();
        $roles = $loginModel->obtenerRols();
        $usuariosArray = [];

        foreach ($usuarios as $usuario) {
            $usuarioData = [ // Cambiar el nombre de la variable para claridad
                'id' => $usuario->id,
                'nombre' => $usuario->nombre,
                'apellido' => $usuario->apellido,
                'nombreUsuario' => $usuario->nombreUsuario,
                'dni' => $usuario->dni,
                'telefono' => $usuario->telefono,
                'email' => $usuario->email,
                'fechaCreacion' => $usuario->fechaCreacion,
                'nombreRol' => $usuario->nombreRol,

            ];

            $usuariosArray[] = $usuarioData; // Agregar al array principal
        }

        $rolsArray = [];

        foreach($roles as $rol){
            $rolData = [
                'id' => $rol->id,
                'nombre' => $rol->nombre,
            ];

            $rolsArray[] = $rolData;
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            header('Content-Type: application/json');
        
            // Combinar ambos arrays en un array asociativo
            $response = [
                'usuariosArray' => $usuariosArray,
                'rolsArray' => $rolsArray,
            ];
        
            // Enviar la respuesta JSON
            echo json_encode($response);
            exit;
        }



        $router->renderAdmin('admin/usuarios/gestion', [
            'nombre' => $nombre,
            'apellido' => $apellido,
            'email' => $email,
            'titulo' => $titulo,
            'rolsArray' => $rolsArray,
        ]);
    }
    public static function editar(){
        iniciarSession();
        adminSession();

        $arrayDatos = $_POST;
        $usuario = $_SESSION['nombreUsuario'];
        
        $loginModel = new LoginModel([
            'id' => $arrayDatos['id'],
            'nombre' => $arrayDatos['nombre'],
            'apellido' => $arrayDatos['apellido'],
            'nombreUsuario' => $arrayDatos['nombreUsuario'],
            'dni' => $arrayDatos['dni'],
            'telefono' => $arrayDatos['telefono'],
            'email' => $arrayDatos['email'],
            'fkRol' => $arrayDatos['rol'],
            'modificadoPor' => $usuario
        ]);

        $userExistente = $loginModel->verificarRegistroAdmin();

        if (!empty($userExistente)) {
            echo json_encode([
                'status' => false,
                'message' => 'El usuario ya existe con alguno de los datos proporcionados (nombre de usuario, DNI, teléfono o email).'
            ]);
            exit;
        }

        $loginModel->persistir();

        echo json_encode([
            'success' => true,
            'usuario' => $arrayDatos,
            'message' => 'Usuario editado Correctamente'
        ]);
        
        exit;
    }

    public static function crear(Router $router)
    {
        iniciarSession();
        adminSession();

        $argsUsuario = $_POST;
        $argsUsuarioFiles = $_FILES;
        $creadoPor = $_SESSION['nombreUsuario'];
        
        // Verificar si el usuario ya existe (solo con los datos que no dependen de los archivos)
        $usuarioTemporal = new LoginModel([
            'nombre' => $argsUsuario['nombre'],
            'apellido' => $argsUsuario['apellido'],
            'nombreUsuario' => $argsUsuario['nombreUsuario'],
            'dni' => $argsUsuario['dni'],
            'telefono' => $argsUsuario['telefono'],
            'email' => $argsUsuario['email'],
            'password' => $argsUsuario['password'],
            'creadoPor' => $creadoPor,
            'fkRol' => $argsUsuario['rol'],
            'dni1' => "No hay imagen. Creado en Admin",
            'dni2' => "No hay imagen. Creado en Admin",
            'dni3' => "No hay imagen. Creado en Admin"
        ]);
        $userExistente = $usuarioTemporal->verificarRegistro();
    
        if (!empty($userExistente)) {
            echo json_encode([
                'status' => false,
                'message' => 'El usuario ya existe con alguno de los datos proporcionados (nombre de usuario, DNI, teléfono o email).'
            ]);
            exit;
        }

    
        // Hashear la contraseña antes de persistir
        if (isset($argsUsuario['password'])) {
            $argsUsuario['password'] = password_hash($argsUsuario['password'], PASSWORD_BCRYPT);
        }
    
        // Crear el objeto LoginModel con todos los datos completos
        $usuario = new LoginModel([
            'nombre' => $argsUsuario['nombre'],
            'apellido' => $argsUsuario['apellido'],
            'nombreUsuario' => $argsUsuario['nombreUsuario'],
            'dni' => $argsUsuario['dni'],
            'telefono' => $argsUsuario['telefono'],
            'email' => $argsUsuario['email'],
            'password' => $argsUsuario['password'],
            'creadoPor' => $creadoPor,
            'fkRol' => $argsUsuario['rol'],
            'dni1' => "No hay imagen. Creado en Admin",
            'dni2' => "No hay imagen. Creado en Admin",
            'dni3' => "No hay imagen. Creado en Admin"
        ]);


        
        // Persistir el usuario con los datos y archivos
        $usuario->persistir();
    
        echo json_encode([
            'success' => true,
            'data' => $argsUsuario,
            'message' => 'Usuario registrado correctamente'
        ]);
    
        exit;
    }
}

