<?php

require_once('../config/conexion.php');

try {
    $db->beginTransaction();

    $query = "
        CREATE TABLE Usuarios_p AS
        SELECT DISTINCT uid AS id_usuario, nombre, mail AS email, password AS contrasena
        FROM mala_usuarios_actividades_p;
    ";

    $db->exec($query);
    $db->commit();

    echo "La tabla 'Usuarios' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}

?>