function increment() {
    const quantity = document.getElementById('quantity');
    quantity.value = parseInt(quantity.value) + 1;
}

function decrement() {
    const quantity = document.getElementById('quantity');
    if (quantity.value > 1) {
        quantity.value = parseInt(quantity.value) - 1;
    }
}

function addToCart(id, name, price, image) {
    const quantity = parseInt(document.getElementById('quantity').value);

    if (quantity < 1) {
        alert('Cantidad inválida. Por favor, selecciona una cantidad mayor a 0.');
        return;
    }

    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let product = cart.find(item => item.id === id);

    if (product) {
        product.quantity += quantity;
    } else {
        cart.push({ id, name, price, image, quantity });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    alert('Producto añadido al carrito');
}
