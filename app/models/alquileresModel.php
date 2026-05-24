<?php

class alquileresModel {
    private $db;

    function __construct() {
        $this->db = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB.';charset=utf8', MYSQL_USER, MYSQL_PASS);
    }

    function obtenerAlquileres() {
        // JOIN para traer titulo de pelicula y usuario junto al alquiler
        $query = $this->db->prepare(
            'SELECT a.*, p.titulo, u.usuario 
             FROM alquileres a
             JOIN peliculas p ON a.id_pelicula = p.id_pelicula
             JOIN usuarios u ON a.id_usuario = u.id_usuario'
        );
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function insertarAlquiler($idPelicula, $idUsuario, $fecha) {
        $query = $this->db->prepare('INSERT INTO alquileres(id_pelicula, id_usuario, fecha_alquiler) VALUES(?,?,?)');
        $query->execute(array($idPelicula, $idUsuario, $fecha));

        // Marcar la película como alquilada
        $upd = $this->db->prepare('UPDATE peliculas SET alquilada = 1 WHERE id_pelicula = ?');
        $upd->execute([$idPelicula]);

        return $this->db->lastInsertId();
    }

    function eliminarAlquiler($idAlquiler) {
        // Obtener id_pelicula antes de borrar para librarla
        $q = $this->db->prepare('SELECT id_pelicula FROM alquileres WHERE id_alquiler = ?');
        $q->execute([$idAlquiler]);
        $alquiler = $q->fetch(PDO::FETCH_OBJ);

        $query = $this->db->prepare('DELETE FROM alquileres WHERE id_alquiler = ?');
        $query->execute([$idAlquiler]);

        // Liberar la película
        if ($alquiler) {
            $upd = $this->db->prepare('UPDATE peliculas SET alquilada = 0 WHERE id_pelicula = ?');
            $upd->execute([$alquiler->id_pelicula]);
        }
    }

    function mostrarAlquiler($idAlquiler) {
        $query = $this->db->prepare(
            'SELECT a.*, p.titulo, u.usuario 
             FROM alquileres a
             JOIN peliculas p ON a.id_pelicula = p.id_pelicula
             JOIN usuarios u ON a.id_usuario = u.id_usuario
             WHERE a.id_alquiler = ?'
        );
        $query->execute(array($idAlquiler));
        return $query->fetch(PDO::FETCH_OBJ);
    }

    function actualizarAlquiler($id, $newIdPelicula, $newIdUsuario, $newFecha) {
        $query = $this->db->prepare(
            "UPDATE alquileres 
             SET id_pelicula = ?, id_usuario = ?, fecha_alquiler = ? 
             WHERE id_alquiler = ?"
        );
        $query->execute(array($newIdPelicula, $newIdUsuario, $newFecha, $id));
    }

    // Traer solo películas disponibles (para el select al alquilar)
    function obtenerPeliculasDisponibles() {
        $query = $this->db->prepare('SELECT * FROM peliculas WHERE alquilada = 0');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    // Traer todos los usuarios (para el select al alquilar)
    function obtenerUsuarios() {
        $query = $this->db->prepare('SELECT id_usuario, usuario FROM usuarios');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}
