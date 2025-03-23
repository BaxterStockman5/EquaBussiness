<?php require('conexion.php'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Publicidad - EquaBusiness</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <!-- Fondo animado -->
    <div id="particles-js"></div>

    <!-- Header -->
    <header class="header">
        <h1 class="text-center text-light">📢 Servicio de Publicidad</h1>
    </header>

    <!-- Carrusel de Publicidad -->
    <div class="container my-5">
        <div id="carouselPublicidad" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner" id="carousel-content"></div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselPublicidad" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselPublicidad" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </div>

    <!-- Botón para abrir el modal -->
    <div class="text-center">
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalPublicidad">Agregar Publicidad</button>
    </div>

    <!-- Modal de Registro -->
    <div class="modal fade" id="modalPublicidad" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Registrar Publicidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="form-publicidad" enctype="multipart/form-data">
                        <input type="text" id="titulo" name="titulo" class="form-control mb-3" placeholder="Título" required>
                        <textarea id="descripcion" name="descripcion" class="form-control mb-3" placeholder="Descripción" required></textarea>
                        <input type="file" id="imagen" name="imagen" class="form-control mb-3" accept="image/*" required>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <p>&copy; 2025 EquaBusiness - Todos los derechos reservados</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/particles.js"></script>
    <script>
        // Cargar Publicidad desde la Base de Datos
        document.addEventListener("DOMContentLoaded", function () {
            fetch('obtener_publicidad.php')
                .then(response => response.json())
                .then(data => {
                    console.log("Datos recibidos:", data);
                    const carouselContent = document.getElementById("carousel-content");
                    let active = "active";
                    data.forEach((item) => {
                        carouselContent.innerHTML += `
                            <div class="carousel-item ${active}">
                                <img src="imagenes/${item.imagen}" class="d-block w-100 img-fluid" alt="${item.titulo}">
                                <div class="carousel-caption d-none d-md-block">
                                    <h5>${item.titulo}</h5>
                                    <p>${item.descripcion}</p>
                                </div>
                            </div>`;
                        active = "";
                    });
                })
                .catch(error => console.error("Error al obtener datos:", error));
        });

        // Guardar Publicidad
        document.getElementById("form-publicidad").addEventListener("submit", function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            
            fetch('guardar_publicidad.php', {
                method: 'POST',
                body: formData
            }).then(response => response.text())
              .then(result => {
                  alert(result);
                  location.reload();
              });
        });

        // Animación de partículas
        particlesJS.load('particles-js', 'particles.json', function() {
            console.log('Partículas cargadas');
        });
    </script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(45deg, #6a11cb, #2575fc);
            color: white;
            overflow: hidden;
        }

        .header {
            padding: 20px;
            background: rgba(0, 0, 0, 0.8);
            text-align: center;
        }

        #particles-js {
            position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            z-index: -1;
        }

        .carousel-item img {
            max-height: 500px;
            object-fit: cover;
        }

        .footer {
            background: rgba(0, 0, 0, 0.8);
            padding: 10px;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</body>
</html>


