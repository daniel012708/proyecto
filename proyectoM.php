<?php
class Usuario {
    private $conexion;

    public function __construct() {
        $this->conexion = new PDO("mysql:host=localhost;dbname=gafra", "root"); // Añadir la contraseña si es necesaria
    }

    public function Registrar($nombre, $tipo_usuario, $nom_usuario, $contrasena, $correo_electronico, $direccion, $telefono, $documento_identidad, $eps, $tipo_sangre, $RH, $estado_civil) {
        $sentencia = $this->conexion->prepare("CALL registrar_usuario(NULL, ?, ?, ?, ?, ?, 'activo', ?, ?, ?, ?, ?, ?, ?)");
        $sentencia->bindParam(1, $nombre);
        $sentencia->bindParam(2, $tipo_usuario);
        $sentencia->bindParam(3, $nom_usuario);
        $sentencia->bindParam(4, $contrasena);
        $sentencia->bindParam(5, $correo_electronico);
        $sentencia->bindParam(6, $direccion);
        $sentencia->bindParam(7, $telefono);
        $sentencia->bindParam(8, $documento_identidad);
        $sentencia->bindParam(9, $eps);
        $sentencia->bindParam(10, $tipo_sangre);
        $sentencia->bindParam(11, $RH);
        $sentencia->bindParam(12, $estado_civil);
        $sentencia->execute();
        header("Location: Login.html");
        exit(); // Importante: detener la ejecución del script después de la redirección
    
    }



    // Método para iniciar sesión
    public function Login($nom_usuario, $contrasena) {
        $sentencia = $this->conexion->prepare("CALL login(?, ?)");
        $sentencia->bindParam(1, $nom_usuario);
        $sentencia->bindParam(2, $contrasena);
        $sentencia->execute();
 

        // agregar condicional para que cada usuario lo dirija a una interfaz diferente

        return $sentencia->fetch(PDO::FETCH_ASSOC); // Retorna el usuario si existe
    }

    // Método para consultar un usuario específico por ID
    public function Consultar($id) {
        $sentencia = $this->conexion->prepare("CALL consultar_usuario(?)");
        $sentencia->bindParam(1, $id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC); // Retorna los datos del usuario
    }

    // Método para consultar todos los usuarios activos
    public function ConsultarGeneral() {
        $sentencia = $this->conexion->prepare("CALL consulta_general_usuario()");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC); // Retorna todos los usuarios activos
    }

// Método para actualizar un usuario
public function Actualizar(
    $id, $nombre, $tipo_usuario, $nom_usuario, $contrasena, 
    $correo_electronico, $estado_usuario, $direccion, $telefono, 
    $documento_identidad, $eps, $tipo_sangre, $RH, $estado_civil
) {
    // Preparar la sentencia para el procedimiento almacenado
    $sentencia = $this->conexion->prepare("CALL actualizar_usuario(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Asociar los parámetros con el procedimiento
    $sentencia->bindParam(1, $id);
    $sentencia->bindParam(2, $nombre);
    $sentencia->bindParam(3, $tipo_usuario);
    $sentencia->bindParam(4, $nom_usuario);
    $sentencia->bindParam(5, $contrasena);
    $sentencia->bindParam(6, $correo_electronico);
    $sentencia->bindParam(7, $estado_usuario);
    $sentencia->bindParam(8, $direccion);
    $sentencia->bindParam(9, $telefono);
    $sentencia->bindParam(10, $documento_identidad);
    $sentencia->bindParam(11, $eps);
    $sentencia->bindParam(12, $tipo_sangre);
    $sentencia->bindParam(13, $RH);
    $sentencia->bindParam(14, $estado_civil);

    // Ejecutar la sentencia
    $sentencia->execute();

    return "Actualización exitosa";
}


    // Método para eliminar un usuario (cambia el estado a inactivo)
    public function Eliminar($id) {
        $sentencia = $this->conexion->prepare("CALL eliminar_usuario(?)");
        $sentencia->bindParam(1, $id);
        $sentencia->execute();
        return "Usuario inactivado exitosamente";
    }
    public function obtenerUsuarioLogistico() {
        // Obtener todos los usuarios de logística
        $sentencia = $this->conexion->prepare("SELECT id FROM usuario WHERE tipo_usuario = 'logistica'");
        $sentencia->execute();
        $usuariosLogistica = $sentencia->fetchAll(PDO::FETCH_ASSOC);
    
        // Verificar que hay usuarios logísticos disponibles
        if (count($usuariosLogistica) > 0) {
            // Seleccionar un usuario de manera aleatoria
            $indiceAleatorio = array_rand($usuariosLogistica);
            return $usuariosLogistica[$indiceAleatorio]['id'];
        } else {
            // Si no hay usuarios logísticos, puedes manejar el error de alguna manera
            return null; // O lanzar una excepción según sea necesario
        }
    }



    // Método para obtener los datos del usuario
    public function obtenerUsuarioPorId($userId) {
        $sql = "SELECT * FROM usuarios WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Método para actualizar los datos del usuario
    public function actualizarUsuario($nombre, $email, $password, $userId) {
        $sql = "UPDATE usuarios SET nombre = :nombre, email = :email, password = :password WHERE id = :id";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':id', $userId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}


?>

