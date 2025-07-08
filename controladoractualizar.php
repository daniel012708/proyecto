<?php
// Iniciar la sesión
session_start();
include 'session_check.php'; // Incluir la verificación del estado del usuario


// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html"); // Redirigir a la página de login si no está autenticado
    exit();
}

include 'proyectoM.php'; // Incluir el modelo de usuario

// Verificar si se está consultando un usuario por su ID
if (isset($_GET['id'])) {
    $usuarioModel = new Usuario();
    $usuario = $usuarioModel->Consultar($_GET['id']); // Consultar el usuario

    if (!$usuario) {
        echo "<script>alert('Usuario no encontrado'); window.location.href='controladorconsulta.php';</script>";
        exit; // Detiene la ejecución si el usuario no se encuentra
    }
}

// Si se envía el formulario
if (!empty($_POST)) {
    $usuarioModel = new Usuario();
    if ($usuarioModel->Actualizar(
        $_GET['id'], 
        $_POST['nombre'], 
        $_POST['tipo_usuario'], 
        $_POST['nom_usuario'], 
        $_POST['contrasena'], 
        $_POST['correo_electronico'], 
        $_POST['estado_usuario'], 
        $_POST['direccion'], 
        $_POST['telefono'], 
        $_POST['documento_identidad'], 
        $_POST['eps'], 
        $_POST['tipo_sangre'], 
        $_POST['RH'], 
        $_POST['estado_civil']
    )) {
        echo "<script>alert('Usuario actualizado exitosamente'); window.location.href='controladorconsulta.php';</script>";
    } else {
        echo "<script>alert('Error al actualizar el usuario'); window.history.back();</script>";
    }
}
?>

<style>
.contraseña{
    display: none;
}
</style>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Actualizar Usuario</h2>
        <form action="" method="POST">
            <!-- Nombre -->
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>" required>
            </div>

            <!-- Nombre de usuario -->
            <div class="mb-3">
                <label for="nom_usuario" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="nom_usuario" name="nom_usuario" value="<?= htmlspecialchars($usuario['nom_usuario']) ?>" required>
            </div>

            <!-- Contraseña -->
            <div class="mb-3">
                <div class="contraseña">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" value="<?= htmlspecialchars($usuario['contrasena']) ?>" required>
            </div>
            </div>

            <!-- Correo Electrónico -->
            <div class="mb-3">
                <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" value="<?= htmlspecialchars($usuario['correo_electronico']) ?>" required>
            </div>

            <!-- Teléfono -->
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="telefono" name="telefono" value="<?= htmlspecialchars($usuario['telefono']) ?>" required>
            </div>

            <!-- Dirección -->
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" value="<?= htmlspecialchars($usuario['direccion']) ?>" required>
            </div>

            <!-- Tipo de Usuario -->
            <div class="mb-3">
                <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
                <select class="form-control" id="tipo_usuario" name="tipo_usuario" required>
                    <option value="admin" <?= $usuario['tipo_usuario'] == 'admin' ? 'selected' : '' ?>>Administrador</option>
                    <option value="logistica" <?= $usuario['tipo_usuario'] == 'logistica' ? 'selected' : '' ?>>Logística</option>
                    <option value="cliente" <?= $usuario['tipo_usuario'] == 'cliente' ? 'selected' : '' ?>>Cliente</option>
                </select>
            </div>

            <!-- Estado de Usuario -->
            <div class="mb-3">
                <label for="estado_usuario" class="form-label">Estado de Usuario</label>
                <select class="form-control" id="estado_usuario" name="estado_usuario" required>
                    <option value="activo" <?= $usuario['estado_usuario'] == 'activo' ? 'selected' : '' ?>>Activo</option>
                    <option value="inactivo" <?= $usuario['estado_usuario'] == 'inactivo' ? 'selected' : '' ?>>Inactivo</option>
                </select>
            </div>

            <!-- Documento de Identidad -->
            <div class="mb-3">
                <label for="documento_identidad" class="form-label">Documento de Identidad</label>
                <input type="text" class="form-control" id="documento_identidad" name="documento_identidad" value="<?= htmlspecialchars($usuario['documento_identidad']) ?>" required>
            </div>

            <!-- EPS -->
            <div class="mb-3">
                <label for="eps" class="form-label">EPS</label>
                <input type="text" class="form-control" id="eps" name="eps" value="<?= htmlspecialchars($usuario['eps']) ?>" required>
            </div>

            <!-- Tipo de Sangre -->
            <div class="mb-3">
                <label for="tipo_sangre" class="form-label">Tipo de Sangre</label>
                <select class="form-control" id="tipo_sangre" name="tipo_sangre" required>
                    <option value="O" <?= $usuario['tipo_sangre'] == 'O' ? 'selected' : '' ?>>O</option>
                    <option value="A" <?= $usuario['tipo_sangre'] == 'A' ? 'selected' : '' ?>>A</option>
                    <option value="B" <?= $usuario['tipo_sangre'] == 'B' ? 'selected' : '' ?>>B</option>
                    <option value="AB" <?= $usuario['tipo_sangre'] == 'AB' ? 'selected' : '' ?>>AB</option>
                </select>
            </div>

            <!-- RH -->
            <div class="mb-3">
                <label for="RH" class="form-label">RH</label>
                <select class="form-control" id="RH" name="RH" required>
                    <option value="+" <?= $usuario['RH'] == '+' ? 'selected' : '' ?>>Positivo</option>
                    <option value="-" <?= $usuario['RH'] == '-' ? 'selected' : '' ?>>Negativo</option>
                </select>
            </div>

            <!-- Estado Civil -->
            <div class="mb-3">
                <label for="estado_civil" class="form-label">Estado Civil</label>
                <select class="form-control" id="estado_civil" name="estado_civil" required>
                    <option value="soltero" <?= $usuario['estado_civil'] == 'soltero' ? 'selected' : '' ?>>Soltero</option>
                    <option value="casado" <?= $usuario['estado_civil'] == 'casado' ? 'selected' : '' ?>>Casado</option>
                    <option value="divorciado" <?= $usuario['estado_civil'] == 'divorciado' ? 'selected' : '' ?>>Divorciado</option>
                    <option value="viudo" <?= $usuario['estado_civil'] == 'viudo' ? 'selected' : '' ?>>Viudo</option>
                </select>
            </div>

            <!-- Botón de envío -->
            <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
    </div>
</body>
</html>
