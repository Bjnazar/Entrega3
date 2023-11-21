<?php include('templates/header.html');   ?>

<body>
  <h1 align="center">Videojuegos </h1>
  <p style="text-align:center;">Aquí podrás encontrar información sobre videojuegos.</p>

  <br>

  <h3 align="center"> Ver todos los juegos y los proveedores que los ofrecen </h3>

  <form align="center" action="consultas/consulta_tipo_juegos.php" method="post">
    <input type="submit" value="Ver">
  </form>

  <br>
  <br>
  <br>

  <h3 align="center"> Buscar juegos con al menos una mínima cantidad de reseñas positivas </h3>

  <form align="center" action="consultas/consulta_tipo_resena.php" method="post">
    Cantidad mínima:
    <input type="text" name="cantidad">
    <br/>
    <input type="submit" value="Buscar">
  </form>
  
  <br>
  <br>
  <br>

  <h3 align="center"> Buscar juegos según su título y ver los proveedores que los ofrecen </h3>

  <form align="center" action="consultas/consulta_tipo_titulo.php" method="post">
    <br/>
    Título:
    <input type="text" name="titulo">
    <br/><br/>
    <input type="submit" value="Buscar">
  </form>
  
  <br>
  <br>
  <br>

  <h3 align="center"> Buscar juegos de un género o de sus subgéneros inmediatos </h3>

  <form align="center" action="consultas/consulta_tipo_genero.php" method="post">
    <br/>
    Género:
    <input type="text" name="genero">
    <br/><br/>
    <input type="submit" value="Buscar">
  </form>
  
  <br>
  <br>
  <br>

  <h3 align="center"> Buscar todos los juegos con su proveedor de un usuario </h3>

  <form align="center" action="consultas/consulta_usuario.php" method="post">
    Username:
    <input type="text" name="username">
    <br/><br/>  
    <input type="submit" value="Ver">
  </form>

  <br>
  <br>
  <br>

  <h3 align="center"> Buscar todos los proveedores para los cuales un usuario ha preordenado más de un juego </h3>

  <form align="center" action="consultas/consulta_tipo_proveedores.php" method="post">
    Username:
    <input type="text" name="username">
    <br/><br/>  
    <input type="submit" value="Ver">
  </form>

  <br>
  <br>
  <br>

  <h3 align="center"> Ver el gasto total de cada usuario en juegos por suscripción </h3>

  <form align="center" action="consultas/consulta_tipo_gasto.php" method="post">
    <input type="submit" value="Ver">
  </form>

  <br>
  <br>
  <br>

</body>
</html>
