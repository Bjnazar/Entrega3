<?php

require_once('../config/conexion.php');

try {
    $db->beginTransaction();

    $query = "
        CREATE TABLE Juego_subGenero AS
        SELECT DISTINCT vid AS id_juego, id_subgenero
        FROM mala_genero_subgenero_p WHERE vid IS NOT NULL;
    ";

    $db->exec($query);
    $db->commit();

    echo "La tabla 'Juego_subGenero' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}

?>