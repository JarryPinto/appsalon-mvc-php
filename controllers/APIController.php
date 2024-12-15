<?php 

namespace Controllers;

use Model\Cita;
use Model\CitaServicio;
use Model\Servicio;

class APIController {

    public static function index() {
        
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }

    public static function guardar() {

        //Almacena la cita y devuelve el ID 
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        $idCita = $resultado['id'];

        //Almacena los servicios con el ID de la cita 
        $idServicios = explode(",", $_POST['servicios']);  //El pimer parametro es el separador y el segundo es el string que se quiere separar
        foreach($idServicios as $idServicio) {
            $args = [
                'citaId' =>  $idCita,
                'servicioId' => $idServicio
            ];

            $citaServicio = new CitaServicio($args); //Creamos una instancia de citaServicio
            $citaServicio->guardar();  //Si no hay un ID la va a ir insertando
        }

        //Retornamos una respuesta
        echo json_encode(['resultado' => $resultado]);
    }

    public static function eliminar() {
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];

            $cita = Cita::find($id); //Busca por un id
            $cita->eliminar();
            header('Location:' . $_SERVER['HTTP_REFERER']); //Para que nos redireccione a la pagina que estabamos
        }
    }

    //MIRAR LAS CITAS OCUPADAS
    public static function citas() {
        $citas = Cita::all();
        echo json_encode($citas);
    }
}