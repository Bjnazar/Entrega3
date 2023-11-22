<?php

require_once('../config/conexion.php');

try {
    // Extraer los datos de la base de datos db
    $queryDb = "SELECT pid, vid, precio, precio_preorden FROM mala_proveedores_p;";
    $data = $db->query($queryDb)->fetchAll(PDO::FETCH_ASSOC);

    // Crear la tabla en db56 y luego insertar los datos
    $db56->beginTransaction();

    // Asegúrate de que la tabla Juego_Proveedor no exista antes de crearla
    $db56->exec("CREATE TABLE IF NOT EXISTS Juego_Proveedor (id_juego INT, id_proveedor INT, precio FLOAT, precio_preorden FLOAT);");

    // Preparar consulta para insertar datos en Juego_Proveedor
    $insertQuery = $db56->prepare("INSERT INTO Juego_Proveedor (id_juego, id_proveedor, precio, precio_preorden) VALUES (:id_juego, :id_proveedor, :precio, :precio_preorden);");

    foreach ($data as $row) {
        $insertQuery->execute([
            ':id_juego' => $row['pid'], 
            ':id_proveedor' => $row['vid'], 
            ':precio' => $row['precio'], 
            ':precio_preorden' => $row['precio_preorden']
        ]);
        if ($insertQuery->rowCount() == 0) {
            throw new Exception("Error al insertar los datos en Juego_Proveedor");
        }
    }

    $db56->commit();

    echo "La tabla 'Juego_Proveedor' ha sido creada con éxito en la base de datos db56.";

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>
