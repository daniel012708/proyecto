<?php

// Iniciar la sesión
session_start();
include 'session_check.php'; // Incluir la verificación del estado del usuario


// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html"); // Redirigir a la página de login si no está autenticado
    exit();
}

include 'productoM.php'; // Incluimos la clase Producto

$productoModel = new Producto();

// Verificamos si se busca un producto por ID
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $producto = $productoModel->Consultar($_POST['id']);
} else {
    // Si no se ha buscado ningún producto por ID, mostramos todos los productos
    $productos = $productoModel->ConsultarTodos();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Productos</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f4f7fa;
        }
        
        .navbar {
            background-color: #1746A2;
            padding: 10px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand img {
            width: 50px;
        }

        .navbar-nav {
            flex-direction: row;
            gap: 20px;
        }

        .nav-link {
            color: #fff !important;
            padding: 8px 12px;
            transition: color 0.3s ease;
            font-weight: bold;
            font-size: 16px;
        }

        .nav-link:hover {
            color: #d4d9f2 !important;
        }

        .table-container {
            margin-top: 70px;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table {
            border-collapse: separate;
            border-spacing: 0 15px;
        }

        .table-striped tbody tr {
            transition: all 0.3s ease;
        }

        .table-striped tbody tr:hover {
            background-color: #f1f3f8;
        }

        .table thead th {
            background-color: #1746A2;
            color: white;
            border: none;
            border-radius: 10px 10px 0 0;
        }

        .table td, .table th {
            border: none;
            padding: 15px;
            text-align: center;
        }

        .form-inline input[type="number"] {
            width: 200px;
            margin-right: 10px;
        }

        .card {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">
            <img src="logo-white.JPG" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link back-button" href="javascript:void(0);" onclick="history.back();">Regresar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container table-container">
        <h2 class="text-center mb-4">Consulta de Productos</h2>

        <!-- Formulario para buscar por ID -->
        <form action="" method="POST" class="form-inline justify-content-center mb-4">
            <input type="number" name="id" class="form-control" placeholder="Buscar por ID" required>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <!-- Mostrar el producto encontrado por ID -->
        <?php if (isset($producto)): ?>
            <?php if ($producto): ?>
                <div class="card">
                    <h3 class="card-title">Producto encontrado:</h3>
                    <p><strong>ID:</strong> <?= $producto['id'] ?></p>
                    <p><strong>Nombre:</strong> <?= $producto['nombre_producto'] ?></p>
                    <p><strong>Color:</strong> <?= $producto['color'] ?></p>
                    <p><strong>Descripción:</strong> <?= $producto['descripcion'] ?></p>
                    <p><strong>Valor:</strong> <?= $producto['valor'] ?></p>
                    <p><strong>Cantidad en Bodega:</strong> <?= $producto['cantidad_bodega'] ?></p>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">No se encontró ningún producto con ese ID.</div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Mostrar todos los productos si no se ha buscado por ID -->
        <?php if (!isset($producto)): ?>
            <h3 class="text-center mb-3">Lista de Productos</h3>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Color</th>
                        <th>Descripción</th>
                        <th>Valor</th>
                        <th>Cantidad en Bodega</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?= $producto['id'] ?></td>
                            <td><?= $producto['nombre_producto'] ?></td>
                            <td><?= $producto['color'] ?></td>
                            <td><?= $producto['descripcion'] ?></td>
                            <td><?= $producto['valor'] ?></td>
                            <td><?= $producto['cantidad_bodega'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Bootstrap JS y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
