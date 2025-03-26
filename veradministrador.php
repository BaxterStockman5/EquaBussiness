<?php
// include("./conexion.php");

// // Verifica si se ha pasado el parámetro 'id' en la URL
// if (isset($_GET['id']) && is_numeric($_GET['id'])) {
//     $id_admin = $_GET['id'];  

//     // Prepara y ejecuta una consulta SQL segura en la tabla administradores
//     $stmt = $conexion->prepare("SELECT id_admin, nombre, apellido, telefono, direccion, email, foto, estado FROM administradores WHERE id_admin = ?");
//     $stmt->bind_param("i", $id_admin);  // "i" indica que el parámetro es un entero
//     $stmt->execute();

//     // Obtiene el resultado de la consulta
//     $result = $stmt->get_result();

//     // Verifica si se encontró el administrador
//     if ($result->num_rows > 0) {
//         // Obtener los datos del administrador
//         $administrador = $result->fetch_assoc();
        
//         // Devuelve el administrador en formato JSON
//         echo json_encode($administrador);
//     } else {
//         // Devuelve un mensaje de error si no se encuentra el administrador
//         echo json_encode(['error' => 'Administrador no encontrado']);
//     }

//     // Cierra la conexión
//     $stmt->close();
//     $conexion->close();
// } else {
//     // Devuelve un mensaje de error si no se proporciona un ID válido
//     echo json_encode(['error' => 'ID inválido o no proporcionado']);
// }
?>





