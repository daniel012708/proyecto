<?php
session_start();
include 'session_check.php'; // Incluir la verificación del estado del usuario


// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html");
    exit();
}

// Conexión directa a la base de datos (sin incluir un archivo externo)
$host = 'localhost'; // Cambia esto por el host de tu base de datos
$dbname = 'gafra';   // Cambia esto por el nombre de tu base de datos
$user = 'root';      // Cambia esto por tu usuario

try {
    // Crear la conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Si se envía un ID de búsqueda, buscamos una venta específica
    $ventaEspecifica = null;
    if (isset($_GET['id_busqueda'])) {
        $idBusqueda = $_GET['id_busqueda'];
        // Consulta para una venta específica
        $stmt = $pdo->prepare("SELECT * FROM venta WHERE id = :id AND estado_venta = 'activo'");
        $stmt->bindParam(':id', $idBusqueda, PDO::PARAM_INT);
        $stmt->execute();
        $ventaEspecifica = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Si no se ha buscado una venta específica, mostrar todas las ventas activas
    if (!$ventaEspecifica) {
        $stmt = $pdo->prepare("CALL consultar_ventas_activas()");
        $stmt->execute();
        $ventasActivas = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

} catch (PDOException $e) {
    echo "Error al consultar las ventas activas: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas Activas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <?php include 'migaDePan.php'; ?>

<div class="container mt-5">
    <h2 class="text-center">Ventas Activas</h2>

    <!-- Formulario para buscar una venta por ID -->
    <form method="GET" action="consultaventas.php" class="mb-4">
        <div class="input-group">
            <input type="number" class="form-control" name="id_busqueda" placeholder="Buscar por ID de Venta" min="1" required>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </div>
    </form>

    <!-- Si se buscó una venta específica, mostrarla aquí -->
    <?php if ($ventaEspecifica): ?>
        <h3>Resultado de la Búsqueda</h3>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID Venta</th>
                    <th>ID Preorden</th>
                    <th>Fecha de Venta</th>
                    <th>Método de Pago</th>
                    <th>Valor Total</th>
                    <th>Restante</th>
                    <th>Cantidad Productos</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= htmlspecialchars($ventaEspecifica['id']) ?></td>
                    <td><?= htmlspecialchars($ventaEspecifica['id_preorden']) ?></td>
                    <td><?= htmlspecialchars($ventaEspecifica['fecha_venta']) ?></td>
                    <td><?= htmlspecialchars($ventaEspecifica['metodo_pago']) ?></td>
                    <td><?= htmlspecialchars($ventaEspecifica['valor_total']) ?></td>
                    <td><?= htmlspecialchars($ventaEspecifica['restante']) ?></td>
                    <td><?= htmlspecialchars($ventaEspecifica['cantidad_productos']) ?></td>
                    <td><?= htmlspecialchars($ventaEspecifica['estado_venta']) ?></td>
                </tr>
            </tbody>
        </table>
    <?php elseif (isset($idBusqueda)): ?>
        <!-- Mostrar alerta si no se encontró la venta -->
        <div class="alert alert-danger" role="alert">
            No se encontró ninguna venta con ese ID.
        </div>
    <?php endif; ?>

    <!-- Mostrar todas las ventas activas solo si no hay búsqueda o no se encontró una venta específica -->
    <?php if (!isset($idBusqueda) || !$ventaEspecifica): ?>
        <?php if (!empty($ventasActivas)): ?>
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID Venta</th>
                        <th>ID Preorden</th>
                        <th>Fecha de Venta</th>
                        <th>Método de Pago</th>
                        <th>Valor Total</th>
                        <th>Restante</th>
                        <th>Cantidad Productos</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventasActivas as $venta): ?>
                        <tr>
                            <td><?= htmlspecialchars($venta['id']) ?></td>
                            <td><?= htmlspecialchars($venta['id_preorden']) ?></td>
                            <td><?= htmlspecialchars($venta['fecha_venta']) ?></td>
                            <td><?= htmlspecialchars($venta['metodo_pago']) ?></td>
                            <td><?= htmlspecialchars($venta['valor_total']) ?></td>
                            <td><?= htmlspecialchars($venta['restante']) ?></td>
                            <td><?= htmlspecialchars($venta['cantidad_productos']) ?></td>
                            <td><?= htmlspecialchars($venta['estado_venta']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No hay ventas activas en este momento.</p>
        <?php endif; ?>
    <?php endif; ?>
</div>

</body>
</html>
