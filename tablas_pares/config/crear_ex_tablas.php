<?php

require_once('../config/conexion.php');

try {
    $db->beginTransaction();
    $delete_query = "
    CREATE TABLE ex_visualizaciones(
        uid INT NOT NULL,
        pid INT,
        cid INT,
        fecha DATE NOT NULL);
        
        CREATE TABLE ex_usuarios(
        id INT NOT NULL,
        nombre TEXT NOT NULL, 
        mail TEXT NOT NULL,
        password TEXT NOT NULL,
        username TEXT NOT NULL,
        fecha_nacimiento DATE NOT NULL);
        
        CREATE TABLE ex_subscripciones(
        id INT NOT NULL,
        estado TEXT NOT NULL,
        fecha_inicio DATE NOT NULL,
        pro_id INT NOT NULL,
        uid INT NOT NULL,
        fecha_termino DATE NOT NULL,
        proveedor TEXT NOT NULL,
        costo INT NOT NULL);
        
        CREATE TABLE ex_proveedores(
        id INT NOT NULL,
        nombre TEXT NOT NULL,
        costo FLOAT,
        sid INT,
        pid INT,
        precio FLOAT,
        disponibilidad INT);
        
        CREATE TABLE ex_pago(
        pago_id INT NOT NULL,
        monto FLOAT NOT NULL,
        fecha DATE NOT NULL,
        uid INT NOT NULL,
        subs_id INT,
        pid INT,
        pro_id INT);
        
        CREATE TABLE ex_multimedia(
        pid INT,
        sid INT,
        cid INT,
        titulo TEXT NOT NULL,
        duracion FLOAT NOT NULL,
        clasificacion VARCHAR(30) NOT NULL,
        puntuacion FLOAT,
        año INT NOT NULL,
        numero INT,
        serie TEXT,
        genero TEXT);
        
        CREATE TABLE ex_genero(
        genero TEXT NOT NULL,
        nombre_subgenero TEXT);
    ";
    $db->exec($delete_query);
    $db->commit();
    echo "Todas las tablas ex_ fueron creadas";

}catch (Exception $e) {
    $db->rollBack();
    echo "Error: $e";
}
?>
