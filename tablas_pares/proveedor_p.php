<?php

require_once('../config/conexion.php');

try {
    $query = "SELECT DISTINCT pid, nombre, plataforma FROM mala_proveedores_p;";

    $result = $db->query($query);
    $data = $result->fetchAll(PDO::FETCH_ASSOC);

    if (count($data) > 0) {
        $db56->beginTransaction();

        $db56->exec("CREATE TABLE IF NOT EXISTS proveedores_p (
            id INTEGER PRIMARY KEY,
            nombre TEXT,
            plataforma TEXT
        );");

        $insertQuery = $db56->prepare("INSERT INTO proveedores_p (
            id, nombre, plataforma
        ) VALUES (
            :id, :nombre, :plataforma
        );");

        foreach ($data as $row) {
            $insertQuery->execute([
                ':id' => $row['pid'],
                ':nombre' => $row['nombre'],
                ':plataforma' => $row['plataforma'],
            ]);

            if ($insertQuery->rowCount() == 0) {
                throw new Exception("Error al insertar datos en proveedores_p");
            }
        }

        $db56->commit();
        echo "La tabla 'proveedores_p' ha sido creada con éxito en la base de datos db56.";
    } else {
        echo "No hay datos para insertar en la tabla 'proveedores_p'.";
    }

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>
