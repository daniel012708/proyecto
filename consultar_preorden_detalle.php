<?php
session_start();
include 'session_check.php'; // Incluir la verificación del estado del usuario


// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html"); // Redirigir a la página de login si no está autenticado
    exit();
}

include 'PreordenM.php'; // Clase PreOrden

$preOrdenModel = new PreOrden(); // Instancia de la clase PreOrden

// Verificar si se pasó un ID de pre-orden por la URL
if (isset($_GET['id'])) {
    $idPreorden = $_GET['id'];
    $detallesPreorden = $preOrdenModel->obtenerDetallesPreorden($idPreorden);
} else {
    header("Location: consultapreorden.php"); // Redirigir si no se pasó ID
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de la Pre-Orden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            font-family: 'Montserrat', sans-serif;
        }
        .container {
            margin-top: 40px;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }
        h2 {
            font-weight: 600;
            margin-bottom: 30px;
            color: #333;
        }
        .list-group-item {
            background-color: #fafafa;
        }
        .table th {
            background-color: #007bff;
            color: #fff;
        }
        .table tbody tr:hover {
            background-color: #f1f1f1;
        }
        .btn-back {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Detalles de la Pre-Orden <?= $idPreorden ?></h2>

        <?php if (!empty($detallesPreorden)): ?>
            <h3>Información General</h3>
            <ul class="list-group mb-4">
                <li class="list-group-item"><strong>ID de Pre-Orden:</strong> <?= $detallesPreorden[0]['preorden_id'] ?></li>
                <li class="list-group-item"><strong>Fecha de Solicitud:</strong> <?= $detallesPreorden[0]['fecha_solicitud'] ?></li>
                <li class="list-group-item"><strong>Destino:</strong> <?= $detallesPreorden[0]['destino'] ?></li>
                <li class="list-group-item"><strong>Fecha de Entrega:</strong> <?= $detallesPreorden[0]['fecha_entrega'] ?></li>
                <li class="list-group-item"><strong>Método de Entrega:</strong> <?= $detallesPreorden[0]['metodo_entrega'] ?></li>
                <li class="list-group-item"><strong>Método de Pago:</strong> <?= $detallesPreorden[0]['metodo_pago'] ?></li>
                <li class="list-group-item"><strong>Valor Total:</strong> <?= number_format($detallesPreorden[0]['valor_total'], 2) ?> </li>
            </ul>

            <h3>Cliente</h3>
            <ul class="list-group mb-4">
                <li class="list-group-item"><strong>Nombre del Cliente:</strong> <?= $detallesPreorden[0]['nombre_cliente'] ?></li>
                <li class="list-group-item"><strong>Correo Electrónico del Cliente:</strong> <?= $detallesPreorden[0]['correo_cliente'] ?></li>
            </ul>

            <h3>Empleado Logístico</h3>
            <ul class="list-group mb-4">
                <li class="list-group-item"><strong>Nombre del Empleado:</strong> <?= $detallesPreorden[0]['nombre_empleado_logistico'] ?></li>
            </ul>

            <h3>Productos</h3>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detallesPreorden as $detalle): ?>
                        <tr>
                            <td><?= $detalle['nombre_producto'] ?></td>
                            <td><?= $detalle['cantidad'] ?></td>
                            <td><?= number_format($detalle['precio'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>
            <div class="alert alert-danger" role="alert">
                No se encontraron detalles para esta pre-orden.
            </div>
        <?php endif; ?>
    </div>

    <!-- JS de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
