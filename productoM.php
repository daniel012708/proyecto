<?php
class Producto {
    private $conexion;

    public function __construct() {
        $this->conexion = new PDO("mysql:host=localhost;dbname=gafra", "root"); 
    }

    // Método para registrar un nuevo producto
    public function Registrar($nombre_producto, $color, $descripcion, $valor, $cantidad_bodega) {
        $sentencia = $this->conexion->prepare("CALL registrarProducto(?, ?, ?, ?, ?)");
        $sentencia->bindParam(1, $nombre_producto);
        $sentencia->bindParam(2, $color);
        $sentencia->bindParam(3, $descripcion);
        $sentencia->bindParam(4, $valor);
        $sentencia->bindParam(5, $cantidad_bodega);
        $sentencia->execute();
        header("Location: panelproductos.php");
        exit();
    }

    // Método para consultar un producto por ID
    public function Consultar($id) {
        $sentencia = $this->conexion->prepare("CALL consultarProducto(?)");
        $sentencia->bindParam(1, $id);
        $sentencia->execute();
        return $sentencia->fetch(PDO::FETCH_ASSOC);
    }

    // Método para actualizar un producto
    public function Actualizar($id, $nombre_producto, $color, $descripcion, $valor, $cantidad_bodega) {
        $sentencia = $this->conexion->prepare("CALL actualizarProducto(?, ?, ?, ?, ?, ?)");
        $sentencia->bindParam(1, $id);
        $sentencia->bindParam(2, $nombre_producto);
        $sentencia->bindParam(3, $color);
        $sentencia->bindParam(4, $descripcion);
        $sentencia->bindParam(5, $valor);
        $sentencia->bindParam(6, $cantidad_bodega);
        $sentencia->execute();
        return "Actualización de producto exitosa";
    }

    // Método para eliminar un producto por ID
    public function Eliminar($id, $estado) {
        $sentencia = $this->conexion->prepare("CALL eliminarProducto(?, ?)");
        $sentencia->bindParam(1, $id);
        $sentencia->bindParam(2, $estado);
        $sentencia->execute();
        
        return "Estado del producto actualizado exitosamente";
    }
    
    // Método para consultar todos los productos
    public function ConsultarTodos() {
        $sentencia = $this->conexion->prepare("CALL consultarTodosLosProductos()");
        $sentencia->execute();
        return $sentencia->fetchAll(PDO::FETCH_ASSOC);
    }
    public function obtenerPrecioProducto($id_producto) {
        $sentencia = $this->conexion->prepare("SELECT valor FROM producto WHERE id = ?");
        $sentencia->bindParam(1, $id_producto);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $resultado['valor']; // Retorna el precio del producto
    }
}
?>
