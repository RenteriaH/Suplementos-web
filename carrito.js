// Cargar productos del carrito desde localStorage
let carrito = JSON.parse(localStorage.getItem('carrito')) || [];
const productosCarrito = document.getElementById('productos-carrito');

// Función para mostrar el carrito
function mostrarCarrito() {
    productosCarrito.innerHTML = '';  // Limpiar el carrito antes de actualizar
    if (carrito.length === 0) {
        productosCarrito.innerHTML = '<p>No tienes productos en el carrito.</p>';
        document.getElementById('total-amount').textContent = '0.00'; // Mostrar total como $0.00
        document.getElementById('num-carrito').textContent = '0'; // Mostrar número de productos como 0
    } else {
        carrito.forEach(item => {
            const productoDiv = document.createElement('div');
            productoDiv.classList.add('producto-carrito');
            productoDiv.innerHTML = `
                <img src="${item.imagen}" alt="${item.nombre}" class="imagen-producto">
                <p>${item.nombre} - $${item.precio} x <span class="cantidad">${item.cantidad}</span></p>
                <button class="eliminar" data-id="${item.id}">Eliminar uno</button>
            `;
            productosCarrito.appendChild(productoDiv);
        });
    }

    // Actualizar el número de productos en el carrito del menú
        document.getElementById('num-carrito').textContent = carrito.reduce((total, item) => total + item.cantidad, 0);

    // Mostrar el botón de PayPal y pasar el total del carrito
    renderPayPalButton();
}

// Mostrar el carrito al cargar la página
mostrarCarrito();

// Agregar productos al carrito

// Función para agregar productos al carrito
document.querySelectorAll('.add-to-cart').forEach(button => {
    button.addEventListener('click', (event) => {
        // Verifica si el usuario está logueado
        if (!estaLogueado) { // Esta variable ya está definida desde PHP
            // Si no está logueado, redirige a la página de inicio de sesión
            window.location.href = 'acceso.php';  // Redirige al inicio de sesión
            return; // Detener la ejecución
        }

        // Si el usuario está logueado, agrega el producto al carrito
            const productoID = event.target.getAttribute('data-id');
            const productoNombre = event.target.getAttribute('data-nombre');
            const productoPrecio = parseFloat(event.target.getAttribute('data-precio'));
            const productoImagen = event.target.getAttribute('data-imagen');

        // Validación de los datos
        if (!productoID || !productoNombre || isNaN(productoPrecio) || !productoImagen) {
            console.error('Datos de producto inválidos:', { productoID, productoNombre, productoPrecio, productoImagen });
            alert('Hubo un error al agregar el producto al carrito.');
            return;
        }

            // Verifica si el producto ya existe en el carrito
            let productoExistente = carrito.find(item => item.id === productoID);
            if (productoExistente) {
                productoExistente.cantidad++;
            } else {
                carrito.push({ id: productoID, nombre: productoNombre, precio: productoPrecio, imagen: productoImagen, cantidad: 1 });
            }

            // Guarda el carrito en el localStorage
            localStorage.setItem('carrito', JSON.stringify(carrito));

            // Actualiza el número de productos en el carrito
            actualizarNumCarrito();

            alert('Producto agregado al carrito');
        });
    });

// Eliminar un producto del carrito (disminuir cantidad)
productosCarrito.addEventListener('click', (event) => {
    if (event.target.classList.contains('eliminar')) {
        const productoID = event.target.getAttribute('data-id');
        
        // Buscar el producto en el carrito
        const producto = carrito.find(item => item.id === productoID);

        if (producto) {
            if (producto.cantidad > 1) {
                // Si hay más de una unidad, solo disminuir la cantidad
                producto.cantidad--;
            } else {
                // Si solo hay una unidad, eliminar el producto
                carrito = carrito.filter(item => item.id !== productoID);
            }

            // Actualizar el carrito en el localStorage
            localStorage.setItem('carrito', JSON.stringify(carrito));

            // Mostrar el carrito actualizado
            mostrarCarrito();
        }
    }
});

// Función para calcular el total del carrito
function calcularTotal() {
    let total = 0;

    // Sumar el total de los productos
    carrito.forEach(item => {
        // Validar que el precio y la cantidad son números válidos
        const precio = parseFloat(item.precio);
        const cantidad = parseInt(item.cantidad);

        // Verificar que el precio y la cantidad son números válidos
        if (isNaN(precio) || isNaN(cantidad)) {
            console.error("Datos inválidos para el producto:", item.nombre);
            return; // Si los datos son inválidos, omitir este producto
        }

        total += precio * cantidad;
    });

    console.log("Total calculado:", total); // Para depuración

    return total.toFixed(2); // Redondear el total a dos decimales
}

// Función para renderizar el botón de PayPal con el total calculado
function renderPayPalButton() { 
    document.getElementById('paypal-button-container').innerHTML = ''; // Limpiar antes de renderizar
    paypal.Buttons({
        style: {
            color: 'blue',
            shape: 'pill',
            label: 'pay'
        },
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: calcularTotal() // Total calculado del carrito
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(detalles) {
                // Aquí se guarda la transacción y los productos del carrito
                let pagoDetalles = {
                    idTransaccion: detalles.id,
                    total: detalles.purchase_units[0].amount.value,
                    productos: carrito
                };
        
                // Guardar detalles de pago en localStorage para el recibo
                localStorage.setItem('pagoDetalles', JSON.stringify(pagoDetalles));
        
                // Enviar los detalles al servidor (procesarCompra)
                procesarCompra(pagoDetalles);
                
                // Redirigir a la página del recibo
                window.location.href = "recibo.php";
            });
        },
        onCancel: function(data) {
            alert("Pago cancelado");
        }
    }).render('#paypal-button-container'); // Renderiza el botón en el contenedor
}

// Función para enviar los detalles de la compra al backend
function procesarCompra(pagoDetalles) {
    fetch('procesar_compra.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(pagoDetalles) // Enviar los detalles de la compra en formato JSON
    })
    .then(response => response.json())
    .then(data => {
        console.log(data);  // Verifica los datos recibidos del servidor
        if (data.status === "success") {
            window.location.href = data.redirect;  // Asegúrate de redirigir aquí
        } else {
            alert("Error al procesar la compra: " + data.message);
        }
    })
    .catch(error => {
        console.error('Error al enviar los datos:', error);
        alert('Hubo un problema al procesar la compra.');
    });
}

//Hola soy checkpoint