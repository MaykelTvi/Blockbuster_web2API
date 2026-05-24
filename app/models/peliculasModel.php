<?php
require_once 'config.php';

class peliculasModel {
    private $db;

    function __construct(){
        $this->db = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB.';charset=utf8', MYSQL_USER, MYSQL_PASS);
    }

    function obtenerPeliculas() {
        $query = $this->db->prepare('SELECT * FROM peliculas');
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function insertarPelicula($titulo, $director, $alquilada, $imagen){
        $query = $this->db->prepare('INSERT INTO peliculas(titulo, director, alquilada, imagen) VALUES(?,?,?,?)');
        $query->execute(array($titulo, $director, $alquilada, $imagen));
        return $this->db->lastInsertId();
    }

    function removerPelicula($idPelicula){
        $query = $this->db->prepare('DELETE FROM peliculas WHERE id_pelicula = ?');
        $query->execute([$idPelicula]);
    }

    function mostrarPelicula($idPelicula) {
        $query = $this->db->prepare('SELECT titulo, director, alquilada, imagen FROM peliculas WHERE id_pelicula = ?');
        $query->execute(array($idPelicula));
        return $query->fetch(PDO::FETCH_OBJ);
    }

    function actualizarPelicula($idPelicula, $newTitulo, $newDirector, $newAlquilada, $newImagen = null){
        if ($newImagen) {
            $query = $this->db->prepare("UPDATE peliculas SET titulo=?, director=?, alquilada=?, imagen=? WHERE id_pelicula = ?");
            $query->execute(array($newTitulo, $newDirector, $newAlquilada, $newImagen, $idPelicula));
        } else {
            $query = $this->db->prepare("UPDATE peliculas SET titulo=?, director=?, alquilada=? WHERE id_pelicula = ?");
            $query->execute(array($newTitulo, $newDirector, $newAlquilada, $idPelicula));
        }
    }
}
