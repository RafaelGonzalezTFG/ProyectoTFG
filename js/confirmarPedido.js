document.getElementById('purchaseForm').addEventListener('submit', function(event) {
    event.preventDefault();

    const productInputs = document.querySelectorAll('input[name="idProductos[]"]');
    const quantityInputs = document.querySelectorAll('input[name="cantidades[]"]');
    const productIds = [];
    const productQuantities = [];

    productInputs.forEach(function(input) {
        productIds.push(input.value);
    });

    quantityInputs.forEach(function(input) {
        productQuantities.push(input.value);
    });

    document.getElementById('productIds').value = productIds.join(',');
    document.getElementById('productQuantities').value = productQuantities.join(',');

    // Verificar que totalFactura tenga un valor antes de enviar el formulario
    const totalFactura = document.getElementById('totalFactura').value;
    if (totalFactura === "") {
        alert("El total de la factura no está presente.");
        return;
    }

    // Limpiar el carrito en localStorage
    localStorage.removeItem('cart');

    this.submit();
});