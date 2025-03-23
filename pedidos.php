<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php"); // Redirigir si no hay sesión iniciada
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Estilos generales */
        body {
            background-color: #f4f7fc;
            font-family: 'Arial', sans-serif;
            color: #333;
            margin: 0;
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        aside {
            width: 250px;
            background-color: #0056b3;
            color: white;
            transition: width 0.3s;
            height: 100%;
            overflow-y: auto;
            box-shadow: 2px 0px 10px rgba(0, 0, 0, 0.1);
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
            background-color: #004085;
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

        /* Main area */
        main {
            flex-grow: 1;
            padding: 20px;
            overflow: auto;
            background-color: #fff;
        }

        /* Titulo */
        h3 {
            color: #0056b3;
            font-size: 2rem;
            margin-bottom: 20px;
            text-align: center;
        }

        /* Tabla */
        .table-container {
            margin-top: 20px;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        .table .row.header {
            background-color: #0056b3;
            color: white;
            font-weight: bold;
            text-align: center;
            padding: 10px;
        }

        .table .row {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            padding: 15px;
            border-bottom: 1px solid #e5e5e5;
            transition: background-color 0.3s;
        }

        .table .row:hover {
            background-color: #f8f9fa;
        }

        .table .row .col {
            text-align: center;
            padding: 10px;
            font-size: 1rem;
        }

        .estado {
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            text-transform: capitalize;
        }

        .estado.pendiente {
            background-color: #17a2b8;
            color: white;
        }

        .estado.procesado {
            background-color: #ffc107;
            color: black;
        }

        .estado.entregado {
            background-color: #28a745;
            color: white;
        }

        .estado.cancelado {
            background-color: #dc3545;
            color: white;
        }

        .btn {
            padding: 6px 12px;
            font-size: 1rem;
            border-radius: 20px;
            transition: background-color 0.3s;
        }

        .btn-info {
            background-color: #17a2b8;
            color: white;
        }

        .btn-success {
            background-color: #28a745;
            color: white;
        }

        .btn-danger {
            background-color: #dc3545;
            color: white;
        }

        .btn:hover {
            filter: brightness(0.9);
        }

        /* Animación de campanita */
        .campanita {
            animation: shake 0.6s ease-in-out infinite;
        }

        @keyframes shake {
            0% { transform: rotate(0deg); }
            25% { transform: rotate(10deg); }
            50% { transform: rotate(0deg); }
            75% { transform: rotate(-10deg); }
            100% { transform: rotate(0deg); }
        }
    </style>
</head>
<body>
    <aside id="sidebar">
        <ul>
            <li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
            <li><a href="pedidos_pendientes.php"><i class="fas fa-clock"></i> Pedidos Pendientes</a></li>
            <li><a href="pedidos_procesados.php"><i class="fas fa-sync-alt"></i> Pedidos Procesados</a></li>
            <li><a href="pedidos_cancelados.php"><i class="fas fa-times"></i> Pedidos Cancelados</a></li>
            <li><a href="pedidos_entregados.php"><i class="fas fa-check"></i> Pedidos Entregados</a></li>
            <li><a href="productos.php"><i class="fas fa-box"></i> Productos</a></li>
            <li><a href="./paneladmin.php"><i class="fas fa-users"></i> Clientes</a></li>
            <li><a href="./librerias/reporte_pedidos.php"><i class="fas fa-chart-line"></i> Reportes</a></li>
            <li><a href="./detalles_pedidos.php"><i class="fas fa-cog"></i> Detalles Pedidos</a></li>
        </ul>
    </aside>
    <main>
        <h3>Lista de Pedidos</h3>
        <div class="table-container">
            <div class="table">
                <div class="row header">
                    <div class="col">ID Pedido</div>
                    <div class="col">Cliente</div>
                    <div class="col">Fecha</div>
                    <div class="col">Total</div>
                    <div class="col">Estado</div>
                    <div class="col">Acciones</div>
                </div>
                <div id="pedidosBody">
                    <!-- Los pedidos se agregarán aquí dinámicamente -->
                </div>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            cargarPedidos();
        });

        function cargarPedidos() {
            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'mostrar_pedidos.php', true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const pedidos = JSON.parse(xhr.responseText);
                    const pedidosBody = document.getElementById('pedidosBody');
                    pedidosBody.innerHTML = '';

                    pedidos.forEach(pedido => {
                        const fila = document.createElement('div');
                        fila.classList.add('row');
                        fila.innerHTML = `
                            <div class="col">${pedido.id_pedido}</div>
                            <div class="col">${pedido.cliente}</div>
                            <div class="col">${pedido.fecha_pedido}</div>
                            <div class="col">${pedido.total}</div>
                            <div class="col"><span class="estado ${pedido.estado}">${pedido.estado}</span></div>
                            <div class="col">
                                <button class="btn btn-info btn-sm" onclick="cambiarEstado(${pedido.id_pedido}, 'procesado')">
                                    <i class="fas fa-sync-alt"></i>
                                </button>
                                <button class="btn btn-success btn-sm" onclick="cambiarEstado(${pedido.id_pedido}, 'entregado')">
                                    <i class="fas fa-check"></i> 
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="cambiarEstado(${pedido.id_pedido}, 'cancelado')">
                                    <i class="fas fa-times"></i>         
                                </button>
                            </div>
                        `;
                        pedidosBody.appendChild(fila);
                    });
                } else {
                    console.error('Error al cargar los pedidos. Código:', xhr.status);
                }
            };

            xhr.send();
        }

        function cambiarEstado(id, estado) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'cambiar_estado_pedido.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const respuesta = JSON.parse(xhr.responseText);
                    if (respuesta.success) {
                        cargarPedidos();
                    } else {
                        console.error('Error al cambiar el estado del pedido:', respuesta.error);
                    }
                } else {
                    console.error('Error al cambiar el estado del pedido. Código:', xhr.status);
                }
            };

            xhr.send(`id_pedido=${id}&estado=${estado}`);
        }
    </script>
</body>
</html>
