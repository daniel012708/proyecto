<?php
include 'PreordenM.php'; // Clase PreOrden
include 'ProductoM.php'; // Clase Producto para cargar productos
include 'ProyectoM.php'; // Clase Usuario para obtener el cliente y logística
include 'session_check.php'; // Incluir la verificación del estado del usuario


$productoModel = new Producto();
$productos = $productoModel->consultarTodos(); // Cargar productos existentes

session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html"); // Redirigir a la página de login si no está autenticado
    exit();
}

// Obtener el ID del cliente logueado desde la sesión
$clienteId = $_SESSION['id_cliente'] ?? 1; // Asumimos que está en sesión el cliente

// Obtener un usuario de logística (automáticamente)
$usuarioModel = new Usuario();
$logisticaId = $usuarioModel->obtenerUsuarioLogistico(); // Obtener un empleado logístico

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $preOrden = new PreOrden();

    // Registrar la Pre-Orden
    $id_pre_orden = $preOrden->registrarPreOrden(
        $_POST['fecha_solicitud'],
        $_POST['destino'],
        $_POST['metodo_entrega'],
        $_POST['fecha_entrega'],
        $_POST['metodo_pago'],
        $_POST['valor_total'], // Calculado en el frontend
        $_POST['abono'],       // Calculado en el frontend
        $_POST['impuesto'],    // Calculado en el frontend
        $_POST['descuento'],   // Calculado en el frontend
        $_POST['descripcion'],
        $clienteId,            // ID del cliente (automático)
        $logisticaId           // ID de logístico (automático)
    );

    // Registrar los detalles de productos seleccionados
    foreach ($_POST['producto_id'] as $index => $producto_id) {
        $cantidad = $_POST['cantidad'][$index];
        $precio = $productoModel->obtenerPrecioProducto($producto_id); // Obtener precio del producto

        // Registrar el detalle de la preorden y restar el stock
        $preOrden->registrarDetallePreOrden($id_pre_orden, $producto_id, $cantidad, $precio);
    }

    // Redirigir a la misma página con un parámetro de éxito
    header("Location: consultapreorden.php?success=true");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Pre-Orden</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f4f7fa;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #1746A2;
            padding: 10px 30px;
        }

        .navbar-brand, .navbar-nav .nav-link {
            color: #fff !important;
            font-weight: bold;
        }

        .navbar-nav .nav-link:hover {
            color: #ddd !important;
        }

        .container {
            margin-top: 50px;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #1746A2;
        }

        .form-label {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #1746A2;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #143d82;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .producto {
            background-color: #e9ecef;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .producto label {
            font-weight: bold;
        }

        .producto select, .producto input {
            margin-bottom: 10px;
        }

        .alert {
            margin-top: 20px;
        }

    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Gafra</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="consultapreorden.php">Ver Pre-Ordenes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php include 'migaDePan.php'; ?>

    <div class="container">
        <h2><i class="fas fa-file-alt"></i> Registrar Pre-Orden</h2>

        <?php if (isset($_GET['success']) && $_GET['success'] == 'true'): ?>
            <div class="alert alert-success">
                Pre-orden registrada exitosamente.
            </div>
        <?php endif; ?>

        <form action="preordenregistro.php" method="POST" id="preorden-form" onsubmit="return validarStock()">
            <!-- Información de la Pre-Orden -->
            <div class="mb-3">
                <label for="fecha_solicitud" class="form-label">Fecha de Solicitud</label>
                <input type="date" class="form-control" id="fecha_solicitud" name="fecha_solicitud" readonly>
            </div>

            <div class="mb-3">
                <label for="destino" class="form-label">Destino</label>
                <input type="text" class="form-control" id="destino" name="destino" required>
            </div>

            <div class="mb-3">
                <label for="metodo_entrega" class="form-label">Método de Entrega</label>
                <select class="form-select" id="metodo_entrega" name="metodo_entrega" required>
                    <option value="domicilio">Domicilio</option>
                    <option value="recogida">Recogida</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="fecha_entrega" class="form-label">Fecha de Entrega</label>
                <input type="date" class="form-control" id="fecha_entrega" name="fecha_entrega" required>
            </div>

            <div class="mb-3">
                <label for="metodo_pago" class="form-label">Método de Pago</label>
                <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                    <option value="tarjeta">Tarjeta</option>
                    <option value="efectivo">Efectivo</option>
                    <option value="transferencia">Transferencia</option>
                </select>
            </div>

            <!-- Valor Total, Impuesto, Descuento (Calculados automáticamente) -->
            <div class="mb-3">
                <label for="valor_total" class="form-label">Valor Total</label>
                <input type="number" class="form-control" id="valor_total" name="valor_total" readonly>
            </div>

            <div class="mb-3">
                <label for="abono" class="form-label">Abono (30%)</label>
                <input type="number" class="form-control" id="abono" name="abono" readonly>
            </div>

            <div class="mb-3">
                <label for="impuesto" class="form-label">Impuesto</label>
                <input type="number" class="form-control" id="impuesto" name="impuesto" readonly>
            </div>

            <div class="mb-3">
                <label for="descuento" class="form-label">Descuento</label>
                <input type="number" class="form-control" id="descuento" name="descuento" readonly>
            </div>

            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <input type="text" class="form-control" id="descripcion" name="descripcion">
            </div>

            <!-- Selección de Productos -->
            <h3>Detalles de Productos</h3>
            <div id="producto-detalles">
                <!-- Productos se agregarán dinámicamente -->
            </div>
            <button type="button" class="btn btn-secondary" onclick="agregarProducto()">Añadir Producto</button>

            <br><br>
            <button type="submit" class="btn btn-primary">Registrar Pre-Orden</button>
        </form>
    </div>

    <!-- Bootstrap JS y jQuery -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Establece la fecha actual como la fecha de solicitud por defecto
        document.getElementById("fecha_solicitud").value = new Date().toISOString().split('T')[0];

        function agregarProducto() {
            const contenedor = document.getElementById("producto-detalles");
            const html = `
                <div class="producto">
                    <label>Selecciona un Producto:</label>
                    <select class="form-select" name="producto_id[]" onchange="calcularTotal()" required>
                        <?php foreach ($productos as $producto): ?>
                            <option value="<?= $producto['id'] ?>" data-precio="<?= $producto['valor'] ?>" data-stock="<?= $producto['cantidad_bodega'] ?>">
                                <?= $producto['nombre_producto'] ?> - Precio: <?= $producto['valor'] ?> - Stock: <?= $producto['cantidad_bodega'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <label>Cantidad:</label>
                    <input type="number" class="form-control" name="cantidad[]" value="1" min="1" onchange="calcularTotal()" required>
                </div>`;
            contenedor.insertAdjacentHTML('beforeend', html);
        }

        function calcularTotal() {
            const productos = document.querySelectorAll('.producto');
            let total = 0, impuesto = 0, descuento = 0, cantidadTotal = 0;

            productos.forEach((producto) => {
                const select = producto.querySelector('select');
                const precio = select.options[select.selectedIndex].dataset.precio;
                const cantidad = producto.querySelector('input[name="cantidad[]"]').value;

                total += precio * cantidad;
                cantidadTotal += parseInt(cantidad);
            });

            // Calcular el impuesto (ej. 19%)
            impuesto = total * 0.19;

            // Aplicar el descuento solo si hay más de 5 productos
            if (cantidadTotal >= 5) {
                descuento = total * 0.10; // Ej. 10% de descuento
            } else {
                descuento = 0;
            }

            const abono = total * 0.30; // Abono del 30%

            // Asignar los valores calculados a los campos
            document.getElementById('valor_total').value = total - descuento;
            document.getElementById('impuesto').value = impuesto;
            document.getElementById('descuento').value = descuento;
            document.getElementById('abono').value = abono;
        }

        function validarStock() {
            const productos = document.querySelectorAll('.producto');
            let stockSuficiente = true;

            productos.forEach((producto) => {
                const select = producto.querySelector('select');
                const stock = parseInt(select.options[select.selectedIndex].dataset.stock);
                const cantidad = parseInt(producto.querySelector('input[name="cantidad[]"]').value);

                // Comprobar si la cantidad seleccionada excede el stock
                if (cantidad > stock) {
                    alert(`No hay stock suficiente para el producto: ${select.options[select.selectedIndex].text}`);
                    stockSuficiente = false;
                }
            });

            // Evitar que el formulario se envíe si el stock es insuficiente
            return stockSuficiente;
        }
    </script>
</body>
</html>
