<?php
// Iniciar la sesión para poder usar las variables de sesión
session_start();

include 'session_check.php'; // Incluir un archivo que verifica si el usuario está activo o la sesión sigue válida

// Verificar si el usuario ha iniciado sesión, si no, redirigirlo a la página de inicio de sesión
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html"); // Redirigir a la página de login si el usuario no está autenticado
    exit(); // Detener la ejecución del código
}

include 'productoM.php'; // Incluir el archivo que contiene la clase Producto

// Crear una instancia de la clase Producto para consultar todos los productos
$productoModel = new Producto();
$productos = $productoModel->ConsultarTodos(); // Llamar a la función para obtener la lista de productos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Productos</title>
    <!-- Incluir Bootstrap para el diseño del frontend -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Incluir Font Awesome para los iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Estilos CSS personalizados para el diseño */
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
            width: 50px; /* Tamaño del logo */
        }

        .navbar-nav {
            flex-direction: row;
            gap: 20px; /* Espacio entre los enlaces */
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Sombra de la tabla */
        }

        .table {
            border-collapse: separate;
            border-spacing: 0 15px; /* Espacio entre las filas de la tabla */
        }

        .table-striped tbody tr {
            transition: all 0.3s ease; /* Efecto de transición en el hover */
        }

        .table-striped tbody tr:hover {
            background-color: #f1f3f8; /* Color de fondo al hacer hover */
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
            text-align: center; /* Centrar el texto en las celdas */
        }

        .btn-warning {
            background-color: #ffc107;
            color: #212529;
            transition: background-color 0.3s ease, transform 0.2s;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            transform: translateY(-2px); /* Animación de botón */
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <!-- Logo del sitio -->
        <a class="navbar-brand" href="#">
            <img src="logo-white.JPG" alt="Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <!-- Enlaces de navegación -->
                <li class="nav-item">
                    <a class="nav-link" href="Consultaproducto.php">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registroproducto.php">Agregar Producto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link back-button" href="javascript:void(0);" onclick="history.back();">Regresar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a> <!-- Cerrar sesión del usuario -->
                </li>
                <!-- Enlace al panel de inicio -->
                <li class="nav-item">
                    <a class="nav-link" href="panel.php">
                        <i class="fas fa-home"></i> Inicio
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Contenedor principal donde se mostrará la tabla de productos -->
    <div class="container table-container">
        <h2 class="text-center mb-4">Lista de Productos</h2>

        <!-- Comprobamos si hay productos disponibles -->
        <?php if (isset($productos) && count($productos) > 0): ?>
            <!-- Crear tabla para mostrar productos -->
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Color</th>
                        <th>Descripción</th>
                        <th>Valor</th>
                        <th>Cantidad en Bodega</th>
                        <th>Acciones</th> <!-- Columna para acciones, como el botón de actualizar -->
                    </tr>
                </thead>
                <tbody>
                    <!-- Recorrer cada producto y mostrar sus datos en la tabla -->
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?= $producto['id'] ?></td>
                            <td><?= $producto['nombre_producto'] ?></td>
                            <td><?= $producto['color'] ?></td>
                            <td><?= $producto['descripcion'] ?></td>
                            <td><?= $producto['valor'] ?></td>
                            <td><?= $producto['cantidad_bodega'] ?></td>
                            <td>
                                <!-- Botón para actualizar el producto -->
                                <form action="actualizarProducto.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $producto['id'] ?>"> <!-- Enviar el ID del producto para actualizar -->
                                    <button type="submit" class="btn btn-warning">Actualizar</button> <!-- Botón para actualizar -->
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <!-- Si no hay productos, mostrar un mensaje de información -->
            <div class="alert alert-info">No hay productos disponibles.</div>
        <?php endif; ?>
    </div>

    <!-- Incluir archivos JS de Bootstrap y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
