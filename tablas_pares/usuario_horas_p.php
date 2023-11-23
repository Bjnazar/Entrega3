<?php

require_once('../config/conexion.php');

try {
    $querySource = "SELECT DISTINCT uid, vid, cantidad FROM mala_usuario_actividades_p;";
    $userData = $db->query($querySource)->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si hay datos para insertar
    if (count($userData) > 0) {
        $db56->beginTransaction();

        $db56->exec("CREATE TABLE IF NOT EXISTS usuario_horas_p (
            id_usuario INT,
            id_videojuego INT,
            cantidad FLOAT,
            FOREIGN KEY (id_usuario) REFERENCES usuarios_p(id),
            FOREIGN KEY (id_videojuego) REFERENCES videojuegos(id)
        );");

        $insertQuery = $db56->prepare("INSERT INTO usuario_horas_p (
            id_usuario, id_videojuego, cantidad
        ) VALUES (
            :id_usuario, :id_videojuego, :cantidad
        );");

        foreach ($userData as $row) {
            $videojuegoExistsQuery = $db56->prepare("SELECT id FROM videojuegos WHERE id = :id_videojuego;");
            $videojuegoExistsQuery->execute([':id_videojuego' => $row['vid']]);
            $videojuegoExists = $videojuegoExistsQuery->rowCount() > 0;
            if (!$videojuegoExists) {
                continue;
            }
            $insertQuery->execute([
                ':id_usuario' => $row['uid'],
                ':id_videojuego' => $row['vid'],
                ':cantidad' => $row['cantidad'],
            ]);

            if ($insertQuery->rowCount() == 0) {
                throw new Exception("Error al insertar datos en usuario_horas_p para uid: " . $row['uid']);
            }
        }

        $db56->commit();
        echo "La tabla 'usuario_horas_p' ha sido creada con éxito en la base de datos db56.";
    } else {
        echo "No hay datos para insertar en la tabla 'usuario_horas_p'.";
    }

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>
