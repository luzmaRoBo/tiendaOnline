<?php
require_once "../logica/carritoLog.php";

if(isset($_POST["eliminarCarrito"])){
    eliminarProductoCarrito();
    header("Location: plantilla.php?pagina=carrito");
    exit();
}
if(isset($_POST["pagar"])){
    $pago =pagar();
}
?>

<section>
    <h1 class="h1Productos">Carrito de la compra</h1>
    <div class="productos">
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unidad</th>
                    <th>Total</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $carrito = verCarrito();
                    while ($fila = $carrito->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>". $fila['producto']. "</td>";
                        echo "<td>". $fila['cantidad']. "</td>";
                        echo "<td>". $fila['precioUnidad']. "</td>";
                        echo "<td>". $fila['total']. "</td>";
                        echo "<td>

                                <form action='' method='POST'>
                                    <input type='hidden' name='idCarrito' value='". $fila['idCarrito']. "'>
                                    <button class='elCa' type='submit' name='eliminarCarrito'><i class='bi bi-trash-fill'></i></button>
                                </form>

                            </td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
    <div>
        <h1 class="h1Productos"> 
            <?php
                $suma = 0;
                $total = totalCarrito(); 
                while($fila = $total->fetch_assoc()){
                    $suma += $fila['total'];
                }
                echo "Total a pagar: " . $suma . " €";
            ?> 
         </h1>
         <form action="" method="POST">
            <button id='añadir' type="submit" name="pagar">Pagar</button>
         </form>
         <h2><?php if(isset($pago)){echo $pago;}?></h2>
    </div>
</section>