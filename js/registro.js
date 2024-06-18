document.getElementById('registroForm').addEventListener('submit', function (event) {
    event.preventDefault();
    let isValid = true;

    // Limpiar errores previos
    document.querySelectorAll('.error').forEach(error => error.textContent = '');

    // Validar Nombre
    const nombre = document.getElementById('Nombre').value.trim();
    if (nombre === '') {
        document.getElementById('errorNombre').textContent = 'El nombre es obligatorio.';
        isValid = false;
    }

    // Validar Apellido
    const apellido = document.getElementById('Apellido').value.trim();
    if (apellido === '') {
        document.getElementById('errorApellido').textContent = 'El apellido es obligatorio.';
        isValid = false;
    }

    // Validar Teléfono
    const telefono = document.getElementById('Telefono').value.trim();
    if (telefono === '') {
        document.getElementById('errorTelefono').textContent = 'El teléfono es obligatorio.';
        isValid = false;
    } else if (!/^\d{9}$/.test(telefono)) {
        document.getElementById('errorTelefono').textContent = 'El teléfono debe tener 10 dígitos.';
        isValid = false;
    }

    // Validar Correo Electrónico
    const correo = document.getElementById('Correo').value.trim();
    if (correo === '') {
        document.getElementById('errorCorreo').textContent = 'El correo electrónico es obligatorio.';
        isValid = false;
    } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correo)) {
        document.getElementById('errorCorreo').textContent = 'El formato del correo electrónico no es válido.';
        isValid = false;
    }

    // Validar Contraseña
    const contrasena = document.getElementById('Contrasena').value.trim();
    if (contrasena === '') {
        document.getElementById('errorContrasena').textContent = 'La contraseña es obligatoria.';
        isValid = false;
    } else if (contrasena.length < 8) {
        document.getElementById('errorContrasena').textContent = 'La contraseña debe tener al menos 8 caracteres.';
        isValid = false;
    }
});