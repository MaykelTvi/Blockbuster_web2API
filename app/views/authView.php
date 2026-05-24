<?php

class AuthView {
    public function showLogin($error = null) {
        require './app/templates/login.phtml';
    }
    public function showError($error = null) {
        require './app/templates/error.phtml';
    }
}
