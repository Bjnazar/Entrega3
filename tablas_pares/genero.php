<?php

require_once('../config/conexion.php');

try {
    $db56->beginTransaction();

    $query = "
        CREATE TABLE Genero_p AS
        SELECT DENSE_RANK() OVER (ORDER BY genero) id_genero, genero
        FROM (SELECT DISTINCT genero FROM mala_genero_p) AS subquery;
    ";

    $db56->exec($query);
    $db56->commit();

    $queryAddPrimaryKey = "
        ALTER TABLE Genero_p
        ADD PRIMARY KEY (id_genero);
    ";

    $db56->exec($queryAddPrimaryKey);

    $db56->commit();

    echo "La tabla 'Genero' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error: " . $e->getMessage();
}

?>