<?php

class usuariosView {
    function __construct() {}

    function mostrarAdminUsuarios($list) {
        require './app/templates/usuariosAdmin.phtml';
    }

    function editarUsuario($idUsuario, $usuario) {
        require './app/templates/usuariosEdit.phtml';
    }

    function mostrarError($error) {
        require './app/templates/error.phtml';
    }
}
