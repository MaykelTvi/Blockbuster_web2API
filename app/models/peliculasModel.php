<?php
require_once 'config.php';

class peliculasModel {
    private $db;

    function __construct(){
        $this->db = new PDO('mysql:host='.MYSQL_HOST.';dbname='.MYSQL_DB.';charset=utf8', MYSQL_USER, MYSQL_PASS);
    }

    function obtenerPeliculas($sort = 'titulo', $order = 'ASC') {
        $campos_validos = ['titulo', 'director', 'id_genero', 'alquilada'];
        $order = $order === 'DESC' ? 'DESC' : 'ASC';
        if (!in_array($sort, $campos_validos)) {
            $sort = 'titulo';
        }
        $query = $this->db->prepare("SELECT * FROM peliculas ORDER BY $sort $order");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    function mostrarPelicula($idPelicula) {
        $query = $this->db->prepare('SELECT * FROM peliculas WHERE id_pelicula = ?');
        $query->execute([$idPelicula]);
        return $query->fetch(PDO::FETCH_OBJ);
    }

    function insertarPelicula($titulo, $director, $id_genero, $alquilada){
        $query = $this->db->prepare('INSERT INTO peliculas(titulo, director, id_genero, alquilada) VALUES(?,?,?,?)');
        $query->execute([$titulo, $director, $id_genero, $alquilada]);
        return $this->db->lastInsertId();
    }

    function actualizarPelicula($idPelicula, $newTitulo, $newDirector, $newGenero, $newAlquilada){
        $query = $this->db->prepare('UPDATE peliculas SET titulo = ?, director = ?, id_genero = ?, alquilada = ? WHERE id_pelicula = ?');
        $query->execute([$newTitulo, $newDirector, $newGenero, $newAlquilada, $idPelicula]);
    }

    function removerPelicula($idPelicula){
        $query = $this->db->prepare('DELETE FROM peliculas WHERE id_pelicula = ?');
        $query->execute([$idPelicula]);
    }
}
