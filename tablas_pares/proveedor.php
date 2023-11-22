<?php

require_once('../config/conexion.php');

try {
    // Extraer los datos de la base de datos db
    $queryDb = "SELECT DISTINCT pid, nombre FROM mala_proveedores_p;";
    $data = $db->query($queryDb)->fetchAll(PDO::FETCH_ASSOC);

    // Crear la tabla en db56 y luego insertar los datos
    $db56->beginTransaction();

    // Asegúrate de que la tabla Proveedor_p no exista antes de crearla
    $db56->exec("CREATE TABLE IF NOT EXISTS Proveedor_p (id_proveedor INT, nombre TEXT);");

    // Preparar consulta para insertar datos en Proveedor_p
    $insertQuery = $db56->prepare("INSERT INTO Proveedor_p (id_proveedor, nombre) VALUES (:id_proveedor, :nombre);");

    foreach ($data as $row) {
        $insertQuery->execute([
            ':id_proveedor' => $row['pid'], 
            ':nombre' => $row['nombre']
        ]);
        if ($insertQuery->rowCount() == 0) {
            throw new Exception("Error al insertar los datos en Proveedor_p");
        }
    }

    $db56->commit();

    echo "La tabla 'Proveedor_p' ha sido creada con éxito en la base de datos db56.";

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>
