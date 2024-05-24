<?php
include '../config/conexion.php';

header('Content-Type: application/json');

$sentencia = $db->query("
    SELECT 
        e.id,
        e.nombres,
        e.apellidos,
        e.fecha_ingreso,
        e.comentarios,
        e.salario,
        g.nombre AS genero,
        d.nombre_departamento AS departamento
    FROM 
        empleados e
    JOIN 
        generos g ON e.genero_id = g.id
    JOIN 
        departamentos d ON e.departamento_id = d.id;
");

$dato = $sentencia->fetchAll(PDO::FETCH_OBJ);
echo json_encode($dato);
?>
