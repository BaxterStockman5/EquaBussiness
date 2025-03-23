<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | EquaBusiness</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="admin.css"> <!-- Archivo CSS personalizado -->
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>

    <!-- Sidebar -->
    <div class="d-flex" id="wrapper">
        <div class="bg-dark border-right" id="sidebar">
            <div class="sidebar-heading text-center text-white py-3">
                <h4>EquaBusiness</h4>
            </div>
            <div class="list-group list-group-flush">
                <a href="#" class="list-group-item list-group-item-action text-white bg-dark active" onclick="cargarSeccion('inicio')">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="#" class="list-group-item list-group-item-action text-white bg-dark" onclick="cargarSeccion('productos')">
                    <i class="fas fa-box"></i> Productos
                </a>
                <a href="#" class="list-group-item list-group-item-action text-white bg-dark" onclick="cargarSeccion('reservas')">
                    <i class="fas fa-calendar-check"></i> Reservas
                </a>
                <a href="#" class="list-group-item list-group-item-action text-white bg-dark" onclick="cargarSeccion('usuarios')">
                    <i class="fas fa-users"></i> Usuarios
                </a>
                <a href="#" class="list-group-item list-group-item-action text-white bg-dark" onclick="cargarSeccion('historial')">
                    <i class="fas fa-history"></i> Historial de Reservas
                </a>
            </div>
        </div>

        <!-- Contenido principal -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom">
                <button class="btn btn-light" id="menu-toggle">☰</button>
                <span class="text-white ms-3">Panel de Administración</span>
            </nav>

            <!-- Contenedor de contenido dinámico -->
            <div class="container-fluid mt-4" id="contenido">
                
                <!-- Resumen General -->
                <div class="container">
                    <h2 class="mb-4">Resumen General</h2>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white text-center p-3">
                                <h4>Productos</h4>
                                <p id="totalProductos">0</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white text-center p-3">
                                <h4>Reservas</h4>
                                <p id="totalReservas">0</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white text-center p-3">
                                <h4>Usuarios</h4>
                                <p id="totalUsuarios">0</p>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white text-center p-3">
                                <h4>Historial</h4>
                                <p id="totalHistorial">0</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gestión de Productos -->
                <div class="container mt-4">
                    <h2>Gestión de Productos</h2>
                    <button class="btn btn-primary mb-3" onclick="mostrarModalAgregar()">Agregar Producto</button>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Categoría</th>
                                <th>Precio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody id="tabla-productos">
                            <!-- Aquí se cargarán los productos -->
                        </tbody>
                    </table>
                </div>

            </div> <!-- Fin Contenido -->
        </div> <!-- Fin Page Content -->
    </div> <!-- Fin Wrapper -->
<style>
    body {
    font-family: 'Arial', sans-serif;
}

#wrapper {
    display: flex;
}

#sidebar {
    width: 250px;
    height: 100vh;
    position: fixed;
    transition: all 0.3s;
}

#sidebar .list-group-item {
    border: none;
    transition: background 0.3s;
}

#sidebar .list-group-item:hover {
    background: #007bff;
}

#page-content-wrapper {
    flex-grow: 1;
    margin-left: 250px;
    transition: all 0.3s;
    padding: 20px;
}

#menu-toggle {
    font-size: 20px;
    cursor: pointer;
}

</style>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    cargarSeccion("inicio");
    cargarDatosDashboard();
});

// Cargar secciones dinámicamente
function cargarSeccion(seccion) {
    let contenido = document.getElementById("contenido");
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "secciones/" + seccion + ".php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            contenido.innerHTML = xhr.responseText;
        }
    };
    xhr.send();
}

// Cargar datos del Dashboard
function cargarDatosDashboard() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "dashboard_data.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            let data = JSON.parse(xhr.responseText);
            document.getElementById("totalProductos").innerText = data.productos;
            document.getElementById("totalReservas").innerText = data.reservas;
            document.getElementById("totalUsuarios").innerText = data.usuarios;
            document.getElementById("totalHistorial").innerText = data.historial;
        }
    };
    xhr.send();
}

// Alternar el menú lateral
document.getElementById("menu-toggle").addEventListener("click", function () {
    let sidebar = document.getElementById("sidebar");
    let content = document.getElementById("page-content-wrapper");
    if (sidebar.style.marginLeft === "-250px") {
        sidebar.style.marginLeft = "0";
        content.style.marginLeft = "250px";
    } else {
        sidebar.style.marginLeft = "-250px";
        content.style.marginLeft = "0";
    }
});

</script>
    <script src="admin.js"></script> <!-- Archivo JS para la lógica -->
</body>
</html>

