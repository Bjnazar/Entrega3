<?php

require_once('../config/conexion.php');

try {
    $db->beginTransaction();

    $query = "
        CREATE TABLE Proveedores_Plataforma AS
        SELECT DISTINCT pid AS id_proveedor, vid AS id_juego, plataforma AS nombre_plataforma
        FROM mala_proveedores_p;
    ";

    $db->exec($query);
    $db->commit();

    echo "La tabla 'Proveedores_Plataforma' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}

?>