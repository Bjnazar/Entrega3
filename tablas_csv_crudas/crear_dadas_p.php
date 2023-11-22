<?php

require_once('/home/grupo55/Sites/config/conexion.php');

try {
    $db56->beginTransaction();
    
    $create_table_query = "
        CREATE TABLE mala_genero_p (
            genero TEXT NOT NULL,
            subgenero TEXT,
            CONSTRAINT chk_genero_subgenero CHECK (genero <> subgenero)
        );
    ";
    
    $db56->exec($create_table_query);
    $db56->commit();
    
    echo "La tabla mala_genero_p fue creada correctamente.";

} catch (Exception $e) {
    $db56->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
