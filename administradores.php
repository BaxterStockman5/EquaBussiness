

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard | EquaBusiness</title>
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="./BOOTSTRAP/css/bootstrap.min.css">
  <link rel="stylesheet" href="./BOOTSTRAP/js/bootstrap.js">
  <link rel="stylesheet" href="./BOOTSTRAP/js/bootstrap.bundle.js">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
  <!-- CSS de Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<?php
session_start();
if (!isset($_SESSION["admin_id"])) {
    header("Location: login.php");
    exit();
}
$nombre = $_SESSION["admin_nombre"]; // Nombre del administrador

if (isset($_SESSION['admin_nombre'])) {
    echo "Bienvenido, " . $_SESSION['admin_nombre'];
} else {
    echo "No has iniciado sesión.";
}
?>
<!-- JS de Bootstrap y Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

  <style>
    /* Estilos generales de la tabla */
.administradores-table {
    width: 100%;
    max-width: 1200px;
    margin: 20px auto;
    border-radius: 10px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
}

/* Encabezado de la tabla */
.administradores-header {
    display: flex;
    background: linear-gradient(to right, #007bff, #0056b3);
    color: white;
    font-weight: bold;
    text-transform: uppercase;
    padding: 12px 0;
    border-bottom: 3px solid #004494;
}

/* Columnas del encabezado */
.administradores-col {
    flex: 1;
    text-align: center;
    padding: 10px;
    font-size: 14px;
}

/* Efecto de hover en los encabezados */
.administradores-col:hover {
    background: rgba(255, 255, 255, 0.2);
    transition: background 0.3s ease-in-out;
}

/* Filas de administradores */
.administradores-row {
    display: flex;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #ddd;
    transition: background 0.3s ease-in-out;
}

/* Alternar color en filas */
.administradores-row:nth-child(even) {
    background: #f9f9f9;
}

.administradores-row:hover {
    background: #e0eaff;
}

/* Columnas de las filas */
.administradores-row .administradores-col {
    padding: 10px;
}

/* Estilos para las imágenes */
.administradores-col img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    object-fit: cover;
    transition: transform 0.3s ease-in-out;
}

.administradores-col img:hover {
    transform: scale(1.1);
}

/* Botones de acción */
.administradores-actions {
    display: flex;
    justify-content: center;
    gap: 5px;
}

.administradores-actions button {
    padding: 5px 10px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: transform 0.2s ease-in-out;
}

.administradores-actions button:hover {
    transform: scale(1.1);
}

/* Colores de los botones */
.btn-editar {
  
    background: #28a745;
    color: white;
}

.btn-eliminar {
    background: #dc3545;
    color: white;
}

    /* Estilo para el interruptor */
.switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input {
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  transition: .4s;
  border-radius: 34px;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  border-radius: 50%;
  left: 4px;
  bottom: 4px;
  background-color: white;
  transition: .4s;
}

input:checked + .slider {
  background-color:rgb(7, 75, 9);
  /* disminuir el tamaño del check  es muy grande*/ 

}


input:checked + .slider:before {
  transform: translateX(26px);
}


    /* Estilos generales */
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
      padding: 0;
    }

    /* Sidebar */
    /* SIDEBAR ESTILIZADO */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: 250px;
    height: 100vh;
    background: linear-gradient(to bottom, #007bff, #0056b3);
    padding-top: 20px;
    overflow-y: auto;
    transition: width 0.4s ease-in-out;
    box-shadow: 3px 0 10px rgba(0, 0, 0, 0.2);
    z-index: 1000;
}

/* LOGO / TÍTULO */
.sidebar h2 {
    color: white;
    text-align: center;
    font-size: 1.8rem;
    margin-bottom: 30px;
    transition: opacity 0.3s ease-in-out;
}

/* LINKS DEL SIDEBAR */
.sidebar a {
    display: flex;
    align-items: center;
    color: white;
    text-decoration: none;
    padding: 12px 20px;
    font-size: 16px;
    transition: background 0.3s, transform 0.2s;
}

/* ÍCONOS */
.sidebar a i {
    margin-right: 10px;
    font-size: 18px;
    transition: transform 0.3s;
}

/* EFECTOS HOVER */
.sidebar a:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateX(5px);
}

