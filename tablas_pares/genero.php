<?php

require_once('../config/conexion.php');

try {
    $db->beginTransaction();

    $query = "
        CREATE TABLE Genero_p AS
        SELECT DISTINCT id_genero, nombre_genero
        FROM mala_genero_subgenero_p;
    ";

    $db->exec($query);
    $db->commit();

    echo "La tabla 'Genero' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}

?>