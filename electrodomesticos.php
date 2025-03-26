<?php
// Conectar a la base de datos
require 'conexion.php';
$sql = "SELECT p.id_producto, p.nombre, p.descripcion, p.precio, p.imagen
FROM productos p
INNER JOIN categorias c ON p.id_categoria = c.id_categoria
WHERE c.nombre = 'electronica'";

$result = $conexion->query($sql);

$productos = [];

if ($result->num_rows > 0) {
    // Almacenar productos en el arreglo
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
} else {
    $productos = [];
}

// Convertir el arreglo de productos a formato JSON para usarlo en el frontend
$productos_json = json_encode($productos);
// 

// Cerrar la conexión
$conexion->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EquaBusiness - Inicio</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="styles.css"> -->
    <!-- FontAwesome for the cart icon -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap JS (con Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="./paginaproducto.css">
</head>
<body>
    <!-- Encabezado -->
    <header class=" text-white text-center py-3">
        <div class="container">
            <h1>EquaBusiness</h1>
            <p>Reserva los mejores productos de tu ciudad</p>
        </div>

    </header>

    <!-- Menú de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark shadow-sm" style="background: linear-gradient(135deg, #220357, #4B0082);">
    <div class="container">
        <!-- Logo animado -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <div class="escudo" style="animation: rotateLogo 3s linear infinite;">
                <img src="./ebisnes.jpg" alt="Logo" style="height: 50px; border-radius: 50%; box-shadow: 0px 0px 10px rgba(255, 255, 255, 0.5);">
            </div>
            <span class="ms-2" style="font-weight: bold; font-size: 1.3rem; color: white;">EquaBusiness</span>
        </a>
        <!-- Toggle button for mobile view -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Navbar links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link active link-hover" href="./paginaproducto.php">Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-hover" href="electrodomesticos.php">Electrónica</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-hover" href="moda.php">Moda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-hover" href="hogar.php">Hogar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link link-hover" href="./gmail.php">Contáctanos</a>
                </li>
                <!-- Carrito -->
                <li class="nav-item position-relative">
                    <a class="nav-link position-relative carrito-hover" href="#" id="carrito" data-bs-toggle="modal" data-bs-target="#modalCarrito">
                        <i class="fas fa-shopping-cart fa-lg"></i>
                        <span id="contador-carrito" class="badge bg-danger position-absolute top-0 start-100 translate-middle">0</span>
                    </a>
                </li>
                <li class="nav-item ms-3">
                    <a href="login.php" class="btn btn-outline-light btn-hover">Iniciar sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
/* Efectos de animación y mejoras */
@keyframes rotateLogo {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.link-hover {
    transition: color 0.3s ease-in-out;
}
.link-hover:hover {
    color: #ffcc00 !important;
    text-decoration: underline;
}

.carrito-hover:hover {
    animation: vibrar 0.2s ease-in-out;
}

@keyframes vibrar {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-3px); }
    50% { transform: translateX(3px); }
    75% { transform: translateX(-3px); }
}

.btn-hover {
    transition: background 0.3s, transform 0.2s;
}
.btn-hover:hover {
    background: #ffcc00 !important;
    color: black !important;
    transform: scale(1.1);
}
</style>



<!-- Modal Carrito con Estilos y Animaciones -->
<div class="modal fade" id="modalCarrito" tabindex="-1" aria-labelledby="modalCarritoLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content custom-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="modalCarritoLabel">🛒 Carrito de Reservas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body" id="contenido-carrito">
                <!-- Los productos seleccionados se mostrarán aquí -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary custom-btn" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary custom-btn" id="btn-validar-reserva" data-bs-toggle="modal" data-bs-target="#modalValidarPedido">
                    ✅ Validar
                </button>
            </div>
        </div>
    </div>
</div>
<style>
    /* Estilos básicos para la notificación */
/* Estilos básicos para la campanita y la notificación */
.notificacion {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 999;
    display: none;  /* Inicialmente oculta */
}

/* Estilo para la campanita */
.campanita {
    background-color: #FF5733;
    color: white;
    padding: 10px;
    border-radius: 50%;
    font-size: 18px;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    position: relative;
    cursor: pointer;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
    transition: transform 0.2s ease;
}

/* Animación de "sacudida" cuando hay productos */
.campanita.sacudir {
    animation: shake 0.5s ease forwards;
}

@keyframes shake {
    0% {
        transform: translateX(0);
    }
    25% {
        transform: translateX(-5px);
    }
    50% {
        transform: translateX(5px);
    }
    75% {
        transform: translateX(-5px);
    }
    100% {
        transform: translateX(0);
    }
}

/* Efecto de mostrar la notificación */
.mostrar {
    display: block;
    animation: fadeIn 0.5s ease-in-out forwards;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Contador de productos en la campanita */
#cantidadCarrito {
    font-weight: bold;
    font-size: 14px;
}

/* Notificación en el carrito */
.navbar .nav-link .badge {
    font-size: 12px;
    top: -5px;
    right: -5px;
}

/* Estilo del carrito en el navbar */
.navbar-nav .nav-item .nav-link {
    position: relative;
}


/* Estilo para la campanita */
.campanita {
    background-color: #FF5733;
    color: white;
    padding: 10px;
    border-radius: 50%;
    font-size: 18px;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 40px;
    height: 40px;
    position: relative;
    cursor: pointer;
    box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
    transition: transform 0.2s ease;
}

/* Animación de "sacudida" cuando hay productos */
.campanita.sacudir {
    animation: shake 0.5s ease forwards;
}

@keyframes shake {
    0% {
        transform: translateX(0);
    }
    25% {
        transform: translateX(-5px);
    }
    50% {
        transform: translateX(5px);
    }
    75% {
        transform: translateX(-5px);
    }
    100% {
        transform: translateX(0);
    }
}

/* Efecto cuando se muestra la notificación */
.mostrar {
    display: block;
    animation: fadeIn 0.5s ease-in-out forwards;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: scale(0.8);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

/* Cambiar tamaño si la cantidad es mayor a 9 */
#cantidadCarrito {
    font-weight: bold;
    font-size: 14px;
}

</style>
<!-- Estilos CSS para el modal con animaciones -->

<!-- solo para la notificacion del carrito -->
<script>
    // Función para mostrar la notificación del carrito
// Función para mostrar la notificación del carrito
function mostrarNotificacionCarrito(cantidad) {
    const notificacion = document.getElementById("notificacionCarrito");
    const campanita = document.getElementById("campanita");
    const cantidadCarrito = document.getElementById("cantidadCarrito");
    const contadorCarrito = document.getElementById("contador-carrito");

    // Actualiza la cantidad en la notificación
    cantidadCarrito.textContent = cantidad;
    contadorCarrito.textContent = cantidad;

    // Muestra la notificación si hay productos en el carrito
    if (cantidad > 0) {
        notificacion.classList.add("mostrar");
        campanita.classList.add("sacudir");
    } else {
        notificacion.classList.remove("mostrar");
    }
}

// Función para agregar al carrito (simulada para este ejemplo)
function agregarAlCarrito() {
    let cantidad = parseInt(document.getElementById("cantidadCarrito").textContent) || 0;
    cantidad += 1;
    mostrarNotificacionCarrito(cantidad); // Muestra la notificación
}

// Llamada de ejemplo para agregar un producto al carrito
agregarAlCarrito(); // Esto debería ser llamado cuando realmente se agrega algo al carrito
// Esto debería ser llamado cuando realmente se agrega algo al carrito

</script>
    <!-- Sección de Productos -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Nuestros Productos</h2>
        <div class="row" id="productos-container">
            <!-- Los productos se cargarán dinámicamente aquí -->
        </div>
    </div>

    <!-- Modal para validar pedido o reserva -->
    <div class="modal fade" id="modalValidarPedido" tabindex="-1" aria-labelledby="modalValidarPedidoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalValidarPedidoLabel">Validar Pedido o Reserva</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="form-validar-pedido" method="post" class="p-3 border rounded shadow-lg bg-light">
                        <h3 class="text-center mb-3 text-info">Datos del Usuario</h3>

                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control form-control-sm shadow-sm" id="nombre" required placeholder="Nombre del usuario">
                        </div>

                        <div class="mb-3">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control form-control-sm shadow-sm" id="telefono" required placeholder="Teléfono del usuario">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control form-control-sm shadow-sm" id="email" required placeholder="Email del usuario">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <input type="password" name="password" class="form-control form-control-sm shadow-sm" id="password" required placeholder="Contraseña">
                        </div>

                        <div class="mb-3">
                            <label for="ubicacion" class="form-label">Ubicación</label>
                            <input type="text" name="ubicacion" class="form-control form-control-sm shadow-sm" id="ubicacion" required placeholder="Ubicación del usuario">
                        </div>

                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-success btn-sm w-100 shadow-sm">Validar Pedido</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        // Manejar el envío del formulario de validación de pedido
document.getElementById("form-validar-pedido").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevenir el envío del formulario

    const formData = new FormData(this);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "crear_pedido.php", true);

    xhr.onload = function () {
        if (xhr.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);

            if (respuesta.success) {
                Swal.fire('¡Éxito!', 'El pedido ha sido creado.', 'success');
                // Limpiar el carrito después de crear el pedido
                localStorage.removeItem("carrito");
                actualizarContadorCarrito();
                new bootstrap.Modal(document.getElementById("modalValidarPedido")).hide();
            } else {
                Swal.fire('Error', respuesta.error || 'Hubo un problema al crear el pedido.', 'error');
            }
        } else {
            Swal.fire('Error', 'Hubo un problema al crear el pedido.', 'error');
        }
    };

    xhr.send(formData);
});
        // Convertir el JSON de PHP en un arreglo de productos en JavaScript
        const productos = <?php echo $productos_json; ?>;

        // Función para mostrar los productos en la interfaz
        
        function mostrarProductos() {
            const container = document.getElementById('productos-container');
            container.innerHTML = '';  // Limpiar el contenedor

            // Recorrer los productos y crear una tarjeta para cada uno
            productos.forEach(producto => {
                const { id_producto, nombre, descripcion, precio, imagen } = producto;

                // Crear la tarjeta del producto
                const tarjeta = document.createElement('div');
                tarjeta.classList.add('col-md-4', 'producto-card'); // Se usa Bootstrap para la estructura de columnas

                tarjeta.innerHTML = `
                    <div class="card product-card">
                        <img src="${imagen}" alt="${nombre}" class="card-img-top">
                        <div class="card-body">
                            <h5 class="card-title">${nombre}</h5>
                            <p class="card-text">${descripcion}</p>
                            <p class="card-text"><strong>Precio: XAF${precio}</strong></p>
                            <button class="btn btn-primary" onclick="agregarAlCarrito(${id_producto})">Agregar al carrito</button>
                        </div>
                    </div>
                `;

                // Añadir la tarjeta al contenedor
                container.appendChild(tarjeta);
            });
        }

        // Llamar a la función para mostrar los productos cuando la página cargue
        document.addEventListener('DOMContentLoaded', mostrarProductos);

        // Función para agregar un producto al carrito
        function agregarAlCarrito(id) {
            var producto = new FormData();

            // agregar dos variables
            // producto.append('id_cliente', id_cliente);
            producto.append('id_producto', id);
            producto.append('accion', 'agregar');
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "carrito.php", true);
            xhr.onload = function () {
                if (xhr.status === 200) {
                    console.log(xhr.response);
                    const respuesta = JSON.parse(xhr.response );
                    console.log(respuesta);
                    if (respuesta ==1) {
                        Swal.fire('¡Éxito!', 'Producto agregado al carrito.', 'success');
                        // actualizarContadorCarrito();
                    } else {
                        Swal.fire('Error', respuesta.error || 'Hubo un problema al agregar el producto al carrito.', 'error');
                    }

                    // Actualizar el contador del carrito
                    // actualizarContadorCarrito();
                } else {
                    Swal.fire('Error', 'Hubo un problema al agregar el producto al carrito.', 'error');
                }
            };
            xhr.send(producto);
            // Actualizar el contador del carrito
            actualizarContadorCarrito();
        }
        function eliminarProducto(idProducto) {
    // Llamada AJAX para eliminar el producto en el backend
    // eliminarProductoBackend(idProducto);

    // Después de la eliminación, actualizamos el carrito en la vista
    const productoEliminado = document.querySelector(`li[data-id='${idProducto}']`);
    if (productoEliminado) {
        productoEliminado.remove();
    }

    // Actualizar el contador del carrito
    actualizarContadorCarrito();
}

