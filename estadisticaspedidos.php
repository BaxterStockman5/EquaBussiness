<?php
header("Content-Type: application/json");
require "conexion.php"; // Archivo de conexión a la base de datos

$sql = "SELECT estado, COUNT(*) AS cantidad FROM pedidos GROUP BY estado";
$consulta = mysqli_query($conexion, $sql);

$resultados = array();
while ($fila = mysqli_fetch_assoc($consulta)) {
    $resultados[$fila["estado"]] = (int)$fila["cantidad"];
}

echo json_encode($resultados);
?>
