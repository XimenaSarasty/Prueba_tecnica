<?php
// Verificar si se ha proporcionado el ID de la persona
if (!isset($_POST['id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(array("success" => false, "message" => "No se proporcionó el ID de la persona"));
    exit();
}

// Obtener los datos del formulario
$id = $_POST['id'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$fecha_ingreso = $_POST['fecha_ingreso'];
$comentarios = $_POST['comentarios'];
$salario = $_POST['salario'];
$genero_id = $_POST['genero_id'];
$departamento_id = $_POST['departamento_id'];

// Incluir el archivo de conexión a la base de datos
include '../config/conexion.php';

// Preparar la consulta para actualizar los datos de la persona
$sentencia = $db->prepare("UPDATE empleados SET nombres = ?, apellidos = ?, fecha_ingreso = ?, comentarios = ?, salario = ?, genero_id = ?, departamento_id = ? WHERE id = ?");
$resultado = $sentencia->execute([$nombres, $apellidos, $fecha_ingreso, $comentarios, $salario, $genero_id, $departamento_id, $id]);

// Verificar si la actualización fue exitosa
if ($resultado) {
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false, "message" => "No se pudo actualizar el registro"));
}
?>
