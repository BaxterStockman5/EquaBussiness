document.addEventListener('DOMContentLoaded', function() {
    cargarProductos();
    cargarCategorias();

    // Manejar el envío del formulario de agregar producto
    document.getElementById('form-agregar-producto').addEventListener('submit', function(event) {
        event.preventDefault();
        agregarProducto();
    });

    // Manejar el envío del formulario de editar producto
    document.getElementById('form-editar-producto').addEventListener('submit', function(event) {
        event.preventDefault();
        editarProducto();
    });
});

// Función para cargar los productos
function cargarProductos() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'mostrar_productos.php', true);

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
                    <div class="col">${producto.precio}</div>
                    <div class="col">${producto.disponible}</div>
                    <div class="col"><img src="${producto.imagen}" alt="${producto.nombre}" class="img-fluid" width="50"></div>
                    <div class="col">
                        <button class="btn btn-info btn-sm" onclick="verProducto(${producto.id_producto})"><i class="fas fa-eye"></i></button>
                        <button class="btn btn-warning btn-sm" onclick="mostrarModalEditar(${producto.id_producto})"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-danger btn-sm" onclick="eliminarProducto(${producto.id_producto})"><i class="fas fa-trash-alt"></i></button>
                    </div>
                `;
                productosBody.appendChild(fila);
            });
        } else {
            console.error('Error al cargar los productos. Código:', xhr.status);
        }
    };

    xhr.send();
}

// Función para cargar las categorías en los select
function cargarCategorias() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'mostrar_categorias.php', true);

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

    xhr.send();
}

// Función para agregar un producto
function agregarProducto() {
    const formData = new FormData(document.getElementById('form-agregar-producto'));
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'insertarproductos.php', true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            if (respuesta.success) {
                Swal.fire('¡Éxito!', 'Producto agregado correctamente.', 'success');
                document.getElementById('form-agregar-producto').reset();
                cargarProductos();
                const modalAgregarProducto = bootstrap.Modal.getInstance(document.getElementById('modalAgregarProducto'));
                modalAgregarProducto.hide();
            } else {
                Swal.fire('Error', respuesta.message || 'Hubo un problema al agregar el producto.', 'error');
            }
        } else {
            Swal.fire('Error', 'Hubo un problema al agregar el producto.', 'error');
        }
    };

    xhr.send(formData);
}

// Función para mostrar el modal de editar producto
function mostrarModalEditar(id) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', `obtener_producto.php?id=${id}`, true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            const producto = JSON.parse(xhr.responseText);
            document.getElementById('editar-id-producto').value = producto.id_producto;
            document.getElementById('editar-nombre').value = producto.nombre;
            document.getElementById('editar-descripcion').value = producto.descripcion;
            document.getElementById('editar-precio').value = producto.precio;
            document.getElementById('editar-categoria').value = producto.id_categoria;
            document.getElementById('imagen-actual').value = producto.imagen;

            new bootstrap.Modal(document.getElementById('modalEditarProducto')).show();
        } else {
            Swal.fire('Error', 'Hubo un problema al obtener los datos del producto.', 'error');
        }
    };

    xhr.send();
}

// Función para editar un producto
function editarProducto() {
    const formData = new FormData(document.getElementById('form-editar-producto'));
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'editar_producto.php', true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            if (respuesta.success) {
                Swal.fire('¡Éxito!', 'Producto editado correctamente.', 'success');
                cargarProductos();
                const modalEditarProducto = bootstrap.Modal.getInstance(document.getElementById('modalEditarProducto'));
                modalEditarProducto.hide();
            } else {
                Swal.fire('Error', respuesta.message || 'Hubo un problema al editar el producto.', 'error');
            }
        } else {
            Swal.fire('Error', 'Hubo un problema al editar el producto.', 'error');
        }
    };

    xhr.send(formData);
}

// Función para eliminar un producto
function eliminarProducto(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo'
    }).then((result) => {
        if (result.isConfirmed) {
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'eliminar_producto.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            xhr.onload = function() {
                if (xhr.status === 200) {
                    const respuesta = JSON.parse(xhr.responseText);
                    if (respuesta.success) {
                        Swal.fire('¡Eliminado!', 'El producto ha sido eliminado.', 'success');
                        cargarProductos();
                    } else {
                        Swal.fire('Error', respuesta.message || 'Hubo un problema al eliminar el producto.', 'error');
                    }
                } else {
                    Swal.fire('Error', 'Hubo un problema al eliminar el producto.', 'error');
                }
            };

            xhr.send(`id_producto=${id}`);
        }
    });
}

// Función para ver los detalles de un producto
function verProducto(id) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', `obtener_producto.php?id=${id}`, true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            const producto = JSON.parse(xhr.responseText);
            document.getElementById('producto-imagen').src = producto.imagen;
            document.getElementById('producto-nombre').textContent = producto.nombre;
            document.getElementById('producto-descripcion').textContent = producto.descripcion;
            document.getElementById('producto-categoria').textContent = producto.categoria;
            document.getElementById('producto-precio').textContent = `${producto.precio} XAF`;

            new bootstrap.Modal(document.getElementById('modalVerProducto')).show();
        } else {
            Swal.fire('Error', 'Hubo un problema al obtener los datos del producto.', 'error');
        }
    };

    xhr.send();
}

// Función para limpiar el formulario de agregar producto
function limpiarFormulario() {
    document.getElementById('form-agregar-producto').reset();
}