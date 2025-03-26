

<?php
header('Content-Type: application/json');

require_once('./conexion.php');

$sql = "SELECT * FROM clientes";
$result = $conexion->query($sql);

$clientes = [];

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $clientes[] = $row;
    }
}

$conexion->close();

// Devolver los datos en formato JSON
echo json_encode($clientes);
?>
