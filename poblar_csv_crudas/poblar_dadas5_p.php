<?php

require_once('../config/conexion.php');

try {
    $db->beginTransaction();

    // Eliminar todos los registros existentes en la tabla mala_usuario_actividades_p
    $delete_query = "DELETE FROM mala_usuario_actividades_p";
    $db->exec($delete_query);

    $file_path = '/home/grupo55/Sites/datos_par/p_usuario_actividades.csv';
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
                $nombre = $row[1];
                $mail = $row[2];
                $password = $row[3];
                $username = $row[4];
                $vid = $row[5];

                // Verificar si 'vid' es una cadena vacía y convertirlo a null
                $vid = ($vid === '') ? null : $vid;

                // Convertir el valor de 'fecha_v' al formato correcto
                $fecha_v = ($row[6] !== '') ? DateTime::createFromFormat('d/m/Y', $row[6]) : null;
		$fecha_v = $fecha_v ? $fecha_v->format('Y-m-d') : null;


                $cantidad = $row[7];

                // Convertir el valor de 'veredicto' a booleano
                $veredicto = strtolower($row[8]);
                $veredicto = ($veredicto == 'positivo') ? true : false;

                $titulo = $row[9];
                $texto = $row[10];

                // Convertir el valor de 'fecha_nacimiento' al formato correcto
                $fecha_nacimiento = DateTime::createFromFormat('d/m/Y', $row[11]);
                $fecha_nacimiento = $fecha_nacimiento ? $fecha_nacimiento->format('Y-m-d') : null;

                $insert_query = "
                    INSERT INTO mala_usuario_actividades_p (uid, nombre, mail, password, username, vid, fecha_v, cantidad, veredicto, titulo, texto, fecha_nacimiento)
                    VALUES (:uid, :nombre, :mail, :password, :username, :vid, :fecha_v, :cantidad, :veredicto, :titulo, :texto, :fecha_nacimiento);
                ";

                $stmt = $db->prepare($insert_query);
                $stmt->bindParam(':uid', $uid);
                $stmt->bindParam(':nombre', $nombre);
                $stmt->bindParam(':mail', $mail);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':vid', $vid);
                $stmt->bindParam(':fecha_v', $fecha_v);
                $stmt->bindParam(':cantidad', $cantidad);
                $stmt->bindParam(':veredicto', $veredicto, PDO::PARAM_BOOL);
                $stmt->bindParam(':titulo', $titulo);
                $stmt->bindParam(':texto', $texto);
                $stmt->bindParam(':fecha_nacimiento', $fecha_nacimiento);
                $stmt->execute();
            }

            fclose($file);

            $db->commit();

            echo "Datos insertados correctamente en la tabla mala_usuario_actividades_p.";
        } else {
            echo "Error: No se pudo abrir el archivo $file_path.";
        }
    }
} catch (Exception $e) {
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}
?>
