<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Estadísticas de Pedidos</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>

    <style>
        /* Fondo con degradado azul y violeta */
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #4b0082, #007bff);
            color: #fff;
            text-align: center;
            margin: 0;
            padding: 20px;
            overflow-x: hidden;
        }

        h2 {
            font-size: 2rem;
            margin-bottom: 20px;
            animation: fadeInDown 1s ease-in-out;
        }

        .chart-container {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        canvas {
            max-width: 400px;
            max-height: 400px;
            background: rgba(255, 255, 255, 0.1);
            padding: 10px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-in-out;
        }

        canvas:hover {
            transform: scale(1.05);
        }

        /* Animación de entrada */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Carga elegante */
        #loading {
            font-size: 1.2rem;
            font-weight: bold;
            color: #fff;
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }
    </style>
</head>
<body>
    <h2>📊 Estadísticas de Pedidos</h2>

    <div id="loading">Cargando estadísticas...</div>  <a style="border: none; color:#fff;" href="./paneladmin.php">volver</a>

    <div class="chart-container" style="display: none;">
        <canvas id="barChart"></canvas>
        <canvas id="pieChart"></canvas>
    </div>
    
    <script>
        function obtenerEstadisticas() {
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "./estadisticaspedidos.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var datos = JSON.parse(xhr.responseText);
                    
                    var estados = ["pendiente", "procesado", "entregado", "cancelado"];
                    var valores = estados.map(estado => datos[estado] || 0);

                    document.getElementById("loading").style.opacity = "0";
                    setTimeout(() => {
                        document.getElementById("loading").style.display = "none";
                        document.querySelector(".chart-container").style.display = "flex";
                    }, 500);

                    actualizarGraficos(estados, valores);
                }
            };
            xhr.send();
        }

        function actualizarGraficos(estados, valores) {
            const colores = ["#ffc107", "#007bff", "#28a745", "#dc3545"];

            // 🎨 Gráfico de Barras
            new Chart(document.getElementById("barChart"), {
                type: "bar",
                data: {
                    labels: estados,
                    datasets: [{
                        label: "Cantidad de Pedidos",
                        data: valores,
                        backgroundColor: colores,
                        borderColor: colores.map(color => color.replace(")", ", 0.8)")),
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: { 
                            beginAtZero: true,
                            ticks: {
                                color: '#fff'  // Cambiar color de los números del eje Y
                            }
                        },
                        x: {
                            ticks: {
                                color: '#fff'  // Cambiar color de los textos del eje X
                            }
                        }
                    },
                    animation: {
                        duration: 2000,
                        easing: "easeInOutBounce"
                    }
                }
            });

            // 🥧 Gráfico de Pastel
            new Chart(document.getElementById("pieChart"), {
                type: "pie",
                data: {
                    labels: estados,
                    datasets: [{
                        data: valores,
                        backgroundColor: colores,
                        hoverOffset: 10
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { 
                            position: "bottom",
                            labels: {
                                color: '#fff' // Cambiar color de las leyendas
                            }
                        }
                    },
                    animation: {
                        animateScale: true,
                        animateRotate: true
                    }
                }
            });
        }
        obtenerEstadisticas();
    </script>

</body>
</html>
