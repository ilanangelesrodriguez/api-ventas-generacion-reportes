<!DOCTYPE html>
<html>
<head>
    <title>Resumen de su Compra</title>
</head>
<body>
<h1>¡Gracias por su compra!</h1>
<p>A continuación, encontrará un resumen de su pedido:</p>

<ul>
    @foreach ($saleDetails['products'] as $product)
        <li>{{ $product['name'] }} - Cantidad: {{ $product['quantity'] }} - Precio: ${{ number_format($product['price'], 2) }}</li>
    @endforeach
</ul>

<p><strong>Total: ${{ number_format($saleDetails['total_amount'], 2) }}</strong></p>
</body>
</html>
