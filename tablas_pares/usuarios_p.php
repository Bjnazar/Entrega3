<?php

require_once('../config/conexion.php');

try {
    $querySource = "SELECT DISTINCT uid, nombre, mail, password, username, fecha_nacimiento FROM mala_usuario_actividades_p;";
    $resultSource = $db->query($querySource);
    $usuarios = $resultSource->fetchAll(PDO::FETCH_ASSOC);

    if (count($usuarios) > 0) {
        $db56->beginTransaction();

        $db56->exec("CREATE TABLE IF NOT EXISTS usuarios_p (
            id INTEGER PRIMARY KEY,
            nombre TEXT,
            mail TEXT,
            password TEXT,
            username TEXT,
            fecha_nacimiento DATE
        );");

        $insertQuery = $db56->prepare("INSERT INTO usuarios_p (id, nombre, mail, password, username, fecha_nacimiento) 
                                       VALUES (:id, :nombre, :mail, :password, :username, :fecha_nacimiento)
                                       ON CONFLICT (id) DO NOTHING;");

        foreach ($usuarios as $row) {
            $checkExistenceQuery = $db56->prepare("SELECT id FROM usuarios_p WHERE id = :id");
            $checkExistenceQuery->execute([':id' => $row['uid']]);
            
            if ($checkExistenceQuery->rowCount() > 0) {
                // El usuario con este ID ya existe
                continue;
            }
            $insertQuery->execute([
                ':id' => $row['uid'],
                ':nombre' => $row['nombre'],
                ':mail' => $row['mail'],
                ':password' => $row['password'],
                ':username' => $row['username'],
                ':fecha_nacimiento' => $row['fecha_nacimiento']
            ]);

            if ($insertQuery->rowCount() == 0) {
                throw new Exception("Error al insertar datos para el usuario con ID: " . $row['uid']);
            }
        }

        $db56->commit();
        echo "La tabla 'usuarios_p' ha sido creada con éxito en la base de datos db56.";
    } else {
        echo "No hay datos para insertar en la tabla 'usuarios_p'.";
    }

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>
