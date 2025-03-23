function insertarAdministrador() {
    // Obtenemos los datos del formulario
    var nombre = document.getElementById("nombre").value;
    var apellido = document.getElementById("apellido").value;
    var telefono = document.getElementById("telefono").value;
    var direccion = document.getElementById("direccion").value;
    var email = document.getElementById("email").value;
    var password = document.getElementById("password").value;
    var foto = document.getElementById("foto").files[0]; // Foto seleccionada
    
    // Validación básica
    if (nombre === "" || apellido === "" || telefono === "" || direccion === "" || email === "" || password === "") {
      alert("Por favor, completa todos los campos.");
      return false;
    }
  
    var formData = new FormData();
    formData.append("nombre", nombre);
    formData.append("apellido", apellido);
    formData.append("telefono", telefono);
    formData.append("direccion", direccion);
    formData.append("email", email);
    formData.append("password", password);
    formData.append("foto", foto); // Agregamos la foto al FormData
  
    // Creamos el objeto XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "insertarAdministradores.php", true);
  
    // Establecemos la función para manejar la respuesta
    xhr.onreadystatechange = function() {
      if (xhr.readyState === 4 && xhr.status === 200) {
        // Mostrar mensaje de éxito o error
        document.getElementById("mensaje").textContent = xhr.responseText;
      }
    };
  
    // Enviar la solicitud
    xhr.send(formData);
  
    // Prevenir el comportamiento por defecto del formulario
    return false;
  }
  // funcion para ver los detalles del admin
  function verAdministrador(id) {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', `obtener_admin.php?id=${id}`, true);
  
    xhr.onload = function() {
      if (xhr.status === 200) {
        const admin = JSON.parse(xhr.responseText);
        document.getElementById('admin-nombre').textContent = admin.nombre;
        document.getElementById('admin-apellido').textContent = admin.apellido;
        document.getElementById('admin-telefono').textContent = admin.telefono;
        document.getElementById('admin-direccion').textContent = admin.direccion;
        document.getElementById('admin-email').textContent = admin.email;
      }
    };
  
    xhr.send();
  }
  // funcion para editar los detalles del admin
  function editarAdministrador(id) {
    const nombre = document.getElementById('admin-nombre-edit').value;
    const apellido = document.getElementById('admin-apellido-edit').value;
    const telefono = document.getElementById('admin-telefono-edit').value;
    const direccion = document.getElementById('admin-direccion-edit').value;
    const email = document.getElementById('admin-email-edit').value;
  
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'editar_admin.php', true);
  
    xhr.onload = function() {
      if (xhr.status === 200) {
        document.getElementById('mensaje-edit').textContent = xhr.responseText;
      }
    };
  
    xhr.send(`id=${id}&nombre=${nombre}&apellido=${apellido}&telefono=${telefono}&direccion=${direccion}&email=${email}`);
  }
  // funcion para eliminar un admin
  function eliminarAdministrador(id) {
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'eliminar_admin.php', true);
  
    xhr.onload = function() {
      if (xhr.status === 200) {
        document.getElementById('mensaje-eliminar').textContent = xhr.responseText;
      }
    };
  
    xhr.send(`id=${id}`);
  }
  // funcion para filtrar administradores
  function filtrarAdministradores() {
    const filtro = document.getElementById('filtro-admin').value.toLowerCase();
  
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'filtrar_admins.php?filtro=' + filtro, true);
  
    xhr.onload = function() {
      if (xhr.status === 200) {
        document.getElementById('tabla-admins').innerHTML = xhr.responseText;
      }
    };
  
    xhr.send();
  }
  // funcion para cargar los administradores al inicio  
  function cargarAdministradores() {
    let xhr = new XMLHttpRequest();
    xhr.open('GET', 'cargar_admins.php', true);
  
    xhr.onload = function() {
      if (xhr.status === 200) {
        document.getElementById('tabla-admins').innerHTML = xhr.responseText;
      }
    };
  
    xhr.send();
  }
  // evento que se ejecuta al cargar la página
  window.onload = function() {
    cargarAdministradores();
  };
  // evento para agregar un nuevo admin
  document.getElementById('agregar-admin').addEventListener('submit', function(e) {
    e.preventDefault();
    insertarAdministrador();
  });
  // evento para ver los detalles del admin
  document.getElementById('tabla-admins').addEventListener('click', function(e) {
    if (e.target.matches('.ver-admin')) {
      const id = e.target.dataset.id;
      verAdministrador(id);
    }
  });
  // evento para editar los detalles del admin
  document.getElementById('tabla-admins').addEventListener('click', function(e) {
    if (e.target.matches('.editar-admin')) {
      const id = e.target.dataset.id;
      document.getElementById('admin-edit-modal').style.display = 'block';
      document.getElementById('admin-id-edit').value = id;
    }
  });
  // evento para eliminar un admin
  document.getElementById('tabla-admins').addEventListener('click', function(e) {
    if (e.target.matches('.eliminar-admin')) {
      const id = e.target.dataset.id;
      eliminarAdministrador(id);
    }
  });
  // evento para filtrar administradores
  document.getElementById('filtro-admin').addEventListener('input', filtrarAdministradores);
  // evento para cerrar el modal de edición de admin
  document.getElementById('cerrar-edit-modal').addEventListener('click', function() {
    document.getElementById('admin-edit-modal').style.display = 'none';
  });
  // evento para cerrar el modal de eliminación de admin
  document.getElementById('cerrar-eliminar-modal').addEventListener('click', function() {
    document.getElementById('mensaje-eliminar').textContent = '';
  });
  