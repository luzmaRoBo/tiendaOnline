<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../logica/conexionBD.php";

function verProductos() {
    $conexion = conectarBD();
    
    $stmt = $conexion->prepare("SELECT * FROM productos");
    $stmt->execute();
    $listado = $stmt->get_result();

    if ($listado->num_rows > 0) {
        while ($producto = $listado->fetch_assoc()) {
            echo '<div id="producto">';
            echo "    <div id='foto'><img class='fotoPro' src='{$producto['foto']}'></div>";
            echo '    <div id="datos">';
            echo "        <h5 class='titulo'>{$producto['nombre']}</h5>";
            echo "        <p id='descrip'>{$producto['descripcion']}</p>";
            echo "        <p id='precio'>Precio: {$producto['precio_venta']} €</p>";
            echo "        <p id='precio'>Stock: {$producto['stock']} unidades</p>";
            if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario')://si no es usuario no puede verlo
            echo "        <form action='plantilla.php?pagina=productos' method='POST'>";
            echo "            <input type='hidden' name='idProdCarrito' value='{$producto['id']}'>"; // ID del producto
            echo "            <input type='number' name='cantidad' placeholder='unidades a comprar' required>";
            echo "            <button type='submit' id='añadir' name='addProducto'>Añadir al carrito</button>"; // Botón de envío
            echo "        </form>";
            endif;
            echo '    </div>';
            if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin')://si no es administrador no puede verlo
            echo "    <div class='botonesAccion'>";

            echo "        <form action='plantilla.php?pagina=productos' method='POST'>";
            echo "            <input type='hidden' name='idProducto' value='{$producto['id']}'>";
            echo "            <button type='submit' class='botonModificar' name='modificarPro'>Modificar</button>";
            echo "        </form>";

            echo "        <form action='' method='POST' onsubmit='return confirmarEliminacion();'>";
            echo "            <input type='hidden' name='idProducto' value='{$producto['id']}'>";
            echo "            <button type='submit' class='botonEliminar' name='eliminarPro'>Eliminar</button>";
            echo "        </form>";

            echo "    </div>";
            endif;
            echo '</div>';
        }
    }

    // Cerrar la conexión
    $conexion->close();

}

function agregarProducto(){
    $conexion = conectarBD();

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        if (empty($_POST["producto"]) || empty($_POST["descripcion"]) || empty($_POST["precio"]) || empty($_POST["stock"]) || empty($_POST["foto"])) {
            die("Todos los campos son obligatorios.");
        }
        $producto = htmlspecialchars($_POST["producto"]);
        $descripcion = htmlspecialchars($_POST["descripcion"]);
        $precio = $_POST["precio"];
        $stock = $_POST["stock"];
        $foto = htmlspecialchars($_POST["foto"]);

        if($_POST["precio"] <= 0){
            die("El precio del producto debe ser mayor que 0.");
        }
        if($stock <= 0){
            die("El stock del producto no puede ser negativo.");
        } 


        $stmt = $conexion->prepare("INSERT INTO productos (nombre, descripcion, precio_venta, stock,  foto) VALUES (?,?,?,?,?)");
        $stmt->bind_param("ssdis", $producto, $descripcion, $precio, $stock, $foto);

        if($stmt->execute()){
            echo "Producto añadido correctamente.";
        } else {
            echo "Error al añadir el producto: ". $stmt->error;
        }

        $stmt->close();
        }

    $conexion->close();

}

function editarProducto($idProducto){
    $conexion = conectarBD();

    // 1. Obtener producto
    $stmt = $conexion->prepare("SELECT * FROM productos WHERE id=?");
    $stmt->bind_param("i", $idProducto);
    if (!$stmt->execute()) {
        echo "Error en la consulta SELECT: ".$stmt->error;
        return null;
    }
    $resultado = $stmt->get_result();
    $producto = ($resultado->num_rows > 0) ? $resultado->fetch_assoc() : null;
    $stmt->close();

    // 2. Si el formulario de actualización está presente
    if (isset($_POST["actualizarProducto"]) && !empty($_POST["actualizarProducto"])) {
        
        // Recoger datos
        $nombre      = htmlspecialchars($_POST["producto"]);
        $descripcion = htmlspecialchars($_POST["descripcion"]);
        $precio      = $_POST["precio"];
        $stock       = $_POST["stock"];
        $foto        = htmlspecialchars($_POST["foto"]);

        // Validaciones
        if ($precio <= 0) {
            die("El precio del producto debe ser mayor que 0.");
        }
        if ($stock < 0) {
            die("El stock no puede ser negativo.");
        }

        // 3. Actualizar
        $stmt = $conexion->prepare("UPDATE productos SET nombre=?, descripcion=?, precio_venta=?, stock=?, foto=? WHERE id=?");
        $stmt->bind_param("ssdisi", $nombre, $descripcion, $precio, $stock, $foto, $idProducto);

        if($stmt->execute()){
            echo "Producto actualizado correctamente.";
            
        } else {
            echo "Error al actualizar el producto: " . $stmt->error;
        }
        
        $stmt->close();
    }

    $conexion->close();
    return $producto;
}

