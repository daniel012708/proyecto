<?php
// Iniciar la sesión
session_start();
include 'session_check.php'; // Incluir la verificación del estado del usuario


// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html"); // Redirigir a la página de login si no está autenticado
    exit();
}

include 'proyectoM.php'; 

// Comprobar si se ha solicitado eliminar un usuario
if (isset($_GET['action']) && $_GET['action'] === 'eliminar' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $usuario = new Usuario();

    // Intentar cambiar el estado a inactivo
    $resultado = $usuario->Eliminar($id);  

    // Comprobar el resultado y mostrar mensaje
    if ($resultado) {
        echo "<script>alert('Usuario eliminado exitosamente'); window.location.href='controladorconsulta.php';</script>";
    } else {
        echo "<script>alert('Error al eliminar el usuario'); window.history.back();</script>";
    }
}

// Obtener todos los usuarios activos
$usuarioModel = new Usuario();
$usuarios = $usuarioModel->ConsultarGeneral();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consulta de Usuarios con Eliminación</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include 'migaDePan.php'; ?>
    <div class="container mt-5">
        <h2>Consulta de Usuarios con Eliminación</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Documento de Identidad</th>
                    <th>Nombre</th>
                    <th>Correo Electrónico</th>
                    <th>Teléfono</th>
                    <th>Tipo de Usuario</th>
                    <th>Acciones</th>
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
                    <td>
                        <a href="?action=eliminar&id=<?= $usuario['id'] ?>" class="btn btn-danger" onclick="return confirm('¿Está seguro de que desea eliminar este usuario?');">Eliminar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
