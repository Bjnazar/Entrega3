<?php

require_once('../config/conexion.php');

try {
    $query = "
        SELECT
            vp.pid,
            vv.vid,
            vp.precio,
            COALESCE(vp.precio_preorden, 0) AS precio_preorden,
            vv.beneficio_preorden
        FROM mala_videojuego_p vv
        INNER JOIN mala_proveedores_p vp ON vv.vid = vp.vid
        WHERE vv.mensualidad IS NULL;
    ";

    $result = $db->query($query);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si hay datos para insertar
    if (count($data) > 0) {
        $db56->beginTransaction();

        // Crear la tabla en db56 si no existe
        $db56->exec("CREATE TABLE IF NOT EXISTS videojuego_pagounico_proveedor (
            id_proveedor INT,
            id_videojuego INT,
            precio INT,
            precio_preorden INT,
            beneficio_preorden TEXT,
            FOREIGN KEY (id_proveedor) REFERENCES proveedores_p(id),
            FOREIGN KEY (id_videojuego) REFERENCES videojuegos(id)
        );");

        $insertQuery = $db56->prepare("INSERT INTO videojuego_pagounico_proveedor (
            id_proveedor, id_videojuego, precio, precio_preorden, beneficio_preorden
        ) VALUES (
            :id_proveedor, :id_videojuego, :precio, :precio_preorden, :beneficio_preorden
        );");

        // Insertar datos en la nueva tabla
        foreach ($data as $row) {
            $insertQuery->execute([
                ':id_proveedor' => $row['pid'],
                ':id_videojuego' => $row['vid'],
                ':precio' => $row['precio'],
                ':precio_preorden' => $row['precio_preorden'],
                ':beneficio_preorden' => $row['beneficio_preorden'],
            ]);

            if ($insertQuery->rowCount() == 0) {
                throw new Exception("Error al insertar datos en videojuego_pagounico_proveedor");
            }
        }

        $db56->commit();
        echo "La tabla 'videojuego_pagounico_proveedor' ha sido creada con éxito en la base de datos db56.";
    } else {
        echo "No hay datos para insertar en la tabla 'videojuego_pagounico_proveedor'.";
        // Puedes realizar alguna acción adicional si no hay datos, según tus necesidades.
    }

} catch (PDOException $e) {
    if ($db56->inTransaction()) {
        $db56->rollBack();
    }
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}


?>
