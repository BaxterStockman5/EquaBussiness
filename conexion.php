
<?php
$host = 'localhost'; // Servidor de la base de datos
$usuario = 'root'; // Usuario de la base de datos
$contrasena = ''; // Contraseña de la base de datos
$base_datos = 'EquaBussiness2'; // Nombre de la base de datos

// Crear la conexión
$conexion = new mysqli($host, $usuario, $contrasena, $base_datos);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}else{
    //  echo "Conectado satisfactoriamente";
}
?>