document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("menu-toggle").addEventListener("click", function () {
        document.getElementById("sidebar").classList.toggle("d-none");
        document.getElementById("page-content-wrapper").classList.toggle("ml-0");
    });

    cargarSeccion('inicio'); // Cargar la sección de inicio por defecto
});

function cargarSeccion(seccion) {
    let xhr = new XMLHttpRequest();
    xhr.open("GET", "secciones/" + seccion + ".php", true);
    xhr.onload = function () {
        if (xhr.status === 200) {
            document.getElementById("contenido").innerHTML = xhr.responseText;
        } else {
            document.getElementById("contenido").innerHTML = "<p>Error al cargar la sección.</p>";
        }
    };
    xhr.send();
}