function eliminarProducto(){
    $conexion = conectarBD();

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (empty($_POST["idProducto"])) {
            die("No se ha seleccionado ningún producto.");
        }

        $idRecibido = $_POST["idProducto"];

        $stmt = $conexion->prepare("DELETE FROM productos WHERE id =?");
        $stmt->bind_param("i", $idRecibido);

        if($stmt->execute()){
            echo "Producto eliminado correctamente.";
        } else {
            echo "Error al eliminar el producto: ". $stmt->error;
        }
        
        $stmt->close();
    }
    
    $conexion->close();
}


function agregarCarrito(){
    $conexion = conectarBD();

    if(isset($_POST["idProdCarrito"]) && isset($_POST["cantidad"])){

        $idProducto = $_POST["idProdCarrito"];
        $idUsu = $_SESSION["id"];
        $cantidad = $_POST["cantidad"];

        //PRIMERA CONSULTA PARA COJER LOS DATOS DEL PRODUCTO SI EXISTE
        //si no hay nada en el carrito preparamos la consulta para insertar los datos en la tabla carrito
        $stmt = $conexion->prepare("SELECT * FROM productos WHERE id =?");
        $stmt->bind_param("i", $idProducto);
        $stmt->execute();
        //obtenemos los datos del producto
        $resultado = $stmt->get_result();
        //si hay resultados obtenemos cada fila en un array asociativo
        if($resultado -> num_rows > 0){
            $fila = $resultado->fetch_assoc();

            //almacenamos los datos necesarios de la fila
            $producto = $fila["nombre"];
            $precio = (float) $fila["precio_venta"];
            $total = round($cantidad * $precio, 2);

            //comprobamos que hay suficiente stock para comprar.
            if($fila["stock"] < $cantidad){
                echo "No hay stock suficiente para la cantidad deseada.";
                $stmt->close();
                $conexion->close();
                return;
            }

            //SEGUNDA CONSULTA PARA COMPROBAR SI YA HAY UNA FILA EN CARRITO CON ESE PRODUCTO Y EL MISMO IDUSUARIO
            //consultamos los datos de carrito para ver si hay algo con el mismo idProducto y el mismo idUsuario
            $stmt = $conexion->prepare("SELECT * FROM carrito WHERE idUsuario =? AND idProducto =?");
            $stmt->bind_param("ii", $idUsu, $idProducto);
            $stmt->execute();

            $resultado = $stmt->get_result();
            //si hay resultados obtenemos cada fila en un array asociativo
            if($resultado -> num_rows > 0){
                $fila = $resultado->fetch_assoc();
                //actualizamos la cantidad
                $stmt = $conexion->prepare("UPDATE carrito SET cantidad = cantidad + ?, total = total + ? WHERE idUsuario = ? AND idProducto = ?");
                $nuevoTotal = round($cantidad * $precio, 2);
                $stmt->bind_param("idii", $cantidad, $nuevoTotal, $idUsu, $idProducto);
                $stmt->execute();
                echo "Producto añadido al carrito correctamente.";
                $stmt->close();

            }else{
                //preparamos la consulta para insertar los datos en la tabla carrito
                $stmt = $conexion->prepare("INSERT INTO carrito (idUsuario, idProducto, producto, cantidad, precioUnidad, total) VALUES (?,?,?,?,?,?)");
                $stmt -> bind_param("iisidd", $idUsu, $idProducto, $producto, $cantidad, $precio, $total);
                //ejecutamos la consulta
                if($stmt->execute()){
                    echo "Producto añadido al carrito correctamente.";
                }else{
                    echo "Error al añadir el producto al carrito: ". $stmt->error;
                }
                $stmt->close();
            }
            //ULTIMA CONSULTA PARA ACTUALIZAR EL STOCK EN PRODUCTOS
            //preparamos la consulta para actualizar el stock del producto
            $stmt = $conexion->prepare("UPDATE productos SET stock = stock -? WHERE id =?");
            $stmt->bind_param("ii", $cantidad, $idProducto);
            //ejecutamos la consulta
            if($stmt->execute()){
                echo "Stock actualizado correctamente.";
            }else{
                echo "Error al actualizar el stock: ". $stmt->error;
            }
            
            $stmt->close();

        }else{
            echo "No se ha encontrado el producto.";
            $stmt->close();
        }
        
    }
    
    $conexion->close();
}





?>