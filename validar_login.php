<?php
session_start();
include "conexion.php"; // Asegúrate de que este archivo conecta correctamente a la base de datos

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);
    
    $sql = "SELECT id_admin, nombre, password FROM administradores WHERE email = ? AND estado = 'activo'";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if ($fila = mysqli_fetch_assoc($resultado)) {
        if (password_verify($password, $fila["password"])) {
            $_SESSION["admin_id"] = $fila["id_admin"];
            $_SESSION["admin_nombre"] = $fila["nombre"];
            
            echo json_encode(["success" => true]);
            exit;
        }
    }
    echo json_encode(["success" => false]);
}
?>
