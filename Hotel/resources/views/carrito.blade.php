<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito Unity</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding-top: 50px;
            background-color: #2b3035;
            color: white;
        }

        .btn-abrir {
            padding: 15px 30px;
            font-size: 18px;
            cursor: pointer;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
        }

        .btn-abrir:hover {
            background-color: #218838;
        }

        .modal-fondo {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
        }

        .modal-contenido {
            background: white;
            color: black;
            width: 400px;
            margin: 100px auto;
            padding: 20px;
            border-radius: 8px;
            text-align: left;
        }

        .btn-cerrar {
            background: #dc3545;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            width: 100%;
            margin-top: 15px;
            border-radius: 5px;
        }

        .producto {
            border-bottom: 1px solid #ccc;
            padding: 10px 0;
        }

        .total {
            font-size: 20px;
            font-weight: bold;
            margin-top: 15px;
            text-align: right;
            color: red;
        }
    </style>
</head>

<body>

    <h1>Carrito recibido desde Unity</h1>
    <button class="btn-abrir" onclick="abrirCarrito()">🛒 Ver Carrito</button>

    <div id="miCarrito" class="modal-fondo">
        <div class="modal-contenido">
            <h2>Tu Pedido</h2>
            <div id="lista-productos">
                @php $total_pagar = 0; @endphp

                @if(count($carrito) > 0)
                    @foreach($carrito as $producto)
                        @php
                            $subtotal = $producto['precio'] * $producto['cantidad'];
                            $total_pagar += $subtotal;
                        @endphp
                        <div class="producto">
                            <strong>{{ $producto['nombre'] }}</strong><br>
                            Cant: {{ $producto['cantidad'] }} |
                            Precio: ${{ $producto['precio'] }} |
                            Subtotal: ${{ $subtotal }}
                        </div>
                    @endforeach
                    <div class="total">
                        Total a Pagar: ${{ $total_pagar }}
                    </div>
                @else
                    <p>No hay productos en el carrito</p>
                @endif
            </div>
            <button class="btn-cerrar" onclick="cerrarCarrito()">Cerrar Carrito</button>
        </div>
    </div>

    <script>
        function abrirCarrito() { document.getElementById('miCarrito').style.display = 'block'; }
        function cerrarCarrito() { document.getElementById('miCarrito').style.display = 'none'; }
    </script>

</body>
</html>