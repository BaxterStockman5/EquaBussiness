<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EquaBusiness - Bienvenido</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet"> -->
    <style>
        
        /* Fondo con animación */
        body {
            background: linear-gradient(-45deg, #007bff, #6610f2, #6f42c1, #004085);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
            font-family: 'Poppins', sans-serif;
            color: white;
            text-align: center;
            overflow: hidden;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Contenedor principal */
        .container {
            position: relative;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
        }

        /* Título estilizado */
        h1 {
            font-size: 3rem;
            font-weight: 700;
            animation: fadeInDown 1.2s ease-out;
        }

        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Botones */
        .btn-custom {
            background: linear-gradient(135deg, #007bff, #6610f2);
            color: white;
            border: none;
            padding: 15px 30px;
            font-size: 1.2rem;
            font-weight: bold;
            border-radius: 8px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-custom:hover {
            transform: scale(1.1);
            box-shadow: 0px 8px 20px rgba(255, 255, 255, 0.3);
        }

        /* Animación de partículas */
        .bubbles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .bubble {
            position: absolute;
            bottom: -10px;
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            opacity: 0.6;
            animation: floatBubble 5s infinite linear;
        }

        @keyframes floatBubble {
            0% { transform: translateY(0); opacity: 0.8; }
            100% { transform: translateY(-100vh); opacity: 0; }
        }
    </style>
</head>
<body>

    <div class="bubbles"></div>

    <div class="container">
        <h1>Bienvenido a EquaBusiness</h1>
        <p>Tu plataforma profesional de reservas y comercio.</p>
        <a href="./inicio.php" class="btn btn-custom mt-3">Acceder</a>
    </div>

    <script>
        // Generar burbujas dinámicas
        // 📌 Se define una función llamada createBubbles(), que se encargará de crear 
        // y agregar burbujas dentro de un contenedor específico
        function createBubbles() {
            // 📌 Se selecciona el elemento contenedor de burbujas usando document.querySelector('.bubbles').
// Este debe existir en el HTML con la clase .bubbles, por ejemplo:
            const bubbleContainer = document.querySelector('.bubbles');
            // 📌 Se usa un for para generar 20 burbujas de forma automática.
// El número 20 puede cambiarse si se desean más o menos burbujas.
            for (let i = 0; i < 20; i++) {
                // 📌 Se crea un nuevo div para cada burbuja y se le agrega la clase "bubble",
                //  la cual debe estar definida en CSS para aplicar estilos y animaciones.
                let bubble = document.createElement('div');
                // 📌 Se genera un tamaño aleatorio para cada burbuja:

// Math.random() * 60 + 20:

// Math.random() * 60 → genera un número entre 0 y 60.

// + 20 → asegura que el tamaño mínimo sea 20px.

// Se asignan estos valores al width y height de la burbuja, asegurando que tengan un tamaño variado entre 20px y 80px.
                bubble.classList.add('bubble');
                // 📌 Se posiciona la burbuja en un lugar aleatorio del eje X (horizontal) dentro del contenedor.

// Math.random() * 100 + '%' → genera un valor entre 0% y 100%, es decir, la burbuja aparece en cualquier parte del ancho del contenedor.
                let size = Math.random() * 60 + 20;
                // 📌 Se asigna una duración de animación aleatoria entre 2 y 5 segundos.

// Math.random() * 3 → genera un valor entre 0 y 3.

// + 2 → asegura que la animación dure mínimo 2 segundos.
                bubble.style.width = size + 'px';
               
                bubble.style.height = size + 'px';
                bubble.style.left = Math.random() * 100 + '%';
                bubble.style.animationDuration = (Math.random() * 3 + 2) + 's';
                 // Se agrega la burbuja dentro del contenedor .bubbles, para que aparezca en el HTML.
                bubbleContainer.appendChild(bubble);
            }
        }
        // 📌 Se ejecuta la función createBubbles() inmediatamente después de ser declarada.
// Esto hace que las burbujas se generen automáticamente al cargar la página.
        createBubbles();

        // ✔️ Genera 20 burbujas de diferentes tamaños y posiciones.
// ✔️ Cada burbuja se mueve hacia arriba y desaparece con una duración aleatoria.
// ✔️ Se repite infinitamente, creando un efecto dinámico y natural.
    </script>

</body>
</html>

