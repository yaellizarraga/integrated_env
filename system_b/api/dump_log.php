<?php

include '../classes/conexion_fake_ace.php';

try {

    $data = json_decode(file_get_contents('php://input'), true);

    
        $action = $data['action'];
        $ip = $_SERVER['REMOTE_ADDR'];
        $registered = date('Y-m-d H:i:s');
        $token = $data['token'];
    

    // insert sale to database mysql
    $conexion = new Conexion();
    $conn = $conexion->conectar();
    $conn->query("INSERT INTO trace_log (token, registered, ip, action) VALUES ('$token','$registered', '$ip', '$action')");
    $conexion->desconectar($conn);
    echo json_encode(['status' => 1, 'message' => 'Log registrado correctamente']);
    
} catch (Exception $e) {
    echo json_encode(['status' => 0, 'message' => 'Error al registrar el log']);
}