<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html");
    exit();
}

include 'PreordenM.php'; // Incluir el modelo

$preOrdenModel = new PreOrden(); // Instanciar el modelo

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_venta = $_POST['id_venta'];
    
    // Llamar a la función para eliminar la venta (cambiar estado a inactivo)
    if ($preOrdenModel->eliminarVenta($id_venta)) { // Asumiendo que tienes un método eliminarVenta en tu modelo
        header("Location: eliminarVenta.php?success=venta_eliminada");
    } else {
        header("Location: eliminarVenta.php?error=no_se_pudo_eliminar");
    }
    exit();
}
?>
