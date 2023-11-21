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
<form method="post">
    Nombre: <input type="text" name="nombre" required><br>
    Email: <input type="email" name="mail" required><br>
    Contraseña: <input type="password" name="password" required><br>
    Nombre de Usuario: <input type="text" name="username" required><br>
    Fecha de Nacimiento: <input type="date" name="fecha_nacimiento" required><br>
    <input type="submit" value="Registrarse">
</form>





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
  <h2>Register Here </h2>
  <form method="post">
  
    <div class="form-group">
      <label for="name">Name:</label>
      <input type="text" class="form-control" id="name" placeholder="Enter name" name="name" requuired>
    </div>
    
    <div class="form-group">
      <label for="email">Email:</label>
      <input type="email" class="form-control" id="email" placeholder="Enter email" name="email">
    </div>
    
    <div class="form-group">
      <label for="pwd">Mobile No:</label>
      <input type="number" class="form-control" maxlength="10" id="mobileno" placeholder="Enter Mobile Number" name="mobno">
    </div>
    
    <div class="form-group">
      <label for="pwd">Password:</label>
      <input type="password" class="form-control" id="pwd" placeholder="Enter password" name="pwd">
    </div>
     
    <input type="submit" name="submit" class="btn btn-primary" value="Submit">
  </form>
</div>
</body>
</html>