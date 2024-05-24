<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insertar Nuevo Empleado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-4">
                <form id="insertForm">
                    <h3 class="text-center">Insertar Nuevo Empleado</h3>
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombres:</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                        </div>
                        <div class="mb-3">
                            <label for="apellidos" class="form-label">Apellidos:</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_ingreso" class="form-label">Fecha de Ingreso:</label>
                            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
                        </div>
                        <div class="mb-3">  
                            <label for="comentarios" class="form-label">Comentarios:</label>
                            <input type="text" class="form-control" id="comentarios" name="comentarios">
                        </div>
                        <div class="mb-3">  
                            <label for="salario" class="form-label">Salario:</label>
                            <input type="number" class="form-control" id="salario" name="salario" required>
                        </div>
                        <div class="mb-3"> 
                        <label for="genero_id" class="form-label">Género:</label>
                        <select id="genero_id" class="form-control" name="genero_id" required></select>
                        </div>
                        <div class="mb-3">
                        <label for="departamento_id" class="form-label">Departamento:</label>
                        <select id="departamento_id" class="form-control" name="departamento_id" required></select>
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Función para cargar opciones de género
        function cargarGeneros() {
            fetch('../api/generos.php')
                .then(response => response.json())
                .then(data => {
                    const selectGenero = document.getElementById('genero_id');
                    data.forEach(genero => {
                        const option = document.createElement('option');
                        option.value = genero.id;
                        option.textContent = genero.nombre;
                        selectGenero.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        // Función para cargar opciones de departamentos
        function cargarDepartamentos() {
            fetch('../api/departamentos.php')
                .then(response => response.json())
                .then(data => {
                    const selectDepartamento = document.getElementById('departamento_id');
                    data.forEach(departamento => {
                        const option = document.createElement('option');
                        option.value = departamento.id;
                        option.textContent = departamento.nombre;
                        selectDepartamento.appendChild(option);
                    });
                })
                .catch(error => console.error('Error:', error));
        }

        // Llamadas a las funciones para cargar opciones al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            cargarGeneros();
            cargarDepartamentos();
        });

        // Evento submit del formulario
        document.getElementById('insertForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Evitar el envío del formulario

            const formData = new FormData(event.target);

            fetch('../api/insert.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Registro insertado correctamente');
                    window.location.href = 'http://localhost/app_crud_php/'; 
                } else {
                    alert('Error al insertar el registro: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        });
    </script>
</body>
</html>
