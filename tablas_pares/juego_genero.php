<?php

require_once('../config/conexion.php');

try {
    $db56->beginTransaction();

    $query = "
        CREATE TABLE Juego_Genero AS
        SELECT DISTINCT v.vid AS id_juego, g.id_genero
        FROM mala_videojuego_genero_p v
        JOIN Genero g ON v.nombre = g.nombre_genero;
    ";

    $db56->exec($query);
    $db56->commit();

    echo "La tabla 'Juego_Genero' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error: " . $e->getMessage();
}

?>