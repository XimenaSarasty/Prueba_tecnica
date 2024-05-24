<?php
include '../config/conexion.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $fecha_ingreso = $_POST['fecha_ingreso'];
    $comentarios = $_POST['comentarios'];
    $salario = $_POST['salario'];
    $genero_id = $_POST['genero_id'];
    $departamento_id = $_POST['departamento_id'];

    $sentencia = $db->prepare("INSERT INTO empleados (nombres, apellidos, fecha_ingreso, comentarios, salario, genero_id, departamento_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $resultado = $sentencia->execute([$name, $apellidos, $fecha_ingreso, $comentarios, $salario, $genero_id, $departamento_id]);

    if ($resultado === true) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al insertar datos']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?>
