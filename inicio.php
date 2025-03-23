<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EquaBusiness - Inicio</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <style>
        /* Estilos generales */
body {
    font-family: 'Arial', sans-serif;
    color: white;
    background-color: #1a1a2e;
    margin: 0;
    padding: 0;
    background: linear-gradient(45deg, #6a11cb, #2575fc);
}

/* Fondo Animado */
.background {
    position: fixed;
    width: 100%;
    height: 100%;
    z-index: -1;
    overflow: hidden;
    background: linear-gradient(45deg, #6a11cb, #2575fc);
}

/* Burbujas */
.bubbles {
    position: absolute;
    width: 100%;
    height: 100%;
}

.bubble {
    position: absolute;
    bottom: -50px;
    background: rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    animation: float 5s infinite linear;
}

@keyframes float {
    from {
        transform: translateY(0);
    }
    to {
        transform: translateY(-100vh);
    }
}

/* Navbar */
.navbar {
    background: rgba(0, 0, 0, 0.7);
    padding: 15px;
}

.navbar-brand {
    color: white;
    font-weight: bold;
}

.navbar-nav .nav-link {
    color: white;
    transition: 0.3s;
}

.navbar-nav .nav-link:hover {
    color: #ff4757;
}

/* Hero */
.hero {
    text-align: center;
    padding: 150px 20px;
}

.hero h1 {
    font-size: 3rem;
}

.hero span {
    color: #ff4757;
}

.hero p {
    font-size: 1.2rem;
    margin-bottom: 20px;
}

/* Secciones Destacadas */
.features {
    padding: 50px 20px;
    text-align: center;
}

.feature-box {
    background: rgba(255, 255, 255, 0.1);
    padding: 20px;
    margin: 15px;
    border-radius: 10px;
    transition: 0.3s;
}

.feature-box:hover {
    transform: translateY(-5px);
    background: rgba(255, 255, 255, 0.2);
}

/* Footer */
footer {
    background: rgba(0, 0, 0, 0.8);
    padding: 30px 20px;
    color: white;
}

footer h5 {
    color: #ff4757;
}

footer ul {
    list-style: none;
    padding: 0;
}

footer ul li {
    margin: 5px 0;
}

footer ul li a {
    color: white;
    text-decoration: none;
    transition: 0.3s;
}

footer ul li a:hover {
    color: #ff4757;
}

    </style>
    <script>
        // Generar burbujas dinámicas
function createBubbles() {
    const bubbleContainer = document.querySelector('.bubbles');
    for (let i = 0; i < 20; i++) {
        let bubble = document.createElement('div');
        bubble.classList.add('bubble');
        let size = Math.random() * 50 + 20;
        bubble.style.width = size + 'px';
        bubble.style.height = size + 'px';
        bubble.style.left = Math.random() * 100 + '%';
        bubble.style.animationDuration = (Math.random() * 4 + 3) + 's';
        bubbleContainer.appendChild(bubble);
    }
}
createBubbles();

    </script>

    <!-- Fondo Animado -->
    <div class="background">
        <div class="bubbles"></div>
    </div>

    <!-- Navbar Mejorado -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">EquaBusiness</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Servicios</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Nosotros</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-primary" href="#">Contacto</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Mejorado -->
    <header class="hero">
        <div class="container text-center">
            <h1>Bienvenido a <span>EquaBusiness</span></h1>
            <p>Tu plataforma confiable para reservas de productos</p>
            <a href="./paginaproducto.php" class="btn btn-primary">Explorar Ahora</a>
        </div>
    </header>

    <!-- Secciones Destacadas -->
    <section class="features">
        <div class="container">
            <div class="row">
                <div class="col-md-4 feature-box">
                    <div class="icon">🛒</div>
                    <h3>Variedad de Productos</h3>
                    <p>Encuentra lo que necesitas en un solo lugar.</p>
                </div>
                <div class="col-md-4 feature-box">
                    <div class="icon">🚀</div>
                    <h3>Reservas Rápidas</h3>
                    <p>Realiza tus reservas en pocos clics.</p>
                </div>
                <div class="col-md-4 feature-box">
                    <div class="icon">💼</div>
                    <h3>Soporte 24/7</h3>
                    <p>Estamos aquí para ayudarte en todo momento.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Mejorado -->
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>EquaBusiness</h5>
                    <p>La mejor plataforma para reservas de productos.</p>
                </div>
                <div class="col-md-4">
                    <h5>Enlaces</h5>
                    <ul>
                        <li><a href="#">Inicio</a></li>
                        <li><a href="#">Servicios</a></li>
                        <li><a href="#">Nosotros</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Contacto</h5>
                    <p>Email: soporte@equabusiness.com</p>
                    <p>Tel: +123 456 7890</p>
                </div>
            </div>
            <hr>
            <p class="text-center">© 2025 EquaBusiness. Todos los derechos reservados.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>

