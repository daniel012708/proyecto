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
    <title>Panel de Administración</title>
    <!-- CSS de Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f6fa;
        }

        /* Contenedor del logo y barra de navegación */
        .navbar-custom {
            background: linear-gradient(to right, #d5d5d7, #A3C1D4, #067DB7); 
            color: #ffffff; /* Color del texto, opcional */
            background-color: #067DB7;
            padding: 0 20px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar-custom .logo img {
            width: 150px;
            height: auto;
        }

        .logout {
            color: #fff;
            font-weight: bold;
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 5px;

        }


        /* Estilos de tarjetas */
        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            padding: 30px;
            text-align: center;
            width: 100%; /* Aumentar el tamaño de las tarjetas */
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .card h3 {
            font-size: 1.8rem;
            font-weight: bold;
            color: #333;
        }

        .card p {
            color: #777;
        }

        .card .btn-primary {
            background-color: #067DB7;
            border: none;
            padding: 12px 25px;
            font-weight: bold;
            border-radius: 5px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .card .btn-primary:hover {
            background-color: #1e4381;
            transform: translateY(-2px);
        }

        /* Contenedor principal */
        .container-custom {
            margin-top: 50px;
        }

        /* Sección de título */
        .admin-text {
            text-align: left; /* Alinear a la izquierda */
            margin-bottom: 30px;
        }

        .admin-text h1 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #067DB7;
        }

        .admin-text p {
            font-size: 1.2rem;
            color: #6c757d;
        }

        /* Ajustes de las cards */
        .card-container {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .card {
            flex: 1; 
        }

        @media (max-width: 768px) {
            .card-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>

    <!-- Encabezado con logo a la izquierda y botón de cerrar sesión a la derecha -->
    <header class="navbar-custom">
        <div class="logo">
            <img src="logo-white.JPG" alt="Gafra Logo">
        </div>
        <a href="logout.php" class="logout">Cerrar sesión</a>
    </header>

    <!-- Contenido principal -->
    <main class="container container-custom">
        <div class="admin-text">
            <h1>Administrador</h1>
            <p>Gestiona tus servicios</p>
        </div>

        <div class="card-container">
            <div class="card">
                <h3>Usuarios</h3>
                <p>Consulta tus servicios de Usuarios</p>
                <a href="panelusuarios.php" class="btn btn-primary">Ir a Usuarios</a>
            </div>
            <div class="card">
                <h3>Productos</h3>
                <p>Consulta tus servicios de Productos</p>
                <a href="panelproductos.php?modulo=productos" class="btn btn-primary">Ir a Productos</a>
            </div>
            <div class="card">
                <h3>Pre-Orden</h3>
                <p>Consulta tus servicios de  Pre-Ordenes</p>
                <a href="panelpreorden.php" class="btn btn-primary">Ir a Pre-Orden</a>
            </div>
            <div class="card">
                <h3>Ventas</h3>
                <p>Consulta las ventas realizadas</p>
                <a href="panelventas.php" class="btn btn-primary">Ir a Ventas</a>
            </div>
        </div>
    </main>

    <!-- JavaScript de Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
