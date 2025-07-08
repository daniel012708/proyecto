<?php
// Iniciar la sesión
session_start();
$modulo = "productos";

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
</head>
<body>
    <!-- index.php -->
    <?php include 'navbar.php'; ?>
    <!-- Resto de la barra de navegación -->

    <div class="container">
        <div class="card">
            <h2><i class="fas fa-plus-circle"></i> Registrar</h2>
            <p>Registra un nuevo producto</p>
            <a href="registroproducto.php" class="btn">Ir a Registro de Productos</a>
        </div>
        <div class="card">
            <h2><i class="fas fa-search"></i> Consultar</h2>
            <p>Consulta un producto</p>
            <a href="Consultaproducto.php" class="btn">Ir a consulta de Productos</a>
        </div>
        <div class="card">
            <h2><i class="fas fa-edit"></i> Actualizar</h2>
            <p>Actualiza un producto</p>
            <a href="Actualizacionproductos.php" class="btn">Ir a Actualizar Productos</a>
        </div>
        <div class="card">
            <h2><i class="fas fa-trash-alt"></i> Eliminar</h2>
            <p>Elimina un producto</p>
            <a href="eliminarproducto.php" class="btn">Ir a Eliminar Productos</a>
        </div>
    </div>

    <!-- Bootstrap JS y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
