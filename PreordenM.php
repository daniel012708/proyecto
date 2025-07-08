<?php
class PreOrden {
    private $conexion;

    // Constructor para inicializar la conexión a la base de datos
    public function __construct() {
        $this->conexion = new PDO("mysql:host=localhost;dbname=gafra", "root",); 
    }

        // Método para registrar una nueva pre-orden
        public function registrarPreOrden($fecha_solicitud, $destino, $metodo_entrega, $fecha_entrega, $metodo_pago, $valor_total, $abono, $impuesto, $descuento, $descripcion, $id_cliente_realiza, $id_logistica_alista) {
            // Insertar en la tabla 'pre_orden'
            $sentencia = $this->conexion->prepare("
                INSERT INTO pre_orden 
                (fecha_solicitud, destino, metodo_entrega, fecha_entrega, metodo_pago, valor_total, abono, impuesto, descuento, descripcion, id_cliente_realiza, id_logistica_alista, estado_preorden) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'activo')
            ");
            $sentencia->bindParam(1, $fecha_solicitud);
            $sentencia->bindParam(2, $destino);
            $sentencia->bindParam(3, $metodo_entrega);
            $sentencia->bindParam(4, $fecha_entrega);
            $sentencia->bindParam(5, $metodo_pago);
            $sentencia->bindParam(6, $valor_total);
            $sentencia->bindParam(7, $abono);
            $sentencia->bindParam(8, $impuesto);
            $sentencia->bindParam(9, $descuento);
            $sentencia->bindParam(10, $descripcion);
            $sentencia->bindParam(11, $id_cliente_realiza);
            $sentencia->bindParam(12, $id_logistica_alista);
            $sentencia->execute();
    
            // Devolver el ID de la pre-orden insertada
            return $this->conexion->lastInsertId();
        }
    
