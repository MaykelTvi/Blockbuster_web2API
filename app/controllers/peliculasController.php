<?php
require_once './app/models/peliculasModel.php';
require_once './app/views/peliculasView.php';
require_once './app/models/UsuarioModel.php';

class peliculasController {
    private $view;
    private $model;
    private $userModel;

    function __construct() {
        $this->view      = new peliculasView();
        $this->model     = new peliculasModel();
        $this->userModel = new UsuarioModel();
    }

    function mostrarPeliculas() {
        AuthHelper::init();
        $list = $this->model->obtenerPeliculas();
        if (isset($_SESSION['id_usuario']) && $this->userModel->isAdmin($_SESSION['id_usuario'])) {
            $this->view->mostrarAdminPeliculas($list);
        } else {
            $this->view->mostrarPeliculas($list);
        }
    }

    function agregarPelicula() {
        AuthHelper::verify();

        $titulo    = $_POST['titulo'];
        $director  = $_POST['director'];
        $alquilada = isset($_POST['alquilada']) ? 1 : 0;

        if (empty($titulo) || empty($director)) {
            $this->view->mostrarError("Debe completar todos los campos obligatorios");
            return;
        }

        $rutaImagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
            $tipoArchivo = $_FILES['imagen']['type'];
            if (in_array($tipoArchivo, ['image/jpg', 'image/jpeg', 'image/png'])) {
                $imagenTmp    = $_FILES['imagen']['tmp_name'];
                $nombreImagen = uniqid("", true) . "." . strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
                $carpetaDest  = 'app/uploads/peliculas/';
                $rutaImagen   = $carpetaDest . $nombreImagen;
                if (!move_uploaded_file($imagenTmp, $rutaImagen)) {
                    $this->view->mostrarError("Error al subir la imagen.");
                    return;
                }
            } else {
                $this->view->mostrarError("Formato de imagen no permitido.");
                return;
            }
        }

        $id = $this->model->insertarPelicula($titulo, $director, $alquilada, $rutaImagen);
        if ($id) {
            header('Location: ' . BASE_URL . 'peliculas');
        } else {
            $this->view->mostrarError("Error al insertar la película.");
        }
    }

    function eliminarPelicula($idPelicula) {
        AuthHelper::verify();
        if ($this->userModel->isAdmin($_SESSION['id_usuario'])) {
            $this->model->removerPelicula($idPelicula);
            header('Location: ' . BASE_URL . 'peliculas');
        }
    }

    function editarPelicula($idPelicula) {
        AuthHelper::verify();
        if ($this->userModel->isAdmin($_SESSION['id_usuario'])) {
            $pelicula = $this->model->mostrarPelicula($idPelicula);
            $this->view->editarPelicula($idPelicula, $pelicula);
        }
    }

    function actualizarPelicula($idPelicula) {
        AuthHelper::verify();

        $nuevoTitulo    = $_POST['titulo'];
        $nuevoDirector  = $_POST['director'];
        $nuevaAlquilada = isset($_POST['alquilada']) ? 1 : 0;

        $rutaImagen = null;
        if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === 0) {
            $tipoArchivo = $_FILES['imagen']['type'];
            if (in_array($tipoArchivo, ['image/jpg', 'image/jpeg', 'image/png'])) {
                $imagenTmp    = $_FILES['imagen']['tmp_name'];
                $nombreImagen = uniqid("", true) . "." . strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
                $carpetaDest  = 'app/uploads/peliculas/';
                $rutaImagen   = $carpetaDest . $nombreImagen;
                if (!move_uploaded_file($imagenTmp, $rutaImagen)) {
                    $this->view->mostrarError("Error al subir la imagen.");
                    return;
                }
            } else {
                $this->view->mostrarError("Formato de imagen no permitido.");
                return;
            }
        }

        $this->model->actualizarPelicula($idPelicula, $nuevoTitulo, $nuevoDirector, $nuevaAlquilada, $rutaImagen);
        header('Location: ' . BASE_URL . 'peliculas');
    }

    public function mostrarPelicula($idPelicula) {
        $pelicula = $this->model->mostrarPelicula($idPelicula);
        $this->view->mostrarPelicula($pelicula);
    }

    function mostrarError() {
        $error = "Hubo un error al procesar la solicitud.";
        $this->view->mostrarError($error);
    }
}
