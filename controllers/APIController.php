<?php 

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;
use MVC\Router;

class APIController{

    public static function index(Router $router){
        $servicios = Servicio::all();
        echo json_encode($servicios);
       // debuguear($servicios);
    }

    public static function guardar(){
     
        $cita = new Cita($_POST);
        $resultado = $cita->guardar(); //Guardar info de la cita en la BD y devuelve el ID

        $id = $resultado['id'];

        //Añmacena los servicios con el ID de la Cita
        $idServicios = explode(',', $_POST['servicios'] );//Separar los IDs a string separados

        foreach ($idServicios as $idServicio) {
            $args = [
                'citaId' => $id,
                'servicioId' => $idServicio
            ];

            $citaServicio = new CitaServicio($args); 
            $citaServicio->guardar();

        }

        //Retornamos la respuesta
        echo json_encode(['resultado' => $resultado]);
    }
}