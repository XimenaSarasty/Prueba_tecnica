<?php
// Verificar si se ha proporcionado un ID válido
if (!isset($_GET['id'])) {
    http_response_code(400); // Bad Request
    echo json_encode(array("error" => "No se proporcionó un ID válido"));
    exit();
}

// Obtener el ID de la persona desde la solicitud
$id = $_GET['id'];

// Incluir el archivo de conexión a la base de datos
include '../config/conexion.php';

// Preparar la consulta para obtener los datos de la persona por su ID
$sentencia = $db->prepare("SELECT * FROM empleados WHERE id = ?");
$sentencia->execute([$id]);

// Obtener los datos de la persona
$persona = $sentencia->fetch(PDO::FETCH_ASSOC);

// Verificar si se encontró una persona con el ID proporcionado
if (!$persona) {
    http_response_code(404); // Not Found
    echo json_encode(array("error" => "No se encontró ninguna persona con el ID proporcionado"));
    exit();
}

// Devolver los datos de la persona en formato JSON
header('Content-Type: application/json');
echo json_encode($persona);
?>
