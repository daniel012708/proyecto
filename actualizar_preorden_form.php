<?php
session_start(); // Inicia una nueva sesión o reanuda la sesión existente.
include 'session_check.php'; // Verifica si el usuario está autenticado y la sesión es válida.
include 'PreordenM.php'; // Incluye la clase PreOrden para manejar la lógica relacionada con las pre-órdenes.
include 'ProductoM.php'; // Incluye la clase Producto para manejar la lógica relacionada con los productos.

$preOrdenModel = new PreOrden(); // Crea una nueva instancia de la clase PreOrden.
$productoModel = new Producto(); // Crea una nueva instancia de la clase Producto.

// Verifica si se ha proporcionado un ID de pre-orden en la URL (GET).
if (isset($_GET['id'])) {
    $idPreorden = $_GET['id']; // Asigna el ID de la pre-orden a una variable.
    $preOrden = $preOrdenModel->consultarPreOrdenPorIdActiva($idPreorden); // Obtiene los detalles de la pre-orden activa.
    $productosPreorden = $preOrdenModel->obtenerProductosPorPreOrden($idPreorden); // Obtiene los productos asociados a la pre-orden.
    $todosLosProductos = $productoModel->consultarTodos(); // Obtiene la lista de todos los productos disponibles.
} else {
    header("Location: actualizarPreorden.php"); // Redirige a la página principal si no se proporciona un ID.
    exit(); // Detiene la ejecución del script.
}

