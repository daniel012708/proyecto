<?php
// Iniciar la sesión al comienzo de la página
session_start();
include 'session_check.php'; // Incluir la verificación del estado del usuario


// Verificar si el usuario ha iniciado sesión (si existe la variable 'usuario' en la sesión)
$isLoggedIn = isset($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Gafra | Inicio</title>
	<link rel="stylesheet" href="estilos.css" />
</head>

<body>
	<header>
		<div class="container-hero">
			<div class="container hero">
				<div class="container-logo">
					<img class="imgh"
						src="https://cdn.leonardo.ai/users/87ff1cbb-7254-440f-8795-cf874b32b261/generations/a89b178e-c65c-4e5b-96c2-4f5ae900d0bd/Leonardo_Phoenix_Design_a_modern_and_sleek_logo_for_GAFRA_a_co_1.jpg"
						alt="Gafra logo">
					<h1 class="logo"><a href="/">Industria Gafra</a></h1>
				</div>
				<div>
					<div class="container-user">
						<?php if (!$isLoggedIn): ?> <!-- Mostrar solo si no está logueado -->
							<a href="Login.html" class="login-button">Iniciar sesión</a>
						<?php else: ?> <!-- Si está logueado -->
							<p class="welcome-message">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario']); ?>!</p>
							<a href="logout.php" class="logout-button">Cerrar sesión</a> <!-- Botón de cerrar sesión -->
						<?php endif; ?>
						<div class="divider"></div>
						<i class="fa-solid fa-cart-arrow-down"></i>
						<div class="content-shopping-cart">
							<span class="text">Carrito</span>
							<span class="number">(0)</span>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="container-navbar">
			<nav class="navbar container">
				<i class="fa-solid fa-bars"></i>
				<ul class="menu">
					<li><a href="#">Inicio</a></li>
					<li><a href="#" id="link-productos">Productos</a></li>
					<li><a href="contacto.php">Contacto</a></li>
				</ul>
			</nav>
		</div>
	</header>

	<section class="banner">
		<div class="content-banner">
			<h2>Bienvenidos a <br />Industria Gafra</h2>
			<a href="preordenregistro2.php">Comprar ahora</a>
		</div>
	</section>

	<main class="main-content">
		<section id="productos" class="container top-categories"> 
			<h1 class="heading-1">Categorías de Productos</h1>
			<div class="container-categories">
				<!-- Corrales -->
				<div class="card-category category-moca">
					<p>Corrales</p>
					<span onclick="window.location.href='consultaproducto2.php'">Ver más</span>
				</div>

				<!-- Mecedoras -->
				<div class="card-category category-expreso">
					<p>Mecedoras</p>
					<span onclick="window.location.href='consultaproducto2.php'">Ver más</span>
				</div>

				<!-- Colchonetas -->
				<div class="card-category category-capuchino">
					<p>Colchonetas</p>
					<span onclick="window.location.href='consultaproducto2.php'">Ver más</span>
				</div>
			</div>
		</section>

	<footer class="footer">
		<div class="container container-footer">
			<div class="menu-footer">
				<div class="contact-info">
					<p class="title-footer">Información de Contacto</p>
					<ul>
						<li>
							Dirección: 71 Pennington Lane Vernon Rockville, CT
							06066
						</li>
						<li>Teléfono: 123-456-7890</li>
						<li>Fax: 55555300</li>
						<li>EmaiL: baristas@support.com</li>
					</ul>
					<div class="social-icons">
						<span class="facebook">
							<a href="https://www.facebook.com/"><i class="fa-brands fa-facebook-f"></i></a>
						</span>
						<span class="twitter">
							<a href="https://x.com/?lang=es"><i class="fa-brands fa-twitter"></i></a>
						</span>
						<span class="instagram">
							<a href="https://www.instagram.com/"><i class="fa-brands fa-instagram"></i></a>
						</span>
					</div>
				</div>

				<div class="information">
					<p class="title-footer">Información</p>
					<ul>
						<li><a href="#">Acerca de Nosotros</a></li>
						<li><a href="#">Información Delivery</a></li>
						<li><a href="#">Politicas de Privacidad</a></li>
						<li><a href="#">Términos y condiciones</a></li>
						<li><a href="#">Contactános</a></li>
					</ul>
				</div>

				<div class="my-account">
					<p class="title-footer">Mi cuenta</p>

					<ul>
						<li><a href="#">Mi cuenta</a></li>
						<li><a href="#">Historial de ordenes</a></li>
						<li><a href="#">Lista de deseos</a></li>
						<li><a href="#">Boletín</a></li>
						<li><a href="#">Reembolsos</a></li>
					</ul>
				</div>

				<div class="newsletter">
					<p class="title-footer">Boletín informativo</p>

					<div class="content">
						<p>
							Suscríbete a nuestros boletines ahora y mantente al
							día con nuevas colecciones y ofertas exclusivas.
						</p>
						<input type="email" placeholder="Ingresa el correo aquí...">
						<button>Suscríbete</button>
					</div>
				</div>
			</div>

			<div class="copyright">
				<p>
					Desarrollado por CyS Web Develoment Company &copy; 2024
				</p>
 			</div>
		</div>
	</footer>

	<!-- Script para manejar el desplazamiento suave a la sección de productos -->
	<script>
	    // Esperar que el DOM esté completamente cargado
	    document.addEventListener('DOMContentLoaded', function () {
	        // Seleccionamos el enlace de productos y la sección de productos
	        const linkProductos = document.getElementById('link-productos');
	        const sectionProductos = document.getElementById('productos');

	        // Agregamos un evento de clic al enlace de productos
	        linkProductos.addEventListener('click', function (event) {
	            event.preventDefault(); // Evita el comportamiento por defecto del enlace

	            // Realizar el scroll suave hasta la sección de productos
	            sectionProductos.scrollIntoView({ behavior: 'smooth' });
	        });
	    });
	</script>
	<script src="https://kit.fontawesome.com/81581fb069.js" crossorigin="anonymous"></script>
</body>

</html>
