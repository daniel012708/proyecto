<?php
// Iniciar la sesión
session_start();
include 'session_check.php'; // Incluir la verificación del estado del usuario


// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html"); // Redirigir a la página de login si no está autenticado
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Producto</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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

        .contact-btn {
            background-color: #FFD84C;
            color: #1a2a33;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            border: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .contact-btn:hover {
            background-color: #f8c542;
            transform: scale(1.1);
        }

        .form-container {
            margin-top: 70px;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
                    <a class="nav-link" href="Consultaproducto.php">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registroproducto.php">Agregar Producto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link back-button" href="javascript:void(0);" onclick="history.back();">Regresar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                </li>
                <!-- Botón de Inicio -->
                <li class="nav-item">
                    <a class="nav-link" href="panel.php">
                        <i class="fas fa-home"></i> Inicio
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container form-container">
        <h2 class="text-center mb-4">Registrar Producto</h2>
        <form action="controladorproductos.php" method="POST">
            <div class="mb-3">
                <label for="nombre_producto" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" required>
            </div>
            <div class="mb-3">
                <label for="color" class="form-label">Color</label>
                <input type="text" class="form-control" id="color" name="color" required>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="valor" class="form-label">Valor</label>
                <input type="number" class="form-control" id="valor" name="valor" required>
            </div>
            <div class="mb-3">
                <label for="cantidad_bodega" class="form-label">Cantidad en Bodega</label>
                <input type="number" class="form-control" id="cantidad_bodega" name="cantidad_bodega" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Registrar Producto</button>
        </form>
    </div>

    <!-- Bootstrap JS y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
