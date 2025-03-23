<?php
require('conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST['titulo'];
    $descripcion = $_POST['descripcion'];

    if (!empty($_FILES['imagen']['name'])) {
        $imagen = $_FILES['imagen']['name'];
        $rutaDestino = "imagenes/" . basename($imagen);
        move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaDestino);
    } else {
        $imagen = "";
    }

    $sql = "INSERT INTO publicidad (titulo, descripcion, imagen) VALUES ('$titulo', '$descripcion', '$imagen')";
    if ($conexion->query($sql) === TRUE) {
        echo "Publicidad guardada con éxito";
    } else {
        echo "Error: " . $conexion->error;
    }
}
?>


