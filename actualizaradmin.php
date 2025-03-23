<?php
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_DEFAULT) : null;
    $img = null;

    // Manejo de la imagen si se sube un nuevo archivo
    if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
        $img_nombre = time() . "_" . basename($_FILES['img']['name']);
        $ruta_destino = "imagenes/" . $img_nombre;
        
        if (move_uploaded_file($_FILES['img']['tmp_name'], $ruta_destino)) {
            $img = $ruta_destino;
        }
    }

    // Construcción de la consulta dinámicamente
    $sql = "UPDATE administradores SET nombre=?, email=?";
    $params = ["ss", &$nombre, &$email];

    if ($password !== null) {
        $sql .= ", password=?";
        $params[0] .= "s";
        $params[] = &$password;
    }

    if ($img !== null) {
        $sql .= ", img=?";
        $params[0] .= "s";
        $params[] = &$img;
    }

    $sql .= " WHERE id=?";
    $params[0] .= "i";
    $params[] = &$id;

    // Preparar la consulta
    $stmt = $conexion->prepare($sql);
    call_user_func_array([$stmt, 'bind_param'], $params);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Administrador actualizado correctamente."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Hubo un error al actualizar el administrador."]);
    }
}
?>
