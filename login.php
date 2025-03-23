<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Administrador</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Fondo animado */
        body {
            background: linear-gradient(-45deg, #4a00e0, #8e2de2, #2196F3, #00d4ff);
            background-size: 400% 400%;
            animation: gradientBG 10s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            font-family: 'Arial', sans-serif;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Tarjeta del login */
        .login-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 100%;
            max-width: 400px;
            opacity: 0;
            transform: translateY(-20px);
            animation: fadeIn 1s forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .login-container h3 {
            font-size: 26px;
            font-weight: bold;
            color: #4a00e0;
            margin-bottom: 20px;
        }

        /* Inputs */
        .form-control {
            border-radius: 8px;
            border: 2px solid #8e2de2;
            transition: 0.3s ease-in-out;
        }

        .form-control:focus {
            border-color: #4a00e0;
            box-shadow: 0 0 10px rgba(74, 0, 224, 0.3);
        }

        /* Botón */
        .btn-primary {
            background: linear-gradient(45deg, #4a00e0, #8e2de2);
            border: none;
            font-size: 18px;
            padding: 10px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-primary:hover {
            background: linear-gradient(45deg, #8e2de2, #4a00e0);
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h3>Iniciar Sesión</h3>
        <form id="loginForm">
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
        </form>
    </div>

    <script>
    document.getElementById("loginForm").addEventListener("submit", function(event) {
        event.preventDefault();
        
        let formData = new FormData(this);

        fetch("validar_login.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: "success",
                    title: "Bienvenido",
                    text: "Inicio de sesión exitoso",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "./administradores.php";
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Acceso Denegado",
                    text: "No eres un administrador o credenciales incorrectas",
                });
            }
        })
        .catch(error => console.error("Error:", error));
    });
    </script>
</body>
</html>

