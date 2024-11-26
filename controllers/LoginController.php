<?php

namespace Controllers;
use MVC\Router;
use Model\LoginModel;
use Model\EmailModel;

class LoginController
{

    public static function login(Router $router)
    {
        loginOn();
        $titulo = "Login";
        $router->render('login/login', [
            'titulo' => $titulo,
        ]);
    }
    public static function autenticar(Router $router)
    {
        $auth = $_POST;
        $credencial = $auth['nombreUsuario'];
        $password = $auth['password'];

        $usuarioModel = new LoginModel();
        $usuario = $usuarioModel->obtenerPorLogin($credencial);


        if ($usuario) {
            // Convertimos a JSON y luego a array
            $json = json_encode($usuario);
            $array = json_decode($json, true);
            $passwordUsuario = $array[0]['password'];

            // Verificamos la contraseña
            if (password_verify($password, $passwordUsuario)) {
                session_start();

                session_regenerate_id(true);
                $_SESSION['id'] = $array[0]['id'];
                $_SESSION['nombreUsuario'] = $array[0]['nombreUsuario'];
                $_SESSION['nombre'] = $array[0]['nombre'];
                $_SESSION['apellido'] = $array[0]['apellido'];
                $_SESSION['email'] = $array[0]['email'];
                $_SESSION['login'] = true;

                $rol = $usuarioModel->obtenerRolPorId($array[0]['fkRol']);
                $_SESSION['rol'] = $rol;
                $_SESSION['fkRol'] = $array[0]['fkRol'];


                echo json_encode([
                    'success' => true,
                    'message' => 'Usuario autenticado'
                ]);

                exit; // Finalizamos para evitar otras salidas
            } else {
                // Contraseña incorrecta
                echo json_encode([
                    'success' => false,
                    'message' => 'Contraseña incorrecta'
                ]);
                exit;
            }
        } else {
            // Usuario no encontrado
            echo json_encode([
                'success' => false,
                'message' => 'Usuario no encontrado o no aceptado'
            ]);
            exit;
        }
    }

    public static function index(Router $router)
    {
        loginOn();
        $titulo = "Registro";

        $rols = new LoginModel();
        $roles = $rols->obtenerRols();

        $rolsArray = [];

        foreach($roles as $rol){
            $rolData = [
                'id' => $rol->id,
                'nombre' => $rol->nombre,
            ];

            $rolsArray[] = $rolData;
        }

        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')  {
            header('Content-Type: application/json');
            echo json_encode($rolsArray); // Devolver la lista de puertas con sus movimientos
            exit;
        }


