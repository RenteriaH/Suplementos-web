document.getElementById('registerForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Evitar el envío del formulario si hay errores

    // Obtener los valores de los campos
    const usuario = document.querySelector('[name="usuario"]').value.trim();
    const contraseña = document.querySelector('[name="contraseña"]').value.trim();
    const email = document.querySelector('[name="email"]').value.trim();
    const telefono = document.querySelector('[name="telefono"]').value.trim();

    // Contenedor para mostrar los errores
    const mensajes = document.getElementById('mensajes');
    mensajes.innerHTML = ''; // Limpiar mensajes anteriores
    let errores = [];

    // Validar cada campo
    if (!usuario) {
        errores.push('El campo usuario es obligatorio.');
    } else if (/[^a-zA-Z0-9]/.test(usuario)) {
        errores.push('El usuario solo puede contener letras y números.');
    }

    if (!contraseña) {
        errores.push('El campo contraseña es obligatorio.');
    } else if (!/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/.test(contraseña)) {
        errores.push('La contraseña debe tener al menos 6 caracteres, una letra y un número.');
    }

    if (!email) {
        errores.push('El campo email es obligatorio.');
    } else if (!/^\S+@\S+\.\S+$/.test(email)) {
        errores.push('El formato del correo electrónico no es válido.');
    }

    if (!telefono) {
        errores.push('El campo teléfono es obligatorio.');
    } else if (!/^\d{10}$/.test(telefono)) {
        errores.push('El teléfono debe contener 10 dígitos.');
    }

    // Mostrar errores si los hay
    if (errores.length > 0) {
        errores.forEach(error => {
            const p = document.createElement('p');
            p.textContent = error;
            p.classList.add('error');
            mensajes.appendChild(p);
        });
        return; // No continuar con el envío del formulario
    }

    // Si no hay errores, enviar el formulario
    e.target.submit();
});