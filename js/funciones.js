//eliminacion de productos
function confirmarEliminacion() {
    return confirm("¿Estás seguro de que deseas eliminar este producto??");
}

//eliminacion de Usuarios
function confirmarEliminacionUsu() {
    return confirm("¿Estás seguro de que deseas eliminar este usuario??");
}

//modal para productos
 function abrirModal(){
    document.getElementById("modal").style.display="block";
}
function cerrar(){
    document.getElementById("modal").style.display="none";
}
function cerrar1(){
    document.getElementById("modal1").style.display="none";
}

//modal para usuarios
function abrirModalU(){
    document.getElementById("modalUsu").style.display="block";
}
function cerrarU(){
    document.getElementById("modalUsu").style.display="none";
}
function cerrar1U(){
    document.getElementById("modalUsuMod").style.display="none";
}