

// Función para cargar los productos a través de AJAX
function cargarProductos() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', './mostrarproductos.php', true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                console.log("Respuesta del servidor:", xhr.responseText); // Debug en la consola

                try {
                    const productos = JSON.parse(xhr.responseText.trim()); // Elimina espacios en blanco innecesarios
                    const tabla = document.querySelector("#productos-table tbody");
                    tabla.innerHTML = ""; // Limpiar la tabla antes de cargar nuevos datos

                    if (productos.error) {
                        alert("Error: " + productos.error);
                        return;
                    }

                    productos.forEach(producto => {
                        const row = document.createElement("tr");
                        row.innerHTML = `
                            <td>${producto.id_producto}</td>
                            <td>${producto.nombre}</td>
                            <td>${producto.descripcion}</td>
                            <td>${producto.precio}</td>
                            <td>${producto.categoria}</td>
                            <td><img src="${producto.imagen}" alt="${producto.nombre}" width="50"></td>
                            <td>${producto.disponible == '1' ? 'Disponible' : 'No Disponible'}</td>
                            <td>
                                <button class="btn btn-info btn-sm" onclick="verProducto(${producto.id_producto})">Ver</button>
                                <button class="btn btn-warning btn-sm" onclick="editarProducto(${producto.id_producto})">Editar</button>
                                <button class="btn btn-danger btn-sm" onclick="eliminarProducto(${producto.id_producto})">Eliminar</button>
                            </td>
                        `;
                        tabla.appendChild(row);
                    });

                } catch (e) {
                    alert("Error al procesar los datos: " + e.message);
                }
            } else {
                alert("Error al obtener los productos. Código: " + xhr.status);
            }
        }
    };

    xhr.send();
}


// Función para eliminar un producto
function eliminarProducto(idProducto) {
    if (confirm("¿Estás seguro de que deseas eliminar este producto?")) {
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "./eliminarproducto.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                alert(xhr.responseText); // Mostrar mensaje de éxito o error
                cargarProductos(); // Recargar la lista de productos
            }
        };

        xhr.send(`id_producto=${idProducto}`);
    }
}


// Carrito de compras
let carrito = [];
let contadorCarrito = document.getElementById('contador-carrito');
let validarCarrito = document.getElementById('validar-carrito');

// Función para cargar los productos
function cargarProductos() {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'productos.php', true);

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const productos = JSON.parse(xhr.responseText);

            if (productos.error) {
                alert('Error al cargar los productos: ' + productos.error);
                return;
            }

            const productosContainer = document.getElementById('productos-container');
            productosContainer.innerHTML = ''; // Limpiar el contenedor antes de agregar nuevos productos

            productos.forEach(producto => {
                const divProducto = document.createElement('div');
                divProducto.classList.add('col-md-3', 'col-sm-6', 'mb-2'); // Tarjetas de tamaño pequeño
                
                divProducto.innerHTML = `
                    <div class="card producto-card" style="width: 14rem;">
                        <img src="${producto.imagen}" class="card-img-top img-producto" alt="${producto.nombre}">
                        <div class="card-body p-2 text-center">
                            <h6 class="card-title">${producto.nombre}</h6>
                            <p class="card-text text-truncate">${producto.descripcion}</p>
                            <p class="card-text"><strong>$${producto.precio}</strong></p>
                            <div class="d-flex justify-content-between mt-3">
                                <button class="btn btn-sm btn-primary" onclick="verProducto(${producto.id_producto})">Ver</button>
                                <button class="btn btn-sm btn-success" onclick="agregarAlCarrito(${producto.id_producto})">Agregar al carrito</button>
                            </div>
                        </div>
                    </div>
                `;
                productosContainer.appendChild(divProducto);
            });
        }
    };

    xhr.send();
}



// Función para mostrar los detalles del producto en un modal
function verProducto(idProducto) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', `verproducto.php?id=${idProducto}`, true); // URL para obtener el detalle del producto

    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const producto = JSON.parse(xhr.responseText);
            if (producto.error) {
                alert('Error al cargar el producto');
                return;
            }

            // Mostrar los detalles en el modal
            document.getElementById('producto-nombre').textContent = producto.nombre;
            document.getElementById('producto-descripcion').textContent = producto.descripcion;
            document.getElementById('producto-precio').textContent = producto.precio;
            document.getElementById('producto-categoria').textContent = producto.categoria;
            document.getElementById('producto-disponibilidad').textContent = producto.disponible === '1' ? 'Disponible' : 'No Disponible';
            document.getElementById('producto-imagen').src = producto.imagen;

            // Mostrar el modal
            const modal = new bootstrap.Modal(document.getElementById('verProductoModal'));
            modal.show();
        }
    };

    xhr.send();
}

// Función para agregar productos al carrito
function agregarAlCarrito() {
    const producto = {
        nombre: document.getElementById('producto-nombre').textContent,
        precio: document.getElementById('producto-precio').textContent,
        cantidad: 1
    };

    carrito.push(producto);
    actualizarCarrito();
}

// Función para actualizar el carrito
function actualizarCarrito() {
    contadorCarrito.textContent = carrito.length;
    if (carrito.length > 0) {
        validarCarrito.disabled = false;
    } else {
        validarCarrito.disabled = true;
    }
}

// Cargar los productos al cargar la página
window.onload = cargarProductos;



document.addEventListener("DOMContentLoaded", function () {
    // Función para cargar los datos del producto en el modal de edición
    function editarProducto(id) {
        let xhr = new XMLHttpRequest();
        xhr.open("GET", "./obtenerproducto.php?id=" + id, true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                let producto = JSON.parse(xhr.responseText);

                if (producto.error) {
                    Swal.fire("Error", producto.error, "error");
                } else {
                    // Llenar los campos del formulario con los datos del producto
                    document.getElementById("editar-id").value = producto.id_producto;
                    document.getElementById("editar-nombre").value = producto.nombre;
                    document.getElementById("editar-descripcion").value = producto.descripcion;
                    document.getElementById("editar-categoria").value = producto.categoria;
                    document.getElementById("editar-precio").value = producto.precio;
                    
                    // Abrir el modal
                    let modal = new bootstrap.Modal(document.getElementById("modalEditarProducto"));
                    modal.show();
                }
            } else {
                Swal.fire("Error", "Hubo un problema al obtener los datos del producto.", "error");
            }
        };

        xhr.send();
    }
    // console.log("./obtenerproducto.php?id=" + id);

    // Función para enviar la actualización del producto
    document.getElementById("form-editar-producto").addEventListener("submit", function (e) {
        e.preventDefault();

        let formData = new FormData(this);
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "./actualizarproducto.php", true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                Swal.fire("Éxito", xhr.responseText, "success");

                // Cerrar el modal
                let modal = bootstrap.Modal.getInstance(document.getElementById("modalEditarProducto"));
                modal.hide();

                // Recargar la tabla de productos
                cargarProductos();
            } else {
                Swal.fire("Error", "No se pudo actualizar el producto.", "error");
            }
        };

        xhr.send(formData);
    });

    // Agregar evento a los botones "Editar" de la tabla
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("btn-editar")) {
            let idProducto = e.target.getAttribute("data-id");
            editarProducto(idProducto);
        }
    });
});






