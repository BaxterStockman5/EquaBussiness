<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger y limpiar datos del formulario
    $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
    $apellido = isset($_POST['apellido']) ? trim($_POST['apellido']) : '';
    $telefono = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
    $direccion = isset($_POST['direccion']) ? trim($_POST['direccion']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $contrasena = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($nombre) || empty($apellido) || empty($telefono) || empty($direccion) || empty($email) || empty($contrasena)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Encriptar la contraseña
    $hash = password_hash($contrasena, PASSWORD_DEFAULT);

    // Manejo de la imagen
    $imgPath = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === 0) {
        $imgName = $_FILES['foto']['name'];
        $imgTmp = $_FILES['foto']['tmp_name'];
        $imgType = $_FILES['foto']['type'];
        $imgSize = $_FILES['foto']['size'];

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($imgType, $allowedTypes)) {
            echo "Error: Solo se permiten imágenes JPEG, PNG o GIF.";
            exit;
        }

        if ($imgSize > 2 * 1024 * 1024) {
            echo "Error: La imagen es demasiado grande (máximo 2MB).";
            exit;
        }

        $uniqueName = time() . "-" . basename($imgName);
        $uploadDir = "imagenes/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        $imgPath = $uploadDir . $uniqueName;
        if (!move_uploaded_file($imgTmp, $imgPath)) {
            echo "Error: No se pudo subir la imagen.";
            exit;
        }
    }

    // Preparar la consulta de inserción
    $stmt = $conexion->prepare("INSERT INTO administradores (nombre, apellido, telefono, direccion, email, password, foto) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo "Error en la preparación: " . $conexion->error;
        exit;
    }
    $stmt->bind_param("sssssss", $nombre, $apellido, $telefono, $direccion, $email, $hash, $imgPath);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error";
    }

    $stmt->close();
} else {
    echo "Método de solicitud no permitido.";
}

$conexion->close();