// Procesa el formulario al enviarlo (método POST).
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Actualiza la información de la pre-orden con los datos enviados en el formulario.
    $preOrdenModel->actualizarPreorden(
        $_POST['id'],
        $_POST['destino'],
        $_POST['metodo_entrega'],
        $_POST['fecha_entrega'],
        $_POST['metodo_pago'],
        $_POST['valor_total'],
        $_POST['abono'],
        $_POST['impuesto'],
        $_POST['descuento'],
        $_POST['descripcion'],
        $preOrden['id_cliente_realiza'],
        $preOrden['id_logistica_alista']
    );

    // Actualiza la información de los productos existentes en la pre-orden.
    foreach ($_POST['producto_id'] as $index => $producto_id) {
        $cantidad = $_POST['cantidad'][$index]; // Cantidad actualizada para el producto.
        $precio = $_POST['precio'][$index]; // Precio del producto (solo lectura).
        $preOrdenModel->actualizarProductoPreOrden($_POST['id'], $producto_id, $cantidad, $precio); // Actualiza la información del producto en la pre-orden.
    }

    // Si se agregan nuevos productos.
    if (!empty($_POST['nuevo_producto_id'])) {
        foreach ($_POST['nuevo_producto_id'] as $index => $nuevo_producto_id) {
            $nueva_cantidad = $_POST['nueva_cantidad'][$index]; // Cantidad para el nuevo producto.
            $nuevo_precio = $productoModel->obtenerPrecioProducto($nuevo_producto_id); // Obtiene el precio del nuevo producto.
            $preOrdenModel->agregarProductoPreOrden($_POST['id'], $nuevo_producto_id, $nueva_cantidad, $nuevo_precio); // Agrega el nuevo producto a la pre-orden.
        }
    }

    // Si se eliminan productos de la pre-orden.
    if (!empty($_POST['eliminar_producto_id'])) {
        foreach ($_POST['eliminar_producto_id'] as $eliminar_producto_id) {
            $preOrdenModel->eliminarProductoPreOrden($_POST['id'], $eliminar_producto_id); // Elimina el producto de la pre-orden.
        }
    }

    // Actualiza los datos de la venta correspondiente a la pre-orden.
    try {
        $cantidadProductos = array_sum($_POST['cantidad']); // Suma todas las cantidades de productos para obtener la cantidad total.
        $restante = $_POST['valor_total'] - $_POST['abono']; // Calcula el valor restante por pagar.

        // Conecta a la base de datos.
        $conexion = new PDO("mysql:host=localhost;dbname=gafra", "root", ""); // Conexión a la base de datos.
        $stmt = $conexion->prepare("CALL actualizar_venta(?, ?, ?, ?, ?, ?)"); // Prepara la llamada al procedimiento almacenado `actualizar_venta`.

        // Enlaza los parámetros al procedimiento almacenado.
        $stmt->bindParam(1, $_POST['id'], PDO::PARAM_INT); // ID de la pre-orden.
        $stmt->bindParam(2, $_POST['fecha_entrega'], PDO::PARAM_STR); // Fecha de venta.
        $stmt->bindParam(3, $_POST['metodo_pago'], PDO::PARAM_STR); // Método de pago.
        $stmt->bindParam(4, $restante, PDO::PARAM_INT); // Valor restante por pagar.
        $stmt->bindParam(5, $_POST['valor_total'], PDO::PARAM_INT); // Valor total de la venta.
        $stmt->bindParam(6, $cantidadProductos, PDO::PARAM_INT); // Cantidad total de productos.

        $stmt->execute(); // Ejecuta la consulta.
    } catch (Exception $e) {
        // Muestra el error si falla la actualización de la venta.
        echo "Error al actualizar la venta: " . $e->getMessage();
    }

    // Redirige a la página de actualización de pre-orden después de completar el proceso.
    header("Location: actualizarPreorden.php?success=true");
    exit(); // Detiene la ejecución.
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Pre-Orden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Actualizar Pre-Orden <?= $preOrden['id'] ?></h2>

        <!-- Mensaje de éxito si la pre-orden se actualizó correctamente -->
        <?php if (isset($_GET['success']) && $_GET['success'] === 'true'): ?>
            <div class="alert alert-success" role="alert">
                La pre-orden se actualizó correctamente.
            </div>
        <?php endif; ?>

        <form method="POST" action="actualizar_preorden_form.php?id=<?= $preOrden['id'] ?>">
            <!-- Campo oculto para el ID de la pre-orden -->
            <input type="hidden" name="id" value="<?= $preOrden['id'] ?>">
            
            <!-- Campo para ingresar el destino de la pre-orden -->
            <div class="mb-3">
                <label for="destino" class="form-label">Destino</label>
                <input type="text" class="form-control" id="destino" name="destino" value="<?= $preOrden['destino'] ?>" required>
            </div>

            <!-- Selección del método de entrega -->
            <div class="mb-3">
                <label for="metodo_entrega" class="form-label">Método de Entrega</label>
                <select class="form-control" id="metodo_entrega" name="metodo_entrega" required>
                    <option value="domicilio" <?= $preOrden['metodo_entrega'] == 'domicilio' ? 'selected' : '' ?>>Domicilio</option>
                    <option value="recogida" <?= $preOrden['metodo_entrega'] == 'recogida' ? 'selected' : '' ?>>Recogida</option>
                </select>
            </div>

            <!-- Campo para ingresar la fecha de entrega -->
            <div class="mb-3">
                <label for="fecha_entrega" class="form-label">Fecha de Entrega</label>
                <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" value="<?= $preOrden['fecha_entrega'] ?>" required>
            </div>

            <!-- Selección del método de pago -->
            <div class="mb-3">
                <label for="metodo_pago" class="form-label">Método de Pago</label>
                <select class="form-control" id="metodo_pago" name="metodo_pago" required>
                    <option value="tarjeta" <?= $preOrden['metodo_pago'] == 'tarjeta' ? 'selected' : '' ?>>Tarjeta</option>
                    <option value="efectivo" <?= $preOrden['metodo_pago'] == 'efectivo' ? 'selected' : '' ?>>Efectivo</option>
                    <option value="transferencia" <?= $preOrden['metodo_pago'] == 'transferencia' ? 'selected' : '' ?>>Transferencia</option>
                </select>
            </div>

            <!-- Campo para la descripción -->
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"><?= htmlspecialchars($preOrden['descripcion']) ?></textarea>
            </div>

            <!-- Campo para el valor total, solo lectura -->
            <div class="mb-3">
                <label for="valor_total" class="form-label">Valor Total</label>
                <input type="number" class="form-control" id="valor_total" name="valor_total" value="<?= $preOrden['valor_total'] ?>" readonly>
            </div>

            <!-- Campo para el descuento, solo lectura -->
            <div class="mb-3">
                <label for="descuento" class="form-label">Descuento</label>
                <input type="number" class="form-control" id="descuento" name="descuento" value="<?= $preOrden['descuento'] ?>" readonly>
            </div>

            <!-- Campo para el impuesto, solo lectura -->
            <div class="mb-3">
                <label for="impuesto" class="form-label">Impuesto</label>
                <input type="number" class="form-control" id="impuesto" name="impuesto" value="<?= $preOrden['impuesto'] ?>" readonly>
            </div>

            <!-- Campo para el abono, solo lectura -->
            <div class="mb-3">
                <label for="abono" class="form-label">Abono</label>
                <input type="number" class="form-control" id="abono" name="abono" value="<?= $preOrden['abono'] ?>" readonly>
            </div>

            <!-- Productos existentes en la pre-orden -->
            <h3>Productos Existentes</h3>
            <?php foreach ($productosPreorden as $index => $producto): ?>
                <div class="mb-3">
                    <label>Producto:</label>
                    <input type="text" class="form-control" value="<?= $producto['nombre_producto'] ?>" readonly>
                    <input type="hidden" name="producto_id[]" value="<?= $producto['id_producto'] ?>">

                    <label>Cantidad:</label>
                    <input type="number" class="form-control" name="cantidad[]" value="<?= $producto['cantidad'] ?>" min="1" required>

                    <label>Precio:</label>
                    <input type="number" class="form-control" name="precio[]" value="<?= $producto['precio'] ?>" readonly>

                    <!-- Checkbox para eliminar productos -->
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="eliminar_producto_id[]" value="<?= $producto['id_producto'] ?>">
                        <label class="form-check-label">Eliminar este producto</label>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Sección para agregar nuevos productos -->
            <h3>Agregar Nuevos Productos</h3>
            <div id="nuevo-producto-container"></div>
            <button type="button" class="btn btn-secondary" onclick="agregarNuevoProducto()">Añadir Producto</button>

            <br><br>
            <button type="submit" class="btn btn-primary">Actualizar Pre-Orden</button>
        </form>
    </div>

    <script>
        // Función para agregar un nuevo producto al formulario
        function agregarNuevoProducto() {
            const contenedor = document.getElementById('nuevo-producto-container');
            const nuevoProductoHTML = `
                <div class="mb-3">
                    <label>Nuevo Producto:</label>
                    <select class="form-control" name="nuevo_producto_id[]">
                        <?php foreach ($todosLosProductos as $producto): ?>
                            <option value="<?= $producto['id'] ?>"><?= $producto['nombre_producto'] ?> - Precio: <?= $producto['valor'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Cantidad:</label>
                    <input type="number" class="form-control" name="nueva_cantidad[]" value="1" min="1" required>
                </div>`;
            contenedor.insertAdjacentHTML('beforeend', nuevoProductoHTML);
        }

        // Confirmar antes de eliminar un producto
        document.querySelectorAll('input[name="eliminar_producto_id[]"]').forEach((checkbox) => {
            checkbox.addEventListener('change', (e) => {
                if (e.target.checked) {
                    if (!confirm('¿Estás seguro de que deseas eliminar este producto?')) {
                        e.target.checked = false;
                    }
                }
            });
        });
    </script>
</body>
</html>
