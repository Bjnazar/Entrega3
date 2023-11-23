<?php

require_once('../config/conexion.php');

try {
    $queryDb = "SELECT pagoid, monto, fecha, uid, preorden, pid, vid, sid 
                FROM mala_pagos_p 
                WHERE sid IS NOT NULL;";

    $data = $db->query($queryDb)->fetchAll(PDO::FETCH_ASSOC);

    $db56->beginTransaction();

    $db56->exec("CREATE TABLE IF NOT EXISTS pagos_suscripcion_p (
        id INT PRIMARY KEY,
        monto INT,
        fecha DATE,
        id_proveedor INT,
        subs_id INT,
        FOREIGN KEY (id_proveedor) REFERENCES proveedores_p(id),
        FOREIGN KEY (subs_id) REFERENCES suscripciones_p(id)
    );");

    $insertQuery = $db56->prepare("INSERT INTO pagos_suscripcion_p (
        id, monto, fecha, id_proveedor, subs_id
    ) VALUES (
        :id, :monto, :fecha, :id_proveedor, :subs_id
    );");

    foreach ($data as $row) {
        
        if ($row['sid'] === null || $row['pid'] === null) {
            continue;
        }
        $subsIdExistsQuery = $db56->prepare("SELECT id FROM suscripciones_p WHERE id = :subs_id;");
        $subsIdExistsQuery->execute([':subs_id' => $row['sid']]);
        $subsIdExists = $subsIdExistsQuery->rowCount() > 0;

        if (!$subsIdExists) {
            continue;
        }

        $insertQuery->execute([
            ':id' => $row['pagoid'],
            ':monto' => $row['monto'],
            ':fecha' => $row['fecha'],
            ':id_proveedor' => $row['pid'],
            ':subs_id' => $row['sid'],
        ]);

        if ($insertQuery->rowCount() == 0) {
            throw new Exception("Error al insertar los datos en pagos_suscripcion_p");
        }
    }

    $db56->commit();

    echo "La tabla 'pagos_suscripcion_p' ha sido creada con éxito en la base de datos db56.";

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>
