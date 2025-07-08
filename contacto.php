<?php
// Incluimos PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Verificamos si el formulario ha sido enviado
$messageSent = false;
$errorMessage = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require 'vendor/autoload.php';  // Ruta hacia autoload de Composer para PHPMailer

    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Validamos que no estén vacíos
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Configuración PHPMailer
        $mail = new PHPMailer(true);

        try {
            // Configuración del servidor SMTP
            $mail->isSMTP();
            $mail->Host = 'smtp.tu-servidor.com'; // Cambia esto por tu servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'tu-correo@ejemplo.com'; // Tu correo
            $mail->Password = 'tu-contraseña'; // Tu contraseña
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Destinatario
            $mail->setFrom($email, $name);
            $mail->addAddress('destinatario@ejemplo.com'); // A quién enviarás el correo

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Nuevo mensaje de contacto';
            $mail->Body    = "<h3>Tienes un nuevo mensaje de contacto</h3>
                              <p><strong>Nombre:</strong> $name</p>
                              <p><strong>Email:</strong> $email</p>
                              <p><strong>Mensaje:</strong> $message</p>";

            // Enviamos el correo
            $mail->send();
            $messageSent = true;
        } catch (Exception $e) {
            $errorMessage = "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        $errorMessage = 'Por favor, completa todos los campos.';
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
        * {
            font-family: 'Montserrat', sans-serif;
            margin: 0;
            padding: 0;
        }
        
        body {
            background-image: url('https://cdn.leonardo.ai/users/87ff1cbb-7254-440f-8795-cf874b32b261/generations/b78253dd-5741-46d1-af19-10571a6ee299/Leonardo_Phoenix_Create_a_visually_stunning_and_intuitive_imag_3.jpg');
            display: inline;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-size: 2200px;
            background-position: center;
            background-color: #f8f9fa;
            margin: 0;
        }
        
        .tipoU {
            display: none;
        }
        
        .container {
            width: 500px;
            padding: 30px;
            border: 1px solid #ced4da;
            border-radius: 25px;
            background-color: rgb(255 255 255 / 64%);
            box-shadow: 0 10px 20px rgb(0 0 0);
            backdrop-filter: blur(15px);
            animation: fadeIn 0.5s ease-in;
        }

        .login-header {
            display: flex;
            justify-content: center;  
            align-items: center;     
            margin-bottom: 20px;      
        }

        .login-header img {
            max-width: 100px;         
            height: auto;          
        }
        
        h2 {
            text-align: center;
            font-weight: 600;
            margin-bottom: 20px;
        }
        
        .form-label {
            font-weight: 400;
        }
        
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 12px 183px;
            border-radius: 30px;
            font-weight: bold;
            color: white;
            transition: background-color 0.3s, transform 0.2s;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            background-color: #0056b3;
            transform: translateY(-2px);
        }
        .TipoU {
            display: none;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>

<?php include 'migaDePan.php'; ?>
<div class="container mt-5">
    <h2 class="text-center mb-4">Formulario de Contacto</h2>

    <!-- Mostrar mensaje de éxito o error -->
    <?php if ($messageSent): ?>
        <div class="alert alert-success">¡Tu mensaje ha sido enviado con éxito!</div>
    <?php elseif (!empty($errorMessage)): ?>
        <div class="alert alert-danger"><?php echo $errorMessage; ?></div>
    <?php endif; ?>

    <form id="contactForm" method="POST" action="" novalidate>
        <div class="mb-3">
            <label for="name" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="name" name="name" required>
            <div class="invalid-feedback">Por favor, introduce tu nombre.</div>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico:</label>
            <input type="email" class="form-control" id="email" name="email" required>
            <div class="invalid-feedback">Por favor, introduce un correo válido.</div>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Descripción del problema, duda o inquietud:</label>
            <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
            <div class="invalid-feedback">Por favor, escribe tu mensaje.</div>
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('contactForm');
        
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            
            form.classList.add('was-validated');
        }, false);
    });
</script>
</body>
</html>
