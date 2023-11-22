<?php

require_once('../config/conexion.php');

try {
    $db->beginTransaction();

    // Eliminar todos los registros existentes en la tabla mala_pagos_p
    $delete_query = "DELETE FROM mala_pagos_p";
    $db->exec($delete_query);

    $file_path = '/home/grupo55/Sites/datos_par/p_pagos.csv';
    echo "Intentando abrir el archivo: $file_path\n";

    if (!file_exists($file_path)) {
        echo "Error: El archivo $file_path no existe.";
    } else {
        $file = fopen($file_path, 'r');

        if ($file !== false) {
            // Omitir la primera fila (encabezado)
            fgetcsv($file);

            while (($row = fgetcsv($file)) !== false) {
                $pagoid = $row[0];
                $monto = $row[1];
                $fecha = DateTime::createFromFormat('j/n/Y', $row[2]);  // Convertir la fecha al formato correcto
                $fecha = $fecha ? $fecha->format('Y-m-d') : null;
                $uid = $row[3];
                $preorden = !empty($row[4]) ? $row[4] : null;
                $pid = !empty($row[5]) ? $row[5] : null;
                $vid = !empty($row[6]) ? $row[6] : null;
                $sid = !empty($row[7]) ? $row[7] : null;

                $insert_query = "
                    INSERT INTO mala_pagos_p (pagoid, monto, fecha, uid, preorden, pid, vid, sid)
                    VALUES (:pagoid, :monto, :fecha, :uid, :preorden, :pid, :vid, :sid);
                ";

                $stmt = $db->prepare($insert_query);
                $stmt->bindParam(':pagoid', $pagoid);
                $stmt->bindParam(':monto', $monto);
                $stmt->bindParam(':fecha', $fecha);
                $stmt->bindParam(':uid', $uid);
                $stmt->bindParam(':preorden', $preorden);
                $stmt->bindParam(':pid', $pid);
                $stmt->bindParam(':vid', $vid);
                $stmt->bindParam(':sid', $sid);
                $stmt->execute();
            }

            fclose($file);

            $db->commit();

            echo "Datos insertados correctamente en la tabla mala_pagos_p.";
        } else {
            echo "Error: No se pudo abrir el archivo $file_path.";
        }
    }
} catch (Exception $e) {
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
