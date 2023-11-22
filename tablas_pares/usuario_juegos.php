<?php

require_once('../config/conexion.php');

try {
    // Extraer los datos de la base de datos db
    $queryDb = "
        SELECT 
            mv.vid AS id_videojuego,
            mp.pid AS id_proveedor,
            mu.uid AS id_usuario,
            COALESCE(mp.horas_juego, 0) AS horas_juego,
            CASE 
                WHEN mp.preorden IS TRUE THEN 'sí' 
                ELSE 'no' 
            END AS preordenado
        FROM 
            mala_videojuego_p AS mv
        JOIN 
            mala_proveedores_p AS mp ON mv.vid = mp.vid
        JOIN 
            mala_usuario_actividades_p AS mu ON mv.vid = mu.vid;
    ";
    $data = $db->query($queryDb)->fetchAll(PDO::FETCH_ASSOC);

    // Crear la tabla en db56 y luego insertar los datos
    $db56->beginTransaction();

    // Asegúrate de que la tabla Usuario_Juegos no exista antes de crearla
    $db56->exec("CREATE TABLE IF NOT EXISTS Usuario_Juegos (id_videojuego INT, id_proveedor INT, id_usuario INT, horas_juego INT, preordenado TEXT);");

    // Preparar consulta para insertar datos en Usuario_Juegos
    $insertQuery = $db56->prepare("INSERT INTO Usuario_Juegos (id_videojuego, id_proveedor, id_usuario, horas_juego, preordenado) VALUES (:id_videojuego, :id_proveedor, :id_usuario, :horas_juego, :preordenado);");

    foreach ($data as $row) {
        $insertQuery->execute([
            ':id_videojuego' => $row['id_videojuego'], 
            ':id_proveedor' => $row['id_proveedor'], 
            ':id_usuario' => $row['id_usuario'], 
            ':horas_juego' => $row['horas_juego'], 
            ':preordenado' => $row['preordenado']
        ]);
        if ($insertQuery->rowCount() == 0) {
            throw new Exception("Error al insertar los datos en Usuario_Juegos");
        }
    }

    $db56->commit();

    echo "La tabla 'Usuario_Juegos' ha sido creada con éxito en la base de datos db56.";

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>
