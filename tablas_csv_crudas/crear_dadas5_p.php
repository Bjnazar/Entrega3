<?php

require_once('../config/conexion.php');

try {
    $db56->beginTransaction();

    // Eliminar la tabla si existe
    $drop_table_query = "DROP TABLE IF EXISTS mala_usuario_actividades_p";
    $db56->exec($drop_table_query);

    $create_table_query = "
        CREATE TABLE mala_usuario_actividades_p (
            uid INT NOT NULL,
            nombre TEXT NOT NULL,
            mail TEXT NOT NULL,
            password TEXT NOT NULL,
            username TEXT,
            vid INT,
            fecha_v DATE,
            cantidad FLOAT NOT NULL,
            veredicto BOOLEAN,
            titulo TEXT,
            texto TEXT,
            fecha_nacimiento DATE NOT NULL,
            CONSTRAINT chk_mail CHECK (CHAR_LENGTH(mail) >= 4 AND mail LIKE '%_@_%._%'),
            CONSTRAINT chk_fecha CHECK (fecha_v <= CURRENT_DATE)
        );
    ";

    $db56->exec($create_table_query);

    $db56->commit();

    echo "La tabla mala_usuario_actividades_p fue creada correctamente.";

} catch (Exception $e) {
    $db56->rollBack();
    echo "Error: " . $e->getMessage();
}

?>
