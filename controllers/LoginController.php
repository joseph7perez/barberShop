<?php 

namespace Controllers;

use Classes\Email;
use Model\Usuario;
use MVC\Router;

class LoginController{
    public static function login(Router $router){
        $usuario = new Usuario;
    
        //Alertas vacias
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $auth = new Usuario($_POST);
            //$usuario->sincronizar($_POST);
            $alertas = $auth->validarCuenta();

          //Revisar si alertas esta vacio
          if (empty($alertas)) {
             //Verificar que el usuario exista
            $usuario = Usuario::where('email', $auth->email);
          //  $resultado = $usuario->existeUsuario();
         // debuguear($usuario);

            if ($usuario) {
                //Verificar la contraseña
                if( $usuario->comprobarContrasenaYVerificado($auth->contrasena)){
                    //Autenticar el usuario
                    session_start();

                    $_SESSION['id'] = $usuario->id;
                    $_SESSION['nombre'] = $usuario->nombre . " " . $usuario->apellido;
                    $_SESSION['email'] = $usuario->email;
                    $_SESSION['login'] = true;

                    //Redireccionamiento 
                    if ($usuario->admin === "1") {
                        $_SESSION['admin'] = $usuario->admin ?? null;

                        header('Location: /admin');

                    } else {
                        header('Location: /cita');
                    }
                }
            } else{
                Usuario::setAlerta('error', 'Usuario no encontrado');
            }
            if(!($resultado->num_rows)){
                $alertas = Usuario::getAlertas();
            } else {
                //Hashear la contraseña
                $usuario->hashContraseña();

                //Generar un token
                $usuario->crearToken();

                //Enviar el mail
                $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                debuguear($email);

                //Redireccion
             //   $router->render('admin/index' );

            }

          }
        }

        $alertas = Usuario::getAlertas();
        $router->render('auth/login', [
            'auth' => $auth,
            'alertas' => $alertas
        ]);
    }
    
    public static function logout(){
        echo "desde logout";
    }

    public static function olvide(Router $router){
        $router->render('auth/olvide-contraseña' );
    }

    public static function recuperar(){
        echo "desde recuperar";
    }

    public static function crear(Router $router){
        $usuario = new Usuario;
    
        //Alertas vacias
        $alertas = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarNuevaCuenta();

          //Revisar si alertas esta  vacio
          if (empty($alertas)) {
             //Verificar que el usuario no este registrado
            $resultado = $usuario->existeUsuario();

            if($resultado->num_rows){
                $alertas = Usuario::getAlertas();
            } else {
                //Hashear la contraseña
                $usuario->hashContraseña();

                //Generar un token
                $usuario->crearToken();

                //Enviar el mail
                $email = new Email($usuario->email, $usuario->nombre, $usuario->token);

                $email->enviarConfirmacion();

                //Crear el usuario
                $resultado = $usuario->guardar();
                if ($resultado) {
                    header('Location: /mensaje');
                }

    //            debuguear($email);

                //Redireccion
              //  $router->render('admin/index' );

            }

          }
        }
        $router->render('auth/crear-cuenta', [
            'usuario' => $usuario,
            'alertas' => $alertas
        ]);
    }

    public static function mensaje(Router $router){
        $router->render('auth/mensaje');
    }

    public static function confirmar(Router $router){
        $usuario = new Usuario;

        $alertas = [];

        $token = s($_GET['token']);

      //  debuguear($token);

        $usuario = Usuario::where('token', $token);  

        if (empty($usuario)) {
            //Mostrar mensaje de error
            Usuario::setAlerta('error', 'Token no válido');

        } else{
            //modificar a usuario confirmado
            $usuario->confirmado = "1";
            $usuario->token = null;
            $usuario->guardar();
            Usuario::setAlerta('exito', 'Cuenta comprobada correctamente');

        }
        //Obtener alertas
        $alertas = Usuario::getAlertas();

        //Renderizar vista
        $router->render('auth/confirmar-cuenta', [
            'alertas' => $alertas
        ]);

    }

}