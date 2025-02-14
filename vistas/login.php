<?php  
    require_once "../logica/loginLog.php";
    require_once "../logica/conexionBD.php";
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda</title>
    <link rel="Stylesheet" href="../css/estilos.css">
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
    </header>
    
    <main>
        <div id="registro">
            <h2>Inicio de sesión</h2>
            <form action="" method="post">
                <label>Nombre</label><br>
                <input type="text" name="nombreUsu" placeholder="nombre"><br>
                <label>Contraseña</label><br>
                <input type="text" name="passUsu" placeholder="contraseña"><br>
                <button type="submit" name="login" id="botonIns">Iniciar</button><br>
                <a id="enlace" href="registro.php">Registro de usuario</a>
            </form>
            <p>
                <?php

                if(isset($_POST["login"])){
                    login();

                    if(isset($_SESSION["usuario"]) && isset($_SESSION["id"])){
                        header("Location: plantilla.php?pagina=inicio");
                    }

                }

                ?>
            </p>
        </div>
    </main>

    <div id="modalInicio">
        <div class="cabeceraModal">
            <div class="titulo"><h2>Datos para el inicio</h2></div>
            <div class="cerrar"><button class="botonCerrar" type="button" onclick="cerrarL()">X</button></div>
        </div>
        <div class="datosInicio">
            <p>
                <strong>Rol Administrador:</strong> admin/admin<br><br>
                <strong>Rol Usuario:</strong> usuario/usuario<br>
                El registro se hace por defecto con rol usuario
            </p>
        </div>
    </div>

    <script src="../js/funciones.js"></script>
</html>
</body>
</html>