.sidebar a:hover i {
    transform: rotate(360deg);
}

/* LINK ACTIVO */
.sidebar a.active {
    background: rgba(255, 255, 255, 0.4);
    font-weight: bold;
    border-left: 4px solid #ffcc00;
}

/* BOTÓN PARA OCULTAR SIDEBAR */
.sidebar-toggle {
    position: absolute;
    top: 15px;
    right: -35px;
    background: #0056b3;
    color: white;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    font-size: 18px;
    border-radius: 0 5px 5px 0;
    transition: all 0.3s ease-in-out;
}

.sidebar-toggle:hover {
    background: #ffcc00;
    color: #0056b3;
}

/* SIDEBAR COLAPSADO */
.sidebar.collapsed {
    width: 70px;
}

.sidebar.collapsed h2,
.sidebar.collapsed a span {
    opacity: 0;
    pointer-events: none;
}

.sidebar.collapsed a i {
    margin: 0 auto;
    font-size: 20px;
}

.sidebar.collapsed a {
    justify-content: center;
    padding: 15px;
}
    /* Contenido principal */
    .main-content {
      margin-left: 250px;
      padding: 20px;
      transition: all 0.3s;
    }
    .navbar-custom {
      background-color: #343a40;
      color: #fff;
    }
    .navbar-custom .navbar-brand {
      font-weight: bold;
      font-size: 1.5rem;
    }

    /* Sección Administradores (tabla con divs) */
    .administradores-header,
    .administradores-row {
      display: flex;
      border-bottom: 1px solid #ddd;
      padding: 10px 0;
      align-items: center;
      transition: background 0.3s;
    }
    .administradores-header {
      background-color: #343a40;
      color: #fff;
      font-weight: bold;
    }
    .administradores-row:nth-child(even) {
      background-color: #f9f9f9;
    }
    .administradores-row:hover {
      background-color: #e9ecef;
    }
    .administradores-col {
      flex: 1;
      text-align: center;
    }
    /* Ajustes para columnas específicas si se desea ancho fijo */
    .col-id { flex: 0.5; }
    .col-acciones { flex: 1.5; }

    /* Estilos para el modal */
    .modal-dialog {
      max-width: 450px;
      max-height: 300px;
    }
    /* check */
    
  </style>
</head>
<body>



  <!-- Sidebar -->
  <!-- SIDEBAR CON BOTÓN DE OCULTAR -->
<div class="sidebar animate__animated animate__fadeInLeft" id="sidebar">
    <button class="sidebar-toggle" onclick="toggleSidebar()">
        <i class="fas fa-bars"></i>
    </button>
    <h2>EquaBusiness</h2>
    <li><a href="paginaproducto.php"><i class="fas fa-home"></i> Inicio</a></li>
    <!-- <a href="#"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a> -->
    <a href="./paneladmin.php"><i class="fas fa-box"></i> <span>Gestionar Productos</span></a>
    <a href="./pedidos.php"><i class="fas fa-calendar-check"></i> <span>Reservas</span></a>
    <a href="#" class="active" onclick="cargarAdministradores()">
        <i class="fas fa-users"></i> <span>Administradores</span>
    </a>
    <a href="estadistica_pedidos.php"><i class="fas fa-history"></i> <span>estadisticas de pedidos</span></a>
 
</div>
<!-- <a href="logout.php" class="btn btn-danger">Cerrar sesión</a>dmd -->


  <!-- Contenido principal -->
  <div class="main-content">
  <nav class="navbar navbar-expand-lg navbar-dark navbar-custom border-bottom mb-4">
  <div class="container-fluid">
    <!-- Logo y título -->
    <a class="navbar-brand" href="#" style="font-size: 1.5rem; font-weight: bold; transition: transform 0.3s ease;">
      Panel de Administración
    </a>
    
    <!-- Toggle Button para dispositivos móviles -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent" aria-controls="navbarContent" aria-expanded="false" aria-label="Toggle navigation" style="transition: all 0.3s;">
      <span class="navbar-toggler-icon"></span>
    </button>
    
    <!-- Saludo con nombre del administrador -->
    <h3 class="ms-3 text-white" style="transition: color 0.3s ease;">Bienvenid@, <?php echo htmlspecialchars($nombre); ?> 👋</h3>

    <!-- Menú desplegable -->
    <div class="collapse navbar-collapse" id="navbarContent">
      <!-- <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" href="#" style="transition: color 0.3s ease;">Inicio</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" style="transition: color 0.3s ease;">Administradores</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" style="transition: color 0.3s ease;">Reservas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#" style="transition: color 0.3s ease;">Historial</a>
        </li> -->
      </ul>
    </div>

    <!-- Botón de cerrar sesión con animación de hover -->
    <button type="button" class="btn btn-danger d-flex align-items-center" style="transition: background-color 0.3s ease;">
      <i class="fas fa-sign-out-alt me-2"></i>
      <a href="logout.php" class="text-white text-decoration-none" style="transition: color 0.3s ease;">Cerrar sesión</a>
    </button>
  </div>
