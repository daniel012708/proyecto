<?php
session_start();
include 'session_check.php'; // Incluir la verificación del estado del usuario

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html");
    exit();
}

include 'PreordenM.php'; // Incluir la clase PreOrden

$preOrdenModel = new PreOrden(); // Instancia de la clase PreOrden

// Si se ha enviado una búsqueda, consulta por ID
$preOrdenEspecifica = null;
if (isset($_GET['id_busqueda'])) {
    $idBusqueda = $_GET['id_busqueda'];
    $preOrdenEspecifica = $preOrdenModel->consultarPreOrdenPorIdActiva($idBusqueda); // Consultar la pre-orden por ID
}

// Consultar todas las pre-órdenes activas solo si no hay una búsqueda
if (!$preOrdenEspecifica) {
    $preOrdenesActivas = $preOrdenModel->consultarTodasPreOrdenesActivas();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Pre-Ordenes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .table-dark th {
            background-color: #343a40;
            color: white;
            text-align: center;
        }
        .table-hover tbody tr:hover {
            background-color: #f1f1f1;
        }
        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }
        .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        .table td, .table th {
            vertical-align: middle;
            text-align: center;
        }
        .btn-space {
            margin-bottom: 10px;
        }
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 10px; /* Espaciado entre botones */
        }
        .badge-success {
            font-size: 1rem;
            padding: 0.5rem;
            color: white;
            background-color: green;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <?php include 'migaDePan.php'; ?>

    <div class="container mt-5">
        <!-- Mostrar alerta si hay algún error -->
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_GET['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <h2 class="text-center">Consulta de Pre-Ordenes</h2>

        <!-- Formulario para buscar por ID -->
        <form method="GET" action="consultapreorden.php" class="mb-4">
            <div class="input-group">
                <input type="number" class="form-control" name="id_busqueda" placeholder="Buscar por ID" min="1" value="<?= isset($idBusqueda) ? $idBusqueda : '' ?>" required>
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>

        <!-- Si se buscó una pre-orden específica, se muestra aquí -->
        <?php if ($preOrdenEspecifica): ?>
            <h3>Resultado de la Búsqueda</h3>
            <!-- Mostrar la pre-orden específica en una tabla -->
            <table class="table table-striped table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Fecha de Solicitud</th>
                        <th>Destino</th>
                        <th>Método de Entrega</th>
                        <th>Fecha de Entrega</th>
                        <th>Método de Pago</th>
                        <th>Valor Total</th>
                        <th>Abono</th>
                        <th>Restante</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?= $preOrdenEspecifica['id'] ?></td>
                        <td><?= $preOrdenEspecifica['fecha_solicitud'] ?></td>
                        <td><?= $preOrdenEspecifica['destino'] ?></td>
                        <td><?= $preOrdenEspecifica['metodo_entrega'] ?></td>
                        <td><?= $preOrdenEspecifica['fecha_entrega'] ?></td>
                        <td><?= $preOrdenEspecifica['metodo_pago'] ?></td>
                        <td><?= $preOrdenEspecifica['valor_total'] ?></td>
                        <td><?= $preOrdenEspecifica['abono'] ?></td>
                        <td><?= $preOrdenEspecifica['valor_total'] - $preOrdenEspecifica['abono'] ?></td>
                        <td class="action-buttons">
                            <!-- Botón para consultar los detalles de la pre-orden -->
                            <a href="consultar_preorden_detalle.php?id=<?= $preOrdenEspecifica['id'] ?>" class="btn btn-info btn-space">Ver Detalles</a>

                            <!-- Comprobar si la venta ya está autorizada -->
                            <?php if ($preOrdenEspecifica['estado_venta'] === 'pendiente'): ?>
                                <!-- Mostrar botón de autorizar si la venta está pendiente -->
                                <form action="autorizarVenta.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id_preorden" value="<?= $preOrdenEspecifica['id'] ?>">
                                    <button type="submit" class="btn btn-success">Autorizar Venta</button>
                                </form>
                            <?php else: ?>
                                <!-- Mostrar mensaje de venta autorizada si ya está autorizada -->
                                <span class="badge badge-success">Venta Autorizada</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php elseif (isset($idBusqueda)): ?>
            <!-- Alerta si no se encuentra la pre-orden -->
            <div class="alert alert-danger" role="alert">
                No se encontró ninguna pre-orden con ese ID.
            </div>
        <?php endif; ?>

        <!-- Tabla de todas las pre-órdenes activas, solo se muestra si no hay búsqueda o si la búsqueda falló -->
        <?php if (!isset($idBusqueda) || !$preOrdenEspecifica): ?>
            
            <?php if (!empty($preOrdenesActivas)): ?>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Fecha de Solicitud</th>
                            <th>Destino</th>
                            <th>Método de Entrega</th>
                            <th>Fecha de Entrega</th>
                            <th>Método de Pago</th>
                            <th>Valor Total</th>
                            <th>Abono</th>
                            <th>Restante</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($preOrdenesActivas as $preOrden): ?>
                            <tr>
                                <td><?= $preOrden['id'] ?></td>
                                <td><?= $preOrden['fecha_solicitud'] ?></td>
                                <td><?= $preOrden['destino'] ?></td>
                                <td><?= $preOrden['metodo_entrega'] ?></td>
                                <td><?= $preOrden['fecha_entrega'] ?></td>
                                <td><?= $preOrden['metodo_pago'] ?></td>
                                <td><?= $preOrden['valor_total'] ?></td>
                                <td><?= $preOrden['abono'] ?></td>
                                <td><?= $preOrden['valor_total'] - $preOrden['abono'] ?></td>
                                <td class="action-buttons">
                                    <!-- Botón para consultar los detalles de la pre-orden -->
                                    <a href="consultar_preorden_detalle.php?id=<?= $preOrden['id'] ?>" class="btn btn-info btn-space">Ver Detalles</a>

                                    <!-- Comprobar si la venta ya está autorizada -->
                                    <?php if ($preOrden['estado_venta'] === 'pendiente'): ?>
                                        <!-- Mostrar botón de autorizar si la venta está pendiente -->
                                        <form action="autorizarVenta.php" method="POST" class="d-inline">
                                            <input type="hidden" name="id_preorden" value="<?= $preOrden['id'] ?>">
                                            <button type="submit" class="btn btn-success">Autorizar Venta</button>
                                        </form>
                                    <?php else: ?>
                                        <!-- Mostrar mensaje de venta autorizada si ya está autorizada -->
                                        <span class="badge badge-success">Venta Autorizada</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No hay pre-órdenes activas.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</body>
</html>

