<?php
require_once './app/models/alquileresModel.php';
require_once './app/views/alquileresView.php';
require_once './app/models/UsuarioModel.php';

class alquileresController {
    private $view;
    private $model;
    private $userModel;

    function __construct() {
        $this->view      = new alquileresView();
        $this->model     = new alquileresModel();
        $this->userModel = new UsuarioModel();
    }

    function mostrarAlquileres() {
        AuthHelper::init();
        $list = $this->model->obtenerAlquileres();
        if (isset($_SESSION['id_usuario']) && $this->userModel->isAdmin($_SESSION['id_usuario'])) {
            $this->view->mostrarAdminAlquileres($list);
        } else {
            $this->view->mostrarAlquileres($list);
        }
    }

    function agregarAlquiler() {
        AuthHelper::verify();

        $idPelicula = $_POST['id_pelicula'];
        $idUsuario  = $_POST['id_usuario'];
        $fecha      = $_POST['fecha_alquiler'];

        if (empty($idPelicula) || empty($idUsuario) || empty($fecha)) {
            $this->view->mostrarError("Debe completar todos los campos.");
            return;
        }

        $id = $this->model->insertarAlquiler($idPelicula, $idUsuario, $fecha);
        if ($id) {
            header('Location: ' . BASE_URL . 'alquileres');
        } else {
            $this->view->mostrarError("Error al registrar el alquiler.");
        }
    }

    function eliminarAlquiler($idAlquiler) {
        AuthHelper::verify();
        if ($this->userModel->isAdmin($_SESSION['id_usuario'])) {
            $this->model->eliminarAlquiler($idAlquiler);
            header('Location: ' . BASE_URL . 'alquileres');
        }
    }

    function editarAlquiler($idAlquiler) {
        AuthHelper::verify();
        if ($this->userModel->isAdmin($_SESSION['id_usuario'])) {
            $alquiler  = $this->model->mostrarAlquiler($idAlquiler);
            $peliculas = $this->model->obtenerPeliculasDisponibles();
            $usuarios  = $this->model->obtenerUsuarios();
            $this->view->editarAlquiler($idAlquiler, $alquiler, $peliculas, $usuarios);
        }
    }

    function actualizarAlquiler($idAlquiler) {
        AuthHelper::verify();

        $newIdPelicula = $_POST['id_pelicula'];
        $newIdUsuario  = $_POST['id_usuario'];
        $newFecha      = $_POST['fecha_alquiler'];

        $this->model->actualizarAlquiler($idAlquiler, $newIdPelicula, $newIdUsuario, $newFecha);
        header('Location: ' . BASE_URL . 'alquileres');
    }

    function mostrarAlquiler($idAlquiler) {
        $alquiler = $this->model->mostrarAlquiler($idAlquiler);
        $this->view->mostrarAlquiler($alquiler);
    }

    function mostrarFormAgregar() {
        AuthHelper::verify();
        $peliculas = $this->model->obtenerPeliculasDisponibles();
        $usuarios  = $this->model->obtenerUsuarios();
        $this->view->mostrarFormAgregar($peliculas, $usuarios);
    }
}
