

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clientes Registrados</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js"></script>
  <style>

    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }
    .container {
      margin-left: 270px;
      padding-top: 40px;
      padding-right: 20px;
    
    }
.table-responsive {
    max-height: 400px; /* Ajusta la altura según lo necesario */
    overflow-y: auto;
}

    .table-container {

      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .table thead {
      background: linear-gradient(to right, #007bff, #0056b3);
      color: white;
      text-transform: uppercase;
      padding: 15px 0;
      border-bottom: 3px solid #004494;

    }
    thead {
       background: linear-gradient(to right, #007bff, #0056b3);
        text-align: center;
        align-items: center;
        border-bottom: 3px solid #004494;
        
    }

    .btn-editar {
      background: #28a745;
      color: white;
    }

    .btn-eliminar {
      background: #dc3545;
      color: white;
    }

    .btn-editar, .btn-eliminar {
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      cursor: pointer;
      transition: transform 0.2s;
    }

    .btn-editar:hover, .btn-eliminar:hover {
      transform: scale(1.1);
    }

    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      width: 250px;
      height: 100vh;
      background: linear-gradient(to bottom, #007bff, #0056b3);
      padding-top: 20px;
      overflow-y: auto;
      box-shadow: 3px 0 10px rgba(0, 0, 0, 0.2);
      z-index: 1000;
    
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
      font-size: 18px;
    }

    .sidebar a:hover {
      background: rgba(255, 255, 255, 0.2);
      transform: translateX(5px);
    }

    .sidebar a.active {
      background: rgba(255, 255, 255, 0.4);
      font-weight: bold;
      border-left: 4px solid #ffcc00;
    }
    tr{
        padding: 10px;
        border-bottom: 1px solid #ddd;
        text-align: left;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-all;
     
    }
  </style>
</head>
<body>
<!-- Sidebar -->
<div class="sidebar">
  <h2>EquaBusiness</h2>
  <a href="./paginaproducto.php"><i class="fas fa-tachometer-alt"></i> inicio</a>
  <a href="#"  class="active"><i class="fas fa-tachometer-alt"></i> clientes</a>
  <!-- <a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a> -->
  <a href="./paneladmin.php"><i class="fas fa-box"></i> Gestionar Productos</a>
  <a href="./pedidos.php"><i class="fas fa-calendar-check"></i> Reservas</a>
  <a href="./administradores.php"><i class="fas fa-users"></i> Administradores</a>
  <a href="./detalles_pedidos.php"><i class="fas fa-history"></i> Historial de Reservas</a>
</div>

<!-- Contenedor principal -->
<div class="container">
  <h2 class="text-center mb-4">Lista de Clientes</h2>
  
  <div class="table-container">
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="text-center">
          <tr>
            <th>ID</th>
            <th>Nombre</th>
            <!-- <th>Apellido</th> -->
            <th>Teléfono</th>
            <th>Email</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody id="clientes-list">
          <!-- Aquí se cargarán los clientes dinámicamente -->
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    cargarClientes();
});

function cargarClientes() {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", "obtener_clients.php", true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            let clientes = JSON.parse(xhr.responseText);
            mostrarClientes(clientes);
        }
    };
    xhr.send();
}

function mostrarClientes(clientes) {
    let contenedor = document.getElementById("clientes-list");
    contenedor.innerHTML = ""; 

    clientes.forEach(cliente => {
        let fila = document.createElement("tr");
        fila.innerHTML = `
            <td class="text-center">${cliente.id_cliente}</td>
            <td>${cliente.nombre}</td>
            
            <td class="text-center">${cliente.telefono}</td>
            <td>${cliente.email}</td>
            <td class="text-center">
                <button class="btn btn-sm btn-editar" onclick="editarCliente(${cliente.id_cliente})">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-sm btn-eliminar" onclick="eliminarCliente(${cliente.id_cliente})">
                    <i class="fas fa-eye"></i>
                </button>
            </td>
        `;
        contenedor.appendChild(fila);
    });
}
</script>
</body>
</html>
