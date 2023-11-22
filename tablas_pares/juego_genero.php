<?php

require_once('../config/conexion.php');

try {
    $db->beginTransaction();

    $query = "
        CREATE TABLE Juego_Genero AS
        SELECT DISTINCT vid AS id_juego, id_genero
        FROM mala_videojuego_genero_p;
    ";

    $db->exec($query);
    $db->commit();

    echo "La tabla 'Juego_Genero' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}

?>