<?php
require_once './app/models/UsuarioModel.php';
require_once './app/views/usuariosView.php';

class usuariosController {
    private $view;
    private $model;

    function __construct() {
        $this->view  = new usuariosView();
        $this->model = new UsuarioModel();
    }

    function mostrarUsuarios() {
        AuthHelper::init();
        $list = $this->model->obtenerUsuarios();
        if (isset($_SESSION['id_usuario']) && $this->model->isAdmin($_SESSION['id_usuario'])) {
            $this->view->mostrarAdminUsuarios($list);
        } else {
            $this->view->mostrarError("No tenés permisos para ver esta sección.");
        }
    }

    function agregarUsuario() {
        AuthHelper::verify();
        $usuario  = $_POST['usuario']  ?? null;
        $password = $_POST['password'] ?? null;
        $admin    = isset($_POST['admin']) ? 1 : 0;

        if (empty($usuario) || empty($password)) {
            $this->view->mostrarError("Debe completar todos los campos");
            return;
        }

        $id = $this->model->insertarUsuario($usuario, $password, $admin);
        if ($id) {
            header('Location: ' . BASE_URL . 'usuarios');
        } else {
            $this->view->mostrarError("Error al insertar el usuario");
        }
    }

    function eliminarUsuario($idUsuario) {
        AuthHelper::verify();
        if ($this->model->isAdmin($_SESSION['id_usuario'])) {
            $this->model->removerUsuario($idUsuario);
            header('Location: ' . BASE_URL . 'usuarios');
        } else {
            $this->view->mostrarError("No tenés permisos para eliminar usuarios");
        }
    }

    function editarUsuario($idUsuario) {
        AuthHelper::verify();
        if ($this->model->isAdmin($_SESSION['id_usuario'])) {
            $usuario = $this->model->mostrarUsuario($idUsuario);
            $this->view->editarUsuario($idUsuario, $usuario);
        }
    }

    function actualizarUsuario($idUsuario) {
        AuthHelper::verify();
        $nuevoUsuario = $_POST['usuario'] ?? null;
        $nuevoAdmin   = isset($_POST['admin']) ? 1 : 0;

        if (empty($nuevoUsuario)) {
            $this->view->mostrarError("El nombre de usuario no puede estar vacío");
            return;
        }

        $this->model->actualizarUsuario($idUsuario, $nuevoUsuario, $nuevoAdmin);
        header('Location: ' . BASE_URL . 'usuarios');
    }

    function mostrarError() {
        $error = "Hubo un error al procesar la solicitud.";
        $this->view->mostrarError($error);
    }
}
