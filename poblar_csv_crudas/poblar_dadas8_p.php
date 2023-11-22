<?php

require_once('../config/conexion.php');

try {
    $db56->beginTransaction();

    // Eliminar todos los registros existentes en la tabla mala_subscripciones_p
    $delete_query = "DELETE FROM mala_subscripciones_p";
    $db56->exec($delete_query);

    $file_path = '/home/grupo55/Sites/datos_par/p_subscripciones.csv';
    echo "Intentando abrir el archivo: $file_path\n";

    if (!file_exists($file_path)) {
        echo "Error: El archivo $file_path no existe.";
    } else {
        $file = fopen($file_path, 'r');

        if ($file !== false) {
            // Omitir la primera fila (encabezado)
            fgetcsv($file);

            while (($row = fgetcsv($file)) !== false) {
                $sid = $row[0];
                $estado = strtolower($row[1]);
                
                // Convertir el valor de 'fecha_inicio' al formato correcto
                $fecha_inicio = DateTime::createFromFormat('d/m/Y', $row[2]);
                $fecha_inicio = $fecha_inicio ? $fecha_inicio->format('Y-m-d') : null;

                $uid = $row[3];

                // Convertir el valor de 'fecha_termino' al formato correcto
                $fecha_termino = DateTime::createFromFormat('d/m/Y', $row[4]);
                $fecha_termino = $fecha_termino ? $fecha_termino->format('Y-m-d') : null;

                $vid = $row[5];

                $mensualidad = ($row[6] !== '') ? floatval($row[6]) : null;

                // Verificar el valor de 'estado'
                if ($estado == 'active') {
                    $estado_bool = true;
                } elseif ($estado == 'canceled') {
                    $estado_bool = false;
                } else {
                    echo "Error: El valor de 'estado' en la fila con SID $sid no es válido.\n";
                    continue; // Saltar a la siguiente iteración del bucle
                }

                // Verificar si las fechas cumplen con la restricción
                if ($fecha_inicio !== null && $fecha_termino !== null) {
                    $fecha_inicio_dt = new DateTime($fecha_inicio);
                    $fecha_termino_dt = new DateTime($fecha_termino);
                    $diferencia = $fecha_inicio_dt->diff($fecha_termino_dt);
                    $diferencia_meses = $diferencia->format('%m');

                    if ($diferencia_meses >= 1) {
                        // Insertar en la base de datos
                        $insert_query = "
                            INSERT INTO mala_subscripciones_p (sid, estado, fecha_inicio, uid, fecha_termino, vid, mensualidad)
                            VALUES (:sid, :estado, :fecha_inicio, :uid, :fecha_termino, :vid, :mensualidad);
                        ";

                        $stmt = $db56->prepare($insert_query);
                        $stmt->bindParam(':sid', $sid);
                        $stmt->bindParam(':estado', $estado_bool, PDO::PARAM_BOOL);
                        $stmt->bindParam(':fecha_inicio', $fecha_inicio);
                        $stmt->bindParam(':uid', $uid);
                        $stmt->bindParam(':fecha_termino', $fecha_termino);
                        $stmt->bindParam(':vid', $vid);
                        $stmt->bindParam(':mensualidad', $mensualidad);
                        $stmt->execute();
                    } else {
                        echo "Error: La fila con SID $sid no cumple con la restricción de fechas.\n";
                    }
                } else {
                    echo "Error: Las fechas en la fila con SID $sid no son válidas.\n";
                }
            }

            fclose($file);

            $db56->commit();

            echo "Datos insertados correctamente en la tabla mala_subscripciones_p.";
        } else {
            echo "Error: No se pudo abrir el archivo $file_path.";
        }
    }
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
