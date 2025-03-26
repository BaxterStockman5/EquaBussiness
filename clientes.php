<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
    <!-- Incluir Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Incluir FontAwesome para iconos -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Incluir SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.0/dist/sweetalert2.all.min.js"></script>
    <!-- Enlace para la hoja de estilos de Bootstrap 5 -->

<!-- Enlace para los íconos de Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">


    <style>
        /* Estilos generales */
        body {
            display: flex;
            height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #f0f2f5;
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            background-color: #007bff;
            top: 0;
            left: 0;
            width: 250px;
            height: 100vh;
            background: linear-gradient(to bottom, #007bff, #0056b3);
            padding-top: 20px;
            transition: width 0.3s ease;
            z-index: 1000;
            box-shadow: 3px 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar h2 {
            color: white;
            text-align: center;
            font-size: 1.8rem;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            font-size: 16px;
            transition: background 0.3s, transform 0.2s;
        }

        .sidebar a i {
            margin-right: 10px;
        }

        .sidebar a:hover {
            background: #0056b3;
            transform: translateX(5px);
        }

        /* Tabla */
        .content {
            margin-left: 250px;
            padding: 20px;
            flex-grow: 1;
        }

        .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .table thead {
            background-color: #007bff;
            color: white;
        }

        .table th, .table td {
            text-align: center;
            padding: 12px;
        }

        .table tbody tr:hover {
            background-color: #f1f1f1;
            cursor: pointer;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .btn-delete {
            color: white;
            background-color: #dc3545;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }
        /* Estilo para la tabla con scroll */
.table-container {
    max-height: 400px;  /* Establecer una altura máxima para la tabla */
    overflow-y: auto;   /* Activar el scroll vertical */
    margin-top: 20px;
}

.table {
    width: 100%;
    border-collapse: collapse;
    table-layout: fixed; /* Evita que la tabla crezca más allá del contenedor */
}

th, td {
    padding: 12px;
    text-align: left;
}

thead {
    background-color: #007bff;
    color: white;
}

tbody {
    background-color: #f9f9f9;
}

tbody tr:nth-child(even) {
    background-color: #f1f1f1;
}

tbody tr:hover {
    background-color: #e8f5ff;
}


    </style>
</head>

<body>
    <div class="sidebar">
        <h2>EquaBusiness</h2>
        <a href="./paginaproducto.php"><i class="fas fa-home"></i> <span>Inicio</span></a>
        <a href="./pedidos_pendientes.php"><i class="fas fa-tachometer-alt"></i> <span>Pedidos Pendientes</span></a>
        <a href="#"><i class="fas fa-box"></i> <span>Gestionar Productos</span></a>
        <a href="./pedidos.php"><i class="fas fa-calendar-check"></i> <span>Pedidos</span></a>
        <a href="./administradores.php"><i class="fas fa-users"></i> <span>Administradores</span></a>
        <a href="./detalles_pedidos.php"><i class="fas fa-history"></i> <span>Detalles Pedidos</span></a>
    </div>

    <div class="content">
        <h1 class="text-center mb-4">Lista de Clientes</h1>
        <div class="table-container">
            <table class="table table-bordered table-striped" id="tabla-clientes">
            <thead style="background-color: #007bff;" class="table- text-center">
    <tr>
        <th><i class="bi bi-hash"></i> ID</th>
        <th><i class="bi bi-person"></i> Nombre</th>
        <th><i class="bi bi-house-door"></i> Dirección</th>
        <th><i class="bi bi-envelope"></i> Email</th>
        <th><i class="bi bi-telephone"></i> Teléfono</th>
        <th><i class="bi bi-calendar"></i> Fecha de Registro</th>
        <th><i class="bi bi-gear"></i> Acciones</th>
    </tr>
</thead>
<style>
    th i {
    margin-right: 8px;
    color: #ffc107; /* Color de los íconos */
    transition: transform 0.3s ease, color 0.3s ease;
}

th i:hover {
    transform: scale(1.2); /* Efecto de aumento de tamaño al pasar el ratón */
    color: #17a2b8; /* Cambia el color cuando se pasa el ratón */
}

</style>
                <tbody>
                    <!-- Los datos de los clientes se cargarán aquí -->
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'obtener_clientes.php', true);

            xhr.onload = function () {
                if (xhr.status >= 200 && xhr.status < 300) {
                    try {
                        var clientes = JSON.parse(xhr.responseText);

                        var tbody = document.querySelector('#tabla-clientes tbody');
                        tbody.innerHTML = '';

                        if (clientes.length === 0) {
                            tbody.innerHTML = '<tr><td colspan="7">No hay clientes registrados.</td></tr>';
                        } else {
                            clientes.forEach(function (cliente) {
                                var fila = document.createElement('tr');
                                fila.innerHTML = `
                                    <td>${cliente.id_cliente}</td>
                                    <td>${cliente.nombre}</td>
                                    <td>${cliente.direccion}</td>
                                    <td>${cliente.email}</td>
                                    <td>${cliente.telefono}</td>
                                    <td>${cliente.fecha_registro}</td>
                                    <td>
                                        <button class="btn-delete" onclick="eliminarCliente(${cliente.id_cliente})">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </td>
                                `;
                                tbody.appendChild(fila);
                            });
                        }
                    } catch (e) {
                        console.error('Error al procesar los datos:', e);
                    }
                } else {
                    console.error('Error en la solicitud. Estado:', xhr.status);
                }
            };

            xhr.onerror = function () {
                console.error('Hubo un error al realizar la solicitud.');
            };

            xhr.send();
        });

        function eliminarCliente(id) {
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No podrás revertir esto",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo!'
            }).then((result) => {
                if (result.isConfirmed) {
                    var xhr = new XMLHttpRequest();
                    xhr.open('POST', 'eliminar_cliente.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function () {
                        if (xhr.status === 200) {
                            Swal.fire(
                                'Eliminado!',
                                'El cliente ha sido eliminado con éxito.',
                                'success'
                            ).then(() => {
                                location.reload();
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Hubo un error al eliminar el cliente.',
                                'error'
                            );
                        }
                    };
                    xhr.onerror = function () {
                        Swal.fire(
                            'Error!',
                            'Hubo un error al realizar la solicitud.',
                            'error'
                        );
                    };
                    xhr.send('id_cliente=' + id);
                }
            });
        }
    </script>

    <!-- Enlace a Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <!-- Enlace a Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.min.js"></script>
</body>

</html>


