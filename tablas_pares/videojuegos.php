<?php

require_once('../config/conexion.php');

try {
    $db->beginTransaction();

    $query = "
        CREATE TABLE Videojuegos AS
        SELECT DISTINCT vid AS id_videojuego, titulo, puntuacion, clasificacion, fecha_de_lanzamiento, 
        CASE 
            WHEN mensualidad IS NOT NULL THEN 'subscripción' 
            WHEN precio IS NOT NULL THEN 'pago único' 
            ELSE 'gratis' 
        END AS adquisicion
        FROM mala_videojuego_p;
    ";

    $db->exec($query);
    $db->commit();

    echo "La tabla 'Videojuegos' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}

?>