// Función para actualizar el contador del carrito
function actualizarContadorCarrito() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "contarcarrito.php", true); // Asegúrate de tener un archivo PHP que devuelva la cantidad de productos en el carrito

    xhr.onload = function () {
        if (xhr.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            const cantidad = respuesta.cantidad || 0;

            // Actualizar el contador en la campanita y en el navbar
            document.getElementById("cantidadCarrito").textContent = cantidad;
            document.getElementById("contador-carrito").textContent = cantidad;

            // Mostrar o esconder la notificación del carrito
            const notificacion = document.getElementById("notificacionCarrito");
            if (cantidad > 0) {
                notificacion.classList.add("mostrar");
            } else {
                notificacion.classList.remove("mostrar");
            }
        } else {
            console.error("Error al actualizar el contador del carrito. Código:", xhr.status);
        }
    };

    xhr.send();
}
     
         // Función para eliminar productos del carrito
function eliminarProductoCarrito(id) {
    var producto = new FormData();
    producto.append('id_producto', id);
    producto.append('accion', 'eliminar');
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./eliminarproductocarrito.php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            console.log(xhr.response);
            const respuesta = JSON.parse(xhr.response);
            console.log(respuesta);
            if (respuesta == 1) {
                Swal.fire('¡Éxito!', 'Producto eliminado del carrito.', 'success');
            } else {
                Swal.fire('Error', respuesta.error || 'Hubo un problema al eliminar el producto del carrito.', 'error');
            }
        } else {
            Swal.fire('Error', 'Hubo un problema al eliminar el producto del carrito.', 'error');
        }
        // Actualizar el contador del carrito
        actualizarContadorCarrito();
    };
    xhr.send(producto);
}

        // Manejar el envío del formulario de validación de pedido
        document.getElementById("form-validar-pedido").addEventListener("submit", function(event) {
            event.preventDefault(); // Prevenir el envío del formulario

            const formData = new FormData(this);

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "crear_pedido.php", true);

            xhr.onload = function () {
                if (xhr.status === 200) {
                    const respuesta = JSON.parse(xhr.responseText);

                    if (respuesta.success) {
                        Swal.fire('¡Éxito!', 'El pedido ha sido creado.', 'success');
                        // Limpiar el carrito después de crear el pedido
                        localStorage.removeItem("carrito");
                        actualizarContadorCarrito();
                        new bootstrap.Modal(document.getElementById("modalValidarPedido")).hide();
                    } else {
                        Swal.fire('Error', respuesta.error || 'Hubo un problema al crear el pedido.', 'error');
                    }
                } else {
                    Swal.fire('Error', 'Hubo un problema al crear el pedido.', 'error');
                }
            };

            xhr.send(formData);
        });


        // funcion para mostrar los articulos del carrito dentro del modal
    // Función para mostrar los productos en el carrito
