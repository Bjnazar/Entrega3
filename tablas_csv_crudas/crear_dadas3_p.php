<?php

require_once('../config/conexion.php');

try {
    $db56->beginTransaction();

    // Verificar y eliminar la tabla si existe
    $drop_table_query = "DROP TABLE IF EXISTS mala_proveedores_p;";
    $db56->exec($drop_table_query);

    // Crear la nueva tabla
    $create_table_query = "
        CREATE TABLE mala_proveedores_p (
            pid INT NOT NULL,
            nombre TEXT NOT NULL,
            plataforma TEXT NOT NULL,
            vid INT NOT NULL,
            precio FLOAT,
            precio_preorden FLOAT
        );
    ";

    $db56->exec($create_table_query);

    $db56->commit();

    echo "La tabla mala_proveedores_p fue creada correctamente.";

} catch (Exception $e) {
    $db56->rollBack();
    echo "Error: " . $e->getMessage();
}

?>
