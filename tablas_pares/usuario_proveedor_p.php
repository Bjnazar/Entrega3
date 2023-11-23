<?php

require_once('../config/conexion.php');

try {
    $querySource = "SELECT DISTINCT uid, pid FROM mala_usuario_proveedor_p;";
    $userData = $db->query($querySource)->fetchAll(PDO::FETCH_ASSOC);

    // Verificar si hay datos para insertar
    if (count($userData) > 0) {
        $db56->beginTransaction();

        $db56->exec("CREATE TABLE IF NOT EXISTS usuario_proveedor_p (
            id_usuario INT,
            id_proveedor INT,
            FOREIGN KEY (id_usuario) REFERENCES usuarios_p(id),
            FOREIGN KEY (id_proveedor) REFERENCES proveedores_p(id)
        );");

        $insertQuery = $db56->prepare("INSERT INTO usuario_proveedor_p (
            id_usuario, id_proveedor
        ) VALUES (
            :id_usuario, :id_proveedor
        );");

        foreach ($userData as $row) {
            $insertQuery->execute([
                ':id_usuario' => $row['uid'],
                ':id_proveedor' => $row['pid'],
            ]);

            if ($insertQuery->rowCount() == 0) {
                throw new Exception("Error al insertar datos en usuario_proveedor_p para uid: " . $row['uid']);
            }
        }

        $db56->commit();
        echo "La tabla 'usuario_proveedor_p' ha sido creada con éxito en la base de datos db56.";
    } else {
        echo "No hay datos para insertar en la tabla 'usuario_proveedor_p'.";
    }

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>
