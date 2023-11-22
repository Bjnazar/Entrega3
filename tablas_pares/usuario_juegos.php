<?php

require_once('../config/conexion.php');

try {
    $db->beginTransaction();

    $query = "
        CREATE TABLE Usuario_Juegos AS
        SELECT 
            mv.vid AS id_videojuego,
            mp.pid AS id_proveedor,  // Asumiendo que existe una relación entre juegos y proveedores
            mu.uid AS id_usuario,   // Asumiendo que existe una relación entre juegos y usuarios
            COALESCE(mp.horas_juego, 0) AS horas_juego, // Asumiendo que 'horas_juego' es un campo en 'mala_proveedores_p' o tabla similar
            CASE 
                WHEN mp.preorden IS TRUE THEN 'sí' 
                ELSE 'no' 
            END AS preordenado
        FROM 
            mala_videojuegos mv
        JOIN 
            mala_proveedores_p mp ON mv.vid = mp.vid
        JOIN 
            mala_usuarios_actividades_p mu ON mv.vid = mu.vid;
    ";

    $db->exec($query);
    $db->commit();

    echo "La tabla 'Usuario_Juegos' ha sido creada con éxito.";

} catch (PDOException $e) {
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}

?>