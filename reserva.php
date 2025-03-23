<?php
// Incluir el archivo de conexión
require 'conexion.php'; // Asegúrate de que la ruta sea correcta

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     // Obtener y sanitizar los datos del formulario
//     $nombre = htmlspecialchars(trim($_POST['nombre']));
//     $apellido = htmlspecialchars(trim($_POST['apellido']));
//     $telefono = htmlspecialchars(trim($_POST['telefono']));
//     $direccion = htmlspecialchars(trim($_POST['direccion']));
//     $email = htmlspecialchars(trim($_POST['email']));
//     $productos = explode(',', $_POST['productos']);

//     // Validar que todos los campos estén completos
//     if (empty($nombre) || empty($apellido) || empty($telefono) || empty($direccion) || empty($email) || empty($productos)) {
//         die("Todos los campos son obligatorios.");
//     }

//     // Validar el email
//     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         die("El email no es válido.");
//     }

//     // Insertar usuario en la base de datos
//     try {
//         // Preparar la consulta para insertar el usuario
//         $sql = "INSERT INTO usuarios (nombre, apellido, telefono, direccion, email) 
//                 VALUES (?, ?, ?, ?, ?)";
//         $stmt = $conexion->prepare($sql);
//         if (!$stmt) {
//             throw new Exception("Error al preparar la consulta: " . $conexion->error);
//         }
//         $stmt->bind_param("sssss", $nombre, $apellido, $telefono, $direccion, $email);

//         // Ejecutar la consulta
//         if ($stmt->execute()) {
//             $usuario_id = $conexion->insert_id; // Obtener el ID del usuario insertado

//             // Insertar las reservas de productos
//            // Verifica que $id tenga un valor válido
// if (!isset($id) || empty($id)) {
//     throw new Exception("Error: El ID del usuario no puede estar vacío.");
// }

// // Insertar las reservas de productos
// foreach ($productos as $producto_id) {
//     // Corregir la consulta para no pasar NULL como valor para usuario_id
//     $sql = "INSERT INTO reservas (id_usuario, id_producto) VALUES (?, ?)";

//     $stmt = $conexion->prepare($sql);
//     if (!$stmt) {
//         throw new Exception("Error al preparar la consulta: " . $conexion->error);
//     }

//     // Asegurarse de que $id y $producto_id sean valores válidos
//     $stmt->bind_param("ii", $id, $producto_id);

//     if (!$stmt->execute()) {
//         throw new Exception("Error al reservar el producto: " . $stmt->error);
//     }
// }


//             echo "Reserva realizada correctamente.";
//         } else {
//             throw new Exception("Error al registrar el usuario: " . $stmt->error);
//         }
//     } catch (Exception $e) {
//         die($e->getMessage()); // Mostrar mensaje de error
//     } finally {
//         // Cerrar la declaración y la conexión
//         if (isset($stmt)) {
//             $stmt->close();
//         }
//         if (isset($conexion)) {
           
//         }
//     }
// } else {
//     // Redirigir si no se envió el formulario
//     header('Location: ./paginaproducto.php');
//     exit();
// }

// // 
//  // Obtener los productos seleccionados en la reserva
// if (isset($_GET['productos'])) {
//     $productos = json_decode(urldecode($_GET['productos']), true);
// } else {
//     $productos = [];
// }
// ?>

 <h2>Confirmar Reserva</h2>
 <?php if (empty($productos)): ?>
     <p>No hay productos en la reserva.</p>
 <?php else: ?>
    <ul>
        <?php foreach ($productos as $producto): ?>
             <li>
                 <?= $producto['nombre']; ?> - <?= $producto['cantidad']; ?> x <?= $producto['precio']; ?> XAF
             </li>
         <?php endforeach; ?>
     </ul>
     <button>Finalizar Reserva</button>
 <?php endif; ?>

