document.addEventListener('DOMContentLoaded', function() {
    // Mostrar productos en el carrito
    document.getElementById('carrito').addEventListener('click', mostrarCarrito);

    // Manejar el envío del formulario de validación de pedido
    document.getElementById("form-validar-pedido").addEventListener("submit", function(event) {
        event.preventDefault(); // Prevenir el envío del formulario

        const formData = new FormData(this);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "validar_pedido.php", true);

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
});

// Función para agregar un producto al carrito
function agregarAlCarrito(id, cantidad = 1) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "agregar_al_carrito.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (xhr.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            if (respuesta.success) {
                Swal.fire('¡Éxito!', 'Producto agregado al carrito.', 'success');
                actualizarContadorCarrito();
            } else {
                Swal.fire('Error', respuesta.error || 'Hubo un problema al agregar el producto al carrito.', 'error');
            }
        } else {
            Swal.fire('Error', 'Hubo un problema al agregar el producto al carrito.', 'error');
        }
    };

    xhr.send(`id_producto=${id}&cantidad=${cantidad}`);
}

// Función para mostrar los productos en el carrito
function mostrarCarrito() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "mostrar_carrito.php", true);

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
                            <p class="precio">Precio: ${precio} XAF</p>
                            <p>Cantidad: ${cantidad}</p>
                        </div>
                        <div class="col-2 d-flex align-items-center justify-content-end">
                            <button class="btn-eliminar" onclick="eliminarProductoCarrito(${id_producto})">
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

// Función para eliminar productos del carrito
function eliminarProductoCarrito(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "eliminar_del_carrito.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (xhr.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            if (respuesta.success) {
                Swal.fire('¡Éxito!', 'Producto eliminado del carrito.', 'success');
                mostrarCarrito();
                actualizarContadorCarrito();
            } else {
                Swal.fire('Error', respuesta.error || 'Hubo un problema al eliminar el producto del carrito.', 'error');
            }
        } else {
            Swal.fire('Error', 'Hubo un problema al eliminar el producto del carrito.', 'error');
        }
    };

    xhr.send(`id_producto=${id}`);
}

// Función para vaciar el carrito
function vaciarCarrito() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "vaciar_carrito.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onload = function () {
        if (xhr.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            if (respuesta.success) {
                Swal.fire('¡Éxito!', 'Carrito vaciado.', 'success');
                mostrarCarrito();
                actualizarContadorCarrito();
            } else {
                Swal.fire('Error', respuesta.error || 'Hubo un problema al vaciar el carrito.', 'error');
            }
        } else {
            Swal.fire('Error', 'Hubo un problema al vaciar el carrito.', 'error');
        }
    };

    xhr.send();
}

// Función para actualizar el contador del carrito
function actualizarContadorCarrito() {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "contar_carrito.php", true);

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