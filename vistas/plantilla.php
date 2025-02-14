<?php

//si se cierra el navegador se cierra la sesión
ini_set('session.cookie_lifetime', 0);
session_start();
//si borran la url se cierra la sesión
if (!isset($_GET['pagina'])) {
    session_unset();
    session_destroy();
}

if((!isset($_SESSION["usuario"]) || $_SESSION["usuario"] == "") && (!isset($_SESSION["id"]) || $_SESSION["id"] == "")){
    header("Location: vistas/login.php");
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="Stylesheet" href="../css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <header>
        <div id="cabecera">
            <div>
                <img class="logo" src="../img/logo.jpg">
            </div>
            <div>
                <h1>Tienda Online</h1>
            </div>
        </div>
        <div class="sesion">
            <h4>Bienvenid@ <?php echo $_SESSION["usuario"];  ?></h4>
                <form method="post">
                    <button type="submit" name="salir" id="salir">Salir</button>
                </form>
                <?php
                    if(isset($_POST["salir"])){
                        session_destroy();
                        header("Location: login.php");
                    }
                ?>
        </div>
    </header>
    <nav>
        <div>
            <ul>
                <li>
                    <a href="plantilla.php?pagina=inicio"
                        class="<?php echo (isset($_GET['pagina']) && $_GET['pagina'] == 'inicio') ? 'activo' : ''; ?>">
                        inicio
                    </a>
                </li>

                <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'admin'): ?><!--Si no es administrador no ve esta sección-->
                    <li>
                        <a href="plantilla.php?pagina=usuarios" class="<?php echo (isset($_GET['pagina']) && $_GET['pagina'] == 'usuarios') ? 'activo' : ''; ?>">
                            Usuarios
                        </a>
                    </li>
                <?php endif; ?>
                
                <li>
                    <a href="plantilla.php?pagina=productos"
                        class="<?php echo (isset($_GET['pagina']) && $_GET['pagina'] == 'productos') ? 'activo' : ''; ?>">
                        Productos
                    </a>
                </li>
            </ul>
        </div>
        <div>
            <ul>
            <?php if (isset($_SESSION['rol']) && $_SESSION['rol'] === 'usuario'): ?><!--Si no es usuario no ve esta sección-->
                <li>
                    <a href="plantilla.php?pagina=carrito"
                        class="<?php echo (isset($_GET['pagina']) && $_GET['pagina'] == 'carrito') ? 'activo' : ''; ?>">
                        <i class="bi bi-cart-fill"></i>
                    </a>
                </li>
            <?php endif; ?>
            </ul>
        </div>
    </nav>
    <main id="plantilla">
        <?php

        if(isset($_GET["pagina"])){

            if(
                $_GET["pagina"] == "inicio" ||
                $_GET["pagina"] == "usuarios" ||
                $_GET["pagina"] == "productos" ||
                $_GET["pagina"] == "carrito"
            ){

                include $_GET["pagina"] . ".php";

            }else{

                echo "No existe la página";

            }   
        }

        ?>
    </main>
    <footer>
        <p>&copy; <spam id="fecha"></spam> - Luz María Rojas Bonachera - Todos los derechos reservados.</p>
    </footer>

    <script src="../js/funciones.js"></script>
</body>
</html>