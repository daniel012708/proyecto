<?php
include "productoM.php"; // Incluye tu archivo de configuración y conexión
include 'session_check.php'; // Incluir la verificación del estado del usuario


$objetoProducto = new Producto(); // Asegúrate de tener la clase Producto definida

$r = $objetoProducto->Registrar(
    $_POST["nombre_producto"],    // Nombre del producto
    $_POST["color"],              // Color del producto
    $_POST["descripcion"],        // Descripción del producto
    $_POST["valor"],              // Valor del producto
    $_POST["cantidad_bodega"]     // Cantidad en bodega
);

echo $r; // Muestra el resultado de la operación

