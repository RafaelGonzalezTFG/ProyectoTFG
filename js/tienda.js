function addToCart(id, name, price, image) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    let product = cart.find(item => item.id === id);

    if (product) {
        product.quantity += 1;
    } else {
        cart.push({
            id,
            name,
            price,
            image,
            quantity: 1
        });
    }

    localStorage.setItem('cart', JSON.stringify(cart));
    alert('Producto añadido al carrito');
}

function verDetalles(id) {
    window.location.href = `detalles_producto.php?id=${id}`;
}