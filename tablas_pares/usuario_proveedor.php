<?php

require_once('../config/conexion.php');

try {
    $db->beginTransaction();

    $query = "
        CREATE TABLE Usuario_Proveedor AS
        SELECT DISTINCT uid AS id_usuario, pid AS id_proveedor
        FROM mala_usuario_proveedores_p;
    ";

    $db->exec($query);
    $db->commit();

    echo "La tabla 'Usuario_Proveedor' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}

?>