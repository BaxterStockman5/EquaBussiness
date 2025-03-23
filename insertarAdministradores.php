<?php
require_once('./conexion.php');
// Verificar que los datos fueron enviados
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  // Recoger los datos del formulario
  $nombre = $conexion->real_escape_string($_POST['nombre']);
  $apellido = $conexion->real_escape_string($_POST['apellido']);
  $telefono = $conexion->real_escape_string($_POST['telefono']);
  $direccion = $conexion->real_escape_string($_POST['direccion']);
  $email = $conexion->real_escape_string($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Encriptamos la contraseña

  // Manejo de la foto
  if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $foto_tmp = $_FILES['foto']['tmp_name'];
    $foto_name = $_FILES['foto']['name'];
    $foto_path = 'imagenes/' . basename($foto_name);

    // Mover la foto al directorio adecuado
    if (!move_uploaded_file($foto_tmp, $foto_path)) {
      echo "Error al subir la foto.";
      exit;
    }
  } else {
    $foto_path = 'default.jpg';  // Si no hay foto, se asigna la foto por defecto
  }

  // Consulta SQL para insertar el administrador
  $sql = "INSERT INTO administradores (nombre, apellido, telefono, direccion, email, foto, password) 
          VALUES ('$nombre', '$apellido', '$telefono', '$direccion', '$email', '$foto_path', '$password')";

  // Ejecutar la consulta y verificar si fue exitosa
  if ($conexion->query($sql) === TRUE) {
    echo "Administrador agregado con éxito.";
  } else {
    echo "Error al agregar el administrador: " . $conexion->error;
  }

  // Cerrar la conexión
  $conexion->close();
}
?>

