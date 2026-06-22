<?php
require_once 'config.php';

class alquileresModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB.';charset=utf8', MYSQL_USER, MYSQL_PASS);
    }

    function obtenerAlquileres($sort = 'fecha_alquiler', $order = 'ASC') {
        $campos_validos = ['fecha_alquiler', 'id_pelicula', 'id_usuario'];
        $order = $order === 'DESC' ? 'DESC' : 'ASC';
        if (!in_array($sort, $campos_validos)) {
            $sort = 'fecha_alquiler';
        }
        $query = $this->db->prepare("SELECT * FROM alquileres ORDER BY $sort $order");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function mostrarAlquiler($idAlquiler) {
        $query = $this->db->prepare('SELECT * FROM alquileres WHERE id_alquiler = ?');
        $query->execute([$idAlquiler]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    function insertarAlquiler($idPelicula, $idUsuario, $fecha) {
        $query = $this->db->prepare('INSERT INTO alquileres(id_pelicula, id_usuario, fecha_alquiler) VALUES(?,?,?)');
        $query->execute([$idPelicula, $idUsuario, $fecha]);
        return $this->db->lastInsertId();
    }

    function actualizarAlquiler($id, $newIdPelicula, $newIdUsuario, $newFecha) {
        $query = $this->db->prepare('UPDATE alquileres SET id_pelicula = ?, id_usuario = ?, fecha_alquiler = ? WHERE id_alquiler = ?');
        $query->execute([$newIdPelicula, $newIdUsuario, $newFecha, $id]);
    }

    function eliminarAlquiler($idAlquiler) {
        $query = $this->db->prepare('DELETE FROM alquileres WHERE id_alquiler = ?');
        $query->execute([$idAlquiler]);
    }
}
