document.addEventListener('DOMContentLoaded', function() {
    loadCart();
});

function loadCart() {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let cartItems = document.getElementById('cartItems');
    let totalAmount = 0;

    cartItems.innerHTML = '';
    cart.forEach(product => {
        if (product.quantity < 1) {
            product.quantity = 1;
        }

        let subtotal = product.price * product.quantity;
        totalAmount += subtotal;

        cartItems.innerHTML += `
            <tr>
                <td><img src="../img/imagenesSubidas/${product.image}" alt="${product.name}" class="cart-img"></td>
                <td>${product.name}</td>
                <td>${product.price}€</td>
                <td>
                    <div class="d-flex justify-content-center align-items-center">
                        <button class="btn btn-warning btn-sm" onclick="updateQuantity(${product.id}, -1)">-</button>
                        <input type="text" class="form-control text-center mx-2" value="${product.quantity}" style="width: 50px;" disabled>
                        <button class="btn btn-warning btn-sm" onclick="updateQuantity(${product.id}, 1)">+</button>
                    </div>
                </td>
                <td>${subtotal.toFixed(2)}€</td>
                <td><button class="btn-delete" onclick="removeFromCart(${product.id})"><img src="../img/Borrar.png" alt="Eliminar"></button></td>
            </tr>
        `;
    });

    document.getElementById('totalAmount').innerText = totalAmount.toFixed(2);
    localStorage.setItem('cart', JSON.stringify(cart));

    // Guardar los datos del carrito en un campo oculto
    document.getElementById('cartData').value = JSON.stringify(cart);
}

function updateQuantity(id, delta) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let product = cart.find(item => item.id === id);

    if (product) {
        product.quantity += delta;
        if (product.quantity < 1) {
            product.quantity = 1;
        }
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    loadCart();
}

function removeFromCart(id) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.filter(item => item.id !== id);

    localStorage.setItem('cart', JSON.stringify(cart));
    loadCart();
}

function clearCart() {
    localStorage.removeItem('cart');
    loadCart();
}