</nav>

<style>
  /* Estilo para el navbar */
  .navbar-custom {
    background-color: #343a40;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);
    transition: background-color 0.3s ease-in-out;
  }

  .navbar-custom:hover {
    background-color: #23272b;
  }

  .navbar-toggler-icon {
    background-color: #ffffff;
    transition: transform 0.3s ease;
  }

  /* Transiciones suaves para enlaces del navbar */
  .navbar-nav .nav-link {
    color: #fff;
    font-size: 1rem;
    padding: 8px 15px;
    transition: color 0.3s ease, transform 0.3s ease;
  }

  .navbar-nav .nav-link:hover {
    color: #ffcc00;
    transform: translateX(5px);
  }

  /* Efecto de hover en el botón de cerrar sesión */
  .btn-danger {
    padding: 8px 15px;
    border-radius: 25px;
    transition: background-color 0.3s ease, transform 0.3s ease;
  }

  .btn-danger:hover {
    background-color: #dc3545;
    transform: scale(1.05);
  }

  /* Efecto en la marca del navbar */
  .navbar-brand:hover {
    transform: scale(1.1);
    color: #ffcc00 !important;
  }

  /* Efecto en el saludo */
  .navbar h3 {
    font-size: 1.2rem;
    color: #fff;
    opacity: 0.9;
  }

  .navbar h3:hover {
    color: #ffcc00;
    opacity: 1;
  }

  /* Alineación de los elementos */
  .navbar-nav {
    display: flex;
    align-items: center;
    justify-content: flex-end;
  }

  /* Estilo de la versión móvil */
  @media (max-width: 768px) {
    .navbar-toggler {
      border: none;
    }
  }
</style>


    <!-- Botón para abrir el modal -->
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdministrador">
<i class="fas fa-user-plus"></i> Agregar Administrador
</button>

<!-- Modal -->
<div class="modal fade" id="modalAdministrador" tabindex="-1" aria-labelledby="modalAdministradorLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalAdministradorLabel">Agregar Administrador</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <!-- Formulario para agregar administrador -->
        <form id="formAdministrador" onsubmit="return insertarAdministrador();" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" required>
          </div>
          <div class="mb-3">
            <label for="apellido" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellido" required>
          </div>
          <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" required>
          </div>
          <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" required>
          </div>
          <div class="mb-3">
            <label for="foto" class="form-label">Foto</label>
            <input type="file" class="form-control" id="foto">
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" required>
          </div>
          <button type="submit" class="btn btn-primary">Agregar Administrador</button>
        </form>
        <p id="mensaje"></p>
      </div>
    </div>
  </div>
</div>

 <!-- #region -->
    <!-- Tarjeta que muestra el número de administradores registrados -->
    <div class="card mb-4" style="transition: transform 0.3s ease, box-shadow 0.3s ease;">
  <div class="card-body" style="transition: all 0.3s ease; background: linear-gradient(145deg, #6c757d, #495057); border-radius: 15px;">
    <h5 class="card-title text-white" style="font-size: 1.25rem; font-weight: bold; transition: color 0.3s ease;">
      Total de Administradores
    </h5>
    <p class="card-text" id="totalAdministradores" style="font-size: 1.1rem; color: #ffc107; font-weight: bold; animation: fadeIn 1.5s ease-in-out;">
      Cargando...
    </p>
  </div>
</div>

