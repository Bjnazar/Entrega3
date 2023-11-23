<?php

require_once('../config/conexion.php');

try {
    $query = "
        SELECT
            vp.pid,
            vv.vid,
            vv.mensualidad
        FROM mala_videojuego_p vv
        INNER JOIN mala_proveedores_p vp ON vv.vid = vp.vid
        WHERE vv.mensualidad IS NOT NULL;
    ";

    $result = $db->query($query);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);

    if (count($data) > 0) {
        $db56->beginTransaction();

        $db56->exec("CREATE TABLE IF NOT EXISTS videojuego_suscripcion_proveedor (
            id_proveedor INT,
            id_videojuego INT,
            mensualidad INT,
            FOREIGN KEY (id_proveedor) REFERENCES proveedores_p(id),
            FOREIGN KEY (id_videojuego) REFERENCES videojuegos(id)
        );");

        $insertQuery = $db56->prepare("INSERT INTO videojuego_suscripcion_proveedor (
            id_proveedor, id_videojuego, mensualidad
        ) VALUES (
            :id_proveedor, :id_videojuego, :mensualidad
        );");

        foreach ($data as $row) {
            $insertQuery->execute([
                ':id_proveedor' => $row['pid'],
                ':id_videojuego' => $row['vid'],
                ':mensualidad' => $row['mensualidad'],
            ]);

            if ($insertQuery->rowCount() == 0) {
                throw new Exception("Error al insertar datos en videojuego_suscripcion_proveedor");
            }
        }

        $db56->commit();
        echo "La tabla 'videojuego_suscripcion_proveedor' ha sido creada con éxito en la base de datos db56.";
    } else {
        echo "No hay datos para insertar en la tabla 'videojuego_suscripcion_proveedor'.";
    }

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>
