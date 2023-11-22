<?php

require_once('../config/conexion.php');

try {
    $db->beginTransaction();

    $query = "
        CREATE TABLE Pagos_Suscripciones_p AS
        SELECT DISTINCT uid AS id_usuario, vid AS id_juego, pid AS id_proveedor, fecha
        FROM mala_pago_p;
    ";

    $db->exec($query);
    $db->commit();

    echo "La tabla 'Pagos_Suscripciones' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}

?>