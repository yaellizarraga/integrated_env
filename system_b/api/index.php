<?php

include '../classes/conexion.php';

try {

    $data = json_decode(file_get_contents('php://input'), true);
    
    $cliente = $data['cliente'];
    $producto = $data['producto'];
    $cantidad = $data['cantidad'];
    $precio = $data['precio'];
    $metodo = $data['metodo'];


    $datos = [
        'cliente' => $cliente,
        'producto' => $producto,
        'cantidad' => $cantidad,
        'precio' => $precio,
        'metodo' => $metodo
    ];

    // insert sale to database mysql
    $conexion = new Conexion();
    $conn = $conexion->conectar();
    $conn->query("INSERT INTO ventas (cliente, producto, cantidad, precio_unitario, metodo_pago) VALUES ('$cliente', '$producto', $cantidad, $precio, '$metodo')");
    $conexion->desconectar($conn);
    echo json_encode(['status' => 1, 'message' => 'Venta registrada correctamente']);
    
} catch (Exception $e) {
    echo json_encode(['status' => 0, 'message' => 'Error al registrar la venta']);
}