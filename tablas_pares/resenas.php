<?php

require_once('../config/conexion.php');

try {
    // Extraer los datos de la base de datos db
    $queryDb = "SELECT DISTINCT uid, vid, titulo, texto, veredicto FROM mala_usuario_actividades_p;";
    $data = $db->query($queryDb)->fetchAll(PDO::FETCH_ASSOC);

    // Crear la tabla en db56 y luego insertar los datos
    $db56->beginTransaction();

    // Asegúrate de que la tabla Resenas no exista antes de crearla
    $db56->exec("CREATE TABLE IF NOT EXISTS Resenas (id_resena INT, id_videojuego INT, titulo TEXT, texto TEXT, veredicto TEXT);");

    // Preparar consulta para insertar datos en Resenas
    $insertQuery = $db56->prepare("INSERT INTO Resenas (id_resena, id_videojuego, titulo, texto, veredicto) VALUES (:id_resena, :id_videojuego, :titulo, :texto, :veredicto);");

    foreach ($data as $row) {
        $insertQuery->execute([
            ':id_resena' => $row['uid'], 
            ':id_videojuego' => $row['vid'], 
            ':titulo' => $row['titulo'], 
            ':texto' => $row['texto'], 
            ':veredicto' => $row['veredicto']
        ]);
        if ($insertQuery->rowCount() == 0) {
            throw new Exception("Error al insertar los datos en Resenas");
        }
    }

    $db56->commit();

    echo "La tabla 'Resenas' ha sido creada con éxito en la base de datos db56.";

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>
