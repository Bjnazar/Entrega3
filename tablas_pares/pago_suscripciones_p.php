<?php

require_once('../config/conexion.php');

try {
    $queryDb = "SELECT pagoid, monto, fecha, pid, sid 
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
        $subsInfoQuery = $db56->prepare("SELECT id_videojuego, id_usuario FROM suscripciones_p WHERE id = :subs_id;");
        $subsInfoQuery->execute([':subs_id' => $row['sid']]);
        $subsInfo = $subsInfoQuery->fetch(PDO::FETCH_ASSOC);

        if (!$subsInfo) {
            continue; // si no existe el registro de la subs_id, entonces no lo guardamos
        }

        $proveedorQuery = $db56->prepare("SELECT id_proveedor FROM videojuego_suscripcion_proveedor WHERE id_videojuego = :id_videojuego;");
        $proveedorQuery->execute([':id_videojuego' => $subsInfo['id_videojuego']]);
        $idProveedor = $proveedorQuery->fetchColumn();

        if (!$idProveedor) {
            continue; // si no hay proveedores, no lo guardamos
        }

        $relacionQuery = $db56->prepare("SELECT COUNT(*) FROM usuario_proveedor_p WHERE id_usuario = :id_usuario AND id_proveedor = :id_proveedor;");
        $relacionQuery->execute([':id_usuario' => $subsInfo['id_usuario'], ':id_proveedor' => $idProveedor]);
        $relacionExistente = $relacionQuery->fetchColumn();

        if (!$relacionExistente) {
            continue; // si el usuario tiene cuenta con el proveedor
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
