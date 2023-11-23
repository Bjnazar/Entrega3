<?php

require_once('../config/conexion.php');

try {
    // Seleccionar datos de la tabla original
    $queryVideojuegos = "
        SELECT DISTINCT vid AS id_videojuego, titulo, puntuacion, clasificacion, fecha_de_lanzamiento, 
        CASE 
            WHEN mensualidad IS NOT NULL THEN 'subscripción' 
            ELSE 'pago único' 
        END AS adquisicion
        FROM mala_videojuego_p;
    ";

    $resultVideojuegos = $db->query($queryVideojuegos);
    $videojuegos = $resultVideojuegos->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si hay datos para insertar
    if (count($videojuegos) > 0) {
        $db56->beginTransaction();

        // Crear la tabla en db56 si no existe
        $db56->exec("CREATE TABLE IF NOT EXISTS Videojuegos (
            id SERIAL PRIMARY KEY,
            titulo TEXT NOT NULL,
            puntuacion FLOAT,
            clasificacion TEXT,
            fecha_de_lanzamiento DATE,
            adquisicion TEXT
        );");

        $insertQuery = $db56->prepare("INSERT INTO Videojuegos (
            id, titulo, puntuacion, clasificacion, fecha_de_lanzamiento, adquisicion
        ) VALUES (
            :id, :titulo, :puntuacion, :clasificacion, :fecha_de_lanzamiento, :adquisicion
        );");

        // Insertar datos en la nueva tabla
        foreach ($videojuegos as $row) {
            $insertQuery->execute([
                ':id' => $row['id_videojuego'],
                ':titulo' => $row['titulo'],
                ':puntuacion' => $row['puntuacion'],
                ':clasificacion' => $row['clasificacion'],
                ':fecha_de_lanzamiento' => $row['fecha_de_lanzamiento'],
                ':adquisicion' => $row['adquisicion'],
            ]);

            if ($insertQuery->rowCount() == 0) {
                throw new Exception("Error al insertar el videojuego con ID: " . $row['id_videojuego']);
            }
        }

        $db56->commit();
        echo "La tabla 'Videojuegos' ha sido creada con éxito en la base de datos db56.";
    } else {
        echo "No hay datos para insertar en la tabla 'Videojuegos'.";
    }

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>
