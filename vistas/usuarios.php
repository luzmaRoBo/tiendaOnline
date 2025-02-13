<?php

require_once "../logica/usuariosLog.php";
//si el usuario no tiene rol admin no puede acceder a esta sección
if ($_SESSION['rol'] !== 'admin') {
    // Si el usuario no es admin, redirige a otra página o muestra un mensaje de error
    header("Location: index.php"); // Redirige a la página de inicio, por ejemplo
    exit();
}

if(isset($_POST["inUsuario"])){
    nuevoUsuario();
    header("Location: plantilla.php?pagina=usuarios");
    exit();
}

if(isset($_POST["eliminarUsu"])){
    eliminarUsuario();
    header("Location: plantilla.php?pagina=usuarios");
    exit();
}


?>

<section>
<h1 class="h1Productos">Listado de usuarios</h1>
    <div class="productos">
        <table class="table table-responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Contraseña</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $usuarios = verUsuarios();
                    while ($fila = $usuarios->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $fila['id'] . "</td>";
                        echo "<td>" . $fila['nombre'] . "</td>";
                        echo "<td>" . $fila['pass'] . "</td>";
                        echo "<td>" . $fila['rol'] . "</td>";
                        echo "<td>";
                        echo "    <div class='botonesAccionUsu'>
                                    <div>
                                        <form action='' method='POST'>
                                            <input type='hidden' name='idUsuario' value='". $fila['id']. "'>
                                            <button type='submit' class='botonEliminarU' name='modificarUsu'><i class='bi bi-pencil-fill'></i></button>
                                        </form>
                                    </div>
                                    <div>
                                        <form action='' method='POST' onsubmit='return confirmarEliminacionUsu();'>
                                            <input type='hidden' name='idUsuario' value='". $fila['id']. "'>
                                            <button type='submit' class='botonEliminarU' name='eliminarUsu'><i class='bi bi-trash-fill'></i></button>
                                        </form>
                                    </div>";

                        echo "    </div>";
                        echo "</tr>";
                        
                            }
                ?>
            </tbody>
        </table>
    </div>

    <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?>
        <div id="botonAñadir">
            <button id="añadirUsu" type="button" onclick="abrirModalU()">Añadir Usuario</button>
        </div>
    <?php endif; ?>
</section>

<!--=====================================
        VENTANA MODAL
======================================-->

<div id="modalUsu" class="modalUsu">

    <div class="cabeceraModal">
        <div class="titulo"><h2>añadir usuario</h2></div>
        <div class="cerrar"><button class="botonCerrar" type="buton" onclick="cerrarU()">X</button></div>
    </div>

    <form action="" method="post">
        <label>Nombre</label><br>
        <input type="text" name="nombreUsu" placeholder="nombre"><br>
        <label>Contraseña</label><br>
        <input type="text" name="passUsu" placeholder="contraseña"><br>
        <label>Rol</label><br>
        <select name="rolUsu">
            <option value="admin">Admin</option>
            <option value="usuario">Usuario</option>
        </select><br>
        <button type="submit" name="inUsuario" id="botonIns">Añadir</button><br>
    </form>

</div>

