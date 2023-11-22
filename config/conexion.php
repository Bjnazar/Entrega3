<?php
try {
    require('data.php'); // Incluye las credenciales

    // Conexión a la base de datos del grupo 56
    $db56 = new PDO("pgsql:dbname=$databaseName56;host=localhost;port=5432;user=$user56;password=$password56");

    // Conexión a la base de datos del grupo 55
    $db = new PDO("pgsql:dbname=$databaseName55;host=localhost;port=5432;user=$user55;password=$password55");

} catch (Exception $e) {
    echo "No se pudo conectar a la base de datos: $e";
}
?>
