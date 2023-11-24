<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Epic Prime</title>
    
    <style>
        /* Estilos CSS */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #DDF2FD; /* Fondo celeste claro */
            color: #fff; /* Texto blanco */
        }

        header {
            background-color: #164863; /* Azul oscuro para el encabezado */
            padding: 10px;
            color: #fff; /* Texto blanco */
            text-align: center;
        }

        h2 {
            color: #164863; /* Azul oscuro para los títulos de sección */
        }

        p {
            color: #427D9D; /* Azul medio para el contenido */
        }
    </style>
</head>
<body>

<header>
    <h1>Bienvenido a Epic Prime</h1>
</header>

<?php include 'navbar.php'; ?>

<section>
    <h2>Bienvenido, <?php echo $_SESSION['username']; ?>!</h2>
</section>

</body>
</html>

