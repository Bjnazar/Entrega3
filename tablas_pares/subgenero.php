<?php

require_once('../config/conexion.php');

try {
    $db56->beginTransaction();

    $query = "
                CREATE TABLE SubGenero_p AS
                SELECT
                    ROW_NUMBER() OVER (ORDER BY subgenero) - 1 AS id,
                    subgenero
                FROM mala_genero_subgenero_p
                WHERE subgenero IS NOT NULL
                GROUP BY subgenero;
    ";

    $db56->exec($query);
    $db56->commit();

    echo "La tabla 'SubGenero' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error: " . $e->getMessage();
}

?>