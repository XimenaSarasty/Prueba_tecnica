<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener el ID del cuerpo de la solicitud
    $input = json_decode(file_get_contents('php://input'), true);
    $EliminarRegistro = $input['id'];

    if (!$EliminarRegistro) {
        http_response_code(400);
        echo json_encode(['error' => 'ID is required']);
        exit;
    }

    include '../config/conexion.php';
    $sentencia = $db->prepare("DELETE FROM empleados WHERE id = ?;");
    $resultado = $sentencia->execute([$EliminarRegistro]);

    if ($resultado === true) {
        echo json_encode(['success' => true]);
    } else {
        http_response_code(500); 
        echo json_encode(['error' => 'Failed to delete record']);
    }
} else {
    http_response_code(405); 
    echo json_encode(['error' => 'Method not allowed']);
}
?>
