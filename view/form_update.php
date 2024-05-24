<?php
include '../config/conexion.php';

// Obtener las opciones de género
$generoStmt = $db->query("SELECT id, nombre FROM generos");
$generos = $generoStmt->fetchAll(PDO::FETCH_OBJ);

// Obtener las opciones de departamento
$departamentoStmt = $db->query("SELECT id, nombre_departamento FROM departamentos");
$departamentos = $departamentoStmt->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-4">
                <form id="updateForm">
                    <h3 class="text-center mb-4">Editar Registro</h3>
                        <div class="mb-3">
                            <label for="nombres" class="form-label">Nombres:</label>
                            <input type="text" class="form-control" id="nombres">
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos:</label>
                            <input type="text" class="form-control" id="apellidos">
                        </div>
                        <div class="mb-3">
                            <label for="fecha_ingreso" class="form-label">Fecha de ingreso</label>
                            <input type="date" class="form-control" id="fecha_ingreso">
                        </div>
                        <div class="mb-3">
                            <label for="comentarios" class="form-label">Comentarios:</label>
                            <input type="text" class="form-control" id="comentarios">
                        </div>
                        <div class="mb-3">
                            <label for="salario" class="form-label">Salario:</label>
                            <input type="number" class="form-control" id="salario">
                        </div>
                        <div class="mb-3">
                            <label for="genero_id" class="form-label">Género:</label>
                            <select id="genero_id" class="form-select">
                                <?php foreach($generos as $genero): ?>
                                    <option value="<?php echo $genero->id; ?>"><?php echo htmlspecialchars($genero->nombre); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="departamento_id" class="form-label">Departamento:</label>
                            <select id="departamento_id" class="form-select">
                                <?php foreach($departamentos as $departamento): ?>
                                    <option value="<?php echo $departamento->id; ?>"><?php echo htmlspecialchars($departamento->nombre_departamento); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">Guardar</button></td>
                        </div>                            
                        </div>
                    <input type="hidden" id="id">
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Obtener el ID de la persona de la URL
            const urlParams = new URLSearchParams(window.location.search);
            const id = urlParams.get('id');
            document.getElementById('id').value = id;

            // Realizar una solicitud AJAX para obtener los datos de la persona
            fetch(`../api/get_persona.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    // Llenar los campos del formulario con los datos de la persona
                    document.getElementById('nombres').value = data.nombres;
                    document.getElementById('apellidos').value = data.apellidos;
                    document.getElementById('fecha_ingreso').value = data.fecha_ingreso;
                    document.getElementById('comentarios').value = data.comentarios;
                    document.getElementById('salario').value = data.salario;
                    document.getElementById('genero_id').value = data.genero_id;
                    document.getElementById('departamento_id').value = data.departamento_id;
                })
                .catch(error => console.error('Error:', error));
        });

        document.getElementById('updateForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el envío del formulario

            const formData = new FormData();
            formData.append('id', document.getElementById('id').value);
            formData.append('nombres', document.getElementById('nombres').value);
            formData.append('apellidos', document.getElementById('apellidos').value);
            formData.append('fecha_ingreso', document.getElementById('fecha_ingreso').value);
            formData.append('comentarios', document.getElementById('comentarios').value);
            formData.append('salario', document.getElementById('salario').value);
            formData.append('genero_id', document.getElementById('genero_id').value);
            formData.append('departamento_id', document.getElementById('departamento_id').value);

            fetch('../api/update.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Registro actualizado correctamente');
                    window.location.href = 'http://localhost/app_crud_php/'; 
                } else {
                    alert('Error al actualizar el registro: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
