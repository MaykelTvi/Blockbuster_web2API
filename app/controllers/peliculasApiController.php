<?php
require_once 'app/controllers/apiController.php';
require_once 'app/models/peliculasModel.php';

class peliculasApiController extends apiController {

    public function __construct(){
        parent::__construct();
        $this->model = new peliculasModel();
    }

    public function listarPeliculas($params = []) {
        $sort = isset($_GET['sort']) ? $_GET['sort'] : 'titulo';
        $order = isset($_GET['order']) ? $_GET['order'] : 'ASC';

        $peliculas = $this->model->obtenerPeliculas($sort, $order);

        if ($peliculas) {
            $this->view->response($peliculas, 200);
        } else {
            $this->view->response('No hay peliculas', 404);
        }
    }

    public function listarPeliculaPorId($params = []) {
        $id = $params[':ID'];
        $pelicula = $this->model->mostrarPelicula($id);

        if ($pelicula) {
            $this->view->response($pelicula, 200);
        } else {
            $this->view->response('No existe pelicula con id ' . $id, 404);
        }
    }

    public function agregarPelicula($params = []) {
        $data = $this->getData();

        if (!isset($data->titulo) || !isset($data->director) || !isset($data->id_genero)) {
            $this->view->response('Complete los campos obligatorios (titulo, director, id_genero)', 400);
            return;
        }

        $id = $this->model->insertarPelicula($data->titulo, $data->director, $data->id_genero, $data->alquilada);

        if ($id) {
            $this->view->response('Se creo la pelicula con id ' . $id, 201);
        } else {
            $this->view->response('Error al agregar la pelicula', 500);
        }
    }

    public function modificarPelicula($params = []) {
        $id = $params[':ID'];
        $pelicula = $this->model->mostrarPelicula($id);

        if (!$pelicula) {
            $this->view->response('No existe pelicula con id ' . $id, 404);
            return;
        }

        $data = $this->getData();

        if (!isset($data->titulo) || !isset($data->director) || !isset($data->id_genero)) {
            $this->view->response('Complete los campos obligatorios (titulo, director, id_genero)', 400);
            return;
        }

        $this->model->actualizarPelicula($id, $data->titulo, $data->director, $data->id_genero, $data->alquilada);
        $this->view->response('Pelicula modificada con exito', 200);
    }

    public function eliminarPelicula($params = []) {
        $id = $params[':ID'];
        $pelicula = $this->model->mostrarPelicula($id);

        if ($pelicula) {
            $this->model->removerPelicula($id);
            $this->view->response('Pelicula eliminada con id ' . $id, 200);
        } else {
            $this->view->response('No existe pelicula con id ' . $id, 404);
        }
    }
}
