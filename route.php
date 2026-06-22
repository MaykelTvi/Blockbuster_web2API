<?php
require_once 'libs/router.php';
require_once 'app/controllers/peliculasApiController.php';
require_once 'app/controllers/alquileresApiController.php';

$router = new Router();

$router->addRoute('peliculas',     'GET',    'peliculasApiController', 'listarPeliculas');
$router->addRoute('peliculas/:ID', 'GET',    'peliculasApiController', 'listarPeliculaPorId');
$router->addRoute('pelicula',      'POST',   'peliculasApiController', 'agregarPelicula');
$router->addRoute('pelicula/:ID',  'PUT',    'peliculasApiController', 'modificarPelicula');
$router->addRoute('pelicula/:ID',  'DELETE',  'peliculasApiController', 'eliminarPelicula');

$router->addRoute('alquileres',     'GET',    'alquileresApiController', 'listarAlquileres');
$router->addRoute('alquileres/:ID', 'GET',    'alquileresApiController', 'listarAlquilerPorId');
$router->addRoute('alquiler',       'POST',   'alquileresApiController', 'agregarAlquiler');
$router->addRoute('alquiler/:ID',   'PUT',    'alquileresApiController', 'modificarAlquiler');
$router->addRoute('alquiler/:ID',   'DELETE',  'alquileresApiController', 'eliminarAlquiler');

$router->route($_GET['resource'], $_SERVER['REQUEST_METHOD']);
