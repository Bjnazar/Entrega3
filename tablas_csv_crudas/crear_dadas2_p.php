<?php

require_once('../config/conexion.php');

try {
    $db56->beginTransaction();

    $create_table_query = "
        CREATE TABLE mala_pagos_p (
            pagoid INT NOT NULL,
            monto FLOAT NOT NULL,
            fecha DATE NOT NULL,
            uid INT NOT NULL,
            preorden BOOLEAN,
            pid INT,
            vid INT,
            sid INT,
            CONSTRAINT chk_fecha CHECK (fecha <= CURRENT_DATE)
 );
    ";

    $db56->exec($create_table_query);

    $db56->commit();

    echo "La tabla mala_pagos_p fue creada correctamente.";

} catch (Exception $e) {
    $db56->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
