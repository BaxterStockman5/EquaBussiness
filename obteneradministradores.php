<?php
// obteneradministradores.php
require 'conexion.php'; // Asegúrate de que este archivo contiene la conexión con $conexion

$sql = "SELECT id_admin, nombre, apellido, telefono, direccion, email, foto, estado FROM administradores";
$resultado = mysqli_query($conexion, $sql); // CORRECCIÓN AQUÍ

$administradores = array();

if ($resultado) { //Verificar si la consulta se ejecutó correctamente
    while ($fila = mysqli_fetch_assoc($resultado)) {
        $administradores[] = $fila;
    }
    mysqli_free_result($resultado); //Liberar memoria del resultado
}

// Devolver JSON
echo json_encode($administradores);

// Cerrar la conexión
mysqli_close($conexion); // Usar la variable correcta para la conexión
?>






