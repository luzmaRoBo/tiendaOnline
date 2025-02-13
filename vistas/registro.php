<?php  
    require_once "../logica/registroLog.php";
    require_once "../logica/conexionBD.php";
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
            <h2>Registro de usuarios</h2>
            <form action="" method="post">
                <label>Nombre</label><br>
                <input type="text" name="nombreRe" placeholder="nombre"><br>
                <label>Contraseña</label><br>
                <input type="text" name="passRe" placeholder="contraseña"><br>
                <button type="submit" name="registro" id="botonIns">Registrar</button><br>
                <a id="enlace" href="login.php">Inicio de sesión</a>
            </form>
            <p>
                <?php

                if(isset($_POST["registro"])){
                    registrar();
                }

                ?>
            </p>
        </div>
    </main>
</body>
</html>

