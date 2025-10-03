<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Formulario de Venta</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
  <div class="container mt-5">
    <?php 
      if (isset($_GET['status'])) {
        if ($_GET['status'] == 'success') {
          echo '<div class="alert alert-success" role="alert">Venta registrada exitosamente.</div>';
        } elseif ($_GET['status'] == 'error') {
          echo '<div class="alert alert-danger" role="alert">Error al registrar la venta. Inténtalo de nuevo.</div>';
        }
      }
    ?>
    <div class="card shadow">
      <div class="card-header bg-primary text-white">
        <h4>Registro de Venta</h4>
      </div>
      <div class="card-body">
        <form method="POST" action="core/process_sale.php">
          <div class="mb-3">
            <label for="cliente" class="form-label">Nombre del Cliente</label>
            <input type="text" class="form-control" id="cliente" name="cliente" required>
          </div>
          <div class="mb-3">
            <label for="producto" class="form-label">Producto</label>
            <input type="text" class="form-control" id="producto" name="producto" required>
          </div>
          <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" name="cantidad" min="1" required>
          </div>
          <div class="mb-3">
            <label for="precio" class="form-label">Precio Unitario</label>
            <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
          </div>
          <div class="mb-3">
            <label for="metodo" class="form-label">Método de Pago</label>
            <select class="form-select" id="metodo" name="metodo" required>
              <option value="">Selecciona uno</option>
              <option value="efectivo">Efectivo</option>
              <option value="tarjeta">Tarjeta</option>
              <option value="transferencia">Transferencia</option>
            </select>
          </div>
          <button type="submit" class="btn btn-success">Registrar Venta</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>