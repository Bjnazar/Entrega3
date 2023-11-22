<?php

require_once('../config/conexion.php');

try {
    $db56->beginTransaction();

    // Eliminar todos los registros existentes en la tabla
    $delete_query = "DELETE FROM mala_genero_p";
    $db56->exec($delete_query);

    $file_path = '/home/grupo55/Sites/datos_par/p_genero.csv';
    echo "Intentando abrir el archivo: $file_path\n";

    if (!file_exists($file_path)) {
        echo "Error: El archivo $file_path no existe.";
    } else {
        $file = fopen($file_path, 'r');

        if ($file !== false) {
            // Omitir la primera fila (encabezado)
            fgetcsv($file);

            while (($row = fgetcsv($file)) !== false) {
                $genero = $row[0];
                $subgenero = !empty($row[1]) ? $row[1] : null;

                $insert_query = "
                    INSERT INTO mala_genero_p (genero, subgenero)
                    VALUES (:genero, :subgenero);
                ";

                $stmt = $db56->prepare($insert_query);
                $stmt->bindParam(':genero', $genero);
                $stmt->bindParam(':subgenero', $subgenero);
                $stmt->execute();
            }

            fclose($file);

            $db56->commit();

            echo "Datos insertados correctamente en la tabla mala_genero_p.";
        } else {
            echo "Error: No se pudo abrir el archivo $file_path.";
        }
    }
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
