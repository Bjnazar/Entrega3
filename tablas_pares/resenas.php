<?php

require_once('../config/conexion.php');

try {
    // Extraer los datos de la base de datos db
    $queryDb = "SELECT DISTINCT uid, vid, titulo, texto, veredicto FROM mala_usuario_actividades_p
                WHERE titulo IS NOT NULL;";
    $data = $db->query($queryDb)->fetchAll(PDO::FETCH_ASSOC);

    // Asegúrate de que la tabla Resenas no exista antes de crearla
    $db56->exec("CREATE TABLE IF NOT EXISTS Resenas_p (
        id_usuario INT,
        id_videojuego INT,
        titulo TEXT,
        texto TEXT,
        veredicto BOOLEAN,
        FOREIGN KEY (id_usuario) REFERENCES usuarios_p(id),
        FOREIGN KEY (id_videojuego) REFERENCES videojuegos(id)
    );");

    // Iniciar la transacción después de la preparación de consultas
    $db56->beginTransaction();

    // Preparar consulta para insertar datos en Resenas
    $insertQuery = $db56->prepare("INSERT INTO Resenas_p (id_usuario, id_videojuego, titulo, texto, veredicto) 
    VALUES (:id_usuario, :id_videojuego, :titulo, :texto, :veredicto);");

    foreach ($data as $row) {
        $userExistsQuery = $db56->prepare("SELECT id FROM usuarios_p WHERE id = :id_usuario;");
        $userExistsQuery->execute([':id_usuario' => $row['uid']]);
        $userExists = $userExistsQuery->rowCount() > 0;

        $gameExistsQuery = $db56->prepare("SELECT id FROM videojuegos WHERE id = :id_videojuego;");
        $gameExistsQuery->execute([':id_videojuego' => $row['vid']]);
        $gameExists = $gameExistsQuery->rowCount() > 0;

        if (!$userExists) {
            echo "Error1: Usuario no encontrado para uid: {$row['uid']}\n";
            continue; 
        }

        if (!$gameExists) {
            echo "Error2: videojuego no encontrado para vid: {$row['vid']}\n";
            continue; 
        }
            
        try {
            // $veredicto = ($row['veredicto'] == 1) ? true : false;
            $veredicto = ($row['veredicto'] == 1) ? true : false;

            $titulo_utf8 = $row['titulo'];
            $texto_utf8 = $row['texto'];
            $insertQuery->execute([
                ':id_usuario' => $row['uid'], 
                ':id_videojuego' => $row['vid'], 
                ':titulo' => $row['titulo'], 
                ':texto' => $row['texto'], 
                ':veredicto' => $row['veredicto']
            ]);
            if ($insertQuery->rowCount() == 0) {
                throw new Exception("Error al insertar los datos en Resenas_p");
            }
        } catch (PDOException $ex) {
            // Manejar la excepción específica que ocurrió durante la inserción
            echo "Error al insertar datos en Resenas_p: " . $ex->getMessage();
            $db56->rollBack();
        }
    }

    $db56->commit();

    echo "La tabla 'Resenas_p' ha sido creada con éxito en la base de datos db56.";

} catch (PDOException $e) {
    // Rollback en caso de error
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    // Rollback en caso de error
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}
?>
