<?php

require_once('../config/conexion.php');

try {
    $db56->beginTransaction();

    $updateQuery = $db56->prepare("UPDATE pagos_unicos_p SET preorden = :preorden_b;");
    
    $selectQuery = $db56->prepare("SELECT id, preorden FROM pagos_unicos_p;");
    $selectQuery->execute();
    $rows = $selectQuery->fetchAll(PDO::FETCH_ASSOC);

    foreach ($rows as $row) {
        $preorden_bool = ($row['preorden'] == "true") ? true : false;

        $updateQuery->execute([
            ':preorden_b' => $preorden_bool,
        ]);

        if ($updateQuery->rowCount() == 0) {
            throw new Exception("Error al actualizar la columna preorden en pagos_unicos_p");
        }
    }

    $db56->commit();

    echo "La columna 'preorden' en la tabla 'pagos_unicos_p' ha sido actualizada con éxito en la base de datos db56.";

} catch (PDOException $e) {
    $db56->rollBack();
    echo "Error PDO: " . $e->getMessage();
} catch (Exception $e) {
    $db56->rollBack();
    echo "Error General: " . $e->getMessage();
}

?>
