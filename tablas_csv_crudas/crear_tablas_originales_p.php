<?php

require_once('../config/conexion.php');

try {
    $db56->beginTransaction();
    $delete_query = "

        CREATE TABLE mala_genero_subgenero_p(
        genero TEXT NOT NULL,
        subgenero TEXT);

	CREATE TABLE mala_pago_p(
        pago_id INT NOT NULL,
        monto FLOAT NOT NULL,
        fecha DATE NOT NULL,
        uid INT NOT NULL,
	preorden BOOLEAN,
	pid INT,
        vid INT,
	sid INT);

	CREATE TABLE mala_proveedores_p(
        pid INT NOT NULL,
        nombre TEXT NOT NULL,
        plataforma TEXT NOT NULL,
        vid INT,
        precio FLOAT,
        precio_preorden FLOAT);

	CREATE TABLE mala_subscripciones_p(
        sid INT NOT NULL,
        estado TEXT NOT NULL,
        fecha_inicio DATE NOT NULL,
        uid INT NOT NULL,
        fecha_termino DATE NOT NULL,
        vid INT,
        mensualidad FLOAT);
	
	CREATE TABLE mala_usuario_proveedores_p(
        uid INT NOT NULL,
        pid INT);
	
	CREATE TABLE mala_usuarios_actividades_p(
        uid INT NOT NULL,
        nombre TEXT NOT NULL, 
        mail TEXT NOT NULL,
        password TEXT NOT NULL,
        username TEXT NOT NULL,
	vid INT NOT NULL,
	fecha_visualizacion DATE NOT NULL,
	cantidad FLOAT NOT NULL,
	veredicto TEXT,
	titulo TEXT,
	texto TEXT,
        fecha_nacimiento DATE NOT NULL);
	
	
	CREATE TABLE mala_videojuego_genero_p(
        vid INT NOT NULL,
        nombre TEXT NOT NULL);

	CREATE TABLE mala_videojuego_p(
        vid INT NOT NULL,
        titulo TEXT NOT NULL,
        puntuacion FLOAT NOT NULL,
        clasificacion TEXT NOT NULL,
        fecha_lanzamiento DATE NOT NULL,
        beneficio_preorden TEXT,
        mensualidad INT,
        genero TEXT NOT NULL);
	
    ";
    $db56->exec($delete_query);
    $db56->commit();
    echo "Todas las tablas ex_ fueron creadas";

}catch (Exception $e) {
    $db56->rollBack();
    echo "Error: $e";
}
?>
