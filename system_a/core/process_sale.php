<?php 

// Este token deberia estar guardado en un lugar seguro como un .env escondido jeje
const TOKEN_SECRETO = 'mi-token-super-secreto-123';

try {
    $cliente = $_POST['cliente'];
    $producto = $_POST['producto'];
    $cantidad = $_POST['cantidad'];

    $datos = [
    'cliente' => $cliente,
    'producto' => $producto,
    'cantidad' => $cantidad,
    'precio' => $_POST['precio'],
    'metodo' => $_POST['metodo']
    ];
    $options = [
        'location' => 'http://localhost:3000/soap',
        'uri' => 'http://localhost:3000/venta',
        'stream_context' => stream_context_create([
            'http' => [
                'header' => "authorization: " . TOKEN_SECRETO . "\r\n"
            ]
        ])
    ];

    $soap = new SoapClient("http://localhost:3000/wsdl", $options);
    $response = $soap->registrarVenta($datos);
    header("Location: ../index.php?status=success");
} catch (Exception $e) {
    header("Location: ../index.php?status=error");
}

