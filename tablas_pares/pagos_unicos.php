<?php

require_once('../config/conexion.php');

try {
    $queryDb = "SELECT pagoid, monto, fecha, uid, preorden, pid, vid, sid 
                FROM mala_pagos_p 
                WHERE sid IS NULL;";

    $data = $db->query($queryDb)->fetchAll(PDO::FETCH_ASSOC);

    $db56->beginTransaction();

    $db56->exec("CREATE TABLE IF NOT EXISTS pagos_unicos_p (
        id INT PRIMARY KEY,
        monto INT,
        fecha DATE,
        id_usuario INT,
        preorden TEXT,
        id_proveedor INT,
        id_videojuego INT,
        FOREIGN KEY (id_usuario) REFERENCES usuarios_p(id),
        FOREIGN KEY (id_proveedor) REFERENCES proveedores_p(id),
        FOREIGN KEY (id_videojuego) REFERENCES videojuegos(id)
    );");

    $insertQuery = $db56->prepare("INSERT INTO pagos_unicos_p (
        id, monto, fecha, id_usuario, preorden, id_proveedor, id_videojuego
    ) VALUES (
        :id, :monto, :fecha, :id_usuario, :preorden, :id_proveedor, :id_videojuego
    );");

    foreach ($data as $row) {
        $preorden = ($row['preorden'] == 1) ? "true" : "false";

        $insertQuery->execute([
            ':id' => $row['pagoid'],
            ':monto' => $row['monto'],
            ':fecha' => $row['fecha'],
            ':id_usuario' => $row['uid'],
            ':preorden' => $preorden,
            ':id_proveedor' => $row['pid'],
            ':id_videojuego' => $row['vid'],
        ]);

        if ($insertQuery->rowCount() == 0) {
            throw new Exception("Error al insertar los datos en pagos_unicos_p");
        }
    }

    $db56->commit();

    echo "La tabla 'pagos_unicos_p' ha sido creada con éxito en la base de datos db56.";

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>
