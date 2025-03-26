<?php
require('conexion.php');
$sql = "SELECT * FROM publicidad ORDER BY id DESC";
$result = $conexion->query($sql);
$publicidades = array();

while ($row = $result->fetch_assoc()) {
    $publicidades[] = array(
        "titulo" => $row["titulo"],
        "descripcion" => $row["descripcion"],
        "imagen" => $row["imagen"]
    );
}
header('Content-Type: application/json');
echo json_encode($publicidades);
?>


