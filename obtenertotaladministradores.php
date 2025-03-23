<?php
// Parámetros de conexión a la base de datos
require_once('conexion.php');

// Preparar la consulta SQL
$query = "SELECT COUNT(*) FROM administradores WHERE id_admin = id_admin";

// Preparar la sentencia
$stmt = $conexion->prepare($query);

// Ejecutar la consulta
$stmt->execute();

// Obtener el resultado
$stmt->bind_result($totalAdministradores);
$stmt->fetch();

// Cerrar la conexión y la sentencia
$stmt->close();
$conexion->close();

// Devolver el resultado al cliente (JavaScript)
echo $totalAdministradores;
?>
