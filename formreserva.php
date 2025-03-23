<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Bootstrap Site</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>

  <link rel="stylesheet" href="./BOOTSTRAP/css/bootstrap.css">
  <link rel="stylesheet" href="./BOOTSTRAP/js/bootstrap.js">
</head>
<body>
    <!-- Formulario de Reserva -->
<form id="form-reserva">
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
        <input type="tel" class="form-control" id="telefono" required>
    </div>
    <div class="mb-3">
        <label for="direccion" class="form-label">Dirección</label>
        <input type="text" class="form-control" id="direccion" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Correo Electrónico</label>
        <input type="email" class="form-control" id="email" required>
    </div>
    <button type="submit" class="btn btn-primary">Realizar Reserva</button>
</form>
<script>
    // Al cargar la página, traer el carrito del sessionStorage y mostrar los productos
window.onload = function() {
    const carritoGuardado = sessionStorage.getItem("carrito");
    if (carritoGuardado) {
        const carrito = JSON.parse(carritoGuardado);
        // Mostrar los productos en el formulario (puedes agregarlos a una lista o mostrar los nombres)
        const productosReserva = document.createElement("ul");
        carrito.forEach(producto => {
            const li = document.createElement("li");
            li.textContent = `${producto.nombre} - $${producto.precio}`;
            productosReserva.appendChild(li);
        });
        document.getElementById("form-reserva").appendChild(productosReserva);
    }
};

// Enviar los datos del formulario al servidor
document.getElementById("form-reserva").addEventListener("submit", function(event) {
    event.preventDefault();
    
    // Obtener los datos del formulario
    const nombre = document.getElementById("nombre").value;
    const apellido = document.getElementById("apellido").value;
    const telefono = document.getElementById("telefono").value;
    const direccion = document.getElementById("direccion").value;
    const email = document.getElementById("email").value;
    
    // Obtener los productos seleccionados del sessionStorage
    const carrito = JSON.parse(sessionStorage.getItem("carrito"));
    
    const datosReserva = {
        nombre,
        apellido,
        telefono,
        direccion,
        email,
        productos: carrito
    };

    // Enviar los datos al servidor (como en el ejemplo anterior)
    const xhr = new XMLHttpRequest();
    xhr.open("POST", "procesar_reserva.php", true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            const respuesta = JSON.parse(xhr.responseText);
            if (respuesta.success) {
                alert("Reserva realizada con éxito");
                sessionStorage.removeItem("carrito");  // Limpiar el carrito
                window.location.href = "gracias.html";  // Redirigir a una página de agradecimiento
            } else {
                alert("Error al realizar la reserva: " + respuesta.error);
            }
        }
    };
    xhr.send(JSON.stringify(datosReserva));
});

</script>
</body>
</html>
