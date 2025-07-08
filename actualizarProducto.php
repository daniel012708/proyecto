session_start(); // Inicia una sesión en el servidor para almacenar y acceder a los datos de la sesión del usuario.
include 'session_check.php'; // Incluye un archivo que probablemente verifica si el usuario tiene una sesión válida o está autenticado.

if (!isset($_SESSION['user_id'])) { // Comprueba si la variable de sesión 'user_id' no está establecida, lo que indicaría que el usuario no está autenticado.
    header("Location: Login.html"); // Redirige al usuario a la página de inicio de sesión si no está autenticado.
    exit(); // Detiene la ejecución del script después de la redirección.
}

include 'productoM.php'; // Incluye el archivo 'productoM.php', que contiene la definición de la clase Producto, que se usa para interactuar con la base de datos de productos.

if (isset($_POST['id'])) { // Comprueba si se ha enviado el ID del producto mediante el método POST (probablemente al acceder al formulario de actualización).
    $productoModel = new Producto(); // Crea una instancia de la clase Producto para interactuar con los productos.
    $producto = $productoModel->Consultar($_POST['id']); // Llama al método 'Consultar' para obtener los detalles del producto en función de su ID.
}

if (isset($_POST['actualizar'])) { // Verifica si se ha enviado el formulario de actualización (comprobando si la variable POST 'actualizar' está establecida).
    $productoModel = new Producto(); // Crea una instancia de la clase Producto.
    // Llama al método 'Actualizar' de la clase Producto, pasando los valores enviados en el formulario (nombre, color, descripción, valor, cantidad en bodega).
    $productoModel->Actualizar($_POST['id'], $_POST['nombre_producto'], $_POST['color'], $_POST['descripcion'], $_POST['valor'], $_POST['cantidad_bodega']);
    
    // Redirige de vuelta a la página 'Consultaproducto.php' después de actualizar el producto.
    header('Location: Consultaproducto.php');
    exit(); // Detiene la ejecución del script después de la redirección.
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"> <!-- Especifica el conjunto de caracteres a utilizar, en este caso UTF-8. -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- Hace que la página sea responsiva en dispositivos móviles. -->
    <title>Actualizar Producto</title> <!-- Título de la página que se muestra en la pestaña del navegador. -->
    <!-- Enlaza la hoja de estilos de Bootstrap para diseñar la página -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5"> <!-- Contenedor principal con margen superior (mt-5). -->
        <h2 class="text-center mb-4">Actualizar Producto</h2> <!-- Título centrado con margen inferior (mb-4). -->

        <?php if (isset($producto)): ?> <!-- Si se encuentra el producto, muestra el formulario con los datos actuales del producto. -->
            <form action="" method="POST"> <!-- Formulario que enviará los datos usando el método POST. -->
                <input type="hidden" name="id" value="<?= $producto['id'] ?>"> <!-- Campo oculto que contiene el ID del producto, necesario para la actualización. -->
                <div class="form-group">
                    <label for="nombre_producto">Nombre del Producto</label> <!-- Etiqueta para el nombre del producto. -->
                    <input type="text" name="nombre_producto" class="form-control" value="<?= $producto['nombre_producto'] ?>" required> <!-- Campo de entrada para el nombre del producto, con el valor actual prellenado. -->
                </div>
                <div class="form-group">
                    <label for="color">Color</label> <!-- Etiqueta para el color del producto. -->
                    <input type="text" name="color" class="form-control" value="<?= $producto['color'] ?>" required> <!-- Campo de entrada para el color, prellenado con el valor actual. -->
                </div>
                <div class="form-group">
                    <label for="descripcion">Descripción</label> <!-- Etiqueta para la descripción del producto. -->
                    <textarea name="descripcion" class="form-control" required><?= $producto['descripcion'] ?></textarea> <!-- Área de texto para la descripción del producto, prellenada con la descripción actual. -->
                </div>
                <div class="form-group">
                    <label for="valor">Valor</label> <!-- Etiqueta para el valor del producto. -->
                    <input type="number" name="valor" class="form-control" value="<?= $producto['valor'] ?>" required> <!-- Campo numérico para el valor del producto, prellenado con el valor actual. -->
                </div>
                <div class="form-group">
                    <label for="cantidad_bodega">Cantidad en Bodega</label> <!-- Etiqueta para la cantidad de productos en bodega. -->
                    <input type="number" name="cantidad_bodega" class="form-control" value="<?= $producto['cantidad_bodega'] ?>" required> <!-- Campo numérico para la cantidad en bodega, prellenado con la cantidad actual. -->
                </div>
                <button type="submit" name="actualizar" class="btn btn-success">Actualizar Producto</button> <!-- Botón para enviar el formulario y actualizar el producto. -->
            </form>
        <?php else: ?> <!-- Si no se encuentra el producto, muestra un mensaje de error. -->
            <div class="alert alert-danger">No se encontró el producto.</div> <!-- Alerta roja que indica que no se encontró el producto. -->
        <?php endif; ?>
    </div>
</body>
</html>
