<?php

class alquileresView {
    function __construct(){}

    function mostrarAdminAlquileres($list) {
        $count = count($list);
        require './app/templates/alquileresAdmin.phtml';
    }

    function mostrarAlquileres($list) {
        $count = count($list);
        require './app/templates/alquileres.phtml';
    }

    public function mostrarAlquiler($alquiler) {
        require './app/templates/alquiler.phtml';
    }

    public function mostrarError($error) {
        require './app/templates/error.phtml';
    }

    function mostrarFormAgregar($peliculas, $usuarios) {
        require './app/templates/alquilerForm.phtml';
    }

    function editarAlquiler($idAlquiler, $alquiler, $peliculas, $usuarios) {
        require './app/templates/alquilerEdit.phtml';
    }
}
