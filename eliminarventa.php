<?php
session_start();
include 'session_check.php'; // Incluir la verificación del estado del usuario
include 'migaDePan.php';

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html"); // Redirigir a la página de login si no está autenticado
    exit();
}

include 'PreordenM.php'; // Incluir la clase Venta

$ventaModel = new PreOrden(); // Instanciar la clase Venta

$ventaModel = new PreOrden(); // Instanciar la clase Venta
$host = 'localhost'; // Cambia esto por el host de tu base de datos
$dbname = 'gafra';   // Cambia esto por el nombre de tu base de datos
$user = 'root';      // Cambia esto por tu usuario

    // Crear la conexión PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
// Si se ha enviado una búsqueda, consulta por ID
$ventaEspecifica = null;
if (isset($_GET['id_busqueda'])) {
    $idBusqueda = $_GET['id_busqueda'];
    $ventaEspecifica = $ventaModel->consultarVentaPorId($idBusqueda); // Consultar la venta por ID
}

// Si se recibe una solicitud para eliminar (cambiar estado a inactivo)
if (isset($_GET['eliminar'])) {
    $idVenta = $_GET['eliminar'];
    $ventaModel->eliminarVenta($idVenta); // Cambiar el estado de la venta a 'inactivo'
    header("Location: eliminarVenta.php?success=true");
    exit();
}

// Consultar todas las ventas activas si no hay búsqueda específica
if (!$ventaEspecifica) {
    $stmt = $pdo->prepare("CALL consultar_ventas_activas()");
    $stmt->execute();
    $ventasActivas = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eliminar Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2>Eliminar Ventas Activas</h2>

        <?php if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
            <div class="alert alert-success" role="alert">
                La venta se ha eliminado correctamente (cambiado a estado inactivo).
            </div>
        <?php endif; ?>

        <!-- Formulario de búsqueda -->
        <form method="GET" action="eliminarVenta.php" class="mb-4">
            <div class="input-group">
                <input type="number" class="form-control" name="id_busqueda" placeholder="Buscar por ID de Venta" min="1" value="<?= isset($idBusqueda) ? $idBusqueda : '' ?>" required>
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>

        <!-- Mostrar el resultado de la búsqueda -->
        <?php if ($ventaEspecifica): ?>
            <h3>Resultado de la Búsqueda</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha de Venta</th>
                        <th>Método de Pago</th>
                        <th>Valor Total</th>
                        <th>Restante</th>
                        <th>Cantidad Productos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $ventaEspecifica['id'] ?></td>
                        <td><?= $ventaEspecifica['fecha_venta'] ?></td>
                        <td><?= $ventaEspecifica['metodo_pago'] ?></td>
                        <td><?= $ventaEspecifica['valor_total'] ?></td>
                        <td><?= $ventaEspecifica['restante'] ?></td>
                        <td><?= $ventaEspecifica['cantidad_productos'] ?></td>
                        <td>
                            <a href="eliminarVenta.php?eliminar=<?= $ventaEspecifica['id'] ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar esta venta?');">Eliminar</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php elseif (isset($idBusqueda)): ?>
            <div class="alert alert-danger" role="alert">
                No se encontró ninguna venta con ese ID.
            </div>
        <?php endif; ?>

        <!-- Mostrar todas las ventas activas solo si no se realiza una búsqueda -->
        <?php if (!isset($idBusqueda) || !$ventaEspecifica): ?>
            <h3>Ventas Activas</h3>
            <?php if (!empty($ventasActivas)): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha de Venta</th>
                            <th>Método de Pago</th>
                            <th>Valor Total</th>
                            <th>Restante</th>
                            <th>Cantidad Productos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($ventasActivas as $venta): ?>
                            <tr>
                                <td><?= $venta['id'] ?></td>
                                <td><?= $venta['fecha_venta'] ?></td>
                                <td><?= $venta['metodo_pago'] ?></td>
                                <td><?= $venta['valor_total'] ?></td>
                                <td><?= $venta['restante'] ?></td>
                                <td><?= $venta['cantidad_productos'] ?></td>
                                <td>
                                    <a href="eliminarVenta.php?eliminar=<?= $venta['id'] ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar esta venta?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay ventas activas.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>
