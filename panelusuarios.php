<?php
// Iniciar la sesión
session_start();
include 'session_check.php'; // Incluir la verificación del estado del usuario


$modulo = "usuarios";
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
    <?php include 'navbar.php'; ?>

    <main>
        <div class="container">
            <div class="card">
                <h2><i class="fas fa-plus-circle"></i> Registrar</h2>
                <p>Registra un nuevo usuario </p>
                <a href="gafraregistro2.php" class="btn">Ir a Formulario de Registro</a> 
            </div>
            <div class="card">
                <h2><i class="fas fa-search"></i>Consultar</h2>
                <p>Consulta varios Usuarios </p>
                <a href="controladorconsulta.php" class="btn">Ir a la consulta  de Usuarios</a> 
            </div>
            <div class="card">
                <h2><i class="fas fa-edit"></i>Actualizar</h2>
                <p>Actualiza datos de un usuario</p>
                <a href="controladorconsultactualizar.php" class="btn">Ir a Actualizacion de Datos</a> 
            </div>
            <div class="card">
                <h2><i class="fas fa-trash-alt"></i>Eliminar</h2>
                <p>Inactiva un usuario</p>
                <a href="controladorconsultaeliminar.php" class="btn">Ir a inactivacion de Usuarios</a> 
            </div>
        </div>
    </main>
</body>
</html>
