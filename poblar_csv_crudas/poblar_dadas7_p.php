<?php

require_once('../config/conexion.php');

try {
    $db56->beginTransaction();

    // Eliminar todos los registros existentes en la tabla mala_videojuego_p
    $delete_query = "DELETE FROM mala_videojuego_p";
    $db56->exec($delete_query);

    $file_path = '/home/grupo55/Sites/datos_par/p_videojuego.csv';
    echo "Intentando abrir el archivo: $file_path\n";

    if (!file_exists($file_path)) {
        echo "Error: El archivo $file_path no existe.";
    } else {
        $file = fopen($file_path, 'r');

        if ($file !== false) {
            // Omitir la primera fila (encabezado)
            fgetcsv($file);

            while (($row = fgetcsv($file)) !== false) {
                $vid = $row[0];
                $titulo = $row[1];
                $puntuacion = $row[2];
                $clasificacion = $row[3];

                // Convertir el valor de 'fecha_de_lanzamiento' al formato correcto
                $fecha_de_lanzamiento = DateTime::createFromFormat('d/m/Y', $row[4]);
                $fecha_de_lanzamiento = $fecha_de_lanzamiento ? $fecha_de_lanzamiento->format('Y-m-d') : null;

                $beneficio_preorden = $row[5];

                // Verificar si la mensualidad es vacía y asignar null en ese caso
                $mensualidad = ($row[6] !== '') ? $row[6] : null;

                $nombre = $row[7];

                $insert_query = "
                    INSERT INTO mala_videojuego_p (vid, titulo, puntuacion, clasificacion, fecha_de_lanzamiento, beneficio_preorden, mensualidad, nombre)
                    VALUES (:vid, :titulo, :puntuacion, :clasificacion, :fecha_de_lanzamiento, :beneficio_preorden, :mensualidad, :nombre);
                ";

                $stmt = $db56->prepare($insert_query);
                $stmt->bindParam(':vid', $vid);
                $stmt->bindParam(':titulo', $titulo);
                $stmt->bindParam(':puntuacion', $puntuacion);
                $stmt->bindParam(':clasificacion', $clasificacion);
                $stmt->bindParam(':fecha_de_lanzamiento', $fecha_de_lanzamiento);
                $stmt->bindParam(':beneficio_preorden', $beneficio_preorden);
                $stmt->bindParam(':mensualidad', $mensualidad);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->execute();
            }

            fclose($file);

            $db56->commit();

            echo "Datos insertados correctamente en la tabla mala_videojuego_p.";
        } else {
            echo "Error: No se pudo abrir el archivo $file_path.";
        }
    }
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error: " . $e->getMessage();
}

?>
