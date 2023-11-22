<?php

require_once('../config/conexion.php');

try {
    $db56->beginTransaction();

    // Eliminar la tabla mala_videojuego_p si ya existe
    $drop_table_query = "DROP TABLE IF EXISTS mala_videojuego_p";
    $db56->exec($drop_table_query);

    // Crear la tabla mala_videojuego_p
    $create_table_query = "
        CREATE TABLE mala_videojuego_p (
            vid INT NOT NULL,
            titulo TEXT NOT NULL,
            puntuacion FLOAT NOT NULL,
            clasificacion TEXT NOT NULL,
            fecha_de_lanzamiento DATE NOT NULL,
            beneficio_preorden TEXT,
            mensualidad FLOAT,
            nombre TEXT NOT NULL
        );
    ";

    $db56->exec($create_table_query);

    $db56->commit();

    echo "La tabla mala_videojuego_p fue creada correctamente.";

} catch (Exception $e) {
    $db56->rollBack();
    echo "Error: " . $e->getMessage();
}

?>
