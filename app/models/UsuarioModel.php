<?php
require_once './config.php';

class UsuarioModel {
    private PDO $db;

    function __construct() {
        $this->db = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB.';charset=utf8', MYSQL_USER, MYSQL_PASS);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function obtenerUsuarios() {
        $query = $this->db->prepare('SELECT * FROM usuarios');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function insertarUsuario(string $usuario, string $password, int $admin) {
        $hash  = password_hash($password, PASSWORD_DEFAULT);
        $query = $this->db->prepare('INSERT INTO usuarios(usuario, password, admin) VALUES(?, ?, ?)');
        $query->execute([$usuario, $hash, $admin]);
        return $this->db->lastInsertId();
    }

    public function removerUsuario(int $idUsuario) {
        $query = $this->db->prepare('DELETE FROM usuarios WHERE id_usuario = ?');
        $query->execute([$idUsuario]);
    }

    public function mostrarUsuario(int $idUsuario) {
        $query = $this->db->prepare('SELECT id_usuario, usuario, admin FROM usuarios WHERE id_usuario = ?');
        $query->execute([$idUsuario]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function actualizarUsuario(int $idUsuario, string $usuario, int $admin) {
        $query = $this->db->prepare("UPDATE usuarios SET usuario = ?, admin = ? WHERE id_usuario = ?");
        $query->execute([$usuario, $admin, $idUsuario]);
    }

    public function getByUser(string $usuario) {
        $query = $this->db->prepare('SELECT * FROM usuarios WHERE usuario = ?');
        $query->execute([$usuario]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function isAdmin(int $id) {
        $query = $this->db->prepare('SELECT admin FROM usuarios WHERE id_usuario = ?');
        $query->execute([$id]);
        $user = $query->fetch(PDO::FETCH_OBJ);
        return $user ? $user->admin : false;
    }
}
