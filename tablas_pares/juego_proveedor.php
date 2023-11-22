<?php

require_once('../config/conexion.php');

try {
    $db->beginTransaction();

    $query = "
        CREATE TABLE Juego_Proveedor AS
        SELECT DISTINCT vid AS id_juego, pid AS id_proveedor, precio, precio_preorden
        FROM mala_proveedores_p;
    ";

    $db->exec($query);
    $db->commit();

    echo "La tabla 'Juego_Proveedor' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}

?>