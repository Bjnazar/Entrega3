<?php

require_once('../config/conexion.php');

try {
    $db56->beginTransaction();

    $query = "
        CREATE TABLE Juego_Proveedor AS
        SELECT 
            pid AS id_juego, 
            vid AS id_proveedor, 
            precio, 
            precio_preorden 
        FROM mala_proveedores_p;
    ";

    $db56->exec($query);
    $db56->commit();

    echo "La tabla 'Juego_Proveedor' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error: " . $e->getMessage();
}

?>