        $router->render('login/registro', [
            'titulo' => $titulo,
            'rolsArray' => $rolsArray
        ]);
    }



    public static function crear(Router $router)
    {
        $argsUsuario = $_POST;
        $argsUsuarioFiles = $_FILES;
    
        // Verificar si el usuario ya existe (solo con los datos que no dependen de los archivos)
        $usuarioTemporal = new LoginModel([
            'nombre' => $argsUsuario['nombre'],
            'apellido' => $argsUsuario['apellido'],
            'nombreUsuario' => $argsUsuario['nombreUsuario'],
            'dni' => $argsUsuario['dni'],
            'telefono' => $argsUsuario['telefono'],
            'email' => $argsUsuario['email'],
            'password' => $argsUsuario['password'],
            'creadoPor' => $argsUsuario['nombreUsuario'],
            'fkRol' => $argsUsuario['fkRol']
        ]);
        $userExistente = $usuarioTemporal->verificarRegistro();
    
        if (!empty($userExistente)) {
            echo json_encode([
                'status' => false,
                'message' => 'El usuario ya existe con alguno de los datos proporcionados (nombre de usuario, DNI, teléfono o email).'
            ]);
            exit;
        }
    
        // Verificar y mover los archivos subidos
        $uploadDir = __DIR__ . '/../public/imagenes/';
        $uploadedFiles = [];
    
        foreach ($argsUsuarioFiles as $key => $file) {
            if ($file['error'] === UPLOAD_ERR_OK) {
                $filename = "dni_" . uniqid() . "_" . basename($file['name']);
                $destination = $uploadDir . $filename;
    
                if (move_uploaded_file($file['tmp_name'], $destination)) {
                    $uploadedFiles[$key] = $filename;
                } else {
                    echo json_encode([
                        'status' => false,
                        'message' => "Error al guardar el archivo $key"
                    ]);
                    exit;
                }
            } else {
                echo json_encode([
                    'status' => false,
                    'message' => "Error al subir el archivo $key"
                ]);
                exit;
            }
        }
    
        // Validar que todos los archivos necesarios se hayan subido
        if (empty($uploadedFiles['dni1']) || empty($uploadedFiles['dni2']) || empty($uploadedFiles['dni3'])) {
            echo json_encode([
                'status' => false,
                'message' => 'Todos los archivos (dni1, dni2, dni3) son obligatorios.'
            ]);
            exit;
        }
    
        // Asignar las rutas de los archivos subidos al array de argumentos
        $argsUsuario['dni1'] = $uploadedFiles['dni1'];
        $argsUsuario['dni2'] = $uploadedFiles['dni2'];
        $argsUsuario['dni3'] = $uploadedFiles['dni3'];
    
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
            'creadoPor' => $argsUsuario['nombreUsuario'],
            'fkRol' => $argsUsuario['fkRol'],
            'dni1' => $argsUsuario['dni1'],
            'dni2' => $argsUsuario['dni2'],
            'dni3' => $argsUsuario['dni3'],
        ]);
        
        // Persistir el usuario con los datos y archivos
        $usuario->persistir();
    
        echo json_encode([
            'status' => true,
            'data' => $argsUsuario,
            'message' => 'Usuario registrado correctamente'
        ]);
    
        exit;
    }
    

    public static function bad()
    {
        header('Location: /login/');
    }

    public static function cs()
    {
        session_start();
        $_SESSION = [];
        header('Location: /login');
    }

    public static function resetPassword(Router $router)
    {
        $titulo = "Reset Password";
        $router->render('login/resetpassword', [
            'titulo' => $titulo,
        ]);
    }
    public static function resetPasswordReceived(Router $router)
    {
        $titulo = "Reset Password";
        $router->render('login/resetpasswordreceived', [
            'titulo' => $titulo,
        ]);
    }

    public static function enviarEmail(Router $router)
    {
        session_start();
        $email = new EmailModel();
        $token = $email->generarToken();
        $emailUsuario = $_POST['email'];

        $loginModel = new LoginModel([
            'email' => $emailUsuario,
            'token' => $token
        ]);

        $loginModel->guardarToken();
        $emailVerificado = $loginModel->obtenerPorEmail();

        if ($emailVerificado) {

            $destinatorio = $emailUsuario;
            $asunto = 'Recuperación de contraseña';

            $cuerpo = "
            <html>
                <head>
                    <style>
                        .container {
                            font-family: Arial, sans-serif;
                            max-width: 600px;
                            margin: auto;
                            padding: 20px;
                            border: 1px solid #ddd;
                            border-radius: 10px;
                            background-color: #f9f9f9;
                        }
                        .header {
                            background-color: #FF9100;
                            color: white;
                            padding: 10px 20px;
                            text-align: center;
                            border-radius: 10px;
                        }
                        .content {
                            padding: 20px;
                            text-align: center;
                        }
                        .btn {
                            display: inline-block;
                            margin-top: 20px;
                            padding: 10px 20px;
                            color: white;
                            background-color: #FF9100;
                            text-decoration: none;
                            border-radius: 5px;
                            font-size: 16px;
                        }
                        a{
                            color: white;
                        }
                        .ii a[href]{
                            color: white;
                        }
                        .btn:hover {
                            background-color: darken(#FF9100, 10%);
                        }
                        .footer {
                            margin-top: 20px;
                            font-size: 12px;
                            color: #888;
                        }
                    </style>
                </head>
                <body>
                    <div class='container'>
                        <div class='header'>
                            <h1>Recuperación de contraseña</h1>
                        </div>
                        <div class='content'>
                            <p>Hola, hemos recibido una solicitud para restablecer tu contraseña.</p>
                            <p>Si realizaste esta solicitud, haz clic en el botón de abajo para restablecer tu contraseña:</p>
                            <a href='https://proyectopropio.uno/resetpasswordreceived?token=$token' class='btn'>Restablecer contraseña</a>
                            <p>Si no solicitaste restablecer tu contraseña, ignora este correo electrónico.</p>
                        </div>
                        <div class='footer'>
                            <p>Este mensaje fue enviado automáticamente, por favor no respondas.</p>
                        </div>
                    </div>
                </body>
            </html>";

            $email->enviar($destinatorio, $asunto, $cuerpo);

            $_SESSION['emailEnviado'] = true;
            echo json_encode([
                'success' => true,
                'data' => $email,
                'message' => 'Email enviado correctamente'
            ]);
            exit;

        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Email no encontrado'
            ]);
            exit;
        }
    }

    public static function emailsend(Router $router)
    {
        session_start();
        if (isset($_SESSION['emailEnviado'])) {
            $emailEnviado = $_SESSION['emailEnviado'];
            if (!$emailEnviado) {
                header('Location: /login');
            }
        } else {
            header('Location: /login');
        }
        $_SESSION = [];
        $titulo = "Email Enviado";
        $router->render('login/emailsend', [
            'titulo' => $titulo,
        ]);
    }

    public static function actualizar(Router $router)
    {
        $token = $_POST['token'];
        $password = $_POST['password'];


        $loginModel = new LoginModel([
            'token' => $token
        ]);
        $tokenVerificado = $loginModel->verificarToken();
        // var_dump($tokenVerificado);
        // exit;

        if ($tokenVerificado) {
            $loginModel->password = password_hash($password, PASSWORD_BCRYPT);
            $loginModel->id = $tokenVerificado[0]->id;
            $loginModel->actualizarPassword();
                echo json_encode([
                'success' => true,
                'message' => 'Contraseña actualizada correctamente'
            ]);
            exit;
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Token no encontrado'
            ]);
            exit;
        }

    }

}