<?php

require_once('../config/conexion.php');

try {
    // Extraer los datos de la base de datos db
    $queryDb = "SELECT DISTINCT pid, vid, plataforma FROM mala_proveedores_p;";
    $data = $db->query($queryDb)->fetchAll(PDO::FETCH_ASSOC);

    // Crear la tabla en db56 y luego insertar los datos
    $db56->beginTransaction();

    // Asegúrate de que la tabla Proveedores_Plataforma no exista antes de crearla
    $db56->exec("CREATE TABLE IF NOT EXISTS Proveedores_Plataforma2 (
                id_proveedor INT, 
                id_videojuego INT, 
                nombre_plataforma TEXT,
                FOREIGN KEY (id_proveedor) REFERENCES proveedores_p(id),
                FOREIGN KEY (id_videojuego) REFERENCES videojuegos(id)
                );");

    // Preparar consulta para insertar datos en Proveedores_Plataforma
    $insertQuery = $db56->prepare("INSERT INTO Proveedores_Plataforma2 (id_proveedor, id_videojuego, nombre_plataforma) VALUES (:id_proveedor, :id_videojuego, :nombre_plataforma);");

    foreach ($data as $row) {
        $insertQuery->execute([
            ':id_proveedor' => $row['pid'], 
            ':id_videojuego' => $row['vid'], 
            ':nombre_plataforma' => $row['plataforma']
        ]);
        if ($insertQuery->rowCount() == 0) {
            throw new Exception("Error al insertar los datos en Proveedores_Plataforma2");
        }
    }

    $db56->commit();

    echo "La tabla 'Proveedores_Plataforma2' ha sido creada con éxito en la base de datos db56.";

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>
