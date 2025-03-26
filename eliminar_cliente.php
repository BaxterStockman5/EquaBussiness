// Código PHP para eliminar el cliente
<?php
require_once('./conexion.php');
if (isset($_POST['id_cliente'])) {
    $id_cliente = $_POST['id_cliente'];
    $sql = "DELETE FROM clientes WHERE id_cliente = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_cliente);
    if ($stmt->execute()) {
        echo "Cliente eliminado";
    } else {
        echo "Error al eliminar cliente";
    }
    $stmt->close();
    $conexion->close();
}
?>
