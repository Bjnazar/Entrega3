<?php

require_once('../config/conexion.php');

try {
    $querySubscriptions = "SELECT DISTINCT sid, estado, fecha_inicio, uid, fecha_termino, vid, mensualidad FROM mala_subscripciones_p;";
    $subscriptionsData = $db->query($querySubscriptions)->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si hay datos para insertar
    if (count($subscriptionsData) > 0) {
        $db56->beginTransaction();

        $db56->exec("CREATE TABLE IF NOT EXISTS suscripciones_p (
            id INTEGER PRIMARY KEY,
            estado TEXT,
            fecha_inicio DATE,
            id_usuario INT,
            fecha_termino DATE,
            id_videojuego INT,
            FOREIGN KEY (id_usuario) REFERENCES usuarios_p(id),
            FOREIGN KEY (id_videojuego) REFERENCES videojuegos(id)
        );");

        $insertQuery = $db56->prepare("INSERT INTO suscripciones_p (
            id, estado, fecha_inicio, id_usuario, fecha_termino, id_videojuego
        ) VALUES (
            :id, :estado, :fecha_inicio, :id_usuario, :fecha_termino, :id_videojuego
        );");

        foreach ($subscriptionsData as $row) {
            $insertQuery->execute([
                ':id' => $row['sid'],
                ':estado' => $row['estado'],
                ':fecha_inicio' => $row['fecha_inicio'],
                ':id_usuario' => $row['uid'],
                ':fecha_termino' => $row['fecha_termino'],
                ':id_videojuego' => $row['vid'],
            ]);

            if ($insertQuery->rowCount() == 0) {
                throw new Exception("Error al insertar datos en suscripciones_p para sid: " . $row['sid']);
            }
        }

        $db56->commit();
        echo "La tabla 'suscripciones_p' ha sido creada con éxito en la base de datos db56.";
    } else {
        echo "No hay datos para insertar en la tabla 'suscripciones_p'.";
    }

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>
