<?php

require_once('../config/conexion.php');

try {
    $db56->beginTransaction();

    // Eliminar todos los registros existentes en la tabla mala_proveedores_p
    $delete_query = "DELETE FROM mala_proveedores_p";
    $db56->exec($delete_query);

    $file_path = '/home/grupo55/Sites/datos_par/p_proveedores.csv';
    echo "Intentando abrir el archivo: $file_path\n";

    if (!file_exists($file_path)) {
        echo "Error: El archivo $file_path no existe.";
    } else {
        $file = fopen($file_path, 'r');

        if ($file !== false) {
            // Omitir la primera fila (encabezado)
            fgetcsv($file);

            while (($row = fgetcsv($file)) !== false) {
                $pid = $row[0];
                $nombre = $row[1];
                $plataforma = $row[2];
                $vid = $row[3];
                
                // Verificar si el valor de 'precio' es válido
                $precio = ($row[4] !== '' && floatval($row[4]) !== 0) ? $row[4] : null;

                // Verificar si el valor de 'precio_preorden' es válido
                $precio_preorden = ($row[5] !== '' && floatval($row[5]) !== 0) ? $row[5] : null;

                $insert_query = "
                    INSERT INTO mala_proveedores_p (pid, nombre, plataforma, vid, precio, precio_preorden)
                    VALUES (:pid, :nombre, :plataforma, :vid, :precio, :precio_preorden);
                ";

                $stmt = $db56->prepare($insert_query);
                $stmt->bindParam(':pid', $pid);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':plataforma', $plataforma);
                $stmt->bindParam(':vid', $vid);
                $stmt->bindParam(':precio', $precio);
                $stmt->bindParam(':precio_preorden', $precio_preorden);
                $stmt->execute();
            }

            fclose($file);

            $db56->commit();

            echo "Datos insertados correctamente en la tabla mala_proveedores_p.";
        } else {
            echo "Error: No se pudo abrir el archivo $file_path.";
        }
    }
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
