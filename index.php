<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Inicio</title>
</head>
<!--Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .table-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .th {
            text-align: center;
        }
    </style>
<body>
<div class="table-container">
    <div>
        <h3 class="text-center">Lista de Empleados</h3>
        <a href="view/form_insert.php"><button  type="button" class="btn btn-success mt-4">Ingresar Nuevo Registro</button></a>
        <a href="view/queries.php"><button  type="button" class="btn btn-primary mt-4">Consultas</button></a>
        <table class="table table-striped table-hover mt-4">
            <thead>
                <tr>
                    <th>NOMBRES</th>
                    <th>APELLIDOS</th>
                    <th>FECHA DE INGRESO</th>
                    <th>COMENTARIOS</th>
                    <th>SALARIO</th>
                    <th>GÉNERO</th>
                    <th>DEPARTAMENTO</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody id="empleados-tbody">
            </tbody>
        </table>
    </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            fetch('api/empleados.php')
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('empleados-tbody');
                    data.forEach(registro => {
                        const row = document.createElement('tr');
                        
                        row.innerHTML = `
                            <td>${registro.nombres}</td>
                            <td>${registro.apellidos}</td>
                            <td>${registro.fecha_ingreso}</td>
                            <td>${registro.comentarios}</td>
                            <td>${registro.salario}</td>
                            <td>${registro.genero}</td>
                            <td>${registro.departamento}</td>
                            <td>
                                <a href="view/form_update.php?id=${registro.id}"><button type="button" class="btn btn-secondary">Editar</button></a>
                                <a href="delete/delete.php?id=${registro.id}"><button type="button" class="btn btn-danger">Eliminar</button></a>
                            </td>
                        `;
                        tbody.appendChild(row);
                    });
                })
                .catch(error => console.error('Error al obtener los datos:', error));
        });
        
        function eliminarRegistro(id) {
            if (confirm('¿Estás seguro de que deseas eliminar este registro?')) {
                fetch(`api/delete.php`, {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${id}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Registro eliminado correctamente');
                        location.reload(); 
                    } else {
                        alert('Error al eliminar el registro');
                    }
                })
                .catch(error => console.error('Error:', error));
            }
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
