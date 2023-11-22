<?php

require_once('../config/conexion.php');

try {
    $db56->beginTransaction();

    // Eliminar la tabla si existe
    $drop_table_query = "DROP TABLE IF EXISTS mala_videojuego_genero_p;";
    $db56->exec($drop_table_query);

    // Crear la nueva tabla
    $create_table_query = "
        CREATE TABLE mala_videojuego_genero_p (
            vid INT NOT NULL,
            nombre TEXT NOT NULL
        );
    ";

    $db56->exec($create_table_query);

    $db56->commit();

    echo "La tabla mala_videojuego_genero_p fue creada correctamente.";

} catch (Exception $e) {
    $db56->rollBack();
    echo "Error: " . $e->getMessage();
}

?>

