<?php

require_once('../config/conexion.php');

try {
    $db->beginTransaction();

    $query = "
        CREATE TABLE Proveedor_p AS
        SELECT DISTINCT pid AS id_proveedor, nombre
        FROM mala_proveedores_p;
    ";

    $db->exec($query);
    $db->commit();

    echo "La tabla 'Proveedor' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}

?>