<?php
include '../config/conexion.php';

header('Content-Type: application/json');

$sentencia = $db->query("SELECT id, nombre_departamento AS nombre FROM departamentos");
$departamentos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($departamentos);
?>
