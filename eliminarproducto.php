<?php
// Iniciar la sesión
session_start();
include 'session_check.php'; // Incluir la verificación del estado del usuario


// Verificar si el usuario está autenticado
if (!isset($_SESSION['user_id'])) {
    header("Location: Login.html"); // Redirigir a la página de login si no está autenticado
    exit();
}

include 'productoM.php'; // Incluimos la clase Producto

$productoModel = new Producto();

// Si se presiona el botón "eliminar", se elimina el producto con el ID correspondiente
if (isset($_POST['eliminar'])) {
    $id = $_POST['id'];
    $estado = 'inactivo'; // Define el estado a aplicar ('activo' o 'inactivo')
    
    $productoModel->Eliminar($id, $estado);
    
    echo "<script>
            alert('El producto ha sido eliminado exitosamente.');
            window.location.href = 'consultaproducto.php';
          </script>";
}


// Consultamos todos los productos para mostrarlos en la tabla
$productos = $productoModel->ConsultarTodos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Productos</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f4f7fa;
        }
        
        .navbar {
            background-color: #1746A2;
            padding: 10px 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar-brand img {
            width: 50px;
        }

        .navbar-nav {
            flex-direction: row;
            gap: 20px;
        }

        .nav-link {
            color: #fff !important;
            padding: 8px 12px;
            transition: color 0.3s ease;
            font-weight: bold;
            font-size: 16px;
        }

        .nav-link:hover {
            color: #d4d9f2 !important;
        }

        .contact-btn {
            background-color: #FFD84C;
            color: #1a2a33;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: bold;
            border: none;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .contact-btn:hover {
            background-color: #f8c542;
            transform: scale(1.1);
        }

        .table-container {
            margin-top: 70px;
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .table {
            border-collapse: separate;
            border-spacing: 0 15px;
        }

        .table-striped tbody tr {
            transition: all 0.3s ease;
        }

        .table-striped tbody tr:hover {
            background-color: #f1f3f8;
        }

        .table thead th {
            background-color: #1746A2;
            color: white;
            border: none;
            border-radius: 10px 10px 0 0;
        }

        .table td, .table th {
            border: none;
            padding: 15px;
            text-align: center;
        }

        .btn-danger {
            transition: background-color 0.3s ease, transform 0.2s;
        }

        .btn-danger:hover {
            background-color: #dc3545;
            transform: translateY(-2px);
        }

        .btn-confirm {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
            transition: background-color 0.3s;
        }

        .btn-confirm:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">
            <img src="logo-white.JPG" alt="Logo"> <!-- Reemplaza con tu logo -->
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="Consultaproducto.php">Productos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="registroproducto.php">Agregar Producto</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link back-button" href="javascript:void(0);" onclick="history.back();">Regresar</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                </li>
                <!-- Botón de Inicio -->
                <li class="nav-item">
                    <a class="nav-link" href="panel.php">
                        <i class="fas fa-home"></i> Inicio
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container table-container">
        <h2 class="text-center mb-4">Lista de Productos</h2>

        <!-- Mostrar todos los productos con botón para Eliminar -->
        <?php if (isset($productos) && count($productos) > 0): ?>
            <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Color</th>
                        <th>Descripción</th>
                        <th>Valor</th>
                        <th>Cantidad en Bodega</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr>
                            <td><?= $producto['id'] ?></td>
                            <td><?= $producto['nombre_producto'] ?></td>
                            <td><?= $producto['color'] ?></td>
                            <td><?= $producto['descripcion'] ?></td>
                            <td><?= $producto['valor'] ?></td>
                            <td><?= $producto['cantidad_bodega'] ?></td>
                            <td>
                                <!-- Botón para eliminar producto con modal de confirmación -->
                                <form action="" method="POST" class="d-inline">
                                    <input type="hidden" name="id" value="<?= $producto['id'] ?>">
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#confirmModal" data-id="<?= $producto['id'] ?>">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="alert alert-info">No hay productos disponibles.</div>
        <?php endif; ?>
    </div>

    <!-- Modal de confirmación -->
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="confirmModalLabel">Confirmar Eliminación</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            ¿Estás seguro de que deseas eliminar este producto?
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            <button type="button" class="btn btn-confirm" id="confirmDelete">Sí, eliminar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Scripts de Bootstrap y jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        let deleteId;
        $('#confirmModal').on('show.bs.modal', function (event) {
            const button = $(event.relatedTarget);
            deleteId = button.data('id');
        });

        $('#confirmDelete').on('click', function () {
            $('<form action="" method="POST">' +
              '<input type="hidden" name="id" value="' + deleteId + '">' +
              '<input type="hidden" name="eliminar" value="1">' +
              '</form>').appendTo('body').submit();
        });
    </script>
</body>
</html>
