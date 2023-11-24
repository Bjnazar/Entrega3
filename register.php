<?php
require 'config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $mail = $_POST['mail'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $username = $_POST['username'];
    $fecha_nacimiento = $_POST['fecha_nacimiento'];

    // Aquí puedes agregar validaciones adicionales si lo deseas

    $sql = "INSERT INTO usuarios (nombre, mail, password, username, fecha_nacimiento) VALUES (?, ?, ?, ?, ?)";
    $stmt= $pdo->prepare($sql);
    $stmt->execute([$nombre, $mail, $password, $username, $fecha_nacimiento]);

    // Redirige o muestra un mensaje después del registro exitoso
}

// Formulario HTML para el registro
?>

<!DOCTYPE html>

<html lang="en">
<head>
  <title>PHP PostgreSQL Registration & Login Example </title>
  <meta name="keywords" content="PHP,PostgreSQL,Insert,Login">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>
<div class="container">
  <h2>Registrarse </h2>
  <form method="post">
  
    <div class="form-group">
      <label for="name">Nombre:</label>
      <input type="text" class="form-control" id="name" name="name" requuired>
    </div>

    <div class="form-group">
      <label for="pwd">Nombre de Usuario:</label>
      <input type="text" class="form-control" id="pwd" name="pwd">
    </div>
    
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" name="email">
    </div>
    
    <div class="form-group">
      <label for="password">Contraseña:</label>
      <input type="password" name="password" class="form-control" id="password"  name="contraseña">
    </div>

    <div class="form-group">
      <label for="fecha_nacimiento">Fecha de nacimiento:</label>
      <input type="date" id="fecha_nacimiento" name="fecha_nacimiento">
    </div>
     
    <input type="submit" name="submit" class="btn btn-primary" value="Registrarse">
  </form>
</div>
</body>
</html>