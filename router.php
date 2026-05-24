<?php
require_once './config.php';
require_once './app/helpers/authHelper.php';
require_once './app/controllers/peliculasController.php';
require_once './app/controllers/alquileresController.php';
require_once './app/controllers/authController.php';
require_once './app/controllers/usuariosController.php';

define('BASE_URL', '//' . $_SERVER['SERVER_NAME'] . ':' . $_SERVER['SERVER_PORT'] . dirname($_SERVER['PHP_SELF']) . '/');

$action = 'home';
if (!empty($_GET['action'])) {
    $action = $_GET['action'];
}

$params = explode('/', $action);

switch ($params[0]) {

    case 'home':
    case 'peliculas':
        $c = new peliculasController();
        $c->mostrarPeliculas();
        break;

    case 'pelicula':
        $c = new peliculasController();
        $c->mostrarPelicula($params[1]);
        break;

    case 'agregarPelicula':
        $c = new peliculasController();
        $c->agregarPelicula();
        break;

    case 'eliminarPelicula':
        $c = new peliculasController();
        $c->eliminarPelicula($params[1]);
        break;

    case 'editarPelicula':
        $c = new peliculasController();
        $c->editarPelicula($params[1]);
        break;

    case 'actualizarPelicula':
        $c = new peliculasController();
        $c->actualizarPelicula($params[1]);
        break;

    // --- Alquileres ---
    case 'alquileres':
        $c = new alquileresController();
        $c->mostrarAlquileres();
        break;

    case 'alquiler':
        $c = new alquileresController();
        $c->mostrarAlquiler($params[1]);
        break;

    case 'formAgregarAlquiler':
        $c = new alquileresController();
        $c->mostrarFormAgregar();
        break;

    case 'agregarAlquiler':
        $c = new alquileresController();
        $c->agregarAlquiler();
        break;

    case 'eliminarAlquiler':
        $c = new alquileresController();
        $c->eliminarAlquiler($params[1]);
        break;

    case 'editarAlquiler':
        $c = new alquileresController();
        $c->editarAlquiler($params[1]);
        break;

    case 'actualizarAlquiler':
        $c = new alquileresController();
        $c->actualizarAlquiler($params[1]);
        break;

    // --- Auth ---
    case 'login':
        $c = new authController();
        $c->showLogin();
        break;

    case 'auth':
        $c = new authController();
        $c->auth();
        break;

    case 'logout':
        $c = new authController();
        $c->logout();
        break;

    // --- Usuarios ---
    case 'usuarios':
        $c = new usuariosController();
        $c->mostrarUsuarios();
        break;

    case 'agregarUsuario':
        $c = new usuariosController();
        $c->agregarUsuario();
        break;

    case 'eliminarUsuario':
        $c = new usuariosController();
        $c->eliminarUsuario($params[1]);
        break;

    case 'editarUsuario':
        $c = new usuariosController();
        $c->editarUsuario($params[1]);
        break;

    case 'actualizarUsuario':
        $c = new usuariosController();
        $c->actualizarUsuario($params[1]);
        break;

    default:
        echo "404 - Página no encontrada";
        break;
}