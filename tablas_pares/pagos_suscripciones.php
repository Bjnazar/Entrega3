<?php

require_once('../config/conexion.php');

try {
    // Extraer los datos de la base de datos db
    $queryDb = "SELECT uid, vid, pid, fecha FROM mala_pagos_p;";
    $data = $db->query($queryDb)->fetchAll(PDO::FETCH_ASSOC);

    // Crear la tabla en db56 y luego insertar los datos
    $db56->beginTransaction();

    // Asegúrate de que la tabla Pagos_Suscripciones no exista antes de crearla
    $db56->exec("CREATE TABLE IF NOT EXISTS Pagos_Suscripciones (id_usuario INT, id_juego INT, id_proveedor INT, fecha DATE);");

    // Preparar consulta para insertar datos en Pagos_Suscripciones
    $insertQuery = $db56->prepare("INSERT INTO Pagos_Suscripciones (id_usuario, id_juego, id_proveedor, fecha) VALUES (:id_usuario, :id_juego, :id_proveedor, :fecha);");

    foreach ($data as $row) {
        $insertQuery->execute([
            ':id_usuario' => $row['uid'], 
            ':id_juego' => $row['vid'], 
            ':id_proveedor' => $row['pid'], 
            ':fecha' => $row['fecha']
        ]);
        if ($insertQuery->rowCount() == 0) {
            throw new Exception("Error al insertar los datos en Pagos_Suscripciones");
        }
    }

    $db56->commit();

    echo "La tabla 'Pagos_Suscripciones' ha sido creada con éxito en la base de datos db56.";

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>
