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
    <title>Registro de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body {
            background-image: url('#');
            font-family: 'Montserrat', sans-serif;
            background-color: #fff;
        }
        .container {
            width: 550px;
            padding: 30px;
            border: 1px solid #ced4da;
            border-radius: 25px;
            background-color: rgba(255, 255, 255, 0);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0);
            backdrop-filter: blur(15px);
            animation: fadeIn 0.5s ease-in;
        }

        .login-header {
            display: flex;
            justify-content: center;  
            align-items: center;     
            margin-bottom: 20px;      
        }

        .login-header img {
            max-width: 100px;         
            height: auto;          
        }

        h2 {
            font-weight: 600;
            margin-bottom: 20px;
        }
        .form-label {
            font-weight: 400;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            font-weight: 600;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004080;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
                /* Mueve el contenedor hacia arriba */
            }

            to {
                opacity: 1;
                transform: translateY(0);
                /* Regresa a la posición original */
            }
        }
    </style>
</head>
<body>
    <?php include 'migaDePan.php'; ?>
    <div class="container mt-5">
        <div class="login-header">
                <img src="https://cdn.leonardo.ai/users/87ff1cbb-7254-440f-8795-cf874b32b261/generations/a89b178e-c65c-4e5b-96c2-4f5ae900d0bd/Leonardo_Phoenix_Design_a_modern_and_sleek_logo_for_GAFRA_a_co_0.jpg?w=512" alt="gafra logo">
        </div>
        <h2>Registro de Empleados</h2>
        <form action="proyectoC.php" method="POST">
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>
            <div class="mb-3">
                <label for="tipo_usuario" class="form-label">Tipo de Usuario</label>
                <select class="form-control" id="tipo_usuario" name="tipo_usuario" required>
                    <option value="admin">Administrador</option>
                    <option value="logistica" selected>Logística</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="nom_usuario" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="nom_usuario" name="nom_usuario" required>
            </div>
            <div class="mb-3">
                <label for="contrasena" class="form-label">Contraseña</label>
                <input type="password" class="form-control" id="contrasena" name="contrasena" required>
            </div>
            <div class="mb-3">
                <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" required>
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" class="form-control" id="direccion" name="direccion" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="number" class="form-control" id="telefono" name="telefono" required min="100000000" max="9999999999">
            </div>
            <div class="mb-3">
                <label for="documento_identidad" class="form-label">Documento de Identidad</label>
                <input type="number" class="form-control" id="documento_identidad" name="documento_identidad" required min="10000000" max="99999999999">
            </div>
            <div class="mb-3">
                <label for="eps" class="form-label">EPS</label>
                <input type="text" class="form-control" id="eps" name="eps" required>
            </div>
            <div class="mb-3">
                <label for="tipo_sangre" class="form-label">Tipo de Sangre</label>
                <select class="form-control" id="tipo_sangre" name="tipo_sangre" required>
                    <option value="O">O</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="AB">AB</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="RH" class="form-label">RH</label>
                <select class="form-control" id="RH" name="RH" required>
                    <option value="+">Positivo</option>
                    <option value="-">Negativo</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="estado_civil" class="form-label">Estado Civil</label>
                <select class="form-control" id="estado_civil" name="estado_civil" required>
                    <option value="soltero">Soltero</option>
                    <option value="casado">Casado</option>
                    <option value="divorciado">Divorciado</option>
                    <option value="viudo">Viudo</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Registrar</button>
        </form>
    </div>
</body>
</html>
