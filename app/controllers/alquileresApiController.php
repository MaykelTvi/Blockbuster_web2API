<?php
require_once 'app/controllers/apiController.php';
require_once 'app/models/alquileresModel.php';

class alquileresApiController extends apiController {

    public function __construct(){
        parent::__construct();
        $this->model = new alquileresModel();
    }

    public function listarAlquileres($params = []) {
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'fecha_alquiler';
        $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

        $alquileres = $this->model->obtenerAlquileres($sort, $order);

        if ($alquileres) {
            $this->view->response($alquileres, 200);
        } else {
            $this->view->response('No hay alquileres', 404);
        }
    }

    public function listarAlquilerPorId($params = []) {
        $id = $params[':ID'];
        $alquiler = $this->model->mostrarAlquiler($id);

        if ($alquiler) {
            $this->view->response($alquiler, 200);
        } else {
            $this->view->response('No existe alquiler con id ' . $id, 404);
        }
    }

    public function agregarAlquiler($params = []) {
        $data = $this->getData();

        if (!isset($data->id_pelicula) || !isset($data->id_usuario) || !isset($data->fecha_alquiler)) {
            $this->view->response('Complete los campos obligatorios (id_pelicula, id_usuario, fecha_alquiler)', 400);
            return;
        }

        $id = $this->model->insertarAlquiler($data->id_pelicula, $data->id_usuario, $data->fecha_alquiler);

        if ($id) {
            $this->view->response('Se creo el alquiler con id ' . $id, 201);
        } else {
            $this->view->response('Error al agregar el alquiler', 500);
        }
    }

    public function modificarAlquiler($params = []) {
        $id = $params[':ID'];
        $alquiler = $this->model->mostrarAlquiler($id);

        if (!$alquiler) {
            $this->view->response('No existe alquiler con id ' . $id, 404);
            return;
        }

        $data = $this->getData();

        if (!isset($data->id_pelicula) || !isset($data->id_usuario) || !isset($data->fecha_alquiler)) {
            $this->view->response('Complete los campos obligatorios (id_pelicula, id_usuario, fecha_alquiler)', 400);
            return;
        }

        $this->model->actualizarAlquiler($id, $data->id_pelicula, $data->id_usuario, $data->fecha_alquiler);
        $this->view->response('Alquiler modificado con exito', 200);
    }

    public function eliminarAlquiler($params = []) {
        $id = $params[':ID'];
        $alquiler = $this->model->mostrarAlquiler($id);

        if ($alquiler) {
            $this->model->eliminarAlquiler($id);
            $this->view->response('Alquiler eliminado con id ' . $id, 200);
        } else {
            $this->view->response('No existe alquiler con id ' . $id, 404);
        }
    }
}
