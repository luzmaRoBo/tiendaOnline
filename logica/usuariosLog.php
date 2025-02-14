<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once "../logica/conexionBD.php";

function verUsuarios() {

    $conexion = conectarBD();

    $stmt = $conexion->prepare("SELECT * FROM usuarios");
    $stmt->execute();
    $listado = $stmt->get_result();

    return $listado;

}

function nuevoUsuario(){
    $conexion = conectarBD();

    if(isset($_POST["nombreUsu"]) && isset($_POST["passUsu"]) && isset($_POST["rolUsu"])){
        if(!empty($_POST["nombreUsu"]) &&!empty($_POST["passUsu"]) &&!empty($_POST["rolUsu"  ])){

            $usuario = htmlspecialchars(strip_tags(trim($_POST["nombreUsu"])));
            $clave = password_hash($_POST["passUsu"], PASSWORD_DEFAULT);
            $rol = $_POST["rolUsu"];

            $stmt = $conexion ->prepare("INSERT INTO usuarios(nombre, pass, rol) VALUES (?,?,?)");
            $stmt->bind_param("sss", $usuario, $clave, $rol);
            $stmt->execute();

        }
        $stmt->close();
        
    }
    $conexion->close();

}

function eliminarUsuario(){
    $conexion = conectarBD();

    if(isset($_POST["idUsuario"])){
        $id = $_POST["idUsuario"];

        $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
    $conexion->close();
}

function modificarUsuario() {
    $conexion = conectarBD();

    if (isset($_POST["idUsuarioMod"])) {
        $id = $_POST["idUsuarioMod"];
        $nombre = htmlspecialchars(trim($_POST["modNombre"]));
        $rol = $_POST["modRol"];
        
        // Revisa si el campo "modPass" está vacío o no
        if (!empty($_POST["modPass"])) {
            // Se ha introducido una nueva contraseña, la hasheamos y la actualizamos
            $pass = password_hash($_POST["modPass"], PASSWORD_DEFAULT);

            $stmt = $conexion->prepare("UPDATE usuarios SET nombre=?, pass=?, rol=? WHERE id=?");
            $stmt->bind_param("sssi", $nombre, $pass, $rol, $id);
        } else {
            // No se ha introducido ninguna nueva contraseña, se ignora el campo pass
            $stmt = $conexion->prepare("UPDATE usuarios SET nombre=?, rol=? WHERE id=?");
            $stmt->bind_param("ssi", $nombre, $rol, $id);
        }

        $stmt->execute();
        $stmt->close();
    }
    
    $conexion->close();
}




?>