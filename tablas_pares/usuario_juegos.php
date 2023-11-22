<?php

require_once('../config/conexion.php');

try {
    $db->beginTransaction();

    $query = "
        CREATE TABLE Usuario_Juegos AS
        SELECT DISTINCT vid AS id_videojuego, pid AS id_proveedor, uid AS id_usuario
        FROM mala_usuario_proveedores_p;
    ";

    $db->exec($query);
    $db->commit();

    echo "La tabla 'Usuario_Juegos' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}

?>