function mostrarCarrito() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "mostrarcarrito.php", true);

    xhr.onload = function () {
    if (xhr.status === 200) {
        const carrito = JSON.parse(xhr.responseText);
        const modalBody = document.getElementById('contenido-carrito');
        modalBody.innerHTML = '';  // Limpiar contenido

        if (carrito.length > 0) {
            carrito.forEach((producto, index) => {
                const { id_producto, nombre, descripcion, precio, imagen, cantidad } = producto;

                const fila = document.createElement('div');
                fila.classList.add('producto-carrito', 'row');
                fila.style.animationDelay = `${index * 0.1}s`; // Retraso en la animación

                fila.innerHTML = `
    <div class="col-3 d-flex align-items-center">
        <img src="${imagen}" alt="${nombre}" class="img-fluid">
    </div>
    <div class="col-6 producto-info">
        <h6>${nombre}</h6>
        <p class="text-muted">${descripcion}</p>
        <p class="precio">Precio:  ${precio} XAF</p>
        <p>Cantidad: ${cantidad}</p>
    </div>
    <div class="col-2 d-flex align-items-center justify-content-end">
        <button class="btn-eliminar" onclick="eliminarProducto(${id_producto})">
            <i class="fa-solid fa-trash"></i>
        </button>
    </div>
`;


                modalBody.appendChild(fila);
            });
        } else {
            modalBody.innerHTML = '<p class="text-center text-muted">No hay productos en el carrito</p>';
        }
    } else {
        document.getElementById('contenido-carrito').innerHTML = '<p class="text-danger">Hubo un problema al cargar el carrito</p>';
    }
};

