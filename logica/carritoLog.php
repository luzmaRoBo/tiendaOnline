<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
    require_once "../logica/conexionBD.php";

    
    function verCarrito() {
        $conexion = conectarBD();

        $stmt = $conexion->prepare("SELECT * FROM carrito WHERE idUsuario=?");
        $stmt->bind_param("i", $_SESSION['id']);
        $stmt->execute();

        $listado = $stmt->get_result();
        return $listado;

    }

    function eliminarProductoCarrito() {
        $conexion = conectarBD();
        //capturamos el id del carrito que se quiere eliminar.
        if(isset($_POST["idCarrito"])) {
            $idCarrito = $_POST['idCarrito'];
    
            // Seleccionamos el registro en el carrito para obtener el id del producto.
            $stmt = $conexion->prepare("SELECT * FROM carrito WHERE idCarrito = ? AND idUsuario = ?");
            $stmt->bind_param("ii", $idCarrito, $_SESSION['id']);
            $stmt->execute();
            $resultado = $stmt->get_result();
            //si hay resultados obtenemos cada fila en un array asociativo y obtenemos el id del producto y la cantidad en el carrito
            if ($resultado->num_rows > 0) {
                $fila = $resultado->fetch_assoc();
                $idProducto = $fila['idProducto'];
                $cantidad = $fila['cantidad'];
                $precio = round((float)$fila['precioUnidad'], 2);
                $nuevoTotal = round($fila['total'] - $precio, 2);
                //si la cantidad es mayor a 1
                if ($cantidad > 1) {
                    // Si hay más de una unidad, se resta 1 actualizando el carrito
                    $stmt = $conexion->prepare("UPDATE carrito SET cantidad = cantidad - 1, total = ? WHERE idCarrito = ? AND idUsuario = ?");
                    $stmt->bind_param("dii",$nuevoTotal, $idCarrito, $_SESSION['id']);
                    $stmt->execute();
                    $stmt->close();
                } else {
                    // Si solo hay 1 unidad, se elimina la fila completa del carrito.
                    $stmt = $conexion->prepare("DELETE FROM carrito WHERE idCarrito = ? AND idUsuario = ?");
                    $stmt->bind_param("ii", $idCarrito, $_SESSION['id']);
                    $stmt->execute();
                    $stmt->close();
                }
    
                // Actualizamos el stock del producto sumando 1 (pues se retiró una unidad).
                $stmt = $conexion->prepare("UPDATE productos SET stock = stock + 1 WHERE id = ?");
                $stmt->bind_param("i", $idProducto);
                $stmt->execute();
                $stmt->close();
    
                echo "Producto eliminado correctamente.";
            }
        }
        $conexion->close();
    }

    function totalCarrito() {
        $conexion = conectarBD();
        $idUsuario = $_SESSION['id'];

        $stmt = $conexion->prepare("SELECT total FROM carrito WHERE idUsuario =?");
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();

        $resultado = $stmt->get_result();
        return $resultado;
    
        $stmt->close();
        $conexion->close();
    }

    function pagar(){
        $conexion = conectarBD();
        $idUsuario = $_SESSION['id'];
        
        $stmt = $conexion->prepare("DELETE FROM carrito WHERE idUsuario =?");
        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();

        return "Compra realizada correctamente.";

        $stmt->close();
        $conexion->close();


    }

?>