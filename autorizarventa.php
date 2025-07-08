<?php


include 'PreordenM.php'; // Incluye el archivo 'PreordenM.php', que contiene la definición de la clase PreOrden. Esta clase se utiliza para interactuar con la base de datos de pre-órdenes.
include 'session_check.php'; // Incluye 'session_check.php' que verifica el estado de autenticación del usuario, asegurando que el usuario esté autenticado antes de realizar acciones.

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_preorden'])) { // Verifica si la solicitud fue enviada mediante el método POST y si se ha pasado el 'id_preorden' en el formulario.
    $idPreorden = $_POST['id_preorden']; // Asigna el valor del 'id_preorden' enviado por el formulario a la variable $idPreorden.

    try { // Bloque 'try' para manejar cualquier error que pueda ocurrir durante la ejecución del código.
        $preOrden = new PreOrden(); // Crea una nueva instancia de la clase PreOrden, que maneja las operaciones relacionadas con pre-órdenes en la base de datos.
        
        // Llama al método 'autorizarVenta' de la clase PreOrden, pasando el ID de la pre-orden.
        // Este método ejecuta el procedimiento almacenado o realiza la lógica para cambiar el estado de la pre-orden de 'pendiente' a 'autorizada'.
        $preOrden->autorizarVenta($idPreorden); 

        // Después de autorizar la venta, redirige a la página 'consultapreorden.php' con un parámetro 'success=true' en la URL para indicar que la operación fue exitosa.
        header("Location: consultapreorden.php?success=true");
    } catch (Exception $e) { // Si ocurre un error, como que la pre-orden ya haya sido autorizada, entra en el bloque 'catch'.
        // Redirige a la misma página de consulta de pre-ordenes, pero con un parámetro 'error' en la URL, que contiene el mensaje de error codificado.
        header("Location: consultapreorden.php?error=" . urlencode($e->getMessage()));
    }
    exit(); // Termina la ejecución del script después de la redirección.
}





