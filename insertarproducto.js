
// Función para ver el producto
document.addEventListener('DOMContentLoaded', function() {
    const botonesVer = document.querySelectorAll('#verproducto');
    botonesVer.forEach(function(boton) {
        boton.addEventListener('click', function() {
            const idProducto = this.getAttribute('data-id'); // Obtener el ID del producto
            verProducto(idProducto); // Llamar la función para ver el producto
        });
    });

 });



// Función para eliminar producto
function eliminarProducto(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Este producto será eliminado de forma permanente!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminarlo',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', './eliminarproducto.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function () {
                if (xhr.status === 200) {
                    Swal.fire('¡Eliminado!', 'El producto ha sido eliminado.', 'success');
                    cargarProductos(); // Recargar los productos después de eliminar
                } else {
                    Swal.fire('Error', 'Hubo un problema al eliminar el producto.', 'error');
                }
            };
            xhr.send('id=' + id); // Enviar el ID del producto a eliminar
        }
    });
}


function verProducto(id) {
    const xhr = new XMLHttpRequest();
    xhr.open('GET', './verproducto.php?id=' + id, true);

    xhr.onload = function() {
        if (xhr.status === 200) {
            try {
                const respuesta = JSON.parse(xhr.responseText);

                if (!respuesta.success) {
                    Swal.fire('Error', respuesta.error || 'Error desconocido', 'error');
                    return;
                }

                const producto = respuesta.producto;

                // Actualizar el modal
                document.getElementById('producto-nombre').innerText = producto.nombre;
                document.getElementById('producto-descripcion').innerText = producto.descripcion;
                document.getElementById('producto-categoria').innerText = producto.categoria;
                document.getElementById('producto-precio').innerText = `$${producto.precio}`;
                document.getElementById('producto-imagen').src = producto.imagen || 'imagenes/default.png';

                // Mostrar el modal
                const modal = new bootstrap.Modal(document.getElementById('modalVerProducto'));
                modal.show();
            } catch (error) {
                Swal.fire('Error', 'Respuesta inválida del servidor.', 'error');
                console.error("Error al parsear JSON:", error);
            }
        } else {
            Swal.fire('Error', 'No se pudo obtener la información del producto.', 'error');
        }
    };
}


    xhr.onerror = function() {
        Swal.fire
    }
