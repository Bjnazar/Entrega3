<?php

require_once('../config/conexion.php');

try {
    $db->beginTransaction();

    $query = "
        CREATE TABLE Resenas AS
        SELECT DISTINCT uid AS id_resena, vid AS id_videojuego, titulo, texto, veredicto
        FROM mala_usuarios_actividades_p;
    ";

    $db->exec($query);
    $db->commit();

    echo "La tabla 'Resenas' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}

?>