<?php

require_once('../config/conexion.php');

try {
    $db56->beginTransaction();

    // Eliminar la tabla mala_subscripciones_p si existe
    $drop_table_query = "DROP TABLE IF EXISTS mala_subscripciones_p";
    $db56->exec($drop_table_query);

    // Crear la tabla mala_subscripciones_p
    $create_table_query = "
        CREATE TABLE mala_subscripciones_p (
            sid INT NOT NULL,
            estado BOOLEAN NOT NULL,
            fecha_inicio DATE NOT NULL CHECK (fecha_inicio <= CURRENT_DATE),
            uid INT NOT NULL,
            fecha_termino DATE NOT NULL CHECK (fecha_termino > fecha_inicio + INTERVAL '1 month'),
            vid INT NOT NULL,
            mensualidad FLOAT NOT NULL
        );
    ";
    $db56->exec($create_table_query);

    $db56->commit();

    echo "La tabla mala_subscripciones_p fue creada correctamente.";

} catch (Exception $e) {
    $db56->rollBack();
    echo "Error: " . $e->getMessage();
}

?>
