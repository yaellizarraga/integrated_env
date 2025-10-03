<?php 

include 'classes/conexion.php';

$conexion = new Conexion();
$conn = $conexion->conectar();
$result = $conn->query("SELECT * FROM ventas");
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
$conexion->desconectar($conn);

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Ventas Registradas</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <div class="card shadow">
      <div class="card-header bg-success text-white">
        <h4>Ventas Registradas</h4>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-hover table-striped">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Cliente</th>
              <th>Producto</th>
              <th>Cantidad</th>
              <th>Precio Unitario</th>
              <th>Método de Pago</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <!-- Aquí se insertan dinámicamente las filas -->
            <?php 
              foreach ($data as $row) {
            ?>
            <tr>
              <td><?php echo $row['id_venta']; ?></td>
              <td><?php echo htmlspecialchars($row['cliente']); ?></td>
              <td><?php echo htmlspecialchars($row['producto']); ?></td>
              <td><?php echo $row['cantidad']; ?></td>
              <td><?php echo number_format($row['precio_unitario'], 2); ?></td>
              <td><?php echo htmlspecialchars($row['metodo_pago']); ?></td>
              <td><?php echo number_format($row['cantidad'] * $row['precio_unitario'], 2); ?></td>
            </tr>
            <?php } ?>
            <!-- Puedes usar PHP, Python, JS para renderizar más filas -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</body>
</html>