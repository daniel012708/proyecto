<?php
session_start();
include 'session_check.php'; // Incluir la verificación del estado del usuario


// Conectar a la base de datos
try {
    $conexion = new PDO("mysql:host=localhost;dbname=gafra", "root", "");
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error al conectar a la base de datos: " . $e->getMessage());
}

// Obtener los datos del formulario
$nom_usuario = $_POST['nom_usuario'];
$contrasena = $_POST['contrasena'];

// Inicializar las variables de sesión para intentos fallidos y bloqueo
if (!isset($_SESSION['intentos_fallidos'])) {
    $_SESSION['intentos_fallidos'] = 0;
}
if (!isset($_SESSION['bloqueado_hasta'])) {
    $_SESSION['bloqueado_hasta'] = null;
}

// Verificar si el usuario está bloqueado
if (isset($_SESSION['bloqueado_hasta']) && time() < $_SESSION['bloqueado_hasta']) {
    $tiempo_restante = ($_SESSION['bloqueado_hasta'] - time()) / 60;
    header("Location: Login.html?error=bloqueado&tiempo_restante=" . round($tiempo_restante));
    exit();
}

// Validar el usuario en la base de datos
$query = "SELECT id, tipo_usuario FROM usuario WHERE nom_usuario = :nom_usuario AND contrasena = :contrasena AND estado_usuario = 'activo'";
$stmt = $conexion->prepare($query);
$stmt->bindParam(':nom_usuario', $nom_usuario);
$stmt->bindParam(':contrasena', $contrasena);
$stmt->execute();

if ($stmt->rowCount() == 1) {
    // Si el usuario existe y está activo, restablecer los intentos fallidos
    $_SESSION['intentos_fallidos'] = 0;

    // Obtener los datos del usuario
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Guardar datos en la sesión
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['tipo_usuario'] = $user['tipo_usuario'];
    $_SESSION['nom_usuario'] = $nom_usuario;
    
    // Redirigir según el tipo de usuario
    if ($user['tipo_usuario'] == 'admin') {
        header("Location: panel.php");
    } elseif ($user['tipo_usuario'] == 'logistica') {
        header("Location: consultapreorden2.php");
    } elseif ($user['tipo_usuario'] == 'cliente') {
        header("Location: Gafra.php");
    }
    exit();
} else {
    // Incrementar el número de intentos fallidos
    $_SESSION['intentos_fallidos']++;

    // Si llega a 5 intentos fallidos, bloquear al usuario durante 5 minutos
    if ($_SESSION['intentos_fallidos'] >= 5) {
        $_SESSION['bloqueado_hasta'] = time() + (5 * 60); // Bloquear por 5 minutos
        header("Location: Login.html?error=bloqueado&tiempo_restante=5");
    } else {
        // Redirigir al formulario de inicio de sesión con un error de credenciales incorrectas
        $intentos_restantes = 5 - $_SESSION['intentos_fallidos'];
        header("Location: Login.html?error=credenciales&intentos_restantes=" . $intentos_restantes);
    }
    exit();
}
?>
