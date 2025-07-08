<?php



// Conectar a la base de datos
$conexion = new PDO("mysql:host=localhost;dbname=gafra", "root", "");
$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Consultar el estado actual del usuario
$query = "SELECT estado_usuario FROM usuario WHERE id = :user_id";
$stmt = $conexion->prepare($query);
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->fetch(PDO::FETCH_ASSOC);

if ($result) {
    // Si el estado es "inactivo", cerrar la sesión y redirigir al login
    if ($result['estado_usuario'] == 'inactivo') {
        session_unset(); // Limpiar las variables de sesión
        session_destroy(); // Destruir la sesión
        header("Location: Login.html?error=eliminado"); // Redirigir al login con un mensaje de error
        exit();
    }
}
?>
