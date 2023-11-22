<?php

require_once('../config/conexion.php');

try {
    $query55 = "SELECT DISTINCT genero FROM mala_genero_p;";
    $result = $db->query($query55);
    $generos = $result->fetchAll(PDO::FETCH_ASSOC);

    // Verifica si hay datos para insertar
    if (count($generos) > 0) {
        $db56->beginTransaction();

        $db56->exec("CREATE TABLE IF NOT EXISTS Genero_p (id_genero SERIAL PRIMARY KEY, genero TEXT NOT NULL);");

        $insertQuery = $db56->prepare("INSERT INTO Genero_p (genero) VALUES (:genero);");

        foreach ($generos as $row) {
            $insertQuery->execute([':genero' => $row['genero']]);
            if ($insertQuery->rowCount() == 0) {
                throw new Exception("Error al insertar el género: " . $row['genero']);
            }
        }

        $db56->commit();
        echo "La tabla 'Genero_p' ha sido creada con éxito en la base de datos db56.";
    } else {
        echo "No hay datos para insertar en la tabla 'Genero_p'.";
    }

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>