# Blockbuster_web2API
**Integrante: Maykel Tvihaug**

Rutas para peliculas

Listar todas las peliculas
Metodo: GET
Ruta completa: http://localhost/Blockbuster_web2API/api/peliculas

Query Params Opcionales:
sort: http://localhost/Blockbuster_web2API/api/peliculas?sort=titulo
order: http://localhost/Blockbuster_web2API/api/peliculas?order=DESC
ambos: http://localhost/Blockbuster_web2API/api/peliculas?sort=director&order=DESC

Obtener una pelicula por su ID
Metodo: GET
Ruta completa: http://localhost/Blockbuster_web2API/api/peliculas/:ID

Agregar una nueva pelicula
Metodo: POST
Ruta completa: http://localhost/Blockbuster_web2API/api/pelicula
{
    "titulo": "Titulo",
    "director": "Director",
    "id_genero": 1,
    "alquilada": (0 o 1)
}

Modificar una pelicula existente
Metodo: PUT
Ruta completa: http://localhost/Blockbuster_web2API/api/pelicula/:ID
{
    "titulo": "Nuevo Titulo",
    "director": "Nuevo Director",
    "id_genero": 1,
    "alquilada": (0 o 1)
}

Eliminar una pelicula
Metodo: DELETE
Ruta completa: http://localhost/Blockbuster_web2API/api/pelicula/:ID


Rutas para alquileres

Listar todos los alquileres
Metodo: GET
Ruta completa: http://localhost/Blockbuster_web2API/api/alquileres

Query Params Opcionales:
sort: http://localhost/Blockbuster_web2API/api/alquileres?sort=fecha_alquiler
order: http://localhost/Blockbuster_web2API/api/alquileres?order=DESC
ambos: http://localhost/Blockbuster_web2API/api/alquileres?sort=id_pelicula&order=ASC

Obtener un alquiler por su ID
Metodo: GET
Ruta completa: http://localhost/Blockbuster_web2API/api/alquileres/:ID

Agregar un nuevo alquiler
Metodo: POST
Ruta completa: http://localhost/Blockbuster_web2API/api/alquiler
{
    "id_pelicula": 1,
    "id_usuario": 2,
    "fecha_alquiler": "2026-01-01"
}

Modificar un alquiler existente
Metodo: PUT
Ruta completa: http://localhost/Blockbuster_web2API/api/alquiler/:ID
{
    "id_pelicula": 1,
    "id_usuario": 2,
    "fecha_alquiler": "2026-01-01"
}

Eliminar un alquiler
Metodo: DELETE
Ruta completa: http://localhost/Blockbuster_web2API/api/alquiler/:ID