<?php
// Iniciar la sesión
session_start();
include 'session_check.php'; // Incluir la verificación del estado del usuario


// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html"); // Redirigir a la página de login si no está autenticado
    exit();
}

include 'proyectoM.php'; // Incluimos la clase Usuario

$usuarioModel = new Usuario();

// Si se busca un usuario por ID
if (isset($_POST['id']) && !empty($_POST['id'])) {
    $usuario = $usuarioModel->Consultar($_POST['id']);
} else {
    // Si no se ha buscado ningún usuario por ID, mostramos todos los usuarios
    $usuarios = $usuarioModel->ConsultarGeneral();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Usuarios</title>
    <!-- Añadimos Bootstrap -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'migaDePan.php'; ?>
    <div class="container mt-5">
        <h2 class="text-center mb-4">Consulta de Usuarios</h2>

        <!-- Formulario para buscar por ID -->
        <form action="" method="POST" class="form-inline justify-content-center mb-4">
            <input type="number" name="id" class="form-control mr-2" placeholder="Buscar por ID" required>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <!-- Mostrar el usuario encontrado por ID -->
        <?php if (isset($usuario)): ?>
            <?php if ($usuario): ?>
                <div class="card mb-4">
                    <div class="card-body">
                        <h3 class="card-title">Usuario encontrado:</h3>
                        <p><strong>ID:</strong> <?= $usuario['id'] ?></p>
                        <p><strong>Documento de Identidad:</strong> <?= $usuario['documento_identidad'] ?></p>
                        <p><strong>Nombre:</strong> <?= $usuario['nombre'] ?></p>
                        <p><strong>Correo Electrónico:</strong> <?= $usuario['correo_electronico'] ?></p>
                        <p><strong>Teléfono:</strong> <?= $usuario['telefono'] ?></p>
                        <p><strong>Tipo de Usuario:</strong> <?= $usuario['tipo_usuario'] ?></p>
                    </div>
                </div>
            <?php else: ?>
                <div class="alert alert-danger">No se encontró ningún usuario con ese ID.</div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Mostrar todos los usuarios si no se ha buscado por ID -->
        <?php if (!isset($usuario)): ?>
            <h3 class="text-center mb-3">Lista de Usuarios</h3>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Documento de Identidad</th>
                        <th>Nombre</th>
                        <th>Correo Electrónico</th>
                        <th>Teléfono</th>
                        <th>Tipo de Usuario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td><?= $usuario['id'] ?></td>
                            <td><?= $usuario['documento_identidad'] ?></td>
                            <td><?= $usuario['nombre'] ?></td>
                            <td><?= $usuario['correo_electronico'] ?></td>
                            <td><?= $usuario['telefono'] ?></td>
                            <td><?= $usuario['tipo_usuario'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <!-- Añadimos scripts de Bootstrap y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
