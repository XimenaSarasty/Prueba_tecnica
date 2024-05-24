<?php
#prueba de envio de datos
#print_r($_GET);
if(!isset($_GET['id'])) {
    header('Location: http://localhost/app_crud_php/');    
}
$EliminarRegistro = $_GET['id'];
#conexion db
include '../config/conexion.php';
#sentencia sql para eliminar registro 
$sentencia = $db->prepare("DELETE FROM empleados WHERE id=?;");
$resultado = $sentencia->execute([$EliminarRegistro]);

#validacion de redireccion
if ($resultado === true) {
    header('Location: http://localhost/app_crud_php/');
}else {
    echo 'error al eliminar registro';
}