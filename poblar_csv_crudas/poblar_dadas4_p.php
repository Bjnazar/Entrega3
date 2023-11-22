<?php

require_once('../config/conexion.php');

try {
    $db56->beginTransaction();

    // Eliminar todos los registros existentes en la tabla mala_usuario_proveedor_p
    $delete_query = "DELETE FROM mala_usuario_proveedor_p";
    $db56->exec($delete_query);

    $file_path = '/home/grupo55/Sites/datos_par/p_usuario_proveedor.csv'; // Cambiar a la ruta correcta
    echo "Intentando abrir el archivo: $file_path\n";

    if (!file_exists($file_path)) {
        echo "Error: El archivo $file_path no existe.";
    } else {
        $file = fopen($file_path, 'r');

        if ($file !== false) {
            // Omitir la primera fila (encabezado)
            fgetcsv($file);

            while (($row = fgetcsv($file)) !== false) {
                $uid = $row[0];
                $pid = $row[1];

                $insert_query = "
                    INSERT INTO mala_usuario_proveedor_p (uid,pid)
                    VALUES (:uid, :pid);
                ";

                $stmt = $db56->prepare($insert_query);
                $stmt->bindParam(':uid', $uid, PDO::PARAM_INT);
                $stmt->bindParam(':pid', $pid, PDO::PARAM_INT);
                $stmt->execute();
            }

            fclose($file);

            $db56->commit();

            echo "Datos insertados correctamente en la tabla mala_usuario_proveedor_p.";
        } else {
            echo "Error: No se pudo abrir el archivo $file_path.";
        }
    }
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error: " . $e->getMessage();
}

?>
