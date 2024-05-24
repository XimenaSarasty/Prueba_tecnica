<?php
// Incluir el archivo de conexión
include '../config/conexion.php';

// Limpiar la tabla de gastos antes de llenarla
$db->exec("TRUNCATE TABLE Gastos");

// Obtener la fecha actual
$fecha_actual = new DateTime();

// Obtener todos los empleados
$sql = "SELECT id, fecha_ingreso, salario, departamento_id FROM Empleados";
$stmt = $db->query($sql);
$empleados = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($empleados as $empleado) {
    $fecha_ingreso = new DateTime($empleado['fecha_ingreso']);
    $salario = $empleado['salario'];
    $departamento_id = $empleado['departamento_id'];

    // Calcular los meses de trabajo del empleado desde la fecha de ingreso hasta la fecha actual
    $intervalo = $fecha_ingreso->diff($fecha_actual);
    $meses_trabajados = ($intervalo->y * 12) + $intervalo->m;

    for ($i = 0; $i <= $meses_trabajados; $i++) {
        $fecha = clone $fecha_ingreso;
        $fecha->modify("+$i month");
        $ano = $fecha->format('Y');
        $mes = $fecha->format('m');

        // Insertar el gasto mensual en la tabla Gastos
        $sql_insert = "INSERT INTO Gastos (ano, mes, gastos, departamento_id) 
        VALUES (:ano, :mes, :gastos, :departamento_id)";
        $stmt_insert = $db->prepare($sql_insert);
        $stmt_insert->execute([
        ':ano' => $ano,
        ':mes' => $mes,
        ':gastos' => $salario,
        ':departamento_id' => $departamento_id
        ]);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultas</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .table-container {
            margin: 100px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="table-container">
        <h3 class="text-center">Resultados de las Consultas</h3>

        <!-- Consulta 1: Empleados del departamento TI -->
        <div class="mt-4">
            <?php
            $sql = "SELECT e.*
                    FROM Empleados e
                    JOIN Departamentos d ON e.departamento_id = d.id
                    WHERE d.nombre_departamento = 'TI'";
            $stmt = $db->query($sql);

            echo "<h4>1. Empleados del departamento TI</h4>";
            if ($stmt->rowCount() > 0) {
                echo "<table class='table table-striped table-hover'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Fecha de Ingreso</th>
                                <th>Salario</th>
                            </tr>
                        </thead>
                        <tbody>";
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['nombres']}</td>
                            <td>{$row['apellidos']}</td>
                            <td>{$row['fecha_ingreso']}</td>
                            <td>{$row['salario']}</td>
                          </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "0 resultados";
            }
            ?>
        </div>

        <!-- Consulta 2: Top 3 departamentos con más gastos -->
        <div class="mt-4">
            <?php
            $sql = "SELECT d.nombre_departamento, SUM(g.gastos) AS total_gastos
                    FROM Gastos g
                    JOIN Departamentos d ON g.departamento_id = d.id
                    GROUP BY d.nombre_departamento
                    ORDER BY total_gastos DESC
                    LIMIT 3";
            $stmt = $db->query($sql);

            echo "<h4>2. Top 3 departamentos con más gastos</h4>";
            if ($stmt->rowCount() > 0) {
                echo "<table class='table table-striped table-hover'>
                        <thead>
                            <tr>
                                <th>Departamento</th>
                                <th>Gastos Totales</th>
                            </tr>
                        </thead>
                        <tbody>";
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>{$row['nombre_departamento']}</td>
                            <td>{$row['total_gastos']}</td>
                          </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "0 resultados";
            }
            ?>
        </div>

        <!-- Consulta 3: Empleado con mayor salario -->
        <div class="mt-4">
            <?php
            $sql = "SELECT *
                    FROM Empleados
                    ORDER BY salario DESC
                    LIMIT 1";
            $stmt = $db->query($sql);

            echo "<h4>3. Empleado con mayor salario</h4>";
            if ($stmt->rowCount() > 0) {
                echo "<table class='table table-striped table-hover'>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Fecha de Ingreso</th>
                                <th>Salario</th>
                            </tr>
                        </thead>
                        <tbody>";
                while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['nombres']}</td>
                            <td>{$row['apellidos']}</td>
                            <td>{$row['fecha_ingreso']}</td>
                            <td>{$row['salario']}</td>
                          </tr>";
                }
                echo "</tbody></table>";
            } else {
                echo "0 resultados";
            }
            ?>
        </div>

        <!-- Consulta 4: Cantidad de empleados con salarios menor a 1,500,000 -->
        <div class="mt-4">
            <?php
            $sql = "SELECT COUNT(*) AS cantidad_empleados
                    FROM Empleados
                    WHERE salario < 1500000";
            $stmt = $db->query($sql);

            echo "<h4>4. Cantidad de empleados con salarios menor a $1'500,000</h4>";
            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                echo "Cantidad: " . $row["cantidad_empleados"];
            } else {
                echo "0 resultados";
            }
            ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
