<?php
require_once "../logica/productosLog.php";
    //llamo a la funcion de agregar producto
    if(isset($_POST["addPro"])){
        agregarProducto();
        header("Location: plantilla.php?pagina=productos");
        exit();
    }

    //llamo a la funcion de eliminar producto
    if(isset($_POST["eliminarPro"])){
        eliminarProducto();
        header("Location: plantilla.php?pagina=productos");
        exit();
    }

    if (isset($_POST["modPro"])) {
        editarProducto($_POST["idProducto"]);
        header("Location: plantilla.php?pagina=productos");
        exit();
    }

    if(isset($_POST["addProducto"])){
        agregarCarrito();
        header("Location: plantilla.php?pagina=productos");
        exit();
    }


?>
<section>
    <h1 class="h1Productos">Listado de productos</h1>
    <div class="productos">
        <?php

        //llamamos a la función para mostrar la lista de productos
        verProductos();

        ?>
    </div>
    <!-- si no es administrador no puede ver este boton -->
    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
        <div id="botonAñadir">
            <button id="añadirPro" type="button" onclick="abrirModal()">Añadir producto</button>
        </div>
    <?php endif; ?>
</section>

<!--=====================================
        VENTANA MODAL
======================================-->

<div id="modal" class="modal">
    <div class="cabeceraModal">
        <div class="titulo"><h2>añadir producto</h2></div>
        <div class="cerrar"><button class="botonCerrar" type="buton" onclick="cerrar()">X</button></div>
    </div>
    <form id="formModal" action="" method="post">
        <input id="inputModal" type="text" name="producto" placeholder="producto" require>
        <textarea placeholder="descripcion" name="descripcion" require></textarea>
        <input id="inputModal" type="number" step="0.01" name="precio" placeholder="precio" require>
        <input id="inputModal" type="number" name="stock" placeholder="stock" require>
        <input id="inputModal" type="text" name="foto" placeholder="foto" require>
        <button id="añadirPro" type="submit" name="addPro">Añadir producto</button>
    </form>

</div>

<?php
    if (!empty($_POST["idProducto"])) {
        $productoEditar = editarProducto($_POST["idProducto"]);
    }
?>

<div id="modal1" class="modal" style="<?php echo isset($productoEditar) ? 'display:block;' : 'display:none;'; ?>">
    
    <div class="cabeceraModal">
        <div class="titulo"><h2>Modificar producto</h2></div>
        <div class="cerrar"><button class="botonCerrar" type="button" onclick="cerrar1()">X</button></div>
    </div>

    <form id="formModal" action="" method="post">
        <input type="hidden" name="idProducto" value="<?php echo $productoEditar['id'] ?? ''; ?>">

        <input type="hidden" name="actualizarProducto" value="<?php echo $productoEditar['id'] ?? ''; ?>">

        <input id="inputModal" type="text" name="producto" value="<?php echo $productoEditar['nombre'] ?? ''; ?>">

        <textarea placeholder="descripcion" name="descripcion"><?php echo $productoEditar['descripcion'] ?? ''; ?></textarea>

        <input id="inputModal" type="number" step="0.01" name="precio" value="<?php echo $productoEditar['precio_venta'] ?? ''; ?>">

        <input id="inputModal" type="number" name="stock"  value="<?php echo $productoEditar['stock'] ?? ''; ?>">

        <input id="inputModal" type="text" name="foto" value="<?php echo $productoEditar['foto'] ?? ''; ?>">

        <button id="añadirPro" type="submit" name="modPro">Editar producto</button>
    </form>

</div>
    