<style>
  /* Estilo general de la tarjeta */
  .card {
    border: none;
    border-radius: 15px;
    box-shadow: 0px 8px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  /* Efecto al pasar el mouse por encima de la tarjeta */
  .card:hover {
    transform: translateY(-5px);
    box-shadow: 0px 12px 25px rgba(0, 0, 0, 0.15);
  }

  /* Efecto de la caja del cuerpo de la tarjeta */
  .card-body {
    background: linear-gradient(145deg, #6c757d, #495057);
    border-radius: 15px;
    padding: 20px;
    color: #fff;
    transition: all 0.3s ease;
  }

  /* Animación del texto al aparecer */
  @keyframes fadeIn {
    0% {
      opacity: 0;
      transform: translateY(10px);
    }
    100% {
      opacity: 1;
      transform: translateY(0);
    }
  }

  /* Efecto de hover sobre el título */
  .card-title:hover {
    color: #ffcc00;
    transform: scale(1.05);
    transition: color 0.3s ease, transform 0.3s ease;
  }

  /* Estilo de texto "Cargando..." */
  .card-text {
    font-size: 1.2rem;
    font-weight: 600;
    color: #ffc107;
    transition: color 0.3s ease;
  }

  /* Efecto en el texto "Cargando..." cuando la tarjeta está activa */
  .card-text:hover {
    color: #ffbb33;
    transform: scale(1.05);
    transition: color 0.3s ease, transform 0.3s ease;
  }

  /* Estilos en dispositivos móviles */
  @media (max-width: 768px) {
    .card-body {
      padding: 15px;
    }
    .card-title {
      font-size: 1.1rem;
    }
    .card-text {
      font-size: 1rem;
    }
  }
</style>



    <!-- Sección de Administradores -->
    <div class="container">
  <h2 class="mb-4 text-center" style="font-size: 1.75rem; font-weight: bold; color: #343a40; transition: color 0.3s ease;">
    Administradores Registrados
  </h2>
  <!-- Encabezado de "tabla" -->
  <div class="administradores-table">
    <div class="administradores-header" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 10px; padding: 10px; background: #f8f9fa; border-radius: 10px; transition: all 0.3s ease; font-weight: 600; color: #495057; font-size: 0.9rem;">
      <div class="administradores-col">Nombre</div>
      <div class="administradores-col">Apellido</div>
      <div class="administradores-col">Teléfono</div>
      <div class="administradores-col">Dirección</div>
      <div class="administradores-col">Email</div>
      <div class="administradores-col">Foto</div>
      <div class="administradores-col">Acciones</div>
    </div>
  </div>
  <!-- Contenedor de filas -->
  <div class="container">
    <div id="administradores-list">
      <!-- Aquí se cargarán los administradores dinámicamente -->
    </div>
  </div>
</div>
<!--  -->

<style>
  /* Estilos generales */
  .administradores-table {
    margin-top: 20px;
    box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.1);
  }

  .administradores-header {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 15px;
    padding: 12px;
    background: linear-gradient(145deg, #e0e0e0, #f5f5f5);
    border-radius: 12px;
    font-size: 1rem;
    font-weight: bold;
    color: #495057;
    transition: background 0.4s ease, transform 0.3s ease;
  }

  /* Efecto de hover para los encabezados */
  .administradores-header:hover {
    background: linear-gradient(145deg, #ffd700, #ff6347);
    transform: scale(1.05);
  }

  .administradores-col {
    padding: 12px;
    text-align: center;
    background: #fff;
    border-radius: 8px;
    font-size: 0.95rem;
    font-weight: 500;
    color: #495057;
    transition: all 0.3s ease, transform 0.3s ease;
    cursor: pointer;
  }

  /* Estilo cuando el ratón pasa por encima de cada columna */
  .administradores-col:hover {
    background-color: #ffeb3b;
    transform: scale(1.05);
  }

  /* Estilo para las filas de los administradores */
  .administradores-row {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 10px;
    padding: 15px;
    margin-bottom: 15px;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  /* Efecto de hover para las filas */
  .administradores-row:hover {
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.15);
    transform: scale(1.02);
  }

  /* Estilo para las imágenes de los administradores */
  .administradores-col img {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    transition: transform 0.3s ease;
  }

  .administradores-col img:hover {
    transform: scale(1.1);
  }

  /* Botones de acción con efectos de hover */
  .acciones-btn {
    display: flex;
    justify-content: center;
    gap: 10px;
  }

  .acciones-btn button {
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 8px 15px;
    cursor: pointer;
    font-size: 0.9rem;
    transition: background-color 0.3s ease, transform 0.3s ease;
  }

  .acciones-btn button:hover {
    background-color: #0056b3;
    transform: scale(1.1);
  }

  /* Animación de aparición para las filas */
  @keyframes fadeIn {
    0% {
      opacity: 0;
      transform: translateY(20px);
    }
    100% {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .administradores-row {
    animation: fadeIn 1s ease-in-out;
  }

  /* Responsividad */
  @media (max-width: 768px) {
    .administradores-header {
      grid-template-columns: repeat(3, 1fr);
    }

    .administradores-col {
      font-size: 0.85rem;
    }

    .administradores-row {
      grid-template-columns: repeat(3, 1fr);
    }
  }
</style>

<style>
  /* Estilos generales */
  .administradores-table {
    margin-top: 20px;
  }

  .administradores-header {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 12px;
    padding: 12px;
    background: #f4f4f4;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: bold;
    color: #495057;
    transition: background-color 0.3s ease, transform 0.3s ease;
  }

  .administradores-header:hover {
    background-color: #e9ecef;
    transform: scale(1.02);
  }

  .administradores-col {
    padding: 8px;
    text-align: center;
    background: #ffffff;
    border: 1px solid #dee2e6;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: background-color 0.3s ease, transform 0.2s ease;
  }

  /* Estilo de las celdas cuando el mouse pasa por encima */
  .administradores-col:hover {
    background-color: #f8f9fa;
    transform: scale(1.03);
  }

  /* Estilos para las filas de los administradores */
  .administradores-row {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 10px;
    padding: 10px;
    margin-bottom: 10px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.05);
    transition: box-shadow 0.3s ease, transform 0.3s ease;
  }

  .administradores-row:hover {
    box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.15);
    transform: scale(1.02);
  }

  /* Estilo de la imagen de los administradores */
  .administradores-col img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    transition: transform 0.3s ease;
  }

  .administradores-col img:hover {
    transform: scale(1.1);
  }

  /* Botones de acción */
  .acciones-btn {
    display: flex;
    justify-content: space-evenly;
    gap: 8px;
  }

  .acciones-btn button {
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    padding: 5px 10px;
    cursor: pointer;
    transition: background-color 0.3s ease, transform 0.3s ease;
  }

  .acciones-btn button:hover {
    background-color: #0056b3;
    transform: scale(1.05);
  }

  /* Animación al aparecer de las filas */
  @keyframes fadeIn {
    0% {
      opacity: 0;
      transform: translateY(10px);
    }
    100% {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .administradores-row {
    animation: fadeIn 1s ease-in-out;
  }

  /* Responsividad en dispositivos móviles */
  @media (max-width: 768px) {
    .administradores-header {
      grid-template-columns: repeat(3, 1fr);
    }

    .administradores-col {
      font-size: 0.8rem;
    }

    .administradores-row {
      grid-template-columns: repeat(3, 1fr);
    }
  }
</style>

  </div>

  <!-- Modal para ver detalles del administrador -->
  <div class="modal fade" id="modalVerDetallesAdmin" tabindex="-1" aria-labelledby="modalVerDetallesAdminLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header bg-dark text-white">
          <h5 class="modal-title" id="modalVerDetallesAdminLabel">Detalles del Administrador</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="detallesAdministrador">
          <!-- Aquí se cargarán los detalles del administrador -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    function cambiarEstado(id, estado) {
    var xhr = new XMLHttpRequest();
    xhr.open("GET", `cambiarestadoadmin.php?id_admin=${id}&estado=${estado}`, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            try {
                var respuesta = JSON.parse(xhr.responseText);
                if (respuesta.status === "success") {
                    alert("Estado actualizado con éxito");
                    cargarAdministradores(); // Recargar la lista
                } else {
                    console.error("Error:", respuesta.message);
                }
            } catch (e) {
                console.error("Error en la respuesta del servidor", e);
            }
        }
    };
    xhr.send();
}


    // Función para cargar administradores
    function cargarAdministradores() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "obteneradministradores.php", true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4) {
      if (xhr.status === 200) {
        try {
          var administradores = JSON.parse(xhr.responseText.trim());
          var container = document.getElementById("administradores-list");
          container.innerHTML = ""; // Limpiar contenedor

          administradores.forEach(function(administrador) {
            var row = document.createElement("div");
            row.classList.add("administradores-row");
            row.innerHTML = `
              <div class="administradores-col">${administrador.nombre}</div>
              <div class="administradores-col">${administrador.apellido}</div>
              <div class="administradores-col">${administrador.telefono}</div>
              <div class="administradores-col">${administrador.direccion}</div>
              <div class="administradores-col">${administrador.email}</div>
              <div class="administradores-col"><img src="${administrador.foto}" alt="Foto" width="50"></div>
              <div class="administradores-col">
<button class="btn btn-info btn-sm" onclick="verAdministrador(${administrador.id})">
    <i class="fas fa-eye"></i>
</button>
                <button class="btn btn-danger btn-sm" onclick="eliminarAdministrador(${administrador.id})"><i class="fa-regular fa-trash-can"></i></button>
                <!-- Interruptor para activar/desactivar sesión -->
                <label class="switch">
                  <input type="checkbox" ${administrador.sessionStatus === 'active' ? 'checked' : ''} onchange="toggleSession(${administrador.id}, this)"> activar
                  <span class="slider round"></span>
                </label>
              </div>
            `;
            container.appendChild(row);
          });
        } catch (e) {
          console.error("Error al parsear los datos:", e);
        }
      } else {
        console.error("Error al cargar administradores. Código:", xhr.status);
      }
    }
  };
  xhr.send();
}

    // Función para ver los detalles del administrador
    function verAdministrador(id) {
      var xhr = new XMLHttpRequest();
      xhr.open("GET", "veradministrador.php?id=" + id, true);
      xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
          if (xhr.status === 200) {
            try {
              var administrador = JSON.parse(xhr.responseText.trim());
              var detallesDiv = document.getElementById("detallesAdministrador");

              detallesDiv.innerHTML = `
                <p><strong>ID:</strong> ${administrador.id}</p>
                <p><strong>Nombre:</strong> ${administrador.nombre}</p>
                <p><strong>Apellido:</strong> ${administrador.apellido}</p>
                <p><strong>Teléfono:</strong> ${administrador.telefono}</p>
                <p><strong>Dirección:</strong> ${administrador.direccion}</p>
                <p><strong>Email:</strong> ${administrador.email}</p>
                <p><strong>Foto:</strong><br><img src="${administrador.foto}" alt="Foto" width="100"></p>
              `;

              var modal = new bootstrap.Modal(document.getElementById('modalVerDetallesAdmin'));
              modal.show();
            } catch (e) {
              console.error("Error al parsear los detalles:", e);
            }
          } else {
            console.error("Error al cargar los detalles del administrador. Código:", xhr.status);
          }
        }
      };
      xhr.send();
    }

    // Función para eliminar un administrador
    function eliminarAdministrador(id) {
      Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esta acción!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar'
      }).then((result) => {
        if (result.isConfirmed) {
          var xhr = new XMLHttpRequest();
          xhr.open("POST", "eliminaradmin.php", true);
          xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
          xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
              let respuesta = xhr.responseText.trim();
              if (respuesta === "success") {
                Swal.fire({
                  icon: "success",
                  title: "¡Éxito!",
                  text: "Administrador eliminado correctamente."
                }).then(() => {
                  cargarAdministradores(); // Recargar la lista de administradores
                });
              } else {
                Swal.fire({
                  icon: "error",
                  title: "Error",
                  text: "No se pudo eliminar al administrador. Intenta de nuevo."
                });
              }
            }
          };
          xhr.send("id=" + id);
        }
      });
    }

    function actualizarTotalAdministradores() {
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "obtenertotaladministradores.php", true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Asegúrate de que el id esté correcto en ambas partes (HTML y JS)
      document.getElementById("totalAdministradores").textContent = xhr.responseText.trim();
    }
  };
  xhr.send();
}

// Llama a la función al cargar la página o cuando sea necesario
actualizarTotalAdministradores();


    // Cargar administradores al cargar la página
    document.addEventListener("DOMContentLoaded", cargarAdministradores);
  </script>
  <script src="./administradores.js"></script>
</body>
</html>
