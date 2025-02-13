<?php


function login(){

    $conexion = conectarBD();

    if(isset($_POST["nombreUsu"]) && isset($_POST["passUsu"])){

        $usuario = htmlspecialchars(strip_tags(trim($_POST["nombreUsu"])));
        $clave = $_POST["passUsu"];

        $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE nombre = ?");
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        if($resultado->num_rows > 0){

            $fila = $resultado->fetch_assoc();
            $claveCryp = $fila["pass"];
            
            if(password_verify($clave, $claveCryp)){

                $_SESSION["usuario"] = $usuario;
                $_SESSION["id"] = $fila["id"];
                $_SESSION["rol"] = $fila["rol"];
                
                
            }else{

                echo "Contraseña incorrecta.";

            }

        }else{

            echo "Usuario no encontrado.";

        }

        $stmt->close();
    }

    $conexion->close();

}

?>