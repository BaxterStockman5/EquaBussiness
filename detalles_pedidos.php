<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de los Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            font-family: 'Times New Roman', Times, serif;
        }

        aside {
            width: 250px;
            background: #0056b3;
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

        #sidebar a {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            font-size: 16px;
            transition: background 0.3s, transform 0.2s;
        }

        aside ul li {
            padding: 15px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        aside ul li:hover {
            background-color: #495057;
        }

        main {
            flex-grow: 1;
            padding: 20px;
            overflow: auto;
            background-color: #f8f9fa;
        }

        .table-container {
            margin-top: 20px;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(133, 106, 106, 0.1);
        }

        .table .row.header {
            font-weight: bold;
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
        }

        .table .row {
            display: flex;
            align-items: center;
            border-bottom: 1px solid #dee2e6;
            padding: 10px 0;
            transition: background-color 0.3s;
        }

        .table .row .col {
            flex: 1;
            text-align: center;
        }

        .table .row .col:last-child {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .table .row.pedido-row:hover {
            background-color: #f1f1f1;
        }

        .btn {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .btn i {
            font-size: 1rem;
        }

        /* LINK ACTIVO */
        .sidebar a.active {
            background: rgba(255, 255, 255, 0.4);
            font-weight: bold;
            border-left: 4px solid #ffcc00;
        }

        .estado {
            padding: 5px 10px;
            border-radius: 5px;
            color: white;
            font-weight: bold;
        }

        .estado.pendiente {
            background-color: #17a2b8;
        }

        .estado.procesado {
            background-color: #ffc107;
        }

        .estado.entregado {
            background-color: #28a745;
        }

        .estado.cancelado {
            background-color: #dc3545;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from { transform: translateY(-50px); }
            to { transform: translateY(0); }
        }

        /* Modal Styling */
        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            animation: slideIn 0.3s;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .modal .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .modal .close:hover {
            color: #000;
        }

        @media (max-width: 768px) {
            .table-container {
                padding: 10px;
            }
            .table .row {
                flex-direction: column;
                align-items: flex-start;
            }
            .table .row .col {
                width: 100%;
                text-align: left;
            }
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
            <li><a href="#" class="active"><i class="fas fa-box"></i> Detalles Pedidos</a></li>
            <li><a href="clientes.php"><i class="fas fa-users"></i> Clientes</a></li>
            <li><a href="reportes.php"><i class="fas fa-chart-line"></i> Reportes</a></li>
            <li><a href="configuracion.php"><i class="fas fa-cog"></i> Configuración</a></li>
        </ul>
    </aside>

    <main>
        <h3>Detalles de los Pedidos</h3>
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

    <div id="pedidoModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: rgba(0, 0, 0, 0.5); animation: fadeIn 0.3s;">
        <div class="modal-content">
            <span class="close" onclick="cerrarModal()">&times;</span>
            <h4>Detalles del Pedido</h4>
            <div id="detallesPedido"></div>
        </div>
    </div>

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
                        fila.classList.add('row', 'pedido-row');
                        fila.innerHTML = `
                            <div class="col">${pedido.id_pedido}</div>
                            <div class="col">${pedido.cliente}</div>
                            <div class="col">${pedido.fecha_pedido}</div>
                            <div class="col">${pedido.total}</div>
                            <div class="col"><span class="estado ${pedido.estado}">${pedido.estado}</span></div>
                            <div class="col">
                                <button class="btn btn-info btn-sm" onclick="mostrarDetalles(${pedido.id_pedido})">
                                    <i class="fas fa-eye"></i>
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
        function mostrarDetalles(idPedido) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', `detalles_pedido.php?id_pedido=${idPedido}`, true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            const detalles = JSON.parse(xhr.responseText);
            const detallesPedido = document.getElementById('detallesPedido');
            detallesPedido.innerHTML = `
                <p><strong>ID Pedido:</strong> ${detalles.id_pedido}</p>
                <p><strong>Cliente:</strong> ${detalles.cliente}</p>
                <p><strong>Correo:</strong> ${detalles.email}</p>
                <p><strong>Teléfono:</strong> ${detalles.telefono}</p>
                <p><strong>Dirección:</strong> ${detalles.direccion}</p>
                <p><strong>Fecha:</strong> ${detalles.fecha_pedido}</p>
                <p><strong>Total:</strong> ${detalles.total}</p>
                <h5>Productos:</h5>
                <ul>
                    ${detalles.productos.map(producto => `
                        <li>
                            <img src="${producto.imagen}" alt="${producto.nombre}" width="50">
                            ${producto.nombre} - ${producto.cantidad} x ${producto.precio} = ${producto.cantidad * producto.precio}
                        </li>
                    `).join('')}
                </ul>
            `;
            // Abrir el modal con una animación de fade-in
            document.getElementById('pedidoModal').style.display = 'block';
            document.getElementById('pedidoModal').classList.add('fade-in');
        } else {
            console.error('Error al cargar los detalles del pedido. Código:', xhr.status);
        }
    };
    xhr.send();
}

     function cerrarModal() {
            document.getElementById('pedidoModal').style.display = 'none';
        }
    </script>
    <style>
        /* Animación de fade-in */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

/* Animación de slide-in desde la parte inferior */
@keyframes slideIn {
    from { transform: translateY(30px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

#detallesPedido {
    animation: fadeIn 0.6s ease-out;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    max-width: 600px;
    margin: 0 auto;
}

/* Estilo de cada detalle del pedido */
#detallesPedido p {
    font-size: 16px;
    margin: 10px 0;
    transition: all 0.3s ease;
}

/* Efecto de resaltar cuando el texto cambia */
#detallesPedido p strong {
    color: #0056b3;
    font-weight: bold;
}

/* Estilo de la lista de productos */
#detallesPedido ul {
    list-style-type: none;
    padding: 0;
    margin: 10px 0;
}

#detallesPedido ul li {
    background-color: #ffffff;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 10px;
    display: flex;
    align-items: center;
    transition: transform 0.3s ease, background-color 0.3s ease;
    animation: slideIn 0.6s ease-out;
}

/* Hover effect for each product */
#detallesPedido ul li:hover {
    transform: scale(1.05);
    background-color: #f1f1f1;
}

#detallesPedido img {
    border-radius: 50%;
    margin-right: 15px;
    transition: transform 0.3s ease;
}

#detallesPedido img:hover {
    transform: scale(1.1);
}

/* Animación de entrada de productos */
@keyframes productEntry {
    from { opacity: 0; transform: translateX(-50px); }
    to { opacity: 1; transform: translateX(0); }
}

#detallesPedido ul li {
    animation: productEntry 0.5s ease-out forwards;
}

#detallesPedido ul li:nth-child(1) {
    animation-delay: 0s;
}

#detallesPedido ul li:nth-child(2) {
    animation-delay: 0.1s;
}

#detallesPedido ul li:nth-child(3) {
    animation-delay: 0.2s;
}

/* Y así sucesivamente... */
/* Animación flip */
@keyframes flipIn {
    0% {
        transform: rotateY(90deg);
        opacity: 0;
    }
    100% {
        transform: rotateY(0);
        opacity: 1;
    }
}

#pedidoModal {
    animation: flipIn 0.6s ease-out;
    transform-origin: center;
}
/* Animación de pulsar el botón */
@keyframes pulse {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.1);
    }
    100% {
        transform: scale(1);
    }
}

.btn-cerrar {
    animation: pulse 1.5s infinite;
}
@keyframes slideFromLeft {
    from {
        transform: translateX(-100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

#detallesPedido {
    animation: slideFromLeft 0.6s ease-out;
}
/* Efecto typing para el total */
@keyframes typing {
    from {
        width: 0;
    }
    to {
        width: 100%;
    }
}

#detallesPedido p strong {
    display: inline-block;
    white-space: nowrap;
    overflow: hidden;
    width: 0;
    animation: typing 2s steps(30) forwards;
}
/* Efecto hover para los botones */
.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    background-color: #0056b3;
    transform: translateY(-3px);
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
}
/* Sombra animada para los detalles */
#detallesPedido {
    transition: box-shadow 0.4s ease-in-out;
}

#detallesPedido:hover {
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}
/* Zoom en imagen */
#detallesPedido img {
    transition: transform 0.3s ease;
}

#detallesPedido img:hover {
    transform: scale(1.2);
}


/* Estilo general para la tabla */
.table-container {
    max-height: 500px; /* Controla la altura */
    overflow-y: auto; /* Agrega el scroll vertical */
    border-radius: 10px; /* Bordes redondeados */
    background-color: #f9f9f9; /* Fondo suave */
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1); /* Sombra suave para el contenedor */
    padding: 10px;
    margin-top: 20px;
}

/* Diseño de la tabla */
.table {
    width: 100%;
    border-collapse: collapse;
    transition: transform 0.3s ease-in-out;
}

.table .row {
    display: flex;
    padding: 10px;
    border-bottom: 1px solid #ddd;
    transition: all 0.3s ease;
}

.table .row.header {
    background-color: #4f6d7a;
    color: #fff;
    font-weight: bold;
    text-transform: uppercase;
}

.table .col {
    flex: 1;
    padding: 10px;
    text-align: center;
}

/* Estilo para las filas de la tabla */
.table .row:nth-child(even) {
    background-color: #f2f2f2;
}

.table .row:hover {
    background-color: #e1f5fe; /* Color suave en hover */
    transform: translateX(10px); /* Desplazamiento sutil en hover */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Sombra en hover */
}

/* Transición y efecto al pasar el mouse por las celdas */
.table .col:hover {
    background-color: #d1e8e2;
    transform: scale(1.05);
    transition: transform 0.3s ease-in-out;
}

/* Animación de entrada de filas */
@keyframes rowEntry {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.table .row {
    animation: rowEntry 0.5s ease-out;
}

/* Personalización de los botones de acción */
.table .actions {
    display: flex;
    justify-content: center;
    gap: 10px;
}

.table .actions button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

.table .actions button:hover {
    background-color: #0056b3;
    box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
}

/* Efecto de scroll suave */
.table-container::-webkit-scrollbar {
    width: 8px;
}

.table-container::-webkit-scrollbar-thumb {
    background-color: #007bff;
    border-radius: 10px;
}

.table-container::-webkit-scrollbar-thumb:hover {
    background-color: #0056b3;
}

/* Diseño responsivo */
@media (max-width: 768px) {
    .table .row {
        flex-direction: column;
        align-items: flex-start;
    }

    .table .col {
        text-align: left;
        padding: 8px;
        font-size: 14px;
    }
}

    </style>
</body>
</html>
