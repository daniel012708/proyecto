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

// Inicializamos la variable para evitar el error
$preOrdenEspecifica = null;

// Si se ha enviado una búsqueda, consulta por ID
if (isset($_GET['id_busqueda']) && !empty($_GET['id_busqueda'])) {
    $idBusqueda = $_GET['id_busqueda'];
    $preOrdenEspecifica = $preOrdenModel->consultarPreOrdenPorIdActiva($idBusqueda); // Consultar la pre-orden por ID
}

// Consultar todas las pre-órdenes activas solo si no hay una búsqueda o si no se encontró la pre-orden
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
</head>
<body>
    <?php include 'migaDePan.php'; ?>

    <div class="container mt-5">
        <h2>Consulta y Actualización de Pre-Ordenes</h2>

        <form method="GET" action="actualizarPreorden.php" class="mb-4">
            <div class="input-group">
                <input type="number" class="form-control" name="id_busqueda" placeholder="Buscar por ID" min="1" value="<?= isset($idBusqueda) ? $idBusqueda : '' ?>">
                <button type="submit" class="btn btn-primary">Buscar</button>
            </div>
        </form>

        <!-- Muestra los resultados de la búsqueda si se ha encontrado una pre-orden específica. -->
        <?php if ($preOrdenEspecifica): ?>
            <h3>Resultado de la Búsqueda</h3>
            <ul class="list-group mb-4">
                <li class="list-group-item"><strong>ID:</strong> <?= $preOrdenEspecifica['id'] ?></li>
                <li class="list-group-item"><strong>Fecha de Solicitud:</strong> <?= $preOrdenEspecifica['fecha_solicitud'] ?></li>
                <li class="list-group-item"><strong>Destino:</strong> <?= $preOrdenEspecifica['destino'] ?></li>
                <li class="list-group-item"><strong>Método de Entrega:</strong> <?= $preOrdenEspecifica['metodo_entrega'] ?></li>
                <li class="list-group-item"><strong>Fecha de Entrega:</strong> <?= $preOrdenEspecifica['fecha_entrega'] ?></li>
                <li class="list-group-item"><strong>Método de Pago:</strong> <?= $preOrdenEspecifica['metodo_pago'] ?></li>
                <li class="list-group-item"><strong>Valor Total:</strong> <?= $preOrdenEspecifica['valor_total'] ?></li>
                <li class="list-group-item">
                    <a href="actualizar_preorden_form.php?id=<?= $preOrdenEspecifica['id'] ?>" class="btn btn-warning">Actualizar Pre-Orden</a>
                </li>
            </ul>
        <?php elseif (isset($idBusqueda)): ?>
            <div class="alert alert-danger" role="alert">
                No se encontró ninguna pre-orden con ese ID.
            </div>
        <?php endif; ?>

        <!-- Mostrar todas las pre-órdenes activas si no se realizó una búsqueda o no se encontró una pre-orden -->
        <?php if (!isset($idBusqueda) || !$preOrdenEspecifica): ?>
            <h3>Pre-Ordenes Activas</h3>
            <?php if (!empty($preOrdenesActivas)): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha de Solicitud</th>
                            <th>Destino</th>
                            <th>Método de Entrega</th>
                            <th>Fecha de Entrega</th>
                            <th>Método de Pago</th>
                            <th>Valor Total</th>
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
                                <td>
                                    <a href="actualizar_preorden_form.php?id=<?= $preOrden['id'] ?>" class="btn btn-warning">Actualizar</a>
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
