<?php
require_once './app/models/UsuarioModel.php';
require_once './app/views/authView.php';
require_once './app/helpers/authHelper.php';

class authController
{
    private $view;
    private $model;

    function __construct()
    {
        $this->model = new UsuarioModel();
        $this->view  = new AuthView();
    }

    public function showLogin() {
        return $this->view->showLogin();
    }

    public function auth() {
        if (!isset($_POST['usuario']) || empty($_POST['usuario'])) {
            return $this->view->showError('Falta completar el usuario');
        }
        if (!isset($_POST['password']) || empty($_POST['password'])) {
            return $this->view->showError('Falta completar la contraseña');
        }

        $usuario  = $_POST['usuario'];
        $password = $_POST['password'];

        $userFromDB = $this->model->getByUser($usuario);

        if ($userFromDB && password_verify($password, $userFromDB->password)) {
            session_start();
            AuthHelper::login($userFromDB);
            $_SESSION['LAST_ACTIVITY'] = time();
            header('Location: ' . BASE_URL);
            exit;
        } else {
            return $this->view->showLogin('Campos incorrectos');
        }
    }

    public function logout() {
        AuthHelper::logout();
        header('Location: ' . BASE_URL);
    }
}
