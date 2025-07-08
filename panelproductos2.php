<?php
// Iniciar la sesión
session_start();
$modulo = "productos";
include 'migaDePan.php';
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
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Estilos personalizados para el panel */
        body {
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
        }

        .card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-bottom: 30px;
            text-align: center;
            padding: 20px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 15px rgba(0, 0, 0, 0.2);
        }

        .card h2 {
            font-size: 24px;
            margin-bottom: 15px;
            color: #007bff;
        }

        .card p {
            font-size: 16px;
            color: #6c757d;
            margin-bottom: 20px;
        }

        .card a {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.2s, box-shadow 0.2s;
        }

        .card a:hover {
            background-color: #0056b3;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .card i {
            font-size: 40px;
            margin-bottom: 10px;
            color: #007bff;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="card">
            <i class="fas fa-plus-circle"></i>
            <h2>Registrar</h2>
            <p>Registra un nuevo producto</p>
            <a href="registroproducto.php" class="btn">Ir a Registro de Productos</a>
        </div>
        <div class="card">
            <i class="fas fa-search"></i>
            <h2>Consultar</h2>
            <p>Consulta un producto</p>
            <a href="Consultaproducto.php" class="btn">Ir a consulta de Productos</a>
        </div>
        <div class="card">
            <i class="fas fa-edit"></i>
            <h2>Actualizar</h2>
            <p>Actualiza un producto</p>
            <a href="Actualizacionproductos.php" class="btn">Ir a Actualizar Productos</a>
        </div>


    <!-- Bootstrap JS y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
