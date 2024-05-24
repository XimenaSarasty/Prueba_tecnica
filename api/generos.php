<?php
include '../config/conexion.php';

header('Content-Type: application/json');

$sentencia = $db->query("SELECT id, nombre FROM generos");
$generos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($generos);
?>