xhr.send();
}

// Llamar a la función para mostrar los productos cuando se abre el modal
document.getElementById('carrito').addEventListener('click', mostrarCarrito);
       
        // Actualizar el contador del carrito cuando se agrega un producto al carrito
    </script>
    <script src="./carrito.js"></script>

    <!-- <script src="./paginaproducto.js"></script> -->
    <style>
        /* Animación de entrada de los productos */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Contenedor de los productos */
.producto-carrito {
    display: flex;
    align-items: center;
    background: white;
    padding: 12px;
    border-radius: 10px;
    box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    margin-bottom: 12px;
    opacity: 0;
    transform: translateY(20px);
    animation: fadeInUp 0.4s ease forwards;
}

/* Efecto hover en la tarjeta */
.producto-carrito:hover {
    transform: scale(1.02);
    box-shadow: 0px 6px 12px rgba(0, 0, 0, 0.15);
}

/* Imagen del producto */
.producto-carrito img {
    width: 100px;
    height: 80px;
    object-fit: cover;
    border-radius: 3px;
    box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.2);
}

/* Texto dentro del producto */
.producto-info {
    flex-grow: 1;
    padding: 0 15px;
}

.producto-info h6 {
    font-size: 1rem;
    font-weight: bold;
    margin-bottom: 5px;
}

.producto-info p {
    font-size: 0.9rem;
    margin-bottom: 4px;
    color: #555;
}

/* Precio en negrita */
.producto-info .precio {
    font-size: 1rem;
    font-weight: bold;
    color: #28a745;
}

/* Botón de eliminar */
.btn-eliminar {
    background: #dc3545;
    color: white;
    font-size: 0.85rem;
    padding: 6px 10px;
    border-radius: 6px;
    border: none;
    transition: all 0.3s ease;
}

/* Efecto hover en botón eliminar */
.btn-eliminar:hover {
    background: #c82333;
    transform: scale(1.1);
}

    </style>
</body>
</html>