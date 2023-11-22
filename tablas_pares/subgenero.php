<?php

require_once('../config/conexion.php');

try {
    $db->beginTransaction();

    $query = "
        CREATE TABLE SubGenero_p AS
        SELECT DISTINCT id_subgenero, nombre_subgenero, id_genero_padre
        FROM mala_genero_subgenero_p WHERE id_subgenero IS NOT NULL;
    ";

    $db->exec($query);
    $db->commit();

    echo "La tabla 'SubGenero' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}

?>