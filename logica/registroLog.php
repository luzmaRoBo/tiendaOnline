<?php


function registrar(){

    $conexion = conectarBD();

    if(isset($_POST["nombreRe"]) && isset($_POST["passRe"])){

        if(!empty($_POST["nombreRe"]) && !empty($_POST["passRe"])){

            $usuario = htmlspecialchars(strip_tags(trim($_POST["nombreRe"])));
            $clave = password_hash($_POST["passRe"], PASSWORD_DEFAULT);

            //comprobamos si el nombre de usuario ya está registrado
            $stmt = $conexion->prepare("SELECT COUNT(*) FROM usuarios WHERE nombre = ?");
            $stmt->bind_param("s", $usuario);
            $stmt->execute();
            $stmt->bind_result($count);
            $stmt->fetch();
            $stmt->close();
            //si el nombre de usuario ya está registrado, avisamos y detenemos el registro
            if ($count > 0) {
                echo "El nombre de usuario ya está registrado. Por favor, elige otro.";
                return; // Detenemos aquí el registro
            }

            $stmt = $conexion->prepare("INSERT INTO usuarios (nombre, pass) VALUES (?,?)");
            $stmt->bind_param("ss",$usuario, $clave);
            $stmt->execute();
            $stmt->close();

            echo "Usuario registrado correctamente.";

        }else{
            echo "Tienes que poner nombre y contraseña.";
        }

    }

    $conexion->close();
    
}

?>