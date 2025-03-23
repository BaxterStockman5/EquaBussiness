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
    <title>Panel de Administración</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="./paneladmin.css">
    <!-- FontAwesome CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha384-Ax00G3v8lrAfU10EOkzMf2l1ezlZTcN2Fp+h7n4MkMVoWWL3J5aWDO2hdF7BkNIE" crossorigin="anonymous">
    <style>
        .sidebar {
    position: fixed;
    background-color: #007bff;
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
    background: #0056b3;
    transform: translateX(5px);
}

.sidebar a:hover i {
    transform: rotate(360deg);
}

/* LINK ACTIVO */
.sidebar a.active {
    background:#007bff;
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
    color: white;
}

.sidebar.collapsed a {
    justify-content: center;
    padding: 15px;
}
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
            width: 250px;
            height: 100vh;
            background:#007bff;
            color: white;
            padding: 15px;
            display: flex;
            flex-direction: column;
            transition: width 0.3s ease-in-out;
        }
        .sidebar i {
            margin-right: 10px;
            color:#dee2e6;
        }
        .sidebar a {
            color: white;
            text-decoration: none;
            padding: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateX(10px);
        }
        .sidebar h2 {
            margin-bottom: 20px;
            font-size: 1.5rem;
        }

        /* Estilos para el botón de toggle */
        #toggleSidebar {
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            padding: 10px;
            font-size: 1.5rem;
            position: absolute;
            left: 260px;
            top: 20px;
            transition: left 0.3s ease-in-out;
        }

        /* Sidebar minimizado */
        .sidebar.minimized {
            width: 60px;
        }
        .sidebar.minimized h2 {
            display: none;
        }
        .sidebar.minimized .text {
            display: none;
        }
        #toggleSidebar.minimized {
            left: 70px;
        }

        /* Estilos del contenido principal */
        .content {
            flex-grow: 1;
            padding: 20px;
            overflow: auto;
        }
        .content header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }
        .content header h3 {
            margin: 0;
            font-size: 1.5rem;
            color: #007bff;
        }
        .content header .btn {
            margin-left: 10px;
        }

        /* Estilos de la tabla */
        .table-container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .table .row.header {
            font-weight: bold;
            background-color:rgb(50, 125, 206);
            color: white;
            border-bottom: 2px solid #dee2e6;
            transition: background-color 0.3s;
            transform: translateY(0);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            z-index: 1;
            transition: box-shadow 0.3s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            transform: translateY(0);
            
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
        .table .row:hover {
            /* background-color: #f1f1f1; */

            /* background-color: #f1f1f1; */
            cursor: pointer;
            transition: background-color 0.3s;
            transform: translateY(-2px);
            box-shadow: 0 2px 4px rgba(185, 47, 47, 0.1);
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            z-index: 1;
            transition: box-shadow 0.3s;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            /* z-index: 1; */
            transform: translateY(0);

        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h2 id="sidebarTitle">EquaBusiness</h2>
        <a href="./paginaproducto.php"><i class="fas fa-home"></i> <span class="text">Inicio</span></a>
        <a href="#"><i class="fas fa-tachometer-alt"></i> <span class="text">Dashboard</span></a>
        <a href="#"><i class="fas fa-box"></i> <span class="text">Gestionar Productos</span></a>
        <a href="./pedidos.php"><i class="fas fa-calendar-check"></i> <span class="text">pedidos</span></a>
        <a href="./administradores.php"><i class="fas fa-users"></i> <span class="text">Usuarios</span></a>
        <a href="#"><i class="fas fa-history"></i> <span class="text">Historial</span></a>
    </div>

    <!-- Botón de Toggle -->
    <!-- <button id="toggleSidebar"> -->
        <i class="fas fa-bars"></i>
    </button>

    <!-- Content Area -->
    <div class="content">
        <!-- Header -->
        <header class="d-flex flex-column flex-sm-row justify-content-between align-items-center p-3 bg-light shadow">
            <h3 class="text-primary mb-3 mb-sm-0">Panel de Administración</h3>
            <div class="d-flex flex-column flex-sm-row align-items-center">
                <button class="btn btn-dark btn-sm mb-2 mb-sm-0 me-2" onclick="toggleDarkMode()">🌙</button>
                <button class="btn btn-danger btn-sm">Cerrar Sesión</button>
            </div>
        </header>

        <!-- Botón para abrir el modal -->
        <div class="d-flex justify-content-end mb-3">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAgregarProducto" onclick="limpiarFormulario()">
                <i class="fas fa-plus"></i>
            </button>
        </div>

        <!-- Modal para registrar producto -->
        <div class="modal fade" id="modalAgregarProducto" tabindex="-1" aria-labelledby="modalAgregarProductoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalAgregarProductoLabel">Registrar Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-agregar-producto" method="post" enctype="multipart/form-data" class="p-3 border rounded shadow-lg bg-light">
                            <h3 class="text-center mb-3 text-info">Registrar Producto</h3>

                            <div class="mb-3">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control form-control-sm shadow-sm" id="nombre" required placeholder="Nombre del producto">
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control form-control-sm shadow-sm" name="descripcion" id="descripcion" required placeholder="Descripción detallada del producto"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" name="precio" class="form-control form-control-sm shadow-sm" id="precio" step="0.01" required placeholder="Precio del producto">
                            </div>

                            <div class="mb-3">
                                <label for="categoria" class="form-label">Categoría</label>
                                <select name="categoria" class="form-control form-control-sm shadow-sm" id="categoria" required>
                                    <option value="" disabled selected>Cargando categorías...</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="imagen" class="form-label">Imagen</label>
                                <input type="file" name="imagen" class="form-control form-control-sm shadow-sm" id="imagen" accept="image/*" required>
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-success btn-sm w-100 shadow-sm">Registrar Producto</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para editar producto -->
        <div class="modal fade" id="modalEditarProducto" tabindex="-1" aria-labelledby="modalEditarProductoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalEditarProductoLabel">Editar Producto</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="form-editar-producto" method="post" enctype="multipart/form-data" class="p-3 border rounded shadow-lg bg-light">
                            <h3 class="text-center mb-3 text-info">Editar Producto</h3>

                            <input type="hidden" id="editar-id-producto" name="id_producto">
                            <input type="hidden" id="imagen-actual" name="imagen_actual">

                            <div class="mb-3">
                                <label for="editar-nombre" class="form-label">Nombre</label>
                                <input type="text" name="nombre" class="form-control form-control-sm shadow-sm" id="editar-nombre" required placeholder="Nombre del producto">
                            </div>

                            <div class="mb-3">
                                <label for="editar-descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control form-control-sm shadow-sm" name="descripcion" id="editar-descripcion" required placeholder="Descripción detallada del producto"></textarea>
                            </div>

                            <div class="mb-3">
                                <label for="editar-precio" class="form-label">Precio</label>
                                <input type="number" name="precio" class="form-control form-control-sm shadow-sm" id="editar-precio" step="0.01" required placeholder="Precio del producto">
                            </div>

                            <div class="mb-3">
                                <label for="editar-categoria" class="form-label">Categoría</label>
                                <select name="categoria" class="form-control form-control-sm shadow-sm" id="editar-categoria" required>
                                    <option value="" disabled selected>Cargando categorías...</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="editar-imagen" class="form-label">Imagen</label>
                                <input type="file" name="imagen" class="form-control form-control-sm shadow-sm" id="editar-imagen" accept="image/*">
                            </div>

                            <div class="d-flex justify-content-center">
                                <button type="submit" class="btn btn-success btn-sm w-100 shadow-sm">Guardar Cambios</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal de detalles del producto -->
        <div class="modal fade animate__animated animate__fadeInDown" id="modalVerProducto" tabindex="-1" role="dialog" aria-labelledby="modalVerProductoLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalVerProductoLabel">Detalles del Producto</h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div id="producto-detalles">
                            <!-- Los detalles del producto se insertarán aquí -->
                            <div class="text-center">
                                <img src="imagenes/default.png" alt="Imagen del producto" class="img-fluid mb-3" id="producto-imagen">
                            </div>
                            <h5 id="producto-nombre"></h5>
                            <p id="producto-descripcion"></p>
                            <p><strong>Categoría:</strong> <span id="producto-categoria"></span></p>
                            <p><strong>Precio:</strong> <span id="producto-precio"></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Lista de productos -->
        <div class="container">
            <div class="table-container">
                <h3>Lista de Productos</h3>
                <div class="table">
                    <div class="row header">
                        <div class="col">Nombre</div>
                        <div class="col">Categoría</div>
                        <div class="col">Precio</div>
                        <div class="col">Disponible</div>
                        <div class="col">Imagen</div>
                        <div class="col">Acciones</div>
                    </div>
                    <div id="productosBody">
                        <!-- Los productos se agregarán aquí dinámicamente -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="insertarproducto.js"></script>
    <script src="./paneladmin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Función para cargar las categorías en los select
        function cargarCategorias() {
            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'obtener_categorias.php', true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const categorias = JSON.parse(xhr.responseText);
                    const selectCategoria = document.getElementById('categoria');
                    const selectEditarCategoria = document.getElementById('editar-categoria');

                    selectCategoria.innerHTML = '<option value="" disabled selected>Selecciona una categoría</option>';
                    selectEditarCategoria.innerHTML = '<option value="" disabled selected>Selecciona una categoría</option>';

                    categorias.forEach(categoria => {
                        const option = document.createElement('option');
                        option.value = categoria.id_categoria;
                        option.textContent = categoria.nombre;
                        selectCategoria.appendChild(option);

                        const optionEditar = document.createElement('option');
                        optionEditar.value = categoria.id_categoria;
                        optionEditar.textContent = categoria.nombre;
                        selectEditarCategoria.appendChild(optionEditar);
                    });
                } else {
                    console.error('Error al cargar las categorías. Código:', xhr.status);
                }
            };

            xhr.onerror = function() {
                console.error('Error de red al intentar cargar las categorías.');
            };

            xhr.send();
        }

        // Llamar a la función cargarCategorias cuando el DOM esté completamente cargado
        document.addEventListener('DOMContentLoaded', function() {
            cargarCategorias();
        });

        // Función para cargar los productos
        function cargarProductos() {
            let xhr = new XMLHttpRequest();
            xhr.open('GET', 'optenerproducto.php', true);

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const productos = JSON.parse(xhr.responseText);
                    const productosBody = document.getElementById('productosBody');
                    productosBody.innerHTML = '';

                    productos.forEach(producto => {
                        const fila = document.createElement('div');
                        fila.classList.add('row', 'producto-row');
                        fila.innerHTML = `
                            <div class="col">${producto.nombre}</div>
                            <div class="col">${producto.categoria}</div>
                            <div class="col">${producto.precio} XFA</div>
                            <div class="col">${producto.disponible}</div>
                            <div class="col"><img src="${producto.imagen}" alt="${producto.nombre}" class="img-fluid" width="50"></div>
                            <div class="col">
                                <button class="btn btn-info btn-sm" onclick="verProducto(${producto.id_producto})"><i class="fas fa-eye"></i></button>
                                <button class="btn btn-warning btn-sm" onclick="mostrarModalEditar(${producto.id_producto})"><i class="fas fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm" onclick="eliminarProducto(${producto.id_producto})"><i class="fas fa-trash"></i></button>
                            </div>
                        `;
                        productosBody.appendChild(fila);
                    });
                } else {
                    console.error('Error al cargar los productos. Código:', xhr.status);
                }
            };

            xhr.onerror = function() {
                console.error('Error de red al intentar cargar los productos.');
            };

            xhr.send();
        }
    </script>
</body>
</html>