        public function registrarDetallePreOrden($id_preorden, $id_producto, $cantidad, $precio) {
            // Insertar el detalle de producto con la cantidad
            $sentencia = $this->conexion->prepare("
                INSERT INTO detalles_contiene (id_preorden, id_producto, cantidad, precio) 
                VALUES (?, ?, ?, ?)
            ");
            $sentencia->execute([$id_preorden, $id_producto, $cantidad, $precio]);
    
            // Restar la cantidad comprada del stock en la tabla producto
            $actualizarStock = $this->conexion->prepare("
                UPDATE producto SET cantidad_bodega = cantidad_bodega - ? WHERE id = ?
            ");
            $actualizarStock->execute([$cantidad, $id_producto]);
        }
        
    
    
        public function consultarTodasPreOrdenesActivas() {
            $sentencia = $this->conexion->prepare("CALL consultar_todas_pre_ordenes_activas()");
            $sentencia->execute();
            return $sentencia->fetchAll(PDO::FETCH_ASSOC); // Retorna todas las pre-órdenes activas
        }
    
        // Método para consultar una pre-orden específica por ID (si está activa)
        public function consultarPreOrdenPorIdActiva($id) {
            $sentencia = $this->conexion->prepare("CALL consultar_pre_orden_por_id_activa(?)");
            $sentencia->bindParam(1, $id, PDO::PARAM_INT);
            $sentencia->execute();
            return $sentencia->fetch(PDO::FETCH_ASSOC); // Retorna la pre-orden activa por ID
        }
        public function consultarVentaPorId($id_venta) {
            $sentencia = $this->conexion->prepare("CALL consultarVentaPorId(?)");
            $sentencia->bindParam(1, $id_venta, PDO::PARAM_INT);
            $sentencia->execute();
            return $sentencia->fetch(PDO::FETCH_ASSOC); // Devuelve la venta encontrada o null si no existe
        }
        public function obtenerDetallesPreorden($idPreorden) {
            $sentencia = $this->conexion->prepare("CALL obtenerDetallesPreorden(?)");
            $sentencia->bindParam(1, $idPreorden, PDO::PARAM_INT);
            $sentencia->execute();
            return $sentencia->fetchAll(PDO::FETCH_ASSOC); // Devuelve todos los detalles de la preorden
        }
        public function actualizarPreorden(
            $id, 
            $destino, 
            $metodo_entrega, 
            $fecha_entrega, 
            $metodo_pago, 
            $valor_total, 
            $abono, 
            $impuesto, 
            $descuento, 
            $descripcion, 
            $id_cliente, 
            $id_logistica
        ) {
            $sentencia = $this->conexion->prepare("CALL actualizarPreorden(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $sentencia->bindParam(1, $id);
            $sentencia->bindParam(2, $destino);
            $sentencia->bindParam(3, $metodo_entrega);
            $sentencia->bindParam(4, $fecha_entrega);
            $sentencia->bindParam(5, $metodo_pago);
            $sentencia->bindParam(6, $valor_total);
            $sentencia->bindParam(7, $abono);
            $sentencia->bindParam(8, $impuesto);
            $sentencia->bindParam(9, $descuento);
            $sentencia->bindParam(10, $descripcion);
            $sentencia->bindParam(11, $id_cliente);
            $sentencia->bindParam(12, $id_logistica);
            $sentencia->execute();
        
            return true;
        }
        
        public function obtenerProductosPorPreOrden($id_preorden) {
            // Preparar la consulta SQL para obtener los productos de la pre-orden
            $stmt = $this->conexion->prepare("
                SELECT 
                    dp.id_producto,
                    p.nombre_producto,
                    dp.cantidad,
                    dp.precio
                FROM detalles_contiene dp
                JOIN producto p ON dp.id_producto = p.id
                WHERE dp.id_preorden = ?");
            
            // Ejecutar la consulta con el ID de la pre-orden
            $stmt->execute([$id_preorden]);
        
            // Devolver los resultados en forma de arreglo
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function actualizarProductoPreOrden($id_preorden, $id_producto, $cantidad, $precio) {
            $stmt = $this->conexion->prepare("UPDATE detalles_contiene 
                SET cantidad = ?, precio = ?
                WHERE id_preorden = ? AND id_producto = ?");
            
            $stmt->execute([$cantidad, $precio, $id_preorden, $id_producto]);
        }
        public function agregarProductoPreOrden($id_preorden, $id_producto, $cantidad, $precio) {
            $stmt = $this->conexion->prepare("INSERT INTO detalles_contiene (id_preorden, id_producto, cantidad, precio) VALUES (?, ?, ?, ?)");
            $stmt->execute([$id_preorden, $id_producto, $cantidad, $precio]);
        }
        public function eliminarProductoPreOrden($id_preorden, $id_producto) {
            $stmt = $this->conexion->prepare("DELETE FROM detalles_contiene WHERE id_preorden = ? AND id_producto = ?");
            $stmt->execute([$id_preorden, $id_producto]);
        }
                

    // Método para cambiar el estado de una pre-orden
    public function eliminarPreorden($id) {
        // Llamar al procedimiento almacenado que cambia el estado de la preorden a 'inactivo'
        $stmt = $this->conexion->prepare("CALL eliminarPreOrden(?)");
        $stmt->execute([$id]);
    }

    public function verificarVentaExistente($idPreorden) {
        $sentencia = $this->conexion->prepare("SELECT COUNT(*) as total FROM venta WHERE id_preorden = ?");
        $sentencia->bindParam(1, $idPreorden, PDO::PARAM_INT);
        $sentencia->execute();
        $resultado = $sentencia->fetch(PDO::FETCH_ASSOC);
        return $resultado['total'] > 0;
    }
    public function autorizarVenta($idPreorden) {
        // Verificar si ya existe una venta para esta pre-orden
        if ($this->verificarVentaExistente($idPreorden)) {
            throw new Exception("La pre-orden ya ha sido autorizada como venta.");
        }
        $query = "UPDATE pre_orden SET estado_venta = 'autorizada' WHERE id = :id AND estado_venta = 'pendiente'";
    
        $stmt = $this->conexion->prepare($query);
        $stmt->bindParam(':id', $idPreorden, PDO::PARAM_INT);
        
        // Ejecutar la consulta y verificar si afectó alguna fila
        if ($stmt->execute()) {
            if ($stmt->rowCount() == 0) {
                throw new Exception("La pre-orden ya ha sido autorizada o no se encontró.");
            }
        } else {
            throw new Exception("Error al autorizar la pre-orden.");
        }
        // Si no existe, proceder con la autorización de la venta
        $sentencia = $this->conexion->prepare("CALL autorizar_venta_preorden(?)");
        $sentencia->bindParam(1, $idPreorden, PDO::PARAM_INT);
        $sentencia->execute();
    }


    public function eliminarVenta($id_venta) {
        $sentencia = $this->conexion->prepare("CALL eliminar_venta(?)");
        return $sentencia->execute([$id_venta]);
    }
    
    
}
?>
