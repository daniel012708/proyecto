<!-- navbar.php -->
<?php
    $modulo_por_defecto = isset($modulo) ? $modulo : 'servicios';
?>
<head>
    <link rel="stylesheet" type="text/css" href="navbar.css">
</head>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand logo" href="panel.php">
            <img src="https://cdn.leonardo.ai/users/87ff1cbb-7254-440f-8795-cf874b32b261/generations/a89b178e-c65c-4e5b-96c2-4f5ae900d0bd/Leonardo_Phoenix_Design_a_modern_and_sleek_logo_for_GAFRA_a_co_0.jpg?w=512" alt="Gafra Logo">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="panelusuarios.php?modulo=usuarios"><i class="fas fa-users"></i> Usuarios </a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" href="panelproductos.php"><i class="fas fa-imbox"></i> Productos </a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" href="panelpreorden.php"><i class="fa fa-calendar-o"></i> Pre Orden </a>
                </li>       
                <li class="nav-item">
                    <a class="nav-link" href="panelventas.php"><i class="fa fa-credit-card"></i> Ventas </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Cerrar Sesión</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<div class="title-section">
    <h1>Administrador</h1>
    <p>Gestiona tus  <?php echo htmlspecialchars($modulo_por_defecto); ?>!</p>
</div>