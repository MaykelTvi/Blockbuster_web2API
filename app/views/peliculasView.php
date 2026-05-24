<?php

class peliculasView {
    function __construct(){}

    function mostrarAdminPeliculas($list) {
        $count = count($list);
        require './app/templates/peliculasAdmin.phtml';
    }

    function mostrarPeliculas($list) {
        $count = count($list);
        require './app/templates/peliculas.phtml';
    }

    public function mostrarPelicula($pelicula) {
        require './app/templates/pelicula.phtml';
    }

    public function mostrarError($error) {
        require './app/templates/error.phtml';
    }

    function editarPelicula($idPelicula, $pelicula) {
        require './app/templates/peliculasEdit.phtml';
    }
}
