
<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php"); // Redirigir si no hay sesión iniciada
    exit();
}
?>

<?php
require "conexion.php"; // Archivo de conexión a la base de datos

// Consulta para obtener los pedidos con estado "cancelado"
$sql = "SELECT p.id_pedido, c.nombre AS cliente, p.fecha_pedido, SUM(pr.precio * dp.cantidad) AS total, p.estado
        FROM pedidos p
        JOIN clientes c ON p.codcliente = c.id_cliente
        JOIN detalles_pedidos dp ON p.id_pedido = dp.id_pedido
        JOIN productos pr ON dp.id_producto = pr.id_producto
        WHERE p.estado = 'pendiente'
        GROUP BY p.id_pedido, c.nombre, p.fecha_pedido, p.estado";
$result = $conexion->query($sql);

$pedidos = [];
while ($row = $result->fetch_assoc()) {
    $pedidos[] = $row;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos pendiente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            font-family: 'Times New Roman', Times, serif;
            background-color: #f0f2f5;
        }
        aside {
            width: 250px;
            background-color:#0056b3;
            color: white;
            transition: width 0.3s;
            height: 100%;
            overflow: auto;
        }
        aside.collapsed {
            width: 0;
        }
        aside ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        aside ul li {
            padding: 15px;
            cursor: pointer;
        }
        aside ul li:hover {
            background-color: #495057;
        }
        main {
            flex-grow: 1;
            padding: 20px;
            overflow: auto;
        }
        .toggle-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            background-color: #343a40;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            z-index: 1000;
        }
        .table-container {
            margin-top: 20px;
        }
        aside {
            width: 250px;
        
            color: white;
            transition: width 0.3s;
            height: 100%;
            overflow: auto;
        }
        aside.collapsed {
            width: 0;
        }
        aside ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        aside ul li {
            padding: 15px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }
        aside ul li:hover {
            background-color:rgb(125, 159, 194);
            transform: translateX(10px);
        }
        aside ul li a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        aside ul li a i {
            margin-right: 10px;
        }
        .active{
            background: rgba(255, 255, 255, 0.4);
    font-weight: bold;
    border-left: 4px solid #ffcc00;
}
    </style>
</head>
<body>
    <!-- <button class="toggle-btn" onclick="toggleSidebar()">☰</button> -->
    <aside id="sidebar">
        <ul>
            <li><a href="./paginaproducto.php"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="#" class="active"><i class="fas fa-clock"></i> Pedidos Pendientes</a></li>
            <li><a href="pedidos_procesados.php"><i class="fas fa-sync-alt"></i> Pedidos Procesados</a></li>
            <li><a href="pedidos_cancelados.php"><i class="fas fa-times"></i> Pedidos Cancelados</a></li>
            <li><a href="pedidos_entregados.php"><i class="fas fa-check"></i> Pedidos Entregados</a></li>
            <li><a href="./paneladmin.php"><i class="fas fa-box"></i> Productos</a></li>
            <li><a href="clientes.php"><i class="fas fa-users"></i> Clientes</a></li>
            <li><a href="reportes.php"><i class="fas fa-chart-line"></i> Reportes</a></li>
            <li><a href="configuracion.php"><i class="fas fa-cog"></i> Configuración</a></li>
        </ul>
    </aside>
    <main>
        <h3>Pedidos pendientes</h3>
        <div class="table-container">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Total</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($pedidos) > 0): ?>
                        <?php foreach ($pedidos as $pedido): ?>
                        <tr>
                            <td><?php echo $pedido['id_pedido']; ?></td>
                            <td><?php echo $pedido['cliente']; ?></td>
                            <td><?php echo $pedido['fecha_pedido']; ?></td>
                            <td><?php echo $pedido['total']; ?></td>
                            <td><?php echo $pedido['estado']; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5">No hay pedidos pendientes.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('collapsed');
        }
    </script>
</body>
</html>