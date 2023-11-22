<?php

require_once('../config/conexion.php');

try {
    // Extraer los datos de la base de datos db
    $queryDb = "SELECT DISTINCT vid AS id_juego, nombre FROM mala_videojuego_genero_p;";
    $data = $db->query($queryDb)->fetchAll(PDO::FETCH_ASSOC);

    // Crear la tabla en db56 y luego insertar los datos
    $db56->beginTransaction();

    // Asegúrate de que la tabla Juego_Genero no exista antes de crearla
    $db56->exec("CREATE TABLE IF NOT EXISTS Juego_Genero (id_juego INT, id_genero INT);");

    // Preparar consulta para insertar datos en Juego_Genero
    $insertQuery = $db56->prepare("INSERT INTO Juego_Genero (id_juego, id_genero) VALUES (:id_juego, (SELECT id_genero FROM Genero_p WHERE genero = :nombre_genero));");

    foreach ($data as $row) {
        $insertQuery->execute([':id_juego' => $row['id_juego'], ':nombre_genero' => $row['nombre']]);
        if ($insertQuery->rowCount() == 0) {
            throw new Exception("Error al insertar los datos en Juego_Genero");
        }
    }

    $db56->commit();

    echo "La tabla 'Juego_Genero' ha sido creada con éxito en la base de datos db56.";

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>

